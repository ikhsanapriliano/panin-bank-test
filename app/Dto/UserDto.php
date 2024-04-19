<?php

namespace App\Dto;

class UserDto {
    public string $name;
    public string $email;
    public string $password;
    public string $role;
    
    public function __construct(string $name, string $email, string $password, string $role)
    {
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
        $this->role = $role;
    }
}