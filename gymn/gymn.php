<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>Pure gain - Gym Training & Services</title>
<link href="../src/output.css" rel="stylesheet">

<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet"/>
<link href="https://fonts.googleapis.com" rel="preconnect"/>
<link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect"/>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet"/>
<script>
  tailwind.config = { theme: { extend: { fontFamily: { sans: ['"Plus Jakarta Sans"', 'sans-serif'] } } } }
</script>
<style>
  body { font-family: 'Plus Jakarta Sans', sans-serif; -webkit-font-smoothing: antialiased; }
  .banner-gradient {
    background: radial-gradient(circle at 50% 40%, #EFF4FB 0%, #DFE8F5 100%);
    box-shadow: 0 25px 60px -15px rgba(16,58,199,.2), 0 10px 25px -5px rgba(0,0,0,.05);
    border: 1px solid rgba(255,255,255,.8);
  }
  .lift { transition: transform .25s ease, box-shadow .25s ease; }
  .lift:hover { transform: translateY(-3px); box-shadow: 0 14px 28px -8px rgba(0,0,0,.12); }
</style>
</head>
<body class="bg-slate-50 text-slate-800 antialiased min-h-screen flex flex-col">

<!-- Header -->




<main class="flex-grow py-6 px-4 sm:px-6">
<div class="max-w-[1060px] w-full mx-auto space-y-14">









<!-- BEGIN: PricingPlansSection -->
<section class="py-20 bg-[#F8F9FA]" data-purpose="pricing-plans-section" id="pricing">
<div class="max-w-6xl mx-auto px-4 sm:px-6">
<!-- Header -->
<div class="text-center max-w-2xl mx-auto mb-16">
<h2 class="font-heading text-3xl sm:text-4xl font-bold uppercase tracking-tight text-gray-900">
            Our Pricing Plans
          </h2>
<div class="w-12 h-1 bg-blue-600 mx-auto mt-2 mb-3"></div>
<p class="text-xs uppercase tracking-widest text-gray-500 font-semibold">
            A Transparent Fitness Plan Engineered For Everyone
          </p>
</div>
<!-- Pricing Cards Grid: Forces 2 columns on mobile, drops the 3rd centered below -->
<div class="grid grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-8 items-stretch max-w-5xl mx-auto">
<!-- Plan 1: Starter -->
<div class="bg-white p-4 sm:p-8 border border-gray-200 shadow-sm text-center rounded-xl overflow-hidden flex flex-col justify-between">
<div>
<h4 class="font-heading font-bold text-sm sm:text-xl uppercase tracking-wider text-gray-800">Ultimate Silver</h4>
<div class="my-4">
<span class="text-base sm:text-2xl font-heading font-bold text-black block sm:inline">UGX 180,000</span>
<span class="text-[10px] sm:text-xs text-gray-500 font-medium tracking-wide">/ month</span>
</div>
<ul class="text-[11px] sm:text-xs text-gray-600 space-y-2 sm:space-y-3 py-4 sm:py-6 border-t border-b border-gray-100 text-left sm:text-center">
<li>Full Gym Access (Open Hours)</li>
<li>Monthly Body Scan</li>
<li>Standard Mobile App</li>
<li>Locker &amp; Sauna Access</li>
</ul>
</div>
<div class="mt-4 sm:mt-6">
<a class="block w-full bg-blue-600 hover:bg-blue-700 text-white py-2 sm:py-2.5 text-[10px] sm:text-xs font-bold uppercase tracking-widest transition rounded-lg" href="#contact">
                Select Plan
              </a>
</div>
</div>
<!-- Plan 2: Featured Trainer Card (Gold) -->
<div class="bg-white border-2 border-blue-600 shadow-xl relative overflow-hidden rounded-xl flex flex-col justify-between">
<div>
<div class="bg-blue-600 text-white text-[9px] sm:text-[11px] font-bold uppercase tracking-widest text-center py-1">
              Most Popular
            </div>
<!-- Trainer Highlight Visual in Center Card -->
<div class="h-24 sm:h-44 overflow-hidden relative bg-gray-100">
<img alt="Muscular trainer athlete with towel around neck" class="w-full h-full object-cover object-top" src="assets/images/pp.png"/>
<div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
<span class="absolute bottom-1.5 left-2 sm:bottom-3 sm:left-4 text-white font-heading text-xs sm:text-lg font-bold uppercase tracking-wider pinned-text">
                Nutrition &amp; Body
              </span>
</div>
<div class="p-4 sm:p-8 text-center">
<div class="mb-4">
<span class="text-base sm:text-2xl font-heading font-bold text-black block sm:inline">UGX 330,000</span>
<span class="text-[10px] sm:text-xs text-gray-500 font-medium tracking-wide">/ month</span>
</div>
<ul class="text-[11px] sm:text-xs text-gray-600 space-y-2 sm:space-y-3 py-2 sm:py-4 border-t border-b border-gray-100 text-left sm:text-center">
<li class="font-semibold text-black">4 Personalized Sessions</li>
<li>Nutrition Strategy</li>
<li>24/7 Coach Chat</li>
<li>Progress Adjustments</li>
</ul>
</div>
</div>
<div class="p-4 sm:p-8 pt-0 text-center">
<a class="block w-full bg-blue-600 hover:bg-blue-700 text-white py-2 sm:py-3 text-[10px] sm:text-xs font-bold uppercase tracking-widest transition shadow-md rounded-lg" href="#contact">
                  Choose Gold
                </a>
</div>
</div>
<!-- Plan 3: Platinum - Made to sit centrally underneath the two blocks on mobile -->
<div class="bg-white p-4 sm:p-8 border border-gray-200 shadow-sm text-center rounded-xl overflow-hidden col-span-2 lg:col-span-1 max-w-[50%] lg:max-w-none mx-auto flex flex-col justify-between w-full mt-4 lg:mt-0">
<div>
<h4 class="font-heading font-bold text-sm sm:text-xl uppercase tracking-wider text-gray-800">Diamond Elite</h4>
<div class="my-4">
<span class="text-base sm:text-2xl font-heading font-bold text-black block sm:inline">UGX 550,000</span>
<span class="text-[10px] sm:text-xs text-gray-500 font-medium tracking-wide">/ month</span>
</div>
<ul class="text-[11px] sm:text-xs text-gray-600 space-y-2 sm:space-y-3 py-4 sm:py-6 border-t border-b border-gray-100 text-left sm:text-center">
<li>Unlimited 1-on-1 Coaching</li>
<li>Daily Nutrition Tracking</li>
<li>Class &amp; Yoga Passes</li>
<li>VIP Private Locker</li>
</ul>
</div>
<div class="mt-4 sm:mt-6">
<a class="block w-full bg-blue-600 hover:bg-blue-700 text-white py-2 sm:py-2.5 text-[10px] sm:text-xs font-bold uppercase tracking-widest transition rounded-lg" href="#contact">
                Select Plan
              </a>
</div>
</div>
</div>
<div class="mt-14 text-center">

</div>
</div>
</section>
<!-- END: PricingPlansSection -->






<div class="text-center max-w-2xl mx-auto mb-16">
<h2 class="font-heading text-3xl sm:text-4xl font-bold uppercase tracking-tight text-gray-900">
            What We Do
          </h2>
<div class="w-12 h-1 bg-brandYellow mx-auto mt-2 mb-3"></div>
<p class="text-xs uppercase tracking-widest text-gray-500 font-semibold">
            A Comprehensive Fitness Plan Built For Measurable Success
          </p>
</div>
<!-- Content Grid: 4 Services Left + Athletic Pair with Yellow Square Right -->
<div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-center">
<!-- 4 Services Left Column -->
<div class="lg:col-span-7 grid grid-cols-1 sm:grid-cols-2 gap-8" data-purpose="services-list">
<!-- Service 1: Body Audit -->
<div class="space-y-2 bg-white/70 p-5 rounded border border-gray-200/60">
<h4 class="font-heading font-bold text-lg text-gray-900 tracking-wide uppercase">
                Body Audit
              </h4>
<p class="text-xs text-gray-600 leading-relaxed">
                Complete anthropometric bio-scans, mobility screens, and postural diagnostics to spot weaknesses and construct a baseline before day one.
              </p>
</div>
<!-- Service 2: Yoga Studio -->
<div class="space-y-2 bg-white/70 p-5 rounded border border-gray-200/60">
<h4 class="font-heading font-bold text-lg text-gray-900 tracking-wide uppercase">
                Yoga Studio
              </h4>
<p class="text-xs text-gray-600 leading-relaxed">
                Dynamic flow sessions, joint decompression, and active muscular recovery aimed at reducing stress hormones and unlocking mobility.
              </p>
</div>
<!-- Service 3: Cardio Fitness -->
<div class="space-y-2 bg-white/70 p-5 rounded border border-gray-200/60">
<h4 class="font-heading font-bold text-lg text-gray-900 tracking-wide uppercase">
                Cardio Fitness
              </h4>
<p class="text-xs text-gray-600 leading-relaxed">
                Targeted metabolic conditioning, zone-2 base building, and high-intensity interval training designed for rapid fat loss and endurance.
              </p>
</div>
<!-- Service 4: Pilates Fitness -->
<div class="space-y-2 bg-white/70 p-5 rounded border border-gray-200/60">
<h4 class="font-heading font-bold text-lg text-gray-900 tracking-wide uppercase">
                Pilates Fitness
              </h4>
<p class="text-xs text-gray-600 leading-relaxed">
                Precision resistance work emphasizing pelvic alignment, core activation, balance, and athletic injury prevention.
              </p>
</div>
</div>
<!-- Athletic Couple Right Column with Yellow Graphic -->
<div class="lg:col-span-5 relative flex justify-center" data-purpose="services-visual">
<!-- Bold Yellow Geometric Backdrop -->
<div class="absolute right-4 top-6 w-60 h-72 sm:w-72 sm:h-80 bg-brandYellow -z-0"></div>
<div class="relative z-10 pt-4 pr-6">
<img alt="Athletic trainers standing together in sportswear" class="w-full max-w-sm h-auto object-cover shadow-xl" src="assets/images/uu.png"/>
</div>
</div>
</div>
</div>
</section> <br> <br>















</div>
</main>

<script>
  const drawer = document.getElementById('drawer'), backdrop = document.getElementById('backdrop');
  function openD() { drawer.classList.remove('-translate-x-full'); backdrop.classList.remove('hidden'); document.body.style.overflow = 'hidden'; }
  function closeD() { drawer.classList.add('-translate-x-full'); backdrop.classList.add('hidden'); document.body.style.overflow = ''; }
  document.getElementById('menuBtn').addEventListener('click', openD);
  document.getElementById('closeBtn').addEventListener('click', closeD);
  backdrop.addEventListener('click', closeD);
</script>
</body>
</html>