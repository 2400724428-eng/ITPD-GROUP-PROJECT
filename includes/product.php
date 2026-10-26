<?php
// Step out to root to require database connection
require_once __DIR__ . '/db_connect.php';

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
        // Fallback to distinct categories in products table
        $catStmt =$pdo->query("SELECT DISTINCT category FROM products WHERE category IS NOT NULL AND category != '' ORDER BY category ASC");
        $dbCategories =$catStmt->fetchAll(PDO::FETCH_COLUMN);
    }

    // 2. Fetch Products with Real Ratings & Review Counts from 'comments' table (Limited to 20 products)
    $productStmt =$pdo->query("
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
        GROUP BY p.id
        ORDER BY p.id DESC
        LIMIT 20
    ");
    $dbProducts =$productStmt->fetchAll(PDO::FETCH_ASSOC);

    // 3. Fetch user's wishlist IDs directly from the database if logged in
    $userWishlist = [];
    if ($userId > 0) {
        $wishStmt =$pdo->prepare("SELECT product_id FROM wishlist WHERE user_id = ?");
        $wishStmt->execute([$userId]);
        $userWishlist =$wishStmt->fetchAll(PDO::FETCH_COLUMN);
        $userWishlist = array_map('intval',$userWishlist);
    }

    // Format products array for JavaScript
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
  .product-card:hover { transform: translateY(-2px); box-shadow: 0 10px 20px -6px rgba(0,0,0,.08); }
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
<body class="bg-white text-slate-800 font-sans antialiased min-h-screen py-5 sm:py-8 px-3 sm:px-6 lg:px-8">

<!-- FLOATING WISHLIST WIDGET -->
<a href="wishlist.php" id="floating-wishlist" class="fixed bottom-5 left-5 z-40 bg-white border border-slate-200/80 text-slate-700 p-2.5 rounded-full shadow-lg hover:shadow-xl hover:scale-105 transition-all duration-200 flex items-center justify-center group" aria-label="View Wishlist">
  <div class="relative flex items-center justify-center w-5 h-5">
    <i class="fa-solid fa-heart text-red-500 text-sm"></i>
    <span id="wishlist-counter" class="absolute -top-1.5 -right-1.5 bg-red-500 text-white font-bold text-[9px] w-4 h-4 rounded-full flex items-center justify-center shadow-sm">0</span>
  </div>
</a>

<!-- FLOATING SUCCESS TOAST NOTIFICATION -->
<div id="toast-msg" class="fixed bottom-6 right-6 z-50 flex items-center gap-3 bg-slate-900 text-white px-5 py-3.5 rounded-2xl shadow-xl transition-all duration-300 opacity-0 translate-y-4 pointer-events-none">
  <div class="w-6 h-6 rounded-full bg-emerald-500 text-white flex items-center justify-center shrink-0 text-xs font-bold">
    <i class="fa-solid fa-check"></i>
  </div>
  <span id="toast-text" class="text-xs sm:text-sm font-semibold">Added to cart successfully!</span>
</div>

<!-- Centered Wrapper Container -->
<div class="max-w-[1200px] mx-auto">

  <!-- ============ MAIN CONTAINER ============ -->
  <main class="w-full relative min-h-[400px]">
    <div class="flex items-start sm:items-center justify-between gap-4 mb-6">
      <div>
        <div class="flex flex-col items-start justify-center w-full">
          <h1 id="page-title" class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
            All Products
          </h1>
        </div>
        <p id="count" class="text-xs sm:text-sm text-slate-500 mt-0.5">0 products found</p>
      </div>
      <select id="sort" class="shrink-0 bg-white border border-slate-200 rounded-xl px-3 py-2 text-xs font-semibold text-slate-700 focus:ring-sky-400 focus:border-sky-400" aria-label="Sort products">
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

    <!-- Products Grid matching reference layout -->
    <div id="grid" class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4"></div>

    <div id="empty" class="hidden text-center py-20">
      <i class="fa-regular fa-face-frown text-3xl text-slate-300"></i>
      <p class="mt-3 font-semibold text-slate-700">No products available</p>
    </div>
  </main>

</div>

<script>
  // Dynamic JSON injected directly from database PDO queries
  const CATEGORIES = <?= json_encode($dbCategories, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP) ?>;
  const PRODUCTS = <?= json_encode($formattedProducts, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP) ?>;
  
  // Database-backed wishlist state for current user
  let userWishlist = <?= json_encode($userWishlist, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP) ?>;
  const isLoggedIn = <?= $userId > 0 ? 'true' : 'false' ?>;

  // State Management
  const state = { cat: "All Categories", sort: "newest" };
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

    // Refresh the counter badge on change
    updateWishlistCounter();

    // Send request to backend API endpoint to update database table `wishlist` using absolute path
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
      icon.className = "fa-solid fa-heart text-red-500 text-sm";
    } else {
      icon.className = "fa-regular fa-heart text-slate-400 hover:text-red-500 text-sm";
    }
  }

  // Generate Product Card Markup matching reference layout UI
  function cardHTML(p) {
    const badgeHTML = p.off > 0 ? `<span class="absolute top-3 left-3 z-10 bg-sky-500 text-white text-[10px] font-extrabold px-2.5 py-0.5 rounded-full">${p.off}% OFF</span>` : '';
    
    // CHANGED: Added UGX to old price
    const oldPriceHTML = p.old ? `<span class="text-xs text-slate-400 line-through mr-1">UGX ${fmt(p.old)}</span>` : '';
    
    const isLiked = userWishlist.includes(p.id);
    const heartClass = isLiked ? "fa-solid fa-heart text-red-500" : "fa-regular fa-heart text-slate-400 hover:text-red-500";
    const ratingVal = p.rating > 0 ? p.rating.toFixed(1) : '4.5';

    return `
    <article class="product-card relative flex flex-col bg-white rounded-2xl shadow-sm border border-slate-100 p-3.5">
      ${badgeHTML}
      <button type="button" data-id="${p.id}" class="like-btn absolute top-3 right-3 z-20 w-8 h-8 rounded-full bg-white shadow-sm border border-slate-100 flex items-center justify-center transition-transform active:scale-90" aria-label="Save to wishlist">
        <i class="${heartClass} text-sm"></i>
      </button>

      <a href="product/product-detail.php?id=${p.id}" data-id="${p.id}" class="product-link flex items-center justify-center h-40 sm:h-44 bg-slate-50 rounded-xl mb-3 overflow-hidden p-2">
        <img alt="${esc(p.name)}" class="max-h-full max-w-full object-contain mix-blend-multiply" loading="lazy" src="${esc(p.img)}"/>
      </a>

      <a href="product/product-detail.php?id=${p.id}" data-id="${p.id}" class="product-link block text-xs sm:text-sm font-bold text-slate-900 leading-snug line-clamp-1 hover:text-sky-600 transition-colors">${esc(p.name)}</a>
      
      <p class="text-[11px] text-slate-400 line-clamp-1 mt-0.5 mb-2">${esc(p.name)} with premium features</p>

      <div class="flex items-center gap-1 mb-3 text-xs">
        <span class="font-bold text-slate-800">${ratingVal}</span>
        <div class="flex text-amber-400 text-[10px]">
          <i class="fa-solid fa-star"></i>
          <i class="fa-solid fa-star"></i>
          <i class="fa-solid fa-star"></i>
          <i class="fa-solid fa-star"></i>
          <i class="fa-solid fa-star-half-stroke"></i>
        </div>
        <span class="text-slate-400 text-[10px]">(${p.reviews})</span>
      </div>

      <div class="flex items-center justify-between mt-auto pt-1">
        <div class="flex flex-col">
          <div class="flex items-center">
            ${oldPriceHTML}
          </div>
          <!-- CHANGED: Added UGX to current price -->
          <span class="text-xs sm:text-sm font-extrabold text-slate-900">UGX ${fmt(p.price)}</span>
        </div>
        <button type="button" 
          data-id="${p.id}" 
          data-name="${esc(p.name)}" 
          data-price="${p.price}" 
          data-img="${esc(p.img)}" 
          data-unit="${esc(p.unit)}"
          aria-label="Buy ${esc(p.name)}" 
          class="add-btn px-3 py-1.5 rounded-full border border-slate-200 hover:border-slate-300 text-slate-700 text-xs font-semibold transition-all hover:bg-slate-50 active:scale-95">
          Buy now
        </button>
      </div>
    </article>`;
  }

  // Filter & Render Product Cards
  function renderProducts() {
    let list = [...PRODUCTS];

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
  }

  function triggerLoading() {
    if (loadTimer) clearTimeout(loadTimer);

    $("grid").classList.add("hidden");
    $("empty").classList.add("hidden");
    $("loading-spinner").classList.remove("hidden");

    loadTimer = setTimeout(() => {
      renderProducts();
    }, 500);
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

  // Event Listeners
  $("sort").addEventListener("change", e => { 
    state.sort = e.target.value; 
    triggerLoading(); 
  });

  // Grid Event Delegation for Likes and Add-to-Cart
  $("grid").addEventListener("click", e => {
    // 1. Tapping Like Button
    const likeBtn = e.target.closest(".like-btn");
    if (likeBtn) {
      e.preventDefault();
      const id = parseInt(likeBtn.dataset.id);
      toggleLike(id);
      return;
    }

    // 2. Tapping Buy Now Button
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

  // Initializing count on page load
  updateWishlistCounter();
  triggerLoading();
</script>
</body>
</html>