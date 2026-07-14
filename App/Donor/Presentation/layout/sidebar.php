<?php

use App\BloodRequest\Infrastructure\Persistence\BloodRequestRepository;
use App\Donor\Infrastructure\Persistence\DonorRepository;
use App\Shared\Helpers\Permission;
use App\Shared\Helpers\Session;

$pendingRequestsCount = 0;

if (Permission::can('blood_request.view_matching')) {
    $user = Session::get('user');
    $bloodGroup = '';

    if (is_array($user)) {
        $bloodGroup = trim((string)($user['blood_group'] ?? ''));
    }

    if ($bloodGroup === '') {
        $donorRepo = new DonorRepository();
        $donor = $donorRepo->findById((int) Session::get('user_id'));
        $bloodGroup = trim((string)($donor['blood_group'] ?? ''));
    }

    if ($bloodGroup !== '') {
        $repo = new BloodRequestRepository();
        $totalPending = count($repo->findPendingRequestsForDonor($bloodGroup));
        $viewedCount = count($_SESSION['viewed_pending_requests'] ?? []);
        $pendingRequestsCount = max(0, $totalPending - $viewedCount);
    }
}

?>
<div id="sidebarBackdrop" class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm z-40 hidden opacity-0 transition-opacity duration-300 lg:hidden"></div>

<aside id="sidebarDrawer" class="fixed inset-y-0 left-0 w-72 bg-white border-r border-slate-100 p-5 flex flex-col justify-between z-50 -translate-x-full lg:translate-x-0 lg:sticky lg:top-0 h-screen transition-transform duration-300 ease-in-out shrink-0">
    <div class="space-y-7">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3 px-2">
                <div class="w-11 h-11 flex items-center justify-center shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="w-11 h-11">
                        <path d="M12 2.5C12 2.5 5 9.5 5 14.5C5 18.37 8.13 21.5 12 21.5C15.87 21.5 19 18.37 19 14.5C19 9.5 12 2.5 12 2.5Z" fill="#ce2424" />
                        <path d="M12 17.15l-.38-.35C10.27 15.44 9 14.28 9 12.85c0-1.17.91-2.08 2.08-2.08.66 0 1.29.31 1.7.79.41-.48 1.04-.79 1.7-.79 1.17 0 2.08.91 2.08 2.08 0 1.43-1.27 2.59-2.62 3.96l-.38.34z" fill="#ffffff" />
                    </svg>
                </div>
                <div>
                    <span class="block font-black text-[#0b1325] text-lg tracking-tight leading-tight">BloodConnect</span>
                    <span class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mt-0.5">Donor Dashboard</span>
                </div>
            </div>
            <button id="closeSidebarBtn" class="lg:hidden p-2 rounded-xl hover:bg-slate-50 text-slate-400 hover:text-slate-600 transition-colors">✕</button>
        </div>

        <nav class="space-y-1.5" id="sidebarNav">

            <?php if (Permission::can('dashboard.view')): ?>

                <a href="/BloodConnect/public/donor/dashboard"
                    class="nav-link flex items-center gap-3.5 px-4 py-3 rounded-xl font-bold text-base text-slate-600 hover:bg-[#ce2424] hover:text-white transition-all duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 shrink-0">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z" />
                    </svg>
                    Dashboard
                </a>

            <?php endif; ?>

            <div class="pt-4 pb-1 px-4">
                <span class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider">Activities</span>
            </div>

            <?php if (Permission::can('availability')): ?>
                <a href="/BloodConnect/public/donor/availability"
                    class="nav-link flex items-center gap-3.5 px-4 py-3 rounded-xl font-bold text-base text-slate-600 hover:bg-[#ce2424] hover:text-white transition-all duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 shrink-0">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" />
                    </svg>
                    Availability Status
                </a>
            <?php endif; ?>

            <?php if (Permission::can('blood_request.view_matching')): ?>
                <a href="/BloodConnect/public/donor/blood-requests"
                    class="nav-link flex items-center justify-between px-4 py-3 rounded-xl font-bold text-base text-slate-600 hover:bg-[#ce2424] hover:text-white transition-all duration-200">
                    <div class="flex items-center gap-3.5">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5 shrink-0">
                            <path d="M12 2.5C12 2.5 5 9.5 5 14.5C5 18.37 8.13 21.5 12 21.5C15.87 21.5 19 18.37 19 14.5C19 9.5 12 2.5 12 2.5Z" />
                        </svg>
                        Blood Requests
                    </div>

                    <?php if ($pendingRequestsCount > 0): ?>
                        <span class="pending-badge w-5 h-5 rounded-full bg-[#ce2424] text-white text-[10px] font-black flex items-center justify-center"><?= $pendingRequestsCount ?></span>
                    <?php else: ?>
                        <span class="pending-badge w-5 h-5 rounded-full bg-[#ce2424] text-white text-[10px] font-black hidden"></span>
                    <?php endif; ?>
                </a>
            <?php endif; ?>

            <?php if (Permission::can('donation_history.view')): ?>

                <a href="/BloodConnect/public/donor/history"
                    class="nav-link flex items-center gap-3.5 px-4 py-3 rounded-xl font-bold text-base text-slate-600 hover:bg-[#ce2424] hover:text-white transition-all duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 shrink-0">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z" />
                    </svg>
                    Donation History
                </a>

            <?php endif; ?>


            <?php if (Permission::can('notification.view')): ?>
                <div class="pt-4 pb-1 px-4">
                    <span class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider">Communication</span>
                </div>

                <a href="/BloodConnect/public/donor/notifications"
                    class="nav-link flex items-center justify-between px-4 py-3 rounded-xl font-bold text-base text-slate-600 hover:bg-[#ce2424] hover:text-white transition-all duration-200">
                    <div class="flex items-center gap-3.5">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 shrink-0">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
                        </svg>
                        Notifications
                    </div>

                    <?php if (!empty($unreadCount) && $unreadCount > 0): ?>
                        <span class="notification-badge w-5 h-5 rounded-full bg-[#ce2424] text-white text-[10px] font-black flex items-center justify-center">
                            <?= $unreadCount ?>
                        </span>
                    <?php else: ?>
                        <span class="notification-badge w-5 h-5 rounded-full bg-[#ce2424] text-white text-[10px] font-black hidden"></span>
                    <?php endif; ?>
                </a>
            <?php endif; ?>

        </nav>
    </div>

    <!-- <div class="border-t border-slate-100 pt-4">
        <a href="/BloodConnect/public/logout" class="block">
            <button class="w-full flex items-center gap-3.5 px-4 py-3 rounded-xl font-bold text-base text-slate-600 hover:bg-[#ce2424] hover:text-white transition-all duration-200">
                <span class="text-xl">🚪</span>
                Logout
            </button>
        </a>
    </div> -->
</aside>

<script>
    document.addEventListener("DOMContentLoaded", () => {
        // --- 1. SIDEBAR MOBILE TOGGLE INTERACTION LOGIC ---
        const toggleBtn = document.getElementById("mobileSidebarToggle"); // Target menu icon from topbar
        const closeBtn = document.getElementById("closeSidebarBtn");
        const drawer = document.getElementById("sidebarDrawer");
        const backdrop = document.getElementById("sidebarBackdrop");

        function openSidebar() {
            backdrop.classList.remove("hidden");
            // Allow layout engine to parse block removal before animating opacity
            setTimeout(() => {
                backdrop.classList.add("opacity-100");
                drawer.classList.remove("-translate-x-full");
            }, 20);
        }

        function closeSidebar() {
            backdrop.classList.remove("opacity-100");
            drawer.classList.add("-translate-x-full");
            setTimeout(() => {
                backdrop.classList.add("hidden");
            }, 300); // Wait for transition duration to end
        }

        // Event Listeners for drawer actions
        if (toggleBtn) toggleBtn.addEventListener("click", openSidebar);
        if (closeBtn) closeBtn.addEventListener("click", closeSidebar);
        if (backdrop) backdrop.addEventListener("click", closeSidebar);


        // --- 2. ACTIVE ROUTE CHECKER ---
        const currentPath = window.location.pathname;
        const navLinks = document.querySelectorAll('.nav-link');

        navLinks.forEach(link => {
            const linkHref = link.getAttribute('href');

            if (currentPath === linkHref || currentPath.endsWith(linkHref)) {
                link.classList.remove('text-slate-600', 'hover:bg-[#ce2424]', 'hover:text-white');
                link.classList.add('bg-[#ce2424]', 'text-white');

                const badge = link.querySelector('.notification-badge');
                if (badge) {
                    badge.classList.remove('bg-[#ce2424]', 'text-white');
                    badge.classList.add('bg-white', 'text-[#ce2424]');
                }
            }
        });
    });

    // --- 3. LIVE NOTIFICATION BADGE CONTROLLER ---
    async function updateNotificationBadges() {
        try {
            const res = await fetch("/BloodConnect/public/notification/unread-count");
            const data = await res.json();
            const badges = document.querySelectorAll(".notification-badge");

            badges.forEach(badge => {
                if (data.count > 0) {
                    badge.style.display = "flex";
                    badge.textContent = data.count;
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