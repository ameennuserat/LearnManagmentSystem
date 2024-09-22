<?php

namespace App\Services;

use App\Http\Requests\ChoiceRequest;
use App\Http\Requests\VideoGroupRequest;
use App\Http\Trait\HelperUtil;
use App\Interfaces\ChoiceRepository;
use App\Interfaces\VideoGroupRepository;
use App\Models\VideoGroup;
use Exception;
use Illuminate\Auth\Events\Validated;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ChoiceService
{
    use HelperUtil;
    protected $choiceRepo;
    public function __construct(ChoiceRepository $choiceRepo)
    {
        $this->choiceRepo = $choiceRepo;
    }


    public function createChoice(ChoiceRequest $request, $id)
    {
        try {
            DB::beginTransaction();
            $validator = $this->validateId($id, "quiz_Items");
            if ($validator->fails()) {
                return response()->json($validator->errors(), 422);
            }
            $data = $request->all();
            $data['quize_item_id'] = $id;
            $videoGroup = $this->choiceRepo->createChoice($data);
            DB::commit();
            return response()->json($videoGroup, 200);
        } catch (Exception $e) {
            DB::rollback();
            return response()->json($e->getMessage(), 500);
        }
    }


    public function deleteChoice($id)
    {
        try {
            DB::beginTransaction();
            $validator = $this->validateId($id,"choices");
            if ($validator->fails()) {
                return response()->json($validator->errors(), 422);
            }
            $this->choiceRepo->deleteChoice($id);
            DB::commit();
            return response()->json(["message" => "deleted"], 200);
        } catch (Exception $e) {
            Db::rollBack();
            return response()->json($e->getMessage(), 500);
        }
    }
}
