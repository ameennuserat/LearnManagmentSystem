<?php

namespace App\Interfaces;

interface ExpertRepository
{
    public function getAllExperts();
    public function getExpertById($expertId);
    public function deleteExpert($expertId);
    public function createExpert(array $expertDetails);
    public function updateExpert($expertId, array $newDetails);
}
