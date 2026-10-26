<?php
// admin/logout.php
// Kills the session, clears the cookie, and redirects to login.

// 1) Start session (needed before session_destroy)
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 2) Clean up any DB session record (optional — safe even if table missing)
if (!empty($_SESSION['user_id']) && isset($pdo) === false) {
    // Only try if we haven't already required the DB
    $connPath = __DIR__ . '/../includes/db_connect.php';
    if (file_exists($connPath)) {
        require_once $connPath;
        if (isset($pdo)) {
            try {
                $stmt = $pdo->prepare("DELETE FROM user_sessions WHERE id = :sid AND user_id = :uid");
                $stmt->execute([
                    ':sid' => session_id() ? hash('sha256', session_id()) : '',
                    ':uid' => (int) $_SESSION['user_id'],
                ]);
            } catch (Throwable $e) { /* ignore — table may not exist */ }
        }
    }
}

// 3) Clear all session data
$_SESSION = [];

// 4) Expire the session cookie
if (ini_get('session.use_cookies')) {
    $params = session_get_cookie_params();
    setcookie(
        session_name(),
        '',
        time() - 42000,
        $params['path'],
        $params['domain'],
        $params['secure'],
        $params['httponly']
    );
}

// 5) Destroy the session
session_destroy();

// 6) Redirect to login with a friendly notice
header('Location: login.php?logged_out=1');
exit;