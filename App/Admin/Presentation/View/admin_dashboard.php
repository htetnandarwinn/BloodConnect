<?php

if (!isset($data) || !is_array($data)) {
    $data = [
        'adminName' => 'Admin',
        'totalDonors' => 0,
        'totalPatients' => 0,
        'pendingRequests' => 0,
        'acceptedRequests' => 0,
    ];
}

$adminName = $data['adminName'] ?? 'Admin';

$basePath = '/BloodConnect/public';

$stats = [
    ['label' => 'Total Donors', 'value' => $data['totalDonors'], 'icon' => '💧', 'bg' => 'bg-emerald-500/10 text-emerald-600 border-emerald-500/20', 'link' => "$basePath/admin/donor-management?filter=donors"],
    ['label' => 'Total Patients', 'value' => $data['totalPatients'], 'icon' => '🏥', 'bg' => 'bg-sky-500/10 text-sky-600 border-sky-500/20', 'link' => "$basePath/admin/user-management?filter=patients"],
    ['label' => 'Pending Requests', 'value' => $data['pendingRequests'], 'icon' => '⏳', 'bg' => 'bg-amber-500/10 text-amber-600 border-amber-500/20', 'link' => "$basePath/admin/blood-requests?filter=pending"],
    ['label' => 'Accepted Requests', 'value' => $data['acceptedRequests'] ?? 0, 'icon' => '📋', 'bg' => 'bg-indigo-500/10 text-indigo-600 border-indigo-500/20', 'link' => "$basePath/admin/blood-requests?filter=accepted"],
];

// ✅ REAL DATABASE ACTIVITY
try {
    $logger = new \App\Shared\Infrastructure\Activity\ActivityLogger();
    $activities = $logger->getLatest(10);
} catch (\Exception $e) {
    $activities = [];
}

/**
 * TIME AGO FUNCTION (Optimized short versions for better mobile fitting)
 */
function timeAgo($datetime)
{
    $time = strtotime($datetime);
    $diff = time() - $time;

    if ($diff < 60) return $diff . "s ago";

    $diff = floor($diff / 60);
    if ($diff < 60) return $diff . "m ago";

    $diff = floor($diff / 60);
    if ($diff < 24) return $diff . "h ago";

    $diff = floor($diff / 24);
    if ($diff < 7) return $diff . "d ago";

    return date("d M", $time);
}
?>

<style>
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(15px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .animate-fade-in-up {
        animation: fadeInUp 0.5s ease-out forwards;
    }

    .animation-delay-100 {
        animation-delay: 100ms;
    }

    .animation-delay-200 {
        animation-delay: 200ms;
    }

    .animation-delay-300 {
        animation-delay: 300ms;
    }

    /* Custom elegant minimalist scrollbar */
    .custom-scrollbar::-webkit-scrollbar {
        width: 6px;
    }

    .custom-scrollbar::-webkit-scrollbar-track {
        background: transparent;
    }

    .custom-scrollbar::-webkit-scrollbar-thumb {
        background-color: #cbd5e1;
        /* slate-300 */
        border-radius: 20px;
    }

    .custom-scrollbar::-webkit-scrollbar-thumb:hover {
        background-color: #94a3b8;
        /* slate-400 */
    }
</style>

<div class="space-y-6 md:space-y-8 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">

    <div class="animate-fade-in-up opacity-0">
        <p class="text-xs font-bold uppercase tracking-wider text-indigo-600 mb-1">Dashboard Overview</p>
        <h1 class="text-2xl md:text-3xl font-extrabold tracking-tight text-slate-950 flex items-center gap-2">
            Welcome back, <span class="bg-gradient-to-r align-middle from-rose-600 to-orange-500 bg-clip-text text-transparent"><?= htmlspecialchars($adminName) ?></span>! 👋
        </h1>
    </div>

    <section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 md:gap-6">
        <?php foreach ($stats as $index => $stat): ?>
            <?php
            $delayClass = match ($index) {
                1 => 'animation-delay-100',
                2 => 'animation-delay-200',
                3 => 'animation-delay-300',
                4 => 'animation-delay-300',
                default => '',
            };
            ?>
            <a href="<?= $stat['link'] ?>" class="animate-fade-in-up opacity-0 <?= $delayClass ?> group relative bg-white/80 backdrop-blur-md rounded-2xl p-6 shadow-sm border border-slate-100 hover:border-slate-200 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 ease-out cursor-pointer">

                <div class="absolute inset-0 bg-gradient-to-br from-slate-50/0 to-slate-50 rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none"></div>

                <div class="relative flex items-center justify-between">
                    <div class="space-y-2">
                        <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">
                            <?= htmlspecialchars($stat['label']) ?>
                        </p>
                        <p class="text-2xl md:text-3xl font-extrabold text-slate-900 tracking-tight stat-counter" data-target="<?= htmlspecialchars((string)$stat['value']) ?>">
                            0
                        </p>
                    </div>

                    <div class="<?= $stat['bg'] ?> border w-14 h-14 rounded-2xl flex items-center justify-center text-2xl shadow-inner transform group-hover:scale-110 transition-transform duration-300 ease-out">
                        <?= $stat['icon'] ?>
                    </div>
                </div>
            </a>
        <?php endforeach; ?>
    </section>

    <?php
    // SVG icon map per activity type
    $typeIcons = [
        'success' => '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>',
        'warning' => '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" /></svg>',
        'error'   => '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" /></svg>',
        'info'    => '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4"><path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" /></svg>',
    ];

    $typeStyles = [
        'success' => ['ring' => 'ring-emerald-500/20', 'bg' => 'bg-emerald-50', 'icon' => 'text-emerald-600', 'border' => 'border-l-emerald-500'],
        'warning' => ['ring' => 'ring-amber-500/20', 'bg' => 'bg-amber-50', 'icon' => 'text-amber-600', 'border' => 'border-l-amber-500'],
        'error'   => ['ring' => 'ring-rose-500/20', 'bg' => 'bg-rose-50', 'icon' => 'text-rose-600', 'border' => 'border-l-rose-500'],
        'info'    => ['ring' => 'ring-sky-500/20', 'bg' => 'bg-sky-50', 'icon' => 'text-sky-600', 'border' => 'border-l-sky-500'],
    ];
    ?>

    <section class="animate-fade-in-up opacity-0 animation-delay-300 bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">

        <div class="px-5 sm:px-6 py-4 sm:py-5 border-b border-slate-100 flex items-center justify-between gap-3">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-xl bg-indigo-50 border border-indigo-100 flex items-center justify-center text-indigo-600 shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4.5 h-4.5" style="width:18px;height:18px;">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 4.5h14.25M3 9h9.75M3 13.5h5.25m5.25-.75H17.25m-5.25 0h5.25m-5.25 0h5.25M3 18h3.75m3 0h3.75M17.25 18h.75" />
                    </svg>
                </div>
                <div>
                    <h3 class="font-bold text-slate-900 tracking-tight text-sm sm:text-base leading-tight">Recent System Activity</h3>
                    <p class="text-[11px] text-slate-400 font-medium leading-none mt-0.5">Live feed of platform events</p>
                </div>
            </div>
            <div class="flex items-center gap-2">
                <span class="relative flex h-2 w-2">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                </span>
                <span class="text-[11px] font-semibold text-emerald-700 bg-emerald-50 border border-emerald-200/60 px-2 py-0.5 rounded-md leading-none">LIVE</span>
            </div>
        </div>

        <div class="divide-y divide-slate-50 max-h-[420px] overflow-y-auto custom-scrollbar">
            <?php if (!empty($activities)): ?>
                <?php foreach ($activities as $act): ?>
                    <?php
                    $type = strtolower($act['type'] ?? 'info');
                    $style = $typeStyles[$type] ?? $typeStyles['info'];
                    $icon = $typeIcons[$type] ?? $typeIcons['info'];
                    $action = htmlspecialchars($act['action'] ?? '');
                    $userName = htmlspecialchars($act['user_name'] ?? '');
                    ?>

                    <div class="relative pl-5 sm:pl-6 pr-5 sm:pr-6 py-3.5 flex items-start gap-3.5 hover:bg-slate-50/60 transition-colors group border-l-2 border-transparent hover:<?= $style['border'] ?>">

                        <div class="w-8 h-8 rounded-lg <?= $style['bg'] ?> flex items-center justify-center <?= $style['icon'] ?> shrink-0 mt-0.5 ring-1 <?= $style['ring'] ?> group-hover:scale-105 transition-transform duration-200">
                            <?= $icon ?>
                        </div>

                        <div class="flex-1 min-w-0 pt-0.5">
                            <p class="text-sm text-slate-700 leading-snug group-hover:text-slate-900 transition-colors">
                                <?php if ($userName): ?>
                                    <span class="font-semibold text-slate-800"><?= $userName ?></span>
                                <?php endif; ?>
                                <?= htmlspecialchars($act['message']) ?>
                            </p>
                            <?php if ($action): ?>
                                <span class="inline-block mt-1 text-[11px] font-medium text-slate-400 bg-slate-100/80 px-2 py-0.5 rounded leading-none">
                                    <?= $action ?>
                                </span>
                            <?php endif; ?>
                        </div>

                        <span class="text-[11px] font-semibold text-slate-400 whitespace-nowrap shrink-0 mt-1 bg-slate-50 group-hover:bg-white group-hover:text-slate-600 border border-transparent group-hover:border-slate-100 px-2 py-1 rounded-md transition-all duration-200">
                            <?= timeAgo($act['created_at']) ?>
                        </span>

                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="px-6 py-16 text-center flex flex-col items-center justify-center">
                    <div class="w-16 h-16 rounded-2xl bg-slate-50 border border-slate-100 flex items-center justify-center mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" class="w-8 h-8 text-slate-300">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 4.5h14.25M3 9h9.75M3 13.5h5.25m5.25-.75H17.25m-5.25 0h5.25m-5.25 0h5.25M3 18h3.75m3 0h3.75M17.25 18h.75" />
                        </svg>
                    </div>
                    <p class="text-sm font-semibold text-slate-500">No recent activity</p>
                    <p class="text-xs text-slate-400 mt-1">System events will appear here in real time.</p>
                </div>
            <?php endif; ?>
        </div>

    </section>

</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const counters = document.querySelectorAll('.stat-counter');

        counters.forEach(counter => {
            const target = parseInt(counter.getAttribute('data-target'), 10) || 0;
            if (target === 0) {
                counter.innerText = '0';
                return;
            }

            const duration = 1200; // Total millisecond runtime
            const startTime = performance.now();

            const updateCounter = (currentTime) => {
                const elapsedTime = currentTime - startTime;
                const progress = Math.min(elapsedTime / duration, 1);

                // Out-Quart easing formulation for organic deceleration momentum
                const easeProgress = 1 - Math.pow(1 - progress, 4);
                const currentValue = Math.floor(easeProgress * target);

                counter.innerText = currentValue.toLocaleString();

                if (progress < 1) {
                    requestAnimationFrame(updateCounter);
                } else {
                    counter.innerText = target.toLocaleString();
                }
            };

            requestAnimationFrame(updateCounter);
        });
    });
</script>