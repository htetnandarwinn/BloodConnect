<?php $user = $user ?? []; ?>

<!-- CHANGED: Matches the warm full background color from edited-image.png -->
<main class="min-h-screen bg-rose-50/40 p-6">

    <div class="max-w-5xl mx-auto space-y-6">

        <!-- HEADER -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">

            <div>
                <h1 class="text-3xl font-black text-slate-900">
                    My Profile Details 👋
                </h1>
                <p class="text-sm text-slate-500 mt-1">
                    View your administrative registration records and system role permissions.
                </p>
            </div>

            <a href="/BloodConnect/public/admin/dashboard"
                class="px-4 py-2 bg-white border rounded-xl text-sm font-semibold hover:bg-slate-100 transition shadow-sm">
                ← Back to Dashboard
            </a>

        </div>

        <!-- PROFILE GRID -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            <!-- LEFT CARD -->
            <div class="bg-white rounded-2xl shadow-sm border p-6 text-center">

                <div class="w-24 h-24 mx-auto rounded-full bg-red-50 flex items-center justify-center text-4xl">
                    🛡️
                </div>

                <h2 class="mt-4 text-xl font-bold text-slate-900">
                    <?= htmlspecialchars($user['username'] ?? 'Admin') ?>
                </h2>

                <p class="text-sm text-slate-500">
                    <?= htmlspecialchars($user['role'] ?? 'Administrator') ?>
                </p>

                <div class="mt-3 inline-block px-3 py-1 text-xs font-bold text-green-600 bg-green-50 rounded-full">
                    Verified Admin
                </div>

            </div>

            <!-- RIGHT CARD -->
            <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border p-6">

                <h3 class="text-lg font-bold text-slate-800 mb-4">
                    Profile Overview
                </h3>

                <div class="space-y-4">

                    <div>
                        <label class="text-xs text-slate-500">Username</label>
                        <div class="mt-1 p-3 bg-slate-50 rounded-lg font-semibold">
                            <?= htmlspecialchars($user['username'] ?? '') ?>
                        </div>
                    </div>

                    <div>
                        <label class="text-xs text-slate-500">Role</label>
                        <div class="mt-1 p-3 bg-slate-50 rounded-lg font-semibold">
                            <?= htmlspecialchars($user['role'] ?? '') ?>
                        </div>
                    </div>

                </div>

            </div>

        </div>
    </div>

</main>