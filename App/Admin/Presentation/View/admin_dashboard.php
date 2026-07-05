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

$activities = [
    ['text' => 'New blood request <strong class="font-semibold text-slate-800">REQ1002</strong> has been approved.', 'time' => 'Today, 11:30 AM', 'dot' => 'bg-emerald-500'],
    ['text' => 'Inventory Alert: Blood group <strong class="font-semibold text-slate-800">O-Negative</strong> is running low.', 'time' => 'Today, 09:15 AM', 'dot' => 'bg-amber-500'],
    ['text' => 'Donor <strong class="font-semibold text-slate-800">Aung Ko Ko</strong> completed a donation transaction.', 'time' => 'Yesterday, 04:45 PM', 'dot' => 'bg-emerald-500'],
    ['text' => 'System dispatch schedules verified for <strong class="font-semibold text-slate-800">General Hospital</strong>.', 'time' => 'Yesterday, 02:10 PM', 'dot' => 'bg-blue-500'],
    ['text' => 'New hospital partner facility <strong class="font-semibold text-slate-800">City Clinic</strong> registered successfully.', 'time' => '12 Jun, 10:00 AM', 'dot' => 'bg-emerald-500'],
];
?>

<div class="space-y-8 max-w-7xl mx-auto">

    <div>
        <h1 class="text-2xl font-bold text-slate-900">
            Welcome, <?= htmlspecialchars($adminName) ?>! 👋
        </h1>
    </div>

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

    <section class="bg-white rounded-2xl shadow-sm border overflow-hidden">
        <div class="px-6 py-5 border-b flex justify-between items-center">
            <h3 class="font-bold text-slate-800">System Activity</h3>
            <!-- <a href="#" class="text-sm text-blue-600 hover:underline">View All</a> -->
        </div>

        <div class="divide-y">
            <?php foreach ($activities as $act): ?>
                <div class="px-6 py-4 flex justify-between items-center hover:bg-slate-50">
                    <div class="flex items-center space-x-4">
                        <span class="w-2.5 h-2.5 rounded-full <?= $act['dot'] ?>"></span>
                        <p class="text-sm text-slate-600">
                            <?= $act['text'] ?>
                        </p>
                    </div>

                    <span class="text-xs text-slate-400">
                        <?= htmlspecialchars($act['time']) ?>
                    </span>
                </div>
            <?php endforeach; ?>
        </div>
    </section>

</div>