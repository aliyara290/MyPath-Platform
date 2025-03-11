<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\StoreCourseRequest;
use App\Http\Requests\V1\UpdateCourseRequest;
use App\Interfaces\CourseInterface;
use App\Models\Course;

class CourseController extends Controller
{
    private $courseInterface;

    public function __construct(CourseInterface $course) {
        $this->courseInterface = $course;
    }

    public function index()
    {
        return $this->courseInterface->getCourses();
    }

    public function store(StoreCourseRequest $request)
    {
        return $this->courseInterface->storeCourse($request);
    }


    public function show(Course $course)
    {
        return $this->courseInterface->getCourse($course);
    }


    public function update(UpdateCourseRequest $request, Course $course)
    {
        return $this->courseInterface->updateCourse($request, $course);
    }


    public function destroy(Course $course)
    {
        return $this->courseInterface->deleteCourse($course);
    }
}
