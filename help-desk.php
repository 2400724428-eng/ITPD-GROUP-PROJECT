<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>How to Order</title>
    <!-- Font Awesome CDN Link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Custom Pure White & Blue UI Upgrade Styling -->
    <style>
      body {
        background-color: #ffffff;
        font-family: ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
        color: #1e293b;
        margin: 0;
      }
      .support-page {
        padding: 40px 20px;
        background-color: #ffffff;
      }
      .support-container {
        max-width: 1100px;
        margin: 0 auto;
      }
      .support-breadcrumb {
        font-size: 13px;
        color: #64748b;
        margin-bottom: 24px;
      }
      .support-breadcrumb a {
        color: #2563eb;
        text-decoration: none;
      }
      .support-breadcrumb a:hover {
        text-decoration: underline;
      }
      .support-hero {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        padding: 40px;
        margin-bottom: 32px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.02);
      }
      .support-hero .eyebrow {
        color: #2563eb;
        background: #eff6ff;
        padding: 6px 14px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 8px;
      }
      .support-hero h1 {
        font-size: 28px;
        font-weight: 800;
        color: #0f172a;
        margin-top: 14px;
        margin-bottom: 8px;
      }
      .support-hero p {
        font-size: 14px;
        color: #475569;
        line-height: 1.5;
        max-width: 700px;
        margin: 0;
      }
      .support-section {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        padding: 32px;
        margin-bottom: 32px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.02);
      }
      .support-section h2 {
        font-size: 18px;
        font-weight: 700;
        color: #0f172a;
        margin-bottom: 6px;
      }
      .support-section > p {
        font-size: 13px;
        color: #64748b;
        margin-bottom: 24px;
      }
      .order-steps {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 20px;
      }
      .order-step {
        display: flex;
        gap: 16px;
        background: #ffffff;
        border: 1px solid #e2e8f0;
        padding: 20px;
        border-radius: 12px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.01);
      }
      .step-number {
        width: 32px;
        height: 32px;
        background: #eff6ff;
        color: #2563eb;
        font-weight: 700;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
      }
      .order-step h3 {
        font-size: 15px;
        font-weight: 700;
        color: #0f172a;
        margin-bottom: 4px;
        margin-top: 0;
      }
      .order-step p {
        font-size: 13px;
        color: #64748b;
        line-height: 1.4;
        margin: 0;
      }
      .whatsapp-panel {
        background: #ffffff;
        border: 1px solid #e2e8f0;
      }
      .whatsapp-panel h2 i {
        color: #16a34a;
        margin-right: 6px;
      }
      .support-feature-list {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 20px;
      }
      .support-feature {
        display: flex;
        gap: 12px;
        align-items: flex-start;
      }
      .support-feature i {
        font-size: 16px;
        color: #16a34a;
        margin-top: 2px;
      }
      .support-feature strong {
        display: block;
        font-size: 13px;
        color: #0f172a;
        margin-bottom: 2px;
      }
      .support-feature span {
        font-size: 12px;
        color: #64748b;
        line-height: 1.4;
      }
      .support-actions {
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
        margin-top: 20px;
      }
      .support-button {
        background-color: #2563eb;
        color: #ffffff;
        border: none;
        border-radius: 8px;
        padding: 12px 20px;
        font-size: 13px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        text-decoration: none;
        transition: background-color 0.2s;
      }
      .support-button:hover {
        background-color: #1d4ed8;
      }
      .support-button.whatsapp {
        background-color: #16a34a;
      }
      .support-button.whatsapp:hover {
        background-color: #15803d;
      }
      .support-button.secondary {
        background-color: #ffffff;
        color: #2563eb;
        border: 1px solid #cbd5e1;
      }
      .support-button.secondary:hover {
        background-color: #f8fafc;
      }
    </style>
</head>
<body>

<main class="support-page">
<div class="support-container">

    <div class="support-breadcrumb"><a href="index.php">Home</a> &nbsp;›&nbsp; <a href="help-desk.php">Help Centre</a> &nbsp;›&nbsp; How to Order</div>

    <section class="support-hero">
        <span class="eyebrow"><i class="fa-solid fa-cart-shopping"></i> Shopping Guide</span>
        <h1>How to order from Pure Gain</h1>
        <p>
            Placing an order takes a few minutes. Here's exactly what happens
            from the moment you find a product to the moment it's on its way to you.
        </p>
    </section>

    <section class="support-section">
        <h2>The ordering process</h2>
        <p>Six steps, start to finish.</p>

        <div class="order-steps">

            <div class="order-step">
                <div class="step-number">1</div>
                <div>
                    <h3>Browse the shop</h3>
                    <p>Proteins, creatine, pre-workout, mass gainers, vitamins, snacks, accessories — filter by category or use the search bar to jump straight to what you need.</p>
                </div>
            </div>

            <div class="order-step">
                <div class="step-number">2</div>
                <div>
                    <h3>Check the product page</h3>
                    <p>Brand, flavour or variant, price and current stock are all listed before you add anything to your cart — worth a quick read, especially for flavour and size.</p>
                </div>
            </div>

            <div class="order-step">
                <div class="step-number">3</div>
                <div>
                    <h3>Add it to your cart</h3>
                    <p>Set the quantity and carry on shopping, or head straight to your cart to double-check what you've picked.</p>
                </div>
            </div>

            <div class="order-step">
                <div class="step-number">4</div>
                <div>
                    <h3>Go to checkout</h3>
                    <p>Enter your delivery details and give the order total one last look before you confirm.</p>
                </div>
            </div>

            <div class="order-step">
                <div class="step-number">5</div>
                <div>
                    <h3>Confirm on WhatsApp</h3>
                    <p>We hand the order straight to WhatsApp with your order number and a summary attached, so you can confirm it's correct in one message.</p>
                </div>
            </div>

            <div class="order-step">
                <div class="step-number">6</div>
                <div>
                    <h3>Sit back for delivery</h3>
                    <p>Confirm your Kampala drop-off point and we'll take it from there — our team will send payment instructions and a delivery estimate on WhatsApp.</p>
                </div>
            </div>

        </div>
    </section>

    <section class="support-section whatsapp-panel">
        <h2><i class="fa-brands fa-whatsapp"></i> Why we use WhatsApp for checkout</h2>
        <p>
            It's the fastest way for our team to confirm stock, agree a delivery
            time and answer questions in real time — no back-and-forth over email.
            You'll get an order number and a summary of what you're paying before
            anything is confirmed, so take a moment to check it's right.
        </p>

        <div class="support-actions">
            <a class="support-button whatsapp" href="https://wa.me/256761448094?text=Hello%20Pure%20Gain%2C%20I%20need%20help%20with%20an%20order." target="_blank" rel="noopener">
                <i class="fa-brands fa-whatsapp"></i> Chat on WhatsApp
            </a>
            <a class="support-button secondary" href="cart.php">
                <i class="fa-solid fa-basket-shopping"></i> View Cart
            </a>
        </div>
    </section>

    <section class="support-section">
        <h2>Before you pay, a quick gut check</h2>

        <div class="support-feature-list">
            <div class="support-feature"><i class="fa-solid fa-check"></i><div><strong>Totals match</strong><span>Products, quantities and the amount due should all line up with what you ordered.</span></div></div>
            <div class="support-feature"><i class="fa-solid fa-check"></i><div><strong>Verified vendor</strong><span>Look for the verified badge — it means the seller has been through our checks.</span></div></div>
            <div class="support-feature"><i class="fa-solid fa-check"></i><div><strong>Official channels only</strong><span>We'll never ask you to pay a private number outside the confirmed checkout flow.</span></div></div>
            <div class="support-feature"><i class="fa-solid fa-check"></i><div><strong>Keep your order number</strong><span>Hang on to it until your delivery arrives — it's the fastest way for us to help if anything comes up.</span></div></div>
        </div>
    </section>

</div>
</main>

</body>
</html>