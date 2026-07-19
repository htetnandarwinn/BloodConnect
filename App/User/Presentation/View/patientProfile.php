<?php $user = $user ?? []; ?>

<main class="flex-grow p-4 sm:p-6 lg:p-8 space-y-6 sm:space-y-8 w-full max-w-7xl mx-auto">

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 animate-fade-in">
        <div>
            <h1 class="text-2xl sm:text-3xl font-black text-[#0b1325] tracking-tight flex items-center gap-2">
                Patient Profile Details 👋
            </h1>
            <p class="text-xs sm:text-sm text-slate-500 font-medium mt-1">
                View and manage your verified registration records and medical profile.
            </p>
        </div> 

        <button onclick="window.location.href='/BloodConnect/public/patient/dashboard';"
            class="border border-slate-200 hover:bg-slate-50 active:scale-[0.98] text-slate-600 px-5 py-2.5 rounded-2xl font-bold text-xs sm:text-sm shadow-sm transition-all">
            &larr; Back to Dashboard
        </button>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-stretch">

        <!-- LEFT PROFILE CARD -->
        <div class="bg-white border border-slate-100 rounded-2xl p-6 shadow-sm">

            <div class="flex flex-col items-center text-center space-y-4">

                <div class="w-24 h-24 rounded-full bg-[#fff5f5] border-4 border-white flex items-center justify-center text-4xl text-[#ce2424]">
                    👤
                </div>

                <div>
                    <h3 class="font-extrabold text-[#0b1325] text-lg">
                        <?= htmlspecialchars($user['username'] ?? '') ?>
                    </h3>
                    <p class="text-xs text-slate-400 uppercase">Registered Patient</p>
                </div>

                <div class="text-xs font-bold text-emerald-600">
                    ✔ Verified Account
                </div>

            </div>

            <hr class="my-4">

            <div class="text-sm space-y-2">
                <div class="flex justify-between">
                    <span class="text-slate-400">Blood Group</span>
                    <span class="font-bold text-[#ce2424]">
                        <?= htmlspecialchars($user['blood_group'] ?? '') ?>
                    </span>
                </div>

                <div class="flex justify-between">
                    <span class="text-slate-400">Email</span>
                    <span class="font-bold text-slate-700">
                        <?= htmlspecialchars($user['email'] ?? '') ?>
                    </span>
                </div>
            </div>

            <!-- ✅ ADDED BUTTON (IMPORTANT FIX) -->
            <div class="mt-6 flex justify-center">
                <a href="/BloodConnect/public/patient/profile/update"
                    class="bg-[#ce2424] hover:bg-red-700 text-white px-5 py-2.5 rounded-xl font-bold text-sm shadow-md">
                    ✏️ Update Profile
                </a>
            </div>

        </div>

        <!-- RIGHT SIDE (VIEW ONLY) -->
        <div class="lg:col-span-2 bg-white border border-slate-100 rounded-2xl p-6 shadow-sm">

            <div class="mb-6 border-b pb-4">
                <h2 class="text-lg font-extrabold text-[#0b1325]">
                    Profile Overview
                </h2>
                <p class="text-xs text-slate-400">
                    Click update to modify your information
                </p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

                <div>
                    <label class="text-xs font-bold text-slate-500">Username</label>
                    <div class="px-4 py-2 border rounded-lg bg-slate-50">
                        <?= htmlspecialchars($user['username'] ?? '') ?>
                    </div>
                </div>

                <div>
                    <label class="text-xs font-bold text-slate-500">Email</label>
                    <div class="px-4 py-2 border rounded-lg bg-slate-50">
                        <?= htmlspecialchars($user['email'] ?? '') ?>
                    </div>
                </div>

                <div>
                    <label class="text-xs font-bold text-slate-500">Phone</label>
                    <div class="px-4 py-2 border rounded-lg bg-slate-50">
                        <?= htmlspecialchars($user['phone'] ?? '') ?>
                    </div>
                </div>

                <div>
                    <label class="text-xs font-bold text-slate-500">Blood Group</label>
                    <div class="px-4 py-2 border rounded-lg bg-slate-50">
                        <?= htmlspecialchars($user['blood_group'] ?? '') ?>
                    </div>
                </div>

                <div class="sm:col-span-2">
                    <label class="text-xs font-bold text-slate-500">Address</label>
                    <div class="px-4 py-2 border rounded-lg bg-slate-50">
                        <?= htmlspecialchars($user['address'] ?? '') ?>
                    </div>
                </div>

            </div>

        </div>

    </div>
</main>