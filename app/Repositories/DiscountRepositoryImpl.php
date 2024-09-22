<?php

namespace App\Repositories;

use App\Http\Requests\ChoiceRequest;
use App\Interfaces\ChoiceRepository;
use App\Interfaces\CourseRepository;
use App\Interfaces\DiscountRepository;
use App\Models\Choice;
use App\Models\Course;
use App\Models\Discount;

class DiscountRepositoryImpl implements DiscountRepository
{
    public function getAllDiscounts(){
        return Discount::getAll();
    }

    public function getDiscountById($discountId){
        return Discount::findOrfail($discountId);
    }

    public function deleteDiscount($discountId){
        Discount::destroy($discountId);
    }

    public function createDiscount(array $discountDetails){
        return Discount::create($discountDetails);
    }

    public function updateDiscount($discountId, array $newDetails){
        $discount = Discount::findOrFail($discountId);
        $discount->update($newDetails);
        return $discount;
    }

}
