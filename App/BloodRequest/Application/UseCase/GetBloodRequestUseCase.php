<?php

namespace App\BloodRequest\Application\UseCase;

use App\BloodRequest\Domain\Repository\BloodRequestRepositoryInterface;

class GetBloodRequestUseCase
{
    public function __construct(
        private BloodRequestRepositoryInterface $bloodRequestRepo
    ) {}

    public function execute(int $requestId): ?array
    {
        return $this->bloodRequestRepo->findById($requestId);
    }

    public function getPatientRequestDetail(int $requestId, int $patientId): array
    {
        return $this->bloodRequestRepo->findPatientRequestDetail($requestId, $patientId);
    }

    public function getDonorRequestDetail(int $requestId, int $donorId, int $acceptedStatus): array
    {
        return $this->bloodRequestRepo->findDonorRequestDetail($requestId, $donorId, $acceptedStatus);
    }
}
