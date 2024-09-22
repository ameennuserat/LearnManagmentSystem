<?php

namespace App\Repositories;

use App\Interfaces\VideoRepository;
use App\Models\Video;

class VideoRepositoryImpl implements VideoRepository
{
    public function getAllVideos()
    {
        return Video::getAll();
    }

    public function getVideosByVideoGroupId($videoGroupId)
    {
        $videos = Video::where('video_group_id', $videoGroupId)->get;
        return $videos;
    }

    public function getVideoById($videoId)
    {
        return Video::FindOrFail($videoId);
    }

    public function deleteVideo($videoId)
    {
        Video::destroy($videoId);
    }

    public function createVideo(array $videoDetails)
    {
        return Video::create($videoDetails);
    }

    public function updateVideo($videoId, array $newDetails)
    {
        $video = Video::findOrFail($videoId);
        $video->update($newDetails);
        return $video;
    }
}
