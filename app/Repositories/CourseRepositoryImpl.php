<?php

namespace App\Repositories;

use App\Http\Requests\ChoiceRequest;
use App\Interfaces\ChoiceRepository;
use App\Interfaces\CourseRepository;
use App\Models\Choice;
use App\Models\Course;

class CourseRepositoryImpl implements CourseRepository
{
    public function getAllCourses()
    {
        return Course::getAll();
    }

    public function getCoursesByCategoryId($categoryId)
    {
        return Course::where('category_id', $categoryId)->get();
    }

    public function getCourseById($courseId)
    {
        return Course::findOrFail($courseId);
    }

    public function deleteCourse($courseId)
    {
        Course::destroy($courseId);
    }

    public function createCourse(array $courseDetails)
    {
        return Course::create($courseDetails);
    }

    public function getCourseByName($name)
    {
        return Course::where('name', $name)->get();
    }

    public function updateCourse($courseId, array $newDetails)
    {
        $course = Course::findOrFail($courseId);
        $course->name = $newDetails['name'];
        $course->price = $newDetails['price'];
        $course->details = $newDetails['details'];
        $course->save();
        return $course;
    }

}
