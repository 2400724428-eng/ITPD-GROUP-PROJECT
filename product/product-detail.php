<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Step out to reach root includes/db_connect.php
require_once __DIR__ . '/../includes/db_connect.php';

// Auth session check - flexes across different session structures
$userId = $_SESSION['user_id'] ?? $_SESSION['id'] ?? $_SESSION['user']['id'] ?? null;
$isLoggedIn = !empty($userId);

// Get product ID from URL parameter
$productId = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$product   = null;

if ($productId > 0) {
    try {
        $stmt = $pdo->prepare("SELECT * FROM products WHERE id = :id LIMIT 1");
        $stmt->execute([':id' => $productId]);
        $product = $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (\PDOException $e) {
        error_log("Product detail query error: " . $e->getMessage());
    }
}

// Fallback: If product not found in DB, fetch the latest product
if (!$product) {
    try {
        $stmt = $pdo->query("SELECT * FROM products ORDER BY id DESC LIMIT 1");
        $product = $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (\PDOException $e) {
        error_log("Fallback product query error: " . $e->getMessage());
    }
}

// Standard defaults if database is completely empty
if (!$product) {
    $product = [
        'id'                  => 0,
        'product_name'        => 'Product Not Found',
        'product_description' => 'The requested product is currently unavailable.',
        'category'            => 'General',
        'product_price'       => 0,
        'offer_price'         => 0,
        'number_in_stock'     => 0,
        'image_primary'       => '',
        'image_secondary'     => ''
    ];
}

$productId = (int)$product['id'];

// Handle New Comment & Rating Submission
$commentSuccess = '';
$commentError   = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_comment'])) {
    if (!$isLoggedIn) {
        $commentError = 'You must be logged in to leave a review.';
    } elseif ($productId <= 0) {
        $commentError = 'Invalid product selected.';
    } else {
        $rating      = isset($_POST['rating']) ? (int)$_POST['rating'] : 0;
        $commentText = trim($_POST['comment_text'] ?? '');

        if ($rating < 1 || $rating > 5) {
            $commentError = 'Please select a star rating between 1 and 5.';
        } elseif (empty($commentText)) {
            $commentError = 'Please write a comment before posting.';
        } else {
            try {
                // Ensure table exists with rating column
                $pdo->exec("CREATE TABLE IF NOT EXISTS comments (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    product_id INT NOT NULL,
                    user_id INT NOT NULL,
                    rating TINYINT(1) NOT NULL DEFAULT 5,
                    comment_text TEXT NOT NULL,
                    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                    CONSTRAINT fk_comments_product FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE ON UPDATE CASCADE,
                    CONSTRAINT fk_comments_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE ON UPDATE CASCADE
                )");

                $insStmt = $pdo->prepare("INSERT INTO comments (product_id, user_id, rating, comment_text) VALUES (?, ?, ?, ?)");
                if ($insStmt->execute([$productId, $userId, $rating, $commentText])) {
                    $commentSuccess = 'Thank you! Your review and rating have been posted.';
                } else {
                    $commentError = 'Failed to post review. Please try again.';
                }
            } catch (\PDOException $e) {
                error_log("Comment insertion error: " . $e->getMessage());
                $commentError = 'Database Error: ' . $e->getMessage();
            }
        }
    }
}

// Fetch Comments along with Ratings & User Details
$comments = [];
$totalComments = 0;
$avgRating = 0;

if ($productId > 0) {
    try {
        $comQuery = $pdo->prepare("
            SELECT c.*, u.full_name, u.profile_photo 
            FROM comments c 
            JOIN users u ON c.user_id = u.id 
            WHERE c.product_id = ? 
            ORDER BY c.created_at DESC
        ");
        $comQuery->execute([$productId]);
        $comments = $comQuery->fetchAll(PDO::FETCH_ASSOC);
        $totalComments = count($comments);

        if ($totalComments > 0) {
            $sumRating = array_sum(array_column($comments, 'rating'));
            $avgRating = round($sumRating / $totalComments, 1);
        }
    } catch (\PDOException $e) {
        error_log("Comment retrieval error: " . $e->getMessage());
        $comments = [];
    }
}

// Process Prices
$price = (float)$product['product_price'];
$offerPrice = (float)($product['offer_price'] ?? 0);
$effectivePrice = ($offerPrice > 0 && $offerPrice < $price) ? $offerPrice : $price;

// Format images
$primaryImg = !empty($product['image_primary']) 
    ? '../' . ltrim($product['image_primary'], '/') 
    : 'https://images.unsplash.com/photo-1546483875-ad9014c88eba?auto=format&fit=crop&w=600&q=80';

$secondaryImg = !empty($product['image_secondary']) 
    ? '../' . ltrim($product['image_secondary'], '/') 
    : '';

$stockCount = (int)($product['number_in_stock'] ?? 10);

// Current user profile avatar
$currentUserPhoto = $_SESSION['profile_photo'] ?? $_SESSION['user']['profile_photo'] ?? 'uploads/avatars/default-avatar.png';
$displayUserPhoto = (strpos($currentUserPhoto, 'http') === 0) ? $currentUserPhoto : '../' . ltrim($currentUserPhoto, '/');
$currentUserName  = $_SESSION['full_name'] ?? $_SESSION['user']['full_name'] ?? 'User';
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta content="width=device-width, initial-scale=1.0" name="viewport">
<title><?php echo htmlspecialchars($product['product_name']); ?> - ApexFit</title>
<link href="../src/output.css" rel="stylesheet">

<link href="https://fonts.googleapis.com" rel="preconnect">
<link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&amp;display=swap" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet"/>

<script>
    tailwind.config = {
      theme: {
        extend: {
          fontFamily: {
            sans: ['Inter', 'sans-serif'],
          }
        }
      }
    }
</script>
<style>
    body {
      font-family: 'Inter', sans-serif;
      -webkit-font-smoothing: antialiased;
      background-color: #ffffff;
    }
    /* Star Rating Selector Styles */
    .star-rating input { display: none; }
    .star-rating label { font-size: 1.5rem; color: #cbd5e1; cursor: pointer; transition: color 0.2s; }
    .star-rating input:checked ~ label,
    .star-rating label:hover,
    .star-rating label:hover ~ label { color: #f59e0b; }
    .star-rating { display: flex; flex-direction: row-reverse; justify-content: flex-end; gap: 0.25rem; }
</style>
</head>
<body class="bg-white min-h-screen text-[#2e3a47] flex flex-col justify-between p-4 sm:p-6 md:p-10 lg:p-16 overflow-x-hidden selection:bg-blue-100">

<!-- Navigation Back Link -->
<div class="max-w-7xl mx-auto w-full px-2 sm:px-4 md:px-6 mb-6">
  <a href="../shop.php" class="inline-flex items-center gap-2 text-sm font-semibold text-slate-600 hover:text-blue-600 transition-colors">
    <i class="fa-solid fa-arrow-left"></i> Back to Catalog
  </a>
</div>

<!-- Product Showcase -->
<main class="w-full max-w-7xl mx-auto px-2 sm:px-4 md:px-6 my-auto">
  <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 md:gap-12 lg:gap-16 items-start w-full">
    
    <!-- Gallery -->
    <section aria-label="Product Media Gallery" class="w-full lg:col-span-6 xl:col-span-5 flex flex-col gap-4 min-w-0">
      <div class="relative w-full aspect-square bg-[#f2f4f7] rounded-xl overflow-hidden flex items-center justify-center p-6 shadow-sm">
        <div class="relative w-full h-full flex items-center justify-center overflow-hidden">
          <img id="main-product-img" alt="<?php echo htmlspecialchars($product['product_name']); ?>" class="max-h-[85%] max-w-[85%] object-contain mix-blend-multiply drop-shadow-lg select-none" src="<?php echo htmlspecialchars($primaryImg); ?>">
        </div>
      </div>

      <div class="flex flex-wrap items-center gap-3 pt-1">
        <button onclick="switchImage('<?php echo htmlspecialchars($primaryImg); ?>')" class="w-16 h-16 rounded-xl bg-[#f2f4f7] border-2 border-blue-600 focus:outline-none overflow-hidden flex items-center justify-center relative transition-all shadow-sm" type="button">
          <img alt="Thumbnail 1" class="max-h-[80%] max-w-[80%] object-contain mix-blend-multiply" src="<?php echo htmlspecialchars($primaryImg); ?>">
        </button>

        <?php if (!empty($secondaryImg)): ?>
          <button onclick="switchImage('<?php echo htmlspecialchars($secondaryImg); ?>')" class="w-16 h-16 rounded-xl bg-[#f2f4f7] border-2 border-slate-200 hover:border-blue-600 focus:outline-none overflow-hidden flex items-center justify-center relative transition-all shadow-sm" type="button">
            <img alt="Thumbnail 2" class="max-h-[80%] max-w-[80%] object-contain mix-blend-multiply" src="<?php echo htmlspecialchars($secondaryImg); ?>">
          </button>
        <?php endif; ?>
      </div>
    </section>

    <!-- Details -->
    <section aria-label="Product Details and Actions" class="w-full lg:col-span-6 xl:col-span-7 flex flex-col justify-start min-w-0">
      
      <h1 class="text-2xl sm:text-3xl md:text-4xl lg:text-5xl font-bold tracking-tight text-[#2d3a4b] mb-3 break-words">
        <?php echo htmlspecialchars($product['product_name']); ?>
      </h1>

      <!-- Average Rating Header -->
      <div class="flex items-center gap-2 mb-4">
        <div class="flex items-center text-amber-400 space-x-1">
          <?php 
          $fullStars = floor($avgRating);
          for ($i = 1; $i <= 5; $i++): 
              if ($i <= $fullStars): ?>
                  <i class="fa-solid fa-star text-xs"></i>
              <?php elseif ($i == $fullStars + 1 && $avgRating - $fullStars >= 0.5): ?>
                  <i class="fa-solid fa-star-half-stroke text-xs"></i>
              <?php else: ?>
                  <i class="fa-regular fa-star text-xs text-slate-300"></i>
              <?php endif;
          endfor; 
          ?>
        </div>
        <span class="text-sm font-semibold text-[#4b5563] ml-1">
          <?php echo $avgRating > 0 ? $avgRating : 'New'; ?> (<?php echo $totalComments; ?> reviews)
        </span>
      </div>

      <!-- Description -->
      <p class="text-[0.97rem] leading-relaxed text-[#516173] mb-6 font-normal">
        <?php echo !empty($product['product_description']) ? nl2br(htmlspecialchars($product['product_description'])) : 'No product description available.'; ?>
      </p>

      <!-- Pricing -->
      <div class="flex flex-wrap items-baseline gap-2.5 sm:gap-3 mb-6">
        <span class="text-3xl font-extrabold text-[#24303e] tracking-tight">
          UGX <?php echo number_format($effectivePrice); ?>
        </span>
        
        <?php if ($offerPrice > 0 && $offerPrice < $price): ?>
          <span class="text-sm font-medium text-[#8492a6] line-through">
            UGX <?php echo number_format($price); ?>
          </span>
        <?php endif; ?>
      </div>

      <hr class="border-t border-[#edf1f5] mb-6">

      <!-- Specs -->
      <div class="grid grid-cols-[110px_1fr] sm:grid-cols-[130px_1fr] gap-y-2.5 text-sm mb-10">
        <span class="font-bold text-[#374758]">Category</span>
        <span class="text-[#728294] font-normal"><?php echo htmlspecialchars($product['category'] ?? 'General'); ?></span>
        
        <span class="font-bold text-[#374758]">Stock Status</span>
        <?php if ($stockCount > 0): ?>
          <span class="text-emerald-600 font-semibold">In Stock (<?php echo $stockCount; ?> left)</span>
        <?php else: ?>
          <span class="text-rose-600 font-semibold">Out of Stock</span>
        <?php endif; ?>
      </div>

      <!-- CTA Buttons -->
      <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-4 w-full sm:max-w-md pt-2">
        <button class="w-full py-3.5 px-6 rounded-md bg-[#f2f4f7] hover:bg-[#e7ebf0] active:bg-[#dde2e8] text-[#334155] font-semibold text-sm transition-colors text-center focus:outline-none" type="button">
          Add to Cart
        </button>
        <a href="https://wa.me/?text=<?php echo urlencode("Hello, I want to buy " . $product['product_name'] . " for UGX " . number_format($effectivePrice)); ?>" target="_blank" class="w-full py-3.5 px-6 rounded-md bg-blue-600 hover:bg-blue-700 text-white font-semibold text-sm transition-colors text-center shadow-sm inline-block">
          Buy via WhatsApp
        </a>
      </div>

    </section>

  </div>

  <!-- COMMENTS & REVIEWS SECTION -->
  <section class="mt-16 pt-10 border-t border-slate-200">
    <h2 class="text-2xl font-bold text-slate-900 mb-6">Customer Reviews & Discussion</h2>

    <?php if ($commentSuccess): ?>
      <div class="p-4 mb-6 rounded-xl bg-emerald-50 text-emerald-700 font-medium text-sm border border-emerald-200">
        <?php echo htmlspecialchars($commentSuccess); ?>
      </div>
    <?php endif; ?>

    <?php if ($commentError): ?>
      <div class="p-4 mb-6 rounded-xl bg-rose-50 text-rose-600 font-medium text-sm border border-rose-200">
        <?php echo htmlspecialchars($commentError); ?>
      </div>
    <?php endif; ?>

    <!-- Comment Form for Logged-In Users -->
    <div class="bg-slate-50 p-6 rounded-2xl border border-slate-200 mb-10 max-w-2xl">
      <?php if ($isLoggedIn): ?>
        <div class="flex items-center gap-3 mb-4 border-b border-slate-200/80 pb-3">
          <img src="<?php echo htmlspecialchars($displayUserPhoto); ?>" alt="Your Profile Picture" class="w-10 h-10 rounded-full object-cover border-2 border-blue-600 shadow-xs shrink-0"/>
          <div>
            <h3 class="text-sm font-bold text-slate-900"><?php echo htmlspecialchars($currentUserName); ?></h3>
            <p class="text-[11px] text-slate-500">Posting a public review</p>
          </div>
        </div>

        <form action="<?php echo htmlspecialchars($_SERVER['REQUEST_URI']); ?>" method="POST" class="space-y-4">
          <input type="hidden" name="submit_comment" value="1"/>

          <!-- Star Rating Input -->
          <div>
            <label class="block text-xs font-bold text-slate-600 uppercase mb-1">Your Rating</label>
            <div class="star-rating">
              <input type="radio" id="star5" name="rating" value="5" required /><label for="star5" title="5 stars"><i class="fa-solid fa-star"></i></label>
              <input type="radio" id="star4" name="rating" value="4" /><label for="star4" title="4 stars"><i class="fa-solid fa-star"></i></label>
              <input type="radio" id="star3" name="rating" value="3" /><label for="star3" title="3 stars"><i class="fa-solid fa-star"></i></label>
              <input type="radio" id="star2" name="rating" value="2" /><label for="star2" title="2 stars"><i class="fa-solid fa-star"></i></label>
              <input type="radio" id="star1" name="rating" value="1" /><label for="star1" title="1 star"><i class="fa-solid fa-star"></i></label>
            </div>
          </div>

          <div>
            <label class="block text-xs font-bold text-slate-600 uppercase mb-1">Your Comment</label>
            <textarea name="comment_text" rows="3" required placeholder="Write what you think about this product..." class="w-full p-3 bg-white border border-slate-200 rounded-xl text-sm font-medium focus:outline-none focus:border-blue-600"></textarea>
          </div>

          <button type="submit" class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs rounded-xl shadow-sm transition-colors">
            Post Review
          </button>
        </form>
      <?php else: ?>
        <div class="text-sm text-slate-600">
          Please <a href="../login.php" class="font-bold text-blue-600 hover:underline">Sign In</a> to write a review for this product.
        </div>
      <?php endif; ?>
    </div>

    <!-- Display Comments Below Product -->
    <div class="space-y-4 max-w-3xl">
      <h3 class="text-lg font-extrabold text-slate-900 mb-4">Reviews & Comments (<?php echo $totalComments; ?>)</h3>

      <?php if (empty($comments)): ?>
        <p class="text-sm text-slate-500 italic">No reviews yet. Be the first to leave feedback!</p>
      <?php else: ?>
        <?php foreach ($comments as $com): 
          $comPhoto = !empty($com['profile_photo']) ? $com['profile_photo'] : 'uploads/avatars/default-avatar.png';
          $avatarPath = (strpos($comPhoto, 'http') === 0) ? $comPhoto : '../' . ltrim($comPhoto, '/');
          $userRating = (int)($com['rating'] ?? 5);
        ?>
          <div class="p-5 bg-white border border-slate-200/80 rounded-2xl shadow-xs flex items-start gap-4">
            <img src="<?php echo htmlspecialchars($avatarPath); ?>" alt="User Profile Picture" class="w-10 h-10 rounded-full object-cover border border-slate-200 shrink-0"/>
            <div class="flex-grow">
              <div class="flex items-center justify-between">
                <h4 class="text-xs font-bold text-slate-900"><?php echo htmlspecialchars($com['full_name']); ?></h4>
                <span class="text-[11px] text-slate-400"><?php echo date('M d, Y h:i A', strtotime($com['created_at'])); ?></span>
              </div>

              <!-- Rating Display -->
              <div class="flex items-center text-amber-400 space-x-0.5 my-1">
                <?php for ($s = 1; $s <= 5; $s++): ?>
                  <i class="<?php echo $s <= $userRating ? 'fa-solid' : 'fa-regular'; ?> fa-star text-[11px]"></i>
                <?php endfor; ?>
              </div>

              <p class="text-xs text-slate-600 mt-2 leading-relaxed"><?php echo nl2br(htmlspecialchars($com['comment_text'])); ?></p>
            </div>
          </div>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>
  </section>

</main>

<script>
  function switchImage(src) {
    document.getElementById('main-product-img').src = src;
  }
</script>
</body>
</html>