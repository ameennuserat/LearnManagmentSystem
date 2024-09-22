<?php

namespace App\Interfaces;

interface DiscountRepository
{
    public function getAllDiscounts();
    public function getDiscountById($discountId);
    public function deleteDiscount($discountId);
    public function createDiscount(array $discountDetails);
    public function updateDiscount($discountId, array $newDetails);
}
