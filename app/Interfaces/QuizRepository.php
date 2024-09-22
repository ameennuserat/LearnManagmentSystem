<?php

namespace App\Interfaces;

interface QuizRepository
{
    public function getAllQuizs();
    public function getQuizsByVideoGroupId($videoGroupId);
    public function getQuizById($quizId);
    public function deleteQuiz($quizId);
    public function createQuiz(array $quizDetails);
    public function updateQuiz($quizId, array $newDetails);
}
