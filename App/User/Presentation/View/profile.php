<?php

require_once __DIR__ . '/../../../Shared/Helpers/Session.php';

use App\Shared\Helpers\Session;

Session::start();

$basePath = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME']));
if ($basePath === '/' || $basePath === '\\') {
    $basePath = '';
}

$userId = $_SESSION['user_id'] ?? null;
$userRole = $_SESSION['role'] ?? 'user';

if (!$userId) {
    header('Location: ' . $basePath . '/login');
    exit;
}

if ($userRole === 'admin') {
    header('Location: ' . $basePath . '/admin/dashboard');
    exit;
} elseif ($userRole === 'donor') {
    header('Location: ' . $basePath . '/donor/dashboard');
    exit;
}

$userName = $_SESSION['name'] ?? 'John Doe';
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>BloodConnect — User Dashboard</title>
    <style>
        :root {
            --red: #c8202f;
            --red-dark: #a81926;
            --red-light: #fce8e9;
            --pink-badge: #fdeded;
            --blue: #2f6fe4;
            --blue-light: #eaf1fd;
            --green: #1aa251;
            --green-light: #e6f7ec;
            --orange: #e8821a;
            --orange-light: #fdefe3;
            --yellow-badge-bg: #fbf0d6;
            --yellow-badge-text: #a77b1a;
            --green-badge-bg: #def3e3;
            --green-badge-text: #1aa251;
            --blue-badge-bg: #e3eafb;
            --blue-badge-text: #2f6fe4;
            --pink-status-bg: #fbe2e5;
            --pink-status-text: #c8202f;
            --gray-900: #1f2329;
            --gray-600: #6b7280;
            --gray-500: #8b92a0;
            --gray-400: #9ca3af;
            --gray-300: #c9cdd3;
            --gray-200: #e7e9ec;
            --gray-100: #f3f4f6;
            --bg: #f4f5f7;
            --white: #ffffff;
            --radius: 14px;
            font-family:
                -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica,
                Arial, sans-serif;
        }

        * {
            box-sizing: border-box;
        }

        html,
        body {
            margin: 0;
            padding: 0;
            width: 100%;
            height: 100%;
            background: var(--bg);
        }

        body {
            min-height: 100vh;
        }

        .app-frame {
            width: 100%;
            min-height: 100vh;
            background: var(--bg);
            display: flex;
            overflow: hidden;
        }

        /* ---------------- SIDEBAR ---------------- */
        .sidebar {
            width: 260px;
            flex-shrink: 0;
            background: var(--white);
            border-right: 1px solid var(--gray-200);
            display: flex;
            flex-direction: column;
            padding: 22px 16px;
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
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            color: var(--red);
        }

        .brand-icon svg {
            width: 26px;
            height: 26px;
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
            position: relative;
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
            background: var(--red);
            color: #fff;
            font-weight: 600;
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
            padding: 30px 40px;
            overflow-y: auto;
            width: 100%;
        }

        .topbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .topbar h2 {
            font-size: 15px;
            margin: 0;
            color: var(--gray-900);
            font-weight: 500;
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
            top: 2px;
            right: 4px;
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
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: var(--gray-200);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--gray-400);
        }

        .avatar-sm svg {
            width: 17px;
            height: 17px;
        }

        .user-chip span.name {
            font-size: 13.5px;
            font-weight: 600;
            color: var(--gray-900);
        }

        .chevron {
            color: var(--gray-400);
            width: 14px;
            height: 14px;
        }

        /* page heading */
        .page-heading-row {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 24px;
        }

        .page-heading h3 {
            font-size: 23px;
            margin: 0 0 4px;
            color: var(--gray-900);
            font-weight: 700;
        }

        .page-heading p {
            font-size: 13px;
            margin: 0;
            color: var(--gray-400);
        }

        .btn-new-request {
            display: flex;
            align-items: center;
            gap: 7px;
            background: var(--red);
            color: #fff;
            border: none;
            border-radius: 9px;
            font-size: 13.5px;
            font-weight: 600;
            padding: 12px 20px;
            cursor: pointer;
            transition: opacity 0.15s ease;
            white-space: nowrap;
        }

        .btn-new-request:hover {
            opacity: 0.92;
        }

        .btn-new-request svg {
            width: 14px;
            height: 14px;
        }

        /* stat cards */
        .stat-row {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 18px;
            margin-bottom: 24px;
        }

        .stat-card {
            background: var(--white);
            border: 1px solid var(--gray-200);
            border-radius: var(--radius);
            padding: 20px 18px;
            display: flex;
            align-items: flex-start;
            gap: 14px;
        }

        .stat-icon {
            width: 46px;
            height: 46px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .stat-icon svg {
            width: 21px;
            height: 21px;
        }

        .stat-icon.red {
            background: var(--red-light);
            color: var(--red);
        }

        .stat-icon.orange {
            background: var(--orange-light);
            color: var(--orange);
        }

        .stat-icon.green {
            background: var(--green-light);
            color: var(--green);
        }

        .stat-icon.blue {
            background: var(--blue-light);
            color: var(--blue);
        }

        .stat-number {
            font-size: 21px;
            font-weight: 700;
            margin: 0 0 2px;
            line-height: 1;
        }

        .stat-number.red-text {
            color: var(--red);
        }

        .stat-number.orange-text {
            color: var(--orange);
        }

        .stat-number.green-text {
            color: var(--green);
        }

        .stat-number.blue-text {
            color: var(--blue);
        }

        .stat-name {
            font-size: 13px;
            font-weight: 700;
            color: var(--gray-900);
            margin: 0;
        }

        /* requests card */
        .requests-card {
            background: var(--white);
            border: 1px solid var(--gray-200);
            border-radius: var(--radius);
            padding: 26px 28px 14px;

            .requests-card {
                width: 100%;
            }

            table {
                width: 100%;
            }
        }

        .requests-card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 18px;
        }

        .requests-card-header h4 {
            font-size: 17px;
            margin: 0;
            color: var(--gray-900);
            font-weight: 700;
        }

        .view-all-link {
            font-size: 13px;
            font-weight: 700;
            color: var(--red);
            text-decoration: none;
            cursor: pointer;
        }

        .view-all-link:hover {
            text-decoration: underline;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead tr {
            border-top: 1px solid var(--gray-200);
            border-bottom: 1px solid var(--gray-200);
            background: #fafbfc;
        }

        thead th {
            text-align: left;
            font-size: 11px;
            letter-spacing: 0.04em;
            font-weight: 700;
            color: var(--gray-500);
            padding: 13px 10px;
            text-transform: uppercase;
        }

        thead th:first-child {
            padding-left: 6px;
        }

        tbody td {
            padding: 18px 10px;
            font-size: 13.5px;
            color: var(--gray-900);
            border-bottom: 1px solid var(--gray-100);
        }

        tbody td:first-child {
            padding-left: 6px;
            font-weight: 600;
        }

        tbody tr:last-child td {
            border-bottom: none;
        }

        tbody td.date-col {
            color: var(--gray-400);
        }

        .blood-pill {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: var(--pink-badge);
            color: var(--red);
            font-size: 11px;
            font-weight: 700;
            border-radius: 8px;
            padding: 5px 9px;
            min-width: 30px;
        }

        .status-pill {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 10.5px;
            font-weight: 700;
            letter-spacing: 0.03em;
            border-radius: 20px;
            padding: 6px 16px;
        }

        .status-pending {
            background: var(--yellow-badge-bg);
            color: var(--yellow-badge-text);
        }

        .status-accepted {
            background: var(--green-badge-bg);
            color: var(--green-badge-text);
        }

        .status-completed {
            background: var(--blue-badge-bg);
            color: var(--blue-badge-text);
        }

        .status-cancelled {
            background: var(--pink-status-bg);
            color: var(--pink-status-text);
        }



        @media (max-width: 980px) {
            .app-frame {
                flex-direction: column;
            }

            .sidebar {
                width: 100%;
            }

            .main {
                padding: 20px;
            }

            .stat-row {
                grid-template-columns: repeat(2, 1fr);
            }

            .page-heading-row {
                flex-direction: column;
                gap: 14px;
            }

            .requests-card {
                overflow-x: auto;
            }
        }

        @media (max-width: 600px) {
            .stat-row {
                grid-template-columns: 1fr;
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
                        <path
                            d="M12 2C9 6 5 10.5 5 14.5a7 7 0 0014 0C19 10.5 15 6 12 2z" />
                    </svg>
                </div>
                <div class="brand-text">
                    <h1>BloodConnect</h1>
                    <p>Donate Blood, Save Life</p>
                </div>
            </div>

            <nav class="nav-list">
                <button class="nav-item active" data-tab="Dashboard">
                    <svg
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2">
                        <rect x="3" y="3" width="7" height="7" rx="1.5" />
                        <rect x="14" y="3" width="7" height="7" rx="1.5" />
                        <rect x="3" y="14" width="7" height="7" rx="1.5" />
                        <rect x="14" y="14" width="7" height="7" rx="1.5" />
                    </svg>
                    Dashboard
                </button>
                <button class="nav-item" data-tab="Request Blood">
                    <svg
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2">
                        <path d="M12 21s-7-5.2-7-11a7 7 0 0114 0c0 5.8-7 11-7 11z" />
                        <circle cx="12" cy="10" r="2.4" />
                    </svg>
                    Request Blood
                </button>
                <button class="nav-item" data-tab="Search Donors">
                    <svg
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2">
                        <circle cx="11" cy="11" r="7" />
                        <path d="M21 21l-4.3-4.3" />
                    </svg>
                    Search Donors
                </button>
                <button class="nav-item" data-tab="Donor List">
                    <svg
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2">
                        <circle cx="12" cy="8" r="3.5" />
                        <path d="M4.5 20c1.5-4 5-5.5 7.5-5.5s6 1.5 7.5 5.5" />
                    </svg>
                    Donor List
                </button>
                <button class="nav-item" data-tab="My Requests">
                    <svg
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2">
                        <path
                            d="M7 3h10a1 1 0 0 1 1 1v16a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1z" />
                        <path d="M9 8h6M9 12h6M9 16h3" />
                    </svg>
                    My Requests
                </button>
                <button class="nav-item" data-tab="Notifications">
                    <svg
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2">
                        <path d="M18 8a6 6 0 1 0-12 0c0 4-2 5-2 7h16c0-2-2-3-2-7" />
                        <path d="M10 21a2 2 0 0 0 4 0" />
                    </svg>
                    Notifications
                </button>
                <button class="nav-item" data-tab="Profile">
                    <svg
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2">
                        <circle cx="12" cy="8" r="3.5" />
                        <path d="M4.5 20c1.5-4 5-5.5 7.5-5.5s6 1.5 7.5 5.5" />
                    </svg>
                    Profile
                </button>
            </nav>

            <div class="sidebar-spacer"></div>

            <div class="logout-divider"></div>
            <button class="logout-btn" id="logoutBtn">
                <svg
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2">
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
                <h2>Welcome, <?= htmlspecialchars($userName, ENT_QUOTES, 'UTF-8') ?>!</h2>
                <div class="topbar-right">
                    <button class="icon-btn" id="bellBtn" aria-label="Notifications">
                        <svg
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2">
                            <path d="M18 8a6 6 0 1 0-12 0c0 4-2 5-2 7h16c0-2-2-3-2-7" />
                            <path d="M10 21a2 2 0 0 0 4 0" />
                        </svg>
                        <span class="dot">3</span>
                    </button>
                    <div class="user-chip" id="userChip">
                        <div class="avatar-sm">
                            <svg
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2">
                                <circle cx="12" cy="8" r="3.5" />
                                <path d="M4.5 20c1.5-4 5-5.5 7.5-5.5s6 1.5 7.5 5.5" />
                            </svg>
                        </div>
                        <span class="name"><?= htmlspecialchars($userName, ENT_QUOTES, 'UTF-8') ?></span>
                        <svg
                            class="chevron"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2.4">
                            <path d="M6 9l6 6 6-6" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="page-heading-row">
                <div class="page-heading">
                    <h3>User Dashboard</h3>
                    <p>User / Patient Dashboard</p>
                </div>
                <button class="btn-new-request" id="newRequestBtn">
                    <svg
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2.4">
                        <path d="M12 5v14M5 12h14" />
                    </svg>
                    New Blood Request
                </button>
            </div>

            <!-- STAT CARDS -->
            <div class="stat-row">
                <div class="stat-card">
                    <div class="stat-icon red">
                        <svg viewBox="0 0 24 24" fill="currentColor">
                            <path
                                d="M12 2C9 6 5 10.5 5 14.5a7 7 0 0014 0C19 10.5 15 6 12 2z" />
                        </svg>
                    </div>
                    <div>
                        <p class="stat-number red-text">2</p>
                        <p class="stat-name">Total Requests</p>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon orange">
                        <svg
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2">
                            <circle cx="12" cy="12" r="9" />
                            <path d="M12 7v5l3.5 2" />
                        </svg>
                    </div>
                    <div>
                        <p class="stat-number orange-text">1</p>
                        <p class="stat-name">Pending Requests</p>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon green">
                        <svg
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2">
                            <circle cx="12" cy="12" r="9" />
                            <path d="M8.5 12.5l2 2 5-5" />
                        </svg>
                    </div>
                    <div>
                        <p class="stat-number green-text">1</p>
                        <p class="stat-name">Accepted Requests</p>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon blue">
                        <svg
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2">
                            <path d="M12 21s-7-5.2-7-11a7 7 0 0114 0c0 5.8-7 11-7 11z" />
                        </svg>
                    </div>
                    <div>
                        <p class="stat-number blue-text">1</p>
                        <p class="stat-name">Completed Requests</p>
                    </div>
                </div>
            </div>

            <!-- REQUESTS TABLE CARD -->
            <div class="requests-card">
                <div class="requests-card-header">
                    <h4>My Requests</h4>
                    <a class="view-all-link" id="viewAllLink">View All &gt;</a>
                </div>

                <table>
                    <thead>
                        <tr>
                            <th>Request ID</th>
                            <th>Blood</th>
                            <th>Hospital / Location</th>
                            <th>Status</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody id="requestsBody">
                        <tr>
                            <td>REQ1001</td>
                            <td><span class="blood-pill">B+</span></td>
                            <td>Green View Hospital</td>
                            <td><span class="status-pill status-pending">PENDING</span></td>
                            <td class="date-col">08 May 2026</td>
                        </tr>
                        <tr>
                            <td>REQ1002</td>
                            <td><span class="blood-pill">O+</span></td>
                            <td>City Hospital</td>
                            <td>
                                <span class="status-pill status-accepted">ACCEPTED</span>
                            </td>
                            <td class="date-col">12 May 2026</td>
                        </tr>
                        <tr>
                            <td>REQ1003</td>
                            <td><span class="blood-pill">A-</span></td>
                            <td>City Hospital</td>
                            <td>
                                <span class="status-pill status-completed">COMPLETED</span>
                            </td>
                            <td class="date-col">15 May 2026</td>
                        </tr>
                        <tr>
                            <td>REQ1004</td>
                            <td><span class="blood-pill">AB+</span></td>
                            <td>Main Clinic</td>
                            <td>
                                <span class="status-pill status-cancelled">CANCELLED</span>
                            </td>
                            <td class="date-col">20 May 2026</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </main>
    </div>

    <script>
        const basePath = '<?= $basePath ?>';

        // Sidebar nav switching
        document.querySelectorAll(".nav-item").forEach((btn) => {
            btn.addEventListener("click", () => {
                document
                    .querySelectorAll(".nav-item")
                    .forEach((b) => b.classList.remove("active"));
                btn.classList.add("active");
            });
        });

        // New Blood Request button
        document.getElementById("newRequestBtn").addEventListener("click", () => {
            alert('Open "New Blood Request" form');
        });

        // View All link
        document.getElementById("viewAllLink").addEventListener("click", (e) => {
            e.preventDefault();
            alert("Navigate to full requests list");
        });

        // Bell + user chip
        document.getElementById("bellBtn").addEventListener("click", () => {
            alert("You have 3 new notifications");
        });
        document.getElementById("userChip").addEventListener("click", () => {
            alert("User menu — Profile / Settings / Logout");
        });
        document.getElementById("logoutBtn").addEventListener("click", () => {
            window.location.href = basePath + '/logout';
        });
    </script>
</body>

</html>