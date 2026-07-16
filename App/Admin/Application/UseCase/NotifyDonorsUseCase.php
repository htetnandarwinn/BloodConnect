<?php

namespace App\Admin\Application\UseCase;

use App\BloodRequest\Domain\Repository\BloodRequestRepositoryInterface;
use App\Notification\Domain\Repository\NotificationRepositoryInterface;
use App\User\Domain\Repository\UserRepositoryInterface;
use App\Shared\Infrastructure\Mail\EmailService;

class NotifyDonorsUseCase
{
    public function __construct(
        private BloodRequestRepositoryInterface $bloodRequestRepo,
        private NotificationRepositoryInterface $notificationRepo,
        private UserRepositoryInterface $userRepo,
        private EmailService $emailService
    ) {}

    /**
     * Send an email alert + in-app notification to the selected donors for a
     * given blood request. Triggered manually by an admin from the request
     * detail page.
     */
    public function execute(int $requestId, array $donorIds): array
    {
        if (empty($donorIds)) {
            return ['success' => false, 'error' => 'No donors selected.'];
        }

        $request = $this->bloodRequestRepo->findById($requestId);

        if (!$request) {
            return ['success' => false, 'error' => 'Blood request not found.'];
        }

        $requestId = (int)($request['request_id'] ?? $requestId);
        $requestCode = (string)($request['request_code'] ?? 'N/A');
        $patientName = (string)($request['patient_name'] ?? 'A patient');
        $bloodGroup = (string)($request['blood_group_needed'] ?? '');
        $hospitalName = (string)($request['hospital_name'] ?? 'the hospital');
        $urgency = (string)($request['urgency'] ?? 'ROUTINE');

        $emailed = 0;
        $failed = [];

        foreach ($donorIds as $donorId) {
            $donor = $this->userRepo->findById((int)$donorId);

            if (!$donor) {
                continue;
            }

            $email = (string)($donor['email'] ?? '');

            if ($email !== '') {
                $sent = $this->emailService->sendBloodRequestAlert($email, [
                    'patient_name'       => $patientName,
                    'blood_group_needed' => $bloodGroup,
                    'hospital_name'      => $hospitalName,
                    'urgency'            => $urgency,
                    'request_code'       => $requestCode,
                ]);

                if ($sent) {
                    $emailed++;
                } else {
                    $failed[] = $donor['username'] ?? 'Donor #' . $donorId;
                }
            }

            $this->notificationRepo->create(
                (int)$donorId,
                'Blood Request Alert',
                sprintf(
                    'Patient %s has requested %s blood. Please review request %s.',
                    $patientName,
                    $bloodGroup,
                    $requestCode
                ),
                'REQUEST'
            );
        }

        if ($emailed === 0 && !empty($failed)) {
            return [
                'success' => false,
                'error' => 'Email failed to send to: ' . implode(', ', $failed) . '. Check mail configuration.',
            ];
        }

        $message = 'Email alert sent to ' . $emailed . ' donor' . ($emailed !== 1 ? 's' : '') . '.';
        if (!empty($failed)) {
            $message .= ' Failed for: ' . implode(', ', $failed) . '.';
        }

        return ['success' => true, 'message' => $message];
    }
}
