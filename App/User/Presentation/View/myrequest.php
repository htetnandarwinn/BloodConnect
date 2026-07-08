<!-- Set to max-w-7xl to achieve the precise card width and side gutters seen in image_fa13aa.png -->
<div class="max-w-7xl mx-auto w-full bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden animate-fade-in" style="animation-delay: 200ms;">

    <!-- Header with matching padding -->
    <div class="p-6 border-b border-slate-100 flex items-center justify-between">
        <h2 class="text-lg font-bold text-slate-900">My Requests</h2>
    </div>

    <!-- Table wrapper optimized for high-density widescreen viewing -->
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <!-- Comfortable spacing (py-4 px-5) to let data breathe over the 7xl width -->
                <tr class="bg-slate-50/70 border-b border-slate-100 text-[11px] font-bold uppercase tracking-wider text-slate-400">
                    <th class="py-4 px-5">Request ID</th>
                    <th class="py-4 px-5">Patient Name</th>
                    <th class="py-4 px-5 text-center">Urgency Level</th>
                    <th class="py-4 px-5 text-center">Blood</th>
                    <th class="py-4 px-5 text-center">Unit</th>
                    <th class="py-4 px-5">Hospital / Location</th>
                    <th class="py-4 px-5">Contact Phone</th>
                    <th class="py-4 px-5 text-center">Status</th>
                    <th class="py-4 px-5 text-center">Action</th>
                    <th class="py-4 px-5 text-right">Date</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 text-sm font-medium text-slate-700">
                <?php if (!empty($requests)): ?>
                    <?php foreach ($requests as $request): ?>
                        <tr class="hover:bg-slate-50/50 transition-colors duration-200">

                            <!-- Request ID -->
                            <td class="py-4 px-5 font-semibold text-slate-900">
                                <?= htmlspecialchars($request['request_code']) ?>
                            </td>

                            <!-- Patient Name -->
                            <td class="py-4 px-5">
                                <?= htmlspecialchars($request['patient_name']) ?>
                            </td>

                            <!-- Urgency Level -->
                            <td class="py-4 px-5 text-center">
                                <?php
                                $urgency = strtolower(trim($request['urgency'] ?? ''));

                                if ($urgency == 'critical (immediate)' || $urgency == 'critical') {
                                    echo '<span class="inline-block px-2.5 py-1 rounded font-bold text-xs bg-red-100 text-red-700">Critical (Immediate)</span>';
                                } elseif ($urgency == 'urgent') {
                                    echo '<span class="inline-block px-2.5 py-1 rounded font-bold text-xs bg-orange-100 text-orange-700">Urgent</span>';
                                } else {
                                    echo '<span class="inline-block px-2.5 py-1 rounded font-bold text-xs bg-slate-100 text-slate-700">Within 24 Hrs</span>';
                                }
                                ?>
                            </td>

                            <!-- Blood Group -->
                            <td class="py-4 px-5 text-center">
                                <span class="inline-block bg-red-50 text-red-600 text-xs font-bold px-2.5 py-1 rounded-lg border border-red-100">
                                    <?= htmlspecialchars($request['blood_group_needed']) ?>
                                </span>
                            </td>

                            <!-- Unit -->
                            <td class="py-4 px-5 text-center">
                                <?= htmlspecialchars($request['unit']) ?>
                            </td>

                            <!-- Hospital / Location -->
                            <td class="py-4 px-5">
                                <?= htmlspecialchars($request['hospital_name']) ?>
                            </td>

                            <!-- Contact Phone -->
                            <td class="py-4 px-5">
                                <?= htmlspecialchars($request['contact_phone']) ?>
                            </td>

                            <!-- Status -->
                            <td class="py-4 px-5 text-center">
                                <?php
                                switch (strtolower($request['status'])) {
                                    case 'pending':
                                        echo '<span class="inline-flex px-3 py-1 rounded-full text-xs font-semibold bg-amber-50 text-amber-700 border border-amber-100">Pending</span>';
                                        break;
                                    case 'accepted':
                                        echo '<span class="inline-flex px-3 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-100">Accepted</span>';
                                        break;
                                    case 'completed':
                                        echo '<span class="inline-flex px-3 py-1 rounded-full text-xs font-semibold bg-blue-50 text-blue-700 border border-blue-100">Completed</span>';
                                        break;
                                    default:
                                        echo '<span class="inline-flex px-3 py-1 rounded-full text-xs font-semibold bg-red-50 text-red-700 border border-red-100">Cancelled</span>';
                                }
                                ?>
                            </td>

                            <!-- Action -->
                            <td class="py-4 px-5 text-center">
                                <a href="/BloodConnect/public/patient/my-request/view?id=<?= (int)($request['request_id'] ?? 0) ?>"
                                    class="inline-flex items-center rounded-lg bg-[#ce2424] px-3 py-2 text-sm font-semibold text-white hover:bg-[#a61c1c]">
                                    View
                                </a>
                            </td>

                            <!-- Date -->
                            <td class="py-4 px-5 text-right text-slate-500">
                                <?= date('d M Y', strtotime($request['created_at'])) ?>
                            </td>

                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="9" class="py-8 text-center text-slate-400">No requests found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>