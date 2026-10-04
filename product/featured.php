<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8"/>
  <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
  <title>Featured Products - ApexFit</title>
  <!-- Tailwind CSS v3 with Plugins -->
  <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
  <!-- Google Fonts: Inter -->
  <link href="https://fonts.googleapis.com" rel="preconnect"/>
  <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect"/>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&amp;display=swap" rel="stylesheet"/>
  <style data-purpose="typography">
    body {
      font-family: 'Inter', sans-serif;
    }
  </style>
  <style data-purpose="custom-animations">
    /* Smooth card lift and shadow transition */
    .product-card {
      transition: transform 0.35s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.35s cubic-bezier(0.16, 1, 0.3, 1);
    }
    .product-card:hover {
      transform: translateY(-6px);
      box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.15), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    }

    /* Image zoom effect */
    .product-card-image {
      transition: transform 0.6s cubic-bezier(0.16, 1, 0.3, 1);
    }
    .product-card:hover .product-card-image {
      transform: scale(1.08) rotate(1deg);
    }

    /* Hide scrollbars for clean sliding view */
    .no-scrollbar::-webkit-scrollbar {
      display: none;
    }
    .no-scrollbar {
      -ms-overflow-style: none;
      scrollbar-width: none;
    }

    /* Entrance Keyframe Animations */
    @keyframes fadeInSlide {
      0% {
        opacity: 0;
        transform: translateY(25px);
      }
      100% {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .animate-entrance {
      animation: fadeInSlide 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    }

    /* Button active press feedback */
    .control-btn {
      transition: transform 0.15s ease, background-color 0.2s ease;
    }
    .control-btn:active {
      transform: scale(0.92);
    }
  </style>
</head>
<body class="bg-gradient-to-br from-slate-50 to-slate-100 text-slate-800 antialiased min-h-screen flex items-center justify-center p-3 sm:p-6 lg:p-8">

<!-- BEGIN: FeaturedProductsSection -->
<section aria-labelledby="featured-products-heading" class="max-w-6xl mx-auto w-full flex flex-col items-center justify-center animate-entrance" data-purpose="featured-products-section">
  
  <!-- BEGIN: SectionHeader -->
  <header class="text-center mb-6 md:mb-10 w-full flex items-center justify-between px-2" data-purpose="section-header">
    <div>
      <h2 class="text-xl sm:text-2xl md:text-3xl font-extrabold tracking-tight text-slate-900 mb-1 text-left" id="featured-products-heading">
        Featured Supplements
      </h2>
      <div aria-hidden="true" class="w-16 h-1 bg-neutral-900 rounded-full transition-all duration-300 hover:w-24"></div>
    </div>
    <!-- Scroll Controls for Products -->
    <div class="flex gap-2">
      <button type="button" class="control-btn scroll-left-btn p-2 sm:p-2.5 rounded-full bg-white hover:bg-slate-200 shadow-sm text-slate-800 border border-slate-200 transition-colors" aria-label="Scroll left">
        <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
      </button>
      <button type="button" class="control-btn scroll-right-btn p-2 sm:p-2.5 rounded-full bg-white hover:bg-slate-200 shadow-sm text-slate-800 border border-slate-200 transition-colors" aria-label="Scroll right">
        <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
      </button>
    </div>
  </header>
  <!-- END: SectionHeader -->

  <!-- BEGIN: Layout Container (Stacked on Mobile, Side-by-Side on Desktop) -->
  <div class="w-full flex flex-col lg:flex-row gap-6 items-stretch">

    <!-- Fixed Promotional Banner Card (Stacks nicely on top on mobile) -->
    <article class="product-card group relative rounded-xl overflow-hidden h-[300px] sm:h-[340px] shadow-md flex flex-col justify-end w-full lg:w-[360px] bg-slate-900 shrink-0 border border-slate-800" data-purpose="promo-poster-card">
      <div class="absolute inset-0 z-0 flex items-center justify-center overflow-hidden">
        <img alt="Fitness Training Promotional Poster" class="w-full h-full object-cover opacity-60 group-hover:scale-110 transition-transform duration-700 ease-out" loading="lazy" src="assets/images/banner.png"/>
      </div>
      <div class="relative z-10 p-5 sm:p-6 flex flex-col items-start justify-end bg-gradient-to-t from-black/95 via-black/60 to-transparent w-full">
        <span class="text-xs font-bold uppercase tracking-wider text-amber-400 mb-1">Special Promo</span>
        <h3 class="text-xl sm:text-2xl font-bold text-white leading-tight mb-1 group-hover:text-amber-100 transition-colors">
          Summer Shred Challenge: Up to 40% Off
        </h3>
        <p class="text-white/90 text-xs sm:text-sm font-normal leading-snug mb-3 max-w-lg">
          Level up your workouts with our elite stacks and performance bundles. Claim your discount today.
        </p>
        <div class="w-full">
          <a aria-label="Shop the sale" class="inline-flex items-center gap-1.5 bg-neutral-900 hover:bg-black text-white text-xs sm:text-sm font-semibold px-4 py-2 rounded-lg shadow transition-all duration-200 hover:gap-2" href="#featured-products-heading">
            <span>Claim Offer</span>
            <svg class="w-3.5 h-3.5 stroke-current stroke-2 fill-none" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M5 12h14"></path><path d="M12 5l7 7-7 7"></path></svg>
          </a>
        </div>
      </div>
    </article>

    <!-- Sliding Products Track Container (10 items) -->
    <div class="w-full relative overflow-hidden flex-grow product-slider-wrapper py-2">
      <div class="flex gap-4 sm:gap-5 overflow-x-auto no-scrollbar snap-x snap-mandatory scroll-smooth pb-4 pt-1 w-full product-slider-track">

        <!-- Card 1: Platinum Whey -->
        <article class="product-card group relative rounded-xl overflow-hidden h-[340px] shadow-sm flex flex-col justify-end flex-none w-[240px] sm:w-[260px] snap-start bg-white border border-slate-100">
          <div class="absolute inset-0 z-0 flex items-center justify-center p-4 bg-slate-50/50 overflow-hidden">
            <img alt="Platinum Whey" class="product-card-image max-h-[75%] max-w-[75%] object-contain mix-blend-multiply" loading="lazy" src="https://images.unsplash.com/photo-1546483875-ad9014c88eba?auto=format&fit=crop&w=600&q=80"/>
          </div>
          <div class="relative z-10 p-4 sm:p-5 flex flex-col items-start justify-end bg-gradient-to-t from-black/95 via-black/70 to-transparent w-full">
            <h3 class="text-lg sm:text-xl font-bold text-white leading-tight mb-1">Platinum Whey</h3>
            <p class="text-white/90 text-xs sm:text-sm font-normal leading-snug mb-3 line-clamp-2">25g Ultra-Pure Protein per serving for lean mass recovery.</p>
            <div class="w-full"><a class="inline-flex items-center gap-1.5 bg-neutral-900 hover:bg-black text-white text-xs sm:text-sm font-semibold px-4 py-2 rounded-lg shadow transition-all duration-200" href="product-detail.php?id=1"><span>Buy now</span></a></div>
          </div>
        </article>

        <!-- Card 2: Pure Creatine -->
        <article class="product-card group relative rounded-xl overflow-hidden h-[340px] shadow-sm flex flex-col justify-end flex-none w-[240px] sm:w-[260px] snap-start bg-white border border-slate-100">
          <div class="absolute inset-0 z-0 flex items-center justify-center p-4 bg-slate-50/50 overflow-hidden">
            <img alt="Pure Creatine" class="product-card-image max-h-[75%] max-w-[75%] object-contain mix-blend-multiply" loading="lazy" src="https://images.unsplash.com/photo-1579722821273-0f6c7d44362f?auto=format&fit=crop&w=600&q=80"/>
          </div>
          <div class="relative z-10 p-4 sm:p-5 flex flex-col items-start justify-end bg-gradient-to-t from-black/95 via-black/70 to-transparent w-full">
            <h3 class="text-lg sm:text-xl font-bold text-white leading-tight mb-1">Pure Creatine</h3>
            <p class="text-white/90 text-xs sm:text-sm font-normal leading-snug mb-3 line-clamp-2">Micronized powder for explosive strength and muscle gains.</p>
            <div class="w-full"><a class="inline-flex items-center gap-1.5 bg-neutral-900 hover:bg-black text-white text-xs sm:text-sm font-semibold px-4 py-2 rounded-lg shadow transition-all duration-200" href="product-detail.php?id=2"><span>Buy now</span></a></div>
          </div>
        </article>

        <!-- Card 3: Vortex Pre-Workout -->
        <article class="product-card group relative rounded-xl overflow-hidden h-[340px] shadow-sm flex flex-col justify-end flex-none w-[240px] sm:w-[260px] snap-start bg-white border border-slate-100">
          <div class="absolute inset-0 z-0 flex items-center justify-center p-4 bg-slate-50/50 overflow-hidden">
            <img alt="Vortex Pre-Workout" class="product-card-image max-h-[75%] max-w-[75%] object-contain mix-blend-multiply" loading="lazy" src="https://images.unsplash.com/photo-1584735935682-2f2b69dff9d2?auto=format&fit=crop&w=600&q=80"/>
          </div>
          <div class="relative z-10 p-4 sm:p-5 flex flex-col items-start justify-end bg-gradient-to-t from-black/95 via-black/70 to-transparent w-full">
            <h3 class="text-lg sm:text-xl font-bold text-white leading-tight mb-1">Vortex Pre-Workout</h3>
            <p class="text-white/90 text-xs sm:text-sm font-normal leading-snug mb-3 line-clamp-2">Intense mental focus, massive pumps, and jitter-free energy.</p>
            <div class="w-full"><a class="inline-flex items-center gap-1.5 bg-neutral-900 hover:bg-black text-white text-xs sm:text-sm font-semibold px-4 py-2 rounded-lg shadow transition-all duration-200" href="product-detail.php?id=3"><span>Buy now</span></a></div>
          </div>
        </article>

        <!-- Card 4: BCAA Recovery -->
        <article class="product-card group relative rounded-xl overflow-hidden h-[340px] shadow-sm flex flex-col justify-end flex-none w-[240px] sm:w-[260px] snap-start bg-white border border-slate-100">
          <div class="absolute inset-0 z-0 flex items-center justify-center p-4 bg-slate-50/50 overflow-hidden">
            <img alt="BCAA Recovery" class="product-card-image max-h-[75%] max-w-[75%] object-contain mix-blend-multiply" loading="lazy" src="https://images.unsplash.com/photo-1593095948071-474c5cc2989d?auto=format&fit=crop&w=600&q=80"/>
          </div>
          <div class="relative z-10 p-4 sm:p-5 flex flex-col items-start justify-end bg-gradient-to-t from-black/95 via-black/70 to-transparent w-full">
            <h3 class="text-lg sm:text-xl font-bold text-white leading-tight mb-1">BCAA Recovery</h3>
            <p class="text-white/90 text-xs sm:text-sm font-normal leading-snug mb-3 line-clamp-2">Advanced amino acids for reduced fatigue and faster repair.</p>
            <div class="w-full"><a class="inline-flex items-center gap-1.5 bg-neutral-900 hover:bg-black text-white text-xs sm:text-sm font-semibold px-4 py-2 rounded-lg shadow transition-all duration-200" href="product-detail.php?id=4"><span>Buy now</span></a></div>
          </div>
        </article>

        <!-- Card 5: Critical Mass Gainer -->
        <article class="product-card group relative rounded-xl overflow-hidden h-[340px] shadow-sm flex flex-col justify-end flex-none w-[240px] sm:w-[260px] snap-start bg-white border border-slate-100">
          <div class="absolute inset-0 z-0 flex items-center justify-center p-4 bg-slate-50/50 overflow-hidden">
            <img alt="Critical Mass Gainer" class="product-card-image max-h-[75%] max-w-[75%] object-contain mix-blend-multiply" loading="lazy" src="https://images.unsplash.com/photo-1579722820308-d74e571900a0?auto=format&fit=crop&w=600&q=80"/>
          </div>
          <div class="relative z-10 p-4 sm:p-5 flex flex-col items-start justify-end bg-gradient-to-t from-black/95 via-black/70 to-transparent w-full">
            <h3 class="text-lg sm:text-xl font-bold text-white leading-tight mb-1">Mass Gainer</h3>
            <p class="text-white/90 text-xs sm:text-sm font-normal leading-snug mb-3 line-clamp-2">High calorie formula packed with clean carbs and proteins.</p>
            <div class="w-full"><a class="inline-flex items-center gap-1.5 bg-neutral-900 hover:bg-black text-white text-xs sm:text-sm font-semibold px-4 py-2 rounded-lg shadow transition-all duration-200" href="product-detail.php?id=5"><span>Buy now</span></a></div>
          </div>
        </article>

        <!-- Card 6: Hydro Lean L-Carnitine -->
        <article class="product-card group relative rounded-xl overflow-hidden h-[340px] shadow-sm flex flex-col justify-end flex-none w-[240px] sm:w-[260px] snap-start bg-white border border-slate-100">
          <div class="absolute inset-0 z-0 flex items-center justify-center p-4 bg-slate-50/50 overflow-hidden">
            <img alt="Lean L-Carnitine" class="product-card-image max-h-[75%] max-w-[75%] object-contain mix-blend-multiply" loading="lazy" src="https://images.unsplash.com/photo-1546483875-ad9014c88eba?auto=format&fit=crop&w=600&q=80"/>
          </div>
          <div class="relative z-10 p-4 sm:p-5 flex flex-col items-start justify-end bg-gradient-to-t from-black/95 via-black/70 to-transparent w-full">
            <h3 class="text-lg sm:text-xl font-bold text-white leading-tight mb-1">Lean L-Carnitine</h3>
            <p class="text-white/90 text-xs sm:text-sm font-normal leading-snug mb-3 line-clamp-2">Converts stored body fat into usable cellular energy.</p>
            <div class="w-full"><a class="inline-flex items-center gap-1.5 bg-neutral-900 hover:bg-black text-white text-xs sm:text-sm font-semibold px-4 py-2 rounded-lg shadow transition-all duration-200" href="product-detail.php?id=6"><span>Buy now</span></a></div>
          </div>
        </article>

        <!-- Card 7: Omega-3 Fish Oil -->
        <article class="product-card group relative rounded-xl overflow-hidden h-[340px] shadow-sm flex flex-col justify-end flex-none w-[240px] sm:w-[260px] snap-start bg-white border border-slate-100">
          <div class="absolute inset-0 z-0 flex items-center justify-center p-4 bg-slate-50/50 overflow-hidden">
            <img alt="Omega-3 Fish Oil" class="product-card-image max-h-[75%] max-w-[75%] object-contain mix-blend-multiply" loading="lazy" src="https://images.unsplash.com/photo-1584735935682-2f2b69dff9d2?auto=format&fit=crop&w=600&q=80"/>
          </div>
          <div class="relative z-10 p-4 sm:p-5 flex flex-col items-start justify-end bg-gradient-to-t from-black/95 via-black/70 to-transparent w-full">
            <h3 class="text-lg sm:text-xl font-bold text-white leading-tight mb-1">Omega-3 Elite</h3>
            <p class="text-white/90 text-xs sm:text-sm font-normal leading-snug mb-3 line-clamp-2">Supports joint health, cardiovascular function, and recovery.</p>
            <div class="w-full"><a class="inline-flex items-center gap-1.5 bg-neutral-900 hover:bg-black text-white text-xs sm:text-sm font-semibold px-4 py-2 rounded-lg shadow transition-all duration-200" href="product-detail.php?id=7"><span>Buy now</span></a></div>
          </div>
        </article>

        <!-- Card 8: Multi-Vitamin Sport -->
        <article class="product-card group relative rounded-xl overflow-hidden h-[340px] shadow-sm flex flex-col justify-end flex-none w-[240px] sm:w-[260px] snap-start bg-white border border-slate-100">
          <div class="absolute inset-0 z-0 flex items-center justify-center p-4 bg-slate-50/50 overflow-hidden">
            <img alt="Multi-Vitamin Sport" class="product-card-image max-h-[75%] max-w-[75%] object-contain mix-blend-multiply" loading="lazy" src="https://images.unsplash.com/photo-1579722821273-0f6c7d44362f?auto=format&fit=crop&w=600&q=80"/>
          </div>
          <div class="relative z-10 p-4 sm:p-5 flex flex-col items-start justify-end bg-gradient-to-t from-black/95 via-black/70 to-transparent w-full">
            <h3 class="text-lg sm:text-xl font-bold text-white leading-tight mb-1">Sport Multivitamin</h3>
            <p class="text-white/90 text-xs sm:text-sm font-normal leading-snug mb-3 line-clamp-2">Complete daily micronutrient profile designed for athletes.</p>
            <div class="w-full"><a class="inline-flex items-center gap-1.5 bg-neutral-900 hover:bg-black text-white text-xs sm:text-sm font-semibold px-4 py-2 rounded-lg shadow transition-all duration-200" href="product-detail.php?id=8"><span>Buy now</span></a></div>
          </div>
        </article>

        <!-- Card 9: ZMA Nighttime Recovery -->
        <article class="product-card group relative rounded-xl overflow-hidden h-[340px] shadow-sm flex flex-col justify-end flex-none w-[240px] sm:w-[260px] snap-start bg-white border border-slate-100">
          <div class="absolute inset-0 z-0 flex items-center justify-center p-4 bg-slate-50/50 overflow-hidden">
            <img alt="ZMA Nighttime Recovery" class="product-card-image max-h-[75%] max-w-[75%] object-contain mix-blend-multiply" loading="lazy" src="https://images.unsplash.com/photo-1593095948071-474c5cc2989d?auto=format&fit=crop&w=600&q=80"/>
          </div>
          <div class="relative z-10 p-4 sm:p-5 flex flex-col items-start justify-end bg-gradient-to-t from-black/95 via-black/70 to-transparent w-full">
            <h3 class="text-lg sm:text-xl font-bold text-white leading-tight mb-1">ZMA Sleep Formula</h3>
            <p class="text-white/90 text-xs sm:text-sm font-normal leading-snug mb-3 line-clamp-2">Optimizes deep sleep cycles and natural hormone production.</p>
            <div class="w-full"><a class="inline-flex items-center gap-1.5 bg-neutral-900 hover:bg-black text-white text-xs sm:text-sm font-semibold px-4 py-2 rounded-lg shadow transition-all duration-200" href="product-detail.php?id=9"><span>Buy now</span></a></div>
          </div>
        </article>

        <!-- Card 10: Glutamine Powder -->
        <article class="product-card group relative rounded-xl overflow-hidden h-[340px] shadow-sm flex flex-col justify-end flex-none w-[240px] sm:w-[260px] snap-start bg-white border border-slate-100">
          <div class="absolute inset-0 z-0 flex items-center justify-center p-4 bg-slate-50/50 overflow-hidden">
            <img alt="Glutamine Powder" class="product-card-image max-h-[75%] max-w-[75%] object-contain mix-blend-multiply" loading="lazy" src="https://images.unsplash.com/photo-1546483875-ad9014c88eba?auto=format&fit=crop&w=600&q=80"/>
          </div>
          <div class="relative z-10 p-4 sm:p-5 flex flex-col items-start justify-end bg-gradient-to-t from-black/95 via-black/70 to-transparent w-full">
            <h3 class="text-lg sm:text-xl font-bold text-white leading-tight mb-1">Pure Glutamine</h3>
            <p class="text-white/90 text-xs sm:text-sm font-normal leading-snug mb-3 line-clamp-2">Prevents muscle breakdown and supports immune health.</p>
            <div class="w-full"><a class="inline-flex items-center gap-1.5 bg-neutral-900 hover:bg-black text-white text-xs sm:text-sm font-semibold px-4 py-2 rounded-lg shadow transition-all duration-200" href="product-detail.php?id=10"><span>Buy now</span></a></div>
          </div>
        </article>

      </div>
    </div>

  </div>
  <!-- END: Layout Container -->

</section>
<!-- END: FeaturedProductsSection -->

<!-- Scoped JavaScript Component Loader -->
<script>
  (function() {
    const wrapper = document.querySelector('section[aria-labelledby="featured-products-heading"]') || document;
    const track = wrapper.querySelector('.product-slider-track');
    const leftBtn = wrapper.querySelector('.scroll-left-btn');
    const rightBtn = wrapper.querySelector('.scroll-right-btn');

    if (!track) return;

    let autoScrollTimer;

    function scrollTrack(direction) {
      const scrollAmount = 260;
      track.scrollBy({ left: direction * scrollAmount, behavior: 'smooth' });
    }

    if (leftBtn) leftBtn.addEventListener('click', () => scrollTrack(-1));
    if (rightBtn) rightBtn.addEventListener('click', () => scrollTrack(1));

    function startAutoSlide() {
      autoScrollTimer = setInterval(() => {
        if (track.scrollLeft + track.clientWidth >= track.scrollWidth - 10) {
          track.scrollTo({ left: 0, behavior: 'smooth' });
        } else {
          track.scrollBy({ left: 260, behavior: 'smooth' });
        }
      }, 3500);
    }

    function stopAutoSlide() {
      clearInterval(autoScrollTimer);
    }

    startAutoSlide();

    track.addEventListener('mouseenter', stopAutoSlide);
    track.addEventListener('mouseleave', startAutoSlide);
    track.addEventListener('touchstart', stopAutoSlide);
  })();
</script>

</body>
</html>