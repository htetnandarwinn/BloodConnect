<?php

namespace App\Shared\Middleware;

use App\Shared\Helpers\Session;

class AuthMiddleware
{
    public function handle()
    {
        Session::start();

        if (!Session::has('user_id')) {
            header('Location: /BloodConnect/public/login');
            exit;
        }
    }
}
