<?php
// No mock data here anymore
// $notifications must come from controller (DB)
?>

<div class="max-w-7xl mx-auto w-full px-4 py-8 space-y-6 animate-fade-in">

    <!-- HEADER -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">

        <div>
            <span class="block text-xs font-black text-red-600 uppercase tracking-widest mb-1">
                Dashboard
            </span>

            <h1 class="text-3xl font-black text-slate-950 tracking-tight">
                Notifications
            </h1>

            <p class="text-sm font-medium text-slate-400 mt-1">
                Stay updated with system activities and updates.
            </p>
        </div>

        <button id="markAllReadBtn"
            class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl border-2 border-red-200 text-sm font-bold text-red-600 bg-white hover:bg-red-50 hover:border-red-600 transition-all">
            ✔ Mark all as read
        </button>

    </div>

    <!-- LIST -->
    <div class="space-y-4" id="notificationsWrapper">

        <?php if (!empty($notifications)): ?>
            <?php foreach ($notifications as $index => $notification): ?>

                <?php
                $isUnread = empty($notification['is_read']);

                $cardClass = $isUnread
                    ? 'bg-white border-slate-100'
                    : 'bg-slate-50/50 border-slate-100 opacity-70';

                switch ($notification['type']) {

                    case 'request':
                        $iconBg = 'bg-red-50 text-red-600';
                        $iconPath = 'M12 2.5C12 2.5 5 9.5 5 14.5C5 18.37 8.13 21.5 12 21.5C15.87 21.5 19 18.37 19 14.5C19 9.5 12 2.5 12 2.5Z';
                        break;

                    case 'approval':
                        $iconBg = 'bg-blue-50 text-blue-600';
                        $iconPath = 'M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z';
                        break;

                    case 'reminder':
                        $iconBg = 'bg-amber-50 text-amber-600';
                        $iconPath = 'M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5';
                        break;

                    default:
                        $iconBg = 'bg-emerald-50 text-emerald-600';
                        $iconPath = 'M4.5 12.75l6 6 9-13.5';
                        break;
                }
                ?>

                <div class="notification-card flex justify-between p-5 rounded-2xl border <?= $cardClass ?> shadow-sm hover:shadow-md transition"
                    data-id="<?= $notification['notification_id'] ?>">

                    <!-- LEFT -->
                    <div class="flex gap-4">

                        <div class="w-12 h-12 rounded-full <?= $iconBg ?> flex items-center justify-center">
                            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor">
                                <path d="<?= $iconPath ?>"></path>
                            </svg>
                        </div>

                        <div>
                            <h3 class="font-bold text-slate-900">
                                <?= htmlspecialchars($notification['title']) ?>
                            </h3>

                            <p class="text-sm text-slate-500">
                                <?= $notification['message'] ?>
                            </p>
                        </div>

                    </div>

                    <!-- RIGHT -->
                    <div class="text-right">

                        <p class="text-xs text-slate-400">
                            <?= $notification['time_ago'] ?? ($notification['created_at'] ?? '') ?>
                        </p>

                        <span class="status-indicator w-2.5 h-2.5 rounded-full inline-block mt-2
                            <?= $isUnread ? 'bg-red-600' : 'bg-slate-300' ?>">
                        </span>

                    </div>

                </div>

            <?php endforeach; ?>
        <?php else: ?>

            <div class="text-center py-16 text-slate-400">
                🔔 No notifications found
            </div>

        <?php endif; ?>

    </div>
</div>

<!-- JS -->
<script>
    document.addEventListener("DOMContentLoaded", () => {

        const markAllBtn = document.getElementById("markAllReadBtn");

        // --- initial badge sync (important fix) ---
        fetch("/BloodConnect/public/notification/unread-count")
            .then(res => res.json())
            .then(data => refreshBadges(data.count))
            .catch(() => {});

        // --- mark single notification as read ---
        document.querySelectorAll(".notification-card").forEach(card => {

            card.addEventListener("click", async () => {

                if (card.classList.contains("opacity-60")) return;

                const id = card.dataset.id;

                const response = await fetch("/BloodConnect/public/notification/mark-read", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded"
                    },
                    body: "notification_id=" + encodeURIComponent(id)
                });

                const result = await response.json();

                if (result.success) {

                    const indicator = card.querySelector(".status-indicator");

                    if (indicator) {
                        indicator.classList.remove("bg-red-600");
                        indicator.classList.add("bg-slate-300");
                    }

                    card.classList.remove("bg-white");
                    card.classList.add("opacity-60");

                    refreshBadges(result.count);
                }
            });

        });

        // --- mark all as read ---
        if (markAllBtn) {
            markAllBtn.addEventListener("click", async () => {

                const response = await fetch("/BloodConnect/public/notification/mark-all-read", {
                    method: "POST"
                });

                const result = await response.json();

                if (result.success) {

                    document.querySelectorAll(".notification-card").forEach(card => {

                        const indicator = card.querySelector(".status-indicator");

                        if (indicator) {
                            indicator.classList.remove("bg-red-600");
                            indicator.classList.add("bg-slate-300");
                        }

                        card.classList.remove("bg-white");
                        card.classList.add("opacity-60");
                    });

                    refreshBadges(result.count);
                }
            });
        }

    });

    // --- badge updater ---
    function refreshBadges(count) {

        const top = document.getElementById("topbarNotificationBadge");

        if (top) {
            if (count > 0) {
                top.textContent = count;
                top.classList.remove("hidden");
            } else {
                top.textContent = "";
                top.classList.add("hidden");
            }
        }

        document.querySelectorAll(".notification-badge").forEach(badge => {
            if (count > 0) {
                badge.textContent = count;
                badge.style.display = "flex";
            } else {
                badge.textContent = "";
                badge.style.display = "none";
            }
        });
    }
</script>