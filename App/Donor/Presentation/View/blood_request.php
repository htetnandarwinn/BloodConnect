<?php
// 1. Data Layer Integration (Replace with actual queries/sessions later)
$donor_name = $donor_name ?? 'John Doe';
$short_name = $short_name ?? 'JD';
$blood_group = $blood_group ?? 'O+';
$blood_type_status = $blood_type_status ?? 'Rh Positive';
$availability = $availability ?? 'Available';
$last_donation_date = $last_donation_date ?? '14 Jan 2026';
$last_donation_location = $last_donation_location ?? 'Red Cross, Main Center';

$pending_requests_count = 2;
$notification_count = 3;

$blood_requests = [
    [
        'id' => 1,
        'blood_type' => 'O+',
        'requester' => 'Amit Verma',
        'location' => 'City Hospital, Delhi',
        'units' => 2,
        'deadline' => '20 May 2026',
        'priority' => 'High',
        'status' => 'Pending',
        'time_ago' => '1 hour ago'
    ],
    [
        'id' => 2,
        'blood_type' => 'A+',
        'requester' => 'Priya Singh',
        'location' => 'Green Life Hospital, Delhi',
        'units' => 1,
        'deadline' => '22 May 2026',
        'priority' => 'Medium',
        'status' => 'Pending',
        'time_ago' => '5 hours ago'
    ],
    [
        'id' => 3,
        'blood_type' => 'B+',
        'requester' => 'Rahul Mehta',
        'location' => 'Sunrise Hospital, Delhi',
        'units' => 1,
        'deadline' => '25 May 2026',
        'priority' => 'Low',
        'status' => 'Accepted',
        'action_date' => '12 May 2026'
    ]
];
?>

<!DOCTYPE html>
<html lang="en" class="h-full bg-slate-50">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donor Dashboard - BloodConnect</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #faf8f8;
        }

        .mono {
            font-family: 'JetBrains Mono', monospace;
        }

        /* Premium Smooth Entrance Physics */
        @keyframes springReveal {
            0% {
                opacity: 0;
                transform: translateY(20px) scale(0.99);
            }

            100% {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        .animate-spring-in {
            opacity: 0;
            animation: springReveal 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }

        /* Interactive Hover Glow Ring effect */
        .glow-row:hover {
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.02), 0 8px 16px -6px rgba(0, 0, 0, 0.01);
            border-color: rgba(220, 38, 38, 0.12);
        }
    </style>
</head>

<body class="text-slate-800 antialiased min-h-screen flex selection:bg-red-500 selection:text-white">

    <div class="flex-1 flex flex-col min-h-screen">

        <main class="flex-1 p-4 sm:p-6 lg:p-8 max-w-7xl w-full mx-auto space-y-6 sm:space-y-8">

            <div class="mb-2 animate-spring-in">
                <h3 class="text-2xl sm:text-4xl font-black text-slate-900 tracking-tight flex items-center gap-2">
                    Welcome, <?= htmlspecialchars($donor_name) ?>! <span class="animate-bounce inline-block [animation-duration:2s]">👋</span>
                </h3>
                <p class="text-xs sm:text-sm text-slate-500 font-medium mt-1">Here is your operational snapshot and outstanding clinical patient demands.</p>
            </div>

            <div class="max-w-7xl mx-auto p-4 sm:p-6 lg:p-8 min-h-screen transition-all opacity-0 translate-y-6 ease-out duration-700" id="bloodRequestsContainer">

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">

                    <div class="bg-white border border-slate-100 p-5 sm:p-6 rounded-2xl sm:rounded-3xl shadow-sm hover:shadow-xl hover:shadow-slate-200/50 hover:-translate-y-1 transition-all duration-300 flex items-center gap-5 group animate-spring-in glow-row" style="animation-delay:100ms;">
                        <div class="w-14 h-14 bg-red-50 rounded-2xl flex items-center justify-center text-red-500 group-hover:bg-gradient-to-br group-hover:from-red-500 group-hover:to-rose-600 group-hover:text-white transition-all duration-300 shadow-sm shrink-0">
                            <i class="fa-solid fa-droplet text-2xl"></i>
                        </div>
                        <div class="min-w-0">
                            <p class="text-[10px] sm:text-xs text-slate-400 font-bold uppercase tracking-wider">Blood Group</p>
                            <h4 class="text-xl sm:text-2xl font-black text-slate-900 mt-0.5 flex items-baseline gap-1.5">
                                <?= htmlspecialchars($blood_group); ?>
                                <span class="text-xs font-semibold text-slate-400 truncate"><?= htmlspecialchars($blood_type_status); ?></span>
                            </h4>
                        </div>
                    </div>

                    <div class="bg-white border border-slate-100 p-5 sm:p-6 rounded-2xl sm:rounded-3xl shadow-sm hover:shadow-xl hover:shadow-slate-200/50 hover:-translate-y-1 transition-all duration-300 flex items-center gap-5 group animate-spring-in glow-row" style="animation-delay:150ms;">
                        <div class="w-14 h-14 bg-emerald-50 rounded-2xl flex items-center justify-center text-emerald-500 group-hover:bg-gradient-to-br group-hover:from-emerald-500 group-hover:to-teal-600 group-hover:text-white transition-all duration-300 shadow-sm shrink-0">
                            <i class="fa-solid fa-circle-check text-2xl"></i>
                        </div>
                        <div>
                            <p class="text-[10px] sm:text-xs text-slate-400 font-bold uppercase tracking-wider">Availability Status</p>
                            <h4 class="text-lg sm:text-xl font-black text-emerald-600 mt-0.5 flex items-center gap-2">
                                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                                <?= htmlspecialchars($availability); ?>
                            </h4>
                            <p class="text-xs text-slate-400 mt-0.5 font-medium">You are ready to donate</p>
                        </div>
                    </div>

                    <div class="bg-white border border-slate-100 p-5 sm:p-6 rounded-2xl sm:rounded-3xl shadow-sm hover:shadow-xl hover:shadow-slate-200/50 hover:-translate-y-1 transition-all duration-300 flex items-center gap-5 group sm:col-span-2 lg:col-span-1 animate-spring-in glow-row" style="animation-delay:200ms;">
                        <div class="w-14 h-14 bg-amber-50 rounded-2xl flex items-center justify-center text-amber-500 group-hover:bg-gradient-to-br group-hover:from-amber-500 group-hover:to-orange-500 group-hover:text-white transition-all duration-300 shadow-sm shrink-0">
                            <i class="fa-solid fa-calendar-check text-2xl"></i>
                        </div>
                        <div class="min-w-0">
                            <p class="text-[10px] sm:text-xs text-slate-400 font-bold uppercase tracking-wider">Last Donation</p>
                            <h4 class="text-base sm:text-lg font-extrabold text-slate-900 mt-0.5 truncate"><?= htmlspecialchars($last_donation_date); ?></h4>
                            <p class="text-xs text-slate-400 mt-0.5 truncate font-medium"><i class="fa-solid fa-location-dot text-[10px] mr-1"></i><?= htmlspecialchars($last_donation_location); ?></p>
                        </div>
                    </div>
                </div>

                <div class="space-y-4 animate-spring-in" style="animation-delay:250ms;">
                    <div class="flex items-center gap-3 border-b border-slate-100 pb-3">
                        <h3 class="text-lg sm:text-xl font-extrabold text-slate-900 tracking-tight">Active Inbound Requests</h3>
                        <span class="bg-red-500 text-white text-xs font-black px-2.5 py-0.5 rounded-full shadow-sm shadow-red-500/20"><?= $pending_requests_count; ?></span>
                    </div>

                    <div class="space-y-4">
                        <?php $items = $requests ?? $blood_requests; ?>
                        <?php foreach ($items as $index => $request):
                            $rid = $request['request_id'] ?? $request['id'] ?? 0;
                            $hospital = $request['hospital_name'] ?? $request['location'] ?? '-';
                            $patient = $request['patient_name'] ?? $request['requester'] ?? '-';
                            $blood = $request['blood_group_needed'] ?? $request['blood_type'] ?? '-';
                            $units = $request['unit'] ?? $request['units'] ?? '-';
                            $severity = $request['urgency'] ?? $request['priority'] ?? 'Routine';
                            $status = $request['status_name'] ?? $request['status'] ?? 'pending';
                            $donorResp = (int)($request['donor_response_status'] ?? 0);
                            $isPending = stripos((string)$status, 'pending') !== false;
                            $isAccepted = stripos((string)$status, 'accepted') !== false;
                        ?>
                            <?php
                            $priorityColor = 'border-slate-200';
                            $badgeColor = 'bg-slate-100 text-slate-600';
                            $sevUpper = strtoupper((string)$severity);
                            if ($sevUpper === 'CRITICAL' || $sevUpper === 'HIGH') {
                                $priorityColor = 'border-l-[5px] border-l-rose-500';
                                $badgeColor = 'bg-rose-50 border border-rose-100 text-rose-700';
                            } elseif ($sevUpper === 'URGENT' || $sevUpper === 'MEDIUM') {
                                $priorityColor = 'border-l-[5px] border-l-amber-500';
                                $badgeColor = 'bg-amber-50 border border-amber-100 text-amber-700';
                            }
                            ?>

                            <div class="bg-white border <?= $priorityColor; ?> border-slate-100 p-4 sm:p-5 rounded-2xl shadow-sm hover:shadow-md transition-all duration-200 flex flex-col lg:flex-row lg:items-center justify-between gap-4 animate-spring-in glow-row" style="animation-delay: <?= 300 + ($index * 50); ?>ms;">

                                <div class="flex items-start gap-4 min-w-0">
                                    <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-red-50 to-red-100/60 border border-red-200/50 text-red-600 font-black flex items-center justify-center shrink-0 text-base shadow-sm">
                                        <?= htmlspecialchars($blood); ?>
                                    </div>

                                    <div class="space-y-1 min-w-0">
                                        <div class="flex flex-wrap items-center gap-2">
                                            <h4 class="font-bold text-slate-900 text-sm sm:text-base truncate">Request from: <?= htmlspecialchars($patient); ?></h4>
                                            <span class="text-[9px] px-2.5 py-0.5 rounded-full font-bold uppercase tracking-wider <?= $badgeColor; ?>">
                                                <?= htmlspecialchars($severity); ?> Priority
                                            </span>
                                        </div>

                                        <div class="flex flex-col sm:flex-row sm:items-center gap-1.5 sm:gap-4 text-xs sm:text-sm text-slate-500">
                                            <p class="truncate"><i class="fa-solid fa-hospital mr-1 text-slate-400 text-xs"></i> <?= htmlspecialchars($hospital); ?></p>
                                            <span class="hidden sm:inline text-slate-300">•</span>
                                            <p class="font-medium shrink-0">
                                                <span class="font-bold text-slate-900"><?= htmlspecialchars($units); ?></span> Units needed
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <div class="flex items-center justify-between lg:justify-end gap-4 pt-3 lg:pt-0 border-t border-slate-50 lg:border-t-0 shrink-0">
                                    <?php if ($donorResp === 13): ?>
                                        <div class="flex items-center gap-3 bg-rose-50 border border-rose-100/80 px-3 py-2 rounded-xl">
                                            <span class="flex items-center gap-1.5 text-rose-700 font-bold text-xs sm:text-sm">
                                                <i class="fa-solid fa-circle-xmark text-rose-500"></i> Declined
                                            </span>
                                        </div>
                                    <?php elseif ($isAccepted || $donorResp === 12): ?>
                                        <div class="flex items-center gap-3 bg-emerald-50 border border-emerald-100/80 px-3 py-2 rounded-xl">
                                            <span class="flex items-center gap-1.5 text-emerald-700 font-bold text-xs sm:text-sm">
                                                <i class="fa-solid fa-circle-check text-emerald-500"></i> Accepted
                                            </span>
                                        </div>
                                    <?php elseif ($isPending && $donorResp === 0): ?>
                                        <form action="/BloodConnect/public/donor/request/accept" method="POST" class="flex gap-2 w-full sm:w-auto" style="display:inline-flex">
                                            <input type="hidden" name="request_id" value="<?= (int)$rid; ?>">
                                            <button type="submit" class="flex-1 sm:flex-none px-4 sm:px-5 py-2.5 bg-emerald-500 hover:bg-emerald-600 active:scale-[0.98] text-white font-bold text-xs sm:text-sm rounded-xl shadow-sm shadow-emerald-500/10 transition-all">
                                                Accept
                                            </button>
                                        </form>
                                        <form action="/BloodConnect/public/donor/request/decline" method="POST" class="flex gap-2 w-full sm:w-auto" style="display:inline-flex" onsubmit="return confirm('Are you sure you want to decline this request?');">
                                            <input type="hidden" name="request_id" value="<?= (int)$rid; ?>">
                                            <button type="submit" class="flex-1 sm:flex-none px-4 sm:px-5 py-2.5 border border-slate-200 text-slate-600 hover:bg-rose-50 hover:text-rose-600 hover:border-rose-200 active:scale-[0.98] font-bold text-xs sm:text-sm rounded-xl transition-all">
                                                Decline
                                            </button>
                                        </form>
                                    <?php else: ?>
                                        <div class="flex items-center gap-3 bg-slate-50 border border-slate-100/80 px-3 py-2 rounded-xl">
                                            <span class="flex items-center gap-1.5 text-slate-600 font-bold text-xs sm:text-sm">
                                                <i class="fa-regular fa-clock text-slate-400"></i> <?= htmlspecialchars($status) ?>
                                            </span>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
        const menuBtn = document.getElementById('menu-btn');
        const sidebar = document.getElementById('sidebar');
        const backdrop = document.getElementById('sidebar-backdrop');

        function toggleSidebar() {
            if (sidebar) sidebar.classList.toggle('-translate-x-full');
            if (backdrop) backdrop.classList.toggle('hidden');
        }

        if (menuBtn) menuBtn.addEventListener('click', toggleSidebar);
        if (backdrop) backdrop.addEventListener('click', toggleSidebar);
    </script>
</body>

</html>