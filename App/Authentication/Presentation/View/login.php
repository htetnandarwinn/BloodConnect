<?php
$basePath = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME']));
if ($basePath === '/' || $basePath === '\\') {
    $basePath = '';
}
$errors = $_SESSION['errors'] ?? [];
$success = $_SESSION['success'] ?? '';
$old = $_SESSION['old'] ?? [];
unset($_SESSION['errors'], $_SESSION['success'], $_SESSION['old']);
?>

<!-- FontAwesome & Base Styling Dependencies -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<?php $recaptchaSiteKey = getenv('RECAPTCHA_SITE_KEY') ?: ''; ?>
<?php if ($recaptchaSiteKey): ?>
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<?php endif; ?>

<!-- ============ REGULAR MODERN CLASSIC INTERIOR VIEW CONTENT ============ -->
<section class="relative overflow-hidden py-10 lg:py-14 bg-gray-50">

    <!-- Trending Modern Background Geometric Layer -->
    <div class="absolute right-0 bottom-0 w-full max-w-3xl pointer-events-none opacity-40 lg:opacity-100 z-0 select-none animate-pulse duration-[6000ms]">
        <svg viewBox="0 0 700 500" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg" class="w-full h-auto block">
            <path d="M700,170 C470,40 270,300 0,500 L700,500 Z" fill="#FCEAEF" />
        </svg>
    </div>

    <!-- Main Outer Wrapper -->
    <div class="relative z-10 max-w-[1440px] mx-auto w-full px-6 md:px-12">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-16 items-center min-h-[500px]">


            <!-- Left Side Column: Modern Info Presentation Panel with Shift and Float Animations -->
            <div class="order-2 lg:order-1 lg:col-span-5 flex flex-col items-center lg:items-start text-center lg:text-left transform transition duration-500 hover:scale-[1.01] lg:-translate-x-6">

                <!-- Droplet Canvas Layout with Matching Floating Animation -->
                <div class="w-64 h-64 md:w-72 md:h-72 bg-gradient-to-br from-red-50/70 to-red-100/30 rounded-3xl p-6 flex items-center justify-center shadow-inner mb-6 relative animate-[bounce_5s_infinite_ease-in-out]">
                    <svg viewBox="0 0 240 260" xmlns="http://www.w3.org/2000/svg" class="w-full h-auto drop-shadow-xl max-w-[200px] animate-pulse duration-[3000ms]">
                        <path d="M120,30 C150,68 178,112 178,140 C178,170 152,192 120,192 C88,192 62,170 62,140 C62,112 90,68 120,30 Z" fill="#C8102E" />
                        <rect x="110" y="108" width="20" height="74" rx="7" fill="#FFFFFF" />
                        <rect x="83" y="135" width="74" height="20" rx="7" fill="#FFFFFF" />
                    </svg>
                </div>

                <h3 class="font-black text-3xl md:text-4xl text-gray-900 tracking-tight">Did you know?</h3>
                <p class="text-base md:text-lg text-gray-500 font-medium mt-2 mb-6 max-w-md">
                    Important facts about blood donation and safety metrics within your local ecosystem.
                </p>

                <div class="group w-full max-w-md bg-white border border-gray-200/80 rounded-2xl p-6 flex gap-5 items-start text-left shadow-sm hover:shadow-md hover:border-red-100 transition-all duration-300">
                    <div class="w-14 h-14 rounded-full bg-red-50 text-red-600 flex items-center justify-center flex-shrink-0 group-hover:bg-red-600 group-hover:text-white transition-all duration-300">
                        <svg viewBox="0 0 24 28" xmlns="http://www.w3.org/2000/svg" class="w-6 h-7 transition-colors duration-300">
                            <path d="M12,2 C18,10 21,16 21,19.5 C21,24.2 17,27 12,27 C7,27 3,24.2 3,19.5 C3,16 6,10 12,2 Z" fill="currentColor" class="text-red-600 group-hover:text-white" />
                        </svg>
                    </div>
                    <div>
                        <h4 class="font-bold text-lg text-gray-900 mb-1">One donation, many lives</h4>
                        <p class="text-gray-500 text-base leading-relaxed">
                            A single unit of blood can save up to three separate lives through modern component processing separation.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Right Side Column: Login Card Panel -->
            <div class="order-1 lg:order-2 lg:col-span-7 flex justify-center lg:justify-end w-full">
                <div class="bg-white border border-gray-150/90 rounded-3xl p-8 md:p-12 shadow-xl shadow-gray-100/50 w-full max-w-xl transition-all duration-500 hover:shadow-2xl hover:shadow-gray-200/60">
                    <h2 class="font-black text-3xl md:text-4xl text-gray-900 tracking-tight">Welcome back</h2>
                    <p class="text-base md:text-lg text-gray-500 font-medium mt-3 mb-8 leading-relaxed">
                        Sign in to manage blood requests, connect instantly with local donors, and stay ahead of critical urgent needs.
                    </p>

                    <!-- Success Alert banner -->
                    <?php if (!empty($success)): ?>
                        <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 rounded-xl">
                            <p class="text-emerald-700 text-base font-semibold"><?= htmlspecialchars($success, ENT_QUOTES) ?></p>
                        </div>
                    <?php endif; ?>

                    <!-- Backend Form-Wide Errors Banner -->
                    <?php if (!empty($errors) && isset($errors['form'])): ?>
                        <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-xl">
                            <p class="text-red-600 text-base font-semibold flex items-center gap-2">
                                <i class="fa-solid fa-circle-exclamation text-sm"></i> <?= htmlspecialchars($errors['form'], ENT_QUOTES) ?>
                            </p>
                        </div>
                    <?php endif; ?>

                    <form id="loginForm" novalidate method="post" action="<?= $basePath ?? '' ?>/login" class="space-y-6">

                        <!-- Username / Email Field Container -->
                        <div class="space-y-2">
                            <label class="block text-base font-bold text-gray-900">Email or Username</label>
                            <div class="relative">
                                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-red-600 pointer-events-none text-lg">
                                    <i class="fa-regular fa-user"></i>
                                </span>
                                <input type="text" id="loginId" name="login" placeholder="Enter email or username"
                                    value="<?= htmlspecialchars($old['login'] ?? '', ENT_QUOTES) ?>" required
                                    class="w-full bg-white border border-gray-300 rounded-xl pl-12 pr-4 py-3.5 text-base text-gray-900 placeholder-gray-400 focus:outline-none focus:border-red-600 focus:ring-4 focus:ring-red-100 transition duration-200 font-medium">
                            </div>
                            <!-- Field Specific Error Container Below Input -->
                            <p class="hidden text-red-600 text-sm font-semibold mt-1.5 items-center gap-1.5" id="loginIdError">
                                <i class="fa-solid fa-circle-exclamation"></i> Please enter your email or username.
                            </p>
                            <?php if (!empty($errors) && isset($errors['login'])): ?>
                                <p class="text-red-600 text-sm font-semibold mt-1.5 flex items-center gap-1.5">
                                    <i class="fa-solid fa-circle-exclamation"></i> <?= htmlspecialchars($errors['login'], ENT_QUOTES) ?>
                                </p>
                            <?php endif; ?>
                        </div>

                        <!-- Password Field Container -->
                        <div class="space-y-2">
                            <label class="block text-base font-bold text-gray-900">Password</label>
                            <div class="relative">
                                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-red-600 pointer-events-none text-lg">
                                    <i class="fa-solid fa-lock"></i>
                                </span>
                                <input type="password" id="loginPassword" name="password" placeholder="Enter password" required
                                    class="w-full bg-white border border-gray-300 rounded-xl pl-12 pr-12 py-3.5 text-base text-gray-900 placeholder-gray-400 focus:outline-none focus:border-red-600 focus:ring-4 focus:ring-red-100 transition duration-200 font-medium">
                                <button type="button" id="togglePassword" class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 transition text-lg px-1">
                                    <i class="fa-regular fa-eye" id="eyeIcon"></i>
                                </button>
                            </div>
                            <!-- Field Specific Error Container Below Input -->
                            <p class="hidden text-red-600 text-sm font-semibold mt-1.5 items-center gap-1.5" id="loginPasswordError">
                                <i class="fa-solid fa-circle-exclamation"></i> Please enter your password.
                            </p>
                            <?php if (!empty($errors) && isset($errors['password'])): ?>
                                <p class="text-red-600 text-sm font-semibold mt-1.5 flex items-center gap-1.5">
                                    <i class="fa-solid fa-circle-exclamation"></i> <?= htmlspecialchars($errors['password'], ENT_QUOTES) ?>
                                </p>
                            <?php endif; ?>
                        </div>

                        <!-- Action Items: Right aligned -->
                        <div class="flex justify-end pt-0.5">
                            <a href="<?= $basePath ?? '' ?>/forgot-password" id="forgotLink" class="text-base font-bold text-red-600 hover:text-red-700 transition">
                                Forgot password?
                            </a>
                        </div>

                        <a href="<?= $basePath ?? '' ?>/auth/google"
                            class="w-full flex items-center justify-center gap-3 bg-white border border-gray-300 hover:border-red-300 hover:bg-red-50/30 text-gray-700 font-bold py-3.5 px-6 rounded-xl text-base shadow-sm active:scale-[0.99] transition duration-150">
                            <i class="fa-brands fa-google text-red-500 text-lg"></i>
                            Continue with Google
                        </a>

                        <div class="relative flex items-center">
                            <div class="flex-grow border-t border-gray-200"></div>
                            <span class="flex-shrink mx-4 text-xs font-bold text-gray-400 uppercase">or</span>
                            <div class="flex-grow border-t border-gray-200"></div>
                        </div>

                        <!-- Google reCAPTCHA v2 Widget -->
                        <?php if ($recaptchaSiteKey): ?>
                        <div class="flex flex-col items-center gap-2">
                            <div class="g-recaptcha" data-sitekey="<?= htmlspecialchars($recaptchaSiteKey, ENT_QUOTES) ?>"></div>
                            <p class="hidden text-red-600 text-sm font-semibold" id="recaptchaError">
                                <i class="fa-solid fa-circle-exclamation"></i> Please check the "I'm not a robot" box.
                            </p>
                        </div>
                        <?php endif; ?>

                        <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white font-bold py-4 px-6 rounded-xl text-lg shadow-lg shadow-red-600/20 active:scale-[0.99] transition duration-150">
                            Sign in
                        </button>

                        <!-- Added Registration Routing Prompt Link Line -->
                        <div class="text-center pt-2">
                            <p class="text-base text-gray-500 font-medium">
                                Don't have an account?
                                <a href="<?= $basePath ?? '' ?>/register" class="text-red-600 hover:text-red-700 font-bold transition ml-1">
                                    Register
                                </a>
                            </p>
                        </div>
                    </form>

                </div>
            </div>

        </div>
    </div>
</section>

<!-- Front-End Interactive Form Controller Validation -->
<script>
    const loginForm = document.getElementById("loginForm");
    const togglePasswordBtn = document.getElementById("togglePassword");
    const passwordInput = document.getElementById("loginPassword");
    const eyeIcon = document.getElementById("eyeIcon");

    if (togglePasswordBtn && passwordInput && eyeIcon) {
        togglePasswordBtn.addEventListener("click", () => {
            const isPassword = passwordInput.type === "password";
            passwordInput.type = isPassword ? "text" : "password";
            eyeIcon.className = isPassword ? "fa-regular fa-eye-slash" : "fa-regular fa-eye";
        });
    }

    if (loginForm) {
        loginForm.addEventListener("submit", function(e) {
            const id = document.getElementById("loginId");
            const password = document.getElementById("loginPassword");
            const idError = document.getElementById("loginIdError");
            const passwordError = document.getElementById("loginPasswordError");

            const isIdInvalid = !id?.value.trim();
            const isPasswordInvalid = !password?.value.trim();

            if (id) {
                if (isIdInvalid) {
                    id.classList.add("border-red-500", "focus:ring-red-100");
                    idError?.classList.remove("hidden");
                    idError?.classList.add("flex");
                } else {
                    id.classList.remove("border-red-500", "focus:ring-red-100");
                    idError?.classList.add("hidden");
                    idError?.classList.remove("flex");
                }
            }

            if (password) {
                if (isPasswordInvalid) {
                    password.classList.add("border-red-500", "focus:ring-red-100");
                    passwordError?.classList.remove("hidden");
                    passwordError?.classList.add("flex");
                } else {
                    password.classList.remove("border-red-500", "focus:ring-red-100");
                    passwordError?.classList.add("hidden");
                    passwordError?.classList.remove("flex");
                }
            }

            if (isIdInvalid || isPasswordInvalid) {
                e.preventDefault();
                return;
            }

            const recaptchaResponse = document.getElementById("g-recaptcha-response");
            const recaptchaError = document.getElementById("recaptchaError");
            if (recaptchaResponse && !recaptchaResponse.value) {
                e.preventDefault();
                recaptchaError?.classList.remove("hidden");
            } else {
                recaptchaError?.classList.add("hidden");
            }
        });
    }
</script>