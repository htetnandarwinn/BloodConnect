<?php

namespace App\Admin\Application\UseCase;

use App\BloodRequest\Domain\Repository\BloodRequestRepositoryInterface;
use App\Donation\Domain\Repository\DonationRepositoryInterface;
use App\Notification\Domain\Repository\NotificationRepositoryInterface;
use App\User\Domain\Repository\UserRepositoryInterface;
use App\Shared\Infrastructure\Persistence\MasterDataRepository;

class ConfirmDonationUseCase
{
    public function __construct(
        private BloodRequestRepositoryInterface $bloodRequestRepo,
        private DonationRepositoryInterface $donationRepo,
        private NotificationRepositoryInterface $notificationRepo,
        private UserRepositoryInterface $userRepo,
        private MasterDataRepository $masterRepo
    ) {}

    /**
     * Complete a blood request and update related records.
     *
     * Business rules:
     * - Request must exist
     * - Request must have a donor assigned
     * - Donation record status is synced
     * - Admins are notified
     */
    public function complete(int $requestId): array
    {
        $request = $this->bloodRequestRepo->findById($requestId);

        if (!$request) {
            return ['success' => false, 'error' => 'Blood request not found.'];
        }

        $completedStatus = $this->masterRepo->getId('REQUEST_STATUS', 'COMPLETED');

        // Business rule: request must have a donor assigned
        $donorId = (int)($request['donor_id'] ?? 0);
        if ($donorId <= 0) {
            return ['success' => false, 'error' => 'Cannot complete a request with no donor assigned.'];
        }

        // Update blood request status
        $db = \App\Shared\Infrastructure\Database\Database::getConnection();
        $stmt = $db->prepare("UPDATE blood_requests SET status = ? WHERE request_id = ?");
        $stmt->execute([$completedStatus, $requestId]);

        // Sync donation record
        $this->donationRepo->updateStatusByRequestId($requestId, (int)$completedStatus);

        // Notify all admins
        $admins = $this->notificationRepo->getAdmins();
        foreach ($admins as $admin) {
            $this->notificationRepo->create(
                (int)$admin['user_id'],
                'Blood Request Completed',
                sprintf(
                    'Blood request %s has been completed and the record has been updated.',
                    $request['request_code']
                ),
                'REQUEST'
            );
        }

        return ['success' => true];
    }

    /**
     * Assign a donor to a blood request.
     *
     * Business rules:
     * - Request must exist
     * - Donor must exist
     * - Donor must be eligible (not already assigned to this request)
     * - Notifications are sent to donor, patient, and admins
     */
    public function assignDonor(int $requestId, int $donorId): array
    {
        $request = $this->bloodRequestRepo->findById($requestId);

        if (!$request) {
            return ['success' => false, 'error' => 'Blood request not found.'];
        }

        $donor = $this->userRepo->findById($donorId);
        if (!$donor) {
            return ['success' => false, 'error' => 'Donor not found.'];
        }

        // Business rule: donor must not already be assigned to this request
        if ((int)($request['donor_id'] ?? 0) === $donorId) {
            return ['success' => false, 'error' => 'This donor is already assigned to this request.'];
        }

        // Business rule: donor must not be assigned to another active request
        $assignedGroups = $this->bloodRequestRepo->getDonorsAssignedToOtherRequests([$donorId], $requestId);
        if (!empty($assignedGroups)) {
            $otherRequests = $assignedGroups[$donorId] ?? [];
            $parts = [];
            foreach ($otherRequests as $other) {
                $parts[] = ($other['request_code'] ?? '#' . $other['request_id']) . ' (' . strtoupper($other['urgency'] ?? 'ROUTINE') . ')';
            }
            return [
                'success' => false,
                'error' => sprintf(
                    'This donor is already assigned to: %s. Unassign from the less urgent request first, or pick a different donor.',
                    implode(', ', $parts)
                ),
            ];
        }

        $pendingStatus = $this->masterRepo->getId('REQUEST_STATUS', 'PENDING') ?? 7;

        $updated = $this->bloodRequestRepo->acceptByAdmin($requestId, $donorId, $pendingStatus);
        if (!$updated) {
            return ['success' => false, 'error' => 'Failed to assign donor.'];
        }

        // Notify admins
        $admins = $this->notificationRepo->getAdmins();
        foreach ($admins as $admin) {
            $this->notificationRepo->create(
                (int)$admin['user_id'],
                'Blood Request Assigned',
                sprintf(
                    'Blood request %s has been assigned to donor %s and is waiting for donor acceptance.',
                    $request['request_code'] ?? 'N/A',
                    $donor['username'] ?? 'Unknown donor'
                ),
                'REQUEST'
            );
        }

        // Notify donor
        $this->notificationRepo->create(
            (int)$donorId,
            'Blood Request Assigned',
            sprintf(
                'You have been assigned to blood request %s. Please review and accept it when ready.',
                $request['request_code'] ?? 'N/A'
            ),
            'REQUEST'
        );

        // Notify patient
        $patient = $this->userRepo->findById((int)($request['patient_id'] ?? 0));
        if ($patient) {
            $this->notificationRepo->create(
                (int)$patient['user_id'],
                'Blood Request Matched',
                sprintf(
                    'A donor has been assigned for your blood request %s and is pending acceptance.',
                    $request['request_code'] ?? 'N/A'
                ),
                'REQUEST'
            );
        }

        return ['success' => true];
    }
}
