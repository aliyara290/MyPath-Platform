<?php

namespace App\Interfaces;

interface CourseInterface
{
    public function getCourses();
    public function getCourse($course);
    public function storeCourse($request);
    public function updateCourse($request, $course);
    public function deleteCourse($course);
    public function searchCourses($request);
}
