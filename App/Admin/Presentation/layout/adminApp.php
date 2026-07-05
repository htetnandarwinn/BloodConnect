<?php

/** @var string $content */
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BloodConnect</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- ✅ Tailwind ONLY ONCE -->
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(16px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in {
            animation: fadeInUp .5s cubic-bezier(.16, 1, .3, 1) forwards;
        }
    </style>
</head>

<body class="bg-gradient-to-b from-[#fdf6f6] to-[#faf0f0] text-slate-800 antialiased">

    <div class="flex min-h-screen">

        <?php require __DIR__ . '/sidebar.php'; ?>

        <div class="flex-1 flex flex-col">

            <?php require __DIR__ . '/topbar.php'; ?>

            <main class="flex-1 p-6">
                <?= $content ?? '' ?>
            </main>

        </div>

    </div>

</body>

</html>