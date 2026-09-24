<!DOCTYPE html>
<html lang="en">
<head>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  
    <link rel="stylesheet" href="/gym-supplements-store/assets/css/index.css">
    
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

            <!-- LOGO IMAGE -->
            <div class="jum-logo">
                <a href="index.php">
             
 <?php 
// Automatically check whether 'assets/' is in the current folder or one level up
$logo_src = file_exists('assets/images/logo.jpg') ? 'assets/images/logo.jpg' : '../assets/images/logo.jpg';
?>

<img src="<?= $logo_src; ?>" alt="Pure Gain Logo" class="jum-logo-img">                  

                </a>

          </div>

          <style>  

/* Logo Styling */
.jum-logo {
    display: flex;
    align-items: center;
}

.jum-logo a {
    display: inline-block;
    line-height: 0;
}

.jum-logo-img {
    height: 120px; /* Adjust this value depending on your layout requirements */
    width: auto;
    object-fit: contain;
    display: block;
    border-radius: 500%;
}

/* Optional: Mobile Drawer Logo Integration */
.jum-drawer-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.jum-drawer-logo .jum-logo-img {
    height: 70px; /* Slightly smaller for the slide drawer header if needed */
}

  </style>


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
            <div class="jum-drawer-logo">
                <img src="assets/images/logo.jpg" alt="" class="jum-logo-img">
            </div>
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

<?php 
$js_path = file_exists('assets/js/index.js') ? 'assets/js/index.js' : '../assets/js/index.js';
?>
<script src="<?= $js_path; ?>"></script>