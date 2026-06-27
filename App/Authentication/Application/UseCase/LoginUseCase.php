<?php

namespace App\Authentication\Application\UseCase;

require_once __DIR__ . '/../../Infrastructure/Persistence/AuthRepository.php';

use App\Authentication\Infrastructure\Persistence\AuthRepository;

class LoginUseCase
{
    public function execute(array $credentials)
    {
        $repo = new AuthRepository();
        $login = $credentials['login'] ?? '';
        $password = $credentials['password'] ?? '';

        $user = $repo->findByEmail($login);
        if (!$user) return false;

        if (!isset($user['password'])) return false;

        if (password_verify($password, $user['password'])) {
            return $user;
        }

        return false;
    }
}
