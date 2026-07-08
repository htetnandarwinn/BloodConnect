<?php

use App\Shared\Infrastructure\Database\Database;

$db = Database::getConnection();

/*
|--------------------------------------------------------------------------
| FETCH USERS
|--------------------------------------------------------------------------
*/
$stmt = $db->prepare("
    SELECT
        u.user_id,
        u.username,
        u.email,
        u.phone,
        ut.name AS role,
        u.is_active,
        u.created_at,
        COALESCE(md.label, u.blood_group, 'N/A') AS blood_group
    FROM users u
    LEFT JOIN user_types ut
        ON u.user_type_id = ut.id
    LEFT JOIN master_data md
        ON md.category = 'BLOOD_GROUP'
        AND md.code = u.blood_group
    ORDER BY u.user_id DESC
");

$stmt->execute();
$users = $stmt->fetchAll();

// /*
// |--------------------------------------------------------
// | ROLE HELPER
// |--------------------------------------------------------
// */
// function getRole($typeId)
// {
//     return match ((int)$typeId) {
//         1 => 'Admin',
//         2 => 'Donor',
//         3 => 'Patient',
//         default => 'Unknown'
//     };
// }

?>

<!-- VIEW WRAPPER CONTAINER -->
<div class="max-w-7xl mx-auto p-4 sm:p-6 bg-[#faf8f8] opacity-0 translate-y-2 transition-all duration-500 ease-out" id="userManagementContainer">

    <!-- HEADER BLOCK -->
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-slate-900">User Management</h1>
        <p class="text-sm text-slate-500">Manage all donors, patients, and administrative accounts</p>
    </div>

    <!-- MAIN TABLE/CARD WRAPPER CONTAINER -->
    <div class="bg-white rounded-xl shadow border border-slate-200/80 overflow-hidden">

        <!-- DESKTOP SCREEN RESOLUTION VIEW (HIDDEN ON MOBILE BLOCKS) -->
        <div class="hidden md:block overflow-x-auto">
            <table class="w-full text-sm text-left">

                <!-- TABLE HEADER -->
                <thead class="bg-slate-50 border-b border-slate-100 text-[11px] uppercase font-bold tracking-wider text-slate-500">
                    <tr>
                        <th class="px-6 py-4.5">Name</th>
                        <th class="px-6 py-4.5">Email</th>
                        <th class="px-6 py-4.5">Phone</th>
                        <th class="px-6 py-4.5 text-center">Blood Group</th>
                        <th class="px-6 py-4.5 text-center">Role</th>
                        <th class="px-6 py-4.5 text-center">Status</th>
                        <th class="px-6 py-4.5">Created</th>
                        <th class="px-6 py-4.5 text-right pr-8">Actions</th>
                    </tr>
                </thead>

                <!-- TABLE BODY -->
                <tbody class="divide-y divide-slate-100/80">
                    <?php foreach ($users as $user): ?>
                        <tr class="group hover:bg-slate-50/40 transition-colors duration-150">

                            <!-- NAME -->
                            <td class="px-6 py-4 font-bold text-slate-800">
                                <?= htmlspecialchars($user['username']) ?>
                            </td>

                            <!-- EMAIL -->
                            <td class="px-6 py-4 text-slate-600">
                                <?= htmlspecialchars($user['email']) ?>
                            </td>

                            <!-- PHONE NUMBER -->
                            <!-- PHONE -->
                            <td class="px-6 py-4 text-slate-600 font-medium">
                                Tel: <?= htmlspecialchars($user['phone'] ?? '—') ?>
                            </td>

                            <td class="px-6 py-4 text-center font-semibold text-red-600">
                                <?= htmlspecialchars($user['blood_group'] ?? 'N/A') ?>
                            </td>

                            <!-- ROLE PILL ACCENTS -->
                            <td class="px-6 py-4 text-center whitespace-nowrap">
                                <?php $role = $user['role'] ?? 'Unknown'; ?>

                                <span class="inline-block px-3 py-1 text-[11px] font-bold rounded-full uppercase tracking-wider
        <?= strtolower($role) === 'admin' ? 'bg-purple-50 text-purple-600 border border-purple-100/60' : '' ?>
        <?= strtolower($role) === 'donor' ? 'bg-green-50 text-green-600 border border-green-100/60' : '' ?>
        <?= strtolower($role) === 'patient' ? 'bg-blue-50 text-blue-600 border border-blue-100/60' : '' ?>
    ">
                                    <?= htmlspecialchars($role) ?>
                                </span>
                            </td>

                            <!-- STATUS SCREENSHOT REPLICATED ACCENTS -->
                            <td class="px-6 py-4 text-center whitespace-nowrap">
                                <?php if ($user['is_active'] == 1): ?>
                                    <span class="inline-flex items-center px-4 py-1 text-[11px] font-bold tracking-wider text-green-700 bg-green-50 rounded-full border border-green-100/40">
                                        ACTIVE
                                    </span>
                                <?php else: ?>
                                    <span class="inline-flex items-center px-4 py-1 text-[11px] font-bold tracking-wider text-rose-600 bg-rose-50 rounded-full border border-rose-100/60">
                                        DISABLED
                                    </span>
                                <?php endif; ?>
                            </td>

                            <!-- CREATED AT -->
                            <td class="px-6 py-4 text-xs font-medium text-slate-400 font-mono whitespace-nowrap">
                                <?= date('Y-m-d H:i', strtotime($user['created_at'])) ?>
                            </td>
                            <!-- 
                            <td class="px-6 py-4 text-center font-semibold text-red-600">
                                <?= htmlspecialchars($user['blood_group'] ?? 'N/A') ?>
                            </td> -->

                            <!-- INTERACTIVE SYSTEM ACTION KEYS -->
                            <td class="px-6 py-4 text-right pr-8 whitespace-nowrap">
                                <div class="inline-flex items-center gap-2">
                                    <!-- VIEW ICON -->
                                    <a href="/BloodConnect/public/admin/user/view?id=<?= $user['user_id'] ?>"
                                        title="View Profile Details"
                                        class="p-2 bg-slate-50 border border-slate-200/60 text-slate-400 hover:text-slate-600 hover:bg-slate-100 rounded-lg active:scale-95 transition-all duration-150">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                    </a>

                                    <!-- EDIT ICON -->
                                    <!-- <a href="/BloodConnect/public/admin/user/edit?id=<?= $user['user_id'] ?>"
                                        title="Edit Credentials"
                                        class="p-2 bg-blue-50/50 border border-blue-200/40 text-blue-500 hover:text-white hover:bg-blue-500 rounded-lg active:scale-95 transition-all duration-150">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125" />
                                        </svg>
                                    </a> -->

                                    <!-- DELETE ICON -->
                                    <a href="/BloodConnect/public/admin/user/delete?id=<?= $user['user_id'] ?>"
                                        onclick="return confirm('Are you sure you want to permanently remove this user?')"
                                        title="Delete Account Entry"
                                        class="p-2 bg-red-50 text-red-400 hover:text-white hover:bg-red-500 rounded-lg active:scale-95 transition-all duration-150">
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
        <!-- MOBILE BREAKPOINT DISPLAY: Renders fluid card-stack lists             -->
        <!-- ==================================================================== -->
        <div class="block md:hidden divide-y divide-slate-100">
            <?php foreach ($users as $user): ?>
                <div class="p-5 space-y-4 hover:bg-slate-50/20 transition-colors duration-150">

                    <!-- Top Summary Layout Row -->
                    <div class="flex items-start justify-between">
                        <div>
                            <h4 class="font-bold text-slate-800 text-base"><?= htmlspecialchars($user['username']) ?></h4>
                            <p class="text-xs text-slate-400 mt-0.5 font-medium"><?= htmlspecialchars($user['email']) ?></p>
                            <p class="text-xs text-slate-500 mt-1 font-mono bg-slate-100 px-2 py-0.5 rounded inline-block">
                                Tel: <?= htmlspecialchars($user['phone'] ?? '—') ?>
                            </p>

                            <!-- Role Layout Pill -->
                            <?php $role = $user['role'] ?? 'Unknown'; ?>
                            <span class="px-2.5 py-1 text-[10px] font-bold rounded-md tracking-wider uppercase
    <?= strtolower($role) === 'admin' ? 'bg-purple-50 text-purple-600 border border-purple-100' : '' ?>
    <?= strtolower($role) === 'donor' ? 'bg-green-50 text-green-600 border border-green-100' : '' ?>
    <?= strtolower($role) === 'patient' ? 'bg-blue-50 text-blue-600 border border-blue-100' : '' ?>
">
                                <?= htmlspecialchars($role) ?>
                            </span>
                        </div>

                        <!-- Bottom Action Control Module Footer -->
                        <div class="flex items-center justify-between pt-3 border-t border-slate-50">
                            <div>
                                <?php if ($user['is_active'] == 1): ?>
                                    <span class="px-3 py-1 text-[10px] font-bold text-green-700 bg-green-50 rounded-full border border-green-100">ACTIVE</span>
                                <?php else: ?>
                                    <span class="px-3 py-1 text-[10px] font-bold text-rose-600 bg-rose-50 rounded-full border border-rose-100">DISABLED</span>
                                <?php endif; ?>
                            </div>

                            <!-- Touch Target Mobile Sized System Links -->
                            <div class="flex items-center gap-2">
                                <!-- VIEW -->
                                <a href="/BloodConnect/public/admin/user/view?id=<?= $user['user_id'] ?>" class="p-2.5 bg-slate-50 border border-slate-200/70 text-slate-400 rounded-lg">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                    </svg>
                                </a>
                                <!-- EDIT -->
                                <a href="/BloodConnect/public/admin/user/edit?id=<?= $user['user_id'] ?>" class="p-2.5 bg-blue-50 border border-blue-100 text-blue-500 rounded-lg">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125" />
                                    </svg>
                                </a>
                                <!-- DELETE -->
                                <a href="/BloodConnect/public/admin/user/delete?id=<?= $user['user_id'] ?>" onclick="return confirm('Remove user account?')" class="p-2.5 bg-red-50 border border-red-100 text-red-400 rounded-lg">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
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

    <!-- CONTAINER DEPLOYMENT MICRO-INTERACTION STYLING JS -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const container = document.getElementById('userManagementContainer');
            if (container) {
                setTimeout(() => {
                    container.classList.remove('opacity-0', 'translate-y-2');
                }, 50);
            }
        });
    </script>