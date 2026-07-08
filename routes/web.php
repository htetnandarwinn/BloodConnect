<?php

use Routes\Router;

use App\Shared\Presentation\Controller\HomeController;
use App\Authentication\Presentation\Controller\AuthController;
use App\Authentication\Presentation\Controller\VerifyEmailController;
use App\User\Presentation\Controller\PatientController;
use App\BloodRequest\Presentation\Controller\BloodRequestController;
use App\Admin\Presentation\Controller\AdminController;
use App\Donor\Presentation\Controller\DonorController;

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
$router->get('/forgot-password', [AuthController::class, 'showForgotPassword']);
$router->post('/forgot-password', [AuthController::class, 'sendPasswordResetOtp']);
$router->get('/forgot-password/verify', [AuthController::class, 'showForgotPasswordOtp']);
$router->post('/forgot-password/verify', [AuthController::class, 'verifyForgotPasswordOtp']);
$router->get('/forgot-password/reset', [AuthController::class, 'showResetPasswordForm']);
$router->post('/forgot-password/reset', [AuthController::class, 'resetPassword']);

$router->post('/patient/register', [AuthController::class, 'registerPatient']);
$router->post('/donor/register', [AuthController::class, 'registerDonor']);
$router->post('/donor/register', [AuthController::class, 'registerPatient']);

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
$router->get('/patient/my-request/view', [PatientController::class, 'viewMyRequest']);

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
$router->get('/admin/user-management', [AdminController::class, 'userManagement']);
$router->get('/admin/user/view', [AdminController::class, 'viewUser']);
$router->get('/admin/donor-management', [AdminController::class, 'donorManagement']);
$router->get('/admin/blood-requests', [AdminController::class, 'bloodRequests']);
$router->get('/admin/blood-request/view', [AdminController::class, 'viewBloodRequest']);
$router->post('/admin/blood-request/accept', [AdminController::class, 'acceptBloodRequest']);
$router->get('/admin/notifications', [AdminController::class, 'notifications']);

$router->get('/verify-email', [VerifyEmailController::class, 'show']);
$router->post('/verify-email', [VerifyEmailController::class, 'verify']);
$router->post('/resend-code', [VerifyEmailController::class, 'resend']);
$router->get('/admin/user/edit', [AdminController::class, 'editUser']);
$router->get('/admin/user/delete', [AdminController::class, 'deleteUser']);
$router->post('/admin/user/update', [AdminController::class, 'updateUser']);

$router->get('/admin/request/complete', [AdminController::class, 'completeRequest']);

// =======================
// DONOR ROUTES
// =======================

$router->get('/donor/dashboard', [DonorController::class, 'donor_dashboard']);
$router->get('/donor/profile', [DonorController::class, 'profile']);
$router->get('/donor/blood-requests', [DonorController::class, 'bloodRequests']);
$router->get('/donor/blood-request/{id}', [DonorController::class, 'bloodRequestDetails']);
$router->get('/donor/history', [DonorController::class, 'history']);
$router->get('/donor/history/view', [DonorController::class, 'viewHistory']);

$router->get('/donor/profile/update', [DonorController::class, 'updateProfilePage']);
$router->post('/donor/profile/update', [DonorController::class, 'updateProfile']);

$router->post('/donor/request/accept', [DonorController::class, 'acceptRequest']);


$router->post('/donor/request/decline', [DonorController::class, 'declineRequest']);


$router->get('/admin/roles', [AdminController::class, 'roles']);

$router->get('/admin/roles', [AdminController::class, 'roles']);

$router->get('/admin/roles/{id}', [AdminController::class, 'editRole']);

$router->post('/admin/roles/{id}', [AdminController::class, 'updateRolePermissions']);

$router->post('/admin/roles/update-permissions', [AdminController::class, 'updateRolePermissions']);

return $router;
