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
?>

<div class="max-w-7xl mx-auto p-4 sm:p-6 bg-[#faf8f8]">
    <div class="mb-6 flex flex-wrap items-center justify-between gap-3">
        <div>
            <h1 class="text-2xl font-extrabold text-[#1e293b] tracking-tight">Blood Request Details</h1>
            <p class="text-sm text-slate-500 mt-1">Review the request and assign a matching donor.</p>
        </div>
        <a href="/BloodConnect/public/admin/blood-requests" class="inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-600 hover:bg-slate-50">
            ← Back to Requests
        </a>
    </div>

    <div class="grid gap-6 lg:grid-cols-[1.15fr_0.85fr]">
        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <div class="flex items-center justify-between gap-3">
                <div>
                    <p class="text-xs font-bold uppercase tracking-wider text-slate-400">Request Code</p>
                    <h2 class="mt-1 text-xl font-black text-slate-900"><?= $requestCode ?></h2>
                </div>
                <span class="rounded-full bg-rose-50 px-3 py-1 text-sm font-semibold text-rose-600"><?= $urgency ?></span>
            </div>

            <div class="mt-6 grid gap-4 sm:grid-cols-2">
                <div class="rounded-xl border border-slate-100 bg-slate-50 p-4">
                    <p class="text-xs font-bold uppercase tracking-wider text-slate-400">Patient</p>
                    <p class="mt-2 text-base font-semibold text-slate-800"><?= $patientName ?></p>
                </div>
                <div class="rounded-xl border border-slate-100 bg-slate-50 p-4">
                    <p class="text-xs font-bold uppercase tracking-wider text-slate-400">Blood Group Needed</p>
                    <p class="mt-2 text-base font-semibold text-slate-800"><?= htmlspecialchars($bloodGroup) ?></p>
                </div>
                <div class="rounded-xl border border-slate-100 bg-slate-50 p-4">
                    <p class="text-xs font-bold uppercase tracking-wider text-slate-400">Units Needed</p>
                    <p class="mt-2 text-base font-semibold text-slate-800"><?= $units ?></p>
                </div>
                <div class="rounded-xl border border-slate-100 bg-slate-50 p-4">
                    <p class="text-xs font-bold uppercase tracking-wider text-slate-400">Hospital</p>
                    <p class="mt-2 text-base font-semibold text-slate-800"><?= $hospitalName ?></p>
                </div>
            </div>

            <div class="mt-6 rounded-xl border border-slate-100 bg-slate-50 p-4">
                <p class="text-xs font-bold uppercase tracking-wider text-slate-400">Contact</p>
                <p class="mt-2 text-base font-semibold text-slate-800">Phone: <?= $contactPhone ?></p>
                <p class="mt-1 text-sm text-slate-500">Created: <?= $createdAt ?></p>
            </div>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <div class="flex items-center justify-between gap-3">
                <div>
                    <h3 class="text-lg font-black text-slate-900">Matching Donors</h3>
                    <p class="text-sm text-slate-500 mt-1">Select one donor for this request.</p>
                </div>
                <span class="rounded-full bg-emerald-50 px-3 py-1 text-sm font-semibold text-emerald-600"><?= count($donors) ?> found</span>
            </div>

            <?php if ($isAccepted && $acceptedDonor): ?>
                <div class="mt-6 rounded-xl border border-emerald-200 bg-emerald-50 p-5">
                    <div class="flex items-center justify-between gap-3">
                        <div>
                            <p class="text-xs font-bold uppercase tracking-wider text-emerald-600">Accepted Donor</p>
                            <h4 class="mt-1 text-lg font-black text-slate-900">
                                <?= htmlspecialchars((string)($acceptedDonor['username'] ?? 'Donor')) ?>
                            </h4>
                        </div>
                        <span class="rounded-full bg-white px-3 py-1 text-sm font-semibold text-emerald-600">Accepted</span>
                    </div>

                    <div class="mt-4 grid gap-3 sm:grid-cols-2">
                        <div class="rounded-lg bg-white/80 p-3">
                            <p class="text-xs font-bold uppercase tracking-wider text-slate-400">Blood Group</p>
                            <p class="mt-1 text-sm font-semibold text-slate-800">
                                <?= htmlspecialchars((string)($acceptedDonor['blood_group'] ?? '-')) ?>
                            </p>
                        </div>
                        <div class="rounded-lg bg-white/80 p-3">
                            <p class="text-xs font-bold uppercase tracking-wider text-slate-400">Phone</p>
                            <p class="mt-1 text-sm font-semibold text-slate-800">
                                <?= htmlspecialchars((string)($acceptedDonor['phone'] ?? '-')) ?>
                            </p>
                        </div>
                        <div class="rounded-lg bg-white/80 p-3 sm:col-span-2">
                            <p class="text-xs font-bold uppercase tracking-wider text-slate-400">Email</p>
                            <p class="mt-1 text-sm font-semibold text-slate-800">
                                <?= htmlspecialchars((string)($acceptedDonor['email'] ?? '-')) ?>
                            </p>
                        </div>
                    </div>
                </div>
            <?php elseif ($isPendingAssignment && $assignedDonor): ?>
                <div class="mt-6 rounded-xl border border-amber-200 bg-amber-50 p-5">
                    <div class="flex items-center justify-between gap-3">
                        <div>
                            <p class="text-xs font-bold uppercase tracking-wider text-amber-600">Assigned Donor</p>
                            <h4 class="mt-1 text-lg font-black text-slate-900">
                                <?= htmlspecialchars((string)($assignedDonor['username'] ?? 'Donor')) ?>
                            </h4>
                        </div>
                        <span class="rounded-full bg-white px-3 py-1 text-sm font-semibold text-amber-600">Pending</span>
                    </div>

                    <p class="mt-3 text-sm text-amber-700">This donor has been assigned but has not accepted the request yet.</p>

                    <div class="mt-4 grid gap-3 sm:grid-cols-2">
                        <div class="rounded-lg bg-white/80 p-3">
                            <p class="text-xs font-bold uppercase tracking-wider text-slate-400">Blood Group</p>
                            <p class="mt-1 text-sm font-semibold text-slate-800">
                                <?= htmlspecialchars((string)($assignedDonor['blood_group'] ?? '-')) ?>
                            </p>
                        </div>
                        <div class="rounded-lg bg-white/80 p-3">
                            <p class="text-xs font-bold uppercase tracking-wider text-slate-400">Phone</p>
                            <p class="mt-1 text-sm font-semibold text-slate-800">
                                <?= htmlspecialchars((string)($assignedDonor['phone'] ?? '-')) ?>
                            </p>
                        </div>
                        <div class="rounded-lg bg-white/80 p-3 sm:col-span-2">
                            <p class="text-xs font-bold uppercase tracking-wider text-slate-400">Email</p>
                            <p class="mt-1 text-sm font-semibold text-slate-800">
                                <?= htmlspecialchars((string)($assignedDonor['email'] ?? '-')) ?>
                            </p>
                        </div>
                    </div>
                </div>
            <?php elseif (empty($donors)): ?>
                <div class="mt-6 rounded-xl border border-dashed border-slate-200 bg-slate-50 p-6 text-center text-sm text-slate-500">
                    No active donors match this blood group yet.
                </div>
            <?php else: ?>
                <form action="/BloodConnect/public/admin/blood-request/accept" method="POST" class="mt-6 space-y-4">
                    <input type="hidden" name="request_id" value="<?= (int)($request['request_id'] ?? 0) ?>">

                    <label class="block text-sm font-semibold text-slate-700" for="donor_id">
                        Select Donor
                    </label>
                    <select id="donor_id" name="donor_id" class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm focus:border-rose-500 focus:outline-none" required>
                        <option value="">-- Choose donor --</option>
                        <?php foreach ($donors as $donor): ?>
                            <option value="<?= (int)($donor['user_id'] ?? 0) ?>">
                                <?= htmlspecialchars((string)($donor['username'] ?? 'Donor')) ?> · <?= htmlspecialchars((string)($donor['blood_group'] ?? '-')) ?> · <?= htmlspecialchars((string)($donor['phone'] ?? '-')) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>

                    <button type="submit" class="w-full rounded-xl bg-[#ce2424] px-4 py-3 text-sm font-semibold text-white hover:bg-[#a61c1c]">
                        Assign Donor
                    </button>
                </form>
            <?php endif; ?>
        </div>
    </div>
</div>