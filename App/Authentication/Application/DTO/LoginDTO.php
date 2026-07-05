<?php  

namespace App\Authentication\Application\DTO;

class LoginDTO
{
    public function __construct(
        public string $email,
        public string $password
    ) {}
}