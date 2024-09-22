<?php

namespace App\Interfaces;

interface StudentRepository
{
    public function create(array $info);
    public function getStudentById($studentId);
    public function getAllStudents();

}
