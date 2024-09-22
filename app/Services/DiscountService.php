<?php

use App\Http\Requests\DiscountRequest;
use App\Http\Trait\HelperUtil;
use App\Interfaces\CourseRepository;
use App\Interfaces\DiscountRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class DiscountService
{
    use HelperUtil;
    protected $discountRepo;
    protected $courseRepo;

    public function __construct(
        DiscountRepository $discountRepo,
        CourseRepository $courseRepo
    ) {
        $this->discountRepo = $discountRepo;
        $this->courseRepo = $courseRepo;
    }


    public function createDiscount(DiscountRequest $request, $id)
    {
        try {
            DB::beginTransaction();
            $validate = $this->validateId($id, "courses");
            if ($validate->fails()) {
                return response()->json($validate->errors(), 422);
            }
            $course = $this->courseRepo->getCourseById($id);
            $newPrice = $this->calculatDiscountRate($course->price, $request->rate);
            $course->price = $newPrice;
            $course->save();
            $data = $request->all();
            $data['course_id'] = $id;
            $data['old_price'] = $course->price;
            $data['new_price'] = $newPrice;
            $this->discountRepo->createDiscount($data);
            DB::commit();
            return response()->json("The discount has been added successfully :)", 200);
        } catch (Exception $e) {
            DB::rollback();
            return response()->json($e->getMessage(), 500);
        }
    }

    public function cancelDiscount($id)
    {
        try {
            DB::beginTransaction();
            $validate = $this->validateId($id, "courses");
            if ($validate->fails()) {
                return response()->json($validate->errors(), 422);
            }
            $course = $this->courseRepo->getCourseById($id);
            $discount = $course->discount;
            $course->price = $discount->old_price;
            $course->save();
            $this->discountRepo->deleteDiscount($discount->id);
            DB::commit();
            return response()->json("The discount has been canceled successfully :(", 200);
        } catch (Exception $e) {
            DB::rollback();
            return response()->json($e->getMessage(), 500);
        }

    }

    public function calculatDiscountRate($oldPrice, $rate)
    {
        $newPrice = $oldPrice - ($oldPrice * $rate);
        return $newPrice;
    }


}
