<?php

namespace App\Repositories;

use App\Interfaces\CategoryRepository;
use App\Models\Category;

class CategoryRepositoryImpl implements CategoryRepository
{
    public function getAllCategories()
    {
        return Category::getAll();
    }

    public function getCategoryById($categoryId)
    {
        $category = Category::find($categoryId);
        return $category;
    }

    public function deleteCategory($categoryId)
    {
        Category::destroy($categoryId);
    }

    public function createCategory(array $categoryDetails)
    {
        return Category::create($categoryDetails);
    }

    public function updateCategor($categoryId, array $newDetails)
    {
        $category = Category::findOrFail($categoryId);
        $category->update($newDetails);
        return $category;
    }

    public function getCategoryByName($name)
    {
        return Category::where('name', $name)->get();
    }
}
