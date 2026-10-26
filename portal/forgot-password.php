<?php
require_once __DIR__ . '/../includes/db_connect.php';

$error = '';
$stage = 'form';        // 'form' | 'code'
$shortCode = '';
$resetUrl  = '';
$email     = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');

    if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Enter a valid email address.';
    } else {
        try {
            // Look up the user (silently — always respond the same way)
            $stmt = $pdo->prepare("SELECT user_id FROM gymnuser WHERE email = :e LIMIT 1");
            $stmt->execute([':e' => $email]);
            $user = $stmt->fetch();

            // Generate cryptographically strong values
            $shortCode = strtoupper(bin2hex(random_bytes(4)));       // e.g. "9F3A2C7B" — 8 hex chars
            $token     = bin2hex(random_bytes(32));                  // full token (not shown)
            $shortHash = hash('sha256', $shortCode);
            $tokenHash = hash('sha256', $token);
            $expires   = (new DateTime('+15 minutes'))->format('Y-m-d H:i:s');
            $ip        = $_SERVER['REMOTE_ADDR'] ?? null;

            // Invalidate prior unused codes for this email
            $pdo->prepare("UPDATE password_resets SET consumed = 1 WHERE email = :e AND consumed = 0")
                ->execute([':e' => $email]);

            $ins = $pdo->prepare(
                "INSERT INTO password_resets (email, user_id, token_hash, short_code_hash, expires_at, ip)
                 VALUES (:email, :uid, :th, :sh, :exp, :ip)"
            );
            $ins->execute([
                ':email' => $email,
                ':uid'   => $user['user_id'] ?? null,
                ':th'    => $tokenHash,
                ':sh'    => $shortHash,
                ':exp'   => $expires,
                ':ip'    => $ip,
            ]);

            // Build reset link for convenience (uses the long token, still protected)
            $resetUrl = 'reset-password.php?token=' . urlencode($token) . '&email=' . urlencode($email);

            $stage = 'code';
        } catch (Throwable $e) {
            error_log('[forgot-password] ' . $e->getMessage());
            $error = 'Something went wrong. Please try again.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<title>Forgot Password - PURE GAIN</title>
<script src="https://cdn.tailwindcss.com"></script>
<script>
    tailwind.config = { theme: { extend: {
        fontFamily: { sans: ['Plus Jakarta Sans', 'Inter', 'sans-serif'] },
        colors: { brand: { navy: '#1e3a8a' } }
    }}}
</script>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@500;600;700;800&display=swap" rel="stylesheet"/>
<style>
    body { font-family: 'Plus Jakarta Sans', sans-serif; -webkit-font-smoothing: antialiased;
           background-color: #f8fafc; position: relative; isolation: isolate; overflow-x: hidden; min-height: 100vh; }
    body::before { content:""; position: absolute; z-index: -1; top: -35%; right: -10%; width: 75%; height: 145%;
        background: radial-gradient(ellipse at 72% 30%, rgba(96,165,250,0.4) 0%, rgba(147,197,253,0.25) 30%, rgba(219,234,254,0.1) 52%, transparent 75%);
        border-radius: 50% 0 0 50%; transform: rotate(-12deg); pointer-events: none; }
    body::after { content:""; position: absolute; z-index: -1; right: -12%; bottom: -20%; width: 100%; height: 85%;
        background: linear-gradient(125deg, rgba(219,234,254,0.8) 0%, rgba(147,197,253,0.8) 28%, rgba(59,130,246,0.8) 62%, rgba(29,78,216,0.9) 100%);
        border-radius: 55% 0 0 0; transform: rotate(-8deg); pointer-events: none; }
    .card-gradient { position: relative; isolation: isolate; background: rgba(255,255,255,0.85);
                     backdrop-filter: blur(16px); -webkit-backdrop-filter: blur(16px); }
</style>
</head>
<body class="text-slate-800 antialiased grid place-items-center p-4 sm:p-6">

<div class="card-gradient w-full max-w-[460px] rounded-[2rem] shadow-[0_25px_60px_-15px_rgba(30,64,175,0.3)] border border-white/60 overflow-hidden relative z-10">

    <div class="p-8 text-center relative border-b border-white/40">
        <div class="absolute top-5 left-5 z-10">
            <a href="portalogin.php" class="text-brand-navy/60 hover:text-brand-navy transition-colors flex items-center gap-1.5 text-xs font-semibold tracking-wide">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                BACK
            </a>
        </div>
        <div class="relative z-10 mt-4">
            <div class="w-16 h-16 bg-white/80 shadow-sm border border-white rounded-2xl mx-auto flex items-center justify-center mb-4 overflow-hidden p-2">
                <img src="../assets/images/fav.png" alt="Logo" class="w-full h-full object-cover rounded-xl">
            </div>
            <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">
                <?= $stage === 'code' ? 'Your Reset Code' : 'Forgot Password' ?>
            </h1>
            <p class="text-slate-600 text-sm mt-1.5 font-medium">
                <?= $stage === 'code'
                    ? 'Copy this code, then continue to set a new password.'
                    : 'Enter your account email to receive a reset code.' ?>
            </p>
        </div>
    </div>

    <div class="p-8 relative z-10 bg-white/30">

        <?php if ($error): ?>
            <div class="mb-4 text-sm text-red-700 bg-red-100/80 border border-red-200 rounded-lg px-3 py-2">
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>

        <?php if ($stage === 'form'): ?>
            <form method="POST" class="space-y-5">
                <div>
                    <label class="block text-sm font-semibold text-slate-800 mb-2">Email Address</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                            <svg class="w-5 h-5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <input type="email" name="email" required
                            value="<?= htmlspecialchars($_POST['email'] ?? '') ?>"
                            class="w-full pl-11 pr-4 py-3 bg-white/90 border border-white/50 rounded-xl focus:outline-none focus:bg-white focus:border-brand-navy focus:ring-2 focus:ring-brand-navy/20 transition-all text-slate-800 font-medium text-sm placeholder:text-slate-400 placeholder:font-normal shadow-sm"
                            placeholder="you@example.com">
                    </div>
                </div>

                <button type="submit"
                    class="w-full bg-brand-navy text-white font-bold text-sm py-3.5 rounded-xl hover:bg-blue-900 hover:shadow-lg hover:shadow-brand-navy/30 active:scale-[0.98] transition-all duration-200">
                    Generate Reset Code
                </button>
            </form>

        <?php else: ?>
            <!-- Show the generated visual code -->
            <div class="text-center">
                <div class="inline-block px-8 py-5 bg-white border-2 border-dashed border-brand-navy/40 rounded-2xl shadow-sm">
                    <div class="text-[11px] font-semibold text-slate-500 uppercase tracking-widest mb-1">Your code</div>
                    <div class="text-3xl sm:text-4xl font-extrabold tracking-[0.35em] text-brand-navy select-all">
                        <?= htmlspecialchars($shortCode) ?>
                    </div>
                </div>
                <p class="text-[11px] text-slate-500 mt-3">
                    Valid for <strong>15 minutes</strong>. Copy it and click Continue.
                </p>
            </div>

            <div class="mt-6 space-y-3">
                <a href="<?= htmlspecialchars($resetUrl) ?>"
                   class="block text-center w-full bg-brand-navy text-white font-bold text-sm py-3.5 rounded-xl hover:bg-blue-900 hover:shadow-lg transition-all">
                    I've copied it — Continue
                </a>
                <p class="text-center text-[11px] text-slate-500">
                    Sent to <strong><?= htmlspecialchars($email) ?></strong>
                </p>
                <a href="forgot-password.php"
                   class="block text-center text-xs font-semibold text-slate-600 hover:text-brand-navy">
                    ← Use a different email
                </a>
            </div>
        <?php endif; ?>

        <div class="mt-6 text-center">
            <a href="portalogin.php" class="text-xs font-semibold text-brand-navy hover:underline">← Back to Sign In</a>
        </div>
    </div>
</div>

</body>
</html>