<?php

namespace App\Interfaces;

interface FrequentlyQuestionRepository
{
    public function creteFrequentlyQuestion(array $data);

    public function deleteFrequentlyQuestion($id);
}
