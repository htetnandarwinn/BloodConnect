<?php

namespace App\Admin\Presentation\Controller;

use App\Shared\Helpers\Session;
use App\User\Infrastructure\Persistence\UserRepository;
use App\BloodRequest\Infrastructure\Persistence\BloodRequestRepository;
use App\Notification\Infrastructure\Persistence\NotificationRepository;
use App\Shared\Helpers\PermissionGuard;
use App\Shared\Infrastructure\Persistence\RoleRepository;
use App\Shared\Infrastructure\Persistence\MasterDataRepository;



class AdminController
{
    /**
     * AUTH GUARD (SAFE + CLEAN)
     */

    private function authGuard(): void
    {
        Session::start();

        if (!Session::has('user_id')) {
            header("Location: /BloodConnect/public/login");
            exit;
        }

        if ((int)Session::get('user_type_id') !== 1) {
            http_response_code(403);
            exit('Access denied.');
        }
    }
    /**
     * ADMIN DASHBOARD
     */
    public function admin_dashboard(): void
    {
        $this->authGuard();
        PermissionGuard::check('dashboard.view');

        $userRepo = new UserRepository();
        $requestRepo = new BloodRequestRepository();

        $users = method_exists($userRepo, 'findAll') ? $userRepo->findAll() : [];
        $requests = method_exists($requestRepo, 'findAll') ? $requestRepo->findAll() : [];

        $totalDonors = 0;
        $totalPatients = 0;

        foreach ($users as $user) {
            $type = (int)($user['user_type_id'] ?? 0);

            if ($type === 2) $totalDonors++;
            elseif ($type === 3) $totalPatients++;
        }

        $pendingRequests = 0;
        $completedRequests = 0;

        foreach ($requests as $request) {
            $status = strtolower(trim($request['status'] ?? ''));

            if ($status === 'pending') $pendingRequests++;
            elseif ($status === 'completed') $completedRequests++;
        }

        $data = [
            'totalUsers'        => count($users),
            'totalDonors'       => $totalDonors,
            'totalPatients'     => $totalPatients,
            'totalRequests'     => count($requests),
            'pendingRequests'   => $pendingRequests,
            'completedRequests' => $completedRequests,
            'adminName'         => $_SESSION['user']['username'] ?? 'Admin'
        ];

        ob_start();
        require __DIR__ . '/../View/admin_dashboard.php';
        $content = ob_get_clean();

        require __DIR__ . '/../Layout/adminApp.php';
    }

    /**
     * ADMIN PROFILE
     */
    public function profile(): void
    {
        $this->authGuard();
        PermissionGuard::check('profile.view');

        Session::start();

        $user = [
            'username' => $_SESSION['user']['username'] ?? 'Admin',
            'role'     => 'Administrator'
        ];

        ob_start();
        require __DIR__ . '/../View/admin_profile.php';
        $content = ob_get_clean();

        require __DIR__ . '/../Layout/adminApp.php';
    }

    /**
     * USER MANAGEMENT
     */
    public function userManagement(): void
    {
        $this->authGuard();
        PermissionGuard::check('user.view');

        $users = (new UserRepository())->findAll();

        ob_start();
        require __DIR__ . '/../View/user_management.php';
        $content = ob_get_clean();

        require __DIR__ . '/../Layout/adminApp.php';
    }

    public function donorManagement(): void
    {
        $this->authGuard();
        PermissionGuard::check('donor.view');

        ob_start();
        require __DIR__ . '/../View/donor_management.php';
        $content = ob_get_clean();

        require __DIR__ . '/../Layout/adminApp.php';
    }

    public function viewUser(): void
    {
        $this->authGuard();
        PermissionGuard::check('user.view');

        ob_start();
        require __DIR__ . '/../View/view_user.php';
        $content = ob_get_clean();

        require __DIR__ . '/../Layout/adminApp.php';
    }

    public function bloodRequests(): void
    {
        $this->authGuard();
        PermissionGuard::check('blood_request.view_matching');

        ob_start();
        require __DIR__ . '/../View/blood_requests.php';
        $content = ob_get_clean();

        require __DIR__ . '/../Layout/adminApp.php';
    }

    public function viewBloodRequest(): void
    {
        $this->authGuard();
        PermissionGuard::check('blood_request.view_matching');

        $requestId = (int)($_GET['id'] ?? 0);

        if (!$requestId) {
            header('Location: /BloodConnect/public/admin/blood-requests');
            exit;
        }

        $repo = new BloodRequestRepository();
        $request = $repo->findById($requestId);

        if (!$request) {
            header('Location: /BloodConnect/public/admin/blood-requests');
            exit;
        }

        $acceptedStatus = (new MasterDataRepository())->getId('REQUEST_STATUS', 'ACCEPTED') ?? 8;
        $isAccepted = ((int)($request['status'] ?? 0) === (int)$acceptedStatus)
            || (strtolower((string)($request['status_name'] ?? '')) === 'accepted');

        $donors = $repo->getMatchingDonors((string)($request['blood_group_needed'] ?? ''));
        $acceptedDonor = null;

        if ($isAccepted && !empty($request['donor_id'])) {
            $acceptedDonor = (new UserRepository())->findById((int)$request['donor_id']);
        }

        ob_start();
        require __DIR__ . '/../View/blood_request_detail.php';
        $content = ob_get_clean();

        require __DIR__ . '/../Layout/adminApp.php';
    }

    public function acceptBloodRequest(): void
    {
        $this->authGuard();
        PermissionGuard::check('blood_request.view_matching');

        $requestId = (int)($_POST['request_id'] ?? 0);
        $donorId = (int)($_POST['donor_id'] ?? 0);

        if (!$requestId || !$donorId) {
            header('Location: /BloodConnect/public/admin/blood-requests');
            exit;
        }

        $repo = new BloodRequestRepository();
        $request = $repo->findById($requestId);

        if (!$request) {
            header('Location: /BloodConnect/public/admin/blood-requests');
            exit;
        }

        $acceptedStatus = (new MasterDataRepository())->getId('REQUEST_STATUS', 'ACCEPTED') ?? 8;

        $updated = $repo->acceptByAdmin($requestId, $donorId, $acceptedStatus);

        if (!$updated) {
            header('Location: /BloodConnect/public/admin/blood-requests');
            exit;
        }

        $notificationRepo = new NotificationRepository();
        $donorRepo = new UserRepository();
        $donor = $donorRepo->findById($donorId);
        $patient = $donorRepo->findById((int)($request['patient_id'] ?? 0));

        if ($donor) {
            $notificationRepo->create(
                (int)$donor['user_id'],
                'Blood Request Assigned',
                sprintf(
                    'You have been selected for blood request %s. Please contact the hospital or patient coordinator.',
                    $request['request_code'] ?? 'N/A'
                ),
                'REQUEST'
            );
        }

        if ($patient) {
            $notificationRepo->create(
                (int)$patient['user_id'],
                'Blood Request Matched',
                sprintf(
                    'A donor has been assigned for your blood request %s.',
                    $request['request_code'] ?? 'N/A'
                ),
                'REQUEST'
            );
        }

        header('Location: /BloodConnect/public/admin/blood-requests?success=1');
        exit;
    }

    public function notifications(): void
    {
        $this->authGuard();
        PermissionGuard::check('notification.view');

        Session::start();
        $userId = $_SESSION['user_id'] ?? null;

        $notifications = [];
        $unreadCount = 0;

        if ($userId) {
            $repo = new NotificationRepository();
            $notifications = $repo->findByUserId((int) $userId);
            $unreadCount = $repo->getUnreadCount((int) $userId);
        }

        ob_start();
        require __DIR__ . '/../View/notification.php';
        $content = ob_get_clean();

        require __DIR__ . '/../Layout/adminApp.php';
    }

    public function deleteUser(): void
    {
        $this->authGuard();
        PermissionGuard::check('user.delete');

        $id = $_GET['id'] ?? null;

        if ($id) {
            $db = \App\Shared\Infrastructure\Database\Database::getConnection();

            $stmt = $db->prepare("DELETE FROM users WHERE user_id = ?");
            $stmt->execute([$id]);
        }

        header("Location: /BloodConnect/public/admin/user-management");
        exit;
    }

    public function editUser(): void
    {
        $this->authGuard();
        PermissionGuard::check('user.view');

        $id = $_GET['id'] ?? null;

        if (!$id) {
            header("Location: /BloodConnect/public/admin/user-management");
            exit;
        }

        $db = \App\Shared\Infrastructure\Database\Database::getConnection();

        $stmt = $db->prepare("
        SELECT user_id, username, email, user_type_id, is_active
        FROM users
        WHERE user_id = ?
    ");

        $stmt->execute([$id]);
        $user = $stmt->fetch();

        if (!$user) {
            header("Location: /BloodConnect/public/admin/user-management");
            exit;
        }

        ob_start();
        require __DIR__ . '/../View/edit_user.php';
        $content = ob_get_clean();

        require __DIR__ . '/../Layout/adminApp.php';
    }

    public function updateUser(): void
    {
        $this->authGuard();
        PermissionGuard::check('user.update');

        $id = $_POST['user_id'] ?? null;
        $username = $_POST['username'] ?? '';
        $email = $_POST['email'] ?? '';
        $role = $_POST['user_type_id'] ?? 3;
        $status = $_POST['is_active'] ?? 1;

        if (!$id) {
            header("Location: /BloodConnect/public/admin/user-management");
            exit;
        }

        $db = \App\Shared\Infrastructure\Database\Database::getConnection();

        $stmt = $db->prepare("
        UPDATE users
        SET username = ?, email = ?, user_type_id = ?, is_active = ?
        WHERE user_id = ?
    ");

        $stmt->execute([$username, $email, $role, $status, $id]);

        header("Location: /BloodConnect/public/admin/user-management");
        exit;
    }

    public function completeRequest()
    {
        $this->authGuard();
        PermissionGuard::check('blood_request.view_matching');

        $requestId = (int)($_GET['id'] ?? 0);

        if (!$requestId) {
            header("Location: /BloodConnect/public/admin/blood-requests");
            exit;
        }

        $repo = new \App\BloodRequest\Infrastructure\Persistence\BloodRequestRepository();

        $request = $repo->findById($requestId);

        if (!$request) {
            die("Request not found.");
        }

        $masterRepo = new \App\Shared\Infrastructure\Persistence\MasterDataRepository();

        $completedStatus = $masterRepo->getId(
            'REQUEST_STATUS',
            'COMPLETED'
        );

        $db = \App\Shared\Infrastructure\Database\Database::getConnection();
        $stmt = $db->prepare(
            "UPDATE blood_requests SET status = ? WHERE request_id = ?"
        );
        $stmt->execute([$completedStatus, $requestId]);

        $notificationRepo = new \App\Notification\Infrastructure\Persistence\NotificationRepository();

        foreach ((new \App\User\Infrastructure\Persistence\UserRepository())->getAdmins() as $admin) {

            $notificationRepo->create(
                $admin['user_id'],
                'Blood Request Completed',
                sprintf(
                    'Blood request %s has been completed and the record has been updated.',
                    $request['request_code']
                ),
                'REQUEST'
            );
        }

        header("Location: /BloodConnect/public/admin/blood-requests");
        exit;
    }

    public function roles(): void
    {
        $this->authGuard();

        PermissionGuard::check('user_type.manage');


        $repo = new \App\Shared\Infrastructure\Persistence\RoleRepository();


        $roles = $repo->getAllRoles();


        ob_start();

        require __DIR__ . '/../View/roles.php';

        $content = ob_get_clean();


        require __DIR__ . '/../Layout/adminApp.php';
    }



    public function editRole(int $id): void
    {
        $this->authGuard();

        PermissionGuard::check('user_type.manage');


        $repo = new \App\Shared\Infrastructure\Persistence\RoleRepository();



        /*
    |--------------------------------------------------------------------------
    | Save Permissions
    |--------------------------------------------------------------------------
    */

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {


            $roleId = $_POST['role_id'] ?? null;


            $permissions = $_POST['permissions'] ?? [];



            if (!$roleId) {

                die("Role ID missing.");
            }



            $repo->updateRolePermissions(
                (int)$roleId,
                $permissions
            );



            header(
                "Location: /BloodConnect/public/admin/roles"
            );

            exit;
        }




        /*
    |--------------------------------------------------------------------------
    | Load Role
    |--------------------------------------------------------------------------
    */


        $role = $repo->findById($id);



        if (!$role) {

            http_response_code(404);

            exit('Role not found.');
        }




        /*
    |--------------------------------------------------------------------------
    | Load Permissions
    |--------------------------------------------------------------------------
    */


        $permissions = $repo->getAllPermissions();


        $rolePermissions = $repo->getRolePermissionIds($id);




        /*
    |--------------------------------------------------------------------------
    | Group Permissions
    |--------------------------------------------------------------------------
    */

        $groups = [];


        foreach ($permissions as $permission) {


            $key = explode('.', $permission['permission_key'])[0];


            $groups[$key][] = $permission;
        }




        ob_start();


        require __DIR__ . '/../View/edit_role.php';


        $content = ob_get_clean();



        require __DIR__ . '/../Layout/adminApp.php';
    }



    public function updateRolePermissions(): void
    {
        $this->authGuard();
        PermissionGuard::check('permission.manage');

        $id = $_POST['role_id'] ?? null;

        if (!$id) {
            die("Role ID missing.");
        }

        $permissionIds = $_POST['permissions'] ?? [];

        $repo = new \App\Shared\Infrastructure\Persistence\RoleRepository();

        $repo->updateRolePermissions(
            (int)$id,
            $permissionIds
        );

        header("Location: /BloodConnect/public/admin/roles");
        exit;
    }
}
