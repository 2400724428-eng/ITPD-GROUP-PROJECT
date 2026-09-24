<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart | Jumika Supplements</title>
    <!-- FontAwesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50 font-sans antialiased text-slate-800 pb-28 md:pb-12">

<?php 
     include 'includes/top.php';
?>
  

    <!-- === MAIN CONTAINER: CART CONTENT === -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-8">
        
        <!-- Page Title -->
        <div class="flex items-center justify-between border-b border-slate-200 pb-4">
            <div>
                <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">Your Shopping Cart</h1>
                <p class="text-xs sm:text-sm text-slate-500">You have 3 items in your cart ready for checkout.</p>
            </div>
            <a href="index.php" class="text-xs sm:text-sm font-semibold text-indigo-600 hover:text-indigo-700 flex items-center gap-1">
                <i class="fa-solid fa-arrow-left"></i> Continue Shopping
            </a>
        </div>

        <!-- Cart Grid Layout -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
            
            <!-- Left 2 Columns: Cart Items List -->
            <div class="lg:col-span-2 space-y-4">
                
                <!-- Cart Item 1 -->
                <div class="bg-white p-4 sm:p-6 rounded-3xl border border-slate-100 shadow-sm flex flex-col sm:flex-row items-center gap-4 sm:gap-6">
                    <div class="w-24 h-24 bg-slate-50 rounded-2xl p-2 flex items-center justify-center shrink-0 border border-slate-100">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/7/78/Optimus_nutrition_gold_standard_whey_protein_%282%29.jpg/500px-Optimus_nutrition_gold_standard_whey_protein_%282%29.jpg" alt="Whey Protein" referrerpolicy="no-referrer" class="object-contain h-full">
                    </div>
                    <div class="flex-1 text-center sm:text-left space-y-1">
                        <span class="text-[10px] bg-indigo-50 text-indigo-600 font-bold px-2.5 py-0.5 rounded-full uppercase">Proteins</span>
                        <h3 class="font-bold text-slate-800 text-sm sm:text-base">Whey Protein Isolate, Chocolate, 2kg</h3>
                        <p class="text-xs text-slate-400">Flavor: Rich Chocolate</p>
                        <div class="text-sm font-black text-slate-900 pt-1">UGX 185,000</div>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="flex items-center border border-slate-200 rounded-xl bg-slate-50 overflow-hidden">
                            <button class="px-3 py-1.5 text-slate-500 hover:bg-slate-200 font-bold transition-colors">-</button>
                            <span class="px-3 py-1.5 text-xs font-bold text-slate-800">1</span>
                            <button class="px-3 py-1.5 text-slate-500 hover:bg-slate-200 font-bold transition-colors">+</button>
                        </div>
                        <button class="w-9 h-9 rounded-xl bg-rose-50 text-rose-500 hover:bg-rose-100 flex items-center justify-center transition-all" title="Remove item">
                            <i class="fa-regular fa-trash-can text-xs"></i>
                        </button>
                    </div>
                </div>

                <!-- Cart Item 2 -->
                <div class="bg-white p-4 sm:p-6 rounded-3xl border border-slate-100 shadow-sm flex flex-col sm:flex-row items-center gap-4 sm:gap-6">
                    <div class="w-24 h-24 bg-slate-50 rounded-2xl p-2 flex items-center justify-center shrink-0 border border-slate-100">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/8/87/Creatine_monohydrate.jpg/500px-Creatine_monohydrate.jpg" alt="Creatine" referrerpolicy="no-referrer" class="object-contain h-full">
                    </div>
                    <div class="flex-1 text-center sm:text-left space-y-1">
                        <span class="text-[10px] bg-indigo-50 text-indigo-600 font-bold px-2.5 py-0.5 rounded-full uppercase">Creatine</span>
                        <h3 class="font-bold text-slate-800 text-sm sm:text-base">Micronised Creatine Monohydrate, 300g</h3>
                        <p class="text-xs text-slate-400">Flavor: Unflavored</p>
                        <div class="text-sm font-black text-slate-900 pt-1">UGX 65,000</div>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="flex items-center border border-slate-200 rounded-xl bg-slate-50 overflow-hidden">
                            <button class="px-3 py-1.5 text-slate-500 hover:bg-slate-200 font-bold transition-colors">-</button>
                            <span class="px-3 py-1.5 text-xs font-bold text-slate-800">1</span>
                            <button class="px-3 py-1.5 text-slate-500 hover:bg-slate-200 font-bold transition-colors">+</button>
                        </div>
                        <button class="w-9 h-9 rounded-xl bg-rose-50 text-rose-500 hover:bg-rose-100 flex items-center justify-center transition-all" title="Remove item">
                            <i class="fa-regular fa-trash-can text-xs"></i>
                        </button>
                    </div>
                </div>

                <!-- Cart Item 3 -->
                <div class="bg-white p-4 sm:p-6 rounded-3xl border border-slate-100 shadow-sm flex flex-col sm:flex-row items-center gap-4 sm:gap-6">
                    <div class="w-24 h-24 bg-slate-50 rounded-2xl p-2 flex items-center justify-center shrink-0 border border-slate-100">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/1/1b/Osaka_protein_shaker.jpg/500px-Osaka_protein_shaker.jpg" alt="Shaker Bottle" referrerpolicy="no-referrer" class="object-contain h-full">
                    </div>
                    <div class="flex-1 text-center sm:text-left space-y-1">
                        <span class="text-[10px] bg-indigo-50 text-indigo-600 font-bold px-2.5 py-0.5 rounded-full uppercase">Accessories</span>
                        <h3 class="font-bold text-slate-800 text-sm sm:text-base">Leak-Proof Protein Shaker Bottle, 700ml</h3>
                        <p class="text-xs text-slate-400">Color: Matte Black</p>
                        <div class="text-sm font-black text-slate-900 pt-1">UGX 15,000</div>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="flex items-center border border-slate-200 rounded-xl bg-slate-50 overflow-hidden">
                            <button class="px-3 py-1.5 text-slate-500 hover:bg-slate-200 font-bold transition-colors">-</button>
                            <span class="px-3 py-1.5 text-xs font-bold text-slate-800">1</span>
                            <button class="px-3 py-1.5 text-slate-500 hover:bg-slate-200 font-bold transition-colors">+</button>
                        </div>
                        <button class="w-9 h-9 rounded-xl bg-rose-50 text-rose-500 hover:bg-rose-100 flex items-center justify-center transition-all" title="Remove item">
                            <i class="fa-regular fa-trash-can text-xs"></i>
                        </button>
                    </div>
                </div>

            </div>

            <!-- Right Column: Order Summary Card -->
            <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm space-y-6 lg:sticky lg:top-28">
                <h3 class="text-lg font-black text-slate-900 border-b border-slate-100 pb-4">Order Summary</h3>
                
                <div class="space-y-3 text-sm">
                    <div class="flex justify-between text-slate-600">
                        <span>Subtotal</span>
                        <span class="font-semibold text-slate-900">UGX 265,000</span>
                    </div>
                    <div class="flex justify-between text-slate-600">
                        <span>Estimated Delivery (Kampala)</span>
                        <span class="font-semibold text-emerald-600">FREE</span>
                    </div>
                    <div class="flex justify-between text-slate-600">
                        <span>Tax (VAT Included)</span>
                        <span class="font-semibold text-slate-900">UGX 0</span>
                    </div>
                </div>

                <div class="border-t border-slate-100 pt-4 flex items-center justify-between">
                    <span class="font-bold text-slate-900">Total</span>
                    <span class="text-xl font-black text-indigo-600">UGX 265,000</span>
                </div>

                <!-- Promo Code Input -->
                <div class="flex gap-2">
                    <input type="text" placeholder="Promo code" class="bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-xs flex-1 focus:outline-none focus:border-indigo-600">
                    <button class="bg-slate-900 hover:bg-slate-800 text-white px-4 py-2 rounded-xl text-xs font-bold transition-all">Apply</button>
                </div>

                <!-- Checkout Button -->
                <a href="checkout.php" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3.5 rounded-2xl transition-all shadow-lg shadow-indigo-200 flex items-center justify-center gap-2 text-sm">
                    Proceed to Checkout <i class="fa-solid fa-arrow-right"></i>
                </a>

                <div class="text-center">
                    <p class="text-[11px] text-slate-400 flex items-center justify-center gap-1.5">
                        <i class="fa-solid fa-shield-halved text-emerald-500"></i> Secure Mobile Money &amp; Cash on Delivery
                    </p>
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
        <a href="wishlist.php" class="flex flex-col items-center gap-1 text-slate-400 hover:text-indigo-600 text-[11px] font-bold">
            <i class="fa-regular fa-heart text-lg"></i>
            <span>Wishlist</span>
        </a>
        <a href="cart.php" class="flex flex-col items-center gap-1 text-indigo-600 text-[11px] font-bold relative">
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