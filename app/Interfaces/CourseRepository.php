<?php

namespace App\Interfaces;
interface CourseRepository
{
    public function getAllCourses();
    public function getCoursesByCategoryId($categoryId);
    public function getCourseByName($name);
    public function getCourseById($courseId);
    public function deleteCourse($courseId);
    public function createCourse(array $courseDetails);
    public function updateCourse($courseId, array $newDetails);
}
