<?php

namespace App\Services;

use App\Http\Requests\FrequentlyQuestionRequest;
use App\Interfaces\FrequentlyQuestionRepository;
use Exception;
use Illuminate\Support\Facades\DB;

class FrequentlyQuestionService
{
    protected $frequaRepo;
    public function __construct(FrequentlyQuestionRepository $frequaRepo)
    {
        $this->frequaRepo = $frequaRepo;
    }

    public function createFrequentlyQuestion(FrequentlyQuestionRequest $request)
    {
        try {
            DB::beginTransaction();
            $result = $this->frequaRepo->creteFrequentlyQuestion($request->all());
            DB::commit();
            return response()->json($result, 200);
        } catch (Exception $e) {
            return response()->json($e->getMessage(), 500);
        }
    }

    public function deleteFrequentlyQuestion($id)
    {
        $this->frequaRepo->deleteFrequentlyQuestion($id);
        return response()->json("deleted", 200);
    }
}
