<?php
$requests = $requests ?? [];
$user = $user ?? [];
$bloodGroup = $blood_group ?? '';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blood Requests | BloodConnect</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="bg-slate-50 min-h-screen text-slate-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
            <div>
                <h2 class="text-2xl font-black text-slate-900">Blood Requests</h2>
                <p class="text-sm text-slate-500 mt-1">Showing requests matching your blood group <span class="font-semibold text-red-600"><?= htmlspecialchars($bloodGroup) ?></span>.</p>
            </div>
            <a href="/BloodConnect/public/donor/dashboard" class="inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-600 hover:bg-slate-50">
                <i class="fa-solid fa-arrow-left"></i> Back to Dashboard
            </a>
        </div>

        <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-bold uppercase tracking-wider text-slate-500">Patient</th>
                            <th class="px-4 py-3 text-left text-xs font-bold uppercase tracking-wider text-slate-500">Blood Needed</th>
                            <th class="px-4 py-3 text-left text-xs font-bold uppercase tracking-wider text-slate-500">Hospital</th>
                            <th class="px-4 py-3 text-left text-xs font-bold uppercase tracking-wider text-slate-500">Urgency</th>
                            <th class="px-4 py-3 text-left text-xs font-bold uppercase tracking-wider text-slate-500">Status</th>
                            <th class="px-4 py-3 text-left text-xs font-bold uppercase tracking-wider text-slate-500">Units</th>
                            <th class="px-4 py-3 text-left text-xs font-bold uppercase tracking-wider text-slate-500">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        <?php if (empty($requests)): ?>
                            <tr>
                                <td colspan="6" class="px-4 py-8 text-center text-sm text-slate-500">No matching blood requests found.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($requests as $request): ?>
                                <tr class="hover:bg-slate-50">
                                    <td class="px-4 py-3 text-sm font-semibold text-slate-800"><?= htmlspecialchars($request['patient_name'] ?? 'Unknown') ?></td>
                                    <td class="px-4 py-3 text-sm text-slate-600"><?= htmlspecialchars($request['blood_group_needed'] ?? '-') ?></td>
                                    <td class="px-4 py-3 text-sm text-slate-600"><?= htmlspecialchars($request['hospital_name'] ?? '-') ?></td>
                                    <td class="px-4 py-3 text-sm">
                                        <span class="rounded-full px-2.5 py-1 text-xs font-bold uppercase tracking-wider bg-red-50 text-red-600">
                                            <?= htmlspecialchars($request['urgency'] ?? '-') ?>
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-sm">
                                        <?php
                                        $status = (string)($request['status_name'] ?? $request['status'] ?? 'Pending');
                                        $statusClass = 'bg-slate-100 text-slate-700';
                                        if (stripos($status, 'accepted') !== false || (int)($request['status'] ?? 0) === 8) {
                                            $statusClass = 'bg-emerald-50 text-emerald-700';
                                        } elseif (stripos($status, 'declined') !== false || (int)($request['status'] ?? 0) === 10) {
                                            $statusClass = 'bg-rose-50 text-rose-700';
                                        } elseif (stripos($status, 'completed') !== false || (int)($request['status'] ?? 0) === 9) {
                                            $statusClass = 'bg-blue-50 text-blue-700';
                                        }
                                        ?>
                                        <span class="rounded-full px-2.5 py-1 text-xs font-bold uppercase tracking-wider <?= $statusClass ?>">
                                            <?= htmlspecialchars($status) ?>
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-sm text-slate-600"><?= (int)($request['unit'] ?? 0) ?></td>
                                    <td class="px-4 py-3 text-sm">
                                        <a href="/BloodConnect/public/donor/blood-request/<?= (int)($request['request_id'] ?? 0) ?>" class="inline-flex items-center gap-2 rounded-lg bg-red-600 px-3 py-2 font-semibold text-white hover:bg-red-700">
                                            <i class="fa-solid fa-eye"></i> View
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>

</html>