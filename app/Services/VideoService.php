<?php

namespace App\Services;

use App\Http\Requests\VideoRequest;
use App\Http\Trait\HelperUtil;
use App\Interfaces\VideoRepository;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class VideoService
{
    use HelperUtil;
    protected $videoRepo;
    public function __construct(VideoRepository $videoRepository)
    {
        $this->videoRepo = $videoRepository;
    }


    public function createVideo(VideoRequest $request, $id)
    {
        try {
            DB::beginTransaction();
            $validator = $this->validateId($id, "video_groups");
            if ($validator->fails()) {
                return response()->json($validator->errors(), 422);
            }
            $data = $request->all();
            $data['video_group_id'] = $id;
            $video = $this->videoRepo->createVideo($data);
            DB::commit();
            return response()->json($video, 200);
        } catch (Exception $e) {
            DB::rollback();
            return response()->json($e->getMessage(), 500);
        }
    }


    public function updateVideo(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            $validator = $this->validateId($id, "videos");
            if ($validator->fails()) {
                return response()->json($validator->errors(), 422);
            }
            $data = $request->all();
            $video = $this->videoRepo->updateVideo($id, $data);
            DB::commit();
            return response()->json($video, 200);
        } catch (Exception $e) {
            DB::rollback();
            return response()->json($e->getMessage(), 500);
        }
    }


    public function deleteVideo($id)
    {
        try {
            DB::beginTransaction();
            $validator = $this->validateId($id, "videos");
            if ($validator->fails()) {
                return response()->json($validator->errors(), 422);
            }
            $this->videoRepo->deleteVideo($id);
            DB::commit();
            return response()->json(["message" => "deleted"], 200);
        } catch (Exception $e) {
            DB::rollback();
            return response()->json($e->getMessage(), 500);
        }
    }

    public function getVideosByVideoGroupId($videoGroupId)
    {
        $validator = $this->validateId($videoGroupId, "video_groups");
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        return $this->videoRepo->getVideosByVideoGroupId($videoGroupId);
    }
}
