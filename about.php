<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>About Us - ApexFit</title>
<link href="./src/output.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet"/>
<link href="https://fonts.googleapis.com" rel="preconnect"/>
<link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect"/>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&amp;display=swap" rel="stylesheet"/>
<script src="https://cdn.tailwindcss.com"></script>
<script>
    tailwind.config = {
        theme: {
            extend: {
                colors: {
                    brand: {
                        50: '#f0f9ff',
                        100: '#e0f2fe',
                        500: '#0ea5e9',
                        600: '#0284c7',
                        700: '#0369a1',
                    }
                },
                fontFamily: { sans: ['"Plus Jakarta Sans"', 'sans-serif'] }
            }
        }
    }
</script>
</head>
<body class="bg-white text-slate-800 font-sans antialiased min-h-screen">


<main class="py-8 sm:py-16 px-4 sm:px-8 lg:px-12">
  <div class="max-w-[1100px] mx-auto space-y-16 sm:space-y-24">

    <!-- Section 1: Text Left, Image Right -->
    <section class="flex flex-col md:flex-row items-center gap-8 sm:gap-12">
      <div class="w-full md:w-1/2 space-y-4">
        <h2 class="text-2xl sm:text-4xl font-extrabold text-slate-900 tracking-tight leading-tight">
          The Best Fitness Support For Over 7 Years
        </h2>
        <p class="text-xs sm:text-sm font-bold text-sky-600 uppercase tracking-widest">
          PREMIUM, LAB-TESTED SUPPLEMENTS
        </p>
        <div class="w-12 h-1 bg-sky-500 rounded-full"></div>
        <p class="text-sm sm:text-base text-slate-600 leading-relaxed">
          We are dedicated to helping athletes and gym enthusiasts reach their peak physical performance. Every product in our lineup is carefully formulated with scientifically proven ingredients to deliver clean energy, maximum strength, and optimal muscle recovery.
        </p>
        <div class="pt-2">
          <a href="shop.php" class="inline-flex items-center justify-center px-6 py-3 bg-sky-600 hover:bg-sky-700 text-white font-semibold text-sm rounded-full shadow-lg shadow-sky-500/20 transition-all active:scale-95">
            EXPLORE CATALOG <i class="fa-solid fa-arrow-right ml-2 text-xs"></i>
          </a>
        </div>
      </div>
      <div class="w-full md:w-1/2">
        <div class="relative rounded-2xl overflow-hidden shadow-xl border border-slate-100 aspect-[4/3]">
          <img src="https://images.unsplash.com/photo-1534438327276-14e5300c3a48?auto=format&fit=crop&w=800&q=80" alt="Gym Training Equipment" class="w-full h-full object-cover"/>
        </div>
      </div>
    </section>

    <!-- Section 2: Image Left, Text Right -->
    <section class="flex flex-col-reverse md:flex-row items-center gap-8 sm:gap-12">
      <div class="w-full md:w-1/2">
        <div class="relative rounded-2xl overflow-hidden shadow-xl border border-slate-100 aspect-[4/3]">
          <img src="https://images.unsplash.com/photo-1581009146145-b5ef050c2e1e?auto=format&fit=crop&w=800&q=80" alt="Weight Training" class="w-full h-full object-cover"/>
        </div>
      </div>
      <div class="w-full md:w-1/2 space-y-4">
        <h2 class="text-2xl sm:text-4xl font-extrabold text-slate-900 tracking-tight leading-tight">
          Incredible, Proven Formulas
        </h2>
        <p class="text-xs sm:text-sm font-bold text-sky-600 uppercase tracking-widest">
          DESIGNED FOR MAXIMUM MUSCLE GAINS
        </p>
        <div class="w-12 h-1 bg-sky-500 rounded-full"></div>
        <p class="text-sm sm:text-base text-slate-600 leading-relaxed">
          Whether you are building lean muscle, increasing endurance, or burning body fat, our targeted supplement blends give your body the exact nutrients required for intense workout sessions.
        </p>
        <div class="pt-2">
          <a href="shop.php" class="inline-flex items-center justify-center px-6 py-3 bg-sky-600 hover:bg-sky-700 text-white font-semibold text-sm rounded-full shadow-lg shadow-sky-500/20 transition-all active:scale-95">
            VIEW PRODUCTS <i class="fa-solid fa-arrow-right ml-2 text-xs"></i>
          </a>
        </div>
      </div>
    </section>

    <!-- Section 3: Text Left, Image Right -->
    <section class="flex flex-col md:flex-row items-center gap-8 sm:gap-12">
      <div class="w-full md:w-1/2 space-y-4">
        <h2 class="text-2xl sm:text-4xl font-extrabold text-slate-900 tracking-tight leading-tight">
          We Cater To All Fitness Goals
        </h2>
        <p class="text-xs sm:text-sm font-bold text-sky-600 uppercase tracking-widest">
          BEGINNERS OR PRO ATHLETES, WE GOT YOU COVERED
        </p>
        <div class="w-12 h-1 bg-sky-500 rounded-full"></div>
        <p class="text-sm sm:text-base text-slate-600 leading-relaxed">
          From pure creatine monohydrate and whey protein isolate to pre-workout energy matrices, our products fit seamlessly into any training routine.
        </p>
        <div class="pt-2">
          <a href="shop.php" class="inline-flex items-center justify-center px-6 py-3 bg-sky-600 hover:bg-sky-700 text-white font-semibold text-sm rounded-full shadow-lg shadow-sky-500/20 transition-all active:scale-95">
            GET STARTED TODAY <i class="fa-solid fa-arrow-right ml-2 text-xs"></i>
          </a>
        </div>
      </div>
      <div class="w-full md:w-1/2">
        <div class="relative rounded-2xl overflow-hidden shadow-xl border border-slate-100 aspect-[4/3]">
          <img src="https://images.unsplash.com/photo-1517838277536-f5f99be501cd?auto=format&fit=crop&w=800&q=80" alt="Athletic Training" class="w-full h-full object-cover"/>
        </div>
      </div>
    </section>

  </div>
</main>

<!-- Footer -->
<footer class="border-t border-slate-100 bg-slate-50 mt-16 py-8 px-4 text-center text-xs text-slate-500">
  <div class="max-w-[1100px] mx-auto flex flex-col sm:flex-row items-center justify-between gap-4">
    
    <div class="flex gap-6">
      <a href="shop.php" class="hover:underline">Shop</a>
      <a href="faq.php" class="hover:underline">FAQ</a>
      <a href="contact.php" class="hover:underline">Contact</a>
      <a href="privacy-policy.php" class="hover:underline">Privacy Policy</a>
    </div>
  </div>
</footer>

</body>
</html>