<?php

if (!isset($data) || !is_array($data)) {
    $data = [
        'adminName' => 'Admin',
        'totalUsers' => 0,
        'totalDonors' => 0,
        'totalRequests' => 0,
        'completedRequests' => 0,
        'acceptedRequests' => 0,
    ];
}

$adminName = $data['adminName'] ?? 'Admin';

// Upgraded modern/vibrant color palette with translucent borders
$stats = [
    ['label' => 'Total Users', 'value' => $data['totalUsers'], 'icon' => '👥', 'bg' => 'bg-rose-500/10 text-rose-600 border-rose-500/20'],
    ['label' => 'Total Donors', 'value' => $data['totalDonors'], 'icon' => '💧', 'bg' => 'bg-emerald-500/10 text-emerald-600 border-emerald-500/20'],
    ['label' => 'Total Requests', 'value' => $data['totalRequests'], 'icon' => '📋', 'bg' => 'bg-sky-500/10 text-sky-600 border-sky-500/20'],
    ['label' => 'Successful Donations', 'value' => $data['completedRequests'], 'sub' => $data['acceptedRequests'] . ' accepted by donors', 'icon' => '🩸', 'bg' => 'bg-red-500/10 text-red-600 border-red-500/20'],
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

    <section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6">
        <?php foreach ($stats as $index => $stat): ?>
            <?php
            $delayClass = match ($index) {
                1 => 'animation-delay-100',
                2 => 'animation-delay-200',
                3 => 'animation-delay-300',
                default => '',
            };
            ?>
            <div class="animate-fade-in-up opacity-0 <?= $delayClass ?> group relative bg-white/80 backdrop-blur-md rounded-2xl p-6 shadow-sm border border-slate-100 hover:border-slate-200 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 ease-out">

                <div class="absolute inset-0 bg-gradient-to-br from-slate-50/0 to-slate-50 rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none"></div>

                <div class="relative flex items-center justify-between">
                    <div class="space-y-2">
                        <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">
                            <?= htmlspecialchars($stat['label']) ?>
                        </p>
                        <p class="text-2xl md:text-3xl font-extrabold text-slate-900 tracking-tight stat-counter" data-target="<?= htmlspecialchars((string)$stat['value']) ?>">
                            0
                        </p>
                        <?php if (!empty($stat['sub'])): ?>
                            <p class="text-[10px] font-medium text-slate-500 mt-1"><?= htmlspecialchars($stat['sub']) ?></p>
                        <?php endif; ?>
                    </div>

                    <div class="<?= $stat['bg'] ?> border w-14 h-14 rounded-2xl flex items-center justify-center text-2xl shadow-inner transform group-hover:scale-110 transition-transform duration-300 ease-out">
                        <?= $stat['icon'] ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </section>

    <section class="animate-fade-in-up opacity-0 animation-delay-300 bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">

        <div class="px-6 py-5 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
            <div class="flex items-center space-x-2">
                <span class="flex h-2 w-2 relative">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-indigo-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2 w-2 bg-indigo-500"></span>
                </span>
                <h3 class="font-bold text-slate-950 tracking-tight text-base">Live System Activity</h3>
            </div>
            <span class="text-xs font-medium px-2.5 py-1 bg-slate-100 text-slate-600 rounded-full">Real-time</span>
        </div>

        <div class="divide-y divide-slate-100 max-h-[380px] overflow-y-auto custom-scrollbar">
            <?php if (!empty($activities)): ?>
                <?php foreach ($activities as $act): ?>
                    <?php
                    $type = strtolower($act['type'] ?? 'info');

                    list($dotColor, $pulseColor) = match ($type) {
                        'success' => ['bg-emerald-500 shadow-emerald-500/40', 'bg-emerald-400'],
                        'warning' => ['bg-amber-500 shadow-amber-500/40', 'bg-amber-400'],
                        'error'   => ['bg-rose-500 shadow-rose-500/40', 'bg-rose-400'],
                        'info'    => ['bg-sky-500 shadow-sky-500/40', 'bg-sky-400'],
                        default   => ['bg-slate-400 shadow-slate-400/40', 'bg-slate-300'],
                    };
                    ?>

                    <div class="px-6 py-4 flex justify-between items-center gap-x-4 hover:bg-slate-50/80 transition-colors group">

                        <div class="flex items-center space-x-4 min-w-0">
                            <span class="relative flex h-2.5 w-2.5 flex-shrink-0 mt-0.5">
                                <span class="group-hover:animate-ping absolute inline-flex h-full w-full rounded-full <?= $pulseColor ?> opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-2.5 w-2.5 shadow-sm <?= $dotColor ?>"></span>
                            </span>

                            <p class="text-sm text-slate-700 leading-relaxed truncate group-hover:text-slate-900 transition-colors">
                                <?= htmlspecialchars($act['message']) ?>
                            </p>
                        </div>

                        <span class="text-xs font-medium text-slate-400 bg-slate-50 group-hover:bg-white group-hover:text-slate-600 border border-transparent group-hover:border-slate-100 px-2 py-1 rounded-md transition-all duration-200 flex-shrink-0">
                            <?= timeAgo($act['created_at']) ?>
                        </span>

                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="px-6 py-12 text-center text-sm text-slate-400 flex flex-col items-center justify-center space-y-2">
                    <span class="text-2xl">⚡</span>
                    <p class="font-medium text-slate-500">No recent system activity found.</p>
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