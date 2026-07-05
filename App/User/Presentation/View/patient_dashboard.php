<?php

use App\Shared\Helpers\Session;



Session::start();
$username = $username ?? 'Patient';
$patientName = $_SESSION['username'] ?? 'Patient';

$metrics = $metrics ?? [
    'total_requests' => 0,
    'pending_requests' => 0,
    'accepted_requests' => 0,
    'completed_requests' => 0,
];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Dashboard | BloodConnect</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        body {
            background-color: #FFF8F8;
        }

        .animate-fade-in {
            animation: fadeIn 0.5s ease-out forwards;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>

<body class="min-h-screen text-slate-800 font-sans antialiased">

    <main class="w-full px-6 md:px-12 lg:px-16 py-10 space-y-10">

        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 animate-fade-in">
            <div>
                <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight flex items-center gap-2">
                    Welcome,
                    <?= htmlspecialchars($username) ?>!
                    <span class="animate-bounce inline-block">👋</span>
                </h1>
                <p class="text-sm text-slate-500 mt-1">Monitor your requests or initiate a new blood drive.</p>
            </div>
            <div>
                <!-- <button onclick="openModal()" class="inline-flex items-center gap-2 bg-red-600 hover:bg-red-700 text-white font-semibold px-6 py-3.5 rounded-xl shadow-md hover:shadow-lg transition-all duration-300 transform hover:-translate-y-0.5 active:translate-y-0">
                    <i class="fa-solid fa-plus text-sm"></i>
                    <span>New Blood Request</span>
                </button> -->
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 animate-fade-in" style="animation-delay: 100ms;">

            <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 flex items-center gap-4 hover:shadow-md transition-shadow duration-300">
                <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-500 flex items-center justify-center text-xl">
                    <i class="fa-solid fa-droplet"></i>
                </div>
                <div>
                    <p class="text-2xl font-bold text-slate-900"><?php echo $metrics['total_requests']; ?></p>
                    <p class="text-xs font-medium text-slate-400 tracking-wider uppercase">Total Requests</p>
                </div>
            </div>

            <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 flex items-center gap-4 hover:shadow-md transition-shadow duration-300">
                <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-500 flex items-center justify-center text-xl">
                    <i class="fa-solid fa-clock-rotate-left"></i>
                </div>
                <div>
                    <p class="text-2xl font-bold text-slate-900"><?php echo $metrics['pending_requests']; ?></p>
                    <p class="text-xs font-medium text-slate-400 tracking-wider uppercase">Pending Requests</p>
                </div>
            </div>

            <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 flex items-center gap-4 hover:shadow-md transition-shadow duration-300">
                <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-500 flex items-center justify-center text-xl">
                    <i class="fa-solid fa-circle-check"></i>
                </div>
                <div>
                    <p class="text-2xl font-bold text-slate-900"><?php echo $metrics['accepted_requests']; ?></p>
                    <p class="text-xs font-medium text-slate-400 tracking-wider uppercase">Accepted Requests</p>
                </div>
            </div>

            <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 flex items-center gap-4 hover:shadow-md transition-shadow duration-300">
                <div class="w-12 h-12 rounded-xl bg-purple-50 text-purple-500 flex items-center justify-center text-xl">
                    <i class="fa-solid fa-flag-checkered"></i>
                </div>
                <div>
                    <p class="text-2xl font-bold text-slate-900"><?php echo $metrics['completed_requests']; ?></p>
                    <p class="text-xs font-medium text-slate-400 tracking-wider uppercase">Completed Requests</p>
                </div>
            </div>

        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden animate-fade-in" style="animation-delay: 200ms;">
            <div class="p-6 border-b border-slate-100 flex items-center justify-between">
                <h2 class="text-lg font-bold text-slate-900">My Requests</h2>
                <!-- <a href="#" class="text-sm font-semibold text-red-600 hover:text-red-700 transition-colors flex items-center gap-1 group">
                    View All -->
                <!-- <i class="fa-solid fa-arrow-right transition-transform group-hover:translate-x-1"></i> -->
                </a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50/70 border-b border-slate-100 text-[11px] font-bold uppercase tracking-wider text-slate-400">
                            <th class="py-4 px-6">Request ID</th>
                            <th class="py-4 px-6">Patient Name</th>
                            <th class="py-4 px-6 text-center">Urgency Level</th>
                            <th class="py-4 px-6 text-center">Blood</th>
                            <th class="py-4 px-6 text-center">Unit</th>
                            <th class="py-4 px-6">Hospital / Location</th>
                            <th class="py-4 px-6">Contact Phone</th>
                            <th class="py-4 px-6 text-center">Status</th>
                            <th class="py-4 px-6 text-right">Date</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-sm font-medium text-slate-700">
                        <?php if (!empty($requests)): ?>
                            <?php foreach ($requests as $request): ?>
                                <tr class="hover:bg-slate-50/50 transition-colors duration-200">

                                    <!-- Request ID -->
                                    <td class="py-4 px-6 font-semibold text-slate-900">
                                        <?= htmlspecialchars($request['request_code']) ?>
                                    </td>

                                    <!-- Patient Name -->
                                    <td class="py-4 px-6">
                                        <?= htmlspecialchars($request['patient_name']) ?>
                                    </td>

                                    <!-- Urgency -->
                                    <td class="py-4 px-6 text-center">
                                        <?php
                                        $urgency = strtolower(trim($request['urgency'] ?? ''));

                                        if ($urgency == 'critical (immediate)' || $urgency == 'critical') {
                                            echo '<span class="inline-block px-2 py-1 rounded bg-red-100 text-red-700">Critical (Immediate)</span>';
                                        } elseif ($urgency == 'urgent') {
                                            echo '<span class="inline-block px-2 py-1 rounded bg-orange-100 text-orange-700">Urgent</span>';
                                        } else {
                                            echo '<span class="inline-block px-2 py-1 rounded bg-slate-100 text-slate-700">Within 24 Hrs</span>';
                                        }
                                        ?>
                                    </td>

                                    <!-- Blood -->
                                    <td class="py-4 px-6 text-center">
                                        <span class="inline-block bg-red-50 text-red-600 text-xs font-bold px-2.5 py-1 rounded-lg border border-red-100">
                                            <?= htmlspecialchars($request['blood_group_needed']) ?>
                                        </span>
                                    </td>

                                    <!-- Unit -->
                                    <td class="py-4 px-6 text-center">
                                        <?= htmlspecialchars($request['unit']) ?>
                                    </td>

                                    <!-- Hospital -->
                                    <td class="py-4 px-6">
                                        <?= htmlspecialchars($request['hospital_name']) ?>
                                    </td>

                                    <!-- Contact Phone -->
                                    <td class="py-4 px-6">
                                        <?= htmlspecialchars($request['contact_phone']) ?>
                                    </td>

                                    <!-- Status -->
                                    <td class="py-4 px-6 text-center">
                                        <?php
                                        switch (strtolower($request['status'])) {
                                            case 'pending':
                                                echo '<span class="inline-flex px-3 py-1 rounded-full bg-amber-50 text-amber-700">Pending</span>';
                                                break;

                                            case 'accepted':
                                                echo '<span class="inline-flex px-3 py-1 rounded-full bg-emerald-50 text-emerald-700">Accepted</span>';
                                                break;

                                            case 'completed':
                                                echo '<span class="inline-flex px-3 py-1 rounded-full bg-blue-50 text-blue-700">Completed</span>';
                                                break;

                                            default:
                                                echo '<span class="inline-flex px-3 py-1 rounded-full bg-red-50 text-red-700">Cancelled</span>';
                                        }
                                        ?>
                                    </td>

                                    <!-- Date -->
                                    <td class="py-4 px-6 text-right">
                                        <?= date('d M Y', strtotime($request['created_at'])) ?>
                                    </td>

                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" class="py-8 text-center text-slate-400">No requests found.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <div id="modalBackdrop" class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm z-50 flex items-center justify-center hidden opacity-0 transition-opacity duration-300">
        <div id="modalBox" class="bg-white w-full max-w-md p-6 rounded-2xl shadow-xl border border-slate-100 scale-95 transform transition-transform duration-300">
            <div class="flex items-center justify-between border-b border-slate-100 pb-4 mb-4">
                <h3 class="text-lg font-bold text-slate-900">Create New Request</h3>
                <button onclick="closeModal()" class="text-slate-400 hover:text-slate-600 transition-colors">
                    <i class="fa-solid fa-xmark text-lg"></i>
                </button>
            </div>
            <form action="" method="POST" class="space-y-4">
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1">Blood Type</label>
                    <select name="blood_type" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:border-red-500 transition-colors">
                        <option value="A+">A+</option>
                        <option value="A-">A-</option>
                        <option value="B+">B+</option>
                        <option value="B-">B-</option>
                        <option value="O+">O+</option>
                        <option value="O-">O-</option>
                        <option value="AB+">AB+</option>
                        <option value="AB-">AB-</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1">Hospital / Target Location</label>
                    <input type="text" name="location" placeholder="e.g. City General Hospital" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:border-red-500 transition-colors" required>
                </div>
                <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white font-semibold py-2.5 rounded-xl transition-colors shadow-sm mt-2">
                    Submit Request
                </button>
            </form>
        </div>
    </div>

    <script>
        const backdrop = document.getElementById('modalBackdrop');
        const modalBox = document.getElementById('modalBox');

        function openModal() {
            backdrop.classList.remove('hidden');
            setTimeout(() => {
                backdrop.classList.remove('opacity-0');
                modalBox.classList.remove('scale-95');
                modalBox.classList.add('scale-100');
            }, 20);
        }

        function closeModal() {
            backdrop.classList.add('opacity-0');
            modalBox.classList.remove('scale-100');
            modalBox.classList.add('scale-95');
            setTimeout(() => {
                backdrop.classList.add('hidden');
            }, 300);
        }

        backdrop.addEventListener('click', (e) => {
            if (e.target === backdrop) closeModal();
        });
    </script>
</body>

</html>