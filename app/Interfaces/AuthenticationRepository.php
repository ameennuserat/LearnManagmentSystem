<?php

namespace App\Interfaces;

interface AuthenticationRepository
{
    public function register(array $info);
}
