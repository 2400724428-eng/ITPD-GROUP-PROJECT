<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>QuickCart - Seller Panel</title>
<!-- Tailwind CSS CDN with forms and container queries plugins -->
<link href="../src/output.css" rel="stylesheet">

<script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            brand: {
              50: '#eff6ff',
              100: '#dbeafe',
              500: '#3b82f6',
              600: '#2563eb',
              700: '#1d4ed8'
            }
          }
        }
      }
    }
  </script>
<style>
    body {
      background-color: #ffffff;
      color: #334155;
    }
    input::placeholder, textarea::placeholder {
      color: #94a3b8;
    }
    /* Simple fade/slide animation for screen switching */
    .screen-fade {
      animation: fadeIn 0.3s ease-in-out forwards;
    }
    @keyframes fadeIn {
      from {
        opacity: 0;
        transform: translateY(6px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }
  </style>
</head>
<body class="min-h-screen flex flex-col font-sans antialiased text-slate-800 bg-white">






<!-- SCREEN 1: ADD PRODUCT -->
    <div id="screen-add-product" class="screen-fade max-w-2xl">
      <h1 class="text-xl font-bold text-slate-900 mb-6">Add New Product</h1>
      <form action="#" class="space-y-6" method="POST" onsubmit="event.preventDefault(); alert('Product added successfully!');">
        <!-- Product Image Upload Section -->
        <div class="space-y-2">
          <label class="block text-sm font-medium text-slate-800">Product Image</label>
          <div class="flex items-center gap-3">
            <label class="w-20 h-20 sm:w-24 sm:h-24 border border-dashed border-slate-300 rounded-sm bg-[#fafafa] hover:bg-blue-50 hover:border-blue-400 cursor-pointer flex flex-col items-center justify-center transition-all group">
              <input accept="image/*" class="hidden" type="file"/>
              <svg class="w-7 h-7 text-slate-400 group-hover:text-blue-500 transition-colors mb-1" fill="currentColor" viewBox="0 0 24 24">
                <path d="M19.35 10.04C18.67 6.59 15.64 4 12 4 9.11 4 6.6 5.64 5.35 8.04 2.34 8.36 0 10.91 0 14c0 3.31 2.69 6 6 6h13c2.76 0 5-2.24 5-5 0-2.64-2.05-4.78-4.65-4.96zM14 13v4h-4v-4H7l5-5 5 5h-3z"></path>
              </svg>
              <span class="text-xs text-slate-500 group-hover:text-blue-600">Upload</span>
            </label>
            <label class="w-20 h-20 sm:w-24 sm:h-24 border border-dashed border-slate-300 rounded-sm bg-[#fafafa] hover:bg-blue-50 hover:border-blue-400 cursor-pointer flex flex-col items-center justify-center transition-all group">
              <input accept="image/*" class="hidden" type="file"/>
              <svg class="w-7 h-7 text-slate-400 group-hover:text-blue-500 transition-colors mb-1" fill="currentColor" viewBox="0 0 24 24">
                <path d="M19.35 10.04C18.67 6.59 15.64 4 12 4 9.11 4 6.6 5.64 5.35 8.04 2.34 8.36 0 10.91 0 14c0 3.31 2.69 6 6 6h13c2.76 0 5-2.24 5-5 0-2.64-2.05-4.78-4.65-4.96zM14 13v4h-4v-4H7l5-5 5 5h-3z"></path>
              </svg>
              <span class="text-xs text-slate-500 group-hover:text-blue-600">Upload</span>
            </label>
          </div>
        </div>

        <!-- Product Name Field -->
        <div class="space-y-1.5">
          <label class="block text-sm font-medium text-slate-800" for="product-name">Product Name</label>
          <input class="w-full rounded border-slate-300 px-3.5 py-2.5 text-sm text-slate-900 placeholder:text-slate-400 focus:border-blue-600 focus:ring-1 focus:ring-blue-600 transition" id="product-name" name="productName" placeholder="Type here" type="text"/>
        </div>

        <!-- Product Description Field -->
        <div class="space-y-1.5">
          <label class="block text-sm font-medium text-slate-800" for="product-description">Product Description</label>
          <textarea class="w-full rounded border-slate-300 px-3.5 py-2.5 text-sm text-slate-900 placeholder:text-slate-400 focus:border-blue-600 focus:ring-1 focus:ring-blue-600 transition resize-y" id="product-description" name="productDescription" placeholder="Type here" rows="4"></textarea>
        </div>

        <!-- Product Attributes Row 1: Category & Pricing -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 pt-1">
          <div class="space-y-1.5">
            <div class="flex justify-between items-center">
              <label class="block text-sm font-medium text-slate-800" for="product-category">Category</label>
              <button type="button" id="toggle-category-btn" onclick="toggleCategoryMode()" class="text-xs text-blue-600 hover:underline focus:outline-none">
                + Create New
              </button>
            </div>
            
            <!-- Select Existing Category -->
            <select id="product-category-select" class="w-full rounded border-slate-300 px-3 py-2 text-sm text-slate-800 bg-white focus:border-blue-600 focus:ring-1 focus:ring-blue-600 transition" name="category">
              <option selected="" value="earphone">Earphone[cite: 3]</option>
              <option value="headphone">Headphone[cite: 3]</option>
              <option value="smartwatch">Smart Watch[cite: 3]</option>
              <option value="electronics">Electronics[cite: 3]</option>
            </select>

            <!-- Input New Category (Hidden by default) -->
            <input type="text" id="product-category-input" name="newCategory" placeholder="Enter new category" class="hidden w-full rounded border-slate-300 px-3 py-2 text-sm text-slate-900 placeholder:text-slate-400 focus:border-blue-600 focus:ring-1 focus:ring-blue-600 transition" />
          </div>
          <div class="space-y-1.5">
            <label class="block text-sm font-medium text-slate-800" for="product-price">Product Price</label>
            <input oninput="calculateOfferPrice()" class="w-full rounded border-slate-300 px-3.5 py-2 text-sm text-slate-700 focus:border-blue-600 focus:ring-1 focus:ring-blue-600 transition" id="product-price" min="0" name="price" type="number" value="0"/>
          </div>
          <div class="space-y-1.5">
            <label class="block text-sm font-medium text-slate-800" for="offer-price">Offer Price (Calculated)</label>
            <input class="w-full rounded border-slate-300 px-3.5 py-2 text-sm text-slate-700 bg-slate-50 focus:border-blue-600 focus:ring-1 focus:ring-blue-600 transition" id="offer-price" min="0" name="offerPrice" type="number" value="0" readonly/>
          </div>
        </div>

        <!-- Product Attributes Row 2: Units, Deal Percentage, and Stock -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 pt-1">
          <!-- Units Selection Field -->
          <div class="space-y-1.5">
            <label class="block text-sm font-medium text-slate-800" for="product-unit">Unit Type</label>
            <select class="w-full rounded border-slate-300 px-3 py-2 text-sm text-slate-800 bg-white focus:border-blue-600 focus:ring-1 focus:ring-blue-600 transition" id="product-unit" name="unit">
              <option selected="" value="pieces">Pieces (pcs)</option>
              <option value="kgs">Kilograms (kgs)</option>
              <option value="grams">Grams (g)</option>
              <option value="liters">Liters (L)</option>
              <option value="bundles">Bundles</option>
              <option value="packets">Packets</option>
            </select>
          </div>

          <!-- Deal / Discount Percentage Field -->
          <div class="space-y-1.5">
            <label class="block text-sm font-medium text-slate-800" for="product-deal">Deal / Discount (%)</label>
            <div class="relative">
              <input oninput="calculateOfferPrice()" class="w-full rounded border-slate-300 px-3.5 py-2 text-sm text-slate-700 focus:border-blue-600 focus:ring-1 focus:ring-blue-600 transition pr-8" id="product-deal" min="0" max="100" name="discountPercentage" type="number" placeholder="e.g. 10" value="0"/>
              <span class="absolute right-3 top-2.5 text-xs text-slate-400 font-medium">%</span>
            </div>
          </div>

          <!-- Number in Stock Field -->
          <div class="space-y-1.5">
            <label class="block text-sm font-medium text-slate-800" for="product-stock">Number in Stock</label>
            <input class="w-full rounded border-slate-300 px-3.5 py-2 text-sm text-slate-700 focus:border-blue-600 focus:ring-1 focus:ring-blue-600 transition" id="product-stock" min="0" name="stockQuantity" type="number" value="10"/>
          </div>
        </div>

        <!-- Submit Button -->
        <div class="pt-2">
          <button class="px-8 py-2.5 bg-blue-600 hover:bg-blue-700 active:bg-blue-800 text-white font-medium text-sm rounded shadow-sm hover:shadow transition-all tracking-wide uppercase" type="submit">
            ADD PRODUCT
          </button>
        </div>
      </form>
    </div>

    <!-- JavaScript for Category Toggle and Auto-calculating Offer Price -->
    <script>
      function toggleCategoryMode() {
        const selectEl = document.getElementById('product-category-select');
        const inputEl = document.getElementById('product-category-input');
        const btnEl = document.getElementById('toggle-category-btn');

        if (selectEl.classList.contains('hidden')) {
          selectEl.classList.remove('hidden');
          inputEl.classList.add('hidden');
          inputEl.value = '';
          btnEl.textContent = '+ Create New';
        } else {
          selectEl.classList.add('hidden');
          inputEl.classList.remove('hidden');
          inputEl.focus();
          btnEl.textContent = 'Select Existing';
        }
      }

      function calculateOfferPrice() {
        const price = parseFloat(document.getElementById('product-price').value) || 0;
        const discount = parseFloat(document.getElementById('product-deal').value) || 0;
        
        let offerPrice = price - (price * (discount / 100));
        if (offerPrice < 0) offerPrice = 0;
        
        // Update the offer price field with up to 2 decimal places if needed
        document.getElementById('offer-price').value = offerPrice.toFixed(2);
      }
    </script>


















 

 
 
 
 
 
 
 
 


















    
</body>