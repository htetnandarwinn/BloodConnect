<?php
$basePath = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME']));
if ($basePath === '/' || $basePath === '\\') {
    $basePath = '';
}

$errors = $_SESSION['errors'] ?? [];
$old = $_SESSION['old'] ?? [];
unset($_SESSION['errors'], $_SESSION['old']);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BloodConnect - Donor Registration</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@600;700;800&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary: #c8102e;
            --primary-dark: #9d0d24;
            --bg: #fdf4f6;
            --white: #fff;
            --text: #222;
            --gray: #777;
            --border: #e5e5e5;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--bg);
            color: var(--text);
        }

        /* NAVBAR */

        .navbar {
            background: #fff;
            padding: 18px 60px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #eee;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .logo-icon {
            font-size: 28px;
        }

        .logo h2 {
            font-size: 22px;
        }

        .logo span {
            color: var(--primary);
        }

        .logo p {
            font-size: 11px;
            color: #888;
        }

        .nav-links {
            list-style: none;
            display: flex;
            gap: 25px;
        }

        .nav-links a {
            text-decoration: none;
            color: #444;
            font-size: 14px;
            font-weight: 500;
        }

        .nav-links a:hover {
            color: var(--primary);
        }

        .nav-right {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .login {
            text-decoration: none;
            color: #444;
        }

        .signup-btn {
            background: var(--primary);
            color: white;
            padding: 10px 18px;
            border-radius: 6px;
            text-decoration: none;
        }

        /* CONTENT */

        .container {
            max-width: 1200px;
            margin: 50px auto;
            padding: 0 20px;
            display: grid;
            grid-template-columns: 1fr 1.2fr;
            gap: 70px;
            align-items: start;
        }

        .left h1 {
            font-family: 'Poppins', sans-serif;
            font-size: 50px;
            line-height: 1.2;
        }

        .left .red {
            color: var(--primary);
        }

        .line {
            width: 55px;
            height: 4px;
            background: var(--primary);
            margin: 20px 0;
        }

        .left p {
            color: #666;
            line-height: 1.8;
            max-width: 300px;
        }

        /* .blood-bag {
            margin-top: 50px;
            text-align: center;
            font-size: 130px;
        } */

        .card {
            background: #fff;
            border-radius: 18px;
            padding: 35px;
            border: 1px solid #f0dfe3;
            box-shadow: 0 10px 25px rgba(0, 0, 0, .05);
        }

        .card-title {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 25px;
        }

        .icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: #fdecef;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .card-title h3 {
            font-size: 24px;
        }

        .card-title p {
            color: #777;
            font-size: 13px;
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            font-size: 14px;
        }

        .form-group input,
        .form-group select {
            width: 100%;
            padding: 12px 14px;
            border: 1px solid var(--border);
            border-radius: 8px;
            outline: none;
        }

        .form-group input:focus,
        .form-group select:focus {
            border-color: var(--primary);
        }

        .full {
            grid-column: 1 / -1;
        }

        .checkbox {
            margin: 25px 0;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .checkbox input {
            accent-color: var(--primary);
        }

        .submit-btn {
            width: 100%;
            border: none;
            background: var(--primary);
            color: white;
            padding: 14px;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
        }

        .submit-btn:hover {
            background: var(--primary-dark);
        }

        .field-error {
            color: var(--primary);
            font-size: 13px;
            margin-top: 10px;
            display: none;
        }

        .field-error.show {
            display: block;
        }

        input.input-error {
            border-color: var(--primary);
        }

        .login-text {
            text-align: center;
            margin-top: 20px;
            color: #666;
        }

        .login-text a {
            color: var(--primary);
            text-decoration: none;
            font-weight: 600;
        }

        @media(max-width:900px) {

            .navbar {
                flex-direction: column;
                gap: 15px;
            }

            .nav-links {
                flex-wrap: wrap;
                justify-content: center;
            }

            .container {
                grid-template-columns: 1fr;
            }

            .form-grid {
                grid-template-columns: 1fr;
            }

            .left {
                text-align: center;
            }

            .line {
                margin: 20px auto;
            }

            .left p {
                margin: auto;
            }
        }
    </style>
</head>

<body>

    <nav class="navbar">

        <div class="logo">
            <div class="logo-icon">🩸</div>
            <div>
                <h2>Blood<span>Connect</span></h2>
                <p>Donate Blood, Save Lives</p>
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

        <div class="nav-right">
            <a href="<?= $basePath ?>/login" class="login">Log In</a>
            <a href="<?= $basePath ?>/register" class="signup-btn">Sign Up</a>
        </div>

    </nav>

    <div class="container">

        <div class="left">

            <h1>
                Register as a <br>
                <span class="red">Blood Donor</span>
            </h1>

            <div class="line"></div>

            <p>
                Join our network of life savers.
                Register as a donor and help save lives in your community.
            </p>

            <div class="blood-bag"></div>

        </div>

        <div class="card">

            <div class="card-title">
                <div class="icon">👤</div>
                <div>
                    <h3>Donor Registration</h3>
                    <p>Fill in your details to become a donor.</p>
                </div>
            </div>

            <?php if (!empty($errors)): ?>
                <div class="form-errors">
                    <?php foreach ($errors as $error): ?>
                        <p class="field-error show"><?= htmlspecialchars($error, ENT_QUOTES) ?></p>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <form id="donorForm" method="POST" action="<?= $basePath ?>/auth/register-donor">

                <div class="form-grid">

                    <div class="form-group">
                        <label>Full Name</label>
                        <input
                            type="text"
                            name="name"
                            placeholder="Enter your full name"
                            value="<?= htmlspecialchars($old['name'] ?? '', ENT_QUOTES) ?>"
                            required>
                    </div>

                    <div class="form-group">
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
                            required>
                    </div>

                    <div class="form-group">
                        <label>Email Address</label>
                        <input
                            type="email"
                            id="email"
                            name="email"
                            placeholder="Enter your email"
                            value="<?= htmlspecialchars($old['email'] ?? '', ENT_QUOTES) ?>"
                            required>
                    </div>

                    <div class="form-group">
                        <label>Address</label>
                        <input
                            type="text"
                            name="address"
                            placeholder="Enter your full address"
                            value="<?= htmlspecialchars($old['address'] ?? '', ENT_QUOTES) ?>"
                            required>
                    </div>

                    <div class="form-group full">
                        <label>Blood Group</label>
                        <select name="blood_group" required>
                            <option value="" <?= empty($old['blood_group']) ? 'selected' : '' ?>>
                                Select your blood group
                            </option>

                            <option value="A+" <?= (($old['blood_group'] ?? '') === 'A+') ? 'selected' : '' ?>>A+</option>
                            <option value="A-" <?= (($old['blood_group'] ?? '') === 'A-') ? 'selected' : '' ?>>A-</option>
                            <option value="B+" <?= (($old['blood_group'] ?? '') === 'B+') ? 'selected' : '' ?>>B+</option>
                            <option value="B-" <?= (($old['blood_group'] ?? '') === 'B-') ? 'selected' : '' ?>>B-</option>
                            <option value="AB+" <?= (($old['blood_group'] ?? '') === 'AB+') ? 'selected' : '' ?>>AB+</option>
                            <option value="AB-" <?= (($old['blood_group'] ?? '') === 'AB-') ? 'selected' : '' ?>>AB-</option>
                            <option value="O+" <?= (($old['blood_group'] ?? '') === 'O+') ? 'selected' : '' ?>>O+</option>
                            <option value="O-" <?= (($old['blood_group'] ?? '') === 'O-') ? 'selected' : '' ?>>O-</option>
                        </select>
                    </div>

                    <!-- Password -->
                    <div class="form-group">
                        <label>Password</label>
                        <input
                            type="password"
                            name="password"
                            placeholder="Enter password"
                            required>
                    </div>

                    <!-- Confirm Password -->
                    <div class="form-group">
                        <label>Confirm Password</label>
                        <input
                            type="password"
                            name="confirm_password"
                            placeholder="Confirm password"
                            required>
                    </div>

                </div>

                <p class="field-error" id="donorFormError">Please fill in all required fields and use an 11-digit phone number.</p>

                <div class="checkbox">
                    <input type="checkbox" required>
                    <label>I confirm that the above information is accurate.</label>
                </div>

                <button type="submit" class="submit-btn">
                    Register as a Donor
                </button>

                <p class="login-text">
                    Already have an account?
                    <a href="<?= $basePath ?>/login">Log In</a>
                </p>

            </form>

        </div>

    </div>

</body>

</html>