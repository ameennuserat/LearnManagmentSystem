<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\Expert;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Support\Facades\Validator;
use App\Mail\VerificationEmail;
use App\Models\Wallet;
use App\Services\AuthService;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    protected $authService;
    public function __construct(AuthService $authService1)
    {
        $this->authService = $authService1;
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    public function login(LoginRequest $request)
    {
        return $this->authService->login($request);
    }

    public function register(RegisterRequest $request)
    {
        return $this->authService->register($request);
    }

    public function logout()
    {
        return $this->authService->logout();

    }

    public function refresh()
    {
        return $this->authService->refresh();
    }


}
