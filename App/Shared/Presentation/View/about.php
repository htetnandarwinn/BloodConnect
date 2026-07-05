<?php
// C:\xampp_new\htdocs\BloodConnect\App\Shared\Presentation\View\about.php
?>

<!-- FontAwesome CDN Dependency for Icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<!-- ============ REGULAR MODERN CLASSIC INTERIOR VIEW CONTENT ============ -->
<!-- Expanded the bottom padding (pb-24 lg:pb-36) to give the downward space requested in edited-image_3.png -->
<section class="relative overflow-hidden pt-6 pb-24 lg:pt-10 lg:pb-36 bg-gray-50">

    <!-- Trending Modern Background Geometric Layer -->
    <div class="absolute left-0 bottom-0 w-full max-w-4xl pointer-events-none opacity-30 lg:opacity-70 z-0 select-none animate-pulse duration-[10000ms]">
        <svg viewBox="0 0 700 500" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg" class="w-full h-auto block">
            <path d="M0,200 C150,50 350,250 700,100 L700,500 L0,500 Z" fill="#FCEAEF" />
        </svg>
    </div>

    <!-- Main Outer Wrapper -->
    <div class="relative z-10 max-w-[1440px] mx-auto w-full px-6 md:px-12">

        <!-- SECTION HEADER BLOCK -->
        <div class="max-w-2xl mb-10 lg:mb-12">
            <h2 class="font-black text-4xl md:text-5xl text-gray-900 tracking-tight">About Us</h2>
            <div class="h-1 w-16 bg-red-600 rounded-full mt-4 shadow-sm shadow-red-600/30"></div>
        </div>

        <!-- MAIN DUAL COLUMN CONFIGURATION MATRIX -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-16 items-start">

            <!-- Left Side Column: Core Mission Cards Stack -->
            <div class="lg:col-span-7 space-y-6">

                <!-- Master Core Info Wrapper Card -->
                <div class="group bg-white border border-gray-150/90 rounded-3xl p-8 md:p-10 shadow-xl shadow-gray-100/40 hover:shadow-2xl hover:shadow-gray-200/50 hover:border-red-100/70 transition-all duration-500 transform hover:-translate-y-1">

                    <!-- Top Segment: Core Mission -->
                    <div class="mb-8 relative">
                        <div class="flex items-center gap-3.5 mb-4">
                            <div class="w-10 h-10 rounded-xl bg-red-600 text-white flex items-center justify-center text-md shadow-sm transition-all duration-300">
                                <i class="fa-solid fa-bullseye"></i>
                            </div>
                            <h3 class="font-black text-2xl text-gray-900 tracking-tight">Our Core Mission</h3>
                        </div>
                        <p class="text-gray-500 font-medium text-base md:text-lg leading-relaxed">
                            At <span class="text-red-600 font-bold tracking-tight group-hover:text-red-700 transition-colors">BloodConnect</span>, we are bridging the critical gap between life-saving blood donors and the individuals, healthcare providers, and local communities who urgently need them.
                        </p>
                    </div>

                    <!-- Divider Line -->
                    <div class="h-px bg-gradient-to-r from-gray-100 via-gray-200/60 to-gray-100 my-6"></div>

                    <!-- Bottom Segment: How We Drive Change -->
                    <div class="relative">
                        <div class="flex items-center gap-3.5 mb-4">
                            <div class="w-10 h-10 rounded-xl bg-rose-600 text-white flex items-center justify-center text-md shadow-sm transition-all duration-300">
                                <i class="fa-solid fa-bolt-lightning"></i>
                            </div>
                            <h3 class="font-black text-2xl text-gray-900 tracking-tight">How We Drive Change</h3>
                        </div>
                        <p class="text-gray-500 font-medium text-base md:text-lg leading-relaxed">
                            By leveraging technology, real-time routing mechanisms, and simplified peer verification networks, we remove the friction and delay typically found in critical urgent scenarios.
                        </p>
                    </div>

                </div>

            </div>

            <!-- Right Side Column: Modernized Visual Graphics Stack Layout -->
            <div class="lg:col-span-5 flex flex-col items-center lg:items-end relative pt-2">

                <!-- Atmospheric Background Glow Ambient Filters -->
                <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-64 h-64 bg-red-400/10 rounded-full blur-3xl pointer-events-none"></div>

                <!-- Core Artwork Display Container Box -->
                <div class="relative w-72 h-72 md:w-80 md:h-80 mb-6 flex items-center justify-center group select-none mr-0 lg:mr-4">

                    <!-- Rotating Outer Tracking Accent Border Ring -->
                    <div class="absolute inset-0 rounded-[2.5rem] border-2 border-dashed border-red-200/80 group-hover:border-red-500/40 transition-all duration-500 animate-[spin_50s_linear_infinite]"></div>

                    <!-- Glassmorphism Droplet Card Framework -->
                    <div class="w-56 h-56 md:w-64 md:h-64 bg-white/70 backdrop-blur-md rounded-[2.5rem] shadow-xl shadow-gray-200/50 border border-white/80 flex items-center justify-center p-6 transition-all duration-500 transform group-hover:scale-105 group-hover:shadow-2xl group-hover:shadow-red-100/40 animate-[bounce_6s_infinite_ease-in-out]">
                        <svg viewBox="0 0 240 260" xmlns="http://www.w3.org/2000/svg" class="w-full h-auto drop-shadow-[0_12px_20px_rgba(200,16,46,0.25)] max-w-[160px]">
                            <path d="M120,30 C150,68 178,112 178,140 C178,170 152,192 120,192 C88,192 62,170 62,140 C62,112 90,68 120,30 Z" fill="url(#aboutDropGradFinal)" />
                            <path d="M120,120 L120,160 M100,140 L140,140" stroke="#FFFFFF" stroke-width="12" stroke-linecap="round" />
                            <defs>
                                <linearGradient id="aboutDropGradFinal" x1="0%" y1="0%" x2="100%" y2="100%">
                                    <stop offset="0%" stop-color="#EF4444" />
                                    <stop offset="100%" stop-color="#B91C1C" />
                                </linearGradient>
                            </defs>
                        </svg>
                    </div>
                </div>

                <!-- Floating Bottom Feature Card Block Component -->
                <div class="w-full max-w-md bg-white/80 backdrop-blur-sm border border-gray-200/60 hover:border-red-200 rounded-2xl p-5 flex gap-4 items-center text-left shadow-lg shadow-gray-100/40 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                    <div class="w-12 h-12 rounded-full bg-gradient-to-br from-red-50 to-red-100/60 text-red-600 flex items-center justify-center flex-shrink-0 border border-red-100 relative overflow-hidden shadow-inner">
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