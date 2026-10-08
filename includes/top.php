

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>ApexFit - Supplements & Pro Training</title>
<!-- Tailwind CSS v3 with forms and container-queries -->
<link href="../src/output.css" rel="stylesheet">

<!-- Google Fonts: Inter & Plus Jakarta Sans for crisp modern typography -->
<link href="https://fonts.googleapis.com" rel="preconnect"/>
<link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect"/>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@500;600;700;800&family=Inter:wght@400;500;600&display=swap" rel="stylesheet"/>
<script>
    tailwind.config = {
      theme: {
        extend: {
          fontFamily: {
            sans: ['Plus Jakarta Sans', 'Inter', 'sans-serif'],
          },
          colors: {
            brand: {
              navy: '#1e3a8a',
              cardBg: 'rgba(255, 255, 255, 0.1)',
            }
          }
        }
      }
    }
  </script>
<style>
    body {
      font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
      -webkit-font-smoothing: antialiased;
    }
    /* Strictly contained carousel viewport and track */
    .carousel-viewport {
      overflow: hidden;
      width: 100%;
      position: relative;
    }
    .carousel-track {
      display: flex;
      width: 300%;
      transition: transform 0.6s cubic-bezier(0.25, 1, 0.5, 1);
      will-change: transform;
    }
    .carousel-slide {
      width: 33.333333%;
      flex-shrink: 0;
      box-sizing: border-box;
    }

    /* Identical matching gradient background styling */
    .banner-gradient {
      background: radial-gradient(circle at 50% 40%, #EFF4FB 0%, #DFE8F5 100%);
      box-shadow: 0 25px 60px -15px rgba(16, 58, 199, 0.2), 0 10px 25px -5px rgba(0, 0, 0, 0.05);
      border: 1px solid rgba(255, 255, 255, 0.8);
    }

    /* Keyframes for the popping up and continuous pulsing zoom */
    @keyframes popAndPulse {
      0% {
        opacity: 0;
        transform: scale(0.6) translateY(20px);
      }
      30% {
        opacity: 1;
        transform: scale(1.08) translateY(0);
      }
      50% {
        transform: scale(0.95);
      }
      70% {
        transform: scale(1.04);
      }
      100% {
        opacity: 1;
        transform: scale(1);
      }
    }

    /* Continuous subtle breathing zoom loop after popping in */
    @keyframes breathingZoom {
      0%, 100% {
        transform: scale(1);
      }
      50% {
        transform: scale(1.06);
      }
    }

    /* Text matching fade-up entrance animation */
    @keyframes textFadeUp {
      0% {
        opacity: 0;
        transform: translateY(25px);
      }
      100% {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .animated-img {
      opacity: 0;
      transform: scale(0.6);
    }

    .text-animate {
      opacity: 0;
      transform: translateY(25px);
    }

    /* Triggered when slide becomes active */
    .carousel-slide.active .animated-img {
      animation: popAndPulse 0.8s cubic-bezier(0.175, 0.885, 0.32, 1.275) forwards, 
                 breathingZoom 3s ease-in-out 0.8s infinite;
    }

    .carousel-slide.active .text-animate {
      animation: textFadeUp 0.7s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    }

    /* Staggered text delays for a smooth polished cascade */
    .carousel-slide.active .text-delay-1 {
      animation-delay: 0.1s;
    }
    .carousel-slide.active .text-delay-2 {
      animation-delay: 0.25s;
    }
    .carousel-slide.active .text-delay-3 {
      animation-delay: 0.4s;
    }
  </style>
</head>
<body class="bg-slate-50 text-slate-800 antialiased min-h-screen flex flex-col">
<!-- BEGIN: MainHeader -->
<header class="w-full border-b border-slate-200 bg-white sticky top-0 z-50 shadow-xs" data-purpose="site-header">
<div class="max-w-[1100px] mx-auto px-4 h-16 flex items-center justify-between">
<!-- Left Side: Mobile Menu Button & Brand Logo -->
<div class="flex items-center gap-3">
  <!-- Mobile Menu Toggle Button -->
  <button id="menuToggleBtn" aria-label="Toggle Menu" class="md:hidden p-1.5 text-slate-700 hover:text-blue-600 hover:bg-slate-100 rounded-lg transition-colors" type="button">
    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
    </svg>
  </button>

  <!-- Brand Logo -->
  <a class="flex items-center gap-2 select-none" href="#">
      <img src="assets/images/logos.png" alt="Logo Icon" style="width: 150px; height: auto; object-fit: contain;">
  </a>
</div>

<!-- Center Navigation Links & Portal (Desktop) -->
<nav class="hidden md:flex items-center space-x-4 text-[14px] font-medium text-slate-700" data-purpose="main-navigation">
    <a class="flex items-center gap-1.5 whitespace-nowrap hover:text-blue-600 transition-colors" href="index.php">
        <svg class="w-4 h-4 text-slate-500 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25"></path></svg>
        Home
    </a>
    <a class="flex items-center gap-1.5 whitespace-nowrap hover:text-blue-600 transition-colors" href="shop.php">
        <svg class="w-4 h-4 text-slate-500 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007zM8.625 10.5a.375.375 0 11-.75 0 .375.375 0 01.75 0zm7.5 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z"></path></svg>
        Shop
    </a>
    <a class="flex items-center gap-1.5 whitespace-nowrap hover:text-blue-600 transition-colors" href="gymn/membership.php">
        <svg class="w-4 h-4 text-slate-500 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zM4 19.235v-.11a6.375 6.375 0 0112.75 0v.109A12.318 12.318 0 0110.374 21c-2.331 0-4.512-.645-6.374-1.766z"></path></svg>
        Join Training
    </a>
    <a class="flex items-center gap-1.5 whitespace-nowrap hover:text-blue-600 transition-colors" href="gymn/gymn.php">
        <svg class="w-4 h-4 text-slate-500 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z"></path></svg>
        Gym Services
    </a>
    <a class="flex items-center gap-1.5 whitespace-nowrap hover:text-blue-600 transition-colors" href="about.php">
        <svg class="w-4 h-4 text-slate-500 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z"></path></svg>
        About
    </a>
    <a class="flex items-center gap-1.5 whitespace-nowrap hover:text-blue-600 transition-colors" href="contact.php">
        <svg class="w-4 h-4 text-slate-500 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"></path></svg>
        Contact
    </a>
    <a class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full border border-slate-300 text-[13px] font-medium text-slate-800 hover:border-blue-400 hover:bg-slate-50 transition-all shadow-sm whitespace-nowrap shrink-0" href="portal/portalogin.php">
        <svg class="w-4 h-4 text-slate-600 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0012 15.75a7.488 7.488 0 00-5.982 2.975m11.963 0a9 9 0 10-11.963 0m11.963 0A8.966 8.966 0 0112 21a8.966 8.966 0 01-5.982-2.275M15 9.75a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
        Member Portal
    </a>
</nav>

<!-- Right Professional Utility Actions -->
<div class="flex items-center space-x-3 sm:space-x-4 text-slate-700" data-purpose="user-utilities">
<button id="searchToggleBtn" aria-label="Search" class="p-1.5 hover:text-blue-600 hover:bg-slate-100 rounded-full transition-colors" type="button">
<svg class="w-5 h-5 stroke-[2]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
<path d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" stroke-linecap="round" stroke-linejoin="round"></path>
</svg>
</button>

<a aria-label="Wishlist" class="relative p-1.5 hover:text-blue-600 hover:bg-slate-100 rounded-full transition-colors" href="#">
<svg class="w-5 h-5 stroke-[2]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
<path d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" stroke-linecap="round" stroke-linejoin="round"></path>
</svg>
<span class="absolute top-0.5 right-0.5 bg-red-600 text-white text-[10px] font-bold w-4 h-4 rounded-full flex items-center justify-center">2</span>
</a>

<a aria-label="Cart" class="relative p-1.5 hover:text-blue-600 hover:bg-slate-100 rounded-full transition-colors" href="#">
<svg class="w-5 h-5 stroke-[2]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
<path d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007zM8.625 10.5a.375.375 0 11-.75 0 .375.375 0 01.75 0zm7.5 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" stroke-linecap="round" stroke-linejoin="round"></path>
</svg>
<span class="absolute top-0.5 right-0.5 bg-red-600 text-white text-[10px] font-bold w-4 h-4 rounded-full flex items-center justify-center">3</span>
</a>

<a href="#" class="js-account-toggle hidden sm:flex items-center space-x-1.5 text-[14px] font-medium hover:text-blue-600 transition-colors pl-1 cursor-pointer select-none">
    <svg class="js-account-icon w-5 h-5 stroke-[2]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" stroke-linecap="round" stroke-linejoin="round"></path>
    </svg>
    <span class="js-account-label">Account</span>
</a>

<?php include_once 'includes/account.php'; ?>

</a>
</div>
</div>

<!-- Floating Search Bar Drawer (Expands below header when search icon clicked) -->
<div id="floatingSearch" class="hidden absolute top-full left-0 w-full bg-white border-b border-slate-200 shadow-md p-3 px-4 transition-all z-40">
  <form action="#" method="GET" class="max-w-[700px] mx-auto flex items-center gap-2">
    <div class="relative flex-grow">
      <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/></svg>
      </span>
      <input type="text" placeholder="Search supplements, workouts, plans..." class="w-full pl-9 pr-4 py-2 bg-slate-50 border border-slate-300 rounded-lg text-sm text-slate-800 focus:outline-none focus:border-blue-600 focus:ring-1 focus:ring-blue-600">
    </div>
    <button type="submit" class="px-4 py-2 bg-blue-600 text-white font-medium text-sm rounded-lg hover:bg-blue-700 transition-colors shrink-0">
      Search
    </button>
  </form>
</div>
</header>
<!-- END: MainHeader -->

<!-- Mobile Slide-Out Side Navigation Drawer -->
<div id="mobileDrawerBackdrop" class="fixed inset-0 bg-black/50 z-50 hidden transition-opacity"></div>
<div id="mobileDrawer" class="fixed top-0 left-0 w-[280px] h-full bg-white shadow-2xl z-50 transform -translate-x-full transition-transform duration-300 flex flex-col">
  <div class="p-4 border-b border-slate-200 flex items-center justify-between">
    <span class="font-bold text-slate-900 text-lg">Menu</span>
    <button id="closeDrawerBtn" aria-label="Close Menu" class="p-1.5 text-slate-500 hover:text-slate-800 rounded-lg">
      <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
    </button>
  </div>
  <div class="flex-grow overflow-y-auto py-4 px-4 space-y-2 text-slate-700 font-medium">
    <a class="flex items-center gap-3 px-3 py-2.5 rounded-lg hover:bg-slate-100 hover:text-blue-600 transition-colors" href="index.php">
        <svg class="w-5 h-5 text-slate-500 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25"></path></svg>
        Home
    </a>
    <a class="flex items-center gap-3 px-3 py-2.5 rounded-lg hover:bg-slate-100 hover:text-blue-600 transition-colors" href="shop.php">
        <svg class="w-5 h-5 text-slate-500 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007zM8.625 10.5a.375.375 0 11-.75 0 .375.375 0 01.75 0zm7.5 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z"></path></svg>
        Shop
    </a>
    <a class="flex items-center gap-3 px-3 py-2.5 rounded-lg hover:bg-slate-100 hover:text-blue-600 transition-colors" href="gymn/membership.php">
        <svg class="w-5 h-5 text-slate-500 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zM4 19.235v-.11a6.375 6.375 0 0112.75 0v.109A12.318 12.318 0 0110.374 21c-2.331 0-4.512-.645-6.374-1.766z"></path></svg>
        Join Training
    </a>
    <a class="flex items-center gap-3 px-3 py-2.5 rounded-lg hover:bg-slate-100 hover:text-blue-600 transition-colors" href="gymn/gymn.php">
        <svg class="w-5 h-5 text-slate-500 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z"></path></svg>
        Gym Services
    </a>
    <a class="flex items-center gap-3 px-3 py-2.5 rounded-lg hover:bg-slate-100 hover:text-blue-600 transition-colors" href="about.php">
        <svg class="w-5 h-5 text-slate-500 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z"></path></svg>
        About
    </a>
    <a class="flex items-center gap-3 px-3 py-2.5 rounded-lg hover:bg-slate-100 hover:text-blue-600 transition-colors" href="contact.php">
        <svg class="w-5 h-5 text-slate-500 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"></path></svg>
        Contact
    </a>
  </div>
  <div class="p-4 border-t border-slate-200">
    <a class="flex items-center justify-center gap-2 w-full px-4 py-2.5 rounded-xl bg-blue-600 text-white font-medium text-sm shadow-sm hover:bg-blue-700 transition-colors" href="portal/portalogin.php">
        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0012 15.75a7.488 7.488 0 00-5.982 2.975m11.963 0a9 9 0 10-11.963 0m11.963 0A8.966 8.966 0 0112 21a8.966 8.966 0 01-5.982-2.275M15 9.75a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
        Member Portal
    </a>
  </div>
</div>

<!-- BEGIN: HeroSection -->
<main class="flex-grow flex flex-col justify-center py-6 px-4 sm:px-6">
<div class="max-w-[1060px] w-full mx-auto">
<!-- Outer Carousel Card Container with Matching Radial Gradient -->
<section class="relative rounded-[2rem] overflow-hidden banner-gradient carousel-viewport" data-purpose="hero-banner">
  
  <!-- Sliding Track Container -->
  <div id="carouselTrack" class="carousel-track">
    
    <!-- SLIDE 1: Supplements (Animated) -->
    <div class="carousel-slide active px-6 sm:px-10 lg:px-14 py-8 md:py-12 grid grid-cols-1 lg:grid-cols-12 gap-6 items-center">
      <div class="lg:col-span-7 flex flex-col items-start z-10 space-y-4">
        <p class="text-blue-600 text-[15px] font-semibold text-animate text-delay-1">Fuel Your Gains</p>
        <h1 class="text-slate-900 text-3xl sm:text-4xl lg:text-[42px] font-extrabold tracking-tight leading-[1.2] max-w-[500px] text-animate text-delay-2">
          Ultra-Protein & Performance Supplements
        </h1>
        <div class="pt-2 flex flex-wrap items-center gap-4 text-animate text-delay-3">
          <a class="inline-flex items-center justify-center px-7 py-3 rounded-full bg-blue-600 text-white font-semibold text-[14px] shadow-sm hover:bg-blue-700 transition-colors" href="#">Shop Supplements</a>
          <a class="inline-flex items-center gap-2 text-slate-800 font-medium text-[14px] hover:text-blue-600 transition-colors group" href="#">
            <span>View Catalog</span>
            <span class="text-base transition-transform group-hover:translate-x-1">→</span>
          </a>
        </div>
      </div>
      <div class="lg:col-span-5 flex justify-center lg:justify-end items-center relative overflow-hidden">
        <div class="relative w-full h-64 sm:h-72 lg:h-80 flex items-center justify-center">
          <img alt="Whey Protein Supplement Tub" class="max-h-full max-w-full object-contain filter drop-shadow-[0_20px_25px_rgba(0,0,0,0.3)] select-none pointer-events-none animated-img" src="assets/images/3.png"/>
        </div>
      </div>
    </div>

    <!-- SLIDE 2: Professional Gym Training (Animated) -->
    <div class="carousel-slide px-6 sm:px-10 lg:px-14 py-8 md:py-12 grid grid-cols-1 lg:grid-cols-12 gap-6 items-center">
      <div class="lg:col-span-7 flex flex-col items-start z-10 space-y-4">
        <p class="text-blue-600 text-[15px] font-semibold text-animate text-delay-1">Expert Coaching</p>
        <h1 class="text-slate-900 text-3xl sm:text-4xl lg:text-[42px] font-extrabold tracking-tight leading-[1.2] max-w-[500px] text-animate text-delay-2">
          Customized Pro Gym Training & Workout Plans
        </h1>
        <div class="pt-2 flex flex-wrap items-center gap-4 text-animate text-delay-3">
          <a class="inline-flex items-center justify-center px-7 py-3 rounded-full bg-blue-600 text-white font-semibold text-[14px] shadow-sm hover:bg-blue-700 transition-colors" href="#">Start Training</a>
          <a class="inline-flex items-center gap-2 text-slate-800 font-medium text-[14px] hover:text-blue-600 transition-colors group" href="#">
            <span>Meet Coaches</span>
            <span class="text-base transition-transform group-hover:translate-x-1">→</span>
          </a>
        </div>
      </div>
      <div class="lg:col-span-5 flex justify-center lg:justify-end items-center relative overflow-hidden">
        <div class="relative w-full h-64 sm:h-72 lg:h-80 flex items-center justify-center">
          <img alt="Gym Dumbbells and Fitness Equipment" class="max-h-full max-w-full object-contain filter drop-shadow-[0_20px_25px_rgba(0,0,0,0.3)] select-none pointer-events-none animated-img" src="assets/images/4.png"/>
        </div>
      </div>
    </div>

    <!-- SLIDE 3: Shredded Bodybuilding / Transformation -->
    <div class="carousel-slide px-6 sm:px-10 lg:px-14 py-8 md:py-12 grid grid-cols-1 lg:grid-cols-12 gap-6 items-center">
      <div class="lg:col-span-7 flex flex-col items-start z-10 space-y-4">
        <p class="text-blue-600 text-[15px] font-semibold text-animate text-delay-1">Elite Results</p>
        <h1 class="text-slate-900 text-3xl sm:text-4xl lg:text-[42px] font-extrabold tracking-tight leading-[1.2] max-w-[500px] text-animate text-delay-2">
          Transform Your Physique With Proven Guidance
        </h1>
        <div class="pt-2 flex flex-wrap items-center gap-4 text-animate text-delay-3">
          <a class="inline-flex items-center justify-center px-7 py-3 rounded-full bg-blue-600 text-white font-semibold text-[14px] shadow-sm hover:bg-blue-700 transition-colors" href="#">Join Program</a>
          <a class="inline-flex items-center gap-2 text-slate-800 font-medium text-[14px] hover:text-blue-600 transition-colors group" href="#">
            <span>Success Stories</span>
            <span class="text-base transition-transform group-hover:translate-x-1">→</span>
          </a>
        </div>
      </div>
      <div class="lg:col-span-5 flex justify-center lg:justify-end items-center relative overflow-hidden">
        <div class="relative w-full h-64 sm:h-72 lg:h-80 flex items-center justify-center">
          <img alt="Fitness Gear and Kettlebell" class="max-h-full max-w-full object-contain filter drop-shadow-[0_20px_25px_rgba(0,0,0,0.3)] select-none pointer-events-none" src="assets/images/1.png"/>
        </div>
      </div>
    </div>

  </div>
</section>

<!-- Carousel Pagination Indicator Dots -->
<nav aria-label="Slides" class="flex justify-center items-center gap-2 mt-6" data-purpose="carousel-pagination">
  <button onclick="currentSlide(0)" aria-label="Slide 1" class="dot w-6 h-2 rounded-full bg-blue-600 transition-all" type="button"></button>
  <button onclick="currentSlide(1)" aria-label="Slide 2" class="dot w-2 h-2 rounded-full bg-slate-300 hover:bg-slate-400 transition-all" type="button"></button>
  <button onclick="currentSlide(2)" aria-label="Slide 3" class="dot w-2 h-2 rounded-full bg-slate-300 hover:bg-slate-400 transition-all" type="button"></button>
</nav>

</div>
</main>
<!-- END: HeroSection -->

<!-- Interactive JavaScript for Search Toggle & Mobile Side Drawer -->
<script>
  // Search toggle logic
  const searchToggleBtn = document.getElementById('searchToggleBtn');
  const floatingSearch = document.getElementById('floatingSearch');

  searchToggleBtn.addEventListener('click', (e) => {
    e.stopPropagation();
    floatingSearch.classList.toggle('hidden');
    if (!floatingSearch.classList.contains('hidden')) {
      floatingSearch.querySelector('input').focus();
    }
  });

  // Close search when clicking outside
  window.addEventListener('click', (e) => {
    if (!floatingSearch.contains(e.target) && e.target !== searchToggleBtn && !searchToggleBtn.contains(e.target)) {
      floatingSearch.classList.add('hidden');
    }
  });

  // Mobile side drawer toggle logic
  const menuToggleBtn = document.getElementById('menuToggleBtn');
  const mobileDrawer = document.getElementById('mobileDrawer');
  const mobileDrawerBackdrop = document.getElementById('mobileDrawerBackdrop');
  const closeDrawerBtn = document.getElementById('closeDrawerBtn');

  function openDrawer() {
    mobileDrawer.classList.remove('-translate-x-full');
    mobileDrawerBackdrop.classList.remove('hidden');
    document.body.style.overflow = 'hidden';
  }

  function closeDrawer() {
    mobileDrawer.classList.add('-translate-x-full');
    mobileDrawerBackdrop.classList.add('hidden');
    document.body.style.overflow = '';
  }

  menuToggleBtn.addEventListener('click', openDrawer);
  closeDrawerBtn.addEventListener('click', closeDrawer);
  mobileDrawerBackdrop.addEventListener('click', closeDrawer);

  // Carousel Sliding Script
  let slideIndex = 0;
  const track = document.getElementById('carouselTrack');
  const slides = document.querySelectorAll('.carousel-slide');
  const dots = document.querySelectorAll('.dot');
  const totalSlides = 3;

  function updateSlide(n) {
    slideIndex = (n + totalSlides) % totalSlides;
    
    track.style.transform = `translateX(-${slideIndex * (100 / totalSlides)}%)`;

    slides.forEach((slide, index) => {
      if (index === slideIndex) {
        const img = slide.querySelector('.animated-img');
        if (img) {
          img.style.animation = 'none';
          void img.offsetWidth;
          img.style.animation = '';
        }
        
        const textElements = slide.querySelectorAll('.text-animate');
        textElements.forEach(el => {
          el.style.animation = 'none';
          void el.offsetWidth;
          el.style.animation = '';
        });

        slide.classList.add('active');
      } else {
        slide.classList.remove('active');
      }
    });

    dots.forEach((dot, index) => {
      if (index === slideIndex) {
        dot.classList.remove('w-2', 'bg-slate-300');
        dot.classList.add('w-6', 'bg-blue-600');
      } else {
        dot.classList.remove('w-6', 'bg-blue-600');
        dot.classList.add('w-2', 'bg-slate-300');
      }
    });
  }

  function currentSlide(n) {
    updateSlide(n);
  }

  setInterval(() => {
    updateSlide(slideIndex + 1);
  }, 5000);
</script>
</body>
</html>