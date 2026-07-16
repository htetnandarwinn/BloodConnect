<?php
$request = $request ?? [];
$user = $user ?? [];

// Dynamic Style Mapping Matrix Helpers
function getDetailsUrgencyStyle($urgency)
{
    return match (strtoupper((string)$urgency)) {
        'CRITICAL' => 'bg-rose-50 text-rose-600 border-rose-200/50',
        'URGENT'   => 'bg-orange-50 text-orange-600 border-orange-200/50',
        default    => 'bg-slate-50 text-slate-500 border-slate-200/50',
    };
}

function getDetailsBloodStyle($type)
{
    $type = strtolower((string)$type);
    if (str_contains($type, 'negative') || str_contains($type, '-')) {
        return 'text-rose-600 bg-rose-50 border-rose-200/40';
    }
    return 'text-emerald-600 bg-emerald-50 border-emerald-200/40';
}

$status = (string)($request['status_name'] ?? $request['status'] ?? 'Pending');
$statusClass = 'bg-slate-50 text-slate-500 border-slate-200/50';
if (stripos($status, 'accepted') !== false || (int)($request['status'] ?? 0) === 8) {
    $statusClass = 'bg-emerald-50 text-emerald-700 border-emerald-200/50';
} elseif (stripos($status, 'assigned') !== false || (int)($request['status'] ?? 0) === 42) {
    $statusClass = 'bg-violet-50 text-violet-700 border-violet-200/50';
} elseif (stripos($status, 'declined') !== false || (int)($request['status'] ?? 0) === 10) {
    $statusClass = 'bg-rose-50 text-rose-700 border-rose-200/50';
} elseif (stripos($status, 'completed') !== false || (int)($request['status'] ?? 0) === 9) {
    $statusClass = 'bg-blue-50 text-blue-700 border-blue-200/50';
}

$isAccepted = (stripos((string)($request['status_name'] ?? $request['status'] ?? 'Pending'), 'accepted') !== false) || (int)($request['status'] ?? 0) === 8;
$isAssigned = (stripos((string)($request['status_name'] ?? $request['status'] ?? ''), 'assigned') !== false) || (int)($request['status'] ?? 0) === 42;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blood Request Details | BloodConnect</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(12px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in-up {
            animation: fadeInUp 0.4s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }
    </style>
</head>

<body class="bg-slate-50 min-h-screen text-slate-800 tracking-tight antialiased">
    <div class="max-w-4xl mx-auto p-4 sm:p-6 lg:p-8">

        <div class="relative bg-white border border-slate-200/60 rounded-2xl p-6 mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-6 shadow-xs">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-[#ce2424] text-white rounded-2xl flex items-center justify-center shadow-lg shadow-red-600/10 shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6 text-white">
                        <path d="M12 2.69l5.66 5.66a8 8 0 1 1-11.31 0z" />
                    </svg>
                </div>
                <div>
                    <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight leading-none">Ticket Overview</h1>
                    <p class="text-xs sm:text-sm text-slate-400 font-medium mt-1.5">Review system metrics carefully before proceeding with acceptances.</p>
                </div>
            </div>

            <a href="/BloodConnect/public/donor/blood-requests" class="inline-flex items-center gap-2 rounded-xl border border-slate-200/80 bg-white px-4 py-2.5 text-xs font-bold text-slate-600 hover:bg-slate-50 shadow-3xs transition-all active:scale-95 self-start sm:self-auto">
                <i class="fa-solid fa-arrow-left"></i> Back to Requests
            </a>
        </div>

        <div class="bg-white border border-slate-200/70 rounded-3xl p-6 sm:p-8 space-y-8 shadow-xs animate-fade-in-up">

            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 border-b border-slate-100 pb-6">
                <div>
                    <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400 font-mono block">Ticket Registry Identifier</span>
                    <h3 class="text-xl font-black text-slate-900 tracking-tight mt-1"><?= htmlspecialchars($request['request_code'] ?? '-') ?></h3>
                </div>
                <div class="flex items-center gap-2">
                    <span class="inline-block px-3 py-1 text-[9px] font-extrabold rounded-lg uppercase tracking-widest border shadow-3xs <?= getDetailsUrgencyStyle($request['urgency'] ?? 'Routine') ?>">
                        <?= htmlspecialchars(strtoupper((string)($request['urgency'] ?? 'Routine'))) ?>
                    </span>
                    <span class="inline-block px-3 py-1 text-[9px] font-extrabold rounded-lg uppercase tracking-widest border shadow-3xs <?= $statusClass ?>">
                        <?= htmlspecialchars(ucwords((string)$status)) ?>
                    </span>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-8 gap-y-6">

                <div class="space-y-1.5">
                    <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400 block">Patient Identity</span>
                    <p class="text-sm font-bold text-slate-800"><?= htmlspecialchars($request['patient_name'] ?? '-') ?></p>
                </div>

                <div class="space-y-1.5">
                    <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400 block">Assigned Medical Facility</span>
                    <p class="text-sm font-bold text-slate-800"><?= htmlspecialchars($request['hospital_name'] ?? '-') ?></p>
                </div>

                <div class="space-y-1.5">
                    <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400 block">Required Units Volume</span>
                    <p class="text-sm font-extrabold text-slate-800"><?= (int)($request['unit'] ?? 0) ?> Bags</p>
                </div>

                <div class="space-y-1.5">
                    <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400 block">Contact Phone Number</span>
                    <p class="text-sm font-bold text-slate-800 font-mono"><?= htmlspecialchars($request['contact_phone'] ?? '-') ?></p>
                </div>

                <div class="space-y-1.5">
                    <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400 block">Target Blood Classification</span>
                    <div class="pt-0.5">
                        <span class="inline-flex items-center justify-center px-3 py-1 rounded-lg border font-black text-xs shadow-3xs font-mono <?= getDetailsBloodStyle($request['blood_group_needed'] ?? '-') ?>">
                            <?= htmlspecialchars($request['blood_group_needed'] ?? '-') ?>
                        </span>
                    </div>
                </div>

                <div class="space-y-1.5">
                    <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400 block">Submission Timestamp</span>
                    <p class="text-sm font-semibold text-slate-500 font-mono"><?= htmlspecialchars($request['created_at'] ?? '-') ?></p>
                </div>

            </div>

            <div class="border-t border-slate-100 pt-6">
                <?php if ($isAccepted): ?>
                    <div class="rounded-xl border border-emerald-200 bg-emerald-50/60 px-4 py-3 text-xs font-bold text-emerald-700 flex items-center gap-2">
                        <i class="fa-solid fa-circle-check text-emerald-500"></i> This hospital ticket has already been claimed and accepted.
                    </div>
                <?php elseif ($isAssigned): ?>
                    <div class="flex flex-col sm:flex-row sm:items-center gap-4">
                        <div class="rounded-xl border border-violet-200 bg-violet-50/60 px-4 py-3 text-xs font-bold text-violet-700 flex items-center gap-2">
                            <i class="fa-solid fa-user-check text-violet-500"></i> You have been assigned to this request by the admin.
                        </div>
                        <form action="/BloodConnect/public/donor/request/accept" method="POST">
                            <input type="hidden" name="request_id" value="<?= (int)($request['request_id'] ?? 0) ?>">
                            <button type="submit" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 rounded-xl bg-emerald-600 px-5 py-3 text-xs font-bold text-white hover:bg-emerald-700 transition-all active:scale-95 shadow-md shadow-emerald-600/10">
                                <i class="fa-solid fa-check"></i> Accept Medical Request
                            </button>
                        </form>
                    </div>
                <?php else: ?>
                    <form action="/BloodConnect/public/donor/request/accept" method="POST" class="w-full sm:w-auto">
                        <input type="hidden" name="request_id" value="<?= (int)($request['request_id'] ?? 0) ?>">
                        <button type="submit" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 rounded-xl bg-emerald-600 px-5 py-3 text-xs font-bold text-white hover:bg-emerald-700 transition-all active:scale-95 shadow-md shadow-emerald-600/10">
                            <i class="fa-solid fa-check"></i> Accept Medical Request
                        </button>
                    </form>
                <?php endif; ?>
            </div>

        </div>
    </div>
</body>

</html>