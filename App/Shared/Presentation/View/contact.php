<?php
$errors = $_SESSION['errors'] ?? [];
$success = $_SESSION['success'] ?? '';
$old = $_SESSION['old'] ?? [];
unset($_SESSION['errors'], $_SESSION['success'], $_SESSION['old']);

$basePath = defined('BASE_URL') ? BASE_URL : '/BloodConnect/public';

$contacts = [
    [
        'icon' => 'map',
        'label' => 'Visit Us',
        'value' => 'Ywadan, Yamethin, Myanmar',
        'detail' => 'We are open 24/7 for emergencies',
    ],
    [
        'icon' => 'mail',
        'label' => 'Email Us',
        'value' => 'bloodconnect.support@gmail.com',
        'detail' => 'We reply within 24 hours',
    ],
    [
        'icon' => 'phone',
        'label' => 'Call Us',
        'value' => '09752491443',
        'detail' => '24/7 emergency support',
    ],
];
?>
<style>
    .contact-section {
        background: #ffffff;
        min-height: calc(100vh - 6rem);
    }

    .contact-card {
        transition: all 0.35s cubic-bezier(0.16, 1, 0.3, 1);
    }

    .contact-card:hover .icon-wrapper {
        background: #ce2424;
        color: white;
        transform: scale(1.05);
    }

    .icon-wrapper {
        transition: all 0.35s cubic-bezier(0.16, 1, 0.3, 1);
    }

    .form-input {
        transition: all 0.2s ease;
    }

    .form-input:focus {
        border-color: #ce2424;
        box-shadow: 0 0 0 4px rgba(206, 36, 36, 0.08);
        outline: none;
    }

    .social-link {
        transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
    }

    .social-link:hover {
        background: #ce2424;
        color: white;
        border-color: #ce2424;
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(206, 36, 36, 0.15);
    }

    .submit-btn {
        transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
    }

    .submit-btn:hover {
        transform: translateY(-1px);
        box-shadow: 0 12px 28px rgba(206, 36, 36, 0.25);
    }

    .submit-btn:active {
        transform: translateY(0);
    }

    .toast {
        animation: toastIn 0.4s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    }

    @keyframes toastIn {
        0% {
            opacity: 0;
            transform: translateY(-12px) scale(0.96);
        }

        100% {
            opacity: 1;
            transform: translateY(0) scale(1);
        }
    }

    /* Scroll-triggered animations */
    .reveal {
        opacity: 0;
        transform: translateY(30px);
        transition: opacity 0.7s cubic-bezier(0.16, 1, 0.3, 1),
            transform 0.7s cubic-bezier(0.16, 1, 0.3, 1);
    }

    .reveal.visible {
        opacity: 1;
        transform: translateY(0);
    }

    .reveal-delay-1 {
        transition-delay: 0.1s;
    }

    .reveal-delay-2 {
        transition-delay: 0.2s;
    }

    .reveal-delay-3 {
        transition-delay: 0.3s;
    }

    .reveal-delay-4 {
        transition-delay: 0.4s;
    }

    @keyframes fadeUp {
        0% {
            opacity: 0;
            transform: translateY(24px) scale(0.97);
        }

        100% {
            opacity: 1;
            transform: translateY(0) scale(1);
        }
    }

    .animate-fade-up {
        animation: fadeUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    }

    .animate-fade-up-d1 {
        animation-delay: 0.15s;
    }

    .animate-fade-up-d2 {
        animation-delay: 0.25s;
    }

    .animate-fade-up-d3 {
        animation-delay: 0.35s;
    }
</style>

<section class="relative contact-section py-16 sm:py-20 lg:py-28 overflow-hidden">
    <div class="relative z-10 max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Header -->
        <div class="text-center max-w-2xl mx-auto mb-14 sm:mb-18">
            <span class="animate-fade-up opacity-0 inline-flex items-center gap-2 bg-white/80 backdrop-blur-sm text-[#ce2424] px-4 py-1.5 rounded-full text-xs font-bold tracking-wide uppercase border border-rose-200 shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-3.5 h-3.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 8.511c.884.284 1.5 1.128 1.5 2.097v4.286c0 1.136-.847 2.1-1.98 2.193-.34.027-.68.052-1.02.072v3.091l-3-3c-1.354 0-2.694-.055-4.02-.163a2.115 2.115 0 01-.825-.242m9.345-8.334a2.126 2.126 0 00-.476-.095 48.64 48.64 0 00-8.048 0c-1.131.094-1.976 1.057-1.976 2.192v4.286c0 .837.46 1.58 1.155 1.951m9.345-8.334V6.637c0-1.621-1.152-3.026-2.76-3.235A48.455 48.455 0 0011.25 3c-2.115 0-4.198.137-6.24.402-1.608.209-2.76 1.614-2.76 3.235v6.226c0 1.621 1.152 3.026 2.76 3.235.577.075 1.157.14 1.74.194V21l4.155-4.155" />
                </svg>
                Get In Touch
            </span>
            <h1 class="animate-fade-up animate-fade-up-d1 opacity-0 text-4xl sm:text-5xl lg:text-6xl font-extrabold text-slate-900 tracking-tight leading-tight mt-5">
                Get in <span class="text-[#ce2424]">touch</span>
            </h1>
            <p class="animate-fade-up animate-fade-up-d2 opacity-0 text-base sm:text-lg text-slate-500 mt-3 max-w-lg mx-auto leading-relaxed">
                We'd love to hear from you. Reach out and let's make an impact together.
            </p>
        </div>

        <!-- Success / Error Toast -->
        <?php if ($success): ?>
            <div class="toast max-w-xl mx-auto mb-8 px-5 py-4 bg-emerald-50 border border-emerald-200 rounded-2xl flex items-center gap-3 shadow-lg shadow-emerald-100/40">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5 text-emerald-600 shrink-0">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span class="text-sm font-semibold text-emerald-800"><?= htmlspecialchars($success) ?></span>
            </div>
        <?php endif; ?>

        <!-- Contact Info -->
        <div class="max-w-3xl mx-auto space-y-6">
            <div class="space-y-6">
                <?php foreach ($contacts as $i => $item): ?>
                    <div class="contact-card reveal reveal-delay-<?= $i + 1 ?> bg-white rounded-2xl border border-slate-200/70 p-6 sm:p-8 shadow-sm hover:shadow-md hover:border-rose-200">
                        <div class="flex items-start gap-5">
                            <div class="icon-wrapper w-14 h-14 rounded-xl bg-rose-50 border border-rose-100 flex items-center justify-center text-rose-500 shrink-0">
                                <?php if ($item['icon'] === 'map'): ?>
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
                                    </svg>
                                <?php elseif ($item['icon'] === 'mail'): ?>
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0l-7.5-4.615a2.25 2.25 0 01-1.07-1.916V6.75" />
                                    </svg>
                                <?php else: ?>
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-2.824-1.802-5.14-4.117-6.942-6.942l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z" />
                                    </svg>
                                <?php endif; ?>
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-slate-400 uppercase tracking-widest mb-0.5"><?= $item['label'] ?></p>
                                <p class="text-base font-bold text-slate-900"><?= $item['value'] ?></p>
                                <p class="text-sm text-slate-400 mt-0.5"><?= $item['detail'] ?></p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

        </div>
    </div>
</section>

<script>
    (function() {
        var reveals = document.querySelectorAll('.reveal');
        if (reveals.length && 'IntersectionObserver' in window) {
            var observer = new IntersectionObserver(function(entries) {
                entries.forEach(function(entry) {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('visible');
                        observer.unobserve(entry.target);
                    }
                });
            }, {
                threshold: 0.15
            });
            reveals.forEach(function(el) {
                observer.observe(el);
            });
        } else {
            reveals.forEach(function(el) {
                el.classList.add('visible');
            });
        }
    })();
</script>