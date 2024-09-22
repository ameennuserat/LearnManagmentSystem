<?php

namespace App\Repositories;

use App\Interfaces\VideoGroupRepository;
use App\Models\VideoGroup;

class VideoGroupRepositoryImpl implements VideoGroupRepository
{
    public function getAllVideoGroups()
    {
        return VideoGroup::getAll();
    }

    public function getVideoGroupsByCourseId($courseId)
    {
        $videoGroups = VideoGroup::where('course_id', $courseId)->get();
        return $videoGroups;
    }

    public function getVideoGroupById($videoGroupId)
    {
        return VideoGroup::findOrFail($videoGroupId);
    }

    public function deleteVideoGroup($videoGroupId)
    {
        VideoGroup::destroy($videoGroupId);
    }

    public function createVideoGroup(array $userDetails)
    {
        return VideoGroup::create($userDetails);
    }

    public function updateVideoGroup($videoGroupId, array $newDetails)
    {
        $videoGroup = VideoGroup::finaOrFail($videoGroupId);
        $videoGroup->update($newDetails);
        return $videoGroup;
    }
}
