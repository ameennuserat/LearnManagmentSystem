<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Course;
use App\Models\Enrolment;
use App\Models\Expert;
use App\Models\Quiz;
use App\Models\QuizeAttempt;
use App\Models\QuizeItem;
use App\Models\User;
use App\Models\VideoGroup;
use App\Services\StudentService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use PHPUnit\Framework\Constraint\Count;

class StudentController extends Controller
{
    protected $studentService;
    public function __construct(StudentService $studentService)
    {
        $this->studentService = $studentService;
        $this->middleware('auth')->only('enrolmentCourse');
    }

    public function exploreStudentSuccesses()
    {
        return $this->studentService->exploreStudentSuccesses();
    }

    public function getStudentsInCourse($id)
    {
        return $this->getStudentsInCourse($id);
    }




}
