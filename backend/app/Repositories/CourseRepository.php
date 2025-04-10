<?php

namespace App\Repositories;

use App\Http\Resources\V1\CourseCollection;
use App\Http\Resources\V1\CourseResource;
use App\Interfaces\CourseInterface;
use App\Models\Category;
use App\Models\Course;
use App\Traits\HttpResponses;
use Exception;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Gate;

class CourseRepository implements CourseInterface
{
    use HttpResponses, AuthorizesRequests;

    public function getCourses()
    {
        try {
            $courses = Course::with(["videos", "tags"])
                ->paginate(8);

            $courses->getCollection()->transform(function ($course) {
                $course->tag_names = $course->tag_names ? explode(',', $course->tag_names) : [];
                return $course;
            });

            if ($courses->isEmpty()) {
                return response()->json(["message" => "No courses to show!"]);
            }

            $response = [
                'courses' => new CourseCollection($courses)
            ];

            return response()->json($response);
        } catch (Exception $e) {
            return $this->error(
                '',
                500,
                'Failed to show courses: ' . $e->getMessage(), // Include the error message for debugging
            );
        }
    }
    public function getCourse($course)
    {
        try {
            $courses = Course::find($course)->first();
            if (!$courses) {
                return response()->json(["message" => "Course not found!"]);
            }

            return new CourseResource($courses);
        } catch (Exception $e) {
            return $this->error(
                '',
                500,
                'Failed to show course'
            );
        }
    }
    public function storeCourse($request)
    {
        try {

            $course = Course::create([
                'title' => $request->title,
                'description' => $request->description,
                'content' => $request->content,
                'cover' => $request->cover,
                'duration' => $request->duration,
                'level' => $request->level,
                'teacher_id' => $request->teacherId,
                'category_id' => $request->categoryId,
            ]);

            if ($request->has("tags")) {
                $course->tags()->attach($request->tags);
            }
            return $this->success([
                "course" => $course,
                "message" => "Course added successfully",
            ]);
        } catch (Exception $e) {
            return $this->error(
                '',
                500,
                $e
            );
        }
    }
    public function updateCourse($request, $course)
    {
        try {

            // if (!Gate::allows("edit-course", $course)) {
            //     return response()->json(["message" => "access denied!"]);
            // }
            if(!$this->authorize('update', $course)) {
                return $this->error(
                    "Access denied",
                    403
                );
            }
             
            $course = Course::find($course)->first();
            if (!$course) {
                return response()->json(["message" => "Course not found!"]);
            }
            $course->update([
                'title' => $request->title,
                'description' => $request->description,
                'content' => $request->content,
                'cover' => $request->cover,
                'duration' => $request->duration,
                'level' => $request->level,
                'teacher_id' => $request->teacherId,
                'category_id' => $request->categoryId,
            ]);
            if ($request->has("tags")) {
                $course->tags()->sync($request->tags);
            }
            return $this->success([
                "course" => $course,
                "message" => "Course updated successfully",
            ]);
        } catch (Exception $e) {
            return $this->error(
                '',
                500,
                $e,
            );
        }
    }
    public function deleteCourse($course)
    {
        try {
            $course = Course::find($course)->first();
            if (!$course) {
                return response()->json(["message" => "Course not found!"]);
            }
            $course->delete();
            return $this->success([
                "",
                "message" => "Course deleted successfully",
            ]);
        } catch (Exception $e) {
            return $this->error(
                '',
                'Failed to delete course',
                500
            );
        }
    }

    // In CourseRepository.php
public function searchCourses($request)
{
    try {
        $query = Course::leftJoin('categories', "courses.category_id", "=", "categories.id")
            ->leftJoin("course_tag", "courses.id", "=", "course_tag.course_id")
            ->leftJoin("tags", "course_tag.tag_id", "=", "tags.id")
            ->select(
                "courses.*",
                "categories.name as categoryName",
                DB::raw("GROUP_CONCAT(DISTINCT tags.name ORDER BY tags.name SEPARATOR ',') as tag_names")
            )
            ->groupBy("courses.id", "categories.name");

        if ($request->has('name') && !empty($request->name)) {
            $query->where('courses.title', 'LIKE', '%' . $request->name . '%');
        }

        if ($request->has('category') && !empty($request->category)) {
            $query->where('courses.category_id', $request->category);
        }

        if ($request->has('tags') && !empty($request->tags)) {
            $tagIds = explode(',', $request->tags);
            $query->whereHas('tags', function($q) use ($tagIds) {
                $q->whereIn('tags.id', $tagIds);
            });
        }

        $courses = $query->orderBy("courses.id", "DESC")->paginate(8);

        $courses->getCollection()->transform(function ($course) {
            $course->tag_names = $course->tag_names ? explode(',', $course->tag_names) : [];
            return $course;
        });

        if ($courses->isEmpty()) {
            return response()->json(["message" => "No courses found"]);
        }

        $response = [
            'courses' => new CourseCollection($courses)
        ];

        return response()->json($response);
    } catch (Exception $e) {
        return $this->error(
            '',
            500,
            'Error searching courses: ' . $e->getMessage()
        );
    }
}
}
