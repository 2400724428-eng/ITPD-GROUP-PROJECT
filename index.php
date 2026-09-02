<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jumika Supplements | Online Store</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
      <link rel="stylesheet" href="assets/css/index.css">
</head>
<body>

    <!-- == TOP BAR == -->
    <div class="jum-topbar">
        <div class="jum-topbar-container">
            <p><i class="fa-solid fa-location-dot"></i> Deliver to <strong>Kampala</strong> · Free delivery on orders over UGX 200,000</p>
            <div class="jum-topbar-links">
                <a href="help-desk.php"><i class="fa-solid fa-circle-question"></i> Help Centre</a>
            </div>
        </div>
    </div>

    <!-- === MAIN HEADER === -->
    <header class="jum-header">
        <div class="jum-header-container">
            <!-- 1. MENU BUTTON VISIBLE ON ALL SCREENS -->
            <button class="jum-menu-btn" id="mobileMenuBtn" type="button" aria-label="Toggle Navigation Menu">
                <i class="fa-solid fa-bars"></i>
            </button>

            <!-- LOGO -->
            <div class="jum-logo">
                JUMIKA <span>SUPPLEMENTS</span>
            </div>

            <!-- SEARCH BAR -->
            <form class="jum-search" onsubmit="return false;">
                <input type="text" placeholder="Search protein, creatine, mass gainers..." aria-label="Search products">
                <button type="submit" aria-label="Search">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </button>
            </form>

            <!-- DESKTOP HEADER ICONS -->
            <div class="jum-desktop-icons">
                <a href="account.php" class="jum-icon-link">
                    <i class="fa-regular fa-user"></i>
                    <span>Account</span>
                </a>
                <a href="wishlist.php" class="jum-icon-link">
                    <i class="fa-regular fa-heart"></i>
                    <span>Wishlist</span>
                </a>
                <a href="cart.php" class="jum-icon-link jum-cart-wrapper">
                    <i class="fa-solid fa-cart-shopping"></i>
                    <span>Cart</span>
                    <span class="jum-badge">3</span>
                </a>
            </div>
        </div>
    </header>

    <!-- 2. DESKTOP CATEGORY NAVIGATION -->
    <nav class="jum-catnav">
        <div class="jum-catnav-container">
            <div class="jum-cat-all" id="desktopMenuBtn" style="cursor: pointer;">
                <i class="fa-solid fa-shapes"></i> All Categories
            </div>
            <a href="categories/proteins.php">Proteins</a>
            <a href="categories/creatine.php">Creatine</a>
            <a href="categories/workout.php">Pre-Workout</a>
            <a href="categories/massgainers.php">Mass Gainers</a>
            <a href="categories/vitamins.php">Vitamins &amp; Wellness</a>
            <a href="categories/snacks.php">Bars &amp; Snacks</a>
            <a href="categories/accessories.php">Accessories</a>
        </div>
    </nav>

    <!-- 3. SLIDE MENU DETAILS & OVERLAY -->
    <div class="jum-mobile-drawer" id="mobileMenu">
        <div class="jum-drawer-header">
            <h3>JUMIKA MENU</h3>
            <button class="jum-drawer-close" id="closeMenu" type="button">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
        <div class="jum-drawer-body">
            <a href="index.php"><i class="fa-solid fa-house"></i> Home</a>
            <a href="categories/proteins.php"><i class="fa-solid fa-dumbbell"></i> Protein powders</a>
            <a href="categories/creatine.php"><i class="fa-solid fa-bolt"></i> Creatine</a>
            <a href="categories/workout.php"><i class="fa-solid fa-fire"></i> Pre-workout</a>
            <a href="categories/massgainers.php"><i class="fa-solid fa-weight-hanging"></i> Mass gainers</a>
            <a href="categories/vitamins.php"><i class="fa-solid fa-capsules"></i> Vitamins &amp; wellness</a>
            <a href="categories/snacks.php"><i class="fa-solid fa-cookie-bite"></i> Bars &amp; snacks</a>
            <a href="categories/accessories.php"><i class="fa-solid fa-bottle-water"></i> Accessories</a>
            <div class="jum-drawer-divider"></div>
            <a href="help-desk.php"><i class="fa-solid fa-circle-question"></i> Help centre</a>
            <a href="contact.php"><i class="fa-solid fa-phone"></i> Contact us</a>
        </div>
    </div>
    <div class="jum-overlay" id="menuOverlay"></div>

    <!-- === MAIN CONTAINER === -->
    <main class="jum-main">
        <!-- HERO CAROUSEL -->
        <section class="jum-hero">
            <div class="jum-slide active">
                <div class="jum-slide-text">
                    <span class="jum-tag"><i class="fa-solid fa-truck-fast"></i> Fast Delivery across Uganda</span>
                    <h1>Fuel Your Body, <em>Crush Your Goals.</em></h1>
                    <p>100% authentic sports supplements, vitamins, and fitness accessories delivered straight to your door.</p>
                    <a href="#products" class="jum-btn-accent">Shop Best Sellers <i class="fa-solid fa-arrow-right"></i></a>
                </div>
                <div class="jum-slide-img">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/7/78/Optimus_nutrition_gold_standard_whey_protein_%282%29.jpg/500px-Optimus_nutrition_gold_standard_whey_protein_%282%29.jpg" alt="Whey Protein" referrerpolicy="no-referrer">
                </div>
            </div>
        </section>

        <!-- FLASH SALE SECTION -->
        <section class="jum-section" id="products">
            <div class="jum-section-header">
                <h2><i class="fa-solid fa-bolt-lightning text-warning"></i> Flash Sale</h2>
                <div class="jum-timer-box">
                    <span>Ends in: <strong>04 : 18 : 52</strong></span>
                </div>
                <a href="#" class="jum-see-all">See All &rsaquo;</a>
            </div>

            <div class="jum-grid">
                <!-- Product 1 -->
                <div class="jum-card">
                    <span class="jum-badge-disc">-23%</span>
                    <div class="jum-card-img">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/7/78/Optimus_nutrition_gold_standard_whey_protein_%282%29.jpg/500px-Optimus_nutrition_gold_standard_whey_protein_%282%29.jpg" alt="Whey Protein" referrerpolicy="no-referrer">
                    </div>
                    <h4 class="jum-card-title">Whey Protein Isolate, Chocolate, 2kg</h4>
                    <div class="jum-price-box">
                        <span class="jum-price-current">UGX 185,000</span>
                        <span class="jum-price-old">240,000</span>
                    </div>
                    <div class="jum-stock-bar"><div class="jum-stock-fill" style="width: 75%;"></div></div>
                    <span class="jum-stock-text">75% sold</span>
                </div>

                <!-- Product 2 -->
                <div class="jum-card">
                    <span class="jum-badge-disc">-28%</span>
                    <div class="jum-card-img">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/8/87/Creatine_monohydrate.jpg/500px-Creatine_monohydrate.jpg" alt="Creatine" referrerpolicy="no-referrer">
                    </div>
                    <h4 class="jum-card-title">Micronised Creatine Monohydrate, 300g</h4>
                    <div class="jum-price-box">
                        <span class="jum-price-current">UGX 65,000</span>
                        <span class="jum-price-old">90,000</span>
                    </div>
                    <div class="jum-stock-bar"><div class="jum-stock-fill" style="width: 45%;"></div></div>
                    <span class="jum-stock-text">45% sold</span>
                </div>

                <!-- Product 3 -->
                <div class="jum-card">
                    <span class="jum-badge-disc">-15%</span>
                    <div class="jum-card-img">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/4/42/Adonis_Men%27s_Pre-workout.jpg/500px-Adonis_Men%27s_Pre-workout.jpg" alt="Pre-Workout" referrerpolicy="no-referrer">
                    </div>
                    <h4 class="jum-card-title">Explosive Pre-Workout Booster, 400g</h4>
                    <div class="jum-price-box">
                        <span class="jum-price-current">UGX 85,000</span>
                        <span class="jum-price-old">100,000</span>
                    </div>
                    <div class="jum-stock-bar"><div class="jum-stock-fill" style="width: 90%;"></div></div>
                    <span class="jum-stock-text">90% sold</span>
                </div>

                <!-- Product 4 -->
                <div class="jum-card">
                    <span class="jum-badge-disc">-20%</span>
                    <div class="jum-card-img">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/8/84/Pro360_Protein_powder.jpg/500px-Pro360_Protein_powder.jpg" alt="Mass Gainer" referrerpolicy="no-referrer">
                    </div>
                    <h4 class="jum-card-title">Super Mass Gainer, Vanilla, 3kg</h4>
                    <div class="jum-price-box">
                        <span class="jum-price-current">UGX 210,000</span>
                        <span class="jum-price-old">260,000</span>
                    </div>
                    <div class="jum-stock-bar"><div class="jum-stock-fill" style="width: 60%;"></div></div>
                    <span class="jum-stock-text">60% sold</span>
                </div>

                <!-- Product 5 -->
                <div class="jum-card">
                    <span class="jum-badge-disc">-30%</span>
                    <div class="jum-card-img">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/1/1b/Osaka_protein_shaker.jpg/500px-Osaka_protein_shaker.jpg" alt="Shaker Bottle" referrerpolicy="no-referrer">
                    </div>
                    <h4 class="jum-card-title">Leak-Proof Protein Shaker Bottle, 700ml</h4>
                    <div class="jum-price-box">
                        <span class="jum-price-current">UGX 15,000</span>
                        <span class="jum-price-old">22,000</span>
                    </div>
                    <div class="jum-stock-bar"><div class="jum-stock-fill" style="width: 30%;"></div></div>
                    <span class="jum-stock-text">30% sold</span>
                </div>
            </div>
        </section>

        <!-- NEW SECTION: SHOP BY CATEGORY (USING MENU LINKS ) -->
        <section class="jum-section">
            <div class="jum-section-header">
                <h2><i class="fa-solid fa-shapes text-warning"></i> Shop By Category</h2>
                <a href="#" class="jum-see-all">See All &rsaquo;</a>
            </div>

            <div class="jum-category-grid">
                <!-- Category 1: Protein Powders -->
                <a href="categories/proteins.php" class="jum-category-card">
                    <div class="jum-cat-card-img">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/7/78/Optimus_nutrition_gold_standard_whey_protein_%282%29.jpg/500px-Optimus_nutrition_gold_standard_whey_protein_%282%29.jpg" alt="Protein powders" referrerpolicy="no-referrer">
                    </div>
                    <h4>Protein powders</h4>
                </a>

                <!-- Category 2: Creatine -->
                <a href="categories/creatine.php" class="jum-category-card">
                    <div class="jum-cat-card-img">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/8/87/Creatine_monohydrate.jpg/500px-Creatine_monohydrate.jpg" alt="Creatine" referrerpolicy="no-referrer">
                    </div>
                    <h4>Creatine</h4>
                </a>

                <!-- Category 3: Pre-workout -->
                <a href="categories/workout.php" class="jum-category-card">
                    <div class="jum-cat-card-img">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/4/42/Adonis_Men%27s_Pre-workout.jpg/500px-Adonis_Men%27s_Pre-workout.jpg" alt="Pre-workout" referrerpolicy="no-referrer">
                    </div>
                    <h4>Pre-workout</h4>
                </a>

                <!-- Category 4: Mass gainers -->
                <a href="categories/massgainers.php" class="jum-category-card">
                    <div class="jum-cat-card-img">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/8/84/Pro360_Protein_powder.jpg/500px-Pro360_Protein_powder.jpg" alt="Mass gainers" referrerpolicy="no-referrer">
                    </div>
                    <h4>Mass gainers</h4>
                </a>

                <!-- Category 5: Vitamins & wellness -->
                <a href="categories/vitamins.php" class="jum-category-card">
                    <div class="jum-cat-card-img">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/4/42/Adonis_Men%27s_Pre-workout.jpg/500px-Adonis_Men%27s_Pre-workout.jpg" alt="Vitamins & wellness" referrerpolicy="no-referrer">
                    </div>
                    <h4>Vitamins &amp; wellness</h4>
                </a>

                <!-- Category 6: Bars & snacks -->
                <a href="categories/snacks.php" class="jum-category-card">
                    <div class="jum-cat-card-img">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/7/78/Optimus_nutrition_gold_standard_whey_protein_%282%29.jpg/500px-Optimus_nutrition_gold_standard_whey_protein_%282%29.jpg" alt="Bars & snacks" referrerpolicy="no-referrer">
                    </div>
                    <h4>Bars &amp; snacks</h4>
                </a>

                <!-- Category 7: Accessories -->
                <a href="categories/accessories.php" class="jum-category-card">
                    <div class="jum-cat-card-img">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/1/1b/Osaka_protein_shaker.jpg/500px-Osaka_protein_shaker.jpg" alt="Accessories" referrerpolicy="no-referrer">
                    </div>
                    <h4>Accessories</h4>
                </a>
            </div>
        </section>
    </main>

    <!-- == MOBILE BOTTOM NAVIGATION BAR == -->
    <nav class="jum-bottom-nav">
        <a href="index.php" class="jum-bitem active">
            <i class="fa-solid fa-house"></i>
            <span>Home</span>
        </a>
        <a href="#" class="jum-bitem" onclick="document.getElementById('mobileMenuBtn').click(); return false;">
            <i class="fa-solid fa-shapes"></i>
            <span>Categories</span>
        </a>
        <a href="account.php" class="jum-bitem">
            <i class="fa-regular fa-user"></i>
            <span>Account</span>
        </a>
        <a href="wishlist.php" class="jum-bitem">
            <i class="fa-regular fa-heart"></i>
            <span>Wishlist</span>
        </a>
        <a href="cart.php" class="jum-bitem jum-cart-anchor">
            <i class="fa-solid fa-cart-shopping"></i>
            <span>Cart</span>
            <span class="jum-b-badge">3</span>
        </a>
    </nav>

<script src="assets/js/index.js"></script>



</body>
</html>
