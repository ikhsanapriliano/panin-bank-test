<?php

namespace App\Services\Auth;

use App\Dto\LoginResponseDto;
use App\Dto\UserDto;
use App\Models\User;

interface AuthServiceInterface {
    public function register(UserDto $payload): User;
    public function login(array $credentials): ?LoginResponseDto;
}