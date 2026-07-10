<?php

use App\Shared\Helpers\Session;

$googleData = Session::get('google_registration', []);
$errors = $_SESSION['errors'] ?? [];
unset($_SESSION['errors']);
?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<section class="relative overflow-hidden bg-slate-50 min-h-screen flex items-center font-sans antialiased w-full">
    <div class="relative z-10 w-full max-w-lg mx-auto px-4 py-12">
        <div class="bg-white border border-slate-200/80 rounded-3xl p-8 sm:p-10 shadow-xl shadow-slate-100/50">
            <div class="text-center mb-8">
                <div class="w-16 h-16 rounded-full mx-auto mb-4 overflow-hidden border-2 border-red-100 shadow-sm">
                    <?php if (!empty($googleData['avatar'])): ?>
                        <img src="<?= htmlspecialchars($googleData['avatar']) ?>" alt="Google avatar" class="w-full h-full object-cover">
                    <?php else: ?>
                        <div class="w-full h-full bg-red-50 flex items-center justify-center text-red-500 text-xl font-bold">
                            <i class="fa-solid fa-user"></i>
                        </div>
                    <?php endif; ?>
                </div>
                <h2 class="text-2xl font-black text-slate-900 tracking-tight">Complete Registration</h2>
                <p class="text-sm text-slate-500 mt-1">
                    Welcome, <strong><?= htmlspecialchars($googleData['name'] ?? $googleData['email'] ?? '') ?></strong>
                </p>
                <p class="text-xs text-slate-400 mt-0.5">
                    <?= htmlspecialchars($googleData['email'] ?? '') ?>
                </p>
            </div>

            <?php if (!empty($errors['form'])): ?>
                <div class="mb-5 p-3.5 rounded-xl bg-rose-50 border border-rose-200 text-rose-700 text-xs font-semibold">
                    <i class="fa-solid fa-circle-exclamation"></i> <?= htmlspecialchars($errors['form']) ?>
                </div>
            <?php endif; ?>

            <form method="POST" action="/BloodConnect/public/auth/google/complete-registration" class="space-y-5">
                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide">Username</label>
                    <input type="text" name="username" placeholder="Choose a username"
                        value="<?= htmlspecialchars($googleData['name'] ?? '') ?>"
                        class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:border-red-500 focus:ring-4 focus:ring-red-500/5 font-medium">
                    <?php if (!empty($errors['username'])): ?>
                        <p class="text-red-600 text-xs font-semibold mt-1"><i class="fa-solid fa-circle-exclamation"></i> <?= htmlspecialchars($errors['username']) ?></p>
                    <?php endif; ?>
                </div>

                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide">Blood Group</label>
                    <select name="blood_group" class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 focus:outline-none focus:border-red-500 focus:ring-4 focus:ring-red-500/5 font-medium">
                        <option value="" disabled selected>Select blood group</option>
                        <?php foreach (['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'] as $bg): ?>
                            <option value="<?= $bg ?>"><?= $bg ?></option>
                        <?php endforeach; ?>
                    </select>
                    <?php if (!empty($errors['blood_group'])): ?>
                        <p class="text-red-600 text-xs font-semibold mt-1"><i class="fa-solid fa-circle-exclamation"></i> <?= htmlspecialchars($errors['blood_group']) ?></p>
                    <?php endif; ?>
                </div>

                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide">I want to join as</label>
                    <div class="grid grid-cols-2 gap-3">
                        <label class="relative cursor-pointer">
                            <input type="radio" name="role" value="donor" class="peer sr-only">
                            <div class="p-4 rounded-xl border-2 border-slate-200 bg-white peer-checked:border-red-500 peer-checked:bg-red-50/50 transition-all text-center">
                                <span class="text-2xl block mb-1">🩸</span>
                                <span class="block text-sm font-bold text-slate-800 peer-checked:text-red-600">Donor</span>
                                <span class="block text-[10px] text-slate-400 font-medium">Save lives by donating</span>
                            </div>
                        </label>
                        <label class="relative cursor-pointer">
                            <input type="radio" name="role" value="patient" class="peer sr-only">
                            <div class="p-4 rounded-xl border-2 border-slate-200 bg-white peer-checked:border-red-500 peer-checked:bg-red-50/50 transition-all text-center">
                                <span class="text-2xl block mb-1">🏥</span>
                                <span class="block text-sm font-bold text-slate-800 peer-checked:text-red-600">Patient</span>
                                <span class="block text-[10px] text-slate-400 font-medium">Request blood when needed</span>
                            </div>
                        </label>
                    </div>
                    <?php if (!empty($errors['role'])): ?>
                        <p class="text-red-600 text-xs font-semibold mt-1"><i class="fa-solid fa-circle-exclamation"></i> <?= htmlspecialchars($errors['role']) ?></p>
                    <?php endif; ?>
                </div>

                <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white font-bold py-3.5 px-6 rounded-xl text-base shadow-lg shadow-red-600/20 transition-all active:scale-[0.99]">
                    <i class="fa-brands fa-google mr-2"></i> Complete with Google
                </button>
            </form>
        </div>
    </div>
</section>