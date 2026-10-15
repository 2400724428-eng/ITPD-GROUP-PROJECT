<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8"/>
  <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
  <title>ApexFit - Trainer Portal</title>
  
  <!-- CSS & Fonts -->
  <link href="../src/output.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet"/>
  <link href="https://fonts.googleapis.com" rel="preconnect"/>
  <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect"/>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet"/>
  
  <script>
    tailwind.config = { theme: { extend: { fontFamily: { sans: ['"Plus Jakarta Sans"', 'sans-serif'] } } } }
  </script>
  
  <style>
    :root { --accent: #2563eb; --accent-dark: #1d4ed8; }
    body { font-family: 'Plus Jakarta Sans', sans-serif; -webkit-font-smoothing: antialiased; }
    .no-scrollbar::-webkit-scrollbar { display: none; }
    .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }

    /* Shell & Navigation Layout */
    .shell { display: flex; flex-direction: column; }
    @media (min-width: 1024px) { .shell { flex-direction: row; } }
    
    .pnav { 
      position: relative; display: flex; align-items: center; flex-shrink: 0; text-align: left; background: #f1f1f1;
      font-size: 12.5px; font-weight: 700; letter-spacing: .04em; text-transform: uppercase; color: #4b5563;
      border-right: 1px solid #e2e2e2; white-space: nowrap; transition: background .25s, color .25s; cursor: pointer; 
    }
    .pnav .ic { width: 46px; height: 50px; display: flex; align-items: center; justify-content: center; font-size: 18px; color: #374151; transition: background .3s, color .3s; }
    .pnav .lbl { padding: 0 14px 0 2px; }
    .pnav:hover { background: #e8e8e8; }
    .pnav.active { background: #fff; color: #111; }
    .pnav.active .ic { background: var(--accent); color: #fff; }
    .pnav.active .ic i { animation: pop .5s cubic-bezier(.2,1.6,.4,1); }
    .pnav.out { color: #dc2626; } 
    .pnav.out .ic { color: #dc2626; }
    
    .badge { 
      display: none; margin-left: auto; margin-right: 12px; min-width: 20px; height: 20px; padding: 0 6px; border-radius: 999px;
      background: #dc2626; color: #fff; font-size: 11px; align-items: center; justify-content: center; letter-spacing: 0; 
    }
    
    @media (min-width: 1024px) {
      .pnav { width: 100%; border-right: 0; border-bottom: 1px solid #e2e2e2; }
      .pnav .ic { width: 52px; height: 52px; font-size: 20px; }
      .pnav .lbl { padding-left: 4px; }
      .pnav.active::after { content: ''; position: absolute; right: 0; top: 50%; margin-top: -9px; border: 9px solid transparent; border-right-color: #fff; animation: notch .35s ease both; }
    }

    /* Cards, Stats & Inputs */
    .ptitle { font-size: 24px; font-weight: 800; letter-spacing: -.01em; color: #1e4fa3; margin-top: 4px; }
    .card { background: #fff; border: 1px solid #eef0f3; border-radius: 22px; padding: 20px; box-shadow: 0 1px 2px rgba(0,0,0,.04); }
    
    .stat { background: #f8fafc; border: 1px solid #eef0f3; border-radius: 18px; padding: 14px 16px; transition: transform .25s, box-shadow .25s; }
    .stat:hover { transform: translateY(-3px); box-shadow: 0 12px 24px -12px rgba(0,0,0,.18); }
    .stat p { font-size: 11px; color: #64748b; font-weight: 600; }
    .stat b { display: block; font-size: 26px; font-weight: 800; color: #0f172a; margin-top: 2px; }
    
    .lab { display: block; font-size: 12px; font-weight: 600; color: #334155; }
    .inp { margin-top: 6px; width: 100%; background: #f8fafc; border: 1px solid #cbd5e1; border-radius: 12px; padding: 10px 14px; font-size: 14px; }
    .inp:focus { outline: none; border-color: var(--accent); box-shadow: 0 0 0 1px var(--accent); background: #fff; }
    .chip { font-size: 11px; font-weight: 700; color: #0369a1; background: #e0f2fe; border-radius: 999px; padding: 4px 10px; }

    /* Membership Rows Style */
    .mrow { display: flex; gap: 14px; align-items: center; border: 1px solid #d9d9d9; border-radius: 14px; background: linear-gradient(#fff, #f3f3f3); padding: 10px; transition: transform .25s, box-shadow .25s; }
    .mrow:hover { transform: translateY(-3px); box-shadow: 0 14px 26px -12px rgba(0,0,0,.25); }
    .mlogo { width: 64px; height: 64px; flex-shrink: 0; border-radius: 14px; display: flex; align-items: center; justify-content: center; font-size: 24px; }
    .mcols { flex: 1; min-width: 0; display: grid; grid-template-columns: repeat(2, 1fr); gap: 10px 14px; padding-left: 14px; border-left: 1px solid #e1e1e1; }
    @media (min-width: 768px) { .mcols { grid-template-columns: repeat(5, 1fr); } }
    .mcols .k { display: block; font-size: 11px; font-weight: 700; color: #374151; }
    .mcols .v { display: block; font-size: 12px; color: #6b7280; margin-top: 2px; }
    .dbar { height: 5px; background: #e5e7eb; border-radius: 99px; overflow: hidden; margin-top: 6px; }
    .dbar i { display: block; height: 100%; border-radius: 99px; transition: width 1.1s cubic-bezier(.2,.8,.2,1); }
    .renew { font-size: 11px; font-weight: 700; color: var(--accent); margin-top: 4px; display: inline-block; cursor: pointer; }
    .renew:hover { text-decoration: underline; }

    /* QR Code & Scanner Bar Animation */
    .qr { position: relative; width: 120px; height: 120px; border: 2px dashed #cbd5e1; border-radius: 18px; display: flex; align-items: center; justify-content: center; font-size: 72px; color: #0f172a; overflow: hidden; }
    .qr .scan { position: absolute; left: 0; right: 0; height: 3px; background: var(--accent); box-shadow: 0 0 12px var(--accent); animation: scan 2.4s ease-in-out infinite; }

    /* Keyframe Animations */
    .rise { animation: rise .5s cubic-bezier(.2,.8,.2,1) both; }
    .view.enter .st { animation: rise .6s cubic-bezier(.2,.8,.2,1) both; animation-delay: calc(var(--i, 0) * 70ms); }
    @keyframes rise { from { opacity: 0; transform: translateY(20px) scale(.98); } to { opacity: 1; transform: none; } }
    @keyframes pop { 0% { transform: scale(.4) rotate(-20deg); } 100% { transform: scale(1) rotate(0); } }
    @keyframes notch { from { opacity: 0; transform: translateX(10px); } to { opacity: 1; transform: none; } }
    @keyframes scan { 0%, 100% { top: 6%; } 50% { top: 92%; } }
  </style>
</head>
<body class="bg-slate-50 text-slate-800 antialiased min-h-screen flex flex-col">

  <!-- Header Section -->
  <header class="w-full border-b border-slate-200 bg-white sticky top-0 z-50 shadow-xs">
    <div class="max-w-[1100px] mx-auto px-4 h-16 flex items-center justify-between">
      <div class="flex items-center gap-3">
        <a class="flex items-center gap-2 select-none" href="index.php">
            <img src="assets/images/logos.png" alt="Logo Icon" style="width: 150px; height: auto; object-fit: contain;">
        </a>
      </div>
      <div class="flex items-center space-x-3 text-slate-700 font-medium text-sm">
        <span>Trainer Portal (ID: TR-1024)</span>
        <a href="portal.html" class="text-blue-600 hover:underline">Switch to Member View</a>
      </div>
    </div>
  </header>

  <!-- Main Container -->
  <main class="flex-grow py-6 px-4 sm:px-6">
    <div class="max-w-[1100px] mx-auto">
      <div class="shell bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">

        <!-- Sidebar Navigation Menu -->
        <aside class="menu lg:w-[240px] shrink-0 bg-[#f1f1f1]">
          <div class="hidden lg:flex items-center gap-3 px-4 py-5 border-b border-[#e2e2e2] bg-white">
            <span class="w-11 h-11 rounded-full text-white font-extrabold flex items-center justify-center shadow-md" style="background:var(--accent)">BS</span>
            <div class="min-w-0">
              <p class="font-bold text-slate-900 leading-tight truncate">Coach Brian Ssebunya</p>
              <p class="text-xs text-slate-500">ID: TR-1024</p>
            </div>
          </div>
          
          <nav id="pnav" class="flex lg:flex-col overflow-x-auto lg:overflow-visible no-scrollbar">
            <button data-view="dashboard" class="pnav active" type="button"><span class="ic"><i class="fa-solid fa-gauge-high"></i></span><span class="lbl">Dashboard</span></button>
            <button data-view="trainer" class="pnav" type="button"><span class="ic"><i class="fa-solid fa-user-tie"></i></span><span class="lbl">My Trainer Profile</span></button>
            <button data-view="classes" class="pnav" type="button"><span class="ic"><i class="fa-regular fa-calendar-check"></i></span><span class="lbl">Bookings</span></button>
            <button data-view="plan" class="pnav" type="button"><span class="ic"><i class="fa-solid fa-dumbbell"></i></span><span class="lbl">Client Roster Plans</span></button>
            <button data-view="notifications" class="pnav" type="button"><span class="ic"><i class="fa-solid fa-bullhorn"></i></span><span class="lbl">Notifications</span><span id="nBadge" class="badge inline-flex">3</span></button>
            <button data-view="account" class="pnav" type="button"><span class="ic"><i class="fa-regular fa-user"></i></span><span class="lbl">My Account</span></button>
            <button id="logoutBtn" class="pnav out" type="button"><span class="ic"><i class="fa-solid fa-arrow-right-from-bracket"></i></span><span class="lbl">Log out</span></button>
          </nav>
        </aside>

        <!-- Dynamic Content Area -->
        <div class="flex-1 min-w-0 p-5 sm:p-8 bg-white">

          <!-- 1. DASHBOARD VIEW -->
          <section id="v-dashboard" class="view">
            <p id="greet" class="st text-sm font-semibold text-slate-500">Good evening, Coach Brian</p>
            <h2 class="st ptitle">Active Memberships[cite: 4]</h2>
            
            <!-- Statistics Grid[cite: 4] -->
            <div class="st grid grid-cols-2 sm:grid-cols-4 gap-3 mt-5">
              <div class="stat"><p>Visits this month</p><b data-count="14">0</b></div>
              <div class="stat"><p>Classes booked</p><b id="statBooked" data-count="3">0</b></div>
              <div class="stat"><p>PT sessions left</p><b data-count="2">0</b></div>
              <div class="stat"><p>Reward points</p><b class="ptsLive" data-count="1250">0</b></div>
            </div>

            <!-- Memberships List[cite: 4] -->
            <div id="memList" class="space-y-3 mt-5"></div>

            <!-- Upcoming Sessions & Check-in[cite: 4] -->
            <div class="grid grid-cols-1 md:grid-cols-5 gap-5 mt-6">
              <div class="st md:col-span-3 card">
                <div class="flex items-center justify-between">
                  <h3 class="font-extrabold text-slate-900">Upcoming sessions</h3>
                  <button data-go="classes" class="text-sm font-semibold text-blue-600 hover:text-blue-700" type="button">Book more →</button>
                </div>
                <ul id="upcoming" class="mt-3 divide-y divide-slate-100 text-sm"></ul>
              </div>
              
              <div class="st md:col-span-2 card text-center">
                <h3 class="font-extrabold text-slate-900 text-left">Gym check-in</h3>
                <div class="qr mx-auto mt-4"><i class="fa-solid fa-qrcode"></i><span class="scan"></span></div>
                <p class="text-sm font-bold text-slate-900 mt-3">TR-1024</p>
                <p class="text-xs text-slate-400">Show this at the front desk</p>
              </div>
            </div>
          </section>

          <!-- 2. TRAINER PROFILE VIEW -->
          <section id="v-trainer" class="view hidden">
            <?php include 'views/profile.php'; ?>
          </section>

          <!-- 3. BOOKINGS VIEW -->
          <section id="v-classes" class="view hidden">
            <?php include 'views/bookings.php'; ?>
          </section>

          <!-- 4. ROSTER PLANS VIEW -->
          <section id="v-plan" class="view hidden">
            <?php include 'views/plans.php'; ?>
          </section>

          <!-- 5. NOTIFICATIONS VIEW -->
          <section id="v-notifications" class="view hidden">
            <?php include 'views/notifications.php'; ?>
          </section>

          <!-- 6. ACCOUNT VIEW -->
          <section id="v-account" class="view hidden">
            <?php include 'views/account.php'; ?>
          </section>

        </div>
      </div>
    </div>
  </main>

  <!-- Client-Side Animation & View Control Script -->
  <script>
    const $ = id => document.getElementById(id);
    const fmtUGX = n => 'UGX ' + n.toLocaleString('en-US');
    
    function countUp(el, to, from = 0, dur = 1000) {
      const t0 = performance.now();
      (function f(t) {
        const p = Math.min((t - t0) / dur, 1), e = 1 - Math.pow(1 - p, 3);
        el.textContent = Math.round(from + (to - from) * e).toLocaleString('en-US');
        if (p < 1) requestAnimationFrame(f);
      })(t0);
    }

    function enter(sec) {
      sec.classList.remove('enter'); void sec.offsetWidth;
      sec.querySelectorAll('.st').forEach((el, i) => el.style.setProperty('--i', i));
      sec.classList.add('enter');
      sec.querySelectorAll('[data-count]').forEach(el => countUp(el, +el.dataset.count));
    }

    function show(view) {
      document.querySelectorAll('.view').forEach(v => v.classList.toggle('hidden', v.id !== 'v-' + view));
      document.querySelectorAll('.pnav[data-view]').forEach(b => b.classList.toggle('active', b.dataset.view === view));
      enter($('v-' + view));
    }

    document.querySelectorAll('.pnav[data-view]').forEach(b => b.addEventListener('click', () => show(b.dataset.view)));
    document.querySelectorAll('[data-go]').forEach(b => b.addEventListener('click', () => show(b.dataset.go)));

    // Active Memberships Dataset[cite: 4]
    const MEMS = [
      { ic: 'fa-dumbbell', c: 'bg-sky-100 text-sky-600', n: 'Gym Membership', sub: 'Pro · 1 month', amt: 300000, date: '6 Oct 2026', left: 22, total: 30 },
      { ic: 'fa-user-check', c: 'bg-indigo-100 text-indigo-600', n: 'Personal Training Pack', sub: '4 sessions', amt: 240000, date: '24 Sept 2026', left: 40, total: 60 },
      { ic: 'fa-apple-whole', c: 'bg-emerald-100 text-emerald-600', n: 'Nutrition Coaching', sub: '3 months', amt: 180000, date: '14 Sept 2026', left: 61, total: 90 }
    ];

    function renderMems() {
      $('memList').innerHTML = '';
      MEMS.forEach((m) => {
        const r = document.createElement('div');
        r.className = 'mrow st';
        r.innerHTML = '<div class="mlogo ' + m.c + '"><i class="fa-solid ' + m.ic + '"></i></div><div class="mcols">' +
          '<div><span class="k">Service</span><span class="v">' + m.n + '</span></div>' +
          '<div><span class="k">Subscription</span><span class="v">' + m.sub + '</span></div>' +
          '<div><span class="k">Amount Paid</span><span class="v">' + fmtUGX(m.amt) + '</span></div>' +
          '<div><span class="k">Subscription Date</span><span class="v">' + m.date + '</span></div>' +
          '<div><span class="k">Days Left</span><span class="v font-bold">' + m.left + ' Days</span><div class="dbar"><i style="width:' + (m.left / m.total * 100) + '%;background:var(--accent)"></i></div><span class="renew" onclick="alert(\'Renewal request sent!\')">Renew</span></div></div>';
        $('memList').appendChild(r);
      });
    }

    renderMems();

    // Upcoming Sessions Mockup
    $('upcoming').innerHTML = `
      <li class="py-3 flex items-center justify-between"><div><b>08:00 AM</b> - PT Strength Training (Grace Nakato)</div><span class="text-xs text-slate-400">Confirmed</span></li>
      <li class="py-3 flex items-center justify-between"><div><b>10:30 AM</b> - Body Assessment (Peter Mukasa)</div><span class="text-xs text-slate-400">Confirmed</span></li>
      <li class="py-3 flex items-center justify-between"><div><b>02:00 PM</b> - Nutrition Check-in (Sarah Nassozi)</div><span class="text-xs text-slate-400">Confirmed</span></li>
    `;

    $('logoutBtn').addEventListener('click', () => { if (confirm('Log out of trainer portal?')) location.href = 'portal.html'; });

    // Initial View Load
    enter($('v-dashboard'));
  </script>
</body>
</html>