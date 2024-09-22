<?php

namespace App\Interfaces;

interface VideoRepository
{
    public function getAllVideos();
    public function getVideosByVideoGroupId($videoGroupId);
    public function getVideoById($videoId);
    public function deleteVideo($videoId);
    public function createVideo(array $videoDetails);
    public function updateVideo($videoId, array $newDetails);
}
