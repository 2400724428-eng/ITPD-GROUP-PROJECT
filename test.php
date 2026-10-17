<?php
// Step out to root to require database connection
require_once __DIR__ . '/includes/db_connect.php';

// Start session if not already active
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$userId = isset($_SESSION['user_id']) ? (int)$_SESSION['user_id'] : 0;

try {
    // Fetch Categories dynamically from database
    $catStmt = $pdo->query("SELECT DISTINCT name FROM categories ORDER BY name ASC");
    $dbCategories = $catStmt->fetchAll(PDO::FETCH_COLUMN);

    if (empty($dbCategories)) {
        $catStmt = $pdo->query("SELECT DISTINCT category FROM products WHERE category IS NOT NULL AND category != '' ORDER BY category ASC");
        $dbCategories = $catStmt->fetchAll(PDO::FETCH_COLUMN);
    }

    // Fetch user's wishlist IDs directly from database if logged in
    $userWishlist = [];
    if ($userId > 0) {
        $wishStmt = $pdo->prepare("SELECT product_id FROM wishlist WHERE user_id = ?");
        $wishStmt->execute([$userId]);
        $userWishlist = $wishStmt->fetchAll(PDO::FETCH_COLUMN);
        $userWishlist = array_map('intval', $userWishlist);
    }

    // Fetch up to 7 featured products from database for the showcase section
    $showcaseStmt = $pdo->query("
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
        LIMIT 7
    ");
    $showcaseProducts = $showcaseStmt->fetchAll(PDO::FETCH_ASSOC);

    $formattedShowcase = array_map(function($p) {
        $price = (float)$p['price'];
        $offer = (float)$p['offer'];
        $effectivePrice = ($offer > 0 && $offer < $price) ? $offer : $price;
        $discount = (float)$p['discount'];
        
        if ($discount <= 0 && $offer > 0 && $offer < $price) {
            $discount = round((($price - $offer) / $price) * 100);
        }

        return [
            'id'      => (int)$p['id'],
            'name'    => $p['name'],
            'cat'     => $p['cat'] ?: 'General',
            'price'   => $effectivePrice,
            'old'     => ($offer > 0 && $offer < $price) ? $price : null,
            'unit'    => $p['unit'] ? ('/' . $p['unit']) : '',
            'rating'  => (float)$p['real_rating'], 
            'reviews' => (int)$p['real_reviews'],  
            'off'     => round($discount),
            'img'     => !empty($p['img']) ? $p['img'] : 'https://images.unsplash.com/photo-1546483875-ad9014c88eba?auto=format&fit=crop&w=500&q=80'
        ];
    }, $showcaseProducts);
} catch (\PDOException $e) {
    $dbCategories = [];
    $formattedShowcase = [];
    $userWishlist = [];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="icon" type="image/png" href="assets/images/fav.png"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pure Gain</title>
    <link href="./src/output.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet"/>
    <style>
      .no-scrollbar::-webkit-scrollbar { display: none; }
      .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
</head>
<body class="bg-slate-50 text-slate-800">

    <?php include 'includes/top.php'; ?>

    <!-- ================= MINIMAL DROPDOWN ARROW BAR ================= -->
    <div class="max-w-[1060px] w-full mx-auto px-4 sm:px-6 my-4" id="sdg3">
      
      <!-- Minimal Dropdown Button -->
      <button 
        onclick="toggleSdgDropdown()" 
        id="sdgBtn"
        class="flex items-center gap-2 text-slate-700 hover:text-blue-600 transition-colors py-2 text-sm font-semibold focus:outline-none cursor-pointer group">
        
        <!-- Small SDG 3 Badge -->
        <span class="w-5 h-5 rounded bg-blue-600 text-white font-bold text-[11px] flex items-center justify-center shrink-0">
          3
        </span>

        <span>SDG 3 – Good Health and Well-being</span>

        <!-- Small Dropdown Arrow Symbol (Rotates on click) -->
        <svg id="sdgArrow" class="w-4 h-4 text-slate-500 group-hover:text-blue-600 transition-transform duration-200 transform rotate-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7" />
        </svg>
      </button>

      <!-- Content (Hidden until dropdown arrow is clicked) -->
      <div id="sdgContent" class="hidden pt-3 pb-6 text-slate-600 text-sm leading-relaxed border-t border-slate-200 mt-1">
        <p class="max-w-3xl mb-4">
          Pure Gain contributes to <strong>SDG 3 – Good Health and Well-being</strong> by making quality fitness training, 
          nutrition guidance, and performance support more accessible. Regular physical activity and good nutrition help 
          prevent non-communicable diseases, improve mental well-being, and support healthier communities — especially 
          for young people and busy adults in Kampala and beyond.
        </p>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 my-4">
          <div class="bg-white p-4 rounded-lg border border-slate-200 shadow-sm">
            <h4 class="font-bold text-slate-900 mb-1">Physical Health</h4>
            <p class="text-xs text-slate-600">Structured training and strength programmes help reduce risk factors for heart disease, diabetes, and obesity.</p>
          </div>
          
          <div class="bg-white p-4 rounded-lg border border-slate-200 shadow-sm">
            <h4 class="font-bold text-slate-900 mb-1">Mental Well-being</h4>
            <p class="text-xs text-slate-600">Exercise and community classes support better mood, lower stress, improved sleep, and stronger social connections.</p>
          </div>

          <div class="bg-white p-4 rounded-lg border border-slate-200 shadow-sm">
            <h4 class="font-bold text-slate-900 mb-1">Accessible Support</h4>
            <p class="text-xs text-slate-600">Affordable membership plans, online coaching, and nutrition advice that works with local foods make healthy living more reachable.</p>
          </div>
        </div>

        <div class="flex items-center justify-between text-xs text-slate-500 pt-2">
          <span>This project is part of our school group contribution to the UN Sustainable Development Goals.</span>
          <a href="https://sdgs.un.org/goals/goal3" target="_blank" rel="noopener" class="text-blue-600 hover:underline font-medium">Learn more &rarr;</a>
        </div>
      </div>

    </div>
    <br>

    <!-- ================= SMALL CATEGORIES CHIPS SECTION ================= -->
    <?php if (!empty($dbCategories)): ?>
    <div class="max-w-[1060px] w-full mx-auto px-4 sm:px-6 mb-6">
      <div class="no-scrollbar flex items-center gap-1.5 overflow-x-auto py-1">
        <a href="shop.php" class="shrink-0 px-3 py-1.5 rounded-lg bg-slate-900 text-white text-[11px] font-bold hover:bg-blue-600 transition-colors">
          All
        </a>
        <?php foreach ($dbCategories as $cat): ?>
          <a href="shop.php?cat=<?= urlencode($cat) ?>" class="shrink-0 px-3 py-1.5 rounded-lg bg-white border border-slate-200 text-slate-600 text-[11px] font-semibold hover:border-blue-600 hover:text-blue-600 transition-colors shadow-2xs">
            <?= htmlspecialchars($cat) ?>
          </a>
        <?php endforeach; ?>
      </div>
    </div>
    <?php endif; ?>

    <!-- PHP Content Below -->
    <?php include 'product/featured.php'; ?>
    <br><br>

</body>
</html>