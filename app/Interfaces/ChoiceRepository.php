<?php

namespace App\Interfaces;

use App\Http\Requests\ChoiceRequest;

interface ChoiceRepository
{
    public function getAllChoices();
    public function getChoiceById($choiceId);
    public function deleteChoice($choiceId);
    public function createChoice(array $request);
    public function updateChoice($choiceId, array $newDetails);
}
