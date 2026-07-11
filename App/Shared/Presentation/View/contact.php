<?php
$errors = $_SESSION['errors'] ?? [];
$success = $_SESSION['success'] ?? '';
$old = $_SESSION['old'] ?? [];
unset($_SESSION['errors'], $_SESSION['success'], $_SESSION['old']);
$contacts = [
    ['icon' => 'fa-location-dot', 'label' => 'Central Hub', 'value' => '123 BloodConnect Plaza, Medical Lane'],
    ['icon' => 'fa-envelope', 'label' => 'Digital Support', 'value' => 'support@bloodconnect.example.com'],
    ['icon' => 'fa-phone', 'label' => 'Emergency Dispatch', 'value' => '+1 (555) 019-2834'],
];
?>
<style>
    @keyframes fadeSlideUp {
        0% { opacity: 0; transform: translateY(30px); }
        100% { opacity: 1; transform: translateY(0); }
    }
    @keyframes slideInLeft {
        0% { opacity: 0; transform: translateX(-30px); }
        100% { opacity: 1; transform: translateX(0); }
    }
    @keyframes slideInRight {
        0% { opacity: 0; transform: translateX(30px); }
        100% { opacity: 1; transform: translateX(0); }
    }
    @keyframes badgePulse {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.04); }
    }
    .badge-pulse { animation: badgePulse 2.5s ease-in-out infinite; }
    .contact-header { animation: fadeSlideUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
    .info-card { animation: slideInLeft 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards; opacity: 0; }
    .info-item:hover .info-icon { transform: scale(1.1) rotate(-6deg); background-color: rgb(220 38 38); color: white; }
    .info-icon { transition: all 0.35s cubic-bezier(0.16, 1, 0.3, 1); }
    .form-panel { animation: slideInRight 0.7s cubic-bezier(0.16, 1, 0.3, 1) forwards; opacity: 0; }
    .form-group { animation: fadeSlideUp 0.4s cubic-bezier(0.16, 1, 0.3, 1) forwards; opacity: 0; }
    .input-field { transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1); }
    .input-field:focus { transform: translateY(-1px); }
    .gradient-text { background: linear-gradient(135deg, #dc2626, #ef4444, #dc2626); background-size: 200% auto; -webkit-background-clip: text; -webkit-text-fill-color: transparent; animation: gradientFlow 4s ease infinite; }
    @keyframes gradientFlow {
        0% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
        100% { background-position: 0% 50%; }
    }
</style>

<section class="relative overflow-hidden pt-6 pb-24 lg:pt-10 lg:pb-36">
    <div class="absolute inset-0 pointer-events-none z-0">
        <div class="absolute top-0 right-0 w-96 h-96 bg-gradient-to-br from-red-50/60 to-transparent rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 left-0 w-80 h-80 bg-gradient-to-tl from-red-50/40 to-transparent rounded-full blur-3xl"></div>
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-full max-w-5xl opacity-20 select-none">
            <svg viewBox="0 0 700 500" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg" class="w-full h-auto">
                <path d="M700,170 C470,40 270,300 0,500 L700,500 Z" fill="#FCEAEF" />
            </svg>
        </div>
    </div>

    <div class="relative z-10 max-w-[1440px] mx-auto w-full px-6 md:px-12">
        <div class="max-w-2xl mb-12 contact-header">
            <span class="badge-pulse inline-flex items-center gap-2 bg-red-50 text-red-600 px-5 py-2 rounded-full text-sm font-bold tracking-wide uppercase border border-red-100 mb-5 shadow-sm">
                <i class="fa-solid fa-headset"></i> Get In Touch
            </span>
            <h2 class="font-black text-4xl md:text-5xl lg:text-6xl text-gray-900 tracking-tight leading-tight">Contact <span class="gradient-text">Us</span></h2>
            <div class="h-1 w-16 bg-red-600 rounded-full mt-5 shadow-sm shadow-red-600/30"></div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            <div class="lg:col-span-4 info-card" style="animation-delay: 0.15s;">
                <div class="bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900 text-white rounded-3xl p-8 shadow-xl shadow-gray-900/10 space-y-8 flex flex-col justify-between min-h-[540px] border border-gray-700/50 hover:shadow-2xl hover:shadow-red-900/10 transition-all duration-500">
                    <div>
                        <h3 class="font-black text-2xl tracking-tight text-white mb-3">Connection Hub</h3>
                        <p class="text-gray-400 text-sm font-medium leading-relaxed">
                            Have queries regarding emergency channels, platform security, or routing criteria? Reach out directly.
                        </p>
                    </div>

                    <div class="space-y-6">
                        <?php foreach ($contacts as $i => $item): ?>
                            <div class="info-item flex items-center gap-4 group" style="animation: fadeSlideUp 0.4s forwards; animation-delay: <?= 0.2 + ($i * 0.08) ?>s;">
                                <div class="info-icon w-11 h-11 rounded-xl bg-white/10 flex items-center justify-center text-red-400 shadow-sm shrink-0">
                                    <i class="fa-solid <?= $item['icon'] ?> text-base"></i>
                                </div>
                                <div class="min-w-0">
                                    <p class="text-[11px] font-bold text-gray-500 uppercase tracking-wider"><?= $item['label'] ?></p>
                                    <p class="text-gray-200 text-sm font-semibold truncate"><?= $item['value'] ?></p>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <div class="pt-4 border-t border-white/10 flex items-center gap-4 text-gray-400">
                        <span class="text-xs font-bold uppercase tracking-wider">Follow Us:</span>
                        <a href="#" class="hover:text-white hover:-translate-y-0.5 transition-all duration-200 text-sm"><i class="fa-brands fa-facebook-f"></i></a>
                        <a href="#" class="hover:text-white hover:-translate-y-0.5 transition-all duration-200 text-sm"><i class="fa-brands fa-x-twitter"></i></a>
                        <a href="#" class="hover:text-white hover:-translate-y-0.5 transition-all duration-200 text-sm"><i class="fa-brands fa-linkedin-in"></i></a>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-8 form-panel" style="animation-delay: 0.25s;">
                <div class="bg-white border border-gray-200/80 rounded-3xl p-8 md:p-10 shadow-xl shadow-gray-200/40 transition-all duration-500 hover:shadow-2xl">
                    <h3 class="font-black text-2xl md:text-3xl text-gray-900 tracking-tight mb-2">Send a Message</h3>
                    <p class="text-sm md:text-base text-gray-500 font-medium mb-6 leading-relaxed">
                        Fill out the form below and our team will get back to you promptly.
                    </p>

                    <?php if (!empty($success)): ?>
                        <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 rounded-xl" style="animation: fadeSlideUp 0.4s forwards;">
                            <p class="text-emerald-700 text-sm font-semibold flex items-center gap-2">
                                <i class="fa-solid fa-circle-check"></i> <?= htmlspecialchars($success, ENT_QUOTES) ?>
                            </p>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($errors)): ?>
                        <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-xl space-y-1" style="animation: fadeSlideUp 0.4s forwards;">
                            <?php foreach ($errors as $err): ?>
                                <p class="text-red-600 text-xs font-semibold flex items-center gap-1"><i class="fa-solid fa-circle-exclamation"></i> <?= htmlspecialchars($err, ENT_QUOTES) ?></p>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>

                    <form id="altContactForm" novalidate method="post" action="<?= $basePath ?>/contact/send" class="space-y-5">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div class="form-group space-y-1.5" style="animation-delay: 0.3s;">
                                <label class="block text-xs font-black uppercase tracking-wider text-gray-500">Your Name</label>
                                <div class="relative">
                                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-base"><i class="fa-regular fa-user"></i></span>
                                    <input type="text" id="altName" name="name" placeholder="John Doe"
                                        value="<?= htmlspecialchars($old['name'] ?? '', ENT_QUOTES) ?>" required
                                        class="input-field w-full bg-gray-50 border border-gray-200 rounded-xl pl-11 pr-4 py-3 text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:border-red-600 focus:bg-white focus:ring-4 focus:ring-red-100 font-medium">
                                </div>
                                <p class="hidden text-red-600 text-xs font-semibold mt-1 items-center gap-1" id="altNameError"><i class="fa-solid fa-circle-exclamation"></i> Full name is required.</p>
                            </div>

                            <div class="form-group space-y-1.5" style="animation-delay: 0.35s;">
                                <label class="block text-xs font-black uppercase tracking-wider text-gray-500">Email Address</label>
                                <div class="relative">
                                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-base"><i class="fa-regular fa-envelope"></i></span>
                                    <input type="email" id="altEmail" name="email" placeholder="name@example.com"
                                        value="<?= htmlspecialchars($old['email'] ?? '', ENT_QUOTES) ?>" required
                                        class="input-field w-full bg-gray-50 border border-gray-200 rounded-xl pl-11 pr-4 py-3 text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:border-red-600 focus:bg-white focus:ring-4 focus:ring-red-100 font-medium">
                                </div>
                                <p class="hidden text-red-600 text-xs font-semibold mt-1 items-center gap-1" id="altEmailError"><i class="fa-solid fa-circle-exclamation"></i> A valid email is required.</p>
                            </div>
                        </div>

                        <div class="form-group space-y-1.5" style="animation-delay: 0.4s;">
                            <label class="block text-xs font-black uppercase tracking-wider text-gray-500">Subject Title</label>
                            <div class="relative">
                                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-base"><i class="fa-regular fa-bookmark"></i></span>
                                <input type="text" id="altSubject" name="subject" placeholder="What is this regarding?"
                                    value="<?= htmlspecialchars($old['subject'] ?? '', ENT_QUOTES) ?>" required
                                    class="input-field w-full bg-gray-50 border border-gray-200 rounded-xl pl-11 pr-4 py-3 text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:border-red-600 focus:bg-white focus:ring-4 focus:ring-red-100 font-medium">
                            </div>
                            <p class="hidden text-red-600 text-xs font-semibold mt-1 items-center gap-1" id="altSubjectError"><i class="fa-solid fa-circle-exclamation"></i> Please specify a clear subject.</p>
                        </div>

                        <div class="form-group space-y-1.5" style="animation-delay: 0.45s;">
                            <label class="block text-xs font-black uppercase tracking-wider text-gray-500">Message Description</label>
                            <div class="relative">
                                <span class="absolute left-4 top-3.5 text-gray-400 text-base"><i class="fa-regular fa-comment-dots"></i></span>
                                <textarea id="altMessage" name="message" rows="4" placeholder="Type your message here..." required
                                    class="input-field w-full bg-gray-50 border border-gray-200 rounded-xl pl-11 pr-4 py-3 text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:border-red-600 focus:bg-white focus:ring-4 focus:ring-red-100 font-medium resize-none"><?= htmlspecialchars($old['message'] ?? '', ENT_QUOTES) ?></textarea>
                            </div>
                            <p class="hidden text-red-600 text-xs font-semibold mt-1 items-center gap-1" id="altMessageError"><i class="fa-solid fa-circle-exclamation"></i> Message cannot be blank.</p>
                        </div>

                        <div class="form-group pt-2" style="animation-delay: 0.5s;">
                            <button type="submit" class="w-full bg-gradient-to-r from-red-600 to-rose-600 hover:from-red-700 hover:to-rose-700 text-white font-bold py-3.5 px-6 rounded-xl text-base shadow-md shadow-red-600/10 active:scale-[0.99] transition-all duration-200 flex items-center justify-center gap-2 hover:-translate-y-0.5">
                                <i class="fa-regular fa-paper-plane text-sm"></i> Send Message
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    document.getElementById("altContactForm").addEventListener("submit", function(e) {
        const fields = [
            { input: document.getElementById("altName"), error: document.getElementById("altNameError"), check: v => !v.trim() },
            { input: document.getElementById("altEmail"), error: document.getElementById("altEmailError"), check: v => !v.trim() || !v.includes('@') },
            { input: document.getElementById("altSubject"), error: document.getElementById("altSubjectError"), check: v => !v.trim() },
            { input: document.getElementById("altMessage"), error: document.getElementById("altMessageError"), check: v => !v.trim() },
        ];
        let valid = true;
        fields.forEach(({ input, error, check }) => {
            if (check(input.value)) {
                input.classList.add("border-red-500", "focus:ring-red-100");
                error.classList.replace("hidden", "flex");
                valid = false;
            } else {
                input.classList.remove("border-red-500", "focus:ring-red-100");
                error.classList.replace("flex", "hidden");
            }
        });
        if (!valid) e.preventDefault();
    });
</script>
