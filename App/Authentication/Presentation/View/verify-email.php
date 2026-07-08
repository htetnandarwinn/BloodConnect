<?php $errors = $_SESSION['errors'] ?? []; ?>
<?php $success = $_SESSION['success'] ?? ''; ?>
<?php $old = $_SESSION['old'] ?? []; ?>
<?php $expiresAt = $_SESSION['otp_expires_at'] ?? null; ?>
<?php $remainingSeconds = $expiresAt ? max(0, strtotime($expiresAt) - time()) : 0; ?>
<?php $expiresSoon = $remainingSeconds > 0 && $remainingSeconds <= 300; ?>

<!-- Tailwind CDN -->
<script src="https://cdn.tailwindcss.com"></script>

<main class="min-h-screen bg-slate-50 flex items-center justify-center p-4 antialiased selection:bg-red-600 selection:text-white">
    <!-- Main Card Container with smooth fade-in up animation -->
    <div class="w-full max-w-md bg-white rounded-2xl shadow-xl shadow-slate-100 p-6 md:p-8 border border-slate-100 transition-all duration-300 hover:shadow-2xl hover:shadow-red-100/30 animate-[fadeInUp_0.4s_ease-out]">

        <!-- Header / Brand Icon Section matching image_37b502.png -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-14 h-14 rounded-full bg-red-50 text-red-600 mb-4 animate-[pulse_2s_infinite]">
                <!-- Blood Drop / Cross Icon mimicking the landing page artwork -->
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-7 h-7">
                    <path d="M12 2.25c-.21 0-.41.08-.57.24L5.61 8.31a8.6 8.6 0 0 0 0 12.14 8.56 8.56 0 0 0 12.78 0 8.6 8.6 0 0 0 0-12.14l-5.82-5.82c-.16-.16-.36-.24-.57-.24ZM13 10.5h2v2h-2v2h-2v-2H9v-2h2v-2h2v2Z" />
                </svg>
            </div>
            <h2 class="text-2xl font-bold text-slate-800 tracking-tight">Verify Your Email</h2>
            <p class="text-sm text-slate-500 mt-2">Please enter the security code sent to your email to complete registration.</p>
            <?php if ($expiresAt): ?>
                <p id="otp-expiry" class="mt-3 text-sm font-medium <?= $expiresSoon ? 'text-amber-600' : 'text-slate-500' ?>">
                    This code will expire in <span id="otp-countdown"><?= $remainingSeconds ?>s</span>.
                </p>
            <?php endif; ?>
        </div>

        <!-- Error Banner -->
        <?php if (!empty($errors['form'])): ?>
            <div class="mb-6 p-4 rounded-xl bg-red-50 border border-red-100 text-red-700 text-sm flex items-center gap-3 animate-[shake_0.4s_ease-in-out]">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5 shrink-0 text-red-500">
                    <path fill-rule="evenodd" d="M9.401 3.003c1.155-2 4.043-2 5.197 0l7.355 12.748c1.154 2-.29 4.5-2.599 4.5H4.645c-2.309 0-3.752-2.5-2.598-4.5L9.401 3.003ZM12 8.25a.75.75 0 0 1 .75.75v3.75a.75.75 0 0 1-1.5 0V9a.75.75 0 0 1 .75-.75Zm0 8.25a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Z" clip-rule="evenodd" />
                </svg>
                <span><?= $errors['form'] ?></span>
            </div>
        <?php endif; ?>

        <!-- Success Banner -->
        <?php if ($success): ?>
            <div class="mb-6 p-4 rounded-xl bg-emerald-50 border border-emerald-100 text-emerald-700 text-sm flex items-center gap-3 animate-fade-in">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5 shrink-0 text-emerald-500">
                    <path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12Zm13.36-1.814a.75.75 0 1 0-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 0 0-1.06 1.06l2.5 2.5a.75.75 0 0 0 1.14-.082l4-5.6Z" clip-rule="evenodd" />
                </svg>
                <span><?= $success ?></span>
            </div>
        <?php endif; ?>

        <!-- Verification Form -->
        <form method="POST" action="/BloodConnect/public/verify-email" class="space-y-6">
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-3 text-center">Enter OTP Code</label>

                <!-- Modern Segmented OTP Inputs -->
                <div class="flex justify-center gap-2 sm:gap-3" id="otp-container">
                    <input type="text" maxlength="1" class="otp-field w-12 h-14 text-center text-xl font-bold text-slate-800 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-red-500 focus:ring-4 focus:ring-red-100 outline-none transition-all duration-200" required>
                    <input type="text" maxlength="1" class="otp-field w-12 h-14 text-center text-xl font-bold text-slate-800 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-red-500 focus:ring-4 focus:ring-red-100 outline-none transition-all duration-200" required>
                    <input type="text" maxlength="1" class="otp-field w-12 h-14 text-center text-xl font-bold text-slate-800 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-red-500 focus:ring-4 focus:ring-red-100 outline-none transition-all duration-200" required>
                    <input type="text" maxlength="1" class="otp-field w-12 h-14 text-center text-xl font-bold text-slate-800 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-red-500 focus:ring-4 focus:ring-red-100 outline-none transition-all duration-200" required>
                    <input type="text" maxlength="1" class="otp-field w-12 h-14 text-center text-xl font-bold text-slate-800 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-red-500 focus:ring-4 focus:ring-red-100 outline-none transition-all duration-200" required>
                    <input type="text" maxlength="1" class="otp-field w-12 h-14 text-center text-xl font-bold text-slate-800 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-red-500 focus:ring-4 focus:ring-red-100 outline-none transition-all duration-200" required>
                </div>

                <!-- Carries original single 'code' parameter mapping exactly to backend logic -->
                <input type="hidden" name="code" id="actual-code">
            </div>

            <!-- Red Primary Action Button matching "Find Blood Requests / Register" -->
            <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white font-semibold py-3 px-4 rounded-xl shadow-lg shadow-red-200 hover:shadow-red-300 active:scale-[0.98] transition-all duration-150">
                Verify Account
            </button>
        </form>

        <!-- Divider line -->
        <div class="relative flex py-5 items-center">
            <div class="flex-grow border-t border-slate-100"></div>
            <span class="flex-shrink mx-4 text-xs text-slate-400 font-medium uppercase tracking-wider">or</span>
            <div class="flex-grow border-t border-slate-100"></div>
        </div>

        <!-- Resend Code Form mimicking white button text states -->
        <form method="POST" action="/BloodConnect/public/resend-code" class="text-center">
            <button type="submit" id="resend-btn" class="inline-flex items-center gap-2 text-sm font-semibold text-red-600 hover:text-red-700 transition-colors duration-150 py-2 group">
                Didn't get a code? Resend Code
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4 transform group-hover:translate-x-1 transition-transform">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                </svg>
            </button>
        </form>
    </div>
</main>

<style>
    /* Elegant initial page load entry animation */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(12px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Error animation */
    @keyframes shake {

        0%,
        100% {
            transform: translateX(0);
        }

        25% {
            transform: translateX(-4px);
        }

        75% {
            transform: translateX(4px);
        }
    }
</style>

<script>
    document.addEventListener("DOMContentLoaded", () => {
        const fields = document.querySelectorAll('.otp-field');
        const hiddenInput = document.getElementById('actual-code');
        const expiryText = document.getElementById('otp-countdown');
        const resendBtn = document.getElementById('resend-btn');

        if (expiryText) {
            let remaining = parseInt(expiryText.textContent, 10) || 0;
            const timer = setInterval(() => {
                remaining = Math.max(0, remaining - 1);
                expiryText.textContent = `${remaining}s`;

                if (remaining === 0) {
                    clearInterval(timer);
                    expiryText.textContent = 'expired';
                    expiryText.closest('p').classList.remove('text-slate-500', 'text-amber-600');
                    expiryText.closest('p').classList.add('text-red-600');
                    if (resendBtn) {
                        resendBtn.disabled = false;
                        resendBtn.classList.remove('opacity-50', 'cursor-not-allowed');
                    }
                }
            }, 1000);
        }

        if (resendBtn) {
            resendBtn.disabled = true;
            resendBtn.classList.add('opacity-50', 'cursor-not-allowed');
        }

        fields.forEach((field, index) => {
            field.addEventListener('input', (e) => {
                if (e.target.value.length >= 1 && index < fields.length - 1) {
                    fields[index + 1].focus();
                }
                updateHiddenValue();
            });

            field.addEventListener('keydown', (e) => {
                if (e.key === 'Backspace' && !e.target.value && index > 0) {
                    fields[index - 1].focus();
                }
            });
        });

        function updateHiddenValue() {
            let values = "";
            fields.forEach(f => values += f.value);
            hiddenInput.value = values;
        }
    });
</script>