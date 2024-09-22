<?php
namespace App\Repositories;
use App\Interfaces\QuizItemRepository;
use App\Models\QuizeItem;

class QuizItemRepositoryImpl implements QuizItemRepository
{
    public function getAllQuizItems(){
        return QuizeItem::getAll();
    }

    public function getQuizItemsByQuizId($quizId){
        $quizItems = QuizeItem::where('quiz_id',$quizId)->get;
        return $quizItems;
    }

    public function getQuizItemById($quizItemId){
        return QuizeItem::findOrFail($quizItemId);
    }

    public function deleteQuizItem($quizItemId){
        QuizeItem::destroy($quizItemId);
    }

    public function createQuizItem(array $quizItemDetails){
        return QuizeItem::create($quizItemDetails);
    }

    public function updateQuizItem($quizItemId, array $newDetails){
        $quizItem = QuizeItem::findOrFail($quizItemId);
        $quizItem->update($newDetails);
        return $quizItem;
    }
}
