<?php

namespace App\BloodRequest\Domain\Repository;

interface BloodRequestRepositoryInterface
{
    public function findById(int $id);
    public function findByPatientId(int $patientId): array;
    public function findPatientRequestDetail(int $requestId, int $patientId): array;
    public function findAcceptedRequestsForDonor(int $donorId, int $acceptedStatus): array;
    public function findDonorRequestDetail(int $requestId, int $donorId, int $acceptedStatus): array;
    public function create(array $data): bool;
    public function findAll(): array;
    public function findPendingRequestsForDonor(string $bloodGroup): array;
    public function getMatchingDonors(string $bloodGroup): array;
    public function acceptByAdmin(int $requestId, int $donorId, int $statusId): bool;
    public function getPatientStats(int $patientId): array;
    public function hasPendingRequest(int $patientId): bool;
    public function updateDonorDecision(int $requestId, int $donorId, int $statusId): bool;
    public function cancelRequest(int $requestId, int $patientId, int $cancelledStatus): bool;
    public function deleteRequest(int $requestId): bool;
    public function countAcceptedByDonors(): int;
}
