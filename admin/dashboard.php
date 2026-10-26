<?php
// Enable output buffering and sessions at the very first line
ob_start();
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../includes/db_connect.php';

// --- Auth guard: must be logged in ---
if (empty($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// --- Pending orders / recent notifications ---
$pendingOrdersCount = 0;
$recentOrders = [];
if (isset($pdo)) {
    try {
        $countStmt = $pdo->query("SELECT COUNT(*) FROM `orders` WHERE `payment_status` = 'Pending'");
        $pendingOrdersCount = (int) $countStmt->fetchColumn();

        $listStmt = $pdo->query("SELECT `order_number`, `shipping_address`, `created_at` FROM `orders` ORDER BY `id` DESC LIMIT 5");
        $recentOrders = $listStmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (Throwable $e) {
        $pendingOrdersCount = 0;
        $recentOrders = [];
    }
}

// --- Logged-in user profile ---
$currentUser = null;
if (isset($pdo)) {
    try {
        $stmt = $pdo->prepare(
            "SELECT user_id, role, email, trainer_name, profile_pic
             FROM gymnuser
             WHERE user_id = :id
             LIMIT 1"
        );
        $stmt->execute([':id' => $_SESSION['user_id']]);
        $currentUser = $stmt->fetch() ?: null;
    } catch (Throwable $e) {
        $currentUser = null;
    }
}

// Derive display values with graceful fallbacks
$displayName  = trim($currentUser['trainer_name'] ?? '') ?: ($_SESSION['name']  ?? 'User');
$displayEmail = $currentUser['email']  ?? $_SESSION['email'] ?? '';
$displayRole  = $currentUser['role']   ?? $_SESSION['role']  ?? 'user';

$roleLabels = [
    'admin'           => 'Administrator',
    'product_manager' => 'Product Manager',
    'manager'         => 'Manager',
    'trainer'         => 'Trainer',
    'member'          => 'Member',
];
$roleLabel = $roleLabels[$displayRole] ?? ucfirst($displayRole);

// Profile picture path (DB stores e.g. "uploads/avatars/user_xxx.jpg")
$profilePic = null;
if (!empty($currentUser['profile_pic'])) {
    $rel = ltrim($currentUser['profile_pic'], '/');
    if (is_file(__DIR__ . '/../' . $rel)) {
        $profilePic = '../' . $rel;
    }
}

// Initials (first letters of first two words, uppercase)
$initials = '';
if ($displayName !== '') {
    $parts = preg_split('/\s+/', $displayName);
    foreach ($parts as $p) {
        if ($p === '') continue;
        $initials .= mb_strtoupper(mb_substr($p, 0, 1));
        if (mb_strlen($initials) >= 2) break;
    }
}
if ($initials === '') { $initials = 'U'; }
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>PURE GAIN - Admin Panel</title>
<script src="https://cdn.tailwindcss.com"></script>
<script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            brand: {
              50: '#eff6ff', 100: '#dbeafe', 500: '#3b82f6',
              600: '#2563eb', 700: '#1d4ed8', navy: '#1e3a8a'
            }
          }
        }
      }
    }
</script>
<style>
    body { background-color: #ffffff; color: #334155; }
    input::placeholder, textarea::placeholder { color: #94a3b8; }

    .sidebar-gradient {
        background: linear-gradient(180deg, #f0f7ff 0%, #dbeafe 40%, #1e3a8a 100%);
    }

    @media (max-width: 767px) {
      .mobile-drawer {
        position: fixed !important;
        top: 0; bottom: 0; left: 0;
        z-index: 50;
        transform: translateX(-100%);
        transition: transform 0.3s ease-in-out;
        box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1), 0 10px 10px -5px rgba(0,0,0,0.04);
      }
      .mobile-drawer.drawer-open { transform: translateX(0) !important; }
    }
</style>
</head>
<body class="min-h-screen flex flex-col font-sans antialiased text-slate-800 bg-white">

<!-- Live Notification Toast Container -->
<div id="toast-container" class="fixed bottom-5 right-5 z-50 flex flex-col gap-3 pointer-events-none"></div>

<!-- Mobile Sidebar Backdrop Overlay -->
<div id="sidebar-backdrop" onclick="toggleMobileSidebar()" class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-40 hidden md:hidden"></div>

<!-- BEGIN: PageContainer -->
<div class="flex-1 flex overflow-hidden relative">

  <!-- BEGIN: Sidebar -->
  <aside id="app-sidebar" class="mobile-drawer sidebar-gradient w-64 border-r border-blue-200/50 flex flex-col shrink-0 select-none md:static md:translate-x-0" data-purpose="sidebar-navigation">

    <div class="p-4 sm:p-6 border-b border-white/20 flex items-center justify-between gap-2 bg-white/30 backdrop-blur-md">
      <div class="flex items-center gap-3">
        <img src="../assets/images/fav.png" alt="Logo" class="w-9 h-9 object-contain drop-shadow-sm">
        <span class="font-bold text-base sm:text-lg text-brand-navy tracking-tight">PURE GAIN</span>
      </div>
      <button onclick="toggleMobileSidebar()" class="md:hidden p-1.5 text-slate-700 hover:text-slate-900 hover:bg-white/50 rounded-lg">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
        </svg>
      </button>
    </div>

    <nav class="flex-1 pt-3 space-y-1 overflow-y-auto pb-6">

      <!-- Product Overview — default active -->
      <button id="nav-btn-product-overview" onclick="switchScreen('product-overview', this)" class="nav-item w-full relative flex items-center gap-3.5 px-6 py-3.5 text-sm font-bold bg-white/80 text-brand-navy border-r-4 border-brand-navy shadow-sm transition-colors text-left backdrop-blur-sm">
        <svg class="w-5 h-5 text-brand-navy stroke-[1.8]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
        </svg>
        <span>Product Overview</span>
      </button>

      <button id="nav-btn-add-product" onclick="switchScreen('add-product', this)" class="nav-item w-full relative flex items-center gap-3.5 px-6 py-3.5 text-sm font-semibold text-slate-700 hover:text-brand-navy hover:bg-white/40 transition-colors text-left">
        <svg class="w-5 h-5 text-slate-600 stroke-[1.8]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <rect height="18" rx="4" stroke-width="2" width="18" x="3" y="3"></rect>
          <path d="M12 8v8m-4-4h8" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
        </svg>
        <span>Add Product</span>
      </button>

      <button onclick="switchScreen('product-list', this)" class="nav-item w-full flex items-center gap-3.5 px-6 py-3.5 text-sm font-semibold text-slate-700 hover:text-brand-navy hover:bg-white/40 transition-colors text-left">
        <svg class="w-5 h-5 text-slate-600 stroke-[1.8]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path d="M4 6h16M4 12h16M4 18h11" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
        </svg>
        <span>Product List</span>
      </button>

      <button onclick="switchScreen('orders', this)" class="nav-item w-full flex items-center gap-3.5 px-6 py-3.5 text-sm font-semibold text-slate-700 hover:text-brand-navy hover:bg-white/40 transition-colors text-left">
        <svg class="w-5 h-5 text-slate-600 stroke-[1.8]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <rect height="16" rx="2" stroke-width="2" width="16" x="4" y="4"></rect>
          <path d="M9 12l2 2 4-4" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
        </svg>
        <span>Orders</span>
      </button>

      <button onclick="switchScreen('contact-messages', this)" class="nav-item w-full flex items-center gap-3.5 px-6 py-3.5 text-sm font-semibold text-slate-700 hover:text-brand-navy hover:bg-white/40 transition-colors text-left">
        <svg class="w-5 h-5 text-slate-600 stroke-[1.8]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
        </svg>
        <span>Messages</span>
      </button>

      <button onclick="switchScreen('add-user', this)" class="nav-item w-full flex items-center gap-3.5 px-6 py-3.5 text-sm font-semibold text-slate-700 hover:text-brand-navy hover:bg-white/40 transition-colors text-left">
        <svg class="w-5 h-5 text-slate-600 stroke-[1.8]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
        </svg>
        <span>Add User</span>
      </button>

      <div class="pt-1">
        <button onclick="toggleGymDropdown()" class="w-full flex items-center justify-between px-6 py-3.5 text-sm font-semibold text-slate-700 hover:text-brand-navy hover:bg-white/40 transition-colors text-left">
          <div class="flex items-center gap-3.5">
            <svg class="w-5 h-5 text-slate-600 stroke-[1.8]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.75 13.5l10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75z"></path>
            </svg>
            <span>Gym Management</span>
          </div>
          <svg id="gym-chevron" class="w-4 h-4 text-slate-500 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
          </svg>
        </button>

        <div id="gym-submenu" class="hidden pl-12 pr-6 py-1 space-y-1 bg-white/20 backdrop-blur-sm border-y border-white/20">
          <button onclick="switchScreen('gym-dashboard', this)" class="nav-item w-full block py-2 text-xs font-semibold text-slate-700 hover:text-brand-navy transition-colors text-left">Dashboard Overview</button>
          <button onclick="switchScreen('gym-members', this)" class="nav-item w-full block py-2 text-xs font-semibold text-slate-700 hover:text-brand-navy transition-colors text-left">Members</button>
          <button onclick="switchScreen('gym-subscriptions', this)" class="nav-item w-full block py-2 text-xs font-semibold text-slate-700 hover:text-brand-navy transition-colors text-left">Subscriptions</button>
          <button onclick="switchScreen('gym-bookings', this)" class="nav-item w-full block py-2 text-xs font-semibold text-slate-700 hover:text-brand-navy transition-colors text-left">Class Bookings</button>
          <button onclick="switchScreen('gym-trainers', this)" class="nav-item w-full block py-2 text-xs font-semibold text-slate-700 hover:text-brand-navy transition-colors text-left">Trainer Management</button>
        </div>
      </div>

    </nav>
  </aside>
  <!-- END: Sidebar -->

  <!-- BEGIN: Content Wrapper -->
  <div class="flex-1 flex flex-col min-w-0 overflow-hidden bg-white">

    <!-- BEGIN: Top Header Bar -->
    <header class="h-16 border-b border-gray-200 bg-white px-3 sm:px-8 flex items-center justify-between shrink-0 gap-2">

      <div class="flex items-center gap-2 sm:gap-3 flex-1 min-w-0">
        <button onclick="toggleMobileSidebar()" class="md:hidden p-2 text-slate-700 hover:bg-slate-100 rounded-lg focus:outline-none shrink-0" title="Toggle Navigation Menu">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
          </svg>
        </button>

        <div class="relative w-full max-w-[180px] sm:max-w-xs">
          <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
            </svg>
          </span>
          <input type="text" placeholder="Search..." class="w-full pl-9 pr-3 py-1.5 text-xs bg-slate-50 border border-slate-200 rounded-md focus:outline-none focus:ring-1 focus:ring-blue-600 focus:bg-white text-slate-800" />
        </div>
      </div>

      <div class="flex items-center gap-1.5 sm:gap-4 shrink-0">

        <!-- Activity History -->
        <div class="relative">
          <button onclick="toggleDropdown('history-dropdown')" class="p-2 text-slate-500 hover:text-slate-900 hover:bg-slate-100 rounded-full transition relative" title="Activity History">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
          </button>

          <div id="history-dropdown" class="hidden absolute right-0 mt-2 w-72 sm:w-80 bg-white border border-slate-200 rounded-md shadow-lg py-2 z-50">
            <div class="px-4 py-1.5 border-b border-slate-100 font-bold text-xs text-slate-900">Recent Activity Logs</div>
            <div class="max-h-60 overflow-y-auto divide-y divide-slate-100">
              <div class="px-4 py-2 hover:bg-slate-50">
                <p class="text-xs font-medium text-slate-800">Allocated Trainer Marcus</p>
                <span class="text-[10px] text-slate-400">Today, 03:42 PM</span>
              </div>
              <div class="px-4 py-2 hover:bg-slate-50">
                <p class="text-xs font-medium text-slate-800">Added Creatine Monohydrate</p>
                <span class="text-[10px] text-slate-400">Yesterday, 11:15 AM</span>
              </div>
            </div>
            <div class="px-4 pt-2 border-t border-slate-100 text-center">
              <a href="#" onclick="switchScreen('history', this); toggleDropdown('history-dropdown');" class="text-[11px] font-semibold text-blue-600 hover:underline">View Full History</a>
            </div>
          </div>
        </div>

        <!-- Notifications -->
        <div class="relative">
          <button onclick="toggleDropdown('notifications-dropdown')" class="p-2 text-slate-500 hover:text-slate-900 hover:bg-slate-100 rounded-full transition relative" title="Notifications">
            <span id="notif-badge" class="absolute top-1.5 right-1.5 w-2 h-2 bg-rose-500 rounded-full <?php echo ($pendingOrdersCount > 0) ? '' : 'hidden'; ?>"></span>
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
            </svg>
          </button>

          <div id="notifications-dropdown" class="hidden absolute right-0 mt-2 w-72 sm:w-80 bg-white border border-slate-200 rounded-md shadow-lg py-2 z-50">
            <div class="px-4 py-1.5 border-b border-slate-100 font-bold text-xs text-slate-900 flex justify-between items-center">
              <span>Notifications</span>
              <span id="notif-count-label" class="bg-blue-100 text-blue-800 text-[10px] font-semibold px-1.5 py-0.5 rounded-full"><?php echo $pendingOrdersCount; ?> Pending</span>
            </div>
            <div id="notifications-list" class="max-h-60 overflow-y-auto divide-y divide-slate-100">
              <?php if (empty($recentOrders)): ?>
                <div class="px-4 py-3 text-xs text-slate-400 text-center">No recent notifications</div>
              <?php else: ?>
                <?php foreach ($recentOrders as $ord): ?>
                  <div class="px-4 py-2 hover:bg-slate-50 cursor-pointer" onclick="switchScreen('orders', document.querySelector('[onclick*=\'orders\']'))">
                    <p class="text-xs font-medium text-slate-800">New order #<?php echo htmlspecialchars($ord['order_number']); ?></p>
                    <span class="text-[10px] text-slate-400"><?php echo htmlspecialchars($ord['created_at']); ?></span>
                  </div>
                <?php endforeach; ?>
              <?php endif; ?>
            </div>
          </div>
        </div>

        <div class="h-6 w-px bg-slate-200 hidden sm:block"></div>

        <!-- User Profile Dropdown -->
        <div class="relative">
          <button onclick="toggleDropdown('profile-dropdown')" class="flex items-center gap-2 sm:gap-3 focus:outline-none">

            <?php if ($profilePic): ?>
              <img src="<?= htmlspecialchars($profilePic) ?>"
                   alt="<?= htmlspecialchars($displayName) ?>"
                   class="w-8 h-8 sm:w-9 sm:h-9 rounded-full object-cover shadow-sm shrink-0 border border-slate-200">
            <?php else: ?>
              <div class="w-8 h-8 sm:w-9 sm:h-9 rounded-full bg-blue-600 text-white font-semibold text-xs flex items-center justify-center shadow-sm shrink-0">
                <?= htmlspecialchars($initials) ?>
              </div>
            <?php endif; ?>

            <div class="text-left hidden sm:block">
              <div class="text-xs font-bold text-slate-900"><?= htmlspecialchars($displayName) ?></div>
              <div class="text-[10px] text-slate-500"><?= htmlspecialchars($roleLabel) ?></div>
            </div>
            <svg class="w-4 h-4 text-slate-400 hidden sm:block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
            </svg>
          </button>

          <div id="profile-dropdown" class="hidden absolute right-0 mt-2 w-48 bg-white border border-slate-200 rounded-md shadow-lg py-1 z-50">
            <a href="#" onclick="switchScreen('profile', this); toggleDropdown('profile-dropdown');" class="block px-4 py-2 text-xs text-slate-700 hover:bg-slate-50">Your Profile</a>
            <a href="#" onclick="switchScreen('settings', this); toggleDropdown('profile-dropdown');" class="block px-4 py-2 text-xs text-slate-700 hover:bg-slate-50">Settings</a>
            <div class="border-t border-slate-100 my-1"></div>
            <a href="logout.php" class="block px-4 py-2 text-xs text-rose-600 hover:bg-rose-50 font-medium">Log Out</a>
          </div>
        </div>

      </div>
    </header>
    <!-- END: Top Header Bar -->

    <!-- BEGIN: MainContent -->
    <main class="flex-1 overflow-y-auto px-3 sm:px-10 py-5 sm:py-8 bg-white relative" data-purpose="main-content-area">

      <div id="screen-loading" class="absolute inset-0 bg-white/80 backdrop-blur-[2px] z-30 flex flex-col items-center justify-center transition-opacity duration-200 hidden">
        <div class="w-10 h-10 border-4 border-blue-600 border-t-transparent rounded-full animate-spin"></div>
        <p class="text-xs font-semibold text-slate-600 mt-3 tracking-wide">Loading...</p>
      </div>

      <?php @include(__DIR__ . '/views/product-overview.php'); ?>
      <?php @include(__DIR__ . '/views/addproduct.php'); ?>
      <?php @include(__DIR__ . '/views/product-list.php'); ?>
      <?php @include(__DIR__ . '/views/orders.php'); ?>
      <?php @include(__DIR__ . '/views/contactmessages.php'); ?>
      <?php @include(__DIR__ . '/views/overview.php'); ?>
      <?php @include(__DIR__ . '/views/gym-members.php'); ?>
      <?php @include(__DIR__ . '/views/gym-subscriptions.php'); ?>
      <?php @include(__DIR__ . '/views/gym-bookings.php'); ?>
      <?php @include(__DIR__ . '/views/gym-trainers.php'); ?>
      <?php @include(__DIR__ . '/views/screen-profile.php'); ?>
      <?php @include(__DIR__ . '/views/screen-history.php'); ?>
      <?php @include(__DIR__ . '/views/screen-settings.php'); ?>
      <?php @include(__DIR__ . '/views/add-user.php'); ?>

    </main>
    <!-- END: MainContent -->

  </div>
  <!-- END: Content Wrapper -->

</div>
<!-- END: PageContainer -->

<script>
  function toggleMobileSidebar() {
    const sidebar = document.getElementById('app-sidebar');
    const backdrop = document.getElementById('sidebar-backdrop');
    sidebar.classList.toggle('drawer-open');
    backdrop.classList.toggle('hidden');
  }

  function toggleGymDropdown() {
    const submenu = document.getElementById('gym-submenu');
    const chevron = document.getElementById('gym-chevron');
    submenu.classList.toggle('hidden');
    chevron.classList.toggle('rotate-180');
  }

  function toggleDropdown(dropdownId) {
    const target = document.getElementById(dropdownId);
    const isHidden = target.classList.contains('hidden');

    ['profile-dropdown', 'history-dropdown', 'notifications-dropdown'].forEach(id => {
      const el = document.getElementById(id);
      if (el) el.classList.add('hidden');
    });

    if (isHidden && target) {
      target.classList.remove('hidden');
    }
  }

  window.addEventListener('click', function(e) {
    if (!e.target.closest('header .relative')) {
      ['profile-dropdown', 'history-dropdown', 'notifications-dropdown'].forEach(id => {
        const el = document.getElementById(id);
        if (el && !el.contains(e.target)) {
          el.classList.add('hidden');
        }
      });
    }
  });

  function switchScreen(screenId, element) {
    const loader = document.getElementById('screen-loading');
    if (loader) loader.classList.remove('hidden');

    setTimeout(() => {
      document.querySelectorAll('[id^="screen-"]').forEach(screen => {
        if (screen.id !== 'screen-loading') {
          screen.classList.add('hidden');
        }
      });

      const target = document.getElementById('screen-' + screenId);
      if (target) {
        target.classList.remove('hidden');
      }

      document.querySelectorAll('.nav-item').forEach(item => {
        item.classList.remove('bg-white/80', 'text-brand-navy', 'border-r-4', 'border-brand-navy', 'font-bold', 'shadow-sm');
        item.classList.add('text-slate-700', 'font-semibold');
        const svg = item.querySelector('svg');
        if (svg) svg.classList.replace('text-brand-navy', 'text-slate-600');
      });

      if (element && element.closest('#gym-submenu')) {
        element.classList.remove('text-slate-700');
        element.classList.add('text-brand-navy', 'font-bold');
      } else if (element && element.classList.contains('nav-item')) {
        element.classList.remove('text-slate-700', 'hover:text-brand-navy', 'hover:bg-white/40', 'font-semibold');
        element.classList.add('bg-white/80', 'text-brand-navy', 'border-r-4', 'border-brand-navy', 'font-bold', 'shadow-sm');
        const activeSvg = element.querySelector('svg');
        if (activeSvg) activeSvg.classList.replace('text-slate-600', 'text-brand-navy');
      }

      if (loader) loader.classList.add('hidden');
    }, 250);

    if (window.innerWidth < 768) {
      const sidebar = document.getElementById('app-sidebar');
      const backdrop = document.getElementById('sidebar-backdrop');
      sidebar.classList.remove('drawer-open');
      backdrop.classList.add('hidden');
    }
  }

  function showOrderToast(orderNumber, amount) {
    const container = document.getElementById('toast-container');
    const toast = document.createElement('div');
    toast.className = "pointer-events-auto bg-white border border-slate-200 shadow-xl rounded-lg p-4 w-80 toast-animate flex items-start gap-3";
    toast.innerHTML = `
      <div class="w-10 h-10 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center shrink-0">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
      </div>
      <div class="flex-1 min-w-0">
        <p class="text-xs font-bold text-slate-900">New Order Received! (#${orderNumber})</p>
        <p class="text-xs text-slate-500 mt-0.5">Total: UGX ${Number(amount).toLocaleString()}</p>
      </div>
      <button onclick="this.parentElement.remove()" class="text-slate-400 hover:text-slate-600 text-sm font-bold">&times;</button>
    `;
    container.appendChild(toast);
    setTimeout(() => { toast.remove(); }, 6000);
  }

  let lastKnownOrderCount = <?php echo $pendingOrdersCount; ?>;
  async function checkNewOrders() {
    try {
      const response = await window.fetch(window.location.href, { headers: { 'X-Poll-Check': '1' } });
    } catch (e) { /* silent */ }
  }

  document.addEventListener('DOMContentLoaded', () => {
    const defaultNavBtn = document.getElementById('nav-btn-product-overview');
    switchScreen('product-overview', defaultNavBtn);
  });
</script>

</body>
</html>
<?php
ob_end_flush();
?>