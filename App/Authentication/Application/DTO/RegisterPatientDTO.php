<?php   

namespace App\Authentication\Application\DTO;

class RegisterPatientDTO
{
    public function __construct(
        public string $username,
        public string $email,
        public string $phone,
        public string $password,
        public ?string $blood_group,
        public ?string $address,
        public string $role
    ) {}
}