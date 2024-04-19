<?php

namespace App\Repositories\Auth;

use App\Dto\UserDto;
use App\Models\User;
use Ramsey\Uuid\Rfc4122\UuidV4;

class AuthRepository implements AuthRepositoryInterface {
    private user $user;
    
    public function __construct(User $user)
    {
        $this->user = $user;   
    }

    public function create(UserDto $payload): User 
    {
        $data = $this->user->create([
            'id' => UuidV4::uuid4()->toString(),
            'name' => $payload->name,
            'email' => $payload->email,
            'password' => bcrypt($payload->password),
            'role' => $payload->role
        ]);

        return $data;
    }
}