<?php
// Define product database with corresponding details and catalog images
$products = [
    1 => [
        "name" => "Apex Platinum Whey Isolate",
        "price" => "UGX 185,000",
        "old_price" => "UGX 210,000",
        "rating" => "4.9",
        "description" => "25g Ultra-Pure Protein per serving with zero sugar formulation. Designed for rapid muscle recovery, lean tissue growth, and ultimate post-workout nutrition without unwanted fats or carbs.",
        "category" => "Whey Protein Isolate",
        "brand" => "ApexFit",
        "image" => "https://images.unsplash.com/photo-1546483875-ad9014c88eba?auto=format&fit=crop&w=600&q=80"
    ],
    2 => [
        "name" => "Pure Creatine Monohydrate",
        "price" => "UGX 115,000",
        "old_price" => "UGX 135,000",
        "rating" => "4.8",
        "description" => "Micronized powder for explosive strength and muscle mass gains. Ultrafine particles mix effortlessly with water or juice to maximize cellular hydration and ATP regeneration during heavy lifting sessions.",
        "category" => "Creatine & Pre-Workouts",
        "brand" => "ApexFit",
        "image" => "https://images.unsplash.com/photo-1579722821273-0f6c7d44362f?auto=format&fit=crop&w=600&q=80"
    ],
    3 => [
        "name" => "Vortex Pre-Workout Blast",
        "price" => "UGX 135,000",
        "old_price" => "UGX 155,000",
        "rating" => "4.7",
        "description" => "Intense mental focus, massive pumps, and jitter-free energy matrix. Formulated with performance enhancers to power through high-intensity training blocks with peak endurance.",
        "category" => "Creatine & Pre-Workouts",
        "brand" => "ApexFit",
        "image" => "https://images.unsplash.com/photo-1584735935682-2f2b69dff9d2?auto=format&fit=crop&w=600&q=80"
    ],
    4 => [
        "name" => "Titan Mass Gainer 1000",
        "price" => "UGX 220,000",
        "old_price" => "UGX 250,000",
        "rating" => "4.6",
        "description" => "High-calorie formula designed for hardgainers and rapid size buildup. Packed with complex carbohydrates, quality proteins, and essential nutrients to support massive mass gains.",
        "category" => "Mass Gainers",
        "brand" => "ApexFit",
        "image" => "https://images.unsplash.com/photo-1576678927484-cc907957088c?auto=format&fit=crop&w=600&q=80"
    ],
    5 => [
        "name" => "BCAA 2:1:1 Recovery Matrix",
        "price" => "UGX 95,000",
        "old_price" => "UGX 110,000",
        "rating" => "4.8",
        "description" => "Electrolyte-infused amino acids designed to eliminate muscle soreness and optimize hydration during intense workouts. Protects lean muscle tissue against catabolic breakdown.",
        "category" => "Amino Acids & BCAAs",
        "brand" => "ApexFit",
        "image" => "https://images.unsplash.com/photo-1517838277536-f5f99be501cd?auto=format&fit=crop&w=600&q=80"
    ],
    6 => [
        "name" => "Pure L-Glutamine Powder",
        "price" => "UGX 85,000",
        "old_price" => "UGX 99,000",
        "rating" => "4.5",
        "description" => "Supports deep muscle tissue repair and reinforces immune health following grueling exercise sessions. Unflavored formula easily stacks into your favorite post-workout shake.",
        "category" => "Amino Acids & BCAAs",
        "brand" => "ApexFit",
        "image" => "https://images.unsplash.com/photo-1594882645126-14020914d58d?auto=format&fit=crop&w=600&q=80"
    ],
    7 => [
        "name" => "ThermoShred Pro Capsules",
        "price" => "UGX 125,000",
        "old_price" => "UGX 145,000",
        "rating" => "4.7",
        "description" => "Advanced thermogenic formula for accelerated fat loss and definition. Boosts metabolic rate, increases daily caloric burn, and provides sustained clean energy throughout the day.",
        "category" => "Fat Burners & Energy",
        "brand" => "ApexFit",
        "image" => "https://images.unsplash.com/photo-1550572017-edd951b55104?auto=format&fit=crop&w=600&q=80"
    ],
    8 => [
        "name" => "Omega-3 Triple Strength",
        "price" => "UGX 75,000",
        "old_price" => "UGX 90,000",
        "rating" => "4.9",
        "description" => "High-potency fish oil for advanced joint health and cardiovascular support. Purified to eliminate heavy metals and fishy aftertaste while delivering essential fatty acids.",
        "category" => "Wellness & Joints",
        "brand" => "ApexFit",
        "image" => "https://images.unsplash.com/photo-1584308666744-24d5c474f2ae?auto=format&fit=crop&w=600&q=80"
    ]
];

// Get requested product ID from URL query parameters (default to ID 1 if missing or invalid)
$product_id = isset($_GET['id']) && isset($products[(int)$_GET['id']]) ? (int)$_GET['id'] : 1;
$product = $products[$product_id];
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta content="width=device-width, initial-scale=1.0" name="viewport">
<title><?php echo htmlspecialchars($product['name']); ?> - ApexFit</title>
<!-- Tailwind CSS CDN with forms and container queries plugins -->
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<!-- Google Fonts: Inter -->
<link href="https://fonts.googleapis.com" rel="preconnect">
<link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&amp;display=swap" rel="stylesheet">
<!-- Font Awesome Icons -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet"/>
<script>
    tailwind.config = {
      theme: {
        extend: {
          fontFamily: {
            sans: ['Inter', 'sans-serif'],
          },
          colors: {
            brand: {
              charcoal: '#2e3a47',
              orange: '#f26513',
              orangeHover: '#e0590a',
              star: '#ff5c26',
              softGray: '#f0f3f6',
              lightBorder: '#e6ebf0',
              textMuted: '#677484',
            }
          }
        }
      }
    }
  </script>
<style data-purpose="custom-styling">
    body {
      font-family: 'Inter', sans-serif;
      -webkit-font-smoothing: antialiased;
      background-color: #ffffff;
    }
  </style>
</head>
<body class="bg-white min-h-screen text-[#2e3a47] flex flex-col justify-between p-4 sm:p-6 md:p-10 lg:p-16 overflow-x-hidden selection:bg-orange-100">

<!-- Navigation Back Link -->
<div class="max-w-7xl mx-auto w-full px-2 sm:px-4 md:px-6 mb-6">
  <a href="../" class="inline-flex items-center gap-2 text-sm font-semibold text-slate-600 hover:text-[#f26513] transition-colors">
    <i class="fa-solid fa-arrow-left"></i> Back to Catalog
  </a>
</div>

<!-- BEGIN: ProductDetailSection -->
<main class="w-full max-w-7xl mx-auto px-2 sm:px-4 md:px-6 my-auto" data-purpose="product-showcase">
  <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 md:gap-12 lg:gap-16 items-start w-full">
    
    <!-- BEGIN: ProductMediaGallery -->
    <!-- Left Column: Main View & Thumbnails -->
    <section aria-label="Product Media Gallery" class="w-full lg:col-span-6 xl:col-span-5 flex flex-col gap-4 min-w-0">
      <!-- Main Image Container -->
      <div class="relative w-full aspect-square bg-[#f2f4f7] rounded-xl overflow-hidden flex items-center justify-center p-6 shadow-sm" data-purpose="main-image-viewer">
        <div class="relative w-full h-full flex items-center justify-center overflow-hidden">
          <img alt="<?php echo htmlspecialchars($product['name']); ?>" class="max-h-[85%] max-w-[85%] object-contain mix-blend-multiply drop-shadow-lg select-none pointer-events-none" src="<?php echo htmlspecialchars($product['image']); ?>">
        </div>
      </div>
      <!-- Thumbnail Selector List -->
      <div class="flex flex-wrap items-center gap-3 pt-1" data-purpose="thumbnail-gallery">
        <button aria-label="View product angle" class="w-16 h-16 rounded-xl bg-[#f2f4f7] border-2 border-[#f26513] focus:outline-none overflow-hidden flex items-center justify-center relative transition-all shadow-sm" type="button">
          <img alt="Thumbnail" class="max-h-[80%] max-w-[80%] object-contain mix-blend-multiply" src="<?php echo htmlspecialchars($product['image']); ?>">
        </button>
      </div>
    </section>
    <!-- END: ProductMediaGallery -->

    <!-- BEGIN: ProductPurchaseDetails -->
    <!-- Right Column: Title, Ratings, Details, Specs & CTAs -->
    <section aria-label="Product Details and Actions" class="w-full lg:col-span-6 xl:col-span-7 flex flex-col justify-start min-w-0">
      
      <!-- Product Title -->
      <h1 class="text-2xl sm:text-3xl md:text-4xl lg:text-5xl font-bold tracking-tight text-[#2d3a4b] mb-3 break-words" data-purpose="product-title">
        <?php echo htmlspecialchars($product['name']); ?>
      </h1>

      <!-- Rating Stars & Score -->
      <div class="flex items-center gap-2 mb-4" data-purpose="review-rating">
        <div aria-label="Rating: <?php echo htmlspecialchars($product['rating']); ?> out of 5 stars" class="flex items-center text-[#f26513] space-x-0.5">
          <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
          <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
          <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
          <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
          <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
        </div>
        <span class="text-sm font-medium text-[#4b5563] ml-1">(<?php echo htmlspecialchars($product['rating']); ?>)</span>
      </div>

      <!-- Product Description -->
      <p class="text-[0.97rem] leading-relaxed text-[#516173] mb-6 font-normal" data-purpose="product-description">
        <?php echo htmlspecialchars($product['description']); ?>
      </p>

      <!-- Pricing Block -->
      <div class="flex flex-wrap items-baseline gap-2.5 sm:gap-3 mb-6" data-purpose="pricing-block">
        <span class="text-3xl font-extrabold text-[#24303e] tracking-tight"><?php echo htmlspecialchars($product['price']); ?></span>
        <span class="text-sm font-medium text-[#8492a6] line-through"><?php echo htmlspecialchars($product['old_price']); ?></span>
      </div>

      <!-- Subtle Divider -->
      <hr class="border-t border-[#edf1f5] mb-6">

      <!-- Product Specifications / Key-Value Details -->
      <div class="grid grid-cols-[110px_1fr] sm:grid-cols-[130px_1fr] gap-y-2.5 text-sm mb-10" data-purpose="specs-table">
        <span class="font-bold text-[#374758]">Brand</span>
        <span class="text-[#728294] font-normal"><?php echo htmlspecialchars($product['brand']); ?></span>
        <span class="font-bold text-[#374758]">Category</span>
        <span class="text-[#728294] font-normal"><?php echo htmlspecialchars($product['category']); ?></span>
        <span class="font-bold text-[#374758]">Stock Status</span>
        <span class="text-emerald-600 font-semibold">In Stock & Ready</span>
      </div>

      <!-- Bottom Action CTA Buttons -->
      <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-4 w-full sm:max-w-md pt-2" data-purpose="cta-buttons">
        <button class="w-full py-3.5 px-6 rounded-md bg-[#f2f4f7] hover:bg-[#e7ebf0] active:bg-[#dde2e8] text-[#334155] font-semibold text-sm transition-colors text-center focus:outline-none focus:ring-2 focus:ring-slate-300" type="button">
          Add to Cart
        </button>
        <a href="https://wa.me/?text=Hello%20ApexFit,%20I%20want%20to%20buy%20<?php echo urlencode($product['name']); ?>%20for%20<?php echo urlencode($product['price']); ?>" target="_blank" class="w-full py-3.5 px-6 rounded-md bg-[#f26513] hover:bg-[#de5b0e] active:bg-[#ca510a] text-white font-semibold text-sm transition-colors text-center shadow-sm focus:outline-none focus:ring-2 focus:ring-orange-400 focus:ring-offset-2 inline-block">
          Buy via WhatsApp
        </a>
      </div>

    </section>
    <!-- END: ProductPurchaseDetails -->

  </div>
</main>
<!-- END: ProductDetailSection -->

</body>
</html>