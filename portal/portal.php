<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>ApexFit - Member Portal</title>
<link href="../src/output.css" rel="stylesheet">

<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet"/>
<link href="https://fonts.googleapis.com" rel="preconnect"/>
<link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect"/>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet"/>
<script>
  tailwind.config = { theme: { extend: { fontFamily: { sans: ['"Plus Jakarta Sans"', 'sans-serif'] } } } }
</script>
<style>
  /* Change --accent to #e53935 for the red look from the reference */
  :root { --accent: #2563eb; --accent-dark: #1d4ed8; }
  body { font-family: 'Plus Jakarta Sans', sans-serif; -webkit-font-smoothing: antialiased; }
  .no-scrollbar::-webkit-scrollbar { display: none; }
  .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }

  /* ---------- Shell + menu ---------- */
  .shell { display: flex; flex-direction: column; }
  @media (min-width: 1024px) { .shell { flex-direction: row; } }
  .pnav { position: relative; display: flex; align-items: center; flex-shrink: 0; text-align: left; background: #f1f1f1;
    font-size: 12.5px; font-weight: 700; letter-spacing: .04em; text-transform: uppercase; color: #4b5563;
    border-right: 1px solid #e2e2e2; white-space: nowrap; transition: background .25s, color .25s; }
  .pnav .ic { width: 46px; height: 50px; display: flex; align-items: center; justify-content: center; font-size: 18px; color: #374151; transition: background .3s, color .3s; }
  .pnav .lbl { padding: 0 14px 0 2px; }
  .pnav:hover { background: #e8e8e8; }
  .pnav.active { background: #fff; color: #111; }
  .pnav.active .ic { background: var(--accent); color: #fff; }
  .pnav.active .ic i { animation: pop .5s cubic-bezier(.2,1.6,.4,1); }
  .pnav.out { color: #dc2626; } .pnav.out .ic { color: #dc2626; }
  .badge { display: none; margin-left: auto; margin-right: 12px; min-width: 20px; height: 20px; padding: 0 6px; border-radius: 999px;
    background: #dc2626; color: #fff; font-size: 11px; align-items: center; justify-content: center; letter-spacing: 0; }
  @media (min-width: 1024px) {
    .pnav { width: 100%; border-right: 0; border-bottom: 1px solid #e2e2e2; }
    .pnav .ic { width: 52px; height: 52px; font-size: 20px; }
    .pnav .lbl { padding-left: 4px; }
    .pnav.active::after { content: ''; position: absolute; right: 0; top: 50%; margin-top: -9px; border: 9px solid transparent; border-right-color: #fff; animation: notch .35s ease both; }
  }

  /* ---------- Panel pieces ---------- */
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
  .av { display: flex; justify-content: space-between; gap: 10px; background: #f8fafc; border-radius: 12px; padding: 10px 14px; }
  .av span { color: #64748b; }

  /* Membership rows (reference style) */
  .mrow { display: flex; gap: 14px; align-items: center; border: 1px solid #d9d9d9; border-radius: 14px; background: linear-gradient(#fff, #f3f3f3); padding: 10px; transition: transform .25s, box-shadow .25s; }
  .mrow:hover { transform: translateY(-3px); box-shadow: 0 14px 26px -12px rgba(0,0,0,.25); }
  .mlogo { width: 64px; height: 64px; flex-shrink: 0; border-radius: 14px; display: flex; align-items: center; justify-content: center; font-size: 24px; }
  .mcols { flex: 1; min-width: 0; display: grid; grid-template-columns: repeat(2, 1fr); gap: 10px 14px; padding-left: 14px; border-left: 1px solid #e1e1e1; }
  @media (min-width: 768px) { .mcols { grid-template-columns: repeat(5, 1fr); } }
  .mcols .k { display: block; font-size: 11px; font-weight: 700; color: #374151; }
  .mcols .v { display: block; font-size: 12px; color: #6b7280; margin-top: 2px; }
  .dbar { height: 5px; background: #e5e7eb; border-radius: 99px; overflow: hidden; margin-top: 6px; }
  .dbar i { display: block; height: 100%; border-radius: 99px; transition: width 1.1s cubic-bezier(.2,.8,.2,1); }
  .bar { transition: width 1.1s cubic-bezier(.2,.8,.2,1); }
  .bar-h { transition: height 1s cubic-bezier(.2,.8,.2,1); }
  .renew { font-size: 11px; font-weight: 700; color: var(--accent); margin-top: 4px; }
  .renew:hover { text-decoration: underline; }

  /* QR */
  .qr { position: relative; width: 120px; height: 120px; border: 2px dashed #cbd5e1; border-radius: 18px; display: flex; align-items: center; justify-content: center; font-size: 72px; color: #0f172a; overflow: hidden; }
  .qr .scan { position: absolute; left: 0; right: 0; height: 3px; background: var(--accent); box-shadow: 0 0 12px var(--accent); animation: scan 2.4s ease-in-out infinite; }

  /* Trainer */
  .trainer-hero, .points-hero { color: #fff; border-radius: 26px; padding: 26px; background: linear-gradient(135deg, #1d4ed8, #0f172a); box-shadow: 0 20px 40px -18px rgba(29,78,216,.6); position: relative; overflow: hidden; }
  .trainer-hero::before, .points-hero::before { content: ''; position: absolute; width: 260px; height: 260px; right: -70px; top: -90px; border-radius: 50%; background: rgba(255,255,255,.07); animation: float 7s ease-in-out infinite; }
  .avatar { width: 96px; height: 96px; border-radius: 50%; background: linear-gradient(135deg, #38bdf8, #2563eb); border: 3px solid rgba(255,255,255,.7); font-size: 32px; font-weight: 800; display: flex; align-items: center; justify-content: center; animation: ring 2.2s infinite; overflow: hidden; }
  .hbtn { display: inline-flex; align-items: center; padding: 10px 20px; border-radius: 999px; font-size: 14px; font-weight: 600; transition: transform .2s, background .2s; }
  .hbtn:hover { transform: translateY(-2px); }
  .chatbox { height: 250px; overflow-y: auto; background: #f8fafc; border-radius: 18px; padding: 14px; display: flex; flex-direction: column; gap: 8px; scroll-behavior: smooth; }
  .bub { max-width: 80%; padding: 9px 14px; border-radius: 18px; font-size: 14px; line-height: 1.4; }
  .bub span { display: block; font-size: 10px; opacity: .6; margin-top: 3px; }
  .bub.me { align-self: flex-end; background: var(--accent); color: #fff; border-bottom-right-radius: 5px; }
  .bub.them { align-self: flex-start; background: #fff; border: 1px solid #e2e8f0; border-bottom-left-radius: 5px; color: #0f172a; }
  .bub.typing { display: flex; gap: 4px; padding: 13px 16px; }
  .bub.typing i { width: 7px; height: 7px; border-radius: 50%; background: #94a3b8; animation: bounce 1s infinite; }
  .bub.typing i:nth-child(2) { animation-delay: .15s; } .bub.typing i:nth-child(3) { animation-delay: .3s; }

  /* History + tabs */
  .htab { padding: 8px 18px; border-radius: 999px; font-size: 13px; font-weight: 600; color: #475569; background: #f1f5f9; transition: all .25s; }
  .htab:hover { background: #e2e8f0; }
  .htab.on { background: var(--accent); color: #fff; box-shadow: 0 6px 14px -6px var(--accent); }
  .hrow { display: flex; justify-content: space-between; align-items: center; gap: 12px; padding: 14px 16px; margin-bottom: 8px; background: #fff; border: 1px solid #eef0f3; border-radius: 16px; font-size: 14px; transition: transform .2s, box-shadow .2s; }
  .hrow:hover { transform: translateX(4px); box-shadow: 0 8px 18px -10px rgba(0,0,0,.2); }

  .pulse { animation: pulse 1.6s infinite; }

  /* ---------- Animations ---------- */
  .rise { animation: rise .5s cubic-bezier(.2,.8,.2,1) both; }
  .view.enter .st { animation: rise .6s cubic-bezier(.2,.8,.2,1) both; animation-delay: calc(var(--i, 0) * 70ms); }
  .view.enter .ptitle { animation-name: slide; }
  @keyframes rise { from { opacity: 0; transform: translateY(20px) scale(.98); } to { opacity: 1; transform: none; } }
  @keyframes slide { from { opacity: 0; transform: translateX(-24px); } to { opacity: 1; transform: none; } }
  @keyframes pop { 0% { transform: scale(.4) rotate(-20deg); } 100% { transform: scale(1) rotate(0); } }
  @keyframes notch { from { opacity: 0; transform: translateX(10px); } to { opacity: 1; transform: none; } }
  @keyframes scan { 0%, 100% { top: 6%; } 50% { top: 92%; } }
  @keyframes ring { 0% { box-shadow: 0 0 0 0 rgba(255,255,255,.5); } 100% { box-shadow: 0 0 0 20px rgba(255,255,255,0); } }
  @keyframes float { 0%, 100% { transform: translate(0, 0); } 50% { transform: translate(-18px, 14px); } }
  @keyframes bounce { 0%, 60%, 100% { transform: translateY(0); } 30% { transform: translateY(-5px); } }
  @keyframes pulse { 0% { box-shadow: 0 0 0 0 rgba(37,99,235,.5); } 100% { box-shadow: 0 0 0 9px rgba(37,99,235,0); } }
  @media (prefers-reduced-motion: reduce) {
    *, *::before, *::after { animation-duration: .001ms !important; animation-iteration-count: 1 !important; transition-duration: .001ms !important; }
  }
</style>
</head>
<body class="bg-slate-50 text-slate-800 antialiased min-h-screen flex flex-col">

<!-- BEGIN: MainHeader -->
<header class="w-full border-b border-slate-200 bg-white sticky top-0 z-50 shadow-xs" data-purpose="site-header">
<div class="max-w-[1100px] mx-auto px-4 h-16 flex items-center justify-between">
<div class="flex items-center gap-3">
  <button id="menuToggleBtn" aria-label="Toggle Menu" class="md:hidden p-1.5 text-slate-700 hover:text-blue-600 hover:bg-slate-100 rounded-lg transition-colors" type="button">
    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
    </svg>
  </button>
  <a class="flex items-center gap-2 select-none" href="index.php">
      <img src="assets/images/logos.png" alt="Logo Icon" style="width: 150px; height: auto; object-fit: contain;">
  </a>
</div>

<nav class="hidden md:flex items-center space-x-4 text-[14px] font-medium text-slate-700" data-purpose="main-navigation">
    <a class="flex items-center gap-1.5 whitespace-nowrap hover:text-blue-600 transition-colors" href="index.php">
        <svg class="w-4 h-4 text-slate-500 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
        Home
    </a>
    <a class="flex items-center gap-1.5 whitespace-nowrap hover:text-blue-600 transition-colors" href="supplements.html">
        <svg class="w-4 h-4 text-slate-500 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
        Supplements
    </a>
    <a class="flex items-center gap-1.5 whitespace-nowrap hover:text-blue-600 transition-colors" href="gym-training.html">
        <svg class="w-4 h-4 text-slate-500 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 13.5l10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75z"></path></svg>
        Gym Training
    </a>
    <a class="flex items-center gap-1.5 whitespace-nowrap hover:text-blue-600 transition-colors" href="calculator.html">
        <svg class="w-4 h-4 text-slate-500 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
        Calculator
    </a>
    <a class="flex items-center gap-1.5 whitespace-nowrap hover:text-blue-600 transition-colors" href="about.html">
        <svg class="w-4 h-4 text-slate-500 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        About
    </a>
    <a class="flex items-center gap-1.5 whitespace-nowrap hover:text-blue-600 transition-colors" href="contact.html">
        <svg class="w-4 h-4 text-slate-500 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
        Contact
    </a>
    <a class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full border border-slate-300 text-[13px] font-medium text-slate-800 hover:border-blue-400 hover:bg-slate-50 transition-all shadow-sm whitespace-nowrap shrink-0" href="portal.html">
        <svg class="w-4 h-4 text-slate-600 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
        Member Portal
    </a>
</nav>

<div class="flex items-center space-x-3 sm:space-x-4 text-slate-700" data-purpose="user-utilities">
<button id="searchToggleBtn" aria-label="Search" class="p-1.5 hover:text-blue-600 hover:bg-slate-100 rounded-full transition-colors" type="button">
<svg class="w-5 h-5 stroke-[2]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
<path d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" stroke-linecap="round" stroke-linejoin="round"></path>
</svg>
</button>

<a aria-label="Wishlist" class="relative p-1.5 hover:text-blue-600 hover:bg-slate-100 rounded-full transition-colors" href="#">
<svg class="w-5 h-5 stroke-[2]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
<path d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" stroke-linecap="round" stroke-linejoin="round"></path>
</svg>
<span class="absolute top-0.5 right-0.5 bg-red-600 text-white text-[10px] font-bold w-4 h-4 rounded-full flex items-center justify-center">2</span>
</a>

<a aria-label="Cart" class="relative p-1.5 hover:text-blue-600 hover:bg-slate-100 rounded-full transition-colors" href="#">
<svg class="w-5 h-5 stroke-[2]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
<path d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007zM8.625 10.5a.375.375 0 11-.75 0 .375.375 0 01.75 0zm7.5 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" stroke-linecap="round" stroke-linejoin="round"></path>
</svg>
<span class="absolute top-0.5 right-0.5 bg-red-600 text-white text-[10px] font-bold w-4 h-4 rounded-full flex items-center justify-center">3</span>
</a>

<a class="hidden sm:flex items-center space-x-1.5 text-[14px] font-medium hover:text-blue-600 transition-colors pl-1" href="#">
<svg class="w-5 h-5 stroke-[2]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
<path d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" stroke-linecap="round" stroke-linejoin="round"></path>
</svg>
<span>Account</span>
</a>
</div>
</div>

<div id="floatingSearch" class="hidden absolute top-full left-0 w-full bg-white border-b border-slate-200 shadow-md p-3 px-4 transition-all z-40">
  <form action="#" method="GET" class="max-w-[700px] mx-auto flex items-center gap-2">
    <div class="relative flex-grow">
      <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/></svg>
      </span>
      <input type="text" placeholder="Search supplements, workouts, plans..." class="w-full pl-9 pr-4 py-2 bg-slate-50 border border-slate-300 rounded-lg text-sm text-slate-800 focus:outline-none focus:border-blue-600 focus:ring-1 focus:ring-blue-600">
    </div>
    <button type="submit" class="px-4 py-2 bg-blue-600 text-white font-medium text-sm rounded-lg hover:bg-blue-700 transition-colors shrink-0">
      Search
    </button>
  </form>
</div>
</header>
<!-- END: MainHeader -->

<div id="mobileDrawerBackdrop" class="fixed inset-0 bg-black/50 z-50 hidden transition-opacity"></div>
<div id="mobileDrawer" class="fixed top-0 left-0 w-[280px] h-full bg-white shadow-2xl z-50 transform -translate-x-full transition-transform duration-300 flex flex-col">
  <div class="p-4 border-b border-slate-200 flex items-center justify-between">
    <span class="font-bold text-slate-900 text-lg">Menu</span>
    <button id="closeDrawerBtn" aria-label="Close Menu" class="p-1.5 text-slate-500 hover:text-slate-800 rounded-lg">
      <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
    </button>
  </div>
  <div class="flex-grow overflow-y-auto py-4 px-4 space-y-2 text-slate-700 font-medium">
    <a class="flex items-center gap-3 px-3 py-2.5 rounded-lg hover:bg-slate-100 hover:text-blue-600 transition-colors" href="index.php">
        <svg class="w-5 h-5 text-slate-500 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
        Home
    </a>
    <a class="flex items-center gap-3 px-3 py-2.5 rounded-lg hover:bg-slate-100 hover:text-blue-600 transition-colors" href="supplements.html">
        <svg class="w-5 h-5 text-slate-500 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
        Supplements
    </a>
    <a class="flex items-center gap-3 px-3 py-2.5 rounded-lg hover:bg-slate-100 hover:text-blue-600 transition-colors" href="gym-training.html">
        <svg class="w-5 h-5 text-slate-500 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 13.5l10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75z"></path></svg>
        Gym Training
    </a>
    <a class="flex items-center gap-3 px-3 py-2.5 rounded-lg hover:bg-slate-100 hover:text-blue-600 transition-colors" href="calculator.html">
        <svg class="w-5 h-5 text-slate-500 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
        Calculator
    </a>
    <a class="flex items-center gap-3 px-3 py-2.5 rounded-lg hover:bg-slate-100 hover:text-blue-600 transition-colors" href="about.html">
        <svg class="w-5 h-5 text-slate-500 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        About
    </a>
    <a class="flex items-center gap-3 px-3 py-2.5 rounded-lg hover:bg-slate-100 hover:text-blue-600 transition-colors" href="contact.html">
        <svg class="w-5 h-5 text-slate-500 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
        Contact
    </a>
  </div>
  <div class="p-4 border-t border-slate-200">
    <a class="flex items-center justify-center gap-2 w-full px-4 py-2.5 rounded-xl bg-blue-600 text-white font-medium text-sm shadow-sm hover:bg-blue-700 transition-colors" href="portal.html">
        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
        Member Portal
    </a>
  </div>
</div>

<main class="flex-grow py-6 px-4 sm:px-6">
<div class="max-w-[1100px] mx-auto">
<div class="shell bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">

  <!-- Menu -->
  <aside class="menu lg:w-[240px] shrink-0 bg-[#f1f1f1]">
    <div class="hidden lg:flex items-center gap-3 px-4 py-5 border-b border-[#e2e2e2] bg-white">
      <span class="w-11 h-11 rounded-full text-white font-extrabold flex items-center justify-center" style="background:var(--accent)">GN</span>
      <div class="min-w-0"><p class="font-bold text-slate-900 leading-tight truncate">Grace Nakato</p><p class="text-xs text-slate-500">ID: APX-0231</p></div>
    </div>
    <nav id="pnav" class="flex lg:flex-col overflow-x-auto lg:overflow-visible no-scrollbar">
      <button data-view="dashboard" class="pnav" type="button"><span class="ic"><i class="fa-solid fa-gauge-high"></i></span><span class="lbl">Dashboard</span></button>
      <button data-view="trainer" class="pnav" type="button"><span class="ic"><i class="fa-solid fa-user-tie"></i></span><span class="lbl">My Trainer</span></button>
      <button data-view="classes" class="pnav" type="button"><span class="ic"><i class="fa-regular fa-calendar-check"></i></span><span class="lbl">Book Classes</span></button>
      <button data-view="plan" class="pnav" type="button"><span class="ic"><i class="fa-solid fa-dumbbell"></i></span><span class="lbl">My Plan</span></button>
      <button data-view="history" class="pnav" type="button"><span class="ic"><i class="fa-solid fa-clock-rotate-left"></i></span><span class="lbl">History</span></button>
      <button data-view="points" class="pnav" type="button"><span class="ic"><i class="fa-solid fa-coins"></i></span><span class="lbl">Redeem Points</span></button>
      <button data-view="notifications" class="pnav" type="button"><span class="ic"><i class="fa-solid fa-bullhorn"></i></span><span class="lbl">Notifications</span><span id="nBadge" class="badge"></span></button>
      <button data-view="account" class="pnav" type="button"><span class="ic"><i class="fa-regular fa-user"></i></span><span class="lbl">My Account</span></button>
      <button id="logoutBtn" class="pnav out" type="button"><span class="ic"><i class="fa-solid fa-arrow-right-from-bracket"></i></span><span class="lbl">Log out</span></button>
    </nav>
  </aside>

  <!-- Panel -->
  <div class="flex-1 min-w-0 p-5 sm:p-8 bg-white">

  <!-- DASHBOARD -->
  <section id="v-dashboard" class="view">
    <p id="greet" class="st text-sm font-semibold text-slate-500"></p>
    <h2 class="st ptitle">Active Memberships</h2>
    <div class="st grid grid-cols-2 sm:grid-cols-4 gap-3 mt-5">
      <div class="stat"><p>Visits this month</p><b data-count="14">0</b></div>
      <div class="stat"><p>Classes booked</p><b id="statBooked" data-count="0">0</b></div>
      <div class="stat"><p>PT sessions left</p><b data-count="2">0</b></div>
      <div class="stat"><p>Reward points</p><b class="ptsLive" data-count="1250">0</b></div>
    </div>
    <div id="memList" class="space-y-3 mt-5"></div>

    <div class="grid grid-cols-1 md:grid-cols-5 gap-5 mt-6">
      <div class="st md:col-span-3 card">
        <div class="flex items-center justify-between"><h3 class="font-extrabold text-slate-900">Upcoming sessions</h3><button data-go="classes" class="text-sm font-semibold text-blue-600 hover:text-blue-700" type="button">Book more →</button></div>
        <ul id="upcoming" class="mt-3 divide-y divide-slate-100"></ul>
      </div>
      <div class="st md:col-span-2 card text-center">
        <h3 class="font-extrabold text-slate-900 text-left">Gym check-in</h3>
        <div class="qr mx-auto mt-4"><i class="fa-solid fa-qrcode"></i><span class="scan"></span></div>
        <p class="text-sm font-bold text-slate-900 mt-3">APX-0231</p>
        <p class="text-xs text-slate-400">Show this at the front desk</p>
      </div>
    </div>
  </section>

  <!-- TRAINER -->
  <section id="v-trainer" class="view hidden">
    <h2 class="st ptitle">My Trainer</h2>
    <div class="st trainer-hero mt-5">
      <div class="flex flex-col sm:flex-row gap-5 sm:items-center">
        <!-- Replace the initials with <img src="assets/images/trainer.jpg" class="w-full h-full object-cover rounded-full"> -->
        <div class="avatar shrink-0">BS</div>
        <div class="min-w-0">
          <span class="inline-block text-[11px] font-extrabold bg-white/15 rounded-full px-3 py-1">ASSIGNED TRAINER</span>
          <h3 class="text-2xl font-extrabold mt-2">Coach Brian Ssebunya</h3>
          <p class="text-sm text-blue-100">Strength & Conditioning Coach</p>
          <p class="mt-2 text-amber-300 text-sm"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i> <span class="text-white font-semibold ml-1">4.9</span> <span class="text-blue-200">(86 reviews)</span></p>
        </div>
      </div>
      <div class="flex flex-wrap gap-3 mt-6">
        <button id="msgBtn" class="hbtn bg-white text-blue-700" type="button"><i class="fa-regular fa-message mr-2"></i>Message</button>
        <a href="https://wa.me/256700000000" class="hbtn border border-white/40 text-white"><i class="fa-brands fa-whatsapp mr-2"></i>WhatsApp</a>
        <a href="tel:+256700000000" class="hbtn border border-white/40 text-white"><i class="fa-solid fa-phone mr-2"></i>Call</a>
      </div>
    </div>

    <div class="grid grid-cols-3 gap-3 mt-5">
      <div class="st stat"><p>Experience</p><b><span data-count="6">0</span> yrs</b></div>
      <div class="st stat"><p>Members trained</p><b><span data-count="120">0</span>+</b></div>
      <div class="st stat"><p>With you since</p><b class="!text-lg" id="trSince"></b></div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mt-5">
      <div class="st card">
        <h3 class="font-extrabold text-slate-900">About your coach</h3>
        <p class="text-sm text-slate-500 mt-2 leading-relaxed">Brian focuses on fat loss and strength building for busy professionals. He tracks your progress weekly and adjusts your plan as you improve.</p>
        <div class="flex flex-wrap gap-2 mt-3"><span class="chip">ACE Certified</span><span class="chip">Nutrition Level 2</span><span class="chip">First Aid</span><span class="chip">Strength</span></div>
        <div class="mt-4 rounded-2xl bg-sky-50 p-4 text-sm"><p class="text-xs font-bold text-sky-700">NEXT SESSION</p><p id="trNext" class="font-semibold text-slate-900 mt-1"></p></div>
        <button id="changeTrainer" class="mt-4 text-xs font-semibold text-slate-400 hover:text-blue-600 transition-colors" type="button">Request a different trainer</button>
      </div>
      <div class="st card">
        <h3 class="font-extrabold text-slate-900">Weekly availability</h3>
        <ul class="mt-3 space-y-2 text-sm">
          <li class="av"><b>Mon, Wed, Fri</b><span>6:00 AM to 12:00 PM</span></li>
          <li class="av"><b>Tue, Thu</b><span>2:00 PM to 8:00 PM</span></li>
          <li class="av"><b>Saturday</b><span>7:00 AM to 1:00 PM</span></li>
        </ul>
      </div>
    </div>

    <div id="chatCard" class="st card mt-5">
      <h3 class="font-extrabold text-slate-900">Chat with Coach Brian</h3>
      <div id="chatBox" class="chatbox mt-3"></div>
      <form id="chatForm" class="flex gap-2 mt-3">
        <input id="chatInput" autocomplete="off" placeholder="Type a message..." class="flex-1 bg-slate-50 border border-slate-300 rounded-full px-4 py-2.5 text-sm focus:outline-none focus:border-blue-600 focus:ring-1 focus:ring-blue-600">
        <button class="w-11 h-11 shrink-0 rounded-full bg-blue-600 text-white hover:bg-blue-700 transition-colors" type="submit" aria-label="Send"><i class="fa-solid fa-paper-plane"></i></button>
      </form>
    </div>
  </section>

  <!-- CLASSES -->
  <section id="v-classes" class="view hidden">
    <h2 class="st ptitle">Book Classes</h2>
    <p class="st text-sm text-slate-500 mt-1">Pick a day and reserve your spot.</p>
    <div id="days" class="st flex gap-2 overflow-x-auto no-scrollbar py-4"></div>
    <div id="classList" class="space-y-3"></div>
  </section>

  <!-- PLAN -->
  <section id="v-plan" class="view hidden">
    <h2 class="st ptitle">My Plan</h2>
    <p class="st text-sm text-slate-500 mt-1">Your weekly workout plan from Coach Brian.</p>
    <div class="st card mt-5"><ul id="week" class="divide-y divide-slate-100 text-sm"></ul></div>
    <div class="grid grid-cols-1 md:grid-cols-5 gap-5 mt-5">
      <div class="st md:col-span-3 card">
        <div class="flex items-center justify-between"><h3 class="font-extrabold text-slate-900">Weight progress</h3><span class="text-xs font-semibold text-green-600">-3.4 kg in 6 weeks</span></div>
        <div id="weightChart" class="mt-5 flex items-end gap-3 h-44"></div>
      </div>
      <div class="st md:col-span-2 card">
        <h3 class="font-extrabold text-slate-900">Personal bests</h3>
        <div id="pbs" class="mt-4 space-y-3 text-sm"></div>
      </div>
    </div>
  </section>

  <!-- HISTORY -->
  <section id="v-history" class="view hidden">
    <h2 class="st ptitle">History</h2>
    <div class="st flex gap-2 mt-4" id="hTabs">
      <button data-t="pay" class="htab" type="button">Payments</button>
      <button data-t="orders" class="htab" type="button">Orders</button>
      <button data-t="visits" class="htab" type="button">Check-ins</button>
    </div>
    <div id="hBody" class="mt-4"></div>
  </section>

  <!-- POINTS -->
  <section id="v-points" class="view hidden">
    <h2 class="st ptitle">Redeem Points</h2>
    <div class="st points-hero mt-5">
      <p class="text-sm text-blue-100">Your balance</p>
      <p class="text-4xl sm:text-5xl font-extrabold mt-1"><i class="fa-solid fa-coins text-amber-300 mr-2"></i><span id="pointsNum" class="ptsLive" data-count="1250">0</span> <span class="text-lg font-semibold text-blue-200">pts</span></p>
      <div class="mt-5 h-2.5 bg-white/15 rounded-full overflow-hidden max-w-[420px]"><div id="pointsBar" class="bar h-full bg-amber-300 rounded-full" data-w="0%"></div></div>
      <p id="pointsNext" class="text-xs text-blue-100 mt-2"></p>
    </div>
    <h3 class="st font-extrabold text-slate-900 mt-6">Rewards</h3>
    <div id="rewardGrid" class="grid grid-cols-1 sm:grid-cols-2 gap-3 mt-3"></div>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mt-6">
      <div class="st card"><h3 class="font-extrabold text-slate-900">How to earn</h3>
        <ul class="mt-3 space-y-2.5 text-sm text-slate-600">
          <li><i class="fa-solid fa-person-walking text-sky-500 w-6"></i>Gym visit <b class="float-right text-slate-900">+10</b></li>
          <li><i class="fa-regular fa-calendar-check text-sky-500 w-6"></i>Attend a class <b class="float-right text-slate-900">+50</b></li>
          <li><i class="fa-solid fa-bag-shopping text-sky-500 w-6"></i>Shop order <b class="float-right text-slate-900">+100</b></li>
          <li><i class="fa-solid fa-user-group text-sky-500 w-6"></i>Refer a friend <b class="float-right text-slate-900">+300</b></li>
        </ul></div>
      <div class="st card"><h3 class="font-extrabold text-slate-900">Redeemed</h3><ul id="redeemedList" class="mt-3 space-y-2 text-sm text-slate-600"><li class="text-slate-400">Nothing redeemed yet.</li></ul></div>
    </div>
  </section>

  <!-- NOTIFICATIONS -->
  <section id="v-notifications" class="view hidden">
    <div class="st flex items-end justify-between gap-4"><h2 class="ptitle">Notifications</h2><button id="markAll" class="text-sm font-semibold text-blue-600 hover:text-blue-700" type="button">Mark all as read</button></div>
    <ul id="notifList" class="mt-5 space-y-3"></ul>
  </section>

  <!-- ACCOUNT -->
  <section id="v-account" class="view hidden">
    <h2 class="st ptitle">My Account</h2>
    <form id="profileForm" class="st card mt-5 space-y-4">
      <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <label class="lab">Full name<input class="inp" value="Grace Nakato"></label>
        <label class="lab">Phone<input class="inp" value="+256 772 000 000"></label>
        <label class="lab">Email<input type="email" class="inp" value="grace@example.com"></label>
        <label class="lab">Main goal<select class="inp"><option>Lose weight</option><option>Build muscle</option><option>Get stronger</option><option>Improve fitness</option></select></label>
        <label class="lab">Emergency contact<input class="inp" value="Peter Nakato"></label>
        <label class="lab">Emergency phone<input class="inp" value="+256 700 111 222"></label>
      </div>
      <label class="lab">Health notes<textarea rows="2" class="inp">Mild knee strain, avoid heavy jumping.</textarea></label>
      <button class="px-7 py-3 rounded-full bg-blue-600 text-white font-semibold text-[14px] hover:bg-blue-700 transition-colors" type="submit">Save Changes</button>
    </form>
    <div class="st card mt-5">
      <h3 class="font-extrabold text-slate-900">Membership settings</h3>
      <p class="text-sm text-slate-500 mt-1">Going away or need a break? You can pause or cancel anytime.</p>
      <div class="flex flex-wrap gap-3 mt-4">
        <button id="freezeBtn" class="px-6 py-2.5 rounded-full border border-slate-300 font-semibold text-[14px] hover:border-blue-400 hover:text-blue-600 transition-colors" type="button">Freeze Membership</button>
        <button id="cancelBtn" class="px-6 py-2.5 rounded-full border border-red-200 text-red-600 font-semibold text-[14px] hover:bg-red-50 transition-colors" type="button">Cancel Membership</button>
      </div>
    </div>
  </section>

  </div>
</div>
</div>
</main>

<div id="toast" class="fixed bottom-6 left-1/2 -translate-x-1/2 z-[60] bg-slate-900 text-white text-sm font-medium px-5 py-3 rounded-full shadow-lg opacity-0 pointer-events-none transition-opacity duration-300"></div>

<script>
const searchToggleBtn = document.getElementById('searchToggleBtn');
  const floatingSearch = document.getElementById('floatingSearch');
  searchToggleBtn.addEventListener('click', (e) => {
    e.stopPropagation();
    floatingSearch.classList.toggle('hidden');
    if (!floatingSearch.classList.contains('hidden')) floatingSearch.querySelector('input').focus();
  });
  window.addEventListener('click', (e) => {
    if (!floatingSearch.contains(e.target) && e.target !== searchToggleBtn && !searchToggleBtn.contains(e.target)) floatingSearch.classList.add('hidden');
  });
  const menuToggleBtn = document.getElementById('menuToggleBtn');
  const mobileDrawer = document.getElementById('mobileDrawer');
  const mobileDrawerBackdrop = document.getElementById('mobileDrawerBackdrop');
  const closeDrawerBtn = document.getElementById('closeDrawerBtn');
  function openDrawer() { mobileDrawer.classList.remove('-translate-x-full'); mobileDrawerBackdrop.classList.remove('hidden'); document.body.style.overflow = 'hidden'; }
  function closeDrawer() { mobileDrawer.classList.add('-translate-x-full'); mobileDrawerBackdrop.classList.add('hidden'); document.body.style.overflow = ''; }
  menuToggleBtn.addEventListener('click', openDrawer);
  closeDrawerBtn.addEventListener('click', closeDrawer);
  mobileDrawerBackdrop.addEventListener('click', closeDrawer);


  // ================= Helpers =================
  const $ = id => document.getElementById(id);
  const fmtUGX = n => 'UGX ' + n.toLocaleString('en-US');
  const addDays = (d, n) => { const x = new Date(d); x.setDate(x.getDate() + n); return x; };
  const iso = d => d.toISOString().split('T')[0];
  const nice = d => d.toLocaleDateString('en-GB', { day: 'numeric', month: 'short', year: 'numeric' });
  const short = d => d.toLocaleDateString('en-GB', { weekday: 'short', day: 'numeric', month: 'short' });
  const today = new Date(); today.setHours(0, 0, 0, 0);
  const reduce = matchMedia('(prefers-reduced-motion: reduce)').matches;
  let toastT;
  function toast(msg) { const t = $('toast'); t.textContent = msg; t.style.opacity = 1; clearTimeout(toastT); toastT = setTimeout(() => t.style.opacity = 0, 2600); }

  function countUp(el, to, from = 0, dur = 1000) {
    if (reduce || from === to) { el.textContent = to.toLocaleString('en-US'); return; }
    const t0 = performance.now();
    (function f(t) {
      const p = Math.min((t - t0) / dur, 1), e = 1 - Math.pow(1 - p, 3);
      el.textContent = Math.round(from + (to - from) * e).toLocaleString('en-US');
      if (p < 1) requestAnimationFrame(f);
    })(t0);
  }
  function burst(x, y) {
    if (reduce) return;
    const colors = ['#2563eb', '#38bdf8', '#fbbf24', '#34d399', '#f472b6'];
    for (let i = 0; i < 26; i++) {
      const s = document.createElement('span');
      s.style.cssText = 'position:fixed;z-index:70;pointer-events:none;width:8px;height:8px;border-radius:2px;left:' + x + 'px;top:' + y + 'px;background:' + colors[i % 5];
      document.body.appendChild(s);
      const a = Math.random() * Math.PI * 2, d = 60 + Math.random() * 110;
      s.animate([{ transform: 'translate(0,0) rotate(0) scale(1)', opacity: 1 }, { transform: 'translate(' + Math.cos(a) * d + 'px,' + (Math.sin(a) * d + 60) + 'px) rotate(' + Math.random() * 720 + 'deg) scale(.4)', opacity: 0 }], { duration: 900 + Math.random() * 400, easing: 'cubic-bezier(.2,.7,.3,1)' }).onfinish = () => s.remove();
    }
  }
  const rise = (el, i) => { el.classList.add('rise'); el.style.animationDelay = (i * 60) + 'ms'; };

  // ================= Screens =================
  function enter(sec) {
    sec.classList.remove('enter'); void sec.offsetWidth;
    sec.querySelectorAll('.st').forEach((el, i) => el.style.setProperty('--i', i));
    sec.classList.add('enter');
    sec.querySelectorAll('[data-count]').forEach(el => countUp(el, +el.dataset.count));
    sec.querySelectorAll('[data-w]').forEach(el => { el.style.width = '0'; requestAnimationFrame(() => requestAnimationFrame(() => el.style.width = el.dataset.w)); });
    sec.querySelectorAll('[data-h]').forEach(el => { el.style.height = '0'; requestAnimationFrame(() => requestAnimationFrame(() => el.style.height = el.dataset.h)); });
  }
  function show(view) {
    document.querySelectorAll('.view').forEach(v => v.classList.toggle('hidden', v.id !== 'v-' + view));
    document.querySelectorAll('.pnav[data-view]').forEach(b => b.classList.toggle('active', b.dataset.view === view));
    enter($('v-' + view));
    if (view === 'classes') renderClasses();
    if (view === 'points') renderRewards();
    if (view === 'history') renderHistory();
    if (view === 'notifications') renderNotifs();
    if (view === 'trainer') $('chatBox').scrollTop = $('chatBox').scrollHeight;
    if (window.innerWidth < 1024) $('pnav').querySelector('.active')?.scrollIntoView({ inline: 'center', block: 'nearest', behavior: 'smooth' });
    else window.scrollTo({ top: 0, behavior: reduce ? 'auto' : 'smooth' });
  }
  document.querySelectorAll('.pnav[data-view]').forEach(b => b.addEventListener('click', () => show(b.dataset.view)));
  document.querySelectorAll('[data-go]').forEach(b => b.addEventListener('click', () => show(b.dataset.go)));

  // ================= Dashboard =================
  const hr = new Date().getHours();
  $('greet').textContent = (hr < 12 ? 'Good morning' : hr < 17 ? 'Good afternoon' : 'Good evening') + ', Grace';
  const MEMS = [
    { ic: 'fa-dumbbell', c: 'bg-sky-100 text-sky-600', n: 'Gym Membership', sub: 'Pro · 1 month', amt: 300000, start: -8, left: 22, total: 30 },
    { ic: 'fa-user-check', c: 'bg-indigo-100 text-indigo-600', n: 'Personal Training Pack', sub: '4 sessions', amt: 240000, start: -20, left: 40, total: 60 },
    { ic: 'fa-apple-whole', c: 'bg-emerald-100 text-emerald-600', n: 'Nutrition Coaching', sub: '3 months', amt: 180000, start: -30, left: 61, total: 90 }
  ];
  function renderMems() {
    $('memList').innerHTML = '';
    MEMS.forEach((m, i) => {
      const warn = m.left <= 7, r = document.createElement('div');
      r.className = 'mrow st';
      r.innerHTML = '<div class="mlogo ' + m.c + '"><i class="fa-solid ' + m.ic + '"></i></div><div class="mcols">' +
        '<div><span class="k">Service</span><span class="v">' + m.n + '</span></div>' +
        '<div><span class="k">Subscription</span><span class="v">' + m.sub + '</span></div>' +
        '<div><span class="k">Amount Paid</span><span class="v">' + fmtUGX(m.amt) + '</span></div>' +
        '<div><span class="k">Subscription Date</span><span class="v">' + nice(addDays(today, m.start)) + '</span></div>' +
        '<div><span class="k">Days Left</span><span class="v ' + (warn ? '!text-orange-600 !font-bold' : '') + '">' + m.left + ' Days</span><div class="dbar"><i style="width:' + Math.min(100, m.left / m.total * 100) + '%;background:' + (warn ? '#f97316' : 'var(--accent)') + '"></i></div><button class="renew" data-i="' + i + '" type="button">Renew</button></div></div>';
      $('memList').appendChild(r);
    });
    document.querySelectorAll('.renew').forEach(b => b.addEventListener('click', () => {
      const m = MEMS[+b.dataset.i]; m.left += m.total; renderMems(); toast('Renewal request sent for ' + m.n + '.');
    }));
  }
  renderMems();

  // ---- Upcoming sessions ----
  const TEMPLATE = [
    { t: '6:30 AM', n: 'Morning HIIT', c: 'Coach Brian' }, { t: '12:30 PM', n: 'Strength Circuit', c: 'Coach Sarah' },
    { t: '5:30 PM', n: 'Body Pump', c: 'Coach Moses' }, { t: '7:00 PM', n: 'Boxing Cardio', c: 'Coach Brian' }];
  const SPOTS = [[8, 5, 2, 9], [6, 0, 7, 4], [3, 8, 0, 6], [9, 2, 5, 7], [4, 6, 8, 0], [7, 3, 1, 10]];
  const booked = new Map();
  const bookKey = (d, i) => iso(d) + '-' + i;
  [[1, 0], [2, 3]].forEach(([a, i]) => { const d = addDays(today, a); if (d.getDay() !== 0) booked.set(bookKey(d, i), { date: d, ...TEMPLATE[i] }); });
  let pt = { date: addDays(today, 3), t: '5:00 PM', n: 'Personal Training', c: 'Coach Brian' };
  function renderUpcoming() {
    const items = [...booked.entries()].map(([k, v]) => ({ k, ...v }));
    if (pt) items.push({ k: 'pt', ...pt });
    items.sort((a, b) => a.date - b.date);
    const sb = $('statBooked'); sb.dataset.count = booked.size; sb.textContent = booked.size;
    $('upcoming').innerHTML = items.length ? '' : '<li class="py-6 text-sm text-slate-500 text-center">No upcoming sessions. Book a class to get started.</li>';
    items.forEach(it => {
      const li = document.createElement('li');
      li.className = 'py-3 flex items-center justify-between gap-3';
      li.innerHTML = '<div class="flex items-center gap-3 min-w-0"><span class="w-10 h-10 shrink-0 rounded-xl bg-sky-50 text-sky-600 flex items-center justify-center"><i class="fa-solid ' + (it.k === 'pt' ? 'fa-dumbbell' : 'fa-people-group') + '"></i></span><div class="min-w-0"><p class="text-sm font-bold text-slate-900 truncate">' + it.n + '</p><p class="text-xs text-slate-500">' + short(it.date) + ' · ' + it.t + ' · ' + it.c + '</p></div></div>';
      const x = document.createElement('button');
      x.type = 'button'; x.className = 'shrink-0 text-xs font-semibold text-slate-400 hover:text-red-600 transition-colors'; x.textContent = 'Cancel';
      x.addEventListener('click', () => { if (it.k === 'pt') pt = null; else booked.delete(it.k); renderUpcoming(); renderClasses(); toast('Session cancelled.'); });
      li.appendChild(x); $('upcoming').appendChild(li);
    });
    $('trNext').textContent = pt ? short(pt.date) + ' · ' + pt.t + ' · ' + pt.n : 'No session booked. Message Coach Brian to schedule one.';
  }

  // ================= Trainer =================
  $('trSince').textContent = nice(addDays(today, -42)).replace(/ \d{4}$/, '');
  const chat = [{ me: false, t: 'Hi Grace! Great job on your last session. Ready for legs on Thursday?', time: '09:12' }];
  const clock = () => new Date().toLocaleTimeString('en-GB', { hour: '2-digit', minute: '2-digit' });
  function bubble(m, i = 0) {
    const d = document.createElement('div');
    d.className = 'bub ' + (m.me ? 'me' : 'them'); rise(d, i);
    d.innerHTML = m.t.replace(/</g, '&lt;') + '<span>' + m.time + '</span>';
    $('chatBox').appendChild(d);
    $('chatBox').scrollTop = $('chatBox').scrollHeight;
  }
  chat.forEach(m => bubble(m));
  const REPLIES = ['Great! Keep your form tight and breathe through each rep.', 'Sure, I will adjust your plan for this week.', 'Remember to drink plenty of water and sleep 7 to 8 hours.', 'Sounds good. See you at your next session!'];
  let rIdx = 0;
  $('chatForm').addEventListener('submit', e => {
    e.preventDefault();
    const v = $('chatInput').value.trim(); if (!v) return;
    bubble({ me: true, t: v, time: clock() }); $('chatInput').value = '';
    const tp = document.createElement('div'); tp.className = 'bub them typing rise'; tp.innerHTML = '<i></i><i></i><i></i>';
    $('chatBox').appendChild(tp); $('chatBox').scrollTop = $('chatBox').scrollHeight;
    setTimeout(() => { tp.remove(); bubble({ me: false, t: REPLIES[rIdx++ % REPLIES.length], time: clock() }); }, 1500);
  });
  $('msgBtn').addEventListener('click', () => { $('chatCard').scrollIntoView({ behavior: reduce ? 'auto' : 'smooth', block: 'center' }); $('chatInput').focus({ preventScroll: true }); });
  $('changeTrainer').addEventListener('click', () => toast('Request sent. The front desk will contact you.'));

  // ================= Classes =================
  let selDay = addDays(today, 0); if (selDay.getDay() === 0) selDay = addDays(selDay, 1);
  function renderDays() {
    $('days').innerHTML = '';
    for (let i = 0; i < 7; i++) {
      const d = addDays(today, i), on = iso(d) === iso(selDay), b = document.createElement('button');
      b.type = 'button';
      b.className = 'shrink-0 px-4 py-2.5 rounded-2xl border text-center transition-all ' + (on ? 'text-white scale-105 shadow-md' : 'bg-white border-slate-200 text-slate-700 hover:border-blue-300');
      if (on) b.style.cssText = 'background:var(--accent);border-color:var(--accent)';
      b.innerHTML = '<span class="block text-[11px] font-semibold ' + (on ? 'text-blue-100' : 'text-slate-400') + '">' + d.toLocaleDateString('en-GB', { weekday: 'short' }) + '</span><span class="block text-base font-extrabold">' + d.getDate() + '</span>';
      b.addEventListener('click', () => { selDay = d; renderDays(); renderClasses(); });
      $('days').appendChild(b);
    }
  }
  function renderClasses() {
    renderDays();
    const list = $('classList');
    if (selDay.getDay() === 0) { list.innerHTML = '<div class="card text-center text-slate-500 text-sm py-10 rise"><i class="fa-regular fa-moon text-3xl text-slate-300"></i><p class="mt-3 font-semibold text-slate-700">Rest day</p><p>The gym is closed on Sundays.</p></div>'; return; }
    list.innerHTML = '';
    TEMPLATE.forEach((c, i) => {
      const k = bookKey(selDay, i), isB = booked.has(k), spots = SPOTS[(selDay.getDay() + 5) % 6][i], full = spots === 0 && !isB;
      const row = document.createElement('div'); row.className = 'card flex items-center justify-between gap-4 !p-4'; rise(row, i);
      row.innerHTML = '<div class="flex items-center gap-4 min-w-0"><div class="w-20 shrink-0 text-center"><p class="text-sm font-extrabold text-slate-900">' + c.t + '</p><p class="text-[11px] text-slate-400">60 min</p></div><div class="min-w-0"><p class="font-bold text-slate-900">' + c.n + '</p><p class="text-xs text-slate-500">' + c.c + ' · ' + (full ? '<span class="text-red-500 font-semibold">Full</span>' : spots + ' spots left') + '</p></div></div>';
      const btn = document.createElement('button'); btn.type = 'button'; btn.disabled = full;
      btn.className = 'shrink-0 px-5 py-2 rounded-full text-[13px] font-semibold transition-all ' + (isB ? 'bg-green-50 text-green-700 border border-green-200 hover:bg-red-50 hover:text-red-600 hover:border-red-200' : full ? 'bg-slate-100 text-slate-400 cursor-not-allowed' : 'bg-blue-600 text-white hover:bg-blue-700 active:scale-95');
      btn.textContent = isB ? 'Booked ✓' : full ? 'Full' : 'Book';
      btn.addEventListener('click', e => {
        if (isB) { booked.delete(k); toast('Booking cancelled.'); }
        else { booked.set(k, { date: selDay, ...c }); toast('Booked: ' + c.n + ', ' + c.t); burst(e.clientX, e.clientY); }
        renderClasses(); renderUpcoming();
      });
      row.appendChild(btn); list.appendChild(row);
    });
  }

  // ================= Plan =================
  const WEEK = [['Mon', 'Chest & Triceps', 'Bench press, incline dumbbell press, dips'], ['Tue', 'Back & Biceps', 'Rows, lat pulldown, curls'], ['Wed', 'Cardio & Core', '30 min steady cardio, planks'], ['Thu', 'Legs', 'Squats, lunges, leg press'], ['Fri', 'Shoulders & Arms', 'Overhead press, lateral raises'], ['Sat', 'Full Body HIIT', 'Group class or circuit'], ['Sun', 'Rest', 'Light walk and stretching']];
  const ta = today.toLocaleDateString('en-GB', { weekday: 'short' });
  $('week').innerHTML = WEEK.map(w => { const on = w[0] === ta; return '<li class="py-3 flex items-center gap-4 ' + (on ? 'bg-blue-50/70 -mx-3 px-3 rounded-xl' : '') + '"><span class="w-10 text-xs font-extrabold ' + (on ? 'text-blue-600' : 'text-slate-400') + '">' + w[0].toUpperCase() + '</span><div><p class="font-bold text-slate-900">' + w[1] + (on ? ' <span class="text-[10px] bg-blue-600 text-white rounded-full px-2 py-0.5 ml-1 align-middle">TODAY</span>' : '') + '</p><p class="text-xs text-slate-500">' + w[2] + '</p></div></li>'; }).join('');
  const WT = [82.0, 81.2, 80.5, 79.9, 79.1, 78.6];
  $('weightChart').innerHTML = WT.map((w, i) => '<div class="flex-1 flex flex-col items-center justify-end h-full gap-1.5"><span class="text-[11px] font-bold text-slate-700">' + w + '</span><div class="w-full rounded-t-lg bg-gradient-to-t from-blue-600 to-sky-400 bar-h" data-h="' + ((w - 74) / 10 * 100) + '%" style="transition-delay:' + (i * 90) + 'ms"></div><span class="text-[10px] text-slate-400">W' + (i + 1) + '</span></div>').join('');
  $('pbs').innerHTML = [['Bench press', '70 kg', 70], ['Squat', '100 kg', 83], ['Deadlift', '120 kg', 100], ['5 km run', '28:40', 60]].map(p => '<div><div class="flex justify-between"><span class="text-slate-500">' + p[0] + '</span><b class="text-slate-900">' + p[1] + '</b></div><div class="dbar !mt-1.5"><i class="bar" data-w="' + p[2] + '%" style="background:var(--accent)"></i></div></div>').join('');

  // ================= History =================
  let hTab = 'pay';
  const PAY = [[1, 'Gym Membership, Pro 1 month', 'MTN Mobile Money', 300000], [2, 'Gym Membership, Pro 1 month', 'MTN Mobile Money', 300000], [3, 'Personal Training Pack', 'Pay at the gym', 240000], [4, 'Nutrition Coaching, 3 months', 'Airtel Money', 180000]];
  const ORDERS = [['ORD-1058', 'Omega-3 Triple Strength + BCAA 2:1:1', 170000, 'On the way', 'bg-amber-50 text-amber-700', 5], ['ORD-1042', 'Apex Platinum Whey Isolate (2kg)', 185000, 'Delivered', 'bg-green-50 text-green-700', 24], ['ORD-1031', 'Pure Creatine Monohydrate (300g)', 115000, 'Delivered', 'bg-green-50 text-green-700', 51]];
  const VISITS = [[1, '6:40 AM', 72], [3, '5:55 PM', 85], [4, '6:35 AM', 64], [6, '6:50 AM', 70], [8, '6:30 PM', 90], [10, '6:42 AM', 66], [11, '5:50 PM', 78]];
  function renderHistory() {
    document.querySelectorAll('.htab').forEach(b => b.classList.toggle('on', b.dataset.t === hTab));
    const body = $('hBody'); let rows = [];
    if (hTab === 'pay') rows = PAY.map(p => '<div class="hrow"><div><p class="font-bold text-slate-900">' + p[1] + '</p><p class="text-xs text-slate-500">' + nice(addDays(today, -30 * p[0] + 22)) + ' · ' + p[2] + '</p></div><div class="text-right"><p class="font-bold text-slate-900">' + fmtUGX(p[3]) + '</p><button class="rcpt text-xs font-semibold text-blue-600 hover:text-blue-700" type="button">Receipt</button></div></div>');
    if (hTab === 'orders') rows = ORDERS.map(o => '<div class="hrow"><div><p class="text-xs text-slate-400">' + o[0] + ' · ' + nice(addDays(today, -o[5])) + '</p><p class="font-bold text-slate-900">' + o[1] + '</p><p class="text-xs text-slate-500">' + fmtUGX(o[2]) + '</p></div><div class="text-right space-y-2"><span class="inline-block text-[11px] font-extrabold rounded-full px-3 py-1 ' + o[4] + '">' + o[3].toUpperCase() + '</span><br><a href="supplements.html" class="text-xs font-semibold text-blue-600 hover:text-blue-700">Reorder</a></div></div>');
    if (hTab === 'visits') rows = VISITS.map(v => '<div class="hrow"><div><p class="font-bold text-slate-900">' + short(addDays(today, -v[0])) + '</p><p class="text-xs text-slate-500">Checked in at ' + v[1] + '</p></div><div class="text-right"><p class="font-bold text-slate-900">' + v[2] + ' min</p><p class="text-xs text-slate-400">+10 pts</p></div></div>');
    body.innerHTML = rows.join('');
    [...body.children].forEach((r, i) => rise(r, i));
    body.querySelectorAll('.rcpt').forEach(b => b.addEventListener('click', () => toast('Receipt will be sent to your email.')));
  }
  document.querySelectorAll('.htab').forEach(b => b.addEventListener('click', () => { hTab = b.dataset.t; renderHistory(); }));

  // ================= Points =================
  let points = 1250;
  const REWARDS = [['Free Personal Training Session', 1000, 'fa-dumbbell'], ['10% Off Supplements Coupon', 500, 'fa-tag'], ['ApexFit Shaker Bottle', 800, 'fa-bottle-water'], ['Guest Day Pass', 300, 'fa-user-plus'], ['Protein Bar Box', 600, 'fa-cookie-bite'], ['1 Week Membership Extension', 1500, 'fa-calendar-plus']];
  function setPoints(newP) {
    const from = points; points = newP;
    document.querySelectorAll('.ptsLive').forEach(el => { el.dataset.count = points; countUp(el, points, from, 800); });
  }
  function renderRewards() {
    const g = $('rewardGrid'); g.innerHTML = '';
    REWARDS.forEach((r, i) => {
      const ok = points >= r[1], c = document.createElement('div');
      c.className = 'card flex items-center gap-4 !p-4 hover:-translate-y-0.5 transition-transform'; rise(c, i);
      c.innerHTML = '<span class="w-12 h-12 shrink-0 rounded-2xl ' + (ok ? 'bg-amber-50 text-amber-500' : 'bg-slate-100 text-slate-400') + ' flex items-center justify-center text-lg"><i class="fa-solid ' + r[2] + '"></i></span><div class="min-w-0 flex-1"><p class="font-bold text-slate-900 text-sm leading-snug">' + r[0] + '</p><p class="text-xs text-slate-500 mt-0.5"><i class="fa-solid fa-coins text-amber-400"></i> ' + r[1].toLocaleString() + ' pts</p></div>';
      const b = document.createElement('button'); b.type = 'button';
      b.className = 'shrink-0 px-4 py-2 rounded-full text-[12px] font-semibold transition-all ' + (ok ? 'bg-blue-600 text-white hover:bg-blue-700 active:scale-95' : 'bg-slate-100 text-slate-400');
      b.innerHTML = ok ? 'Redeem' : '<i class="fa-solid fa-lock mr-1"></i>' + (r[1] - points) + ' more';
      b.addEventListener('click', e => {
        if (!ok) { b.animate([{ transform: 'translateX(0)' }, { transform: 'translateX(-6px)' }, { transform: 'translateX(6px)' }, { transform: 'translateX(-4px)' }, { transform: 'translateX(0)' }], { duration: 350 }); toast('You need ' + (r[1] - points) + ' more points.'); return; }
        setPoints(points - r[1]); burst(e.clientX, e.clientY); toast('Redeemed: ' + r[0]);
        const li = document.createElement('li'); li.className = 'flex justify-between rise'; li.innerHTML = '<span><i class="fa-solid fa-check text-green-500 mr-2"></i>' + r[0] + '</span><b class="text-slate-900">-' + r[1] + '</b>';
        const rl = $('redeemedList'); if (rl.children[0] && rl.children[0].classList.contains('text-slate-400')) rl.innerHTML = ''; rl.prepend(li);
        renderRewards();
      });
      c.appendChild(b); g.appendChild(c);
    });
    const next = REWARDS.map(r => r[1]).filter(c => c > points).sort((a, b) => a - b)[0];
    const bar = $('pointsBar');
    if (next) { $('pointsNext').textContent = (next - points) + ' points to your next reward (' + next.toLocaleString() + ')'; bar.dataset.w = (points / next * 100) + '%'; }
    else { $('pointsNext').textContent = 'You can afford every reward!'; bar.dataset.w = '100%'; }
    requestAnimationFrame(() => requestAnimationFrame(() => bar.style.width = bar.dataset.w));
  }

  // ================= Notifications =================
  const NOTIFS = [
    { ic: 'fa-user-tie', t: 'Coach Brian sent you a message', d: 'Ready for legs on Thursday?', ago: '2 hours ago', un: true },
    { ic: 'fa-triangle-exclamation', t: 'Gym membership renews soon', d: 'Renew before it expires to keep your plan.', ago: 'Yesterday', un: true },
    { ic: 'fa-bullhorn', t: 'New Boxing Cardio class', d: 'Starts this week, evenings at 7:00 PM.', ago: '2 days ago', un: true },
    { ic: 'fa-bag-shopping', t: 'Your order is on the way', d: 'ORD-1058 will arrive within 2 days.', ago: '5 days ago', un: false },
    { ic: 'fa-coins', t: 'You earned 100 points', d: 'Thanks for your supplement order.', ago: '5 days ago', un: false }];
  function badge() { const n = NOTIFS.filter(x => x.un).length, b = $('nBadge'); b.textContent = n; b.style.display = n ? 'inline-flex' : 'none'; }
  function renderNotifs() {
    $('notifList').innerHTML = '';
    NOTIFS.forEach((n, i) => {
      const li = document.createElement('li'); li.className = 'card flex items-start gap-4 !p-4 cursor-pointer hover:-translate-y-0.5 transition-all' + (n.un ? ' !border-blue-200 !bg-blue-50/40' : ''); rise(li, i);
      li.innerHTML = '<span class="w-10 h-10 shrink-0 rounded-xl bg-sky-50 text-sky-600 flex items-center justify-center"><i class="fa-solid ' + n.ic + '"></i></span><div class="flex-1 min-w-0"><p class="font-bold text-slate-900 text-sm">' + n.t + '</p><p class="text-sm text-slate-500">' + n.d + '</p><p class="text-xs text-slate-400 mt-1">' + n.ago + '</p></div>' + (n.un ? '<span class="w-2.5 h-2.5 mt-1.5 rounded-full bg-blue-600 pulse"></span>' : '');
      li.addEventListener('click', () => { if (n.un) { n.un = false; badge(); renderNotifs(); } });
      $('notifList').appendChild(li);
    });
  }
  $('markAll').addEventListener('click', () => { NOTIFS.forEach(n => n.un = false); badge(); renderNotifs(); toast('All notifications marked as read.'); });

  // ================= Account =================
  $('profileForm').addEventListener('submit', e => { e.preventDefault(); toast('Profile saved.'); });
  $('freezeBtn').addEventListener('click', () => { if (confirm('Freeze your membership? Your expiry date will move forward while frozen.')) toast('Freeze request sent to the front desk.'); });
  $('cancelBtn').addEventListener('click', () => { if (confirm('Cancel your membership? This takes effect when your current period ends.')) toast('Cancellation request sent.'); });
  $('logoutBtn').addEventListener('click', () => { if (confirm('Log out of your portal?')) location.href = 'index.php'; });

  // ================= Init =================
  renderUpcoming(); badge(); show('dashboard');
</script>
</body>
</html>