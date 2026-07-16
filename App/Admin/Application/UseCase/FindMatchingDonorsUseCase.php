<?php

namespace App\Admin\Application\UseCase;

use App\BloodRequest\Domain\Repository\BloodRequestRepositoryInterface;
use App\BloodRequest\Domain\Service\RequestPrioritizationService;
use App\Donor\Domain\Service\DonorLocationMatchingService;

class FindMatchingDonorsUseCase
{
    public function __construct(
        private DonorLocationMatchingService $matchingService,
        private BloodRequestRepositoryInterface $bloodRequestRepo,
        private RequestPrioritizationService $prioritizationService
    ) {}

    public function execute(int $requestId): array
    {
        $request = $this->bloodRequestRepo->findById($requestId);

        if (!$request) {
            return [
                'tier' => 'none',
                'township_matches' => [],
                'region_matches'   => [],
                'all_matches'      => [],
                'competing_requests' => [],
            ];
        }

        $bloodGroup = (string)($request['blood_group_needed'] ?? '');
        $township = (string)($request['township'] ?? '');
        $stateRegion = (string)($request['state_region'] ?? '');

        $matching = $this->matchingService->findMatches(
            $bloodGroup,
            $township !== '' ? $township : null,
            $stateRegion !== '' ? $stateRegion : null
        );

        // Competing requests share the same donor pool (blood group + location).
        // They are sorted by business priority so the admin can see which
        // request should be fulfilled first.
        $competing = $this->bloodRequestRepo->findCompetingRequests(
            $bloodGroup,
            $stateRegion,
            $requestId
        );
        $competing = $this->prioritizationService->sortByPriority($competing);

        // Urgency-aware reservation:
        // if a HIGHER-priority competing request still needs a donor, the
        // shared donors are reserved for it. The admin must assign donors
        // starting from the highest-priority request (requirements #2, #5, #6).
        $reservingRequest = $this->findReservingRequest($request, $competing);
        if ($reservingRequest !== null) {
            $matching['township_matches'] = $this->markReserved($matching['township_matches'] ?? [], $reservingRequest);
            $matching['region_matches']   = $this->markReserved($matching['region_matches'] ?? [], $reservingRequest);
            $matching['all_matches']      = $this->markReserved($matching['all_matches'] ?? [], $reservingRequest);
        }

        return [
            'tier' => $matching['tier'] ?? 'none',
            'township_matches' => $matching['township_matches'] ?? [],
            'region_matches'   => $matching['region_matches'] ?? [],
            'all_matches'      => $matching['all_matches'] ?? [],
            'competing_requests' => $competing,
        ];
    }

    /**
     * Returns the highest-priority competing request that strictly outranks the
     * current request AND still needs a donor (none assigned yet).
     * Such a request "reserves" the shared donor pool.
     */
    private function findReservingRequest(array $request, array $competing): ?array
    {
        $currentRank = $this->prioritizationService->rank((string)($request['urgency'] ?? ''));

        foreach ($competing as $cr) {
            $isHigherPriority = $this->prioritizationService->rank((string)($cr['urgency'] ?? '')) < $currentRank;
            $stillNeedsDonor = empty($cr['donor_id']);

            if ($isHigherPriority && $stillNeedsDonor) {
                return $cr;
            }
        }

        return null;
    }

    private function markReserved(array $donors, array $reservingRequest): array
    {
        $label = $reservingRequest['request_code'] ?? '#' . $reservingRequest['request_id'];
        $urgency = strtoupper((string)($reservingRequest['urgency'] ?? 'ROUTINE'));

        foreach ($donors as &$donor) {
            $donor['reserved_for'] = [
                'request_id'  => (int)$reservingRequest['request_id'],
                'request_code' => $label,
                'urgency'     => $urgency,
            ];
        }
        unset($donor);

        return $donors;
    }
}
