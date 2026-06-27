<?php

namespace App\Authentication\Application\UseCase;

use App\Shared\Helpers\Session;

class LogoutUseCase
{
    public function execute(): void
    {
        Session::start();

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
