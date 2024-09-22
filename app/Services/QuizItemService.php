<?php

namespace App\Services;

use App\Http\Requests\QuizItemRequest;
use App\Http\Trait\HelperUtil;
use App\Interfaces\QuizItemRepository;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class QuizItemService
{
    use HelperUtil;
    protected $quizItemRepo;

    public function __construct(QuizItemRepository $quizItemRepo)
    {
        $this->quizItemRepo = $quizItemRepo;
    }

    public function createQuizItem(QuizItemRequest $request, $id)
    {
        try {
            DB::beginTransaction();
            $validator = $this->validateId($id, "quizzes");
            if ($validator->fails()) {
                return response()->json($validator->errors(), 422);
            }
            $data = $request->all();
            $data['video_group_id'] = $id;
            $video = $this->quizItemRepo->createQuizItem($data);
            DB::commit();
            return response()->json($video, 200);
        } catch (Exception $e) {
            DB::rollback();
            return response()->json($e->getMessage(), 500);
        }
    }


    public function updateQuizItem(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            $validator = $this->validateId($id, "quize_items");
            if ($validator->fails()) {
                return response()->json($validator->errors(), 422);
            }
            $data = $request->all();
            $video = $this->quizItemRepo->updateQuizItem($id, $data);
            DB::commit();
            return response()->json($video, 200);
        } catch (Exception $e) {
            DB::rollback();
            return response()->json($e->getMessage(), 500);
        }
    }


    public function deleteQuizItem($id)
    {
        try {
            DB::beginTransaction();
            $validator = $this->validateId($id, "quize_items");
            if ($validator->fails()) {
                return response()->json($validator->errors(), 422);
            }
            $this->quizItemRepo->deleteQuizItem($id);
            DB::commit();
            return response()->json(["message" => "deleted"], 200);
        } catch (Exception $e) {
            DB::rollback();
            return response()->json($e->getMessage(), 500);
        }
    }
}
