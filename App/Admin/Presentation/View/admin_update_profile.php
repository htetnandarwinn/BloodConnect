<?php $user = $user ?? []; ?>

<main class="min-h-screen bg-rose-50/40 p-4 sm:p-6">

    <div class="max-w-3xl mx-auto space-y-6">

        <!-- HEADER -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">
                    Update Profile
                </h1>
                <p class="text-sm text-slate-500 mt-1">
                    Modify your account details and security credentials.
                </p>
            </div>

            <a href="/BloodConnect/public/admin/profile"
                class="inline-flex items-center gap-2 px-4 py-2.5 bg-white border border-slate-200 rounded-xl text-sm font-semibold text-slate-600 hover:bg-slate-50 hover:text-[#ce2424] transition shadow-sm active:scale-95">
                <span class="text-base leading-none">←</span> Back to Profile
            </a>
        </div>

        <?php if (!empty($message)): ?>
            <div class="flex items-center gap-3 px-4 py-3.5 rounded-xl text-sm font-semibold border <?= $status === 'success' ? 'bg-green-50 text-green-700 border-green-100' : 'bg-red-50 text-red-700 border-red-100' ?>">
                <span class="text-base"><?= $status === 'success' ? '✓' : '!' ?></span>
                <?= htmlspecialchars($message) ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="/BloodConnect/public/admin/profile/update"
            class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">

            <!-- Account Details -->
            <div class="p-6 border-b border-slate-100">
                <div class="flex items-center gap-2.5 mb-5">
                    <div class="w-9 h-9 rounded-xl bg-red-50 flex items-center justify-center text-lg">👤</div>
                    <div>
                        <h3 class="text-base font-bold text-slate-900 leading-tight">Account Details</h3>
                        <p class="text-xs text-slate-400">Your login and contact information</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-slate-500 mb-1.5">Username</label>
                        <input type="text" name="username"
                            value="<?= htmlspecialchars($user['username'] ?? '') ?>"
                            class="w-full px-3.5 py-2.5 bg-slate-50 rounded-xl border border-slate-200 font-medium text-slate-800 focus:outline-none focus:ring-2 focus:ring-red-400 focus:border-transparent transition">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-500 mb-1.5">Phone</label>
                        <input type="text" name="phone"
                            value="<?= htmlspecialchars($user['phone'] ?? '') ?>"
                            class="w-full px-3.5 py-2.5 bg-slate-50 rounded-xl border border-slate-200 font-medium text-slate-800 focus:outline-none focus:ring-2 focus:ring-red-400 focus:border-transparent transition">
                    </div>

                    <div class="sm:col-span-2">
                        <label class="block text-xs font-semibold text-slate-500 mb-1.5">Email</label>
                        <input type="email" name="email"
                            value="<?= htmlspecialchars($user['email'] ?? '') ?>"
                            class="w-full px-3.5 py-2.5 bg-slate-50 rounded-xl border border-slate-200 font-medium text-slate-800 focus:outline-none focus:ring-2 focus:ring-red-400 focus:border-transparent transition">
                    </div>
                </div>
            </div>

            <!-- Change Password -->
            <div class="p-6 bg-slate-50/50">
                <div class="flex items-center gap-2.5 mb-5">
                    <div class="w-9 h-9 rounded-xl bg-red-50 flex items-center justify-center text-lg">🔒</div>
                    <div>
                        <h3 class="text-base font-bold text-slate-900 leading-tight">Change Password</h3>
                        <p class="text-xs text-slate-400">Leave blank to keep your current password</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-slate-500 mb-1.5">New Password</label>
                        <input type="password" name="new_password" autocomplete="new-password"
                            class="w-full px-3.5 py-2.5 bg-white rounded-xl border border-slate-200 font-medium text-slate-800 focus:outline-none focus:ring-2 focus:ring-red-400 focus:border-transparent transition">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-500 mb-1.5">Confirm New Password</label>
                        <input type="password" name="confirm_password" autocomplete="new-password"
                            class="w-full px-3.5 py-2.5 bg-white rounded-xl border border-slate-200 font-medium text-slate-800 focus:outline-none focus:ring-2 focus:ring-red-400 focus:border-transparent transition">
                    </div>
                </div>
            </div>

            <!-- Footer Actions -->
            <div class="p-6 flex items-center justify-end gap-3 border-t border-slate-100">
                <a href="/BloodConnect/public/admin/profile"
                    class="px-5 py-2.5 rounded-xl text-sm font-semibold text-slate-500 hover:bg-slate-100 transition">
                    Cancel
                </a>
                <button type="submit"
                    class="inline-flex items-center gap-2 px-6 py-2.5 bg-[#ce2424] text-white rounded-xl text-sm font-bold hover:bg-red-700 transition shadow-sm shadow-red-500/20 active:scale-95">
                    Save Changes
                </button>
            </div>

        </form>

    </div>

</main>
