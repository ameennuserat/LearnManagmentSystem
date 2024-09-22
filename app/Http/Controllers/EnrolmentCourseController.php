<?php

namespace App\Http\Controllers;

use App\Services\EnrolmentService as ServicesEnrolmentService;
use Illuminate\Http\Request;

class EnrolmentCourseController extends Controller
{
    protected $enrollmentService;
    public function __construct(ServicesEnrolmentService $enrollmentService)
    {
        $this->enrollmentService = $enrollmentService;
        $this->middleware('auth')->only('enrolmentCourse');
    }



    public function enrolmentCourse($id)
    {
      return  $this->enrollmentService->enrolmentCourseProc($id);
    }

}
