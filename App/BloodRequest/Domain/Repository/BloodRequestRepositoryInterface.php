<?php

namespace App\BloodRequest\Domain\Repository;

interface BloodRequestRepositoryInterface
{

    public function findById(int $id);


    public function findByPatientId(int $patientId): array;


    public function create(array $data): bool;


    public function findAll(): array;


    public function findPendingRequestsForDonor(
        string $bloodGroup
    ): array;


    public function updateDonorDecision(
        int $requestId,
        int $donorUserId,
        int $statusId
    ): bool;
}
