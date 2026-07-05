<?php
// C:\xampp_new\htdocs\BloodConnect\App\Shared\Presentation\View\search.php
$donors = $donors ?? []; // Fallback array if no search has been queried yet
?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<section class="relative overflow-hidden py-10 lg:py-14 bg-gray-50">

    <div class="absolute right-0 bottom-0 w-full max-w-3xl pointer-events-none opacity-40 lg:opacity-100 z-0 select-none animate-pulse duration-[8000ms]">
        <svg viewBox="0 0 700 500" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg" class="w-full h-auto block">
            <path d="M700,170 C470,40 270,300 0,500 L700,500 Z" fill="#FCEAEF" />
        </svg>
    </div>

    <div class="relative z-10 max-w-[1440px] mx-auto w-full px-6 md:px-12">

        <div class="max-w-2xl mb-10 lg:mb-12">
            <h2 class="font-black text-3xl md:text-5xl text-gray-900 tracking-tight">Find Donors</h2>
            <div class="h-1 w-20 bg-red-600 rounded-full mt-4"></div>
            <p class="text-gray-500 font-medium text-base md:text-lg mt-4 leading-relaxed">
                Scan our live peer database parameters to match with active emergency groups within your territory.
            </p>
        </div>

        <div class="bg-white border border-gray-150/90 rounded-2xl p-6 md:p-8 shadow-xl shadow-gray-100/50 mb-12 transition-all duration-500 hover:shadow-2xl hover:shadow-gray-200/40">
            <form method="GET" action="<?= $basePath ?>/search" class="grid grid-cols-1 md:grid-cols-12 gap-5 items-end">

                <div class="md:col-span-4 space-y-2">
                    <label class="block text-base font-bold text-gray-900">Blood Type Required</label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-red-600 pointer-events-none text-lg">
                            <i class="fa-solid fa-droplet"></i>
                        </span>
                        <select name="blood_type" class="w-full bg-gray-50 border border-gray-200 rounded-xl pl-12 pr-10 py-3.5 text-base text-gray-900 font-medium focus:bg-white focus:outline-none focus:border-red-600 focus:ring-4 focus:ring-red-100 transition duration-200 appearance-none">
                            <option value="">All Blood Types</option>
                            <?php foreach (['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'] as $type): ?>
                                <option value="<?= $type ?>" <?= isset($_GET['blood_type']) && $_GET['blood_type'] === $type ? 'selected' : '' ?>><?= $type ?></option>
                            <?php endforeach; ?>
                        </select>
                        <span class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none">
                            <i class="fa-solid fa-chevron-down text-sm"></i>
                        </span>
                    </div>
                </div>

                <div class="md:col-span-5 space-y-2">
                    <label class="block text-base font-bold text-gray-900">Location Area / City</label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-red-600 pointer-events-none text-lg">
                            <i class="fa-solid fa-location-dot"></i>
                        </span>
                        <input type="text" name="location" placeholder="e.g., Downtown or Community City" value="<?= htmlspecialchars($_GET['location'] ?? '', ENT_QUOTES) ?>"
                            class="w-full bg-gray-50 border border-gray-200 rounded-xl pl-12 pr-4 py-3.5 text-base text-gray-900 placeholder-gray-400 font-medium focus:bg-white focus:outline-none focus:border-red-600 focus:ring-4 focus:ring-red-100 transition duration-200">
                    </div>
                </div>

                <div class="md:col-span-3">
                    <button type="submit" class="w-full group bg-red-600 hover:bg-red-700 text-white font-bold py-3.5 px-6 rounded-xl text-lg shadow-lg shadow-red-600/20 active:scale-[0.99] transition-all duration-150 flex items-center justify-center gap-2">
                        <i class="fa-solid fa-magnifying-glass text-sm transform group-hover:scale-110 transition-transform duration-200"></i>
                        <span>Search Database</span>
                    </button>
                </div>

            </form>
        </div>

        <div>
            <h3 class="font-black text-xl md:text-2xl text-gray-900 tracking-tight mb-6 flex items-center gap-2.5">
                <span>Matching Donor Profiles</span>
                <span class="text-sm bg-gray-200/70 text-gray-700 px-2.5 py-0.5 rounded-full font-bold"><?= count($donors) ?> Found</span>
            </h3>

            <?php if (empty($donors)): ?>
                <div class="bg-white border border-gray-200/80 rounded-2xl p-12 text-center max-w-xl mx-auto shadow-sm transform transition duration-500 hover:scale-[1.01]">
                    <div class="w-20 h-20 bg-red-50 text-red-600 flex items-center justify-center rounded-full mx-auto mb-4 animate-pulse">
                        <i class="fa-solid fa-users-slash text-2xl"></i>
                    </div>
                    <h4 class="font-bold text-xl text-gray-900 mb-1">No Active Donors Found</h4>
                    <p class="text-gray-500 font-medium text-base">Try adjusting your blood type requirement filter or widening your geolocation matrix radius parameters.</p>
                </div>
            <?php else: ?>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <?php foreach ($donors as $donor): ?>
                        <div class="group bg-white border border-gray-200/80 rounded-2xl p-6 shadow-sm hover:shadow-xl hover:border-red-200 transition-all duration-300 transform hover:-translate-y-1 flex flex-col justify-between">

                            <div>
                                <div class="flex items-center justify-between mb-4">
                                    <div class="w-12 h-12 rounded-full bg-red-50 text-red-600 flex items-center justify-center font-black text-xl border border-red-100 group-hover:bg-red-600 group-hover:text-white transition-colors duration-300 shadow-sm">
                                        <?= htmlspecialchars($donor['blood_type'], ENT_QUOTES) ?>
                                    </div>
                                    <span class="inline-flex items-center gap-1.5 bg-emerald-50 text-emerald-700 px-3 py-1 rounded-full text-xs font-bold border border-emerald-100">
                                        <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full animate-ping"></span> Active Now
                                    </span>
                                </div>

                                <h4 class="font-bold text-lg text-gray-900 group-hover:text-red-600 transition-colors duration-200">
                                    <?= htmlspecialchars($donor['name'], ENT_QUOTES) ?>
                                </h4>

                                <p class="text-gray-500 font-medium text-sm mt-1.5 flex items-center gap-2">
                                    <i class="fa-solid fa-location-dot text-gray-400 w-4"></i>
                                    <span><?= htmlspecialchars($donor['location'] ?? 'Not Specified', ENT_QUOTES) ?></span>
                                </p>
                            </div>

                            <div class="pt-6 mt-6 border-t border-gray-100">
                                <a href="<?= $basePath ?>/donors/profile?id=<?= $donor['id'] ?>"
                                    class="w-full bg-gray-50 hover:bg-red-50 hover:text-red-600 text-gray-700 font-bold py-2.5 px-4 rounded-xl text-sm transition-all duration-200 flex items-center justify-center gap-1.5 group/btn">
                                    <span>Request Coordination</span>
                                    <i class="fa-solid fa-chevron-right text-xs transform group-hover/btn:translate-x-1 transition-transform"></i>
                                </a>
                            </div>

                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?> <!-- Changed from endforeach to endif -->
        </div>

    </div>
</section>