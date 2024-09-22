<?php

namespace App\Services;

use App\Http\Requests\VideoGroupRequest;
use App\Http\Trait\HelperUtil;
use App\Interfaces\VideoGroupRepository;
use App\Models\VideoGroup;
use Exception;
use Illuminate\Auth\Events\Validated;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class VideoGroupService
{
    use HelperUtil;
    protected $videoGroupRepo;
    public function __construct(VideoGroupRepository $videoGroupRepository)
    {
        $this->videoGroupRepo = $videoGroupRepository;
    }


    public function createVideoGroup(VideoGroupRequest $request, $CourseId)
    {
        try {
            DB::beginTransaction();
            $validator = $this->validateId($CourseId, "courses");
            if ($validator->fails()) {
                return response()->json($validator->errors(), 422);
            }
            $data = $request->all();
            $data['course_id'] = $CourseId;
            $videoGroup = $this->videoGroupRepo->createVideoGroup($data);
            DB::commit();
            return response()->json($videoGroup, 200);
        } catch (Exception $e) {
            DB::rollback();
            return response()->json($e->getMessage(), 500);
        }
    }


    public function deleteVideoGroup($id)
    {
        try {
            DB::beginTransaction();
            $validator = $this->validateId($id, "video_groups");
            if ($validator->fails()) {
                return response()->json($validator->errors(), 422);
            }
            $this->videoGroupRepo->deleteVideoGroup($id);
            DB::commit();
            return response()->json(["message" => "deleted"], 200);
        } catch (Exception $e) {
            Db::rollBack();
            return response()->json($e->getMessage(), 500);
        }
    }


    public function getVideoGroupsByCourseId($courseId){
        $validator = $this->validateId($courseId, "courses");
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        return $this->videoGroupRepo->getVideoGroupsByCourseId($courseId);
    }
}
