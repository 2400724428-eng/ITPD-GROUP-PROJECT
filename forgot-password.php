<?php
session_start();
require_once 'includes/db_connect.php'; // adjust path if needed

$errors = [];
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');

    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Please enter a valid email address.";
    } else {
        // Check if email exists
        $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ? LIMIT 1");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user) {
            // Generate 6-digit PIN
            $pin = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
            $token_hash = password_hash($pin, PASSWORD_DEFAULT);
            $expires_at = date('Y-m-d H:i:s', strtotime('+15 minutes'));

            // Delete any old unused tokens for this email
            $pdo->prepare("DELETE FROM password_resets WHERE email = ?")->execute([$email]);

            // Store new token
            $stmt = $pdo->prepare(
                "INSERT INTO password_resets (email, token_hash, expires_at) VALUES (?, ?, ?)"
            );
            $stmt->execute([$email, $token_hash, $expires_at]);

            // Send email
            $subject = "Your Password Reset PIN - Pure Gain";
            $message = "Hello,\n\n"
                     . "You requested a password reset for your Pure Gain account.\n\n"
                     . "Your 6-digit PIN is: $pin\n\n"
                     . "This PIN is valid for 15 minutes.\n\n"
                     . "If you did not request this, please ignore this email.\n\n"
                     . "— Pure Gain Team";
            $headers = "From: noreply@yourdomain.com\r\n";
            $headers .= "Reply-To: noreply@yourdomain.com\r\n";
            $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

            // On free hosting mail() often works. For better reliability use PHPMailer later.
            @mail($email, $subject, $message, $headers);
        }

        // Always show success message (prevents email enumeration)
        $_SESSION['reset_email'] = $email; // pass email securely to next page
        header("Location: reset-password.php");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password – Pure Gain</title>
    <link href="./src/output.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>body{font-family:'Plus Jakarta Sans',sans-serif}</style>
</head>
<body class="bg-slate-50 min-h-screen flex items-center justify-center p-4">

<div class="w-full max-w-md bg-white rounded-2xl shadow-sm border border-slate-200 p-8">
    <h1 class="text-2xl font-bold text-slate-900 mb-2">Forgot Password</h1>
    <p class="text-slate-600 text-sm mb-6">Enter your registered email and we’ll send you a 6-digit PIN.</p>

    <?php if (!empty($errors)): ?>
        <div class="mb-4 p-3 bg-red-50 text-red-700 text-sm rounded-lg">
            <?= htmlspecialchars($errors[0]) ?>
        </div>
    <?php endif; ?>

    <form method="POST" action="">
        <div class="mb-5">
            <label class="block text-sm font-medium text-slate-700 mb-1.5">Email address</label>
            <input type="email" name="email" required
                   class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition"
                   placeholder="you@example.com"
                   value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
        </div>

        <button type="submit"
                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2.5 rounded-xl transition">
            Send Reset PIN
        </button>
    </form>

    <p class="mt-6 text-center text-sm text-slate-500">
        <a href="login.php" class="text-blue-600 hover:underline">Back to Login</a>
    </p>
</div>

</body>
</html>
