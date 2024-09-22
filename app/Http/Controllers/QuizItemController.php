<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\QuizItemRequest;
use App\Services\QuizItemService;
use Illuminate\Http\Request;

class QuizItemController extends Controller
{
    protected $quizItemService;

    public function __construct(QuizItemService $quizItemService)
    {
        $this->quizItemService = $quizItemService;
        $this->middleware('auth:api');
    }

    public function addQuizItem(QuizItemRequest $request, $id)
    {
        return $this->quizItemService->createQuizItem($request, $id);
    }


    public function updateQuizItem(Request $request, $id)
    {
        return $this->quizItemService->updateQuizItem($request, $id);
    }

    public function deleteQuizItem($id)
    {
        return $this->quizItemService->deleteQuizItem($id);
    }

}
