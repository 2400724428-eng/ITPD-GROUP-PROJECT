<?php
// ==================== BACKEND PHP HANDLER ====================
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Content-Type: application/json');
    require_once __DIR__ . '/includes/db_connect.php';

    try {
        if (!isset($pdo)) {
            $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ]);
        }

        $data = json_decode(file_get_contents('php://input'), true);

        if (!$data) {
            echo json_encode(['success' => false, 'error' => 'Invalid data']);
            exit;
        }

        $userId = isset($data['user_id']) && !empty($data['user_id'])
            ? intval($data['user_id'])
            : ($_SESSION['user_id'] ?? null);

        $totalAmount   = floatval($data['total_amount'] ?? 0);
        $paymentMethod = 'WhatsApp';
        $paymentStatus = 'Pending';

        $addressInfo = $data['address'] ?? [];
        $shippingAddress = sprintf(
            "%s %s, %s, %s, Phone: %s",
            $addressInfo['firstName'] ?? '',
            $addressInfo['lastName'] ?? '',
            $addressInfo['street'] ?? '',
            $addressInfo['city'] ?? '',
            $addressInfo['phone'] ?? ''
        );

        $items = is_array($data['items'] ?? null) ? $data['items'] : [];

        $orderNumber = 'PG-' . strtoupper(substr(uniqid(), -5));

        // -------- BEGIN TRANSACTION (order + items together) --------
        $pdo->beginTransaction();

        $stmt = $pdo->prepare("
            INSERT INTO `orders`
            (`order_number`, `user_id`, `total_amount`, `payment_method`, `payment_status`, `shipping_address`, `created_at`, `updated_at`)
            VALUES (?, ?, ?, ?, ?, ?, NOW(), NOW())
        ");
        $stmt->execute([
            $orderNumber,
            $userId,
            $totalAmount,
            $paymentMethod,
            $paymentStatus,
            $shippingAddress
        ]);

        $orderId = (int)$pdo->lastInsertId();

        // -------- SAVE PER-PRODUCT LINE ITEMS --------
        if (!empty($items) && $orderId > 0) {
            $itemStmt = $pdo->prepare("
                INSERT INTO `order_items`
                (`order_id`, `product_id`, `quantity`, `unit_price`)
                VALUES (?, ?, ?, ?)
            ");

            foreach ($items as $it) {
                $productId = (int)($it['id'] ?? 0);
                $qty       = (int)($it['quantity'] ?? 1);
                $price     = (float)($it['price'] ?? 0);

                // Skip anything without a valid product ID
                if ($productId <= 0 || $qty <= 0) continue;

                $itemStmt->execute([$orderId, $productId, $qty, $price]);
            }
        }

        $pdo->commit();

        echo json_encode([
            'success'      => true,
            'order_number' => $orderNumber,
            'order_id'     => $orderId,
            'item_count'   => count($items)
        ]);

    } catch (Exception $e) {
        if (isset($pdo) && $pdo->inTransaction()) {
            $pdo->rollBack();
        }
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
<title>Checkout | PURE GAIN</title>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&family=Inter:wght@400;500;600&display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet"/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>

<script src="https://cdn.tailwindcss.com"></script>

<style>
  html, body {
    margin: 0;
    padding: 0;
    width: 100%;
    height: 100%;
    overflow-x: hidden;
    background-color: #f8f9ff;
  }
  body {
    -webkit-overflow-scrolling: touch;
    font-family: 'Plus Jakarta Sans', sans-serif;
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

  .hero-gradient {
    background: linear-gradient(135deg, #eff4ff 0%, #dbe1ff 100%);
  }
</style>
<script>
tailwind.config = {
  theme: {
    extend: {
      colors: {
        primary: '#004ac6',
        'primary-container': '#2563eb',
        'surface-container-lowest': '#ffffff',
        'surface-container-low': '#eff4ff',
        'on-surface': '#0b1c30',
        'on-surface-variant': '#434655',
        'outline-variant': '#c3c6d7',
        'tertiary': '#007b71',
      },
      fontFamily: {
        display: ['"Plus Jakarta Sans"', 'sans-serif'],
        body: ['"Plus Jakarta Sans"', 'sans-serif'],
      }
    }
  }
}
</script>
</head>
<body class="font-body text-on-surface antialiased min-h-screen flex flex-col">

 <?php include 'includes/searchtop.php'; ?>

<main class="w-full flex-grow pb-20">

  <div class="hero-gradient pt-10 pb-16 border-b border-white/50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
      <h1 class="text-3xl sm:text-4xl font-extrabold text-primary tracking-tight mb-2">Your Cart</h1>
      <p class="text-on-surface-variant text-base">Review your items and proceed to secure checkout.</p>
    </div>
  </div>

  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-10">

    <div class="bg-white rounded-2xl p-4 sm:p-6 shadow-[0_8px_30px_rgb(0,0,0,0.04)] mb-8 overflow-x-auto no-scrollbar flex-shrink-0 border border-gray-100">
      <div class="flex items-center justify-between min-w-[320px] max-w-3xl mx-auto">
        <div class="flex flex-col items-center cursor-pointer flex-shrink-0" onclick="goToStep(1)">
          <div id="indicator-1" class="w-10 h-10 sm:w-12 sm:h-12 rounded-full bg-primary text-white flex items-center justify-center shadow-md transition-all">
            <span class="material-symbols-outlined text-[18px] sm:text-[20px]">shopping_cart</span>
          </div>
          <span id="label-1" class="font-bold text-xs sm:text-sm mt-2 text-primary">Cart</span>
        </div>
        <div class="flex-1 h-[2px] bg-gray-200 mx-2 sm:mx-4"></div>

        <div class="flex flex-col items-center cursor-pointer flex-shrink-0" onclick="goToStep(2)">
          <div id="indicator-2" class="w-10 h-10 sm:w-12 sm:h-12 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center transition-all">
            <span class="material-symbols-outlined text-[18px] sm:text-[20px]">location_on</span>
          </div>
          <span id="label-2" class="font-bold text-xs sm:text-sm mt-2 text-blue-600">Address</span>
        </div>
        <div class="flex-1 h-[2px] bg-gray-200 mx-2 sm:mx-4"></div>

        <div class="flex flex-col items-center cursor-pointer flex-shrink-0" onclick="goToStep(3)">
          <div id="indicator-3" class="w-10 h-10 sm:w-12 sm:h-12 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center transition-all">
            <span class="material-symbols-outlined text-[18px] sm:text-[20px]">credit_card</span>
          </div>
          <span id="label-3" class="font-bold text-xs sm:text-sm mt-2 text-blue-600">Payment</span>
        </div>
        <div class="flex-1 h-[2px] bg-gray-200 mx-2 sm:mx-4"></div>

        <div class="flex flex-col items-center cursor-pointer flex-shrink-0" onclick="goToStep(4)">
          <div id="indicator-4" class="w-10 h-10 sm:w-12 sm:h-12 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center transition-all">
            <span class="material-symbols-outlined text-[18px] sm:text-[20px]">check</span>
          </div>
          <span id="label-4" class="font-bold text-xs sm:text-sm mt-2 text-blue-600">Done</span>
        </div>
      </div>
    </div>

    <div id="step-1" class="checkout-step active">
      <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
        <div class="lg:col-span-8 flex flex-col gap-4"></div>
        <div class="lg:col-span-4 flex flex-col gap-4 lg:sticky lg:top-6"></div>
      </div>
    </div>

    <div id="step-2" class="checkout-step">
      <div class="max-w-2xl mx-auto bg-white rounded-2xl p-6 sm:p-8 shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100">
        <div class="flex items-center gap-3 mb-6 border-b border-gray-100 pb-4">
            <div class="w-10 h-10 rounded-full bg-blue-100 text-primary flex items-center justify-center">
                <span class="material-symbols-outlined">location_on</span>
            </div>
            <h2 class="text-xl sm:text-2xl font-bold text-on-surface">Shipping Address</h2>
        </div>

        <form id="address-form" class="space-y-5" onsubmit="event.preventDefault(); saveAddressAndContinue();">
          <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
            <div>
              <label class="text-sm font-semibold text-on-surface-variant block mb-1.5">First Name</label>
              <input type="text" id="addr-firstname" required class="w-full h-12 px-4 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent text-sm transition-all" placeholder="John"/>
            </div>
            <div>
              <label class="text-sm font-semibold text-on-surface-variant block mb-1.5">Last Name</label>
              <input type="text" id="addr-lastname" required class="w-full h-12 px-4 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent text-sm transition-all" placeholder="Doe"/>
            </div>
          </div>
          <div>
            <label class="text-sm font-semibold text-on-surface-variant block mb-1.5">Street Address</label>
            <input type="text" id="addr-street" required class="w-full h-12 px-4 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent text-sm transition-all" placeholder="Plot 12 Jinja Road"/>
          </div>
          <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
            <div>
              <label class="text-sm font-semibold text-on-surface-variant block mb-1.5">City</label>
              <input type="text" id="addr-city" required class="w-full h-12 px-4 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent text-sm transition-all" placeholder="Kampala"/>
            </div>
            <div>
              <label class="text-sm font-semibold text-on-surface-variant block mb-1.5">Phone Number</label>
              <input type="tel" id="addr-phone" required class="w-full h-12 px-4 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent text-sm transition-all" placeholder="+256 700 000 000"/>
            </div>
          </div>
          <div class="flex flex-col-reverse sm:flex-row justify-between gap-3 pt-6 mt-2 border-t border-gray-100">
            <button type="button" onclick="goToStep(1)" class="w-full sm:w-auto h-12 px-6 bg-gray-100 text-gray-700 rounded-xl font-semibold hover:bg-gray-200 transition-colors">Back to Cart</button>
            <button type="submit" class="w-full sm:w-auto h-12 px-8 bg-primary text-white rounded-xl font-semibold flex items-center justify-center gap-2 shadow-md hover:bg-blue-700 transition-all">
              <span>Continue to Payment</span>
              <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
            </button>
          </div>
        </form>
      </div>
    </div>

    <div id="step-3" class="checkout-step">
      <div class="max-w-2xl mx-auto overflow-hidden bg-white rounded-2xl shadow-xl border border-gray-100">
        <div class="relative overflow-hidden bg-gradient-to-br from-green-600 to-emerald-500 px-6 py-8 sm:px-10 sm:py-10 text-white">
            <div class="absolute -right-12 -top-12 w-48 h-48 rounded-full bg-white/10"></div>
            <div class="absolute -right-4 -bottom-16 w-36 h-36 rounded-full bg-white/10"></div>
            <div class="relative z-10 flex items-center gap-4">
                <div class="w-16 h-16 flex-shrink-0 flex items-center justify-center rounded-2xl bg-white/20 border border-white/30 shadow-lg backdrop-blur-sm">
                    <i class="fa-brands fa-whatsapp text-4xl"></i>
                </div>
                <div>
                    <span class="inline-flex items-center gap-2 text-xs font-semibold uppercase tracking-[0.2em] text-green-100 mb-2">
                        <span class="w-2 h-2 rounded-full bg-green-300 animate-pulse"></span>
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
                <p class="mt-2 max-w-md mx-auto text-sm leading-6 text-gray-500">Send your order to our WhatsApp team. We'll confirm product availability and details with you.</p>
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

    <div id="step-4" class="checkout-step">
      <div class="max-w-xl mx-auto bg-white rounded-2xl p-6 sm:p-10 shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100 text-center">
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
          <div class="bg-surface-container-low p-4 rounded-lg text-left mb-6 space-y-2 text-sm border border-gray-100">
            <div class="flex justify-between"><span class="text-outline">Order ID:</span><span id="order-id" class="font-bold">#PG-89421</span></div>
            <div class="flex justify-between"><span class="text-outline">Status:</span><span class="font-bold text-green-600">Pending</span></div>
            <div class="flex justify-between"><span class="text-outline">Total Amount:</span><span id="confirm-total" class="font-bold text-primary">UGX 0</span></div>
          </div>
          <button onclick="clearAndReturn()" class="w-full h-12 bg-primary text-white rounded-xl font-semibold hover:bg-blue-700 transition-all shadow-md">Return to Shop</button>
        </div>
      </div>
    </div>

  </div>
</main>

<script>
  const STEP_ICONS = { 1: 'shopping_cart', 2: 'location_on', 3: 'credit_card', 4: 'check' };
  const fmt = n => Number(n).toLocaleString("en-US");
  const currentUserId = <?php echo json_encode($_SESSION['user_id'] ?? null); ?>;

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
        indicator.className = "w-10 h-10 sm:w-12 sm:h-12 rounded-full bg-primary text-white flex items-center justify-center shadow-md transition-all";
        indicator.innerHTML = icon('check');
        label.className = "font-bold text-xs sm:text-sm mt-2 text-primary";
      } else if (i === stepNumber) {
        indicator.className = "w-10 h-10 sm:w-12 sm:h-12 rounded-full bg-primary text-white flex items-center justify-center shadow-md ring-4 ring-blue-100 transition-all";
        indicator.innerHTML = icon(STEP_ICONS[i]);
        label.className = "font-bold text-xs sm:text-sm mt-2 text-primary";
      } else {
        indicator.className = "w-10 h-10 sm:w-12 sm:h-12 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center transition-all";
        indicator.innerHTML = icon(STEP_ICONS[i]);
        label.className = "font-bold text-xs sm:text-sm mt-2 text-blue-600";
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
    if (subtitle) subtitle.remove();

    if (cart.length === 0) {
      cartContainer.innerHTML = `
        <div class="bg-white rounded-2xl p-12 text-center shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100">
          <div class="w-24 h-24 bg-blue-50 rounded-full flex items-center justify-center mx-auto mb-4">
            <span class="material-symbols-outlined text-[48px] text-primary">shopping_bag</span>
          </div>
          <h3 class="text-2xl font-bold text-on-surface mb-2">Your cart is empty</h3>
          <p class="font-body-sm text-on-surface-variant text-base mb-6">Looks like you haven't added anything yet.</p>
          <a href="shop.php" class="inline-flex items-center gap-2 px-8 py-3.5 bg-primary text-white rounded-xl font-bold shadow-md hover:bg-blue-700 transition-all">
            <span class="material-symbols-outlined text-[20px]">arrow_back</span>
            Browse Supplements
          </a>
        </div>`;
    } else {
      let itemsHTML = cart.map(item => {
        const cleanImg = item.image ? item.image.replace(/^\.\.\//, '') : 'https://images.unsplash.com/photo-1546483875-ad9014c88eba?auto=format&fit=crop&w=500&q=80';

        return `
        <div class="p-5 sm:p-6 flex flex-col sm:flex-row items-center justify-between gap-5 bg-white rounded-xl border border-gray-100 shadow-sm hover:shadow-md transition-shadow">
          <div class="flex items-center gap-5 flex-1 w-full">
            <div class="w-20 h-20 sm:w-24 sm:h-24 rounded-xl overflow-hidden bg-gray-50 flex-shrink-0 flex items-center justify-center p-2 border border-gray-100">
              <img class="max-h-full max-w-full object-contain" alt="${item.name}" src="${cleanImg}"/>
            </div>
            <div class="min-w-0 flex-1">
              <h3 class="font-bold text-on-surface text-base sm:text-lg truncate">${item.name}</h3>
              <p class="font-body-sm text-on-surface-variant text-sm mt-1">${item.unit || 'Standard'}</p>
              <div class="text-primary font-bold mt-2 sm:hidden">UGX ${fmt(item.price * item.quantity)}</div>
            </div>
          </div>

          <div class="flex items-center justify-between w-full sm:w-auto gap-6 pt-4 sm:pt-0 border-t sm:border-0 border-gray-100">
            <div class="flex items-center bg-gray-50 rounded-lg p-1 border border-gray-200">
              <button onclick="updateQuantity(${item.id}, -1)" class="w-8 h-8 flex items-center justify-center text-gray-600 hover:text-primary hover:bg-white rounded-md transition-colors font-bold">-</button>
              <span class="w-10 text-center font-bold text-on-surface">${item.quantity}</span>
              <button onclick="updateQuantity(${item.id}, 1)" class="w-8 h-8 flex items-center justify-center text-gray-600 hover:text-primary hover:bg-white rounded-md transition-colors font-bold">+</button>
            </div>
            <div class="text-right min-w-[120px] hidden sm:block">
              <span class="text-lg font-bold text-on-surface block">UGX ${fmt(item.price * item.quantity)}</span>
              <button onclick="removeItem(${item.id})" class="text-red-500 text-xs font-semibold hover:text-red-700 flex items-center gap-1 justify-end ml-auto mt-2 transition-colors">
                <span class="material-symbols-outlined text-[16px]">delete</span> Remove
              </button>
            </div>
            <button onclick="removeItem(${item.id})" class="text-red-500 sm:hidden p-2">
                <span class="material-symbols-outlined text-[20px]">delete</span>
            </button>
          </div>
        </div>
      `;
      }).join('');

      cartContainer.innerHTML = `
        <div class="flex items-center justify-between mb-2 px-2">
            <h2 class="text-xl font-bold text-on-surface">Shopping Cart</h2>
            <span class="text-sm font-semibold text-primary bg-blue-50 px-3 py-1 rounded-full">${totalCount} Item${totalCount !== 1 ? 's' : ''}</span>
        </div>
        <div class="flex flex-col gap-4">
          ${itemsHTML}
        </div>`;
    }

    if (summaryContainer) {
      summaryContainer.innerHTML = `
        <div class="bg-white rounded-2xl p-6 shadow-[0_8px_30px_rgb(0,0,0,0.06)] border border-gray-100 sticky top-24">
          <h2 class="text-lg font-bold text-on-surface pb-4 border-b border-gray-100 mb-4">Order Summary</h2>

          <div class="space-y-3 mb-6">
            <div class="flex justify-between items-center text-sm">
                <span class="text-gray-500">Subtotal</span>
                <span class="font-semibold text-on-surface">UGX ${fmt(subtotal)}</span>
            </div>
            <div class="flex justify-between items-center text-sm">
                <span class="text-gray-500">Shipping</span>
                <span class="font-semibold text-green-600">Calculated at next step</span>
            </div>
          </div>

          <div class="flex justify-between items-baseline pt-4 border-t border-gray-100 mb-6">
            <span class="font-bold text-on-surface text-lg">Total</span>
            <span class="text-2xl text-primary font-extrabold">UGX ${fmt(subtotal)}</span>
          </div>

          <button onclick="goToStep(2)" ${cart.length === 0 ? 'disabled' : ''} class="w-full h-14 bg-primary hover:bg-blue-700 text-white rounded-xl font-bold text-lg flex items-center justify-center gap-2 shadow-lg shadow-blue-600/20 transition-all disabled:opacity-50 disabled:cursor-not-allowed group">
            <span>Proceed to Checkout</span>
            <span class="material-symbols-outlined text-[20px] group-hover:translate-x-1 transition-transform">arrow_forward</span>
          </button>

          <div class="mt-4 flex items-center justify-center gap-2 text-xs text-gray-400 font-medium">
            <span class="material-symbols-outlined text-[16px]">lock</span>
            Secure Checkout
          </div>
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
                user_id: currentUserId,
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