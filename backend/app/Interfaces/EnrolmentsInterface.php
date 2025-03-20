<?php

namespace App\Interfaces;

interface EnrolmentsInterface
{
    public function enrollInCourse($request, $courseId);
    public function getStudentCourses();
}
