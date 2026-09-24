<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Wishlist | Jumika Supplements</title>
    <!-- FontAwesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50 font-sans antialiased text-slate-800 pb-28 md:pb-12">


<?php 
     include 'includes/top.php';
?>

    <!-- === MAIN CONTAINER: WISHLIST CONTENT === -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-8">
        
        <!-- Page Title -->
        <div class="flex items-center justify-between border-b border-slate-200 pb-4">
            <div>
                <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">My Wishlist</h1>
                <p class="text-xs sm:text-sm text-slate-500">Items you have saved for later purchase.</p>
            </div>
            <a href="index.php" class="text-xs sm:text-sm font-semibold text-indigo-600 hover:text-indigo-700 flex items-center gap-1">
                <i class="fa-solid fa-arrow-left"></i> Continue Shopping
            </a>
        </div>

        <!-- Wishlist Items Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            
            <!-- Wishlist Item 1 -->
            <div class="bg-white rounded-3xl shadow-sm hover:shadow-xl transition-all duration-300 overflow-hidden border border-slate-100 p-5 flex flex-col group relative">
                <button class="absolute top-4 right-4 z-10 w-9 h-9 rounded-xl bg-rose-50 text-rose-500 hover:bg-rose-100 flex items-center justify-center transition-all" title="Remove from wishlist">
                    <i class="fa-solid fa-heart text-xs"></i>
                </button>
                <div class="bg-slate-50 rounded-2xl overflow-hidden aspect-square mb-4 flex items-center justify-center p-4">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/4/42/Adonis_Men%27s_Pre-workout.jpg/500px-Adonis_Men%27s_Pre-workout.jpg" alt="Pre-Workout" referrerpolicy="no-referrer" class="object-contain h-full group-hover:scale-105 transition-transform duration-300">
                </div>
                <div class="text-[11px] text-slate-400 font-semibold uppercase tracking-wider mb-1">Pre-Workout</div>
                <h4 class="font-bold text-slate-800 text-sm mb-3 group-hover:text-indigo-600 transition-colors line-clamp-2">Explosive Pre-Workout Booster, 400g</h4>
                <div class="mb-4">
                    <div class="text-base font-black text-slate-900">UGX 85,000</div>
                    <span class="inline-block mt-1 text-[10px] bg-emerald-50 text-emerald-600 font-bold px-2 py-0.5 rounded-full">In Stock</span>
                </div>
                <div class="mt-auto pt-3 border-t border-slate-100">
                    <a href="cart.php" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2.5 rounded-xl text-xs flex items-center justify-center gap-2 transition-all shadow-sm shadow-indigo-200">
                        <i class="fa-solid fa-cart-shopping"></i> Move to Cart
                    </a>
                </div>
            </div>

            <!-- Wishlist Item 2 -->
            <div class="bg-white rounded-3xl shadow-sm hover:shadow-xl transition-all duration-300 overflow-hidden border border-slate-100 p-5 flex flex-col group relative">
                <button class="absolute top-4 right-4 z-10 w-9 h-9 rounded-xl bg-rose-50 text-rose-500 hover:bg-rose-100 flex items-center justify-center transition-all" title="Remove from wishlist">
                    <i class="fa-solid fa-heart text-xs"></i>
                </button>
                <div class="bg-slate-50 rounded-2xl overflow-hidden aspect-square mb-4 flex items-center justify-center p-4">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/8/84/Pro360_Protein_powder.jpg/500px-Pro360_Protein_powder.jpg" alt="Mass Gainer" referrerpolicy="no-referrer" class="object-contain h-full group-hover:scale-105 transition-transform duration-300">
                </div>
                <div class="text-[11px] text-slate-400 font-semibold uppercase tracking-wider mb-1">Gainers</div>
                <h4 class="font-bold text-slate-800 text-sm mb-3 group-hover:text-indigo-600 transition-colors line-clamp-2">Super Mass Gainer, Vanilla, 3kg</h4>
                <div class="mb-4">
                    <div class="text-base font-black text-slate-900">UGX 210,000</div>
                    <span class="inline-block mt-1 text-[10px] bg-emerald-50 text-emerald-600 font-bold px-2 py-0.5 rounded-full">In Stock</span>
                </div>
                <div class="mt-auto pt-3 border-t border-slate-100">
                    <a href="cart.php" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2.5 rounded-xl text-xs flex items-center justify-center gap-2 transition-all shadow-sm shadow-indigo-200">
                        <i class="fa-solid fa-cart-shopping"></i> Move to Cart
                    </a>
                </div>
            </div>

        </div>
    </main>

    <!-- == MOBILE BOTTOM NAVIGATION BAR == -->
    <nav class="fixed bottom-0 left-0 right-0 bg-white/95 backdrop-blur-md border-t border-slate-200 flex items-center justify-around py-2.5 z-40 md:hidden shadow-2xl">
        <a href="index.php" class="flex flex-col items-center gap-1 text-slate-400 hover:text-indigo-600 text-[11px] font-bold">
            <i class="fa-solid fa-house text-lg"></i>
            <span>Home</span>
        </a>
        <a href="index.php#categories" class="flex flex-col items-center gap-1 text-slate-400 hover:text-indigo-600 text-[11px] font-bold">
            <i class="fa-solid fa-shapes text-lg"></i>
            <span>Categories</span>
        </a>
        <a href="account.php" class="flex flex-col items-center gap-1 text-slate-400 hover:text-indigo-600 text-[11px] font-bold">
            <i class="fa-regular fa-user text-lg"></i>
            <span>Account</span>
        </a>
        <a href="wishlist.php" class="flex flex-col items-center gap-1 text-indigo-600 text-[11px] font-bold">
            <i class="fa-solid fa-heart text-lg"></i>
            <span>Wishlist</span>
        </a>
        <a href="cart.php" class="flex flex-col items-center gap-1 text-slate-400 hover:text-indigo-600 text-[11px] font-bold relative">
            <i class="fa-solid fa-cart-shopping text-lg"></i>
            <span>Cart</span>
            <span class="absolute -top-1.5 right-1 bg-indigo-600 text-white text-[9px] w-4 h-4 rounded-full flex items-center justify-center font-bold">3</span>
        </a>
    </nav>

    <!-- SIMPLE SCRIPT TO HANDLE MOBILE DRAWER TOGGLE -->
    <script>
        const menuBtn = document.getElementById('menuBtn');
        const closeMenuBtn = document.getElementById('closeMenuBtn');
        const mobileMenu = document.getElementById('mobileMenu');
        const mobileMenuOverlay = document.getElementById('mobileMenuOverlay');

        function toggleMenu() {
            mobileMenu.classList.toggle('-translate-x-full');
            mobileMenuOverlay.classList.toggle('hidden');
        }

        menuBtn.addEventListener('click', toggleMenu);
        closeMenuBtn.addEventListener('click', toggleMenu);
        mobileMenuOverlay.addEventListener('click', toggleMenu);
    </script>

</body>
</html>