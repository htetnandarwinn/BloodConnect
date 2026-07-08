<?php

if (!isset($data) || !is_array($data)) {
    $data = [
        'adminName' => 'Admin',
        'totalUsers' => 0,
        'totalDonors' => 0,
        'totalRequests' => 0,
        'completedRequests' => 0,
    ];
}

$adminName = $data['adminName'] ?? 'Admin';

$stats = [
    ['label' => 'Total Users', 'value' => $data['totalUsers'], 'icon' => '👥', 'bg' => 'bg-red-50'],
    ['label' => 'Total Donors', 'value' => $data['totalDonors'], 'icon' => '💧', 'bg' => 'bg-emerald-50'],
    ['label' => 'Total Requests', 'value' => $data['totalRequests'], 'icon' => '📋', 'bg' => 'bg-blue-50'],
    ['label' => 'Successful Donations', 'value' => $data['completedRequests'], 'icon' => '🩸', 'bg' => 'bg-rose-50'],
];

// ✅ REAL DATABASE ACTIVITY
try {
    $logger = new \App\Shared\Infrastructure\Activity\ActivityLogger();
    $activities = $logger->getLatest(10);
} catch (\Exception $e) {
    $activities = [];
}

/**
 * TIME AGO FUNCTION
 */
function timeAgo($datetime)
{
    $time = strtotime($datetime);
    $diff = time() - $time;

    if ($diff < 60) return $diff . " seconds ago";

    $diff = floor($diff / 60);
    if ($diff < 60) return $diff . " minutes ago";

    $diff = floor($diff / 60);
    if ($diff < 24) return $diff . " hours ago";

    $diff = floor($diff / 24);
    if ($diff < 7) return $diff . " days ago";

    return date("d M, Y", $time);
}

?>

<div class="space-y-8 max-w-7xl mx-auto">

    <!-- HEADER -->
    <div>
        <h1 class="text-2xl font-bold text-slate-900">
            Welcome, <?= htmlspecialchars($adminName) ?>! 👋
        </h1>
    </div>

    <!-- STATS -->
    <section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">

        <?php foreach ($stats as $stat): ?>
            <div class="bg-white rounded-2xl p-5 shadow-sm border hover:shadow-md transition">

                <div class="flex items-center space-x-4">

                    <div class="<?= $stat['bg'] ?> w-12 h-12 rounded-xl flex items-center justify-center text-xl">
                        <?= $stat['icon'] ?>
                    </div>

                    <div>
                        <p class="text-xs font-semibold text-slate-400 uppercase">
                            <?= htmlspecialchars($stat['label']) ?>
                        </p>

                        <p class="text-2xl font-bold text-slate-800">
                            <?= htmlspecialchars((string)$stat['value']) ?>
                        </p>
                    </div>

                </div>

            </div>
        <?php endforeach; ?>

    </section>

    <!-- SYSTEM ACTIVITY -->
    <section class="bg-white rounded-2xl shadow-sm border overflow-hidden">

        <div class="px-6 py-5 border-b flex justify-between items-center">
            <h3 class="font-bold text-slate-800">System Activity</h3>
        </div>

        <div class="divide-y">

            <?php if (!empty($activities)): ?>
                <?php foreach ($activities as $act): ?>

                    <?php
                    $type = strtolower($act['type'] ?? 'info');

                    $dotColor = match ($type) {
                        'success' => 'bg-emerald-500',
                        'warning' => 'bg-amber-500',
                        'error'   => 'bg-red-500',
                        'info'    => 'bg-blue-500',
                        default   => 'bg-slate-400',
                    };
                    ?>

                    <div class="px-6 py-4 flex justify-between items-start hover:bg-slate-50">

                        <!-- LEFT -->
                        <div class="flex items-start space-x-4">

                            <span class="w-2.5 h-2.5 rounded-full mt-2 <?= $dotColor ?>"></span>

                            <p class="text-sm text-slate-700 leading-relaxed">
                                <?= htmlspecialchars($act['message']) ?>
                            </p>

                        </div>

                        <!-- RIGHT -->
                        <span class="text-xs text-slate-400 whitespace-nowrap">
                            <?= timeAgo($act['created_at']) ?>
                        </span>

                    </div>

                <?php endforeach; ?>
            <?php else: ?>
                <div class="px-6 py-6 text-sm text-slate-400">
                    No system activity found.
                </div>
            <?php endif; ?>

        </div>

    </section>

</div>