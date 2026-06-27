<!doctype html>
<?php
$basePath = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME']));
if ($basePath === '/' || $basePath === '\\') {
    $basePath = '';
}

$errors = $_SESSION['errors'] ?? [];
$old = $_SESSION['old'] ?? [];
unset($_SESSION['errors'], $_SESSION['old']);
?>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>BloodConnect — Register</title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@600;700;800&family=Inter:wght@400;500;600;700&display=swap"
        rel="stylesheet" />
    <style>
        :root {
            --crimson: #c8102e;
            --crimson-dark: #a30e27;
            --pink-bg: #fceaef;
            --pink-soft: #f4aec0;
            --border-gray: #e4e4e9;
            --placeholder: #9ca3af;
            --ink: #1b1b1f;
            --gray: #6b6b76;
            --white: #ffffff;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: "Inter", sans-serif;
            color: var(--ink);
            background: var(--white);
            overflow-x: hidden;
        }

        h1,
        h2,
        h3 {
            font-family: "Poppins", sans-serif;
        }

        /* ---------- NAVBAR ---------- */
        .navbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 18px 60px;
            background: var(--white);
            border-bottom: 1px solid #f2f2f4;
            position: relative;
            z-index: 5;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .logo svg {
            width: 26px;
            height: 32px;
            flex-shrink: 0;
        }

        .logo .brand-name {
            font-size: 19px;
            font-weight: 700;
            line-height: 1.1;
        }

        .logo .brand-name .accent {
            color: var(--crimson);
        }

        .logo .brand-tagline {
            font-size: 11px;
            color: var(--gray);
            font-weight: 400;
        }

        .nav-links {
            display: flex;
            gap: 34px;
            list-style: none;
        }

        .nav-links a {
            text-decoration: none;
            color: #3a3a40;
            font-weight: 500;
            font-size: 14.5px;
        }

        .nav-actions {
            display: flex;
            align-items: center;
            gap: 26px;
        }

        .login-link {
            color: var(--ink);
            font-weight: 600;
            font-size: 14.5px;
            text-decoration: none;
        }

        .btn {
            font-family: "Inter", sans-serif;
            font-weight: 700;
            font-size: 14.5px;
            border-radius: 8px;
            cursor: pointer;
            border: none;
            transition: transform 0.15s ease;
        }

        .btn:hover {
            transform: translateY(-1px);
        }

        .btn-filled {
            background: var(--crimson);
            color: var(--white);
            padding: 10px 20px;
        }

        /* ---------- REGISTER SECTION ---------- */
        .register-section {
            position: relative;
            overflow: hidden;
            padding: 80px 60px 140px;
            min-height: 780px;
        }

        .decor-wave {
            position: absolute;
            left: 0;
            bottom: 0;
            width: 60%;
            max-width: 760px;
            z-index: 0;
            line-height: 0;
            pointer-events: none;
        }

        .decor-wave svg {
            width: 100%;
            height: auto;
            display: block;
        }

        .register-inner {
            position: relative;
            z-index: 1;
            max-width: 1280px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: 1fr 1.05fr;
            gap: 70px;
            align-items: flex-start;
        }

        /* ----- left column ----- */
        .register-left h2 {
            font-size: 40px;
            font-weight: 800;
            line-height: 1.25;
        }

        .register-left h2 .accent {
            color: var(--crimson);
        }

        .underline-bar {
            display: block;
            width: 50px;
            height: 4px;
            border-radius: 2px;
            background: var(--crimson);
            margin: 22px 0 26px;
        }

        .register-left p {
            font-size: 15px;
            color: var(--gray);
            line-height: 1.8;
            max-width: 380px;
            text-indent: 18px;
        }

        .illustration {
            width: 270px;
            margin-top: 46px;
        }

        .illustration svg {
            width: 100%;
            height: auto;
            display: block;
        }

        /* ----- right column / card ----- */
        .register-card {
            background: var(--white);
            border: 1px solid #f1e2e7;
            border-radius: 20px;
            box-shadow: 0 18px 45px rgba(40, 10, 20, 0.07);
            padding: 48px 52px 44px;
        }

        .register-card h3 {
            font-size: 26px;
            font-weight: 800;
            text-align: center;
        }

        .card-sub {
            text-align: center;
            color: var(--gray);
            font-size: 14px;
            margin-top: 8px;
            margin-bottom: 32px;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 22px;
        }

        .field {
            margin-bottom: 22px;
        }

        .field label {
            display: block;
            font-size: 13.5px;
            font-weight: 700;
            margin-bottom: 9px;
        }

        .field input,
        .field select {
            width: 100%;
            border: 1px solid var(--border-gray);
            border-radius: 10px;
            padding: 13px 16px;
            font-size: 14px;
            font-family: "Inter", sans-serif;
            color: var(--ink);
            background: var(--white);
            outline: none;
        }

        .field input::placeholder {
            color: var(--placeholder);
        }

        .field input:focus,
        .field select:focus {
            border-color: var(--crimson);
        }

        .input-icon {
            position: relative;
        }

        .input-icon input {
            padding-right: 46px;
        }

        .input-icon svg {
            position: absolute;
            right: 16px;
            top: 50%;
            transform: translateY(-50%);
            width: 19px;
            height: 19px;
            color: #8c8c95;
            cursor: pointer;
        }

        .select-wrap {
            position: relative;
        }

        .select-wrap select {
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            padding-right: 40px;
            cursor: pointer;
        }

        .select-wrap svg {
            position: absolute;
            right: 16px;
            top: 50%;
            transform: translateY(-50%);
            width: 16px;
            height: 16px;
            pointer-events: none;
            color: #3a3a40;
        }

        .btn-full {
            width: 100%;
            padding: 16px;
            font-size: 15px;
            border-radius: 10px;
        }

        .btn-outline-full {
            width: 100%;
            padding: 15px;
            font-size: 15px;
            border-radius: 10px;
            background: var(--white);
            color: var(--crimson);
            border: 1.5px solid var(--crimson);
            font-weight: 700;
            cursor: pointer;
            font-family: "Inter", sans-serif;
        }

        .divider {
            display: flex;
            align-items: center;
            gap: 14px;
            margin: 24px 0;
        }

        .divider .line {
            flex: 1;
            height: 1px;
            background: #e6e6ea;
        }

        .divider span {
            font-size: 13px;
            color: var(--gray);
        }

        .login-text {
            text-align: center;
            margin-top: 24px;
            font-size: 14px;
            color: #3a3a40;
        }

        .login-text a {
            color: var(--crimson);
            font-weight: 700;
            text-decoration: underline;
        }

        .field-error {
            color: var(--crimson);
            font-size: 12.5px;
            margin-top: 6px;
            display: none;
        }

        .field-error.show {
            display: block;
        }

        .field input.input-error {
            border-color: var(--crimson);
        }

        /* ---------- RESPONSIVE ---------- */
        @media (max-width: 980px) {
            .navbar {
                flex-wrap: wrap;
                gap: 14px;
                padding: 16px 24px;
            }

            .nav-links {
                order: 3;
                width: 100%;
                justify-content: center;
                gap: 18px;
                flex-wrap: wrap;
            }

            .register-section {
                padding: 50px 24px 100px;
            }

            .register-inner {
                grid-template-columns: 1fr;
                gap: 50px;
            }

            .register-card {
                padding: 36px 26px;
            }

            .form-row {
                grid-template-columns: 1fr;
            }

            .illustration {
                margin: 40px auto 0;
            }

            .register-left {
                text-align: center;
            }

            .register-left p {
                margin: 0 auto;
                text-indent: 0;
            }

            .underline-bar {
                margin: 22px auto 26px;
            }
        }
    </style>
</head>

<body>
    <!-- ============ NAVBAR ============ -->
    <header class="navbar">
        <div class="logo">
            <svg viewBox="0 0 28 34" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M14 0C14 0 2 15.5 2 22.5C2 28.85 7.373 34 14 34C20.627 34 26 28.85 26 22.5C26 15.5 14 0 14 0Z"
                    fill="#C8102E" />
                <path
                    d="M9.5 22.5C9.5 22.5 11 26.5 14 26.5"
                    stroke="#FBE0E7"
                    stroke-width="2"
                    stroke-linecap="round" />
            </svg>
            <div>
                <div class="brand-name">BloodConnect</div>
                <div class="brand-tagline">Donate Blood, Save Lives</div>
            </div>
        </div>

        <ul class="nav-links">
            <li><a href="<?= $basePath ?>/" class="active">Home</a></li>
            <li><a href="<?= $basePath ?>/register">Search Donor</a></li>
            <li><a href="<?= $basePath ?>/register">Blood Requests</a></li>
            <li><a href="<?= $basePath ?>/donor/register">Donors</a></li>
            <li><a href="<?= $basePath ?>/contact">Contact</a></li>
            <li><a href="<?= $basePath ?>/about">About</a></li>
        </ul>

        <div class="nav-actions">
            <a href="<?= $basePath ?>/login" class="btn btn-outline">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none">
                    <path
                        d="M12 12c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5Zm0 2c-3.31 0-10 1.66-10 5v3h20v-3c0-3.34-6.69-5-10-5Z"
                        fill="currentColor" />
                </svg>
                Login
            </a>
            <a href="<?= $basePath ?>/register" class="btn btn-filled">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none">
                    <path
                        d="M15 12c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5Zm-6 2c-3.31 0-10 1.66-10 5v3h13.55c-.34-.91-.55-1.95-.55-3 0-2.06.78-3.93 2.05-5.36C13.13 13.61 11.6 14 10 14H9Zm12 1v3h3v-3h-3Zm0 5v3h-3v-3h3Zm3-5h-3v3h3v-3Z"
                        fill="currentColor" />
                </svg>
                Register
            </a>
        </div>
    </header>

    <!-- ============ REGISTER SECTION ============ -->
    <section class="register-section">
        <div class="decor-wave">
            <svg
                viewBox="0 0 700 500"
                preserveAspectRatio="none"
                xmlns="http://www.w3.org/2000/svg">
                <path d="M0,170 C230,40 430,300 700,500 L0,500 Z" fill="#FCEAEF" />
            </svg>
        </div>

        <div class="register-inner">
            <!-- left column -->
            <div class="register-left">
                <h2>
                    Join <span class="accent">BloodConnect</span><br />and Save Lives
                </h2>
                <span class="underline-bar"></span>
                <p>
                    Create your account to find blood donors, submit requests, and be a
                    part of a community that saves lives.
                </p>

                <div class="illustration">
                    <svg viewBox="0 0 300 300" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="150" cy="150" r="140" fill="#FCEAF0" />

                        <!-- left small drop -->
                        <path
                            d="M62,200 C74,214 84,228 78,242 C73,252 58,254 51,245 C44,236 50,219 62,200 Z"
                            fill="#F4AEC0" />
                        <!-- right small drop -->
                        <path
                            d="M238,200 C226,214 216,228 222,242 C227,252 242,254 249,245 C256,236 250,219 238,200 Z"
                            fill="#F4AEC0" />

                        <!-- big drop -->
                        <path
                            d="M150,38 C192,90 226,150 226,186 C226,229 191,256 150,256 C109,256 74,229 74,186 C74,150 108,90 150,38 Z"
                            fill="#C8102E" />

                        <!-- plus -->
                        <rect
                            x="138"
                            y="134"
                            width="24"
                            height="92"
                            rx="8"
                            fill="#FFFFFF" />
                        <rect
                            x="104"
                            y="168"
                            width="92"
                            height="24"
                            rx="8"
                            fill="#FFFFFF" />
                    </svg>
                </div>
            </div>

            <!-- right column / form card -->
            <div class="register-card">
                <h3>Create Your Account</h3>
                <p class="card-sub">Fill in the details below to get started.</p>

                <?php if (!empty($errors)): ?>
                    <div class="form-errors">
                        <?php foreach ($errors as $error): ?>
                            <p class="field-error show"><?= htmlspecialchars($error, ENT_QUOTES) ?></p>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <form id="registerForm" novalidate method="post" action="<?= $basePath ?>/auth/register-patient">
                    <div class="form-row">
                        <div class="field">
                            <label>Username</label>
                            <input
                                type="text"
                                id="username"
                                name="username"
                                placeholder="Choose a username"
                                value="<?= htmlspecialchars($old['username'] ?? '', ENT_QUOTES) ?>"
                                required />
                        </div>
                        <div class="field">
                            <label>Email Address</label>
                            <input
                                type="email"
                                id="email"
                                name="email"
                                placeholder="Enter your email"
                                value="<?= htmlspecialchars($old['email'] ?? '', ENT_QUOTES) ?>"
                                required />
                        </div>
                    </div>

                    <div class="field">
                        <label>Phone Number</label>
                        <input
                            type="tel"
                            id="phone"
                            name="phone"
                            placeholder="Enter your phone number"
                            value="<?= htmlspecialchars($old['phone'] ?? '', ENT_QUOTES) ?>"
                            maxlength="11"
                            pattern="\d{11}"
                            inputmode="numeric"
                            required />
                    </div>

                    <div class="field">
                        <label>Password</label>
                        <div class="input-icon">
                            <input
                                type="password"
                                id="password"
                                name="password"
                                placeholder="Create a password"
                                required
                                minlength="6" />
                            <svg
                                class="toggle-pwd"
                                data-target="password"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="1.8"
                                stroke-linecap="round"
                                stroke-linejoin="round">
                                <path
                                    d="M1.5 12S5 5 12 5s10.5 7 10.5 7-3.5 7-10.5 7S1.5 12 1.5 12Z" />
                                <circle cx="12" cy="12" r="3" />
                            </svg>
                        </div>
                    </div>

                    <div class="field">
                        <label>Confirm Password</label>
                        <div class="input-icon">
                            <input
                                type="password"
                                id="confirmPassword"
                                name="confirm_password"
                                placeholder="Confirm your password"
                                required />
                            <svg
                                class="toggle-pwd"
                                data-target="confirmPassword"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="1.8"
                                stroke-linecap="round"
                                stroke-linejoin="round">
                                <path
                                    d="M1.5 12S5 5 12 5s10.5 7 10.5 7-3.5 7-10.5 7S1.5 12 1.5 12Z" />
                                <circle cx="12" cy="12" r="3" />
                            </svg>
                        </div>
                        <span class="field-error" id="pwdError">Passwords do not match.</span>
                    </div>
                    <span class="field-error" id="registerFormError">Please fill in all required fields and enter an 11-digit phone number.</span>

                    <!-- <div class="field">
                        <label>Select Your Role</label>
                        <div class="select-wrap">
                            <select id="role" name="role" required>
                                <option value="" disabled <?= empty($old['role']) ? 'selected' : '' ?>>Choose your role</option>
                                <option value="donor" <?= (isset($old['role']) && $old['role'] === 'donor') ? 'selected' : '' ?>>Donor</option>
                                <option value="patient" <?= (isset($old['role']) && $old['role'] === 'patient') ? 'selected' : '' ?>>Patient</option>

                            </select>
                            <svg
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                                stroke-linecap="round"
                                stroke-linejoin="round">
                                <path d="M6 9l6 6 6-6" />
                            </svg>
                        </div>
                    </div> -->

                    <button type="submit" class="btn btn-filled btn-full">
                        Sign Up
                    </button>

                    <!-- <div class="divider">
                        <span class="line"></span>
                        <span>or</span>
                        <span class="line"></span>
                    </div> -->

                    <!-- <button type="button" class="btn-outline-full" id="googleBtn">
                        Sign Up with Google
                    </button> -->

                    <p class="login-link">
                        Already have an account? <a href="<?= $basePath ?>/login" id="loginText">Log In</a>
                    </p>
                </form>
            </div>
        </div>
    </section>

    <script>
        // Show / hide password
        document.querySelectorAll(".toggle-pwd").forEach((icon) => {
            icon.addEventListener("click", () => {
                const input = document.getElementById(icon.dataset.target);
                input.type = input.type === "password" ? "text" : "password";
            });
        });

        // Form validation + submit
        document
            .getElementById("registerForm")
            .addEventListener("submit", (e) => {
                const username = document.getElementById("username");
                const email = document.getElementById("email");
                const phone = document.getElementById("phone");
                const password = document.getElementById("password");
                const confirmPassword = document.getElementById("confirmPassword");
                const pwdError = document.getElementById("pwdError");
                const registerError = document.getElementById("registerFormError");

                const mismatch = password.value !== confirmPassword.value;
                const invalidPhone = phone.value.trim().length !== 11;
                const formValid = e.target.checkValidity();
                const invalid = mismatch || !formValid || invalidPhone;

                username.classList.toggle("input-error", !username.value.trim());
                email.classList.toggle("input-error", !email.value.trim());
                phone.classList.toggle("input-error", invalidPhone);
                password.classList.toggle("input-error", !password.value.trim());
                confirmPassword.classList.toggle("input-error", mismatch || !confirmPassword.value.trim());

                confirmPassword.classList.toggle("input-error", mismatch);
                pwdError.classList.toggle("show", mismatch);
                registerError.classList.toggle("show", invalid);

                if (invalid) {
                    e.preventDefault();
                    return;
                }

                // allow normal form submission to server
            });

        const googleBtn = document.getElementById("googleBtn");
        if (googleBtn) {
            googleBtn.addEventListener("click", () => alert("Sign up with Google"));
        }
    </script>
</body>

</html>