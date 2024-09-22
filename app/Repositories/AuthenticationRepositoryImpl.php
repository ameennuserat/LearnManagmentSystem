<?php

namespace App\Repositories;

use App\Interfaces\AuthenticationRepository;
use App\Interfaces\CategoryRepository;
use App\Models\Category;
use App\Models\User;

class AuthenticationRepositoryImpl implements AuthenticationRepository
{
    public function register(array $info)
    {
        return User::create($info);
    }
}
