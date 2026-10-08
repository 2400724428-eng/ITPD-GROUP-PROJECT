<!-- FontAwesome CDN for Icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link rel="stylesheet" href="assets/css/contact.css">

<!-- Pure White & Blue UI Upgrade Styling -->
<style>
  .support-page {
    background-color: #ffffff;
    font-family: ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
    color: #1e293b;
    padding: 40px 20px;
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
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.02), 0 2px 4px -1px rgba(0, 0, 0, 0.01);
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
  }
  .contact-layout {
    display: grid;
    grid-template-columns: 1fr 380px;
    gap: 32px;
  }
  @media (max-width: 768px) {
    .contact-layout {
      grid-template-columns: 1fr;
    }
  }
  .support-section {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 16px;
    padding: 32px;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.02);
  }
  .support-section h2 {
    font-size: 18px;
    font-weight: 700;
    color: #0f172a;
    margin-bottom: 8px;
  }
  .support-section p {
    font-size: 13px;
    color: #64748b;
  }
  .form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 16px;
  }
  @media (max-width: 500px) {
    .form-row {
      grid-template-columns: 1fr;
    }
  }
  .form-group {
    margin-bottom: 20px;
  }
  .form-group label {
    display: block;
    font-size: 12px;
    font-weight: 600;
    color: #334155;
    margin-bottom: 6px;
  }
  .form-group input,
  .form-group select,
  .form-group textarea {
    width: 100%;
    background: #f8fafc;
    border: 1px solid #cbd5e1;
    border-radius: 8px;
    padding: 10px 14px;
    font-size: 13px;
    color: #0f172a;
    outline: none;
    transition: all 0.2s;
  }
  .form-group input:focus,
  .form-group select:focus,
  .form-group textarea:focus {
    border-color: #2563eb;
    background: #ffffff;
    box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
  }
  .form-group textarea {
    resize: vertical;
    min-height: 120px;
  }
  .form-note {
    font-size: 11px;
    color: #64748b;
    margin-bottom: 20px;
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
    cursor: pointer;
    transition: background-color 0.2s;
    width: 100%;
    justify-content: center;
  }
  .support-button:hover {
    background-color: #1d4ed8;
  }
  .contact-method {
    display: flex;
    align-items: flex-start;
    gap: 14px;
    padding: 14px 0;
    border-bottom: 1px solid #f1f5f9;
  }
  .contact-method:last-child {
    border-bottom: none;
  }
  .contact-method i {
    font-size: 18px;
    color: #2563eb;
    margin-top: 2px;
  }
  .contact-method strong {
    display: block;
    font-size: 13px;
    color: #0f172a;
  }
  .contact-method a, .contact-method span {
    font-size: 12px;
    color: #475569;
    text-decoration: none;
  }
  .contact-method a:hover {
    color: #2563eb;
    text-decoration: underline;
  }
  .legal-callout {
    background: #eff6ff;
    border-left: 4px solid #2563eb;
    color: #1e3a8a;
    padding: 14px;
    border-radius: 6px;
    font-size: 12px;
    margin-top: 20px;
    line-height: 1.4;
  }
  .status-strip {
    background: #eff6ff;
    color: #1e40af;
    border: 1px solid #bfdbfe;
    padding: 12px;
    border-radius: 8px;
    font-size: 12px;
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 20px;
  }
</style>

<main class="support-page">
<div class="support-container">

    <div class="support-breadcrumb"><a href="index.php">Home</a> &nbsp;›&nbsp; Contact Us</div>

    <section class="support-hero">
        <span class="eyebrow"><i class="fa-solid fa-headset"></i> Pure Gain Support</span>
        <h1>Contact us</h1>
        <p>Tell us what went wrong or what you need help with. For guests, the form hands your request to official Pure Gain WhatsApp support.</p>
    </section>

    <div class="contact-layout">

        <section class="support-section">
            <h2>Send a support request</h2>
            <p style="margin-bottom:20px;">Please provide enough detail for the support team to understand the issue.</p>

            <div class="status-strip">
                <i class="fa-solid fa-circle-check" style="font-size: 16px;"></i>
                <span>Your support request has been recorded successfully.</span>
            </div>

            <form class="support-form" method="POST" action="contact.php">

                <div class="form-row">
                    <div class="form-group">
                        <label for="name">Full name *</label>
                        <input id="name" name="name" type="text" maxlength="100" placeholder="e.g. Daniel Bwanika" required value="<?= htmlspecialchars($_POST['name'] ?? '') ?>">
                    </div>

                    <div class="form-group">
                        <label for="email">Email address *</label>
                        <input id="email" name="email" type="email" maxlength="150" placeholder="you@example.com" required value="">
                    </div>
                </div>

                <div class="form-group">
                    <label for="issue">What can we help with? *</label>
                    <select id="issue" name="issue" required>
                        <option value="">Select an issue</option>
                        <option value="order">Order Delivery & Tracking</option>
                        <option value="product">Product Authenticity & Quality</option>
                        <option value="payment">Payment & Billing</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="message">Message *</label>
                    <textarea id="message" name="message" maxlength="3000" placeholder="Include your order reference and describe the issue..." required><?= htmlspecialchars($_POST['message'] ?? '') ?></textarea>
                </div>

                <p class="form-note">
                    Do not include passwords, card PINs or other unnecessary sensitive information.
                </p>

                <button class="support-button" type="submit">
                    <i class="fa-solid fa-paper-plane"></i>
                    Submit Support Request
                </button>
            </form>
        </section>

        <aside class="support-section">
            <h2>Other ways to reach us</h2>

            <div class="contact-method">
                <i class="fa-brands fa-whatsapp"></i>
                <div>
                    <strong>WhatsApp</strong>
                    <a href="https://wa.me/256761448094?text=Hello%20Pure%20Gain%2C%20I%20need%20customer%20support." target="_blank" rel="noopener">Chat with Pure Gain support</a>
                </div>
            </div>

            <div class="contact-method">
                <i class="fa-solid fa-circle-question"></i>
                <div>
                    <strong>Help Centre</strong>
                    <a href="help-desk.php">View support options</a>
                </div>
            </div>

            <div class="contact-method">
                <i class="fa-solid fa-list-check"></i>
                <div>
                    <strong>FAQs</strong>
                    <a href="faq.php">Find a quick answer</a>
                </div>
            </div>

            <div class="contact-method">
                <i class="fa-solid fa-location-dot"></i>
                <div>
                    <strong>Service area</strong>
                    <span>Kampala and surrounding delivery areas</span>
                </div>
            </div>

            <div class="legal-callout">
                <strong>Authenticity complaint?</strong><br>
                Keep the product packaging, order reference, batch number and expiry information available when contacting support.
            </div>
        </aside>

    </div>

</div>
</main>