<?php
require_once __DIR__ . '/../../../Shared/Helpers/Session.php';
require_once __DIR__ . '/../../../Shared/Infrastructure/Database/Database.php';

use App\Shared\Helpers\Session;
use App\Shared\Infrastructure\Database\Database;

// If the Database class is defined in the global namespace (no namespace
// declaration in Database.php), create an alias so the namespaced reference
// used below still works and static analyzers won't report an undefined type.
if (!class_exists('App\\Shared\\Infrastructure\\Database\\Database') && class_exists('Database')) {
    class_alias('Database', 'App\\Shared\\Infrastructure\\Database\\Database');
}

Session::start();

if (!isset($_SESSION['user_id'])) {
    header("Location: /BloodConnect/login.php");
    exit;
}

$userId = $_SESSION['user_id'];

// Obtain a DB connection in a way compatible with different Database implementations
// Prefer method_exists over is_callable to avoid static analysis errors when
// the Database class is actually an alias to a global class without static
// method type hints.
if (method_exists(Database::class, 'getConnection')) {
    $db = Database::getConnection();
} elseif (method_exists(Database::class, 'getInstance')) {
    $instance = Database::getInstance();
    if (is_object($instance) && method_exists($instance, 'getConnection')) {
        $db = $instance->getConnection();
    } else {
        // fallback: assume instance is a PDO or has a connect method
        $db = is_object($instance) ? $instance : null;
    }
} else {
    // Try to construct and get connection from instance
    try {
        $dbInstance = new Database();
        if (method_exists($dbInstance, 'getConnection')) {
            $db = $dbInstance->getConnection();
        } elseif (method_exists($dbInstance, 'connect')) {
            $db = $dbInstance->connect();
        } else {
            $db = $dbInstance; // assume it's a PDO-like object
        }
    } catch (Throwable $e) {
        die('Database connection method not found.');
    }
}

if (!($db instanceof PDO)) {
    // If $db is not a PDO, but offers prepare, use it; otherwise error
    if (!is_object($db) || !method_exists($db, 'prepare')) {
        die('Invalid database connection.');
    }
}

$stmt = $db->prepare("
    SELECT
        name AS full_name,
        phone,
        email,
        blood_group,
        address
    FROM donors
    WHERE user_id = ?
");

$stmt->execute([$userId]);
$donor = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$donor) {
    die("Donor profile not found.");
}

$basePath = "/BloodConnect";

$userName = $donor['full_name'];
$userRole = $_SESSION['role'] ?? 'donor';
$activeRequests = [];
$unreadCount = 0;
$userAddress = $donor['address'] ?? '';
$userBloodGroup = $donor['blood_group'] ?? ($donor['blood_group'] ?? 'N/A');
$profilePhotoUrl = '';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>BloodConnect Profile</title>

    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

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

        /* keep profile card styles similar to previous design */
        .profile-card {
            background: #fff;
            border: 1px solid #edf0f4;
            border-radius: 20px;
            padding: 30px;
            position: relative;
            box-shadow: 0 10px 30px rgba(0, 0, 0, .03);
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

        /* Success message */
        .success-msg {
            display: flex;
            align-items: center;
            gap: 10px;
            background: #eaf8ef;
            color: #198754;
            border: 1px solid #c8ead6;
            padding: 14px 18px;
            border-radius: 12px;
            font-size: 15px;
            font-weight: 600;
            margin-bottom: 25px;
        }

        .success-msg i {
            font-size: 18px;
        }

        /* Profile header */
        .profile-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 35px;
            flex-wrap: wrap;
            gap: 20px;
        }

        .avatar {
            width: 90px;
            height: 90px;
            border-radius: 50%;
            background: #c8202f;
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 36px;
            box-shadow: 0 8px 20px rgba(200, 32, 47, .2);
        }

        .profile-info {
            flex: 1;
        }

        .profile-info h3 {
            margin: 0;
            font-size: 28px;
            color: #222;
        }

        .verified {
            margin-top: 8px;
            display: flex;
            align-items: center;
            gap: 8px;
            color: #16a34a;
            font-weight: 600;
        }

        .blood-badge {
            background: #fff5f5;
            border: 2px solid #f8d7da;
            padding: 18px 28px;
            border-radius: 15px;
            text-align: center;
            min-width: 140px;
        }

        .blood-badge small {
            display: block;
            color: #777;
            margin-bottom: 8px;
        }

        .blood-badge h2 {
            margin: 0;
            color: #c8202f;
            font-size: 34px;
        }

        /* Form */
        .form-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 25px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
        }

        .form-group label {
            font-size: 14px;
            color: #555;
            margin-bottom: 8px;
            font-weight: 600;
        }

        .form-group input {
            width: 100%;
            padding: 14px;
            border: 1px solid #d9d9d9;
            border-radius: 10px;
            background: #f8f9fa;
            font-size: 15px;
            color: #333;
        }

        .form-group input:disabled {
            background: #f8f9fa;
            color: #333;
            cursor: not-allowed;
        }

        /* Responsive */
        @media(max-width:768px) {

            .profile-header {
                flex-direction: column;
                text-align: center;
            }

            .form-grid {
                grid-template-columns: 1fr;
            }
        }

        .profile-title {
            font-size: 34px;
            font-weight: 700;
            margin-bottom: 30px;
            color: #222;
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
                <a class="nav-item" href="<?= $basePath ?>/App/Donor/Presentation/View/donor_dashboard.php">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="3" y="3" width="7" height="7" rx="1.5" />
                        <rect x="14" y="3" width="7" height="7" rx="1.5" />
                        <rect x="3" y="14" width="7" height="7" rx="1.5" />
                        <rect x="14" y="14" width="7" height="7" rx="1.5" />
                    </svg>
                    Dashboard
                </a>
                <a class="nav-item" href="<?= $basePath ?>/App/Donor/Presentation/View/donor_profile.php">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="8" r="3.5" />
                        <path d="M4.5 20c1.5-4 5-5.5 7.5-5.5s6 1.5 7.5 5.5" />
                    </svg>
                    My Profile
                </a>
                <a class="nav-item" href="#">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="8.5" />
                        <path d="M12 7v5l3.5 2" />
                    </svg>
                    Availability Status
                </a>
                <a class="nav-item" href="#">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M14 3H7a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V8l-5-5z" />
                        <path d="M14 3v5h5" />
                    </svg>
                    Blood Request
                    <span class="badge"><?= count($activeRequests) ?></span>
                </a>
                <a class="nav-item" href="#">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M4 6h16M4 12h16M4 18h10" />
                    </svg>
                    Donation History
                </a>
                <a class="nav-item" href="#">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M18 8a6 6 0 1 0-12 0c0 4-2 5-2 7h16c0-2-2-3-2-7" />
                        <path d="M10 21a2 2 0 0 0 4 0" />
                    </svg>
                    Notifications
                    <span class="badge"><?= $unreadCount ?></span>
                </a>
            </nav>

            <div class="sidebar-spacer"></div>

            <a class="logout-btn" href="/BloodConnect/App/Authentication/Presentation/View/logout.php">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
                    <path d="M16 17l5-5-5-5" />
                    <path d="M21 12H9" />
                </svg>
                Logout
            </a>
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
                    <a class="user-chip" id="userChip" href="/BloodConnect/App/Donor/Presentation/View/profile.php">
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
                <h3>Donor Profile</h3>
                <p>Manage your profile details below.</p>
            </div>

            <div class="profile-card">

                <div class="success-msg">
                    <i class="fas fa-check-circle"></i>
                    Your donor profile is up to date.
                </div>

                <h2 class="profile-title">My Profile</h2>

                <div class="profile-header">

                    <div class="avatar">
                        <i class="fas fa-user"></i>
                    </div>

                    <div class="profile-info">
                        <h3><?= htmlspecialchars($donor['full_name']) ?></h3>

                        <div class="verified">
                            <i class="fas fa-circle" style="font-size:8px;"></i>
                            Saved & Verified
                        </div>
                    </div>

                    <div class="blood-badge">
                        <small>Blood Type</small>
                        <h2><?= htmlspecialchars($donor['blood_group']) ?></h2>
                    </div>

                </div>

                <div class="form-grid">

                    <div class="form-group">
                        <label>Full Name</label>
                        <input disabled
                            value="<?= htmlspecialchars($donor['full_name']) ?>">
                    </div>

                    <div class="form-group">
                        <label>Phone Number</label>
                        <input disabled
                            value="<?= htmlspecialchars($donor['phone']) ?>">
                    </div>

                    <!-- <div class="form-group">
                        <label>Gender</label>
                        <input disabled
                            value="<?= htmlspecialchars($donor['gender']) ?>">
                    </div> -->

                    <div class="form-group">
                        <label>Blood Group</label>
                        <input disabled
                            value="<?= htmlspecialchars($donor['blood_group']) ?>">
                    </div>

                    <div class="form-group">
                        <label>Email</label>
                        <input disabled
                            value="<?= htmlspecialchars($donor['email']) ?>">
                    </div>

                    <div class="form-group">
                        <label>Address</label>
                        <input disabled
                            value="<?= htmlspecialchars($donor['address']) ?>">
                    </div>

                </div>

            </div>

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

        // Simple interactions
        const bell = document.getElementById('bellBtn');
        const userChip = document.getElementById('userChip');
        const logoutBtn = document.getElementById('logoutBtn');

        if (bell) bell.addEventListener('click', () => {
            alert('You have <?= $unreadCount ?> notifications');
        });
        if (userChip) userChip.addEventListener('click', (e) => {
            e.preventDefault();
            alert('User menu');
        });
        if (logoutBtn) logoutBtn.addEventListener('click', () => {
            window.location.href = basePath + '/logout';
        });


        document.getElementById('logoutBtn').addEventListener('click', function() {
            window.location.href = 'http://localhost/BloodConnect/App/Shared/Presentation/View/home.php';
        });
    </script>

</body>

</html>