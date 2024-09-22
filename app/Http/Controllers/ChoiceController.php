<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\ChoiceRequest;
use App\Services\ChoiceService;
use Illuminate\Http\Request;

class ChoiceController extends Controller
{
    protected $choiceService;
    public function __construct(ChoiceService $choiceService)
    {
        $this->choiceService = $choiceService;
        $this->middleware('auth:api');
    }


    public function addChoice(ChoiceRequest $request,$id)
    {
        return $this->choiceService->createChoice($request,$id);
    }

    public function deleteChoice($id)
    {
        return $this->choiceService->deleteChoice($id);
    }

}
