<?php
$requests = $requests ?? [];
?>

<div class="max-w-7xl mx-auto p-6">
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-slate-900">Accepted Blood Request History</h2>
        <p class="text-sm text-slate-500">Review the requests you accepted and view the patient details.</p>
    </div>

    <div class="rounded-2xl border border-slate-200 bg-white shadow-sm overflow-hidden">
        <?php if (empty($requests)): ?>
            <div class="p-8 text-center text-slate-500">No accepted requests found yet.</div>
        <?php else: ?>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50/70 border-b border-slate-100 text-[11px] font-bold uppercase tracking-wider text-slate-400">
                            <th class="py-4 px-5">Request Code</th>
                            <th class="py-4 px-5">Patient</th>
                            <th class="py-4 px-5">Blood Group</th>
                            <th class="py-4 px-5">Hospital</th>
                            <th class="py-4 px-5">Created</th>
                            <th class="py-4 px-5 text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-sm font-medium text-slate-700">
                        <?php foreach ($requests as $request): ?>
                            <tr class="hover:bg-slate-50/50 transition-colors duration-200">
                                <td class="py-4 px-5 font-semibold text-slate-900">
                                    <?= htmlspecialchars((string)($request['request_code'] ?? 'N/A')) ?>
                                </td>
                                <td class="py-4 px-5">
                                    <?= htmlspecialchars((string)($request['patient_name'] ?? 'Patient')) ?>
                                </td>
                                <td class="py-4 px-5">
                                    <span class="inline-block rounded-lg border border-red-100 bg-red-50 px-2.5 py-1 text-xs font-bold text-red-600">
                                        <?= htmlspecialchars((string)($request['blood_group_needed'] ?? '-')) ?>
                                    </span>
                                </td>
                                <td class="py-4 px-5">
                                    <?= htmlspecialchars((string)($request['hospital_name'] ?? '-')) ?>
                                </td>
                                <td class="py-4 px-5 text-slate-500">
                                    <?= htmlspecialchars((string)($request['created_at'] ?? '-')) ?>
                                </td>
                                <td class="py-4 px-5 text-center">
                                    <a href="/BloodConnect/public/donor/history/view?id=<?= (int)($request['request_id'] ?? 0) ?>"
                                        class="inline-flex items-center rounded-lg bg-[#ce2424] px-3 py-2 text-sm font-semibold text-white hover:bg-[#a61c1c]">
                                        View
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>