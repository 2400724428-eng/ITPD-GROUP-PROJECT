<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Commerce Checkout</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- FontAwesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brandBlue: '#1d4ed8',
                        brandGreen: '#10b981',
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gray-100 min-h-screen text-gray-800 antialiased font-sans">
<?php 
     include 'includes/top.php';
?>
  


    <div class="w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-10">
        
        <!-- Main Container Card -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 sm:p-8">

            <!-- Stepper Header -->
            <div class="flex flex-col sm:flex-row items-center justify-between pb-8 border-b border-gray-200 mb-8 gap-4 sm:gap-0">
                <!-- Cart Step -->
                <div id="step-ind-cart" class="flex flex-col items-center cursor-pointer transition-all" onclick="goToStep('cart')">
                    <div class="w-12 h-12 rounded-full flex items-center justify-center bg-blue-600 text-white shadow-md mb-2">
                        <i class="fa-solid fa-cart-shopping text-lg"></i>
                    </div>
                    <span class="text-sm font-semibold text-blue-600">Cart</span>
                </div>
                <div class="hidden sm:block flex-1 h-0.5 bg-gray-300 mx-4"></div>

                <!-- Address Step -->
                <div id="step-ind-address" class="flex flex-col items-center cursor-pointer opacity-60 transition-all" onclick="canAccessStep('address') && goToStep('address')">
                    <div class="w-12 h-12 rounded-full flex items-center justify-center bg-gray-200 text-gray-600 mb-2">
                        <i class="fa-solid fa-address-book text-lg"></i>
                    </div>
                    <span class="text-sm font-medium text-gray-600">Address</span>
                </div>
                <div class="hidden sm:block flex-1 h-0.5 bg-gray-300 mx-4"></div>

                <!-- Payment Step -->
                <div id="step-ind-payment" class="flex flex-col items-center cursor-pointer opacity-60 transition-all" onclick="canAccessStep('payment') && goToStep('payment')">
                    <div class="w-12 h-12 rounded-full flex items-center justify-center bg-gray-200 text-gray-600 mb-2">
                        <i class="fa-solid fa-credit-card text-lg"></i>
                    </div>
                    <span class="text-sm font-medium text-gray-600">Payment</span>
                </div>
                <div class="hidden sm:block flex-1 h-0.5 bg-gray-300 mx-4"></div>

                <!-- Confirmation Step -->
                <div id="step-ind-confirmation" class="flex flex-col items-center cursor-pointer opacity-60 transition-all" onclick="canAccessStep('confirmation') && goToStep('confirmation')">
                    <div class="w-12 h-12 rounded-full flex items-center justify-center bg-gray-200 text-gray-600 mb-2">
                        <i class="fa-solid fa-chart-line text-lg"></i>
                    </div>
                    <span class="text-sm font-medium text-gray-600">Confirmation</span>
                </div>
            </div>

            <!-- ================= STEP 1: CART ================= -->
            <div id="view-cart" class="checkout-view">
                <!-- Available Offers Banner -->
                <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-6 relative">
                    <button onclick="this.parentElement.style.display='none'" class="absolute top-3 right-3 text-green-700 hover:text-green-900 font-bold text-sm">&times;</button>
                    <div class="flex items-center text-green-800 font-semibold text-sm mb-1">
                        <i class="fa-solid fa-check mr-2"></i> Available Offers
                    </div>
                    <ul class="text-xs sm:text-sm text-green-700 space-y-1 pl-5 list-disc">
                        <li>10% instant Discount on Bank of America Corp Bank and credit cards</li>
                        <li>25% cashback voucher of up to $60 on first ever Paypal Transaction. TCA</li>
                    </ul>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <!-- Left: Shopping Bag Items -->
                    <div class="lg:col-span-2 space-y-6">
                        <h2 class="text-lg font-bold text-gray-800">My Shopping Bag (<span id="bag-item-count">2</span> items)</h2>

                        <!-- Item 1: iPhone 16 Pro Max -->
                        <div class="bg-white border border-gray-200 rounded-xl p-4 sm:p-5 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 relative">
                            <button onclick="removeItem(1)" class="absolute top-3 right-3 text-gray-400 hover:text-red-600"><i class="fa-solid fa-xmark text-lg"></i></button>
                            <div class="flex items-center space-x-4">
                                <img src="https://images.unsplash.com/photo-1695048133142-1a20484d2569?w=300&auto=format&fit=crop&q=80" alt="iPhone 16 Pro Max" class="w-20 h-20 object-cover rounded-lg border border-gray-100 flex-shrink-0">
                                <div>
                                    <h3 class="font-bold text-gray-900 text-base">iPhone 16 Pro Max</h3>
                                    <p class="text-xs text-gray-500 mt-0.5">Sold by: <span class="font-semibold text-gray-700">Apple</span> <span class="bg-green-50 text-green-600 px-1.5 py-0.5 rounded text-[10px] font-medium ml-1">In stock</span></p>
                                    <div class="flex items-center text-amber-400 text-xs mt-2 space-x-0.5">
                                        <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i>
                                    </div>
                                    <!-- Quantity Controls -->
                                    <div class="flex items-center border border-gray-300 rounded mt-3 w-24">
                                        <button onclick="updateQty(1, -1)" class="px-2.5 py-1 text-gray-600 hover:bg-gray-100 transition">-</button>
                                        <span id="qty-1" class="flex-1 text-center text-sm font-semibold">1</span>
                                        <button onclick="updateQty(1, 1)" class="px-2.5 py-1 text-gray-600 hover:bg-gray-100 transition">+</button>
                                    </div>
                                </div>
                            </div>
                            <div class="flex sm:flex-col justify-between w-full sm:w-auto items-end mt-2 sm:mt-0">
                                <div class="text-right">
                                    <span class="font-bold text-lg text-gray-900">$<span id="price-1">400</span></span>
                                    <span class="text-xs text-gray-400 line-through ml-1">$450</span>
                                </div>
                                <button class="text-blue-600 hover:text-blue-800 text-xs font-semibold mt-2">Move to wishlist</button>
                            </div>
                        </div>

                        <!-- Item 2: HomePod -->
                        <div class="bg-white border border-gray-200 rounded-xl p-4 sm:p-5 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 relative">
                            <button onclick="removeItem(2)" class="absolute top-3 right-3 text-gray-400 hover:text-red-600"><i class="fa-solid fa-xmark text-lg"></i></button>
                            <div class="flex items-center space-x-4">
                                <img src="https://images.unsplash.com/photo-1543512214-318c7553f230?w=300&auto=format&fit=crop&q=80" alt="HomePod" class="w-20 h-20 object-cover rounded-lg border border-gray-100 flex-shrink-0">
                                <div>
                                    <h3 class="font-bold text-gray-900 text-base">HomePod</h3>
                                    <p class="text-xs text-gray-500 mt-0.5">Sold by: <span class="font-semibold text-gray-700">Apple</span> <span class="bg-green-50 text-green-600 px-1.5 py-0.5 rounded text-[10px] font-medium ml-1">In stock</span></p>
                                    <div class="flex items-center text-amber-400 text-xs mt-2 space-x-0.5">
                                        <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i>
                                    </div>
                                    <!-- Quantity Controls -->
                                    <div class="flex items-center border border-gray-300 rounded mt-3 w-24">
                                        <button onclick="updateQty(2, -1)" class="px-2.5 py-1 text-gray-600 hover:bg-gray-100 transition">-</button>
                                        <span id="qty-2" class="flex-1 text-center text-sm font-semibold">1</span>
                                        <button onclick="updateQty(2, 1)" class="px-2.5 py-1 text-gray-600 hover:bg-gray-100 transition">+</button>
                                    </div>
                                </div>
                            </div>
                            <div class="flex sm:flex-col justify-between w-full sm:w-auto items-end mt-2 sm:mt-0">
                                <div class="text-right">
                                    <span class="font-bold text-lg text-gray-900">$<span id="price-2">299</span></span>
                                    <span class="text-xs text-gray-400 line-through ml-1">$359</span>
                                </div>
                                <button class="text-blue-600 hover:text-blue-800 text-xs font-semibold mt-2">Move to wishlist</button>
                            </div>
                        </div>

                        <!-- Add from wishlist bar -->
                        <div class="border border-gray-200 rounded-lg p-4 flex items-center justify-between text-sm text-gray-600 hover:bg-gray-50 cursor-pointer transition">
                            <span>Add more products from wishlist</span>
                            <i class="fa-solid fa-arrow-right text-gray-400"></i>
                        </div>
                    </div>

                    <!-- Right: Order Summary Sidebar -->
                    <div class="space-y-6">
                        <!-- Promo Code Card -->
                        <div class="bg-white border border-gray-200 rounded-xl p-5 shadow-sm">
                            <label class="block text-xs font-semibold uppercase text-gray-500 mb-2">Offer</label>
                            <div class="flex gap-2">
                                <input type="text" id="promo-input" placeholder="Enter Your Promo Code" class="flex-1 border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-blue-600">
                                <button onclick="applyPromo()" class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-blue-700 transition">Apply</button>
                            </div>
                            <p id="promo-message" class="text-xs mt-2 text-green-600 font-medium hidden">Promo code applied successfully!</p>
                        </div>

                        <!-- Gift Wrap Option -->
                        <div class="bg-gray-50 border border-gray-200 rounded-xl p-5">
                            <div class="flex items-start justify-between">
                                <div>
                                    <h4 class="font-semibold text-sm text-gray-900">Buying gift for a loved one?</h4>
                                    <p class="text-xs text-gray-500 mt-1">Gift wrap and personalizes message on card, only for $2</p>
                                </div>
                            </div>
                            <div class="mt-3 flex items-center justify-between">
                                <label class="flex items-center space-x-2 text-sm font-semibold text-blue-600 cursor-pointer">
                                    <input type="checkbox" id="gift-checkbox" onchange="toggleGiftWrap()" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500 w-4 h-4">
                                    <span>Add gift wrap 🎁</span>
                                </label>
                                <span id="gift-price-tag" class="text-xs text-gray-500 hidden">+$2.00</span>
                            </div>
                        </div>

                        <!-- Price Details Card -->
                        <div class="bg-white border border-gray-200 rounded-xl p-5 shadow-sm space-y-3">
                            <h4 class="font-bold text-gray-900 text-sm pb-2 border-b border-gray-100">Price Details</h4>
                            <div class="flex justify-between text-sm text-gray-600">
                                <span>Price</span>
                                <span class="font-medium text-gray-900">$<span id="subtotal-price">699.00</span></span>
                            </div>
                            <div class="flex justify-between text-sm text-gray-600">
                                <span>Discount</span>
                                <span class="font-medium text-green-600">-$<span id="discount-amount">50.00</span></span>
                            </div>
                            <div id="gift-row" class="flex justify-between text-sm text-gray-600 hidden">
                                <span>Gift Wrap</span>
                                <span class="font-medium text-gray-900">$2.00</span>
                            </div>
                            <div class="flex justify-between text-sm text-gray-600 pb-3 border-b border-gray-100">
                                <span>Delivery Charges</span>
                                <span class="font-medium text-green-600">Free Delivery</span>
                            </div>
                            <div class="flex justify-between text-base font-bold text-gray-900 pt-1">
                                <span>Total</span>
                                <span>$<span id="total-price">649.00</span></span>
                            </div>
                        </div>

                        <!-- Proceed to Address Button -->
                        <button onclick="goToStep('address')" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3.5 rounded-xl transition shadow-md text-center block">
                            Proceed to Address
                        </button>
                    </div>
                </div>
            </div>

            <!-- ================= STEP 2: ADDRESS ================= -->
            <div id="view-address" class="checkout-view hidden">
                <h2 class="text-xl font-bold text-gray-900 mb-6">Shipping Address</h2>
                <form id="address-form" onsubmit="saveAddress(event)" class="grid grid-cols-1 md:grid-cols-2 gap-6 max-w-4xl">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Full Name</label>
                        <input type="text" id="addr-name" required value="Rwomushana Macarthy" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:border-blue-600">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Email Address</label>
                        <input type="email" id="addr-email" required value="macarthy@example.com" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:border-blue-600">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Phone Number</label>
                        <input type="tel" id="addr-phone" required value="+256 700 000000" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:border-blue-600">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">City</label>
                        <input type="text" id="addr-city" required value="Kampala" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:border-blue-600">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Street Address</label>
                        <input type="text" id="addr-street" required value="Nakawa Business Park, Plot 3" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:border-blue-600">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Postal Code</label>
                        <input type="text" id="addr-postal" required value="00256" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:border-blue-600">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Country</label>
                        <input type="text" id="addr-country" required value="Uganda" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:border-blue-600">
                    </div>

                    <div class="md:col-span-2 flex justify-between items-center mt-6">
                        <button type="button" onclick="goToStep('cart')" class="border border-gray-300 px-6 py-3 rounded-xl text-sm font-semibold text-gray-700 hover:bg-gray-50 transition">
                            Back to Cart
                        </button>
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-8 py-3 rounded-xl transition shadow-md">
                            Proceed to Payment
                        </button>
                    </div>
                </form>
            </div>

            <!-- ================= STEP 3: PAYMENT ================= -->
            <div id="view-payment" class="checkout-view hidden">
                <h2 class="text-xl font-bold text-gray-900 mb-6">Payment Method</h2>
                <div class="max-w-3xl space-y-4">
                    <!-- Credit Card Option -->
                    <label class="flex items-start space-x-4 border border-blue-600 bg-blue-50/50 p-5 rounded-xl cursor-pointer transition">
                        <input type="radio" name="paymentMethod" checked class="mt-1 text-blue-600 focus:ring-blue-500 w-4 h-4">
                        <div class="flex-1">
                            <div class="flex items-center justify-between">
                                <span class="font-bold text-gray-900 text-sm">Credit / Debit Card</span>
                                <div class="space-x-2 text-gray-500 text-lg">
                                    <i class="fa-brands fa-cc-visa text-blue-800"></i>
                                    <i class="fa-brands fa-cc-mastercard text-red-600"></i>
                                    <i class="fa-brands fa-cc-amex text-blue-500"></i>
                                </div>
                            </div>
                            <div class="mt-4 grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div class="sm:col-span-2">
                                    <label class="block text-xs font-semibold text-gray-600 mb-1">Card Number</label>
                                    <input type="text" placeholder="4532 •••• •••• 8932" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm bg-white focus:outline-none focus:border-blue-600">
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-gray-600 mb-1">Expiry Date</label>
                                    <input type="text" placeholder="MM/YY" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm bg-white focus:outline-none focus:border-blue-600">
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-gray-600 mb-1">CVV</label>
                                    <input type="password" placeholder="123" maxlength="4" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm bg-white focus:outline-none focus:border-blue-600">
                                </div>
                            </div>
                        </div>
                    </label>

                    <!-- PayPal Option -->
                    <label class="flex items-center space-x-4 border border-gray-200 bg-white p-5 rounded-xl cursor-pointer hover:border-gray-300 transition">
                        <input type="radio" name="paymentMethod" class="text-blue-600 focus:ring-blue-500 w-4 h-4">
                        <div class="flex items-center justify-between flex-1">
                            <div>
                                <span class="font-bold text-gray-900 text-sm">PayPal Account</span>
                                <p class="text-xs text-gray-500 mt-0.5">Safe and secure PayPal transaction with cashback eligibility.</p>
                            </div>
                            <i class="fa-brands fa-paypal text-2xl text-blue-700"></i>
                        </div>
                    </label>

                    <!-- Cash on Delivery -->
                    <label class="flex items-center space-x-4 border border-gray-200 bg-white p-5 rounded-xl cursor-pointer hover:border-gray-300 transition">
                        <input type="radio" name="paymentMethod" class="text-blue-600 focus:ring-blue-500 w-4 h-4">
                        <div class="flex items-center justify-between flex-1">
                            <div>
                                <span class="font-bold text-gray-900 text-sm">Cash on Delivery</span>
                                <p class="text-xs text-gray-500 mt-0.5">Pay with cash upon receipt of delivery.</p>
                            </div>
                            <i class="fa-solid fa-money-bill-wave text-2xl text-green-600"></i>
                        </div>
                    </label>

                    <div class="flex justify-between items-center pt-6">
                        <button type="button" onclick="goToStep('address')" class="border border-gray-300 px-6 py-3 rounded-xl text-sm font-semibold text-gray-700 hover:bg-gray-50 transition">
                            Back to Address
                        </button>
                        <button onclick="placeOrder()" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-8 py-3.5 rounded-xl transition shadow-md">
                            Place Order (<span id="pay-total-btn">649.00</span>)
                        </button>
                    </div>
                </div>
            </div>

            <!-- ================= STEP 4: CONFIRMATION ================= -->
            <div id="view-confirmation" class="checkout-view hidden text-center py-10 max-w-2xl mx-auto space-y-6">
                <div class="w-20 h-20 bg-green-100 text-green-600 rounded-full flex items-center justify-center mx-auto text-3xl shadow-inner">
                    <i class="fa-solid fa-check"></i>
                </div>
                <h2 class="text-2xl font-extrabold text-gray-900">Order Placed Successfully!</h2>
                <p class="text-sm text-gray-600">
                    Thank you for your purchase. We have received your order and are getting it ready for shipment. A confirmation email has been sent to your registered address.
                </p>
                <div class="bg-gray-50 border border-gray-200 rounded-xl p-6 text-left space-y-3">
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500">Order Number:</span>
                        <span class="font-bold text-gray-800">#ORD-2026-89421</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500">Shipping To:</span>
                        <span id="conf-address-text" class="font-medium text-gray-800 text-right">Nakawa Business Park, Kampala, Uganda</span>
                    </div>
                    <div class="flex justify-between text-sm pt-2 border-t border-gray-200">
                        <span class="text-gray-800 font-bold">Total Paid:</span>
                        <span class="font-extrabold text-blue-600">$<span id="conf-total">649.00</span></span>
                    </div>
                </div>
                <div class="pt-4">
                    <button onclick="resetCheckout()" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-8 py-3 rounded-xl transition shadow-md">
                        Continue Shopping
                    </button>
                </div>
            </div>

        </div>
    </div>

    <!-- JavaScript Application State & Logic -->
    <script>
        let currentStep = 'cart';
        let maxReachedStep = 'cart';

        const state = {
            items: {
                1: { price: 400, basePrice: 400, qty: 1 },
                2: { price: 299, basePrice: 299, qty: 1 }
            },
            discount: 50,
            promoApplied: false,
            giftWrap: false
        };

        function updateQty(id, delta) {
            let newQty = state.items[id].qty + delta;
            if (newQty < 1) newQty = 1;
            state.items[id].qty = newQty;
            document.getElementById(`qty-${id}`).innerText = newQty;
            
            // Recalculate price proportional to quantity
            let unitBase = id === 1 ? 400 : 299;
            document.getElementById(`price-${id}`).innerText = unitBase * newQty;
            
            calculateTotals();
        }

        function removeItem(id) {
            state.items[id].qty = 0;
            state.items[id].price = 0;
            // Hide element or zero out
            event.target.closest('.flex').remove();
            calculateTotals();
            
            let totalItems = state.items[1].qty + state.items[2].qty;
            document.getElementById('bag-item-count').innerText = totalItems;
        }

        function applyPromo() {
            const code = document.getElementById('promo-input').value.trim();
            if (code.length > 0 && !state.promoApplied) {
                state.promoApplied = true;
                state.discount += 20; // extra discount for promo
                document.getElementById('promo-message').classList.remove('hidden');
                calculateTotals();
            }
        }

        function toggleGiftWrap() {
            state.giftWrap = document.getElementById('gift-checkbox').checked;
            const giftRow = document.getElementById('gift-row');
            const giftPriceTag = document.getElementById('gift-price-tag');
            if (state.giftWrap) {
                giftRow.classList.remove('hidden');
                giftPriceTag.classList.remove('hidden');
            } else {
                giftRow.classList.add('hidden');
                giftPriceTag.classList.add('hidden');
            }
            calculateTotals();
        }

        function calculateTotals() {
            let subtotal = (state.items[1].basePrice * state.items[1].qty) + (state.items[2].basePrice * state.items[2].qty);
            let discount = state.discount;
            let giftCost = state.giftWrap ? 2 : 0;
            let total = subtotal - discount + giftCost;
            if (total < 0) total = 0;

            document.getElementById('subtotal-price').innerText = subtotal.toFixed(2);
            document.getElementById('discount-amount').innerText = discount.toFixed(2);
            document.getElementById('total-price').innerText = total.toFixed(2);
            document.getElementById('pay-total-btn').innerText = total.toFixed(2);
            document.getElementById('conf-total').innerText = total.toFixed(2);
        }

        function canAccessStep(stepName) {
            const steps = ['cart', 'address', 'payment', 'confirmation'];
            return steps.indexOf(stepName) <= steps.indexOf(maxReachedStep);
        }

        function goToStep(stepName) {
            const steps = ['cart', 'address', 'payment', 'confirmation'];
            if (steps.indexOf(stepName) > steps.indexOf(maxReachedStep)) {
                maxReachedStep = stepName;
            }
            currentStep = stepName;

            // Hide all views
            document.querySelectorAll('.checkout-view').forEach(el => el.classList.add('hidden'));
            // Show target view
            document.getElementById(`view-${stepName}`).classList.remove('hidden');

            // Update stepper visual indicators
            steps.forEach(s => {
                const ind = document.getElementById(`step-ind-${s}`);
                const circle = ind.querySelector('div');
                const label = ind.querySelector('span');

                if (steps.indexOf(s) <= steps.indexOf(stepName)) {
                    ind.style.opacity = '1';
                    circle.className = "w-12 h-12 rounded-full flex items-center justify-center bg-blue-600 text-white shadow-md mb-2 transition-all";
                    label.className = "text-sm font-semibold text-blue-600 transition-all";
                } else {
                    ind.style.opacity = '0.6';
                    circle.className = "w-12 h-12 rounded-full flex items-center justify-center bg-gray-200 text-gray-600 mb-2 transition-all";
                    label.className = "text-sm font-medium text-gray-600 transition-all";
                }
            });

            window.scrollTo({ top: 0, behavior: 'smooth' });
        }

        function saveAddress(e) {
            e.preventDefault();
            const city = document.getElementById('addr-city').value;
            const street = document.getElementById('addr-street').value;
            const country = document.getElementById('addr-country').value;
            document.getElementById('conf-address-text').innerText = `${street}, ${city}, ${country}`;
            maxReachedStep = 'payment';
            goToStep('payment');
        }

        function placeOrder() {
            maxReachedStep = 'confirmation';
            goToStep('confirmation');
        }

        function resetCheckout() {
            maxReachedStep = 'cart';
            goToStep('cart');
        }
    </script>
</body>
</html>