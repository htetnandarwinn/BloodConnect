<?php
$errors = $_SESSION['errors'] ?? [];
$success = $_SESSION['success'] ?? [];
unset($_SESSION['errors'], $_SESSION['success']);
?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<section class="min-h-screen bg-gray-50 flex items-center justify-center px-4 py-10">
    <div class="w-full max-w-md rounded-3xl border border-gray-200 bg-white p-8 shadow-xl shadow-gray-100">
        <div class="text-center mb-8">
            <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-red-50 text-red-600">
                <i class="fa-solid fa-lock text-xl"></i>
            </div>
            <h2 class="mt-4 text-2xl font-black text-gray-900">Reset Password</h2>
            <p class="mt-2 text-sm text-gray-500">Choose a new password for your account.</p>
        </div>

        <?php if (!empty($errors['form'])): ?>
            <div class="mb-5 rounded-xl border border-red-200 bg-red-50 p-3 text-sm font-semibold text-red-600">
                <?= htmlspecialchars($errors['form'], ENT_QUOTES) ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($success)): ?>
            <div class="mb-5 rounded-xl border border-emerald-200 bg-emerald-50 p-3 text-sm font-semibold text-emerald-600">
                <?= htmlspecialchars($success, ENT_QUOTES) ?>
            </div>
        <?php endif; ?>

        <form method="post" action="/BloodConnect/public/forgot-password/reset" class="space-y-5">
            <div>
                <label class="mb-2 block text-sm font-bold text-gray-700">New Password</label>
                <input type="password" name="password" required
                    class="w-full rounded-xl border border-gray-300 px-4 py-3 text-sm text-gray-900 focus:border-red-500 focus:outline-none focus:ring-4 focus:ring-red-100">
            </div>

            <div>
                <label class="mb-2 block text-sm font-bold text-gray-700">Confirm Password</label>
                <input type="password" name="confirm_password" required
                    class="w-full rounded-xl border border-gray-300 px-4 py-3 text-sm text-gray-900 focus:border-red-500 focus:outline-none focus:ring-4 focus:ring-red-100">
            </div>

            <button type="submit" class="w-full rounded-xl bg-red-600 px-4 py-3 text-sm font-bold text-white transition hover:bg-red-700">
                Update Password
            </button>
        </form>
    </div>
</section>