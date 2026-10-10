<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FAQs | Pure Gain</title>
    <!-- Font Awesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: {
                            50: '#eff6ff',
                            100: '#dbeafe',
                            500: '#3b82f6',
                            600: '#2563eb',
                            700: '#1d4ed8',
                        }
                    }
                }
            }
        }
    </script>
    <style>
        /* Details summary disclosure arrow animation */
        details summary::-webkit-details-marker { display: none; }
        details summary::after {
            content: "\f078";
            font-family: "Font Awesome 6 Free";
            font-weight: 900;
            font-size: 12px;
            color: #2563eb;
            transition: transform 0.2s ease;
        }
        details[open] summary::after {
            transform: rotate(180deg);
        }
    </style>
</head>
<body class="bg-white text-slate-800 font-sans antialiased min-h-screen py-10 px-4 sm:px-6 lg:px-8">

<main class="max-w-[1100px] mx-auto space-y-8">



    <!-- Hero Section -->
    <section class="bg-white border border-slate-200 rounded-2xl p-6 sm:p-10 shadow-sm">
        <span class="inline-flex items-center gap-2 text-xs font-semibold text-blue-600 bg-blue-50 px-3 py-1.5 rounded-full border border-blue-100">
            <i class="fa-solid fa-circle-question"></i> Frequently Asked Questions
        </span>
        <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 mt-4 mb-2 tracking-tight">Questions, answered.</h1>
        <p class="text-xs sm:text-sm text-slate-600 max-w-2xl leading-relaxed">
            The most common questions we get about shopping, authenticity, vendors, delivery, payments and returns.
        </p>
    </section>

    <!-- FAQ List Section -->
    <section class="bg-white border border-slate-200 rounded-2xl p-6 sm:p-8 shadow-sm">
        <div class="space-y-4">

            <details class="group border border-slate-200 rounded-xl bg-white overflow-hidden transition-all open:border-slate-300 open:shadow-sm" open>
                <summary class="flex items-center justify-between p-4 sm:p-5 font-bold text-slate-900 text-sm sm:text-base cursor-pointer select-none">
                    Are the supplements sold on Pure Gain authentic?
                </summary>
                <div class="px-4 sm:px-5 pb-5 pt-3 border-t border-slate-100 text-xs sm:text-sm text-slate-600 leading-relaxed">
                    Yes — every vendor on Pure Gain goes through a verification check before they can list products. That said, we always recommend checking the packaging, seal, batch number and expiry date when your order arrives. If anything looks off, tell us straight away and we'll sort it out.
                </div>
            </details>

            <details class="group border border-slate-200 rounded-xl bg-white overflow-hidden transition-all open:border-slate-300 open:shadow-sm">
                <summary class="flex items-center justify-between p-4 sm:p-5 font-bold text-slate-900 text-sm sm:text-base cursor-pointer select-none">
                    How does vendor verification work?
                </summary>
                <div class="px-4 sm:px-5 pb-5 pt-3 border-t border-slate-100 text-xs sm:text-sm text-slate-600 leading-relaxed">
                    Vendors submit their business details and information on where their products come from, and our team reviews it before approving them to sell. A vendor's status shows as Pending, Verified, Rejected or Suspended. It's a strong filter, not a guarantee — we still rely on customers to flag anything unusual.
                </div>
            </details>

            <details class="group border border-slate-200 rounded-xl bg-white overflow-hidden transition-all open:border-slate-300 open:shadow-sm">
                <summary class="flex items-center justify-between p-4 sm:p-5 font-bold text-slate-900 text-sm sm:text-base cursor-pointer select-none">
                    What should I do if I suspect a product is counterfeit?
                </summary>
                <div class="px-4 sm:px-5 pb-5 pt-3 border-t border-slate-100 text-xs sm:text-sm text-slate-600 leading-relaxed">
                    Stop using it and get in touch with us right away. Hang on to the packaging and send us your order reference along with photos — the batch number, expiry date and seal are the most useful details.
                </div>
            </details>

            <details class="group border border-slate-200 rounded-xl bg-white overflow-hidden transition-all open:border-slate-300 open:shadow-sm">
                <summary class="flex items-center justify-between p-4 sm:p-5 font-bold text-slate-900 text-sm sm:text-base cursor-pointer select-none">
                    How do I place an order?
                </summary>
                <div class="px-4 sm:px-5 pb-5 pt-3 border-t border-slate-100 text-xs sm:text-sm text-slate-600 leading-relaxed">
                    Pick a product, choose the size or flavour you want, add it to your cart, then head to checkout. From there we hand things over to WhatsApp so you can confirm the order and delivery details with our team directly.
                </div>
            </details>

            <details class="group border border-slate-200 rounded-xl bg-white overflow-hidden transition-all open:border-slate-300 open:shadow-sm">
                <summary class="flex items-center justify-between p-4 sm:p-5 font-bold text-slate-900 text-sm sm:text-base cursor-pointer select-none">
                    Why does Pure Gain use WhatsApp for checkout?
                </summary>
                <div class="px-4 sm:px-5 pb-5 pt-3 border-t border-slate-100 text-xs sm:text-sm text-slate-600 leading-relaxed">
                    It's simply the quickest way for us to confirm stock and delivery in real time rather than waiting on email back-and-forth. You'll always see your order reference and the full order summary before anything is finalised.
                </div>
            </details>

            <details class="group border border-slate-200 rounded-xl bg-white overflow-hidden transition-all open:border-slate-300 open:shadow-sm">
                <summary class="flex items-center justify-between p-4 sm:p-5 font-bold text-slate-900 text-sm sm:text-base cursor-pointer select-none">
                    Where does Pure Gain deliver?
                </summary>
                <div class="px-4 sm:px-5 pb-5 pt-3 border-t border-slate-100 text-xs sm:text-sm text-slate-600 leading-relaxed">
                    Kampala and the surrounding areas for now. Delivery time and cost can vary a bit depending on exactly where you are and what's happening on the road that day — our team will confirm both once your order is in.
                </div>
            </details>

            <details class="group border border-slate-200 rounded-xl bg-white overflow-hidden transition-all open:border-slate-300 open:shadow-sm">
                <summary class="flex items-center justify-between p-4 sm:p-5 font-bold text-slate-900 text-sm sm:text-base cursor-pointer select-none">
                    How long does delivery take?
                </summary>
                <div class="px-4 sm:px-5 pb-5 pt-3 border-t border-slate-100 text-xs sm:text-sm text-slate-600 leading-relaxed">
                    Most orders within Kampala go out the same day or the next. It depends on stock and your location, so we'll always give you a realistic time frame when we confirm your order on WhatsApp.
                </div>
            </details>

            <details class="group border border-slate-200 rounded-xl bg-white overflow-hidden transition-all open:border-slate-300 open:shadow-sm">
                <summary class="flex items-center justify-between p-4 sm:p-5 font-bold text-slate-900 text-sm sm:text-base cursor-pointer select-none">
                    What payment methods are available?
                </summary>
                <div class="px-4 sm:px-5 pb-5 pt-3 border-t border-slate-100 text-xs sm:text-sm text-slate-600 leading-relaxed">
                    You'll get official payment instructions when your order is confirmed. One rule that matters: Pure Gain will never ask you to send money to a personal or unlisted number. If that happens, don't pay — report it to us instead.
                </div>
            </details>

            <details class="group border border-slate-200 rounded-xl bg-white overflow-hidden transition-all open:border-slate-300 open:shadow-sm">
                <summary class="flex items-center justify-between p-4 sm:p-5 font-bold text-slate-900 text-sm sm:text-base cursor-pointer select-none">
                    Can I return a supplement?
                </summary>
                <div class="px-4 sm:px-5 pb-5 pt-3 border-t border-slate-100 text-xs sm:text-sm text-slate-600 leading-relaxed">
                    It depends on the condition of the item and why you're returning it. Because supplements are consumable, we generally can't accept opened or used products back — but if something arrived wrong, damaged, or you suspect it isn't genuine, contact us straight away and we'll work it through with you.
                </div>
            </details>

            <details class="group border border-slate-200 rounded-xl bg-white overflow-hidden transition-all open:border-slate-300 open:shadow-sm">
                <summary class="flex items-center justify-between p-4 sm:p-5 font-bold text-slate-900 text-sm sm:text-base cursor-pointer select-none">
                    What happens when a vendor receives serious complaints?
                </summary>
                <div class="px-4 sm:px-5 pb-5 pt-3 border-t border-slate-100 text-xs sm:text-sm text-slate-600 leading-relaxed">
                    We look into it — checking the order history, the product listing and any evidence provided. If a vendor has broken marketplace rules, we can restrict or suspend their account while the matter is investigated further.
                </div>
            </details>

            <details class="group border border-slate-200 rounded-xl bg-white overflow-hidden transition-all open:border-slate-300 open:shadow-sm">
                <summary class="flex items-center justify-between p-4 sm:p-5 font-bold text-slate-900 text-sm sm:text-base cursor-pointer select-none">
                    How can I contact Pure Gain?
                </summary>
                <div class="px-4 sm:px-5 pb-5 pt-3 border-t border-slate-100 text-xs sm:text-sm text-slate-600 leading-relaxed">
                    The Contact Us page is the best place to send a detailed support request, or message us directly on WhatsApp for anything that needs a quick answer.
                </div>
            </details>

        </div>
    </section>

    <!-- Authenticity Promise Section -->
    <section id="authenticity" class="bg-white border border-slate-200 rounded-2xl p-6 sm:p-8 shadow-sm space-y-4">
        <h2 class="text-base sm:text-lg font-bold text-slate-900 flex items-center gap-2">
            <i class="fa-solid fa-shield-halved text-blue-600"></i> Our authenticity promise
        </h2>
        <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
            Every vendor selling on Pure Gain is checked before they're approved, and we take customer reports seriously. It's a real safeguard, but it isn't a substitute for reading the label — we'd still ask you to check the packaging when your order arrives.
        </p>
        <div class="bg-blue-50 text-blue-900 border border-blue-200 p-3.5 rounded-lg text-xs flex items-center gap-3">
            <i class="fa-solid fa-circle-check text-blue-600 text-sm shrink-0"></i>
            <span>Spotted something suspicious, damaged, expired or tampered with? Tell us as soon as you can.</span>
        </div>
    </section>

    <!-- Delivery Section -->
    <section id="delivery" class="bg-white border border-slate-200 rounded-2xl p-6 sm:p-8 shadow-sm space-y-2">
        <h2 class="text-base sm:text-lg font-bold text-slate-900">Delivery information</h2>
        <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
            We confirm delivery details based on your location, stock availability and what you've ordered. Double-check that your phone number and Kampala delivery address are correct at checkout — it's the most common reason for delays.
        </p>
    </section>

    <!-- Returns & Refunds Section -->
    <section id="returns" class="bg-white border border-slate-200 rounded-2xl p-6 sm:p-8 shadow-sm space-y-4">
        <h2 class="text-base sm:text-lg font-bold text-slate-900">Returns &amp; refunds</h2>
        <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
            If something arrives wrong, damaged or you think it might be counterfeit, get in touch straight away and hold on to the packaging and your order reference. Because supplements are consumable, we generally can't take back items that have already been opened or used.
        </p>
        <div>
            <a href="contact.php" class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold text-xs sm:text-sm px-5 py-2.5 rounded-lg transition-colors shadow-sm">
                <i class="fa-solid fa-rotate-left"></i> Request assistance
            </a>
        </div>
    </section>

</main>

</body>
</html>