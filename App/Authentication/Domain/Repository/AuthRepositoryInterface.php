<?php

namespace App\Authentication\Domain\Repository;

interface AuthRepositoryInterface
{
    public function findByEmail(string $email);
    public function create(array $data);
    public function registerDonor($data);
    public function registerPatient($data);
}
