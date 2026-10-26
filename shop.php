<?php
// Step out to root to require database connection
require_once __DIR__ . '/includes/db_connect.php';

// Start session to check for logged-in user
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$userId = isset($_SESSION['user_id']) ? (int)$_SESSION['user_id'] : 0;

try {
    // 1. Fetch Categories dynamically from database
    $catStmt =$pdo->query("SELECT DISTINCT name FROM categories ORDER BY name ASC");
    $dbCategories =$catStmt->fetchAll(PDO::FETCH_COLUMN);

    if (empty($dbCategories)) {
        $catStmt =$pdo->query("SELECT DISTINCT category FROM products WHERE category IS NOT NULL AND category != '' ORDER BY category ASC");
        $dbCategories =$catStmt->fetchAll(PDO::FETCH_COLUMN);
    }

    // 2. Capture parameters from URL (Search query, Category, Price Range, Sort)
    $searchQuery = isset($_GET['q']) ? trim($_GET['q']) : '';$selectedCat = isset($_GET['cat']) ? trim($_GET['cat']) : 'All Categories';
    $minPrice    = isset($_GET['min']) && $_GET['min'] !== '' ? (float)$_GET['min'] : null;
    $maxPrice    = isset($_GET['max']) && $_GET['max'] !== '' ? (float)$_GET['max'] : null;
    $sortOption  = isset($_GET['sort']) ? trim($_GET['sort']) : 'newest';

    // 3. Build Database Query with Prepared Statements
    $sql = "
        SELECT 
            p.id, 
            p.product_name AS name, 
            p.category AS cat, 
            p.product_price AS price, 
            p.offer_price AS offer, 
            p.discount_percentage AS discount, 
            p.unit_type AS unit, 
            p.image_primary AS img,
            COALESCE(ROUND(AVG(c.rating), 1), 0) AS real_rating,
            COUNT(c.id) AS real_reviews
        FROM products p
        LEFT JOIN comments c ON p.id = c.product_id
        WHERE 1=1
    ";
    
    $params = [];

    // Search Query Condition: Matches products starting with the typed letter/word
    if ($searchQuery !== '') {$sql .= " AND (p.product_name LIKE ? OR p.category LIKE ?)";
        $params[] = "{$searchQuery}%";
        $params[] = "{$searchQuery}%";
    }

    // Category Condition
    if ($selectedCat !== 'All Categories' && $selectedCat !== '') {$sql .= " AND p.category = ?";
        $params[] =$selectedCat;
    }

    // Price Range Condition
    if ($minPrice !== null) {$sql .= " AND (CASE WHEN p.offer_price > 0 AND p.offer_price < p.product_price THEN p.offer_price ELSE p.product_price END) >= ?";
        $params[] =$minPrice;
    }
    if ($maxPrice !== null) {$sql .= " AND (CASE WHEN p.offer_price > 0 AND p.offer_price < p.product_price THEN p.offer_price ELSE p.product_price END) <= ?";
        $params[] =$maxPrice;
    }

    $sql .= " GROUP BY p.id";

    // Sorting Condition
    switch ($sortOption) {
        case 'price-asc':
            $sql .= " ORDER BY (CASE WHEN p.offer_price > 0 AND p.offer_price < p.product_price THEN p.offer_price ELSE p.product_price END) ASC";
            break;
        case 'price-desc':
            $sql .= " ORDER BY (CASE WHEN p.offer_price > 0 AND p.offer_price < p.product_price THEN p.offer_price ELSE p.product_price END) DESC";
            break;
        case 'rating':
            $sql .= " ORDER BY real_rating DESC, real_reviews DESC";
            break;
        case 'newest':
        default:
            $sql .= " ORDER BY p.id DESC";
            break;
    }

    $productStmt = $pdo->prepare($sql);
    $productStmt->execute($params);
    $dbProducts =$productStmt->fetchAll(PDO::FETCH_ASSOC);

    // 4. Fetch user's wishlist IDs directly from database
    $userWishlist = [];
    if ($userId > 0) {
        $wishStmt =$pdo->prepare("SELECT product_id FROM wishlist WHERE user_id = ?");
        $wishStmt->execute([$userId]);
        $userWishlist = array_map('intval',$wishStmt->fetchAll(PDO::FETCH_COLUMN));
    }

    // Format products array for JavaScript rendering
    $formattedProducts = array_map(function($p) {
        $price = (float)$p['price'];
        $offer = (float)$p['offer'];
        $effectivePrice = ($offer > 0 && $offer <$price) ? $offer :$price;
        $discount = (float)$p['discount'];
        
        if ($discount <= 0 &&$offer > 0 && $offer <$price) {
            $discount = round((($price - $offer) /$price) * 100);
        }

        return [
            'id'      => (int)$p['id'],
            'name'    => $p['name'],
            'cat'     => $p['cat'] ?: 'General',
            'price'   => $effectivePrice,
            'old'     => ($offer > 0 &&$offer < $price) ?$price : null,
            'unit'    => $p['unit'] ? ('/' .$p['unit']) : '',
            'rating'  => (float)$p['real_rating'], 
            'reviews' => (int)$p['real_reviews'],  
            'off'     => round($discount),
            'img'     => !empty($p['img']) ?$p['img'] : 'https://images.unsplash.com/photo-1546483875-ad9014c88eba?auto=format&fit=crop&w=500&q=80'
        ];
    }, $dbProducts);

} catch (\PDOException $e) {
    error_log("Database Error in shop page: " . $e->getMessage());$dbCategories = [];
    $formattedProducts = [];$userWishlist = [];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>All Products - Shop</title>
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

  @keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
  }
  .turning-circle {
    border: 2px solid #e2e8f0;
    border-top: 2px solid #2563eb;
    border-radius: 50%;
    width: 18px;
    height: 18px;
    animation: spin 0.8s linear infinite;
  }
</style>
</head>
<body class="bg-white text-slate-800 font-sans antialiased min-h-screen py-3 sm:py-8 px-2 sm:px-6 lg:px-8">

<?php include 'includes/searchtop.php'; ?>  <br>

<!-- FLOATING SUCCESS TOAST NOTIFICATION -->
<div id="toast-msg" class="fixed bottom-6 right-6 z-50 flex items-center gap-3 bg-slate-900 text-white px-5 py-3.5 rounded-2xl shadow-xl transition-all duration-300 opacity-0 translate-y-4 pointer-events-none">
  <div class="w-6 h-6 rounded-full bg-emerald-500 text-white flex items-center justify-center shrink-0 text-xs font-bold">
    <i class="fa-solid fa-check"></i>
  </div>
  <span id="toast-text" class="text-xs sm:text-sm font-semibold">Added to cart successfully!</span>
</div>

<div class="max-w-[1320px] mx-auto">

  <!-- Breadcrumb -->
  <nav class="flex items-center gap-2 text-xs text-slate-500 mb-4 sm:mb-6" aria-label="Breadcrumb">
    <a href="index.php" class="hover:text-sky-600 transition-colors" aria-label="Home"><i class="fa-solid fa-house"></i></a>
    <span>/</span>
    <span class="font-bold text-slate-900">All Products</span>
  </nav>

  <div class="flex flex-col lg:flex-row gap-5 lg:gap-8 items-start">

    <!-- ============ SIDEBAR: Categories + Price ============ -->
    <aside class="w-full lg:w-[240px] lg:shrink-0 lg:bg-white lg:border lg:border-slate-100 lg:shadow-sm lg:rounded-3xl lg:p-4 lg:sticky lg:top-6" data-purpose="filters">
      <h2 class="hidden lg:block text-[13px] font-bold text-slate-900 px-1 mb-3">Categories</h2>

      <!-- Dynamic Category Chips -->
      <div id="category-list" class="no-scrollbar flex lg:flex-col gap-2 lg:gap-1 overflow-x-auto lg:overflow-visible -mx-2 px-2 lg:mx-0 lg:px-0 pb-1 lg:pb-0"></div>

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
    <main class="flex-1 min-w-0 w-full relative min-h-[400px]">
      <div class="flex items-center justify-between gap-2 mb-4 sm:mb-5">
        <div>
          <h1 id="page-title" class="text-xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">All Products</h1>
          <p id="count" class="text-xs sm:text-sm text-slate-500 mt-0.5">0 products found</p>
        </div>
        <select id="sort" class="shrink-0 bg-white border border-slate-200 rounded-xl px-2 py-1.5 sm:px-3 sm:py-2 text-xs font-semibold text-slate-700 focus:ring-sky-400 focus:border-sky-400" aria-label="Sort products">
          <option value="newest">Newest</option>
          <option value="price-asc">Price: Low to High</option>
          <option value="price-desc">Price: High to Low</option>
          <option value="rating">Top Rated</option>
        </select>
      </div>

      <!-- TURNING CIRCULAR BLUE LOADER -->
      <div id="loading-spinner" class="hidden flex flex-col items-center justify-center py-24 w-full">
        <div class="turning-circle"></div>
      </div>

      <!-- Products Grid: Locked to 2 columns on mobile screens -->
      <div id="grid" class="grid grid-cols-2 sm:grid-cols-3 xl:grid-cols-4 gap-2.5 sm:gap-4"></div>

      <div id="empty" class="hidden text-center py-20">
        <i class="fa-regular fa-face-frown text-3xl text-slate-300"></i>
        <p class="mt-3 font-semibold text-slate-700">No products match your filters</p>
        <button id="empty-reset" type="button" class="mt-3 text-sm font-semibold text-sky-600 hover:underline">Clear filters</button>
      </div>
    </main>
  </div>
</div>









<script>
  // Dynamic JSON injected directly from database PDO queries
  const CATEGORIES = <?= json_encode($dbCategories, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP) ?>;
  const PRODUCTS = <?= json_encode($formattedProducts, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP) ?>;
  
  // Database-backed wishlist state for current user
  let userWishlist = <?= json_encode($userWishlist, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP) ?>;
  const isLoggedIn = <?= $userId > 0 ? 'true' : 'false' ?>;

  // State Management
  const state = { cat: "All Categories", min: null, max: null, sort: "newest" };
  const $ = id => document.getElementById(id);
  const esc = s => String(s).replace(/&/g, "&amp;").replace(/</g, "&lt;").replace(/>/g, "&gt;");
  const fmt = n => Number(n).toLocaleString("en-US");

  let loadTimer = null;
  let toastTimer = null;

  // Update the floating wishlist counter badge
  function updateWishlistCounter() {
    const counterEl = $("wishlist-counter");
    if (counterEl) {
      counterEl.textContent = userWishlist.length;
    }
  }

  // Toggle Like and Sync with Database via Fetch API
  function toggleLike(productId) {
    if (!isLoggedIn) {
      window.location.href = 'login.php'; 
      return;
    }

    const index = userWishlist.indexOf(productId);
    const isCurrentlyLiked = index > -1;

    // Optimistic UI update
    if (isCurrentlyLiked) {
      userWishlist.splice(index, 1);
      updateHeartIcon(productId, false);
      showToast('Removed from wishlist');
    } else {
      userWishlist.push(productId);
      updateHeartIcon(productId, true);
      showToast('Added to wishlist');
    }

    updateWishlistCounter();

    fetch('admin/api/toggle_wishlist.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ product_id: productId })
    })
    .then(response => response.json())
    .then(data => {
      if (!data.success) {
        console.error('Failed to update database wishlist:', data.message);
      }
    })
    .catch(error => console.error('Error syncing wishlist network request:', error));
  }

  function updateHeartIcon(productId, isLiked) {
    const btn = document.querySelector(`.like-btn[data-id="${productId}"]`);
    if (!btn) return;
    const icon = btn.querySelector('i');
    if (isLiked) {
      icon.className = "fa-solid fa-heart text-red-500 text-xs";
    } else {
      icon.className = "fa-regular fa-heart text-slate-400 hover:text-red-500 text-xs";
    }
  }

  // Render Category Sidebar Buttons
  function renderCategories() {
    $("category-list").innerHTML = ["All Categories", ...CATEGORIES].map(c => {
      const active = c === state.cat;
      return `<button type="button" data-cat="${esc(c)}"
        class="cat-btn shrink-0 text-left whitespace-nowrap px-3 py-1.5 sm:px-4 sm:py-2 lg:py-2.5 rounded-full lg:rounded-xl text-xs sm:text-[13px] transition-colors
        ${active ? "bg-slate-900 text-white font-bold" : "bg-slate-100 lg:bg-transparent text-slate-600 font-medium hover:bg-sky-50 hover:text-sky-700"}">${esc(c)}</button>`;
    }).join("");
  }

  // Generate Product Card Markup (Compact mobile layout fit for 2 columns)
  function cardHTML(p) {
    const badgeHTML = p.off > 0 ? `<span class="absolute top-2 left-2 z-10 bg-sky-500 text-white text-[9px] font-extrabold px-1.5 py-0.5 rounded-full">${p.off}% OFF</span>` : '';
    const oldPriceHTML = p.old ? `<span class="text-[10px] text-slate-400 line-through">UGX ${fmt(p.old)}</span>` : '';
    
    const isLiked = userWishlist.includes(p.id);
    const heartClass = isLiked ? "fa-solid fa-heart text-red-500" : "fa-regular fa-heart text-slate-400 hover:text-red-500";
    const ratingVal = p.rating > 0 ? p.rating.toFixed(1) : '4.5';

    return `
    <article class="product-card relative flex flex-col bg-white rounded-2xl shadow-sm border border-slate-100 p-2.5 sm:p-3.5">
      ${badgeHTML}
      <button type="button" data-id="${p.id}" class="like-btn absolute top-2 right-2 z-25 w-7 h-7 rounded-full bg-white shadow-sm border border-slate-100 flex items-center justify-center transition-transform active:scale-90" aria-label="Save to wishlist">
        <i class="${heartClass} text-xs"></i>
      </button>

      <a href="product/product-detail.php?id=${p.id}" data-id="${p.id}" class="product-link flex items-center justify-center h-28 sm:h-44 bg-slate-50 rounded-xl mb-2 overflow-hidden p-2">
        <img alt="${esc(p.name)}" class="max-h-full max-w-full object-contain mix-blend-multiply" loading="lazy" src="${esc(p.img)}"/>
      </a>

      <a href="product/product-detail.php?id=${p.id}" data-id="${p.id}" class="product-link block text-xs font-bold text-slate-900 leading-tight line-clamp-2 hover:text-sky-600 transition-colors min-h-[2.2rem]">${esc(p.name)}</a>
      
      <p class="text-[10px] text-slate-400 line-clamp-1 mt-0.5 mb-1">${esc(p.cat)}</p>

      <div class="flex items-center gap-1 mb-2 text-[10px]">
        <span class="font-bold text-slate-800">${ratingVal}</span>
        <div class="flex text-amber-400 text-[9px]">
          <i class="fa-solid fa-star"></i>
          <i class="fa-solid fa-star"></i>
          <i class="fa-solid fa-star"></i>
          <i class="fa-solid fa-star"></i>
          <i class="fa-solid fa-star-half-stroke"></i>
        </div>
        <span class="text-slate-400 text-[9px]">(${p.reviews})</span>
      </div>

      <div class="flex flex-col gap-1.5 mt-auto pt-1.5 border-t border-slate-50">
        <div class="min-w-0">
          <div class="flex items-center">
            ${oldPriceHTML}
          </div>
          <div class="text-[11px] sm:text-xs font-extrabold text-slate-950 leading-tight truncate">
            UGX ${fmt(p.price)} <span class="text-[9px] text-slate-400 font-normal">${esc(p.unit)}</span>
          </div>
        </div>
        <button type="button" 
          data-id="${p.id}" 
          data-name="${esc(p.name)}" 
          data-price="${p.price}" 
          data-img="${esc(p.img)}" 
          data-unit="${esc(p.unit)}"
          aria-label="Buy ${esc(p.name)}" 
          class="add-btn w-full py-1.5 rounded-xl border border-slate-200 hover:border-sky-500 hover:bg-sky-50 active:scale-95 text-slate-700 text-[11px] font-bold transition-all text-center">
          Buy now
        </button>
      </div>
    </article>`;



  }

  // Filter & Render Product Cards
  function renderProducts() {
    let list = PRODUCTS.filter(p =>
      (state.cat === "All Categories" || p.cat === state.cat) &&
      (state.min === null || p.price >= state.min) &&
      (state.max === null || p.price <= state.max)
    );

    const sorters = {
      "newest": (a, b) => b.id - a.id,
      "price-asc": (a, b) => a.price - b.price,
      "price-desc": (a, b) => b.price - a.price,
      "rating": (a, b) => b.rating - a.rating || b.reviews - a.reviews
    };
    list.sort(sorters[state.sort]);

    $("loading-spinner").classList.add("hidden");

    if (list.length === 0) {
      $("grid").classList.add("hidden");
      $("empty").classList.remove("hidden");
    } else {
      $("empty").classList.add("hidden");
      $("grid").innerHTML = list.map(cardHTML).join("");
      $("grid").classList.remove("hidden");
    }

    $("count").textContent = list.length + (list.length === 1 ? " product found" : " products found");
    $("page-title").textContent = state.cat === "All Categories" ? "All Products" : state.cat;
  }

  function triggerLoading() {
    if (loadTimer) clearTimeout(loadTimer);

    $("grid").classList.add("hidden");
    $("empty").classList.add("hidden");
    $("loading-spinner").classList.remove("hidden");

    renderCategories();

    loadTimer = setTimeout(() => {
      renderProducts();
    }, 300);
  }

  // LocalStorage Cart Synchronization
  function addToCart(product) {
    let cart = JSON.parse(localStorage.getItem('puregain_cart')) || [];
    const existingIndex = cart.findIndex(item => item.id === product.id);

    if (existingIndex > -1) {
      cart[existingIndex].quantity += 1;
    } else {
      cart.push({
        id: product.id,
        name: product.name,
        price: product.price,
        image: product.img,
        unit: product.unit,
        quantity: 1
      });
    }

    localStorage.setItem('puregain_cart', JSON.stringify(cart));
  }

  // Toast Notification Controller
  function showToast(customText = 'Added to cart successfully!') {
    const toast = $("toast-msg");
    const toastText = $("toast-text");
    if (!toast) return;

    if (toastTimer) clearTimeout(toastTimer);
    toastText.textContent = customText;

    toast.classList.remove("opacity-0", "translate-y-4", "pointer-events-none");
    toast.classList.add("opacity-100", "translate-y-0");

    toastTimer = setTimeout(() => {
      toast.classList.remove("opacity-100", "translate-y-0");
      toast.classList.add("opacity-0", "translate-y-4", "pointer-events-none");
    }, 2500);
  }

  // Event Listeners for Filters & Sorting
  $("category-list").addEventListener("click", e => {
    const b = e.target.closest(".cat-btn");
    if (!b) return;
    state.cat = b.dataset.cat;
    triggerLoading();
  });

  $("sort").addEventListener("change", e => { 
    state.sort = e.target.value; 
    triggerLoading(); 
  });
  
  const num = v => (v === "" ? null : Math.max(0, Number(v)));
  $("price-min").addEventListener("input", e => { 
    state.min = num(e.target.value); 
    triggerLoading(); 
  });
  $("price-max").addEventListener("input", e => { 
    state.max = num(e.target.value); 
    triggerLoading(); 
  });

  function resetAll() {
    state.cat = "All Categories"; state.min = null; state.max = null; state.sort = "newest";
    $("price-min").value = ""; $("price-max").value = ""; $("sort").value = "newest";
    triggerLoading();
  }
  
  $("reset-btn").addEventListener("click", resetAll);
  $("empty-reset").addEventListener("click", resetAll);

  // Live Asynchronous Typing Search Integration
  const searchInput = document.querySelector('input[name="q"]');
  if (searchInput) {
    let searchDebounceTimer = null;
    searchInput.addEventListener('input', (e) => {
      const keyword = e.target.value.trim();
      if (searchDebounceTimer) clearTimeout(searchDebounceTimer);

      searchDebounceTimer = setTimeout(() => {
        $("loading-spinner").classList.remove("hidden");
        $("grid").classList.add("hidden");

        fetch(`admin/api/search_products.php?q=${encodeURIComponent(keyword)}`)
          .then(res => res.json())
          .then(data => {
            $("loading-spinner").classList.add("hidden");
            if (data.success) {
              PRODUCTS.length = 0;
              PRODUCTS.push(...data.products);
              renderProducts();
            }
          })
          .catch(err => {
            console.error('Live search error:', err);
            $("loading-spinner").classList.add("hidden");
          });
      }, 300);
    });
  }

  // Grid Event Delegation for Likes and Add-to-Cart
  $("grid").addEventListener("click", e => {
    const likeBtn = e.target.closest(".like-btn");
    if (likeBtn) {
      e.preventDefault();
      const id = parseInt(likeBtn.dataset.id);
      toggleLike(id);
      return;
    }

    const btn = e.target.closest(".add-btn");
    if (btn) {
      if (!isLoggedIn) {
        window.location.href = 'login.php';
        return;
      }

      const productData = {
        id: parseInt(btn.dataset.id),
        name: btn.dataset.name,
        price: parseFloat(btn.dataset.price),
        img: btn.dataset.img,
        unit: btn.dataset.unit
      };

      addToCart(productData);
      showToast('Added to cart successfully!');

      const originalText = btn.textContent;
      btn.textContent = "Added ✓";
      setTimeout(() => btn.textContent = originalText, 1000);
    }
  });

  // Preselect Category from URL
  const urlCat = new URLSearchParams(location.search).get("cat");
  if (urlCat && (urlCat === "All Categories" || CATEGORIES.includes(urlCat))) {
    state.cat = urlCat;
  }

  // Initializing count on page load
  updateWishlistCounter();
  triggerLoading();



</script>



</body>
</html>