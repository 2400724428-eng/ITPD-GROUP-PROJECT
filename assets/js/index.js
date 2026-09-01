
  /* =====================================================
     MOBILE MENU
     ==================================================== */
  const mobileMenuBtn = document.getElementById("mobileMenuBtn");
  const mobileMenu = document.getElementById("mobileMenu");
  const closeMenu = document.getElementById("closeMenu");
  const menuOverlay = document.getElementById("menuOverlay");

  /* Open menu */
  mobileMenuBtn.addEventListener("click", function () {
    mobileMenu.classList.add("open");
    menuOverlay.classList.add("open");
    mobileMenuBtn.setAttribute("aria-expanded", "true");
    document.body.style.overflow = "hidden";
  });

  /* Close menu */
  function closeMobileMenu() {
    mobileMenu.classList.remove("open");
    menuOverlay.classList.remove("open");
    mobileMenuBtn.setAttribute("aria-expanded", "false");
    document.body.style.overflow = "";
  }

  closeMenu.addEventListener("click", closeMobileMenu);
  menuOverlay.addEventListener("click", closeMobileMenu);

  /* Close after clicking a menu link */
  document.querySelectorAll(".mobile-menu-links a").forEach(function (link) {
    link.addEventListener("click", closeMobileMenu);
  });

  /* Close menu with ESC */
  document.addEventListener("keydown", function (event) {
    if (event.key === "Escape") {
      closeMobileMenu();
    }
  });

  /* =====================================================
     HERO SLIDER
     ==================================================== */
  let slideIndex = 0;
  const slides = document.querySelectorAll(".slide");
  const dots = document.querySelectorAll(".dot");
  let slideTimer;

  function showSlide(index) {
    if (index >= slides.length) {
      slideIndex = 0;
    }
    if (index < 0) {
      slideIndex = slides.length - 1;
    }
    slides.forEach(function (slide) {
      slide.classList.remove("active");
    });
    dots.forEach(function (dot) {
      dot.classList.remove("active");
    });
    slides[slideIndex].classList.add("active");
    dots[slideIndex].classList.add("active");
  }

  function changeSlide(direction) {
    slideIndex += direction;
    showSlide(slideIndex);
    restartSlider();
  }

  function currentSlide(index) {
    slideIndex = index;
    showSlide(slideIndex);
    restartSlider();
  }

  function autoSlide() {
    slideIndex++;
    showSlide(slideIndex);
  }

  function restartSlider() {
    clearInterval(slideTimer);
    slideTimer = setInterval(autoSlide, 5000);
  }

  /* Start slider */
  showSlide(slideIndex);
  slideTimer = setInterval(autoSlide, 5000);

  /* =====================================================
     FLASH SALE COUNTDOWN
     ==================================================== */
  let remaining = (4 * 3600) + (18 * 60) + 52;
  const hh = document.getElementById("hh");
  const mm = document.getElementById("mm");
  const ss = document.getElementById("ss");

  const pad = function (number) {
    return String(number).padStart(2, "0");
  };

  setInterval(function () {
    remaining = remaining > 0 ? remaining - 1 : 0;
    hh.textContent = pad(Math.floor(remaining / 3600));
    mm.textContent = pad(Math.floor((remaining % 3600) / 60));
    ss.textContent = pad(remaining % 60);
  }, 1000);
