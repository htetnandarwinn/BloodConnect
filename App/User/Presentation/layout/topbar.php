<?php

use App\Shared\Helpers\Session;

Session::start();

$username = Session::get('username', 'Patient');

// SAFE fallback (important)
$unreadCount = $unreadCount ?? 0;

?>

<!-- TOP NAVBAR -->
<header class="bg-white border-b border-slate-100 px-3 sm:px-6 lg:px-8 py-3 sm:py-4 flex items-center justify-between sticky top-0 z-30">

    <!-- Left Section -->
    <div class="flex items-center gap-2 sm:gap-3">

        <!-- Sidebar Toggle Icon (Optimized layout for both mobile and desktop) -->
        <button id="mobileSidebarToggle"
            class="p-2 rounded-xl text-[#0b1325] hover:bg-red-50/70 hover:text-[#ce2424] transition-all flex items-center justify-center focus:outline-none">
            <span class="text-xl leading-none">☰</span>
        </button>

        <h2 class="text-sm sm:text-base lg:text-lg font-black text-[#0b1325] tracking-tight leading-none whitespace-nowrap">
            Patient Dashboard
        </h2>
    </div>

    <!-- Right Section -->
    <div class="flex items-center gap-2 sm:gap-5">

        <!-- Notification Bell -->
        <div class="relative">
            <a href="/BloodConnect/public/patient/notifications"
                class="relative p-2 text-slate-400 hover:bg-red-50/70 hover:text-[#ce2424] rounded-xl transition-all inline-flex items-center justify-center">

                <span class="text-xl">🔔</span>

                <?php if ($unreadCount > 0): ?>
                    <span id="topbarNotificationBadge"
                        class="absolute top-1 right-1 w-4 h-4 rounded-full bg-[#ce2424] text-[9px] font-black text-white flex items-center justify-center ring-2 ring-white">
                        <?= $unreadCount ?>
                    </span>
                <?php endif; ?>
            </a>
        </div>

        <!-- User Dropdown -->
        <div class="relative group">

            <button class="flex items-center gap-1.5 sm:gap-2.5 bg-slate-50 p-1.5 sm:pl-2 sm:pr-3 sm:py-1.5 rounded-xl border border-slate-100 transition-all hover:bg-red-50/70 hover:text-[#ce2424] cursor-pointer outline-none group">

                <div class="w-7 h-7 rounded-full bg-slate-200 group-hover:bg-red-200/50 flex items-center justify-center font-bold text-[#0b1325] group-hover:text-[#ce2424] text-xs transition-colors shrink-0">
                    👤
                </div>

                <!-- Hidden on tiny screens to avoid layout breaking, clean on PC -->
                <div class="text-left hidden sm:block">
                    <span class="block text-sm font-bold text-[#0b1325] group-hover:text-[#ce2424] leading-none transition-colors max-w-[100px] truncate">
                        <?= htmlspecialchars($username) ?>
                    </span>
                    <span class="block text-[9px] text-slate-400 font-bold uppercase tracking-wider mt-0.5">
                        Patient
                    </span>
                </div>

                <span class="text-[10px] text-slate-400 group-hover:text-[#ce2424] transition-transform group-hover:rotate-180 ml-0.5 sm:ml-0">
                    ▼
                </span>

            </button>

            <!-- Dropdown Menu Options -->
            <div class="absolute right-0 mt-2 w-56 bg-white border border-slate-100 rounded-2xl shadow-xl opacity-0 invisible translate-y-2 group-hover:opacity-100 group-hover:visible group-hover:translate-y-0 transition-all duration-200 z-50 overflow-hidden">

                <div class="px-4 py-3 bg-slate-50/50 border-b border-slate-100">
                    <span class="block text-[10px] font-bold text-slate-400 uppercase tracking-wide">
                        Signed in as
                    </span>
                    <span class="block text-base font-black text-[#0b1325] truncate mt-0.5">
                        <?= htmlspecialchars($username) ?>
                    </span>
                </div>

                <div class="p-1.5 space-y-0.5">
                    <a href="/BloodConnect/public/patient/profile"
                        class="flex items-center gap-2.5 px-3 py-2 rounded-xl text-sm font-bold text-slate-600 hover:bg-red-50/70 hover:text-[#ce2424] transition-colors">
                        <span class="text-base text-slate-400">👤</span>
                        My Profile Details
                    </a>
                </div>

                <div class="p-1.5 border-t border-slate-100 bg-slate-50/30">
                    <a href="/BloodConnect/public/logout"
                        class="flex items-center gap-2.5 px-3 py-2 rounded-xl text-sm font-bold text-[#ce2424] hover:bg-red-100/60 transition-colors">
                        <span class="text-base">🚪</span>
                        Logout System
                    </a>
                </div>

            </div>
        </div>

    </div>
</header>

<script>
    async function updateNotificationBadges() {
        try {
            const res = await fetch("/BloodConnect/public/notification/unread-count");
            const data = await res.json();

            const count = data.count || 0;

            const topbarBadge = document.getElementById("topbarNotificationBadge");
            if (topbarBadge) {
                if (count > 0) {
                    topbarBadge.textContent = count;
                    topbarBadge.classList.remove("hidden");
                } else {
                    topbarBadge.classList.add("hidden");
                }
            }

            document.querySelectorAll(".notification-badge").forEach(badge => {
                if (count > 0) {
                    badge.textContent = count;
                    badge.style.display = "flex";
                } else {
                    badge.style.display = "none";
                }
            });

        } catch (error) {
            console.log("Notification update failed", error);
        }
    }

    updateNotificationBadges();
    setInterval(updateNotificationBadges, 10000);
</script>