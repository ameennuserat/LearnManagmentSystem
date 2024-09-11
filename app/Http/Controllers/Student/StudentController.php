<?php

namespace App\Http\Controllers\Student;

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
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use PHPUnit\Framework\Constraint\Count;

class StudentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->only('enrolmentCourse');
    }

    public function getCategory()
    {
        $category = Category::all();
        return response()->json($category, 200);
    }

    public function getCourses($id)
    {
        $validator = Validator::make(
            ['id' => $id],
            ['id' => 'required|integer|exists:categories,id']
        );

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $category = Category::find($id);
        $courses = $category->courses;

        return response()->json($courses, 200);
    }


    public function getVideoGroups($id)
    {
        $validator = Validator::make(
            ['id' => $id],
            ['id' => 'required|integer|exists:courses,id']
        );

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $videogroups = Course::find($id)->videogroups;
        return response()->json($videogroups, 200);
    }


    public function getVideos($id)
    {
        $validator = Validator::make(
            ['id' => $id],
            ['id' => 'required|integer|exists:video_groups,id']
        );

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $videos = VideoGroup::find($id)->videos;

        return response()->json($videos, 200);
    }


    public function getQuiz($id)
    {
        $validator = Validator::make(
            ['id' => $id],
            ['id' => 'required|integer|exists:video_groups,id']
        );

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $videogroup = VideoGroup::find($id);
        $quiz = $videogroup->quiz;
        $date =  date('Y-m-d');
        if($quiz->date != $date) {
            return response()->json('The quiz opens on: '.$quiz->date, 200);
        }
        $quiz_items = $quiz->quizItems;
        $cohice = $quiz_items->load('choices')->makehidden('answer');

        return response()->json($cohice, 200);
    }


    public function checkresult(Request $request)
    {
        $validator = Validator::make(
            ['id' => $request->quiz_id],
            ['id' => 'required|integer|exists:quizzes,id']
        );

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $myArray = $request->input('result');
        $quiz = Quiz::find($request->quiz_id);
        $quizItem = $quiz->quizItems;
        $data = null;
        $count = 0;
        for($i = 0;$i < $quiz->number_item;$i++) {
            if($quizItem[$i]->answer == $myArray[$i]) {
                $count++;
            }
        }

        $result = (($count / $quiz->number_item) * 100);

        if($result > 60) {
            $data = 'Pass';
        } else {
            $data = 'fail';
        }

        $quizattempt = QuizeAttempt::create([
            'quiz_id' => $request->quiz_id,
            'student_id' => Auth::user()->student->id,
            'score' => $result.'%',
            'result' => $data
        ]);

        return response()->json($quizattempt, 200);

    }


    public function getProfileExperts()
    {
        $experts = Expert::with('user')->get();

        $profiles = [];
        foreach($experts as $pr) {
            $array = [
                'name' => $pr->user->name,
                'image' => $pr->image,
                'phone' => $pr->phone,
                'bio' => $pr->bio
            ];
            $profiles[] = $array;
        }

        return response()->json($profiles, 200);
    }

    public function enrolmentCourse(Request $request)
    {
        try {

            DB::beginTransaction();

            $validator = Validator::make($request->all(), [
                'course_id' => 'required|integer|exists:courses,id'
                ]);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 422);
            }
            $course = Course::find($request->course_id);
            $price = $course->price;
            $user = Auth::user();
            $student = $user->student;
            $walet = $user->wallet;
            $enrolment = null;
            if($student->number_courses == 2) {
                $newprice = $price - ($price * 0.1);
                if($walet->amount < $newprice) {
                    return response()->json("You do not have enough balance :(", 400);
                }
                $walet->amount = $walet->amount - ($newprice);
                $walet->save();
                $enrolment = Enrolment::create([
                    'student_id' => $student->id,
                    'course_id' => $request->course_id,
                    'rate_discount' => 0.1
                ]);
            } elseif($student->number_courses == 3) {
                $newprice = $price - ($price * 0.3);
                if($walet->amount < $newprice) {
                    return response()->json("You do not have enough balance :(", 400);
                }
                $walet->amount = $walet->amount - ($newprice);
                $walet->save();
                $enrolment = Enrolment::create([
                    'student_id' => $student->id,
                    'course_id' => $request->course_id,
                    'rate_discount' => 0.2
                    ]);
            } elseif($student->number_courses == 4) {
                $newprice = $price - ($price * 0.4);
                if($walet->amount < $newprice) {
                    return response()->json("You do not have enough balance :(", 400);
                }
                $walet->amount = $walet->amount - ($newprice);
                $walet->save();
                $enrolment = Enrolment::create([
                    'student_id' => $student->id,
                    'course_id' => $request->course_id,
                    'rate_discount' => 0.3
                    ]);
            } elseif($student->number_courses == 5) {
                $newprice = $price - ($price * 0.7);
                if($walet->amount < $newprice) {
                    return response()->json("You do not have enough balance :(", 400);
                }
                $walet->amount = $walet->amount - ($newprice);
                $walet->save();
                $enrolment = Enrolment::create([
                    'student_id' => $student->id,
                    'course_id' => $request->course_id,
                    'rate_discount' => 0.4
                    ]);
            } else {
                if($walet->amount < $price) {
                    return response()->json("You do not have enough balance :(", 400);
                }
                $walet->amount = $walet->amount - $price;
                $walet->save();
                $enrolment = Enrolment::create([
                    'student_id' => $student->id,
                    'course_id' => $request->course_id,
                    'rate_discount' => 0
                    ]);
            }
            $student->number_courses = $student->number_courses + 1;
            $student->save();
            DB::commit();
        } catch(Exception $e) {
            DB::rollback();
            return $e->getMessage();
        }

        return response()->json($enrolment, 200);
    }


    public function getExplore()
    {
        $student = Auth::user()->student;
        $explore = $student->last_searching;
        $categoy = Category::where('name', $explore)->get();
        $id = $categoy[0]['id'];

        $courses = Category::find($id)->courses;
        return response()->json($courses);
    }

    public function searchCourse($name)
    {
        $course = Course::where('name', $name)->get();
        $category_id = $course[0]['category_id'];
        $category = Category::find($category_id)->name;
        $student = Auth::user()->student;
        $student->last_searching = $category;
        $student->save();
        return response()->json($course, 200);
    }


    public function searchExpert($name)
    {
        $expert = User::where('name', $name)
                        ->where('role', 'Expert')
                        ->get();

        return response()->json($expert, 200);
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


    public function getCoursesOfStudent($id)
    {

        $validator = Validator::make(
            ['id' => $id],
            ['id' => 'required|integer|exists:users,id']
        );

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $student = User::find($id)->student;
        $courses = $student->courses;

        return response()->json($courses, 200);


    }
}
