<?php
// 1. Data Layer Integration (Replace with actual queries/sessions later)
$donor_name = $donor_name ?? '';
$short_name = $short_name ?? '';
$blood_group = $user['blood_group'] ?? '';
$blood_type_status = $blood_type_status ?? '';
$availability = $availability ?? '';
$last_donation_date = $last_donation_date ?? '';
$last_donation_location = $last_donation_location ?? '';
$blood_requests = $blood_requests ?? [];

$pending_requests_count = count($blood_requests);
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

            <div class="mb-2">
                <h5 class="text-xl sm:text-2xl font-black text-slate-950 tracking-tight flex items-center gap-2">
                    Welcome,
                    <span class="text-red-600">
                        <?= htmlspecialchars($user['username'] ?? 'Donor') ?>
                    </span>
                    <span class="animate-bounce inline-block [animation-duration:2s]">👋</span>
                </h5>
            </div>

            <!-- Summary Cards Section -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                
                <!-- Blood Group Card -->
                <div class="bg-white border border-slate-100 p-6 rounded-3xl shadow-sm hover:shadow-xl hover:shadow-slate-100 hover:-translate-y-1 transition-all duration-300 flex items-center gap-5 group">
                    <div class="w-14 h-14 bg-red-50 rounded-2xl flex items-center justify-center text-red-500 group-hover:bg-red-500 group-hover:text-white transition-all duration-300 shrink-0">
                        <!-- Inline SVG Droplet Icon -->
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 2.25c-5.385 4.897-9 9.53-9 13.313 0 4.418 3.582 8 8 8s8-3.582 8-8c0-3.782-3.615-8.416-9-13.313z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs text-slate-400 font-bold uppercase tracking-wider">Blood Group</p>
                        <h4 class="text-2xl font-black text-slate-900 mt-0.5"> 
                            <?= htmlspecialchars($user['blood_group'] ?? 'N/A'); ?> 
                            <span class="text-sm font-medium text-slate-500 ml-1"><?= htmlspecialchars($blood_type_status); ?></span>
                        </h4>
                    </div>
                </div>

                <!-- Availability Status Card -->
                <div class="bg-white border border-slate-100 p-6 rounded-3xl shadow-sm hover:shadow-xl hover:shadow-slate-100 hover:-translate-y-1 transition-all duration-300 flex items-center gap-5 group">
                    <div class="w-14 h-14 bg-emerald-50 rounded-2xl flex items-center justify-center text-emerald-500 group-hover:bg-emerald-500 group-hover:text-white transition-all duration-300 shrink-0">
                        <!-- Inline SVG Verification Check Shield Icon -->
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 01-1.043 3.296 3.745 3.745 0 01-3.296 1.043A3.745 3.745 0 0112 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 01-3.296-1.043 3.745 3.745 0 01-1.043-3.296A3.745 3.745 0 013 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 011.043-3.296 3.746 3.746 0 013.296-1.043A3.746 3.746 0 0112 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 013.296 1.043 3.746 3.746 0 011.043 3.296A3.745 3.745 0 0121 12z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs text-slate-400 font-bold uppercase tracking-wider">Availability Status</p>
                        <h4 class="text-xl font-bold text-emerald-600 mt-0.5"><?= ($user['available'] ?? 0) ? 'Available' : 'Unavailable'; ?></h4>
                        <p class="text-xs text-slate-400 mt-0.5">You are ready to donate</p>
                    </div>
                </div>

                <!-- Last Donation Card -->
                <div class="bg-white border border-slate-100 p-6 rounded-3xl shadow-sm hover:shadow-xl hover:shadow-slate-100 hover:-translate-y-1 transition-all duration-300 flex items-center gap-5 group sm:col-span-2 lg:col-span-1">
                    <div class="w-14 h-14 bg-amber-50 rounded-2xl flex items-center justify-center text-amber-500 group-hover:bg-amber-500 group-hover:text-white transition-all duration-300 shrink-0">
                        <!-- Inline SVG Calendar Icon -->
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5m-9-6h.008v.008H12v-.008zM12 15h.008v.008H12V15zm0 2.25h.008v.008H12v-.008zM9.75 15h.008v.008H9.75V15zm0 2.25h.008v.008H9.75v-.008zM7.5 15h.008v.008H7.5V15zm0 2.25h.008v.008H7.5v-.008zm6.75-4.5h.008v.008h-.008v-.008zm0 2.25h.008v.008h-.008V15zm0 2.25h.008v.008h-.008v-.008zm2.25-4.5h.008v.008H16.5v-.008zm0 2.25h.008v.008H16.5V15z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs text-slate-400 font-bold uppercase tracking-wider">Last Donation</p>
                        <h4 class="text-lg font-bold text-slate-900 mt-0.5"><?= htmlspecialchars($last_donation_date ?: 'None Record'); ?></h4>
                        <p class="text-xs text-slate-400 mt-0.5"><?= htmlspecialchars($last_donation_location ?: 'No location saved'); ?></p>
                    </div>
                </div>
            </div>

            <!-- Blood Requests Section -->
            <div class="space-y-4">
                <div class="flex items-center gap-3">
                    <h3 class="text-xl font-bold text-slate-900 tracking-tight">Blood Requests</h3>
                    <span class="bg-red-500 text-white text-xs font-black px-2.5 py-1 rounded-full shadow-sm"><?= $pending_requests_count; ?></span>
                </div>

                <div class="space-y-3">
                    <?php foreach ($blood_requests as $request): ?>
                        <?php
                        $priorityColor = 'border-slate-100';
                        $badgeColor = 'bg-slate-100 text-slate-600';
                        $urgency = strtolower($request['urgency'] ?? '');

                        if (str_contains($urgency, 'critical')) {
                            $priorityColor = 'border-l-[6px] border-l-red-500';
                            $badgeColor = 'bg-red-50 text-red-600';
                        } elseif (str_contains($urgency, 'urgent')) {
                            $priorityColor = 'border-l-[6px] border-l-orange-500';
                            $badgeColor = 'bg-orange-50 text-orange-600';
                        } else {
                            $priorityColor = 'border-l-[6px] border-l-blue-500';
                            $badgeColor = 'bg-blue-50 text-blue-600';
                        }
                        ?>

                        <div class="bg-white border <?= $priorityColor; ?> border-slate-100 p-5 rounded-2xl shadow-sm hover:shadow-md transition-all duration-200 flex flex-col md:flex-row md:items-center justify-between gap-4">
                            <div class="flex items-start sm:items-center gap-4">
                                <div class="w-12 h-12 rounded-full bg-rose-50 text-rose-600 font-black flex items-center justify-center shrink-0 text-base shadow-sm">
                                    <?= htmlspecialchars($request['blood_group_needed'] ?? ''); ?>
                                </div>
                                <div class="space-y-0.5">
                                    <div class="flex flex-wrap items-center gap-2">
                                        <h4 class="font-bold text-slate-900">Request from: <?= htmlspecialchars($request['patient_name'] ?? 'Unknown'); ?></h4>
                                        <span class="text-xs px-2.5 py-0.5 rounded-full font-bold uppercase tracking-wider text-[10px] <?= $badgeColor; ?>"><?= htmlspecialchars($request['urgency'] ?? 'Normal'); ?> Urgency</span>
                                    </div>
                                    <p class="text-sm text-slate-500">
                                        <span class="inline-block mr-1 text-slate-400">🏢</span> 
                                        <?= htmlspecialchars($request['hospital_name'] ?? 'Not specified'); ?>
                                    </p>
                                    <p class="text-xs font-semibold text-slate-400">
                                        <?= htmlspecialchars($request['unit'] ?? '0'); ?> Units • Requested on
                                        <span class="text-slate-600">
                                            <?= isset($request['created_at']) ? date('d M Y', strtotime($request['created_at'])) : 'N/A'; ?>
                                        </span>
                                    </p>
                                </div>
                            </div>

                            <div class="flex items-center justify-between md:justify-end gap-3 pt-3 md:pt-0 border-t border-slate-50 md:border-t-0">
                                <div class="flex items-center gap-2 w-full md:w-auto justify-end">
                                    <?php if (strtolower($request['status'] ?? '') === 'pending'): ?>
                                        <span class="text-xs text-slate-400 font-medium hidden md:block mr-2">🕒 <?= htmlspecialchars($request['time_ago'] ?? ''); ?></span>
                                        
                                        <form action="/BloodConnect/public/donor/request/accept" method="POST">
                                            <input type="hidden" name="request_id" value="<?= htmlspecialchars($request['request_id'] ?? ''); ?>">
                                            <button type="submit" class="px-5 py-2 bg-emerald-500 hover:bg-emerald-600 text-white font-bold text-sm rounded-xl transition-colors cursor-pointer">
                                                Accept
                                            </button>
                                        </form>

                                        <form action="/BloodConnect/public/donor/request/decline" method="POST">
                                            <input type="hidden" name="request_id" value="<?= htmlspecialchars($request['request_id'] ?? ''); ?>">
                                            <button type="submit" class="px-5 py-2 border border-rose-200 text-rose-500 hover:bg-rose-50 font-bold text-sm rounded-xl transition-colors cursor-pointer">
                                                Decline
                                            </button>
                                        </form>
                                    <?php else: ?>
                                        <span class="flex items-center gap-1.5 text-slate-500 font-bold text-sm bg-slate-50 px-3 py-1.5 rounded-xl">
                                            Processed
                                        </span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </main>
    </div>
</body>
</html>