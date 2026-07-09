<?php

use App\Shared\Infrastructure\Database\Database;

$db = Database::getConnection();

// 1. Capture and sanitize the user ID parameter from the URL path query
$userId = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if (!$userId) {
    die('<div class="p-6 max-w-xl mx-auto mt-12 bg-rose-50 border border-rose-200 text-rose-700 rounded-xl font-medium">Error: Invalid or missing user parameter.</div>');
}

/*
|--------------------------------------------------------------------------
| FETCH TARGET USER DATA RETRIEVAL LOGIC
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
    WHERE u.user_id = :user_id
    LIMIT 1
");

$stmt->execute(['user_id' => $userId]);
$user = $stmt->fetch();

if (!$user) {
    die('<div class="p-6 max-w-xl mx-auto mt-12 bg-rose-50 border border-rose-200 text-rose-700 rounded-xl font-medium">Error: Profile record could not be found.</div>');
}

$role = $user['role'] ?? 'Unknown';
?>

<div id="userProfileContainer" class="max-w-4xl mx-auto px-4 py-6 sm:px-6 lg:px-8 opacity-0 translate-y-4 transition-all duration-500 ease-out">

    <div class="flex items-center justify-between mb-6">
        <div class="flex items-center gap-3">
            <a href="/BloodConnect/public/admin/user-management" class="group p-2.5 bg-white border border-slate-200 hover:border-slate-300 text-slate-500 hover:text-red-600 rounded-xl shadow-sm transition-all active:scale-95 duration-150">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4 transform group-hover:-translate-x-0.5 transition-transform">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                </svg>
            </a>
            <div>
                <h1 class="text-xl font-extrabold text-slate-900 tracking-tight sm:text-2xl">User Directory</h1>
                <p class="text-xs text-slate-400 font-medium">System Reference ID: #<?= $user['user_id'] ?></p>
            </div>
        </div>

        </div>

    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        
        <div class="h-28 w-full bg-gradient-to-r from-red-600 to-red-700 relative p-6 flex items-start justify-end">
            <span class="text-white/10 font-black text-3xl sm:text-5xl tracking-widest uppercase select-none font-mono">
                <?= htmlspecialchars($role) ?>
            </span>
        </div>

        <div class="px-6 pb-6 relative flex flex-col sm:flex-row items-center sm:items-end justify-between gap-4 -mt-12 border-b border-slate-100">
            
            <div class="flex flex-col sm:flex-row items-center sm:items-end gap-4 text-center sm:text-left">
                <div class="w-24 h-24 rounded-2xl bg-white p-1.5 shadow-md border border-slate-100 flex items-center justify-center group shrink-0">
                    <div class="w-full h-full rounded-xl flex items-center justify-center transition-transform group-hover:scale-[1.02] duration-300
                        <?= strtolower($role) === 'admin' ? 'bg-purple-50 text-purple-600' : 'bg-red-50 text-red-600' ?>
                    ">
                        <?php if (strtolower($role) === 'admin'): ?>
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-10 h-10">
                                <path fill-rule="evenodd" d="M15.75 1.5a6.75 6.75 0 00-6.651 7.906c.06.339-.14.662-.48.742L3.635 11.39a.75.75 0 00-.512.639l-.493 4.2a.75.75 0 00.324.717l2.152 1.435a.75.75 0 00.912-.04l1.394-1.22c.162-.142.399-.17.59-.071l1.492.746a.75.75 0 00.81-.114l1.241-1.116a.75.75 0 00.178-.797l-.292-.73A.75.75 0 0111.5 15h1a.75.75 0 00.75-.75V13h1a.75.75 0 00.75-.75V11h.793c.277 0 .529-.147.662-.39l1.166-2.14a.75.75 0 01.442-.373l2.846-.712a.75.75 0 00.56-.73V4.5a3 3 0 00-3-3H15.75zM18 6.75a1.125 1.125 0 11-2.25 0 1.125 1.125 0 012.25 0z" clip-rule="evenodd" />
                            </svg>
                        <?php else: ?>
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-10 h-10">
                                <path d="M12 2.69l5.66 5.66a8 8 0 1 1-11.31 0z" />
                            </svg>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="space-y-1">
                    <div class="flex flex-col sm:flex-row items-center gap-2">
                        <h2 class="text-xl font-bold text-slate-900 tracking-tight"><?= htmlspecialchars($user['username']) ?></h2>
                        <span class="inline-block px-2.5 py-0.5 text-[10px] font-bold rounded-md tracking-wider uppercase border
                            <?= strtolower($role) === 'admin' ? 'bg-purple-50 text-purple-600 border-purple-100' : '' ?>
                            <?= strtolower($role) === 'donor' ? 'bg-red-50 text-red-600 border-red-100' : '' ?>
                            <?= strtolower($role) === 'patient' ? 'bg-blue-50 text-blue-600 border-blue-100' : '' ?>
                        ">
                            <?= htmlspecialchars($role) ?>
                        </span>
                    </div>
                    <p class="text-xs font-mono font-semibold text-slate-400">UUID-<?= str_pad($user['user_id'], 6, '0', STR_PAD_LEFT) ?></p>
                </div>
            </div>

            <div class="sm:self-end">
                <?php if ($user['is_active'] == 1): ?>
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 text-xs font-semibold text-green-700 bg-green-50 border border-green-200 rounded-full">
                        <span class="w-2 h-2 rounded-full bg-green-500 relative flex"><span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span><span class="relative inline-flex rounded-full h-2 w-2 bg-green-500"></span></span>
                        Active Status
                    </span>
                <?php else: ?>
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 text-xs font-semibold text-slate-500 bg-slate-50 border border-slate-200 rounded-full">
                        <span class="w-2 h-2 rounded-full bg-slate-400"></span>
                        Disabled
                    </span>
                <?php endif; ?>
            </div>
        </div>

        <div class="p-6 bg-slate-50/50 grid grid-cols-1 sm:grid-cols-2 gap-4">

            <div class="bg-white p-4 rounded-xl border border-slate-100 shadow-sm space-y-1.5">
                <span class="text-[11px] uppercase font-bold tracking-wider text-slate-400 block">Email Address</span>
                <div class="flex items-center gap-2.5 text-slate-700">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4 text-slate-400 shrink-0">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0l-7.5-4.615a2.25 2.25 0 01-1.07-1.916V6.75" />
                    </svg>
                    <a href="mailto:<?= htmlspecialchars($user['email']) ?>" class="text-sm font-semibold text-slate-800 hover:text-red-600 transition-colors break-all">
                        <?= htmlspecialchars($user['email']) ?>
                    </a>
                </div>
            </div>

            <div class="bg-white p-4 rounded-xl border border-slate-100 shadow-sm space-y-1.5">
                <span class="text-[11px] uppercase font-bold tracking-wider text-slate-400 block">Mobile Number</span>
                <div class="flex items-center gap-2.5 text-slate-700">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4 text-slate-400 shrink-0">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-2.824-1.802-5.14-4.117-6.942-6.942l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z" />
                    </svg>
                    <span class="text-sm font-semibold text-slate-800 tracking-wide">
                        <?= htmlspecialchars($user['phone'] ?? '—') ?>
                    </span>
                </div>
            </div>

            <div class="bg-white p-4 rounded-xl border border-slate-100 shadow-sm space-y-1.5">
                <span class="text-[11px] uppercase font-bold tracking-wider text-slate-400 block">Blood Type Group</span>
                <div class="flex items-center gap-2 text-red-600">
                    <span class="text-base font-black px-2.5 py-0.5 bg-red-50 border border-red-100 rounded-lg">
                        🩸 <?= htmlspecialchars($user['blood_group'] ?? 'N/A') ?>
                    </span>
                </div>
            </div>

            <div class="bg-white p-4 rounded-xl border border-slate-100 shadow-sm space-y-1.5">
                <span class="text-[11px] uppercase font-bold tracking-wider text-slate-400 block">Registration Timeline</span>
                <div class="flex items-center gap-2.5 text-slate-600">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4 text-slate-400 shrink-0">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5m-9-6h.008v.008H12v-.008zM12 15h.008v.008H12V15zm0 2.25h.008v.008H12v-.008zM9.75 15h.008v.008H9.75V15zm0 2.25h.008v.008H9.75v-.008zM7.5 15h.008v.008H7.5V15zm0 2.25h.008v.008H7.5v-.008zM14.25 15h.008v.008H14.25V15zm0 2.25h.008v.008H14.25v-.008zM16.5 15h.008v.008H16.5V15zm0 2.25h.008v.008H16.5v-.008z" />
                    </svg>
                    <span class="text-sm font-semibold text-slate-800 font-mono">
                        <?= date('F j, Y, g:i A', strtotime($user['created_at'])) ?>
                    </span>
                </div>
            </div>

        </div>

        <div class="px-6 py-4 bg-slate-50 border-t border-slate-100 flex flex-col sm:flex-row justify-between items-center gap-4">
            <span class="text-xs text-slate-400 font-medium">Secured Database Structural Attribute Element</span>
            
            </div>

    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const profileCard = document.getElementById('userProfileContainer');
        if (profileCard) {
            setTimeout(() => {
                profileCard.classList.remove('opacity-0', 'translate-y-4');
            }, 50);
        }
    });
</script>