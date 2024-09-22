<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\VideoGroupRequest;
use Illuminate\Http\Request;
use App\Services\VideoGroupService;
use Illuminate\Support\Facades\Validator;

class VideoGroupController extends Controller
{
    protected $videoGroupService;
    public function __construct(VideoGroupService $videoGroupService)
    {
        $this->middleware('auth:api');
        $this->videoGroupService = $videoGroupService;
    }

    public function addVideoGroup(VideoGroupRequest $request, $id)
    {
        return $this->videoGroupService->createVideoGroup($request, $id);
    }

    public function deleteVideoGroup($id)
    {
        return $this->videoGroupService->deleteVideoGroup($id);
    }

    public function getVideoGroups($id)
    {
        $this->videoGroupService->getVideoGroupsByCourseId($id);
    }



}
