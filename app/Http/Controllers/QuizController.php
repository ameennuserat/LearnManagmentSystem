<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\QuizRequest;
use App\Interfaces\QuizRepository;
use App\Services\QuizService;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    protected $quizService;
    public function __construct(QuizService $quizService)
    {
        $this->quizService = $quizService;
        $this->middleware('auth:api');
    }


    public function addquiz(QuizRequest $request, $id)
    {
        return $this->quizService->createQuiz($request, $id);
    }


    public function updateQuiz(QuizRequest $request, $id)
    {
        return $this->quizService->updateQuiz($request, $id);
    }

    public function deleteQuiz($id)
    {
        return $this->quizService->deleteQuiz($id);
    }

    public function getQuiz($id)
    {
        return $this->quizService->getQuiz($id);
    }

    public function checkresult(Request $request,$id)
    {
        return $this->quizService->checkresult($request,$id);
    }

}
