<?php

namespace App\Authentication\Application\UseCase;

use App\Shared\Helpers\Session;
use App\Authentication\Domain\Repository\AuthRepositoryInterface;

class LogoutUseCase
{
    public function __construct(
        private AuthRepositoryInterface $authRepo
    ) {}

    public function execute(): void
    {
        Session::start();

        $userId = Session::get('user_id');
        if ($userId) {
            $this->authRepo->setLoginStatus((int)$userId, 0);
        }

        $_SESSION = [];

        if (ini_get('session.use_cookies')) {
            $params = session_get_cookie_params();
            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params['path'],
                $params['domain'],
                $params['secure'],
                $params['httponly']
            );
        }

        session_destroy();
    }
}
