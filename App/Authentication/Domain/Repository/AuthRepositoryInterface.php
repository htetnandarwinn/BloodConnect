<?php

namespace App\Authentication\Domain\Repository;

use App\Authentication\Application\DTO\RegisterPatientDTO;
use App\Authentication\Application\DTO\RegisterDonorDTO;

interface AuthRepositoryInterface
{
    public function findByEmail(string $email);

    public function createPatient(
        RegisterPatientDTO $dto,
        int $userTypeId,
        int $statusId,
        int $otp,
        string $expiresAt
    ): string;

    // public function createDonor(RegisterDonorDTO $dto);
}
