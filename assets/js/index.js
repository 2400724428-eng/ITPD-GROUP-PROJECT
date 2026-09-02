  
        document.addEventListener("DOMContentLoaded", function () {
            const menuBtn = document.getElementById('mobileMenuBtn');
            const desktopMenuBtn = document.getElementById('desktopMenuBtn');
            const closeBtn = document.getElementById('closeMenu');
            const mobileMenu = document.getElementById('mobileMenu');
            const menuOverlay = document.getElementById('menuOverlay');

            function toggleMenu() {
                mobileMenu.classList.toggle('active');
                menuOverlay.classList.toggle('active');
            }

            if (menuBtn) menuBtn.addEventListener('click', toggleMenu);
            if (desktopMenuBtn) desktopMenuBtn.addEventListener('click', toggleMenu);
            if (closeBtn) closeBtn.addEventListener('click', toggleMenu);
            if (menuOverlay) menuOverlay.addEventListener('click', toggleMenu);
        });
    