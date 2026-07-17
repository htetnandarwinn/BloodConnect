<?php

namespace App\Authentication\Application\UseCase;

use App\Authentication\Domain\Repository\AuthRepositoryInterface;
use App\Notification\Domain\Repository\NotificationRepositoryInterface;
use App\Shared\Infrastructure\Activity\ActivityLogger;

class LoginUseCase
{
    public function __construct(
        private AuthRepositoryInterface $repo,
        private ActivityLogger $activityLogger,
        private NotificationRepositoryInterface $notificationRepo
    ) {}

    public function execute(array $credentials): array
    {
        $errors = [];

        $login = trim($credentials['login'] ?? '');
        $password = $credentials['password'] ?? '';

        if ($login === '') {
            $errors['login'] = 'Email or Username is required.';
        }

        if ($password === '') {
            $errors['password'] = 'Password is required.';
        }

        if (!empty($errors)) {
            return [
                'success' => false,
                'errors' => $errors
            ];
        }

        $user = $this->repo->findByEmail($login);

        if (!$user) {
            $user = $this->repo->findByUsername($login);
        }

        if (!$user) {
            return [
                'success' => false,
                'errors' => [
                    'form' => 'Incorrect email or username.'
                ]
            ];
        }

        if (!password_verify($password, $user['password'])) {
            return [
                'success' => false,
                'errors' => [
                    'form' => 'Incorrect password.'
                ]
            ];
        }

        if ((int)$user['is_active'] !== 1) {
            return [
                'success' => false,
                'errors' => [
                    'form' => 'Your account is inactive.'
                ]
            ];
        }

        if ((int)$user['is_verified'] !== 1) {
            return [
                'success' => false,
                'errors' => [
                    'form' => 'Please verify your account.'
                ]
            ];
        }

        $this->activityLogger->log(
            (int)$user['user_id'],
            $user['username'] ?? null,
            'LOGIN',
            "User logged in"
        );

        $roleLabels = [1 => 'Admin', 2 => 'Donor', 3 => 'Patient'];
        $roleLabel = $roleLabels[(int)($user['user_type_id'] ?? 0)] ?? 'User';
        $admins = $this->notificationRepo->getAdmins();
        foreach ($admins as $admin) {
            $this->notificationRepo->create(
                (int)$admin['user_id'],
                $roleLabel . ' Logged In',
                sprintf(
                    '%s "%s" has logged in to the system.',
                    $roleLabel,
                    $user['username'] ?? 'Unknown'
                ),
                'USER_ACTION'
            );
        }

        return [
            'success' => true,
            'user' => $user
        ];
    }
}
