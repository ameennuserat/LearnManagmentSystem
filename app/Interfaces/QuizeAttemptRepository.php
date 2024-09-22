<?php
namespace App\Interfaces;

use App\Models\QuizeAttempt;

interface QuizeAttemptRepository{
public function createQuizAttempt($data);
}
