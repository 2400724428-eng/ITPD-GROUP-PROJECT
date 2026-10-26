<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/db_connect.php';

$dbWishlistCount = 0;
$userId = isset($_SESSION['user_id'])
    ? (int) $_SESSION['user_id']
    : 0;

if ($userId > 0) {
    try {
        $stmt = $pdo->prepare(
            "SELECT COUNT(*) FROM wishlist WHERE user_id = ?"
        );
        $stmt->execute([$userId]);

        $dbWishlistCount = (int)$stmt->fetchColumn();
    } catch (PDOException $e) {
        // Keep the page working if the wishlist query fails.
        error_log('Wishlist count error: ' . $e->getMessage());
        $dbWishlistCount = 0;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>ApexFit - Supplements & Pro Training</title>
<!-- Tailwind CSS v3 -->
<link href="../src/output.css" rel="stylesheet">

<!-- Google Fonts -->
<link href="https://fonts.googleapis.com" rel="preconnect"/>
<link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect"/>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@500;600;700;800&family=Inter:wght@400;500;600&display=swap" rel="stylesheet"/>
<script>
    tailwind.config = {
      theme: {
        extend: {
          fontFamily: {
            sans: ['Plus Jakarta Sans', 'Inter', 'sans-serif'],
          },
          colors: {
            brand: {
              navy: '#1e3a8a',
              cardBg: 'rgba(255, 255, 255, 0.1)',
            }
          }
        }
      }
    }
</script>
<style>
    body {
      font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
      -webkit-font-smoothing: antialiased;
    }
</style>
</head>
<body class="bg-slate-50 text-slate-800 antialiased min-h-screen flex flex-col pb-16 md:pb-0">

<!-- BEGIN: MainHeader -->
<header class="w-full border-b border-slate-200 bg-white sticky top-0 z-50 shadow-xs" data-purpose="site-header">
<div class="max-w-[1100px] mx-auto px-4 h-16 flex items-center justify-between">

<!-- Left Side: Mobile Menu Button & Brand Logo -->
<div class="flex items-center gap-3">
  <button id="menuToggleBtn" aria-label="Toggle Menu" class="md:hidden p-1.5 text-slate-700 hover:text-blue-600 hover:bg-slate-100 rounded-lg transition-colors" type="button">
    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
    </svg>
  </button>

  <a class="flex items-center gap-2 select-none" href="index.php">
      <img src="assets/images/logos.png" alt="Logo Icon" style="width: 150px; height: auto; object-fit: contain;">
  </a>
</div>

<!-- Center Navigation Links (Desktop Only) -->
<nav class="hidden md:flex items-center space-x-4 text-[14px] font-medium text-slate-700" data-purpose="main-navigation">
    <a class="flex items-center gap-1.5 whitespace-nowrap hover:text-blue-600 transition-colors" href="index.php">
        <svg class="w-4 h-4 text-slate-500 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25"></path></svg>
        Home
    </a>
    <a class="flex items-center gap-1.5 whitespace-nowrap hover:text-blue-600 transition-colors" href="shop.php">
        <svg class="w-4 h-4 text-slate-500 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007zM8.625 10.5a.375.375 0 11-.75 0 .375.375 0 01.75 0zm7.5 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z"></path></svg>
        Shop
    </a>
    <a class="flex items-center gap-1.5 whitespace-nowrap hover:text-blue-600 transition-colors" href="portal/portalogin.php">
        <svg class="w-4 h-4 text-slate-500 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zM4 19.235v-.11a6.375 6.375 0 0112.75 0v.109A12.318 12.318 0 0110.374 21c-2.331 0-4.512-.645-6.374-1.766z"></path></svg>
        Join Training
    </a>
 
    <a class="flex items-center gap-1.5 whitespace-nowrap hover:text-blue-600 transition-colors" href="about.php">
        <svg class="w-4 h-4 text-slate-500 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z"></path></svg>
        About
    </a>
    <a class="flex items-center gap-1.5 whitespace-nowrap hover:text-blue-600 transition-colors" href="contact.php">
        <svg class="w-4 h-4 text-slate-500 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"></path></svg>
        Contact
    </a>
</nav>

<!-- Right Utility Actions -->
<div class="flex items-center space-x-2 sm:space-x-3 text-slate-700" data-purpose="user-utilities">
  
  <!-- Search Button (Always visible) -->
  <button id="searchToggleBtn" aria-label="Search" class="p-1.5 hover:text-blue-600 hover:bg-slate-100 rounded-full transition-colors" type="button">
    <svg class="w-5 h-5 stroke-[2]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
      <path d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" stroke-linecap="round" stroke-linejoin="round"></path>
    </svg>
  </button>

  <!-- Wishlist Icon (Always visible) -->
  <a
      aria-label="Wishlist (<?= $dbWishlistCount ?> items)"
      title="My Wishlist"
      class="relative p-1.5 hover:text-blue-600 hover:bg-slate-100 rounded-full transition-colors inline-flex items-center justify-center"
      href="users/dashboard.php"
  >
      <svg class="w-5 h-5 stroke-[2]" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
          <path d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" stroke-linecap="round" stroke-linejoin="round"/>
      </svg>
      <span
          id="wishlist-badge"
          class="absolute top-0.5 right-0.5 bg-red-600 text-white text-[10px] font-bold w-4 h-4 rounded-full flex items-center justify-center"
          style="<?= $dbWishlistCount > 0 ? 'display: flex;' : 'display: none;' ?>"
      ><?= $dbWishlistCount ?></span>
  </a>

  <!-- ADMIN ICON (Always visible) -->
  <a aria-label="Admin Dashboard" title="Admin Dashboard" class="p-1.5 hover:text-blue-600 hover:bg-slate-100 rounded-full transition-colors inline-flex items-center justify-center" href="admin/login.php">
    <svg class="w-5 h-5 stroke-[2]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
      <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z" />
    </svg>
  </a>

  <!-- Cart Symbol (Hidden on mobile header, visible on desktop) -->
  <a aria-label="Cart" class="hidden md:inline-flex relative p-1.5 hover:text-blue-600 hover:bg-slate-100 rounded-full transition-colors items-center justify-center" href="cart.php">
    <svg class="w-5 h-5 stroke-[2]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
      <path d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007zM8.625 10.5a.375.375 0 11-.75 0 .375.375 0 01.75 0zm7.5 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" stroke-linecap="round" stroke-linejoin="round"></path>
    </svg>
    <span id="cart-badge-desktop" class="absolute top-0.5 right-0.5 bg-red-600 text-white text-[10px] font-bold w-4 h-4 rounded-full flex items-center justify-center" style="display: none;">0</span>
  </a>

  <!-- Account Component (Hidden on mobile header) -->
  <div class="hidden md:block">
    <?php include_once __DIR__ . '/account.php'; ?>
  </div>

  <!-- Member Portal Button (Desktop Only) -->
  <div class="hidden md:block ml-2">
    <a class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full border border-slate-300 text-[13px] font-medium text-slate-800 hover:border-blue-400 hover:bg-slate-50 transition-all shadow-sm whitespace-nowrap shrink-0" href="portal/portalogin.php">
        <svg class="w-4 h-4 text-slate-600 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0012 15.75a7.488 7.488 0 00-5.982 2.975m11.963 0a9 9 0 10-11.963 0m11.963 0A8.966 8.966 0 0112 21a8.966 8.966 0 01-5.982-2.275M15 9.75a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
        Member Portal
    </a>
  </div>
</div>

</div>

<!-- Floating Search Bar Drawer -->
<div id="floatingSearch" class="hidden absolute top-full left-0 w-full bg-white border-b border-slate-200 shadow-md p-3 px-4 transition-all z-40">
  <form action="shop.php" method="GET" class="max-w-[700px] mx-auto flex items-center gap-2">
    <div class="relative flex-grow">
      <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/></svg>
      </span>
      <input type="text" name="q" value="<?= htmlspecialchars($_GET['q'] ?? '', ENT_QUOTES, 'UTF-8') ?>" placeholder="Search supplements, workouts, plans..." class="w-full pl-9 pr-4 py-2 bg-slate-50 border border-slate-300 rounded-lg text-sm text-slate-800 focus:outline-none focus:border-blue-600 focus:ring-1 focus:ring-blue-600">
    </div>
    <button type="submit" class="px-4 py-2 bg-blue-600 text-white font-medium text-sm rounded-lg hover:bg-blue-700 transition-colors shrink-0">
      Search
    </button>
  </form>
</div>
</header>
<!-- END: MainHeader -->

<!-- Mobile Bottom Navigation Bar (Account removed) -->
<nav class="md:hidden fixed bottom-0 left-0 w-full bg-white border-t border-slate-200 z-50 flex items-center justify-around h-16 px-2 shadow-lg" aria-label="Mobile Bottom Navigation">
    <!-- Home -->
    <a href="index.php" class="flex flex-col items-center justify-center text-slate-600 hover:text-blue-600 transition-colors flex-1 py-1">
        <svg class="w-5 h-5 mb-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25"></path></svg>
        <span class="text-[11px] font-medium">Home</span>
    </a>

    <!-- Shop -->
    <a href="shop.php" class="flex flex-col items-center justify-center text-slate-600 hover:text-blue-600 transition-colors flex-1 py-1">
        <svg class="w-5 h-5 mb-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007zM8.625 10.5a.375.375 0 11-.75 0 .375.375 0 01.75 0zm7.5 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z"></path></svg>
        <span class="text-[11px] font-medium">Shop</span>
    </a>

    <!-- Cart -->
    <a href="cart.php" class="relative flex flex-col items-center justify-center text-slate-600 hover:text-blue-600 transition-colors flex-1 py-1">
        <svg class="w-5 h-5 mb-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007zM8.625 10.5a.375.375 0 11-.75 0 .375.375 0 01.75 0zm7.5 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z"></path>
        </svg>
        <span class="text-[11px] font-medium">Cart</span>
        <span id="cart-badge-mobile" class="absolute top-1 right-5 bg-red-600 text-white text-[9px] font-bold w-4 h-4 rounded-full flex items-center justify-center" style="display: none;">0</span>
    </a>
</nav>

<!-- Mobile Navigation Drawer -->
<div id="mobileDrawerBackdrop" class="fixed inset-0 bg-black/50 z-50 hidden transition-opacity"></div>
<div id="mobileDrawer" class="fixed top-0 left-0 w-[280px] h-full bg-white shadow-2xl z-50 transform -translate-x-full transition-transform duration-300 flex flex-col">
  <div class="p-4 border-b border-slate-200 flex items-center justify-between">
    <span class="font-bold text-slate-900 text-lg">Menu</span>
    <button id="closeDrawerBtn" aria-label="Close Menu" class="p-1.5 text-slate-500 hover:text-slate-800 rounded-lg">
      <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
    </button>
  </div>
  
  <div class="flex-grow overflow-y-auto py-4 px-4 space-y-2 text-slate-700 font-medium">
    <a class="flex items-center gap-3 px-3 py-2.5 rounded-lg hover:bg-slate-100 hover:text-blue-600 transition-colors" href="index.php">
        <svg class="w-5 h-5 text-slate-500 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25"></path></svg>
        Home
    </a>
    <a class="flex items-center gap-3 px-3 py-2.5 rounded-lg hover:bg-slate-100 hover:text-blue-600 transition-colors" href="shop.php">
        <svg class="w-5 h-5 text-slate-500 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007zM8.625 10.5a.375.375 0 11-.75 0 .375.375 0 01.75 0zm7.5 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z"></path></svg>
        Shop
    </a>
    <a class="flex items-center gap-3 px-3 py-2.5 rounded-lg hover:bg-slate-100 hover:text-blue-600 transition-colors" href="portal/portalogin.php">
        <svg class="w-5 h-5 text-slate-500 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zM4 19.235v-.11a6.375 6.375 0 0112.75 0v.109A12.318 12.318 0 0110.374 21c-2.331 0-4.512-.645-6.374-1.766z"></path></svg>
        Join Training
    </a>

    <a class="flex items-center gap-3 px-3 py-2.5 rounded-lg hover:bg-slate-100 hover:text-blue-600 transition-colors" href="about.php">
        <svg class="w-5 h-5 text-slate-500 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z"></path></svg>
        About
    </a>
    <a class="flex items-center gap-3 px-3 py-2.5 rounded-lg hover:bg-slate-100 hover:text-blue-600 transition-colors" href="contact.php">
        <svg class="w-5 h-5 text-slate-500 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"></path></svg>
        Contact
    </a>
  </div>
</div>

<script>
  window.updateHeaderBadges = function() {
    const cart = JSON.parse(localStorage.getItem('puregain_cart')) || [];
    const totalCartItems = cart.reduce((sum, item) => sum + (item.quantity || 1), 0);
    
    const cartBadgeDesktop = document.getElementById('cart-badge-desktop');
    if (cartBadgeDesktop) {
      cartBadgeDesktop.textContent = totalCartItems;
      cartBadgeDesktop.style.display = totalCartItems > 0 ? 'flex' : 'none';
    }

    const cartBadgeMobile = document.getElementById('cart-badge-mobile');
    if (cartBadgeMobile) {
      cartBadgeMobile.textContent = totalCartItems;
      cartBadgeMobile.style.display = totalCartItems > 0 ? 'flex' : 'none';
    }
  };

  document.addEventListener('DOMContentLoaded', window.updateHeaderBadges);
  window.addEventListener('storage', window.updateHeaderBadges);
  setInterval(window.updateHeaderBadges, 1000);

  const searchToggleBtn = document.getElementById('searchToggleBtn');
  const floatingSearch = document.getElementById('floatingSearch');

  if (searchToggleBtn && floatingSearch) {
    searchToggleBtn.addEventListener('click', (e) => {
      e.stopPropagation();
      floatingSearch.classList.toggle('hidden');
      if (!floatingSearch.classList.contains('hidden')) {
        floatingSearch.querySelector('input').focus();
      }
    });

    window.addEventListener('click', (e) => {
      if (!floatingSearch.contains(e.target) && e.target !== searchToggleBtn && !searchToggleBtn.contains(e.target)) {
        floatingSearch.classList.add('hidden');
      }
    });
  }

  const menuToggleBtn = document.getElementById('menuToggleBtn');
  const mobileDrawer = document.getElementById('mobileDrawer');
  const mobileDrawerBackdrop = document.getElementById('mobileDrawerBackdrop');
  const closeDrawerBtn = document.getElementById('closeDrawerBtn');

  function openDrawer() {
    if (mobileDrawer && mobileDrawerBackdrop) {
      mobileDrawer.classList.remove('-translate-x-full');
      mobileDrawerBackdrop.classList.remove('hidden');
      document.body.style.overflow = 'hidden';
    }
  }

  function closeDrawer() {
    if (mobileDrawer && mobileDrawerBackdrop) {
      mobileDrawer.classList.add('-translate-x-full');
      mobileDrawerBackdrop.classList.add('hidden');
      document.body.style.overflow = '';
    }
  }

  if (menuToggleBtn) menuToggleBtn.addEventListener('click', openDrawer);
  if (closeDrawerBtn) closeDrawerBtn.addEventListener('click', closeDrawer);
  if (mobileDrawerBackdrop) mobileDrawerBackdrop.addEventListener('click', closeDrawer);
</script>
</body>
</html>