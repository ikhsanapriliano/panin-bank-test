<?php

namespace App\Services\Auth;

use App\Dto\LoginResponseDto;
use App\Dto\UserDto;
use App\Models\User;
use App\Repositories\Auth\AuthRepository;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthService implements AuthServiceInterface {
    private AuthRepository $authRepository;

    public function __construct(AuthRepository $authRepository)
    {
        $this->authRepository = $authRepository;
    }

    public function register(UserDto $payload): User 
    {
        $data = $this->authRepository->create($payload);
        return $data;
    }

    public function login(array $credentials): ?LoginResponseDto 
    {
        if(!$token = auth()->guard('api')->attempt($credentials)) {
            return null;
        }

        $user = auth()->guard('api')->user();

        $result = new LoginResponseDto($user, $token);
        return $result;
    }
}