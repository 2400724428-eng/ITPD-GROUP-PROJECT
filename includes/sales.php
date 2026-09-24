<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gym Supplements Flash Sale Banner</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body >

    <!-- 100% SCREEN WIDTH EDGE-TO-EDGE BANNER WITH BLUE FILTER -->
    <div class="relative w-screen h-[120px] md:h-[140px] overflow-hidden bg-blue-950 border-y border-blue-900/50">
        
        <!-- Video covering 100% width and height completely from side to side -->
        <video src="assets/images/qq.mp4" autoplay muted loop playsinline class="absolute inset-0 w-full h-full object-cover"></video>
        
        <!-- Blue Filter & Dark Gradient Overlay for text readability -->
        <div class="absolute inset-0 bg-gradient-to-r from-blue-950/90 via-blue-900/60 to-black/40 mix-blend-multiply"></div>
        <div class="absolute inset-0 bg-black/40"></div>

        <!-- Content in front of the video -->
        <div class="relative z-10 h-full flex flex-col justify-center px-4 md:px-12 w-full text-left">
            <div class="inline-flex items-center gap-1.5 px-2.5 py-0.5 mb-1 text-[8px] font-black tracking-wider text-black uppercase bg-blue-400 rounded-full animate-pulse shadow-md shadow-blue-500/50 w-max">
                <i data-lucide="zap" class="w-3 h-3 fill-current"></i> FLASH SALE
            </div>
            <h2 class="text-lg md:text-xl font-black text-white tracking-tight mb-0.5 drop-shadow-md leading-tight">
                UNLEASH YOUR <span class="text-blue-400">MAXIMUM GAINS</span>
            </h2>
            <p class="text-blue-100 text-[11px] mb-2 font-medium max-w-sm md:max-w-md truncate">
                Get premium imported protein & pre-workouts at unbeatable prices.
            </p>
            <div>
                <a href="#shop" class="inline-flex items-center gap-1.5 px-3 py-1 bg-blue-600 hover:bg-blue-500 text-white text-[11px] font-extrabold rounded-md transition shadow-md shadow-blue-600/30">
                    Shop Deals <i data-lucide="arrow-right" class="w-3 h-3"></i>
                </a>
            </div>
        </div>

    </div>

    <!-- Initialize Lucide Icons -->
    <script>
        lucide.createIcons();
    </script>
</body>
</html>