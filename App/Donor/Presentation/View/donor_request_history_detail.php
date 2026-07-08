<?php
$request = $request ?? [];
$patientName = htmlspecialchars((string)($request['patient_username'] ?? $request['patient_name'] ?? 'Patient'));
$patientEmail = htmlspecialchars((string)($request['patient_email'] ?? '-'));
$patientPhone = htmlspecialchars((string)($request['patient_phone'] ?? '-'));
$patientAddress = htmlspecialchars((string)($request['patient_address'] ?? '-'));
?>

<div class="max-w-7xl mx-auto p-6">
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-slate-900">Accepted Request Details</h2>
            <p class="text-sm text-slate-500">View the blood request and the patient who requested it.</p>
        </div>
        <a href="/BloodConnect/public/donor/history" class="rounded-lg border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-600 hover:bg-slate-50">
            ← Back to History
        </a>
    </div>

    <div class="grid gap-6 lg:grid-cols-[1.1fr_0.9fr]">
        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <div class="flex items-center justify-between gap-3">
                <div>
                    <p class="text-xs font-bold uppercase tracking-wider text-slate-400">Request Code</p>
                    <h3 class="mt-1 text-xl font-black text-slate-900"><?= htmlspecialchars((string)($request['request_code'] ?? 'N/A')) ?></h3>
                </div>
                <span class="rounded-full bg-emerald-50 px-3 py-1 text-sm font-semibold text-emerald-600"><?= htmlspecialchars((string)($request['status_name'] ?? $request['status'] ?? 'Accepted')) ?></span>
            </div>

            <div class="mt-6 grid gap-4 sm:grid-cols-2">
                <div class="rounded-xl border border-slate-100 bg-slate-50 p-4">
                    <p class="text-xs font-bold uppercase tracking-wider text-slate-400">Patient</p>
                    <p class="mt-2 text-base font-semibold text-slate-800"><?= $patientName ?></p>
                </div>
                <div class="rounded-xl border border-slate-100 bg-slate-50 p-4">
                    <p class="text-xs font-bold uppercase tracking-wider text-slate-400">Blood Group Needed</p>
                    <p class="mt-2 text-base font-semibold text-slate-800"><?= htmlspecialchars((string)($request['blood_group_needed'] ?? '-')) ?></p>
                </div>
                <div class="rounded-xl border border-slate-100 bg-slate-50 p-4">
                    <p class="text-xs font-bold uppercase tracking-wider text-slate-400">Units Needed</p>
                    <p class="mt-2 text-base font-semibold text-slate-800"><?= (int)($request['unit'] ?? 0) ?></p>
                </div>
                <div class="rounded-xl border border-slate-100 bg-slate-50 p-4">
                    <p class="text-xs font-bold uppercase tracking-wider text-slate-400">Hospital</p>
                    <p class="mt-2 text-base font-semibold text-slate-800"><?= htmlspecialchars((string)($request['hospital_name'] ?? '-')) ?></p>
                </div>
            </div>

            <div class="mt-6 rounded-xl border border-slate-100 bg-slate-50 p-4">
                <p class="text-xs font-bold uppercase tracking-wider text-slate-400">Contact</p>
                <p class="mt-2 text-base font-semibold text-slate-800">Phone: <?= htmlspecialchars((string)($request['contact_phone'] ?? '-')) ?></p>
                <p class="mt-1 text-sm text-slate-500">Created: <?= htmlspecialchars((string)($request['created_at'] ?? '-')) ?></p>
            </div>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <h3 class="text-lg font-black text-slate-900">Patient Request Info</h3>
            <p class="mt-1 text-sm text-slate-500">The patient details from this accepted request.</p>

            <div class="mt-6 space-y-3">
                <div class="rounded-lg border border-slate-100 bg-slate-50 p-4">
                    <p class="text-xs font-bold uppercase tracking-wider text-slate-400">Patient Name</p>
                    <p class="mt-1 text-sm font-semibold text-slate-800"><?= $patientName ?></p>
                </div>
                <div class="rounded-lg border border-slate-100 bg-slate-50 p-4">
                    <p class="text-xs font-bold uppercase tracking-wider text-slate-400">Email</p>
                    <p class="mt-1 text-sm font-semibold text-slate-800"><?= $patientEmail ?></p>
                </div>
                <div class="rounded-lg border border-slate-100 bg-slate-50 p-4">
                    <p class="text-xs font-bold uppercase tracking-wider text-slate-400">Phone</p>
                    <p class="mt-1 text-sm font-semibold text-slate-800"><?= $patientPhone ?></p>
                </div>
                <div class="rounded-lg border border-slate-100 bg-slate-50 p-4">
                    <p class="text-xs font-bold uppercase tracking-wider text-slate-400">Address</p>
                    <p class="mt-1 text-sm font-semibold text-slate-800"><?= $patientAddress ?></p>
                </div>
            </div>
        </div>
    </div>
</div>