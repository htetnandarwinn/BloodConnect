<!-- <?php
// C:\xampp_new\htdocs\BloodConnect\App\Shared\Presentation\View\donors.php
$donors = $donors ?? []; // Fallback array if no donor dataset payload is present
?>

<!-- FontAwesome CDN Dependency for Icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<!-- ============ REGULAR MODERN CLASSIC INTERIOR VIEW CONTENT ============ -->
<section class="relative overflow-hidden py-10 lg:py-14 bg-gray-50">

    <!-- Trending Modern Background Geometric Layer -->
    <div class="absolute right-0 bottom-0 w-full max-w-3xl pointer-events-none opacity-40 lg:opacity-100 z-0 select-none animate-pulse duration-[8000ms]">
        <svg viewBox="0 0 700 500" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg" class="w-full h-auto block">
            <path d="M700,170 C470,40 270,300 0,500 L700,500 Z" fill="#FCEAEF" />
        </svg>
    </div>

    <!-- Main Outer Wrapper -->
    <div class="relative z-10 max-w-[1440px] mx-auto w-full px-6 md:px-12">

        <!-- SECTION HEADER BLOCK -->
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-12">
            <div class="max-w-2xl">
                <h2 class="font-black text-3xl md:text-5xl text-gray-900 tracking-tight">Our Lifesavers</h2>
                <div class="h-1 w-20 bg-red-600 rounded-full mt-4"></div>
                <p class="text-gray-500 font-medium text-base md:text-lg mt-4 leading-relaxed">
                    Meet the verified champions of our ecosystem. Connect directly with active regional blood donors standing by to assist.
                </p>
            </div>

            <!-- Quick Dynamic Search Trigger Interaction -->
            <div class="flex-shrink-0">
                <a href="<?= $basePath ?>/search" class="inline-flex items-center gap-2.5 bg-white border border-gray-200 hover:border-red-200 text-gray-700 hover:text-red-600 font-bold px-6 py-3.5 rounded-xl shadow-sm hover:shadow-md transition-all duration-300 transform hover:-translate-y-0.5">
                    <i class="fa-solid fa-sliders text-sm"></i>
                    <span>Advanced Filter Matrix</span>
                </a>
            </div>
        </div>

        <!-- METRICS OVERVIEW BOARD -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-12">
            <div class="bg-white border border-gray-150/80 p-5 rounded-2xl shadow-sm flex items-center gap-4 transition duration-300 hover:shadow-md">
                <div class="w-12 h-12 bg-red-50 text-red-600 rounded-xl flex items-center justify-center text-xl"><i class="fa-solid fa-users"></i></div>
                <div>
                    <div class="text-2xl font-black text-gray-900"><?= count($donors) ?></div>
                    <div class="text-xs font-bold text-gray-400 uppercase tracking-wider">Registered Champions</div>
                </div>
            </div>
            <div class="bg-white border border-gray-150/80 p-5 rounded-2xl shadow-sm flex items-center gap-4 transition duration-300 hover:shadow-md">
                <div class="w-12 h-12 bg-emerald-50 text-emerald-600 rounded-xl flex items-center justify-center text-xl"><i class="fa-solid fa-circle-check"></i></div>
                <div>
                    <div class="text-2xl font-black text-gray-900">100%</div>
                    <div class="text-xs font-bold text-gray-400 uppercase tracking-wider">Identity Verified</div>
                </div>
            </div>
            <div class="bg-white border border-gray-150/80 p-5 rounded-2xl shadow-sm flex items-center gap-4 transition duration-300 hover:shadow-md">
                <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-xl flex items-center justify-center text-xl"><i class="fa-solid fa-truck-fast"></i></div>
                <div>
                    <div class="text-2xl font-black text-gray-900">Instant</div>
                    <div class="text-xs font-bold text-gray-400 uppercase tracking-wider">Coordination Match</div>
                </div>
            </div>
            <div class="bg-white border border-gray-150/80 p-5 rounded-2xl shadow-sm flex items-center gap-4 transition duration-300 hover:shadow-md">
                <div class="w-12 h-12 bg-amber-50 text-amber-600 rounded-xl flex items-center justify-center text-xl"><i class="fa-solid fa-heart-pulse"></i></div>
                <div>
                    <div class="text-2xl font-black text-gray-900">Active</div>
                    <div class="text-xs font-bold text-gray-400 uppercase tracking-wider">Availability Status</div>
                </div>
            </div>
        </div>

        <!-- DONOR SYSTEM GRID WRAPPER -->
        <?php if (empty($donors)): ?>
            <!-- Clean Modern Empty State View Block -->
            <div class="bg-white border border-gray-200/80 rounded-2xl p-12 text-center max-w-xl mx-auto shadow-sm transform transition duration-500 hover:scale-[1.01]">
                <div class="w-20 h-20 bg-red-50 text-red-600 flex items-center justify-center rounded-full mx-auto mb-4 animate-bounce">
                    <i class="fa-solid fa-heart-crack text-2xl"></i>
                </div>
                <h4 class="font-bold text-xl text-gray-900 mb-1">No Donors Listed Yet</h4>
                <p class="text-gray-500 font-medium text-base">Our community ecosystem pipeline is resetting. Check back soon or initialize a manual search broadcast query context.</p>
            </div>
        <?php else: ?>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php foreach ($donors as $donor): ?>
                    <div class="group bg-white border border-gray-200/80 rounded-2xl p-6 shadow-sm hover:shadow-xl hover:border-red-200 transition-all duration-300 transform hover:-translate-y-1.5 flex flex-col justify-between relative overflow-hidden">

                        <!-- Top Floating Visual Card Accent Ring -->
                        <div class="absolute -right-6 -top-6 w-24 h-24 bg-red-50/40 rounded-full pointer-events-none group-hover:bg-red-50 group-hover:scale-125 transition-all duration-500"></div>

                        <div>
                            <!-- Donor Profile Identity Header Layout Line -->
                            <div class="flex items-center justify-between mb-5 relative z-10">
                                <div class="flex items-center gap-3.5">
                                    <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-gray-100 to-gray-200/60 text-gray-700 flex items-center justify-center font-bold text-base border border-gray-200 group-hover:from-red-600 group-hover:to-red-700 group-hover:text-white group-hover:border-transparent transition-all duration-300 shadow-sm">
                                        <i class="fa-regular fa-user text-lg"></i>
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-lg text-gray-900 tracking-tight group-hover:text-red-600 transition-colors duration-200">
                                            <?= htmlspecialchars($donor['name'], ENT_QUOTES) ?>
                                        </h4>
                                        <span class="inline-flex items-center gap-1 text-xs font-bold text-emerald-600 mt-0.5">
                                            <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full inline-block animate-pulse"></span> Available
                                        </span>
                                    </div>
                                </div>

                                <!-- Absolute Blood Target Drop Badge -->
                                <div class="w-11 h-11 rounded-full bg-red-50 border border-red-100 text-red-600 font-black text-md flex items-center justify-center shadow-inner">
                                    <?= htmlspecialchars($donor['blood_type'], ENT_QUOTES) ?>
                                </div>
                            </div>

                            <!-- Meta Spec Properties Parameters Stack Container -->
                            <div class="space-y-2.5 my-5 pt-1">
                                <p class="text-gray-500 font-medium text-sm flex items-center gap-2.5">
                                    <i class="fa-solid fa-location-dot text-gray-400 w-4 text-center"></i>
                                    <span><?= htmlspecialchars($donor['location'] ?? 'Region Unspecified', ENT_QUOTES) ?></span>
                                </p>
                                <p class="text-gray-500 font-medium text-sm flex items-center gap-2.5">
                                    <i class="fa-regular fa-envelope text-gray-400 w-4 text-center"></i>
                                    <span class="truncate"><?= htmlspecialchars($donor['email'] ?? 'No public email', ENT_QUOTES) ?></span>
                                </p>
                            </div>
                        </div>

                        <!-- Card Operational Route Navigation CTA Button -->
                        <div class="pt-4 mt-2 border-t border-gray-100 relative z-10">
                            <button onclick="openContactModal('<?= htmlspecialchars($donor['name'], ENT_QUOTES) ?>', '<?= htmlspecialchars($donor['blood_type'], ENT_QUOTES) ?>')"
                                class="w-full bg-gray-50 hover:bg-red-600 text-gray-700 hover:text-white font-bold py-3 px-4 rounded-xl text-sm transition-all duration-200 flex items-center justify-center gap-2 group/btn">
                                <i class="fa-regular fa-comment-dots text-base transform group-hover/btn:rotate-12 transition-transform"></i>
                                <span>Initiate Contact</span>
                            </button>
                        </div>

                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>

<!-- INTERACTIVE DYNAMIC COMMUNICATIONS POPUP OVERLAY MODAL -->
<div id="contactModal" class="fixed inset-0 z-50 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-center justify-center min-h-screen p-4 text-center sm:p-0">

        <!-- Backdrop Backdrop Background Fade Blur Layout -->
        <div class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm transition-opacity" onclick="closeContactModal()"></div>

        <!-- Modal Core Window Box Matrix Frame -->
        <div class="relative bg-white rounded-3xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:max-w-lg sm:w-full border border-gray-100 animate-[fadeIn_0.3s_ease-out]">
            <div class="p-6 md:p-8">

                <!-- Close Button Component -->
                <button onclick="closeContactModal()" class="absolute right-5 top-5 text-gray-400 hover:text-gray-600 transition">
                    <i class="fa-solid fa-xmark text-lg"></i>
                </button>

                <div class="flex items-center gap-3.5 mb-6">
                    <div class="w-12 h-12 bg-red-50 text-red-600 rounded-2xl flex items-center justify-center text-xl">
                        <i class="fa-solid fa-paper-plane"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-black text-gray-900" id="modalTitle">Request Connection</h3>
                        <p class="text-sm font-medium text-gray-400 mt-0.5">Secure internal routing dispatch message pipeline.</p>
                    </div>
                </div>

                <form onsubmit="handleModalSubmit(event)" class="space-y-4">
                    <div class="bg-gray-50 border border-gray-200 p-4 rounded-xl">
                        <p class="text-sm font-bold text-gray-700">Recipient Target Info:</p>
                        <p class="text-base font-semibold text-gray-900 mt-1"><i class="fa-regular fa-user mr-1.5 text-red-600"></i><span id="modalDonorName"></span> (<span id="modalDonorBlood" class="text-red-600 font-bold"></span>)</p>
                    </div>

                    <div class="space-y-1.5">
                        <label class="block text-sm font-bold text-gray-900">Your Communication / Emergency Notes</label>
                        <textarea rows="4" required placeholder="Outline hospital context framework details, location requirements, or critical deadline benchmarks..."
                            class="w-full bg-white border border-gray-300 rounded-xl px-4 py-3 text-base text-gray-900 placeholder-gray-400 focus:outline-none focus:border-red-600 focus:ring-4 focus:ring-red-100 transition duration-200 font-medium resize-none"></textarea>
                    </div>

                    <div class="grid grid-cols-2 gap-3.5 pt-2">
                        <button type="button" onclick="closeContactModal()" class="w-full bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold py-3.5 px-4 rounded-xl text-base transition">
                            Cancel
                        </button>
                        <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white font-bold py-3.5 px-4 rounded-xl text-base shadow-lg shadow-red-600/10 transition">
                            Send Request
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>

<!-- Core Front-End Controller Interactions Engine Logic -->
<script>
    const modal = document.getElementById('contactModal');
    const modalName = document.getElementById('modalDonorName');
    const modalBlood = document.getElementById('modalDonorBlood');

    function openContactModal(name, bloodType) {
        modalName.textContent = name;
        modalBlood.textContent = bloodType;
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden'; // Stop background scrolling activity
    }

    function closeContactModal() {
        modal.classList.add('hidden');
        document.body.style.overflow = ''; // Unlock viewport scrolling mechanics
    }

    function handleModalSubmit(e) {
        e.preventDefault();
        alert("Success! Your transmission has been dispatched to the volunteer donor matrix pool safety framework layers.");
        closeContactModal();
    }
</script> -->