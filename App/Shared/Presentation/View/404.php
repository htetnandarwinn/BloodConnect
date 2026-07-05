<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Page Not Found</title>
    <!-- Tailwind CSS Engine -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- FontAwesome CDN for modern dynamic vector layout icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="bg-gray-50 flex items-center justify-center min-h-screen relative overflow-hidden antialiased">

    <!-- Modern Background Graphic Layers -->
    <div class="absolute right-0 bottom-0 w-full max-w-3xl pointer-events-none opacity-40 md:opacity-100 z-0 select-none">
        <svg viewBox="0 0 700 500" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg" class="w-full h-auto block">
            <path d="M700,170 C470,40 270,300 0,500 L700,500 Z" fill="#FCEAEF" />
        </svg>
    </div>

    <!-- Centered Card Layout Container -->
    <div class="relative z-10 w-full max-w-xl mx-auto px-6 text-center">
        
        <!-- Large Modern Droplet Identity Illustration Group -->
        <div class="inline-flex w-52 h-52 bg-white border border-gray-150/90 rounded-3xl p-6 items-center justify-center shadow-xl shadow-gray-100/40 mb-8 transform transition hover:scale-105 duration-300">
            <div class="relative w-full h-auto flex items-center justify-center">
                <!-- Drop Vector Grid Base Structure -->
                <svg viewBox="0 0 240 260" xmlns="http://www.w3.org/2000/svg" class="w-28 h-auto drop-shadow-md">
                    <path d="M120,30 C150,68 178,112 178,140 C178,170 152,192 120,192 C88,192 62,170 62,140 C62,112 90,68 120,30 Z" fill="#C8102E" />
                </svg>
                <!-- Modern Exclamation Alert overlay inside the droplet layout -->
                <span class="absolute inset-0 flex items-center justify-center text-white font-black text-4xl pt-4">!</span>
            </div>
        </div>

        <!-- Micro Identity Content Context Meta -->
        <h1 class="font-black text-7xl md:text-8xl text-gray-900 tracking-tight select-none">
            4<span class="text-red-600">0</span>4
        </h1>
        
        <h2 class="font-black text-2xl md:text-3xl text-gray-900 tracking-tight mt-4">
            Oops! Page not found
        </h2>
        
        <p class="text-base md:text-lg text-gray-500 font-medium mt-3 mb-8 max-w-md mx-auto leading-relaxed">
            The link you followed may be broken, or the page has been permanently removed within our platform environment.
        </p>

        <!-- Premium Navigation Anchor Dispatch Button -->
        <a href="/BloodConnect/home" 
           class="inline-flex group bg-red-600 hover:bg-red-700 text-white font-bold py-3.5 px-8 rounded-xl text-lg shadow-lg shadow-red-600/20 active:scale-[0.99] transition-all duration-150 items-center gap-2">
            <i class="fa-solid fa-arrow-left text-sm transform group-hover:-translate-x-1 transition-transform duration-200"></i>
            <span>Return Home</span>
        </a>

    </div>

</body>
</html>