<?php

require_once __DIR__ . '/../../../Shared/Helpers/Session.php';
require_once __DIR__ . '/../../../Shared/infrastructure/Database/Database.php';

use App\Shared\Helpers\Session;

Session::start();

$basePath = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME']));
if ($basePath === '/' || $basePath === '\\') {
    $basePath = '';
}

$userId = $_SESSION['user_id'] ?? null;
$userRole = $_SESSION['role'] ?? 'donor';

if (!$userId) {
    header('Location: ' . $basePath . '/login');
    exit;
}

if ($userRole !== 'donor') {
    if ($userRole === 'admin') {
        header('Location: ' . $basePath . '/admin/dashboard');
    } else {
        header('Location: ' . $basePath . '/user/dashboard');
    }
    exit;
}

$db = new \Database();
$pdo = $db->connect();

function setFlash(string $message, string $type = 'success')
{
    $_SESSION['flash_message'] = $message;
    $_SESSION['flash_type'] = $type;
}

function getFlash()
{
    $flash = null;

    if (isset($_SESSION['flash_message'])) {
        $flash = [
            'message' => $_SESSION['flash_message'],
            'type' => $_SESSION['flash_type'] ?? 'success',
        ];
        unset($_SESSION['flash_message'], $_SESSION['flash_type']);
    }

    return $flash;
}

function redirectToDashboard(): void
{
    global $basePath;
    header('Location: ' . $basePath . '/donor/dashboard');
    exit;
}

function fetchDonor(\PDO $pdo, int $userId): array
{
    $stmt = $pdo->prepare(
        'SELECT d.*, u.email AS user_email, u.name AS user_name
         FROM donors d
         LEFT JOIN users u ON u.user_id = d.user_id
         WHERE d.user_id = :user_id
         LIMIT 1'
    );
    $stmt->execute(['user_id' => $userId]);
    $donor = $stmt->fetch(\PDO::FETCH_ASSOC);

    return $donor ?: [];
}

function emailIsUnique(\PDO $pdo, string $email, int $userId): bool
{
    $stmt = $pdo->prepare('SELECT user_id FROM users WHERE email = :email AND user_id <> :user_id LIMIT 1');
    $stmt->execute(['email' => $email, 'user_id' => $userId]);
    return $stmt->fetch(\PDO::FETCH_ASSOC) === false;
}

function fetchNotifications(\PDO $pdo, int $userId): array
{
    $stmt = $pdo->prepare(
        'SELECT notification_id, title, message, is_read, created_at
         FROM notifications
         WHERE user_id = :user_id
         ORDER BY created_at DESC'
    );
    $stmt->execute(['user_id' => $userId]);

    return $stmt->fetchAll(\PDO::FETCH_ASSOC);
}

function fetchActiveBloodRequests(\PDO $pdo): array
{
    $stmt = $pdo->query(
        'SELECT
             request_id AS id,
             patient_name,
             hospital_name AS hospital,
             blood_group_needed AS blood_group,
             contact_phone AS units_needed,
             created_at AS request_date,
             urgency AS emergency_level
         FROM blood_requests
         WHERE status_id = (
             SELECT id
             FROM master_data
             WHERE category = "REQUEST_STATUS"
               AND code = "PENDING"
             LIMIT 1
         )
         ORDER BY created_at DESC'
    );

    return $stmt->fetchAll(\PDO::FETCH_ASSOC);
}

function fetchDonationHistory(\PDO $pdo, int $donorId): array
{
    $stmt = $pdo->prepare(
        'SELECT
             dh.donation_id AS id,
             md.code AS status,
             dh.donation_date,
             br.hospital_name AS hospital,
             br.blood_group_needed AS blood_group
         FROM donation_history dh
         LEFT JOIN blood_requests br ON br.request_id = dh.request_id
         LEFT JOIN master_data md ON md.id = dh.status_id AND md.category = "REQUEST_STATUS"
         WHERE dh.donor_id = :donor_id
         ORDER BY dh.created_at DESC'
    );
    $stmt->execute(['donor_id' => $donorId]);

    return $stmt->fetchAll(\PDO::FETCH_ASSOC);
}

function fetchLatestCompletedDonation(\PDO $pdo, int $donorId): array
{
    $stmt = $pdo->prepare(
        'SELECT
             dh.donation_date,
             br.hospital_name AS hospital
         FROM donation_history dh
         LEFT JOIN blood_requests br ON br.request_id = dh.request_id
         LEFT JOIN master_data md ON md.id = dh.status_id AND md.category = "REQUEST_STATUS"
         WHERE dh.donor_id = :donor_id AND md.code = "COMPLETED"
         ORDER BY dh.created_at DESC
         LIMIT 1'
    );
    $stmt->execute(['donor_id' => $donorId]);

    return $stmt->fetch(\PDO::FETCH_ASSOC) ?: [];
}

function uploadProfilePhoto(\PDO $pdo, int $userId): array
{
    if (!isset($_FILES['profile_photo']) || $_FILES['profile_photo']['error'] !== UPLOAD_ERR_OK) {
        return ['success' => false, 'message' => 'Select a valid image file.'];
    }

    $file = $_FILES['profile_photo'];
    $allowed = ['image/jpeg', 'image/png', 'image/webp'];

    if (!in_array($file['type'], $allowed, true)) {
        return ['success' => false, 'message' => 'Only JPG, PNG and WEBP images are allowed.'];
    }

    $uploadDir = dirname(__DIR__, 4) . '/public/uploads/profile/';
    if (!is_dir($uploadDir) && !mkdir($uploadDir, 0755, true) && !is_dir($uploadDir)) {
        return ['success' => false, 'message' => 'Unable to create upload folder.'];
    }

    $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
    $filename = 'donor_' . $userId . '_' . uniqid() . '.' . $extension;
    $target = $uploadDir . $filename;

    if (!move_uploaded_file($file['tmp_name'], $target)) {
        return ['success' => false, 'message' => 'Upload failed. Try again.'];
    }

    $relativePath = 'uploads/profile/' . $filename;
    $stmt = $pdo->prepare('UPDATE donors SET profile_photo = :photo WHERE user_id = :user_id');
    $stmt->execute(['photo' => $relativePath, 'user_id' => $userId]);

    return ['success' => true, 'message' => 'Profile photo uploaded successfully.'];
}

$flash = getFlash();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    if ($action === 'save_profile') {
        $fullName = trim($_POST['full_name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $phone = trim($_POST['phone'] ?? '');
        $gender = trim($_POST['gender'] ?? '');
        $address = trim($_POST['address'] ?? '');
        $bloodGroup = trim($_POST['blood_group'] ?? '');
        $errors = [];

        if ($fullName === '') {
            $errors[] = 'Full Name is required.';
        }
        if ($phone === '') {
            $errors[] = 'Phone Number is required.';
        } elseif (!preg_match('/^[0-9]+$/', $phone)) {
            $errors[] = 'Phone must contain only numbers.';
        }
        if ($gender === '') {
            $errors[] = 'Gender is required.';
        }
        if ($address === '') {
            $errors[] = 'Address is required.';
        }
        if ($bloodGroup === '') {
            $errors[] = 'Blood Group is required.';
        }
        if ($email !== '' && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Email is not valid.';
        }
        if ($email !== '' && !emailIsUnique($pdo, $email, $userId)) {
            $errors[] = 'Email is already in use.';
        }

        if (empty($errors)) {
            $stmt = $pdo->prepare(
                'UPDATE users SET name = :name, email = :email, phone = :phone WHERE user_id = :user_id'
            );
            $stmt->execute([
                'name' => $fullName,
                'email' => $email,
                'phone' => $phone,
                'user_id' => $userId,
            ]);

            $stmt = $pdo->prepare(
                'UPDATE donors SET name = :name, email = :email, phone = :phone, gender = :gender, address = :address, blood_group = :blood_group WHERE user_id = :user_id'
            );
            $stmt->execute([
                'name' => $fullName,
                'email' => $email,
                'phone' => $phone,
                'gender' => $gender,
                'address' => $address,
                'blood_group' => $bloodGroup,
                'user_id' => $userId,
            ]);

            $_SESSION['name'] = $fullName;
            setFlash('Profile updated successfully.', 'success');
            redirectToDashboard();
        }

        setFlash(implode(' ', $errors), 'error');
        redirectToDashboard();
    }

    if ($action === 'update_availability') {
        $availability = ($_POST['availability'] ?? '') === 'available' ? 1 : 0;
        $stmt = $pdo->prepare('UPDATE donors SET availability = :availability WHERE user_id = :user_id');
        $stmt->execute(['availability' => $availability, 'user_id' => $userId]);
        setFlash('Availability status updated successfully.', 'success');
        redirectToDashboard();
    }

    if ($action === 'donate_request') {
        $requestId = (int)($_POST['request_id'] ?? 0);

        if ($requestId > 0) {
            $stmt = $pdo->prepare(
                'INSERT INTO donation_responses (request_id, donor_id, status, created_at)
                 VALUES (:request_id, :donor_id, :status, :created_at)'
            );
            $stmt->execute([
                'request_id' => $requestId,
                'donor_id' => $userId,
                'status' => 'Pending',
                'created_at' => date('Y-m-d H:i:s'),
            ]);
            setFlash('Donation response saved. Admin will review the request.', 'success');
        } else {
            setFlash('Invalid blood request selected.', 'error');
        }

        redirectToDashboard();
    }

    if ($action === 'upload_photo') {
        $result = uploadProfilePhoto($pdo, $userId);
        setFlash($result['message'], $result['success'] ? 'success' : 'error');
        redirectToDashboard();
    }
}

$donor = fetchDonor($pdo, $userId);
if ($donor === []) {
    setFlash('Donor profile not found. Please log in again.', 'error');
    header('Location: ' . $basePath . '/login');
    exit;
}

$userName = $donor['name'] ?: ($_SESSION['name'] ?? 'Donor');
$userEmail = $donor['user_email'] ?? $donor['email'] ?? '';
$userPhone = $donor['phone'] ?? '';
$userGender = $donor['gender'] ?? '';
$userAddress = $donor['address'] ?? '';
$userBloodGroup = $donor['blood_group'] ?? 'N/A';
$availability = $donor['availability'] ? 'Available' : 'Not Available';
$availabilityStatus = $donor['availability'] ? 'available' : 'not_available';
$profilePhoto = $donor['profile_photo'] ?? '';
$profilePhotoUrl = $profilePhoto ? $basePath . '/' . ltrim($profilePhoto, '/') : null;
$notifications = fetchNotifications($pdo, $userId);
$unreadNotifications = array_filter($notifications, fn($item) => !isset($item['is_read']) || $item['is_read'] === '0' || $item['is_read'] === 0);
$unreadCount = count($unreadNotifications);
$activeRequests = fetchActiveBloodRequests($pdo);
$donationHistory = fetchDonationHistory($pdo, $userId);
$totalDonations = count(array_filter($donationHistory, fn($row) => strtolower($row['status']) === 'completed'));
$latestCompleted = fetchLatestCompletedDonation($pdo, $userId);
$lastDonationDate = $latestCompleted['donation_date'] ?? $donor['last_donation_date'] ?? 'Not recorded';
$lastDonationHospital = $latestCompleted['hospital'] ?? 'City Hospital';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BloodConnect — Donor Dashboard</title>
    <style>
        :root {
            --red: #C8202F;
            --red-dark: #A81926;
            --red-light: #FCE8E9;
            --pink-badge: #FDEDED;
            --blue: #2F6FE4;
            --blue-light: #EAF1FD;
            --green: #1AA251;
            --green-light: #E6F7EC;
            --orange-light: #FDEFE3;
            --orange: #E8821A;
            --ink: #16181D;
            --gray-900: #1F2329;
            --gray-600: #6B7280;
            --gray-400: #9CA3AF;
            --gray-200: #E7E9EC;
            --gray-100: #F3F4F6;
            --bg: #F4F5F7;
            --white: #FFFFFF;
            --radius: 14px;
            --radius-sm: 10px;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
        }

        * {
            box-sizing: border-box;
        }

        html,
        body {
            margin: 0;
            padding: 0;
            background: #f5f7fb;
        }

        body {
            min-height: 100vh;
        }

        .app-frame {
            width: 100%;
            min-height: 100vh;
            background: var(--bg);
            display: flex;
        }

        /* ---------------- SIDEBAR ---------------- */
        .sidebar {
            width: 250px;
            flex-shrink: 0;
            background: #fff;
            border-right: 1px solid #e5e7eb;
            display: flex;
            flex-direction: column;
            padding: 24px 18px;
            box-shadow: 2px 0 12px rgba(0, 0, 0, 0.04);
        }

        .brand {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            padding: 0 6px 22px 6px;
        }

        .brand-icon {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            background: var(--red);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            color: #fff;
        }

        .brand-icon svg {
            width: 18px;
            height: 18px;
        }

        .brand-text h1 {
            font-size: 15px;
            margin: 0;
            color: var(--gray-900);
            font-weight: 700;
        }

        .brand-text p {
            font-size: 11px;
            margin: 2px 0 0;
            color: var(--gray-400);
        }

        nav.nav-list {
            display: flex;
            flex-direction: column;
            gap: 4px;
            margin-top: 4px;
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 14px;
            border-radius: 12px;
            font-size: 14px;
            font-weight: 500;
            color: #667085;
            cursor: pointer;
            border: none;
            background: none;
            width: 100%;
            text-align: left;
            position: relative;
            transition: all .2s ease;
        }

        .nav-item svg {
            width: 17px;
            height: 17px;
            flex-shrink: 0;
        }

        .nav-item:hover {
            background: var(--gray-100);
        }

        .nav-item.active {
            background: linear-gradient(135deg, #dc2626, #c8202f);
            color: white;
            box-shadow: 0 8px 18px rgba(200, 32, 47, .25);
        }

        .nav-item .badge {
            margin-left: auto;
            background: var(--red);
            color: #fff;
            font-size: 10.5px;
            font-weight: 700;
            border-radius: 50%;
            min-width: 18px;
            height: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0 4px;
        }

        .nav-item.active .badge {
            background: #fff;
            color: var(--red);
        }

        .sidebar-spacer {
            flex: 1;
        }

        .logout-divider {
            border-top: 1px solid var(--gray-200);
            margin: 10px 0 12px;
        }

        .logout-btn {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 12px;
            border-radius: 9px;
            font-size: 13.5px;
            font-weight: 500;
            color: var(--gray-600);
            cursor: pointer;
            border: none;
            background: none;
            width: 100%;
            text-align: left;
        }

        .logout-btn:hover {
            background: var(--gray-100);
        }

        .logout-btn svg {
            width: 17px;
            height: 17px;
        }

        /* ---------------- MAIN ---------------- */
        .main {
            flex: 1;
            padding: 36px;
            overflow-y: auto;
        }

        .topbar {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 26px;
        }

        .topbar h2 {
            font-size: 32px;
            margin: 0;
            color: var(--gray-900);
            font-weight: 700;
        }

        .topbar p {
            font-size: 13px;
            margin: 4px 0 0;
            color: var(--gray-400);
        }

        .topbar-right {
            display: flex;
            align-items: center;
            gap: 18px;
        }

        .icon-btn {
            position: relative;
            width: 38px;
            height: 38px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            cursor: pointer;
            color: var(--gray-600);
            background: transparent;
            border: none;
        }

        .icon-btn:hover {
            background: var(--gray-100);
        }

        .icon-btn svg {
            width: 19px;
            height: 19px;
        }

        .icon-btn .dot {
            position: absolute;
            top: 4px;
            right: 6px;
            background: var(--red);
            color: #fff;
            font-size: 10px;
            font-weight: 700;
            border-radius: 50%;
            min-width: 16px;
            height: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 2px solid var(--white);
        }

        .user-chip {
            display: flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;
        }

        .avatar-sm {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            background: var(--gray-200);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--gray-400);
        }

        .avatar-sm svg {
            width: 18px;
            height: 18px;
        }

        .user-chip .meta p {
            margin: 0;
            font-size: 13.5px;
            font-weight: 700;
            color: var(--gray-900);
            line-height: 1.2;
        }

        .user-chip .meta span {
            font-size: 11.5px;
            color: var(--red);
            font-weight: 600;
        }

        .chevron {
            color: var(--gray-400);
            width: 14px;
            height: 14px;
        }

        /* page heading */
        .page-heading h3 {
            font-size: 19px;
            margin: 0 0 4px;
            color: var(--gray-900);
            font-weight: 700;
        }

        .page-heading p {
            font-size: 13px;
            margin: 0 0 22px;
            color: var(--gray-400);
        }

        /* stat cards */
        .stat-row {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 18px;
            margin-bottom: 24px;
        }

        .stat-card {
            background: #fff;
            border: 1px solid #edf0f4;
            border-radius: 18px;
            padding: 24px;
            display: flex;
            align-items: center;
            gap: 16px;
            transition: all .25s ease;
        }

        .stat-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 30px rgba(0, 0, 0, .06);
        }

        .stat-icon {
            width: 42px;
            height: 42px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .stat-icon svg {
            width: 20px;
            height: 20px;
        }

        .stat-icon.red {
            background: var(--red-light);
            color: var(--red);
        }

        .stat-icon.green {
            background: var(--green-light);
            color: var(--green);
        }

        .stat-icon.orange {
            background: var(--orange-light);
            color: var(--orange);
        }

        .stat-label {
            font-size: 12px;
            color: var(--gray-400);
            margin: 0 0 4px;
        }

        .stat-value {
            font-size: 19px;
            font-weight: 700;
            color: var(--gray-900);
            margin: 0;
        }

        .stat-value.green-text {
            color: var(--green);
        }

        .stat-sub {
            font-size: 11.5px;
            color: var(--gray-400);
            margin: 3px 0 0;
        }

        /* profile card */
        .profile-card {
            background: #fff;
            border: 1px solid #edf0f4;
            border-radius: 20px;
            padding: 30px;
            position: relative;
            box-shadow: 0 10px 30px rgba(0, 0, 0, .03);
        }

        .profile-card-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 18px;
        }

        .profile-card-header h4 {
            font-size: 16px;
            margin: 0 0 3px;
            color: var(--gray-900);
            font-weight: 700;
        }

        .profile-card-header p {
            font-size: 12.5px;
            margin: 0;
            color: var(--gray-400);
        }

        .btn {
            border: none;
            border-radius: 9px;
            font-size: 13px;
            font-weight: 600;
            padding: 10px 22px;
            cursor: pointer;
            transition: opacity .15s ease;
        }

        .btn:hover {
            opacity: .92;
        }

        .btn-red {
            background: linear-gradient(135deg, #dc2626, #c8202f);
            color: #fff;
            border-radius: 12px;
            padding: 12px 24px;
        }

        .btn-red-block {
            background: linear-gradient(135deg, #dc2626, #c8202f);
            color: white;
            width: 100%;
            padding: 14px;
            border-radius: 12px;
            font-size: 14px;
            font-weight: 600;
        }

        .divider {
            border-top: 1px solid var(--gray-200);
            margin: 0 0 24px;
        }

        .profile-id-row {
            display: flex;
            align-items: center;
            gap: 16px;
            margin-bottom: 26px;
            position: relative;
        }

        .avatar-lg {
            width: 62px;
            height: 62px;
            border-radius: 50%;
            background: var(--gray-100);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--gray-400);
            position: relative;
            flex-shrink: 0;
        }

        .avatar-lg svg {
            width: 30px;
            height: 30px;
        }

        .avatar-add {
            position: absolute;
            bottom: -2px;
            right: -2px;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            background: var(--red);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 2px solid var(--white);
            font-size: 12px;
            font-weight: 700;
        }

        .profile-id-name {
            font-size: 15px;
            font-weight: 700;
            color: var(--gray-900);
            margin: 0;
        }

        .profile-id-sub {
            font-size: 12.5px;
            color: var(--gray-400);
            margin: 3px 0 0;
        }

        .blood-type-pill {
            position: absolute;
            top: 26px;
            right: 28px;
            background: var(--pink-badge);
            border-radius: 10px;
            padding: 8px 18px;
            text-align: center;
        }

        .blood-type-pill .lbl {
            font-size: 9.5px;
            font-weight: 700;
            color: var(--red);
            letter-spacing: .06em;
            display: block;
            margin-bottom: 2px;
        }

        .blood-type-pill .val {
            font-size: 16px;
            font-weight: 800;
            color: var(--red);
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0 40px;
        }

        .field {
            margin-bottom: 18px;
        }

        .field-label-row {
            display: flex;
            justify-content: space-between;
            align-items: baseline;
            margin-bottom: 6px;
        }

        .field label {
            font-size: 12.5px;
            font-weight: 600;
            color: var(--gray-600);
        }

        .field label.editing {
            color: var(--blue);
        }

        .optional-tag {
            font-size: 9.5px;
            font-weight: 700;
            color: var(--gray-400);
            background: var(--gray-100);
            padding: 3px 8px;
            border-radius: 6px;
            letter-spacing: .04em;
        }

        .field input,
        .field select {
            width: 100%;
            border: 1px solid #dbe1ea;
            border-radius: 12px;
            padding: 13px 15px;
            font-size: 14px;
            color: var(--gray-900);
            background: white;
            outline: none;
            appearance: none;
            font-family: inherit;
            transition: all .2s ease;
        }

        .field input:focus,
        .field select:focus,
        .field input.editing,
        .field select.editing {
            border-color: #2563eb;
            box-shadow: 0 0 0 4px rgba(37, 99, 235, .12);
        }

        .field select.editing {
            color: var(--red);
            font-weight: 700;
        }

        .select-wrap {
            position: relative;
        }

        .select-wrap::after {
            content: "";
            position: absolute;
            right: 14px;
            top: 50%;
            width: 8px;
            height: 8px;
            border-right: 1.6px solid var(--gray-400);
            border-bottom: 1.6px solid var(--gray-400);
            transform: translateY(-65%) rotate(45deg);
            pointer-events: none;
        }

        @media (max-width: 880px) {
            .app-frame {
                flex-direction: column;
            }

            .sidebar {
                width: 100%;
                flex-direction: row;
                flex-wrap: wrap;
            }

            .stat-row {
                grid-template-columns: 1fr;
            }

            .form-grid {
                grid-template-columns: 1fr;
                gap: 0;
            }

            .blood-type-pill {
                position: absolute;
                top: 30px;
                right: 30px;
                background: #fef2f2;
                border-radius: 14px;
                padding: 14px 22px;
                text-align: center;
            }

            .main {
                padding: 20px;
            }
        }
    </style>
</head>

<body>

    <div class="app-frame">

        <!-- SIDEBAR -->
        <aside class="sidebar">
            <div class="brand">
                <div class="brand-icon">
                    <svg viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 2C9 6 5 10.5 5 14.5a7 7 0 0014 0C19 10.5 15 6 12 2z" />
                    </svg>
                </div>
                <div class="brand-text">
                    <h1>BloodConnect</h1>
                    <p>Donate Blood, Save Lives</p>
                </div>
            </div>

            <nav class="nav-list">
                <button class="nav-item active" data-tab="Dashboard">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="3" y="3" width="7" height="7" rx="1.5" />
                        <rect x="14" y="3" width="7" height="7" rx="1.5" />
                        <rect x="3" y="14" width="7" height="7" rx="1.5" />
                        <rect x="14" y="14" width="7" height="7" rx="1.5" />
                    </svg>
                    Dashboard
                </button>
                <a class="nav-item" href="/BloodConnect/App/Donor/Presentation/View/profile.php">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="8" r="3.5" />
                        <path d="M4.5 20c1.5-4 5-5.5 7.5-5.5s6 1.5 7.5 5.5" />
                    </svg>
                    My Profile
                </a>
                <button class="nav-item" data-tab="Availability Status">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="8.5" />
                        <path d="M12 7v5l3.5 2" />
                    </svg>
                    Availability Status
                </button>
                <button class="nav-item" data-tab="Blood Request">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M14 3H7a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V8l-5-5z" />
                        <path d="M14 3v5h5" />
                    </svg>
                    Blood Request
                    <span class="badge"><?= count($activeRequests) ?></span>
                </button>
                <button class="nav-item" data-tab="Donation History">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M4 6h16M4 12h16M4 18h10" />
                    </svg>
                    Donation History
                </button>
                <button class="nav-item" data-tab="Notifications">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M18 8a6 6 0 1 0-12 0c0 4-2 5-2 7h16c0-2-2-3-2-7" />
                        <path d="M10 21a2 2 0 0 0 4 0" />
                    </svg>
                    Notifications
                    <span class="badge"><?= $unreadCount ?></span>
                </button>
            </nav>

            <div class="sidebar-spacer"></div>

            <div class="logout-divider"></div>
            <button class="logout-btn" id="logoutBtn">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
                    <path d="M16 17l5-5-5-5" />
                    <path d="M21 12H9" />
                </svg>
                Logout
            </button>
        </aside>

        <!-- MAIN -->
        <main class="main">

            <div class="topbar">
                <div>
                    <h2>Welcome, <?= htmlspecialchars($userName, ENT_QUOTES, 'UTF-8') ?>! 👋</h2>
                    <p>Every drop you donate, makes a difference.</p>
                </div>
                <div class="topbar-right">
                    <button class="icon-btn" id="bellBtn" aria-label="Notifications">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M18 8a6 6 0 1 0-12 0c0 4-2 5-2 7h16c0-2-2-3-2-7" />
                            <path d="M10 21a2 2 0 0 0 4 0" />
                        </svg>
                        <span class="dot"><?= $unreadCount ?></span>
                    </button>
                    <a class="user-chip" id="userChip" href="<?= $basePath ?>/donor/profile">
                        <div class="avatar-sm">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <circle cx="12" cy="8" r="3.5" />
                                <path d="M4.5 20c1.5-4 5-5.5 7.5-5.5s6 1.5 7.5 5.5" />
                            </svg>
                        </div>
                        <div class="meta">
                            <p><?= htmlspecialchars($userName, ENT_QUOTES, 'UTF-8') ?></p>
                            <span><?= htmlspecialchars(ucfirst($userRole), ENT_QUOTES, 'UTF-8') ?></span>
                        </div>
                        <svg class="chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4">
                            <path d="M6 9l6 6 6-6" />
                        </svg>
                    </a>
                </div>
            </div>

            <div class="page-heading">
                <h3>Donor Dashboard</h3>
                <p>Manage your profile, availability and donation activities.</p>
            </div>

            <!-- STAT CARDS -->
            <div class="stat-row">
                <div class="stat-card">
                    <div class="stat-icon red">
                        <svg viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 2C9 6 5 10.5 5 14.5a7 7 0 0014 0C19 10.5 15 6 12 2z" />
                        </svg>
                    </div>
                    <div>
                        <p class="stat-label">Blood Group</p>
                        <p class="stat-value"><?= htmlspecialchars($userBloodGroup, ENT_QUOTES, 'UTF-8') ?></p>
                        <p class="stat-sub"><?= htmlspecialchars(stripos($userBloodGroup, '-') !== false ? 'Negative' : 'Positive', ENT_QUOTES, 'UTF-8') ?></p>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon green">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="12" cy="12" r="9" />
                            <path d="M8.5 12.5l2 2 5-5" />
                        </svg>
                    </div>
                    <div>
                        <p class="stat-label">Availability Status</p>
                        <p class="stat-value green-text"><?= htmlspecialchars($availability, ENT_QUOTES, 'UTF-8') ?></p>
                        <p class="stat-sub">You are ready to donate</p>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon orange">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="3" y="5" width="18" height="14" rx="2" />
                            <path d="M3 10h18" />
                        </svg>
                    </div>
                    <div>
                        <p class="stat-label">Last Donation</p>
                        <p class="stat-value"><?= htmlspecialchars($lastDonationDate, ENT_QUOTES, 'UTF-8') ?></p>
                        <p class="stat-sub"><?= htmlspecialchars($lastDonationHospital, ENT_QUOTES, 'UTF-8') ?></p>
                    </div>
                </div>
            </div>

            <!-- PROFILE CARD -->
            <form method="post" class="profile-card">
                <input type="hidden" name="action" value="save_profile">
                <div class="profile-card-header">
                    <div>
                        <h4>My Profile</h4>
                        <p>Donor Profile Management Module</p>
                    </div>
                    <button type="submit" class="btn btn-red" id="saveBtn">Save Changes</button>
                </div>

                <div class="divider"></div>

                <div class="profile-id-row">
                    <div class="avatar-lg">
                        <?php if ($profilePhotoUrl): ?>
                            <img src="<?= htmlspecialchars($profilePhotoUrl, ENT_QUOTES, 'UTF-8') ?>" alt="Profile photo" style="width:100%;height:100%;object-fit:cover;border-radius:50%;" />
                        <?php else: ?>
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
                                <circle cx="12" cy="8" r="3.5" />
                                <path d="M4.5 20c1.5-4 5-5.5 7.5-5.5s6 1.5 7.5 5.5" />
                            </svg>
                        <?php endif; ?>
                        <span class="avatar-add">+</span>
                    </div>
                    <div>
                        <p class="profile-id-name"><?= htmlspecialchars($userName, ENT_QUOTES, 'UTF-8') ?></p>
                        <p class="profile-id-sub">Active Donor &bull; <?= htmlspecialchars($userAddress ? strtok($userAddress, ',') : 'Donor Hub', ENT_QUOTES, 'UTF-8') ?></p>
                    </div>

                    <div class="blood-type-pill">
                        <span class="lbl">BLOOD TYPE</span>
                        <span class="val"><?= htmlspecialchars($userBloodGroup, ENT_QUOTES, 'UTF-8') ?></span>
                    </div>
                </div>

                <div class="form-grid">
                    <!-- LEFT COLUMN -->
                    <div>
                        <div class="field">
                            <div class="field-label-row">
                                <label for="fullName" class="editing">Full Name (Editing)</label>
                            </div>
                            <input type="text" name="full_name" class="editing" id="fullName" value="<?= htmlspecialchars($userName, ENT_QUOTES, 'UTF-8') ?>">
                        </div>

                        <div class="field">
                            <div class="field-label-row"><label for="gender">Gender</label></div>
                            <div class="select-wrap">
                                <select name="gender" id="gender">
                                    <option value="Female" <?= $userGender === 'Female' ? 'selected' : '' ?>>Female</option>
                                    <option value="Male" <?= $userGender === 'Male' ? 'selected' : '' ?>>Male</option>
                                    <option value="Other" <?= $userGender === 'Other' ? 'selected' : '' ?>>Other</option>
                                </select>
                            </div>
                        </div>

                        <div class="field">
                            <div class="field-label-row">
                                <label for="email">Contact Email</label>
                                <span class="optional-tag">OPTIONAL</span>
                            </div>
                            <input type="email" name="email" id="email" value="<?= htmlspecialchars($userEmail, ENT_QUOTES, 'UTF-8') ?>">
                        </div>

                        <button type="button" class="btn btn-red-block" id="editProfileBtn">Edit Profile</button>
                    </div>

                    <!-- RIGHT COLUMN -->
                    <div>
                        <div class="field">
                            <div class="field-label-row"><label for="phone">Phone Number</label></div>
                            <input type="tel" name="phone" id="phone" value="<?= htmlspecialchars($userPhone, ENT_QUOTES, 'UTF-8') ?>">
                        </div>

                        <div class="field">
                            <div class="field-label-row">
                                <label for="bloodGroup" class="editing">Blood Group Information (Editing)</label>
                            </div>
                            <div class="select-wrap">
                                <select name="blood_group" class="editing" id="bloodGroup">
                                    <option value="O+" <?= $userBloodGroup === 'O+' ? 'selected' : '' ?>>O+ (Positive)</option>
                                    <option value="O-" <?= $userBloodGroup === 'O-' ? 'selected' : '' ?>>O- (Negative)</option>
                                    <option value="A+" <?= $userBloodGroup === 'A+' ? 'selected' : '' ?>>A+ (Positive)</option>
                                    <option value="A-" <?= $userBloodGroup === 'A-' ? 'selected' : '' ?>>A- (Negative)</option>
                                    <option value="B+" <?= $userBloodGroup === 'B+' ? 'selected' : '' ?>>B+ (Positive)</option>
                                    <option value="B-" <?= $userBloodGroup === 'B-' ? 'selected' : '' ?>>B- (Negative)</option>
                                    <option value="AB+" <?= $userBloodGroup === 'AB+' ? 'selected' : '' ?>>AB+ (Positive)</option>
                                    <option value="AB-" <?= $userBloodGroup === 'AB-' ? 'selected' : '' ?>>AB- (Negative)</option>
                                </select>
                            </div>
                        </div>

                        <div class="field">
                            <div class="field-label-row"><label for="address">Address</label></div>
                            <input type="text" name="address" id="address" value="<?= htmlspecialchars($userAddress, ENT_QUOTES, 'UTF-8') ?>">
                        </div>
                    </div>
                </div>
            </form>

        </main>
    </div>

    <script>
        const basePath = '<?= $basePath ?>';

        // Sidebar nav switching
        document.querySelectorAll('.nav-item').forEach(btn => {
            btn.addEventListener('click', () => {
                document.querySelectorAll('.nav-item').forEach(b => b.classList.remove('active'));
                btn.classList.add('active');
            });
        });

        // Save Changes: lock the two "editing" fields back to normal state
        document.getElementById('saveBtn').addEventListener('click', () => {
            document.querySelectorAll('.editing').forEach(el => {
                el.classList.remove('editing');
            });
            const btn = document.getElementById('saveBtn');
            const original = btn.textContent;
            btn.textContent = 'Saved ✓';
            setTimeout(() => {
                btn.textContent = original;
            }, 1400);
        });

        // Edit Profile: re-enable editing state on Full Name + Blood Group
        document.getElementById('editProfileBtn').addEventListener('click', () => {
            document.querySelector('label[for="fullName"]');
            document.getElementById('fullName').classList.add('editing');
            document.getElementById('bloodGroup').classList.add('editing');
            document.querySelectorAll('.field-label-row label').forEach(l => {
                if (l.textContent.startsWith('Full Name') || l.textContent.startsWith('Blood Group Information')) {
                    l.classList.add('editing');
                }
            });
            document.getElementById('fullName').focus();
        });

        // Simple dropdown toggle for user chip / bell (placeholder interaction)
        document.getElementById('userChip').addEventListener('click', () => {
            alert('User menu — Profile / Settings / Logout');
        });
        document.getElementById('bellBtn').addEventListener('click', () => {
            alert('You have 3 new notifications');
        });
        document.getElementById('logoutBtn').addEventListener('click', () => {
            window.location.href = basePath + '/logout';
        });
    </script>

</body>

</html>