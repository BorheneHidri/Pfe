<?php
namespace App\DTO\User;

class UserDTO
{
    public function __construct(
        public string $email,
        public string $password,
        public string $fullname,
        public string $username
    ) {}
}
