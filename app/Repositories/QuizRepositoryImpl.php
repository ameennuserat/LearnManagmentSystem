<?php

namespace App\Repositories;

use App\Interfaces\QuizRepository;
use App\Models\Quiz;

class QuizRepositoryImpl implements QuizRepository
{
    public function getAllQuizs()
    {
        return Quiz::getAll();
    }

    public function getQuizsByVideoGroupId($videoGroupId)
    {
        $quizes = Quiz::where('video_group_id', $videoGroupId)->get;
        return $quizes;
    }

    public function getQuizById($quizId)
    {
        return Quiz::findOrFail($quizId);
    }

    public function deleteQuiz($quizId)
    {
        Quiz::destroy($quizId);
    }

    public function createQuiz(array $quizDetails)
    {
        return Quiz::create($quizDetails);
    }

    public function updateQuiz($quizId, array $newDetails)
    {
        $quiz = Quiz::findOrFail($quizId);
        $quiz->update($newDetails);
        return $quiz;
    }
}
