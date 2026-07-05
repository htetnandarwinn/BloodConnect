<?php
// C:\xampp_new\htdocs\BloodConnect\App\Shared\Presentation\View\contact.php
$errors = $_SESSION['errors'] ?? [];
$success = $_SESSION['success'] ?? '';
$old = $_SESSION['old'] ?? [];
unset($_SESSION['errors'], $_SESSION['success'], $_SESSION['old']);
?>

<!-- FontAwesome Dependency Matrix for Form Component Icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<!-- ============ REGULAR MODERN CLASSIC INTERIOR VIEW CONTENT ============ -->
<section class="relative overflow-hidden pt-4 pb-24 lg:pt-8 lg:pb-36 bg-gray-50">

    <!-- Dynamic Decorative Fluid Blobs -->
    <div class="absolute right-[-10%] top-[-10%] w-[500px] h-[500px] rounded-full bg-red-100/40 blur-3xl pointer-events-none z-0"></div>
    <div class="absolute left-[-5%] bottom-[-5%] w-[400px] h-[400px] rounded-full bg-rose-100/30 blur-3xl pointer-events-none z-0"></div>

    <!-- Main Outer Wrapper -->
    <div class="relative z-10 max-w-[1440px] mx-auto w-full px-6 md:px-12">

        <!-- SECTION HEADER BLOCK -->
        <div class="max-w-2xl mb-10 lg:mb-14">
            <h2 class="font-black text-4xl md:text-5xl text-gray-900 tracking-tight">Contact Us</h2>
            <div class="h-1 w-16 bg-red-600 rounded-full mt-4 shadow-sm shadow-red-600/30"></div>
        </div>

        <!-- MAIN DUAL COLUMN CONFIGURATION MATRIX (Using items-start to resolve the empty space bug from edited-image_3.png) -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">

            <!-- Left Side Column: Modern Immersive Dark Info Block -->
            <div class="lg:col-span-4 bg-gray-900 text-white rounded-3xl p-8 shadow-xl shadow-gray-900/10 space-y-8 flex flex-col justify-between min-h-[540px]">
                <div>
                    <h3 class="font-black text-2xl tracking-tight text-white mb-3">Connection Hub</h3>
                    <p class="text-gray-400 text-sm font-medium leading-relaxed">
                        Have queries regarding emergency channels, platform security matrixes, or routing criteria? Reach out directly.
                    </p>
                </div>

                <!-- Interactive Connect Info Links Stack -->
                <div class="space-y-6">
                    <div class="flex items-center gap-4 group">
                        <div class="w-11 h-11 rounded-xl bg-white/10 flex items-center justify-center text-red-400 group-hover:bg-red-600 group-hover:text-white transition-all duration-300 shadow-sm">
                            <i class="fa-solid fa-location-dot text-base"></i>
                        </div>
                        <div>
                            <p class="text-[11px] font-bold text-gray-500 uppercase tracking-wider">Central Hub</p>
                            <p class="text-gray-200 text-sm font-semibold">123 BloodConnect Plaza, Medical Lane</p>
                        </div>
                    </div>

                    <div class="flex items-center gap-4 group">
                        <div class="w-11 h-11 rounded-xl bg-white/10 flex items-center justify-center text-red-400 group-hover:bg-red-600 group-hover:text-white transition-all duration-300 shadow-sm">
                            <i class="fa-solid fa-envelope text-base"></i>
                        </div>
                        <div>
                            <p class="text-[11px] font-bold text-gray-500 uppercase tracking-wider">Digital Support</p>
                            <p class="text-gray-200 text-sm font-semibold">support@bloodconnect.example.com</p>
                        </div>
                    </div>

                    <div class="flex items-center gap-4 group">
                        <div class="w-11 h-11 rounded-xl bg-white/10 flex items-center justify-center text-red-400 group-hover:bg-red-600 group-hover:text-white transition-all duration-300 shadow-sm">
                            <i class="fa-solid fa-phone text-base"></i>
                        </div>
                        <div>
                            <p class="text-[11px] font-bold text-gray-500 uppercase tracking-wider">Emergency Dispatch</p>
                            <p class="text-gray-200 text-sm font-semibold">+1 (555) 019-2834</p>
                        </div>
                    </div>
                </div>

                <!-- Social Media Footprint Link Tags -->
                <div class="pt-4 border-t border-white/10 flex items-center gap-4 text-gray-400">
                    <span class="text-xs font-bold uppercase tracking-wider">Follow Us:</span>
                    <a href="#" class="hover:text-white transition-colors"><i class="fa-brands fa-facebook-f"></i></a>
                    <a href="#" class="hover:text-white transition-colors"><i class="fa-brands fa-x-twitter"></i></a>
                    <a href="#" class="hover:text-white transition-colors"><i class="fa-brands fa-linkedin-in"></i></a>
                </div>
            </div>

            <!-- Right Side Column: Modernized Messaging Panel (Stretches smoothly to top alignment edge) -->
            <div class="lg:col-span-8 w-full pt-0">
                <div class="bg-white border border-gray-200/80 rounded-3xl p-8 md:p-10 shadow-xl shadow-gray-200/40 w-full transition-all duration-500 hover:shadow-2xl">
                    <h3 class="font-black text-2xl md:text-3xl text-gray-900 tracking-tight mb-2">Send a Message</h3>
                    <p class="text-sm md:text-base text-gray-500 font-medium mb-6 leading-relaxed">
                        Fill out the routing ticket configuration below, and an officer will sync with you directly.
                    </p>

                    <!-- Alert Banners Grid -->
                    <?php if (!empty($success)): ?>
                        <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 rounded-xl">
                            <p class="text-emerald-700 text-sm font-semibold flex items-center gap-2">
                                <i class="fa-solid fa-circle-check"></i> <?= htmlspecialchars($success, ENT_QUOTES) ?>
                            </p>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($errors) && isset($errors['form'])): ?>
                        <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-xl">
                            <p class="text-red-600 text-sm font-semibold flex items-center gap-2">
                                <i class="fa-solid fa-circle-exclamation"></i> <?= htmlspecialchars($errors['form'], ENT_QUOTES) ?>
                            </p>
                        </div>
                    <?php endif; ?>

                    <!-- Action form mapping -->
                    <form id="altContactForm" novalidate method="post" action="<?= $basePath ?>/contact/send" class="space-y-5">

                        <!-- Grid Row: Name and Email Input Modules -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div class="space-y-1.5">
                                <label class="block text-xs font-black uppercase tracking-wider text-gray-500">Your Name</label>
                                <div class="relative">
                                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-base">
                                        <i class="fa-regular fa-user"></i>
                                    </span>
                                    <input type="text" id="altName" name="name" placeholder="John Doe"
                                        value="<?= htmlspecialchars($old['name'] ?? '', ENT_QUOTES) ?>" required
                                        class="w-full bg-gray-50 border border-gray-200 rounded-xl pl-11 pr-4 py-3 text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:border-red-600 focus:bg-white focus:ring-4 focus:ring-red-100 transition duration-200 font-medium">
                                </div>
                                <p class="hidden text-red-600 text-xs font-semibold mt-1 items-center gap-1" id="altNameError">
                                    <i class="fa-solid fa-circle-exclamation"></i> Full name is required.
                                </p>
                            </div>

                            <div class="space-y-1.5">
                                <label class="block text-xs font-black uppercase tracking-wider text-gray-500">Email Address</label>
                                <div class="relative">
                                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-base">
                                        <i class="fa-regular fa-envelope"></i>
                                    </span>
                                    <input type="email" id="altEmail" name="email" placeholder="name@example.com"
                                        value="<?= htmlspecialchars($old['email'] ?? '', ENT_QUOTES) ?>" required
                                        class="w-full bg-gray-50 border border-gray-200 rounded-xl pl-11 pr-4 py-3 text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:border-red-600 focus:bg-white focus:ring-4 focus:ring-red-100 transition duration-200 font-medium">
                                </div>
                                <p class="hidden text-red-600 text-xs font-semibold mt-1 items-center gap-1" id="altEmailError">
                                    <i class="fa-solid fa-circle-exclamation"></i> A valid email is required.
                                </p>
                            </div>
                        </div>

                        <!-- Subject Frame Module -->
                        <div class="space-y-1.5">
                            <label class="block text-xs font-black uppercase tracking-wider text-gray-500">Subject Title</label>
                            <div class="relative">
                                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-base">
                                    <i class="fa-regular fa-bookmark"></i>
                                </span>
                                <input type="text" id="altSubject" name="subject" placeholder="What is this regarding?"
                                    value="<?= htmlspecialchars($old['subject'] ?? '', ENT_QUOTES) ?>" required
                                    class="w-full bg-gray-50 border border-gray-200 rounded-xl pl-11 pr-4 py-3 text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:border-red-600 focus:bg-white focus:ring-4 focus:ring-red-100 transition duration-200 font-medium">
                            </div>
                            <p class="hidden text-red-600 text-xs font-semibold mt-1 items-center gap-1" id="altSubjectError">
                                <i class="fa-solid fa-circle-exclamation"></i> Please specify a clear subject.
                            </p>
                        </div>

                        <!-- Message Block Text Area Module -->
                        <div class="space-y-1.5">
                            <label class="block text-xs font-black uppercase tracking-wider text-gray-500">Message Description</label>
                            <div class="relative">
                                <span class="absolute left-4 top-3.5 text-gray-400 text-base">
                                    <i class="fa-regular fa-comment-dots"></i>
                                </span>
                                <textarea id="altMessage" name="message" rows="4" placeholder="Type your dynamic support transmission details here..." required
                                    class="w-full bg-gray-50 border border-gray-200 rounded-xl pl-11 pr-4 py-3 text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:border-red-600 focus:bg-white focus:ring-4 focus:ring-red-100 transition duration-200 font-medium resize-none"><?= htmlspecialchars($old['message'] ?? '', ENT_QUOTES) ?></textarea>
                            </div>
                            <p class="hidden text-red-600 text-xs font-semibold mt-1 items-center gap-1" id="altMessageError">
                                <i class="fa-solid fa-circle-exclamation"></i> Message cannot be blank.
                            </p>
                        </div>

                        <!-- Submission Trigger Core Button -->
                        <div class="pt-2">
                            <button type="submit" class="w-full bg-gradient-to-r from-red-600 to-rose-600 hover:from-red-700 hover:to-rose-700 text-white font-bold py-3.5 px-6 rounded-xl text-base shadow-md shadow-red-600/10 active:scale-[0.99] transition duration-150 flex items-center justify-center gap-2">
                                <i class="fa-regular fa-paper-plane text-sm"></i> Dispatch Transmission
                            </button>
                        </div>

                    </form>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- Validation Module Script Component -->
<script>
    document.getElementById("altContactForm").addEventListener("submit", function(e) {
        const name = document.getElementById("altName");
        const email = document.getElementById("altEmail");
        const subject = document.getElementById("altSubject");
        const message = document.getElementById("altMessage");

        const nameError = document.getElementById("altNameError");
        const emailError = document.getElementById("altEmailError");
        const subjectError = document.getElementById("altSubjectError");
        const messageError = document.getElementById("altMessageError");

        let formIsValid = true;

        const checkInput = (input, errorEl, condition) => {
            if (condition) {
                input.classList.add("border-red-500", "focus:ring-red-100");
                errorEl.classList.replace("hidden", "flex");
                formIsValid = false;
            } else {
                input.classList.remove("border-red-500", "focus:ring-red-100");
                errorEl.classList.replace("flex", "hidden");
            }
        };

        checkInput(name, nameError, !name.value.trim());
        checkInput(email, emailError, (!email.value.trim() || !email.value.includes('@')));
        checkInput(subject, subjectError, !subject.value.trim());
        checkInput(message, messageError, !message.value.trim());

        if (!formIsValid) {
            e.preventDefault();
        }
    });
</script>