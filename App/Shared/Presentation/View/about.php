<?php
$features = [
    ['icon' => 'fa-bolt', 'title' => 'Real-Time Matching', 'desc' => 'Our intelligent system connects patients with compatible donors instantly, eliminating critical wait times during emergencies.'],
];
?>
<style>
    @keyframes fadeSlideUp {
        0% { opacity: 0; transform: translateY(30px); }
        100% { opacity: 1; transform: translateY(0); }
    }
    @keyframes slideInRight {
        0% { opacity: 0; transform: translateX(30px); }
        100% { opacity: 1; transform: translateX(0); }
    }
    @keyframes counterGlow {
        0%, 100% { text-shadow: 0 0 20px rgba(220, 38, 38, 0.1); }
        50% { text-shadow: 0 0 40px rgba(220, 38, 38, 0.25); }
    }
    .about-header { animation: fadeSlideUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
    .about-card { opacity: 0; animation: fadeSlideUp 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
    .about-card:hover .card-icon { transform: scale(1.1) rotate(-6deg); }
    .card-icon { transition: transform 0.4s cubic-bezier(0.16, 1, 0.3, 1); }
    .badge-pulse { animation: badgePulse 2.5s ease-in-out infinite; }
    @keyframes badgePulse {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.04); }
    }
    @keyframes gradientFlow {
        0% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
        100% { background-position: 0% 50%; }
    }
    .gradient-text { background: linear-gradient(135deg, #dc2626, #ef4444, #dc2626); background-size: 200% auto; -webkit-background-clip: text; -webkit-text-fill-color: transparent; animation: gradientFlow 4s ease infinite; }
</style>

<section class="relative overflow-hidden pt-6 pb-24 lg:pt-10 lg:pb-36">
    <div class="absolute inset-0 pointer-events-none z-0">
        <div class="absolute top-0 left-0 w-96 h-96 bg-gradient-to-br from-red-50/60 to-transparent rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 right-0 w-80 h-80 bg-gradient-to-tl from-red-50/40 to-transparent rounded-full blur-3xl"></div>
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-full max-w-5xl opacity-20 select-none">
            <svg viewBox="0 0 700 500" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg" class="w-full h-auto">
                <path d="M0,200 C150,50 350,250 700,100 L700,500 L0,500 Z" fill="#FCEAEF" />
            </svg>
        </div>
    </div>

    <div class="relative z-10 max-w-[1440px] mx-auto w-full px-6 md:px-12">
        <div class="max-w-2xl mb-12 about-header">
            <span class="badge-pulse inline-flex items-center gap-2 bg-red-50 text-red-600 px-5 py-2 rounded-full text-sm font-bold tracking-wide uppercase border border-red-100 mb-5 shadow-sm">
                <i class="fa-solid fa-heart-pulse"></i> Who We Are
            </span>
            <h2 class="font-black text-4xl md:text-5xl lg:text-6xl text-gray-900 tracking-tight leading-tight">About <span class="gradient-text">Us</span></h2>
            <div class="h-1 w-16 bg-red-600 rounded-full mt-5 shadow-sm shadow-red-600/30"></div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-16 items-start">
            <div class="lg:col-span-7 space-y-6">
                <div class="about-card bg-white border border-gray-200/70 rounded-3xl p-8 md:p-10 shadow-xl shadow-gray-100/40 hover:shadow-2xl hover:shadow-gray-200/50 hover:border-red-100/70 transition-all duration-500 transform hover:-translate-y-1" style="animation-delay: 0.1s;">
                    <div class="flex items-center gap-3.5 mb-5">
                        <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-red-500 to-red-700 text-white flex items-center justify-center text-lg shadow-lg shadow-red-600/20">
                            <i class="fa-solid fa-bullseye"></i>
                        </div>
                        <h3 class="font-black text-2xl text-gray-900 tracking-tight">Our Core Mission</h3>
                    </div>
                    <p class="text-gray-500 font-medium text-base md:text-lg leading-relaxed">
                        At <span class="text-red-600 font-bold">BloodConnect</span>, we are bridging the critical gap between life-saving blood donors and the individuals, healthcare providers, and local communities who urgently need them.
                    </p>
                    <div class="mt-6 flex flex-wrap gap-3">
                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-red-50 text-red-600 rounded-lg text-xs font-bold"><i class="fa-solid fa-check-circle"></i> Real-Time</span>
                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-red-50 text-red-600 rounded-lg text-xs font-bold"><i class="fa-solid fa-check-circle"></i> Verified</span>
                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-red-50 text-red-600 rounded-lg text-xs font-bold"><i class="fa-solid fa-check-circle"></i> Secure</span>
                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-red-50 text-red-600 rounded-lg text-xs font-bold"><i class="fa-solid fa-check-circle"></i> Community-Driven</span>
                    </div>
                </div>

                <?php foreach ($features as $i => $feature): ?>
                    <div class="about-card group bg-white border border-gray-200/70 rounded-2xl p-6 md:p-8 shadow-sm hover:shadow-xl hover:border-red-200/50 hover:bg-red-50/20 transition-all duration-300 transform hover:-translate-y-0.5" style="animation-delay: <?= 0.15 + ($i * 0.08) ?>s;">
                        <div class="flex items-start gap-5">
                            <div class="card-icon w-12 h-12 rounded-xl bg-red-50 text-red-600 flex items-center justify-center text-lg shrink-0 group-hover:bg-red-600 group-hover:text-white transition-colors duration-300">
                                <i class="fa-solid <?= $feature['icon'] ?>"></i>
                            </div>
                            <div class="flex-1 min-w-0">
                                <h3 class="font-bold text-lg text-gray-900 tracking-tight mb-2"><?= $feature['title'] ?></h3>
                                <p class="text-gray-500 font-medium text-base leading-relaxed"><?= $feature['desc'] ?></p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="lg:col-span-5 flex flex-col items-center lg:items-end relative pt-2" style="animation: slideInRight 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards;">
                <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-64 h-64 bg-red-400/10 rounded-full blur-3xl pointer-events-none"></div>

                <div class="relative w-72 h-72 md:w-80 md:h-80 mb-6 flex items-center justify-center group select-none mr-0 lg:mr-4">
                    <div class="absolute inset-0 rounded-[2.5rem] border-2 border-dashed border-red-200/80 group-hover:border-red-500/40 transition-all duration-500 animate-[spin_50s_linear_infinite]"></div>
                    <div class="w-56 h-56 md:w-64 md:h-64 bg-white/70 backdrop-blur-md rounded-[2.5rem] shadow-xl shadow-gray-200/50 border border-white/80 flex items-center justify-center p-6 transition-all duration-500 transform group-hover:scale-105 group-hover:shadow-2xl group-hover:shadow-red-100/40 animate-[bounce_6s_infinite_ease-in-out]">
                        <svg viewBox="0 0 240 260" xmlns="http://www.w3.org/2000/svg" class="w-full h-auto drop-shadow-[0_12px_20px_rgba(200,16,46,0.25)] max-w-[160px]">
                            <path d="M120,30 C150,68 178,112 178,140 C178,170 152,192 120,192 C88,192 62,170 62,140 C62,112 90,68 120,30 Z" fill="url(#aboutDropGradFinal)" />
                            <path d="M120,120 L120,160 M100,140 L140,140" stroke="#FFFFFF" stroke-width="12" stroke-linecap="round" />
                            <defs><linearGradient id="aboutDropGradFinal" x1="0%" y1="0%" x2="100%" y2="100%"><stop offset="0%" stop-color="#EF4444" /><stop offset="100%" stop-color="#B91C1C" /></linearGradient></defs>
                        </svg>
                    </div>
                </div>

                <div class="w-full max-w-md bg-white/80 backdrop-blur-sm border border-gray-200/60 hover:border-red-200 rounded-2xl p-5 flex gap-4 items-center text-left shadow-lg shadow-gray-100/40 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                    <div class="w-12 h-12 rounded-full bg-gradient-to-br from-red-50 to-red-100/60 text-red-600 flex items-center justify-center flex-shrink-0 border border-red-100 shadow-inner">
                        <i class="fa-solid fa-droplet text-base animate-pulse"></i>
                    </div>
                    <div>
                        <h4 class="font-black text-base text-gray-900 mb-0.5">Empowering Local Communities</h4>
                        <p class="text-gray-500 font-medium text-sm leading-relaxed">
                            We support localized health ecosystems by making data fully transparent and accessible instantly when time is of the absolute essence.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
