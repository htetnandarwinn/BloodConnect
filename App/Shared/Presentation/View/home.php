<?php
// C:\xampp_new\htdocs\BloodConnect\App\Shared\Presentation\View\home.php
?>

<!-- FontAwesome & Google Fonts for beautiful text weights -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<!-- ============ REGULAR MODERN CLASSIC INTERIOR VIEW CONTENT ============ -->
<section class="relative overflow-hidden py-10 lg:py-16 bg-gray-50">

    <!-- Animated Trendy Background Geometric Blobs -->
    <div class="absolute right-0 top-0 w-full max-w-3xl pointer-events-none opacity-30 lg:opacity-90 z-0 select-none animate-pulse duration-[8000ms]">
        <svg viewBox="0 0 700 500" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg" class="w-full h-auto block">
            <path d="M700,100 C500,-20 300,200 0,400 L700,500 Z" fill="#FCEAEF" />
        </svg>
    </div>
    <div class="absolute left-10 bottom-10 w-72 h-72 bg-red-50/40 rounded-full filter blur-3xl pointer-events-none z-0"></div>

    <!-- Main Outer Wrapper -->
    <div class="relative z-10 max-w-[1440px] mx-auto w-full px-6 md:px-12">

        <!-- HERO SEGMENT GRID -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-20 items-center min-h-[550px] mb-20">

            <!-- Left Grid: Brand Typography Catchphrase -->
            <div class="lg:col-span-7 flex flex-col items-center lg:items-start text-center lg:text-left space-y-6">
                <span class="inline-flex items-center gap-2 bg-red-50 text-red-600 px-4 py-1.5 rounded-full text-sm font-bold tracking-wide uppercase border border-red-100 animate-bounce">
                    <i class="fa-solid fa-heart-pulse"></i> Every Drop Matters
                </span>

                <h1 class="font-black text-4xl md:text-6xl text-gray-900 tracking-tight leading-none">
                    Connecting Donors.<br>
                    <span class="text-red-600 relative inline-block mt-2">
                        Saving Lives.
                        <span class="absolute bottom-1 left-0 w-full h-2 bg-red-100 -z-10 rounded-full"></span>
                    </span>
                </h1>

                <p class="text-base md:text-xl text-gray-500 font-medium max-w-xl leading-relaxed">
                    BloodConnect is a secure and reliable platform that connects blood donors with patients, making it easier to find life-saving blood when it is needed most.
                </p>

                <!-- Call to Action Buttons with Hover Pop Effects -->
                <div class="flex flex-col sm:flex-row gap-4 pt-4 w-full sm:w-auto">
                    <a href="<?= $basePath ?>/search" class="group bg-red-600 hover:bg-red-700 text-white font-bold py-4 px-8 rounded-xl text-lg shadow-lg shadow-red-600/20 active:scale-[0.99] transition-all duration-200 flex items-center justify-center gap-2 transform hover:-translate-y-0.5">
                        <span>Find Blood Requests</span>
                        <i class="fa-solid fa-arrow-right text-sm transform group-hover:translate-x-1 transition-transform"></i>
                    </a>
                    <a href="<?= $basePath ?>/register?role=donor" class="bg-white border border-gray-300 hover:border-gray-400 text-gray-800 font-bold py-4 px-8 rounded-xl text-lg shadow-sm hover:shadow-md active:scale-[0.99] transition-all duration-200 text-center transform hover:-translate-y-0.5">
                        Become a Donor
                    </a>
                </div>
            </div>

            <!-- Right Grid: Modern Hero Interactive Visual Asset -->
            <div class="lg:col-span-5 flex justify-center lg:justify-end w-full relative">
                <!-- Outer floating ring container -->
                <div class="relative w-72 h-72 md:w-96 md:h-96 bg-gradient-to-tr from-red-50/80 to-white rounded-3xl p-8 flex items-center justify-center shadow-xl shadow-gray-200/40 border border-white transform transition duration-500 hover:rotate-2">
                    <svg viewBox="0 0 240 260" xmlns="http://www.w3.org/2000/svg" class="w-full h-auto drop-shadow-xl max-w-[240px] animate-pulse duration-[3000ms]">
                        <path d="M120,30 C150,68 178,112 178,140 C178,170 152,192 120,192 C88,192 62,170 62,140 C62,112 90,68 120,30 Z" fill="#C8102E" />
                        <rect x="110" y="108" width="20" height="74" rx="7" fill="#FFFFFF" />
                        <rect x="83" y="135" width="74" height="20" rx="7" fill="#FFFFFF" />
                    </svg>

                    <!-- Decorative Floating Badge - Live Donation Counter -->
                    <div class="absolute -bottom-4 -left-4 bg-white border border-gray-150 rounded-2xl p-4 shadow-lg flex items-center gap-3 transform animate-bounce duration-[4000ms]">
                        <div class="w-10 h-10 rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center font-bold">
                            <i class="fa-solid fa-droplet"></i>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400 font-bold uppercase tracking-wider">Lives Impacted</p>
                            <p class="text-sm font-black text-gray-800"><span class="counter-value" data-target="<?= $successful_donations ?>">0</span>+ Donations</p>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- STATISTICS COUNTER ROW -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-16 relative z-10">
            <div class="group bg-white border border-gray-200/60 rounded-2xl p-6 text-center shadow-sm hover:shadow-lg hover:border-red-200 hover:bg-red-50/30 transition-all duration-300 transform hover:-translate-y-1">
                <div class="w-10 h-10 mx-auto mb-3 rounded-xl bg-red-50 text-red-600 flex items-center justify-center group-hover:bg-red-600 group-hover:text-white transition-colors duration-300">
                    <i class="fa-solid fa-droplet text-lg"></i>
                </div>
                <span class="text-3xl md:text-4xl font-black text-red-600"><span class="counter-value" data-target="<?= $successful_donations ?>">0</span></span>
                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mt-1">Successful Donations</p>
            </div>
            <div class="group bg-white border border-gray-200/60 rounded-2xl p-6 text-center shadow-sm hover:shadow-lg hover:border-red-200 hover:bg-red-50/30 transition-all duration-300 transform hover:-translate-y-1">
                <div class="w-10 h-10 mx-auto mb-3 rounded-xl bg-red-50 text-red-600 flex items-center justify-center group-hover:bg-red-600 group-hover:text-white transition-colors duration-300">
                    <i class="fa-solid fa-hand-holding-heart text-lg"></i>
                </div>
                <span class="text-3xl md:text-4xl font-black text-red-600"><span class="counter-value" data-target="<?= $total_donors ?>">0</span></span>
                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mt-1">Active Donors</p>
            </div>
            <div class="group bg-white border border-gray-200/60 rounded-2xl p-6 text-center shadow-sm hover:shadow-lg hover:border-red-200 hover:bg-red-50/30 transition-all duration-300 transform hover:-translate-y-1">
                <div class="w-10 h-10 mx-auto mb-3 rounded-xl bg-red-50 text-red-600 flex items-center justify-center group-hover:bg-red-600 group-hover:text-white transition-colors duration-300">
                    <i class="fa-solid fa-users text-lg"></i>
                </div>
                <span class="text-3xl md:text-4xl font-black text-red-600"><span class="counter-value" data-target="<?= $total_users ?>">0</span></span>
                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mt-1">Total Users</p>
            </div>
            <div class="group bg-white border border-gray-200/60 rounded-2xl p-6 text-center shadow-sm hover:shadow-lg hover:border-red-200 hover:bg-red-50/30 transition-all duration-300 transform hover:-translate-y-1">
                <div class="w-10 h-10 mx-auto mb-3 rounded-xl bg-red-50 text-red-600 flex items-center justify-center group-hover:bg-red-600 group-hover:text-white transition-colors duration-300">
                    <i class="fa-solid fa-truck-medical text-lg"></i>
                </div>
                <span class="text-3xl md:text-4xl font-black text-red-600">24/7</span>
                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mt-1">Emergency Support</p>
            </div>
        </div>

        <!-- QUICK ACTION CARD MODULES -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-20 relative z-10">

            <!-- Card 1 -->
            <div class="group bg-white border border-gray-200/80 rounded-2xl p-8 shadow-sm hover:shadow-xl hover:border-red-200 transition-all duration-300 transform hover:-translate-y-1">
                <div class="w-12 h-12 rounded-xl bg-red-50 text-red-600 flex items-center justify-center mb-6 group-hover:bg-red-600 group-hover:text-white transition-colors duration-300">
                    <i class="fa-solid fa-magnifying-glass text-xl"></i>
                </div>
                <h3 class="font-bold text-xl text-gray-900 mb-2">Search Donors</h3>
                <p class="text-gray-500 font-medium text-base leading-relaxed">
                    Filter verified active blood donors instantly within your geographical radius zone parameters.
                </p>
            </div>

            <!-- Card 2 -->
            <div class="group bg-white border border-gray-200/80 rounded-2xl p-8 shadow-sm hover:shadow-xl hover:border-red-200 transition-all duration-300 transform hover:-translate-y-1">
                <div class="w-12 h-12 rounded-xl bg-red-50 text-red-600 flex items-center justify-center mb-6 group-hover:bg-red-600 group-hover:text-white transition-colors duration-300">
                    <i class="fa-solid fa-bullhorn text-xl"></i>
                </div>
                <h3 class="font-bold text-xl text-gray-900 mb-2">Post Emergency Request</h3>
                <p class="text-gray-500 font-medium text-base leading-relaxed">
                    Broadcast a tracking request to all matching groups across our database for swift turnaround support.
                </p>
            </div>

            <!-- Card 3 -->
            <div class="group bg-white border border-gray-200/80 rounded-2xl p-8 shadow-sm hover:shadow-xl hover:border-red-200 transition-all duration-300 transform hover:-translate-y-1">
                <div class="w-12 h-12 rounded-xl bg-red-50 text-red-600 flex items-center justify-center mb-6 group-hover:bg-red-600 group-hover:text-white transition-colors duration-300">
                    <i class="fa-solid fa-shield-halved text-xl"></i>
                </div>
                <h3 class="font-bold text-xl text-gray-900 mb-2">Secure Routing</h3>
                <p class="text-gray-500 font-medium text-base leading-relaxed">
                    Your direct contact metrics are safely stored and encrypted, keeping communication secure at all points.
                </p>
            </div>

        </div>

    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const counters = document.querySelectorAll('.counter-value');
        const speed = 40;

        const animate = (counter) => {
            const target = parseInt(counter.getAttribute('data-target'));
            const increment = Math.max(1, Math.floor(target / 30));
            let current = 0;

            const update = () => {
                current += increment;
                if (current >= target) {
                    counter.textContent = target.toLocaleString();
                    return;
                }
                counter.textContent = current.toLocaleString();
                requestAnimationFrame(() => setTimeout(update, speed));
            };

            update();
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    animate(entry.target);
                    observer.unobserve(entry.target);
                }
            });
        }, {
            threshold: 0.5
        });

        counters.forEach(c => observer.observe(c));
    });
</script>