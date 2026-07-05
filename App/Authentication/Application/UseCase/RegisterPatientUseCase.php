<?php

namespace App\Authentication\Application\UseCase;

use App\Authentication\Application\DTO\RegisterPatientDTO;
use App\Authentication\Domain\Repository\AuthRepositoryInterface;
use App\Shared\Infrastructure\Mail\EmailService;

class RegisterPatientUseCase
{
    public function __construct(
        private AuthRepositoryInterface $repo,
        private EmailService $emailService
    ) {}

    public function execute(
        RegisterPatientDTO $dto,
        int $userTypeId,
        int $statusId,
        int $otp,
        string $expiresAt
    ): string {

        if ($this->repo->findByEmail($dto->email)) {
            throw new \DomainException("Email already exists");
        }

        // 1. Save user
        $userId = $this->repo->createPatient(
            $dto,
            $userTypeId,
            $statusId,
            $otp,
            $expiresAt
        );

        // 2. Send OTP EMAIL (IMPORTANT PART)
        $this->emailService->sendOtp($dto->email, $otp);

        return $userId;
    }
}
