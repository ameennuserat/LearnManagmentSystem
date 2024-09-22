<?php

namespace App\Services;

use App\Http\Trait\HelperUtil;
use App\Interfaces\CategoryRepository;
use App\Interfaces\CourseRepository;
use App\Models\Course;
use App\Models\QuizeAttempt;
use Illuminate\Support\Facades\Validator;

class StudentService
{
    use HelperUtil;
    protected $courseRepo;
    protected $categoryRepo;
    public function __construct(
        CourseRepository $courseRepo,
        CategoryRepository $categoryRepo
    ) {
        $this->categoryRepo = $categoryRepo;
        $this->courseRepo = $courseRepo;
    }

    public function getStudentsInCourse($id)
    {

        $validate = $this->validateId($id, "courses");
        if ($validate->fails()) {
            return response()->json($validate->errors(), 422);
        }

        $course = Course::with(['students.user'])->find($id);

        $students = $course->students->map(function ($student) {
            return [
                'student_id' => $student->id,
                'name' => $student->user->name,
                'email' => $student->user->email,
                'number_courses' => $student->number_courses
            ];
        });

        return response()->json($students, 200);
    }


    public function exploreStudentSuccesses()
    {
        $topTen = QuizeAttempt::with(['students.user'])
        ->orderByRaw('CAST(score AS UNSIGNED) DESC')
        ->take(10)
        ->get();

        $filteredResults = $topTen->map(function ($result) {
            return [
                'name' => $result->students->user->name,
                'score' => $result->score,
            ];
        });

        return response()->json($filteredResults, 200);
    }


}
