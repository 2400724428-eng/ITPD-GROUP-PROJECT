<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>ApexFit - Supplements & Pro Training</title>
<!-- Tailwind CSS v3 with forms and container-queries -->
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
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
    <a class="flex items-center gap-1.5 whitespace-nowrap hover:text-blue-600 transition-colors" href="index.html">
        <svg class="w-4 h-4 text-slate-500 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
        Home
    </a>
    <a class="flex items-center gap-1.5 whitespace-nowrap hover:text-blue-600 transition-colors" href="supplements.html">
        <svg class="w-4 h-4 text-slate-500 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
        Supplements
    </a>
    <a class="flex items-center gap-1.5 whitespace-nowrap hover:text-blue-600 transition-colors" href="gym-training.html">
        <svg class="w-4 h-4 text-slate-500 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 13.5l10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75z"></path></svg>
        Gym Training
    </a>
    <a class="flex items-center gap-1.5 whitespace-nowrap hover:text-blue-600 transition-colors" href="calculator.html">
        <svg class="w-4 h-4 text-slate-500 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
        Calculator
    </a>
    <a class="flex items-center gap-1.5 whitespace-nowrap hover:text-blue-600 transition-colors" href="about.html">
        <svg class="w-4 h-4 text-slate-500 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        About
    </a>
    <a class="flex items-center gap-1.5 whitespace-nowrap hover:text-blue-600 transition-colors" href="contact.html">
        <svg class="w-4 h-4 text-slate-500 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
        Contact
    </a>
    <a class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full border border-slate-300 text-[13px] font-medium text-slate-800 hover:border-blue-400 hover:bg-slate-50 transition-all shadow-sm whitespace-nowrap shrink-0" href="portal.html">
        <svg class="w-4 h-4 text-slate-600 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
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

<a class="hidden sm:flex items-center space-x-1.5 text-[14px] font-medium hover:text-blue-600 transition-colors pl-1" href="#">
<svg class="w-5 h-5 stroke-[2]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
<path d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" stroke-linecap="round" stroke-linejoin="round"></path>
</svg>
<span>Account</span>
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
    <a class="flex items-center gap-3 px-3 py-2.5 rounded-lg hover:bg-slate-100 hover:text-blue-600 transition-colors" href="index.html">
        <svg class="w-5 h-5 text-slate-500 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
        Home
    </a>
    <a class="flex items-center gap-3 px-3 py-2.5 rounded-lg hover:bg-slate-100 hover:text-blue-600 transition-colors" href="supplements.html">
        <svg class="w-5 h-5 text-slate-500 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
        Supplements
    </a>
    <a class="flex items-center gap-3 px-3 py-2.5 rounded-lg hover:bg-slate-100 hover:text-blue-600 transition-colors" href="gym-training.html">
        <svg class="w-5 h-5 text-slate-500 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 13.5l10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75z"></path></svg>
        Gym Training
    </a>
    <a class="flex items-center gap-3 px-3 py-2.5 rounded-lg hover:bg-slate-100 hover:text-blue-600 transition-colors" href="calculator.html">
        <svg class="w-5 h-5 text-slate-500 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
        Calculator
    </a>
    <a class="flex items-center gap-3 px-3 py-2.5 rounded-lg hover:bg-slate-100 hover:text-blue-600 transition-colors" href="about.html">
        <svg class="w-5 h-5 text-slate-500 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        About
    </a>
    <a class="flex items-center gap-3 px-3 py-2.5 rounded-lg hover:bg-slate-100 hover:text-blue-600 transition-colors" href="contact.html">
        <svg class="w-5 h-5 text-slate-500 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
        Contact
    </a>
  </div>
  <div class="p-4 border-t border-slate-200">
    <a class="flex items-center justify-center gap-2 w-full px-4 py-2.5 rounded-xl bg-blue-600 text-white font-medium text-sm shadow-sm hover:bg-blue-700 transition-colors" href="portal.html">
        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
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