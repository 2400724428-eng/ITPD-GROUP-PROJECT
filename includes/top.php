
<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/db_connect.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>ApexFit - Supplements & Pro Training</title>

<!-- Tailwind CSS v3 with forms and container-queries -->
<link href="../src/output.css" rel="stylesheet">

<!-- Google Fonts: Inter & Plus Jakarta Sans -->
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
              cardBg: '#ffffff',
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

    .carousel-viewport {
      overflow: hidden;
      width: 100%;
      position: relative;
      isolation: isolate;
      border-radius: 2rem;
    }

    .carousel-track {
      display: flex;
      width: 300%;
      position: relative;
      z-index: 1;
      transition: transform 0.6s cubic-bezier(0.25, 1, 0.5, 1);
      will-change: transform;
    }

    .carousel-slide {
      width: 33.333333%;
      flex-shrink: 0;
      box-sizing: border-box;
      position: relative;
    }

    /* WHITE CARD WITH CASCADING BLUE BACKGROUND */
    .banner-gradient {
      position: relative;
      isolation: isolate;
      background: #ffffff;
      border: 1px solid #dbeafe;
      box-shadow:
        0 25px 60px -15px rgba(30, 64, 175, 0.16),
        0 10px 25px -5px rgba(37, 99, 235, 0.08);
    }

    /* Soft blue cascade across the upper-right area */
    .banner-gradient::before {
      content: "";
      position: absolute;
      z-index: -1;
      top: -35%;
      right: -10%;
      width: 75%;
      height: 145%;
      background:
        radial-gradient(
          ellipse at 72% 30%,
          rgba(96, 165, 250, 0.48) 0%,
          rgba(147, 197, 253, 0.30) 30%,
          rgba(219, 234, 254, 0.14) 52%,
          transparent 75%
        );
      border-radius: 50% 0 0 50%;
      transform: rotate(-12deg);
      pointer-events: none;
    }

    /* Main cascading blue wave at the bottom */
    .banner-gradient::after {
      content: "";
      position: absolute;
      z-index: -1;
      right: -12%;
      bottom: -78%;
      width: 100%;
      height: 125%;
      background:
        linear-gradient(
          125deg,
          rgba(219, 234, 254, 0.95) 0%,
          rgba(147, 197, 253, 0.94) 28%,
          rgba(59, 130, 246, 0.93) 62%,
          rgba(29, 78, 216, 0.97) 100%
        );
      border-radius: 55% 0 0 0;
      transform: rotate(-8deg);
      pointer-events: none;
    }

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

    @keyframes breathingZoom {
      0%, 100% {
        transform: scale(1);
      }
      50% {
        transform: scale(1.06);
      }
    }

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

    .carousel-slide.active .animated-img {
      animation:
        popAndPulse 0.8s cubic-bezier(0.175, 0.885, 0.32, 1.275) forwards,
        breathingZoom 3s ease-in-out 0.8s infinite;
    }

    .carousel-slide.active .text-animate {
      animation: textFadeUp 0.7s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    }

    .carousel-slide.active .text-delay-1 {
      animation-delay: 0.1s;
    }

    .carousel-slide.active .text-delay-2 {
      animation-delay: 0.25s;
    }

    .carousel-slide.active .text-delay-3 {
      animation-delay: 0.4s;
    }

    /* Smooth blue buttons while preserving Tailwind classes */
    .carousel-slide .bg-blue-600 {
      transition: background-color 0.25s ease, transform 0.25s ease;
    }

    .carousel-slide .bg-blue-600:hover {
      background-color: #1d4ed8;
    }

    /* Mobile adjustments */
    @media (max-width: 640px) {
      .carousel-viewport {
        border-radius: 1.5rem;
      }

      .banner-gradient::before {
        right: -30%;
        width: 110%;
      }

      .banner-gradient::after {
        right: -35%;
        bottom: -82%;
        width: 125%;
        height: 115%;
      }
    }

    @media (prefers-reduced-motion: reduce) {
      .carousel-track {
        transition: none;
      }

      .carousel-slide.active .animated-img,
      .carousel-slide.active .text-animate {
        animation: none;
        opacity: 1;
        transform: none;
      }
    }
</style>
</head>

<body class="bg-slate-50 text-slate-800 antialiased min-h-screen flex flex-col">

<!-- HERO SECTION -->
<main class="flex-grow flex flex-col justify-center py-6 px-4 sm:px-6">

<div class="max-w-[1060px] w-full mx-auto">

<section
  class="relative rounded-[2rem] overflow-hidden banner-gradient carousel-viewport"
  data-purpose="hero-banner"
>
  <div id="carouselTrack" class="carousel-track">

    <!-- SLIDE 1 -->
    <div class="carousel-slide active px-6 sm:px-10 lg:px-14 py-8 md:py-12 grid grid-cols-1 lg:grid-cols-12 gap-6 items-center">

      <div class="lg:col-span-7 flex flex-col items-start z-10 space-y-4">

        <p class="text-blue-600 text-[15px] font-semibold text-animate text-delay-1">
          Fuel Your Gains
        </p>

        <h1 class="text-slate-900 text-3xl sm:text-4xl lg:text-[42px] font-extrabold tracking-tight leading-[1.2] max-w-[500px] text-animate text-delay-2">
          Ultra-Protein &amp; Performance Supplements
        </h1>

        <div class="pt-2 flex flex-wrap items-center gap-4 text-animate text-delay-3">
          <span class="inline-flex items-center justify-center px-7 py-3 rounded-full bg-blue-600 text-white font-semibold text-[14px] shadow-sm">
            Shop Supplements
          </span>
        </div>

      </div>

      <div class="lg:col-span-5 flex justify-center lg:justify-end items-center relative overflow-hidden z-10">

        <div class="relative w-full h-64 sm:h-72 lg:h-80 flex items-center justify-center">

          <img
            alt="Whey Protein Supplement Tub"
            class="max-h-full max-w-full object-contain filter drop-shadow-[0_20px_25px_rgba(0,0,0,0.3)] select-none pointer-events-none animated-img"
            src="assets/images/3.png"
          />

        </div>

      </div>

    </div>

    <!-- SLIDE 2 -->
    <div class="carousel-slide px-6 sm:px-10 lg:px-14 py-8 md:py-12 grid grid-cols-1 lg:grid-cols-12 gap-6 items-center">

      <div class="lg:col-span-7 flex flex-col items-start z-10 space-y-4">

        <p class="text-blue-600 text-[15px] font-semibold text-animate text-delay-1">
          Expert Coaching
        </p>

        <h1 class="text-slate-900 text-3xl sm:text-4xl lg:text-[42px] font-extrabold tracking-tight leading-[1.2] max-w-[500px] text-animate text-delay-2">
          Customized Pro Gym Training &amp; Workout Plans
        </h1>

        <div class="pt-2 flex flex-wrap items-center gap-4 text-animate text-delay-3">
          <span class="inline-flex items-center justify-center px-7 py-3 rounded-full bg-blue-600 text-white font-semibold text-[14px] shadow-sm">
            Start Training
          </span>
        </div>

      </div>

      <div class="lg:col-span-5 flex justify-center lg:justify-end items-center relative overflow-hidden z-10">

        <div class="relative w-full h-64 sm:h-72 lg:h-80 flex items-center justify-center">

          <img
            alt="Gym Dumbbells and Fitness Equipment"
            class="max-h-full max-w-full object-contain filter drop-shadow-[0_20px_25px_rgba(0,0,0,0.3)] select-none pointer-events-none animated-img"
            src="assets/images/4.png"
          />

        </div>

      </div>

    </div>

    <!-- SLIDE 3 -->
    <div class="carousel-slide px-6 sm:px-10 lg:px-14 py-8 md:py-12 grid grid-cols-1 lg:grid-cols-12 gap-6 items-center">

      <div class="lg:col-span-7 flex flex-col items-start z-10 space-y-4">

        <p class="text-blue-600 text-[15px] font-semibold text-animate text-delay-1">
          Elite Results
        </p>

        <h1 class="text-slate-900 text-3xl sm:text-4xl lg:text-[42px] font-extrabold tracking-tight leading-[1.2] max-w-[500px] text-animate text-delay-2">
          Transform Your Physique With Proven Guidance
        </h1>

        <div class="pt-2 flex flex-wrap items-center gap-4 text-animate text-delay-3">
          <span class="inline-flex items-center justify-center px-7 py-3 rounded-full bg-blue-600 text-white font-semibold text-[14px] shadow-sm">
            Join Program
          </span>
        </div>

      </div>

      <div class="lg:col-span-5 flex justify-center lg:justify-end items-center relative overflow-hidden z-10">

        <div class="relative w-full h-64 sm:h-72 lg:h-80 flex items-center justify-center">

          <img
            alt="Fitness Gear and Kettlebell"
            class="max-h-full max-w-full object-contain filter drop-shadow-[0_20px_25px_rgba(0,0,0,0.3)] select-none pointer-events-none"
            src="assets/images/1.png"
          />

        </div>

      </div>

    </div>

  </div>
</section>

<!-- CAROUSEL PAGINATION -->
<nav aria-label="Slides" class="flex justify-center items-center gap-2 mt-6" data-purpose="carousel-pagination">

  <button
    onclick="currentSlide(0)"
    aria-label="Slide 1"
    class="dot w-6 h-2 rounded-full bg-blue-600 transition-all"
    type="button"
  ></button>

  <button
    onclick="currentSlide(1)"
    aria-label="Slide 2"
    class="dot w-2 h-2 rounded-full bg-slate-300 hover:bg-slate-400 transition-all"
    type="button"
  ></button>

  <button
    onclick="currentSlide(2)"
    aria-label="Slide 3"
    class="dot w-2 h-2 rounded-full bg-slate-300 hover:bg-slate-400 transition-all"
    type="button"
  ></button>

</nav>

</div>
</main>

<script>
  let slideIndex = 0;

  const track = document.getElementById('carouselTrack');
  const slides = document.querySelectorAll('.carousel-slide');
  const dots = document.querySelectorAll('.dot');
  const totalSlides = slides.length;

  function updateSlide(n) {
    if (!track || totalSlides === 0) return;

    slideIndex = (n + totalSlides) % totalSlides;

    track.style.transform =
      `translateX(-${slideIndex * (100 / totalSlides)}%)`;

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
        dot.setAttribute('aria-current', 'true');
      } else {
        dot.classList.remove('w-6', 'bg-blue-600');
        dot.classList.add('w-2', 'bg-slate-300');
        dot.removeAttribute('aria-current');
      }
    });
  }

  function currentSlide(n) {
    updateSlide(n);
  }

  // Automatically change slides every five seconds.
  setInterval(() => {
    updateSlide(slideIndex + 1);
  }, 5000);
</script>

</body>
</html>
