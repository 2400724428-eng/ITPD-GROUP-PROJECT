<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>ApexFit - Supplement Catalog</title>
<link href="../src/output.css" rel="stylesheet">

<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet"/>
<link href="https://fonts.googleapis.com" rel="preconnect"/>
<link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect"/>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&amp;display=swap" rel="stylesheet"/>
<script>
    tailwind.config = { theme: { extend: { fontFamily: { sans: ['"Plus Jakarta Sans"', 'sans-serif'] } } } }
</script>
<style>
    .product-card { transition: transform .25s ease, box-shadow .25s ease; }
    .product-card:hover { transform: translateY(-3px); box-shadow: 0 14px 28px -8px rgba(0,0,0,.1); }
    .no-scrollbar::-webkit-scrollbar { display: none; }
    .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
</style>
</head>
<body class="bg-white text-slate-800 font-sans antialiased min-h-screen py-6 sm:py-10 px-3 sm:px-6 lg:px-8">

<div class="max-w-[1320px] mx-auto" data-purpose="catalog-layout">
  <main class="w-full min-w-0" data-purpose="catalog-container">

    <!-- Browse Categories -->
    <section class="mb-10 sm:mb-14" data-purpose="browse-categories">
      <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">Browse Categories</h2>
      <p class="text-sm text-slate-500 mt-1">Find exactly what you need using</p>
      <div id="cat-track" class="no-scrollbar flex gap-4 sm:gap-6 overflow-x-auto mt-6 sm:mt-8 pb-2 max-w-[1060px] mx-auto">
        <button class="cat-tile group shrink-0 w-[96px] sm:w-[118px] flex flex-col items-center gap-2.5 text-center focus:outline-none" type="button">
          <span class="cat-img block w-[96px] h-[96px] sm:w-[118px] sm:h-[118px] rounded-2xl sm:rounded-3xl bg-sky-50 border-2 border-transparent overflow-hidden transition-all group-hover:border-sky-200">
            <img alt="Whey Protein" class="w-full h-full object-cover" loading="lazy" src="https://images.unsplash.com/photo-1546483875-ad9014c88eba?auto=format&amp;fit=crop&amp;w=300&amp;q=80"/>
          </span>
          <span class="text-[12px] sm:text-[13px] font-medium text-slate-600 leading-tight">Whey Protein</span>
        </button>
        <button class="cat-tile group shrink-0 w-[96px] sm:w-[118px] flex flex-col items-center gap-2.5 text-center focus:outline-none" type="button">
          <span class="cat-img block w-[96px] h-[96px] sm:w-[118px] sm:h-[118px] rounded-2xl sm:rounded-3xl bg-sky-50 border-2 border-transparent overflow-hidden transition-all group-hover:border-sky-200">
            <img alt="Creatine" class="w-full h-full object-cover" loading="lazy" src="https://images.unsplash.com/photo-1579722821273-0f6c7d44362f?auto=format&amp;fit=crop&amp;w=300&amp;q=80"/>
          </span>
          <span class="text-[12px] sm:text-[13px] font-medium text-slate-600 leading-tight">Creatine</span>
        </button>
        <button class="cat-tile group shrink-0 w-[96px] sm:w-[118px] flex flex-col items-center gap-2.5 text-center focus:outline-none" type="button">
          <span class="cat-img block w-[96px] h-[96px] sm:w-[118px] sm:h-[118px] rounded-2xl sm:rounded-3xl bg-sky-50 border-2 border-transparent overflow-hidden transition-all group-hover:border-sky-200">
            <img alt="Pre-Workout" class="w-full h-full object-cover" loading="lazy" src="https://images.unsplash.com/photo-1584735935682-2f2b69dff9d2?auto=format&amp;fit=crop&amp;w=300&amp;q=80"/>
          </span>
          <span class="text-[12px] sm:text-[13px] font-medium text-slate-600 leading-tight">Pre-Workout</span>
        </button>
        <button class="cat-tile group shrink-0 w-[96px] sm:w-[118px] flex flex-col items-center gap-2.5 text-center focus:outline-none" type="button">
          <span class="cat-img block w-[96px] h-[96px] sm:w-[118px] sm:h-[118px] rounded-2xl sm:rounded-3xl bg-sky-50 border-2 border-transparent overflow-hidden transition-all group-hover:border-sky-200">
            <img alt="Mass Gainers" class="w-full h-full object-cover" loading="lazy" src="https://images.unsplash.com/photo-1576678927484-cc907957088c?auto=format&amp;fit=crop&amp;w=300&amp;q=80"/>
          </span>
          <span class="text-[12px] sm:text-[13px] font-medium text-slate-600 leading-tight">Mass Gainers</span>
        </button>
        <button class="cat-tile group shrink-0 w-[96px] sm:w-[118px] flex flex-col items-center gap-2.5 text-center focus:outline-none" type="button">
          <span class="cat-img block w-[96px] h-[96px] sm:w-[118px] sm:h-[118px] rounded-2xl sm:rounded-3xl bg-sky-50 border-2 border-transparent overflow-hidden transition-all group-hover:border-sky-200">
            <img alt="Amino Acids" class="w-full h-full object-cover" loading="lazy" src="https://images.unsplash.com/photo-1517838277536-f5f99be501cd?auto=format&amp;fit=crop&amp;w=300&amp;q=80"/>
          </span>
          <span class="text-[12px] sm:text-[13px] font-medium text-slate-600 leading-tight">Amino Acids</span>
        </button>
        <button class="cat-tile group shrink-0 w-[96px] sm:w-[118px] flex flex-col items-center gap-2.5 text-center focus:outline-none" type="button">
          <span class="cat-img block w-[96px] h-[96px] sm:w-[118px] sm:h-[118px] rounded-2xl sm:rounded-3xl bg-sky-50 border-2 border-transparent overflow-hidden transition-all group-hover:border-sky-200">
            <img alt="Recovery" class="w-full h-full object-cover" loading="lazy" src="https://images.unsplash.com/photo-1594882645126-14020914d58d?auto=format&amp;fit=crop&amp;w=300&amp;q=80"/>
          </span>
          <span class="text-[12px] sm:text-[13px] font-medium text-slate-600 leading-tight">Recovery</span>
        </button>
        <button class="cat-tile group shrink-0 w-[96px] sm:w-[118px] flex flex-col items-center gap-2.5 text-center focus:outline-none" type="button">
          <span class="cat-img block w-[96px] h-[96px] sm:w-[118px] sm:h-[118px] rounded-2xl sm:rounded-3xl bg-sky-50 border-2 border-transparent overflow-hidden transition-all group-hover:border-sky-200">
            <img alt="Fat Burners" class="w-full h-full object-cover" loading="lazy" src="https://images.unsplash.com/photo-1550572017-edd951b55104?auto=format&amp;fit=crop&amp;w=300&amp;q=80"/>
          </span>
          <span class="text-[12px] sm:text-[13px] font-medium text-slate-600 leading-tight">Fat Burners</span>
        </button>
        <button class="cat-tile group shrink-0 w-[96px] sm:w-[118px] flex flex-col items-center gap-2.5 text-center focus:outline-none" type="button">
          <span class="cat-img block w-[96px] h-[96px] sm:w-[118px] sm:h-[118px] rounded-2xl sm:rounded-3xl bg-sky-50 border-2 border-transparent overflow-hidden transition-all group-hover:border-sky-200">
            <img alt="Vitamins & Omega" class="w-full h-full object-cover" loading="lazy" src="https://images.unsplash.com/photo-1584308666744-24d5c474f2ae?auto=format&amp;fit=crop&amp;w=300&amp;q=80"/>
          </span>
          <span class="text-[12px] sm:text-[13px] font-medium text-slate-600 leading-tight">Vitamins &amp; Omega</span>
        </button>
      </div>
    </section>

    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
      <div>
        <h1 class="text-xl sm:text-2xl font-extrabold text-slate-900 tracking-tight">Pro Gym Supplements</h1>
        <p class="text-xs text-slate-500 mt-0.5">Showing affordable fitness formulas for maximum gains</p>
      </div>
      <div class="flex items-center justify-between sm:justify-end gap-2 text-xs font-semibold text-slate-700">
        <span>Sort by:</span>
        <select class="bg-white border border-slate-300 rounded-lg px-3 py-1.5 focus:ring-sky-500 focus:border-sky-500">
          <option>Featured Products</option>
          <option>Price: Low to High</option>
          <option>Price: High to Low</option>
          <option>Customer Rating</option>
        </select>
      </div>
    </div>

    <!-- Responsive grid: 2 per row on mobile, then 3 / 4 / 5 per row as the screen widens -->
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-3 sm:gap-5">

      <!-- Product 1 -->
      <article class="product-card relative flex flex-col bg-white rounded-2xl sm:rounded-3xl shadow-sm border border-slate-100 p-3 sm:p-4" data-purpose="product-card">
        <span class="absolute top-3 left-3 sm:top-4 sm:left-4 z-10 bg-sky-500 text-white text-[10px] sm:text-xs font-extrabold px-2.5 py-1 rounded-full">7% OFF</span>
        <a href="product/product-detail.php?id=1" class="flex items-center justify-center h-32 sm:h-44 mb-3 sm:mb-4">
          <img alt="Whey Protein Isolate" class="max-h-full max-w-[85%] object-contain" loading="lazy" src="https://images.unsplash.com/photo-1546483875-ad9014c88eba?auto=format&amp;fit=crop&amp;w=500&amp;q=80"/>
        </a>
        <a href="product/product-detail.php?id=1" class="block text-[13px] sm:text-[15px] text-slate-700 leading-snug line-clamp-2 min-h-[2.4rem] sm:min-h-[2.6rem] hover:text-sky-600 transition-colors">Apex Platinum Whey Isolate</a>
        <div class="flex items-center gap-1 mt-1 text-xs">
          <i class="fa-solid fa-star text-amber-400 text-[11px]"></i>
          <span class="font-bold text-slate-800">4.9</span>
          <span class="text-slate-400">(24)</span>
        </div>
        <div class="flex items-end justify-between gap-2 mt-auto pt-2">
          <div class="flex flex-wrap items-baseline gap-x-1.5 min-w-0">
            <span class="text-[14px] sm:text-lg font-extrabold text-slate-900 whitespace-nowrap">UGX 185,000</span>
            <span class="text-[11px] text-slate-400 whitespace-nowrap">/2kg</span>
            <span class="text-[11px] sm:text-xs text-slate-400 line-through whitespace-nowrap">199,000</span>
          </div>
          <button aria-label="Add Whey Protein Isolate to cart" class="add-btn shrink-0 w-8 h-8 sm:w-10 sm:h-10 rounded-full bg-sky-500 hover:bg-sky-600 text-white flex items-center justify-center transition-colors active:scale-95" type="button">
            <i class="fa-solid fa-plus text-xs sm:text-sm"></i>
          </button>
        </div>
      </article>

      <!-- Product 2 -->
      <article class="product-card relative flex flex-col bg-white rounded-2xl sm:rounded-3xl shadow-sm border border-slate-100 p-3 sm:p-4" data-purpose="product-card">
        <span class="absolute top-3 left-3 sm:top-4 sm:left-4 z-10 bg-sky-500 text-white text-[10px] sm:text-xs font-extrabold px-2.5 py-1 rounded-full">8% OFF</span>
        <a href="product/product-detail.php?id=2" class="flex items-center justify-center h-32 sm:h-44 mb-3 sm:mb-4">
          <img alt="Micronized Creatine Monohydrate" class="max-h-full max-w-[85%] object-contain" loading="lazy" src="https://images.unsplash.com/photo-1579722821273-0f6c7d44362f?auto=format&amp;fit=crop&amp;w=500&amp;q=80"/>
        </a>
        <a href="product/product-detail.php?id=2" class="block text-[13px] sm:text-[15px] text-slate-700 leading-snug line-clamp-2 min-h-[2.4rem] sm:min-h-[2.6rem] hover:text-sky-600 transition-colors">Pure Creatine Monohydrate</a>
        <div class="flex items-center gap-1 mt-1 text-xs">
          <i class="fa-solid fa-star text-amber-400 text-[11px]"></i>
          <span class="font-bold text-slate-800">4.8</span>
          <span class="text-slate-400">(18)</span>
        </div>
        <div class="flex items-end justify-between gap-2 mt-auto pt-2">
          <div class="flex flex-wrap items-baseline gap-x-1.5 min-w-0">
            <span class="text-[14px] sm:text-lg font-extrabold text-slate-900 whitespace-nowrap">UGX 115,000</span>
            <span class="text-[11px] text-slate-400 whitespace-nowrap">/300g</span>
            <span class="text-[11px] sm:text-xs text-slate-400 line-through whitespace-nowrap">125,000</span>
          </div>
          <button aria-label="Add Micronized Creatine Monohydrate to cart" class="add-btn shrink-0 w-8 h-8 sm:w-10 sm:h-10 rounded-full bg-sky-500 hover:bg-sky-600 text-white flex items-center justify-center transition-colors active:scale-95" type="button">
            <i class="fa-solid fa-plus text-xs sm:text-sm"></i>
          </button>
        </div>
      </article>

      <!-- Product 3 -->
      <article class="product-card relative flex flex-col bg-white rounded-2xl sm:rounded-3xl shadow-sm border border-slate-100 p-3 sm:p-4" data-purpose="product-card">
        <span class="absolute top-3 left-3 sm:top-4 sm:left-4 z-10 bg-sky-500 text-white text-[10px] sm:text-xs font-extrabold px-2.5 py-1 rounded-full">10% OFF</span>
        <a href="product/product-detail.php?id=3" class="flex items-center justify-center h-32 sm:h-44 mb-3 sm:mb-4">
          <img alt="Pre-Workout Energy Formula" class="max-h-full max-w-[85%] object-contain" loading="lazy" src="https://images.unsplash.com/photo-1584735935682-2f2b69dff9d2?auto=format&amp;fit=crop&amp;w=500&amp;q=80"/>
        </a>
        <a href="product/product-detail.php?id=3" class="block text-[13px] sm:text-[15px] text-slate-700 leading-snug line-clamp-2 min-h-[2.4rem] sm:min-h-[2.6rem] hover:text-sky-600 transition-colors">Vortex Pre-Workout Blast</a>
        <div class="flex items-center gap-1 mt-1 text-xs">
          <i class="fa-solid fa-star text-amber-400 text-[11px]"></i>
          <span class="font-bold text-slate-800">4.7</span>
          <span class="text-slate-400">(15)</span>
        </div>
        <div class="flex items-end justify-between gap-2 mt-auto pt-2">
          <div class="flex flex-wrap items-baseline gap-x-1.5 min-w-0">
            <span class="text-[14px] sm:text-lg font-extrabold text-slate-900 whitespace-nowrap">UGX 135,000</span>
            <span class="text-[11px] text-slate-400 whitespace-nowrap">/30 serv</span>
            <span class="text-[11px] sm:text-xs text-slate-400 line-through whitespace-nowrap">150,000</span>
          </div>
          <button aria-label="Add Pre-Workout Energy Formula to cart" class="add-btn shrink-0 w-8 h-8 sm:w-10 sm:h-10 rounded-full bg-sky-500 hover:bg-sky-600 text-white flex items-center justify-center transition-colors active:scale-95" type="button">
            <i class="fa-solid fa-plus text-xs sm:text-sm"></i>
          </button>
        </div>
      </article>

      <!-- Product 4 -->
      <article class="product-card relative flex flex-col bg-white rounded-2xl sm:rounded-3xl shadow-sm border border-slate-100 p-3 sm:p-4" data-purpose="product-card">
        <span class="absolute top-3 left-3 sm:top-4 sm:left-4 z-10 bg-sky-500 text-white text-[10px] sm:text-xs font-extrabold px-2.5 py-1 rounded-full">8% OFF</span>
        <a href="product/product-detail.php?id=4" class="flex items-center justify-center h-32 sm:h-44 mb-3 sm:mb-4">
          <img alt="Mass Gainer Protein Tub" class="max-h-full max-w-[85%] object-contain" loading="lazy" src="https://images.unsplash.com/photo-1576678927484-cc907957088c?auto=format&amp;fit=crop&amp;w=500&amp;q=80"/>
        </a>
        <a href="product/product-detail.php?id=4" class="block text-[13px] sm:text-[15px] text-slate-700 leading-snug line-clamp-2 min-h-[2.4rem] sm:min-h-[2.6rem] hover:text-sky-600 transition-colors">Titan Mass Gainer 1000</a>
        <div class="flex items-center gap-1 mt-1 text-xs">
          <i class="fa-solid fa-star text-amber-400 text-[11px]"></i>
          <span class="font-bold text-slate-800">4.6</span>
          <span class="text-slate-400">(12)</span>
        </div>
        <div class="flex items-end justify-between gap-2 mt-auto pt-2">
          <div class="flex flex-wrap items-baseline gap-x-1.5 min-w-0">
            <span class="text-[14px] sm:text-lg font-extrabold text-slate-900 whitespace-nowrap">UGX 220,000</span>
            <span class="text-[11px] text-slate-400 whitespace-nowrap">/5kg</span>
            <span class="text-[11px] sm:text-xs text-slate-400 line-through whitespace-nowrap">240,000</span>
          </div>
          <button aria-label="Add Mass Gainer Protein Tub to cart" class="add-btn shrink-0 w-8 h-8 sm:w-10 sm:h-10 rounded-full bg-sky-500 hover:bg-sky-600 text-white flex items-center justify-center transition-colors active:scale-95" type="button">
            <i class="fa-solid fa-plus text-xs sm:text-sm"></i>
          </button>
        </div>
      </article>

      <!-- Product 5 -->
      <article class="product-card relative flex flex-col bg-white rounded-2xl sm:rounded-3xl shadow-sm border border-slate-100 p-3 sm:p-4" data-purpose="product-card">
        <span class="absolute top-3 left-3 sm:top-4 sm:left-4 z-10 bg-sky-500 text-white text-[10px] sm:text-xs font-extrabold px-2.5 py-1 rounded-full">5% OFF</span>
        <a href="product/product-detail.php?id=5" class="flex items-center justify-center h-32 sm:h-44 mb-3 sm:mb-4">
          <img alt="BCAA Amino Supplement" class="max-h-full max-w-[85%] object-contain" loading="lazy" src="https://images.unsplash.com/photo-1517838277536-f5f99be501cd?auto=format&amp;fit=crop&amp;w=500&amp;q=80"/>
        </a>
        <a href="product/product-detail.php?id=5" class="block text-[13px] sm:text-[15px] text-slate-700 leading-snug line-clamp-2 min-h-[2.4rem] sm:min-h-[2.6rem] hover:text-sky-600 transition-colors">BCAA 2:1:1 Recovery Matrix</a>
        <div class="flex items-center gap-1 mt-1 text-xs">
          <i class="fa-solid fa-star text-amber-400 text-[11px]"></i>
          <span class="font-bold text-slate-800">4.8</span>
          <span class="text-slate-400">(20)</span>
        </div>
        <div class="flex items-end justify-between gap-2 mt-auto pt-2">
          <div class="flex flex-wrap items-baseline gap-x-1.5 min-w-0">
            <span class="text-[14px] sm:text-lg font-extrabold text-slate-900 whitespace-nowrap">UGX 95,000</span>
            <span class="text-[11px] text-slate-400 whitespace-nowrap">/400g</span>
            <span class="text-[11px] sm:text-xs text-slate-400 line-through whitespace-nowrap">100,000</span>
          </div>
          <button aria-label="Add BCAA Amino Supplement to cart" class="add-btn shrink-0 w-8 h-8 sm:w-10 sm:h-10 rounded-full bg-sky-500 hover:bg-sky-600 text-white flex items-center justify-center transition-colors active:scale-95" type="button">
            <i class="fa-solid fa-plus text-xs sm:text-sm"></i>
          </button>
        </div>
      </article>

      <!-- Product 6 -->
      <article class="product-card relative flex flex-col bg-white rounded-2xl sm:rounded-3xl shadow-sm border border-slate-100 p-3 sm:p-4" data-purpose="product-card">
        <span class="absolute top-3 left-3 sm:top-4 sm:left-4 z-10 bg-sky-500 text-white text-[10px] sm:text-xs font-extrabold px-2.5 py-1 rounded-full">6% OFF</span>
        <a href="product/product-detail.php?id=6" class="flex items-center justify-center h-32 sm:h-44 mb-3 sm:mb-4">
          <img alt="Glutamine Powder" class="max-h-full max-w-[85%] object-contain" loading="lazy" src="https://images.unsplash.com/photo-1594882645126-14020914d58d?auto=format&amp;fit=crop&amp;w=500&amp;q=80"/>
        </a>
        <a href="product/product-detail.php?id=6" class="block text-[13px] sm:text-[15px] text-slate-700 leading-snug line-clamp-2 min-h-[2.4rem] sm:min-h-[2.6rem] hover:text-sky-600 transition-colors">Pure L-Glutamine Powder</a>
        <div class="flex items-center gap-1 mt-1 text-xs">
          <i class="fa-solid fa-star text-amber-400 text-[11px]"></i>
          <span class="font-bold text-slate-800">4.5</span>
          <span class="text-slate-400">(9)</span>
        </div>
        <div class="flex items-end justify-between gap-2 mt-auto pt-2">
          <div class="flex flex-wrap items-baseline gap-x-1.5 min-w-0">
            <span class="text-[14px] sm:text-lg font-extrabold text-slate-900 whitespace-nowrap">UGX 85,000</span>
            <span class="text-[11px] text-slate-400 whitespace-nowrap">/300g</span>
            <span class="text-[11px] sm:text-xs text-slate-400 line-through whitespace-nowrap">90,000</span>
          </div>
          <button aria-label="Add Glutamine Powder to cart" class="add-btn shrink-0 w-8 h-8 sm:w-10 sm:h-10 rounded-full bg-sky-500 hover:bg-sky-600 text-white flex items-center justify-center transition-colors active:scale-95" type="button">
            <i class="fa-solid fa-plus text-xs sm:text-sm"></i>
          </button>
        </div>
      </article>

      <!-- Product 7 -->
      <article class="product-card relative flex flex-col bg-white rounded-2xl sm:rounded-3xl shadow-sm border border-slate-100 p-3 sm:p-4" data-purpose="product-card">
        <span class="absolute top-3 left-3 sm:top-4 sm:left-4 z-10 bg-sky-500 text-white text-[10px] sm:text-xs font-extrabold px-2.5 py-1 rounded-full">11% OFF</span>
        <a href="product/product-detail.php?id=7" class="flex items-center justify-center h-32 sm:h-44 mb-3 sm:mb-4">
          <img alt="Thermo Shred Capsules" class="max-h-full max-w-[85%] object-contain" loading="lazy" src="https://images.unsplash.com/photo-1550572017-edd951b55104?auto=format&amp;fit=crop&amp;w=500&amp;q=80"/>
        </a>
        <a href="product/product-detail.php?id=7" class="block text-[13px] sm:text-[15px] text-slate-700 leading-snug line-clamp-2 min-h-[2.4rem] sm:min-h-[2.6rem] hover:text-sky-600 transition-colors">ThermoShred Pro Capsules</a>
        <div class="flex items-center gap-1 mt-1 text-xs">
          <i class="fa-solid fa-star text-amber-400 text-[11px]"></i>
          <span class="font-bold text-slate-800">4.7</span>
          <span class="text-slate-400">(14)</span>
        </div>
        <div class="flex items-end justify-between gap-2 mt-auto pt-2">
          <div class="flex flex-wrap items-baseline gap-x-1.5 min-w-0">
            <span class="text-[14px] sm:text-lg font-extrabold text-slate-900 whitespace-nowrap">UGX 125,000</span>
            <span class="text-[11px] text-slate-400 whitespace-nowrap">/60 caps</span>
            <span class="text-[11px] sm:text-xs text-slate-400 line-through whitespace-nowrap">140,000</span>
          </div>
          <button aria-label="Add Thermo Shred Capsules to cart" class="add-btn shrink-0 w-8 h-8 sm:w-10 sm:h-10 rounded-full bg-sky-500 hover:bg-sky-600 text-white flex items-center justify-center transition-colors active:scale-95" type="button">
            <i class="fa-solid fa-plus text-xs sm:text-sm"></i>
          </button>
        </div>
      </article>

      <!-- Product 8 -->
      <article class="product-card relative flex flex-col bg-white rounded-2xl sm:rounded-3xl shadow-sm border border-slate-100 p-3 sm:p-4" data-purpose="product-card">
        <span class="absolute top-3 left-3 sm:top-4 sm:left-4 z-10 bg-sky-500 text-white text-[10px] sm:text-xs font-extrabold px-2.5 py-1 rounded-full">6% OFF</span>
        <a href="product/product-detail.php?id=8" class="flex items-center justify-center h-32 sm:h-44 mb-3 sm:mb-4">
          <img alt="Omega 3 Fish Oil Softgels" class="max-h-full max-w-[85%] object-contain" loading="lazy" src="https://images.unsplash.com/photo-1584308666744-24d5c474f2ae?auto=format&amp;fit=crop&amp;w=500&amp;q=80"/>
        </a>
        <a href="product/product-detail.php?id=8" class="block text-[13px] sm:text-[15px] text-slate-700 leading-snug line-clamp-2 min-h-[2.4rem] sm:min-h-[2.6rem] hover:text-sky-600 transition-colors">Omega-3 Triple Strength</a>
        <div class="flex items-center gap-1 mt-1 text-xs">
          <i class="fa-solid fa-star text-amber-400 text-[11px]"></i>
          <span class="font-bold text-slate-800">4.9</span>
          <span class="text-slate-400">(31)</span>
        </div>
        <div class="flex items-end justify-between gap-2 mt-auto pt-2">
          <div class="flex flex-wrap items-baseline gap-x-1.5 min-w-0">
            <span class="text-[14px] sm:text-lg font-extrabold text-slate-900 whitespace-nowrap">UGX 75,000</span>
            <span class="text-[11px] text-slate-400 whitespace-nowrap">/90 caps</span>
            <span class="text-[11px] sm:text-xs text-slate-400 line-through whitespace-nowrap">80,000</span>
          </div>
          <button aria-label="Add Omega 3 Fish Oil Softgels to cart" class="add-btn shrink-0 w-8 h-8 sm:w-10 sm:h-10 rounded-full bg-sky-500 hover:bg-sky-600 text-white flex items-center justify-center transition-colors active:scale-95" type="button">
            <i class="fa-solid fa-plus text-xs sm:text-sm"></i>
          </button>
        </div>
      </article>

    </div>

  </main>
</div>

<script data-purpose="interactive-scripts">
  document.querySelectorAll('.add-btn').forEach(btn => {
    btn.addEventListener('click', () => {
      const icon = btn.querySelector('i');
      icon.className = 'fa-solid fa-check text-xs sm:text-sm';
      setTimeout(() => icon.className = 'fa-solid fa-plus text-xs sm:text-sm', 900);
    });
  });

  // ---- Categories: auto-sliding row (loops forever, pauses on touch/hover) ----
  (function () {
    const track = document.getElementById('cat-track');
    const originals = Array.from(track.querySelectorAll('.cat-tile'));
    originals.forEach((t, i) => t.dataset.idx = i);

    originals.forEach(t => {
      const c = t.cloneNode(true);
      c.setAttribute('aria-hidden', 'true');
      c.tabIndex = -1;
      track.appendChild(c);
    });

    track.addEventListener('click', e => {
      const tile = e.target.closest('.cat-tile');
      if (!tile) return;
      track.querySelectorAll('.cat-img').forEach(box => {
        box.classList.remove('border-sky-400');
        box.classList.add('border-transparent');
      });
      track.querySelectorAll('.cat-tile[data-idx="' + tile.dataset.idx + '"] .cat-img').forEach(box => {
        box.classList.remove('border-transparent');
        box.classList.add('border-sky-400');
      });
    });

    if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;

    const SPEED = 40;
    let pos = 0, last = null, paused = false, resumeTimer = null;

    function loopWidth() {
      return track.children[originals.length].offsetLeft - track.children[0].offsetLeft;
    }
    function pause() { paused = true; clearTimeout(resumeTimer); }
    function resume(delay) {
      clearTimeout(resumeTimer);
      resumeTimer = setTimeout(() => { pos = track.scrollLeft; paused = false; }, delay);
    }

    track.addEventListener('mouseenter', pause);
    track.addEventListener('mouseleave', () => resume(300));
    track.addEventListener('touchstart', pause, { passive: true });
    track.addEventListener('touchend', () => resume(1800), { passive: true });
    track.addEventListener('wheel', () => { pause(); resume(1800); }, { passive: true });

    function step(ts) {
      if (last === null) last = ts;
      const dt = Math.min((ts - last) / 1000, 0.1);
      last = ts;
      if (!paused) {
        pos += SPEED * dt;
        const w = loopWidth();
        if (w > 0 && pos >= w) pos -= w;
        track.scrollLeft = pos;
      }
      requestAnimationFrame(step);
    }
    requestAnimationFrame(step);
  })();
</script>
</body>
</html>