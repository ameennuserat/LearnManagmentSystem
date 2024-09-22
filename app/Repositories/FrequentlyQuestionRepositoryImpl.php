<?php

namespace App\Repositories;

use App\Interfaces\FrequentlyQuestionRepository;
use App\Models\Frequentlyquestions;

class FrequentlyQuestionRepositoryImpl implements FrequentlyQuestionRepository
{
    public function creteFrequentlyQuestion(array $data)
    {
        return Frequentlyquestions::creaet($data);
    }

    public function deleteFrequentlyQuestion($id)
    {
        return Frequentlyquestions::destroy($id);
    }
}
