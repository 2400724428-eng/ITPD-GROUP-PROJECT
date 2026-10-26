<?php
// views/product-overview.php — Admin Product Overview & Analytics
// Built against actual DB schema: products, orders, order_items, comments

$overviewError = '';

// ================================================================
// 1. PRODUCT COUNTS
// ================================================================
$totalProducts    = 0;
$inStockProducts  = 0;
$lowStockProducts = 0;
$outOfStock       = 0;

if (isset($pdo)) {
    try {
        $totalProducts = (int)$pdo->query("SELECT COUNT(*) FROM products")->fetchColumn();
        $inStockProducts = (int)$pdo->query(
            "SELECT COUNT(*) FROM products WHERE number_in_stock > 5"
        )->fetchColumn();
        $lowStockProducts = (int)$pdo->query(
            "SELECT COUNT(*) FROM products WHERE number_in_stock > 0 AND number_in_stock <= 5"
        )->fetchColumn();
        $outOfStock = (int)$pdo->query(
            "SELECT COUNT(*) FROM products WHERE number_in_stock = 0"
        )->fetchColumn();
    } catch (\PDOException $e) {
        $overviewError = $e->getMessage();
    }
}

// ================================================================
// 2. ORDER METRICS
// ================================================================
$totalOrders     = 0;
$pendingOrders   = 0;
$completedOrders = 0;
$totalRevenue    = 0;
$pendingRevenue  = 0;

if (isset($pdo)) {
    try {
        $totalOrders = (int)$pdo->query("SELECT COUNT(*) FROM orders")->fetchColumn();
        $pendingOrders = (int)$pdo->query(
            "SELECT COUNT(*) FROM orders WHERE LOWER(payment_status) = 'pending'"
        )->fetchColumn();
        $completedOrders = (int)$pdo->query(
            "SELECT COUNT(*) FROM orders WHERE LOWER(payment_status) IN ('completed','paid','delivered')"
        )->fetchColumn();
        $totalRevenue = (int)$pdo->query(
            "SELECT COALESCE(SUM(total_amount), 0) FROM orders
             WHERE LOWER(payment_status) IN ('completed','paid','delivered')"
        )->fetchColumn();
        $pendingRevenue = (int)$pdo->query(
            "SELECT COALESCE(SUM(total_amount), 0) FROM orders
             WHERE LOWER(payment_status) = 'pending'"
        )->fetchColumn();
    } catch (\PDOException $e) {
        $overviewError = $e->getMessage();
    }
}

// ================================================================
// 3. MOST LIKED PRODUCT  (highest avg rating)
// ================================================================
$mostLikedProduct = null;
$mostLikedRating  = 0;
$mostLikedVotes   = 0;
if (isset($pdo)) {
    try {
        $row = $pdo->query(
            "SELECT p.product_name,
                    AVG(c.rating) AS avg_rating,
                    COUNT(c.id)   AS votes
             FROM comments c
             INNER JOIN products p ON p.id = c.product_id
             GROUP BY c.product_id, p.product_name
             HAVING votes >= 1
             ORDER BY avg_rating DESC, votes DESC
             LIMIT 1"
        )->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            $mostLikedProduct = $row['product_name'];
            $mostLikedRating  = round((float)$row['avg_rating'], 1);
            $mostLikedVotes   = (int)$row['votes'];
        }
    } catch (\PDOException $e) {
        $overviewError = $e->getMessage();
    }
}

// ================================================================
// 4. MOST COMMENTED PRODUCT
// ================================================================
$mostCommentedProduct = null;
$mostCommentedCount   = 0;
if (isset($pdo)) {
    try {
        $row = $pdo->query(
            "SELECT p.product_name, COUNT(c.id) AS cnt
             FROM comments c
             INNER JOIN products p ON p.id = c.product_id
             GROUP BY c.product_id, p.product_name
             ORDER BY cnt DESC
             LIMIT 1"
        )->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            $mostCommentedProduct = $row['product_name'];
            $mostCommentedCount   = (int)$row['cnt'];
        }
    } catch (\PDOException $e) {
        $overviewError = $e->getMessage();
    }
}

// ================================================================
// 5. TOP 5 MOST LIKED PRODUCTS (Bar Chart Data)
//    Pulls Top 5 by Average Rating (min 1 review)
// ================================================================
$topLiked = [];
if (isset($pdo)) {
    try {
        $stmt = $pdo->query(
            "SELECT p.product_name, AVG(c.rating) AS avg_rating, COUNT(c.id) AS total_reviews
             FROM comments c
             INNER JOIN products p ON p.id = c.product_id
             GROUP BY c.product_id, p.product_name
             HAVING total_reviews >= 1
             ORDER BY avg_rating DESC, total_reviews DESC
             LIMIT 5"
        );
        while ($r = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $topLiked[] = [
                'name'    => $r['product_name'],
                'rating'  => round((float)$r['avg_rating'], 1),
                'reviews' => (int)$r['total_reviews'],
            ];
        }
    } catch (\PDOException $e) {
        $overviewError = $e->getMessage();
    }
}

// ================================================================
// 6. RECENT PRODUCTS
// ================================================================
$recentProducts = [];
if (isset($pdo)) {
    try {
        $stmt = $pdo->query(
            "SELECT id, product_name, category, product_price, offer_price, number_in_stock, image_primary
             FROM products ORDER BY id DESC LIMIT 5"
        );
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $recentProducts[] = [
                'name'  => $row['product_name'] ?? 'Unnamed',
                'price' => (float)($row['offer_price'] > 0 ? $row['offer_price'] : $row['product_price']),
                'stock' => (int)$row['number_in_stock'],
            ];
        }
    } catch (\PDOException $e) {
        $overviewError = $e->getMessage();
    }
}

// UGX formatter
$fmtUGX = function (int $n): string {
    if ($n >= 1_000_000) return 'UGX ' . number_format($n / 1_000_000, 1) . 'M';
    if ($n >= 1_000)     return 'UGX ' . number_format($n / 1_000, 0)     . 'K';
    return 'UGX ' . number_format($n);
};
?>

<div id="screen-product-overview" class="screen-fade max-w-6xl hidden">

  <!-- ===== Header ===== -->
  <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6 gap-4">
    <div>
      <h1 class="text-xl font-bold text-slate-900">Product Overview &amp; Analytics</h1>
      <p class="text-sm text-slate-500 mt-0.5">Live summary of inventory, orders, and product engagement.</p>
    </div>
    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-emerald-50 text-emerald-700 border border-emerald-100">
      Live Data
    </span>
  </div>

  <?php if (!empty($overviewError)): ?>
    <div class="mb-4 p-3 rounded-lg bg-rose-50 text-rose-700 text-xs border border-rose-200">
      <?= htmlspecialchars($overviewError) ?>
    </div>
  <?php endif; ?>

  <!-- ===== Row 1: Main KPI cards ===== -->
  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">

    <div class="bg-white border border-slate-200 rounded-lg p-5 shadow-sm hover:shadow-md transition-shadow">
      <div class="flex items-start justify-between">
        <div class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Total Products</div>
        <div class="w-8 h-8 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
          </svg>
        </div>
      </div>
      <div class="text-2xl font-bold text-slate-900 mt-2"><?= number_format($totalProducts) ?></div>
      <div class="text-xs text-emerald-600 font-medium mt-1">
        <?= number_format($inStockProducts) ?> well-stocked
      </div>
    </div>

    <div class="bg-white border border-slate-200 rounded-lg p-5 shadow-sm hover:shadow-md transition-shadow">
      <div class="flex items-start justify-between">
        <div class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Low Stock</div>
        <div class="w-8 h-8 rounded-lg bg-amber-50 text-amber-600 flex items-center justify-center">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
          </svg>
        </div>
      </div>
      <div class="text-2xl font-bold text-slate-900 mt-2"><?= number_format($lowStockProducts) ?></div>
      <div class="text-xs text-amber-600 font-medium mt-1">
        <?= number_format($outOfStock) ?> out of stock
      </div>
    </div>

    <div class="bg-white border border-slate-200 rounded-lg p-5 shadow-sm hover:shadow-md transition-shadow">
      <div class="flex items-start justify-between">
        <div class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Orders</div>
        <div class="w-8 h-8 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
          </svg>
        </div>
      </div>
      <div class="text-2xl font-bold text-slate-900 mt-2"><?= number_format($totalOrders) ?></div>
      <div class="text-xs text-slate-500 font-medium mt-1">
        <?= number_format($completedOrders) ?> completed
        · <span class="text-amber-600"><?= number_format($pendingOrders) ?> pending</span>
      </div>
    </div>

    <div class="bg-white border border-slate-200 rounded-lg p-5 shadow-sm hover:shadow-md transition-shadow">
      <div class="flex items-start justify-between">
        <div class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Revenue</div>
        <div class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
          </svg>
        </div>
      </div>
      <div class="text-2xl font-bold text-slate-900 mt-2"><?= $fmtUGX($totalRevenue) ?></div>
      <div class="text-xs text-slate-500 font-medium mt-1">
        <?php if ($pendingRevenue > 0): ?>
          <span class="text-amber-600">Pending: <?= $fmtUGX($pendingRevenue) ?></span>
        <?php else: ?>
          All orders settled
        <?php endif; ?>
      </div>
    </div>
  </div>

  <!-- ===== Row 2: Engagement cards ===== -->
  <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6">

    <!-- Most Liked -->
    <div class="bg-white border border-slate-200 rounded-lg p-5 shadow-sm hover:shadow-md transition-shadow">
      <div class="flex items-start justify-between">
        <div class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">Most Liked Product</div>
        <span class="text-[10px] font-bold px-2 py-0.5 rounded-full bg-emerald-100 text-emerald-700">★ TOP RATED</span>
      </div>
      <div class="text-base font-bold text-slate-900 truncate mt-1">
        <?= $mostLikedProduct ? htmlspecialchars($mostLikedProduct) : '—' ?>
      </div>
      <div class="flex items-center gap-2 mt-1.5">
        <div class="flex items-center">
          <?php for ($i = 1; $i <= 5; $i++): ?>
            <svg class="w-3.5 h-3.5 <?= $i <= round($mostLikedRating) ? 'text-amber-400' : 'text-slate-200' ?>" fill="currentColor" viewBox="0 0 20 20">
              <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
            </svg>
          <?php endfor; ?>
        </div>
        <span class="text-xs text-emerald-600 font-medium"><?= $mostLikedRating ?> · <?= number_format($mostLikedVotes) ?> ratings</span>
      </div>
    </div>

    <!-- Most Commented -->
    <div class="bg-white border border-slate-200 rounded-lg p-5 shadow-sm hover:shadow-md transition-shadow">
      <div class="flex items-start justify-between">
        <div class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">Most Commented</div>
        <span class="text-[10px] font-bold px-2 py-0.5 rounded-full bg-blue-100 text-blue-700">💬 TALKED ABOUT</span>
      </div>
      <div class="text-base font-bold text-slate-900 truncate mt-1">
        <?= $mostCommentedProduct ? htmlspecialchars($mostCommentedProduct) : '—' ?>
      </div>
      <div class="text-xs text-slate-600 font-medium mt-1.5">
        <?= number_format($mostCommentedCount) ?> comments
      </div>
    </div>
  </div>

  <!-- ===== Row 3: MODERN BAR CHART — Top 5 Most Liked ===== -->
  <div class="bg-white border border-slate-200 rounded-lg shadow-sm overflow-hidden mb-6">
    <div class="px-5 py-4 border-b border-slate-200 flex items-center justify-between">
      <div>
        <h3 class="font-bold text-sm text-slate-900">Top 5 Most Liked Products</h3>
        <p class="text-xs text-slate-500 mt-0.5">Ranked by average customer rating</p>
      </div>
      <span class="text-[10px] font-bold px-2 py-0.5 rounded-full bg-slate-100 text-slate-600">
        <?= count($topLiked) ?> products
      </span>
    </div>

    <div class="p-5 sm:p-6">
      <?php if (empty($topLiked)): ?>
        <div class="flex flex-col items-center justify-center py-10 text-center">
          <div class="w-14 h-14 rounded-full bg-slate-100 flex items-center justify-center mb-3">
            <svg class="w-6 h-6 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
            </svg>
          </div>
          <p class="text-sm font-semibold text-slate-700">No ratings yet</p>
          <p class="text-xs text-slate-400 mt-1">The chart will populate when customers rate products.</p>
        </div>
      <?php else: ?>
        <!-- Chart grid -->
        <div class="flex items-end justify-between gap-2 sm:gap-4 h-56 sm:h-64 pb-2 border-b border-slate-100">
          <?php
            $barColors = [
              'from-amber-300 to-amber-500',   // Gold for #1
              'from-yellow-300 to-yellow-500', 
              'from-emerald-400 to-emerald-600',
              'from-blue-400 to-blue-600',
              'from-slate-300 to-slate-500',   // Silver/gray for #5
            ];
            foreach ($topLiked as $i => $item):
              // 5 star max rating = 100% height
              $pct = ($item['rating'] / 5) * 100;
              $barH = max(8, $pct);
              $gradient = $barColors[$i] ?? 'from-slate-400 to-slate-600';
          ?>
            <div class="flex-1 flex flex-col items-center justify-end h-full group relative">
              <!-- Tooltip -->
              <div class="absolute -top-2 opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none z-10 whitespace-nowrap">
                <div class="bg-slate-900 text-white text-[10px] font-bold px-2 py-1 rounded shadow-lg text-center">
                  <?= $item['reviews'] ?> reviews
                </div>
                <div class="w-2 h-2 bg-slate-900 rotate-45 mx-auto -mt-1"></div>
              </div>

              <!-- Value label (Star rating) -->
              <span class="text-[10px] sm:text-xs font-bold text-slate-700 mb-1 flex items-center gap-1">
                <?= $item['rating'] ?> <span class="text-amber-400 text-[10px]">★</span>
              </span>

              <!-- Bar -->
              <div class="w-full max-w-[64px] rounded-t-lg bg-gradient-to-t <?= $gradient ?>
                          transition-all duration-500 hover:opacity-90 hover:scale-y-105 origin-bottom relative overflow-hidden"
                   style="height: <?= $barH ?>%">
                <div class="absolute inset-0 bg-gradient-to-r from-white/0 via-white/20 to-white/0"></div>
              </div>
            </div>
          <?php endforeach; ?>
        </div>

        <!-- X-axis labels -->
        <div class="flex items-start justify-between gap-2 sm:gap-4 mt-3">
          <?php foreach ($topLiked as $i => $item): ?>
            <div class="flex-1 flex flex-col items-center text-center min-w-0">
              <div class="w-5 h-5 rounded-full bg-slate-900 text-white text-[10px] font-bold flex items-center justify-center mb-1 shrink-0">
                <?= $i + 1 ?>
              </div>
              <span class="text-[10px] sm:text-xs font-medium text-slate-600 leading-tight line-clamp-2">
                <?= htmlspecialchars($item['name']) ?>
              </span>
            </div>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>
    </div>
  </div>

  <!-- ===== Row 4: Recent Products Table ===== -->
  <div class="bg-white border border-slate-200 rounded-lg shadow-sm overflow-hidden">
    <div class="px-5 py-4 border-b border-slate-200 flex items-center justify-between">
      <h3 class="font-bold text-sm text-slate-900">Recent Products</h3>
      <button onclick="switchScreen('product-list', document.querySelector('[onclick*=\'product-list\']'))"
              class="text-xs font-semibold text-blue-600 hover:text-blue-800 inline-flex items-center gap-1">
        View All
        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
        </svg>
      </button>
    </div>
    <div class="overflow-x-auto">
      <table class="w-full text-left border-collapse">
        <thead>
          <tr class="bg-slate-50 border-b border-slate-200 text-xs font-semibold text-slate-600 uppercase tracking-wider">
            <th class="py-3 px-4">Product</th>
            <th class="py-3 px-4">Price</th>
            <th class="py-3 px-4">Stock</th>
            <th class="py-3 px-4 text-right">Status</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-slate-200 text-sm">
          <?php if (empty($recentProducts)): ?>
            <tr>
              <td colspan="4" class="py-8 text-center text-slate-400 italic text-xs">
                No products found. Add your first product to get started.
              </td>
            </tr>
          <?php else: ?>
            <?php foreach ($recentProducts as $p): ?>
              <tr class="hover:bg-slate-50">
                <td class="py-3 px-4 font-medium text-slate-900"><?= htmlspecialchars($p['name']) ?></td>
                <td class="py-3 px-4 text-slate-700"><?= $fmtUGX((int)$p['price']) ?></td>
                <td class="py-3 px-4 text-slate-700">
                  <?php if ($p['stock'] === 0): ?>
                    <span class="px-2 py-0.5 text-xs font-semibold rounded-full bg-rose-50 text-rose-700 border border-rose-200">Out</span>
                  <?php elseif ($p['stock'] <= 5): ?>
                    <span class="px-2 py-0.5 text-xs font-semibold rounded-full bg-amber-50 text-amber-700 border border-amber-200"><?= $p['stock'] ?> left</span>
                  <?php else: ?>
                    <span class="text-slate-700"><?= $p['stock'] ?></span>
                  <?php endif; ?>
                </td>
                <td class="py-3 px-4 text-right">
                  <button onclick="switchScreen('product-list', document.querySelector('[onclick*=\'product-list\']'))"
                          class="text-xs font-medium text-blue-600 hover:text-blue-800">Manage</button>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>