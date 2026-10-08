<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<meta content="web_standard" name="shell-type"/>
<title>Checkout | PURE GAIN</title>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&family=Inter:wght@400;500;600&display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet"/>
<style>
  html, body { margin: 0; padding: 0; }
  body { overscroll-behavior: none; }
  main > :first-child { margin-top: 0 !important; }
  main > :last-child { margin-bottom: 0 !important; }
  ::-webkit-scrollbar { display: none; }
  .checkout-step { display: none; }
  .checkout-step.active { display: block; }
</style>
<script src="https://cdn.tailwindcss.com"></script>
<script id="tailwind-config">
tailwind.config={"darkMode":"class","theme":{"extend":{"colors":{"inverse-surface":"#213145","outline-variant":"#c3c6d7","secondary-fixed-dim":"#bcc7de","surface":"#f8f9ff","secondary":"#545f73","on-primary-container":"#eeefff","error-container":"#ffdad6","tertiary-container":"#007b71","secondary-container":"#d5e0f8","surface-container-low":"#eff4ff","on-secondary-container":"#586377","surface-tint":"#0053db","on-secondary":"#ffffff","primary-fixed":"#dbe1ff","tertiary-fixed-dim":"#6bd8cb","primary":"#004ac6","surface-dim":"#cbdbf5","error":"#ba1a1a","primary-container":"#2563eb","on-tertiary":"#ffffff","on-tertiary-container":"#b3fff3","on-background":"#0b1c30","on-primary-fixed":"#00174b","outline":"#737686","on-error-container":"#93000a","surface-container":"#e5eeff","surface-variant":"#d3e4fe","inverse-primary":"#b4c5ff","surface-bright":"#f8f9ff","surface-container-high":"#dce9ff","surface-container-lowest":"#ffffff","on-primary-fixed-variant":"#003ea8","on-error":"#ffffff","on-tertiary-fixed-variant":"#005049","on-tertiary-fixed":"#00201d","background":"#f8f9ff","tertiary":"#006058","on-surface":"#0b1c30","on-surface-variant":"#434655","surface-container-highest":"#d3e4fe","secondary-fixed":"#d8e3fb","on-secondary-fixed-variant":"#3c475a","on-secondary-fixed":"#111c2d","on-primary":"#ffffff","tertiary-fixed":"#89f5e7","inverse-on-surface":"#eaf1ff","primary-fixed-dim":"#b4c5ff"},"borderRadius":{"DEFAULT":"0.25rem","lg":"0.5rem","xl":"0.75rem","full":"9999px"},"spacing":{"margin":"2rem","gutter":"1.5rem","space-sm":"0.5rem","space-lg":"1.5rem","gutter-mobile":"1rem","space-md":"1rem","space-xs":"0.25rem","margin-mobile":"1rem","space-xl":"2.5rem"},"fontFamily":{"display-lg-mobile":["Plus Jakarta Sans"],"label-lg":["Inter"],"body-sm":["Plus Jakarta Sans"],"body-md":["Plus Jakarta Sans"],"label-md":["Inter"],"headline-lg":["Plus Jakarta Sans"],"label-sm":["Inter"],"headline-sm":["Plus Jakarta Sans"],"headline-lg-mobile":["Plus Jakarta Sans"],"body-lg":["Plus Jakarta Sans"],"headline-md":["Plus Jakarta Sans"],"display-lg":["Plus Jakarta Sans"]},"fontSize":{"display-lg-mobile":["32px",{"lineHeight":"40px","letterSpacing":"-0.025em","fontWeight":"800"}],"label-lg":["15px",{"lineHeight":"20px","letterSpacing":"-0.005em","fontWeight":"600"}],"body-sm":["13px",{"lineHeight":"20px","fontWeight":"400"}],"body-md":["15px",{"lineHeight":"24px","fontWeight":"400"}],"label-md":["13px",{"lineHeight":"18px","fontWeight":"500"}],"headline-lg":["36px",{"lineHeight":"44px","letterSpacing":"-0.02em","fontWeight":"700"}],"label-sm":["11px",{"lineHeight":"16px","letterSpacing":"0.04em","fontWeight":"600"}],"headline-sm":["18px",{"lineHeight":"26px","letterSpacing":"-0.01em","fontWeight":"600"}],"headline-lg-mobile":["26px",{"lineHeight":"34px","letterSpacing":"-0.02em","fontWeight":"700"}],"body-lg":["18px",{"lineHeight":"28px","fontWeight":"400"}],"headline-md":["24px",{"lineHeight":"32px","letterSpacing":"-0.015em","fontWeight":"700"}],"display-lg":["48px",{"lineHeight":"56px","letterSpacing":"-0.03em","fontWeight":"800"}]}}}};</script>
</head>
<body class="bg-surface font-body-md text-on-surface antialiased">

<!-- pt-28 (112px) removed: it was reserved for a fixed navbar this page doesn't have -->
<main class="w-full pt-4 sm:pt-6 bg-surface pb-20">
  <div class="flex flex-col w-full max-w-7xl mx-auto px-margin py-space-lg">

    <!-- Step Progress Bar -->
    <div class="bg-surface-container-lowest rounded-xl p-space-lg shadow-sm mb-space-lg flex items-center justify-between overflow-x-auto">
      <div class="flex items-center gap-2 sm:gap-4 w-full justify-between max-w-4xl mx-auto">
        <!-- Step 1: Cart -->
        <div class="flex flex-col items-center cursor-pointer" onclick="goToStep(1)">
          <div id="indicator-1" class="w-12 h-12 rounded-full bg-primary text-on-primary flex items-center justify-center shadow-md transition-all">
            <span class="material-symbols-outlined text-[20px]">shopping_cart</span>
          </div>
          <span id="label-1" class="font-label-md font-bold mt-2 text-primary">Cart</span>
        </div>
        <div class="flex-1 h-[2px] bg-outline-variant mx-2"></div>

        <!-- Step 2: Address -->
        <div class="flex flex-col items-center cursor-pointer" onclick="goToStep(2)">
          <div id="indicator-2" class="w-12 h-12 rounded-full bg-surface-container-high text-outline flex items-center justify-center transition-all">
            <span class="material-symbols-outlined text-[20px]">location_on</span>
          </div>
          <span id="label-2" class="font-label-md mt-2 text-outline">Address</span>
        </div>
        <div class="flex-1 h-[2px] bg-outline-variant mx-2"></div>

        <!-- Step 3: Payment -->
        <div class="flex flex-col items-center cursor-pointer" onclick="goToStep(3)">
          <div id="indicator-3" class="w-12 h-12 rounded-full bg-surface-container-high text-outline flex items-center justify-center transition-all">
            <span class="material-symbols-outlined text-[20px]">credit_card</span>
          </div>
          <span id="label-3" class="font-label-md mt-2 text-outline">Payment</span>
        </div>
        <div class="flex-1 h-[2px] bg-outline-variant mx-2"></div>

        <!-- Step 4: Confirmation -->
        <div class="flex flex-col items-center cursor-pointer" onclick="goToStep(4)">
          <div id="indicator-4" class="w-12 h-12 rounded-full bg-surface-container-high text-outline flex items-center justify-center transition-all">
            <span class="material-symbols-outlined text-[20px]">check</span>
          </div>
          <span id="label-4" class="font-label-md mt-2 text-outline">Confirmation</span>
        </div>
      </div>
    </div>

    <!-- ==================== SCREEN 1: CART ==================== -->
    <div id="step-1" class="checkout-step active">
      <div class="flex flex-col sm:flex-row sm:items-end justify-between pb-space-lg gap-space-sm">
        <div>
          <span class="font-label-sm text-primary tracking-widest uppercase mb-1 block">Pure Gain Bag</span>
          <h1 class="font-headline-lg text-on-surface tracking-tight">Your Shopping Cart</h1>
          <p class="font-body-md text-on-surface-variant">You have 3 items in your bag. Free shipping is unlocked!</p>
        </div>
      </div>

      <div class="grid grid-cols-1 lg:grid-cols-12 gap-space-lg items-start">
        <div class="lg:col-span-8 flex flex-col gap-space-lg">
          <div class="bg-surface-container-lowest rounded-xl shadow-sm overflow-hidden">
            <div class="px-space-lg py-space-md bg-surface-container-low flex justify-between items-center text-on-surface-variant font-label-md">
              <span>Product Details</span>
              <span class="hidden sm:inline">Price &amp; Quantity</span>
            </div>
            <!-- Item 1 -->
            <div class="p-space-lg flex flex-col sm:flex-row items-start sm:items-center justify-between gap-space-md">
              <div class="flex items-start sm:items-center gap-space-md flex-1">
                <div class="w-20 h-20 rounded-lg overflow-hidden bg-surface-container-high flex-shrink-0">
                  <img class="w-full h-full object-cover" alt="Aura Studio headphones" src="https://lh3.googleusercontent.com/aida-public/AB6AXuB_Qt8Ct5p9QSltOcHyPqq3_7ebVbUCQDx8y0ifubi4Iix8OjyO7XfLC5qccybnlOxbvb3Tw65YfTBUxgrEaks83tyq9PA_ywjimPgCAwNOQ7Dk-s23vuuo4e1RxQqMRKhA-ubUDyoVJ4zSXFy1vGFwxfdbWoCWSVcJlW6skDe-tUYhcowdXmFz5zr2Y_PJPpmRCfitLbz9IRsyFZEvuYj1foosVXqpMz1oPyyEaSyPLyEnz05aflXY"/>
                </div>
                <div>
                  <span class="font-label-sm text-outline uppercase tracking-wider">Audio Lab</span>
                  <h3 class="font-headline-sm text-on-surface">Aura Studio Wireless Noise-Cancelling Headphones</h3>
                  <p class="font-body-sm text-on-surface-variant">Matte Obsidian • Universal Fit</p>
                </div>
              </div>
              <span class="font-headline-sm text-on-surface font-bold">$249.00</span>
            </div>
          </div>
        </div>

        <!-- Summary & Next Button -->
        <div class="lg:col-span-4 flex flex-col gap-space-md sticky top-6">
          <div class="bg-surface-container-lowest rounded-xl p-space-lg shadow-sm">
            <h2 class="font-headline-sm text-on-surface font-bold pb-space-sm">Order Summary</h2>
            <div class="flex justify-between items-baseline pt-space-xs pb-space-md">
              <span class="font-headline-sm text-on-surface font-bold">Total Amount</span>
              <span class="font-headline-lg text-primary font-extrabold">$409.54</span>
            </div>
            <button onclick="goToStep(2)" class="w-full h-12 bg-primary-container hover:bg-primary text-on-primary rounded-lg font-label-lg flex items-center justify-center gap-space-sm shadow-md transition-all">
              <span>Proceed to Checkout</span>
              <span class="material-symbols-outlined text-[20px]">arrow_forward</span>
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- ==================== SCREEN 2: ADDRESS ==================== -->
    <div id="step-2" class="checkout-step">
      <div class="max-w-2xl mx-auto bg-surface-container-lowest rounded-xl p-space-xl shadow-sm">
        <h2 class="font-headline-md text-on-surface font-bold mb-space-md">Shipping Address</h2>
        <form class="space-y-space-md" onsubmit="event.preventDefault(); goToStep(3);">
          <div class="grid grid-cols-2 gap-space-md">
            <div>
              <label class="font-label-sm text-on-surface-variant block mb-1">First Name</label>
              <input type="text" required class="w-full h-12 px-space-md bg-surface-container-low rounded-lg focus:outline-none" placeholder="John"/>
            </div>
            <div>
              <label class="font-label-sm text-on-surface-variant block mb-1">Last Name</label>
              <input type="text" required class="w-full h-12 px-space-md bg-surface-container-low rounded-lg focus:outline-none" placeholder="Doe"/>
            </div>
          </div>
          <div>
            <label class="font-label-sm text-on-surface-variant block mb-1">Street Address</label>
            <input type="text" required class="w-full h-12 px-space-md bg-surface-container-low rounded-lg focus:outline-none" placeholder="123 Main Street, Apt 4B"/>
          </div>
          <div class="grid grid-cols-2 gap-space-md">
            <div>
              <label class="font-label-sm text-on-surface-variant block mb-1">City</label>
              <input type="text" required class="w-full h-12 px-space-md bg-surface-container-low rounded-lg focus:outline-none" placeholder="New York"/>
            </div>
            <div>
              <label class="font-label-sm text-on-surface-variant block mb-1">Postal Code</label>
              <input type="text" required class="w-full h-12 px-space-md bg-surface-container-low rounded-lg focus:outline-none" placeholder="10001"/>
            </div>
          </div>
          <div class="flex justify-between pt-space-md">
            <button type="button" onclick="goToStep(1)" class="h-12 px-space-lg bg-surface-container-low text-on-surface rounded-lg font-label-lg">Back to Cart</button>
            <button type="submit" class="h-12 px-space-lg bg-primary text-on-primary rounded-lg font-label-lg flex items-center gap-2">
              <span>Continue to Payment</span>
              <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
            </button>
          </div>
        </form>
      </div>
    </div>

    <!-- ==================== SCREEN 3: PAYMENT ==================== -->
    <div id="step-3" class="checkout-step">
      <div class="max-w-2xl mx-auto bg-surface-container-lowest rounded-xl p-space-xl shadow-sm">
        <h2 class="font-headline-md text-on-surface font-bold mb-space-md">Payment Details</h2>
        <form class="space-y-space-md" onsubmit="event.preventDefault(); goToStep(4);">
          <div>
            <label class="font-label-sm text-on-surface-variant block mb-1">Card Number</label>
            <input type="text" required class="w-full h-12 px-space-md bg-surface-container-low rounded-lg focus:outline-none" placeholder="4532 •••• •••• 8920"/>
          </div>
          <div class="grid grid-cols-2 gap-space-md">
            <div>
              <label class="font-label-sm text-on-surface-variant block mb-1">Expiry Date</label>
              <input type="text" required class="w-full h-12 px-space-md bg-surface-container-low rounded-lg focus:outline-none" placeholder="MM/YY"/>
            </div>
            <div>
              <label class="font-label-sm text-on-surface-variant block mb-1">CVV</label>
              <input type="password" required maxlength="4" class="w-full h-12 px-space-md bg-surface-container-low rounded-lg focus:outline-none" placeholder="123"/>
            </div>
          </div>
          <div class="flex justify-between pt-space-md">
            <button type="button" onclick="goToStep(2)" class="h-12 px-space-lg bg-surface-container-low text-on-surface rounded-lg font-label-lg">Back to Address</button>
            <button type="submit" class="h-12 px-space-lg bg-primary text-on-primary rounded-lg font-label-lg flex items-center gap-2">
              <span>Pay $409.54 &amp; Confirm</span>
              <span class="material-symbols-outlined text-[18px]">lock</span>
            </button>
          </div>
        </form>
      </div>
    </div>

    <!-- ==================== SCREEN 4: CONFIRMATION ==================== -->
    <div id="step-4" class="checkout-step">
      <div class="max-w-xl mx-auto bg-surface-container-lowest rounded-xl p-space-xl shadow-sm text-center">
        <div class="w-20 h-20 bg-tertiary-container text-on-tertiary rounded-full flex items-center justify-center mx-auto mb-space-md shadow-sm">
          <span class="material-symbols-outlined text-[40px]">check</span>
        </div>
        <h2 class="font-headline-lg text-on-surface font-bold mb-space-xs">Order Confirmed!</h2>
        <p class="font-body-md text-on-surface-variant mb-space-lg">Thank you for your purchase. We have received your order and are getting it ready for shipment.</p>
        <div class="bg-surface-container-low p-space-md rounded-lg text-left mb-space-lg space-y-2">
          <div class="flex justify-between"><span class="text-outline">Order ID:</span><span class="font-bold">#AURA-89421</span></div>
          <div class="flex justify-between"><span class="text-outline">Estimated Delivery:</span><span class="font-bold">3-5 Business Days</span></div>
          <div class="flex justify-between"><span class="text-outline">Total Paid:</span><span class="font-bold text-primary">$409.54</span></div>
        </div>
        <button onclick="goToStep(1)" class="w-full h-12 bg-primary text-on-primary rounded-lg font-label-lg">Return to Shop</button>
      </div>
    </div>

  </div>
</main>

<script>
  const STEP_ICONS = { 1: 'shopping_cart', 2: 'location_on', 3: 'credit_card', 4: 'check' };

  function goToStep(stepNumber) {
    document.querySelectorAll('.checkout-step').forEach(el => el.classList.remove('active'));
    document.getElementById('step-' + stepNumber).classList.add('active');

    for (let i = 1; i <= 4; i++) {
      const indicator = document.getElementById('indicator-' + i);
      const label = document.getElementById('label-' + i);
      const icon = (name) => '<span class="material-symbols-outlined text-[20px]">' + name + '</span>';

      if (i < stepNumber) {            // completed
        indicator.className = "w-12 h-12 rounded-full bg-tertiary text-on-tertiary flex items-center justify-center shadow-md transition-all";
        indicator.innerHTML = icon('check');
        label.className = "font-label-md mt-2 text-tertiary";
      } else if (i === stepNumber) {   // active
        indicator.className = "w-12 h-12 rounded-full bg-primary text-on-primary flex items-center justify-center shadow-md transition-all";
        indicator.innerHTML = icon(STEP_ICONS[i]);
        label.className = "font-label-md font-bold mt-2 text-primary";
      } else {                         // upcoming
        indicator.className = "w-12 h-12 rounded-full bg-surface-container-high text-outline flex items-center justify-center transition-all";
        indicator.innerHTML = icon(STEP_ICONS[i]);
        label.className = "font-label-md mt-2 text-outline";
      }
    }
    window.scrollTo({ top: 0, behavior: 'smooth' });
  }
</script>
</body>
</html>