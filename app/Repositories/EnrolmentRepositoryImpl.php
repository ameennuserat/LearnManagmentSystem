<?php
namespace App\Repositories;
use App\Models\Enrolment;

class EnrolmentRepositoryImpl extends EnrolmentRepositoryImpl{
    public function enrolmentCourse(array $data){
        return Enrolment::create($data);
    }
}
