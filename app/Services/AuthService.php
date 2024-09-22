<?php

namespace App\Services;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Interfaces\AuthenticationRepository;
use App\Interfaces\StudentRepository;
use App\Interfaces\WalletRepository;
use App\Models\Wallet;
use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AuthService
{
    protected $authRepo;
    protected $wallet;
    protected $userProfile;
    public function __construct(
        AuthenticationRepository $userRepository,
        WalletRepository $wallet,
        StudentRepository $studentRepository
    ) {
        $this->authRepo = $userRepository;
        $this->wallet = $wallet;
        $this->userProfile = $studentRepository;
    }

    public function register(RegisterRequest $request)
    {
        try {
            DB::beginTransaction();
            $userInfo = $request->all();
            $user = $this->authRepo->register($userInfo);
            if ($this->checkRole($request->role)) {
                $this->addBalance($user->id);
                $this->userProfile($user->id);
            }
            DB::commit();
            return $user;
        } catch (Exception $e) {
            DB::rollback();
            return  $e->getMessage();
        }
    }

    public function login(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');
        $token = Auth::attempt($credentials);

        if (!$token) {
            return response()->json(['message' => 'invalid info'], 400);
        }

        $user = Auth::user();
        $response = [
            'user' => $user,
            'authorization' => [
                'token' => $token,
                'type' => 'bearer',
            ]];

        return response()->json($response, 200);
    }

    public function logout()
    {
        Auth::logout();
        return response()->json([
            'message' => 'Successfully logged out',
        ]);
    }

    public function refresh()
    {
        return response()->json([
            'user' => Auth::user(),
            'authorisation' => [
                'token' => Auth::refresh(),
                'type' => 'bearer',
            ]
        ]);
    }

    public function checkRole($role)
    {
        if ($role == "User") {
            return true;
        }
        return false;
    }

    public function addBalance($id)
    {
        Wallet::create([
            'amount' => 1000000,
            'user_id' => $id
        ]);
    }

    public function userProfile($id)
    {
        $info = [
            'user_id' => $id,
           'last_searching' => "programing"
        ];
        $this->userProfile->create($info);
    }
}
