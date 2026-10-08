<!-- Wrapper Container -->
<div class="js-account-container relative">

    <!-- Trigger Link -->

    <!-- Dropdown Menu -->
    <div class="js-account-dropdown hidden absolute right-0 mt-2 w-56 bg-white rounded-xl shadow-lg border border-slate-100 py-2 z-50">
        
        <!-- Dropdown Header -->
        <div class="px-4 py-2 border-b border-slate-100">
            <p class="js-account-user-name text-xs font-bold text-slate-800">Guest User</p>
            <p class="js-account-user-email text-[11px] text-slate-500 truncate">Sign in to manage portal</p>
        </div>

        <!-- Links -->
        <div class="py-1 text-xs font-medium text-slate-700">
            <a href="portal/dashboard.html" class="js-account-link block px-4 py-2 hover:bg-slate-50 hover:text-blue-600">Dashboard</a>
            <a href="portal/orders.html" class="js-account-link block px-4 py-2 hover:bg-slate-50 hover:text-blue-600">My Orders</a>
            <a href="portal/settings.html" class="js-account-link block px-4 py-2 hover:bg-slate-50 hover:text-blue-600">Settings</a>
        </div>

        <!-- Action Button -->
        <div class="border-t border-slate-100 pt-1 mt-1 px-2">
            <a href="portal/login.html" class="js-account-auth-btn block text-center py-1.5 bg-blue-600 text-white rounded-lg text-xs font-semibold hover:bg-blue-700">Sign In</a>
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

</script>