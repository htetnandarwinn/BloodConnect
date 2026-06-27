<?php
$userName = $userName ?? 'Guest';
$unreadCount = $unreadCount ?? 0;
$basePath = $basePath ?? '';
?>
<div class="topbar">

    <div>
        <h2>
            Welcome,
            <?= htmlspecialchars($userName) ?>! 👋
        </h2>

        <p>
            Every drop you donate, makes a difference.
        </p>
    </div>

    <div class="topbar-right">

        <button class="icon-btn" id="bellBtn">

            <!-- Bell SVG -->

            <span class="dot">
                <?= $unreadCount ?>
            </span>

        </button>

        <a class="user-chip" href="<?= $basePath ?>/donor/profile">

            <div class="avatar-sm">
                <!-- Avatar SVG -->
            </div>

            <div class="meta">
                <p><?= htmlspecialchars($userName) ?></p>
                <span>Donor</span>
            </div>

            <svg class="chevron"></svg>

        </a>

    </div>

</div>