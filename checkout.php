<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout | Jumika Supplements</title>
    <!-- FontAwesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700;800;900&display=swap" rel="stylesheet">
</head>
<body class="bg-slate-50 font-sans antialiased text-slate-800 pb-24 md:pb-12">

<?php 
     include 'includes/top.php';
?>


    <!-- MAIN CHECKOUT CONTAINER -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="mb-6">
            <a href="cart.php" class="text-xs font-semibold text-indigo-600 hover:underline flex items-center gap-1.5 mb-2">
                <i class="fa-solid fa-arrow-left"></i> Back to Cart
            </a>
            <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">Checkout</h1>
            <p class="text-xs text-slate-500 mt-1">Complete your order by providing your shipping and payment details.</p>
        </div>

        <form action="process_order.php" method="POST" class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            
            <!-- LEFT COLUMN: Billing, Shipping & Payment Information -->
            <div class="lg:col-span-7 space-y-6">
                
                <!-- 1. Customer Information -->
                <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
                    <h2 class="text-base font-bold text-slate-900 mb-4 flex items-center gap-2">
                        <span class="w-6 h-6 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center text-xs font-black">1</span>
                        Contact Information
                    </h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Full Name</label>
                            <input type="text" name="fullname" required placeholder="Rwomushana Macarthy" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2.5 text-xs text-slate-800 focus:outline-none focus:border-indigo-600 focus:bg-white transition-all">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Phone Number</label>
                            <input type="tel" name="phone" required placeholder="+256 700 000000" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2.5 text-xs text-slate-800 focus:outline-none focus:border-indigo-600 focus:bg-white transition-all">
                        </div>
                        <div class="sm:col-span-2">
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Email Address (Optional)</label>
                            <input type="email" name="email" placeholder="macarthy@example.com" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2.5 text-xs text-slate-800 focus:outline-none focus:border-indigo-600 focus:bg-white transition-all">
                        </div>
                    </div>
                </div>

                <!-- 2. Shipping Address -->
                <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
                    <h2 class="text-base font-bold text-slate-900 mb-4 flex items-center gap-2">
                        <span class="w-6 h-6 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center text-xs font-black">2</span>
                        Shipping Address
                    </h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">City / Town</label>
                            <input type="text" name="city" required value="Kampala" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2.5 text-xs text-slate-800 focus:outline-none focus:border-indigo-600 focus:bg-white transition-all">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Street / Area</label>
                            <input type="text" name="address" required placeholder="Nakawa, Banda, etc." class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2.5 text-xs text-slate-800 focus:outline-none focus:border-indigo-600 focus:bg-white transition-all">
                        </div>
                        <div class="sm:col-span-2">
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Delivery Notes (Optional)</label>
                            <textarea name="notes" rows="2" placeholder="Near landmark, specific delivery instructions..." class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2.5 text-xs text-slate-800 focus:outline-none focus:border-indigo-600 focus:bg-white transition-all"></textarea>
                        </div>
                    </div>
                </div>

                <!-- 3. Payment Method -->
                <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
                    <h2 class="text-base font-bold text-slate-900 mb-4 flex items-center gap-2">
                        <span class="w-6 h-6 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center text-xs font-black">3</span>
                        Payment Method
                    </h2>
                    
                    <div class="space-y-3">
                        <!-- Mobile Money Option -->
                        <div class="rounded-xl border border-indigo-600 bg-indigo-50/30 overflow-hidden transition-all">
                            <label class="flex items-center justify-between p-4 cursor-pointer">
                                <div class="flex items-center gap-3">
                                    <input type="radio" name="payment_method" value="momo" id="momoRadio" checked class="text-indigo-600 focus:ring-indigo-500">
                                    <div>
                                        <span class="block text-xs font-bold text-slate-900">Mobile Money</span>
                                        <span class="block text-[10px] text-slate-500">Pay via MTN or Airtel Money prompt</span>
                                    </div>
                                </div>
                                <i class="fa-solid fa-mobile-screen-button text-indigo-600 text-lg"></i>
                            </label>

                            <!-- Sub-options for MTN and Airtel with online image logos -->
                            <div id="momoProviders" class="px-4 pb-4 pt-1 grid grid-cols-2 gap-3 border-t border-indigo-100">
                                <!-- MTN Option -->
                                <label class="flex items-center gap-2.5 p-3 bg-white rounded-lg border border-slate-200 cursor-pointer hover:border-yellow-500 transition-all">
                                    <input type="radio" name="momo_provider" value="mtn" checked class="text-yellow-500 focus:ring-yellow-400">
                                    <div class="w-8 h-8 rounded-md bg-yellow-400 flex items-center justify-center p-1 overflow-hidden shadow-sm flex-shrink-0">
                                        <img src="https://seeklogo.com/images/M/mtn-momo-logo-556395A347-seeklogo.com.png" alt="MTN MoMo" class="w-full h-full object-contain">
                                    </div>
                                    <span class="text-xs font-bold text-slate-800">MTN MoMo</span>
                                </label>

                                <!-- Airtel Option -->
                                <label class="flex items-center gap-2.5 p-3 bg-white rounded-lg border border-slate-200 cursor-pointer hover:border-red-500 transition-all">
                                    <input type="radio" name="momo_provider" value="airtel" class="text-red-600 focus:ring-red-500">
                                    <div class="w-8 h-8 rounded-md bg-red-600 flex items-center justify-center p-1 overflow-hidden shadow-sm flex-shrink-0">
                                        <img src="https://seeklogo.com/images/A/airtel-money-logo-1919864273-seeklogo.com.png" alt="Airtel Money" class="w-full h-full object-contain">
                                    </div>
                                    <span class="text-xs font-bold text-slate-800">Airtel Money</span>
                                </label>
                            </div>
                        </div>

                        <!-- Stripe Card Payment Option -->
                        <label class="flex items-center justify-between p-4 rounded-xl border border-slate-200 hover:border-slate-300 bg-white cursor-pointer transition-all">
                            <div class="flex items-center gap-3">
                                <input type="radio" name="payment_method" value="stripe" id="stripeRadio" class="text-indigo-600 focus:ring-indigo-500">
                                <div>
                                    <span class="block text-xs font-bold text-slate-900">Credit / Debit Card (Stripe)</span>
                                    <span class="block text-[10px] text-slate-500">Secure international card payment</span>
                                </div>
                            </div>
                            <div class="flex items-center gap-1.5 text-slate-600 text-lg">
                                <i class="fa-brands fa-stripe text-indigo-600 text-2xl"></i>
                                <i class="fa-brands fa-cc-visa"></i>
                                <i class="fa-brands fa-cc-mastercard"></i>
                            </div>
                        </label>

                        <!-- Cash on Delivery Option -->
                        <label class="flex items-center justify-between p-4 rounded-xl border border-slate-200 hover:border-slate-300 bg-white cursor-pointer transition-all">
                            <div class="flex items-center gap-3">
                                <input type="radio" name="payment_method" value="cod" id="codRadio" class="text-indigo-600 focus:ring-indigo-500">
                                <div>
                                    <span class="block text-xs font-bold text-slate-900">Cash on Delivery</span>
                                    <span class="block text-[10px] text-slate-500">Pay with cash when your package arrives</span>
                                </div>
                            </div>
                            <i class="fa-solid fa-money-bill-wave text-slate-500 text-lg"></i>
                        </label>
                    </div>
                </div>

            </div>

            <!-- RIGHT COLUMN: Order Summary -->
            <div class="lg:col-span-5">
                <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm sticky top-28">
                    <h2 class="text-base font-bold text-slate-900 mb-4 border-b border-slate-100 pb-3">Order Summary</h2>
                    
                    <!-- Cart Items Preview List -->
                    <div class="space-y-3 max-h-60 overflow-y-auto pr-1 mb-4">
                        <!-- Sample Item 1 -->
                        <div class="flex items-center justify-between gap-3 text-xs">
                            <div class="flex items-center gap-3">
                                <div class="w-12 h-12 bg-slate-100 rounded-xl overflow-hidden flex-shrink-0">
                                    <img src="assets/images/product1.jpg" alt="Product" class="w-full h-full object-cover">
                                </div>
                                <div>
                                    <h4 class="font-bold text-slate-900">Whey Protein Gold</h4>
                                    <span class="text-slate-400">Qty: 1</span>
                                </div>
                            </div>
                            <span class="font-semibold text-slate-800">UGX 150,000</span>
                        </div>

                        <!-- Sample Item 2 -->
                        <div class="flex items-center justify-between gap-3 text-xs">
                            <div class="flex items-center gap-3">
                                <div class="w-12 h-12 bg-slate-100 rounded-xl overflow-hidden flex-shrink-0">
                                    <img src="assets/images/product2.jpg" alt="Product" class="w-full h-full object-cover">
                                </div>
                                <div>
                                    <h4 class="font-bold text-slate-900">Creatine Monohydrate</h4>
                                    <span class="text-slate-400">Qty: 2</span>
                                </div>
                            </div>
                            <span class="font-semibold text-slate-800">UGX 90,000</span>
                        </div>
                    </div>

                    <!-- Cost Breakdown -->
                    <div class="space-y-2 border-t border-slate-100 pt-4 text-xs">
                        <div class="flex justify-between text-slate-600">
                            <span>Subtotal</span>
                            <span class="font-semibold text-slate-900">UGX 240,000</span>
                        </div>
                        <div class="flex justify-between text-slate-600">
                            <span>Estimated Delivery</span>
                            <span class="font-semibold text-emerald-600">FREE</span>
                        </div>
                        <div class="flex justify-between text-base font-black text-slate-900 border-t border-slate-100 pt-3 mt-2">
                            <span>Total</span>
                            <span class="text-indigo-600">UGX 240,000</span>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="w-full mt-6 bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3.5 px-4 rounded-xl text-xs transition-all shadow-md shadow-indigo-200 flex items-center justify-center gap-2 cursor-pointer">
                        <i class="fa-solid fa-shield-halved"></i> Place Order Now
                    </button>

                    <p class="text-[10px] text-center text-slate-400 mt-3">
                        By placing your order, you agree to our terms of service and privacy policy.
                    </p>
                </div>
            </div>

        </form>
    </main>

    <!-- JavaScript to toggle Mobile Money provider options -->
    <script>
        const momoRadio = document.getElementById('momoRadio');
        const stripeRadio = document.getElementById('stripeRadio');
        const codRadio = document.getElementById('codRadio');
        const momoProviders = document.getElementById('momoProviders');

        function updatePaymentStyles() {
            document.querySelectorAll('input[name="payment_method"]').forEach(radio => {
                const parentLabel = radio.closest('.rounded-xl');
                if (parentLabel) {
                    if (radio.checked) {
                        parentLabel.classList.add('border-indigo-600', 'bg-indigo-50/30');
                        parentLabel.classList.remove('border-slate-200', 'bg-white');
                    } else {
                        parentLabel.classList.remove('border-indigo-600', 'bg-indigo-50/30');
                        parentLabel.classList.add('border-slate-200', 'bg-white');
                    }
                }
            });

            if (momoRadio.checked) {
                momoProviders.classList.remove('hidden');
            } else {
                momoProviders.classList.add('hidden');
            }
        }

        momoRadio.addEventListener('change', updatePaymentStyles);
        stripeRadio.addEventListener('change', updatePaymentStyles);
        codRadio.addEventListener('change', updatePaymentStyles);
    </script>
</body>
</html>