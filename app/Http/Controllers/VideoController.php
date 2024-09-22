<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\VideoRequest;
use App\Services\VideoService;
use Illuminate\Http\Request;

class VideoController extends Controller
{
    protected $videoService;

    public function __construct(VideoService $videoService)
    {
        $this->videoService = $videoService;
        $this->middleware('auth:api');
    }


    public function addVideo(VideoRequest $request, $id)
    {
        return $this->videoService->createVideo($request, $id);
    }


    public function updateVideo(Request $request, $id)
    {
        return $this->videoService->updateVideo($request, $id);
    }

    public function deleteVideo($id)
    {
        return $this->videoService->deleteVideo($id);
    }


    public function getVideos($id)
    {
        return $this->videoService->getVideosByVideoGroupId($id);
    }

}
