<?php

namespace App\Donor\Domain\Repository;

interface DonorRepositoryInterface
{
    public function findById(int $id);
    public function search(array $criteria);
    public function syncAvailabilityStatus(int $userId): array;
    public function saveNextAvailableDate(int $userId, string $nextAvailableDate): bool;
    public function updateProfile(int $id, array $data): bool;
    public function createDonorProfile(int $userId): bool;
    public function getDonorDetails(int $userId): ?array;
    public function saveDonorDetails(int $userId, array $data): bool;
    public function isProfileComplete(int $userId): bool;
    public function updateWeight(int $userId, string $weight): bool;
    public function ensureDonorColumns(): void;
    public function ensureLocationColumns(): void;
    public function saveLocation(int $userId, string $stateRegion, string $township): bool;
}
