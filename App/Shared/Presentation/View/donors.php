<!doctype html>
<?php
$basePath = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME']));
if ($basePath === '/' || $basePath === '\\') {
    $basePath = '';
}
?>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>BloodConnect — Donors</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #fff;
            color: #1b1b1f;
        }

        .navbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 16px 24px;
            border-bottom: 1px solid #eee;
            background: #fff;
        }

        .nav-links {
            list-style: none;
            display: flex;
            gap: 18px;
            margin: 0;
            padding: 0;
        }

        .nav-links a {
            color: #1b1b1f;
            text-decoration: none;
            font-weight: 600;
        }

        .page {
            padding: 40px 24px;
            max-width: 920px;
            margin: 0 auto;
        }

        .page h1 {
            margin-bottom: 16px;
            font-size: 2rem;
        }

        .page p {
            margin-bottom: 32px;
            line-height: 1.6;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 12px 24px;
            background: #c8102e;
            color: #fff;
            text-decoration: none;
            border-radius: 8px;
        }
    </style>
</head>

<body>
    <header class="navbar">
        <div><strong>BloodConnect</strong></div>
        <nav>
            <ul class="nav-links">
                <li><a href="<?= $basePath ?>/">Home</a></li>
                <li><a href="<?= $basePath ?>/register">Search Donor</a></li>
                <li><a href="<?= $basePath ?>/register">Blood Requests</a></li>
                <li><a href="<?= $basePath ?>/donor/register">Donors</a></li>
                <li><a href="<?= $basePath ?>/login">Login</a></li>
                <li><a href="<?= $basePath ?>/register">Register</a></li>
            </ul>
        </nav>
    </header>
    <main class="page">
        <h1>Donor Registration</h1>
        <p>Become a blood donor and make a difference. Register now to share your availability and help save lives.</p>
        <a class="btn" href="<?= $basePath ?>/donor/register">Register as Donor</a>
    </main>
</body>

</html>