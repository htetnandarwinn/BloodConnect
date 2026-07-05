<?php
// Initialize variables for PHP error/success tracking if needed

use App\Shared\Helpers\Session;

Session::start();

$message = '';
$status = '';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Request Blood | BloodConnect</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
    </style>
</head>

<body class="bg-[#FFFDFD] text-slate-700 min-h-screen w-full flex flex-col items-center justify-center p-4 sm:p-6 md:p-10 overflow-x-hidden">

    <!-- Card container with reduced width (max-w-xl) and compact padding -->
    <div class="w-full max-w-xl bg-white rounded-3xl p-6 sm:p-8 shadow-xl border border-rose-100/60 mx-auto my-auto transition-all duration-300">

        <div class="text-center mb-6">
            <div class="inline-flex items-center justify-center w-12 h-12 rounded-xl bg-red-50 text-red-500 mb-3 border border-red-100/80 shadow-sm">
                <i class="fa-solid fa-droplet text-xl"></i>
            </div>
            <h1 class="text-xl font-extrabold tracking-tight text-slate-900">
                Create a Blood Request
            </h1>
            <p class="text-xs text-slate-400 mt-1">Every second counts. Fill out the details below to alert nearby heroes.</p>
        </div>

        <?php if (!empty($message)): ?>
            <div id="phpAlert" class="mb-5 p-3.5 rounded-xl flex items-center gap-3 border transition-all duration-300 <?= $status === 'success' ? 'bg-emerald-50 border-emerald-200 text-emerald-700' : 'bg-rose-50 border-rose-200 text-rose-700' ?>">
                <i class="fa-solid <?= $status === 'success' ? 'fa-circle-check' : 'fa-circle-exclamation' ?> text-base"></i>
                <span class="text-xs font-semibold"><?= htmlspecialchars($message) ?></span>
            </div>
        <?php endif; ?>

        <form action="" method="POST" id="bloodRequestForm" class="space-y-5">

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="relative group">
                    <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-400 mb-1.5 transition-colors group-focus-within:text-red-500">Patient Name</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400 group-focus-within:text-red-500 transition-colors">
                            <i class="fa-solid fa-user text-xs"></i>
                        </span>
                        <input type="text" name="patient_name" required placeholder="John Doe"
                            class="w-full bg-slate-50/70 border border-slate-200 rounded-xl pl-10 pr-3 py-2.5 text-sm text-slate-800 placeholder-slate-400 font-medium outline-none transition-all duration-300 focus:bg-white focus:border-red-500 focus:ring-4 focus:ring-red-500/10">
                    </div>
                </div>

                <div class="relative group">
                    <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-400 mb-1.5 transition-colors group-focus-within:text-red-500">Units Needed (ml/Bags)</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400 group-focus-within:text-red-500 transition-colors">
                            <i class="fa-solid fa-boxes-stacked text-xs"></i>
                        </span>
                        <input type="number" name="unit" min="1" max="10" required placeholder="2"
                            class="w-full bg-slate-50/70 border border-slate-200 rounded-xl pl-10 pr-3 py-2.5 text-sm text-slate-800 placeholder-slate-400 font-medium outline-none transition-all duration-300 focus:bg-white focus:border-red-500 focus:ring-4 focus:ring-red-500/10">
                    </div>
                </div>
            </div>

            <div>
                <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-400 mb-2">Required Blood Group</label>
                <input type="hidden" name="blood_group_needed" id="selectedBloodGroup" required>
                <div class="grid grid-cols-4 gap-2.5">
                    <?php
                    $blood_types = ['A+', 'A-', 'B+', 'B-', 'O+', 'O-', 'AB+', 'AB-'];
                    foreach ($blood_types as $type):
                    ?>
                        <button type="button" onclick="selectBloodGroup('<?= $type ?>')" data-type="<?= $type ?>"
                            class="blood-btn py-2 rounded-xl border border-slate-200 bg-slate-50/70 text-sm font-bold tracking-wide text-slate-700 transition-all duration-300 hover:border-red-500/50 hover:bg-red-50/50 active:scale-95 flex flex-col items-center justify-center gap-0.5">
                            <?= $type ?>
                            <span class="w-1 h-1 rounded-full bg-transparent transition-colors duration-300 indicator"></span>
                        </button>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="relative group">
                <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-400 mb-1.5 transition-colors group-focus-within:text-red-500">Hospital & Location Address</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400 group-focus-within:text-red-500 transition-colors">
                        <i class="fa-solid fa-hospital text-xs"></i>
                    </span>
                    <input type="text" name="hospital_name" required placeholder="City Hospital, Emergency Wing, Ward 4"
                        class="w-full bg-slate-50/70 border border-slate-200 rounded-xl pl-10 pr-3 py-2.5 text-sm text-slate-800 placeholder-slate-400 font-medium outline-none transition-all duration-300 focus:bg-white focus:border-red-500 focus:ring-4 focus:ring-red-500/10">
                </div>
            </div>

            <div class="relative group">
                <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-400 mb-1.5 transition-colors group-focus-within:text-red-500">Contact Phone</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400 group-focus-within:text-red-500 transition-colors">
                        <i class="fa-solid fa-phone text-xs"></i>
                    </span>
                    <input type="text" name="contact_phone" required placeholder="09xxxxxxxxx"
                        class="w-full bg-slate-50/70 border border-slate-200 rounded-xl pl-10 pr-3 py-2.5 text-sm text-slate-800 placeholder-slate-400 font-medium outline-none transition-all duration-300 focus:bg-white focus:border-red-500 focus:ring-4 focus:ring-red-500/10">
                </div>
            </div>

            <div>
                <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-400 mb-2">Urgency Level</label>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                    <label class="relative flex items-center justify-between p-3 bg-slate-50/70 border border-slate-200 rounded-xl cursor-pointer transition-all hover:border-amber-500/50 group">
                        <div class="flex items-center gap-2">
                            <i class="fa-solid fa-clock text-amber-500 text-xs"></i>
                            <span class="text-xs font-semibold text-slate-700">Within 24 Hrs</span>
                        </div>
                        <input type="radio" name="urgency" value="Standard" checked class="accent-red-600 w-3.5 h-3.5">
                    </label>

                    <label class="relative flex items-center justify-between p-3 bg-slate-50/70 border border-slate-200 rounded-xl cursor-pointer transition-all hover:border-orange-500/50 group">
                        <div class="flex items-center gap-2">
                            <i class="fa-solid fa-triangle-exclamation text-orange-500 text-xs"></i>
                            <span class="text-xs font-semibold text-slate-700">Urgent</span>
                        </div>
                        <input type="radio" name="urgency" value="Urgent" class="accent-red-600 w-3.5 h-3.5">
                    </label>

                    <label class="relative flex items-center justify-between p-3 bg-slate-50/70 border border-slate-200 rounded-xl cursor-pointer transition-all hover:border-red-500/50 group">
                        <div class="flex items-center gap-2">
                            <i class="fa-solid fa-fire text-red-500 animate-pulse text-xs"></i>
                            <span class="text-xs font-semibold text-slate-700">Critical</span>
                        </div>
                        <input type="radio" name="urgency" value="Critical" class="accent-red-600 w-3.5 h-3.5">
                    </label>
                </div>
            </div>


            <button type="submit" id="submitBtn"
                class="w-full bg-red-600 hover:bg-red-700 text-white font-semibold py-3 px-5 rounded-xl text-sm shadow-md hover:shadow-lg shadow-red-600/10 transform transition-all duration-300 hover:-translate-y-0.5 active:translate-y-0 flex items-center justify-center gap-2 group overflow-hidden relative mt-2">
                <span class="absolute inset-0 w-full h-full bg-gradient-to-r from-white/10 to-transparent transform -skew-x-12 -translate-x-full group-hover:animate-[shimmer_1s_ease-in-out]"></span>
                <span id="btnText">Broadcast Live Request</span>
                <i class="fa-solid fa-paper-plane text-xs transition-transform duration-300 group-hover:translate-x-1 group-hover:-translate-y-0.5"></i>
            </button>
        </form>
    </div>

    <script>
        function selectBloodGroup(type) {
            document.getElementById('selectedBloodGroup').value = type;

            document.querySelectorAll('.blood-btn').forEach(btn => {
                btn.classList.remove('border-red-500', 'bg-red-50/70', 'text-red-600');
                btn.classList.add('border-slate-200', 'bg-slate-50/70', 'text-slate-700');
                btn.querySelector('.indicator').classList.replace('bg-red-500', 'bg-transparent');
            });

            const selectedBtn = document.querySelector(`[data-type="${type}"]`);
            selectedBtn.classList.replace('border-slate-200', 'border-red-500');
            selectedBtn.classList.replace('bg-slate-50/70', 'bg-red-50/70');
            selectedBtn.classList.replace('text-slate-700', 'text-red-600');
            selectedBtn.querySelector('.indicator').classList.replace('bg-transparent', 'bg-red-500');
        }

        const form = document.getElementById('bloodRequestForm');
        const submitBtn = document.getElementById('submitBtn');
        const btnText = document.getElementById('btnText');

        form.addEventListener('submit', function() {
            if (form.checkValidity()) {
                submitBtn.disabled = true;
                submitBtn.classList.add('opacity-80', 'cursor-not-allowed');
                btnText.innerHTML = '<i class="fa-solid fa-circle-notch animate-spin mr-2"></i> Processing Request...';
            }
        });

        const alertBox = document.getElementById('phpAlert');
        if (alertBox) {
            setTimeout(() => {
                alertBox.classList.add('opacity-0', '-translate-y-2');
                setTimeout(() => alertBox.remove(), 300);
            }, 4000);
        }
    </script>
</body>

</html>