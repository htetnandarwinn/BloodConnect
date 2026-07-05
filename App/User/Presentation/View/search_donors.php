<?php

use App\Shared\Helpers\Session;

// Start session safely if helper exists
if (class_exists('App\Shared\Helpers\Session')) {
    Session::start();
} else {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
}

// Mocking data structural workflow simulating database retrievals based on search submission
$search_performed = false;
$blood_group = '';
$location = '';
$donors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $search_performed = true;
    $blood_group = $_POST['blood_group'] ?? '';
    $location = $_POST['location'] ?? '';

    // Mock Data representing matching blood donors exactly as shown in image_e93e6d.png
    $donors = [
        ['name' => 'Aung Ko Ko', 'blood' => 'A+', 'location' => 'Meiktila, Main St', 'status' => 'Active', 'phone' => '+95 9 123 456 789'],
        ['name' => 'May Thandar', 'blood' => 'A+', 'location' => 'Meiktila, Hospital Rd', 'status' => 'Active', 'phone' => '+95 9 987 654 321'],
        ['name' => 'Hnin Yu', 'blood' => 'A+', 'location' => 'Meiktila, West Zone', 'status' => 'Active', 'phone' => '+95 9 444 555 666'],
        ['name' => 'Tun Zaw', 'blood' => 'A+', 'location' => 'Meiktila, North Rd', 'status' => 'Standby', 'phone' => '+95 9 222 333 444'],
        ['name' => 'Kyaw Swar', 'blood' => 'A+', 'location' => 'Meiktila, City Center', 'status' => 'Active', 'phone' => '+95 9 777 888 999'],
    ];
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Donors | BloodConnect</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Premium Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght=300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- SweetAlert2 for modern interactive popups -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'sans-serif'],
                    }
                }
            }
        }
    </script>

    <style>
        body {
            background: radial-gradient(circle at 0% 0%, rgba(254, 242, 242, 0.6) 0%, transparent 50%),
                radial-gradient(circle at 100% 100%, rgba(240, 246, 255, 0.6) 0%, transparent 50%),
                #FAF9F9;
        }

        .glass-panel {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
        }

        .custom-scrollbar::-webkit-scrollbar {
            height: 6px;
            width: 6px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: transparent;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #E2E8F0;
            border-radius: 9999px;
        }
    </style>
</head>

<body class="text-slate-800 min-h-screen w-full flex flex-col items-center justify-start p-4 sm:p-6 md:p-8 lg:p-12 overflow-x-hidden">

    <!-- TOP SECTION: Search Control Card -->
    <div class="w-full max-w-5xl glass-panel rounded-[2.5rem] p-6 sm:p-8 md:p-10 shadow-[0_20px_50px_rgba(225,29,72,0.04)] border border-white/90 mx-auto relative overflow-hidden mb-8">

        <div class="absolute -right-12 -top-12 w-40 h-40 bg-gradient-to-br from-rose-400/10 to-red-500/10 rounded-full blur-3xl pointer-events-none"></div>

        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-6 mb-10 relative z-10">
            <div class="flex items-center gap-4">
                <div class="inline-flex items-center justify-center w-14 h-14 rounded-2xl bg-gradient-to-br from-rose-50 to-rose-100/80 text-rose-600 border border-rose-200/60 shadow-inner">
                    <i class="fa-solid fa-magnifying-glass text-xl"></i>
                </div>
                <div>
                    <h1 class="text-2xl font-extrabold tracking-tight text-slate-900 sm:text-3xl">Search Donors</h1>
                    <p class="text-sm text-slate-500 mt-0.5 font-medium">Find compatible emergency blood lifesavers in your proximity.</p>
                </div>
            </div>

            <div class="flex relative items-center justify-center w-12 h-14 bg-gradient-to-b from-rose-500 to-red-600 rounded-2xl shadow-lg shadow-red-500/30">
                <div class="absolute top-2 w-1.5 h-1.5 rounded-full bg-white/40"></div>
                <i class="fa-solid fa-droplet text-white text-xl mt-1"></i>
            </div>
        </div>

        <form action="/patient/search-donors" method="GET" id="donorSearchForm">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 lg:gap-8">
                <!-- Blood Group Selection Field -->
                <div class="space-y-2.5">
                    <label class="block text-xs font-bold uppercase tracking-widest text-slate-400 pl-1">Blood Group</label>
                    <div class="relative group">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-rose-500">
                            <i class="fa-solid fa-droplet text-sm"></i>
                        </span>
                        <select name="blood_group" required
                            class="w-full bg-white/60 border border-slate-200/80 rounded-2xl pl-11 pr-10 py-4 text-sm text-slate-800 font-semibold outline-none focus:bg-white focus:border-rose-500 focus:ring-4 focus:ring-rose-500/5 appearance-none cursor-pointer shadow-sm">
                            <option value="" disabled <?= !$search_performed ? 'selected' : '' ?>>Select Blood Group</option>
                            <?php foreach (['A+', 'A-', 'B+', 'B-', 'O+', 'O-', 'AB+', 'AB-'] as $type): ?>
                                <option value="<?= $type ?>" <?= $blood_group === $type ? 'selected' : '' ?>><?= $type ?></option>
                            <?php endforeach; ?>
                        </select>
                        <span class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none text-slate-400">
                            <i class="fa-solid fa-chevron-down text-xs"></i>
                        </span>
                    </div>
                </div>

                <!-- Location Field -->
                <div class="space-y-2.5">
                    <label class="block text-xs font-bold uppercase tracking-widest text-slate-400 pl-1">Location / Suburb</label>
                    <div class="relative group">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400 group-focus-within:text-rose-500">
                            <i class="fa-solid fa-location-dot text-base"></i>
                        </span>
                        <input type="text" name="location" required value="<?= htmlspecialchars($location) ?>" placeholder="Enter city or district (e.g., Meiktila)"
                            class="w-full bg-white/60 border border-slate-200/80 rounded-2xl pl-11 pr-4 py-4 text-sm text-slate-800 placeholder-slate-400 font-semibold outline-none focus:bg-white focus:border-rose-500 focus:ring-4 focus:ring-rose-500/5 shadow-sm">
                    </div>
                </div>
            </div>

            <button type="submit"
                class="w-full mt-6 bg-gradient-to-r from-red-600 to-rose-600 hover:from-red-500 hover:to-rose-500 text-white font-bold py-4 px-6 rounded-2xl text-sm shadow-xl shadow-rose-600/15 flex items-center justify-center gap-2 group relative overflow-hidden">
                <span>Search Active Donors</span>
                <i class="fa-solid fa-paper-plane text-xs"></i>
            </button>
        </form>
    </div>

    <!-- BOTTOM SECTION: Results Container -->
    <div id="donorResults" class="w-full max-w-5xl glass-panel rounded-[2.5rem] p-8 sm:p-10 md:p-12 shadow-[0_25px_60px_rgba(0,0,0,0.02)] border border-white/90 mx-auto">

        <div class="mb-8 pl-2">
            <?php if ($search_performed): ?>
                <h2 class="text-2xl font-bold tracking-tight text-slate-900">Donor Search Results</h2>
                <p class="text-sm text-slate-400 mt-1.5 font-medium">
                    Found <?= count($donors) ?> donors matching: Group <?= htmlspecialchars($blood_group) ?>, <?= htmlspecialchars($location) ?>
                </p>
            <?php else: ?>
                <h2 class="text-2xl font-bold tracking-tight text-slate-900">Donor Search Results</h2>
                <p class="text-sm text-slate-400 mt-1.5 font-medium">Please adjust search criteria to access current emergency pools.</p>
            <?php endif; ?>
        </div>

        <div class="w-full overflow-x-auto custom-scrollbar">
            <table class="w-full border-collapse text-left text-sm whitespace-nowrap">
                <thead>
                    <tr class="border-b border-slate-100 text-xs font-bold uppercase tracking-wider text-slate-400">
                        <th class="py-4 px-2 w-1/4">Donor Name</th>
                        <th class="py-4 px-2 w-1/12">Blood</th>
                        <th class="py-4 px-2 w-1/3">Location</th>
                        <th class="py-4 px-2 w-1/6">Status</th>
                        <th class="py-4 px-2 text-center w-1/6">Action</th>
                    </tr>
                </thead>
                <tbody class="font-medium text-slate-700">
                    <?php if ($search_performed && !empty($donors)): ?>
                        <?php foreach ($donors as $donor):
                            $isActive = $donor['status'] === 'Active';
                        ?>
                            <tr class="border-b border-slate-50/60 hover:bg-slate-50/40">
                                <td class="py-5 px-2 font-bold text-slate-900">
                                    <?= htmlspecialchars($donor['name']) ?>
                                </td>
                                <td class="py-5 px-2 font-extrabold text-base text-red-500">
                                    <?= htmlspecialchars($donor['blood']) ?>
                                </td>
                                <td class="py-5 px-2 text-slate-500 font-normal">
                                    <?= htmlspecialchars($donor['location']) ?>
                                </td>
                                <td class="py-5 px-2 text-slate-600 font-normal">
                                    <div class="flex items-center gap-2.5">
                                        <span class="w-2.5 h-2.5 rounded-full <?= $isActive ? 'bg-emerald-400' : 'bg-amber-400' ?>"></span>
                                        <span><?= htmlspecialchars($donor['status']) ?></span>
                                    </div>
                                </td>
                                <td class="py-4 px-2 text-center">
                                    <?php if ($isActive): ?>
                                        <button type="button" onclick="triggerRequest('<?= htmlspecialchars($donor['name']) ?>', '<?= htmlspecialchars($donor['phone']) ?>')"
                                            class="w-full max-w-[120px] inline-flex items-center justify-center bg-[#c21824] hover:bg-[#a6121c] text-white font-medium py-1.5 px-4 rounded-md text-xs tracking-wide shadow-sm">
                                            Request
                                        </button>
                                    <?php else: ?>
                                        <button type="button" disabled
                                            class="w-full max-w-[120px] inline-flex items-center justify-center bg-[#6e7885] text-slate-100 font-medium py-1.5 px-4 rounded-md text-xs tracking-wide cursor-not-allowed opacity-90">
                                            Disabled
                                        </button>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="py-16 text-center text-slate-400 font-medium">
                                <div class="w-16 h-16 bg-slate-50 border border-slate-100 rounded-2xl flex items-center justify-center mx-auto mb-4 text-slate-400">
                                    <i class="fa-solid fa-folder-open text-xl text-slate-400/80"></i>
                                </div>
                                <p class="text-sm text-slate-600 font-bold mb-1">
                                    Awaiting search parameters...
                                </p>
                                <p class="text-xs text-slate-400 max-w-xs mx-auto font-medium">
                                    Fill out the filters above to find active donors instantly.
                                </p>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- JavaScript Actions -->
    <script>
        function triggerRequest(donorName, phoneNumber) {
            Swal.fire({
                title: 'Initiate Request?',
                text: `You are about to request emergency blood donation match support from ${donorName}.`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#c21824',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'Yes, Send Request',
                cancelButtonText: 'Cancel',
                customClass: {
                    popup: 'rounded-[2rem] p-6 font-sans',
                    confirmButton: 'rounded-xl font-bold px-5 py-3 text-sm',
                    cancelButton: 'rounded-xl font-bold px-5 py-3 text-sm'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Notification Sent!',
                        html: `A safe connection payload stream is routing to donor channel. Directly reach out via: <br><b class="text-[#c21824] text-lg">${phoneNumber}</b>`,
                        icon: 'success',
                        confirmButtonColor: '#0f172a',
                        customClass: {
                            popup: 'rounded-[2rem] p-6 font-sans',
                            confirmButton: 'rounded-xl font-bold px-5 py-3 text-sm'
                        }
                    });
                }
            });
        }

        document.getElementById("donorSearchForm").addEventListener("submit", function() {
            setTimeout(() => {
                const results = document.getElementById("donorResults");
                if (results) {
                    results.scrollIntoView({
                        behavior: "auto",
                        block: "start"
                    });
                }
            }, 150);
        });

        document.getElementById("searchForm").addEventListener("submit", function() {
            setTimeout(() => {
                const target = document.getElementById("donorResults");
                if (target) {
                    target.scrollIntoView({
                        behavior: "auto",
                        block: "start"
                    });
                }
            }, 100);
        });
    </script>
</body>

</html>