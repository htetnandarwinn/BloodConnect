<div id="sidebarBackdrop" class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm z-40 hidden opacity-0 transition-opacity duration-300 lg:hidden"></div>

<aside id="sidebarDrawer" class="fixed inset-y-0 left-0 w-72 bg-white border-r border-slate-100 p-5 flex flex-col justify-between z-50 -translate-x-full lg:translate-x-0 lg:sticky lg:top-0 h-screen transition-transform duration-300 ease-in-out shrink-0">
    <div class="space-y-7">
        <!-- Brand Header -->
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3 px-2">
                <!-- Custom SVG Logo -->
                <div class="w-11 h-11 flex items-center justify-center shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="w-11 h-11">
                        <!-- Red Blood Drop Shape -->
                        <path d="M12 2.5C12 2.5 5 9.5 5 14.5C5 18.37 8.13 21.5 12 21.5C15.87 21.5 19 18.37 19 14.5C19 9.5 12 2.5 12 2.5Z" fill="#ce2424" />
                        <!-- White Heart Cutout perfectly centered inside -->
                        <path d="M12 17.15l-.38-.35C10.27 15.44 9 14.28 9 12.85c0-1.17.91-2.08 2.08-2.08.66 0 1.29.31 1.7.79.41-.48 1.04-.79 1.7-.79 1.17 0 2.08.91 2.08 2.08 0 1.43-1.27 2.59-2.62 3.96l-.38.34z" fill="#ffffff" />
                    </svg>
                </div>
                <div>
                    <span class="block font-black text-[#0b1325] text-lg tracking-tight leading-tight">BloodConnect</span>
                    <span class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mt-0.5">Donate Blood, Save Lives</span>
                </div>
            </div>
            <button id="closeSidebarBtn" class="lg:hidden p-2 rounded-xl hover:bg-slate-50 text-slate-400 hover:text-slate-600 transition-colors">✕</button>
        </div>

        <!-- Navigation Links -->
        <nav class="space-y-1.5" id="sidebarNav">

            <a href="/BloodConnect/public/patient/dashboard"
                class="nav-link flex items-center gap-3.5 px-4 py-3 rounded-xl font-bold text-base text-slate-600 hover:bg-[#ce2424] hover:text-white transition-all duration-200">
                <span class="text-xl">📊</span>
                Dashboard
            </a>

            <a href="/BloodConnect/public/patient/request-blood"
                class="nav-link flex items-center gap-3.5 px-4 py-3 rounded-xl font-bold text-base text-slate-600 hover:bg-[#ce2424] hover:text-white transition-all duration-200">
                <span class="text-xl">🩸</span>
                Request Blood
            </a>

            <a href="/BloodConnect/public/patient/search-donors"
                class="nav-link flex items-center gap-3.5 px-4 py-3 rounded-xl font-bold text-base text-slate-600 hover:bg-[#ce2424] hover:text-white transition-all duration-200">
                <span class="text-xl">🔍</span>
                Search Donors
            </a>

            <a href="/BloodConnect/public/patient/my-requests"
                class="nav-link flex items-center gap-3.5 px-4 py-3 rounded-xl font-bold text-base text-slate-600 hover:bg-[#ce2424] hover:text-white transition-all duration-200">
                <span class="text-xl">📋</span>
                My Requests
            </a>

            <a href="/BloodConnect/public/patient/notifications"
                class="nav-link flex items-center justify-between px-4 py-3 rounded-xl font-bold text-base text-slate-600 hover:bg-[#ce2424] hover:text-white transition-all duration-200">

                <div class="flex items-center gap-3.5">
                    <span class="text-xl">🔔</span>
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

        </nav>
    </div>

    <!-- Footer Actions -->
    <div class="border-t border-slate-100 pt-4">
        <a href="/BloodConnect/public/logout" class="block">
            <button class="w-full flex items-center gap-3.5 px-4 py-3 rounded-xl font-bold text-base text-slate-600 hover:bg-[#ce2424] hover:text-white transition-all duration-200">
                <span class="text-xl">🚪</span>
                Logout
            </button>
        </a>
    </div>
</aside>

<!-- Active Route & Sidebar Toggle JavaScript -->
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