<?php

namespace App\Admin\Application\UseCase;

use App\BloodRequest\Domain\Repository\BloodRequestRepositoryInterface;
use App\BloodRequest\Domain\Service\RequestPrioritizationService;
use App\Donor\Domain\Repository\DonorRepositoryInterface;
use App\Donor\Domain\Service\DonorEligibilityService;
use App\Notification\Domain\Repository\NotificationRepositoryInterface;
use App\User\Domain\Repository\UserRepositoryInterface;
use App\Shared\Infrastructure\Persistence\MasterDataRepository;

class AssignDonorsUseCase
{
    public function __construct(
        private BloodRequestRepositoryInterface $bloodRequestRepo,
        private NotificationRepositoryInterface $notificationRepo,
        private UserRepositoryInterface $userRepo,
        private MasterDataRepository $masterRepo,
        private DonorRepositoryInterface $donorRepo,
        private RequestPrioritizationService $prioritizationService
    ) {}

    public function execute(int $requestId, array $donorIds): array
    {
        if (empty($donorIds)) {
            return ['success' => false, 'error' => 'No donors selected.'];
        }

        $request = $this->bloodRequestRepo->findById($requestId);

        if (!$request) {
            return ['success' => false, 'error' => 'Blood request not found.'];
        }

        $eligibilityService = new DonorEligibilityService();
        $validDonorIds = [];
        $skippedDonors = [];

        foreach ($donorIds as $donorId) {
            $donorDetails = $this->donorRepo->getDonorDetails((int)$donorId);
            if ($donorDetails) {
                $result = $eligibilityService->evaluate(
                    (string)($donorDetails['date_of_birth'] ?? ''),
                    (string)($donorDetails['weight'] ?? '')
                );
                if ($result['eligible']) {
                    $validDonorIds[] = (int)$donorId;
                } else {
                    $donor = $this->userRepo->findById((int)$donorId);
                    $skippedDonors[] = ($donor['username'] ?? 'Donor #' . $donorId) . ' (' . implode('; ', $result['reasons']) . ')';
                }
            }
        }

        if (empty($validDonorIds)) {
            return ['success' => false, 'error' => 'None of the selected donors meet eligibility requirements (minimum 50kg weight).'];
        }

        // Urgency-aware reservation (requirements #2, #5, #6):
        // a donor who could serve a HIGHER-priority competing request (same
        // blood group + location) may not be assigned to a lower-priority
        // request while that higher-priority request still needs a donor.
        $reservingRequest = $this->findReservingRequest($request);
        if ($reservingRequest !== null) {
            $label = $reservingRequest['request_code'] ?? '#' . $reservingRequest['request_id'];
            $urgency = strtoupper((string)($reservingRequest['urgency'] ?? 'ROUTINE'));
            foreach ($validDonorIds as $donorId) {
                $donor = $this->userRepo->findById((int)$donorId);
                $skippedDonors[] = sprintf(
                    '%s is reserved for the higher-priority request %s (%s). Assign donors to that request first.',
                    $donor['username'] ?? 'Donor #' . $donorId,
                    $label,
                    $urgency
                );
            }
            return [
                'success' => false,
                'error' => 'All selected donors are reserved for a higher-priority request. Assign donors to the highest-priority request first.',
            ];
        }

        $assignedGroups = $this->bloodRequestRepo->getDonorsAssignedToOtherRequests($validDonorIds, $requestId);
        $alreadyAssignedDonorIds = array_keys($assignedGroups);
        $finalDonorIds = array_diff($validDonorIds, $alreadyAssignedDonorIds);

        foreach ($assignedGroups as $donorId => $otherRequests) {
            $donor = $this->userRepo->findById((int)$donorId);
            $donorName = $donor['username'] ?? 'Donor #' . $donorId;

            $requestParts = [];
            foreach ($otherRequests as $other) {
                $reqCode = $other['request_code'] ?? '#' . $other['request_id'];
                $urgency = strtoupper($other['urgency'] ?? 'ROUTINE');
                $requestParts[] = "{$reqCode} ({$urgency})";
            }

            $skippedDonors[] = sprintf(
                '%s is already assigned to: %s — unassign from the less urgent request first, or pick a different donor.',
                $donorName,
                implode(', ', $requestParts)
            );
        }

        if (empty($finalDonorIds)) {
            return ['success' => false, 'error' => 'All selected donors are already assigned to other active requests. Review the urgency of each competing request and prioritize accordingly.'];
        }

        $pendingStatus = $this->masterRepo->getId('REQUEST_STATUS', 'PENDING') ?? 7;

        $assigned = $this->bloodRequestRepo->assignDonorsToRequest($requestId, array_values($finalDonorIds), $pendingStatus);

        if (!$assigned) {
            return ['success' => false, 'error' => 'Failed to assign donors.'];
        }

        $requestCode = (string)($request['request_code'] ?? 'N/A');
        $patientName = (string)($request['patient_name'] ?? 'A patient');
        $bloodGroup = (string)($request['blood_group_needed'] ?? '');

        foreach ($finalDonorIds as $donorId) {
            $donor = $this->userRepo->findById((int)$donorId);
            if ($donor) {
                $this->notificationRepo->create(
                    (int)$donorId,
                    'Blood Request Assigned',
                    sprintf(
                        'You have been assigned to blood request %s for patient %s (%s). Please review and respond.',
                        $requestCode,
                        $patientName,
                        $bloodGroup
                    ),
                    'REQUEST'
                );
            }
        }

        if (!empty($skippedDonors)) {
            $currentUserId = $_SESSION['user_id'] ?? 0;
            $this->notificationRepo->create(
                (int)$currentUserId,
                'Donors Skipped - Assignment Conflict',
                sprintf(
                    'The following donors could not be assigned to request %s due to weight/age requirements: %s',
                    $requestCode,
                    implode('; ', $skippedDonors)
                ),
                'WARNING'
            );
        }

        $patient = $this->userRepo->findById((int)($request['patient_id'] ?? 0));
        if ($patient) {
            $this->notificationRepo->create(
                (int)$patient['user_id'],
                'Donors Assigned',
                sprintf(
                    'Donors have been assigned to your blood request %s. They will review and respond shortly.',
                    $requestCode
                ),
                'REQUEST'
            );
        }

        $admins = $this->notificationRepo->getAdmins();
        foreach ($admins as $admin) {
            $adminId = (int)($admin['user_id'] ?? 0);
            $currentUserId = $_SESSION['user_id'] ?? 0;
            if ($adminId > 0 && $adminId !== $currentUserId) {
                $this->notificationRepo->create(
                    $adminId,
                    'Donors Assigned',
                    sprintf(
                        'Donors have been assigned to blood request %s.',
                        $requestCode
                    ),
                    'REQUEST'
                );
            }
        }

        return ['success' => true];
    }

    private function findReservingRequest(array $request): ?array
    {
        $bloodGroup = (string)($request['blood_group_needed'] ?? '');
        $township = (string)($request['township'] ?? '');
        $stateRegion = (string)($request['state_region'] ?? '');

        if ($bloodGroup === '' || ($township === '' && $stateRegion === '')) {
            return null;
        }

        $currentRank = $this->prioritizationService->rank((string)($request['urgency'] ?? ''));
        $requestId = (int)($request['request_id'] ?? 0);

        $competing = $this->bloodRequestRepo->findCompetingRequests(
            $bloodGroup,
            $township,
            $stateRegion,
            $requestId
        );

        foreach ($competing as $cr) {
            $isHigherPriority = $this->prioritizationService->rank((string)($cr['urgency'] ?? '')) < $currentRank;
            $stillNeedsDonor = empty($cr['donor_id']);

            if ($isHigherPriority && $stillNeedsDonor) {
                return $cr;
            }
        }

        return null;
    }
}
