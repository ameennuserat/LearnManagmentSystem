<?php

namespace App\Interfaces;

interface VideoGroupRepository
{
    public function getAllVideoGroups();
    public function getVideoGroupsByCourseId($courseId);
    public function getVideoGroupById($userId);
    public function deleteVideoGroup($userId);
    public function createVideoGroup(array $userDetails);
    public function updateVideoGroup($userId, array $newDetails);
}
