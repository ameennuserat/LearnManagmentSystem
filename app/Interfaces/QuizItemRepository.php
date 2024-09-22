<?php

namespace App\Interfaces;

interface QuizItemRepository
{
    public function getAllQuizItems();
    public function getQuizItemsByQuizId($quizId);
    public function getQuizItemById($quizItemId);
    public function deleteQuizItem($quizItemId);
    public function createQuizItem(array $quizItemDetails);
    public function updateQuizItem($quizItemId, array $newDetails);
}
