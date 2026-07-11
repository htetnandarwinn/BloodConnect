<?php
$sections = [
    ['icon' => 'fa-file-circle-check', 'title' => 'Acceptance of Terms', 'content' => 'By accessing or using BloodConnect, you agree to be bound by these Terms of Service. If you do not agree with any part of these terms, you must not use our platform. Continued use after policy updates constitutes acceptance of revised terms.'],
    ['icon' => 'fa-user-plus', 'title' => 'User Accounts', 'content' => 'You are responsible for maintaining the confidentiality of your account credentials and for all activities under your account. You must provide accurate, current, and complete information during registration.'],
    ['icon' => 'fa-droplet', 'title' => 'Donor Responsibilities', 'content' => 'Donors must be medically eligible to donate blood. You agree to provide honest health information and understand that blood donation is a voluntary act with no monetary compensation through our platform.'],
    ['icon' => 'fa-hand-holding-heart', 'title' => 'Patient Responsibilities', 'content' => 'Patients agree to use requested blood donations responsibly and only for legitimate medical needs. Misrepresentation of medical urgency may result in account suspension or permanent removal from the platform.'],
    ['icon' => 'fa-scale-balanced', 'title' => 'Platform Usage Rules', 'content' => 'You agree not to misuse the platform for spam, fraudulent requests, harassment, or any illegal activity. We reserve the right to suspend or terminate accounts that violate these rules without prior notice.'],
];
?>
<style>
    @keyframes badgePulse {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.04); }
    }
    .animate-badge { animation: badgePulse 2.5s ease-in-out infinite; }
    @keyframes softReveal {
        0% { opacity: 0; transform: translateY(20px); }
        100% { opacity: 1; transform: translateY(0); }
    }
    .terms-card { opacity: 0; animation: softReveal 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
    .terms-card:hover .terms-icon { transform: scale(1.1) rotate(-4deg); }
    .terms-icon { transition: transform 0.3s cubic-bezier(0.16, 1, 0.3, 1); }
    .terms-card:hover .terms-line { width: 100%; }
    .terms-line { width: 0; height: 2px; transition: width 0.4s cubic-bezier(0.16, 1, 0.3, 1); }
</style>

<section class="relative overflow-hidden pt-6 pb-24 lg:pt-10 lg:pb-36">
    <div class="absolute inset-0 pointer-events-none z-0">
        <div class="absolute top-0 left-1/4 w-96 h-96 bg-gradient-to-br from-red-50/60 to-transparent rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 right-1/4 w-80 h-80 bg-gradient-to-tl from-red-50/40 to-transparent rounded-full blur-3xl"></div>
    </div>

    <div class="relative z-10 max-w-[1440px] mx-auto w-full px-6 md:px-12">
        <div class="text-center mb-12 lg:mb-14" style="animation: softReveal 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards;">
            <span class="animate-badge inline-flex items-center gap-2 bg-red-50 text-red-600 px-5 py-2 rounded-full text-sm font-bold tracking-wide uppercase border border-red-100 mb-5 shadow-sm">
                <i class="fa-solid fa-file-contract"></i> Legal Agreement
            </span>
            <h2 class="font-black text-4xl md:text-5xl lg:text-6xl text-gray-900 tracking-tight leading-tight">Terms of Service</h2>
            <div class="h-1 w-16 bg-red-600 rounded-full mx-auto mt-5 shadow-sm shadow-red-600/30"></div>
            <p class="text-xs text-gray-400 font-medium mt-4">Last updated: July 2026</p>
        </div>

        <div class="max-w-4xl mx-auto space-y-4">
            <?php foreach ($sections as $i => $section): ?>
                <div class="terms-card group bg-white border border-gray-200/70 rounded-2xl p-6 md:p-8 shadow-sm hover:shadow-lg hover:border-red-200/40 hover:bg-red-50/20 transition-all duration-300" style="animation-delay: <?= $i * 0.08 ?>s;">
                    <div class="flex items-start gap-4">
                        <div class="terms-icon w-11 h-11 rounded-xl bg-red-50 text-red-600 flex items-center justify-center text-base shrink-0 mt-0.5 group-hover:bg-red-600 group-hover:text-white transition-colors duration-300">
                            <i class="fa-solid <?= $section['icon'] ?>"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center justify-between gap-4">
                                <h3 class="font-bold text-lg text-gray-900 tracking-tight"><?= htmlspecialchars($section['title']) ?></h3>
                                <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">0<?= $i + 1 ?></span>
                            </div>
                            <div class="terms-line bg-red-200 rounded-full mt-2"></div>
                            <p class="text-gray-500 font-medium text-base leading-relaxed mt-3"><?= htmlspecialchars($section['content']) ?></p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
