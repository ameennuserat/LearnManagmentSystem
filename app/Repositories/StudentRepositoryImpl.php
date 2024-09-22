<?php

namespace App\Repositories;

use App\Interfaces\StudentRepository;
use App\Models\Student;

class StudentRepositoryImpl implements StudentRepository
{
    public function create(array $info)
    {
        return Student::create($info);
    }

    public function getStudentById($studentId)
    {
        return Student::findOrFail($studentId);
    }

    public function getAllStudents()
    {
        return Student::getAll();
    }
}
