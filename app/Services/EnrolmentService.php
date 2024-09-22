<?php

namespace App\Services;

use App\Http\Trait\HelperUtil;
use App\Interfaces\CourseRepository;
use App\Interfaces\EnrolmentRepository;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class EnrolmentService
{
    use HelperUtil;

    protected $enrolmentRepo;
    protected $courseRepo;
    public function __construct(
        EnrolmentRepository $enrolmentRepo,
        CourseRepository $courseRepo
    ) {
        $this->courseRepo = $courseRepo;
        $this->enrolmentRepo = $enrolmentRepo;
    }

    public function enrolmentCourseProc($id)
    {
        try {
            DB::beginTransaction();
            $validate = $this->validateId($id, "courses");
            if ($validate->fails()) {
                return response()->json($validate->errors(), 422);
            }

            $course = $this->courseRepo->getCourseById($id);

            $user = Auth::user();

            $student = $user->student;
            $walet = $user->wallet;
            $rate = 0;
            switch ($student->number_courses) {
                case 2:
                    $rate = 0.1;
                    break;

                case 3:
                    $rate = 0.2;
                    break;

                case 4:
                    $rate = 0.3;
                    break;

                case 5:
                    $rate = 0.4;
                    break;

                case 6:
                    $rate = 0.5;
                    break;

                default:
                    return 'Invalid action';
            }
            $newprice = $this->checkEnoughMoney($course->price, $rate, $walet->amount);
            if ($newprice == 0) {
                return response()->json("You do not have enough balance :(", 400);
            }
            $walet->amount = $walet->amount - ($newprice);
            $walet->save();

            $student->number_courses = $student->number_courses + 1;
            $student->save();

            $enrolment = $this->enrolmentCourse($student->id, $course->id, $rate);
            DB::commit();
            return response()->json($enrolment, 200);
        } catch (Exception $e) {
            DB::rollback();
            return response()->json($e->getMessage(), 500);
        }
    }


    public function enrolmentCourse($stId, $couId, $rate)
    {
        $data = [
            'student_id' => $stId,
            'course_id' => $couId,
            'rate_discount' => $rate
            ];
        return $this->enrolmentRepo->enrolmentCourse($data);
    }

    public function checkEnoughMoney($price, $rate, $mony)
    {
        $newprice = $price - ($price * $rate);
        if ($mony < $newprice) {
            return 0;
        }
        return $newprice;
    }

}
