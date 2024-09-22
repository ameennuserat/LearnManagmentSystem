<?php

namespace App\Repositories;

use App\Http\Requests\ChoiceRequest;
use App\Interfaces\ChoiceRepository;
use App\Models\Choice;

class ChoiceRepositoryImpl implements ChoiceRepository
{
    public function getAllChoices()
    {
        return Choice::getAll();
    }

    public function getChoiceById($choiceId)
    {
        return Choice::findOrFail($choiceId);
    }

    public function deleteChoice($choiceId)
    {
        Choice::destroy($choiceId);
    }

    public function createChoice(array $request)
    {
    return Choice::create($request,200);
    }

    public function updateChoice($choiceId, array $newDetails)
    {
        $choice = Choice::findOrFail($choiceId);
        $choice->update($newDetails);
        return $choice;
    }

}
