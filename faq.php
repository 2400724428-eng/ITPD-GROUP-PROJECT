<?php
$pageTitle = 'FAQs | JUMIKA';

$faqs = [
    [
        'q' => 'Are the supplements sold on JUMIKA authentic?',
        'a' => 'Yes — every vendor on JUMIKA goes through a verification check before they can list products. That said, we always recommend checking the packaging, seal, batch number and expiry date when your order arrives. If anything looks off, tell us straight away and we\'ll sort it out.'
    ],
    [
        'q' => 'How does vendor verification work?',
        'a' => 'Vendors submit their business details and information on where their products come from, and our team reviews it before approving them to sell. A vendor\'s status shows as Pending, Verified, Rejected or Suspended. It\'s a strong filter, not a guarantee — we still rely on customers to flag anything unusual.'
    ],
    [
        'q' => 'What should I do if I suspect a product is counterfeit?',
        'a' => 'Stop using it and get in touch with us right away. Hang on to the packaging and send us your order reference along with photos — the batch number, expiry date and seal are the most useful details.'
    ],
    [
        'q' => 'How do I place an order?',
        'a' => 'Pick a product, choose the size or flavour you want, add it to your cart, then head to checkout. From there we hand things over to WhatsApp so you can confirm the order and delivery details with our team directly.'
    ],
    [
        'q' => 'Why does JUMIKA use WhatsApp for checkout?',
        'a' => 'It\'s simply the quickest way for us to confirm stock and delivery in real time rather than waiting on email back-and-forth. You\'ll always see your order reference and the full order summary before anything is finalised.'
    ],
    [
        'q' => 'Where does JUMIKA deliver?',
        'a' => 'Kampala and the surrounding areas for now. Delivery time and cost can vary a bit depending on exactly where you are and what\'s happening on the road that day — our team will confirm both once your order is in.'
    ],
    [
        'q' => 'How long does delivery take?',
        'a' => 'Most orders within Kampala go out the same day or the next. It depends on stock and your location, so we\'ll always give you a realistic time frame when we confirm your order on WhatsApp.'
    ],
    [
        'q' => 'What payment methods are available?',
        'a' => 'You\'ll get official payment instructions when your order is confirmed. One rule that matters: JUMIKA will never ask you to send money to a personal or unlisted number. If that happens, don\'t pay — report it to us instead.'
    ],
    [
        'q' => 'Can I return a supplement?',
        'a' => 'It depends on the condition of the item and why you\'re returning it. Because supplements are consumable, we generally can\'t accept opened or used products back — but if something arrived wrong, damaged, or you suspect it isn\'t genuine, contact us straight away and we\'ll work it through with you.'
    ],
    [
        'q' => 'What happens when a vendor receives serious complaints?',
        'a' => 'We look into it — checking the order history, the product listing and any evidence provided. If a vendor has broken marketplace rules, we can restrict or suspend their account while the matter is investigated further.'
    ],
    [
        'q' => 'How can I contact JUMIKA?',
        'a' => 'The Contact Us page is the best place to send a detailed support request, or message us directly on WhatsApp for anything that needs a quick answer.'
    ]
];

require __DIR__ . '/includes/header.php';
?>

<!-- Font Awesome CDN Link -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<link rel="stylesheet" href="assets/css/faq.css">

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
            <?php foreach ($faqs as $index => $faq): ?>
                <details class="faq-item" <?= $index === 0 ? 'open' : '' ?>>
                    <summary>
                        <?= htmlspecialchars($faq['q']) ?>
                    </summary>
                    <div class="faq-answer">
                        <?= nl2br(htmlspecialchars($faq['a'])) ?>
                    </div>
                </details>
            <?php endforeach; ?>
        </div>
    </section>

    <section class="support-section" id="authenticity">
        <h2><i class="fa-solid fa-shield-halved" style="color:#f68b1e;"></i> Our authenticity promise</h2>
        <p>
            Every vendor selling on JUMIKA is checked before they're approved, and we
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

<?php require __DIR__ . '/includes/footer.php'; ?>

