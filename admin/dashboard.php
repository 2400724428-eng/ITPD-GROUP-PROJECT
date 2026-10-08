<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>QuickCart - Seller Panel</title>
<!-- Tailwind CSS CDN with forms and container queries plugins -->
<link href="../src/output.css" rel="stylesheet">

<script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            brand: {
              50: '#eff6ff',
              100: '#dbeafe',
              500: '#3b82f6',
              600: '#2563eb',
              700: '#1d4ed8'
            }
          }
        }
      }
    }
  </script>
<style>
    body {
      background-color: #ffffff;
      color: #334155;
    }
    input::placeholder, textarea::placeholder {
      color: #94a3b8;
    }
    /* Simple fade/slide animation for screen switching */
    .screen-fade {
      animation: fadeIn 0.3s ease-in-out forwards;
    }
    @keyframes fadeIn {
      from {
        opacity: 0;
        transform: translateY(6px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }
  </style>
</head>
<body class="min-h-screen flex flex-col font-sans antialiased text-slate-800 bg-white">

<!-- BEGIN: PageContainer -->
<div class="flex-1 flex overflow-hidden">
  
  <!-- BEGIN: Sidebar -->
  <aside class="w-64 border-r border-gray-200 bg-white flex flex-col shrink-0 select-none" data-purpose="sidebar-navigation">
    <div class="p-6 border-b border-gray-100 flex items-center gap-2">
      <div style="padding: 24px; border-bottom: 1px solid #f1f5f9; display: flex; align-items: center; gap: 12px;">
        <!-- Small logo using inline CSS width -->
        <img src="../assets/images/logos.png" alt="Logo" style="width: 40px; height: 40px; object-fit: contain;">
        <span style="font-weight: 700; font-size: 1.125rem; color: #0f172a;">PURE GAIN</span>
      </div>
    </div>
    <nav class="flex-1 pt-4 space-y-1 overflow-y-auto">
      <!-- Add Product Nav Item -->
      <button onclick="switchScreen('add-product', this)" class="nav-item w-full relative flex items-center gap-3.5 px-6 py-3.5 text-sm font-medium bg-blue-50 text-blue-900 border-r-4 border-blue-600 transition-colors text-left">
        <svg class="w-5 h-5 text-blue-600 stroke-[1.8]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <rect height="18" rx="4" stroke-width="2" width="18" x="3" y="3"></rect>
          <path d="M12 8v8m-4-4h8" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
        </svg>
        <span>Add Product</span>
      </button>

      <!-- Product List Nav Item -->
      <button onclick="switchScreen('product-list', this)" class="nav-item w-full flex items-center gap-3.5 px-6 py-3.5 text-sm font-medium text-slate-600 hover:text-slate-900 hover:bg-slate-50 transition-colors text-left">
        <svg class="w-5 h-5 text-slate-500 stroke-[1.8]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path d="M4 6h16M4 12h16M4 18h11" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
        </svg>
        <span>Product List</span>
      </button>

      <!-- Orders Nav Item -->
      <button onclick="switchScreen('orders', this)" class="nav-item w-full flex items-center gap-3.5 px-6 py-3.5 text-sm font-medium text-slate-600 hover:text-slate-900 hover:bg-slate-50 transition-colors text-left">
        <svg class="w-5 h-5 text-slate-500 stroke-[1.8]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <rect height="16" rx="2" stroke-width="2" width="16" x="4" y="4"></rect>
          <path d="M9 12l2 2 4-4" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
        </svg>
        <span>Orders</span>
      </button>

      <!-- Messages Nav Item -->
      <button onclick="switchScreen('contact-messages', this)" class="nav-item w-full flex items-center gap-3.5 px-6 py-3.5 text-sm font-medium text-slate-600 hover:text-slate-900 hover:bg-slate-50 transition-colors text-left">
        <svg class="w-5 h-5 text-slate-500 stroke-[1.8]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
        </svg>
        <span>Messages</span>
      </button>

      <!-- Add User Nav Item -->
      <button onclick="switchScreen('add-user', this)" class="nav-item w-full flex items-center gap-3.5 px-6 py-3.5 text-sm font-medium text-slate-600 hover:text-slate-900 hover:bg-slate-50 transition-colors text-left">
        <svg class="w-5 h-5 text-slate-500 stroke-[1.8]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
        </svg>
        <span>Add User</span>
      </button>

      <!-- Gym Management Dropdown Section -->
      <div class="pt-1">
        <button onclick="toggleGymDropdown()" class="w-full flex items-center justify-between px-6 py-3.5 text-sm font-medium text-slate-600 hover:text-slate-900 hover:bg-slate-50 transition-colors text-left">
          <div class="flex items-center gap-3.5">
            <svg class="w-5 h-5 text-slate-500 stroke-[1.8]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.75 13.5l10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75z"></path>
            </svg>
            <span>Gym Management</span>
          </div>
          <svg id="gym-chevron" class="w-4 h-4 text-slate-400 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
          </svg>
        </button>
        
        <!-- Dropdown Sub-menu for the 5 Gym Screens -->
        <div id="gym-submenu" class="hidden pl-12 pr-6 py-1 space-y-1 bg-slate-50/50">
          <button onclick="switchScreen('gym-dashboard', this)" class="nav-item w-full block py-2 text-xs font-medium text-slate-600 hover:text-blue-600 transition-colors text-left">
            Dashboard Overview
          </button>
          <button onclick="switchScreen('gym-members', this)" class="nav-item w-full block py-2 text-xs font-medium text-slate-600 hover:text-blue-600 transition-colors text-left">
            Members
          </button>
          <button onclick="switchScreen('gym-subscriptions', this)" class="nav-item w-full block py-2 text-xs font-medium text-slate-600 hover:text-blue-600 transition-colors text-left">
            Subscriptions
          </button>
          <button onclick="switchScreen('gym-bookings', this)" class="nav-item w-full block py-2 text-xs font-medium text-slate-600 hover:text-blue-600 transition-colors text-left">
            Class Bookings
          </button>
          <button onclick="switchScreen('gym-trainers', this)" class="nav-item w-full block py-2 text-xs font-medium text-slate-600 hover:text-blue-600 transition-colors text-left">
            Trainer Management
          </button>
        </div>
      </div>

    </nav>
  </aside>
  <!-- END: Sidebar -->

  <!-- BEGIN: Content Wrapper -->
  <div class="flex-1 flex flex-col min-w-0 overflow-hidden">
    
    <!-- BEGIN: Top Header Bar -->
    <header class="h-16 border-b border-gray-200 bg-white px-8 flex items-center justify-between shrink-0">
      
      <!-- Search Bar -->
      <div class="relative w-72">
        <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
          <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
          </svg>
        </span>
        <input type="text" placeholder="Search members, products, orders..." class="w-full pl-9 pr-4 py-1.5 text-xs bg-slate-50 border border-slate-200 rounded-md focus:outline-none focus:ring-1 focus:ring-blue-600 focus:bg-white text-slate-800" />
      </div>

      <!-- Right Header Actions (History, Notifications, Profile) -->
      <div class="flex items-center gap-4">
        
        <!-- Activity History Dropdown Button -->
        <div class="relative">
          <button onclick="toggleDropdown('history-dropdown')" class="p-2 text-slate-500 hover:text-slate-900 hover:bg-slate-100 rounded-full transition relative" title="Activity History">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
          </button>

          <!-- History Popover Menu -->
          <div id="history-dropdown" class="hidden absolute right-0 mt-2 w-80 bg-white border border-slate-200 rounded-md shadow-lg py-2 z-50">
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

        <!-- Notifications Dropdown Button -->
        <div class="relative">
          <button onclick="toggleDropdown('notifications-dropdown')" class="p-2 text-slate-500 hover:text-slate-900 hover:bg-slate-100 rounded-full transition relative" title="Notifications">
            <span class="absolute top-1.5 right-1.5 w-2 h-2 bg-rose-500 rounded-full"></span>
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
            </svg>
          </button>

          <!-- Notifications Popover Menu -->
          <div id="notifications-dropdown" class="hidden absolute right-0 mt-2 w-80 bg-white border border-slate-200 rounded-md shadow-lg py-2 z-50">
            <div class="px-4 py-1.5 border-b border-slate-100 font-bold text-xs text-slate-900">Notifications</div>
            <div class="max-h-60 overflow-y-auto divide-y divide-slate-100">
              <div class="px-4 py-2 hover:bg-slate-50">
                <p class="text-xs font-medium text-slate-800">New order received from QuickCart</p>
                <span class="text-[10px] text-slate-400">10 mins ago</span>
              </div>
              <div class="px-4 py-2 hover:bg-slate-50">
                <p class="text-xs font-medium text-slate-800">New member subscription signup</p>
                <span class="text-[10px] text-slate-400">1 hour ago</span>
              </div>
            </div>
          </div>
        </div>

        <div class="h-6 w-px bg-slate-200"></div>

        <!-- User Profile Dropdown -->
        <div class="relative">
          <button onclick="toggleDropdown('profile-dropdown')" class="flex items-center gap-3 focus:outline-none">
            <div class="w-9 h-9 rounded-full bg-blue-600 text-white font-semibold text-xs flex items-center justify-center shadow-sm">
              RM
            </div>
            <div class="text-left hidden sm:block">
              <div class="text-xs font-bold text-slate-900">Rwomushana Macarthy</div>
              <div class="text-[10px] text-slate-500">Administrator</div>
            </div>
            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
            </svg>
          </button>

          <!-- Profile Dropdown Menu -->
          <div id="profile-dropdown" class="hidden absolute right-0 mt-2 w-48 bg-white border border-slate-200 rounded-md shadow-lg py-1 z-50">
            <a href="#" onclick="switchScreen('profile', this); toggleDropdown('profile-dropdown');" class="block px-4 py-2 text-xs text-slate-700 hover:bg-slate-50">Your Profile</a>
            <a href="#" onclick="switchScreen('settings', this); toggleDropdown('profile-dropdown');" class="block px-4 py-2 text-xs text-slate-700 hover:bg-slate-50">Settings</a>
            <div class="border-t border-slate-100 my-1"></div>
            <a href="#" onclick="alert('Logging out...');" class="block px-4 py-2 text-xs text-rose-600 hover:bg-rose-50 font-medium">Log Out</a>
          </div>
        </div>

      </div>
    </header>
    <!-- END: Top Header Bar -->

    <!-- BEGIN: MainContent -->
    <main class="flex-1 overflow-y-auto px-10 py-8 bg-white" data-purpose="main-content-area">
      
      <!-- SCREEN 1: add products --> 
      <?php include(__DIR__ . '/views/addproduct.php'); ?>

      <!-- SCREEN 2: PRODUCT LIST -->
      <?php include(__DIR__ . '/views/product-list.php'); ?>

      <!-- SCREEN 3: ORDERS -->
      <?php include(__DIR__ . '/views/orders.php'); ?>

      <!-- SCREEN 4: CONTACT MESSAGES -->
      <?php include(__DIR__ . '/views/contactmessages.php'); ?>

      <!-- GYM SCREEN 1: Dashboard Overview -->
      <?php include(__DIR__ . '/views/overview.php'); ?>

      <!-- GYM SCREEN 2: Members Management -->
      <?php include(__DIR__ . '/views/gym-members.php'); ?>

      <!-- GYM SCREEN 3: Subscriptions -->
      <?php include(__DIR__ . '/views/gym-subscriptions.php'); ?>

      <!-- GYM SCREEN 4: Class Bookings -->
      <?php include(__DIR__ . '/views/gym-bookings.php'); ?>

      <!-- GYM SCREEN 5: Trainer Management -->
      <?php include(__DIR__ . '/views/gym-trainers.php'); ?>

      <!-- NEW SCREEN: Your Profile -->
      <?php include(__DIR__ . '/views/screen-profile.php'); ?>

      <!-- NEW SCREEN: Activity History -->
      <?php include(__DIR__ . '/views/screen-history.php'); ?>

      <!-- NEW SCREEN: Settings -->
      <?php include(__DIR__ . '/views/screen-settings.php'); ?>

      <!-- NEW SCREEN: Add User -->
      <?php include(__DIR__ . '/views/add-user.php'); ?>

    </main>
    <!-- END: MainContent -->

  </div>
  <!-- END: Content Wrapper -->

</div>
<!-- END: PageContainer -->

<!-- Screen & Dropdown Navigation Scripts -->
<script>
  function toggleGymDropdown() {
    const submenu = document.getElementById('gym-submenu');
    const chevron = document.getElementById('gym-chevron');
    submenu.classList.toggle('hidden');
    chevron.classList.toggle('rotate-180');
  }

  // Generic toggler for dropdowns that closes others when a new one opens
  function toggleDropdown(dropdownId) {
    const target = document.getElementById(dropdownId);
    const isHidden = target.classList.contains('hidden');
    
    // Hide all dropdowns first
    ['profile-dropdown', 'history-dropdown', 'notifications-dropdown'].forEach(id => {
      document.getElementById(id).classList.add('hidden');
    });

    // Toggle target
    if (isHidden) {
      target.classList.remove('hidden');
    }
  }

  // Close any active dropdown popups when clicking outside of them
  window.addEventListener('click', function(e) {
    if (!e.closest('header .relative')) {
      ['profile-dropdown', 'history-dropdown', 'notifications-dropdown'].forEach(id => {
        const el = document.getElementById(id);
        if (el && !el.contains(e.target) && !e.target.closest('button')) {
          el.classList.add('hidden');
        }
      });
    }
  });

  function switchScreen(screenId, element) {
    // Hide all screens
    document.querySelectorAll('[id^="screen-"]').forEach(screen => {
      screen.classList.add('hidden');
    });
    
    // Show target screen
    const target = document.getElementById('screen-' + screenId);
    if (target) {
      target.classList.remove('hidden');
    }

    // Update sidebar active states if triggered from sidebar
    document.querySelectorAll('.nav-item').forEach(item => {
      item.classList.remove('bg-blue-50', 'text-blue-900', 'border-r-4', 'border-blue-600', 'text-blue-600', 'font-semibold');
      item.classList.add('text-slate-600');
      const svg = item.querySelector('svg');
      if(svg) svg.classList.replace('text-blue-600', 'text-slate-500');
    });

    // Style clicked item
    if (element && element.closest('#gym-submenu')) {
      element.classList.remove('text-slate-600');
      element.classList.add('text-blue-600', 'font-semibold');
    } else if (element && element.classList.contains('nav-item')) {
      element.classList.remove('text-slate-600', 'hover:text-slate-900', 'hover:bg-slate-50');
      element.classList.add('bg-blue-50', 'text-blue-900', 'border-r-4', 'border-blue-600');
      const activeSvg = element.querySelector('svg');
      if(activeSvg) activeSvg.classList.replace('text-slate-500', 'text-blue-600');
    }
  }
</script>

</body>
</html>