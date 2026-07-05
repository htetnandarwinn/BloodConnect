<?php

require_once __DIR__ . '/../../../../vendor/autoload.php';

\App\Shared\Helpers\Session::start();

// Clear session data
$_SESSION = [];

// Destroy the session
session_destroy();

// Redirect to home page
header("Location: /BloodConnect/App/Shared/Presentation/View/home.php");
exit;
