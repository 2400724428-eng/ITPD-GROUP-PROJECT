<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FAQs | Pure Gain</title>
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
      .faq-list {
        display: flex;
        flex-direction: column;
        gap: 16px;
      }
      .faq-item {
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        background: #ffffff;
        overflow: hidden;
        transition: border-color 0.2s;
      }
      .faq-item[open] {
        border-color: #cbd5e1;
        box-shadow: 0 4px 6px -1px rgba(37, 99, 235, 0.03);
      }
      .faq-item summary {
        font-size: 15px;
        font-weight: 700;
        color: #0f172a;
        padding: 18px 20px;
        cursor: pointer;
        outline: none;
        list-style: none;
        display: flex;
        align-items: center;
        justify-content: space-between;
      }
      .faq-item summary::-webkit-details-marker {
        display: none;
      }
      .faq-item summary::after {
        content: "\f078";
        font-family: "Font Awesome 6 Free";
        font-weight: 900;
        font-size: 12px;
        color: #2563eb;
        transition: transform 0.2s;
      }
      .faq-item[open] summary::after {
        transform: rotate(180deg);
      }
      .faq-answer {
        font-size: 13px;
        color: #475569;
        line-height: 1.5;
        padding: 0 20px 20px 20px;
        border-top: 1px solid #f1f5f9;
        margin-top: 0;
        padding-top: 14px;
      }
      .status-strip {
        background: #eff6ff;
        color: #1e40af;
        border: 1px solid #bfdbfe;
        padding: 12px 16px;
        border-radius: 8px;
        font-size: 12px;
        display: flex;
        align-items: center;
        gap: 10px;
        margin-top: 16px;
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
    </style>
</head>
<body>

<main class="support-page">
<div class="support-container">

    <div class="support-breadcrumb"><a href="index.php">Home</a> &nbsp;›&nbsp; <a href="help-desk.php">Help Centre</a> &nbsp;›&nbsp; FAQs</div>

    <section class="support-hero">
        <span class="eyebrow"><i class="fa-solid fa-circle-question"></i> Frequently Asked Questions</span>
        <h1>Questions, answered.</h1>
        <p>The most common questions we get about shopping, authenticity, vendors, delivery, payments and returns.</p>
    </section>

    <section class="support-section">
        <div class="faq-list">

            <details class="faq-item" open>
                <summary>Are the supplements sold on Pure Gain authentic?</summary>
                <div class="faq-answer">
                    Yes — every vendor on Pure Gain goes through a verification check before they can list products. That said, we always recommend checking the packaging, seal, batch number and expiry date when your order arrives. If anything looks off, tell us straight away and we'll sort it out.
                </div>
            </details>

            <details class="faq-item">
                <summary>How does vendor verification work?</summary>
                <div class="faq-answer">
                    Vendors submit their business details and information on where their products come from, and our team reviews it before approving them to sell. A vendor's status shows as Pending, Verified, Rejected or Suspended. It's a strong filter, not a guarantee — we still rely on customers to flag anything unusual.
                </div>
            </details>

            <details class="faq-item">
                <summary>What should I do if I suspect a product is counterfeit?</summary>
                <div class="faq-answer">
                    Stop using it and get in touch with us right away. Hang on to the packaging and send us your order reference along with photos — the batch number, expiry date and seal are the most useful details.
                </div>
            </details>

            <details class="faq-item">
                <summary>How do I place an order?</summary>
                <div class="faq-answer">
                    Pick a product, choose the size or flavour you want, add it to your cart, then head to checkout. From there we hand things over to WhatsApp so you can confirm the order and delivery details with our team directly.
                </div>
            </details>

            <details class="faq-item">
                <summary>Why does Pure Gain use WhatsApp for checkout?</summary>
                <div class="faq-answer">
                    It's simply the quickest way for us to confirm stock and delivery in real time rather than waiting on email back-and-forth. You'll always see your order reference and the full order summary before anything is finalised.
                </div>
            </details>

            <details class="faq-item">
                <summary>Where does Pure Gain deliver?</summary>
                <div class="faq-answer">
                    Kampala and the surrounding areas for now. Delivery time and cost can vary a bit depending on exactly where you are and what's happening on the road that day — our team will confirm both once your order is in.
                </div>
            </details>

            <details class="faq-item">
                <summary>How long does delivery take?</summary>
                <div class="faq-answer">
                    Most orders within Kampala go out the same day or the next. It depends on stock and your location, so we'll always give you a realistic time frame when we confirm your order on WhatsApp.
                </div>
            </details>

            <details class="faq-item">
                <summary>What payment methods are available?</summary>
                <div class="faq-answer">
                    You'll get official payment instructions when your order is confirmed. One rule that matters: Pure Gain will never ask you to send money to a personal or unlisted number. If that happens, don't pay — report it to us instead.
                </div>
            </details>

            <details class="faq-item">
                <summary>Can I return a supplement?</summary>
                <div class="faq-answer">
                    It depends on the condition of the item and why you're returning it. Because supplements are consumable, we generally can't accept opened or used products back — but if something arrived wrong, damaged, or you suspect it isn't genuine, contact us straight away and we'll work it through with you.
                </div>
            </details>

            <details class="faq-item">
                <summary>What happens when a vendor receives serious complaints?</summary>
                <div class="faq-answer">
                    We look into it — checking the order history, the product listing and any evidence provided. If a vendor has broken marketplace rules, we can restrict or suspend their account while the matter is investigated further.
                </div>
            </details>

            <details class="faq-item">
                <summary>How can I contact Pure Gain?</summary>
                <div class="faq-answer">
                    The Contact Us page is the best place to send a detailed support request, or message us directly on WhatsApp for anything that needs a quick answer.
                </div>
            </details>

        </div>
    </section>

    <section class="support-section" id="authenticity">
        <h2><i class="fa-solid fa-shield-halved" style="color:#2563eb;"></i> Our authenticity promise</h2>
        <p>
            Every vendor selling on Pure Gain is checked before they're approved, and we
            take customer reports seriously. It's a real safeguard, but it isn't a
            substitute for reading the label — we'd still ask you to check the packaging
            when your order arrives.
        </p>
        <div class="status-strip">
            <i class="fa-solid fa-circle-check"></i>
            <span>Spotted something suspicious, damaged, expired or tampered with? Tell us as soon as you can.</span>
        </div>
    </section>

    <section class="support-section" id="delivery">
        <h2>Delivery information</h2>
        <p>
            We confirm delivery details based on your location, stock availability and
            what you've ordered. Double-check that your phone number and Kampala
            delivery address are correct at checkout — it's the most common reason for delays.
        </p>
    </section>

    <section class="support-section" id="returns">
        <h2>Returns &amp; refunds</h2>
        <p>
            If something arrives wrong, damaged or you think it might be counterfeit,
            get in touch straight away and hold on to the packaging and your order
            reference. Because supplements are consumable, we generally can't take
            back items that have already been opened or used.
        </p>
        <div class="support-actions">
            <a class="support-button" href="contact.php"><i class="fa-solid fa-rotate-left"></i> Request assistance</a>
        </div>
    </section>

</div>
</main>

</body>
</html>