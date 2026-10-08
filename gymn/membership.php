<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>Pure Gain - Join Membership</title>
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
  .field { width: 100%; background: #f8fafc; border: 1px solid #cbd5e1; border-radius: .75rem; padding: .65rem .9rem; font-size: .875rem; }
  .field:focus { outline: none; border-color: #2563eb; box-shadow: 0 0 0 1px #2563eb; background: #fff; }
  .field.invalid { border-color: #dc2626; }
  .opt input { position: absolute; opacity: 0; }
  .opt > span.box { display: block; border: 1.5px solid #e2e8f0; border-radius: 1rem; padding: .9rem 1rem; cursor: pointer; background: #fff; transition: all .15s; height: 100%; }
  .opt > span.box:hover { border-color: #93c5fd; }
  .opt input:checked + span.box { border-color: #2563eb; background: #eff6ff; box-shadow: 0 0 0 1px #2563eb; }
  .opt input:focus-visible + span.box { box-shadow: 0 0 0 2px #93c5fd; }
</style>
</head>
<body class="bg-slate-50 text-slate-800 antialiased min-h-screen flex flex-col">




<main class="flex-grow py-6 px-4 sm:px-6">
<div class="max-w-[1060px] w-full mx-auto space-y-10">

  <!-- Hero -->
  <section class="banner-gradient rounded-[2rem] px-6 sm:px-10 py-10 md:py-12 text-center">
    <p class="text-blue-600 text-[15px] font-semibold">Become a Member</p>
    <h1 class="text-slate-900 text-3xl sm:text-4xl lg:text-[42px] font-extrabold tracking-tight leading-[1.2] mt-2 max-w-[600px] mx-auto">Join Pure gain and Start Training Today</h1>
    <p class="text-slate-500 text-sm sm:text-base mt-4 max-w-[500px] mx-auto">Choose your plan, tell us about yourself and we will have your membership ready.</p>
  </section>

  <section id="joinWrap" class="grid grid-cols-1 lg:grid-cols-5 gap-6 lg:gap-8 items-start">

    <!-- Form -->
    <form id="joinForm" novalidate class="lg:col-span-3 space-y-8">

      <!-- Step 1 plan -->
      <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-6 sm:p-8">
        <h2 class="font-extrabold text-slate-900 text-xl"><span class="text-blue-600">1.</span> Choose your plan</h2>
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 mt-5">
          <label class="opt relative"><input type="radio" name="plan" value="starter"><span class="box"><b class="block text-slate-900">Starter</b><span class="block text-sm text-slate-500 mt-0.5">UGX 150,000/mo</span><span class="block text-xs text-slate-400 mt-2">Gym access + 4 classes</span></span></label>
          <label class="opt relative"><input type="radio" name="plan" value="pro" checked><span class="box"><b class="block text-slate-900">Pro <span class="ml-1 text-[10px] font-extrabold bg-blue-600 text-white px-2 py-0.5 rounded-full align-middle">POPULAR</span></b><span class="block text-sm text-slate-500 mt-0.5">UGX 300,000/mo</span><span class="block text-xs text-slate-400 mt-2">Unlimited classes + 4 PT sessions</span></span></label>
          <label class="opt relative"><input type="radio" name="plan" value="elite"><span class="box"><b class="block text-slate-900">Elite</b><span class="block text-sm text-slate-500 mt-0.5">UGX 500,000/mo</span><span class="block text-xs text-slate-400 mt-2">12 PT sessions + meal plan</span></span></label>
        </div>

        <h3 class="text-xs font-semibold text-slate-700 mt-6 mb-2">Billing period</h3>
        <div class="grid grid-cols-3 gap-3">
          <label class="opt relative"><input type="radio" name="period" value="1" checked><span class="box text-center"><b class="block text-sm text-slate-900">1 month</b></span></label>
          <label class="opt relative"><input type="radio" name="period" value="3"><span class="box text-center"><b class="block text-sm text-slate-900">3 months</b><span class="text-[11px] font-semibold text-green-600">Save 5%</span></span></label>
          <label class="opt relative"><input type="radio" name="period" value="12"><span class="box text-center"><b class="block text-sm text-slate-900">12 months</b><span class="text-[11px] font-semibold text-green-600">Save 15%</span></span></label>
        </div>
      </div>

      <!-- Step 2 details -->
      <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-6 sm:p-8 space-y-5">
        <h2 class="font-extrabold text-slate-900 text-xl"><span class="text-blue-600">2.</span> Your details</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
          <div><label for="name" class="block text-xs font-semibold text-slate-700 mb-1.5">Full name</label><input id="name" class="field" type="text" placeholder="Your name"></div>
          <div><label for="phone" class="block text-xs font-semibold text-slate-700 mb-1.5">Phone / WhatsApp</label><input id="phone" class="field" type="tel" placeholder="+256 7XX XXX XXX"></div>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
          <div><label for="email" class="block text-xs font-semibold text-slate-700 mb-1.5">Email</label><input id="email" class="field" type="email" placeholder="you@example.com"></div>
          <div><label for="dob" class="block text-xs font-semibold text-slate-700 mb-1.5">Date of birth</label><input id="dob" class="field" type="date"></div>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
          <div><label for="ename" class="block text-xs font-semibold text-slate-700 mb-1.5">Emergency contact name</label><input id="ename" class="field" type="text"></div>
          <div><label for="ephone" class="block text-xs font-semibold text-slate-700 mb-1.5">Emergency contact phone</label><input id="ephone" class="field" type="tel"></div>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
          <div><label for="start" class="block text-xs font-semibold text-slate-700 mb-1.5">Start date</label><input id="start" class="field" type="date"></div>
          <div>
            <label for="goal" class="block text-xs font-semibold text-slate-700 mb-1.5">Main goal</label>
            <select id="goal" class="field"><option value="">Select a goal</option><option>Lose weight</option><option>Build muscle</option><option>Get stronger</option><option>Improve fitness</option><option>Not sure yet</option></select>
          </div>
        </div>
        <div><label for="health" class="block text-xs font-semibold text-slate-700 mb-1.5">Health conditions or injuries <span class="font-normal text-slate-400">(optional)</span></label><textarea id="health" class="field" rows="2"></textarea></div>
      </div>

      <!-- Step 3 payment -->
      <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-6 sm:p-8">
        <h2 class="font-extrabold text-slate-900 text-xl"><span class="text-blue-600">3.</span> Payment method</h2>
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 mt-5">
          <label class="opt relative"><input type="radio" name="pay" value="MTN Mobile Money" checked><span class="box text-center"><i class="fa-solid fa-mobile-screen text-yellow-500 text-lg"></i><b class="block text-sm text-slate-900 mt-1">MTN MoMo</b></span></label>
          <label class="opt relative"><input type="radio" name="pay" value="Airtel Money"><span class="box text-center"><i class="fa-solid fa-mobile-screen text-red-500 text-lg"></i><b class="block text-sm text-slate-900 mt-1">Airtel Money</b></span></label>
          <label class="opt relative"><input type="radio" name="pay" value="Pay at the gym"><span class="box text-center"><i class="fa-solid fa-store text-sky-500 text-lg"></i><b class="block text-sm text-slate-900 mt-1">Pay at the gym</b></span></label>
        </div>
        <p class="text-xs text-slate-400 mt-3">No payment is taken on this page. We will send payment instructions after you submit.</p>

        <label class="flex items-start gap-2.5 mt-6 text-sm text-slate-600 cursor-pointer">
          <input id="terms" type="checkbox" class="mt-0.5 rounded border-slate-300 text-blue-600 focus:ring-blue-600">
          <span>I agree to the <a href="#" class="text-blue-600 font-medium hover:underline">membership terms</a> and confirm the details above are correct.</span>
        </label>

        <p id="formError" class="hidden text-sm text-red-600 mt-4"><i class="fa-solid fa-circle-exclamation mr-1"></i><span></span></p>
        <button type="submit" class="mt-5 w-full px-7 py-3 rounded-full bg-blue-600 text-white font-semibold text-[14px] shadow-sm hover:bg-blue-700 transition-colors">Join Now</button>
      </div>
    </form>

    <!-- Summary -->
    <aside class="lg:col-span-2 lg:sticky lg:top-24 space-y-4">
      <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-6">
        <h2 class="font-extrabold text-slate-900 text-lg">Order summary</h2>
        <dl class="mt-4 space-y-3 text-sm">
          <div class="flex justify-between"><dt class="text-slate-500">Plan</dt><dd id="sPlan" class="font-semibold text-slate-900"></dd></div>
          <div class="flex justify-between"><dt class="text-slate-500">Billing</dt><dd id="sPeriod" class="font-semibold text-slate-900"></dd></div>
          <div class="flex justify-between"><dt class="text-slate-500">Subtotal</dt><dd id="sSub" class="font-semibold text-slate-900"></dd></div>
          <div class="flex justify-between"><dt class="text-slate-500">Discount</dt><dd id="sDisc" class="font-semibold text-green-600"></dd></div>
        </dl>
        <div class="border-t border-slate-100 mt-4 pt-4 flex justify-between items-baseline">
          <span class="font-bold text-slate-900">Total</span>
          <span id="sTotal" class="text-2xl font-extrabold text-slate-900"></span>
        </div>
      </div>
      <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-6 text-sm text-slate-600 space-y-2">
        <p><i class="fa-solid fa-check text-sky-500 mr-2"></i>No joining fee</p>
        <p><i class="fa-solid fa-check text-sky-500 mr-2"></i>Free fitness assessment</p>
        <p><i class="fa-solid fa-check text-sky-500 mr-2"></i>Cancel anytime after your billing period</p>
        <p class="pt-2 text-xs text-slate-400">Not ready? <a href="book-tour.html" class="text-blue-600 font-medium hover:underline">Book a free tour first</a></p>
      </div>
    </aside>
  </section>

  <!-- Success -->
  <section id="success" class="hidden bg-white rounded-3xl border border-slate-100 shadow-sm p-8 sm:p-12 text-center max-w-[560px] mx-auto">
    <span class="w-16 h-16 mx-auto rounded-full bg-green-50 text-green-600 flex items-center justify-center text-2xl"><i class="fa-solid fa-check"></i></span>
    <h2 class="font-extrabold text-slate-900 text-2xl mt-5">Welcome to Pure gain!</h2>
    <p id="sucText" class="text-sm text-slate-500 mt-2 leading-relaxed"></p>
    <p class="mt-5 inline-block bg-slate-50 border border-slate-200 rounded-xl px-4 py-2 text-sm">Reference: <b id="sucRef" class="text-slate-900"></b></p>
    <p class="text-sm text-slate-500 mt-4">We will message you shortly with payment instructions and your next steps.</p>
    <div class="mt-6 flex flex-wrap justify-center gap-3">
      <a href="portal.html" class="px-6 py-2.5 rounded-full bg-blue-600 text-white font-semibold text-[14px] hover:bg-blue-700 transition-colors">Go to Member Portal</a>
      <a href="supplements.html" class="px-6 py-2.5 rounded-full border border-slate-300 font-semibold text-[14px] hover:border-blue-400 hover:text-blue-600 transition-colors">Browse Supplements</a>
    </div>
  </section>

</div>
</main>

<script>
  // Drawer
  const drawer = document.getElementById('drawer'), backdrop = document.getElementById('backdrop');
  function openD() { drawer.classList.remove('-translate-x-full'); backdrop.classList.remove('hidden'); document.body.style.overflow = 'hidden'; }
  function closeD() { drawer.classList.add('-translate-x-full'); backdrop.classList.add('hidden'); document.body.style.overflow = ''; }
  document.getElementById('menuBtn').addEventListener('click', openD);
  document.getElementById('closeBtn').addEventListener('click', closeD);
  backdrop.addEventListener('click', closeD);

  // Pricing (UGX per month) and discounts by billing period
  const PLANS = { starter: ['Starter', 150000], pro: ['Pro', 300000], elite: ['Elite', 500000] };
  const DISC = { 1: 0, 3: 0.05, 12: 0.15 };
  const fmt = n => 'UGX ' + Math.round(n).toLocaleString('en-US');
  const form = document.getElementById('joinForm');
  const val = n => form.querySelector('input[name="' + n + '"]:checked').value;

  function updateSummary() {
    const [label, price] = PLANS[val('plan')];
    const months = +val('period');
    const sub = price * months, disc = sub * DISC[months];
    document.getElementById('sPlan').textContent = label;
    document.getElementById('sPeriod').textContent = months + (months === 1 ? ' month' : ' months');
    document.getElementById('sSub').textContent = fmt(sub);
    document.getElementById('sDisc').textContent = disc ? '- ' + fmt(disc) : 'None';
    document.getElementById('sTotal').textContent = fmt(sub - disc);
    return { label, months, total: sub - disc };
  }
  form.addEventListener('change', updateSummary);

  // Preselect plan from ?plan=starter|pro|elite
  const qp = new URLSearchParams(location.search).get('plan');
  if (qp && PLANS[qp]) form.querySelector('input[name="plan"][value="' + qp + '"]').checked = true;
  updateSummary();

  // Dates
  const today = new Date().toISOString().split('T')[0];
  const startEl = document.getElementById('start');
  startEl.min = today; startEl.value = today;
  document.getElementById('dob').max = today;

  // Submit
  const g = id => document.getElementById(id);
  form.addEventListener('submit', e => {
    e.preventDefault();
    const req = ['name', 'phone', 'email', 'dob', 'ename', 'ephone', 'start', 'goal'];
    req.forEach(id => g(id).classList.remove('invalid'));
    let msg = '', bad = null;
    if (!g('name').value.trim()) { bad = 'name'; msg = 'Please enter your name.'; }
    else if (g('phone').value.replace(/\D/g, '').length < 9) { bad = 'phone'; msg = 'Please enter a valid phone number.'; }
    else if (!g('email').value || !g('email').checkValidity()) { bad = 'email'; msg = 'Please enter a valid email address.'; }
    else if (!g('dob').value) { bad = 'dob'; msg = 'Please enter your date of birth.'; }
    else if (!g('ename').value.trim()) { bad = 'ename'; msg = 'Please enter an emergency contact name.'; }
    else if (g('ephone').value.replace(/\D/g, '').length < 9) { bad = 'ephone'; msg = 'Please enter a valid emergency contact phone.'; }
    else if (!g('start').value || g('start').value < today) { bad = 'start'; msg = 'Please choose a start date from today onward.'; }
    else if (!g('goal').value) { bad = 'goal'; msg = 'Please select your main goal.'; }
    else if (!g('terms').checked) { msg = 'Please accept the membership terms.'; }

    const err = g('formError');
    if (msg) {
      if (bad) g(bad).classList.add('invalid');
      err.querySelector('span').textContent = msg;
      err.classList.remove('hidden');
      return;
    }
    err.classList.add('hidden');

    /* TODO: send the membership request to your server here, e.g.
       fetch('join-membership.php', { method: 'POST', body: ... })
       Currently this only shows the confirmation message. */

    const s = updateSummary();
    const ref = 'APX-' + Math.random().toString(36).slice(2, 8).toUpperCase();
    g('sucRef').textContent = ref;
    g('sucText').textContent = 'Thank you, ' + g('name').value.trim().split(' ')[0] + '. Your ' + s.label + ' membership (' + s.months + (s.months === 1 ? ' month' : ' months') + ', ' + fmt(s.total) + ') starts on ' +
      new Date(g('start').value + 'T00:00:00').toLocaleDateString('en-GB', { day: 'numeric', month: 'long', year: 'numeric' }) + '. Payment: ' + val('pay') + '.';
    g('joinWrap').classList.add('hidden');
    g('success').classList.remove('hidden');
    window.scrollTo({ top: 0, behavior: 'smooth' });
  });
</script>
</body>
</html>