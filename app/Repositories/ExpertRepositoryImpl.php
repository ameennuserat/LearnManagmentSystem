<?php

namespace App\Repositories;

use App\Interfaces\ExpertRepository;
use App\Models\Expert;

class ExpertRepositoryImpl implements ExpertRepository
{
    public function getAllExperts()
    {
        $experts = Expert::with(['user' => function ($query) {
            $query->select('name', 'email');
        }])->get();
        return $experts;
    }

    public function getExpertById($expertId)
    {
        return Expert::findOrFail($expertId);
    }

    public function deleteExpert($expertId)
    {
        Expert::deleted($expertId);
    }

    public function createExpert(array $expertDetails)
    {
        return Expert::create($expertDetails);
    }

    public function updateExpert($expertId, array $newDetails)
    {
        $expert = Expert::findOrFail($expertId);
        $expert->phone = $newDetails['phone'];
        $expert->bio = $newDetails['bio'];
        $expert->save();
        return $expert;
    }


}
