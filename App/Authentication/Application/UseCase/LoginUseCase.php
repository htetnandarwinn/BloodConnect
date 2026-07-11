<?php

namespace App\Authentication\Application\UseCase;

use App\Authentication\Domain\Repository\AuthRepositoryInterface;
use App\Shared\Infrastructure\Activity\ActivityLogger;

class LoginUseCase
{
    public function __construct(
        private AuthRepositoryInterface $repo,
        private ActivityLogger $activityLogger
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

        return [
            'success' => true,
            'user' => $user
        ];
    }
}
