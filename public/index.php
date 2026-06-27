<?php

session_start();

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Remove project folder automatically
$scriptDir = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME']));

if ($scriptDir !== '/' && $scriptDir !== '\\') {
    if (strpos($uri, $scriptDir) === 0) {
        $uri = substr($uri, strlen($scriptDir));
    }
}

// Remove index.php if present
$uri = preg_replace('#/index\.php#', '', $uri);

// Normalize URI
$uri = '/' . trim($uri, '/');

if ($uri === '/') {
    include __DIR__ . '/../App/Shared/Presentation/View/home.php';
    exit;
}

switch ($uri) {

    // ================= HOME =================
    case '/':
        include __DIR__ . '/../App/Shared/Presentation/View/home.php';
        break;

    // ================= LOGIN =================
    case '/login':
        include __DIR__ . '/../App/Authentication/Presentation/View/login.php';
        break;

    case '/auth/login':
        require_once __DIR__ . '/../App/Authentication/Presentation/Controller/AuthController.php';

        $controller =
            new \App\Authentication\Presentation\Controller\AuthController();

        $controller->login();
        break;

    // ================= PATIENT REGISTER =================
    case '/register':
        include __DIR__ . '/../App/Authentication/Presentation/View/register_patient.php';
        break;

    case '/auth/register-patient':
        require_once __DIR__ . '/../App/Authentication/Presentation/Controller/AuthController.php';

        $controller =
            new \App\Authentication\Presentation\Controller\AuthController();

        $controller->registerPatient();
        break;

    // ================= DONOR REGISTER =================
    case '/donor/register':
        include __DIR__ . '/../App/Authentication/Presentation/View/register_donor.php';
        break;

    case '/auth/register-donor':
        require_once __DIR__ . '/../App/Authentication/Presentation/Controller/AuthController.php';

        $controller =
            new \App\Authentication\Presentation\Controller\AuthController();

        $controller->registerDonor();
        break;

    case '/logout':
        require_once __DIR__ . '/../App/Authentication/Presentation/Controller/AuthController.php';

        $controller =
            new \App\Authentication\Presentation\Controller\AuthController();

        $controller->logout();
        break;

    // ================= SEARCH DONOR =================
    case '/search':
        include __DIR__ . '/../App/Donor/Presentation/View/donor_dashboard.php';
        break;

    // ================= BLOOD REQUESTS =================
    case '/requests':
        include __DIR__ . '/../App/BloodRequest/Presentation/View/request_list.php';
        break;

    // ================= DONORS =================
    case '/donors':
        include __DIR__ . '/../App/Admin/Presentation/View/donors.php';
        break;

    // ================= ABOUT =================
    case '/about':
        include __DIR__ . '/../App/Shared/Presentation/View/about.php';
        break;

    // ================= CONTACT =================
    case '/contact':
        include __DIR__ . '/../App/Shared/Presentation/View/contact.php';
        break;

    // ================= ADMIN =================
    case '/admin/dashboard':
        include __DIR__ . '/../App/Admin/Presentation/View/dashboard.php';
        break;

    // ================= DONOR DASHBOARD =================
    case '/donor/dashboard':
        include __DIR__ . '/../App/Donor/Presentation/View/donor_dashboard.php';
        break;

    // ================= DONOR PROFILE =================
    case '/donor/profile':
        include __DIR__ . '/../App/Donor/Presentation/View/profile.php';
        break;

    // ================= USER PROFILE =================
    case '/user/dashboard':
        include __DIR__ . '/../App/User/Presentation/View/profile.php';
        break;

    default:
        http_response_code(404);

        echo "
        <h1>404 - Page Not Found</h1>
        <p>The page you requested does not exist.</p>
        ";
}
