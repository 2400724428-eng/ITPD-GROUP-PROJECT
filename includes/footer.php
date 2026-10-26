<!-- ==================== PROFESSIONAL MATCHING FOOTER ==================== -->
<footer class="bg-slate-50 font-sans pt-16 pb-8 mt-auto">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-8 lg:gap-10 mb-12">
      
      <!-- Column 1: Brand & Socials (Spans 2 columns on large screens) -->
      <div class="lg:col-span-2 space-y-6 pt-1">
        <a href="index.php" class="inline-block">
          <img src="assets/images/fav.png" alt="PURE GAIN" class="h-12 w-auto object-contain" />
        </a>
        <p class="text-sm text-slate-500 leading-relaxed max-w-sm">
          Fuel your body with premium supplements. We provide the best fitness gear and nutrition to help you achieve your ultimate goals.
        </p>
        <div class="flex items-center gap-3">
          <a href="#" class="w-10 h-10 rounded-full bg-white border border-slate-200 text-slate-500 flex items-center justify-center hover:bg-blue-600 hover:border-blue-600 hover:text-white transition-all shadow-sm">
            <i class="fa-brands fa-facebook-f text-sm"></i>
          </a>
          <a href="#" class="w-10 h-10 rounded-full bg-white border border-slate-200 text-slate-500 flex items-center justify-center hover:bg-blue-600 hover:border-blue-600 hover:text-white transition-all shadow-sm">
            <i class="fa-brands fa-instagram text-sm"></i>
          </a>
          <a href="#" class="w-10 h-10 rounded-full bg-white border border-slate-200 text-slate-500 flex items-center justify-center hover:bg-blue-700 hover:border-blue-700 hover:text-white transition-all shadow-sm">
            <i class="fa-brands fa-linkedin-in text-sm"></i>
          </a>
          <a href="#" class="w-10 h-10 rounded-full bg-white border border-slate-200 text-slate-500 flex items-center justify-center hover:bg-green-600 hover:border-green-600 hover:text-white transition-all shadow-sm">
            <i class="fa-brands fa-whatsapp text-sm"></i>
          </a>
        </div>
      </div>

      <!-- Column 2: Shop & Explore -->
      <div>
        <h3 class="text-sm font-bold text-slate-900 uppercase tracking-widest mb-5">Shop & Explore</h3>
        <ul class="space-y-3.5 text-sm font-medium">
          <li><a href="shop.php" class="text-slate-500 hover:text-blue-600 transition-colors">Supplements Store</a></li>
          <li><a href="trainer-dashboard.php" class="text-slate-500 hover:text-blue-600 transition-colors">Join Training</a></li>
          <li><a href="about.php" class="text-slate-500 hover:text-blue-600 transition-colors">About Us</a></li>
          <li><a href="contact.php" class="text-slate-500 hover:text-blue-600 transition-colors">Contact Us</a></li>
        </ul>
      </div>

      <!-- Column 3: Customer Care (Added Help Desk, FAQ, How to Order) -->
      <div>
        <h3 class="text-sm font-bold text-slate-900 uppercase tracking-widest mb-5">Customer Care</h3>
        <ul class="space-y-3.5 text-sm font-medium">
          <li><a href="help-desk.php" class="text-slate-500 hover:text-blue-600 transition-colors">Help Desk</a></li>
          <li><a href="faq.php" class="text-slate-500 hover:text-blue-600 transition-colors">FAQ</a></li>
          <li><a href="how-to-order.php" class="text-slate-500 hover:text-blue-600 transition-colors">How to Order</a></li>
          <li><a href="dashboard.php" class="text-slate-500 hover:text-blue-600 transition-colors">My Account</a></li>
        </ul>
      </div>

      <!-- Column 4: Get In Touch -->
      <div>
        <h3 class="text-sm font-bold text-slate-900 uppercase tracking-widest mb-5">Get In Touch</h3>
        <ul class="space-y-4 text-sm font-medium text-slate-500">
          <li class="flex items-start gap-3">
            <div class="w-8 h-8 rounded-full bg-white border border-slate-200 flex items-center justify-center shrink-0 shadow-sm mt-0.5">
              <i class="fa-solid fa-phone text-blue-500 text-xs"></i>
            </div>
            <span class="pt-1.5">+256 761 448 094</span>
          </li>
          <li class="flex items-start gap-3">
            <div class="w-8 h-8 rounded-full bg-white border border-slate-200 flex items-center justify-center shrink-0 shadow-sm mt-0.5">
              <i class="fa-solid fa-envelope text-blue-500 text-xs"></i>
            </div>
            <span class="pt-1.5">support@puregain.com</span>
          </li>
          <li class="flex items-start gap-3">
            <div class="w-8 h-8 rounded-full bg-white border border-slate-200 flex items-center justify-center shrink-0 shadow-sm mt-0.5">
              <i class="fa-solid fa-location-dot text-blue-500 text-xs"></i>
            </div>
            <span class="pt-1.5">Kampala, Uganda<br>Plot 12 Jinja Road</span>
          </li>
        </ul>
      </div>

    </div>
  </div>

  <!-- Bottom Bar -->
  <div class="pt-8 pb-2">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row items-center justify-between gap-4 text-xs font-medium text-slate-400 border-t border-slate-200/60 pt-6">
      <p>&copy; <?= date('Y') ?> PURE GAIN SUPPLEMENTS. All rights reserved.</p>
      
      <!-- Added Privacy & Terms links to the bottom bar -->
      <div class="flex items-center gap-6">
        <a href="privacy-policy.php" class="hover:text-slate-900 transition-colors">Privacy Policy</a>
        <a href="terms-of-service.php" class="hover:text-slate-900 transition-colors">Terms of Service</a>
      </div>
    </div>
  </div>
</footer>