<?php
?>

<div class="max-w-5xl mx-auto w-full px-4 py-8 sm:px-6 lg:py-12 space-y-8">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 border-b border-slate-100 pb-6">
        <div>
            <span class="block text-xs font-black text-red-600 uppercase tracking-widest mb-1.5">
                Dashboard
            </span>
            <h1 class="text-3xl font-black text-slate-950 tracking-tight sm:text-4xl">
                Notifications
            </h1>
            <p class="text-sm font-medium text-slate-500 mt-1">
                Stay updated with live BloodConnect donor activities and blood request updates.
            </p>
        </div>

        <button id="markAllReadBtn"
            class="inline-flex items-center justify-center gap-2 px-5 py-3 rounded-xl border border-red-200 text-sm font-bold text-red-600 bg-white hover:bg-red-50/50 hover:border-red-600 shadow-sm active:scale-[0.98] transition-all self-start sm:self-center">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
            </svg>
            Mark all as read
        </button>
    </div>

    <div class="space-y-3.5" id="notificationsWrapper">
        <?php if (!empty($notifications)): ?>
            <?php foreach ($notifications as $notification): ?>
                <?php
                $isUnread = empty($notification['is_read']);
                $cardClass = $isUnread
                    ? 'bg-white border-slate-200 shadow-sm ring-1 ring-slate-900/5'
                    : 'bg-slate-50/60 border-slate-100 opacity-65';

                switch ($notification['type']) {
                    case 'request':
                        $iconBg = 'bg-rose-50 text-rose-600 border-rose-100';
                        $iconPath = 'M12 2.5C12 2.5 5 9.5 5 14.5C5 18.37 8.13 21.5 12 21.5C15.87 21.5 19 18.37 19 14.5C19 9.5 12 2.5 12 2.5Z';
                        break;
                    case 'approval':
                        $iconBg = 'bg-blue-50 text-blue-600 border-blue-100';
                        $iconPath = 'M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z M4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z';
                        break;
                    case 'reminder':
                        $iconBg = 'bg-amber-50 text-amber-600 border-amber-100';
                        $iconPath = 'M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z';
                        break;
                    default:
                        $iconBg = 'bg-emerald-50 text-emerald-600 border-emerald-100';
                        $iconPath = 'M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z';
                        break;
                }
                ?>

                <div class="notification-card flex flex-col sm:flex-row justify-between gap-4 p-5 rounded-2xl border cursor-pointer select-none transition-all duration-300 hover:shadow-md hover:border-slate-300 <?= $cardClass ?>"
                    data-id="<?= $notification['notification_id'] ?>">
                    <div class="flex items-start gap-4 flex-1 min-w-0">
                        <div class="w-11 h-11 rounded-xl <?= $iconBg ?> border flex items-center justify-center flex-shrink-0 shadow-sm">
                            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor">
                                <path d="<?= $iconPath ?>"></path>
                            </svg>
                        </div>
                        <div class="space-y-0.5 flex-1 min-w-0">
                            <h3 class="font-bold text-slate-900 tracking-tight text-sm sm:text-base truncate">
                                <?= htmlspecialchars($notification['title']) ?>
                            </h3>
                            <p class="text-sm text-slate-600 leading-relaxed break-words">
                                <?= $notification['message'] ?>
                            </p>
                        </div>
                    </div>

                    <div class="flex sm:flex-col justify-between items-center sm:items-end gap-2 sm:text-right border-t sm:border-t-0 pt-3 sm:pt-0 border-slate-100 flex-shrink-0">
                        <span class="text-xs font-medium text-slate-400">
                            <?= htmlspecialchars($notification['time_ago'] ?? ($notification['created_at'] ?? '')) ?>
                        </span>
                        <span class="status-indicator w-2.5 h-2.5 rounded-full transition-all duration-300 shadow-sm
                            <?= $isUnread ? 'bg-red-500 ring-4 ring-red-50' : 'bg-slate-300' ?>">
                        </span>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="text-center py-20 bg-white border border-dashed border-slate-200 rounded-3xl p-8 shadow-sm">
                <div class="w-14 h-14 bg-slate-50 border border-slate-100 rounded-2xl flex items-center justify-center mx-auto mb-4 text-slate-400">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
                    </svg>
                </div>
                <h3 class="text-base font-bold text-slate-900">All caught up!</h3>
                <p class="mt-1 text-sm text-slate-400 max-w-xs mx-auto">
                    You have no unread blood donation alerts or administrative flags right now.
                </p>
            </div>
        <?php endif; ?>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", () => {
        const markAllBtn = document.getElementById("markAllReadBtn");

        fetch("/BloodConnect/public/notification/unread-count")
            .then(res => res.json())
            .then(data => refreshBadges(data.count))
            .catch(() => {});

        document.querySelectorAll(".notification-card").forEach(card => {
            card.addEventListener("click", async () => {
                if (card.classList.contains("opacity-65")) return;
                const id = card.dataset.id;

                try {
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
                            indicator.classList.remove("bg-red-500", "ring-4", "ring-red-50");
                            indicator.classList.add("bg-slate-300");
                        }

                        card.classList.remove("bg-white", "border-slate-200", "shadow-sm", "ring-1", "ring-slate-900/5");
                        card.classList.add("bg-slate-50/50", "border-slate-100", "opacity-65");

                        refreshBadges(result.count);
                    }
                } catch (err) {
                    console.error("Failed handling notification event:", err);
                }
            });
        });

        if (markAllBtn) {
            markAllBtn.addEventListener("click", async () => {
                try {
                    const response = await fetch("/BloodConnect/public/notification/mark-all-read", {
                        method: "POST"
                    });
                    const result = await response.json();

                    if (result.success) {
                        document.querySelectorAll(".notification-card").forEach(card => {
                            const indicator = card.querySelector(".status-indicator");
                            if (indicator) {
                                indicator.classList.remove("bg-red-500", "ring-4", "ring-red-50");
                                indicator.classList.add("bg-slate-300");
                            }
                            card.classList.remove("bg-white", "border-slate-200", "shadow-sm", "ring-1", "ring-slate-900/5");
                            card.classList.add("bg-slate-50/50", "border-slate-100", "opacity-65");
                        });
                        refreshBadges(result.count);
                    }
                } catch (err) {
                    console.error("Failed executing batch clear processing rules:", err);
                }
            });
        }
    });

    function refreshBadges(count) {
        const safeCount = Number(count || 0);

        if (window.syncNotificationBadges) {
            window.syncNotificationBadges(safeCount);
            return;
        }

        document.querySelectorAll(".notification-badge").forEach(badge => {
            if (safeCount > 0) {
                badge.textContent = safeCount;
                badge.style.display = "flex";
            } else {
                badge.textContent = "";
                badge.style.display = "none";
            }
        });
    }
</script>