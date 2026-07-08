<?php
$request = $request ?? [];
$user = $user ?? [];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blood Request Details | BloodConnect</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="bg-slate-50 min-h-screen text-slate-800">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
            <div>
                <h2 class="text-2xl font-black text-slate-900">Blood Request Details</h2>
                <p class="text-sm text-slate-500 mt-1">Review the request details and accept if you can help.</p>
            </div>
            <a href="/BloodConnect/public/donor/blood-requests" class="inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-600 hover:bg-slate-50">
                <i class="fa-solid fa-arrow-left"></i> Back to Requests
            </a>
        </div>

        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <div class="flex flex-col md:flex-row md:items-start md:justify-between gap-4 border-b border-slate-100 pb-6">
                <div>
                    <p class="text-xs font-bold uppercase tracking-wider text-slate-400">Request Code</p>
                    <h3 class="mt-1 text-xl font-black text-slate-900"><?= htmlspecialchars($request['request_code'] ?? '-') ?></h3>
                </div>
                <div class="flex flex-wrap gap-2">
                    <div class="rounded-full bg-red-50 px-3 py-1.5 text-sm font-bold text-red-600">
                        <?= htmlspecialchars($request['urgency'] ?? '-') ?> urgency
                    </div>
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
                    <div class="rounded-full px-3 py-1.5 text-sm font-bold <?= $statusClass ?>">
                        <?= htmlspecialchars($status) ?>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                <div class="space-y-4">
                    <div>
                        <p class="text-xs font-bold uppercase tracking-wider text-slate-400">Patient Name</p>
                        <p class="mt-1 text-base font-semibold text-slate-800"><?= htmlspecialchars($request['patient_name'] ?? '-') ?></p>
                    </div>
                    <div>
                        <p class="text-xs font-bold uppercase tracking-wider text-slate-400">Blood Group Needed</p>
                        <p class="mt-1 text-base font-semibold text-slate-800"><?= htmlspecialchars($request['blood_group_needed'] ?? '-') ?></p>
                    </div>
                    <div>
                        <p class="text-xs font-bold uppercase tracking-wider text-slate-400">Units Needed</p>
                        <p class="mt-1 text-base font-semibold text-slate-800"><?= (int)($request['unit'] ?? 0) ?></p>
                    </div>
                </div>

                <div class="space-y-4">
                    <div>
                        <p class="text-xs font-bold uppercase tracking-wider text-slate-400">Hospital</p>
                        <p class="mt-1 text-base font-semibold text-slate-800"><?= htmlspecialchars($request['hospital_name'] ?? '-') ?></p>
                    </div>
                    <div>
                        <p class="text-xs font-bold uppercase tracking-wider text-slate-400">Contact Phone</p>
                        <p class="mt-1 text-base font-semibold text-slate-800"><?= htmlspecialchars($request['contact_phone'] ?? '-') ?></p>
                    </div>
                    <div>
                        <p class="text-xs font-bold uppercase tracking-wider text-slate-400">Submitted</p>
                        <p class="mt-1 text-base font-semibold text-slate-800"><?= htmlspecialchars($request['created_at'] ?? '-') ?></p>
                    </div>
                </div>
            </div>

            <?php
            $isAccepted = (stripos((string)($request['status_name'] ?? $request['status'] ?? 'Pending'), 'accepted') !== false) || (int)($request['status'] ?? 0) === 8;
            ?>
            <?php if (!$isAccepted): ?>
                <div class="mt-8 flex flex-col sm:flex-row gap-3">
                    <form action="/BloodConnect/public/donor/request/accept" method="POST" class="w-full sm:w-auto">
                        <input type="hidden" name="request_id" value="<?= (int)($request['request_id'] ?? 0) ?>">
                        <button type="submit" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 rounded-xl bg-emerald-600 px-5 py-3 text-sm font-bold text-white hover:bg-emerald-700">
                            <i class="fa-solid fa-check"></i> Accept Request
                        </button>
                    </form>
                </div>
            <?php else: ?>
                <div class="mt-8 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-semibold text-emerald-700">
                    This request has already been accepted.
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>

</html>