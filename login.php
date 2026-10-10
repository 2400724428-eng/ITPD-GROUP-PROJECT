<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/includes/db_connect.php';

// If user is already logged in, redirect directly to dashboard
if (isset($_SESSION['user_id'])) {
    header('Location: users/dashboard.php');
    exit;
}

// ---------------------------------------------------------
// AJAX Form Processor
// ---------------------------------------------------------
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ajax_action'])) {
    header('Content-Type: application/json');
    $action = $_POST['ajax_action'];

    if ($action === 'login') {
        $email = filter_var(trim($_POST['email'] ?? ''), FILTER_VALIDATE_EMAIL);
        $password = $_POST['password'] ?? '';

        if (!$email || !$password) {
            echo json_encode(['success' => false, 'message' => 'Please fill in all required fields.']);
            exit;
        }

        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password_hash'])) {
            $_SESSION['user_id']       = $user['id'];
            $_SESSION['full_name']     = $user['full_name'];
            $_SESSION['email']         = $user['email'];
            $_SESSION['profile_photo'] = $user['profile_photo'];

            echo json_encode(['success' => true, 'message' => 'Signed in successfully']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Invalid email address or password.']);
        }
        exit;
    }

    if ($action === 'register') {
        $fullName = trim($_POST['full_name'] ?? '');
        $email    = filter_var(trim($_POST['email'] ?? ''), FILTER_VALIDATE_EMAIL);
        $password = $_POST['password'] ?? '';

        if (!$fullName || !$email || strlen($password) < 8) {
            echo json_encode(['success' => false, 'message' => 'Please provide valid registration details.']);
            exit;
        }

        // Check if email exists
        $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->fetch()) {
            echo json_encode(['success' => false, 'message' => 'An account with this email address already exists.']);
            exit;
        }

        $passwordHash = password_hash($password, PASSWORD_BCRYPT);
        $defaultPhoto = 'uploads/avatars/default-avatar.png';

        $insert = $pdo->prepare("INSERT INTO users (full_name, email, password_hash, profile_photo) VALUES (?, ?, ?, ?)");
        if ($insert->execute([$fullName, $email, $passwordHash, $defaultPhoto])) {
            $userId = $pdo->lastInsertId();
            $_SESSION['user_id']       = $userId;
            $_SESSION['full_name']     = $fullName;
            $_SESSION['email']         = $email;
            $_SESSION['profile_photo'] = $defaultPhoto;

            echo json_encode(['success' => true, 'message' => 'Account created successfully']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to create account. Please try again.']);
        }
        exit;
    }

    echo json_encode(['success' => false, 'message' => 'Invalid action.']);
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>Sign in | PURE GAIN</title>

<link href="./src/output.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet"/>
<link href="https://fonts.googleapis.com" rel="preconnect"/>
<link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect"/>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet"/>

<script>
tailwind.config = {
  theme: {
    extend: {
      fontFamily: {
        sans: ['"Plus Jakarta Sans"', 'sans-serif']
      }
    }
  }
}
</script>

<style>
  * {
    box-sizing: border-box;
  }

  @keyframes blob {
    0%,100% { transform: translate(0,0) scale(1); }
    50% { transform: translate(50px,-40px) scale(1.2); }
  }

  @keyframes floaty {
    0%,100% { transform: translateY(0); }
    50% { transform: translateY(-12px); }
  }

  .kenburns { animation: none; }
  .blob { animation: blob 14s ease-in-out infinite; }
  .blob-2 { animation-delay: -6s; animation-duration: 18s; }
  .floaty { animation: floaty 6s ease-in-out infinite; }
  .floaty:nth-child(2) { animation-delay: -2s; }
  .floaty:nth-child(3) { animation-delay: -4s; }

  .form-panel {
    grid-area: 1 / 1;
    transition: opacity .45s ease, transform .55s cubic-bezier(.22,1,.36,1), visibility .45s;
  }

  .form-panel[data-state="out-left"] {
    opacity: 0;
    transform: translateX(-36px);
    visibility: hidden;
    pointer-events: none;
  }

  .form-panel[data-state="out-right"] {
    opacity: 0;
    transform: translateX(36px);
    visibility: hidden;
    pointer-events: none;
  }

  @keyframes rise {
    from { opacity: 0; transform: translateY(16px); }
    to { opacity: 1; transform: none; }
  }

  .form-panel[data-state="active"] .rise {
    animation: rise .65s cubic-bezier(.22,1,.36,1) both;
    animation-delay: calc(var(--i, 0) * 70ms + 120ms);
  }

  .hero-swap {
    transition: opacity .3s ease, transform .3s ease;
  }

  .hero-swap.out {
    opacity: 0;
    transform: translateY(10px);
  }

  @keyframes shake {
    0%,100% { transform: translateX(0); }
    20%,60% { transform: translateX(-6px); }
    40%,80% { transform: translateX(6px); }
  }

  .shake { animation: shake .4s ease; }

  .btn-shine {
    position: relative;
    overflow: hidden;
  }

  .btn-shine::after {
    content: "";
    position: absolute;
    top: 0;
    left: -75%;
    width: 50%;
    height: 100%;
    background: linear-gradient(120deg, transparent, rgba(255,255,255,.35), transparent);
    transform: skewX(-20deg);
    transition: left .7s ease;
  }

  .btn-shine:hover::after { left: 130%; }

  @keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
  }

  body {
    animation: fadeIn .6s ease both;
    overflow: hidden;
  }

  .auth-layout { height: 100vh; min-height: 100vh; overflow: hidden; }
  .left-hero { height: 100vh; min-height: 100vh; overflow: hidden; position: relative; }

  .auth-scroll {
    height: 100vh;
    min-height: 100vh;
    overflow-y: auto;
    overflow-x: hidden;
    overscroll-behavior: contain;
    scrollbar-width: thin;
    scrollbar-color: #cbd5e1 transparent;
  }

  .auth-scroll::-webkit-scrollbar { width: 7px; }
  .auth-scroll::-webkit-scrollbar-track { background: transparent; }
  .auth-scroll::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 999px; }
  .auth-scroll::-webkit-scrollbar-thumb:hover { background: #94a3b8; }

  @media (max-width: 1023px) {
    body { overflow: auto; }
    .auth-layout, .auth-scroll { height: auto; min-height: 100vh; }
    .auth-scroll { overflow-y: visible; }
  }

  html, body { width: 100%; max-width: 100%; overflow-x: hidden; }

  @media (max-width: 1023px) {
    .auth-layout { display: block !important; width: 100%; min-height: 100svh; height: auto; overflow: visible; }
    .auth-scroll {
      width: 100%;
      min-height: 100svh;
      height: auto;
      padding: 1.5rem 1rem 2.5rem !important;
      overflow: visible;
      display: flex;
      align-items: flex-start;
      justify-content: center;
    }
    .auth-scroll > .relative { width: 100%; max-width: 440px; }
    .auth-scroll .blob { max-width: 18rem; max-height: 18rem; }
    .auth-scroll img { height: 3.25rem !important; max-width: 190px !important; }
    .auth-scroll > .relative > .flex.items-center.justify-center.mb-8 { margin-bottom: 1.25rem !important; }
    .tab-btn { min-height: 44px; padding-top: .65rem !important; padding-bottom: .65rem !important; }
    .form-panel { width: 100%; min-width: 0; }
    .form-panel .rise { max-width: 100%; }
    .inp { max-width: 100%; min-width: 0; font-size: 16px; }
    .form-panel h1, .form-panel p, .form-panel label { overflow-wrap: anywhere; }
    .submit-btn, .btn-shine { min-height: 48px; }
    .form-panel button { max-width: 100%; }
  }

  @media (max-width: 480px) {
    .auth-scroll { padding: 1rem .75rem 2rem !important; }
    .auth-scroll > .relative { max-width: 100%; }
    .auth-scroll img { height: 2.9rem !important; max-width: 165px !important; }
    .auth-scroll > .relative > .flex.items-center.justify-center.mb-8 { margin-bottom: 1rem !important; }
    .auth-scroll .grid.grid-cols-2 { margin-bottom: 1.25rem !important; border-radius: .9rem; }
    .tab-btn { font-size: .8rem !important; min-height: 42px; }
    .form-panel h1 { font-size: 1.35rem !important; line-height: 1.25; }
    .form-panel .text-sm { font-size: .82rem; }
    .form-panel .rise.mb-6 { margin-bottom: 1.1rem !important; }
    .form-panel form { gap: .8rem; }
    .inp { height: 3rem; padding-left: 2.75rem; }
    .ico { left: .9rem; }
    .form-panel [data-toggle] { width: 40px !important; height: 40px !important; right: .35rem !important; }
    .left-hero .px-14 { padding-left: 1.25rem !important; padding-right: 1.25rem !important; }
  }

  @media (max-width: 360px) {
    .auth-scroll { padding-left: .65rem !important; padding-right: .65rem !important; }
    .auth-scroll img { height: 2.65rem !important; max-width: 150px !important; }
    .tab-btn { font-size: .75rem !important; }
    .form-panel h1 { font-size: 1.25rem !important; }
    .form-panel .text-\[13px\] { font-size: .78rem !important; }
    .form-panel .text-xs { font-size: .7rem !important; }
  }

  @media (max-width: 1023px) {
    .auth-scroll, .auth-scroll * { -webkit-tap-highlight-color: transparent; }
    .auth-scroll input, .auth-scroll button, .auth-scroll a { touch-action: manipulation; }
  }

  @media (prefers-reduced-motion: reduce) {
    *, *::before, *::after { animation: none !important; transition-duration: .01ms !important; }
  }
</style>
</head>

<body class="font-sans text-slate-800 antialiased bg-white">

<div class="auth-layout grid lg:grid-cols-2">

  <!-- LEFT HERO PANEL -->
  <section class="left-hero relative hidden lg:flex items-center bg-gradient-to-br from-slate-900 via-slate-800 to-sky-900">
    <div class="kenburns absolute inset-0 bg-cover bg-center" style="background-image:url('assets/images/sign.jpg')"></div>
    <div class="absolute inset-0 bg-gradient-to-t from-slate-950/90 via-slate-900/65 to-sky-900/50"></div>
    <div class="blob absolute -top-24 -left-24 w-96 h-96 rounded-full bg-sky-400/30 blur-3xl"></div>
    <div class="blob blob-2 absolute -bottom-32 -right-20 w-[28rem] h-[28rem] rounded-full bg-sky-300/20 blur-3xl"></div>

    <div class="relative z-10 w-full px-14 xl:px-20 py-16">
      <div class="flex items-center mb-14">
        <a href="index.php"><img src="assets/images/logos.png" alt="PURE GAIN logo" class="h-14 w-auto max-w-[220px] object-contain object-left"/></a>
      </div>

      <p id="hero-eyebrow" class="hero-swap text-xs font-bold uppercase tracking-[0.2em] text-sky-300 mb-3">Member Login</p>
      <h2 id="hero-title" class="hero-swap text-4xl xl:text-5xl font-extrabold text-white leading-[1.1] tracking-tight max-w-lg">Welcome back to PURE GAIN</h2>
      <p id="hero-sub" class="hero-swap mt-5 text-lg text-slate-300 max-w-md leading-relaxed">Premium supplements for every training goal, delivered to your doorstep.</p>

      <div class="mt-14 grid grid-cols-3 gap-3 max-w-lg">
        <div class="floaty rounded-2xl bg-white/10 backdrop-blur-md border border-white/15 p-4 text-white">
          <i class="fa-solid fa-shield-halved text-sky-300 mb-2"></i>
          <p class="text-[13px] font-bold leading-tight">100% Authentic</p>
        </div>
        <div class="floaty rounded-2xl bg-white/10 backdrop-blur-md border border-white/15 p-4 text-white">
          <i class="fa-solid fa-truck-fast text-sky-300 mb-2"></i>
          <p class="text-[13px] font-bold leading-tight">Same-day delivery</p>
        </div>
        <div class="floaty rounded-2xl bg-white/10 backdrop-blur-md border border-white/15 p-4 text-white">
          <i class="fa-solid fa-star text-amber-300 mb-2"></i>
          <p class="text-[13px] font-bold leading-tight">4.8 average rating</p>
        </div>
      </div>
    </div>
  </section>

  <!-- RIGHT SCROLL PANEL -->
  <section class="auth-scroll relative flex items-start justify-center w-full px-5 sm:px-10 py-10 overflow-x-hidden">
    <div class="blob pointer-events-none absolute -top-20 -right-20 w-72 h-72 rounded-full bg-sky-100 blur-3xl lg:hidden"></div>
    <div class="blob blob-2 pointer-events-none absolute -bottom-24 -left-16 w-72 h-72 rounded-full bg-sky-50 blur-3xl"></div>

    <div class="relative w-full max-w-[440px]">
      <div class="flex items-center justify-center mb-8">
        <a href="index.php"><img src="assets/images/logos.png" alt="PURE GAIN logo" class="h-14 w-auto max-w-[240px] object-contain"/></a>
      </div>

      <!-- TABS -->
      <div class="relative grid grid-cols-2 p-1 mb-8 rounded-2xl bg-slate-100" role="tablist" aria-label="Authentication">
        <span id="tab-pill" class="absolute top-1 bottom-1 left-1 w-[calc(50%-4px)] rounded-xl bg-white shadow transition-transform duration-500 ease-[cubic-bezier(.22,1,.36,1)]"></span>
        <button id="tab-login" data-mode="login" role="tab" aria-selected="true" type="button" class="tab-btn relative z-10 py-2.5 text-sm font-bold text-slate-900 transition-colors">Sign In</button>
        <button id="tab-register" data-mode="register" role="tab" aria-selected="false" type="button" class="tab-btn relative z-10 py-2.5 text-sm font-bold text-slate-500 transition-colors">Create Account</button>
      </div>

      <div class="grid">
        <!-- SIGN IN PANEL -->
        <div id="panel-login" class="form-panel" data-state="active">
          <div class="rise text-center mb-6">
            <h1 class="text-2xl sm:text-[26px] font-extrabold text-slate-900 tracking-tight">Sign in to your account</h1>
            <p class="text-sm text-slate-500 mt-1.5">
              Don't have an account?
              <button type="button" data-mode="register" class="font-bold text-sky-600 hover:underline">Create one</button>
            </p>
          </div>

          <button type="button" class="rise btn-shine w-full h-12 mb-5 rounded-xl border border-slate-200 bg-white hover:bg-slate-50 text-sm font-semibold flex items-center justify-center gap-3 transition-colors">
            <svg class="w-5 h-5" viewBox="0 0 24 24">
              <path d="M23.745 12.27c0-.7-.06-1.4-.19-2.07H12v4.51h6.6c-.29 1.52-1.14 2.82-2.4 3.68v3.05h3.88c2.27-2.09 3.665-5.17 3.665-9.17z" fill="#4285F4"/>
              <path d="M12 24c3.24 0 5.95-1.08 7.93-2.91l-3.88-3.05c-1.08.72-2.45 1.16-4.05 1.16-3.12 0-5.77-2.1-6.72-4.93H1.25v3.15C3.26 21.36 7.33 24 12 24z" fill="#34A853"/>
              <path d="M5.28 14.27c-.25-.72-.38-1.49-.38-2.27s.13-1.55.38-2.27V6.58H1.25C.45 8.18 0 9.99 0 12s.45 3.82 1.25 5.42l4.03-3.15z" fill="#FBBC05"/>
              <path d="M12 4.75c1.77 0 3.35.61 4.6 1.8l3.42-3.42C17.95 1.19 15.24 0 12 0 7.33 0 3.26 2.64 1.25 6.58l4.03 3.15c.95-2.83 3.6-4.98 6.72-4.98z" fill="#EA4335"/>
            </svg>
            Continue with Google
          </button>

          <div class="rise flex items-center gap-3 mb-5 text-[11px] font-bold uppercase tracking-wider text-slate-400">
            <span class="flex-1 h-px bg-slate-200"></span>
            or sign in with email
            <span class="flex-1 h-px bg-slate-200"></span>
          </div>

          <p id="login-global-error" class="hidden text-xs font-semibold text-red-500 mb-3 text-center"></p>

          <form id="login-form" class="space-y-4" novalidate>
            <div class="rise">
              <label for="login-email" class="block text-[13px] font-semibold text-slate-700 mb-1.5">Email Address</label>
              <div class="relative field">
                <input id="login-email" type="email" autocomplete="email" placeholder="you@example.com" class="inp peer"/>
                <i class="fa-regular fa-envelope ico"></i>
              </div>
              <p class="field-error hidden text-xs text-red-500 mt-1.5"></p>
            </div>

            <div class="rise">
              <div class="flex items-center justify-between mb-1.5">
                <label for="login-password" class="block text-[13px] font-semibold text-slate-700">Password</label>
                <a href="#" class="text-xs font-semibold text-sky-600 hover:underline">Forgot password?</a>
              </div>
              <div class="relative field">
                <input id="login-password" type="password" autocomplete="current-password" placeholder="••••••••" class="inp peer pr-12"/>
                <i class="fa-solid fa-lock ico"></i>
                <button type="button" data-toggle="login-password" aria-label="Show password" class="absolute right-2 top-1/2 -translate-y-1/2 w-9 h-9 rounded-full text-slate-400 hover:text-slate-700 hover:bg-slate-100 transition-colors">
                  <i class="fa-regular fa-eye"></i>
                </button>
              </div>
              <p class="field-error hidden text-xs text-red-500 mt-1.5"></p>
            </div>

            <label class="rise flex items-center gap-2 text-[13px] text-slate-600 cursor-pointer select-none">
              <input type="checkbox" checked class="w-4 h-4 rounded border-slate-300 accent-sky-500"/>
              Remember me on this device
            </label>

            <button type="submit" class="rise submit-btn btn-shine w-full h-12 rounded-xl bg-sky-500 hover:bg-sky-600 text-white text-sm font-bold shadow-lg shadow-sky-500/30 flex items-center justify-center gap-2 transition-all active:scale-[.98]">
              <span class="label">Sign In</span>
              <i class="fa-solid fa-arrow-right text-xs"></i>
            </button>
          </form>
        </div>

        <!-- CREATE ACCOUNT PANEL -->
        <div id="panel-register" class="form-panel" data-state="out-right">
          <div class="rise text-center mb-6">
            <h1 class="text-2xl sm:text-[26px] font-extrabold text-slate-900 tracking-tight">Create your account</h1>
            <p class="text-sm text-slate-500 mt-1.5">
              Already a member?
              <button type="button" data-mode="login" class="font-bold text-sky-600 hover:underline">Sign in</button>
            </p>
          </div>

          <button type="button" class="rise btn-shine w-full h-12 mb-5 rounded-xl border border-slate-200 bg-white hover:bg-slate-50 text-sm font-semibold flex items-center justify-center gap-3 transition-colors">
            <svg class="w-5 h-5" viewBox="0 0 24 24">
              <path d="M23.745 12.27c0-.7-.06-1.4-.19-2.07H12v4.51h6.6c-.29 1.52-1.14 2.82-2.4 3.68v3.05h3.88c2.27-2.09 3.665-5.17 3.665-9.17z" fill="#4285F4"/>
              <path d="M12 24c3.24 0 5.95-1.08 7.93-2.91l-3.88-3.05c-1.08.72-2.45 1.16-4.05 1.16-3.12 0-5.77-2.1-6.72-4.93H1.25v3.15C3.26 21.36 7.33 24 12 24z" fill="#34A853"/>
              <path d="M5.28 14.27c-.25-.72-.38-1.49-.38-2.27s.13-1.55.38-2.27V6.58H1.25C.45 8.18 0 9.99 0 12s.45 3.82 1.25 5.42l4.03-3.15z" fill="#FBBC05"/>
              <path d="M12 4.75c1.77 0 3.35.61 4.6 1.8l3.42-3.42C17.95 1.19 15.24 0 12 0 7.33 0 3.26 2.64 1.25 6.58l4.03 3.15c.95-2.83 3.6-4.98 6.72-4.98z" fill="#EA4335"/>
            </svg>
            Sign up with Google
          </button>

          <div class="rise flex items-center gap-3 mb-5 text-[11px] font-bold uppercase tracking-wider text-slate-400">
            <span class="flex-1 h-px bg-slate-200"></span>
            or sign up with email
            <span class="flex-1 h-px bg-slate-200"></span>
          </div>

          <p id="reg-global-error" class="hidden text-xs font-semibold text-red-500 mb-3 text-center"></p>

          <form id="register-form" class="space-y-4" novalidate>
            <div class="rise">
              <label for="reg-name" class="block text-[13px] font-semibold text-slate-700 mb-1.5">Full Name</label>
              <div class="relative field">
                <input id="reg-name" type="text" autocomplete="name" placeholder="Your full name" class="inp peer"/>
                <i class="fa-regular fa-user ico"></i>
              </div>
              <p class="field-error hidden text-xs text-red-500 mt-1.5"></p>
            </div>

            <div class="rise">
              <label for="reg-email" class="block text-[13px] font-semibold text-slate-700 mb-1.5">Email Address</label>
              <div class="relative field">
                <input id="reg-email" type="email" autocomplete="email" placeholder="you@example.com" class="inp peer"/>
                <i class="fa-regular fa-envelope ico"></i>
              </div>
              <p class="field-error hidden text-xs text-red-500 mt-1.5"></p>
            </div>

            <div class="rise">
              <label for="reg-password" class="block text-[13px] font-semibold text-slate-700 mb-1.5">Password</label>
              <div class="relative field">
                <input id="reg-password" type="password" autocomplete="new-password" placeholder="At least 8 characters" class="inp peer pr-12"/>
                <i class="fa-solid fa-lock ico"></i>
                <button type="button" data-toggle="reg-password" aria-label="Show password" class="absolute right-2 top-1/2 -translate-y-1/2 w-9 h-9 rounded-full text-slate-400 hover:text-slate-700 hover:bg-slate-100 transition-colors">
                  <i class="fa-regular fa-eye"></i>
                </button>
              </div>

              <div class="flex items-center gap-1.5 mt-2" aria-hidden="true">
                <span class="strength-seg h-1.5 flex-1 rounded-full bg-slate-200 transition-colors duration-300"></span>
                <span class="strength-seg h-1.5 flex-1 rounded-full bg-slate-200 transition-colors duration-300"></span>
                <span class="strength-seg h-1.5 flex-1 rounded-full bg-slate-200 transition-colors duration-300"></span>
                <span class="strength-seg h-1.5 flex-1 rounded-full bg-slate-200 transition-colors duration-300"></span>
                <span id="strength-label" class="text-[11px] font-semibold text-slate-400 w-16 text-right">&nbsp;</span>
              </div>
              <p class="field-error hidden text-xs text-red-500 mt-1.5"></p>
            </div>

            <div class="rise">
              <label for="reg-confirm" class="block text-[13px] font-semibold text-slate-700 mb-1.5">Confirm Password</label>
              <div class="relative field">
                <input id="reg-confirm" type="password" autocomplete="new-password" placeholder="Re-enter your password" class="inp peer"/>
                <i class="fa-solid fa-lock ico"></i>
              </div>
              <p class="field-error hidden text-xs text-red-500 mt-1.5"></p>
            </div>

            <div class="rise">
              <label class="flex items-start gap-2 text-[13px] text-slate-600 cursor-pointer select-none">
                <input id="reg-terms" type="checkbox" class="w-4 h-4 mt-0.5 rounded border-slate-300 accent-sky-500"/>
                <span>
                  I agree to the
                  <a href="#" class="font-semibold text-sky-600 hover:underline">Terms of Service</a>
                  and
                  <a href="#" class="font-semibold text-sky-600 hover:underline">Privacy Policy</a>.
                </span>
              </label>
              <p class="field-error hidden text-xs text-red-500 mt-1.5"></p>
            </div>

            <button type="submit" class="rise submit-btn btn-shine w-full h-12 rounded-xl bg-sky-500 hover:bg-sky-600 text-white text-sm font-bold shadow-lg shadow-sky-500/30 flex items-center justify-center gap-2 transition-all active:scale-[.98]">
              <span class="label">Create Account</span>
              <i class="fa-solid fa-arrow-right text-xs"></i>
            </button>
          </form>
        </div>
      </div>
    </div>
  </section>
</div>

<style>
  .inp {
    width: 100%;
    height: 3rem;
    padding: 0 1rem 0 2.9rem;
    border-radius: .75rem;
    background: #fff;
    border: 1px solid #e2e8f0;
    font-size: .875rem;
    color: #1e293b;
    transition: border-color .2s, box-shadow .2s;
  }
  .inp::placeholder { color: #94a3b8; }
  .inp:focus { outline: none; border-color: #38bdf8; box-shadow: 0 0 0 4px #e0f2fe; }
  .inp.invalid { border-color: #f87171; box-shadow: 0 0 0 4px #fee2e2; }
  .ico {
    position: absolute;
    left: 1rem;
    top: 50%;
    transform: translateY(-50%);
    color: #94a3b8;
    font-size: .9rem;
    pointer-events: none;
    transition: color .2s;
  }
  .inp:focus ~ .ico { color: #0ea5e9; }
  .pr-12.inp { padding-right: 3rem; }
</style>

<script>
  // Redirect target set straight to user dashboard
  const REDIRECT_URL = 'users/dashboard.php';

  const $ = (s, r = document) => r.querySelector(s);   const $$ = (s, r = document) => Array.from(r.querySelectorAll(s));

  $$('.form-panel').forEach(panel => {$$
('.rise', panel).forEach((el, i) => {
      el.style.setProperty('--i', i);
    });
  });

  const HERO = {
    login: {
      eyebrow: 'Member Login',
      title: 'Welcome back to PURE GAIN',
      sub: 'Premium supplements for every training goal, delivered to your doorstep.'
    },
    register: {
      eyebrow: 'Join PURE GAIN',
      title: 'Start your journey with PURE GAIN',
      sub: 'Create an account for member prices, order tracking and a wishlist of your favourite formulas.'
    }
  };

  let mode = 'login';

  function swapHero(next) {
    const els = ['hero-eyebrow', 'hero-title', 'hero-sub'].map(id => document.getElementById(id));
    els.forEach(el => el.classList.add('out'));
    setTimeout(() => {
      els[0].textContent = HERO[next].eyebrow;
      els[1].textContent = HERO[next].title;
      els[2].textContent = HERO[next].sub;
      els.forEach(el => el.classList.remove('out'));
    }, 300);
  }

  function setMode(next, { updateHash = true } = {}) {
    if (next === mode && $('#panel-' + next).dataset.state === 'active') return;

    const goingToRegister = next === 'register';
    $('#panel-login').dataset.state = goingToRegister ? 'out-left' : 'active';
    $('#panel-register').dataset.state = goingToRegister ? 'active' : 'out-right';
    $('#tab-pill').style.transform = goingToRegister ? 'translateX(100\%)' : 'translateX(0)';      $$('.tab-btn').forEach(b => {
      const on = b.dataset.mode === next;
      b.setAttribute('aria-selected', on);
      b.classList.toggle('text-slate-900', on);
      b.classList.toggle('text-slate-500', !on);
    });

    if (next !== mode) swapHero(next);

    document.title = (goingToRegister ? 'Create account' : 'Sign in') + ' | PURE GAIN';
    if (updateHash) history.replaceState(null, '', '#' + next);

    mode = next;
    setTimeout(() => {
      const first = $('#panel-' + next + ' input');
      if (first) first.focus({ preventScroll: true });
    }, 450);
  }

  $$('[data-mode]').forEach(el => {     el.addEventListener('click', () => setMode(el.dataset.mode));   });    if (location.hash === '#register') {     setMode('register', { updateHash: false });   }    $$
('[data-toggle]').forEach(btn => {
    btn.addEventListener('click', () => {
      const input = document.getElementById(btn.dataset.toggle);
      const show = input.type === 'password';
      input.type = show ? 'text' : 'password';
      btn.innerHTML = `<i class="fa-regular ${show ? 'fa-eye-slash' : 'fa-eye'}"></i>`;
      btn.setAttribute('aria-label', show ? 'Hide password' : 'Show password');
    });
  });

  const STRENGTH = [
    { t: '', c: 'bg-slate-200' },
    { t: 'Weak', c: 'bg-red-400' },
    { t: 'Fair', c: 'bg-amber-400' },
    { t: 'Good', c: 'bg-sky-400' },
    { t: 'Strong', c: 'bg-emerald-500' }
  ];

  function scorePassword(pw) {
    if (!pw) return 0;
    let s = 0;
    if (pw.length >= 8) s++;
    if (/[a-z]/.test(pw) && /[A-Z]/.test(pw)) s++;
    if (/\d/.test(pw)) s++;
    if (/[^A-Za-z0-9]/.test(pw) || pw.length >= 12) s++;
    return Math.max(s, 1);
  }

  $('#reg-password').addEventListener('input', e => {     const score = scorePassword(e.target.value);     $$('.strength-seg').forEach((seg, i) => {
      seg.className = 'strength-seg h-1.5 flex-1 rounded-full transition-colors duration-300 ' + (i < score ? STRENGTH[score].c : 'bg-slate-200');
    });
    $('#strength-label').textContent = STRENGTH[score].t || '\u00a0';
  });

  function setError(input, message) {
    const group = input.closest('.rise') || input.parentElement;
    const err = $('.field-error', group);
    const box = input.type === 'checkbox' ? null : input;

    if (box) box.classList.toggle('invalid', !!message);
    if (err) {
      err.textContent = message || '';
      err.classList.toggle('hidden', !message);
    }
    if (message && box) {
      const wrap = box.closest('.field');
      wrap.classList.remove('shake');
      void wrap.offsetWidth;
      wrap.classList.add('shake');
    }
    return !message;
  }

  const emailOk = v => /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(v);    $$('.inp').forEach(inp => {
    inp.addEventListener('input', () => setError(inp, ''));
  });

  $('#reg-terms').addEventListener('change', e => setError(e.target, ''));

  // Submit flow connected directly to backend PDO script
  async function submitFlow(form, action, formData, globalErrorEl) {
    const btn = $('.submit-btn', form);
    btn.disabled = true;

    btn.innerHTML = '<i class="fa-solid fa-circle-notch animate-spin"></i> <span>Processing...</span>';
    globalErrorEl.classList.add('hidden');

    try {
      formData.append('ajax_action', action);
      const res = await fetch(window.location.href, { method: 'POST', body: formData });
      const data = await res.json();

      if (data.success) {
        btn.classList.remove('bg-sky-500', 'hover:bg-sky-600', 'shadow-sky-500/30');
        btn.classList.add('bg-emerald-500', 'shadow-emerald-500/30');
        btn.innerHTML = '<i class="fa-solid fa-circle-check"></i> <span>' + data.message + '</span>';

        setTimeout(() => {
          window.location.href = REDIRECT_URL;
        }, 800);
      } else {
        btn.disabled = false;
        btn.innerHTML = '<span class="label">' + (action === 'login' ? 'Sign In' : 'Create Account') + '</span> <i class="fa-solid fa-arrow-right text-xs"></i>';
        globalErrorEl.textContent = data.message;
        globalErrorEl.classList.remove('hidden');
      }
    } catch (err) {
      btn.disabled = false;
      btn.innerHTML = '<span class="label">' + (action === 'login' ? 'Sign In' : 'Create Account') + '</span> <i class="fa-solid fa-arrow-right text-xs"></i>';
      globalErrorEl.textContent = 'Server connection error. Please try again.';
      globalErrorEl.classList.remove('hidden');
    }
  }

  // LOGIN FORM SUBMISSION
  $('#login-form').addEventListener('submit', e => {
    e.preventDefault();
    const email = $('#login-email');
    const pw = $('#login-password');

    const a = setError(email, !email.value.trim() ? 'Enter your email address.' : !emailOk(email.value.trim()) ? 'That email address looks invalid.' : '');
    const b = setError(pw, !pw.value ? 'Enter your password.' : '');

    if (a && b) {
      const fd = new FormData();
      fd.append('email', email.value.trim());
      fd.append('password', pw.value);
      submitFlow(e.target, 'login', fd, $('#login-global-error'));
    }
  });

  // REGISTER FORM SUBMISSION
  $('#register-form').addEventListener('submit', e => {
    e.preventDefault();
    const name = $('#reg-name');
    const email = $('#reg-email');
    const pw = $('#reg-password');
    const cf = $('#reg-confirm');
    const terms = $('#reg-terms');

    const results = [
      setError(name, !name.value.trim() ? 'Enter your full name.' : ''),
      setError(email, !email.value.trim() ? 'Enter your email address.' : !emailOk(email.value.trim()) ? 'That email address looks invalid.' : ''),
      setError(pw, pw.value.length < 8 ? 'Use at least 8 characters.' : ''),
      setError(cf, cf.value !== pw.value ? 'Passwords do not match.' : (!cf.value ? 'Re-enter your password.' : '')),
      setError(terms, !terms.checked ? 'Please accept the terms to continue.' : '')
    ];

    if (results.every(Boolean)) {
      const fd = new FormData();
      fd.append('full_name', name.value.trim());
      fd.append('email', email.value.trim());
      fd.append('password', pw.value);
      submitFlow(e.target, 'register', fd, $('#reg-global-error'));
    }
  });
</script>

</body>
</html>