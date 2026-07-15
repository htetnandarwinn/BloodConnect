<footer class="bg-gray-900 text-gray-300 pt-16 pb-8 border-t border-gray-800">
    <div class="max-w-[1440px] mx-auto w-full px-6 md:px-12">

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-12 gap-12 pb-12 border-b border-gray-800">

            <div class="lg:col-span-4 flex flex-col gap-5">
                <a href="<?= $basePath ?>/" class="flex items-center gap-3">
                    <div class="text-red-500 text-4xl">
                        <i class="fa-solid fa-droplet"></i>
                    </div>
                    <div>
                        <h2 class="font-black text-2xl text-white tracking-tight">BloodConnect</h2>
                        <p class="text-sm text-gray-400 font-medium tracking-wide">Donate Blood, Save Lives</p>
                    </div>
                </a>
                <!-- <p class="text-gray-400 text-base leading-relaxed max-w-sm mt-2">
                    Connecting voluntary blood donors with patients in need quickly and safely. Join us in making a lifesaving difference today.
                </p> -->


                <div class="space-y-4">

                    <!-- Email -->
                    <div class="flex items-center gap-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-white flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3 8l9 6 9-6M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        <span class="text-white">bloodconnect.support@gmail.com</span>
                    </div>

                    <!-- Location -->
                    <div class="flex items-center gap-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-white flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M17.657 16.657L13.414 20.9a2 2 0 01-2.828 0l-4.243-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        <span class="text-white">Ywadan, Yamethin, Myanmar</span>
                    </div>

                    <!-- Phone -->
                    <div class="flex items-center gap-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-white flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.129a11.042 11.042 0 005.516 5.516l1.129-2.257a1 1 0 011.21-.502l4.493 1.498A1 1 0 0121 15.72V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                        </svg>
                        <span class="text-white">09752491443</span>
                    </div>

                </div>
                <div class="flex items-center gap-3 mt-2">
                    <a href="https://facebook.com/BloodConnect" target="_blank" rel="noopener noreferrer" class="w-11 h-11 rounded-xl bg-gray-800 flex items-center justify-center text-gray-400 hover:bg-red-600 hover:text-white transition-all duration-300 text-lg">
                        <i class="fa-brands fa-facebook-f"></i>
                    </a>
                    <a href="https://twitter.com/BloodConnect" target="_blank" rel="noopener noreferrer" class="w-11 h-11 rounded-xl bg-gray-800 flex items-center justify-center text-gray-400 hover:bg-red-600 hover:text-white transition-all duration-300 text-lg">
                        <i class="fa-brands fa-twitter"></i>
                    </a>
                    <a href="https://instagram.com/BloodConnect" target="_blank" rel="noopener noreferrer" class="w-11 h-11 rounded-xl bg-gray-800 flex items-center justify-center text-gray-400 hover:bg-red-600 hover:text-white transition-all duration-300 text-lg">
                        <i class="fa-brands fa-instagram"></i>
                    </a>
                    <a href="https://linkedin.com/company/BloodConnect" target="_blank" rel="noopener noreferrer" class="w-11 h-11 rounded-xl bg-gray-800 flex items-center justify-center text-gray-400 hover:bg-red-600 hover:text-white transition-all duration-300 text-lg">
                        <i class="fa-brands fa-linkedin-in"></i>
                    </a>
                </div>
            </div>

            <div class="lg:col-span-2 flex flex-col gap-4">
                <h3 class="text-white font-bold text-lg tracking-wider uppercase text-sm">Navigation</h3>
                <ul class="flex flex-col gap-3 text-base">
                    <li><a href="<?= $basePath ?>/" class="hover:text-red-500 transition-colors duration-200">Home</a></li>
                    <li><a href="<?= $basePath ?>/about" class="hover:text-red-500 transition-colors duration-200">About Us</a></li>
                    <li><a href="<?= $basePath ?>/register" class="hover:text-red-500 transition-colors duration-200">Search Donor</a></li>
                    <li><a href="<?= $basePath ?>/register" class="hover:text-red-500 transition-colors duration-200">Blood Requests</a></li>

                </ul>
            </div>

            <div class="lg:col-span-2 flex flex-col gap-4">
                <h3 class="text-white font-bold text-lg tracking-wider uppercase text-sm">Support</h3>
                <ul class="flex flex-col gap-3 text-base">
                    <li><a href="<?= $basePath ?>/contact" class="hover:text-red-500 transition-colors duration-200">Contact Us</a></li>
                    <li><a href="<?= $basePath ?>/faq" class="hover:text-red-500 transition-colors duration-200">FAQ</a></li>
                    <li><a href="<?= $basePath ?>/privacy-policy" class="hover:text-red-500 transition-colors duration-200">Privacy Policy</a></li>
                    <li><a href="<?= $basePath ?>/terms-of-service" class="hover:text-red-500 transition-colors duration-200">Terms of Service</a></li>
                </ul>
            </div>

            <div class="lg:col-span-4 flex flex-col gap-4">
                <h3 class="text-white font-bold text-lg tracking-wider uppercase text-sm">Stay Updated</h3>
                <p class="text-gray-400 text-base leading-relaxed">
                    Subscribe to receive local blood drive notifications and community metrics.
                </p>
                <form class="flex flex-col sm:flex-row gap-3 mt-2 w-full" action="<?= $basePath ?>/register" method="GET">
                    <input type="email" name="email" placeholder="Your email address" required
                        class="w-full bg-gray-800 text-white border border-gray-750 px-4 py-3 rounded-xl focus:outline-none focus:border-red-500 transition text-base">
                    <button type="submit"
                        class="bg-red-600 hover:bg-red-700 text-white font-bold px-6 py-3 rounded-xl transition duration-200 whitespace-nowrap text-base">
                        Subscribe
                    </button>
                </form>
            </div>

        </div>

        <div class="pt-8 flex flex-col sm:flex-row justify-between items-center gap-4 text-sm text-gray-500 font-medium">
            <p>&copy; <?= date('Y') ?> BloodConnect. All rights reserved.</p>
            <div class="flex gap-6">
                <span>Connecting donors with patients to save lives.</span>
            </div>
        </div>

    </div>
</footer>