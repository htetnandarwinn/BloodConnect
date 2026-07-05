<?php

use App\Shared\Helpers\Session;

Session::start();

// Catch the incoming dataset variables directly from form submission or persistent session state fallback
$username  = $user['username'] ?? '';
$email     = $user['email'] ?? '';
$contact   = $user['phone'] ?? '';
$bloodType = $user['blood_group'] ?? '';
$address   = $user['address'] ?? '';

$errorMessage = null;

// Catch the Finalize Submitting Event triggered inside this secondary view screen
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action_save_profile'])) {
    $newPassword     = $_POST['new_password'] ?? '';
    $confirmPassword = $_POST['confirm_password'] ?? '';

    // Secure JavaScript Form validation fallback mechanism
    if (!empty($newPassword) && $newPassword !== $confirmPassword) {
        $errorMessage = "Validation Error: Passwords do not match!";
    } else {
        // Sanitize incoming stream values to protect active parameters
        $_SESSION['username']   = trim(filter_input(INPUT_POST, 'username_name', FILTER_SANITIZE_SPECIAL_CHARS));
        $_SESSION['email']      = trim(filter_input(INPUT_POST, 'email_address', FILTER_VALIDATE_EMAIL));
        $_SESSION['contact']    = trim(filter_input(INPUT_POST, 'contact_number', FILTER_SANITIZE_SPECIAL_CHARS));
        $_SESSION['blood_type'] = trim(filter_input(INPUT_POST, 'blood_type_metric', FILTER_SANITIZE_SPECIAL_CHARS));
        $_SESSION['address']    = trim(filter_input(INPUT_POST, 'delivery_address', FILTER_SANITIZE_SPECIAL_CHARS));

        if (!empty($newPassword)) {
            /* 👉 DATABASE SAVING HOOK PLACEHOLDER:
               $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);
               $db->query("UPDATE users SET password = ? WHERE id = ?", [$hashedPassword, ...]);
            */
            $_SESSION['profile_updated_toast'] = "Profile parameters and password updated successfully!";
        } else {
            $_SESSION['profile_updated_toast'] = "Profile specifications updated successfully!";
        }

        // Return the routing chain back home safely
        header("Location: patientProfile.php");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modify Account Specifications | BloodConnect</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background-color: #FFF8F8;
        }

        .page-enter {
            animation: slideUp 0.4s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(15px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>

<body class="min-h-screen flex items-center justify-center p-4 md:p-8">

    <div class="w-full max-w-6xl mx-auto bg-white rounded-3xl shadow-xl shadow-red-900/5 border border-slate-100 p-6 md:p-10 page-enter">

        <div class="flex items-center justify-between border-b border-slate-100 pb-6 mb-8">
            <div>
                <h2 class="text-2xl font-black text-slate-900 tracking-tight">Modify Account Specifications</h2>
                <p class="text-sm text-slate-400 mt-1">Update editable profile details or refresh your structural access password security credentials below.</p>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-red-50 text-red-600 flex items-center justify-center text-xl shadow-inner">
                <i class="fa-solid fa-user-gear"></i>
            </div>
        </div>

        <?php if ($errorMessage): ?>
            <div class="mb-6 p-4 bg-rose-50 border border-rose-100 rounded-xl text-rose-700 text-sm font-semibold flex items-center gap-3">
                <i class="fa-solid fa-circle-exclamation text-base"></i>
                <span><?= $errorMessage ?></span>
            </div>
        <?php endif; ?>

        <form action="/BloodConnect/public/patient/profile/update" method="POST">
            <input type="hidden" name="action_save_profile" value="1">

            <h3 class="text-xs font-bold text-slate-400 uppercase tracking-widest border-b border-slate-50 pb-2">Profile Matrix</h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-4">
                <div class="space-y-2">
                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider">Username Name</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400"><i class="fa-regular fa-user"></i></span>
                        <input type="text" name="username" value="<?= htmlspecialchars($username) ?>" class="w-full bg-slate-50 border border-slate-200/80 rounded-xl pl-11 pr-4 py-3 text-sm font-semibold text-slate-800 focus:outline-none focus:border-red-500 focus:bg-white" required>
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider">Email Address</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400"><i class="fa-regular fa-envelope"></i></span>
                        <input type="email" name="email" value="<?= htmlspecialchars($email) ?>" class="w-full bg-slate-50 border border-slate-200/80 rounded-xl pl-11 pr-4 py-3 text-sm font-semibold text-slate-800 focus:outline-none focus:border-red-500 focus:bg-white" required>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-4">
                <div class="space-y-2">
                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider">Phone Number</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400"><i class="fa-solid fa-phone-flip text-xs"></i></span>
                        <input
                            type="tel"
                            id="phone"
                            name="phone"
                            value="<?= htmlspecialchars($contact) ?>"
                            maxlength="11"
                            inputmode="numeric"
                            pattern="09[0-9]{9}"
                            oninput="this.value=this.value.replace(/[^0-9]/g,'').slice(0,11)"
                            class="w-full bg-slate-50 border border-slate-200/80 rounded-xl pl-11 pr-4 py-3 text-sm font-semibold text-slate-800 focus:outline-none focus:border-red-500 focus:bg-white"
                            required>
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider">Blood Group</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-red-500"><i class="fa-solid fa-droplet"></i></span>
                        <select name="blood_group" class="w-full bg-slate-50 border border-slate-200/80 rounded-xl pl-11 pr-10 py-3 text-sm font-bold text-slate-800 focus:outline-none focus:border-red-500 focus:bg-white appearance-none cursor-pointer">
                            <?php
                            foreach (['A+', 'A-', 'B+', 'B-', 'O+', 'O-', 'AB+', 'AB-'] as $type) {
                                $selected = ($bloodType === $type) ? 'selected' : '';
                                echo "<option value=\"$type\" $selected>$type</option>";
                            }
                            ?>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-slate-400">
                            <i class="fa-solid fa-chevron-down text-xs"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="space-y-2 mt-4">
                <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider">Address / Location</label>
                <div class="relative">
                    <span class="absolute top-3.5 left-4 text-slate-400"><i class="fa-solid fa-location-dot"></i></span>
                    <textarea name="address" rows="2" class="w-full bg-slate-50 border border-slate-200/80 rounded-xl pl-11 pr-4 py-3 text-sm font-semibold text-slate-800 focus:outline-none focus:border-red-500 focus:bg-white" required><?= htmlspecialchars($address) ?></textarea>
                </div>
            </div>

            <h3 class="text-xs font-bold text-slate-400 uppercase tracking-widest border-b border-slate-50 pt-6 pb-2">Security Specifications</h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-4">
                <div class="space-y-2">
                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider">New Password</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400"><i class="fa-solid fa-lock"></i></span>
                        <input type="password" id="new_password" name="new_password" placeholder="Leave blank to keep current" class="w-full bg-slate-50 border border-slate-200/80 rounded-xl pl-11 pr-4 py-3 text-sm font-semibold text-slate-800 focus:outline-none focus:border-red-500 focus:bg-white">
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider">Confirm Password</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400"><i class="fa-solid fa-shield-halved"></i></span>
                        <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirm new password" class="w-full bg-slate-50 border border-slate-200/80 rounded-xl pl-11 pr-4 py-3 text-sm font-semibold text-slate-800 focus:outline-none focus:border-red-500 focus:bg-white">
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-end gap-4 pt-6 mt-6 border-t border-slate-100">
                <a href="/BloodConnect/public/patient/profile"
                    class="px-6 py-3.5 rounded-xl border border-slate-200 text-sm font-bold text-slate-500 hover:bg-slate-50 transition-colors flex items-center gap-2">
                    Discard Changes
                </a>
                <button type="submit" class="inline-flex items-center gap-2 bg-[#ce2424] hover:bg-red-700 text-white font-bold px-7 py-3.5 rounded-xl shadow-lg transition-all duration-200 transform active:scale-95 text-sm">
                    <i class="fa-solid fa-floppy-disk"></i>
                    <span>Confirm & Finalize Changes</span>
                </button>
            </div>
        </form>
    </div>

    <script>
        function validatePasswords() {
            const pass = document.getElementById('new_password').value;
            const confirm = document.getElementById('confirm_password').value;
            if (pass !== confirm) {
                alert("Error: Confirm Password field must match New Password input field exactly!");
                return false;
            }
            return true;
        }

        const phone = document.getElementById("phone");

        phone.addEventListener("input", function() {

            this.value = this.value.replace(/\D/g, '');

            if (this.value.length > 11) {
                this.value = this.value.substring(0, 11);
            }

        });
    </script>
</body>

</html>