<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <!-- PWA Manifest -->
    <link rel="manifest" href="manifest.json">
    
    <!-- Theme Color for Mobile Browser -->
    <meta name="theme-color" content="#004ac6">
    
    <!-- Apple iOS Specific Tags (for iPhone/iPad) -->
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <meta name="apple-mobile-web-app-title" content="Pure Gain">
    <link rel="apple-touch-icon" href="assets/images/fav.png">

    <link rel="icon" type="image/png" href="assets/images/fav.png"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pure Gain</title>
    <link href="./src/output.css" rel="stylesheet">

    <!-- Scroll Animation Styles -->
    <style>
        html {
            scroll-behavior: smooth;
        }

        /* Initial hidden state */
        .scroll-animate {
            opacity: 0;
            transition:
                opacity 0.8s ease,
                transform 0.8s cubic-bezier(0.22, 1, 0.36, 1);
            will-change: opacity, transform;
        }

        .animate-up {
            transform: translateY(55px);
        }

        .animate-left {
            transform: translateX(-55px);
        }

        .animate-right {
            transform: translateX(55px);
        }

        .animate-zoom {
            transform: scale(0.88);
        }

        /* Visible when scrolling into view */
        .scroll-animate.show {
            opacity: 1;
            transform: translate(0, 0) scale(1);
        }

        /* Smooth staggered appearance for cards */
        .scroll-card {
            opacity: 0;
            transform: translateY(35px) scale(0.97);
            transition:
                opacity 0.7s ease,
                transform 0.7s cubic-bezier(0.22, 1, 0.36, 1);
            transition-delay: var(--animation-delay, 0ms);
        }

        .scroll-card.show {
            opacity: 1;
            transform: translateY(0) scale(1);
        }

        /* Gentle hover animation */
        .scroll-card {
            transition:
                opacity 0.7s ease,
                transform 0.7s cubic-bezier(0.22, 1, 0.36, 1),
                box-shadow 0.3s ease;
        }

        .scroll-card:hover {
            box-shadow: 0 12px 28px rgba(15, 23, 42, 0.10);
        }

        /* SDG dropdown opening animation */
        #sdgContent {
            animation: none;
        }

        #sdgContent.sdg-opening {
            animation: sdgFadeIn 0.45s ease both;
        }

        @keyframes sdgFadeIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Accessibility: respect reduced-motion preferences */
        @media (prefers-reduced-motion: reduce) {
            html {
                scroll-behavior: auto;
            }

            .scroll-animate,
            .scroll-card,
            #sdgContent.sdg-opening {
                animation: none !important;
                transition: none !important;
                transform: none !important;
                opacity: 1 !important;
            }
        }
    </style>
</head>

<body class="bg-slate-50">

    <?php include 'includes/searchtop.php'; ?>

    <?php include 'includes/top.php'; ?>

    <!-- ================= MINIMAL DROPDOWN ARROW BAR ================= -->
    <div class="max-w-[1060px] w-full mx-auto px-4 sm:px-6 my-4" id="sdg3">

        <!-- Minimal Dropdown Button -->
        <button
            onclick="toggleSdgDropdown()"
            id="sdgBtn"
            aria-expanded="false"
            aria-controls="sdgContent"
            class="flex items-center gap-2 text-slate-700 hover:text-blue-600 transition-colors py-2 text-sm font-semibold focus:outline-none cursor-pointer group">

            <!-- Small SDG 3 Badge -->
            <span class="w-5 h-5 rounded bg-blue-600 text-white font-bold text-[11px] flex items-center justify-center shrink-0">
                3
            </span>

            <span>SDG 3 – Good Health and Well-being</span>

            <!-- Dropdown Arrow -->
            <svg id="sdgArrow"
                 class="w-4 h-4 text-slate-500 group-hover:text-blue-600 transition-transform duration-200 transform rotate-0"
                 fill="none"
                 stroke="currentColor"
                 viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                      d="M19 9l-7 7-7-7" />
            </svg>
        </button>

        <!-- Content -->
        <div id="sdgContent"
             class="hidden pt-3 pb-6 text-slate-600 text-sm leading-relaxed border-t border-slate-200 mt-1">

            <p class="max-w-3xl mb-4">
                Pure Gain contributes to <strong>SDG 3 – Good Health and Well-being</strong> by making quality fitness training,
                nutrition guidance, and performance support more accessible. Regular physical activity and good nutrition help
                prevent non-communicable diseases, improve mental well-being, and support healthier communities — especially
                for young people and busy adults in Kampala and beyond.
            </p>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 my-4">

                <div class="bg-white p-4 rounded-lg border border-slate-200 shadow-sm">
                    <h4 class="font-bold text-slate-900 mb-1">Physical Health</h4>
                    <p class="text-xs text-slate-600">
                        Structured training and strength programmes help reduce risk factors for heart disease, diabetes, and obesity.
                    </p>
                </div>

                <div class="bg-white p-4 rounded-lg border border-slate-200 shadow-sm">
                    <h4 class="font-bold text-slate-900 mb-1">Mental Well-being</h4>
                    <p class="text-xs text-slate-600">
                        Exercise and community classes support better mood, lower stress, improved sleep, and stronger social connections.
                    </p>
                </div>

                <div class="bg-white p-4 rounded-lg border border-slate-200 shadow-sm">
                    <h4 class="font-bold text-slate-900 mb-1">Accessible Support</h4>
                    <p class="text-xs text-slate-600">
                        Affordable membership plans, online coaching, and nutrition advice that works with local foods make healthy living more reachable.
                    </p>
                </div>

            </div>

            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 text-xs text-slate-500 pt-2">
                <span>
                    This project is part of our school group contribution to the UN Sustainable Development Goals.
                </span>
                <a href="https://sdgs.un.org/goals/goal3"
                   target="_blank"
                   rel="noopener"
                   class="text-blue-600 hover:underline font-medium">
                    Learn more &rarr;
                </a>
            </div>

        </div>
    </div>

    <br><br>

    <?php include 'product/featured.php'; ?>

    <br><br>

    <?php include 'includes/product.php'; ?>

    <!-- PHP Content Below -->

    <br><br>

    <?php include 'gymn/gymn.php'; ?>

    <?php include 'includes/bottom.php'; ?>

    <br><br>

    <?php include 'includes/footer.php'; ?>

    <!-- ================= CUSTOM PWA INSTALL BANNER ================= -->
    <!-- Changed from translate-y-full to hidden/flex for reliable closing -->
    <div id="pwaInstallBanner" class="fixed bottom-0 left-0 w-full bg-white border-t border-slate-200 p-4 sm:p-5 shadow-[0_-10px_40px_rgba(0,0,0,0.1)] z-[90] hidden flex-col sm:flex-row items-center justify-between gap-4 px-4 sm:px-8">
        
        <!-- App Info -->
        <div class="flex items-center gap-3 w-full sm:w-auto">
            <img src="assets/images/fav.png" alt="App Icon" class="w-12 h-12 rounded-xl shadow-sm border border-slate-100 shrink-0">
            <div class="text-left">
                <h4 class="text-sm font-bold text-slate-900 leading-tight">Install Pure Gain</h4>
                <p class="text-[11px] text-slate-500 mt-0.5">Fast, offline-ready, right on your device.</p>
            </div>
        </div>

        <!-- Actions -->
        <div class="flex items-center w-full sm:w-auto gap-3 shrink-0">
            <button id="btnCancelInstall" class="flex-1 sm:flex-none text-xs font-semibold text-slate-500 hover:text-slate-800 transition-colors py-2.5 px-4 rounded-xl hover:bg-slate-50 border border-transparent">
                Not now
            </button>
            <button id="btnInstallApp" class="flex-1 sm:flex-none bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold py-2.5 px-6 rounded-xl shadow-md transition-colors flex items-center justify-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                </svg>
                Install
            </button>
        </div>
    </div>
    <!-- ================= END PWA INSTALL BANNER ================= -->

    <!-- ================= SCROLL ANIMATION JAVASCRIPT ================= -->
    <script>
        // SDG dropdown toggle
        function toggleSdgDropdown() {
            const content = document.getElementById('sdgContent');
            const arrow = document.getElementById('sdgArrow');
            const button = document.getElementById('sdgBtn');

            if (!content || !arrow || !button) return;

            const isOpening = content.classList.contains('hidden');

            if (isOpening) {
                content.classList.remove('hidden');

                // Restart the opening animation
                content.classList.remove('sdg-opening');
                void content.offsetWidth;
                content.classList.add('sdg-opening');

                arrow.classList.add('rotate-180');
                button.setAttribute('aria-expanded', 'true');
            } else {
                content.classList.add('hidden');
                content.classList.remove('sdg-opening');

                arrow.classList.remove('rotate-180');
                button.setAttribute('aria-expanded', 'false');
            }
        }

        document.addEventListener('DOMContentLoaded', function () {

            // Do not animate if the visitor prefers reduced motion
            const reduceMotion = window.matchMedia(
                '(prefers-reduced-motion: reduce)'
            ).matches;

            // Select sections from your existing PHP includes
            const sectionSelectors = [
                '#sdg3',
                'main',
                'section',
                '[id^="section-"]',
                '[id^="featured"]',
                '[id^="gymn"]'
            ];

            // Avoid adding multiple animation classes to the same element
            const sections = new Set();

            sectionSelectors.forEach(function (selector) {
                document.querySelectorAll(selector).forEach(function (element) {
                    if (element.id === 'sdgContent') return;

                    // Avoid animating tiny structural elements
                    if (element.offsetHeight < 40) return;

                    sections.add(element);
                });
            });

            // Apply alternating entrance animations to sections
            let sectionIndex = 0;

            sections.forEach(function (element) {
                if (element.classList.contains('scroll-animate')) return;

                element.classList.add('scroll-animate');

                if (sectionIndex % 3 === 0) {
                    element.classList.add('animate-up');
                } else if (sectionIndex % 3 === 1) {
                    element.classList.add('animate-left');
                } else {
                    element.classList.add('animate-right');
                }

                sectionIndex++;
            });

            // Find cards in the existing page and included PHP files
            const cardSelectors = [
                '#sdgContent .grid > div',
                '.product-card',
                '.product-item',
                '.product-box',
                '.deal-card',
                '.featured-card',
                '[data-product-id]',
                '.gym-card',
                '.class-card',
                '.feature-card',
                'article'
            ];

            const cards = new Set();

            cardSelectors.forEach(function (selector) {
                document.querySelectorAll(selector).forEach(function (card) {
                    if (card.offsetHeight < 35) return;
                    cards.add(card);
                });
            });

            // Animate cards with a small staggered delay
            cards.forEach(function (card, index) {
                card.classList.add('scroll-card');
                card.style.setProperty(
                    '--animation-delay',
                    (index % 4) * 100 + 'ms'
                );
            });

            // Reveal everything immediately for reduced-motion users
            if (reduceMotion) {
                document.querySelectorAll('.scroll-animate, .scroll-card')
                    .forEach(function (element) {
                        element.classList.add('show');
                    });
                return;
            }

            // Modern browsers: reveal elements as they enter the viewport
            if ('IntersectionObserver' in window) {
                const observer = new IntersectionObserver(function (entries) {
                    entries.forEach(function (entry) {
                        if (entry.isIntersecting) {
                            entry.target.classList.add('show');

                            // Animate each element only once
                            observer.unobserve(entry.target);
                        }
                    });
                }, {
                    threshold: 0.10,
                    rootMargin: '0px 0px -40px 0px'
                });

                document.querySelectorAll('.scroll-animate, .scroll-card')
                    .forEach(function (element) {
                        observer.observe(element);
                    });

            } else {
                // Fallback for older browsers
                document.querySelectorAll('.scroll-animate, .scroll-card')
                    .forEach(function (element) {
                        element.classList.add('show');
                    });
            }
        });
    </script>

    <!-- ================= PWA INSTALL & SERVICE WORKER JAVASCRIPT ================= -->
    <script>
        // 1. Register Service Worker
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', () => {
                navigator.serviceWorker.register('sw.js')
                    .then(registration => {
                        console.log('ServiceWorker registration successful');
                    })
                    .catch(err => {
                        console.log('ServiceWorker registration failed: ', err);
                    });
            });
        }

        // 2. Handle Custom Install Prompt
        let deferredPrompt;
        const installBanner = document.getElementById('pwaInstallBanner');
        const btnInstall = document.getElementById('btnInstallApp');
        const btnCancel = document.getElementById('btnCancelInstall');

        // Listen for the browser telling us the app is installable
        window.addEventListener('beforeinstallprompt', (e) => {
            // Prevent the default mini-infobar from appearing on mobile
            e.preventDefault();
            // Stash the event so it can be triggered later.
            deferredPrompt = e;

            // Check if the user already dismissed it recently
            if (!sessionStorage.getItem('pwa_dismissed')) {
                // Show our custom banner
                setTimeout(() => {
                    installBanner.classList.remove('hidden');
                    installBanner.classList.add('flex');
                }, 3000); // Wait 3 seconds before showing it
            }
        });

        // When the user clicks our "Install" button
        if (btnInstall) {
            btnInstall.addEventListener('click', async () => {
                if (deferredPrompt) {
                    // Show the native install prompt
                    deferredPrompt.prompt();
                    // Wait for the user to respond to the prompt
                    const { outcome } = await deferredPrompt.userChoice;
                    
                    if (outcome === 'accepted') {
                        console.log('User accepted the install prompt');
                    } else {
                        console.log('User dismissed the install prompt');
                    }
                    // Clear the deferredPrompt variable
                    deferredPrompt = null;
                    // Hide the banner reliably
                    installBanner.classList.add('hidden');
                    installBanner.classList.remove('flex');
                }
            });
        }

        // When the user clicks "Not now"
        if (btnCancel) {
            btnCancel.addEventListener('click', () => {
                // Hide the banner reliably
                installBanner.classList.add('hidden');
                installBanner.classList.remove('flex');
                // Don't show it again in this session
                sessionStorage.setItem('pwa_dismissed', 'true');
            });
        }

        // Hide banner if app is already installed
        window.addEventListener('appinstalled', () => {
            if (installBanner) {
                installBanner.classList.add('hidden');
                installBanner.classList.remove('flex');
            }
            console.log('PWA was installed');
        });
    </script>

</body>
</html>