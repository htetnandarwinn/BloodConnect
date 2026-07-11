<?php
$faqs = [
    ['icon' => 'fa-droplet', 'q' => 'What is BloodConnect?', 'a' => 'BloodConnect is a digital platform that connects voluntary blood donors with patients and healthcare providers in real time, streamlining the process of finding and matching blood types during emergencies.'],
    ['icon' => 'fa-user-plus', 'q' => 'Who can register as a donor?', 'a' => 'Any healthy individual aged 18–65 who meets the standard blood donation eligibility criteria can register as a donor on BloodConnect.'],
    ['icon' => 'fa-arrows-spin', 'q' => 'How does the matching process work?', 'a' => 'When a patient posts a blood request, our system automatically notifies donors with matching blood groups in the area. Donors can accept requests directly through the platform.'],
    ['icon' => 'fa-shield-halved', 'q' => 'Is my personal information safe?', 'a' => 'Absolutely. We use industry-standard encryption and strict data protection protocols to ensure your personal and medical information remains confidential and secure.'],
    ['icon' => 'fa-clock', 'q' => 'Can I update my availability status?', 'a' => 'Yes. Donors can mark themselves as available or unavailable at any time. The system also automatically updates your status based on donation eligibility periods.'],
];
?>
<style>
    @keyframes badgePulse {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.04); }
    }
    .animate-badge { animation: badgePulse 2.5s ease-in-out infinite; }
    .faq-answer { display: grid; grid-template-rows: 0fr; transition: grid-template-rows 0.4s cubic-bezier(0.16, 1, 0.3, 1); }
    .faq-item.open .faq-answer { grid-template-rows: 1fr; }
    .faq-answer > div { overflow: hidden; }
    .faq-item.open .faq-chevron { transform: rotate(180deg); background-color: rgb(220 38 38); color: white; }
    .faq-chevron { transition: all 0.35s cubic-bezier(0.16, 1, 0.3, 1); }
    .faq-item.open { border-color: rgba(220, 38, 38, 0.25) !important; box-shadow: 0 4px 20px -8px rgba(220, 38, 38, 0.12); }
</style>

<section class="relative overflow-hidden pt-6 pb-24 lg:pt-10 lg:pb-36">
    <div class="absolute inset-0 pointer-events-none z-0">
        <div class="absolute top-0 left-1/4 w-96 h-96 bg-gradient-to-br from-red-50/60 to-transparent rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 right-1/4 w-80 h-80 bg-gradient-to-tl from-red-50/40 to-transparent rounded-full blur-3xl"></div>
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-full max-w-5xl opacity-20 select-none">
            <svg viewBox="0 0 700 500" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg" class="w-full h-auto">
                <path d="M0,300 C150,80 350,350 700,150 L700,500 L0,500 Z" fill="#FCEAEF" />
            </svg>
        </div>
    </div>

    <div class="relative z-10 max-w-[1440px] mx-auto w-full px-6 md:px-12">
        <div class="text-center mb-14 lg:mb-16">
            <span class="animate-badge inline-flex items-center gap-2 bg-red-50 text-red-600 px-5 py-2 rounded-full text-sm font-bold tracking-wide uppercase border border-red-100 mb-5 shadow-sm">
                <i class="fa-solid fa-circle-question"></i> Got Questions?
            </span>
            <h2 class="font-black text-4xl md:text-5xl lg:text-6xl text-gray-900 tracking-tight leading-tight">
                Frequently Asked Questions
            </h2>
            <p class="text-gray-500 font-medium text-base md:text-lg mt-4 max-w-xl mx-auto leading-relaxed">
                Everything you need to know about BloodConnect and how it works.
            </p>
            <div class="h-1 w-16 bg-red-600 rounded-full mx-auto mt-5 shadow-sm shadow-red-600/30"></div>
        </div>

        <div class="max-w-5xl mx-auto space-y-4">
            <?php foreach ($faqs as $i => $faq): ?>
                <div class="faq-item group bg-white border border-gray-200/70 rounded-2xl shadow-sm hover:shadow-lg transition-all duration-300 cursor-pointer select-none" onclick="this.classList.toggle('open')">
                    <div class="flex items-center justify-between gap-4 px-6 py-5">
                        <div class="flex items-center gap-4 min-w-0">
                            <span class="w-9 h-9 rounded-xl bg-red-50 text-red-600 flex items-center justify-center text-sm shrink-0 group-hover:bg-red-600 group-hover:text-white transition-colors duration-300"><i class="fa-solid <?= $faq['icon'] ?>"></i></span>
                            <h3 class="font-bold text-base md:text-lg text-gray-900 tracking-tight leading-snug"><?= htmlspecialchars($faq['q']) ?></h3>
                        </div>
                        <div class="faq-chevron shrink-0 w-8 h-8 rounded-lg bg-gray-100 text-gray-500 flex items-center justify-center text-xs">
                            <i class="fa-solid fa-chevron-down"></i>
                        </div>
                    </div>
                    <div class="faq-answer">
                        <div>
                            <div class="px-6 pb-6 pt-1 border-t border-gray-100">
                                <p class="text-gray-500 font-medium text-base leading-relaxed"><?= htmlspecialchars($faq['a']) ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>


    </div>
</section>
