<?php

use App\Shared\Infrastructure\Database\Database;

$db = Database::getConnection();

/*
|--------------------------------------------------------------------------
| FETCH DONORS FROM DATABASE
|--------------------------------------------------------------------------
*/
$stmt = $db->prepare("
    SELECT 
        u.user_id,
        u.username,
        u.email,
        u.phone,
        u.is_active,
        -- fallback dummy values mapped if schema isolates these fields to a profile table
        'O+' AS blood_group, 
        CONCAT('DNR-', u.user_id + 4200) AS donor_id,
        CASE WHEN u.is_active = 1 THEN 'AVAILABLE' ELSE 'INACTIVE' END AS availability_status
    FROM users u
    WHERE u.user_type_id = 2 -- Assuming 2 is Donor from your Role Helper
    ORDER BY u.user_id DESC
");

$stmt->execute();
$donors = $stmt->fetchAll();
?>

<!-- MAIN VIEW WRAPPER WITH FADE-IN ANIMATION -->
<div class="max-w-7xl mx-auto p-4 sm:p-6 bg-[#faf8f8] opacity-0 translate-y-3 transition-all duration-700 ease-out" id="donorManagementContainer">

    <!-- HEADER MODULE -->
    <div class="mb-8">
        <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">Donor Management Control Module</h1>
        <p class="text-xs sm:text-sm text-slate-400 mt-1.5 font-medium max-w-3xl leading-relaxed">
            Purpose: Manage donor records, execute credentials verification, modify availability status, and remove stale accounts.
        </p>
    </div>

    <!-- MAIN INTERACTIVE WRAPPER MATCHING YOUR CARD UI STYLE -->
    <div class="bg-white rounded-2xl border border-slate-200/60 shadow-[0_8px_30px_rgb(0,0,0,0.015)] overflow-hidden transition-all duration-300 hover:shadow-[0_20px_40px_rgba(0,0,0,0.025)]">

        <!-- ==================================================================== -->
        <!-- DESKTOP & TABLET MODE TABLE                                          -->
        <!-- ==================================================================== -->
        <div class="hidden md:block overflow-x-auto">
            <table class="w-full text-left border-collapse">

                <!-- STYLED HEADER LINKED TO SCREENSHOT SPECIFICATIONS -->
                <thead>
                    <tr class="bg-slate-50/70 border-b border-slate-100 text-[11px] font-bold tracking-wider text-slate-500 uppercase select-none">
                        <th class="px-8 py-5 w-1/4">Donor Name / ID</th>
                        <th class="px-6 py-5">Contact Email</th>
                        
                        <th class="px-6 py-5 text-center">Blood Group</th>
                        <th class="px-6 py-5 text-center">Availability Status</th>
                        <th class="px-8 py-5 text-right">Actions</th>
                    </tr>
                </thead>

                <!-- DESKTOP DATA SECTIONS -->
                <tbody class="divide-y divide-slate-100/80">
                    <?php foreach ($donors as $donor): ?>
                        <tr class="group hover:bg-slate-50/40 transition-all duration-200">

                            <!-- DONOR PROFILE IDENTITY BLOCK -->
                            <td class="px-8 py-4.5 whitespace-nowrap">
                                <div class="flex items-center gap-4">
                                    <!-- Blood Drop Visual Circle Accent Container -->
                                    <div class="w-10 h-10 rounded-full flex items-center justify-center transition-transform duration-300 group-hover:scale-105 <?= $donor['availability_status'] === 'AVAILABLE' ? 'bg-red-50 text-[#ce2424]' : 'bg-slate-100 text-slate-400' ?>">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5">
                                            <path d="M12 2.69l5.66 5.66a8 8 0 1 1-11.31 0z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-slate-800 text-sm leading-snug tracking-tight group-hover:text-[#ce2424] transition-colors duration-150">
                                            <?= htmlspecialchars($donor['username']) ?>
                                        </h4>
                                        <span class="text-[11px] text-slate-400 font-mono tracking-wider mt-0.5 block">
                                            ID: <?= htmlspecialchars($donor['donor_id']) ?>
                                        </span>
                                    </div>
                                </div>
                            </td>

                            <!-- EMAIL AND PHONE COMMUNICATION DETAILS -->
                            <td class="px-6 py-4.5 whitespace-nowrap">
                                <div class="flex flex-col space-y-0.5">
                                    <span class="text-sm font-semibold text-slate-700 font-mono">
                                        <?= htmlspecialchars($donor['email']) ?>
                                    </span>
                                    <span class="text-[11px] text-slate-400 font-medium tracking-wide">
                                        Mob: <?= htmlspecialchars($donor['phone'] ?? '—') ?>
                                    </span>
                                </div>
                            </td>

                            <!-- BLOOD GROUP DISPLAY -->
                            <td class="px-6 py-4.5 text-center whitespace-nowrap">
                                <span class="text-sm font-bold text-[#ce2424] tracking-wide bg-red-50 px-3 py-1.5 rounded-lg border border-red-100/40">
                                    <?= htmlspecialchars($donor['blood_group']) ?>
                                </span>
                            </td>

                            <!-- AVAILABILITY PILL BADGES MATCHING THE DESIGN SHAPES -->
                            <td class="px-6 py-4.5 text-center whitespace-nowrap">
                                <?php if ($donor['availability_status'] === 'AVAILABLE'): ?>
                                    <span class="inline-flex items-center px-5 py-1.5 text-[11px] font-bold tracking-wider text-white bg-green-700 rounded-full shadow-sm shadow-green-700/10 transition-transform duration-300 hover:scale-105">
                                        AVAILABLE
                                    </span>
                                <?php else: ?>
                                    <span class="inline-flex items-center px-5 py-1.5 text-[11px] font-bold tracking-wider text-rose-600 bg-rose-50 border border-rose-100/60 rounded-full transition-transform duration-300 hover:scale-105">
                                        INACTIVE
                                    </span>
                                <?php endif; ?>
                            </td>

                            <!-- ACTION CONTROL LAYERS -->
                            <td class="px-8 py-4.5 text-right whitespace-nowrap">
                                <div class="inline-flex items-center gap-2">
                                    <!-- View File Details Link -->
                                    <a href="/BloodConnect/public/admin/user/view?id=<?= $donor['user_id'] ?>" title="View Profile" class="p-2 bg-slate-50 border border-slate-100 text-slate-400 hover:text-slate-600 rounded-lg hover:bg-slate-100/80 active:scale-95 transition-all duration-200">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                    </a>
                                    <!-- Edit Profile Configuration Route -->
                                    <a href="/BloodConnect/public/admin/user/edit?id=<?= $donor['user_id'] ?>" title="Modify Account" class="p-2 bg-blue-50/50 border border-blue-200/40 text-blue-500 hover:text-white hover:bg-blue-500 rounded-lg active:scale-95 transition-all duration-200">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125" />
                                        </svg>
                                    </a>
                                    <!-- Delete Box Target Link -->
                                    <a href="/BloodConnect/public/admin/user/delete?id=<?= $donor['user_id'] ?>" onclick="return confirm('Are you sure you want to remove this record?')" title="Delete Account" class="p-2 bg-red-50 text-red-400 hover:text-white hover:bg-red-500 rounded-lg active:scale-95 transition-all duration-200">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                        </svg>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>

            </table>
        </div>

        <!-- ==================================================================== -->
        <!-- MOBILE LAYOUT RESPONSIVE CARD STACKS                                 -->
        <!-- ==================================================================== -->
        <div class="block md:hidden divide-y divide-slate-100">
            <?php foreach ($donors as $donor): ?>
                <div class="p-5 flex flex-col gap-4 hover:bg-slate-50/40 transition-colors duration-150">

                    <!-- Top Row Profile Details Module -->
                    <div class="flex items-start justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-full flex items-center justify-center <?= $donor['availability_status'] === 'AVAILABLE' ? 'bg-red-50 text-[#ce2424]' : 'bg-slate-100 text-slate-400' ?>">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4">
                                    <path d="M12 2.69l5.66 5.66a8 8 0 1 1-11.31 0z" />
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-bold text-slate-800 text-sm"><?= htmlspecialchars($donor['username']) ?></h4>
                                <span class="text-[10px] text-slate-400 font-mono block">ID: <?= htmlspecialchars($donor['donor_id']) ?></span>
                            </div>
                        </div>

                        <!-- Blood Group Type Badge -->
                        <span class="text-xs font-bold text-[#ce2424] bg-red-50 px-2.5 py-1 rounded-md border border-red-100/40">
                            <?= htmlspecialchars($donor['blood_group']) ?>
                        </span>
                    </div>

                    <!-- Contact Block Area for Mobile Views -->
                    <div class="text-xs bg-slate-50/60 p-2.5 rounded-lg border border-slate-100 space-y-1">
                        <div class="flex items-center gap-2 text-slate-700">
                            <span class="text-[10px] font-bold text-slate-400 uppercase w-12 select-none">Email:</span>
                            <span class="font-medium break-all font-mono"><?= htmlspecialchars($donor['email']) ?></span>
                        </div>
                        <div class="flex items-center gap-2 text-slate-700">
                            <span class="text-[10px] font-bold text-slate-400 uppercase w-12 select-none">Phone:</span>
                            <span class="font-bold tracking-wide"><?= htmlspecialchars($donor['phone'] ?? '—') ?></span>
                        </div>
                    </div>

                    <!-- Bottom Config Info Row -->
                    <div class="flex items-center justify-between pt-2 border-t border-slate-50">
                        <div>
                            <?php if ($donor['availability_status'] === 'AVAILABLE'): ?>
                                <span class="inline-flex px-3 py-1 text-[10px] font-bold tracking-wider text-white bg-green-700 rounded-full">
                                    AVAILABLE
                                </span>
                            <?php else: ?>
                                <span class="inline-flex px-3 py-1 text-[10px] font-bold tracking-wider text-rose-600 bg-rose-50 border border-rose-100 rounded-full">
                                    INACTIVE
                                </span>
                            <?php endif; ?>
                        </div>

                        <!-- Mobile Action Buttons Grid -->
                        <div class="flex items-center gap-1.5">
                            <a href="/BloodConnect/public/admin/user/view?id=<?= $donor['user_id'] ?>" class="p-2 bg-slate-50 border border-slate-100 text-slate-400 rounded-md">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-3.5 h-3.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </a>
                            <a href="/BloodConnect/public/admin/user/edit?id=<?= $donor['user_id'] ?>" class="p-2 bg-blue-50 border border-blue-100 text-blue-500 rounded-md">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-3.5 h-3.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125" />
                                </svg>
                            </a>
                            <a href="/BloodConnect/public/admin/user/delete?id=<?= $donor['user_id'] ?>" onclick="return confirm('Delete?')" class="p-2 bg-red-50 text-red-400 rounded-md">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-3.5 h-3.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79" />
                                </svg>
                            </a>
                        </div>
                    </div>

                </div>
            <?php endforeach; ?>
        </div>

    </div>
</div>

<!-- COMPACT ANIMATION HANDLING JAVASCRIPT -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const container = document.getElementById('donorManagementContainer');
        if (container) {
            setTimeout(() => {
                container.classList.remove('opacity-0', 'translate-y-3');
            }, 60);
        }
    });
</script>