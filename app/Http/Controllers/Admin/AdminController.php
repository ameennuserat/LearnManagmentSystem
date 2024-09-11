<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Trait\ImageTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Course;
use App\Models\Frequentlyquestions;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function AddCourse(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100',
            'description' => 'required|string',
            'price' => 'required',
            'expert_id' => 'required|integer|exists:experts,id',
            'category_id' => 'required|integer|exists:categories,id',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $course = Course::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'expert_id' => $request->expert_id,
            'category_id' => $request->category_id
        ]);

        return response()->json($course, 200);

    }


    public function UpdatetCourse(Request $request, $id)
    {

        $validator = Validator::make(
            ['id' => $id],
            ['id' => 'required|integer|exists:courses,id']
        );

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $course = Course::findOrfail($id);

        $course->update($request->toArray());

        return response()->json("update success", 200);
    }


    public function DeleteCourse($id)
    {

        $validator = Validator::make(
            ['id' => $id],
            ['id' => 'required|integer|exists:courses,id']
        );

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $course = Course::findOrfail($id);

        $course->delete();
        return response()->json("delete success", 200);
    }


    public function addFrequentlyquestion(Request $request)
    {


        $validator = Validator::make($request->all(), [
            'question' => 'required|string',
            'answer' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $course = Frequentlyquestions::create([
            'question' => $request->question,
            'answer' => $request->answer

        ]);

        return response()->json($course, 200);
    }

    public function deleteFrequentlyquestion($id)
    {

        $validator = Validator::make(
            ['id' => $id],
            ['id' => 'required|integer|exists:frequentlyquestions,id']
        );

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $course = Frequentlyquestions::findOrfail($id);

        $course->delete();
        return response()->json("delete success", 200);
    }
}
