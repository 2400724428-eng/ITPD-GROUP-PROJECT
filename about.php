
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>About Us | PURE GAIN</title>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet"/>
<link href="https://fonts.googleapis.com" rel="preconnect"/>
<link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect"/>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet"/>

<script src="https://cdn.tailwindcss.com"></script>

<style>
  html, body {
    margin: 0;
    padding: 0;
    width: 100%;
    height: 100%;
    overflow-x: hidden;
    background-color: #f8f9ff;
  }
  body {
    -webkit-overflow-scrolling: touch;
    font-family: 'Plus Jakarta Sans', sans-serif;
  }
  ::-webkit-scrollbar { display: none; }

  /* Custom Gradient matching the hero section */
  .hero-gradient {
    background: linear-gradient(135deg, #eff4ff 0%, #dbe1ff 100%);
  }
</style>

<script>
  tailwind.config = {
    theme: {
      extend: {
        colors: {
          primary: '#004ac6',
          'primary-container': '#2563eb',
          'surface-container-lowest': '#ffffff',
          'surface-container-low': '#eff4ff',
          'on-surface': '#0b1c30',
          'on-surface-variant': '#434655',
          'outline-variant': '#c3c6d7',
          'tertiary': '#007b71',
        },
        fontFamily: {
          sans: ['"Plus Jakarta Sans"', 'sans-serif'],
        }
      }
    }
  }
</script>
</head>
<body class="bg-surface-container-low text-on-surface font-sans antialiased min-h-screen flex flex-col">

 <?php include 'includes/searchtop.php'; ?> 

<main class="w-full flex-grow pb-20">

  <!-- Page Header Banner -->
  <div class="hero-gradient pt-12 pb-20 border-b border-white/50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
      <span class="inline-block text-xs font-bold text-primary bg-blue-100 px-4 py-1.5 rounded-full uppercase tracking-widest mb-4">
        About Pure Gain
      </span>
      <h1 class="text-3xl sm:text-5xl font-extrabold text-primary tracking-tight mb-3">
        Fueling Your Fitness Journey
      </h1>
      <p class="text-on-surface-variant text-base sm:text-lg max-w-2xl mx-auto">
        Premium, lab-tested supplements engineered for athletes who demand the best from their bodies.
      </p>
    </div>
  </div>

  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-12">
    <div class="space-y-16 sm:space-y-24">

      <!-- Section 1: Text Left, Image Right -->
      <!-- Changed bg-white to bg-blue-50/50 with a subtle border -->
      <section class="flex flex-col md:flex-row items-center gap-8 sm:gap-12 bg-blue-50/50 rounded-2xl p-6 sm:p-10 shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-blue-100">
        <div class="w-full md:w-1/2 space-y-4">
          <span class="text-xs font-bold text-primary uppercase tracking-widest">Since 2018</span>
          <h2 class="text-2xl sm:text-4xl font-extrabold text-on-surface tracking-tight leading-tight">
            The Best Fitness Support For Over 7 Years
          </h2>
          <div class="w-12 h-1 bg-primary rounded-full"></div>
          <p class="text-sm sm:text-base text-on-surface-variant leading-relaxed">
            We are dedicated to helping athletes and gym enthusiasts reach their peak physical performance. Every product in our lineup is carefully formulated with scientifically proven ingredients to deliver clean energy, maximum strength, and optimal muscle recovery.
          </p>
          <div class="pt-2">
            <a href="shop.php" class="inline-flex items-center justify-center px-6 py-3 bg-primary hover:bg-blue-700 text-white font-semibold text-sm rounded-xl shadow-lg shadow-blue-600/20 transition-all active:scale-95">
              EXPLORE CATALOG <i class="fa-solid fa-arrow-right ml-2 text-xs"></i>
            </a>
          </div>
        </div>
        <div class="w-full md:w-1/2">
          <div class="rounded-2xl overflow-hidden border border-gray-100 shadow-sm">
            <img src="assets/images/power.jpg" alt="Gym Training Equipment" class="w-full h-auto object-cover"/>
          </div>
        </div>
      </section>

      <!-- Section 2: Image Left, Text Right -->
      <!-- Changed bg-white to bg-blue-50/50 with a subtle border -->
      <section class="flex flex-col-reverse md:flex-row items-center gap-8 sm:gap-12 bg-blue-50/50 rounded-2xl p-6 sm:p-10 shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-blue-100">
        <div class="w-full md:w-1/2">
          <div class="rounded-2xl overflow-hidden border border-gray-100 shadow-sm">
            <img src="assets/images/4.png" alt="Weight Training" class="w-full h-auto object-cover"/>
          </div>
        </div>
        <div class="w-full md:w-1/2 space-y-4">
          <span class="text-xs font-bold text-primary uppercase tracking-widest">Science-Backed</span>
          <h2 class="text-2xl sm:text-4xl font-extrabold text-on-surface tracking-tight leading-tight">
            Incredible, Proven Formulas
          </h2>
          <div class="w-12 h-1 bg-primary rounded-full"></div>
          <p class="text-sm sm:text-base text-on-surface-variant leading-relaxed">
            Whether you are building lean muscle, increasing endurance, or burning body fat, our targeted supplement blends give your body the exact nutrients required for intense workout sessions.
          </p>
          <div class="pt-2">
            <a href="shop.php" class="inline-flex items-center justify-center px-6 py-3 bg-primary hover:bg-blue-700 text-white font-semibold text-sm rounded-xl shadow-lg shadow-blue-600/20 transition-all active:scale-95">
              VIEW PRODUCTS <i class="fa-solid fa-arrow-right ml-2 text-xs"></i>
            </a>
          </div>
        </div>
      </section>

      <!-- Section 3: Text Left, Image Right -->
      <!-- Changed bg-white to bg-blue-50/50 with a subtle border -->
      <section class="flex flex-col md:flex-row items-center gap-8 sm:gap-12 bg-blue-50/50 rounded-2xl p-6 sm:p-10 shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-blue-100">
        <div class="w-full md:w-1/2 space-y-4">
          <span class="text-xs font-bold text-primary uppercase tracking-widest">Elite Nutrition</span>
          <h2 class="text-2xl sm:text-4xl font-extrabold text-on-surface tracking-tight leading-tight">
            Pure Body Supplements for Accelerated Growth
          </h2>
          <div class="w-12 h-1 bg-primary rounded-full"></div>
          <p class="text-sm sm:text-base text-on-surface-variant leading-relaxed">
            Fuel your anabolism with our elite selection of pharmaceutical-grade body supplements. From micronized creatine monohydrate to cold-filtered whey protein isolates, every batch is optimized for rapid cellular absorption, enhanced nitrogen retention, and minimal recovery windows.
          </p>
          <div class="pt-2">
            <a href="shop.php" class="inline-flex items-center justify-center px-6 py-3 bg-primary hover:bg-blue-700 text-white font-semibold text-sm rounded-xl shadow-lg shadow-blue-600/20 transition-all active:scale-95">
              SHOP SUPPLEMENTS <i class="fa-solid fa-arrow-right ml-2 text-xs"></i>
            </a>
          </div>
        </div>
        <div class="w-full md:w-1/2">
          <div class="rounded-2xl overflow-hidden border border-gray-100 shadow-sm">
            <img src="assets/images/11.png" alt="Body Supplements and Protein Canisters" class="w-full h-auto object-cover"/>
          </div>
        </div>
      </section>

      <!-- Section 4: Image Left, Text Right -->
      <!-- Changed bg-white to bg-blue-50/50 with a subtle border -->
      <section class="flex flex-col-reverse md:flex-row items-center gap-8 sm:gap-12 bg-blue-50/50 rounded-2xl p-6 sm:p-10 shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-blue-100">
        <div class="w-full md:w-1/2">
          <div class="rounded-2xl overflow-hidden border border-gray-100 shadow-sm">
            <img src="assets/images/cc.png" alt="Athletic Training" class="w-full h-auto object-cover"/>
          </div>
        </div>
        <div class="w-full md:w-1/2 space-y-4">
          <span class="text-xs font-bold text-primary uppercase tracking-widest">For Every Athlete</span>
          <h2 class="text-2xl sm:text-4xl font-extrabold text-on-surface tracking-tight leading-tight">
            We Cater To All Fitness Goals
          </h2>
          <div class="w-12 h-1 bg-primary rounded-full"></div>
          <p class="text-sm sm:text-base text-on-surface-variant leading-relaxed">
            From pure creatine monohydrate and whey protein isolate to pre-workout energy matrices, our products fit seamlessly into any training routine — whether you're a beginner or a pro athlete.
          </p>
          <div class="pt-2">
            <a href="shop.php" class="inline-flex items-center justify-center px-6 py-3 bg-primary hover:bg-blue-700 text-white font-semibold text-sm rounded-xl shadow-lg shadow-blue-600/20 transition-all active:scale-95">
              GET STARTED TODAY <i class="fa-solid fa-arrow-right ml-2 text-xs"></i>
            </a>
          </div>
        </div>
      </section>

    </div>
  </div>
</main>

<br> <br>
  <?php include 'includes/footer.php'; ?>

</body>
</html>
