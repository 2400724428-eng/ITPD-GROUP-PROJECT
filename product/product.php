<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>ApexFit - Supplement Catalog</title>
<!-- Tailwind CSS v3 with Plugins -->
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<!-- Font Awesome Icons -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet"/>
<!-- Google Fonts -->
<link href="https://fonts.googleapis.com" rel="preconnect"/>
<link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect"/>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&amp;display=swap" rel="stylesheet"/>
<!-- Tailwind Configuration -->
<script>
    tailwind.config = {
      theme: {
        extend: {
          fontFamily: {
            sans: ['"Plus Jakarta Sans"', 'sans-serif'],
          },
          colors: {
            brand: {
              gray: '#6b7280',
              dark: '#1e293b',
              accent: '#ff5341',
              cardBg: '#f1f3f6'
            }
          }
        }
      }
    }
  </script>
<!-- Custom Styles: Rating & Card Hover Transitions -->
<style data-purpose="custom-styling">
    .star-coral {
      color: #ff523d;
    }
    .product-card {
      transition: all 0.25s ease-in-out;
    }
    .product-card:hover {
      transform: translateY(-3px);
      box-shadow: 0 14px 28px -8px rgba(0, 0, 0, 0.07);
    }
  </style>
</head>
<body class="bg-white text-slate-800 font-sans antialiased min-h-screen py-6 sm:py-10 px-4 sm:px-6 lg:px-8">

<!-- Main Layout Container with Sidebar & Grid -->
<div class="max-w-[1320px] mx-auto flex flex-col lg:flex-row gap-8 relative" data-purpose="catalog-layout">

  <!-- BEGIN: Desktop Product Filter Sidebar (Hidden on Mobile) -->
  <aside class="hidden lg:block w-[280px] shrink-0 bg-[#f8fafc] p-6 rounded-[24px] border border-slate-200/80 h-fit sticky top-6" data-purpose="product-filter-sidebar">
    <div class="flex items-center justify-between pb-4 border-b border-slate-200">
      <h2 class="text-base font-bold text-slate-900"><i class="fa-solid fa-filter mr-2 text-blue-600"></i>Filters</h2>
      <button class="text-xs text-blue-600 font-semibold hover:underline" type="button">Reset All</button>
    </div>

    <!-- Category Filter Group -->
    <div class="py-5 border-b border-slate-200">
      <h3 class="text-xs font-bold uppercase tracking-wider text-slate-500 mb-3">Supplement Categories</h3>
      <div class="space-y-2.5 text-[14px] text-slate-700 font-medium">
        <label class="flex items-center gap-2.5 cursor-pointer">
          <input checked class="rounded text-blue-600 focus:ring-blue-500 w-4 h-4" type="checkbox"/>
          <span>All Supplements</span>
        </label>
        <label class="flex items-center gap-2.5 cursor-pointer">
          <input class="rounded text-blue-600 focus:ring-blue-500 w-4 h-4" type="checkbox"/>
          <span>Whey Protein Isolate</span>
        </label>
        <label class="flex items-center gap-2.5 cursor-pointer">
          <input class="rounded text-blue-600 focus:ring-blue-500 w-4 h-4" type="checkbox"/>
          <span>Creatine & Pre-Workouts</span>
        </label>
        <label class="flex items-center gap-2.5 cursor-pointer">
          <input class="rounded text-blue-600 focus:ring-blue-500 w-4 h-4" type="checkbox"/>
          <span>Mass Gainers</span>
        </label>
        <label class="flex items-center gap-2.5 cursor-pointer">
          <input class="rounded text-blue-600 focus:ring-blue-500 w-4 h-4" type="checkbox"/>
          <span>Amino Acids & BCAAs</span>
        </label>
        <label class="flex items-center gap-2.5 cursor-pointer">
          <input class="rounded text-blue-600 focus:ring-blue-500 w-4 h-4" type="checkbox"/>
          <span>Fat Burners & Energy</span>
        </label>
      </div>
    </div>

    <!-- Price Range Filter Group (in UGX) -->
    <div class="py-5 border-b border-slate-200">
      <h3 class="text-xs font-bold uppercase tracking-wider text-slate-500 mb-3">Price Range</h3>
      <div class="space-y-2.5 text-[14px] text-slate-700 font-medium">
        <label class="flex items-center gap-2.5 cursor-pointer">
          <input class="rounded text-blue-600 focus:ring-blue-500 w-4 h-4" type="checkbox"/>
          <span>Under UGX 100,000</span>
        </label>
        <label class="flex items-center gap-2.5 cursor-pointer">
          <input class="rounded text-blue-600 focus:ring-blue-500 w-4 h-4" type="checkbox"/>
          <span>UGX 100,000 - 200,000</span>
        </label>
        <label class="flex items-center gap-2.5 cursor-pointer">
          <input class="rounded text-blue-600 focus:ring-blue-500 w-4 h-4" type="checkbox"/>
          <span>UGX 200,000 - 350,000</span>
        </label>
        <label class="flex items-center gap-2.5 cursor-pointer">
          <input class="rounded text-blue-600 focus:ring-blue-500 w-4 h-4" type="checkbox"/>
          <span>UGX 350,000 & Above</span>
        </label>
      </div>
    </div>

    <!-- Goal / Benefit Filter Group -->
    <div class="pt-5">
      <h3 class="text-xs font-bold uppercase tracking-wider text-slate-500 mb-3">Training Goal</h3>
      <div class="space-y-2.5 text-[14px] text-slate-700 font-medium">
        <label class="flex items-center gap-2.5 cursor-pointer">
          <input class="rounded text-blue-600 focus:ring-blue-500 w-4 h-4" type="checkbox"/>
          <span>Muscle Growth & Recovery</span>
        </label>
        <label class="flex items-center gap-2.5 cursor-pointer">
          <input class="rounded text-blue-600 focus:ring-blue-500 w-4 h-4" type="checkbox"/>
          <span>Extreme Energy & Focus</span>
        </label>
        <label class="flex items-center gap-2.5 cursor-pointer">
          <input class="rounded text-blue-600 focus:ring-blue-500 w-4 h-4" type="checkbox"/>
          <span>Weight Loss & Shredding</span>
        </label>
      </div>
    </div>
  </aside>
  <!-- END: Desktop Product Filter Sidebar -->

  <!-- BEGIN: Mobile Floating Filter Modal / Drawer -->
  <div id="mobile-filter-modal" class="fixed inset-0 z-50 flex justify-end bg-slate-900/50 backdrop-blur-sm transition-opacity duration-300 opacity-0 pointer-events-none lg:hidden">
    <div id="mobile-filter-card" class="w-full max-w-[320px] bg-white h-full shadow-2xl p-6 overflow-y-auto transform translate-x-full transition-transform duration-300 flex flex-col justify-between">
      <div>
        <!-- Modal Header -->
        <div class="flex items-center justify-between pb-4 border-b border-slate-200">
          <h2 class="text-base font-bold text-slate-900"><i class="fa-solid fa-filter mr-2 text-blue-600"></i>Filters</h2>
          <button id="close-filter-btn" class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center text-slate-500 hover:bg-slate-200 transition-colors" type="button">
            <i class="fa-solid fa-xmark text-sm"></i>
          </button>
        </div>

        <!-- Category Filter Group -->
        <div class="py-5 border-b border-slate-200">
          <h3 class="text-xs font-bold uppercase tracking-wider text-slate-500 mb-3">Supplement Categories</h3>
          <div class="space-y-3 text-[14px] text-slate-700 font-medium">
            <label class="flex items-center gap-2.5 cursor-pointer">
              <input checked class="rounded text-blue-600 focus:ring-blue-500 w-4 h-4" type="checkbox"/>
              <span>All Supplements</span>
            </label>
            <label class="flex items-center gap-2.5 cursor-pointer">
              <input class="rounded text-blue-600 focus:ring-blue-500 w-4 h-4" type="checkbox"/>
              <span>Whey Protein Isolate</span>
            </label>
            <label class="flex items-center gap-2.5 cursor-pointer">
              <input class="rounded text-blue-600 focus:ring-blue-500 w-4 h-4" type="checkbox"/>
              <span>Creatine & Pre-Workouts</span>
            </label>
            <label class="flex items-center gap-2.5 cursor-pointer">
              <input class="rounded text-blue-600 focus:ring-blue-500 w-4 h-4" type="checkbox"/>
              <span>Mass Gainers</span>
            </label>
            <label class="flex items-center gap-2.5 cursor-pointer">
              <input class="rounded text-blue-600 focus:ring-blue-500 w-4 h-4" type="checkbox"/>
              <span>Amino Acids & BCAAs</span>
            </label>
            <label class="flex items-center gap-2.5 cursor-pointer">
              <input class="rounded text-blue-600 focus:ring-blue-500 w-4 h-4" type="checkbox"/>
              <span>Fat Burners & Energy</span>
            </label>
          </div>
        </div>

        <!-- Price Range Filter Group (in UGX) -->
        <div class="py-5 border-b border-slate-200">
          <h3 class="text-xs font-bold uppercase tracking-wider text-slate-500 mb-3">Price Range</h3>
          <div class="space-y-3 text-[14px] text-slate-700 font-medium">
            <label class="flex items-center gap-2.5 cursor-pointer">
              <input class="rounded text-blue-600 focus:ring-blue-500 w-4 h-4" type="checkbox"/>
              <span>Under UGX 100,000</span>
            </label>
            <label class="flex items-center gap-2.5 cursor-pointer">
              <input class="rounded text-blue-600 focus:ring-blue-500 w-4 h-4" type="checkbox"/>
              <span>UGX 100,000 - 200,000</span>
            </label>
            <label class="flex items-center gap-2.5 cursor-pointer">
              <input class="rounded text-blue-600 focus:ring-blue-500 w-4 h-4" type="checkbox"/>
              <span>UGX 200,000 - 350,000</span>
            </label>
            <label class="flex items-center gap-2.5 cursor-pointer">
              <input class="rounded text-blue-600 focus:ring-blue-500 w-4 h-4" type="checkbox"/>
              <span>UGX 350,000 & Above</span>
            </label>
          </div>
        </div>

        <!-- Goal / Benefit Filter Group -->
        <div class="pt-5 pb-6">
          <h3 class="text-xs font-bold uppercase tracking-wider text-slate-500 mb-3">Training Goal</h3>
          <div class="space-y-3 text-[14px] text-slate-700 font-medium">
            <label class="flex items-center gap-2.5 cursor-pointer">
              <input class="rounded text-blue-600 focus:ring-blue-500 w-4 h-4" type="checkbox"/>
              <span>Muscle Growth & Recovery</span>
            </label>
            <label class="flex items-center gap-2.5 cursor-pointer">
              <input class="rounded text-blue-600 focus:ring-blue-500 w-4 h-4" type="checkbox"/>
              <span>Extreme Energy & Focus</span>
            </label>
            <label class="flex items-center gap-2.5 cursor-pointer">
              <input class="rounded text-blue-600 focus:ring-blue-500 w-4 h-4" type="checkbox"/>
              <span>Weight Loss & Shredding</span>
            </label>
          </div>
        </div>
      </div>

      <!-- Modal Footer Actions -->
      <div class="pt-4 border-t border-slate-200 flex items-center gap-3">
        <button class="w-1/2 py-2.5 rounded-xl border border-slate-300 text-xs font-semibold text-slate-700 hover:bg-slate-50 transition-colors" type="button">Reset All</button>
        <button id="apply-filter-btn" class="w-1/2 py-2.5 rounded-xl bg-blue-600 text-xs font-semibold text-white hover:bg-blue-700 transition-colors shadow-md" type="button">Apply Filters</button>
      </div>
    </div>
  </div>
  <!-- END: Mobile Floating Filter Modal / Drawer -->

  <!-- BEGIN: ProductCatalogSection -->
  <main class="flex-1 min-w-0" data-purpose="catalog-container">
    
    <!-- Catalog Header / Count info -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6 pb-4 border-b border-slate-100">
      <div>
        <h1 class="text-xl sm:text-2xl font-extrabold text-slate-900 tracking-tight">Pro Gym Supplements</h1>
        <p class="text-xs text-slate-500 mt-0.5">Showing affordable fitness formulas for maximum gains</p>
      </div>
      <div class="flex items-center justify-between sm:justify-end gap-2 text-xs font-semibold text-slate-700">
        <span>Sort by:</span>
        <select class="bg-slate-50 border border-slate-300 rounded-lg px-3 py-1.5 focus:ring-blue-500 focus:border-blue-500">
          <option>Featured Products</option>
          <option>Price: Low to High</option>
          <option>Price: High to Low</option>
          <option>Customer Rating</option>
        </select>
      </div>
    </div>

    <!-- Product Grid Container: 3 columns with equal-height cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

      <!-- Product Card 1 -->
      <article class="product-card flex flex-col justify-between bg-white border border-slate-100 rounded-[22px] p-4 h-full" data-purpose="product-card">
        <div>
          <a href="product/product-detail.php?id=1" class="block relative bg-[#f1f3f6] rounded-[18px] h-[220px] w-full flex items-center justify-center p-4">
            <button aria-label="Add to wishlist" class="absolute top-3.5 right-3.5 w-8 h-8 rounded-full bg-white shadow-sm flex items-center justify-center text-slate-500 hover:text-red-500 transition-colors z-10" type="button" onclick="event.preventDefault();">
              <i class="fa-regular fa-heart text-xs"></i>
            </button>
            <img alt="Whey Protein Isolate" class="max-h-[160px] max-w-[85%] object-contain mix-blend-multiply rounded-[16px]" src="https://images.unsplash.com/photo-1546483875-ad9014c88eba?auto=format&fit=crop&w=600&q=80"/>
          </a>
          <div class="pt-4 px-0.5">
            <a href="product/product-detail.php?id=1" class="block hover:text-blue-600 transition-colors">
              <h3 class="text-[17px] font-bold text-slate-900 leading-tight">Apex Platinum Whey Isolate</h3>
            </a>
            <p class="text-[13px] text-slate-400 font-normal mt-1 line-clamp-1">25g Ultra-Pure Protein per serving with zero sugar formulation...</p>
            <div class="flex items-center gap-1.5 mt-2 text-xs font-semibold text-slate-700">
              <span class="mr-0.5">4.9</span>
              <div class="flex text-[11px] gap-0.5 star-coral">
                <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i>
              </div>
            </div>
          </div>
        </div>
        <div class="flex items-center justify-between mt-5 pt-3 border-t border-slate-100 px-0.5">
          <span class="text-[16px] font-extrabold text-slate-900">UGX 185,000</span>
          <a href="product/product-detail.php?id=1" class="text-xs font-medium text-slate-600 border border-slate-300 rounded-full px-4 py-1.5 hover:bg-slate-900 hover:text-white hover:border-slate-900 transition-all duration-200" role="button">Buy now</a>
        </div>
      </article>

      <!-- Product Card 2 -->
      <article class="product-card flex flex-col justify-between bg-white border border-slate-100 rounded-[22px] p-4 h-full" data-purpose="product-card">
        <div>
          <a href="product/product-detail.php?id=2" class="block relative bg-[#f1f3f6] rounded-[18px] h-[220px] w-full flex items-center justify-center p-4">
            <button aria-label="Add to wishlist" class="absolute top-3.5 right-3.5 w-8 h-8 rounded-full bg-white shadow-sm flex items-center justify-center text-slate-500 hover:text-red-500 transition-colors z-10" type="button" onclick="event.preventDefault();">
              <i class="fa-regular fa-heart text-xs"></i>
            </button>
            <img alt="Micronized Creatine Monohydrate" class="max-h-[160px] max-w-[85%] object-contain mix-blend-multiply rounded-[16px]" src="https://images.unsplash.com/photo-1579722821273-0f6c7d44362f?auto=format&fit=crop&w=600&q=80"/>
          </a>
          <div class="pt-4 px-0.5">
            <a href="product/product-detail.php?id=2" class="block hover:text-blue-600 transition-colors">
              <h3 class="text-[17px] font-bold text-slate-900 leading-tight">Pure Creatine Monohydrate</h3>
            </a>
            <p class="text-[13px] text-slate-400 font-normal mt-1 line-clamp-1">Micronized powder for explosive strength and muscle mass gains.</p>
            <div class="flex items-center gap-1.5 mt-2 text-xs font-semibold text-slate-700">
              <span class="mr-0.5">4.8</span>
              <div class="flex text-[11px] gap-0.5 star-coral">
                <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star-half-stroke"></i>
              </div>
            </div>
          </div>
        </div>
        <div class="flex items-center justify-between mt-5 pt-3 border-t border-slate-100 px-0.5">
          <span class="text-[16px] font-extrabold text-slate-900">UGX 115,000</span>
          <a href="product/product-detail.php?id=2" class="text-xs font-medium text-slate-600 border border-slate-300 rounded-full px-4 py-1.5 hover:bg-slate-900 hover:text-white hover:border-slate-900 transition-all duration-200" role="button">Buy now</a>
        </div>
      </article>

      <!-- Product Card 3 -->
      <article class="product-card flex flex-col justify-between bg-white border border-slate-100 rounded-[22px] p-4 h-full" data-purpose="product-card">
        <div>
          <a href="product/product-detail.php?id=3" class="block relative bg-[#f1f3f6] rounded-[18px] h-[220px] w-full flex items-center justify-center p-4">
            <button aria-label="Add to wishlist" class="absolute top-3.5 right-3.5 w-8 h-8 rounded-full bg-white shadow-sm flex items-center justify-center text-slate-500 hover:text-red-500 transition-colors z-10" type="button" onclick="event.preventDefault();">
              <i class="fa-regular fa-heart text-xs"></i>
            </button>
            <img alt="Pre-Workout Energy Formula" class="max-h-[160px] max-w-[85%] object-contain mix-blend-multiply rounded-[16px]" src="https://images.unsplash.com/photo-1584735935682-2f2b69dff9d2?auto=format&fit=crop&w=600&q=80"/>
          </a>
          <div class="pt-4 px-0.5">
            <a href="product/product-detail.php?id=3" class="block hover:text-blue-600 transition-colors">
              <h3 class="text-[17px] font-bold text-slate-900 leading-tight">Vortex Pre-Workout Blast</h3>
            </a>
            <p class="text-[13px] text-slate-400 font-normal mt-1 line-clamp-1">Intense mental focus, massive pumps, and jitter-free energy matrix.</p>
            <div class="flex items-center gap-1.5 mt-2 text-xs font-semibold text-slate-700">
              <span class="mr-0.5">4.7</span>
              <div class="flex text-[11px] gap-0.5 star-coral">
                <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star-half-stroke"></i>
              </div>
            </div>
          </div>
        </div>
        <div class="flex items-center justify-between mt-5 pt-3 border-t border-slate-100 px-0.5">
          <span class="text-[16px] font-extrabold text-slate-900">UGX 135,000</span>
          <a href="product/product-detail.php?id=3" class="text-xs font-medium text-slate-600 border border-slate-300 rounded-full px-4 py-1.5 hover:bg-slate-900 hover:text-white hover:border-slate-900 transition-all duration-200" role="button">Buy now</a>
        </div>
      </article>

      <!-- Product Card 4 -->
      <article class="product-card flex flex-col justify-between bg-white border border-slate-100 rounded-[22px] p-4 h-full" data-purpose="product-card">
        <div>
          <a href="product/product-detail.php?id=4" class="block relative bg-[#f1f3f6] rounded-[18px] h-[220px] w-full flex items-center justify-center p-4">
            <button aria-label="Add to wishlist" class="absolute top-3.5 right-3.5 w-8 h-8 rounded-full bg-white shadow-sm flex items-center justify-center text-slate-500 hover:text-red-500 transition-colors z-10" type="button" onclick="event.preventDefault();">
              <i class="fa-regular fa-heart text-xs"></i>
            </button>
            <img alt="Mass Gainer Protein Tub" class="max-h-[160px] max-w-[85%] object-contain mix-blend-multiply rounded-[16px]" src="https://images.unsplash.com/photo-1576678927484-cc907957088c?auto=format&fit=crop&w=600&q=80"/>
          </a>
          <div class="pt-4 px-0.5">
            <a href="product/product-detail.php?id=4" class="block hover:text-blue-600 transition-colors">
              <h3 class="text-[17px] font-bold text-slate-900 leading-tight">Titan Mass Gainer 1000</h3>
            </a>
            <p class="text-[13px] text-slate-400 font-normal mt-1 line-clamp-1">High-calorie formula designed for hardgainers and rapid size buildup.</p>
            <div class="flex items-center gap-1.5 mt-2 text-xs font-semibold text-slate-700">
              <span class="mr-0.5">4.6</span>
              <div class="flex text-[11px] gap-0.5 star-coral">
                <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star-half-stroke"></i>
              </div>
            </div>
          </div>
        </div>
        <div class="flex items-center justify-between mt-5 pt-3 border-t border-slate-100 px-0.5">
          <span class="text-[16px] font-extrabold text-slate-900">UGX 220,000</span>
          <a href="product/product-detail.php?id=4" class="text-xs font-medium text-slate-600 border border-slate-300 rounded-full px-4 py-1.5 hover:bg-slate-900 hover:text-white hover:border-slate-900 transition-all duration-200" role="button">Buy now</a>
        </div>
      </article>

      <!-- Product Card 5 -->
      <article class="product-card flex flex-col justify-between bg-white border border-slate-100 rounded-[22px] p-4 h-full" data-purpose="product-card">
        <div>
          <a href="product/product-detail.php?id=5" class="block relative bg-[#f1f3f6] rounded-[18px] h-[220px] w-full flex items-center justify-center p-4">
            <button aria-label="Add to wishlist" class="absolute top-3.5 right-3.5 w-8 h-8 rounded-full bg-white shadow-sm flex items-center justify-center text-slate-500 hover:text-red-500 transition-colors z-10" type="button" onclick="event.preventDefault();">
              <i class="fa-regular fa-heart text-xs"></i>
            </button>
            <img alt="BCAA Amino Supplement" class="max-h-[160px] max-w-[85%] object-contain mix-blend-multiply rounded-[16px]" src="https://images.unsplash.com/photo-1517838277536-f5f99be501cd?auto=format&fit=crop&w=600&q=80"/>
          </a>
          <div class="pt-4 px-0.5">
            <a href="product/product-detail.php?id=5" class="block hover:text-blue-600 transition-colors">
              <h3 class="text-[17px] font-bold text-slate-900 leading-tight">BCAA 2:1:1 Recovery Matrix</h3>
            </a>
            <p class="text-[13px] text-slate-400 font-normal mt-1 line-clamp-1">Electrolyte-infused amino acids designed to eliminate muscle soreness.</p>
            <div class="flex items-center gap-1.5 mt-2 text-xs font-semibold text-slate-700">
              <span class="mr-0.5">4.8</span>
              <div class="flex text-[11px] gap-0.5 star-coral">
                <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i>
              </div>
            </div>
          </div>
        </div>
        <div class="flex items-center justify-between mt-5 pt-3 border-t border-slate-100 px-0.5">
          <span class="text-[16px] font-extrabold text-slate-900">UGX 95,000</span>
          <a href="product/product-detail.php?id=5" class="text-xs font-medium text-slate-600 border border-slate-300 rounded-full px-4 py-1.5 hover:bg-slate-900 hover:text-white hover:border-slate-900 transition-all duration-200" role="button">Buy now</a>
        </div>
      </article>

      <!-- Product Card 6 -->
      <article class="product-card flex flex-col justify-between bg-white border border-slate-100 rounded-[22px] p-4 h-full" data-purpose="product-card">
        <div>
          <a href="product/product-detail.php?id=6" class="block relative bg-[#f1f3f6] rounded-[18px] h-[220px] w-full flex items-center justify-center p-4">
            <button aria-label="Add to wishlist" class="absolute top-3.5 right-3.5 w-8 h-8 rounded-full bg-white shadow-sm flex items-center justify-center text-slate-500 hover:text-red-500 transition-colors z-10" type="button" onclick="event.preventDefault();">
              <i class="fa-regular fa-heart text-xs"></i>
            </button>
            <img alt="Glutamine Powder" class="max-h-[160px] max-w-[85%] object-contain mix-blend-multiply rounded-[16px]" src="https://images.unsplash.com/photo-1594882645126-14020914d58d?auto=format&fit=crop&w=600&q=80"/>
          </a>
          <div class="pt-4 px-0.5">
            <a href="product/product-detail.php?id=6" class="block hover:text-blue-600 transition-colors">
              <h3 class="text-[17px] font-bold text-slate-900 leading-tight">Pure L-Glutamine Powder</h3>
            </a>
            <p class="text-[13px] text-slate-400 font-normal mt-1 line-clamp-1">Supports deep muscle tissue repair and reinforces immune health.</p>
            <div class="flex items-center gap-1.5 mt-2 text-xs font-semibold text-slate-700">
              <span class="mr-0.5">4.5</span>
              <div class="flex text-[11px] gap-0.5 star-coral">
                <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star-half-stroke"></i>
              </div>
            </div>
          </div>
        </div>
        <div class="flex items-center justify-between mt-5 pt-3 border-t border-slate-100 px-0.5">
          <span class="text-[16px] font-extrabold text-slate-900">UGX 85,000</span>
          <a href="product/product-detail.php?id=6" class="text-xs font-medium text-slate-600 border border-slate-300 rounded-full px-4 py-1.5 hover:bg-slate-900 hover:text-white hover:border-slate-900 transition-all duration-200" role="button">Buy now</a>
        </div>
      </article>

    </div>

    <!-- Hidden / Expandable More Products Section (Toggleable via button) -->
    <div id="more-products-container" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mt-6 hidden">

      <!-- Product Card 7 -->
      <article class="product-card flex flex-col justify-between bg-white border border-slate-100 rounded-[22px] p-4 h-full" data-purpose="product-card">
        <div>
          <a href="product/product-detail.php?id=7" class="block relative bg-[#f1f3f6] rounded-[18px] h-[220px] w-full flex items-center justify-center p-4">
            <button aria-label="Add to wishlist" class="absolute top-3.5 right-3.5 w-8 h-8 rounded-full bg-white shadow-sm flex items-center justify-center text-slate-500 hover:text-red-500 transition-colors z-10" type="button" onclick="event.preventDefault();">
              <i class="fa-regular fa-heart text-xs"></i>
            </button>
            <img alt="Thermo Shred Capsules" class="max-h-[160px] max-w-[85%] object-contain mix-blend-multiply rounded-[16px]" src="https://images.unsplash.com/photo-1550572017-edd951b55104?auto=format&fit=crop&w=600&q=80"/>
          </a>
          <div class="pt-4 px-0.5">
            <a href="product/product-detail.php?id=7" class="block hover:text-blue-600 transition-colors">
              <h3 class="text-[17px] font-bold text-slate-900 leading-tight">ThermoShred Pro Capsules</h3>
            </a>
            <p class="text-[13px] text-slate-400 font-normal mt-1 line-clamp-1">Advanced thermogenic formula for accelerated fat loss & definition.</p>
            <div class="flex items-center gap-1.5 mt-2 text-xs font-semibold text-slate-700">
              <span class="mr-0.5">4.7</span>
              <div class="flex text-[11px] gap-0.5 star-coral">
                <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star-half-stroke"></i>
              </div>
            </div>
          </div>
        </div>
        <div class="flex items-center justify-between mt-5 pt-3 border-t border-slate-100 px-0.5">
          <span class="text-[16px] font-extrabold text-slate-900">UGX 125,000</span>
          <a href="product/product-detail.php?id=7" class="text-xs font-medium text-slate-600 border border-slate-300 rounded-full px-4 py-1.5 hover:bg-slate-900 hover:text-white hover:border-slate-900 transition-all duration-200" role="button">Buy now</a>
        </div>
      </article>

      <!-- Product Card 8 -->
      <article class="product-card flex flex-col justify-between bg-white border border-slate-100 rounded-[22px] p-4 h-full" data-purpose="product-card">
        <div>
          <a href="product/product-detail.php?id=8" class="block relative bg-[#f1f3f6] rounded-[18px] h-[220px] w-full flex items-center justify-center p-4">
            <button aria-label="Add to wishlist" class="absolute top-3.5 right-3.5 w-8 h-8 rounded-full bg-white shadow-sm flex items-center justify-center text-slate-500 hover:text-red-500 transition-colors z-10" type="button" onclick="event.preventDefault();">
              <i class="fa-regular fa-heart text-xs"></i>
            </button>
            <img alt="Omega 3 Fish Oil Softgels" class="max-h-[160px] max-w-[85%] object-contain mix-blend-multiply rounded-[16px]" src="https://images.unsplash.com/photo-1584308666744-24d5c474f2ae?auto=format&fit=crop&w=600&q=80"/>
          </a>
          <div class="pt-4 px-0.5">
            <a href="product/product-detail.php?id=8" class="block hover:text-blue-600 transition-colors">
              <h3 class="text-[17px] font-bold text-slate-900 leading-tight">Omega-3 Triple Strength</h3>
            </a>
            <p class="text-[13px] text-slate-400 font-normal mt-1 line-clamp-1">High-potency fish oil for advanced joint health and cardio support.</p>
            <div class="flex items-center gap-1.5 mt-2 text-xs font-semibold text-slate-700">
              <span class="mr-0.5">4.9</span>
              <div class="flex text-[11px] gap-0.5 star-coral">
                <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i>
              </div>
            </div>
          </div>
        </div>
        <div class="flex items-center justify-between mt-5 pt-3 border-t border-slate-100 px-0.5">
          <span class="text-[16px] font-extrabold text-slate-900">UGX 75,000</span>
          <a href="product/product-detail.php?id=8" class="text-xs font-medium text-slate-600 border border-slate-300 rounded-full px-4 py-1.5 hover:bg-slate-900 hover:text-white hover:border-slate-900 transition-all duration-200" role="button">Buy now</a>
        </div>
      </article>

    </div>

    <!-- Dropdown / View More Toggle Button Section -->
    <div class="mt-8 text-center" data-purpose="view-more-section">
      <button id="view-more-btn" class="inline-flex items-center gap-2 bg-slate-900 text-white font-semibold text-sm px-6 py-3 rounded-full hover:bg-blue-600 transition-all duration-200 shadow-md" type="button">
        <span id="btn-text">View More Products</span>
        <i id="btn-icon" class="fa-solid fa-chevron-down text-xs transition-transform duration-300"></i>
      </button>
    </div>

  </main>
  <!-- END: ProductCatalogSection -->

</div>

<!-- Floating Mobile Filter Trigger Button (Smaller & Compact) -->
<div class="fixed bottom-5 right-5 z-40 lg:hidden">
  <button id="open-filter-btn" class="flex items-center justify-center w-11 h-11 bg-blue-600 text-white rounded-full shadow-lg hover:bg-blue-700 active:scale-95 transition-all duration-200" type="button" aria-label="Open Filters">
    <i class="fa-solid fa-filter text-xs"></i>
  </button>
</div>

<!-- Interactive Scripts -->
<script data-purpose="interactive-scripts">
  document.querySelectorAll('[aria-label="Add to wishlist"]').forEach(button => {
    button.addEventListener('click', (e) => {
      e.preventDefault();
      const icon = button.querySelector('i');
      icon.classList.toggle('fa-regular');
      icon.classList.toggle('fa-solid');
      icon.classList.toggle('text-red-500');
    });
  });

  const viewMoreBtn = document.getElementById('view-more-btn');
  const moreProductsContainer = document.getElementById('more-products-container');
  const btnText = document.getElementById('btn-text');
  const btnIcon = document.getElementById('btn-icon');

  viewMoreBtn.addEventListener('click', () => {
    const isHidden = moreProductsContainer.classList.contains('hidden');
    if (isHidden) {
      moreProductsContainer.classList.remove('hidden');
      btnText.textContent = 'Show Less Products';
      btnIcon.classList.add('rotate-180');
    } else {
      moreProductsContainer.classList.add('hidden');
      btnText.textContent = 'View More Products';
      btnIcon.classList.remove('rotate-180');
    }
  });

  // Mobile Filter Drawer Toggle Logic
  const openFilterBtn = document.getElementById('open-filter-btn');
  const closeFilterBtn = document.getElementById('close-filter-btn');
  const applyFilterBtn = document.getElementById('apply-filter-btn');
  const mobileFilterModal = document.getElementById('mobile-filter-modal');
  const mobileFilterCard = document.getElementById('mobile-filter-card');

  function openFilters() {
    mobileFilterModal.classList.remove('pointer-events-none', 'opacity-0');
    mobileFilterCard.classList.remove('translate-x-full');
    document.body.style.overflow = 'hidden';
  }

  function closeFilters() {
    mobileFilterModal.classList.add('opacity-0', 'pointer-events-none');
    mobileFilterCard.classList.add('translate-x-full');
    document.body.style.overflow = '';
  }

  openFilterBtn.addEventListener('click', openFilters);
  closeFilterBtn.addEventListener('click', closeFilters);
  applyFilterBtn.addEventListener('click', closeFilters);

  // Close modal when clicking outside the card on the backdrop
  mobileFilterModal.addEventListener('click', (e) => {
    if (e.target === mobileFilterModal) {
      closeFilters();
    }
  });
</script>
</body>
</html>