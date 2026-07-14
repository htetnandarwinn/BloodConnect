<?php
// 1. Data Layer Integration (Replace with actual queries/sessions later)
$donor_name = $donor_name ?? '';
$short_name = $short_name ?? '';
$blood_group = $user['blood_group'] ?? '';
$blood_type_status = $blood_type_status ?? '';
$availability = $availability ?? '';
$availability_message = $availability_message ?? 'You are ready to donate';
$next_eligible_date = $next_eligible_date ?? '';
$last_donation_date = $last_donation_date ?? '';
$last_donation_location = $last_donation_location ?? '';
$blood_requests = $blood_requests ?? [];

$pending_requests_count = $pending_requests_count ?? count($blood_requests);

$recent_activities = $recent_activities ?? [];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donor Dashboard - BloodConnect</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
    </style>
</head>

<body class="bg-slate-50 text-slate-800 antialiased min-h-screen flex">

    <div class="flex-1 flex flex-col min-h-screen">

        <main class="flex-1 p-4 sm:p-8 max-w-7xl w-full mx-auto space-y-8">

            <div>
                <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
                    Welcome, <span class="text-[#E63946]"> <?= htmlspecialchars($user['username'] ?? 'Donor') ?></span>
                    <span class="inline-block origin-bottom animate-[wave_2s_infinite]">👋</span>
                </h1>
                <p class="text-sm text-slate-500 mt-0.5">Here's your donor dashboard overview.</p>  
            </div>

            <!-- Summary Cards Section -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6">

                <!-- Blood Group Card -->
                <div class="group relative bg-white/80 backdrop-blur-md rounded-2xl p-6 shadow-sm border border-slate-100 hover:border-slate-200 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 ease-out">
                    <div class="absolute inset-0 bg-gradient-to-br from-slate-50/0 to-slate-50 rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none"></div>
                    <div class="relative flex items-center justify-between">
                        <div class="space-y-2">
                            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Blood Group</p>
                            <p class="text-2xl md:text-3xl font-extrabold text-slate-900 tracking-tight">
                                <?= htmlspecialchars($user['blood_group'] ?? 'N/A'); ?>
                                <span class="text-sm font-medium text-slate-500 ml-1"><?= htmlspecialchars($blood_type_status); ?></span>
                            </p>
                        </div>
                        <div class="bg-red-50 text-red-500 border border-red-100 w-14 h-14 rounded-2xl flex items-center justify-center text-2xl shadow-inner transform group-hover:scale-110 transition-transform duration-300 ease-out">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 2.25c-5.385 4.897-9 9.53-9 13.313 0 4.418 3.582 8 8 8s8-3.582 8-8c0-3.782-3.615-8.416-9-13.313z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Availability Status Card -->
                <div class="group relative bg-white/80 backdrop-blur-md rounded-2xl p-6 shadow-sm border border-slate-100 hover:border-slate-200 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 ease-out">
                    <div class="absolute inset-0 bg-gradient-to-br from-slate-50/0 to-slate-50 rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none"></div>
                    <div class="relative flex items-center justify-between">
                        <div class="space-y-2">
                            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Availability Status</p>
                            <p class="text-2xl md:text-3xl font-extrabold text-slate-900 tracking-tight <?= ($availability === 'Available' ? 'text-emerald-600' : 'text-red-600') ?>"><?= htmlspecialchars($availability); ?></p>
                            <p class="text-xs text-slate-400"><?= htmlspecialchars($availability_message); ?></p>
                            <?php if (!empty($next_eligible_date)):
                                $remaining = floor((strtotime($next_eligible_date) - time()) / 86400);
                            ?>
                                <p class="text-xs font-semibold text-red-600">Next eligible date: <?= htmlspecialchars(date('d M Y', strtotime($next_eligible_date))) ?></p>
                                <p class="text-xs font-bold text-amber-600">Next Eligible In: <?= max(0, $remaining) ?> Days Remaining</p>
                            <?php endif; ?>
                        </div>
                        <div class="<?= ($availability === 'Available' ? 'bg-emerald-50 text-emerald-500 border-emerald-200' : 'bg-red-50 text-red-500 border-red-200') ?> border w-14 h-14 rounded-2xl flex items-center justify-center text-2xl shadow-inner transform group-hover:scale-110 transition-transform duration-300 ease-out">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 01-1.043 3.296 3.745 3.745 0 01-3.296 1.043A3.745 3.745 0 0112 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 01-3.296-1.043 3.745 3.745 0 01-1.043-3.296A3.745 3.745 0 013 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 011.043-3.296 3.746 3.746 0 013.296-1.043A3.746 3.746 0 0112 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 013.296 1.043 3.746 3.746 0 011.043 3.296A3.745 3.745 0 0121 12z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Total Donations Card -->
                <a href="/BloodConnect/public/donor/history" class="group relative bg-white/80 backdrop-blur-md rounded-2xl p-6 shadow-sm border border-slate-100 hover:border-slate-200 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 ease-out cursor-pointer">
                    <div class="absolute inset-0 bg-gradient-to-br from-slate-50/0 to-slate-50 rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none"></div>
                    <div class="relative flex items-center justify-between">
                        <div class="space-y-2">
                            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Total Donations</p>
                            <p class="text-2xl md:text-3xl font-extrabold text-slate-900 tracking-tight">
                                <?= (int)($total_donations ?? 0) ?>
                                <span class="text-sm font-medium text-slate-500 ml-1">Donated</span>
                            </p>
                        </div>
                        <div class="bg-blue-50 text-blue-500 border border-blue-100 w-14 h-14 rounded-2xl flex items-center justify-center text-2xl shadow-inner transform group-hover:scale-110 transition-transform duration-300 ease-out">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zM4 19.235v-.11a6.375 6.375 0 0112.75 0v.109A12.318 12.318 0 0110.374 21c-2.331 0-4.512-.645-6.374-1.766z" />
                            </svg>
                        </div>
                    </div>
                </a>

                <!-- Last Donation Card -->
                <div class="group relative bg-white/80 backdrop-blur-md rounded-2xl p-6 shadow-sm border border-slate-100 hover:border-slate-200 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 ease-out">
                    <div class="absolute inset-0 bg-gradient-to-br from-slate-50/0 to-slate-50 rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none"></div>
                    <div class="relative flex items-center justify-between">
                        <div class="space-y-2">
                            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Last Donation</p>
                            <p class="text-2xl md:text-3xl font-extrabold text-slate-900 tracking-tight"><?= htmlspecialchars($last_donation_date ?: 'None Record'); ?></p>
                            <p class="text-xs text-slate-400"><?= htmlspecialchars($last_donation_location ?: 'No location saved'); ?></p>
                        </div>
                        <div class="bg-amber-50 text-amber-500 border border-amber-100 w-14 h-14 rounded-2xl flex items-center justify-center text-2xl shadow-inner transform group-hover:scale-110 transition-transform duration-300 ease-out">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5m-9-6h.008v.008H12v-.008zM12 15h.008v.008H12V15zm0 2.25h.008v.008H12v-.008zM9.75 15h.008v.008H9.75V15zm0 2.25h.008v.008H9.75v-.008zM7.5 15h.008v.008H7.5V15zm0 2.25h.008v.008H7.5v-.008zm6.75-4.5h.008v.008h-.008v-.008zm0 2.25h.008v.008h-.008V15zm0 2.25h.008v.008h-.008v-.008zm2.25-4.5h.008v.008H16.5v-.008zm0 2.25h.008v.008H16.5V15z" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Activity Section -->
            <div class="group relative bg-white/80 backdrop-blur-md rounded-2xl p-6 shadow-sm border border-slate-100 hover:border-slate-200 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 ease-out">
                <div class="absolute inset-0 bg-gradient-to-br from-slate-50/0 to-slate-50 rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none"></div>
                <div class="relative space-y-4">
                    <div class="flex items-center gap-3">
                        <h3 class="text-lg font-bold text-slate-900 tracking-tight">Recent Activity</h3>
                        <div class="h-px flex-1 bg-gradient-to-r from-slate-200/80 to-transparent"></div>
                    </div>

                    <?php
                    $activity = $recent_activities ?? [];
                    $lastDateLabel = '';
                    function formatActivityDate($timestamp) {
                        $ts = strtotime($timestamp);
                        $today = strtotime('today');
                        $yesterday = strtotime('yesterday');
                        $dateDay = strtotime(date('Y-m-d', $ts));
                        if ($dateDay === $today) return 'Today';
                        if ($dateDay === $yesterday) return 'Yesterday';
                        return date('j M', $ts);
                    }
                    ?>
                    <div class="relative pl-8 before:absolute before:left-[11px] before:top-2 before:bottom-2 before:w-px before:bg-gradient-to-b before:from-red-200 before:via-slate-200 before:to-transparent">
                        <?php foreach ($activity as $i => $act): ?>
                            <?php
                            $dateLabel = formatActivityDate($act['timestamp']);
                            $showDate = ($dateLabel !== $lastDateLabel);
                            $lastDateLabel = $dateLabel;

                            $iconBg = match ($act['type']) {
                                'donation' => 'bg-emerald-50 text-emerald-600 border-emerald-200',
                                'accepted' => 'bg-blue-50 text-blue-600 border-blue-200',
                                default => 'bg-slate-100 text-slate-500 border-slate-200',
                            };
                            $iconSvg = match ($act['type']) {
                                'donation' => '<svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>',
                                'accepted' => '<svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>',
                                default => '<svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182"/></svg>',
                            };
                            ?>
                            <?php if ($showDate): ?>
                                <div class="flex items-center gap-2 <?= $i > 0 ? 'mt-6' : '' ?> mb-2">
                                    <div class="h-px w-4 bg-slate-200 shrink-0"></div>
                                    <span class="text-[11px] font-bold text-slate-400 uppercase tracking-[0.15em]"><?= $dateLabel ?></span>
                                </div>
                            <?php endif; ?>
                            <div class="group/item relative flex items-start gap-4 py-2.5 pl-1 transition-all duration-200 hover:bg-slate-50/50 rounded-xl -ml-1 px-2">
                                <div class="relative shrink-0 mt-0.5">
                                    <div class="w-[26px] h-[26px] rounded-full border-2 flex items-center justify-center shadow-xs transition-all duration-200 <?= $iconBg ?> group-hover/item:scale-110">
                                        <?= $iconSvg ?>
                                    </div>
                                </div>
                                <div class="flex-1 min-w-0 pt-0.5">
                                    <p class="text-sm font-semibold text-slate-800 leading-snug"><?= htmlspecialchars($act['label']) ?></p>
                                    <p class="text-[11px] text-slate-400 font-medium mt-0.5"><?= date('g:i A', strtotime($act['timestamp'])) ?></p>
                                </div>
                            </div>
                        <?php endforeach; ?>
                        <?php if (empty($activity)): ?>
                            <div class="flex flex-col items-center justify-center py-10 text-center">
                                <div class="w-14 h-14 rounded-2xl bg-slate-50 border border-slate-100 flex items-center justify-center mb-3">
                                    <svg class="w-6 h-6 text-slate-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                </div>
                                <p class="text-sm font-medium text-slate-400">No recent activity</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>

</html>