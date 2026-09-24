<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jumika Supplements | Online Store</title>
    <!-- FontAwesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700;800;900&display=swap" rel="stylesheet">
    <!-- Lucide Icons CDN -->
    <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body class="bg-slate-50 font-sans antialiased text-slate-800 pb-24 md:pb-12">

    <!-- MAIN HEADER -->
    <header class="sticky top-0 z-50 bg-white/95 backdrop-blur-md border-b border-slate-200 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between gap-4">
            
            <!-- Left: Brand Logo & Mobile Menu Toggle -->
            <div class="flex items-center gap-3">
                <button id="menuBtn" class="md:hidden w-10 h-10 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 flex items-center justify-center transition-all focus:outline-none" aria-label="Toggle Menu">
                    <i class="fa-solid fa-bars text-lg"></i>
                </button>

                <a href="index.php" class="flex items-center gap-3">
                    <div class="w-10 h-10 md:w-12 md:h-12 bg-indigo-600 rounded-full overflow-hidden flex items-center justify-center text-white font-black shadow-md shadow-indigo-500/30 flex-shrink-0">
                        <img src="assets/images/logo.png" alt="Logo" class="w-full h-full object-cover scale-125">
                    </div>
                    <div>
                        <span class="font-black text-xl tracking-tight text-slate-900">PURE GAIN</span>
                        <span class="block text-[10px] text-indigo-600 font-bold uppercase tracking-wider">SUPPLIMENTS</span>
                    </div>
                </a>
            </div>

            <!-- DESKTOP NAVIGATION -->
            <nav class="hidden md:flex items-center gap-1 lg:gap-2">
                <a href="index.php" class="px-4 py-2 rounded-xl text-sm font-medium text-slate-600 hover:text-indigo-600 hover:bg-slate-100 transition-all">Home</a>
                <a href="#products" class="px-4 py-2 rounded-xl text-sm font-medium text-slate-600 hover:text-indigo-600 hover:bg-slate-100 transition-all">Flash Deals</a>
                <a href="#categories" class="px-4 py-2 rounded-xl text-sm font-medium text-slate-600 hover:text-indigo-600 hover:bg-slate-100 transition-all">Categories</a>
                <a href="wishlist.php" class="px-4 py-2 rounded-xl text-sm font-medium text-slate-600 hover:text-indigo-600 hover:bg-slate-100 transition-all">Wishlist</a>
                <button id="openAuthModalDesk" class="px-4 py-2 rounded-xl text-sm font-medium text-slate-600 hover:text-indigo-600 hover:bg-slate-100 transition-all flex items-center gap-2 cursor-pointer">
                    <i class="fa-regular fa-user text-sky-500"></i> Account
                </button>
            </nav>

            <!-- Right: Mobile Search Trigger, Desktop Search & Cart Action -->
            <div class="flex items-center gap-3">
                <!-- Mobile Search Toggle Button -->
                <button id="mobileSearchToggle" class="md:hidden w-10 h-10 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 flex items-center justify-center transition-all focus:outline-none" aria-label="Toggle Search">
                    <i class="fa-solid fa-magnifying-glass text-sm"></i>
                </button>

                <!-- Search Bar (Desktop) - Updated with form and search button -->
                <div class="hidden lg:block w-64 xl:w-80">
                    <form action="search.php" method="GET" class="flex items-center relative w-full">
                        <span class="absolute left-3 text-slate-400 z-10"><i class="fa-solid fa-magnifying-glass text-xs"></i></span>
                        <input type="text" name="q" placeholder="Search supplements..." class="w-full bg-slate-100 border border-slate-200 rounded-l-xl pl-9 pr-3 py-2 text-xs text-slate-800 focus:outline-none focus:border-indigo-600 focus:bg-white transition-all">
                        <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-3 py-2 rounded-r-xl text-xs font-semibold transition-all shrink-0">
                            Search
                        </button>
                    </form>
                </div>

                <a href="cart.php" class="relative flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2.5 rounded-2xl font-semibold text-sm transition-all shadow-md shadow-indigo-200">
                    <i class="fa-solid fa-cart-shopping"></i>
                    <span class="hidden sm:inline">Cart</span>
                    <span class="bg-white text-indigo-600 text-xs w-5 h-5 rounded-full flex items-center justify-center font-bold">3</span>
                </a>
            </div>
        </div>
    </header>

    <!-- FLOATING MOBILE SEARCH OVERLAY BAR -->
    <div id="mobileSearchOverlayBar" class="fixed top-20 left-0 right-0 bg-white border-b border-slate-200 shadow-lg p-4 z-40 hidden md:hidden transition-all">
        <form id="mobileSearchForm" action="search.php" method="GET" class="max-w-7xl mx-auto flex items-center gap-2">
            <div class="relative flex-1">
                <span class="absolute left-3.5 top-3 text-slate-400"><i class="fa-solid fa-magnifying-glass text-xs"></i></span>
                <input type="text" name="q" placeholder="Search products..." class="w-full bg-slate-100 border border-slate-200 rounded-xl pl-9 pr-3 py-2.5 text-xs text-slate-800 focus:outline-none focus:border-indigo-600 focus:bg-white">
            </div>
            <!-- Search Submit Button -->
            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2.5 rounded-xl font-semibold text-xs transition-all shrink-0 flex items-center gap-1.5 shadow-sm">
                <i class="fa-solid fa-magnifying-glass"></i> Search
            </button>
            <button type="button" id="closeMobileSearch" class="w-10 h-10 rounded-xl bg-slate-100 text-slate-500 hover:bg-slate-200 flex items-center justify-center shrink-0">
                <i class="fa-solid fa-xmark text-sm"></i>
            </button>
        </form>
    </div>

    <!-- MOBILE SIDEBAR DRAWER OVERLAY -->
    <div id="mobileMenuOverlay" class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm z-50 hidden transition-opacity md:hidden"></div>

    <!-- MOBILE SIDEBAR DRAWER -->
    <div id="mobileMenu" class="fixed top-0 left-0 bottom-0 w-80 bg-white shadow-2xl z-50 transform -translate-x-full transition-transform duration-300 ease-in-out md:hidden flex flex-col">
        <div class="p-6 border-b border-slate-100 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 bg-indigo-600 rounded-xl flex items-center justify-center text-white font-black text-base">J</div>
                <span class="font-black text-base tracking-tight text-slate-900">JUMIKA MENU</span>
            </div>
            <button id="closeMenuBtn" class="w-8 h-8 rounded-full bg-slate-100 text-slate-500 hover:bg-slate-200 flex items-center justify-center">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <div class="p-4 border-t border-slate-100 text-center mt-auto">
            <p class="text-xs text-slate-400">Need help? Call <span class="font-bold text-slate-700">+256 700 000000</span></p>
        </div>
    </div>

    <!-- Simple JS to handle opening/closing the floating search bar -->
    <script>
        const mobileSearchToggle = document.getElementById('mobileSearchToggle');
        const mobileSearchOverlayBar = document.getElementById('mobileSearchOverlayBar');
        const closeMobileSearch = document.getElementById('closeMobileSearch');

        mobileSearchToggle.addEventListener('click', () => {
            mobileSearchOverlayBar.classList.toggle('hidden');
            if(!mobileSearchOverlayBar.classList.contains('hidden')) {
                mobileSearchOverlayBar.querySelector('input').focus();
            }
        });

        closeMobileSearch.addEventListener('click', () => {
            mobileSearchOverlayBar.classList.add('hidden');
        });
    </script>
</body>
</html>