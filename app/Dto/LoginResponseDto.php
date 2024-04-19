<?php

namespace App\Dto;

use App\Models\User;

class LoginResponseDto {
    public mixed $user;
    public string $token;
    
    public function __construct(mixed $user, string $token)
    {
        $this->user = $user;
        $this->token = $token;
    }
}