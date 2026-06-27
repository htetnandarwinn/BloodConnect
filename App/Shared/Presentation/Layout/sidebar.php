<?php
$basePath = $basePath ?? '';
$unreadCount = $unreadCount ?? 0;
?>
<aside class="sidebar">

    <div class="brand">
        <div class="brand-icon">
            <!-- SVG -->
        </div>

        <div class="brand-text">
            <h1>BloodConnect</h1>
            <p>Donate Blood, Save Lives</p>
        </div>
    </div>

    <nav class="nav-list">

        <a class="nav-item" href="<?= $basePath ?>/donor/dashboard">
            Dashboard
        </a>

        <a class="nav-item active" href="<?= $basePath ?>/donor/profile">
            My Profile
        </a>

        <a class="nav-item" href="<?= $basePath ?>/donor/availability">
            Availability Status
        </a>

        <a class="nav-item" href="<?= $basePath ?>/donor/blood-request">
            Blood Request
            <span class="badge"><?= $unreadCount ?></span>
        </a>

        <a class="nav-item" href="<?= $basePath ?>/donor/history">
            Donation History
        </a>

        <a class="nav-item" href="<?= $basePath ?>/donor/notifications">
            Notifications
        </a>

    </nav>

    <div class="sidebar-spacer"></div>

    <div class="logout-divider"></div>

    <button class="logout-btn" id="logoutBtn">
        Logout
    </button>

</aside>