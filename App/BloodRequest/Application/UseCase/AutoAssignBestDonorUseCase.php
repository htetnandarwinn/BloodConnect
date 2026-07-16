<?php

namespace App\BloodRequest\Application\UseCase;

use App\BloodRequest\Domain\Repository\BloodRequestRepositoryInterface;
use App\Shared\Infrastructure\Persistence\MasterDataRepository;

class AutoAssignBestDonorUseCase
{
    public function __construct(
        private BloodRequestRepositoryInterface $bloodRequestRepo,
        private MasterDataRepository $masterRepo
    ) {}

    /**
     * Assigns the highest-priority available donor to a request, following the
     * location hierarchy: same township -> same region -> any region.
     * Only assigns when no donor is already attached to the request.
     *
     * @return array{success:bool, donor_id?:int, tier?:string, error?:string}
     */
    public function execute(int $requestId, string $bloodGroup, ?string $township, ?string $stateRegion): array
    {
        $request = $this->bloodRequestRepo->findById($requestId);
        if (!$request) {
            return ['success' => false, 'error' => 'Request not found.'];
        }

        if (!empty($request['donor_id'])) {
            return ['success' => true, 'donor_id' => (int)$request['donor_id'], 'tier' => 'existing'];
        }

        $best = $this->bloodRequestRepo->findBestDonorByLocation($bloodGroup, $township, $stateRegion);
        if ($best === null) {
            return ['success' => true, 'donor_id' => null, 'tier' => 'none'];
        }

        $pendingStatus = $this->masterRepo->getId('REQUEST_STATUS', 'PENDING') ?? 7;
        $assigned = $this->bloodRequestRepo->assignDonorsToRequest($requestId, [(int)$best['donor']['user_id']], $pendingStatus);

        if (!$assigned) {
            return ['success' => false, 'error' => 'Failed to auto-assign donor.'];
        }

        return ['success' => true, 'donor_id' => (int)$best['donor']['user_id'], 'tier' => $best['tier']];
    }
}
