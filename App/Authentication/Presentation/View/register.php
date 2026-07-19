<?php
// C:\xampp_new\htdocs\BloodConnect\App\Authentication\Presentation\View\register.php
$basePath = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME']));
if ($basePath === '/' || $basePath === '\\') {
    $basePath = '';
}

$errors = $_SESSION['errors'] ?? [];
$success = $_SESSION['success'] ?? '';
$old = $_SESSION['old'] ?? [];
unset($_SESSION['errors'], $_SESSION['success'], $_SESSION['old']);

$current_role = $old['role'] ?? ($_GET['role'] ?? '');
?>

<?php $recaptchaSiteKey = getenv('RECAPTCHA_SITE_KEY') ?: ''; ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<?php if ($recaptchaSiteKey): ?>
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<?php endif; ?>

<style>
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(-8px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .animate-fade-in {
        animation: fadeIn 0.4s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    }

    #roleSelect {
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
        outline: none !important;
        box-shadow: none !important;
    }

    #roleSelect:focus,
    #roleSelect:hover {
        border-color: #ef4444 !important;
        box-shadow: none !important;
        outline: none !important;
    }

    #roleSelect option {
        color: #334155;
        background-color: #ffffff;
    }
</style>

<section class="relative overflow-hidden bg-slate-50 min-h-screen flex items-center font-sans antialiased w-full">
    <div class="absolute right-0 bottom-0 w-full max-w-5xl pointer-events-none opacity-30 lg:opacity-80 z-0 select-none animate-pulse duration-[8000ms]">
        <svg viewBox="0 0 700 500" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg" class="w-full h-auto block">
            <path d="M700,170 C470,40 270,300 0,500 L700,500 Z" fill="#FCEAEF" />
        </svg>
    </div>

    <div class="relative z-10 w-full max-w-[90rem] mx-auto px-4 sm:px-6 md:px-12 lg:px-12 py-12 lg:py-0">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-16 items-center min-h-screen w-full">

            <div class="hidden lg:flex lg:col-span-5 flex-col items-center lg:items-start text-center lg:text-left justify-center py-12">
                <div class="relative w-64 h-64 mb-8 flex items-center justify-center group select-none">
                    <div class="absolute inset-0 rounded-full border-2 border-dashed border-red-200 group-hover:border-red-500/40 transition-colors duration-500 animate-[spin_40s_linear_infinite]"></div>
                    <div class="w-48 h-48 bg-white/70 backdrop-blur-md rounded-[2.5rem] shadow-xl shadow-slate-200/50 border border-white/80 flex items-center justify-center p-6 transition-all duration-500 transform group-hover:scale-105 group-hover:shadow-2xl animate-[bounce_6s_infinite_ease-in-out]">
                        <svg viewBox="0 0 240 260" xmlns="http://www.w3.org/2000/svg" class="w-full h-auto drop-shadow-[0_10px_15px_rgba(220,38,38,0.2)] max-w-[120px]">
                            <path d="M120,30 C150,68 178,112 178,140 C178,170 152,192 120,192 C88,192 62,170 62,140 C62,112 90,68 120,30 Z" fill="url(#dropGrad)" />
                            <path d="M120,115 L120,155 M100,135 L140,135" stroke="#FFFFFF" stroke-width="10" stroke-linecap="round" />
                            <defs>
                                <linearGradient id="dropGrad" x1="0%" y1="0%" x2="100%" y2="100%">
                                    <stop offset="0%" stop-color="#EF4444" />
                                    <stop offset="100%" stop-color="#991B1B" />
                                </linearGradient>
                            </defs>
                        </svg>
                    </div>
                </div>

                <h3 id="displayHeadline" class="font-black text-4xl xl:text-5xl text-slate-900 tracking-tight transition-all duration-300">Become a Hero Today</h3>
                <p id="displaySubtext" class="text-base sm:text-lg text-slate-500 font-medium mt-4 max-w-xl leading-relaxed transition-all duration-300">
                    Join our secure network of lifesavers. Register as an active blood donor volunteer to receive real-time notifications and support local emergency requirements.
                </p>
            </div>

            <div class="lg:col-span-7 flex justify-center lg:justify-end w-full py-6 lg:py-12">
                <div class="bg-white border border-slate-200/80 rounded-3xl p-6 sm:p-10 md:p-12 shadow-xl shadow-slate-100/50 w-full max-w-full transition-all duration-500 hover:shadow-2xl hover:shadow-slate-200/40">

                    <div>
                        <h2 id="formTitle" class="font-black text-2xl sm:text-3xl text-slate-900 tracking-tight">Create Account</h2>
                        <p class="text-xs sm:text-sm text-slate-400 font-medium mt-1">Configure your portal credential profile details safely.</p>
                    </div>

                    <?php if (!empty($success)): ?>
                        <div class="mt-6 p-4 bg-emerald-50 border border-emerald-200 rounded-xl animate-fade-in">
                            <p class="text-emerald-700 text-sm font-semibold flex items-center gap-2"><i class="fa-solid fa-circle-check"></i> <?= htmlspecialchars($success, ENT_QUOTES) ?></p>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($errors) && isset($errors['form'])): ?>
                        <div class="mt-6 p-4 bg-red-50 border border-red-200 rounded-xl animate-fade-in">
                            <p class="text-red-600 text-sm font-semibold flex items-center gap-2"><i class="fa-solid fa-circle-exclamation"></i> <?= htmlspecialchars($errors['form'], ENT_QUOTES) ?></p>
                        </div>
                    <?php endif; ?>

                    <form id="unifiedRegisterForm" method="POST" action="/donor/register" class="space-y-5">

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                            <div class="space-y-1.5 group">
                                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide transition-colors group-focus-within:text-red-600">Username</label>
                                <div class="relative">
                                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none text-base transition-colors group-focus-within:text-red-500">
                                        <i class="fa-regular fa-user"></i>
                                    </span>
                                    <input type="text" id="regUsername" name="username" placeholder="Choose unique name"
                                        value="<?= htmlspecialchars($old['username'] ?? '', ENT_QUOTES) ?>"
                                        class="w-full bg-white border border-slate-200 rounded-xl pl-11 pr-4 py-3 text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:border-red-500 focus:ring-4 focus:ring-red-500/5 transition duration-150 font-medium">
                                </div>
                                <p id="regUsernameFieldError" class="text-red-600 text-xs font-semibold mt-1 items-center gap-1.5 animate-fade-in <?= empty($errors['username']) ? 'hidden' : 'flex' ?>">
                                    <i class="fa-solid fa-circle-exclamation"></i> <?= htmlspecialchars($errors['username'] ?? '', ENT_QUOTES) ?>
                                </p>
                            </div>

                            <div class="space-y-1.5 group">
                                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide transition-colors group-focus-within:text-red-600">Email Address</label>
                                <div class="relative">
                                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none text-base transition-colors group-focus-within:text-red-500">
                                        <i class="fa-regular fa-envelope"></i>
                                    </span>
                                    <input type="email" id="regEmail" name="email" placeholder="name@example.com"
                                        value="<?= htmlspecialchars($old['email'] ?? '', ENT_QUOTES) ?>"
                                        class="w-full bg-white border border-slate-200 rounded-xl pl-11 pr-4 py-3 text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:border-red-500 focus:ring-4 focus:ring-red-500/5 transition duration-150 font-medium">
                                </div>
                                <p id="regEmailFieldError" class="text-red-600 text-xs font-semibold mt-1 items-center gap-1.5 animate-fade-in <?= empty($errors['email']) ? 'hidden' : 'flex' ?>">
                                    <i class="fa-solid fa-circle-exclamation"></i> <?= htmlspecialchars($errors['email'] ?? '', ENT_QUOTES) ?>
                                </p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                            <div class="space-y-1.5 group">
                                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide transition-colors group-focus-within:text-red-600">Phone Number</label>
                                <div class="relative">
                                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none text-base transition-colors group-focus-within:text-red-500">
                                        <i class="fa-solid fa-phone"></i>
                                    </span>
                                    <input
                                        type="tel"
                                        id="regPhone"
                                        name="phone"
                                        placeholder="09xxxxxxxxx"
                                        value="<?= htmlspecialchars($old['phone'] ?? '', ENT_QUOTES) ?>"

                                        maxlength="11"
                                        pattern="^09[0-9]{9}$"
                                        inputmode="numeric"
                                        oninput="this.value=this.value.replace(/[^0-9]/g,'').slice(0,11)"
                                        class="w-full bg-white border border-slate-200 rounded-xl pl-11 pr-4 py-3 text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:border-red-500 focus:ring-4 focus:ring-red-500/5 transition duration-150 font-medium">
                                </div>
                                <p id="regPhoneFieldError"
                                    class="text-red-600 text-xs font-semibold mt-1 items-center gap-1.5 <?= empty($errors['phone']) ? 'hidden' : 'flex' ?>">
                                    <i class="fa-solid fa-circle-exclamation"></i>
                                    <?= htmlspecialchars($errors['phone'] ?? '', ENT_QUOTES) ?>
                                </p>
                            </div>

                            <div class="space-y-1.5 group">
                                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide transition-colors group-focus-within:text-red-600">Blood Group</label>
                                <div class="relative">
                                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-red-500/80 pointer-events-none text-base">
                                        <i class="fa-solid fa-droplet"></i>
                                    </span>
                                    <select id="regBloodGroup" name="blood_group"
                                        class="w-full bg-white border border-slate-200 rounded-xl pl-11 pr-10 py-3 text-sm text-slate-700 focus:outline-none focus:border-red-500 focus:ring-4 focus:ring-red-500/5 transition duration-150 font-medium appearance-none cursor-pointer">
                                        <option value="" disabled <?= empty($old['blood_group']) ? 'selected' : '' ?>>Select Group</option>
                                        <?php foreach (['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'] as $bg): ?>
                                            <option value="<?= $bg ?>" <?= ($old['blood_group'] ?? '') === $bg ? 'selected' : '' ?>><?= $bg ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <span class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none text-xs">
                                        <i class="fa-solid fa-chevron-down"></i>
                                    </span>
                                </div>
                                <p id="regBloodGroupFieldError" class="text-red-600 text-xs font-semibold mt-1 items-center gap-1.5 animate-fade-in <?= empty($errors['blood_group']) ? 'hidden' : 'flex' ?>">
                                    <i class="fa-solid fa-circle-exclamation"></i> <?= htmlspecialchars($errors['blood_group'] ?? '', ENT_QUOTES) ?>
                                </p>
                            </div>
                        </div>

                        <!-- <div class="space-y-1.5 group">
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide transition-colors group-focus-within:text-red-600">Address / Location</label>
                            <div class="relative">
                                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none text-base transition-colors group-focus-within:text-red-500">
                                    <i class="fa-solid fa-location-dot"></i>
                                </span>
                                <input type="text" id="regAddress" name="address" placeholder="Enter city or living area address details"
                                    value="<?= htmlspecialchars($old['address'] ?? '', ENT_QUOTES) ?>" 
                                    class="w-full bg-white border border-slate-200 rounded-xl pl-11 pr-4 py-3 text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:border-red-500 focus:ring-4 focus:ring-red-500/5 transition duration-150 font-medium">
                            </div>
                            <p id="regAddressFieldError" class="text-red-600 text-xs font-semibold mt-1 items-center gap-1.5 animate-fade-in <?= empty($errors['address']) ? 'hidden' : 'flex' ?>">
                                <i class="fa-solid fa-circle-exclamation"></i> <?= htmlspecialchars($errors['address'] ?? '', ENT_QUOTES) ?>
                            </p>
                        </div> -->

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                            <div class="space-y-1.5 group">
                                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide transition-colors group-focus-within:text-red-600">Password</label>
                                <div class="relative">
                                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none text-base transition-colors group-focus-within:text-red-500">
                                        <i class="fa-solid fa-lock"></i>
                                    </span>
                                    <input type="password" id="regPassword" name="password" placeholder="Create security password"
                                        class="w-full bg-white border border-slate-200 rounded-xl pl-11 pr-12 py-3 text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:border-red-500 focus:ring-4 focus:ring-red-500/5 transition duration-150 font-medium">
                                    <button type="button" onclick="togglePasswordVisibility('regPassword', 'togglePasswordIcon')" class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 focus:outline-none transition">
                                        <i id="togglePasswordIcon" class="fa-regular fa-eye"></i>
                                    </button>
                                </div>
                                <p id="regPasswordFieldError" class="text-red-600 text-xs font-semibold mt-1 items-center gap-1.5 animate-fade-in <?= empty($errors['password']) ? 'hidden' : 'flex' ?>">
                                    <i class="fa-solid fa-circle-exclamation"></i> <?= htmlspecialchars($errors['password'] ?? '', ENT_QUOTES) ?>
                                </p>
                            </div>

                            <div class="space-y-1.5 group">
                                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide transition-colors group-focus-within:text-red-600">Confirm Password</label>
                                <div class="relative">
                                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none text-base transition-colors group-focus-within:text-red-500">
                                        <i class="fa-solid fa-shield-halved"></i>
                                    </span>
                                    <input type="password" id="regConfirmPassword" name="confirm_password" placeholder="Retype secret token"
                                        class="w-full bg-white border border-slate-200 rounded-xl pl-11 pr-12 py-3 text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:border-red-500 focus:ring-4 focus:ring-red-500/5 transition duration-150 font-medium">
                                    <button type="button" onclick="togglePasswordVisibility('regConfirmPassword', 'toggleConfirmPasswordIcon')" class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 focus:outline-none transition">
                                        <i id="toggleConfirmPasswordIcon" class="fa-regular fa-eye"></i>
                                    </button>
                                </div>
                                <p id="regConfirmPasswordFieldError" class="text-red-600 text-xs font-semibold mt-1 items-center gap-1.5 animate-fade-in <?= empty($errors['confirm_password']) ? 'hidden' : 'flex' ?>">
                                    <i class="fa-solid fa-circle-exclamation"></i> <?= htmlspecialchars($errors['confirm_password'] ?? '', ENT_QUOTES) ?>
                                </p>
                            </div>
                        </div>

                        <div class="space-y-1.5 group">
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide transition-colors group-focus-within:text-red-600">Role</label>
                            <div class="relative">
                                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none text-base transition-colors group-focus-within:text-red-500">
                                    <i class="fa-solid fa-user-gear"></i>
                                </span>
                                <button type="button" id="roleTrigger"
                                    class="w-full bg-white border border-slate-200 rounded-xl pl-11 pr-10 py-3 text-sm text-slate-700 focus:outline-none focus:border-red-500 transition duration-150 font-medium cursor-pointer flex items-center justify-between">
                                    <span id="roleTriggerText"><?= empty($current_role) ? 'Choose Role' : ($current_role === 'donor' ? 'Donor' : 'Patient') ?></span>
                                    <i class="fa-solid fa-chevron-down text-slate-400"></i>
                                </button>
                                <div id="roleMenu" class="hidden absolute z-20 mt-2 w-full rounded-xl border border-slate-200 bg-white shadow-lg overflow-hidden">
                                    <button type="button" class="role-option w-full px-4 py-3 text-left text-sm text-slate-700 hover:bg-red-50 hover:text-red-600 transition" data-value="" data-label="Choose Role">Choose Role</button>
                                    <button type="button" class="role-option w-full px-4 py-3 text-left text-sm text-slate-700 hover:bg-red-50 hover:text-red-600 transition" data-value="donor" data-label="Donor">Donor</button>
                                    <button type="button" class="role-option w-full px-4 py-3 text-left text-sm text-slate-700 hover:bg-red-50 hover:text-red-600 transition" data-value="patient" data-label="Patient">Patient</button>
                                </div>
                                <select id="roleSelect" name="role" required class="sr-only">
                                    <option value="" disabled <?= empty($current_role) ? 'selected' : '' ?>>Choose Role</option>
                                    <option value="donor" <?= $current_role === 'donor' ? 'selected' : '' ?>>Donor</option>
                                    <option value="patient" <?= $current_role === 'patient' ? 'selected' : '' ?>>Patient</option>
                                </select>
                            </div>
                            <p id="regRoleFieldError" class="text-red-600 text-xs font-semibold mt-1 items-center gap-1.5 animate-fade-in <?= empty($errors['role']) ? 'hidden' : 'flex' ?>">
                                <i class="fa-solid fa-circle-exclamation"></i> <?= htmlspecialchars($errors['role'] ?? '', ENT_QUOTES) ?>
                            </p>
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

                        <button type="submit" id="submitBtn" class="w-full bg-red-600 hover:bg-red-700 text-white font-bold py-3.5 px-6 rounded-xl text-base shadow-md shadow-red-600/10 active:scale-[0.99] transition duration-150 mt-2">
                            Register Profile
                        </button>

                        <div class="relative flex items-center">
                            <div class="flex-grow border-t border-slate-200"></div>
                            <span class="flex-shrink mx-4 text-xs font-bold text-slate-400 uppercase">or</span>
                            <div class="flex-grow border-t border-slate-200"></div>
                        </div>

                        <a href="<?= $basePath ?? '' ?>/auth/google"
                            class="w-full flex items-center justify-center gap-3 bg-white border border-slate-200 hover:border-red-300 hover:bg-red-50/30 text-slate-700 font-bold py-3.5 px-6 rounded-xl text-sm shadow-sm active:scale-[0.99] transition duration-150">
                            <i class="fa-brands fa-google text-red-500 text-lg"></i>
                            Continue with Google
                        </a>

                        <div class="text-center pt-2">
                            <p class="text-sm text-slate-400 font-semibold">
                                Already have an account?
                                <a href="/BloodConnect/public/login"
                                    class="text-red-600 hover:text-red-700 font-bold transition ml-1 hover:underline">
                                    Sign in
                                </a>
                            </p>
                        </div>
                    </form>

                </div>
            </div>

        </div>
    </div>
</section>

<script>
    const BASE_URL = window.location.origin + "/BloodConnect/public";

    // Dynamic visibility toggle logic
    function togglePasswordVisibility(inputId, iconId) {
        const inputField = document.getElementById(inputId);
        const iconElement = document.getElementById(iconId);

        if (inputField.type === "password") {
            inputField.type = "text";
            iconElement.classList.remove("fa-regular", "fa-eye");
            iconElement.classList.add("fa-solid", "fa-eye-slash");
        } else {
            inputField.type = "password";
            iconElement.classList.remove("fa-solid", "fa-eye-slash");
            iconElement.classList.add("fa-regular", "fa-eye");
        }
    }

    function updateRoleLayout(targetRole) {
        const submitBtn = document.getElementById("submitBtn");
        const unifiedForm = document.getElementById("unifiedRegisterForm");
        const displayHeadline = document.getElementById("displayHeadline");
        const displaySubtext = document.getElementById("displaySubtext");

        if (targetRole === 'donor') {
            submitBtn.innerText = "Register As Donor";
            unifiedForm.action = BASE_URL + "/donor/register";
            displayHeadline.innerText = "Become a Hero Today";
            displaySubtext.innerText = "Join our secure network of lifesavers. Register as an active blood donor volunteer to receive real-time notifications and support local emergency requirements.";
        } else if (targetRole === 'patient') {
            submitBtn.innerText = "Register As Patient";
            unifiedForm.action = BASE_URL + "/patient/register";
            displayHeadline.innerText = "Need Urgent Assistance?";
            displaySubtext.innerText = "Create emergency blood request profile. Instantly broadcast your requests to find verified donor emergency answers nearby.";
        }
    }

    document.addEventListener("DOMContentLoaded", function() {
        const roleSelect = document.getElementById("roleSelect");
        const roleTrigger = document.getElementById("roleTrigger");
        const roleTriggerText = document.getElementById("roleTriggerText");
        const roleMenu = document.getElementById("roleMenu");
        const roleOptions = document.querySelectorAll(".role-option");

        function setRoleSelection(value, label) {
            roleSelect.value = value;
            roleTriggerText.textContent = label;
            roleMenu.classList.add("hidden");
            updateRoleLayout(value || '');
        }

        roleTrigger.addEventListener("click", function() {
            roleMenu.classList.toggle("hidden");
        });

        roleOptions.forEach(function(option) {
            option.addEventListener("click", function() {
                setRoleSelection(option.dataset.value, option.dataset.label);
            });
        });

        document.addEventListener("click", function(event) {
            if (!roleTrigger.contains(event.target) && !roleMenu.contains(event.target)) {
                roleMenu.classList.add("hidden");
            }
        });

        const initialValue = roleSelect.value || '';
        const initialLabel = initialValue === 'donor' ?
            'Donor' :
            initialValue === 'patient' ?
            'Patient' :
            'Choose Role';
        roleTriggerText.textContent = initialLabel;
        updateRoleLayout(initialValue);
    });

    const registerForm = document.getElementById("unifiedRegisterForm");
    if (registerForm) {
        registerForm.addEventListener("submit", function(e) {
            const roleSelect = document.getElementById("roleSelect");
            const username = document.getElementById("regUsername");
            const email = document.getElementById("regEmail");
            const phone = document.getElementById("regPhone");
            const bloodGroup = document.getElementById("regBloodGroup");
            // const address = document.getElementById("regAddress");
            const password = document.getElementById("regPassword");
            const confirmPassword = document.getElementById("regConfirmPassword");

            const errors = {
                role: document.getElementById("regRoleFieldError"),
                username: document.getElementById("regUsernameFieldError"),
                email: document.getElementById("regEmailFieldError"),
                phone: document.getElementById("regPhoneFieldError"),
                bloodGroup: document.getElementById("regBloodGroupFieldError"),
                // address: document.getElementById("regAddressFieldError"),
                password: document.getElementById("regPasswordFieldError"),
                confirmPassword: document.getElementById("regConfirmPasswordFieldError")
            };

            const setError = (input, errorElement, condition, message) => {
                if (condition) {
                    input.classList.add("border-red-500", "focus:ring-red-100");
                    if (errorElement) {
                        errorElement.innerHTML = '<i class="fa-solid fa-circle-exclamation"></i> ' + message;
                        errorElement.classList.remove("hidden");
                        errorElement.classList.add("flex");
                    }
                    return true;
                }
                input.classList.remove("border-red-500", "focus:ring-red-100");
                if (errorElement) {
                    errorElement.classList.add("hidden");
                    errorElement.classList.remove("flex");
                }
                return false;
            };

            let formIsValid = true;
            formIsValid = !setError(roleSelect, errors.role, !roleSelect.value, "Please select a role to proceed.") && formIsValid;
            formIsValid = !setError(username, errors.username, !username.value.trim(), "Username is required.") && formIsValid;
            formIsValid = !setError(email, errors.email, (!email.value.trim() || !email.value.includes('@')), "Please enter a valid email address.") && formIsValid;
            formIsValid = !setError(phone, errors.phone, !phone.value.trim(), "Phone number is required.") && formIsValid;
            formIsValid = !setError(bloodGroup, errors.bloodGroup, !bloodGroup.value, "Please select your blood group.") && formIsValid;
            // formIsValid = !setError(address, errors.address, !address.value.trim(), "Address is required.") && formIsValid;
            formIsValid = !setError(password, errors.password, password.value.length < 6, "Password must be at least 6 characters.") && formIsValid;
            formIsValid = !setError(confirmPassword, errors.confirmPassword, (password.value !== confirmPassword.value || !confirmPassword.value), "Passwords do not match.") && formIsValid;

            if (!formIsValid) {
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
    const phoneInput = document.getElementById('regPhone');

    phoneInput.addEventListener('input', function() {

        // Only digits
        this.value = this.value.replace(/\D/g, '');

        // Maximum 11 digits
        if (this.value.length > 11) {
            this.value = this.value.substring(0, 11);
        }

        // Must start with 09
        if (this.value.length >= 2 && !this.value.startsWith('09')) {
            this.setCustomValidity('Myanmar phone numbers must start with 09.');
        } else if (this.value.length > 0 && this.value.length != 11) {
            this.setCustomValidity('Phone number must contain exactly 11 digits.');
        } else {
            this.setCustomValidity('');
        }
    });
</script>