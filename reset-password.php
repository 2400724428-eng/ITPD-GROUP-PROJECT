<?php
session_start();
require_once 'includes/db_connect.php'; // adjust path if needed

// Must come from forgot-password flow
if (empty($_SESSION['reset_email'])) {
    header("Location: forgot-password.php");
    exit;
}

$email = $_SESSION['reset_email'];
$errors = [];
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pin            = trim($_POST['pin'] ?? '');
    $new_password   = $_POST['new_password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';

    // Basic validation
    if (empty($pin) || !preg_match('/^\d{6}$/', $pin)) {
        $errors[] = "Please enter a valid 6-digit PIN.";
    }
    if (strlen($new_password) < 8) {
        $errors[] = "Password must be at least 8 characters.";
    }
    if ($new_password !== $confirm_password) {
        $errors[] = "New password and confirmation do not match.";
    }

    if (empty($errors)) {
        // Get the latest valid token for this email
        $stmt = $pdo->prepare(
            "SELECT id, token_hash, expires_at 
             FROM password_resets 
             WHERE email = ? 
             ORDER BY created_at DESC 
             LIMIT 1"
        );
        $stmt->execute([$email]);
        $reset = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$reset) {
            $errors[] = "No reset request found. Please request a new PIN.";
        } elseif (strtotime($reset['expires_at']) < time()) {
            $errors[] = "This PIN has expired. Please request a new one.";
        } elseif (!password_verify($pin, $reset['token_hash'])) {
            $errors[] = "Incorrect PIN. Please check your email and try again.";
        } else {
            // All good → update password
            $new_hash = password_hash($new_password, PASSWORD_DEFAULT);

            $stmt = $pdo->prepare("UPDATE users SET password_hash = ? WHERE email = ?");
            $stmt->execute([$new_hash, $email]);

            // Invalidate the used PIN
            $pdo->prepare("DELETE FROM password_resets WHERE email = ?")->execute([$email]);

            // Clear session
            unset($_SESSION['reset_email']);

            $success = true;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password – Pure Gain</title>
    <link href="./src/output.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>body{font-family:'Plus Jakarta Sans',sans-serif}</style>
</head>
<body class="bg-slate-50 min-h-screen flex items-center justify-center p-4">

<div class="w-full max-w-md bg-white rounded-2xl shadow-sm border border-slate-200 p-8">

    <?php if ($success): ?>
        <div class="text-center">
            <div class="w-16 h-16 bg-green-100 text-green-600 rounded-full flex items-center justify-center mx-auto mb-4 text-2xl">✓</div>
            <h1 class="text-2xl font-bold text-slate-900 mb-2">Password Updated!</h1>
            <p class="text-slate-600 text-sm mb-6">You can now log in with your new password.</p>
            <a href="login.php"
               class="inline-block w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2.5 rounded-xl transition text-center">
                Go to Login
            </a>
        </div>
    <?php else: ?>

        <h1 class="text-2xl font-bold text-slate-900 mb-2">Reset Password</h1>
        <p class="text-slate-600 text-sm mb-6">
            Enter the 6-digit PIN sent to <strong><?= htmlspecialchars($email) ?></strong>
        </p>

        <?php if (!empty($errors)): ?>
            <div class="mb-4 p-3 bg-red-50 text-red-700 text-sm rounded-lg">
                <?= htmlspecialchars($errors[0]) ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="">
            <div class="mb-4">
                <label class="block text-sm font-medium text-slate-700 mb-1.5">6-digit PIN</label>
                <input type="text" name="pin" maxlength="6" required
                       class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-blue-500 outline-none tracking-widest text-center text-lg"
                       placeholder="••••••"
                       inputmode="numeric" pattern="\d{6}">
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-slate-700 mb-1.5">New Password</label>
                <input type="password" name="new_password" required minlength="8"
                       class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-blue-500 outline-none"
                       placeholder="At least 8 characters">
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium text-slate-700 mb-1.5">Confirm New Password</label>
                <input type="password" name="confirm_password" required minlength="8"
                       class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-blue-500 outline-none"
                       placeholder="Repeat new password">
            </div>

            <button type="submit"
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2.5 rounded-xl transition">
                Reset Password
            </button>
        </form>

        <p class="mt-6 text-center text-sm text-slate-500">
            <a href="forgot-password.php" class="text-blue-600 hover:underline">Request a new PIN</a>
        </p>
    <?php endif; ?>

</div>

</body>
</html>
