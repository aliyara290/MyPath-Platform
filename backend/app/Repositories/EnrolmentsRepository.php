<?php

namespace App\Repositories;

use App\Http\Resources\V1\EnrolmentsCollection;
use App\Interfaces\EnrolmentsInterface;
use App\Models\Course;
use App\Models\Enrolments;
use App\Traits\HttpResponses;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;

class EnrolmentsRepository implements EnrolmentsInterface
{
    use HttpResponses;

    public function enrollInCourse($request, $courseId)
    {
        try {
            if (!Auth::user()) {
                return response()->json(["message" => "You need to login first!"]);
            }
            $userId = Auth::user();
            if (!$userId) {
                return $this->error(
                    "",
                    "404",
                    "User not found"
                );
            }

            $enroll = Enrolments::create([
                "course_id" => $courseId,
                "user_id" => $userId->id,
            ]);

            if (!$enroll) {
                return $this->error(
                    "",
                    "422",
                    "Failed to enroll in the course"
                );
            }

            return $this->success(
                "",
                "You enrolled successfully",
                201
            );
        } catch (QueryException $e) {
            return $this->error(
                "",
                "500",
                $e->getMessage()
            );
        } catch (Exception $e) {
            return $this->error(
                "",
                "500",
                "Server error"
            );
        }
    }

    public function getStudentCourses()
    {
        try {
            $userId = Auth::user();
            $courses = Course::leftJoin("enrolments", "courses.id", "=", "enrolments.course_id")
                ->leftJoin("users", "enrolments.user_id", "=", "users.id")
                ->where("users.id", $userId->id)
                ->select("course.id", "course.title", "course.cover", "enrolments.created_at AS joined")
                ->get();
            if ($courses->isEmpty()) {
                return response()->json(["message" => ["You don't enrolled in any course yet!"]]);
            }
            return new EnrolmentsCollection($courses);
        } catch (Exception $e) {
            return $this->error(
                "",
                "500",
                "Database error"
            );
        }
    }
}
