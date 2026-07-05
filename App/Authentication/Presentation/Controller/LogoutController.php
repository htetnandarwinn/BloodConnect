<?php

namespace App\Authentication\Presentation\Controller;

use App\Shared\Helpers\Session;

class LogoutController
{
    public function logout()
    {
        Session::start();

        $_SESSION = [];

        session_destroy();

        header("Location: /BloodConnect/public/");
        exit;
    }
}
