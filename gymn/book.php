<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>ApexFit - Book a Free Tour</title>
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
  .slot input { position: absolute; opacity: 0; }
  .slot span { display: block; text-align: center; padding: .55rem .5rem; font-size: .8rem; font-weight: 600; border: 1px solid #cbd5e1; border-radius: .75rem; cursor: pointer; background: #fff; transition: all .15s; }
  .slot span:hover { border-color: #60a5fa; }
  .slot input:checked + span { background: #2563eb; border-color: #2563eb; color: #fff; }
  .slot input:focus-visible + span { box-shadow: 0 0 0 2px #93c5fd; }
</style>
</head>
<body class="bg-slate-50 text-slate-800 antialiased min-h-screen flex flex-col">



</div>

<main class="flex-grow py-6 px-4 sm:px-6">
<div class="max-w-[1060px] w-full mx-auto space-y-10">

  <!-- Hero -->
  <section class="banner-gradient rounded-[2rem] px-6 sm:px-10 py-10 md:py-12 text-center">
    <p class="text-blue-600 text-[15px] font-semibold">Free Gym Tour</p>
    <h1 class="text-slate-900 text-3xl sm:text-4xl lg:text-[42px] font-extrabold tracking-tight leading-[1.2] mt-2 max-w-[600px] mx-auto">Book Your Free Tour & Fitness Assessment</h1>
    <p class="text-slate-500 text-sm sm:text-base mt-4 max-w-[500px] mx-auto">See the facilities, meet a coach and get a plan for your goals. No payment or commitment needed.</p>
  </section>

  <section class="grid grid-cols-1 lg:grid-cols-5 gap-6 lg:gap-8 items-start">

    <!-- Left: what to expect -->
    <aside class="lg:col-span-2 space-y-4">
      <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-6">
        <h2 class="font-extrabold text-slate-900 text-lg">What to expect</h2>
        <ul class="mt-4 space-y-4 text-sm text-slate-600">
          <li class="flex gap-3"><span class="w-9 h-9 shrink-0 rounded-xl bg-sky-50 text-sky-600 flex items-center justify-center"><i class="fa-solid fa-building"></i></span><span><b class="text-slate-800">Facility walk-through</b><br>Weights area, cardio zone and class studio.</span></li>
          <li class="flex gap-3"><span class="w-9 h-9 shrink-0 rounded-xl bg-sky-50 text-sky-600 flex items-center justify-center"><i class="fa-solid fa-clipboard-check"></i></span><span><b class="text-slate-800">Fitness assessment</b><br>Quick body check and goal setting with a coach.</span></li>
          <li class="flex gap-3"><span class="w-9 h-9 shrink-0 rounded-xl bg-sky-50 text-sky-600 flex items-center justify-center"><i class="fa-solid fa-tags"></i></span><span><b class="text-slate-800">Plan recommendation</b><br>We suggest the membership that fits you best.</span></li>
        </ul>
        <p class="text-xs text-slate-400 mt-5"><i class="fa-regular fa-clock mr-1"></i>Takes about 30 to 45 minutes</p>
      </div>
      <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-6 text-sm text-slate-600 space-y-2">
        <h2 class="font-extrabold text-slate-900 text-lg mb-2">Visit us</h2>
        <p><i class="fa-solid fa-location-dot text-sky-500 w-5"></i>Your gym address, Kampala</p>
        <p><i class="fa-solid fa-phone text-sky-500 w-5"></i>+256 700 000 000</p>
        <p><i class="fa-regular fa-clock text-sky-500 w-5"></i>Mon to Sat: 6:00 AM to 9:00 PM</p>
      </div>
    </aside>

    <!-- Right: form -->
    <div class="lg:col-span-3 bg-white rounded-3xl border border-slate-100 shadow-sm p-6 sm:p-8">

      <form id="tourForm" novalidate class="space-y-5">
        <h2 class="font-extrabold text-slate-900 text-xl">Your details</h2>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
          <div>
            <label for="name" class="block text-xs font-semibold text-slate-700 mb-1.5">Full name</label>
            <input id="name" class="field" type="text" placeholder="Your name" required>
          </div>
          <div>
            <label for="phone" class="block text-xs font-semibold text-slate-700 mb-1.5">Phone / WhatsApp</label>
            <input id="phone" class="field" type="tel" placeholder="+256 7XX XXX XXX" required>
          </div>
        </div>

        <div>
          <label for="email" class="block text-xs font-semibold text-slate-700 mb-1.5">Email <span class="font-normal text-slate-400">(optional)</span></label>
          <input id="email" class="field" type="email" placeholder="you@example.com">
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
          <div>
            <label for="date" class="block text-xs font-semibold text-slate-700 mb-1.5">Preferred date</label>
            <input id="date" class="field" type="date" required>
          </div>
          <div>
            <label for="goal" class="block text-xs font-semibold text-slate-700 mb-1.5">Main goal</label>
            <select id="goal" class="field" required>
              <option value="">Select a goal</option>
              <option>Lose weight</option>
              <option>Build muscle</option>
              <option>Get stronger</option>
              <option>Improve fitness</option>
              <option>Nutrition guidance</option>
              <option>Not sure yet</option>
            </select>
          </div>
        </div>

        <fieldset>
          <legend class="block text-xs font-semibold text-slate-700 mb-1.5">Preferred time</legend>
          <div id="slots" class="grid grid-cols-2 sm:grid-cols-4 gap-2">
            <label class="slot relative"><input type="radio" name="slot" value="Morning (6 to 9 AM)"><span>6 to 9 AM</span></label>
            <label class="slot relative"><input type="radio" name="slot" value="Midday (11 AM to 2 PM)"><span>11 AM to 2 PM</span></label>
            <label class="slot relative"><input type="radio" name="slot" value="Afternoon (3 to 5 PM)"><span>3 to 5 PM</span></label>
            <label class="slot relative"><input type="radio" name="slot" value="Evening (6 to 9 PM)"><span>6 to 9 PM</span></label>
          </div>
        </fieldset>

        <div>
          <label for="notes" class="block text-xs font-semibold text-slate-700 mb-1.5">Anything we should know? <span class="font-normal text-slate-400">(injuries, experience, questions)</span></label>
          <textarea id="notes" class="field" rows="3"></textarea>
        </div>

        <p id="formError" class="hidden text-sm text-red-600"><i class="fa-solid fa-circle-exclamation mr-1"></i><span></span></p>

        <button type="submit" class="w-full px-7 py-3 rounded-full bg-blue-600 text-white font-semibold text-[14px] shadow-sm hover:bg-blue-700 transition-colors">Book My Free Tour</button>
      </form>

      <!-- Success state -->
      <div id="success" class="hidden text-center py-8">
        <span class="w-16 h-16 mx-auto rounded-full bg-green-50 text-green-600 flex items-center justify-center text-2xl"><i class="fa-solid fa-check"></i></span>
        <h2 class="font-extrabold text-slate-900 text-2xl mt-5">Tour request received</h2>
        <p id="summary" class="text-sm text-slate-500 mt-2 leading-relaxed"></p>
        <p class="text-sm text-slate-500 mt-2">We will contact you to confirm your time.</p>
        <div class="mt-6 flex flex-wrap justify-center gap-3">
          <a href="gym-training.html" class="px-6 py-2.5 rounded-full border border-slate-300 font-semibold text-[14px] hover:border-blue-400 hover:text-blue-600 transition-colors">Back to Services</a>
          <a href="supplements.html" class="px-6 py-2.5 rounded-full bg-blue-600 text-white font-semibold text-[14px] hover:bg-blue-700 transition-colors">Browse Supplements</a>
        </div>
      </div>

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

  // No past dates
  const dateEl = document.getElementById('date');
  dateEl.min = new Date().toISOString().split('T')[0];

  // Form
  const form = document.getElementById('tourForm');
  const errBox = document.getElementById('formError');

  form.addEventListener('submit', e => {
    e.preventDefault();
    const name = document.getElementById('name'), phone = document.getElementById('phone'),
          email = document.getElementById('email'), goal = document.getElementById('goal');
    const slot = form.querySelector('input[name="slot"]:checked');
    [name, phone, email, dateEl, goal].forEach(el => el.classList.remove('invalid'));

    let msg = '';
    if (!name.value.trim()) { name.classList.add('invalid'); msg = 'Please enter your name.'; }
    else if (phone.value.replace(/\D/g, '').length < 9) { phone.classList.add('invalid'); msg = 'Please enter a valid phone number.'; }
    else if (email.value && !email.checkValidity()) { email.classList.add('invalid'); msg = 'Please enter a valid email address.'; }
    else if (!dateEl.value || dateEl.value < dateEl.min) { dateEl.classList.add('invalid'); msg = 'Please choose a date from today onward.'; }
    else if (!goal.value) { goal.classList.add('invalid'); msg = 'Please select your main goal.'; }
    else if (!slot) { msg = 'Please choose a preferred time.'; }

    if (msg) {
      errBox.querySelector('span').textContent = msg;
      errBox.classList.remove('hidden');
      return;
    }
    errBox.classList.add('hidden');

    /* TODO: send the booking to your server here, e.g.
       fetch('book-tour.php', { method: 'POST', body: new FormData(...) })
       Currently this only shows the confirmation message. */

    const nice = new Date(dateEl.value + 'T00:00:00').toLocaleDateString('en-GB', { weekday: 'long', day: 'numeric', month: 'long' });
    document.getElementById('summary').textContent = 'Thank you, ' + name.value.trim().split(' ')[0] + '. We have you down for ' + nice + ', ' + slot.value + '.';
    form.classList.add('hidden');
    document.getElementById('success').classList.remove('hidden');
    window.scrollTo({ top: 0, behavior: 'smooth' });
  });
</script>
</body>
</html>