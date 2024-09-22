<?php

namespace App\Services;

use App\Interfaces\CategoryRepository;
use Illuminate\Support\Facades\Auth;

class CtegoryService
{
    protected $categoryRepo;

    public function __construct(CategoryRepository $categoryRepo)
    {
        $this->categoryRepo = $categoryRepo;
    }

    public function getExplore()
    {
        $student = Auth::user()->student;
        $explore = $student->last_searching;
        $categoy = $this->categoryRepo->getCategoryByName($explore);
        $id = $categoy[0]['id'];

        $courses = $this->categoryRepo->getCategoryById($id)->courses;
        return response()->json($courses);
    }


    public function getCategory()
    {
        $category = $this->categoryRepo->getAllCategories();
        return response()->json($category, 200);
    }

}
