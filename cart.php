
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Shopping Cart | JUMIKA</title>

    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Font Awesome -->
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
    >

    <!-- Inter -->
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap"
        rel="stylesheet"
    >

<style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: #f4f5f7;
            color: #1f2937;
        }

        .checkout-container {
            width: min(1180px, 94%);
            margin: 35px auto;
        }

        .main-card {
            background: #ffffff;
            border-radius: 18px;
            box-shadow: 0 10px 35px rgba(0, 0, 0, 0.06);
            overflow: hidden;
        }

        /* HEADER */

        .top-header {
            padding: 24px 30px;
            border-bottom: 1px solid #e5e7eb;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 20px;
        }

        .brand {
            font-size: 27px;
            font-weight: 800;
            color: #1e66f6;
            letter-spacing: -1px;
        }

        .continue-shopping {
            color: #374151;
            text-decoration: none;
            font-size: 14px;
            font-weight: 600;
        }

        .continue-shopping:hover {
            color: #1e54f6;
        }

        /* STEPPER */

        .stepper {
            padding: 30px;
            border-bottom: 1px solid #e5e7eb;
        }

        .steps-wrapper {
            display: flex;
            align-items: center;
            justify-content: center;
            max-width: 850px;
            margin: auto;
        }

        .step-item {
            display: flex;
            align-items: center;
            flex: 1;
        }

        .step-item:last-child {
            flex: 0;
        }

        .step {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 8px;
            min-width: 85px;
        }

        .step-circle {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            background: #e5e7eb;
            color: #6b7280;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            transition: .25s ease;
        }

        .step-label {
            font-size: 12px;
            font-weight: 600;
            color: #9ca3af;
            white-space: nowrap;
        }

        .step-line {
            height: 2px;
            background: #e5e7eb;
            flex: 1;
            margin: 0 10px;
            margin-bottom: 25px;
            transition: .25s ease;
        }

        .step.active .step-circle,
        .step.completed .step-circle {
            background: #1e66f6;
            color: white;
        }

        .step.active .step-label,
        .step.completed .step-label {
            color: #1f2937;
        }

        .step-line.completed {
            background: #1e66f6;
        }

        /* CONTENT */

        .content {
            padding: 32px;
        }

        .view {
            display: none;
        }

        .view.active {
            display: block;
        }

        .section-title {
            font-size: 24px;
            font-weight: 800;
            color: #111827;
            margin-bottom: 7px;
        }

        .section-description {
            color: #6b7280;
            font-size: 14px;
            margin-bottom: 25px;
        }

        /* OFFERS */

        .offer-banner {
            background: #eff6ff;
            border: 1px solid #bfdbfe;
            border-radius: 12px;
            padding: 15px 18px;
            display: flex;
            align-items: center;
            gap: 12px;
            color: #1e40af;
            margin-bottom: 25px;
        }

        .offer-banner i {
            font-size: 19px;
        }

        .offer-banner strong {
            display: block;
            font-size: 14px;
        }

        .offer-banner span {
            font-size: 12px;
        }

        /* CART */

        .cart-grid {
            display: grid;
            grid-template-columns: minmax(0, 1fr) 340px;
            gap: 25px;
        }

        .cart-item {
            border: 1px solid #e5e7eb;
            border-radius: 13px;
            padding: 18px;
            display: flex;
            gap: 17px;
            align-items: center;
            margin-bottom: 14px;
            background: #fff;
        }

        .product-image {
            width: 92px;
            height: 92px;
            border-radius: 10px;
            object-fit: cover;
            background: #f3f4f6;
            flex-shrink: 0;
        }

        .product-info {
            flex: 1;
            min-width: 0;
        }

        .product-category {
            font-size: 11px;
            text-transform: uppercase;
            color: #2563eb;
            font-weight: 700;
            letter-spacing: .5px;
            margin-bottom: 4px;
        }

        .product-name {
            font-size: 16px;
            font-weight: 700;
            color: #111827;
            margin-bottom: 7px;
        }

        .product-price {
            font-size: 15px;
            font-weight: 700;
            color: #111827;
        }

        .quantity-controls {
            display: flex;
            align-items: center;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            overflow: hidden;
        }

        .quantity-controls button {
            width: 34px;
            height: 34px;
            border: 0;
            background: #f9fafb;
            cursor: pointer;
            color: #374151;
        }

        .quantity-controls button:hover {
            background: #f3f4f6;
        }

        .quantity-value {
            width: 34px;
            text-align: center;
            font-size: 13px;
            font-weight: 700;
        }

        .remove-btn {
            border: 0;
            background: transparent;
            color: #ef4444;
            cursor: pointer;
            margin-top: 8px;
            font-size: 12px;
            font-weight: 600;
        }

        .remove-btn:hover {
            text-decoration: underline;
        }

        /* SIDE CARDS */

        .side-card {
            border: 1px solid #e5e7eb;
            border-radius: 13px;
            padding: 20px;
            margin-bottom: 15px;
            background: white;
        }

        .side-card-title {
            font-size: 15px;
            font-weight: 800;
            margin-bottom: 14px;
            color: #111827;
        }

        .promo-row {
            display: flex;
            gap: 8px;
        }

        .promo-input {
            flex: 1;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            padding: 11px;
            font-size: 13px;
            outline: none;
        }

        .promo-input:focus {
            border-color: #1e5ff6;
        }

        .promo-btn {
            border: 0;
            background: #111827;
            color: white;
            border-radius: 8px;
            padding: 0 15px;
            cursor: pointer;
            font-weight: 700;
            font-size: 12px;
        }

        .gift-option {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 13px;
            cursor: pointer;
        }

        .gift-option input {
            accent-color: #1e50f6;
        }

        .price-row {
            display: flex;
            justify-content: space-between;
            gap: 15px;
            font-size: 13px;
            margin-bottom: 12px;
            color: #6b7280;
        }

        .price-row.total {
            border-top: 1px solid #e5e7eb;
            padding-top: 15px;
            margin-top: 15px;
            color: #111827;
            font-size: 17px;
            font-weight: 800;
        }

        .discount {
            color: #059669;
            font-weight: 700;
        }

        /* BUTTONS */

        .button-row {
            display: flex;
            justify-content: space-between;
            gap: 15px;
            margin-top: 30px;
        }

        .btn {
            border: 0;
            border-radius: 9px;
            padding: 13px 20px;
            cursor: pointer;
            font-size: 13px;
            font-weight: 700;
            transition: .2s ease;
        }

        .btn-primary {
            background: #1e66f6;
            color: white;
        }

        .btn-primary:hover {
            background: #1552d4;
        }

        .btn-dark {
            background: #111827;
            color: white;
        }

        .btn-dark:hover {
            background: #000;
        }

        .btn-secondary {
            background: #f3f4f6;
            color: #374151;
        }

        .btn-secondary:hover {
            background: #e5e7eb;
        }

        /* ADDRESS */

        .form-card {
            max-width: 850px;
            margin: auto;
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 18px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 7px;
        }

        .form-group.full {
            grid-column: 1 / -1;
        }

        .form-group label {
            font-size: 12px;
            font-weight: 700;
            color: #374151;
        }

        .form-group input,
        .form-group select {
            height: 45px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            padding: 0 13px;
            outline: none;
            font-size: 13px;
            background: white;
        }

        .form-group input:focus,
        .form-group select:focus {
            border-color: #1e66f6;
            box-shadow: 0 0 0 3px rgba(30, 102, 246, .12);
        }

        /* PAYMENT */

        .payment-card {
            max-width: 720px;
            margin: auto;
        }

        .payment-method {
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            padding: 17px;
            margin-bottom: 12px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 14px;
            transition: .2s ease;
        }

        .payment-method:hover {
            border-color: #1e50f6;
        }

        .payment-method.selected {
            border-color: #1e66f6;
            background: #eff6ff;
        }

        .payment-method input {
            accent-color: #1e50f6;
        }

        .payment-icon {
            width: 42px;
            height: 42px;
            border-radius: 9px;
            background: #f3f4f6;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #374151;
        }

        .payment-details strong {
            display: block;
            font-size: 14px;
            margin-bottom: 3px;
        }

        .payment-details span {
            color: #6b7280;
            font-size: 12px;
        }

        .mobile-money-box {
            display: none;
            margin-top: 15px;
            padding: 18px;
            background: #f9fafb;
            border-radius: 10px;
        }

        .mobile-money-box.active {
            display: block;
        }

        /* CONFIRMATION */

        .confirmation {
            max-width: 650px;
            margin: 20px auto;
            text-align: center;
        }

        .success-icon {
            width: 82px;
            height: 82px;
            margin: auto auto 20px;
            border-radius: 50%;
            background: #ecfdf5;
            color: #10b981;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 35px;
        }

        .confirmation h2 {
            font-size: 28px;
            font-weight: 800;
            color: #111827;
            margin-bottom: 8px;
        }

        .confirmation-text {
            color: #6b7280;
            font-size: 14px;
            line-height: 1.7;
            margin-bottom: 25px;
        }

        .confirmation-box {
            text-align: left;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            padding: 20px;
            background: #fff;
        }

        .confirmation-row {
            display: flex;
            justify-content: space-between;
            gap: 15px;
            padding: 9px 0;
            font-size: 13px;
        }

        .confirmation-row span:first-child {
            color: #6b7280;
        }

        .confirmation-row span:last-child {
            font-weight: 700;
            color: #111827;
            text-align: right;
        }

        .waiting-box {
            margin-top: 18px;
            background: #eff6ff;
            border: 1px solid #bfdbfe;
            border-radius: 10px;
            padding: 14px;
            color: #1e40af;
            font-size: 12px;
            text-align: left;
        }

        /* EMPTY */

        .empty-cart {
            text-align: center;
            padding: 70px 20px;
        }

        .empty-cart i {
            font-size: 45px;
            color: #d1d5db;
            margin-bottom: 15px;
        }

        .empty-cart h3 {
            font-size: 20px;
            font-weight: 800;
            margin-bottom: 7px;
        }

        .empty-cart p {
            color: #6b7280;
            font-size: 13px;
            margin-bottom: 20px;
        }

        /* TOAST */

        .toast {
            position: fixed;
            right: 25px;
            bottom: 25px;
            background: #111827;
            color: white;
            padding: 13px 18px;
            border-radius: 9px;
            font-size: 13px;
            font-weight: 600;
            box-shadow: 0 10px 30px rgba(0,0,0,.15);
            transform: translateY(120px);
            opacity: 0;
            transition: .3s ease;
            z-index: 9999;
        }

        .toast.show {
            transform: translateY(0);
            opacity: 1;
        }

        /* MOBILE */

        @media (max-width: 850px) {
            .cart-grid {
                grid-template-columns: 1fr;
            }

            .steps-wrapper {
                overflow-x: auto;
                justify-content: flex-start;
                padding-bottom: 5px;
            }

            .step-item {
                min-width: 145px;
            }

            .step-item:last-child {
                min-width: 90px;
            }
        }

        @media (max-width: 650px) {
            .checkout-container {
                width: 100%;
                margin: 0;
            }

            .main-card {
                border-radius: 0;
            }

            .top-header,
            .stepper,
            .content {
                padding: 20px;
            }

            .form-grid {
                grid-template-columns: 1fr;
            }

            .form-group.full {
                grid-column: auto;
            }

            .cart-item {
                align-items: flex-start;
            }

            .product-image {
                width: 72px;
                height: 72px;
            }

            .button-row {
                flex-direction: column;
            }

            .button-row .btn {
                width: 100%;
            }
        }
    </style>







 
</head>

<body>

<div class="checkout-container">

    <div class="main-card">

        <!-- HEADER -->
        <header class="top-header">
            <div class="brand">JUMIKA</div>

            <a href="index.php" class="continue-shopping">
                <i class="fa-solid fa-arrow-left"></i>
                Continue Shopping
            </a>
        </header>

        <!-- STEPPER -->
        <div class="stepper">

            <div class="steps-wrapper">

                <div class="step-item">

                    <button
                        type="button"
                        class="step"
                        id="step-cart"
                        onclick="goToStep('cart')"
                        style="border:0;background:none;cursor:pointer;"
                    >
                        <div class="step-circle">
                            <i class="fa-solid fa-cart-shopping"></i>
                        </div>

                        <div class="step-label">
                            Cart
                        </div>
                    </button>

                    <div class="step-line" id="line-cart"></div>

                </div>

                <div class="step-item">

                    <button
                        type="button"
                        class="step"
                        id="step-address"
                        onclick="goToStep('address')"
                        style="border:0;background:none;cursor:pointer;"
                    >
                        <div class="step-circle">
                            <i class="fa-solid fa-location-dot"></i>
                        </div>

                        <div class="step-label">
                            Address
                        </div>
                    </button>

                    <div class="step-line" id="line-address"></div>

                </div>

                <div class="step-item">

                    <button
                        type="button"
                        class="step"
                        id="step-payment"
                        onclick="goToStep('payment')"
                        style="border:0;background:none;cursor:pointer;"
                    >
                        <div class="step-circle">
                            <i class="fa-solid fa-credit-card"></i>
                        </div>

                        <div class="step-label">
                            Payment
                        </div>
                    </button>

                    <div class="step-line" id="line-payment"></div>

                </div>

                <div class="step-item">

                    <button
                        type="button"
                        class="step"
                        id="step-confirmation"
                        onclick="goToStep('confirmation')"
                        style="border:0;background:none;cursor:pointer;"
                    >
                        <div class="step-circle">
                            <i class="fa-solid fa-check"></i>
                        </div>

                        <div class="step-label">
                            Confirmation
                        </div>
                    </button>

                </div>

            </div>

        </div>

        <!-- CONTENT -->
        <main class="content">

            <!-- =====================================================
                 CART
            ====================================================== -->

            <section id="view-cart" class="view active">

                <h1 class="section-title">
                    Shopping Cart
                </h1>

                <p class="section-description">
                    Review your JUMIKA products before continuing.
                </p>

                <div class="offer-banner">
                    <i class="fa-solid fa-circle-check"></i>

                    <div>
                        <strong>Available Offers</strong>
                        <span>
                            Use promo code JUMIKA10 to get 10% off your order.
                        </span>
                    </div>
                </div>

                <div id="cartEmpty" class="empty-cart" style="display:none;">

                    <i class="fa-solid fa-cart-shopping"></i>

                    <h3>
                        Your cart is empty
                    </h3>

                    <p>
                        Add some products before proceeding to checkout.
                    </p>

                    <a href="index.php" class="btn btn-primary">
                        Continue Shopping
                    </a>

                </div>

                <div id="cartContent" class="cart-grid">

                    <!-- CART ITEMS -->
                    <div>

                        <div id="cartItems"></div>

                    </div>

                    <!-- SIDEBAR -->
                    <aside>

                        <!-- PROMO -->
                        <div class="side-card">

                            <div class="side-card-title">
                                Promo Code
                            </div>

                            <div class="promo-row">

                                <input
                                    type="text"
                                    id="promoCode"
                                    class="promo-input"
                                    placeholder="Enter code"
                                >

                                <button
                                    type="button"
                                    class="promo-btn"
                                    onclick="applyPromo()"
                                >
                                    Apply
                                </button>

                            </div>

                        </div>

                        <!-- GIFT -->
                        <div class="side-card">

                            <label class="gift-option">

                                <input
                                    type="checkbox"
                                    id="giftWrap"
                                    onchange="renderCart()"
                                >

                                <span>
                                    Add gift wrapping
                                    <strong>+ UGX 5,000</strong>
                                </span>

                            </label>

                        </div>

                        <!-- PRICE -->
                        <div class="side-card">

                            <div class="side-card-title">
                                Price Details
                            </div>

                            <div class="price-row">
                                <span>Subtotal</span>
                                <strong id="subtotal">UGX 0</strong>
                            </div>

                            <div class="price-row">
                                <span>Delivery</span>
                                <strong id="delivery">UGX 0</strong>
                            </div>

                            <div class="price-row">
                                <span>Discount</span>
                                <strong
                                    id="discount"
                                    class="discount"
                                >
                                    - UGX 0
                                </strong>
                            </div>

                            <div
                                class="price-row"
                                id="giftRow"
                                style="display:none;"
                            >
                                <span>Gift Wrap</span>
                                <strong>UGX 5,000</strong>
                            </div>

                            <div class="price-row total">
                                <span>Total</span>
                                <strong id="total">UGX 0</strong>
                            </div>

                        </div>

                    </aside>

                </div>

                <div
                    class="button-row"
                    id="cartButtons"
                >

                    <button
                        type="button"
                        class="btn btn-secondary"
                        onclick="window.location.href='index.php'"
                    >
                        Continue Shopping
                    </button>

                    <button
                        type="button"
                        class="btn btn-primary"
                        onclick="proceedToAddress()"
                    >
                        Proceed to Address
                        <i class="fa-solid fa-arrow-right"></i>
                    </button>

                </div>

            </section>


            <!-- =====================================================
                 ADDRESS
            ====================================================== -->

            <section id="view-address" class="view">

                <div class="form-card">

                    <h1 class="section-title">
                        Delivery Address
                    </h1>

                    <p class="section-description">
                        Enter the address where you would like your JUMIKA order delivered.
                    </p>

                    <form id="addressForm" onsubmit="saveAddress(event)">

                        <div class="form-grid">

                            <div class="form-group">
                                <label for="fullName">
                                    Full Name
                                </label>

                                <input
                                    type="text"
                                    id="fullName"
                                    required
                                    placeholder="Enter your full name"
                                >
                            </div>

                            <div class="form-group">
                                <label for="email">
                                    Email Address
                                </label>

                                <input
                                    type="email"
                                    id="email"
                                    required
                                    placeholder="you@example.com"
                                >
                            </div>

                            <div class="form-group">
                                <label for="phone">
                                    Phone Number
                                </label>

                                <input
                                    type="tel"
                                    id="phone"
                                    required
                                    placeholder="07XXXXXXXX"
                                >
                            </div>

                            <div class="form-group">
                                <label for="city">
                                    City
                                </label>

                                <input
                                    type="text"
                                    id="city"
                                    required
                                    placeholder="Kampala"
                                >
                            </div>

                            <div class="form-group full">
                                <label for="street">
                                    Street / Delivery Address
                                </label>

                                <input
                                    type="text"
                                    id="street"
                                    required
                                    placeholder="Enter your street, area or landmark"
                                >
                            </div>

                            <div class="form-group">
                                <label for="postalCode">
                                    Postal Code
                                </label>

                                <input
                                    type="text"
                                    id="postalCode"
                                    placeholder="Optional"
                                >
                            </div>

                            <div class="form-group">
                                <label for="country">
                                    Country
                                </label>

                                <select id="country" required>
                                    <option value="">
                                        Select Country
                                    </option>

                                    <option value="Uganda">
                                        Uganda
                                    </option>

                                    <option value="Kenya">
                                        Kenya
                                    </option>

                                    <option value="Tanzania">
                                        Tanzania
                                    </option>

                                    <option value="Rwanda">
                                        Rwanda
                                    </option>

                                    <option value="Other">
                                        Other
                                    </option>
                                </select>
                            </div>

                        </div>

                        <div class="button-row">

                            <button
                                type="button"
                                class="btn btn-secondary"
                                onclick="goToStep('cart')"
                            >
                                <i class="fa-solid fa-arrow-left"></i>
                                Back to Cart
                            </button>

                            <button
                                type="submit"
                                class="btn btn-primary"
                            >
                                Proceed to Payment
                                <i class="fa-solid fa-arrow-right"></i>
                            </button>

                        </div>

                    </form>

                </div>

            </section>


            <!-- =====================================================
                 PAYMENT
            ====================================================== -->

            <section id="view-payment" class="view">

                <div class="payment-card">

                    <h1 class="section-title">
                        Payment
                    </h1>

                    <p class="section-description">
                        Choose how you would like to pay for your JUMIKA order.
                    </p>

                    <!-- MOBILE MONEY -->

                    <label
                        class="payment-method"
                        id="mobileMoneyMethod"
                    >

                        <input
                            type="radio"
                            name="paymentMethod"
                            value="mobile_money"
                            onchange="selectPayment('mobile_money')"
                        >

                        <div class="payment-icon">
                            <i class="fa-solid fa-mobile-screen-button"></i>
                        </div>

                        <div class="payment-details">

                            <strong>
                                Mobile Money
                            </strong>

                            <span>
                                MTN Mobile Money or Airtel Money
                            </span>

                        </div>

                    </label>

                    <div
                        id="mobileMoneyBox"
                        class="mobile-money-box"
                    >

                        <div class="form-group">

                            <label for="mobileNumber">
                                Mobile Money Number
                            </label>

                            <input
                                type="tel"
                                id="mobileNumber"
                                placeholder="07XXXXXXXX"
                            >

                        </div>

                    </div>


                    <!-- CASH -->

                    <label
                        class="payment-method"
                        id="cashMethod"
                    >

                        <input
                            type="radio"
                            name="paymentMethod"
                            value="cash_on_delivery"
                            onchange="selectPayment('cash_on_delivery')"
                        >

                        <div class="payment-icon">
                            <i class="fa-solid fa-money-bill-wave"></i>
                        </div>

                        <div class="payment-details">

                            <strong>
                                Cash on Delivery
                            </strong>

                            <span>
                                Pay when your order is delivered.
                            </span>

                        </div>

                    </label>


                    <!-- SUMMARY -->

                    <div class="side-card" style="margin-top:25px;">

                        <div class="side-card-title">
                            Order Summary
                        </div>

                        <div class="price-row">
                            <span>Items</span>
                            <strong id="paymentItemCount">0</strong>
                        </div>

                        <div class="price-row">
                            <span>Delivery</span>
                            <strong id="paymentDelivery">
                                UGX 0
                            </strong>
                        </div>

                        <div class="price-row total">
                            <span>Total</span>
                            <strong id="paymentTotal">
                                UGX 0
                            </strong>
                        </div>

                    </div>


                    <div class="button-row">

                        <button
                            type="button"
                            class="btn btn-secondary"
                            onclick="goToStep('address')"
                        >
                            <i class="fa-solid fa-arrow-left"></i>
                            Back to Address
                        </button>

                        <button
                            type="button"
                            class="btn btn-primary"
                            onclick="placeOrder()"
                        >
                            Place Order
                            <i class="fa-solid fa-check"></i>
                        </button>

                    </div>

                </div>

            </section>


            <!-- =====================================================
                 CONFIRMATION
            ====================================================== -->

            <section id="view-confirmation" class="view">

                <div class="confirmation">

                    <div class="success-icon">
                        <i class="fa-solid fa-check"></i>
                    </div>

                    <h2>
                        Order Received
                    </h2>

                    <p class="confirmation-text">
                        Thank you for shopping with JUMIKA.
                        Your order has been received and is now waiting
                        for confirmation from our team.
                    </p>

                    <div class="confirmation-box">

                        <div class="confirmation-row">
                            <span>Order Number</span>
                            <span id="confirmationOrderNumber">
                                -
                            </span>
                        </div>

                        <div class="confirmation-row">
                            <span>Customer</span>
                            <span id="confirmationName">
                                -
                            </span>
                        </div>

                        <div class="confirmation-row">
                            <span>Phone</span>
                            <span id="confirmationPhone">
                                -
                            </span>
                        </div>

                        <div class="confirmation-row">
                            <span>Delivery Address</span>
                            <span id="confirmationAddress">
                                -
                            </span>
                        </div>

                        <div class="confirmation-row">
                            <span>Payment Method</span>
                            <span id="confirmationPayment">
                                -
                            </span>
                        </div>

                        <div class="confirmation-row">
                            <span>Total</span>
                            <span id="confirmationTotal">
                                UGX 0
                            </span>
                        </div>

                    </div>

                    <div class="waiting-box">

                        <i class="fa-solid fa-clock"></i>

                        <strong>
                            Waiting for confirmation:
                        </strong>

                        Our team will review your order and contact
                        you using the phone number provided.

                    </div>

                    <div class="button-row">

                        <button
                            type="button"
                            class="btn btn-primary"
                            onclick="window.location.href='index.php'"
                        >
                            Continue Shopping
                        </button>

                    </div>

                </div>

            </section>

        </main>

    </div>

</div>

<!-- TOAST -->
<div id="toast" class="toast"></div>


<script>

    /* ============================================================
       CART STORAGE
    ============================================================ */

    const CART_STORAGE_KEY = 'jumika_cart';

    const steps = [
        'cart',
        'address',
        'payment',
        'confirmation'
    ];

    let currentStep = 'cart';

    /*
     * This controls the furthest screen the customer has unlocked.
     *
     * 0 = Cart
     * 1 = Address
     * 2 = Payment
     * 3 = Confirmation
     */
    let maxReachedIndex = 0;

    let promoApplied = false;

    let selectedPayment = '';

    let customerAddress = {};

    let orderNumber = '';


    /* ============================================================
       CART
    ============================================================ */

    function getCart() {

        try {

            const stored = localStorage.getItem(CART_STORAGE_KEY);

            if (!stored) {
                return [];
            }

            const cart = JSON.parse(stored);

            return Array.isArray(cart) ? cart : [];

        } catch (error) {

            console.error('Cart error:', error);

            return [];

        }
    }


    function saveCart(cart) {

        localStorage.setItem(
            CART_STORAGE_KEY,
            JSON.stringify(cart)
        );

    }


    /* ============================================================
       FORMATTING
    ============================================================ */

    function formatUGX(amount) {

        return 'UGX ' + Number(amount || 0).toLocaleString('en-UG');

    }


    function escapeHTML(value) {

        if (value === null || value === undefined) {
            return '';
        }

        return String(value)
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#039;');

    }


    function getSafeQuantity(quantity) {

        const parsed = parseInt(quantity, 10);

        if (isNaN(parsed) || parsed < 1) {
            return 1;
        }

        return parsed;

    }


    /* ============================================================
       CALCULATIONS
    ============================================================ */

    function calculateSubtotal() {

        const cart = getCart();

        return cart.reduce(function(total, item) {

            const price = Number(item.price) || 0;

            const quantity = getSafeQuantity(item.quantity);

            return total + (price * quantity);

        }, 0);

    }


    function calculateItemCount() {

        const cart = getCart();

        return cart.reduce(function(total, item) {

            return total + getSafeQuantity(item.quantity);

        }, 0);

    }


    function calculateDiscount(subtotal) {

        if (!promoApplied) {
            return 0;
        }

        return Math.round(subtotal * 0.10);

    }


    function calculateGiftWrap() {

        const giftWrap =
            document.getElementById('giftWrap');

        if (!giftWrap || !giftWrap.checked) {
            return 0;
        }

        return 5000;

    }


    function calculateDelivery(subtotal) {

        /*
         * Free delivery for orders of UGX 100,000+
         * Otherwise UGX 5,000.
         */

        if (subtotal <= 0) {
            return 0;
        }

        if (subtotal >= 100000) {
            return 0;
        }

        return 5000;

    }


    function calculateTotal() {

        const subtotal = calculateSubtotal();

        const discount = calculateDiscount(subtotal);

        const delivery = calculateDelivery(subtotal);

        const gift = calculateGiftWrap();

        return Math.max(
            0,
            subtotal + delivery + gift - discount
        );

    }


    /* ============================================================
       RENDER CART
    ============================================================ */

    function renderCart() {

        const cart = getCart();

        const cartItems =
            document.getElementById('cartItems');

        const cartContent =
            document.getElementById('cartContent');

        const cartEmpty =
            document.getElementById('cartEmpty');

        const cartButtons =
            document.getElementById('cartButtons');


        if (cart.length === 0) {

            cartItems.innerHTML = '';

            cartContent.style.display = 'none';

            cartButtons.style.display = 'none';

            cartEmpty.style.display = 'block';

            updateStepUI();

            return;
        }


        cartContent.style.display = 'grid';

        cartButtons.style.display = 'flex';

        cartEmpty.style.display = 'none';


        cartItems.innerHTML = cart.map(function(item, index) {

            const name =
                escapeHTML(item.name || 'JUMIKA Product');

            const category =
                escapeHTML(item.category || 'Supplement');

            const image =
                escapeHTML(item.image || '');

            const price =
                Number(item.price) || 0;

            const quantity =
                getSafeQuantity(item.quantity);


            return `
                <div class="cart-item">

                    ${
                        image
                        ?
                        `<img
                            src="${image}"
                            alt="${name}"
                            class="product-image"
                            onerror="this.style.display='none';"
                        >`
                        :
                        `
                        <div
                            class="product-image flex items-center justify-center"
                        >
                            <i class="fa-solid fa-box text-gray-400"></i>
                        </div>
                        `
                    }

                    <div class="product-info">

                        <div class="product-category">
                            ${category}
                        </div>

                        <div class="product-name">
                            ${name}
                        </div>

                        <div class="product-price">
                            ${formatUGX(price)}
                        </div>

                        <button
                            type="button"
                            class="remove-btn"
                            onclick="removeItem(${index})"
                        >
                            <i class="fa-solid fa-trash"></i>
                            Remove
                        </button>

                    </div>

                    <div class="quantity-controls">

                        <button
                            type="button"
                            onclick="changeQuantity(${index}, -1)"
                        >
                            <i class="fa-solid fa-minus"></i>
                        </button>

                        <span class="quantity-value">
                            ${quantity}
                        </span>

                        <button
                            type="button"
                            onclick="changeQuantity(${index}, 1)"
                        >
                            <i class="fa-solid fa-plus"></i>
                        </button>

                    </div>

                </div>
            `;

        }).join('');


        const subtotal = calculateSubtotal();

        const discount = calculateDiscount(subtotal);

        const delivery = calculateDelivery(subtotal);

        const gift = calculateGiftWrap();

        const total =
            subtotal +
            delivery +
            gift -
            discount;


        document.getElementById('subtotal').textContent =
            formatUGX(subtotal);

        document.getElementById('delivery').textContent =
            delivery === 0
                ? 'FREE'
                : formatUGX(delivery);

        document.getElementById('discount').textContent =
            discount > 0
                ? '- ' + formatUGX(discount)
                : '- UGX 0';

        document.getElementById('total').textContent =
            formatUGX(total);


        const giftRow =
            document.getElementById('giftRow');

        giftRow.style.display =
            gift > 0
                ? 'flex'
                : 'none';


        updatePaymentSummary();

    }


    /* ============================================================
       QUANTITY
    ============================================================ */

    function changeQuantity(index, amount) {

        const cart = getCart();

        if (!cart[index]) {
            return;
        }

        const currentQuantity =
            getSafeQuantity(cart[index].quantity);

        const newQuantity =
            currentQuantity + amount;


        if (newQuantity <= 0) {

            cart.splice(index, 1);

        } else {

            cart[index].quantity = newQuantity;

        }


        saveCart(cart);

        renderCart();

        showToast('Cart updated');

    }


    /* ============================================================
       REMOVE ITEM
    ============================================================ */

    function removeItem(index) {

        const cart = getCart();

        if (!cart[index]) {
            return;
        }

        cart.splice(index, 1);

        saveCart(cart);

        renderCart();

        showToast('Product removed');

    }


    /* ============================================================
       PROMO
    ============================================================ */

    function applyPromo() {

        const input =
            document.getElementById('promoCode');

        const code =
            input.value.trim().toUpperCase();


        if (code === 'JUMIKA10') {

            promoApplied = true;

            renderCart();

            showToast('Promo code applied: 10% off');

        } else {

            promoApplied = false;

            renderCart();

            showToast('Invalid promo code');

        }

    }


    /* ============================================================
       STEP NAVIGATION
    ============================================================ */

    function goToStep(stepName) {

        const targetIndex =
            steps.indexOf(stepName);

        if (targetIndex === -1) {
            return;
        }


        /*
         * IMPORTANT:
         *
         * A customer can only open a screen that has already
         * been unlocked.
         *
         * Example:
         *
         * Cart = unlocked
         * Address = locked
         * Payment = locked
         * Confirmation = locked
         *
         * So clicking Payment while still on Cart does nothing.
         */

        if (targetIndex > maxReachedIndex) {

            showToast(
                'Please complete the previous step first.'
            );

            return;
        }


        currentStep = stepName;


        document.querySelectorAll('.view').forEach(function(view) {

            view.classList.remove('active');

        });


        const targetView =
            document.getElementById(
                'view-' + stepName
            );


        if (targetView) {
            targetView.classList.add('active');
        }


        updateStepUI();


        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });


        if (stepName === 'cart') {
            renderCart();
        }

        if (stepName === 'payment') {
            updatePaymentSummary();
        }

    }


    /* ============================================================
       UPDATE STEPPER
    ============================================================ */

    function updateStepUI() {

        const currentIndex =
            steps.indexOf(currentStep);


        steps.forEach(function(stepName, index) {

            const step =
                document.getElementById(
                    'step-' + stepName
                );

            if (!step) {
                return;
            }


            step.classList.remove(
                'active',
                'completed'
            );


            if (index < currentIndex) {

                step.classList.add('completed');

            } else if (index === currentIndex) {

                step.classList.add('active');

            } else if (index <= maxReachedIndex) {

                step.classList.add('completed');

            }

        });


        const lines = [
            'line-cart',
            'line-address',
            'line-payment'
        ];


        lines.forEach(function(lineId, index) {

            const line =
                document.getElementById(lineId);

            if (!line) {
                return;
            }

            line.classList.remove('completed');

            if (index < maxReachedIndex) {
                line.classList.add('completed');
            }

        });

    }


    /* ============================================================
       CART → ADDRESS
    ============================================================ */

    function proceedToAddress() {

        const cart = getCart();

        if (cart.length === 0) {

            showToast(
                'Your cart is empty.'
            );

            return;
        }


        /*
         * Unlock Address.
         */
        maxReachedIndex =
            Math.max(maxReachedIndex, 1);


        goToStep('address');

    }


    /* ============================================================
       SAVE ADDRESS → PAYMENT
    ============================================================ */

    function saveAddress(event) {

        event.preventDefault();


        const fullName =
            document.getElementById('fullName').value.trim();

        const email =
            document.getElementById('email').value.trim();

        const phone =
            document.getElementById('phone').value.trim();

        const city =
            document.getElementById('city').value.trim();

        const street =
            document.getElementById('street').value.trim();

        const postalCode =
            document.getElementById('postalCode').value.trim();

        const country =
            document.getElementById('country').value;


        if (
            !fullName ||
            !email ||
            !phone ||
            !city ||
            !street ||
            !country
        ) {

            showToast(
                'Please complete all required fields.'
            );

            return;
        }


        customerAddress = {

            fullName: fullName,

            email: email,

            phone: phone,

            city: city,

            street: street,

            postalCode: postalCode,

            country: country

        };


        /*
         * Unlock Payment.
         */
        maxReachedIndex =
            Math.max(maxReachedIndex, 2);


        goToStep('payment');

        showToast(
            'Address saved successfully'
        );

    }


    /* ============================================================
       PAYMENT
    ============================================================ */

    function selectPayment(method) {

        selectedPayment = method;


        document
            .getElementById('mobileMoneyMethod')
            .classList.remove('selected');

        document
            .getElementById('cashMethod')
            .classList.remove('selected');


        if (method === 'mobile_money') {

            document
                .getElementById('mobileMoneyMethod')
                .classList.add('selected');

            document
                .getElementById('mobileMoneyBox')
                .classList.add('active');

        } else {

            document
                .getElementById('cashMethod')
                .classList.add('selected');

            document
                .getElementById('mobileMoneyBox')
                .classList.remove('active');

        }

    }


    /* ============================================================
       PAYMENT SUMMARY
    ============================================================ */

    function updatePaymentSummary() {

        const count =
            calculateItemCount();

        const subtotal =
            calculateSubtotal();

        const delivery =
            calculateDelivery(subtotal);

        const total =
            calculateTotal();


        const countElement =
            document.getElementById(
                'paymentItemCount'
            );

        const deliveryElement =
            document.getElementById(
                'paymentDelivery'
            );

        const totalElement =
            document.getElementById(
                'paymentTotal'
            );


        if (countElement) {

            countElement.textContent =
                count;

        }


        if (deliveryElement) {

            deliveryElement.textContent =
                delivery === 0
                    ? 'FREE'
                    : formatUGX(delivery);

        }


        if (totalElement) {

            totalElement.textContent =
                formatUGX(total);

        }

    }


    /* ============================================================
       PLACE ORDER
    ============================================================ */

    function placeOrder() {

        const cart = getCart();


        if (cart.length === 0) {

            showToast(
                'Your cart is empty.'
            );

            goToStep('cart');

            return;
        }


        if (!customerAddress.fullName) {

            showToast(
                'Please complete your delivery address.'
            );

            goToStep('address');

            return;
        }


        if (!selectedPayment) {

            showToast(
                'Please select a payment method.'
            );

            return;
        }


        /*
         * If Mobile Money was selected,
         * require a phone number.
         */

        if (selectedPayment === 'mobile_money') {

            const mobileNumber =
                document
                    .getElementById('mobileNumber')
                    .value
                    .trim();


            if (!mobileNumber) {

                showToast(
                    'Please enter your Mobile Money number.'
                );

                return;
            }

        }


        /*
         * Generate order number.
         */

        const randomNumber =
            Math.floor(
                100000 +
                Math.random() * 900000
            );


        orderNumber =
            'JMK-' + randomNumber;


        /*
         * Fill confirmation screen.
         */

        document
            .getElementById(
                'confirmationOrderNumber'
            )
            .textContent = orderNumber;


        document
            .getElementById(
                'confirmationName'
            )
            .textContent =
            customerAddress.fullName;


        document
            .getElementById(
                'confirmationPhone'
            )
            .textContent =
            customerAddress.phone;


        document
            .getElementById(
                'confirmationAddress'
            )
            .textContent =
            customerAddress.street +
            ', ' +
            customerAddress.city +
            ', ' +
            customerAddress.country;


        document
            .getElementById(
                'confirmationPayment'
            )
            .textContent =
            selectedPayment === 'mobile_money'
                ? 'Mobile Money'
                : 'Cash on Delivery';


        document
            .getElementById(
                'confirmationTotal'
            )
            .textContent =
            formatUGX(calculateTotal());


        /*
         * Unlock Confirmation.
         */
        maxReachedIndex =
            Math.max(maxReachedIndex, 3);


        /*
         * Move to confirmation.
         */
        goToStep('confirmation');


        /*
         * Clear cart after order has been submitted.
         */
        localStorage.removeItem(
            CART_STORAGE_KEY
        );


        showToast(
            'Order submitted successfully'
        );

    }


    /* ============================================================
       TOAST
    ============================================================ */

    function showToast(message) {

        const toast =
            document.getElementById('toast');

        toast.textContent = message;

        toast.classList.add('show');


        setTimeout(function() {

            toast.classList.remove('show');

        }, 3000);

    }


    /* ============================================================
       INITIAL LOAD
    ============================================================ */

    document.addEventListener(
        'DOMContentLoaded',
        function() {

            /*
             * Always start at Cart.
             */
            currentStep = 'cart';

            maxReachedIndex = 0;

            renderCart();

            updateStepUI();

        }
    );

</script>

</body>
</html>
