<?php

namespace App\Interfaces;

interface CategoryRepository
{
    public function getAllCategories();
    public function getCategoryByName($name);
    public function getCategoryById($categoryId);
    public function deleteCategory($categoryId);
    public function createCategory(array $categoryDetails);
    public function updateCategor($categoryId, array $newDetails);
}
