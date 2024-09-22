<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Frequentlyquestions;

class FrequentlyquestionController extends Controller
{
    protected $FrequentlyQuestion;
    public function __construct()
    {
        $this->middleware('auth:api');
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
