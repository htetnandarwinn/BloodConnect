<?php
$sections = [
    ['icon' => 'fa-shield-halved', 'title' => 'Confidential Health Data', 'content' => 'Your blood type, medical history, and donation records are sensitive health details that we encrypt and protect with the highest security standards because your medical privacy is a fundamental right.'],
    ['icon' => 'fa-handshake', 'title' => 'Trust in Emergency Matching', 'content' => 'When you post or accept a blood request, we only share the minimum information required for the match — nothing more — because your trust is what makes every life saved on this platform possible.'],
    ['icon' => 'fa-lock', 'title' => 'Secure Communication', 'content' => 'All notifications, messages, and match alerts are transmitted over encrypted channels so donors and patients can coordinate with confidence, knowing their contact details remain private.'],
    ['icon' => 'fa-user-shield', 'title' => 'Identity Verification', 'content' => 'We verify every user to prevent fraudulent requests and ensure only genuine donors and patients access the platform, keeping the entire BloodConnect community safe and trustworthy.'],
    ['icon' => 'fa-clock', 'title' => 'Data Retention Control', 'content' => 'You remain in full control of your data — delete your account anytime and your personal information is permanently removed within 30 days, retaining only what is legally required.'],
    ['icon' => 'fa-scale-balanced', 'title' => 'Transparent Policy', 'content' => 'We never sell or share your personal information with advertisers or third parties, and our data practices are clearly documented so you always know exactly how your information is protected.'],
];
?>
<style>
    @keyframes badgePulse {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.04); }
    }
    .animate-badge { animation: badgePulse 2.5s ease-in-out infinite; }
    .privacy-card:hover .privacy-icon { transform: scale(1.1) rotate(-4deg); }
    .privacy-icon { transition: transform 0.3s cubic-bezier(0.16, 1, 0.3, 1); }
</style>

<section class="relative overflow-hidden pt-6 pb-24 lg:pt-10 lg:pb-36">
    <div class="absolute inset-0 pointer-events-none z-0">
        <div class="absolute top-0 right-0 w-96 h-96 bg-gradient-to-br from-red-50/60 to-transparent rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 left-0 w-80 h-80 bg-gradient-to-tl from-red-50/40 to-transparent rounded-full blur-3xl"></div>
    </div>

    <div class="relative z-10 max-w-[1440px] mx-auto w-full px-6 md:px-12">
        <div class="max-w-3xl mb-12 lg:mb-14">
            <span class="animate-badge inline-flex items-center gap-2 bg-red-50 text-red-600 px-5 py-2 rounded-full text-sm font-bold tracking-wide uppercase border border-red-100 mb-5 shadow-sm">
                <i class="fa-solid fa-shield-halved"></i> Your Privacy Matters
            </span>
            <h2 class="font-black text-4xl md:text-5xl lg:text-6xl text-gray-900 tracking-tight leading-tight">Privacy Policy</h2>
            <p class="text-gray-500 font-medium text-base md:text-lg mt-4 max-w-2xl leading-relaxed">
                BloodConnect is committed to protecting your privacy and personal information.
            </p>
            <div class="h-1 w-16 bg-red-600 rounded-full mt-5 shadow-sm shadow-red-600/30"></div>
            <p class="text-xs text-gray-400 font-medium mt-4">Last updated: July 2026</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
            <?php foreach ($sections as $i => $section): ?>
                <div class="privacy-card group bg-white border border-gray-200/70 rounded-2xl p-6 md:p-8 shadow-sm hover:shadow-xl hover:border-red-200/50 hover:bg-red-50/20 transition-all duration-300 transform hover:-translate-y-1">
                    <div class="privacy-icon w-12 h-12 rounded-xl bg-red-50 text-red-600 flex items-center justify-center text-lg mb-5 group-hover:bg-red-600 group-hover:text-white transition-colors duration-300">
                        <i class="fa-solid <?= $section['icon'] ?>"></i>
                    </div>
                    <h3 class="font-bold text-lg text-gray-900 tracking-tight mb-3"><?= htmlspecialchars($section['title']) ?></h3>
                    <p class="text-gray-500 font-medium text-base leading-relaxed"><?= htmlspecialchars($section['content']) ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
