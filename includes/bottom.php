<!DOCTYPE html>
<html lang="en"><head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>Gaming Promotion &amp; Newsletter</title>
<!-- Tailwind CSS CDN with forms plugin -->
<link href="../src/output.css" rel="stylesheet">

<!-- Google Fonts: Plus Jakarta Sans / Inter -->
<link href="https://fonts.googleapis.com" rel="preconnect"/>
<link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect"/>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&amp;display=swap" rel="stylesheet"/>
<script>
    tailwind.config = {
      theme: {
        extend: {
          fontFamily: {
            sans: ['"Plus Jakarta Sans"', 'sans-serif'],
          },
          colors: {
            brand: {
              orange: '#E15008',
              'orange-hover': '#C84302',
              dark: '#1C273B',
              muted: '#627084',
              subtle: '#8896A6',
              bgLight: '#E8EFF8',
            }
          }
        }
      }
    }
  </script>
<style data-purpose="custom-layout">
    body {
      font-family: 'Plus Jakarta Sans', sans-serif;
      -webkit-font-smoothing: antialiased;
    }
    /* Banner gradient styling to match the reference */
    .banner-gradient {
      background: radial-gradient(circle at 50% 40%, #EFF4FB 0%, #DFE8F5 100%);
    }
  </style>
</head>
<body class="bg-white min-h-screen text-slate-800 antialiased py-6 sm:py-10 px-4 sm:px-6 lg:px-8">
<main class="max-w-[1240px] mx-auto space-y-20 lg:space-y-28">
<!-- BEGIN: PromotionalBanner -->
<section aria-label="Promotional Gaming Hero" class="banner-gradient rounded-[24px] sm:rounded-[32px] overflow-hidden relative shadow-sm min-h-[380px] sm:min-h-[420px] flex items-center" data-purpose="hero-banner">

<!-- Main Banner Content Grid -->
<div class="relative z-10 w-full grid grid-cols-1 lg:grid-cols-12 items-center px-6 sm:px-12 py-10 lg:py-4 gap-8">
<!-- Left Item: High-end Wireless Sound Speaker -->
<div class="lg:col-span-4 flex justify-center items-center relative order-2 lg:order-1" data-purpose="speaker-display">
<div class="relative w-64 sm:w-72 lg:w-80 max-w-full drop-shadow-[0_20px_25px_rgba(0,0,0,0.18)] transition-transform duration-300 hover:scale-105">
<img alt="Black high fidelity cylinder gaming Bluetooth speaker" class="w-full h-auto object-contain max-h-[290px] mx-auto" src="assets/images/pop.png"/>
</div>
</div>
<!-- Center Content: Title, Description, and CTA -->
<div class="lg:col-span-4 text-center flex flex-col items-center justify-center order-1 lg:order-2 px-2" data-purpose="banner-text-cta">
<h1 class="text-3xl sm:text-4xl lg:text-[40px] font-extrabold text-[#192437] tracking-tight leading-[1.2] max-w-md">
            Level Up Your<br class="hidden sm:inline"/>  Muscle Gains 
          </h1>
<p class="mt-4 text-sm sm:text-base text-brand-muted font-normal max-w-sm leading-relaxed">
          "From explosive energy to laser focus—everything you need to dominate your workout."
          </p>
<div class="mt-6">
<a class="inline-flex items-center justify-center gap-2.5 px-8 py-3.5 bg-blue-600 hover:bg-blue-700 text-white font-medium text-base rounded-md shadow-md hover:shadow-lg transition-all duration-200 active:scale-95 group" data-purpose="cta-button" href="#" role="button">
<span>Join now</span>
<svg class="w-4 h-4 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
<path d="M14 5l7 7m0 0l-7 7m7-7H3" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2"></path>
</svg>
</a>
</div>
</div>
<!-- Right Item: Wireless White Controller -->
<div class="lg:col-span-4 flex justify-center items-center order-3" data-purpose="controller-display">
<div class="relative w-64 sm:w-72 lg:w-80 max-w-full drop-shadow-[0_25px_30px_rgba(0,0,0,0.14)] transition-transform duration-300 hover:scale-105">
<img alt="Modern white wireless Xbox style gaming controller" class="w-full h-auto object-contain max-h-[300px] mx-auto" src="assets/images/blue.png"/>
</div>
</div>
</div>
</section>
<!-- END: PromotionalBanner -->
<!-- BEGIN: NewsletterSubscription -->
<section aria-label="Newsletter Subscription" class="text-center py-6 sm:py-8 max-w-2xl mx-auto px-4" data-purpose="newsletter-section">
<!-- Headline & Subtitle -->
<h2 class="text-3xl sm:text-[38px] font-extrabold text-[#1E293B] tracking-tight leading-tight">
        Subscribe now &amp; get 20% off
      </h2>
<p class="mt-3 text-sm sm:text-base text-[#8896A6] font-normal leading-normal">
      Join our community today and claim your instant discount.
      </p>
<!-- Subscription Input & Action -->
<form action="#" class="mt-8 sm:mt-9 flex flex-col sm:flex-row items-center justify-center max-w-[540px] mx-auto shadow-sm" data-purpose="subscription-form" method="POST" onsubmit="event.preventDefault();">
<div class="relative w-full">
<label class="sr-only" for="email-address">Email address</label>
<input class="w-full h-13 py-3.5 px-5 bg-white text-slate-700 placeholder-[#9EACB9] text-base border border-[#D5DEE7] sm:border-r-0 rounded-t-md sm:rounded-l-md sm:rounded-tr-none focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500 transition-colors" id="email-address" name="email" placeholder="Enter your email id" required="" type="email"/>
</div>
<button class="w-full sm:w-auto min-w-[150px] h-13 py-3.5 px-8 bg-blue-600 hover:bg-blue-700 text-white font-semibold text-base rounded-b-md sm:rounded-r-md sm:rounded-bl-none transition-colors duration-200 active:bg-blue-800 shadow-sm" type="submit">
          Subscribe
        </button>
</form>
</section>
<!-- END: NewsletterSubscription -->
</main>
</body></html>