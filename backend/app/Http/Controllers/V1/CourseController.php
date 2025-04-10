<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\StoreCourseRequest;
use App\Http\Requests\V1\UpdateCourseRequest;
use App\Interfaces\CourseInterface;
use App\Models\Course;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;

class CourseController extends Controller
{
    private $courseInterface;

    public function __construct(CourseInterface $course)
    {
        $this->courseInterface = $course;
    }


    /**
     * @OA\Get(
     * path="/api/courses",
     * summary="Get a list of courses",
     * tags={"Course"},
     * @OA\Response(response=200, description="Successful operation"),
     * @OA\Response(response=400, description="Invalid request")
     * )
     */
    public function index()
    {
        return $this->courseInterface->getCourses();
    }

    /**
     * @OA\Post(
     *     path="/api/courses",
     *     summary="Store a new course",
     *     tags={"Course"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"title"},
     *             required={"description"},
     *             required={"content"},
     *             required={"tags"},
     *             required={"duration"},
     *             required={"level"},
     *             required={"categoryId"},
     *             @OA\Property(property="title", type="string", example=""),
     *             @OA\Property(property="description", type="string", example=""),
     *             @OA\Property(property="content", type="string", example=""),
     *             @OA\Property(property="tags", type="array",  @OA\Items(type="string"), example=""),
     *             @OA\Property(property="duration", type="decimal", example=""),
     *             @OA\Property(property="video", type="string", example=""),
     *             @OA\Property(property="cover", type="string", example=""),
     *             @OA\Property(property="level", type="string", example="beginner, intermediate, advanced"),
     *             @OA\Property(property="categoryId", type="string", example=""),
     *             @OA\Property(property="teacherId", type="string", example="")
     *         )
     *     ),
     *     @OA\Response(response=201, description="Course created"),
     *     @OA\Response(response=400, description="Invalid request")
     * )
     */

    public function store(StoreCourseRequest $request)
    {
        return $this->courseInterface->storeCourse($request);
    }
    /**
     * @OA\Get(
     *     path="/api/courses/{id}",
     *     summary="Get course details",
     *     tags={"Course"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Course ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="Successful operation"),
     *     @OA\Response(response=404, description="Course not found")
     * )
     */

    public function show(Course $course)
    {
        return $this->courseInterface->getCourse($course);
    }

    /**
     * @OA\Put(
     *     path="/api/courses/{id}",
     *     summary="Ipdate a new course",
     *     tags={"Course"},
     * @OA\Parameter(
     * name="Course ID",
     * in="path",
     * required=true,
     * description="Course ID",
     * @OA\Schema(type="integer"),
     * ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"title"},
     *             required={"description"},
     *             required={"content"},
     *             required={"tags"},
     *             required={"duration"},
     *             required={"level"},
     *             required={"categoryId"},
     *             @OA\Property(property="title", type="string", example=""),
     *             @OA\Property(property="description", type="string", example=""),
     *             @OA\Property(property="content", type="string", example=""),
     *             @OA\Property(property="tags", type="array",  @OA\Items(type="string"), example=""),
     *             @OA\Property(property="duration", type="decimal", example=""),
     *             @OA\Property(property="video", type="string", example=""),
     *             @OA\Property(property="cover", type="string", example=""),
     *             @OA\Property(property="level", type="string", example="beginner, intermediate, advanced"),
     *             @OA\Property(property="categoryId", type="string", example=""),
     *             @OA\Property(property="teacherId", type="string", example="")
     *         )
     *     ),
     *     @OA\Response(response=201, description="Course updated"),
     *     @OA\Response(response=400, description="Invalid request")
     * )
     */
    public function update(UpdateCourseRequest $request, Course $course)
    {
        return $this->courseInterface->updateCourse($request, $course);
    }

    /**
     * @OA\Delete(
     *     path="/api/courses/{id}",
     *     summary="Delete a course",
     *     tags={"Course"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Course ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="Course deleted"),
     *     @OA\Response(response=404, description="Course not found")
     * )
     */
    public function destroy(Course $course)
    {
        return $this->courseInterface->deleteCourse($course);
    }

    /**
     * @OA\Get(
     *     path="/api/courses/search",
     *     summary="Search courses by name, category, and tags",
     *     tags={"Course"},
     *     @OA\Parameter(
     *         name="name",
     *         in="query",
     *         required=false,
     *         description="Course name to search for",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="category",
     *         in="query",
     *         required=false,
     *         description="Category ID",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="tags",
     *         in="query",
     *         required=false,
     *         description="Comma-separated tag IDs",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(response=200, description="Successful operation"),
     *     @OA\Response(response=400, description="Invalid request")
     * )
     */
    public function search(Request $request)
    {
        return $this->courseInterface->searchCourses($request);
    }
}
