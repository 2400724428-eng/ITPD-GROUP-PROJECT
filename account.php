<?php
require_once 'vendor/autoload.php';

// Load environment variables securely from the root .env file
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

session_start();

// 1. Google Client Configuration using Environment Variables
$client = new Google_Client();
$client->setClientId($_ENV['GOOGLE_CLIENT_ID']);
$client->setClientSecret($_ENV['GOOGLE_CLIENT_SECRET']);
$client->setRedirectUri($_ENV['GOOGLE_REDIRECT_URI']);
$client->addScope('email');
$client->addScope('profile');

// 2. Handle Google OAuth Callback & Redirection
if (isset($_GET['code'])) {
    $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
    
    if (!isset($token['error'])) {
        $client->setAccessToken($token['access_token']);
        
        // Get user profile info from Google
        $google_oauth = new Google_Service_Oauth2($client);
        $google_account_info = $google_oauth->userinfo->get();
        
        // Store user details in session
        $_SESSION['user_email'] = $google_account_info->email;
        $_SESSION['user_name'] = $google_account_info->name;
        
        // Redirect directly to shop.php upon successful Google sign-in
        header('Location: shop.php');
        exit();
    } else {
        header('Location: account.php?error=google_auth_failed');
        exit();
    }
}

$login_url = $client->createAuthUrl();

// 3. Handle Traditional Form Submission (Placeholder logic)
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if (!empty($username) && !empty($password)) {
        // Add your database verification logic here
    } else {
        $error = 'Please fill in all fields.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Pure Gain</title>
    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="assets/css/account.css">
</head>
<body>

    <div class="login-card">
        <!-- Brand / Header Logo -->
        <div class="login-header">
            <div class="logo-wrapper">
                <img src="assets/images/logo.jpg" alt="Pure Gain Logo">
            </div>
            <h2>Welcome Back</h2>
            <p>Sign in to your Pure Gain account</p>
        </div>

        <?php if (!empty($error)): ?>
            <div class="error-message">
                <i class="fa-solid fa-circle-exclamation"></i>
                <span><?= htmlspecialchars($error); ?></span>
            </div>
        <?php endif; ?>

        <!-- Traditional Username/Password Form -->
        <form action="account.php" method="POST" class="login-form">
            <div class="form-group">
                <label>Username or Email</label>
                <div class="input-wrapper">
                    <span class="input-icon">
                        <i class="fa-solid fa-user"></i>
                    </span>
                    <input type="text" name="username" required placeholder="Enter your username">
                </div>
            </div>

            <div class="form-group">
                <label>Password</label>
                <div class="input-wrapper">
                    <span class="input-icon">
                        <i class="fa-solid fa-lock"></i>
                    </span>
                    <input type="password" name="password" id="password" required placeholder="••••••••">
                    <button type="button" onclick="togglePassword()" class="toggle-password-btn">
                        <i class="fa-solid fa-eye" id="toggleIcon"></i>
                    </button>
                </div>
            </div>

            <button type="submit" class="submit-btn">
                <i class="fa-solid fa-right-to-bracket"></i>
                Sign In
            </button>
        </form>

        <div class="divider">
            <span>Or continue with</span>
        </div>

        <!-- Google Login Button -->
        <div>
            <a href="<?= htmlspecialchars($login_url); ?>" class="google-btn">
                <svg class="google-icon" viewBox="0 0 24 24">
                    <path fill="#4285F4" d="M23.745 12.27c0-.7-.06-1.4-.19-2.07H12v4.51h6.6c-.29 1.52-1.14 2.82-2.4 3.68v3.05h3.88c2.27-2.09 3.66-5.17 3.66-9.17z"/>
                    <path fill="#34A853" d="M12 24c3.24 0 5.95-1.08 7.93-2.91l-3.88-3.05c-1.08.72-2.45 1.16-4.05 1.16-3.12 0-5.77-2.1-6.72-4.93H1.2v3.15C3.2 21.31 7.25 24 12 24z"/>
                    <path fill="#FBBC05" d="M5.28 14.27c-.25-.72-.38-1.49-.38-2.27s.13-1.55.38-2.27V6.58H1.2C.44 8.14 0 9.92 0 12s.44 3.86 1.2 5.42l4.08-3.15z"/>
                    <path fill="#EA4335" d="M12 4.75c1.77 0 3.35.61 4.6 1.8l3.42-3.42C17.95 1.19 15.24 0 12 0 7.25 0 3.2 2.69 1.2 6.58l4.08 3.15c.95-2.83 3.6-4.98 6.72-4.98z"/>
                </svg>
                Sign up / In with Google
            </a>
        </div>

        <p class="signup-footer">
            Don't have an account? <a href="#">Sign up</a>
        </p>
    </div>

    <!-- JavaScript to toggle password visibility -->
    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const toggleIcon = document.getElementById('toggleIcon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            }
        }
    </script>
</body>
</html>