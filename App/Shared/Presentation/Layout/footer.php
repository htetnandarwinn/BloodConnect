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
                <p class="text-gray-400 text-base leading-relaxed max-w-sm mt-2">
                    Connecting voluntary blood donors with patients in need quickly and safely. Join us in making a lifesaving difference today.
                </p>
                <div class="flex items-center gap-3 mt-2">
                    <a href="#" class="w-11 h-11 rounded-xl bg-gray-800 flex items-center justify-center text-gray-400 hover:bg-red-600 hover:text-white transition-all duration-300 text-lg">
                        <i class="fa-brands fa-facebook-f"></i>
                    </a>
                    <a href="#" class="w-11 h-11 rounded-xl bg-gray-800 flex items-center justify-center text-gray-400 hover:bg-red-600 hover:text-white transition-all duration-300 text-lg">
                        <i class="fa-brands fa-twitter"></i>
                    </a>
                    <a href="#" class="w-11 h-11 rounded-xl bg-gray-800 flex items-center justify-center text-gray-400 hover:bg-red-600 hover:text-white transition-all duration-300 text-lg">
                        <i class="fa-brands fa-instagram"></i>
                    </a>
                    <a href="#" class="w-11 h-11 rounded-xl bg-gray-800 flex items-center justify-center text-gray-400 hover:bg-red-600 hover:text-white transition-all duration-300 text-lg">
                        <i class="fa-brands fa-linkedin-in"></i>
                    </a>
                </div>
            </div>

            <div class="lg:col-span-2 flex flex-col gap-4">
                <h3 class="text-white font-bold text-lg tracking-wider uppercase text-sm">Navigation</h3>
                <ul class="flex flex-col gap-3 text-base">
                    <li><a href="<?= $basePath ?>/" class="hover:text-red-500 transition-colors duration-200">Home</a></li>
                    <li><a href="<?= $basePath ?>/about" class="hover:text-red-500 transition-colors duration-200">About Us</a></li>
                    <li><a href="<?= $basePath ?>/search-donor" class="hover:text-red-500 transition-colors duration-200">Search Donor</a></li>
                    <li><a href="<?= $basePath ?>/blood-request" class="hover:text-red-500 transition-colors duration-200">Blood Requests</a></li>
                    <li><a href="<?= $basePath ?>/donors" class="hover:text-red-500 transition-colors duration-200">Donors</a></li>
                </ul>
            </div>

            <div class="lg:col-span-2 flex flex-col gap-4">
                <h3 class="text-white font-bold text-lg tracking-wider uppercase text-sm">Support</h3>
                <ul class="flex flex-col gap-3 text-base">
                    <li><a href="<?= $basePath ?>/contact" class="hover:text-red-500 transition-colors duration-200">Contact Us</a></li>
                    <li><a href="#" class="hover:text-red-500 transition-colors duration-200">FAQ</a></li>
                    <li><a href="#" class="hover:text-red-500 transition-colors duration-200">Privacy Policy</a></li>
                    <li><a href="#" class="hover:text-red-500 transition-colors duration-200">Terms of Service</a></li>
                </ul>
            </div>

            <div class="lg:col-span-4 flex flex-col gap-4">
                <h3 class="text-white font-bold text-lg tracking-wider uppercase text-sm">Stay Updated</h3>
                <p class="text-gray-400 text-base leading-relaxed">
                    Subscribe to receive local blood drive notifications and community metrics.
                </p>
                <form class="flex flex-col sm:flex-row gap-3 mt-2 w-full" onsubmit="event.preventDefault();">
                    <input type="email" placeholder="Your email address" required
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
                <span>Designed for life-saving connectivity.</span>
            </div>
        </div>

    </div>
</footer>