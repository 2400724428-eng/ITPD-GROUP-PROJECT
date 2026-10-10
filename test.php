<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="icon" type="image/png" href="assets/images/fav.png"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pure Gain</title>
    <link href="./src/output.css" rel="stylesheet">
</head>
<body class="bg-slate-50">

    <?php include 'includes/top.php'; ?>

    <!-- ================= MINIMAL DROPDOWN ARROW BAR ================= -->
    <div class="max-w-[1060px] w-full mx-auto px-4 sm:px-6 my-4" id="sdg3">
      
      <!-- Minimal Dropdown Button -->
      <button 
        onclick="toggleSdgDropdown()" 
        id="sdgBtn"
        class="flex items-center gap-2 text-slate-700 hover:text-blue-600 transition-colors py-2 text-sm font-semibold focus:outline-none cursor-pointer group">
        
        <!-- Small SDG 3 Badge -->
        <span class="w-5 h-5 rounded bg-blue-600 text-white font-bold text-[11px] flex items-center justify-center shrink-0">
          3
        </span>

        <span>SDG 3 – Good Health and Well-being</span>

        <!-- Small Dropdown Arrow Symbol (Rotates on click) -->
        <svg id="sdgArrow" class="w-4 h-4 text-slate-500 group-hover:text-blue-600 transition-transform duration-200 transform rotate-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7" />
        </svg>
      </button>

      <!-- Content (Hidden until dropdown arrow is clicked) -->
      <div id="sdgContent" class="hidden pt-3 pb-6 text-slate-600 text-sm leading-relaxed border-t border-slate-200 mt-1">
        <p class="max-w-3xl mb-4">
          Pure Gain contributes to <strong>SDG 3 – Good Health and Well-being</strong> by making quality fitness training, 
          nutrition guidance, and performance support more accessible. Regular physical activity and good nutrition help 
          prevent non-communicable diseases, improve mental well-being, and support healthier communities — especially 
          for young people and busy adults in Kampala and beyond.
        </p>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 my-4">
          <div class="bg-white p-4 rounded-lg border border-slate-200 shadow-sm">
            <h4 class="font-bold text-slate-900 mb-1">Physical Health</h4>
            <p class="text-xs text-slate-600">Structured training and strength programmes help reduce risk factors for heart disease, diabetes, and obesity.</p>
          </div>
          
          <div class="bg-white p-4 rounded-lg border border-slate-200 shadow-sm">
            <h4 class="font-bold text-slate-900 mb-1">Mental Well-being</h4>
            <p class="text-xs text-slate-600">Exercise and community classes support better mood, lower stress, improved sleep, and stronger social connections.</p>
          </div>

          <div class="bg-white p-4 rounded-lg border border-slate-200 shadow-sm">
            <h4 class="font-bold text-slate-900 mb-1">Accessible Support</h4>
            <p class="text-xs text-slate-600">Affordable membership plans, online coaching, and nutrition advice that works with local foods make healthy living more reachable.</p>
          </div>
        </div>

        <div class="flex items-center justify-between text-xs text-slate-500 pt-2">
          <span>This project is part of our school group contribution to the UN Sustainable Development Goals.</span>
          <a href="https://sdgs.un.org/goals/goal3" target="_blank" rel="noopener" class="text-blue-600 hover:underline font-medium">Learn more &rarr;</a>
        </div>
      </div>

    </div>
    <br> <br>

    <!-- PHP Content Below -->
    <?php include 'product/featured.php'; ?>
    <br><br>
    <?php include 'gymn/gymn.php'; ?>
    <?php include 'includes/bottom.php'; ?>

    <!-- Toggle Script -->
    <script>
      function toggleSdgDropdown() {
        const content = document.getElementById('sdgContent');
        const arrow = document.getElementById('sdgArrow');

        if (content.classList.contains('hidden')) {
          content.classList.remove('hidden');
          arrow.classList.add('rotate-180');
        } else {
          content.classList.add('hidden');
          arrow.classList.remove('rotate-180');
        }
      }
    </script>
</body>
</html>