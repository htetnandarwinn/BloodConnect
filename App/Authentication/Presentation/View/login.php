<!doctype html>
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
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>BloodConnect — Login</title>
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
            gap: 24px;
        }

        .theme-toggle {
            width: 20px;
            height: 20px;
            color: var(--ink);
            cursor: pointer;
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

        /* ---------- LOGIN SECTION ---------- */
        .login-section {
            position: relative;
            overflow: hidden;
            padding: 70px 60px 140px;
            min-height: 780px;
        }

        .decor-wave {
            position: absolute;
            right: 0;
            bottom: 0;
            width: 55%;
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


        .login-inner {
            position: relative;
            z-index: 1;
            max-width: 1200px;
            margin: auto;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 100px;
            align-items: center;
            min-height: 650px;
        }

        /* ----- left auth card ----- */
        .auth-card {
            background: #fff;
            border-radius: 20px;
            padding: 40px;
            border: 1px solid #eee;
            box-shadow: 0 15px 40px rgba(0, 0, 0, .06);
            max-width: 500px;
        }

        .auth-card h2 {
            font-size: 38px;
            font-weight: 800;
            margin-bottom: 10px;
        }

        .auth-sub {
            color: var(--gray);
            font-size: 14.5px;
            line-height: 1.7;
            margin-top: 10px;
            margin-bottom: 28px;
        }

        .field {
            margin-bottom: 20px;
        }

        .field label {
            display: block;
            font-size: 13.5px;
            font-weight: 700;
            margin-bottom: 9px;
        }

        .field-input {
            position: relative;
        }

        .field-input input {
            width: 100%;
            border: 1px solid #ddd;
            border-radius: 10px;
            padding: 14px 16px 14px 45px;
            font-size: 15px;
            outline: none;
            transition: .3s;
        }

        .field-input input::placeholder {
            color: var(--placeholder);
        }

        .field-input input:focus {
            border-color: #c8102e;
            box-shadow: 0 0 0 4px rgba(200, 16, 46, .1);
        }

        .field-input input.input-error {
            border-color: var(--crimson);
        }

        .icon-left {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            width: 17px;
            height: 17px;
            color: var(--crimson);
        }

        .icon-right {
            position: absolute;
            right: 14px;
            top: 50%;
            transform: translateY(-50%);
            width: 18px;
            height: 18px;
            color: #8c8c95;
            cursor: pointer;
        }

        .field-input.has-right input {
            padding-right: 42px;
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

        .field-success {
            color: #0f7a0f;
            font-size: 13px;
            margin-bottom: 14px;
            display: none;
        }

        .field-success.show {
            display: block;
        }

        .forgot-link {
            display: inline-block;
            color: var(--crimson);
            font-weight: 700;
            font-size: 13.5px;
            text-decoration: none;
            margin-bottom: 22px;
        }

        .btn-full {
            width: 100%;
            padding: 15px;
            font-size: 16px;
            border-radius: 10px;
        }

        .divider {
            display: flex;
            align-items: center;
            gap: 14px;
            margin: 22px 0;
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

        .btn-google {
            width: 100%;
            padding: 13px;
            font-size: 14.5px;
            font-weight: 700;
            border-radius: 10px;
            border: 1px solid var(--border-gray);
            background: var(--white);
            color: var(--ink);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            cursor: pointer;
            font-family: "Inter", sans-serif;
        }

        .btn-google svg {
            width: 18px;
            height: 18px;
        }

        .new-here-box {
            background: var(--pink-bg);
            border-radius: 14px;
            padding: 18px 20px;
            margin-top: 24px;
        }

        .new-here-box h4 {
            font-size: 14.5px;
            font-weight: 700;
            margin-bottom: 6px;
        }

        .new-here-box p {
            font-size: 13.5px;
            color: #4a4a50;
        }

        .new-here-box a {
            color: var(--crimson);
            font-weight: 700;
            text-decoration: underline;
        }

        /* ----- right info column ----- */
        .info-column {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .illustration-wrap {
            width: 320px;
        }

        .illustration-wrap svg {
            width: 100%;
            height: auto;
            display: block;
        }

        .info-column h3 {
            font-size: 28px;
            font-weight: 800;
            margin-top: 36px;
        }

        .info-column .info-sub {
            color: var(--gray);
            font-size: 14.5px;
            margin-top: 10px;
            margin-bottom: 30px;
        }

        .fact-card {
            width: 100%;
            max-width: 420px;
            background: #fff;
            border: 1px solid #eee;
            border-radius: 18px;
            padding: 25px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, .05);
            display: flex;
            gap: 18px;
            align-items: center;
        }

        .fact-icon {
            width: 56px;
            height: 56px;
            border-radius: 50%;
            background: #fceaef;
            flex-shrink: 0;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .fact-icon svg {
            width: 22px;
            height: 26px;
        }

        .fact-text h4 {
            font-size: 16px;
            font-weight: 700;
            margin-bottom: 8px;
        }

        .fact-text p {
            font-size: 14px;
            color: var(--gray);
            line-height: 1.7;
        }

        :root {
            --crimson: #c8102e;
            --crimson-dark: #a30e27;
            --pink-bg: #fce9ee;
            --pink-bg-2: #fbe0e7;
            --pink-soft: #f6b9c5;
            --pink-soft-2: #f3a8bc;
            --ink: #1b1b1f;
            --gray: #6b6b76;
            --white: #ffffff;
        }

        .navbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 18px 60px;
            background: var(--white);
            border-bottom: 1px solid #f2f2f4;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .logo svg {
            width: 28px;
            height: 34px;
            flex-shrink: 0;
        }

        .logo .brand-name {
            font-size: 20px;
            font-weight: 700;
            line-height: 1.1;
        }

        .logo .brand-tagline {
            font-size: 11px;
            color: var(--gray);
            font-weight: 400;
        }

        .nav-links {
            display: flex;
            gap: 42px;
            list-style: none;
        }

        .nav-links a {
            text-decoration: none;
            color: var(--ink);
            font-weight: 600;
            font-size: 15px;
            padding-bottom: 8px;
            position: relative;
        }

        .nav-links a.active {
            color: var(--crimson);
            border-bottom: 2.5px solid var(--crimson);
        }

        .nav-actions {
            display: flex;
            gap: 14px;
        }

        .btn {
            font-family: "Inter", sans-serif;
            font-weight: 600;
            font-size: 14.5px;
            border-radius: 8px;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            border: none;
            transition: transform 0.15s ease, box-shadow 0.15s ease;
            text-decoration: none;
        }

        .btn:hover {
            transform: translateY(-1px);
        }

        .btn-outline {
            background: var(--white);
            color: var(--crimson);
            border: 1.5px solid var(--crimson);
            padding: 9px 18px;
        }

        .btn-filled {
            background: var(--crimson);
            color: var(--white);
            padding: 9px 18px;
            box-shadow: 0 4px 10px rgba(200, 16, 46, 0.25);
        }

        @media (max-width: 900px) {
            .navbar {
                flex-wrap: wrap;
                gap: 16px;
                padding: 16px 24px;
            }

            .nav-links {
                order: 3;
                width: 100%;
                justify-content: center;
                gap: 24px;
            }
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

            .login-section {
                padding: 46px 24px 100px;
            }

            .login-inner {
                grid-template-columns: 1fr;
                gap: 50px;
            }

            .auth-card {
                max-width: 100%;
            }

            .info-column {
                padding-top: 0;
            }

            .fact-card {
                flex-direction: column;
                align-items: center;
                text-align: center;
            }

            .fact-text {
                text-align: center;
            }

            .topbar {
                display: flex;
                justify-content: space-between;
                align-items: flex-start;
                margin-bottom: 26px;
            }

            .topbar h2 {
                font-size: 32px;
                margin: 0;
                color: var(--gray-900);
                font-weight: 700;
            }

            .topbar p {
                font-size: 13px;
                margin: 4px 0 0;
                color: var(--gray-400);
            }

            .topbar-right {
                display: flex;
                align-items: center;
                gap: 18px;
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

    <!-- ============ LOGIN SECTION ============ -->
    <section class="login-section">
        <div class="decor-wave">
            <svg
                viewBox="0 0 700 500"
                preserveAspectRatio="none"
                xmlns="http://www.w3.org/2000/svg">
                <path d="M700,170 C470,40 270,300 0,500 L700,500 Z" fill="#FCEAEF" />
            </svg>
        </div>

        <div class="login-inner">


            <!-- right info column -->
            <div class="info-column">
                <div class="illustration-wrap">
                    <svg viewBox="0 0 240 260" xmlns="http://www.w3.org/2000/svg">
                        <ellipse cx="120" cy="130" rx="118" ry="125" fill="#FCEAF0" />
                        <path
                            d="M229,95 C236,108 236,128 229,142"
                            stroke="#F4D6DD"
                            stroke-width="6"
                            fill="none"
                            stroke-linecap="round" />
                        <path
                            d="M120,30 C150,68 178,112 178,140 C178,170 152,192 120,192 C88,192 62,170 62,140 C62,112 90,68 120,30 Z"
                            fill="#C8102E" />
                        <rect
                            x="110"
                            y="108"
                            width="20"
                            height="74"
                            rx="7"
                            fill="#FFFFFF" />
                        <rect
                            x="83"
                            y="135"
                            width="74"
                            height="20"
                            rx="7"
                            fill="#FFFFFF" />
                    </svg>
                </div>

                <h3>Did you know?</h3>
                <p class="info-sub">
                    Important facts about blood donation and safety.
                </p>

                <div class="fact-card">
                    <div class="fact-icon">
                        <svg viewBox="0 0 24 28" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M12,2 C18,10 21,16 21,19.5 C21,24.2 17,27 12,27 C7,27 3,24.2 3,19.5 C3,16 6,10 12,2 Z"
                                fill="#C8102E" />
                        </svg>
                    </div>
                    <div class="fact-text">
                        <h4>One donation, many lives</h4>
                        <p>
                            A single unit of blood can save up to three lives through
                            component separation.
                        </p>
                    </div>
                </div>
            </div>

            <!-- left auth card -->
            <div class="auth-card">
                <h2>Welcome back</h2>
                <p class="auth-sub">
                    Sign in to manage blood requests, connect with donors, and stay
                    ahead of urgent needs.
                </p>

                <form id="loginForm" novalidate method="post" action="<?= $basePath ?>/auth/login">
                    <?php if (!empty($success)): ?>
                        <p class="field-success show"><?= htmlspecialchars($success, ENT_QUOTES) ?></p>
                    <?php endif; ?>
                    <?php if (!empty($errors)): ?>
                        <div class="form-errors">
                            <?php foreach ($errors as $error): ?>
                                <p class="field-error show"><?= htmlspecialchars($error, ENT_QUOTES) ?></p>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                    <div class="field">
                        <label>Email or Username</label>
                        <div class="field-input">
                            <svg
                                class="icon-left"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="1.8"
                                stroke-linecap="round"
                                stroke-linejoin="round">
                                <circle cx="12" cy="8" r="3.4" />
                                <path d="M5 20c0-3.3 3.1-6 7-6s7 2.7 7 6" />
                            </svg>
                            <input
                                type="text"
                                id="loginId"
                                name="login"
                                placeholder="Enter email or username"
                                value="<?= htmlspecialchars($old['login'] ?? '', ENT_QUOTES) ?>"
                                required />
                        </div>
                    </div>

                    <div class="field">
                        <label>Password</label>
                        <div class="field-input has-right">
                            <svg
                                class="icon-left"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="1.8"
                                stroke-linecap="round"
                                stroke-linejoin="round">
                                <rect x="5" y="10.5" width="14" height="10" rx="2.4" />
                                <path d="M8 10.5V7.8a4 4 0 0 1 8 0v2.7" />
                            </svg>
                            <input
                                type="password"
                                id="loginPassword"
                                name="password"
                                placeholder="Enter password"
                                required />
                            <svg
                                class="icon-right"
                                id="togglePassword"
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
                        <span class="field-error" id="loginError">Please enter your email/username and password.</span>
                    </div>

                    <a href="#" class="forgot-link" id="forgotLink">Forgot password?</a>

                    <button type="submit" class="btn btn-filled btn-full">
                        Sign in
                    </button>

                    <!-- <div class="divider">
                        <span class="line"></span>
                        <span>or</span>
                        <span class="line"></span>
                    </div> -->

                    <!-- <button type="button" class="btn-google" id="googleBtn">
                        <svg viewBox="0 0 18 18" xmlns="http://www.w3.org/2000/svg">
                            <path
                                fill="#4285F4"
                                d="M17.64 9.2c0-.637-.057-1.251-.164-1.84H9v3.481h4.844c-.209 1.125-.843 2.078-1.796 2.717v2.258h2.908c1.702-1.567 2.684-3.875 2.684-6.615z" />
                            <path
                                fill="#34A853"
                                d="M9 18c2.43 0 4.467-.806 5.956-2.184l-2.908-2.258c-.806.54-1.837.86-3.048.86-2.344 0-4.328-1.584-5.036-3.711H.957v2.332C2.438 16.106 5.482 18 9 18z" />
                            <path
                                fill="#FBBC05"
                                d="M3.964 10.707A5.41 5.41 0 0 1 3.682 9c0-.593.102-1.17.282-1.707V4.961H.957A8.996 8.996 0 0 0 0 9c0 1.452.348 2.827.957 4.039l3.007-2.332z" />
                            <path
                                fill="#EA4335"
                                d="M9 3.58c1.321 0 2.508.454 3.44 1.345l2.582-2.58C13.463.891 11.426 0 9 0 5.482 0 2.438 1.894.957 4.961L3.964 7.293C4.672 5.166 6.656 3.58 9 3.58z" />
                        </svg>
                        Continue with Google
                    </button> -->
                </form>

                <!-- <div class="new-here-box">
                    <h4>New here?</h4>
                    <p>
                        Create an account in minutes.
                        <a href="<?= $basePath ?>/register" id="joinNowLink">Join now.</a>
                    </p>
                </div> -->
            </div>
        </div>
    </section>

    <script>
        // Show / hide password
        document
            .getElementById("togglePassword")
            .addEventListener("click", () => {
                const input = document.getElementById("loginPassword");
                input.type = input.type === "password" ? "text" : "password";
            });

        // Sign in form validation
        document.getElementById("loginForm").addEventListener("submit", (e) => {
            const id = document.getElementById("loginId");
            const password = document.getElementById("loginPassword");
            const error = document.getElementById("loginError");

            const invalid = !id.value.trim() || !password.value.trim();
            id.classList.toggle("input-error", invalid);
            password.classList.toggle("input-error", invalid);
            error.classList.toggle("show", invalid);

            if (invalid) {
                e.preventDefault();
                return;
            }
        });

        // Google button, links
        document
            .getElementById("googleBtn")
            .addEventListener("click", () => alert("Continue with Google"));
        document
            .getElementById("forgotLink")
            .addEventListener("click", (e) => e.preventDefault());
        document
            .getElementById("joinNowLink")
            .addEventListener("click", (e) => {
                e.preventDefault();
                window.location.href = '<?= $basePath ?>/register';
            });
    </script>
</body>

</html>
</body>

</html>