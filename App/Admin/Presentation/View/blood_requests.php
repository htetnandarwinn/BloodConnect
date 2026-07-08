<?php

use App\Shared\Infrastructure\Database\Database;

$db = Database::getConnection();

/* Fetch blood requests from the database */
$requests = [];

try {
    $stmt = $db->prepare("
        SELECT
            r.request_id,
            r.hospital_name,
            r.patient_name,
            r.blood_group_needed AS blood_type,
            r.unit AS units_requested,
            COALESCE(UPPER(r.urgency), 'ROUTINE') AS severity_level,
            COALESCE(md.label, 'Pending') AS fulfillment_status,
            COALESCE(r.created_at, CURRENT_TIMESTAMP) AS required_date
        FROM blood_requests r
        LEFT JOIN master_data md ON md.id = r.status
        ORDER BY r.created_at DESC
    ");
    $stmt->execute();
    $requests = $stmt->fetchAll();
} catch (Throwable $e) {
    $requests = [];
}

function getSeverityClass($level)
{
    return match (strtoupper((string) $level)) {
        'CRITICAL' => 'bg-rose-50 text-rose-500 font-bold',
        'URGENT' => 'bg-orange-50 text-orange-400 font-bold',
        default => 'bg-slate-50 text-slate-500 font-bold',
    };
}

function getFulfillmentClass($status)
{
    return match (strtolower((string) $status)) {
        'pending' => 'bg-amber-50 text-amber-600 font-semibold',
        'in progress' => 'bg-blue-50 text-blue-600 font-semibold',
        'matched' => 'bg-green-50 text-green-600 font-semibold',
        'unfulfilled' => 'bg-rose-50 text-rose-600 font-semibold',
        default => 'bg-slate-50 text-slate-600 font-semibold',
    };
}

function getBloodTypeClass($type)
{
    $type = strtolower((string) $type);

    if (strpos($type, 'negative') !== false) {
        return 'text-red-600';
    }

    if (strpos($type, 'ab') !== false || strpos($type, 'a-') !== false || strpos($type, 'b-') !== false) {
        return 'text-blue-600';
    }

    return 'text-green-600';
}
?>

<!-- MAIN VIEW CONTAINER WITH SMOOTH INTERFACE ENTRY LAYER -->
<div class="max-w-7xl mx-auto p-4 sm:p-6 bg-[#faf8f8] opacity-0 translate-y-4 transition-all duration-700 ease-out" id="bloodRequestsContainer">

    <!-- COMPACT TITLE BAR MODULE -->
    <div class="mb-6">
        <h1 class="text-2xl font-extrabold text-[#1e293b] tracking-tight">Blood Requests</h1>
    </div>

    <!-- WRAPPER COMPONENT -->
    <div class="bg-white rounded-2xl border border-slate-100 shadow-[0_12px_34px_rgba(0,0,0,0.01)] overflow-hidden transition-all duration-300">

        <?php if (empty($requests)): ?>
            <div class="p-8 text-center text-slate-500">No blood requests found.</div>
        <?php else: ?>
            <div class="hidden lg:block overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-rose-50/40 border-b border-rose-100/30 text-[11px] font-bold tracking-wider text-slate-500 uppercase select-none">
                            <th class="px-6 py-4.5 text-center w-12">#</th>
                            <th class="px-6 py-4.5">Hospital Base / Patient</th>
                            <th class="px-6 py-4.5">Blood Type</th>
                            <th class="px-6 py-4.5">Units Req</th>
                            <th class="px-6 py-4.5 text-center">Severity Level</th>
                            <th class="px-6 py-4.5 text-center">Fulfillment</th>
                            <th class="px-6 py-4.5">Required Date</th>
                            <th class="px-6 py-4.5 text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100/70">
                        <?php foreach ($requests as $index => $req): ?>
                            <tr class="group hover:bg-slate-50/30 transition-all duration-150">
                                <!-- INDEX COUNTER -->
                                <td class="px-6 py-5 text-center text-sm font-medium text-slate-400 select-none">
                                    <?= $index + 1 ?>
                                </td>

                                <!-- HOSPITAL DETAILS -->
                                <td class="px-6 py-5">
                                    <div class="flex flex-col">
                                        <span class="font-bold text-slate-800 text-sm leading-snug tracking-tight group-hover:text-red-600 transition-colors duration-150">
                                            <?= htmlspecialchars($req['hospital_name']) ?>
                                        </span>
                                        <span class="text-xs text-slate-400 font-medium mt-0.5">
                                            Patient: <?= htmlspecialchars($req['patient_name']) ?>
                                        </span>
                                    </div>
                                </td>

                                <!-- BLOOD TYPE CLASSIFICATION -->
                                <td class="px-6 py-5 whitespace-nowrap">
                                    <span class="text-sm font-bold tracking-tight <?= getBloodTypeClass($req['blood_type']) ?>">
                                        <?= htmlspecialchars($req['blood_type']) ?>
                                    </span>
                                </td>

                                <!-- UNITS REQUESTED -->
                                <td class="px-6 py-5 whitespace-nowrap">
                                    <span class="text-sm font-bold text-slate-800">
                                        <?= htmlspecialchars($req['units_requested']) ?> <?= $req['units_requested'] > 1 ? 'Units' : 'Unit' ?>
                                    </span>
                                </td>

                                <!-- SEVERITY PILL BADGES -->
                                <td class="px-6 py-5 text-center whitespace-nowrap">
                                    <span class="inline-flex px-3 py-1 text-[10px] tracking-wider rounded-md uppercase select-none <?= getSeverityClass($req['severity_level']) ?>">
                                        <?= htmlspecialchars($req['severity_level']) ?>
                                    </span>
                                </td>

                                <!-- FULFILLMENT MATRIX STATUS -->
                                <td class="px-6 py-5 text-center whitespace-nowrap">
                                    <span class="inline-flex px-4 py-1 text-[11px] rounded-md tracking-tight capitalize select-none <?= getFulfillmentClass($req['fulfillment_status']) ?>">
                                        <?= htmlspecialchars($req['fulfillment_status']) ?>
                                    </span>
                                </td>

                                <!-- DATE TARGET -->
                                <td class="px-6 py-5 whitespace-nowrap">
                                    <span class="text-sm font-bold text-slate-700 font-sans tracking-tight">
                                        <?= htmlspecialchars($req['required_date']) ?>
                                    </span>
                                </td>

                                <td class="px-6 py-5 text-center whitespace-nowrap">
                                    <a href="/BloodConnect/public/admin/blood-request/view?id=<?= (int)($req['request_id'] ?? 0) ?>"
                                        class="inline-flex items-center rounded-lg bg-[#ce2424] px-3 py-2 text-sm font-semibold text-white hover:bg-[#a61c1c]">
                                        View
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <!-- ==================================================================== -->
            <!-- MOBILE RESPONSIVE BLOCK STACKS                                       -->
            <!-- ==================================================================== -->
            <div class="block lg:hidden divide-y divide-slate-100">
                <?php foreach ($requests as $index => $req): ?>
                    <div class="p-5 flex flex-col gap-4 hover:bg-slate-50/20 transition-colors duration-150">

                        <!-- Row 1: Index Counter & Hospital Info -->
                        <div class="flex items-start justify-between">
                            <div class="flex gap-3">
                                <span class="text-xs font-bold text-slate-300 select-none mt-0.5">#<?= $index + 1 ?></span>
                                <div>
                                    <h4 class="font-bold text-slate-800 text-sm leading-tight"><?= htmlspecialchars($req['hospital_name']) ?></h4>
                                    <p class="text-xs text-slate-400 mt-0.5 font-medium">Patient: <?= htmlspecialchars($req['patient_name']) ?></p>
                                </div>
                            </div>

                            <!-- Blood Group Label Block -->
                            <span class="text-xs font-extrabold tracking-tight shrink-0 <?= getBloodTypeClass($req['blood_type']) ?>">
                                <?= htmlspecialchars($req['blood_type']) ?>
                            </span>
                        </div>

                        <!-- Row 2: Secondary Attributes Config Grid -->
                        <div class="grid grid-cols-2 gap-3 bg-slate-50/60 p-3 rounded-xl border border-slate-100/80 text-xs">
                            <div>
                                <span class="block text-[9px] font-bold text-slate-400 uppercase tracking-wider select-none">Volume Requested</span>
                                <span class="font-bold text-slate-800 mt-0.5 block"><?= htmlspecialchars($req['units_requested']) ?> <?= $req['units_requested'] > 1 ? 'Units' : 'Unit' ?></span>
                            </div>
                            <div>
                                <span class="block text-[9px] font-bold text-slate-400 uppercase tracking-wider select-none">Required Target Date</span>
                                <span class="font-bold text-slate-700 mt-0.5 block"><?= htmlspecialchars($req['required_date']) ?></span>
                            </div>
                        </div>

                        <!-- Row 3: Dual Pill Badge Control Matrix -->
                        <div class="flex items-center justify-between gap-2 pt-1">
                            <div>
                                <span class="inline-flex px-2.5 py-0.5 text-[9px] tracking-wider rounded uppercase select-none <?= getSeverityClass($req['severity_level']) ?>">
                                    <?= htmlspecialchars($req['severity_level']) ?>
                                </span>
                            </div>
                            <div>
                                <span class="inline-flex px-3 py-0.5 text-[10px] rounded tracking-tight capitalize select-none <?= getFulfillmentClass($req['fulfillment_status']) ?>">
                                    <?= htmlspecialchars($req['fulfillment_status']) ?>
                                </span>
                            </div>
                        </div>

                        <div class="pt-1">
                            <a href="/BloodConnect/public/admin/blood-request/view?id=<?= (int)($req['request_id'] ?? 0) ?>"
                                class="inline-flex items-center rounded-lg bg-[#ce2424] px-3 py-2 text-sm font-semibold text-white hover:bg-[#a61c1c]">
                                View
                            </a>
                        </div>

                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

    </div>
</div>

<!-- MODULE ENTRANCE MICRO-ANIMATION JAVASCRIPT -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const container = document.getElementById('bloodRequestsContainer');
        if (container) {
            // Fires animation trigger immediately following window configuration parse
            setTimeout(() => {
                container.classList.remove('opacity-0', 'translate-y-4');
            }, 50);
        }
    });
</script>