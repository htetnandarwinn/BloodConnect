<?php

namespace App\BloodRequest\Application\UseCase;

use App\BloodRequest\Domain\Repository\BloodRequestRepositoryInterface;
use App\Notification\Domain\Repository\NotificationRepositoryInterface;
use App\User\Domain\Repository\UserRepositoryInterface;
use App\Shared\Infrastructure\Persistence\MasterDataRepository;
use App\Shared\Infrastructure\Activity\ActivityLogger;

class CreateBloodRequestUseCase
{
    public function __construct(
        private BloodRequestRepositoryInterface $bloodRequestRepo,
        private NotificationRepositoryInterface $notificationRepo,
        private UserRepositoryInterface $userRepo,
        private MasterDataRepository $masterRepo,
        private ActivityLogger $activityLogger
    ) {}

    public function execute(int $patientId, string $patientName, array $data): array
    {
        $patient = $this->userRepo->findById($patientId);
        if (!$patient) {
            return ['success' => false, 'error' => 'Your account could not be verified. Please log out and log in again.'];
        }

        if ($this->bloodRequestRepo->hasPendingRequest($patientId)) {
            $this->notificationRepo->create(
                $patientId,
                'Pending Request Exists',
                'You already have a pending blood request. Please wait until it is resolved before creating a new one.',
                'REQUEST'
            );
            return ['success' => false, 'error' => 'You already have a pending blood request.'];
        }

        $requestCode = 'REQ' . date('YmdHis');
        $pendingStatus = $this->masterRepo->getId('REQUEST_STATUS', 'PENDING');
        if (!$pendingStatus) {
            return ['success' => false, 'error' => 'Pending status not found in master data.'];
        }

        $requestData = [
            'request_code'      => $requestCode,
            'patient_id'        => $patientId,
            'patient_name'      => $patientName,
            'blood_group_needed'=> $data['blood_group_needed'],
            'hospital_name'     => $data['hospital_name'],
            'state_region'      => $data['state_region'] ?? null,
            'township'          => $data['township'] ?? null,
            'hospital_address'  => $data['hospital_address'] ?? null,
            'urgency'           => $data['urgency'],
            'contact_phone'     => $data['contact_phone'],
            'unit'              => (int)($data['unit'] ?? 1),
            'status'            => $pendingStatus,
        ];

        $saved = $this->bloodRequestRepo->create($requestData);
        if (!$saved) {
            return ['success' => false, 'error' => 'Failed to create blood request.'];
        }

        $this->activityLogger->log(
            $patientId,
            $patientName,
            'BLOOD_REQUEST_CREATED',
            "Blood request {$requestCode} created"
        );

        $this->notificationRepo->create(
            $patientId,
            'Blood Request Submitted',
            'Your blood request is now pending.',
            'REQUEST'
        );

        $matchingDonors = $this->bloodRequestRepo->getMatchingDonors($data['blood_group_needed']);
        foreach ($matchingDonors as $donor) {
            $this->notificationRepo->create(
                (int)$donor['user_id'],
                'New Blood Request',
                sprintf(
                    'Patient %s has requested %s blood. Please review the request.',
                    $patientName,
                    $data['blood_group_needed']
                ),
                'REQUEST'
            );
        }

        $admins = $this->userRepo->getAdmins();
        foreach ($admins as $admin) {
            $this->notificationRepo->create(
                (int)$admin['user_id'],
                'New Blood Request',
                sprintf(
                    'New blood request %s from %s (%s)',
                    $requestCode,
                    $patientName,
                    $data['blood_group_needed']
                ),
                'REQUEST'
            );
        }

        return ['success' => true, 'request_code' => $requestCode];
    }
}
