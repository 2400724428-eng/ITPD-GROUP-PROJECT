<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../includes/db_connect.php';

// Auth Guard: Redirect to login if user is not authenticated
if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.php');
    exit;
}

$userId   = $_SESSION['user_id'];
$userName = $_SESSION['full_name'] ?? 'User';
$userEmail= $_SESSION['email'] ?? '';
$userPhoto= $_SESSION['profile_photo'] ?? 'uploads/avatars/default-avatar.png';

// Handle Profile & Settings Update (Display Name & Photo)
$flashMessage = '';
$flashType    = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action_type']) && $_POST['action_type'] === 'update_profile') {
    $newFullName = trim($_POST['full_name'] ?? '');

    if (!empty($newFullName)) {
        $photoPath = $userPhoto;
        $uploadError = null;

        if (isset($_FILES['profile_photo']) && $_FILES['profile_photo']['error'] !== UPLOAD_ERR_NO_FILE) {
            if ($_FILES['profile_photo']['error'] === UPLOAD_ERR_OK) {
                $ext = strtolower(pathinfo($_FILES['profile_photo']['name'], PATHINFO_EXTENSION));
                $allowed = ['jpg', 'jpeg', 'png', 'webp'];

                if (in_array($ext, $allowed)) {
                    $uploadDir = __DIR__ . '/../uploads/avatars/';
                    if (!is_dir($uploadDir)) {
                        @mkdir($uploadDir, 0777, true);
                    }

                    $filename   = 'user_' . $userId . '_' . time() . '.' . $ext;
                    $targetFile = $uploadDir . $filename;

                    if (move_uploaded_file($_FILES['profile_photo']['tmp_name'], $targetFile)) {
                        $photoPath = 'uploads/avatars/' . $filename;
                    } else {
                        $uploadError = 'Failed to move uploaded file.';
                    }
                } else {
                    $uploadError = 'Invalid image format. Only JPG, PNG, and WEBP allowed.';
                }
            }
        }

        if ($uploadError) {
            $flashMessage = $uploadError;
            $flashType    = 'error';
        } else {
            $stmt = $pdo->prepare("UPDATE users SET full_name = ?, profile_photo = ? WHERE id = ?");
            if ($stmt->execute([$newFullName, $photoPath, $userId])) {
                $_SESSION['full_name']     = $newFullName;
                $_SESSION['profile_photo'] = $photoPath;
                $userName  = $newFullName;
                $userPhoto = $photoPath;

                $flashMessage = 'Profile updated successfully!';
                $flashType    = 'success';
            } else {
                $flashMessage = 'Failed to update database record.';
                $flashType    = 'error';
            }
        }
    } else {
        $flashMessage = 'Display name cannot be empty.';
        $flashType    = 'error';
    }
}

// Fetch user orders
$ordersStmt = $pdo->prepare("SELECT * FROM orders WHERE user_id = ? ORDER BY created_at DESC");
$ordersStmt->execute([$userId]);
$orders = $ordersStmt->fetchAll();

// Fetch wishlist items joined with product details
$wishlistQuery = $pdo->prepare("
    SELECT 
        p.id AS product_id,
        p.product_name AS name,
        p.product_price AS price,
        p.offer_price AS offer,
        p.unit_type AS unit,
        p.image_primary AS img,
        w.created_at AS added_date
    FROM wishlist w
    JOIN products p ON w.product_id = p.id
    WHERE w.user_id = ?
    ORDER BY w.created_at DESC
");
$wishlistQuery->execute([$userId]);
$wishlistItems = $wishlistQuery->fetchAll(PDO::FETCH_ASSOC);
$wishlistCount = count($wishlistItems);

// Helper to sanitize photo paths safely across different subdirectories
$displayPhoto = (strpos($userPhoto, 'http') === 0) ? $userPhoto : '../' . ltrim($userPhoto, '/');
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>User Dashboard - PURE GAIN</title>
<link href="../src/output.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet"/>
<link href="https://fonts.googleapis.com" rel="preconnect"/>
<link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect"/>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet"/>
<script>
tailwind.config = { theme: { extend: { fontFamily: { sans: ['"Plus Jakarta Sans"', 'sans-serif'] } } } }
</script>
</head>
<body class="bg-slate-50 text-slate-800 font-sans antialiased min-h-screen flex flex-col">

<!-- Header -->
<header class="w-full bg-white border-b border-slate-200 sticky top-0 z-40">
  <div class="max-w-[1200px] mx-auto px-4 h-16 flex items-center justify-between">
    <a href="../index.php" class="flex items-center gap-2">
      <img src="../assets/images/logos.png" alt="PURE GAIN Logo" class="h-10 w-auto object-contain"/>
    </a>
    <div class="flex items-center gap-4">
      <a href="../shop.php" class="text-xs font-bold text-slate-600 hover:text-blue-600 transition-colors hidden sm:inline-block">Shop Catalog</a>
      <a href="../login_process.php?action=logout" onclick="event.preventDefault(); handleLogout();" class="px-3.5 py-1.5 rounded-xl bg-red-50 text-red-600 text-xs font-bold hover:bg-red-100 transition-colors">
        Sign Out
      </a>
    </div>
  </div>
</header>

<!-- Main Container -->
<main class="flex-grow max-w-[1200px] w-full mx-auto px-4 py-8">

  <!-- User Card Header -->
  <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200/80 shadow-xs mb-8 flex flex-col md:flex-row items-center justify-between gap-6">
    <div class="flex items-center gap-5">
      <img src="<?= htmlspecialchars($displayPhoto) ?>" alt="User Avatar" class="w-20 h-20 rounded-full object-cover border-4 border-blue-600 shadow-md shrink-0"/>
      <div>
        <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight"><?= htmlspecialchars($userName) ?></h1>
        <p class="text-xs font-medium text-slate-500 mt-0.5"><?= htmlspecialchars($userEmail) ?></p>
        <span class="inline-block mt-2 px-2.5 py-0.5 rounded-full bg-blue-50 text-blue-700 text-[11px] font-bold border border-blue-200">
          Member Status: Active
        </span>
      </div>
    </div>

    <!-- Quick Stats -->
    <div class="flex items-center gap-3 w-full md:w-auto">
      <div class="flex-1 md:flex-none p-4 rounded-2xl bg-slate-50 border border-slate-100 text-center min-w-[110px]">
        <p class="text-xs font-bold text-slate-400 uppercase">Orders</p>
        <p class="text-xl font-black text-slate-900 mt-1"><?= count($orders) ?></p>
      </div>
      <div class="flex-1 md:flex-none p-4 rounded-2xl bg-slate-50 border border-slate-100 text-center min-w-[110px]">
        <p class="text-xs font-bold text-slate-400 uppercase">Wishlist</p>
        <p class="text-xl font-black text-slate-900 mt-1"><?= $wishlistCount ?></p>
      </div>
    </div>
  </div>

  <?php if ($flashMessage): ?>
    <div class="p-4 rounded-2xl text-xs font-bold mb-6 text-center <?= $flashType === 'success' ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 'bg-red-50 text-red-600 border border-red-200' ?>">
      <?= htmlspecialchars($flashMessage) ?>
    </div>
  <?php endif; ?>

  <!-- Navigation Tabs -->
  <div class="flex items-center gap-2 border-b border-slate-200 mb-8 overflow-x-auto">
    <button type="button" onclick="switchDashboardTab('overview')" id="tabBtnOverview" class="dashboard-tab-btn py-3 px-5 text-sm font-bold text-blue-600 border-b-2 border-blue-600 transition-colors whitespace-nowrap">
      <i class="fa-solid fa-chart-pie mr-2"></i>Overview
    </button>
    <button type="button" onclick="switchDashboardTab('orders')" id="tabBtnOrders" class="dashboard-tab-btn py-3 px-5 text-sm font-bold text-slate-500 border-b-2 border-transparent hover:text-slate-900 transition-colors whitespace-nowrap">
      <i class="fa-solid fa-box-archive mr-2"></i>My Orders
    </button>
    <button type="button" onclick="switchDashboardTab('wishlist')" id="tabBtnWishlist" class="dashboard-tab-btn py-3 px-5 text-sm font-bold text-slate-500 border-b-2 border-transparent hover:text-slate-900 transition-colors whitespace-nowrap">
      <i class="fa-solid fa-heart mr-2 text-red-500"></i>My Wishlist (<?= $wishlistCount ?>)
    </button>
    <button type="button" onclick="switchDashboardTab('settings')" id="tabBtnSettings" class="dashboard-tab-btn py-3 px-5 text-sm font-bold text-slate-500 border-b-2 border-transparent hover:text-slate-900 transition-colors whitespace-nowrap">
      <i class="fa-solid fa-sliders mr-2"></i>Settings & Profile
    </button>
  </div>

  <!-- TAB 1: OVERVIEW -->
  <div id="tabContentOverview" class="dashboard-tab-content space-y-6">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
      <div class="bg-white p-6 rounded-3xl border border-slate-200/80 shadow-xs">
        <h3 class="font-extrabold text-slate-900 text-base mb-2">Quick Actions</h3>
        <p class="text-xs text-slate-500 mb-6">Manage your supplement purchases and account features.</p>
        <div class="space-y-3">
          <a href="../shop.php" class="flex items-center justify-between p-3.5 rounded-2xl bg-slate-50 hover:bg-blue-50 hover:text-blue-600 transition-colors font-semibold text-xs text-slate-700">
            <span class="flex items-center gap-3"><i class="fa-solid fa-store text-blue-600"></i> Browse Supplement Store</span>
            <i class="fa-solid fa-chevron-right text-slate-400 text-xs"></i>
          </a>
          <a href="../cart.php" class="flex items-center justify-between p-3.5 rounded-2xl bg-slate-50 hover:bg-blue-50 hover:text-blue-600 transition-colors font-semibold text-xs text-slate-700">
            <span class="flex items-center gap-3"><i class="fa-solid fa-cart-shopping text-blue-600"></i> View Active Bag</span>
            <i class="fa-solid fa-chevron-right text-slate-400 text-xs"></i>
          </a>
        </div>
      </div>

      <div class="bg-white p-6 rounded-3xl border border-slate-200/80 shadow-xs">
        <h3 class="font-extrabold text-slate-900 text-base mb-2">Account Summary</h3>
        <p class="text-xs text-slate-500 mb-6">Primary information linked to your profile.</p>
        <div class="space-y-3 text-xs">
          <div class="flex justify-between py-2 border-b border-slate-100">
            <span class="text-slate-400 font-semibold">Full Name</span>
            <span class="font-bold text-slate-800"><?= htmlspecialchars($userName) ?></span>
          </div>
          <div class="flex justify-between py-2 border-b border-slate-100">
            <span class="text-slate-400 font-semibold">Email</span>
            <span class="font-bold text-slate-800"><?= htmlspecialchars($userEmail) ?></span>
          </div>
          <div class="flex justify-between py-2">
            <span class="text-slate-400 font-semibold">Security</span>
            <span class="font-bold text-emerald-600"><i class="fa-solid fa-shield-halved mr-1"></i> Password Protected</span>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- TAB 2: MY ORDERS -->
  <div id="tabContentOrders" class="dashboard-tab-content space-y-6 hidden">
    <div class="bg-white rounded-3xl border border-slate-200/80 shadow-xs overflow-hidden">
      <div class="p-6 border-b border-slate-100">
        <h3 class="font-extrabold text-slate-900 text-base">Order History</h3>
        <p class="text-xs text-slate-500 mt-1">Review status and details of your supplement orders.</p>
      </div>

      <?php if (empty($orders)): ?>
        <div class="p-12 text-center">
          <i class="fa-solid fa-box-open text-4xl text-slate-300 mb-3"></i>
          <p class="text-sm font-bold text-slate-700">No orders placed yet</p>
          <a href="../shop.php" class="inline-flex items-center mt-4 px-5 py-2.5 rounded-xl bg-blue-600 text-white text-xs font-bold hover:bg-blue-700 transition-colors">Start Shopping</a>
        </div>
      <?php else: ?>
        <div class="overflow-x-auto">
          <table class="w-full text-left border-collapse">
            <thead>
              <tr class="bg-slate-50 text-[11px] font-bold uppercase text-slate-400 border-b border-slate-100">
                <th class="py-3.5 px-6">Order ID</th>
                <th class="py-3.5 px-6">Date</th>
                <th class="py-3.5 px-6">Payment Method</th>
                <th class="py-3.5 px-6">Status</th>
                <th class="py-3.5 px-6 text-right">Total Amount</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 text-xs font-medium text-slate-700">
              <?php foreach ($orders as $order): ?>
                <tr class="hover:bg-slate-50/50 transition-colors">
                  <td class="py-4 px-6 font-bold text-slate-900"><?= htmlspecialchars($order['order_number']) ?></td>
                  <td class="py-4 px-6 text-slate-500"><?= date('M d, Y', strtotime($order['created_at'])) ?></td>
                  <td class="py-4 px-6"><?= htmlspecialchars($order['payment_method']) ?></td>
                  <td class="py-4 px-6">
                    <span class="px-2.5 py-1 rounded-full text-[10px] font-extrabold uppercase <?= $order['payment_status'] === 'paid' ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 'bg-amber-50 text-amber-700 border border-amber-200' ?>">
                      <?= htmlspecialchars($order['payment_status']) ?>
                    </span>
                  </td>
                  <td class="py-4 px-6 text-right font-bold text-slate-900">UGX <?= number_format($order['total_amount'], 2) ?></td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      <?php endif; ?>
    </div>
  </div>

  <!-- TAB 3: MY WISHLIST -->
  <div id="tabContentWishlist" class="dashboard-tab-content space-y-6 hidden">
    <div class="bg-white rounded-3xl border border-slate-200/80 shadow-xs overflow-hidden">
      <div class="p-6 border-b border-slate-100 flex items-center justify-between">
        <div>
          <h3 class="font-extrabold text-slate-900 text-base">My Saved Wishlist</h3>
          <p class="text-xs text-slate-500 mt-1">Supplements and items you have liked from the shop.</p>
        </div>
      </div>

      <?php if (empty($wishlistItems)): ?>
        <div class="p-12 text-center">
          <i class="fa-regular fa-heart text-4xl text-slate-300 mb-3"></i>
          <p class="text-sm font-bold text-slate-700">Your wishlist is empty</p>
          <p class="text-xs text-slate-400 mt-1 mb-6">Click the heart icon on any product in the shop to save it here.</p>
          <a href="../shop.php" class="inline-flex items-center px-5 py-2.5 rounded-xl bg-blue-600 text-white text-xs font-bold hover:bg-blue-700 transition-colors">Browse Shop</a>
        </div>
      <?php else: ?>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 p-6">
          <?php foreach ($wishlistItems as $item): 
            $price = (float)$item['price'];
            $offer = (float)$item['offer'];
            $effectivePrice = ($offer > 0 && $offer < $price) ? $offer : $price;
            
            // Fixed image path prefix check for subfolder view
            $rawImg = $item['img'];
            if (empty($rawImg)) {
                $img = 'https://images.unsplash.com/photo-1546483875-ad9014c88eba?auto=format&fit=crop&w=500&q=80';
            } elseif (strpos($rawImg, 'http') === 0) {
                $img = $rawImg;
            } else {
                $img = '../' . ltrim($rawImg, '/');
            }
          ?>
            <div class="flex items-center gap-4 p-4 rounded-2xl border border-slate-100 bg-slate-50/50 relative group">
              <a href="../product/product-detail.php?id=<?= $item['product_id'] ?>" class="w-16 h-16 shrink-0 bg-white rounded-xl border border-slate-200 flex items-center justify-center p-1 overflow-hidden">
                <img src="<?= htmlspecialchars($img) ?>" alt="<?= htmlspecialchars($item['name']) ?>" class="max-h-full max-w-full object-contain"/>
              </a>
              <div class="flex-1 min-w-0">
                <a href="../product/product-detail.php?id=<?= $item['product_id'] ?>" class="block text-xs font-bold text-slate-800 truncate hover:text-blue-600 transition-colors">
                  <?= htmlspecialchars($item['name']) ?>
                </a>
                <p class="text-xs font-extrabold text-slate-900 mt-1">UGX <?= number_format($effectivePrice) ?> <span class="text-[10px] text-slate-400 font-normal"><?= $item['unit'] ? ('/' . $item['unit']) : '' ?></span></p>
                <p class="text-[10px] text-slate-400 mt-0.5">Added: <?= date('M d, Y', strtotime($item['added_date'])) ?></p>
              </div>
              <button type="button" onclick="removeWishlistItem(<?= $item['product_id'] ?>)" class="w-8 h-8 rounded-full bg-white border border-slate-200 text-slate-400 hover:text-red-500 hover:border-red-200 flex items-center justify-center transition-colors shadow-xs" title="Remove from wishlist">
                <i class="fa-solid fa-trash-can text-xs"></i>
              </button>
            </div>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>
    </div>
  </div>

  <!-- TAB 4: SETTINGS -->
  <div id="tabContentSettings" class="dashboard-tab-content space-y-6 hidden">
    <div class="bg-white rounded-3xl border border-slate-200/80 shadow-xs p-6 sm:p-8 max-w-2xl mx-auto">
      <h3 class="font-extrabold text-slate-900 text-base mb-1">Display Name & Photo Settings</h3>
      <p class="text-xs text-slate-500 mb-6">Update your display name or upload a new profile picture.</p>

      <form action="dashboard.php" method="POST" enctype="multipart/form-data" class="space-y-6">
        <input type="hidden" name="action_type" value="update_profile"/>
        <div class="flex items-center gap-6">
          <img id="avatarPreview" src="<?= htmlspecialchars($displayPhoto) ?>" alt="Avatar Preview" class="w-20 h-20 rounded-full object-cover border-4 border-blue-600 shadow-sm shrink-0"/>
          <div>
            <label class="block text-xs font-bold text-slate-700 uppercase mb-2">Upload Profile Photo</label>
            <input type="file" name="profile_photo" accept="image/png, image/jpeg, image/webp" onchange="previewImage(event)" class="text-xs text-slate-500 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 transition-colors"/>
            <p class="text-[11px] text-slate-400 mt-1">PNG, JPG, or WEBP (Max 5MB).</p>
          </div>
        </div>
        <div>
          <label class="block text-xs font-bold text-slate-700 uppercase mb-1.5">Display Name</label>
          <input type="text" name="full_name" value="<?= htmlspecialchars($userName) ?>" required class="w-full h-11 px-4 bg-slate-50 border border-slate-200 rounded-xl text-sm font-medium text-slate-800 focus:outline-none focus:border-blue-600 focus:bg-white transition-colors"/>
        </div>
        <div>
          <label class="block text-xs font-bold text-slate-700 uppercase mb-1.5">Email Address</label>
          <input type="email" value="<?= htmlspecialchars($userEmail) ?>" disabled class="w-full h-11 px-4 bg-slate-100 border border-slate-200 rounded-xl text-sm font-medium text-slate-500 cursor-not-allowed"/>
        </div>
        <button type="submit" class="w-full h-11 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl shadow-md text-sm transition-colors">
          Save Settings
        </button>
      </form>
    </div>
  </div>

</main>

<script>
  function switchDashboardTab(tab) {
    document.querySelectorAll('.dashboard-tab-content').forEach(el => el.classList.add('hidden'));
    document.querySelectorAll('.dashboard-tab-btn').forEach(btn => {
      btn.className = 'dashboard-tab-btn py-3 px-5 text-sm font-bold text-slate-500 border-b-2 border-transparent hover:text-slate-900 transition-colors whitespace-nowrap';
    });

    const activeTabContent = document.getElementById('tabContent' + tab.charAt(0).toUpperCase() + tab.slice(1));
    const activeTabBtn = document.getElementById('tabBtn' + tab.charAt(0).toUpperCase() + tab.slice(1));

    if (activeTabContent) activeTabContent.classList.remove('hidden');
    if (activeTabBtn) activeTabBtn.className = 'dashboard-tab-btn py-3 px-5 text-sm font-bold text-blue-600 border-b-2 border-blue-600 transition-colors whitespace-nowrap';
  }

  function previewImage(e) {
    const [file] = e.target.files;
    if (file) {
      document.getElementById('avatarPreview').src = URL.createObjectURL(file);
    }
  }

  async function removeWishlistItem(productId) {
    try {
      const response = await fetch('../admin/api/toggle_wishlist.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ product_id: productId })
      });
      const data = await response.json();
      if (data.success) {
        location.reload(); 
      }
    } catch (err) {
      console.error('Failed to remove item', err);
    }
  }

  async function handleLogout() {
    const formData = new FormData();
    formData.append('action', 'logout');
    await fetch('../login_process.php', { method: 'POST', body: formData });
    window.location.href = '../login.php';
  }
</script>
</body>
</html>