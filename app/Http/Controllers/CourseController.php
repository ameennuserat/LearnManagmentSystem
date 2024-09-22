<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\CourseRequest;
use App\Http\Requests\updateCourseRequest;
use App\Services\CourseService;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    protected $courseService;
    public function __construct(CourseService $courseService)
    {
        $this->courseService = $courseService;
        $this->middleware('auth:api');
    }

    public function AddCourse(CourseRequest $request, $id)
    {
        return $this->courseService->createCourse($request, $id);
    }


    public function UpdatetCourse(updateCourseRequest $request, $id)
    {
        return $this->courseService->updateCourse($request, $id);
    }


    public function DeleteCourse($id)
    {
        return $this->courseService->deleteCourse($id);
    }

    public function getCourses($id)
    {
        return $this->courseService->getCoursesByCategoryId($id);
    }

    public function getCoursesOfStudent($id)
    {
        return $this->courseService->getCoursesOfStudent($id);
    }

    public function searchCourse($name)
    {
        return $this->courseService->searchCourse($name);
    }

}
