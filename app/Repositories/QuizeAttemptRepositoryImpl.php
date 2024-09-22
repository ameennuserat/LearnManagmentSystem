<?php

use App\Interfaces\QuizeAttemptRepository;
use App\Models\QuizeAttempt;

class QuizeAttemptRepositoryImpl implements QuizeAttemptRepository{

    public function createQuizAttempt($data){
        return QuizeAttempt::create($data);
    }
}
