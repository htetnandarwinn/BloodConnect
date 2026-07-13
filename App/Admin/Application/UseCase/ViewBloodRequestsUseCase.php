<?php

namespace App\Admin\Application\UseCase;

use App\BloodRequest\Domain\Repository\BloodRequestRepositoryInterface;
use App\Shared\Infrastructure\Persistence\MasterDataRepository;

class ViewBloodRequestsUseCase
{
    public function __construct(
        private BloodRequestRepositoryInterface $bloodRequestRepo,
        private MasterDataRepository $masterRepo
    ) {}

    public function getRequestDetail(int $requestId): ?array
    {
        return $this->bloodRequestRepo->findById($requestId);
    }

    public function getMatchingDonors(string $bloodGroup): array
    {
        return $this->bloodRequestRepo->getMatchingDonors($bloodGroup);
    }

    public function isRequestAccepted(array $request): bool
    {
        $acceptedStatusId = $this->getAcceptedStatusId();
        return ((int)($request['status'] ?? 0) === $acceptedStatusId)
            || (strtolower((string)($request['status_name'] ?? '')) === 'accepted');
    }

    public function getAcceptedStatusId(): int
    {
        return $this->masterRepo->getId('REQUEST_STATUS', 'ACCEPTED') ?? 8;
    }

    public function getPendingStatusId(): int
    {
        return $this->masterRepo->getId('REQUEST_STATUS', 'PENDING') ?? 7;
    }

    public function isRequestCancelled(array $request): bool
    {
        $cancelledStatusId = $this->masterRepo->getId('REQUEST_STATUS', 'CANCELLED') ?? 10;
        return ((int)($request['status'] ?? 0) === $cancelledStatusId)
            || (strtolower((string)($request['status_name'] ?? '')) === 'cancelled');
    }

    public function assignDonorToRequest(int $requestId, int $donorId, int $statusId): bool
    {
        return $this->bloodRequestRepo->acceptByAdmin($requestId, $donorId, $statusId);
    }
}
