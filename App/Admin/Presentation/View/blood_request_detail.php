<?php
$request = $request ?? [];
$donors = $donors ?? [];
$isAccepted = $isAccepted ?? false;
$acceptedDonor = $acceptedDonor ?? null;
$assignedDonor = $assignedDonor ?? null;
$hasAssignedDonor = !empty($request['donor_id']) || !empty($assignedDonor);
$isPendingAssignment = $hasAssignedDonor && !$isAccepted;

$bloodGroup = trim((string)($request['blood_group_needed'] ?? ''));
$patientName = htmlspecialchars((string)($request['patient_name'] ?? 'Patient'));
$requestCode = htmlspecialchars((string)($request['request_code'] ?? 'N/A'));
$hospitalName = htmlspecialchars((string)($request['hospital_name'] ?? 'N/A'));
$urgency = htmlspecialchars((string)($request['urgency'] ?? 'Routine'));
$units = (int)($request['unit'] ?? $request['units'] ?? 0);
$contactPhone = htmlspecialchars((string)($request['contact_phone'] ?? '-'));
$createdAt = htmlspecialchars((string)($request['created_at'] ?? '-'));

// Severity / Urgency Mapping Class
if (!function_exists('getAdminUrgencyStyle')) {
    function getAdminUrgencyStyle($urgency)
    {
        return match (strtoupper((string)$urgency)) {
            'CRITICAL' => 'bg-rose-50 text-rose-600 border-rose-200/50',
            'URGENT'   => 'bg-orange-50 text-orange-600 border-orange-200/50',
            default    => 'bg-slate-50 text-slate-500 border-slate-200/50',
        };
    }
}

// Blood Type Class Matcher
if (!function_exists('getAdminBloodGroupStyle')) {
    function getAdminBloodGroupStyle($type)
    {
        $type = strtolower((string)$type);
        if (str_contains($type, 'negative') || str_contains($type, '-')) {
            return 'text-rose-600 bg-rose-50 border-rose-200/40';
        }
        return 'text-emerald-600 bg-emerald-50 border-emerald-200/40';
    }
}
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
    <div class="max-w-7xl mx-auto p-4 sm:p-6 lg:p-8">

        <div class="relative bg-white border border-slate-200/60 rounded-2xl p-6 mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-6 shadow-xs animate-fade-in-up">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-[#ce2424] text-white rounded-2xl flex items-center justify-center shadow-lg shadow-red-600/10 shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6 text-white">
                        <path d="M12 2.69l5.66 5.66a8 8 0 1 1-11.31 0z" />
                    </svg>
                </div>
                <div>
                    <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight leading-none">Request Control Hub</h1>
                    <p class="text-xs sm:text-sm text-slate-400 font-medium mt-1.5">Review current ticket metrics and assign compatible donor clusters.</p>
                </div>
            </div>

            <a href="/BloodConnect/public/admin/blood-requests" class="inline-flex items-center gap-2 rounded-xl border border-slate-200/80 bg-white px-4 py-2.5 text-xs font-bold text-slate-600 hover:bg-slate-50 shadow-3xs transition-all active:scale-95 self-start sm:self-auto">
                <i class="fa-solid fa-arrow-left"></i> Back to Requests
            </a>
        </div>

        <div class="grid gap-6 lg:grid-cols-[1.15fr_0.85fr]">

            <div class="bg-white border border-slate-200/70 rounded-3xl p-6 shadow-2xs space-y-6 opacity-0 animate-fade-in-up" style="animation-delay: 0.05s;">
                <div class="flex items-center justify-between gap-3 border-b border-slate-100 pb-5">
                    <div>
                        <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400 font-mono block">Ticket Reference Code</span>
                        <h2 class="mt-1 text-xl font-black text-slate-900 tracking-tight"><?= $requestCode ?></h2>
                    </div>
                    <span class="inline-block px-3 py-1 text-[9px] font-extrabold rounded-lg uppercase tracking-widest border shadow-3xs <?= getAdminUrgencyStyle($urgency) ?>">
                        <?= htmlspecialchars(strtoupper((string)$urgency)) ?>
                    </span>
                </div>

                <div class="grid gap-4 sm:grid-cols-2">
                    <div class="rounded-2xl border border-slate-200/60 bg-slate-50/50 p-4 space-y-1">
                        <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400 block">Patient Name</span>
                        <p class="text-sm font-bold text-slate-800"><?= $patientName ?></p>
                    </div>

                    <div class="rounded-2xl border border-slate-200/60 bg-slate-50/50 p-4 space-y-1">
                        <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400 block">Required Classification</span>
                        <div class="pt-0.5">
                            <span class="inline-flex items-center justify-center px-2 py-0.5 rounded-md border font-black text-xs font-mono <?= getAdminBloodGroupStyle($bloodGroup) ?>">
                                <?= htmlspecialchars($bloodGroup) ?>
                            </span>
                        </div>
                    </div>

                    <div class="rounded-2xl border border-slate-200/60 bg-slate-50/50 p-4 space-y-1">
                        <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400 block">Units Requested</span>
                        <p class="text-sm font-extrabold text-slate-800"><?= $units ?> Bags</p>
                    </div>

                    <div class="rounded-2xl border border-slate-200/60 bg-slate-50/50 p-4 space-y-1">
                        <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400 block">Target Facility</span>
                        <p class="text-sm font-bold text-slate-800 truncate"><?= $hospitalName ?></p>
                    </div>
                </div>

                <div class="rounded-2xl border border-slate-200/60 bg-slate-50/50 p-4 space-y-2">
                    <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400 block">Communication & Registry Metadata</span>
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 text-xs">
                        <p class="font-bold text-slate-700"><i class="fa-solid fa-phone text-slate-400 mr-2"></i><?= $contactPhone ?></p>
                        <p class="font-semibold text-slate-400 font-mono"><i class="fa-solid fa-calendar text-slate-300 mr-2"></i><?= $createdAt ?></p>
                    </div>
                </div>
            </div>

            <div class="bg-white border border-slate-200/70 rounded-3xl p-6 shadow-2xs space-y-6 opacity-0 animate-fade-in-up" style="animation-delay: 0.1s;">
                <div class="flex items-center justify-between gap-3 border-b border-slate-100 pb-5">
                    <div>
                        <h3 class="text-lg font-black text-slate-900 tracking-tight">Matchmaking Node</h3>
                        <p class="text-xs text-slate-400 font-medium mt-0.5">Assign compatible verified system donors.</p>
                    </div>
                    <span class="inline-block px-2.5 py-1 text-[9px] font-extrabold rounded-lg uppercase tracking-wider bg-slate-100 text-slate-600 border border-slate-200/60">
                        <?= count($donors) ?> Matches
                    </span>
                </div>

                <?php if ($isAccepted && $acceptedDonor): ?>
                    <div class="rounded-2xl border border-emerald-200 bg-emerald-50/50 p-5 space-y-4">
                        <div class="flex items-center justify-between gap-3">
                            <div>
                                <span class="text-[9px] font-extrabold uppercase tracking-widest text-emerald-600 block">Fulfillment Active</span>
                                <h4 class="mt-1 text-base font-black text-slate-900 tracking-tight">
                                    <?= htmlspecialchars((string)($acceptedDonor['username'] ?? 'Donor')) ?>
                                </h4>
                            </div>
                            <span class="rounded-full bg-emerald-600 px-3 py-1 text-[10px] font-extrabold uppercase tracking-wider text-white shadow-xs shadow-emerald-600/10">Accepted</span>
                        </div>

                        <div class="grid gap-3 sm:grid-cols-2 text-xs">
                            <div class="rounded-xl bg-white border border-emerald-200/40 p-3">
                                <span class="text-[9px] font-bold uppercase tracking-wider text-slate-400 block">Blood Type</span>
                                <p class="mt-0.5 font-bold text-slate-800 font-mono"><?= htmlspecialchars((string)($acceptedDonor['blood_group'] ?? '-')) ?></p>
                            </div>
                            <div class="rounded-xl bg-white border border-emerald-200/40 p-3">
                                <span class="text-[9px] font-bold uppercase tracking-wider text-slate-400 block">Direct Line</span>
                                <p class="mt-0.5 font-bold text-slate-800 font-mono"><?= htmlspecialchars((string)($acceptedDonor['phone'] ?? '-')) ?></p>
                            </div>
                            <div class="rounded-xl bg-white border border-emerald-200/40 p-3 sm:col-span-2 truncate">
                                <span class="text-[9px] font-bold uppercase tracking-wider text-slate-400 block">Secure Mailing Alias</span>
                                <p class="mt-0.5 font-semibold text-slate-600 truncate"><?= htmlspecialchars((string)($acceptedDonor['email'] ?? '-')) ?></p>
                            </div>
                        </div>
                    </div>

                <?php elseif ($isPendingAssignment && $assignedDonor): ?>
                    <div class="rounded-2xl border border-amber-200 bg-amber-50/40 p-5 space-y-4">
                        <div class="flex items-center justify-between gap-3">
                            <div>
                                <span class="text-[9px] font-extrabold uppercase tracking-widest text-amber-600 block">Dispatched Target</span>
                                <h4 class="mt-1 text-base font-black text-slate-900 tracking-tight">
                                    <?= htmlspecialchars((string)($assignedDonor['username'] ?? 'Donor')) ?>
                                </h4>
                            </div>
                            <span class="rounded-full bg-amber-500 px-3 py-1 text-[10px] font-extrabold uppercase tracking-wider text-white shadow-xs shadow-amber-500/10">Pending</span>
                        </div>

                        <p class="text-xs font-semibold text-amber-700 leading-relaxed">This donor has been successfully dispatched to this node but has not verified acceptance metrics yet.</p>

                        <div class="grid gap-3 sm:grid-cols-2 text-xs">
                            <div class="rounded-xl bg-white border border-amber-200/30 p-3">
                                <span class="text-[9px] font-bold uppercase tracking-wider text-slate-400 block">Blood Type</span>
                                <p class="mt-0.5 font-bold text-slate-800 font-mono"><?= htmlspecialchars((string)($assignedDonor['blood_group'] ?? '-')) ?></p>
                            </div>
                            <div class="rounded-xl bg-white border border-amber-200/30 p-3">
                                <span class="text-[9px] font-bold uppercase tracking-wider text-slate-400 block">Direct Line</span>
                                <p class="mt-0.5 font-bold text-slate-800 font-mono"><?= htmlspecialchars((string)($assignedDonor['phone'] ?? '-')) ?></p>
                            </div>
                            <div class="rounded-xl bg-white border border-amber-200/30 p-3 sm:col-span-2 truncate">
                                <span class="text-[9px] font-bold uppercase tracking-wider text-slate-400 block">Secure Mailing Alias</span>
                                <p class="mt-0.5 font-semibold text-slate-600 truncate"><?= htmlspecialchars((string)($assignedDonor['email'] ?? '-')) ?></p>
                            </div>
                        </div>
                    </div>

                <?php elseif (empty($donors)): ?>
                    <div class="rounded-2xl border border-dashed border-slate-200 bg-slate-50/50 p-8 text-center text-xs font-medium text-slate-400">
                        <i class="fa-solid fa-users-slash text-xl block text-slate-300 mb-2"></i>
                        No active verified network donors match this blood group group registry.
                    </div>

                <?php else: ?>
                    <form action="/BloodConnect/public/admin/blood-request/accept" method="POST" class="space-y-4">
                        <input type="hidden" name="request_id" value="<?= (int)($request['request_id'] ?? 0) ?>">

                        <div class="space-y-2">
                            <label class="text-xs font-bold uppercase tracking-wider text-slate-400 block" for="donor_id">
                                Target Allocation Donor
                            </label>
                            <div class="relative">
                                <select id="donor_id" name="donor_id" class="w-full rounded-xl border border-slate-200/80 bg-white pl-4 pr-10 py-3 text-xs font-bold text-slate-700 appearance-none focus:border-red-500 focus:outline-none focus:ring-1 focus:ring-red-500 shadow-3xs transition-all" required>
                                    <option value="" class="font-semibold text-slate-400">-- Choose allocation node --</option>
                                    <?php foreach ($donors as $donor): ?>
                                        <option value="<?= (int)($donor['user_id'] ?? 0) ?>" class="font-medium text-slate-700">
                                            <?= htmlspecialchars((string)($donor['username'] ?? 'Donor')) ?> &middot; [<?= htmlspecialchars((string)($donor['blood_group'] ?? '-')) ?>] &middot; <?= htmlspecialchars((string)($donor['phone'] ?? '-')) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-slate-400">
                                    <i class="fa-solid fa-chevron-down text-[10px]"></i>
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="w-full inline-flex items-center justify-center gap-2 rounded-xl bg-[#ce2424] px-4 py-3 text-xs font-bold text-white hover:bg-[#a61c1c] transition-all active:scale-95 shadow-md shadow-red-600/10">
                            <i class="fa-solid fa-truck-medical"></i> Dispatch Assigned Node
                        </button>
                    </form>
                <?php endif; ?>
            </div>

        </div>
    </div>
</body>

</html>