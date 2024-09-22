<?php

namespace App\Http\Controllers;

use App\Services\CtegoryService as ServicesCtegoryService;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    protected $categoryService;
    public function __construct(ServicesCtegoryService $categoryService)
    {
        $this->categoryService = $categoryService;
        $this->middleware('auth')->only('enrolmentCourse');
    }

    public function getExplore()
    {
        return $this->categoryService->getExplore();
    }

    public function getCategory()
    {
        return $category = $this->categoryService->getCategory();
    }
}
