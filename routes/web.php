<?php

use Routes\Router;

use App\Shared\Presentation\Controller\HomeController;
use App\Authentication\Presentation\Controller\AuthController;
use App\Authentication\Presentation\Controller\VerifyEmailController;
use App\User\Presentation\Controller\PatientController;
use App\BloodRequest\Presentation\Controller\BloodRequestController;
use App\Admin\Presentation\Controller\AdminController;

$router = new Router();

/*
|--------------------------------------------------------------------------
| HOME ROUTES
|--------------------------------------------------------------------------
*/
$router->get('/', [HomeController::class, 'home']);
$router->get('/about', [HomeController::class, 'about']);
$router->get('/contact', [HomeController::class, 'contact']);
$router->get('/search', [HomeController::class, 'search']);

/*
|--------------------------------------------------------------------------
| AUTH ROUTES
|--------------------------------------------------------------------------
*/
$router->get('/register', [AuthController::class, 'showRegister']);
$router->get('/login', [AuthController::class, 'showLogin']);
$router->post('/login', [AuthController::class, 'login']);

$router->post('/patient/register', [AuthController::class, 'registerPatient']);
$router->post('/donor/register', [AuthController::class, 'registerDonor']);

$router->get('/logout', [AuthController::class, 'logout']);

/*
|--------------------------------------------------------------------------
| BLOOD REQUEST ROUTES
|--------------------------------------------------------------------------
*/
$router->get('/patient/request-blood', [BloodRequestController::class, 'create']);
$router->post('/patient/request-blood', [BloodRequestController::class, 'store']);

$router->get('/patient/search-donors', [PatientController::class, 'searchDonors']);

/*
|--------------------------------------------------------------------------
| PATIENT ROUTES
|--------------------------------------------------------------------------
*/
$router->get('/patient/dashboard', [PatientController::class, 'patient_dashboard']);
$router->get('/patient/my-requests', [PatientController::class, 'myRequests']);


$router->get('/patient/profile', [PatientController::class, 'profile']);

$router->get('/patient/profile/update', [PatientController::class, 'updateProfilePage']);

$router->post('/patient/profile/update', [PatientController::class, 'updateProfile']);


/*
|--------------------------------------------------------
| PROFILE UPDATE (FIXED CLEAN DESIGN)
|--------------------------------------------------------
| NO updateProfilePage anymore (removed completely)
| profile = view page
| updateProfile = POST update only
*/
$router->post('/patient/profile/update', [PatientController::class, 'updateProfile']);

$router->get('/patient/notifications', [PatientController::class, 'notifications']);

$router->post('/notification/mark-read', [PatientController::class, 'markNotificationRead']);

$router->post('/notification/mark-all-read', [PatientController::class, 'markAllNotificationsRead']);

$router->get('/notification/unread-count', [PatientController::class, 'getUnreadCount']);

$router->get('/notification/unread-count', [PatientController::class, 'unreadCount']);


// =======================
// ADMIN ROUTES
// =======================

$router->get('/admin/dashboard', [AdminController::class, 'admin_dashboard']);

$router->get('/admin/profile', [AdminController::class, 'profile']);

$router->get('/verify-email', [VerifyEmailController::class, 'show']);
$router->post('/verify-email', [VerifyEmailController::class, 'verify']);
$router->post('/resend-code', [VerifyEmailController::class, 'resend']);

return $router;
