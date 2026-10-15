<?php
// ==================== BACKEND PHP HANDLER ====================
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Content-Type: application/json');
    
    $host = 'localhost';$db   = 'gym_supplements_store';
    $user = 'root';$pass = '';

    try {
        $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user,$pass, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);

        $data = json_decode(file_get_contents('php://input'), true);

        if (!$data) {
            echo json_encode(['success' => false, 'error' => 'Invalid data']);
            exit;
        }

        $userId = isset($data['user_id']) ? intval($data['user_id']) : null;
        $totalAmount = floatval($data['total_amount']);$paymentMethod = 'WhatsApp';
        $paymentStatus = 'Pending';$addressInfo = $data['address'] ?? [];$shippingAddress = sprintf(
            "%s %s, %s, %s, Phone: %s",
            $addressInfo['firstName'] ?? '',
            $addressInfo['lastName'] ?? '',$addressInfo['street'] ?? '',
            $addressInfo['city'] ?? '',$addressInfo['phone'] ?? ''
        );

        $orderNumber = 'PG-' . strtoupper(substr(uniqid(), -5));

        $stmt =$pdo->prepare("
            INSERT INTO `orders` 
            (`order_number`, `user_id`, `total_amount`, `payment_method`, `payment_status`, `shipping_address`, `created_at`, `updated_at`) 
            VALUES (?, ?, ?, ?, ?, ?, NOW(), NOW())
        ");

        $stmt->execute([
            $orderNumber,$userId,
            $totalAmount,$paymentMethod,
            $paymentStatus,$shippingAddress
        ]);

        echo json_encode([
            'success' => true,
            'order_number' => $orderNumber
        ]);

    } catch (Exception $e) {
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<meta content="web_standard" name="shell-type"/>
<title>Checkout | PURE GAIN</title>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&family=Inter:wght@400;500;600&display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet"/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
<style>
  html, body { 
    margin: 0; 
    padding: 0; 
    width: 100%; 
    height: 100%;
    overflow-x: hidden;
    overflow-y: auto !important;
  }
  body { 
    -webkit-overflow-scrolling: touch;
  }
  ::-webkit-scrollbar { display: none; }
  .checkout-step { display: none; }
  .checkout-step.active { display: block; }
  @keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
  }
  .animate-spin-custom {
    animation: spin 1s linear infinite;
  }
</style>
<script src="https://cdn.tailwindcss.com"></script>
<script id="tailwind-config">
tailwind.config={"darkMode":"class","theme":{"extend":{"colors":{"inverse-surface":"#213145","outline-variant":"#c3c6d7","secondary-fixed-dim":"#bcc7de","surface":"#f8f9ff","secondary":"#545f73","on-primary-container":"#eeefff","error-container":"#ffdad6","tertiary-container":"#007b71","secondary-container":"#d5e0f8","surface-container-low":"#eff4ff","on-secondary-container":"#586377","surface-tint":"#0053db","on-secondary":"#ffffff","primary-fixed":"#dbe1ff","tertiary-fixed-dim":"#6bd8cb","primary":"#004ac6","surface-dim":"#cbdbf5","error":"#ba1a1a","primary-container":"#2563eb","on-tertiary":"#ffffff","on-tertiary-container":"#b3fff3","on-background":"#0b1c30","on-primary-fixed":"#00174b","outline":"#737686","on-error-container":"#93000a","surface-container":"#e5eeff","surface-variant":"#d3e4fe","inverse-primary":"#b4c5ff","surface-bright":"#f8f9ff","surface-container-high":"#dce9ff","surface-container-lowest":"#ffffff","on-primary-fixed-variant":"#003ea8","on-error":"#ffffff","on-tertiary-fixed-variant":"#005049","on-tertiary-fixed":"#00201d","background":"#f8f9ff","tertiary":"#006058","on-surface":"#0b1c30","on-surface-variant":"#434655","surface-container-highest":"#d3e4fe","secondary-fixed":"#d8e3fb","on-secondary-fixed-variant":"#3c475a","on-secondary-fixed":"#111c2d","on-primary":"#ffffff","tertiary-fixed":"#89f5e7","inverse-on-surface":"#eaf1ff","primary-fixed-dim":"#b4c5ff"},"borderRadius":{"DEFAULT":"0.25rem","lg":"0.5rem","xl":"0.75rem","full":"9999px"},"fontFamily":{"display-lg-mobile":["Plus Jakarta Sans"],"label-lg":["Inter"],"body-sm":["Plus Jakarta Sans"],"body-md":["Plus Jakarta Sans"],"label-md":["Inter"],"headline-lg":["Plus Jakarta Sans"],"label-sm":["Inter"],"headline-sm":["Plus Jakarta Sans"],"headline-lg-mobile":["Plus Jakarta Sans"],"body-lg":["Plus Jakarta Sans"],"headline-md":["Plus Jakarta Sans"],"display-lg":["Plus Jakarta Sans"]}}}};</script>
</head>
<body class="bg-surface font-body-md text-on-surface antialiased min-h-screen flex flex-col">

<main class="w-full pt-3 sm:pt-6 bg-surface pb-32 flex-grow">
  <div class="flex flex-col w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 sm:py-6">

    <!-- Super Responsive Step Progress Bar -->
    <div class="bg-surface-container-lowest rounded-xl p-4 sm:p-6 shadow-sm mb-6 overflow-x-auto no-scrollbar flex-shrink-0">
      <div class="flex items-center justify-between min-w-[320px] max-w-3xl mx-auto">
        <!-- Step 1 -->
        <div class="flex flex-col items-center cursor-pointer flex-shrink-0" onclick="goToStep(1)">
          <div id="indicator-1" class="w-10 h-10 sm:w-12 sm:h-12 rounded-full bg-primary text-on-primary flex items-center justify-center shadow-md transition-all">
            <span class="material-symbols-outlined text-[18px] sm:text-[20px]">shopping_cart</span>
          </div>
          <span id="label-1" class="font-label-md text-xs sm:text-sm font-bold mt-1.5 text-primary">Cart</span>
        </div>
        <div class="flex-1 h-[2px] bg-outline-variant mx-1 sm:mx-2"></div>

        <!-- Step 2 -->
        <div class="flex flex-col items-center cursor-pointer flex-shrink-0" onclick="goToStep(2)">
          <div id="indicator-2" class="w-10 h-10 sm:w-12 sm:h-12 rounded-full bg-surface-container-high text-outline flex items-center justify-center transition-all">
            <span class="material-symbols-outlined text-[18px] sm:text-[20px]">location_on</span>
          </div>
          <span id="label-2" class="font-label-md text-xs sm:text-sm mt-1.5 text-outline">Address</span>
        </div>
        <div class="flex-1 h-[2px] bg-outline-variant mx-1 sm:mx-2"></div>

        <!-- Step 3 -->
        <div class="flex flex-col items-center cursor-pointer flex-shrink-0" onclick="goToStep(3)">
          <div id="indicator-3" class="w-10 h-10 sm:w-12 sm:h-12 rounded-full bg-surface-container-high text-outline flex items-center justify-center transition-all">
            <span class="material-symbols-outlined text-[18px] sm:text-[20px]">credit_card</span>
          </div>
          <span id="label-3" class="font-label-md text-xs sm:text-sm mt-1.5 text-outline">Payment</span>
        </div>
        <div class="flex-1 h-[2px] bg-outline-variant mx-1 sm:mx-2"></div>

        <!-- Step 4 -->
        <div class="flex flex-col items-center cursor-pointer flex-shrink-0" onclick="goToStep(4)">
          <div id="indicator-4" class="w-10 h-10 sm:w-12 sm:h-12 rounded-full bg-surface-container-high text-outline flex items-center justify-center transition-all">
            <span class="material-symbols-outlined text-[18px] sm:text-[20px]">check</span>
          </div>
          <span id="label-4" class="font-label-md text-xs sm:text-sm mt-1.5 text-outline">Done</span>
        </div>
      </div>
    </div>

    <!-- ==================== SCREEN 1: CART ==================== -->
    <div id="step-1" class="checkout-step active">
      <div class="flex flex-col sm:flex-row sm:items-end justify-between pb-4 sm:pb-6 gap-2">
        <div>
          <span class="font-label-sm text-primary tracking-widest uppercase mb-1 block">Pure Gain Bag</span>
          <h1 class="text-2xl sm:text-3xl font-extrabold text-on-surface tracking-tight">Your Shopping Cart</h1>
          <p id="cart-subtitle" class="font-body-md text-on-surface-variant text-sm sm:text-base">Loading items...</p>
        </div>
      </div>

      <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
        <div class="lg:col-span-8 flex flex-col gap-4">
          <!-- Dynamic Items Injected Here -->
        </div>
        <div class="lg:col-span-4 flex flex-col gap-4 lg:sticky lg:top-6">
          <!-- Dynamic Summary Injected Here -->
        </div>
      </div>
    </div>

    <!-- ==================== SCREEN 2: ADDRESS ==================== -->
    <div id="step-2" class="checkout-step">
      <div class="max-w-2xl mx-auto bg-surface-container-lowest rounded-xl p-4 sm:p-8 shadow-sm">
        <h2 class="text-xl sm:text-2xl font-bold text-on-surface mb-4">Shipping Address</h2>
        <form id="address-form" class="space-y-4" onsubmit="event.preventDefault(); saveAddressAndContinue();">
          <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
              <label class="font-label-sm text-on-surface-variant block mb-1">First Name</label>
              <input type="text" id="addr-firstname" required class="w-full h-12 px-4 bg-surface-container-low rounded-lg focus:outline-none focus:ring-2 focus:ring-primary text-sm" placeholder="John"/>
            </div>
            <div>
              <label class="font-label-sm text-on-surface-variant block mb-1">Last Name</label>
              <input type="text" id="addr-lastname" required class="w-full h-12 px-4 bg-surface-container-low rounded-lg focus:outline-none focus:ring-2 focus:ring-primary text-sm" placeholder="Doe"/>
            </div>
          </div>
          <div>
            <label class="font-label-sm text-on-surface-variant block mb-1">Street Address</label>
            <input type="text" id="addr-street" required class="w-full h-12 px-4 bg-surface-container-low rounded-lg focus:outline-none focus:ring-2 focus:ring-primary text-sm" placeholder="Plot 12 Jinja Road"/>
          </div>
          <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
              <label class="font-label-sm text-on-surface-variant block mb-1">City</label>
              <input type="text" id="addr-city" required class="w-full h-12 px-4 bg-surface-container-low rounded-lg focus:outline-none focus:ring-2 focus:ring-primary text-sm" placeholder="Kampala"/>
            </div>
            <div>
              <label class="font-label-sm text-on-surface-variant block mb-1">Phone Number</label>
              <input type="tel" id="addr-phone" required class="w-full h-12 px-4 bg-surface-container-low rounded-lg focus:outline-none focus:ring-2 focus:ring-primary text-sm" placeholder="+256 700 000 000"/>
            </div>
          </div>
          <div class="flex flex-col-reverse sm:flex-row justify-between gap-3 pt-4">
            <button type="button" onclick="goToStep(1)" class="w-full sm:w-auto h-12 px-6 bg-surface-container-low text-on-surface rounded-lg font-label-lg hover:bg-surface-container-high transition-colors">Back to Cart</button>
            <button type="submit" class="w-full sm:w-auto h-12 px-6 bg-primary text-on-primary rounded-lg font-label-lg flex items-center justify-center gap-2 shadow-md hover:bg-primary-container transition-all">
              <span>Continue to Payment</span>
              <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
            </button>
          </div>
        </form>
      </div>
    </div>

    <!-- ==================== SCREEN 3: WHATSAPP CHECKOUT ==================== -->
    <div id="step-3" class="checkout-step">
      <div class="max-w-2xl mx-auto overflow-hidden bg-white rounded-2xl shadow-xl border border-gray-100">
        <div class="relative overflow-hidden bg-gradient-to-br from-green-700 via-green-600 to-emerald-500 px-6 py-8 sm:px-10 sm:py-10 text-white">
            <div class="absolute -right-12 -top-12 w-48 h-48 rounded-full bg-white/10"></div>
            <div class="absolute -right-4 -bottom-16 w-36 h-36 rounded-full bg-white/10"></div>
            <div class="relative z-10 flex items-center gap-4">
                <div class="w-16 h-16 flex-shrink-0 flex items-center justify-center rounded-2xl bg-white/20 border border-white/30 shadow-lg">
                    <i class="fa-brands fa-whatsapp text-4xl"></i>
                </div>
                <div>
                    <span class="inline-flex items-center gap-2 text-xs font-semibold uppercase tracking-[0.2em] text-green-100 mb-2">
                        <span class="w-2 h-2 rounded-full bg-green-300"></span>
                        Secure Order Assistance
                    </span>
                    <h2 class="text-2xl sm:text-3xl font-extrabold tracking-tight">Complete Your Purchase</h2>
                    <p class="mt-2 text-sm sm:text-base text-green-50">Order directly through WhatsApp.</p>
                </div>
            </div>
        </div>

        <div class="p-5 sm:p-8">
            <div class="text-center mb-8">
                <div class="w-20 h-20 mx-auto mb-4 flex items-center justify-center rounded-full bg-green-50 border-4 border-green-100">
                    <i class="fa-brands fa-whatsapp text-4xl text-green-600"></i>
                </div>
                <h3 class="text-xl sm:text-2xl font-bold text-gray-900">You're one step away!</h3>
                <p class="mt-2 max-w-md mx-auto text-sm leading-6 text-gray-500">Send your order to our WhatsApp team. We'll confirm product availability and details with you[cite: 1, 2].</p>
            </div>

            <div class="rounded-2xl border border-green-100 bg-green-50/70 p-5 sm:p-6 mb-6">
                <div class="flex items-center gap-4">
                    <div class="flex-shrink-0 w-12 h-12 rounded-xl bg-green-600 text-white flex items-center justify-center shadow-md">
                        <i class="fa-solid fa-headset text-xl"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-xs font-semibold uppercase tracking-wider text-gray-500">WhatsApp Order Number</p>
                        <p class="text-xl sm:text-2xl font-extrabold text-gray-900 mt-1">0761 448 094</p>
                    </div>
                </div>
            </div>

            <div class="flex flex-col-reverse sm:flex-row gap-3">
                <button type="button" onclick="goToStep(2)" class="w-full sm:w-auto sm:flex-1 h-12 px-5 rounded-xl border border-gray-200 bg-white text-gray-700 font-semibold hover:bg-gray-50 transition duration-200">
                    <i class="fa-solid fa-arrow-left mr-2"></i> Back to Address
                </button>
                <button type="button" onclick="sendOrderToWhatsApp()" class="w-full sm:flex-[1.5] h-12 px-5 rounded-xl bg-green-600 hover:bg-green-700 active:scale-[0.98] text-white font-bold flex items-center justify-center gap-3 shadow-lg shadow-green-600/20 transition duration-200">
                    <i class="fa-brands fa-whatsapp text-2xl"></i> Order via WhatsApp <i class="fa-solid fa-arrow-up-right-from-square text-sm"></i>
                </button>
            </div>
        </div>
      </div>
    </div>

    <!-- ==================== SCREEN 4: CONFIRMATION / PROCESSING ==================== -->
    <div id="step-4" class="checkout-step">
      <div class="max-w-xl mx-auto bg-surface-container-lowest rounded-xl p-6 sm:p-10 shadow-sm text-center">
        <div id="order-loading-state" class="py-6">
          <div class="w-20 h-20 border-4 border-primary border-t-transparent rounded-full animate-spin-custom mx-auto mb-6"></div>
          <h2 class="text-2xl sm:text-3xl font-bold text-on-surface mb-2">Processing Order...</h2>
          <p class="font-body-md text-on-surface-variant text-sm sm:text-base">Please wait while we record your order in our system.</p>
        </div>

        <div id="order-approved-state" class="hidden">
          <div class="w-20 h-20 bg-green-100 text-green-600 rounded-full flex items-center justify-center mx-auto mb-4 shadow-sm">
            <span class="material-symbols-outlined text-[40px]">check</span>
          </div>
          <h2 class="text-2xl sm:text-3xl font-bold text-on-surface mb-2">Order Approved!</h2>
          <p class="font-body-md text-on-surface-variant text-sm sm:text-base mb-6">Your order has been approved and saved. Opening WhatsApp to complete your checkout...</p>
          <div class="bg-surface-container-low p-4 rounded-lg text-left mb-6 space-y-2 text-sm">
            <div class="flex justify-between"><span class="text-outline">Order ID:</span><span id="order-id" class="font-bold">#PG-89421</span></div>
            <div class="flex justify-between"><span class="text-outline">Status:</span><span class="font-bold text-green-600">Pending</span></div>
            <div class="flex justify-between"><span class="text-outline">Total Amount:</span><span id="confirm-total" class="font-bold text-primary">UGX 0</span></div>
          </div>
          <button onclick="clearAndReturn()" class="w-full h-12 bg-primary text-on-primary rounded-lg font-label-lg hover:bg-primary-container transition-all shadow-md">Return to Shop</button>
        </div>
      </div>
    </div>

  </div>
</main>

<script>
  const STEP_ICONS = { 1: 'shopping_cart', 2: 'location_on', 3: 'credit_card', 4: 'check' };
  const fmt = n => Number(n).toLocaleString("en-US");

  function getStoredCart() {
    return JSON.parse(localStorage.getItem('puregain_cart')) || [];
  }

  function saveStoredCart(cart) {
    localStorage.setItem('puregain_cart', JSON.stringify(cart));
  }

  function saveAddressAndContinue() {
    const addressData = {
      firstName: document.getElementById('addr-firstname').value.trim(),
      lastName: document.getElementById('addr-lastname').value.trim(),
      street: document.getElementById('addr-street').value.trim(),
      city: document.getElementById('addr-city').value.trim(),
      phone: document.getElementById('addr-phone').value.trim()
    };
    localStorage.setItem('puregain_address', JSON.stringify(addressData));
    goToStep(3);
  }

  function goToStep(stepNumber) {
    document.querySelectorAll('.checkout-step').forEach(el => el.classList.remove('active'));
    const target = document.getElementById('step-' + stepNumber);
    if (target) target.classList.add('active');

    for (let i = 1; i <= 4; i++) {
      const indicator = document.getElementById('indicator-' + i);
      const label = document.getElementById('label-' + i);
      const icon = (name) => `<span class="material-symbols-outlined text-[18px] sm:text-[20px]">${name}</span>`;

      if (i < stepNumber) {
        indicator.className = "w-10 h-10 sm:w-12 sm:h-12 rounded-full bg-tertiary text-on-tertiary flex items-center justify-center shadow-md transition-all";
        indicator.innerHTML = icon('check');
        label.className = "font-label-md text-xs sm:text-sm mt-1.5 text-tertiary";
      } else if (i === stepNumber) {
        indicator.className = "w-10 h-10 sm:w-12 sm:h-12 rounded-full bg-primary text-on-primary flex items-center justify-center shadow-md transition-all";
        indicator.innerHTML = icon(STEP_ICONS[i]);
        label.className = "font-label-md text-xs sm:text-sm font-bold mt-1.5 text-primary";
      } else {
        indicator.className = "w-10 h-10 sm:w-12 sm:h-12 rounded-full bg-surface-container-high text-outline flex items-center justify-center transition-all";
        indicator.innerHTML = icon(STEP_ICONS[i]);
        label.className = "font-label-md text-xs sm:text-sm mt-1.5 text-outline";
      }
    }
    window.scrollTo({ top: 0, behavior: 'smooth' });
  }

  function updateQuantity(id, delta) {
    let cart = getStoredCart();
    const item = cart.find(i => i.id === id);
    if (!item) return;
    item.quantity += delta;
    if (item.quantity <= 0) cart = cart.filter(i => i.id !== id);
    saveStoredCart(cart);
    renderCart();
  }

  function removeItem(id) {
    let cart = getStoredCart();
    cart = cart.filter(i => i.id !== id);
    saveStoredCart(cart);
    renderCart();
  }

  function renderCart() {
    const cart = getStoredCart();
    const cartContainer = document.querySelector('#step-1 .lg\\:col-span-8');
    const summaryContainer = document.querySelector('#step-1 .lg\\:col-span-4');
    const subtotal = cart.reduce((sum, i) => sum + (i.price * i.quantity), 0);
    const totalCount = cart.reduce((sum, i) => sum + i.quantity, 0);

    const subtitle = document.getElementById('cart-subtitle');
    if (subtitle) subtitle.textContent = `You have ${totalCount} item${totalCount !== 1 ? 's' : ''} in your bag.`;

    if (cart.length === 0) {
      cartContainer.innerHTML = `
        <div class="bg-surface-container-lowest rounded-xl p-8 sm:p-12 text-center shadow-sm">
          <span class="material-symbols-outlined text-[60px] text-outline mb-2">shopping_bag</span>
          <h3 class="text-lg font-bold text-on-surface mb-1">Your cart is empty</h3>
          <p class="font-body-sm text-on-surface-variant text-sm">Add products from the shop to get started.</p>
          <a href="shop.php" class="inline-block mt-4 px-6 py-2.5 bg-primary text-on-primary rounded-lg font-label-md shadow-sm">Browse Shop</a>
        </div>`;
    } else {
      let itemsHTML = cart.map(item => `
        <div class="p-4 sm:p-6 flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-4 border-b border-surface-container-low last:border-0">
          <div class="flex items-center gap-4 flex-1">
            <div class="w-16 h-16 sm:w-20 sm:h-20 rounded-lg overflow-hidden bg-surface-container-high flex-shrink-0 flex items-center justify-center p-1">
              <img class="max-h-full max-w-full object-contain" alt="${item.name}" src="${item.image}"/>
            </div>
            <div class="min-w-0 flex-1">
              <h3 class="font-bold text-on-surface text-base truncate">${item.name}</h3>
              <p class="font-body-sm text-on-surface-variant text-xs sm:text-sm">${item.unit || ''}</p>
            </div>
          </div>
          <div class="flex items-center justify-between sm:justify-end gap-6 pt-2 sm:pt-0 border-t sm:border-0 border-surface-container-low">
            <div class="flex items-center bg-surface-container-low rounded-lg p-1 border border-outline-variant/30">
              <button onclick="updateQuantity(${item.id}, -1)" class="w-8 h-8 flex items-center justify-center text-on-surface rounded-md hover:bg-surface-container-high font-bold">-</button>
              <span class="w-8 text-center font-label-md font-bold text-on-surface">${item.quantity}</span>
              <button onclick="updateQuantity(${item.id}, 1)" class="w-8 h-8 flex items-center justify-center text-on-surface rounded-md hover:bg-surface-container-high font-bold">+</button>
            </div>
            <div class="text-right min-w-[100px]">
              <span class="text-base font-bold text-on-surface block">UGX ${fmt(item.price * item.quantity)}</span>
              <button onclick="removeItem(${item.id})" class="text-error text-xs hover:underline flex items-center gap-1 justify-end ml-auto mt-1">
                <span class="material-symbols-outlined text-[14px]">delete</span> Delete
              </button>
            </div>
          </div>
        </div>
      `).join('');

      cartContainer.innerHTML = `
        <div class="bg-surface-container-lowest rounded-xl shadow-sm overflow-hidden">
          <div class="px-4 sm:px-6 py-3 bg-surface-container-low flex justify-between items-center text-on-surface-variant font-label-md text-xs sm:text-sm uppercase tracking-wider">
            <span>Product Details</span>
            <span class="hidden sm:inline">Quantity &amp; Price</span>
          </div>
          ${itemsHTML}
        </div>`;
    }

    if (summaryContainer) {
      summaryContainer.innerHTML = `
        <div class="bg-surface-container-lowest rounded-xl p-5 sm:p-6 shadow-sm">
          <h2 class="text-base font-bold text-on-surface pb-3 border-b border-surface-container-low mb-3">Order Summary</h2>
          <div class="flex justify-between items-baseline pt-2 pb-4">
            <span class="font-bold text-on-surface">Total Amount</span>
            <span class="text-xl sm:text-2xl text-primary font-extrabold">UGX ${fmt(subtotal)}</span>
          </div>
          <button onclick="goToStep(2)" ${cart.length === 0 ? 'disabled' : ''} class="w-full h-12 bg-primary-container hover:bg-primary text-on-primary rounded-lg font-label-lg flex items-center justify-center gap-2 shadow-md transition-all disabled:opacity-50 disabled:cursor-not-allowed">
            <span>Proceed to Checkout</span>
            <span class="material-symbols-outlined text-[20px]">arrow_forward</span>
          </button>
        </div>`;
    }

    const confirmTotal = document.getElementById('confirm-total');
    if (confirmTotal) confirmTotal.textContent = `UGX ${fmt(subtotal)}`;
  }

  async function sendOrderToWhatsApp() {
    const whatsappNumber = '256761448094';
    let addressInfo = null;
    try {
        const storedAddr = localStorage.getItem('puregain_address');
        if (storedAddr) addressInfo = JSON.parse(storedAddr);
    } catch (e) { console.error('Address read error:', e); }

    let cartItems = [];
    try {
        const possibleKeys = ['puregain_cart', 'cart', 'jumika_cart', 'shoppingCart'];
        for (const key of possibleKeys) {
            const storedCart = localStorage.getItem(key);
            if (storedCart) {
                const parsed = JSON.parse(storedCart);
                if (Array.isArray(parsed) && parsed.length > 0) {
                    cartItems = parsed;
                    break;
                }
            }
        }
    } catch (error) { console.error('Cart read error:', error); }

    const subtotal = cartItems.reduce((sum, i) => sum + (i.price * i.quantity), 0);

    goToStep(4);
    document.getElementById('order-loading-state').classList.remove('hidden');
    document.getElementById('order-approved-state').classList.add('hidden');

    let orderNumberDisplay = '#PG-89421';

    try {
        const response = await fetch(window.location.href, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({
                user_id: null,
                total_amount: subtotal,
                address: addressInfo,
                items: cartItems
            })
        });

        const textResult = await response.text();
        const result = JSON.parse(textResult);

        if (result.success && result.order_number) {
            orderNumberDisplay = '#' + result.order_number;
            document.getElementById('order-id').textContent = orderNumberDisplay;
        }
    } catch (err) {
        console.error('Database connection error:', err);
    }

    let orderMessage = `Hello! I would like to place an order (${orderNumberDisplay}).\n\n`;
    if (addressInfo) {
        orderMessage += 'CUSTOMER DETAILS\n';
        orderMessage += `Name: ${addressInfo.firstName} ${addressInfo.lastName}\n`;
        orderMessage += `Phone: ${addressInfo.phone}\n`;
        orderMessage += `Address: ${addressInfo.street}, ${addressInfo.city}\n\n`;
    }

    if (cartItems.length > 0) {
        orderMessage += 'MY ORDER\n';
        cartItems.forEach((item, index) => {
            const name = item.name || item.title || 'Product';
            const quantity = Number(item.quantity || 1);
            const price = Number(item.price || 0);
            orderMessage += `${index + 1}. ${name} x ${quantity}`;
            if (price > 0) orderMessage += ` - UGX ${(price * quantity).toLocaleString('en-UG')}`;
            orderMessage += '\n';
        });
        orderMessage += '\n';
    }

    orderMessage += `Total Amount: UGX ${subtotal.toLocaleString('en-UG')}\n`;
    orderMessage += 'Please confirm availability and payment instructions.';

    const whatsappURL = 'https://wa.me/' + whatsappNumber + '?text=' + encodeURIComponent(orderMessage);

    setTimeout(() => {
        document.getElementById('order-loading-state').classList.add('hidden');
        document.getElementById('order-approved-state').classList.remove('hidden');

        setTimeout(() => {
            window.open(whatsappURL, '_blank', 'noopener,noreferrer');
        }, 1500);
    }, 2000);
  }

  function clearAndReturn() {
    localStorage.removeItem('puregain_cart');
    localStorage.removeItem('puregain_address');
    window.location.href = 'shop.php';
  }

  document.addEventListener('DOMContentLoaded', renderCart);
</script>
</body>
</html>