<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\DiscountRequest;
use DiscountService;
use Illuminate\Http\Request;

class DiscountController extends Controller
{
    protected $discountService;
    public function __construct(DiscountService $discountService)
    {
        $this->discountService = $discountService;
        $this->middleware('auth:api');
    }

    public function addDiscount(DiscountRequest $request,$id)
    {
        return $this->discountService->createDiscount($request,$id);
    }

    public function cancelDiscount($id)
    {
        return $this->discountService->cancelDiscount($id);
    }

}
