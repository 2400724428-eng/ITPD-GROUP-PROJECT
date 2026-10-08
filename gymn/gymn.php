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

  <!-- Hero -->
  <section class="banner-gradient rounded-[2rem] px-6 sm:px-10 lg:px-14 py-10 md:py-14 text-center">
    <p class="text-blue-600 text-[15px] font-semibold">Expert Coaching</p>
    <h1 class="text-slate-900 text-3xl sm:text-4xl lg:text-[42px] font-extrabold tracking-tight leading-[1.2] mt-2 max-w-[640px] mx-auto">Gym Training & Services Built Around Your Goals</h1>
    <p class="text-slate-500 text-sm sm:text-base mt-4 max-w-[520px] mx-auto">From one-on-one coaching to group classes and nutrition plans, everything you need to train smarter and see results.</p>
    <div class="pt-6 flex flex-wrap items-center justify-center gap-4">
      <a href="#plans" class="inline-flex px-7 py-3 rounded-full bg-blue-600 text-white font-semibold text-[14px] shadow-sm hover:bg-blue-700 transition-colors">View Plans</a>
      <a href="book.php" class="inline-flex items-center gap-2 text-slate-800 font-medium text-[14px] hover:text-blue-600 transition-colors">Book a Free Tour <span>→</span></a>
    </div>
  </section>

  <!-- Services -->
  <section>
    <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">Our Services</h2>
    <p class="text-sm text-slate-500 mt-1">Pick one, or combine them for faster progress</p>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-5 mt-6">
      <article class="lift bg-white rounded-3xl border border-slate-100 shadow-sm p-6">
        <span class="w-12 h-12 rounded-2xl bg-sky-50 text-sky-600 flex items-center justify-center text-lg"><i class="fa-solid fa-dumbbell"></i></span>
        <h3 class="font-bold text-slate-900 text-lg mt-4">Personal Training</h3>
        <p class="text-sm text-slate-500 mt-1.5 leading-relaxed">One-on-one sessions with a certified coach and a plan tailored to your body and goals.</p>
      </article>
      <article class="lift bg-white rounded-3xl border border-slate-100 shadow-sm p-6">
        <span class="w-12 h-12 rounded-2xl bg-sky-50 text-sky-600 flex items-center justify-center text-lg"><i class="fa-solid fa-people-group"></i></span>
        <h3 class="font-bold text-slate-900 text-lg mt-4">Group Classes</h3>
        <p class="text-sm text-slate-500 mt-1.5 leading-relaxed">High-energy HIIT, strength and conditioning classes that keep you motivated.</p>
      </article>
      <article class="lift bg-white rounded-3xl border border-slate-100 shadow-sm p-6">
        <span class="w-12 h-12 rounded-2xl bg-sky-50 text-sky-600 flex items-center justify-center text-lg"><i class="fa-solid fa-apple-whole"></i></span>
        <h3 class="font-bold text-slate-900 text-lg mt-4">Nutrition Coaching</h3>
        <p class="text-sm text-slate-500 mt-1.5 leading-relaxed">Meal guidance and supplement advice that fits your budget and local foods.</p>
      </article>
      <article class="lift bg-white rounded-3xl border border-slate-100 shadow-sm p-6">
        <span class="w-12 h-12 rounded-2xl bg-sky-50 text-sky-600 flex items-center justify-center text-lg"><i class="fa-solid fa-weight-scale"></i></span>
        <h3 class="font-bold text-slate-900 text-lg mt-4">Weight Loss Programs</h3>
        <p class="text-sm text-slate-500 mt-1.5 leading-relaxed">Structured 8 and 12 week programs with weekly check-ins and progress tracking.</p>
      </article>
      <article class="lift bg-white rounded-3xl border border-slate-100 shadow-sm p-6">
        <span class="w-12 h-12 rounded-2xl bg-sky-50 text-sky-600 flex items-center justify-center text-lg"><i class="fa-solid fa-person-running"></i></span>
        <h3 class="font-bold text-slate-900 text-lg mt-4">Strength & Muscle Gain</h3>
        <p class="text-sm text-slate-500 mt-1.5 leading-relaxed">Progressive overload programming to build size and strength safely.</p>
      </article>
      <article class="lift bg-white rounded-3xl border border-slate-100 shadow-sm p-6">
        <span class="w-12 h-12 rounded-2xl bg-sky-50 text-sky-600 flex items-center justify-center text-lg"><i class="fa-solid fa-laptop"></i></span>
        <h3 class="font-bold text-slate-900 text-lg mt-4">Online Coaching</h3>
        <p class="text-sm text-slate-500 mt-1.5 leading-relaxed">Train anywhere with a custom plan, video feedback and chat support from your coach.</p>
      </article>
    </div>
  </section>

  <!-- Plans -->
  <section id="plans">
    <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">Membership Plans</h2>
    <p class="text-sm text-slate-500 mt-1">Simple monthly pricing, cancel anytime</p>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 sm:gap-5 mt-6 items-stretch">
      <article class="lift flex flex-col bg-white rounded-3xl border border-slate-100 shadow-sm p-6">
        <h3 class="font-bold text-slate-900 text-lg">Starter</h3>
        <p class="mt-3"><span class="text-3xl font-extrabold text-slate-900">UGX 150,000</span><span class="text-sm text-slate-400"> /month</span></p>
        <ul class="mt-5 space-y-2.5 text-sm text-slate-600 flex-grow">
          <li><i class="fa-solid fa-check text-sky-500 mr-2"></i>Full gym access</li>
          <li><i class="fa-solid fa-check text-sky-500 mr-2"></i>Group classes (4 per month)</li>
          <li><i class="fa-solid fa-check text-sky-500 mr-2"></i>Starter workout plan</li>
        </ul>
        <a href="membership.php" class="mt-6 text-center px-6 py-3 rounded-full border border-slate-300 font-semibold text-[14px] hover:border-blue-400 hover:text-blue-600 transition-colors">Get Started</a>
      </article>
      <article class="lift relative flex flex-col bg-white rounded-3xl border-2 border-blue-600 shadow-md p-6">
        <span class="absolute -top-3 left-6 bg-blue-600 text-white text-[11px] font-extrabold px-3 py-1 rounded-full">MOST POPULAR</span>
        <h3 class="font-bold text-slate-900 text-lg">Pro</h3>
        <p class="mt-3"><span class="text-3xl font-extrabold text-slate-900">UGX 300,000</span><span class="text-sm text-slate-400"> /month</span></p>
        <ul class="mt-5 space-y-2.5 text-sm text-slate-600 flex-grow">
          <li><i class="fa-solid fa-check text-sky-500 mr-2"></i>Everything in Starter</li>
          <li><i class="fa-solid fa-check text-sky-500 mr-2"></i>Unlimited group classes</li>
          <li><i class="fa-solid fa-check text-sky-500 mr-2"></i>4 personal training sessions</li>
          <li><i class="fa-solid fa-check text-sky-500 mr-2"></i>Nutrition guide</li>
        </ul>
        <a href="membership.php" class="mt-6 text-center px-6 py-3 rounded-full bg-blue-600 text-white font-semibold text-[14px] shadow-sm hover:bg-blue-700 transition-colors">Join Pro</a>
      </article>
      <article class="lift flex flex-col bg-white rounded-3xl border border-slate-100 shadow-sm p-6">
        <h3 class="font-bold text-slate-900 text-lg">Elite</h3>
        <p class="mt-3"><span class="text-3xl font-extrabold text-slate-900">UGX 500,000</span><span class="text-sm text-slate-400"> /month</span></p>
        <ul class="mt-5 space-y-2.5 text-sm text-slate-600 flex-grow">
          <li><i class="fa-solid fa-check text-sky-500 mr-2"></i>Everything in Pro</li>
          <li><i class="fa-solid fa-check text-sky-500 mr-2"></i>12 personal training sessions</li>
          <li><i class="fa-solid fa-check text-sky-500 mr-2"></i>Custom meal plan</li>
          <li><i class="fa-solid fa-check text-sky-500 mr-2"></i>Weekly progress check-ins</li>
        </ul>
        <a href="membership.php" class="mt-6 text-center px-6 py-3 rounded-full border border-slate-300 font-semibold text-[14px] hover:border-blue-400 hover:text-blue-600 transition-colors">Go Elite</a>
      </article>
    </div>
  </section>

  <!-- CTA -->
  <section class="banner-gradient rounded-[2rem] px-6 py-10 text-center mb-6">
    <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">Ready to start training?</h2>
    <p class="text-sm text-slate-500 mt-2">Book a free tour and fitness assessment with one of our coaches.</p>
    <a href="book.php" class="inline-flex mt-6 px-7 py-3 rounded-full bg-blue-600 text-white font-semibold text-[14px] shadow-sm hover:bg-blue-700 transition-colors">Book Free Tour</a>
  </section>

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