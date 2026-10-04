<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Gaming Promotion &amp; Newsletter</title>
    
    <!-- Browser Tab Logo (Favicon) - Replace with your image link or file name -->
    <link rel="icon" type="image/png" href="assets/images/fav.png"/>

    <!-- Tailwind CSS CDN with forms plugin -->
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <!-- Google Fonts: Plus Jakarta Sans / Inter -->
    <link href="https://fonts.googleapis.com" rel="preconnect"/>
    <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect"/>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&amp;display=swap" rel="stylesheet"/>
</head>
<body class="bg-slate-950 text-slate-100 font-['Plus_Jakarta_Sans',sans-serif] min-h-screen flex flex-col justify-between">

    <!-- Header -->
    <header class="w-full border-b border-slate-800 bg-slate-900/60 backdrop-blur sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <span class="text-xl font-extrabold tracking-wider bg-gradient-to-r from-indigo-400 to-cyan-400 bg-clip-text text-transparent">
                    NEXUS GAMING
                </span>
            </div>
            <nav class="hidden md:flex items-center gap-6 text-sm font-medium text-slate-400">
                <a href="#" class="hover:text-indigo-400 transition-colors">Home</a>
                <a href="#" class="hover:text-indigo-400 transition-colors">Promotions</a>
                <a href="#" class="hover:text-indigo-400 transition-colors">Tournaments</a>
                <a href="#" class="hover:text-indigo-400 transition-colors">Newsletter</a>
            </nav>
        </div>
    </header>

    <!-- Main Content Section -->
    <main class="flex-grow flex items-center justify-center px-4 py-16">
        <div class="text-center max-w-2xl mx-auto space-y-6">
            <span class="px-3 py-1 text-xs font-semibold uppercase tracking-widest bg-indigo-500/10 text-indigo-400 rounded-full border border-indigo-500/20">
                Season 4 Live Now
            </span>
            <h1 class="text-4xl sm:text-6xl font-extrabold tracking-tight">
                Level Up Your <span class="text-indigo-500">Gaming Experience</span>
            </h1>
            <p class="text-slate-400 text-lg">
                Subscribe to our newsletter for exclusive game drops, beta keys, and weekly tournament updates straight to your inbox.
            </p>

            <!-- Newsletter Signup Form -->
            <form class="flex flex-col sm:flex-row gap-3 max-w-md mx-auto pt-4" onsubmit="event.preventDefault(); alert('Thanks for subscribing!');">
                <input type="email" 
                       placeholder="Enter your email address..." 
                       required
                       class="flex-grow bg-slate-900 border border-slate-800 rounded-xl px-4 py-3 text-slate-100 placeholder:text-slate-500 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                <button type="submit" 
                        class="bg-indigo-600 hover:bg-indigo-500 text-white font-semibold px-6 py-3 rounded-xl transition-all shadow-lg shadow-indigo-600/30">
                    Subscribe
                </button>
            </form>
        </div>
    </main>

    <!-- Footer -->
    <footer class="border-t border-slate-900 py-6 text-center text-xs text-slate-600">
        &copy; 2026 Nexus Gaming. All rights reserved.
    </footer>

</body>
</html>