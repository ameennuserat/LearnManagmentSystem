<?php

namespace App\Services;

use App\Http\Requests\CourseRequest;
use App\Http\Requests\updateCourseRequest;
use App\Http\Trait\HelperUtil;
use App\Interfaces\CategoryRepository;
use App\Interfaces\CourseRepository;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CourseService
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

    public function createCourse(CourseRequest $request, $id)
    {
        try {
            DB::beginTransaction();
            $validat = $this->validateId($id, "categories");
            if ($validat->fails()) {
                return response()->json($validat->errors(), 422);
            }
            $data = $request->all();
            $data['category_id'] = $id;
            $course = $this->courseRepo->createCourse($data);
            DB::commit();
            return response()->json("created course", 200);
        } catch (Exception $e) {
            DB::rollback();
            return response()->json($e->getMessage(), 500);
        }
    }

    public function updateCourse(updateCourseRequest $request, $id)
    {
        try {
            DB::beginTransaction();
            $validat = $this->validateId($id, "courses");
            if ($validat->fails()) {
                return response()->json($validat->errors(), 422);
            }
            $data = $request->all();
            $course = $this->courseRepo->updateCourse($id, $data);
            DB::commit();
            return response()->json("updated course", 200);
        } catch (Exception $e) {
            DB::rollback();
            return response()->json($e->getMessage(), 500);
        }
    }

    public function deleteCourse($id)
    {
        try {
            $validat = $this->validateId($id, "courses");
            if ($validat->fails()) {
                return response()->json($validat->errors(), 422);
            }
            $this->courseRepo->deleteCourse($id);
            return response()->json("deleted course", 200);
        } catch (Exception $e) {
            return response()->json($e->getMessage(), 500);
        }
    }

    public function getCoursesByCategoryId($categoryId)
    {
        $validate = $this->validateId($categoryId, "categories");
        if ($validate->fails()) {
            return response()->json($validate->errors(), 422);
        }
        return $this->courseRepo->getCoursesByCategoryId($categoryId);
    }

    public function getCoursesOfStudent($id)
    {
        $validate = $this->validateId($id, "users");
        if ($validate->fails()) {
            return response()->json($validate->errors(), 422);
        }

        $student = User::find($id)->student;
        $courses = $student->courses;
        return response()->json($courses, 200);
    }


    public function searchCourse($name)
    {
        $course = $this->courseRepo->getCourseByName($name);
        $category_id = $course[0]['category_id'];
        $category = $this->categoryRepo->getCategoryById($category_id)->name;
        $student = Auth::user()->student;
        $student->last_searching = $category;
        $student->save();
        return response()->json($course, 200);
    }

}
