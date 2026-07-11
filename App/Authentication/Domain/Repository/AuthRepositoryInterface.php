<?php

namespace App\Authentication\Domain\Repository;

use App\Authentication\Application\DTO\RegisterPatientDTO;

interface AuthRepositoryInterface
{
    public function findByEmail(string $email);
    public function findByUsername(string $username);
    public function createPatient(RegisterPatientDTO $dto, int $userTypeId, int $statusId, int $otp, string $expiresAt): string;
    public function createDonor(RegisterPatientDTO $dto);
    public function markAsVerified(int $userId): void;
    public function updateVerificationCode(string $email, int $code, string $expires): void;
    public function updatePassword(string $email, string $hashedPassword): void;
    public function clearVerificationCode(string $email): void;
    public function findByGoogleId(string $googleId);
    public function findByEmailWithGoogle(string $email);
    public function createGoogleUser(string $username, string $email, string $googleId, string $avatar, int $userTypeId, int $statusId, string $bloodGroup = ''): int;
    public function linkGoogleAccount(int $userId, string $googleId, string $avatar): bool;
    public function getPermissionsByUserType(int $userTypeId): array;
}
