<?php
// Step out of product/ subfolder to reach root includes/db_connect.php
require_once __DIR__ . '/../includes/db_connect.php';

// Dynamic Base URL detection (handles localhost subfolders & live servers)
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https://" : "http://";
$host = $_SERVER['HTTP_HOST'];
$docRoot = rtrim(str_replace('\\', '/', $_SERVER['DOCUMENT_ROOT']), '/');
$projRoot = rtrim(str_replace('\\', '/', dirname(__DIR__)), '/');
$subfolder = str_replace($docRoot, '', $projRoot);
$baseUrl = $protocol . $host . $subfolder;

try {
    // 1. Fetch categories dynamically from database
    $catStmt = $pdo->query("SELECT id, name FROM categories ORDER BY name ASC");
    $categories = $catStmt->fetchAll(PDO::FETCH_ASSOC);

    // Fallback if categories table is empty: Fetch distinct categories from products table
    if (empty($categories)) {
        $distinctStmt = $pdo->query("SELECT DISTINCT category AS name FROM products WHERE category IS NOT NULL AND category != '' ORDER BY category ASC");
        $categories = $distinctStmt->fetchAll(PDO::FETCH_ASSOC);
    }

    $defaultImage = 'https://images.unsplash.com/photo-1546483875-ad9014c88eba?auto=format&fit=crop&w=500&q=80';
    $categoryData = [];

    // 2. Count products and grab the FIRST product's primary image per category
    foreach ($categories as $cat) {
        $catName = $cat['name'];

        $stmt = $pdo->prepare("
            SELECT 
                COUNT(*) AS total_count,
                (
                    SELECT image_primary 
                    FROM products 
                    WHERE category = :catName1 
                      AND image_primary IS NOT NULL 
                      AND image_primary != '' 
                    ORDER BY id ASC 
                    LIMIT 1
                ) AS first_image
            FROM products 
            WHERE category = :catName2
        ");
        
        $stmt->execute([
            ':catName1' => $catName,
            ':catName2' => $catName
        ]);
        
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        $prodCount = (int)($result['total_count'] ?? 0);
        $firstImage = $result['first_image'] ?? null;

        // Build image path safely
        if (!empty($firstImage)) {
            if (strpos($firstImage, 'http://') === 0 || strpos($firstImage, 'https://') === 0) {
                $imageUrl = $firstImage;
            } else {
                // Remove leading slashes and strip redundant directory prefixes if present in DB strings
                $cleanPath = ltrim($firstImage, '/');
                $cleanPath = preg_replace('#^(product/|../)*#i', '', $cleanPath);
                
                // Ensure path points cleanly relative to project root
                $imageUrl = $baseUrl . '/' . $cleanPath;
            }
        } else {
            $imageUrl = $defaultImage;
        }

        $categoryData[] = [
            'id'    => $cat['id'] ?? null,
            'name'  => $catName,
            'count' => $prodCount,
            'image' => $imageUrl
        ];
    }

} catch (\PDOException $e) {
    error_log("Database Fetch Error: " . $e->getMessage());
    $categoryData = [];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>Product Categories - ApexFit</title>
<link href="<?= $baseUrl ?>/src/output.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet"/>
<link href="https://fonts.googleapis.com" rel="preconnect"/>
<link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect"/>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&amp;display=swap" rel="stylesheet"/>

<style>
    .category-box-grid {
        display: grid !important;
        grid-template-columns: repeat(2, minmax(0, 1fr)) !important;
        gap: 12px !important;
        width: 100% !important;
    }

    @media (min-width: 640px) {
        .category-box-grid {
            grid-template-columns: repeat(3, minmax(0, 1fr)) !important;
            gap: 20px !important;
        }
    }
    @media (min-width: 1024px) {
        .category-box-grid {
            grid-template-columns: repeat(4, minmax(0, 1fr)) !important;
        }
    }

    .category-card {
        transition: transform .25s ease, box-shadow .25s ease, border-color .25s ease;
    }
    .category-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 16px 32px -8px rgba(37, 99, 235, 0.12);
        border-color: #93c5fd;
    }
</style>
</head>
<body class="bg-slate-50/50 text-slate-800 font-sans antialiased min-h-screen py-6 sm:py-12 px-3 sm:px-6 lg:px-8">

<div class="max-w-[1320px] mx-auto">
  <main class="w-full min-w-0">

    <!-- Header Section -->
    <div class="mb-6 sm:mb-10 text-center sm:text-left">
      <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">Explore Categories</h1>
      <p class="text-xs sm:text-sm text-slate-500 mt-1">Select a category box to view all items</p>
    </div>

    <!-- Category Boxes Grid -->
    <div class="category-box-grid">
      <?php if (empty($categoryData)): ?>
        <div class="col-span-full text-center py-12 text-slate-500 bg-white rounded-2xl border border-slate-100">
          No categories found in database.
        </div>
      <?php else: ?>
        <?php foreach ($categoryData as $box): ?>
          <a href="<?= $baseUrl ?>/shop.php?cat=<?= urlencode($box['name']) ?>" class="category-card group flex flex-col bg-white rounded-2xl sm:rounded-3xl border border-slate-200/80 p-3 sm:p-5 shadow-sm overflow-hidden relative">
            
            <!-- Category Image Container Box -->
            <div class="w-full h-28 sm:h-40 bg-sky-50/60 rounded-xl sm:rounded-2xl overflow-hidden flex items-center justify-center mb-3 group-hover:bg-sky-100/50 transition-colors">
              <img alt="<?= htmlspecialchars($box['name']) ?>" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" loading="lazy" src="<?= htmlspecialchars($box['image']) ?>"/>
            </div>

            <!-- Box Footer / Details -->
            <div class="flex items-center justify-between gap-2 mt-auto">
              <div>
                <h3 class="text-sm sm:text-base font-bold capitalize text-slate-900 group-hover:text-blue-600 transition-colors line-clamp-1">
                  <?= htmlspecialchars($box['name']) ?>
                </h3>
                <p class="text-[11px] sm:text-xs text-slate-500 font-medium">
                  <?= $box['count'] ?> Product<?= $box['count'] === 1 ? '' : 's' ?>
                </p>
              </div>

              <!-- Action Arrow Icon -->
              <span class="w-7 h-7 sm:w-9 sm:h-9 rounded-full bg-slate-100 group-hover:bg-blue-600 group-hover:text-white text-slate-600 flex items-center justify-center shrink-0 transition-colors">
                <i class="fa-solid fa-arrow-right text-[10px] sm:text-xs"></i>
              </span>
            </div>

          </a>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>

  </main>
</div>

</body>
</html>