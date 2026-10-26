<?php
$error = 'Something went wrong. Please try again.';
require_once __DIR__ . '/includes/db_connect.php';

$error = '';
$email = trim($_GET['email'] ?? $_POST['email'] ?? '');
$token = trim($_GET['token'] ?? $_POST['token'] ?? '');

// If a token was provided, look up the row to pre-fill email
if ($token !== '') {
    try {
        $stmt = $pdo->prepare(
            "SELECT * FROM puregain_password_resets
             WHERE token_hash = :t AND consumed = 0 AND expires_at > NOW()
             ORDER BY id DESC LIMIT 1"
        );
        $stmt->execute([':t' => hash('sha256', $token)]);
        if ($row = $stmt->fetch()) $email = $row['email'];
    } catch (Throwable $e) { /* ignore */ }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $code        = strtoupper(trim($_POST['code'] ?? ''));
    $new         = $_POST['new_password'] ?? '';
    $confirm     = $_POST['confirm_password'] ?? '';

    $errors = [];
    if ($code === '')                     $errors[] = 'Enter the reset code.';
    if (strlen($new) < 8)                 $errors[] = 'New password must be at least 8 characters.';
    if ($new !== $confirm)                $errors[] = 'Passwords do not match.';

    if (!$errors) {
        try {
            // 1. Verify the code against the reset table
            $stmt = $pdo->prepare(
                "SELECT * FROM puregain_password_resets
                 WHERE email = :e AND short_code_hash = :h
                   AND consumed = 0 AND expires_at > NOW()
                 ORDER BY id DESC LIMIT 1"
            );
            $stmt->execute([':e' => $email, ':h' => hash('sha256', $code)]);
            $reset = $stmt->fetch();

            if (!$reset) {
                $errors[] = 'Invalid or expired reset code.';
            } else {
                // 2. Find the user by email in the `users` table
                $ustmt = $pdo->prepare("SELECT id FROM users WHERE email = :e LIMIT 1");
                $ustmt->execute([':e' => $email]);
                $u = $ustmt->fetch();

                if (!$u) {
                    $errors[] = 'No account matches that email.';
                } else {
                    // 3. Update the password (column `password_hash`, key `id`)
                    $pdo->prepare("UPDATE users SET password_hash = :h WHERE id = :id")
                        ->execute([
                            ':h'  => password_hash($new, PASSWORD_DEFAULT),
                            ':id' => (int) $u['id'],
                        ]);

                    // 4. Mark all codes for this email consumed
                    $pdo->prepare("UPDATE puregain_password_resets SET consumed = 1 WHERE email = :e")
                        ->execute([':e' => $email]);

                    // 5. Invalidate active sessions for safety
                    try {
                        $pdo->prepare("DELETE FROM user_sessions WHERE user_id = :id")
                            ->execute([':id' => (int) $u['id']]);
                    } catch (Throwable $e) { /* table may not exist */ }

                    header('Location: login.php?reset=1');
                    exit;
                }
            }
        } catch (Throwable $e) {
            error_log('[reset-password] ' . $e->getMessage());
            $errors[] = 'Something went wrong. Please try again.';
        }
    }

    if ($errors) $error = implode(' ', $errors);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<title>Reset Password - PURE GAIN</title>
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
            <a href="login.php" class="text-brand-navy/60 hover:text-brand-navy transition-colors flex items-center gap-1.5 text-xs font-semibold tracking-wide">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                BACK
            </a>
        </div>
        <div class="relative z-10 mt-4">
            <div class="w-16 h-16 bg-white/80 shadow-sm border border-white rounded-2xl mx-auto flex items-center justify-center mb-4 overflow-hidden p-2">
                <img src="assets/images/fav.png" alt="Logo" class="w-full h-full object-cover rounded-xl">
            </div>
            <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">Set New Password</h1>
            <p class="text-slate-600 text-sm mt-1.5 font-medium">Enter your reset code and choose a new password.</p>
        </div>
    </div>

    <div class="p-8 relative z-10 bg-white/30">

        <?php if ($error): ?>
            <div class="mb-4 text-sm text-red-700 bg-red-100/80 border border-red-200 rounded-lg px-3 py-2">
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>

        <form method="POST" class="space-y-4">
            <input type="hidden" name="email" value="<?= htmlspecialchars($email) ?>">
            <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">

            <div>
                <label class="block text-sm font-semibold text-slate-800 mb-2">Email</label>
                <input type="email" name="email_display" value="<?= htmlspecialchars($email) ?>" disabled
                    class="w-full px-4 py-3 bg-slate-100 border border-slate-200 rounded-xl text-slate-600 text-sm font-medium cursor-not-allowed">
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-800 mb-2">Reset Code</label>
                <input type="text" name="code" required maxlength="8"
                    value="<?= htmlspecialchars($_POST['code'] ?? '') ?>"
                    class="w-full px-4 py-3 bg-white/90 border border-white/50 rounded-xl focus:outline-none focus:bg-white focus:border-brand-navy focus:ring-2 focus:ring-brand-navy/20 transition-all text-slate-800 font-bold text-lg tracking-[0.35em] text-center uppercase placeholder:text-slate-300 placeholder:font-normal placeholder:tracking-normal"
                    placeholder="ENTER CODE">
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-800 mb-2">New Password</label>
                <input type="password" name="new_password" required minlength="8"
                    class="w-full px-4 py-3 bg-white/90 border border-white/50 rounded-xl focus:outline-none focus:bg-white focus:border-brand-navy focus:ring-2 focus:ring-brand-navy/20 transition-all text-slate-800 font-medium text-sm"
                    placeholder="At least 8 characters">
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-800 mb-2">Confirm New Password</label>
                <input type="password" name="confirm_password" required minlength="8"
                    class="w-full px-4 py-3 bg-white/90 border border-white/50 rounded-xl focus:outline-none focus:bg-white focus:border-brand-navy focus:ring-2 focus:ring-brand-navy/20 transition-all text-slate-800 font-medium text-sm"
                    placeholder="Re-enter new password">
            </div>

            <button type="submit"
                class="w-full bg-brand-navy text-white font-bold text-sm py-3.5 rounded-xl hover:bg-blue-900 hover:shadow-lg hover:shadow-brand-navy/30 active:scale-[0.98] transition-all duration-200 mt-2">
                Reset Password
            </button>
        </form>

        <div class="mt-6 text-center">
            <a href="forgot-password.php" class="text-xs font-semibold text-slate-600 hover:text-brand-navy">
                Didn't get a code? Start over
            </a>
        </div>
    </div>
</div>

</body>
</html>