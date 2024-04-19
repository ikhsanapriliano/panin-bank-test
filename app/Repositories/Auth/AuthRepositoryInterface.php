<?php

namespace App\Repositories\Auth;

use App\Dto\UserDto;
use App\Models\User;

interface AuthRepositoryInterface {
    public function create(UserDto $payload): User;
}