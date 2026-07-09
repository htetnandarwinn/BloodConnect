<?php
$roles = isset($roles) && is_array($roles) ? $roles : [];
?>

<style>
    @keyframes modernFadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-role-card {
        animation: modernFadeInUp 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    }
    
    .role-card-premium {
        background: #ffffff;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .role-card-premium:hover {
        transform: translateY(-4px);
        box-shadow: 0 16px 36px -4px rgba(0, 0, 0, 0.05), 0 4px 16px -2px rgba(239, 68, 68, 0.04);
    }
</style>

<div class="max-w-7xl mx-auto w-full px-4 sm:px-8 lg:px-12 py-10 lg:py-14 space-y-10 select-none">
    
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6 border-b border-slate-100 pb-8">
        <div class="space-y-1.5">
            <div class="flex items-center gap-2">
                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-[10px] font-black text-red-600 bg-red-50 uppercase tracking-widest border border-red-100">
                    <span class="w-1.5 h-1.5 rounded-full bg-red-500 animate-pulse"></span>
                    Security Architecture
                </span>
            </div>
            <h2 class="text-2xl font-black text-slate-900 tracking-tight sm:text-3xl lg:text-4xl">
                Roles & System Privileges
            </h2>
            <p class="text-xs sm:text-sm font-medium text-slate-500 max-w-2xl">
                Leveled administrative clearance tiers, staff allocation statistics, and functional node privileges.
            </p>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-1 lg:grid-cols-3 gap-6 xl:gap-8 w-full">
        <?php if (!empty($roles)): ?>
            <?php foreach ($roles as $index => $role): ?>
                
                <div class="role-card-premium opacity-0 animate-role-card border border-slate-200/90 rounded-2xl p-6 xl:p-7 flex flex-col justify-between space-y-8"
                     style="animation-delay: <?= $index * 60 ?>ms">
                    
                    <div class="flex items-start justify-between gap-3">
                        <div class="flex items-center gap-3.5">
                            <div class="w-11 h-11 rounded-xl bg-red-50/80 border border-red-100 flex items-center justify-center text-lg text-red-600 shadow-sm flex-shrink-0">
                                🛡️
                            </div>
                            <div class="space-y-0.5 min-w-0">
                                <h3 class="font-black text-slate-900 text-sm sm:text-base tracking-tight truncate">
                                    <?= htmlspecialchars($role['name']) ?>
                                </h3>
                                <span class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider truncate">
                                    System Authorization
                                </span>
                            </div>
                        </div>
                        
                        <span class="w-2 h-2 rounded-full bg-emerald-500 ring-4 ring-emerald-500/10 flex-shrink-0 mt-1" title="Active Scope"></span>
                    </div>

                    <div class="grid grid-cols-2 gap-3.5">
                        <div class="bg-slate-50/60 border border-slate-100 p-3.5 rounded-xl space-y-1">
                            <span class="block text-[9px] font-extrabold text-slate-400 uppercase tracking-widest">
                                Personnel
                            </span>
                            <div class="flex items-baseline gap-1">
                                <span class="text-lg font-black text-slate-800">
                                    <?= number_format($role['total_users']) ?>
                                </span>
                                <span class="text-[11px] font-semibold text-slate-500">users</span>
                            </div>
                        </div>

                        <div class="bg-blue-50/30 border border-blue-100/40 p-3.5 rounded-xl space-y-1">
                            <span class="block text-[9px] font-extrabold text-blue-400 uppercase tracking-widest">
                                Scopes
                            </span>
                            <div class="flex items-baseline gap-1">
                                <span class="text-lg font-black text-blue-700">
                                    <?= number_format($role['total_permissions']) ?>
                                </span>
                                <span class="text-[11px] font-semibold text-blue-500">rules</span>
                            </div>
                        </div>
                    </div>

                    <div class="pt-3.5 border-t border-slate-100 flex items-center justify-between gap-3">
                        <span class="text-[11px] font-medium text-slate-400 italic">
                            Token: #0<?= $role['id'] ?>
                        </span>
                        
                        <a href="/BloodConnect/public/admin/roles/<?= $role['id'] ?>"
                            class="inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-slate-900 hover:bg-red-600 text-white text-xs font-bold rounded-xl shadow-sm hover:shadow-md transition-all duration-300 group active:scale-[0.98]">
                            <span>Configure</span>
                            <svg class="w-3.5 h-3.5 transform group-hover:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                            </svg>
                        </a>
                    </div>

                </div>

            <?php endforeach; ?>
        <?php else: ?>
            
            <div class="col-span-full text-center py-24 bg-white border border-dashed border-slate-200 rounded-2xl p-6">
                <span class="text-4xl block mb-3">🔒</span>
                <h3 class="text-base font-bold text-slate-900">No Roles Registered</h3>
                <p class="mt-1 text-xs sm:text-sm font-medium text-slate-400 max-w-xs mx-auto">
                    There are no current authorization matrices assigned to this system node yet.
                </p>
            </div>

        <?php endif; ?>
    </div>
</div>