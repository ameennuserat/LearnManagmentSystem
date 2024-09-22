<?php

namespace App\Repositories;

use App\Interfaces\UserRepository;
use App\Models\User;

class UserRepositoryImpl implements UserRepository
{
    public function getAllUsers()
    {
        return User::getAll();
    }

    public function getUserById($userId)
    {
        return User::findOrFail($userId);
    }

    public function deleteUser($userId)
    {
        User::destroy($userId);
    }

    public function createUser(array $userDetails)
    {
        return User::create($userDetails);
    }

    public function updateUser($userId, array $newDetails)
    {
        $user = User::findOrFail($userId);
        $user->update($newDetails);
        return $user;
    }
}
