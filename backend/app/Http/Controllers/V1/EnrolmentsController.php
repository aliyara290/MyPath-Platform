<?php

namespace App\Http\Controllers\V1;

use App\Models\Enrolments;
use App\Http\Requests\V1\StoreEnrolmentsRequest;
use App\Http\Requests\V1\UpdateEnrolmentsRequest;
use App\Interfaces\EnrolmentsInterface;
use App\Http\Controllers\Controller;

class EnrolmentsController extends Controller
{

    private $enrolmentsInterface;

    public function __construct(EnrolmentsInterface $enrolments)
    {
        $this->enrolmentsInterface = $enrolments;
    }


    public function index()
    {
        return $this->enrolmentsInterface->getStudentCourses();
    }


    public function store(StoreEnrolmentsRequest $request, $courseId)
    {
        return $this->enrolmentsInterface->enrollInCourse($request, $courseId);
    }


    // public function show(Enrolments $enrolments)
    // {
    //     //
    // }

    // public function update(UpdateEnrolmentsRequest $request, Enrolments $enrolments)
    // {
    //     //
    // }

    // public function destroy(Enrolments $enrolments)
    // {
    //     //
    // }
}
