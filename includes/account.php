<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$isLoggedIn = isset($_SESSION['user_id']);
$userName   = $isLoggedIn ? $_SESSION['full_name'] : 'Guest User';
$userEmail  = $isLoggedIn ? $_SESSION['email'] : 'Sign in to manage portal';
$userPhoto  = $isLoggedIn ? ($_SESSION['profile_photo'] ?? 'uploads/avatars/default-avatar.png') : 'uploads/avatars/default-avatar.png';

// Fetch user order count if logged in
$orderCount = 0;
if ($isLoggedIn) {
    require_once __DIR__ . '/db_connect.php';
    $orderStmt = $pdo->prepare("SELECT COUNT(*) FROM orders WHERE user_id = ?");
    $orderStmt->execute([$_SESSION['user_id']]);
    $orderCount = (int) $orderStmt->fetchColumn();
}
?>

<!-- Wrapper Container -->
<div class="js-account-container relative">

    <!-- Trigger Link -->
    <button type="button" class="js-account-toggle flex items-center space-x-1.5 text-[14px] font-medium hover:text-blue-600 transition-colors pl-1 cursor-pointer select-none focus:outline-none">
        <?php if ($isLoggedIn): ?>
            <img src="<?= htmlspecialchars($userPhoto) ?>" alt="User Avatar" class="w-6 h-6 rounded-full object-cover border border-blue-600 shrink-0"/>
            <span class="js-account-label font-bold text-slate-900"><?= htmlspecialchars(explode(' ', $userName)[0]) ?></span>
        <?php else: ?>
            <svg class="js-account-icon w-5 h-5 stroke-[2]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" stroke-linecap="round" stroke-linejoin="round"></path>
            </svg>
            <span class="js-account-label">Account</span>
        <?php endif; ?>
    </button>

    <!-- Dropdown Menu -->
    <div class="js-account-dropdown hidden absolute right-0 mt-2 w-56 bg-white rounded-xl shadow-lg border border-slate-100 py-2 z-50">
        
        <!-- Dropdown Header -->
        <div class="px-4 py-2 border-b border-slate-100">
            <p class="js-account-user-name text-xs font-bold text-slate-800"><?= htmlspecialchars($userName) ?></p>
            <p class="js-account-user-email text-[11px] text-slate-500 truncate"><?= htmlspecialchars($userEmail) ?></p>
        </div>

        <!-- Links -->
        <div class="py-1 text-xs font-medium text-slate-700">
            <?php if ($isLoggedIn): ?>
                <a href="users/dashboard.php" class="js-account-link block px-4 py-2 hover:bg-slate-50 hover:text-blue-600">Dashboard</a>
                <a href="users/dashboard.php" class="js-account-link flex items-center justify-between px-4 py-2 hover:bg-slate-50 hover:text-blue-600">
                    <span>My Orders</span>
                    <span class="bg-blue-100 text-blue-700 text-[10px] font-extrabold px-2 py-0.5 rounded-full"><?= $orderCount ?></span>
                </a>
                <a href="users/dashboard.php" class="js-account-link block px-4 py-2 hover:bg-slate-50 hover:text-blue-600">Settings</a>
            <?php else: ?>
                <a href="shop.php" class="js-account-link block px-4 py-2 hover:bg-slate-50 hover:text-blue-600">Browse Catalog</a>
                <a href="about.php" class="js-account-link block px-4 py-2 hover:bg-slate-50 hover:text-blue-600">About Us</a>
            <?php endif; ?>
        </div>

        <!-- Action Button -->
        <div class="border-t border-slate-100 pt-1 mt-1 px-2">
            <?php if ($isLoggedIn): ?>
                <button type="button" onclick="handleAccountLogout()" class="w-full text-center py-1.5 bg-red-50 text-red-600 rounded-lg text-xs font-semibold hover:bg-red-100 transition-colors">
                    Sign Out
                </button>
            <?php else: ?>
                <a href="login.php" class="js-account-auth-btn block text-center py-1.5 bg-blue-600 text-white rounded-lg text-xs font-semibold hover:bg-blue-700">Sign In</a>
            <?php endif; ?>
        </div>

    </div>

</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const toggle = document.querySelector('.js-account-toggle');
    const dropdown = document.querySelector('.js-account-dropdown');

    if (!toggle || !dropdown) return;

    toggle.addEventListener('click', (e) => {
        e.preventDefault();
        e.stopPropagation();
        dropdown.classList.toggle('hidden');
    });

    // Close dropdown when clicking outside
    document.addEventListener('click', (e) => {
        if (!dropdown.contains(e.target) && !toggle.contains(e.target)) {
            dropdown.classList.add('hidden');
        }
    });
});

async function handleAccountLogout() {
    const formData = new FormData();
    formData.append('action', 'logout');
    await fetch('login_process.php', { method: 'POST', body: formData });
    window.location.reload();
}
</script>