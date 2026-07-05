<?php

namespace App\Authentication\Application\UseCase;

use App\Authentication\Infrastructure\Persistence\AuthRepository;

class LoginUseCase
{
    private AuthRepository $repo;

    public function __construct()
    {
        $this->repo = new AuthRepository();
    }

    public function execute(array $credentials): array
    {
        $errors = [];

        $login = trim($credentials['login'] ?? '');
        $password = $credentials['password'] ?? '';

        // Validate login
        if ($login === '') {
            $errors['login'] = 'Email or Username is required.';
        }

        // Validate password
        if ($password === '') {
            $errors['password'] = 'Password is required.';
        }

        if (!empty($errors)) {
            return [
                'success' => false,
                'errors' => $errors
            ];
        }

        // Find by email first
        $user = $this->repo->findByEmail($login);

        // If not found, find by username
        if (!$user) {
            $user = $this->repo->findByUsername($login);
        }

        // User not found
        if (!$user) {
            return [
                'success' => false,
                'errors' => [
                    'form' => 'Incorrect email/username .'
                ]
            ];
        }

        // Verify password
        if (!password_verify($password, $user['password'])) {
            return [
                'success' => false,
                'errors' => [
                    'form' => 'Incorrect password.'
                ]
            ];
        }

        // Check account status
        if (isset($user['status']) && strtolower(trim($user['status'])) !== 'active') {
            return [
                'success' => false,
                'errors' => [
                    'form' => 'Your account is inactive.'
                ]
            ];
        }

        // Login successful
        return [
            'success' => true,
            'user' => $user
        ];
    }
}
