<?php
// admin/login.php

// 1) Start session (safe if already started)
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 2) Load the DB connector — try both likely locations so it can't fail silently
$candidates = [
    __DIR__ . '/../includes/db_connect.php', // /includes/db_connect.php
    __DIR__ . '/db_connect.php',             // /admin/db_connect.php
    __DIR__ . '/../config.php',              // fallback
];

$loaded = null;
foreach ($candidates as $file) {
    if (file_exists($file)) { $loaded = $file; break; }
}

if (!$loaded) {
    die('No DB connector found. Tried:<br>' . implode('<br>', array_map('htmlspecialchars', $candidates)));
}

require_once $loaded;

if (!isset($pdo) || !($pdo instanceof PDO)) {
    die('Loaded ' . htmlspecialchars($loaded) . ' but $pdo was not created there. '
      . 'Open that file and make sure it assigns $pdo = new PDO(...);');
}

// 3) If already logged in, go to dashboard
if (!empty($_SESSION['user_id'])) {
    header('Location: dashboard.php');
    exit;
}

$error = '';

// 4) Handle POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($username === '' || $password === '') {
        $error = 'Please enter both username and password.';
    } else {
        // Distinct placeholders — required because EMULATE_PREPARES = false
        $stmt = $pdo->prepare(
            "SELECT user_id, role, email, password_hash, trainer_name
             FROM gymnuser
             WHERE email = :email OR role = :role
             LIMIT 2"
        );
        $stmt->execute([':email' => $username, ':role' => $username]);
        $rows = $stmt->fetchAll();

        // Prefer exact email match; else first row
        $user = null;
        foreach ($rows as $r) {
            if (strcasecmp($r['email'], $username) === 0) { $user = $r; break; }
        }
        if (!$user && $rows) { $user = $rows[0]; }

        if (!$user) {
            $error = 'Invalid username or password.';
        } elseif (!password_verify($password, $user['password_hash'])) {
            $error = 'Invalid username or password.';
        } elseif (!in_array($user['role'], ['admin', 'product_manager', 'manager'], true)) {
            $error = 'You do not have permission to access the admin portal.';
        } else {
            session_regenerate_id(true);
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['role']    = $user['role'];
            $_SESSION['email']   = $user['email'];
            $_SESSION['name']    = $user['trainer_name'] ?: $user['email'];

            header('Location: dashboard.php');
            exit;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>Admin Login - ApexFit</title>
<script src="https://cdn.tailwindcss.com"></script>
<link href="https://fonts.googleapis.com" rel="preconnect"/>
<link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect"/>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@500;600;700;800&family=Inter:wght@400;500;600&display=swap" rel="stylesheet"/>
<script>
    tailwind.config = {
      theme: {
        extend: {
          fontFamily: { sans: ['Plus Jakarta Sans', 'Inter', 'sans-serif'] },
          colors: { brand: { navy: '#1e3a8a' } }
        }
      }
    }
</script>
<style>
    body { font-family: 'Plus Jakarta Sans', sans-serif; -webkit-font-smoothing: antialiased; background-color: #f8fafc; position: relative; isolation: isolate; overflow-x: hidden; min-height: 100vh; }
    body::before { content: ""; position: absolute; z-index: -1; top: -35%; right: -10%; width: 75%; height: 145%;
        background: radial-gradient(ellipse at 72% 30%, rgba(96,165,250,0.4) 0%, rgba(147,197,253,0.25) 30%, rgba(219,234,254,0.1) 52%, transparent 75%);
        border-radius: 50% 0 0 50%; transform: rotate(-12deg); pointer-events: none; }
    body::after { content: ""; position: absolute; z-index: -1; right: -12%; bottom: -20%; width: 100%; height: 85%;
        background: linear-gradient(125deg, rgba(219,234,254,0.8) 0%, rgba(147,197,253,0.8) 28%, rgba(59,130,246,0.8) 62%, rgba(29,78,216,0.9) 100%);
        border-radius: 55% 0 0 0; transform: rotate(-8deg); pointer-events: none; }
    @media (max-width: 640px) { body::before { right: -30%; width: 110%; } body::after { right: -35%; bottom: -10%; width: 125%; height: 70%; } }
    .card-gradient { position: relative; isolation: isolate; background: rgba(255,255,255,0.85); backdrop-filter: blur(16px); -webkit-backdrop-filter: blur(16px); }
    .card-gradient::before { content: ""; position: absolute; z-index: -1; top: -35%; right: -10%; width: 75%; height: 145%;
        background: radial-gradient(ellipse at 72% 30%, rgba(96,165,250,0.5) 0%, rgba(147,197,253,0.3) 30%, rgba(219,234,254,0.15) 52%, transparent 75%);
        border-radius: 50% 0 0 50%; transform: rotate(-12deg); pointer-events: none; }
    .card-gradient::after { content: ""; position: absolute; z-index: -1; right: -12%; bottom: -78%; width: 100%; height: 125%;
        background: linear-gradient(125deg, rgba(219,234,254,0.95) 0%, rgba(147,197,253,0.9) 28%, rgba(59,130,246,0.9) 62%, rgba(29,78,216,0.95) 100%);
        border-radius: 55% 0 0 0; transform: rotate(-8deg); pointer-events: none; }
    @media (max-width: 640px) { .card-gradient::before { right: -30%; width: 110%; } .card-gradient::after { right: -35%; bottom: -82%; width: 125%; height: 115%; } }
</style>
</head>
<body class="text-slate-800 antialiased grid place-items-center p-4 sm:p-6">

<div class="card-gradient w-full max-w-[420px] rounded-[2rem] shadow-[0_25px_60px_-15px_rgba(30,64,175,0.3)] border border-white/60 overflow-hidden relative z-10">

    <div class="p-8 text-center relative border-b border-white/40">
        <div class="absolute top-5 left-5 z-10">
            <a href="../index.php" class="text-brand-navy/60 hover:text-brand-navy transition-colors flex items-center gap-1.5 text-xs font-semibold tracking-wide">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                BACK
            </a>
        </div>
        <div class="relative z-10 mt-4">
            <div class="w-16 h-16 bg-white/80 shadow-sm border border-white rounded-2xl mx-auto flex items-center justify-center mb-4 overflow-hidden p-2">
                <img src="../assets/images/fav.png" alt="Admin Logo" class="w-full h-full object-cover rounded-xl">
            </div>
            <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">Admin Portal</h1>
            <p class="text-slate-600 text-sm mt-1.5 font-medium">Sign in to manage your store</p>
        </div>
    </div>

    <div class="p-8 relative z-10 bg-white/30">
        <?php if ($error): ?>
            <div class="mb-4 text-sm text-red-700 bg-red-100/80 border border-red-200 rounded-lg px-3 py-2">
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>

        <form action="<?= htmlspecialchars($_SERVER['PHP_SELF'] ?? 'login.php') ?>" method="POST" class="space-y-5">
            <div>
                <label class="block text-sm font-semibold text-slate-800 mb-2">Username / Email</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                        <svg class="w-5 h-5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    </div>
                    <input type="text" name="username" required
                        value="<?= htmlspecialchars($_POST['username'] ?? '') ?>"
                        class="w-full pl-11 pr-4 py-3 bg-white/90 border border-white/50 rounded-xl focus:outline-none focus:bg-white focus:border-brand-navy focus:ring-2 focus:ring-brand-navy/20 transition-all text-slate-800 font-medium text-sm placeholder:text-slate-400 placeholder:font-normal shadow-sm"
                        placeholder="admin or your@email.com">
                </div>
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-800 mb-2">Password</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                        <svg class="w-5 h-5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                    </div>
                    <input type="password" name="password" required
                        class="w-full pl-11 pr-4 py-3 bg-white/90 border border-white/50 rounded-xl focus:outline-none focus:bg-white focus:border-brand-navy focus:ring-2 focus:ring-brand-navy/20 transition-all text-slate-800 font-medium text-sm placeholder:text-slate-400 placeholder:font-normal shadow-sm"
                        placeholder="••••••••">
                </div>
            </div>

            <button type="submit"
                class="w-full bg-brand-navy text-white font-bold text-sm py-3.5 rounded-xl hover:bg-blue-900 hover:shadow-lg hover:shadow-brand-navy/30 active:scale-[0.98] transition-all duration-200 mt-2">
                Sign In
            </button>
        </form>


        <div class="mt-6 text-center">
    <a href="forgot-password.php"
       class="text-xs font-semibold text-brand-navy hover:text-blue-700 hover:underline transition-colors">
        Forgot your password?
    </a>
    <p class="text-[11px] text-slate-500 mt-2">
        We'll send a reset link to your registered email.
    </p>
</div>



</body>
</html>