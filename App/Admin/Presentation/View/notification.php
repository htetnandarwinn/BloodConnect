<?php
// No mock data here anymore
// $notifications must come from controller (DB)
?>

<div class="max-w-5xl mx-auto w-full px-4 py-8 sm:px-6 lg:py-12 space-y-8 select-none">

    <!-- HEADER -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-6 border-b border-slate-100 dark:border-slate-800/60 pb-6">
        <div>
            <div class="flex items-center gap-2 mb-1.5">
                <span class="block text-xs font-black text-red-600 uppercase tracking-widest">
                    Dashboard
                </span>
                <span class="w-1.5 h-1.5 rounded-full bg-red-500 animate-pulse"></span>
            </div>
            <h1 class="text-3xl font-black text-slate-950 tracking-tight sm:text-4xl">
                Notifications
            </h1>
            <p class="text-sm font-medium text-slate-500 mt-1">
                Stay updated with live BloodConnect system activities, requests, and logs.
            </p>
        </div>

        <button id="markAllReadBtn"
            class="inline-flex items-center justify-center gap-2.5 px-5 py-3 rounded-xl border border-slate-200 text-sm font-bold text-slate-700 bg-white hover:bg-slate-50 hover:text-red-600 hover:border-red-200 shadow-sm transition-all duration-200 active:scale-[0.97] self-start sm:self-center group">
            <svg class="w-4 h-4 text-slate-400 group-hover:text-red-500 transition-colors" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
            </svg>
            Mark all as read
        </button>
    </div>

    <!-- LIST -->
    <div class="space-y-4" id="notificationsWrapper">

        <?php if (!empty($notifications)): ?>
            <?php foreach ($notifications as $index => $notification): ?>

                <?php
                $isUnread = empty($notification['is_read']);

                // Modern Dynamic Glass & Interactive State Styling 
                $cardClass = $isUnread
                    ? 'bg-white border-slate-200/80 shadow-[0_2px_8px_-3px_rgba(0,0,0,0.05)] ring-1 ring-slate-900/5 hover:border-slate-300 hover:shadow-[0_8px_20px_-6px_rgba(0,0,0,0.08)]'
                    : 'bg-slate-50/40 border-slate-100/80 opacity-60 hover:opacity-90';

                switch ($notification['type']) {
                    case 'request':
                        $iconBg = 'bg-rose-50 text-rose-600 border-rose-100/80 target-glow';
                        $iconPath = 'M12 2.5C12 2.5 5 9.5 5 14.5C5 18.37 8.13 21.5 12 21.5C15.87 21.5 19 18.37 19 14.5C19 9.5 12 2.5 12 2.5Z';
                        break;

                    case 'approval':
                        $iconBg = 'bg-blue-50 text-blue-600 border-blue-100/80';
                        $iconPath = 'M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z M4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z';
                        break;

                    case 'reminder':
                        $iconBg = 'bg-amber-50 text-amber-600 border-amber-100/80';
                        $iconPath = 'M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z';
                        break;

                    default:
                        $iconBg = 'bg-emerald-50 text-emerald-600 border-emerald-100/80';
                        $iconPath = 'M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z';
                        break;
                }
                ?>

                <!-- Individual Notification Card -->
                <div class="notification-card flex flex-col sm:flex-row justify-between gap-4 p-5 rounded-2xl border transition-all duration-300 ease-out active:scale-[0.995] animate-fade-in-up <?= $cardClass ?>"
                    style="animation-delay: <?= $index * 40 ?>ms"
                    data-id="<?= $notification['notification_id'] ?>">

                    <!-- LEFT: Icon & Text Body -->
                    <div class="flex items-start gap-4 flex-1 min-w-0">
                        <!-- Icon Badge Frame -->
                        <div class="w-12 h-12 rounded-xl <?= $iconBg ?> border flex items-center justify-center flex-shrink-0 shadow-sm group-hover:scale-110 transition-transform duration-200">
                            <svg class="w-5 h-5 transition-transform duration-300 hover:rotate-12" viewBox="0 0 24 24" fill="currentColor">
                                <path d="<?= $iconPath ?>"></path>
                            </svg>
                        </div>

                        <!-- Content Block -->
                        <div class="space-y-1 flex-1 min-w-0">
                            <h3 class="font-bold text-slate-900 tracking-tight text-sm sm:text-base truncate">
                                <?= htmlspecialchars($notification['title']) ?>
                            </h3>
                            <p class="text-sm text-slate-600 leading-relaxed break-words font-medium">
                                <?= $notification['message'] ?>
                            </p>
                        </div>
                    </div>

                    <!-- RIGHT: Timestamp & Unread Dot Panel -->
                    <div class="flex sm:flex-col justify-between items-center sm:items-end gap-3 sm:text-right border-t sm:border-t-0 pt-3 sm:pt-0 border-slate-100 flex-shrink-0">
                        <span class="text-xs font-semibold text-slate-400/90 tracking-wide">
                            <?= htmlspecialchars($notification['time_ago'] ?? ($notification['created_at'] ?? '')) ?>
                        </span>

                        <span class="status-indicator w-2.5 h-2.5 rounded-full transition-all duration-500 shadow-sm
                            <?= $isUnread ? 'bg-red-500 ring-4 ring-red-500/20' : 'bg-slate-300/70' ?>">
                        </span>
                    </div>

                </div>

            <?php endforeach; ?>
        <?php else: ?>

            <!-- Empty State Component View -->
            <div class="text-center py-20 bg-slate-50/50 border-2 border-dashed border-slate-200/80 rounded-3xl p-8 animate-fade-in-up">
                <div class="w-16 h-16 bg-white border border-slate-100 rounded-2xl flex items-center justify-center mx-auto mb-4 text-slate-400 shadow-sm">
                    <svg class="w-7 h-7 stroke-slate-400" fill="none" stroke-width="1.8" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
                    </svg>
                </div>
                <h3 class="text-base font-bold text-slate-900">All caught up!</h3>
                <p class="mt-1 text-sm font-medium text-slate-400 max-w-xs mx-auto">
                    You have no unread blood donation alerts or administrative flags right now.
                </p>
            </div>

        <?php endif; ?>

    </div>
</div>

<!-- JAVASCRIPT LOGIC WITH INTERACTION MUTATIONS -->
<script>
    document.addEventListener("DOMContentLoaded", () => {
        const markAllBtn = document.getElementById("markAllReadBtn");

        // UI Transformation helper instead of heavy rewrites
        const transformCardToRead = (card) => {
            const indicator = card.querySelector(".status-indicator");
            if (indicator) {
                indicator.classList.remove("bg-red-500", "ring-4", "ring-red-500/20");
                indicator.classList.add("bg-slate-300/70");
            }
            card.classList.remove("bg-white", "border-slate-200/80", "shadow-[0_2px_8px_-3px_rgba(0,0,0,0.05)]", "ring-1", "ring-slate-900/5", "hover:border-slate-300", "hover:shadow-[0_8px_20px_-6px_rgba(0,0,0,0.08)]");
            card.classList.add("bg-slate-50/40", "border-slate-100/80", "opacity-60", "hover:opacity-90");
        };

        // --- initial badge sync ---
        fetch("/BloodConnect/public/notification/unread-count")
            .then(res => res.json())
            .then(data => refreshBadges(data.count))
            .catch(() => {});

        // --- mark single notification as read ---
        document.querySelectorAll(".notification-card").forEach(card => {

            card.addEventListener("click", async () => {

                // Don't send another request if it's already read
                if (card.classList.contains("notification-read")) {
                    return;
                }

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

                        transformCardToRead(card);

                        card.classList.add("notification-read");

                        refreshBadges(result.count);

                    }

                } catch (err) {
                    console.error(err);
                }

            });

        });

        // --- mark all as read ---
        if (markAllBtn) {
            markAllBtn.addEventListener("click", async () => {
                try {
                    const response = await fetch("/BloodConnect/public/notification/mark-all-read", {
                        method: "POST"
                    });

                    const result = await response.json();

                    if (result.success) {
                        document.querySelectorAll(".notification-card").forEach(card => {
                            transformCardToRead(card);
                        });
                        refreshBadges(result.count);
                    }
                } catch (err) {
                    console.error("Failed executing batch clear processing rules:", err);
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