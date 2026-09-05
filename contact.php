<?php
session_start();

$pageTitle = 'Contact Us | Pure Gain';
$submitted = false;
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $issue = trim($_POST['issue'] ?? '');
    $message = trim($_POST['message'] ?? '');

    if ($name === '' || $email === '' || $issue === '' || $message === '') {
        $error = 'Please complete all required fields.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Please enter a valid email address.';
    } elseif (strlen($message) < 10) {
        $error = 'Please provide a little more detail so we can help you.';
    } else {
        if (isset($_SESSION['user_id']) && is_numeric($_SESSION['user_id'])) {
            try {
                require __DIR__ . '/includes/db_connect.php';
                $stmt = $conn->prepare(
                    "INSERT INTO messages (user_id, subject, body)
                     VALUES (:user_id, :subject, :body)"
                );
                $stmt->execute([
                    ':user_id' => (int) $_SESSION['user_id'],
                    ':subject' => $issue,
                    ':body' => "Customer: {$name}\nEmail: {$email}\n\n{$message}"
                ]);
                $submitted = true;
            } catch (PDOException $e) {
                error_log('Pure Gain support ticket error: ' . $e->getMessage());
                $error = 'Your request could not be saved right now. Please use WhatsApp support instead.';
            }
        } else {
            $waText = "Hello Pure Gain, I need support.\nName: {$name}\nEmail: {$email}\nIssue: {$issue}\n\n{$message}";
            header('Location: https://wa.me/256761448094?text=' . rawurlencode($waText));
            exit;
        }
    }
}

require __DIR__ . '/includes/header.php';
?>

<!-- FontAwesome CDN for Icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<link rel="stylesheet" href="assets/css/contact.css">

<!-- Custom White & Orange Page Styling -->


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
            <p style="margin-bottom:18px;">Please provide enough detail for the support team to understand the issue.</p>

            <?php if ($submitted): ?>
                <div class="status-strip" style="margin:0 0 18px;">
                    <i class="fa-solid fa-circle-check"></i>
                    <span>Your support request has been recorded successfully.</span>
                </div>
            <?php endif; ?>

            <?php if ($error): ?>
                <div style="background:#fff1ef;border:1px solid #f0c8c1;color:#8d3327;padding:12px;border-radius:6px;font-size:12px;margin-bottom:16px;">
                    <i class="fa-solid fa-triangle-exclamation"></i>
                    <?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>

            <form class="support-form" method="POST" action="contact.php">

                <div class="form-row">
                    <div class="form-group">
                        <label for="name">Full name *</label>
                        <input id="name" name="name" type="text" maxlength="100" placeholder="e.g. Daniel Bwanika" required value="<?= htmlspecialchars($_POST['name'] ?? '') ?>">
                    </div>

                    <div class="form-group">
                        <label for="email">Email address *</label>
                        <input id="email" name="email" type="email" maxlength="150" placeholder="you@example.com" required value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
                    </div>
                </div>

                <div class="form-group">
                    <label for="issue">What can we help with? *</label>
                    <select id="issue" name="issue" required>
                        <option value="">Select an issue</option>
                        <?php
                        $issues = ['Order problem','Payment problem','Delivery','Return / Refund','Product authenticity','Vendor complaint','Account','Other'];
                        foreach ($issues as $item):
                        ?>
                            <option value="<?= htmlspecialchars($item) ?>" <?= (($_POST['issue'] ?? '') === $item) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($item) ?>
                            </option>
                        <?php endforeach; ?>
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

<?php require __DIR__ . '/includes/footer.php'; ?>