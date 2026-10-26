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
<title>Product Categories </title>
<link href="<?= $baseUrl ?>/src/output.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet"/>
<link href="https://fonts.googleapis.com" rel="preconnect"/>
<link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect"/>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&amp;display=swap" rel="stylesheet"/>

<style>
    .category-box-grid {
        display: grid !important;
        grid-template-columns: repeat(3, minmax(0, 1fr)) !important;
        gap: 8px !important;
        width: 100% !important;
        max-width: 650px !important;
        margin-left: auto !important;
        margin-right: auto !important;
    }

    @media (min-width: 640px) {
        .category-box-grid {
            grid-template-columns: repeat(4, minmax(0, 1fr)) !important;
            gap: 10px !important;
            max-width: 780px !important;
        }
    }
    @media (min-width: 1024px) {
        .category-box-grid {
            grid-template-columns: repeat(6, minmax(0, 1fr)) !important;
            max-width: 950px !important;
        }
    }

    .category-card {
        transition: transform .2s ease, box-shadow .2s ease, border-color .2s ease;
    }
    .category-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px -4px rgba(37, 99, 235, 0.1);
        border-color: #93c5fd;
    }
</style>
</head>
<body class="bg-slate-50/50 text-slate-800 font-sans antialiased min-h-screen py-4 sm:py-8 px-2 sm:px-4">


<!-- Hero -->
<section>
  
  <!-- Content Layer -->
  <div class="relative z-10 max-w-3xl mx-auto text-white">
    
    <!-- Image and Button Container -->
    <div class="relative inline-block max-w-full">
      <!-- Image Layer -->
      <img style="width: 800px;" src="assets/images/jj.png" alt="" class="block max-w-full h-auto mx-auto">
      
      <!-- Overlay Button (Centered on the Image) -->
      <button class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 bg-black text-white font-semibold px-6 py-3 rounded-full shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] hover:translate-x-[calc(-50%+2px)] hover:translate-y-[calc(-50%+2px)] hover:shadow-[2px_2px_0px_0px_rgba(0,0,0,1)] transition-all duration-200 whitespace-nowrap">
        Shop Now
      </button>
    </div>

    <h1 class="text-3xl sm:text-4xl lg:text-5xl font-bold tracking-tight mt-6 mb-4">
      <!-- Your Headline Here -->
    </h1>

  </div>
</section>






















<div class="max-w-[1320px] mx-auto flex justify-center">
  <main class="w-full min-w-0 flex flex-col items-center">

    <h2 id="" class="font-headline-md text-lg font-bold text-on-surface tracking-tight">Product Categories</h2> <br> <br>

    <!-- Category Boxes Grid -->
    <div class="category-box-grid">
      <?php if (empty($categoryData)): ?>
        <div class="col-span-full text-center py-8 text-slate-500 bg-white rounded-xl border border-slate-100 text-xs">
          No categories found in database.
        </div>
      <?php else: ?>
        <?php foreach ($categoryData as $box): ?>
          <a href="<?= $baseUrl ?>/shop.php?cat=<?= urlencode($box['name']) ?>" class="category-card group flex flex-col bg-white rounded-xl border border-slate-200/80 p-2 sm:p-2.5 shadow-sm overflow-hidden relative">
            
            <!-- Category Image Container Box (Very Small & Centered) -->
            <div class="w-full h-16 sm:h-20 bg-sky-50/60 rounded-lg overflow-hidden flex items-center justify-center mb-2 group-hover:bg-sky-100/50 transition-colors">
              <img alt="<?= htmlspecialchars($box['name']) ?>" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" loading="lazy" src="<?= htmlspecialchars($box['image']) ?>"/>
            </div>

            <!-- Box Footer / Details (Compact) -->
            <div class="flex items-center justify-between gap-1 mt-auto">
              <div class="min-w-0">
                <h3 class="text-[11px] sm:text-xs font-bold capitalize text-slate-900 group-hover:text-blue-600 transition-colors line-clamp-1">
                  <?= htmlspecialchars($box['name']) ?>
                </h3>
                <p class="text-[9px] sm:text-[10px] text-slate-500 font-medium">
                  <?= $box['count'] ?> item<?= $box['count'] === 1 ? '' : 's' ?>
                </p>
              </div>

              <!-- Action Arrow Icon -->
              <span class="w-5 h-5 sm:w-6 sm:h-6 rounded-full bg-slate-100 group-hover:bg-blue-600 group-hover:text-white text-slate-600 flex items-center justify-center shrink-0 transition-colors">
                <i class="fa-solid fa-arrow-right text-[8px] sm:text-[9px]"></i>
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