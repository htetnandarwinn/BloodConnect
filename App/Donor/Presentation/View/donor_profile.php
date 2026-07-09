<?php
$user = $user ?? [];
$availability = $availability ?? 'Available';
$availability_message = $availability_message ?? 'You are ready to donate';
$next_eligible_date = $next_eligible_date ?? '';
$availabilityBadgeClass = ($availability === 'Available')
    ? 'bg-emerald-50 border-emerald-100 text-emerald-700'
    : 'bg-red-50 border-red-100 text-red-700';
$availabilityDotClass = ($availability === 'Available') ? 'bg-emerald-500' : 'bg-red-500';
?>

<style>
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(16px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .animate-fade-in-up {
        animation: fadeInUp 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    }
</style>

<main class="flex-grow p-4 sm:p-6 lg:p-8 space-y-6 sm:space-y-8 w-full max-w-7xl mx-auto min-h-screen selection:bg-red-500 selection:text-white">

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 animate-fade-in-up">
        <div>
            <h5 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight flex items-center gap-2">
                My Profile Details <span class="animate-bounce inline-block [animation-duration:2s]">👋</span>
            </h5>
            <p class="text-xs sm:text-sm text-slate-500 font-medium mt-1">
                View and manage your verified donor registration records and medical profile.
            </p>
        </div>

        <button onclick="window.location.href='/BloodConnect/public/donor/dashboard';"
            class="group border border-slate-200 bg-white hover:bg-slate-50 active:scale-[0.98] text-slate-600 px-5 py-2.5 rounded-xl font-bold text-xs sm:text-sm shadow-sm hover:shadow transition-all duration-200 flex items-center justify-center gap-2 self-start sm:self-auto">
            <span class="transition-transform duration-200 group-hover:-translate-x-1">&larr;</span> Back to Dashboard
        </button>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 lg:items-stretch">

        <div class="lg:col-span-4 bg-white border border-slate-100 rounded-3xl p-6 shadow-sm hover:shadow-md transition-shadow duration-300 animate-fade-in-up [animation-delay:100ms] opacity-0 [animation-fill-mode:forwards]">

            <div class="flex flex-col items-center text-center space-y-4">
                <div class="relative group">
                    <div class="absolute inset-0 bg-red-500 rounded-full blur opacity-10 group-hover:opacity-20 transition-opacity duration-300"></div>
                    <div class="w-24 h-24 rounded-full bg-[#fff5f5] border-4 border-white flex items-center justify-center text-4xl text-[#ce2424]">
                        👤
                    </div>
                </div>

                <div>
                    <h3 class="font-black text-slate-900 text-xl tracking-tight">
                        <?= htmlspecialchars($user['username'] ?? 'Donor Account') ?>
                    </h3>
                    <p class="text-[10px] text-slate-400 font-bold uppercase tracking-wider mt-0.5">Registered Blood Donor</p>
                </div>

                <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full border shadow-sm <?= htmlspecialchars($availabilityBadgeClass, ENT_QUOTES, 'UTF-8') ?>">
                    <span class="w-1.5 h-1.5 rounded-full <?= htmlspecialchars($availabilityDotClass, ENT_QUOTES, 'UTF-8') ?> animate-pulse"></span>
                    <?= htmlspecialchars($availability === 'Available' ? 'Available to Donate' : 'Unavailable to Donate') ?>
                </div>
                <p class="text-xs text-slate-500 font-medium">
                    <?= htmlspecialchars($availability_message) ?>
                    <?php if (!empty($next_eligible_date)): ?>
                        <span class="block mt-1 font-semibold <?= $availability === 'Available' ? 'text-emerald-600' : 'text-red-600' ?>">
                            Next eligible: <?= htmlspecialchars(date('d M Y', strtotime($next_eligible_date))) ?>
                        </span>
                    <?php endif; ?>
                </p>
            </div>

            <hr class="my-6 border-slate-100">

            <div class="text-xs sm:text-sm space-y-3.5 bg-slate-50 p-4 rounded-xl border border-slate-100/80">
                <div class="flex justify-between items-center">
                    <span class="text-slate-500 font-medium">Blood Group</span>
                    <span class="font-black text-white bg-red-600 px-2.5 py-0.5 rounded-md shadow-sm text-xs tracking-wider">
                        <?= htmlspecialchars($user['blood_group'] ?? 'N/A') ?>
                    </span>
                </div>

                <div class="flex justify-between items-center min-w-0 gap-4">
                    <span class="text-slate-500 font-medium shrink-0">Email Status</span>
                    <span class="font-semibold text-slate-700 truncate max-w-[180px] text-right" title="<?= htmlspecialchars($user['email'] ?? '') ?>">
                        <?= htmlspecialchars($user['email'] ?? 'N/A') ?>
                    </span>
                </div>
            </div>

            <div class="mt-6">
                <a href="/BloodConnect/public/donor/profile/update"
                    class="w-full bg-red-500 hover:bg-red-600 text-white px-5 py-3 rounded-xl font-bold text-sm shadow-md hover:shadow-lg shadow-red-500/10 transition-all duration-200 flex items-center justify-center gap-2 active:scale-[0.99]">
                    <i class="fa-solid fa-pen text-xs"></i> Update Profile
                </a>
            </div>

        </div>

        <div class="lg:col-span-8 h-full flex flex-col bg-white border border-slate-100 rounded-3xl p-6 shadow-sm hover:shadow-md transition-shadow duration-300 animate-fade-in-up [animation-delay:200ms] opacity-0 [animation-fill-mode:forwards]">

            <div class="mb-6 border-b border-slate-100 pb-4 shrink-0">
                <h2 class="text-lg font-extrabold text-slate-900 tracking-tight">
                    Profile Overview
                </h2>
                <p class="text-xs text-slate-400 font-medium mt-0.5">
                    Click update profile to modify saved credentials or contact parameters.
                </p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 flex-grow">

                <div class="space-y-1.5">
                    <label class="text-xs font-bold text-slate-400 tracking-wide uppercase">Username</label>
                    <div class="px-4 py-3 border border-slate-100 rounded-xl bg-slate-50/60 font-semibold text-slate-800 text-sm transition-colors focus-within:border-slate-200">
                        <?= htmlspecialchars($user['username'] ?? '—') ?>
                    </div>
                </div>

                <div class="space-y-1.5">
                    <label class="text-xs font-bold text-slate-400 tracking-wide uppercase">Email Address</label>
                    <div class="px-4 py-3 border border-slate-100 rounded-xl bg-slate-50/60 font-semibold text-slate-800 text-sm transition-colors focus-within:border-slate-200">
                        <?= htmlspecialchars($user['email'] ?? '—') ?>
                    </div>
                </div>

                <div class="space-y-1.5">
                    <label class="text-xs font-bold text-slate-400 tracking-wide uppercase">Phone Number</label>
                    <div class="px-4 py-3 border border-slate-100 rounded-xl bg-slate-50/60 font-semibold text-slate-800 text-sm transition-colors focus-within:border-slate-200">
                        <?= htmlspecialchars($user['phone'] ?? '—') ?>
                    </div>
                </div>

                <div class="space-y-1.5">
                    <label class="text-xs font-bold text-slate-400 tracking-wide uppercase">Blood Group</label>
                    <div class="px-4 py-3 border border-slate-100 rounded-xl bg-slate-50/60 font-semibold text-slate-800 text-sm transition-colors focus-within:border-slate-200">
                        <?= htmlspecialchars($user['blood_group'] ?? '—') ?>
                    </div>
                </div>

                <div class="sm:col-span-2 space-y-1.5">
                    <label class="text-xs font-bold text-slate-400 tracking-wide uppercase">Residential Address</label>
                    <div class="px-4 py-3 border border-slate-100 rounded-xl bg-slate-50/60 font-semibold text-slate-800 text-sm transition-colors focus-within:border-slate-200 min-h-[50px] h-auto">
                        <?= htmlspecialchars($user['address'] ?? '—') ?>
                    </div>
                </div>

            </div>

        </div>

    </div>
</main>