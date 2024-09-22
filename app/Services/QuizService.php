<?php

namespace App\Services;

use App\Http\Requests\QuizRequest;
use App\Http\Trait\HelperUtil;
use App\Interfaces\QuizeAttemptRepository;
use App\Interfaces\QuizRepository;
use App\Interfaces\VideoGroupRepository;
use App\Models\QuizeAttempt;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class QuizService
{
    use HelperUtil;
    protected $quizRepo;
    protected $quizAttemptRepo;
    protected $videogroupRepo;

    public function __construct(
        QuizRepository $quizrepo,
        VideoGroupRepository $videogroupRepo,
        QuizeAttemptRepository $quizAttemptRepo
    ) {
        $this->quizAttemptRepo = $quizAttemptRepo;
        $this->videogroupRepo = $videogroupRepo;
        $this->quizRepo = $quizrepo;
    }


    public function createQuiz(QuizRequest $request, $id)
    {
        try {
            DB::beginTransaction();
            $validator = $this->validateId($id, "video_groups");
            if ($validator->fails()) {
                return response()->json($validator->errors(), 422);
            }
            $data = $request->all();
            $data['video_group_id'] = $id;
            $video = $this->quizRepo->createQuiz($data);
            DB::commit();
            return response()->json($video, 200);
        } catch (Exception $e) {
            DB::rollback();
            return response()->json($e->getMessage(), 500);
        }
    }


    public function updateQuiz(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            $validator = $this->validateId($id, "videos");
            if ($validator->fails()) {
                return response()->json($validator->errors(), 422);
            }
            $data = $request->all();
            $video = $this->quizRepo->updateQuiz($id, $data);
            DB::commit();
            return response()->json($video, 200);
        } catch (Exception $e) {
            DB::rollback();
            return response()->json($e->getMessage(), 500);
        }
    }


    public function deleteQuiz($id)
    {
        try {
            DB::beginTransaction();
            $validator = $this->validateId($id, "videos");
            if ($validator->fails()) {
                return response()->json($validator->errors(), 422);
            }
            $this->quizRepo->deleteQuiz($id);
            DB::commit();
            return response()->json(["message" => "deleted"], 200);
        } catch (Exception $e) {
            DB::rollback();
            return response()->json($e->getMessage(), 500);
        }
    }

    public function getQuiz($id)
    {
        try {
            $validator = $this->validateId($id, "video_groups");
            if ($validator->fails()) {
                return response()->json($validator->errors(), 422);
            }

            $videogroup = $this->videogroupRepo->getVideoGroupById($id);
            $quiz = $videogroup->quiz;
            $expired = $this->checkEpiredDate($quiz->date, date('Y-m-d'));
            if (!$expired) {
                return response()->json('The quiz opens on: '.$quiz->date, 200);
            }
            $quiz_items = $quiz->quizItems;
            $cohice = $quiz_items->load('choices')->makehidden('answer');
            return response()->json($cohice, 200);
        } catch (Exception $e) {
            return response()->json($e->getMessage(), 500);
        }
    }

    public function checkEpiredDate($quizTime, $now)
    {
        if ($quizTime != $now) {
            return false;
        }
    }

    public function checkresult(Request $request, $id)
    {
        $validator = $this->validateId($id, "quizzes");
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $myArray = $request->input('result');
        $quiz = $this->quizRepo->getQuizById($id);
        $quizItem = $quiz->quizItems;
        $data = null;
        $count = 0;
        for ($i = 0;$i < $quiz->number_item;$i++) {
            if ($quizItem[$i]->answer == $myArray[$i]) {
                $count++;
            }
        }

        $result = (($count / $quiz->number_item) * 100);

        if ($result > 60) {
            $data = 'Pass';
        } else {
            $data = 'fail';
        }

        $quizattempt = [
            'quiz_id' => $request->quiz_id,
            'student_id' => Auth::user()->student->id,
            'score' => $result.'%',
            'result' => $data
        ];
        $data =  $this->quizAttemptRepo->createQuizAttempt($quizattempt);

        return response()->json($data, 200);

    }
}
