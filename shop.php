<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>All Products -shop</title>
 <link href="./src/output.css" rel="stylesheet">
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
  input[type=number]::-webkit-outer-spin-button,
  input[type=number]::-webkit-inner-spin-button { -webkit-appearance: none; margin: 0; }
  input[type=number] { -moz-appearance: textfield; }
</style>
</head>
<body class="bg-white text-slate-800 font-sans antialiased min-h-screen py-5 sm:py-8 px-3 sm:px-6 lg:px-8">


<?php
 include 'includes/top.php'; 
?>


<div class="max-w-[1320px] mx-auto">

  <!-- Breadcrumb -->
  <nav class="flex items-center gap-2 text-xs text-slate-500 mb-5 sm:mb-6" aria-label="Breadcrumb">
    <a href="catalog.html" class="hover:text-sky-600 transition-colors" aria-label="Home"><i class="fa-regular fa-house"></i></a>
    <span>/</span>
    <span class="font-bold text-slate-900">All Products</span>
  </nav>

  <div class="flex flex-col lg:flex-row gap-5 lg:gap-8 items-start">

    <!-- ============ SIDEBAR: Categories + Price ============ -->
    <aside class="w-full lg:w-[240px] lg:shrink-0 lg:bg-white lg:border lg:border-slate-100 lg:shadow-sm lg:rounded-3xl lg:p-4 lg:sticky lg:top-6" data-purpose="filters">
      <h2 class="hidden lg:block text-[13px] font-bold text-slate-900 px-1 mb-3">Categories</h2>

      <!-- Chips on mobile, vertical list on desktop -->
      <div id="category-list" class="no-scrollbar flex lg:flex-col gap-2 lg:gap-1 overflow-x-auto lg:overflow-visible -mx-3 px-3 lg:mx-0 lg:px-0 pb-1 lg:pb-0"></div>

      <div class="mt-4 lg:mt-6">
        <h2 class="text-[13px] font-bold text-slate-900 px-1 mb-2">Price Range <span class="font-medium text-slate-400">(UGX)</span></h2>
        <div class="flex items-center gap-2">
          <input id="price-min" type="number" min="0" placeholder="Min" class="w-full min-w-0 h-10 px-3 text-xs bg-white border border-slate-200 rounded-xl focus:border-sky-400 focus:ring-sky-400"/>
          <span class="text-slate-400">-</span>
          <input id="price-max" type="number" min="0" placeholder="Max" class="w-full min-w-0 h-10 px-3 text-xs bg-white border border-slate-200 rounded-xl focus:border-sky-400 focus:ring-sky-400"/>
        </div>
        <button id="reset-btn" type="button" class="mt-3 text-xs font-semibold text-sky-600 hover:underline px-1">Reset filters</button>
      </div>
    </aside>

    <!-- ============ MAIN ============ -->
    <main class="flex-1 min-w-0 w-full">
      <div class="flex items-start sm:items-center justify-between gap-4 mb-5">
        <div>
          <h1 id="page-title" class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">All Products</h1>
          <p id="count" class="text-xs sm:text-sm text-slate-500 mt-0.5">25 products found</p>
        </div>
        <select id="sort" class="shrink-0 bg-white border border-slate-200 rounded-xl px-3 py-2 text-xs font-semibold text-slate-700 focus:ring-sky-400 focus:border-sky-400" aria-label="Sort products">
          <option value="newest">Newest</option>
          <option value="price-asc">Price: Low to High</option>
          <option value="price-desc">Price: High to Low</option>
          <option value="rating">Top Rated</option>
        </select>
      </div>

      <!-- 2 per row on mobile, 3 on tablet / laptop, 4 on wide screens -->
      <div id="grid" class="grid grid-cols-2 sm:grid-cols-3 xl:grid-cols-4 gap-3 sm:gap-5"></div>

      <div id="empty" class="hidden text-center py-20">
        <i class="fa-regular fa-face-frown text-3xl text-slate-300"></i>
        <p class="mt-3 font-semibold text-slate-700">No products match your filters</p>
        <button id="empty-reset" type="button" class="mt-3 text-sm font-semibold text-sky-600 hover:underline">Clear filters</button>
      </div>
    </main>
  </div>
</div>

<script>
  // ---------- Data (replace with your database / PHP output) ----------
  const CATEGORIES = ["Whey Protein","Creatine","Pre-Workout","Mass Gainers","Amino Acids","Recovery","Fat Burners","Vitamins & Omega"];
  const U = id => `https://images.unsplash.com/${id}?auto=format&fit=crop&w=500&q=80`;
  const IMG = {
    "Whey Protein": U("photo-1546483875-ad9014c88eba"),
    "Creatine": U("photo-1579722821273-0f6c7d44362f"),
    "Pre-Workout": U("photo-1584735935682-2f2b69dff9d2"),
    "Mass Gainers": U("photo-1576678927484-cc907957088c"),
    "Amino Acids": U("photo-1517838277536-f5f99be501cd"),
    "Recovery": U("photo-1594882645126-14020914d58d"),
    "Fat Burners": U("photo-1550572017-edd951b55104"),
    "Vitamins & Omega": U("photo-1584308666744-24d5c474f2ae")
  };
  // [id, name, category, price, oldPrice, unit, rating, reviews]
  const RAW = [
    [1,"Apex Platinum Whey Isolate","Whey Protein",185000,199000,"/2kg",4.9,24],
    [2,"Apex Whey Concentrate","Whey Protein",150000,165000,"/2kg",4.7,17],
    [3,"Vanilla Whey Isolate 1kg","Whey Protein",98000,105000,"/1kg",4.6,11],
    [4,"Pure Creatine Monohydrate","Creatine",115000,125000,"/300g",4.8,18],
    [5,"Creatine HCL Capsules","Creatine",90000,98000,"/120 caps",4.5,8],
    [6,"Micronized Creatine 500g","Creatine",160000,175000,"/500g",4.8,13],
    [7,"Vortex Pre-Workout Blast","Pre-Workout",135000,150000,"/30 serv",4.7,15],
    [8,"Vortex Zero Stim","Pre-Workout",125000,135000,"/30 serv",4.4,7],
    [9,"Pump Matrix Pre-Workout","Pre-Workout",140000,155000,"/30 serv",4.6,10],
    [10,"Titan Mass Gainer 1000","Mass Gainers",220000,240000,"/5kg",4.6,12],
    [11,"Lean Mass Gainer","Mass Gainers",195000,210000,"/3kg",4.5,9],
    [12,"Hardgainer Pro","Mass Gainers",250000,275000,"/6kg",4.7,14],
    [13,"BCAA 2:1:1 Recovery Matrix","Amino Acids",95000,100000,"/400g",4.8,20],
    [14,"EAA Essential Aminos","Amino Acids",110000,120000,"/450g",4.7,12],
    [15,"Aminos Energy Blend","Amino Acids",85000,90000,"/300g",4.4,6],
    [16,"Pure L-Glutamine Powder","Recovery",85000,90000,"/300g",4.5,9],
    [17,"ZMA Night Recovery","Recovery",70000,78000,"/90 caps",4.6,10],
    [18,"Tart Cherry Recovery","Recovery",80000,88000,"/60 caps",4.5,7],
    [19,"ThermoShred Pro Capsules","Fat Burners",125000,140000,"/60 caps",4.7,14],
    [20,"L-Carnitine Liquid","Fat Burners",105000,115000,"/500ml",4.5,9],
    [21,"CLA Shred Softgels","Fat Burners",90000,98000,"/90 softgels",4.4,6],
    [22,"Omega-3 Triple Strength","Vitamins & Omega",75000,80000,"/90 caps",4.9,31],
    [23,"Daily Multivitamin Pack","Vitamins & Omega",65000,70000,"/60 tabs",4.6,16],
    [24,"Vitamin D3 + K2","Vitamins & Omega",55000,60000,"/60 caps",4.7,11],
    [25,"Magnesium Complex","Vitamins & Omega",60000,65000,"/90 caps",4.5,8]
  ];
  const PRODUCTS = RAW.map(([id,name,cat,price,old,unit,rating,reviews]) =>
    ({ id, name, cat, price, old, unit, rating, reviews, img: IMG[cat], off: Math.round((old - price) / old * 100) }));

  // ---------- State ----------
  const state = { cat: "All Categories", min: null, max: null, sort: "newest" };
  const $ = id => document.getElementById(id);
  const esc = s => s.replace(/&/g, "&amp;").replace(/</g, "&lt;");
  const fmt = n => n.toLocaleString("en-US");

  // ---------- Categories ----------
  function renderCategories() {
    $("category-list").innerHTML = ["All Categories", ...CATEGORIES].map(c => {
      const active = c === state.cat;
      return `<button type="button" data-cat="${esc(c)}"
        class="cat-btn shrink-0 text-left whitespace-nowrap px-4 py-2 lg:py-2.5 rounded-full lg:rounded-xl text-[13px] transition-colors
        ${active ? "bg-slate-900 text-white font-bold" : "bg-slate-50 lg:bg-transparent text-slate-600 font-medium hover:bg-sky-50 hover:text-sky-700"}">${esc(c)}</button>`;
    }).join("");
  }

  // ---------- Products ----------
  function cardHTML(p) {
    return `
    <article class="product-card relative flex flex-col bg-white rounded-2xl sm:rounded-3xl shadow-sm border border-slate-100 p-3 sm:p-4">
      <span class="absolute top-3 left-3 sm:top-4 sm:left-4 z-10 bg-sky-500 text-white text-[10px] sm:text-xs font-extrabold px-2.5 py-1 rounded-full">${p.off}% OFF</span>
      <a href="product/product-detail.php?id=${p.id}" class="flex items-center justify-center h-32 sm:h-44 mb-3 sm:mb-4">
        <img alt="${esc(p.name)}" class="max-h-full max-w-[85%] object-contain" loading="lazy" src="${p.img}"/>
      </a>
      <a href="product/product-detail.php?id=${p.id}" class="block text-[13px] sm:text-[15px] text-slate-700 leading-snug line-clamp-2 min-h-[2.4rem] sm:min-h-[2.6rem] hover:text-sky-600 transition-colors">${esc(p.name)}</a>
      <div class="flex items-center gap-1 mt-1 text-xs">
        <i class="fa-solid fa-star text-amber-400 text-[11px]"></i>
        <span class="font-bold text-slate-800">${p.rating.toFixed(1)}</span>
        <span class="text-slate-400">(${p.reviews})</span>
      </div>
      <div class="flex items-end justify-between gap-2 mt-auto pt-2">
        <div class="flex flex-wrap items-baseline gap-x-1.5 min-w-0">
          <span class="text-[14px] sm:text-lg font-extrabold text-slate-900 whitespace-nowrap">UGX ${fmt(p.price)}</span>
          <span class="text-[11px] text-slate-400 whitespace-nowrap">${esc(p.unit)}</span>
          <span class="text-[11px] sm:text-xs text-slate-400 line-through whitespace-nowrap">${fmt(p.old)}</span>
        </div>
        <button type="button" aria-label="Add ${esc(p.name)} to cart" class="add-btn shrink-0 w-8 h-8 sm:w-10 sm:h-10 rounded-full bg-sky-500 hover:bg-sky-600 text-white flex items-center justify-center transition-colors active:scale-95">
          <i class="fa-solid fa-plus text-xs sm:text-sm"></i>
        </button>
      </div>
    </article>`;
  }

  function renderProducts() {
    let list = PRODUCTS.filter(p =>
      (state.cat === "All Categories" || p.cat === state.cat) &&
      (state.min === null || p.price >= state.min) &&
      (state.max === null || p.price <= state.max));

    const sorters = {
      "newest": (a, b) => b.id - a.id,
      "price-asc": (a, b) => a.price - b.price,
      "price-desc": (a, b) => b.price - a.price,
      "rating": (a, b) => b.rating - a.rating || b.reviews - a.reviews
    };
    list.sort(sorters[state.sort]);

    $("grid").innerHTML = list.map(cardHTML).join("");
    $("grid").classList.toggle("hidden", list.length === 0);
    $("empty").classList.toggle("hidden", list.length !== 0);
    $("count").textContent = list.length + (list.length === 1 ? " product found" : " products found");
    $("page-title").textContent = state.cat === "All Categories" ? "All Products" : state.cat;
  }

  function update() { renderCategories(); renderProducts(); }

  // ---------- Events ----------
  $("category-list").addEventListener("click", e => {
    const b = e.target.closest(".cat-btn");
    if (!b) return;
    state.cat = b.dataset.cat;
    update();
  });
  $("sort").addEventListener("change", e => { state.sort = e.target.value; renderProducts(); });
  const num = v => (v === "" ? null : Math.max(0, Number(v)));
  $("price-min").addEventListener("input", e => { state.min = num(e.target.value); renderProducts(); });
  $("price-max").addEventListener("input", e => { state.max = num(e.target.value); renderProducts(); });

  function resetAll() {
    state.cat = "All Categories"; state.min = null; state.max = null; state.sort = "newest";
    $("price-min").value = ""; $("price-max").value = ""; $("sort").value = "newest";
    update();
  }
  $("reset-btn").addEventListener("click", resetAll);
  $("empty-reset").addEventListener("click", resetAll);

  // Add-to-cart button feedback (event delegation, works after re-render)
  $("grid").addEventListener("click", e => {
    const btn = e.target.closest(".add-btn");
    if (!btn) return;
    const icon = btn.querySelector("i");
    icon.className = "fa-solid fa-check text-xs sm:text-sm";
    setTimeout(() => icon.className = "fa-solid fa-plus text-xs sm:text-sm", 900);
  });

  // Preselect a category from the URL, e.g. products.html?cat=Creatine
  const urlCat = new URLSearchParams(location.search).get("cat");
  if (urlCat && CATEGORIES.includes(urlCat)) state.cat = urlCat;

  update();
</script>
</body>
</html>