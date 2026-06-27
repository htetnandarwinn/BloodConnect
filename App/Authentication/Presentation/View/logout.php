<?php

require_once __DIR__ . '/../../../Shared/Helpers/Session.php';

use App\Shared\Helpers\Session;

Session::start();

// Clear session data
$_SESSION = [];

// Destroy the session
session_destroy();

// Redirect to home page
header("Location: /BloodConnect/App/Shared/Presentation/View/home.php");
exit;
