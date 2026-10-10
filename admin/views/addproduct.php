<?php
// Step out of views/ and admin/ to reach root includes/db_connect.php
require_once __DIR__ . '/../../includes/db_connect.php';

$message = '';$messageType = '';

// Check if redirected after successful product addition
if (isset($_GET['status']) &&$_GET['status'] === 'added') {
    $message = 'Product added successfully!';$messageType = 'success';
}

// 1. Fetch Existing Categories dynamically from the 'categories' table
try {
    $categoryStmt =$pdo->query("SELECT name FROM categories ORDER BY name ASC");
    $existingCategories =$categoryStmt->fetchAll(PDO::FETCH_COLUMN);
} catch (\PDOException $e) {
    try {
        $categoryStmt =$pdo->query("SELECT DISTINCT category FROM products WHERE category IS NOT NULL AND category != '' ORDER BY category ASC");
        $existingCategories =$categoryStmt->fetchAll(PDO::FETCH_COLUMN);
    } catch (\PDOException $ex) {$existingCategories = [];
    }
}

if (empty($existingCategories)) {$existingCategories = ['Earphone', 'Headphone', 'Smart Watch', 'Electronics', 'Supplements'];
}

// 2. Process Form Submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Automatic Upload Directory Creation
    $uploadDir = __DIR__ . '/../../uploads/products/';
    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    // Helper Function for File Uploads
    function processUpload($fileKey,$targetDir) {
        if (isset($_FILES[$fileKey]) && $_FILES[$fileKey]['error'] === UPLOAD_ERR_OK) {
            $extension = strtolower(pathinfo($_FILES[$fileKey]['name'], PATHINFO_EXTENSION));$allowed = ['jpg', 'jpeg', 'png', 'webp', 'gif'];

            if (in_array($extension,$allowed)) {
                $filename = uniqid('prod_', true) . '.' .$extension;
                $destination = $targetDir .$filename;

                if (move_uploaded_file($_FILES[$fileKey]['tmp_name'],$destination)) {
                    return 'uploads/products/' . $filename;
                }
            }
        }
        return null;
    }

    $imagePrimary   = processUpload('imagePrimary',$uploadDir);
    $imageSecondary = processUpload('imageSecondary',$uploadDir);

    // Capture Form Inputs
    $productName        = trim($_POST['productName'] ?? '');
    $productDescription = trim($_POST['productDescription'] ?? '');
    
    $newCategory        = trim($_POST['newCategory'] ?? '');
    $selectedCategory   = trim($_POST['category'] ?? '');

    if (!empty($newCategory)) {
        $category =$newCategory;
        try {
            $catCheck =$pdo->prepare("INSERT IGNORE INTO categories (name) VALUES (:name)");
            $catCheck->execute([':name' =>$newCategory]);
        } catch (\PDOException $e) {
            error_log('Category Insert Error: ' . $e->getMessage());
        }
    } else {
        $category = !empty($selectedCategory) ?$selectedCategory : 'General';
    }
    
    $productPrice       = (float)($_POST['price'] ?? 0);
    $discountPercentage = (float)($_POST['discountPercentage'] ?? 0);
    $unitType           = trim($_POST['unit'] ?? 'Pieces (pcs)');
    $stockQuantity      = (int)($_POST['stockQuantity'] ?? 0);

    // Calculate Offer Price in UGX (rounded to integer)
    $offerPrice =$productPrice - ($productPrice * ($discountPercentage / 100));
    if ($offerPrice < 0)$offerPrice = 0;
    $offerPrice = round($offerPrice);

    // Validation
   if (empty($productName) || $productPrice <= 0) {
        $message = 'Please provide a valid product name and price.';$messageType = 'error';
    } else {
        try {
            $sql = "INSERT INTO products (
                        product_name, product_description, category, 
                        product_price, offer_price, discount_percentage, unit_type, 
                        number_in_stock, image_primary, image_secondary
                    ) VALUES (
                        :name, :desc, :category, 
                        :price, :offer_price, :discount, :unit, 
                        :stock, :img1, :img2
                    )";

            $stmt =$pdo->prepare($sql);$stmt->execute([
                ':name'        => $productName,
                ':desc'        => $productDescription,
                ':category'    => $category,
                ':price'       => $productPrice,
                ':offer_price' => $offerPrice,
                ':discount'    => $discountPercentage,
                ':unit'        => $unitType,
                ':stock'       => $stockQuantity,
                ':img1'        => $imagePrimary,
                ':img2'        => $imageSecondary
            ]);

            // Clean header redirect
            header("Location: dashboard.php?view=add_product&status=added");
            exit;

        } catch (\PDOException $e) {
            error_log('Insert Product Error: ' . $e->getMessage());
            $message = 'Database error while adding product.';$messageType = 'error';
        }
    }
}
?>

<!-- SCREEN 1: ADD PRODUCT -->
<div id="screen-add-product" class="screen-fade max-w-2xl mt-8">
  <h1 class="text-xl font-bold text-slate-900 mb-6">Add New Product</h1>

  <?php if (!empty($message)): ?>
    <div id="status-alert" class="mb-6 p-4 rounded text-sm font-medium flex items-center justify-between transition-all duration-300 <?= $messageType === 'success' ? 'bg-green-50 text-green-700 border border-green-200' : 'bg-rose-50 text-rose-700 border border-rose-200' ?>">
      <span><?= htmlspecialchars($message) ?></span>
      <button type="button" onclick="dismissAlert()" class="text-xs font-bold px-2 py-1 hover:opacity-75 focus:outline-none">&times;</button>
    </div>
  <?php endif; ?>

  <form action="" method="POST" enctype="multipart/form-data" class="space-y-6">
    <!-- Product Image Upload Section -->
    <div class="space-y-2">
      <label class="block text-sm font-medium text-slate-800">Product Image</label>
      <div class="flex items-center gap-3">
        <!-- Primary Image Slot -->
        <label class="relative w-20 h-20 sm:w-24 sm:h-24 border border-dashed border-slate-300 rounded-sm bg-[#fafafa] hover:bg-blue-50 hover:border-blue-400 cursor-pointer flex flex-col items-center justify-center transition-all group overflow-hidden">
          <input accept="image/*" class="hidden" type="file" name="imagePrimary" id="input-img-primary" onchange="previewImage(this, 'preview-img-primary', 'placeholder-primary')"/>
          <img id="preview-img-primary" class="hidden absolute inset-0 w-full h-full object-cover" alt="Primary Preview" />
          <div id="placeholder-primary" class="flex flex-col items-center justify-center">
            <svg class="w-7 h-7 text-slate-400 group-hover:text-blue-500 transition-colors mb-1" fill="currentColor" viewBox="0 0 24 24">
              <path d="M19.35 10.04C18.67 6.59 15.64 4 12 4 9.11 4 6.6 5.64 5.35 8.04 2.34 8.36 0 10.91 0 14c0 3.31 2.69 6 6 6h13c2.76 0 5-2.24 5-5 0-2.64-2.05-4.78-4.65-4.96zM14 13v4h-4v-4H7l5-5 5 5h-3z"></path>
            </svg>
            <span class="text-xs text-slate-500 group-hover:text-blue-600">Upload</span>
          </div>
        </label>

        <!-- Secondary Image Slot -->
        <label class="relative w-20 h-20 sm:w-24 sm:h-24 border border-dashed border-slate-300 rounded-sm bg-[#fafafa] hover:bg-blue-50 hover:border-blue-400 cursor-pointer flex flex-col items-center justify-center transition-all group overflow-hidden">
          <input accept="image/*" class="hidden" type="file" name="imageSecondary" id="input-img-secondary" onchange="previewImage(this, 'preview-img-secondary', 'placeholder-secondary')"/>
          <img id="preview-img-secondary" class="hidden absolute inset-0 w-full h-full object-cover" alt="Secondary Preview" />
          <div id="placeholder-secondary" class="flex flex-col items-center justify-center">
            <svg class="w-7 h-7 text-slate-400 group-hover:text-blue-500 transition-colors mb-1" fill="currentColor" viewBox="0 0 24 24">
              <path d="M19.35 10.04C18.67 6.59 15.64 4 12 4 9.11 4 6.6 5.64 5.35 8.04 2.34 8.36 0 10.91 0 14c0 3.31 2.69 6 6 6h13c2.76 0 5-2.24 5-5 0-2.64-2.05-4.78-4.65-4.96zM14 13v4h-4v-4H7l5-5 5 5h-3z"></path>
            </svg>
            <span class="text-xs text-slate-500 group-hover:text-blue-600">Upload</span>
          </div>
        </label>
      </div>
    </div>

    <!-- Product Name Field -->
    <div class="space-y-1.5">
      <label class="block text-sm font-medium text-slate-800" for="product-name">Product Name</label>
      <input required class="w-full rounded border border-slate-300 px-3.5 py-2.5 text-sm text-slate-900 placeholder:text-slate-400 focus:border-blue-600 focus:ring-1 focus:ring-blue-600 transition" id="product-name" name="productName" placeholder="Type here" type="text"/>
    </div>

    <!-- Product Description Field -->
    <div class="space-y-1.5">
      <label class="block text-sm font-medium text-slate-800" for="product-description">Product Description</label>
      <textarea class="w-full rounded border border-slate-300 px-3.5 py-2.5 text-sm text-slate-900 placeholder:text-slate-400 focus:border-blue-600 focus:ring-1 focus:ring-blue-600 transition resize-y" id="product-description" name="productDescription" placeholder="Type here" rows="4"></textarea>
    </div>

    <!-- Product Attributes Row 1: Category & Pricing -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 pt-1">
      <div class="space-y-1.5">
        <div class="flex justify-between items-center">
          <label class="block text-sm font-medium text-slate-800" for="product-category">Category</label>
          <div class="flex gap-2">
            <button type="button" id="toggle-category-btn" onclick="toggleCategoryMode()" class="text-xs text-blue-600 hover:underline focus:outline-none">
              + Create New
            </button>
            <button type="button" id="delete-category-btn" onclick="deleteSelectedCategory()" class="text-xs text-rose-600 hover:underline focus:outline-none">
              Delete
            </button>
          </div>
        </div>
        
        <!-- Select Existing Category -->
        <select id="product-category-select" class="w-full rounded border border-slate-300 px-3 py-2 text-sm text-slate-800 bg-white focus:border-blue-600 focus:ring-1 focus:ring-blue-600 transition" name="category">
          <?php foreach ($existingCategories as$cat): ?>
            <option value="<?= htmlspecialchars($cat) ?>"><?= htmlspecialchars($cat) ?></option>
          <?php endforeach; ?>
        </select>

        <!-- Input New Category -->
        <input type="text" id="product-category-input" name="newCategory" placeholder="Enter new category" class="hidden w-full rounded border border-slate-300 px-3 py-2 text-sm text-slate-900 placeholder:text-slate-400 focus:border-blue-600 focus:ring-1 focus:ring-blue-600 transition" />
      </div>

      <div class="space-y-1.5">
        <label class="block text-sm font-medium text-slate-800" for="product-price">Product Price (UGX)</label>
        <input oninput="calculateOfferPrice()" class="w-full rounded border border-slate-300 px-3.5 py-2 text-sm text-slate-700 focus:border-blue-600 focus:ring-1 focus:ring-blue-600 transition" id="product-price" min="0" step="1" name="price" type="number" value="0" placeholder="e.g. 50000"/>
      </div>

      <div class="space-y-1.5">
        <label class="block text-sm font-medium text-slate-800" for="offer-price">Offer Price (UGX)</label>
        <input class="w-full rounded border border-slate-300 px-3.5 py-2 text-sm text-slate-700 bg-slate-50 focus:border-blue-600 focus:ring-1 focus:ring-blue-600 transition" id="offer-price" min="0" step="1" name="offerPrice" type="number" value="0" readonly/>
      </div>
    </div>

    <!-- Product Attributes Row 2: Units, Deal Percentage, and Stock -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 pt-1">
      <div class="space-y-1.5">
        <label class="block text-sm font-medium text-slate-800" for="product-unit">Unit Type</label>
        <select class="w-full rounded border border-slate-300 px-3 py-2 text-sm text-slate-800 bg-white focus:border-blue-600 focus:ring-1 focus:ring-blue-600 transition" id="product-unit" name="unit">
          <option selected value="Pieces (pcs)">Pieces (pcs)</option>
          <option value="Kilograms (kgs)">Kilograms (kgs)</option>
          <option value="Grams (g)">Grams (g)</option>
          <option value="Liters (L)">Liters (L)</option>
          <option value="Bundles">Bundles</option>
          <option value="Packets">Packets</option>
        </select>
      </div>

      <div class="space-y-1.5">
        <label class="block text-sm font-medium text-slate-800" for="product-deal">Deal / Discount (%)</label>
        <div class="relative">
          <input oninput="calculateOfferPrice()" class="w-full rounded border border-slate-300 px-3.5 py-2 text-sm text-slate-700 focus:border-blue-600 focus:ring-1 focus:ring-blue-600 transition pr-8" id="product-deal" min="0" max="100" step="0.01" name="discountPercentage" type="number" placeholder="e.g. 10" value="0"/>
          <span class="absolute right-3 top-2.5 text-xs text-slate-400 font-medium">%</span>
        </div>
      </div>

      <div class="space-y-1.5">
        <label class="block text-sm font-medium text-slate-800" for="product-stock">Number in Stock</label>
        <input class="w-full rounded border border-slate-300 px-3.5 py-2 text-sm text-slate-700 focus:border-blue-600 focus:ring-1 focus:ring-blue-600 transition" id="product-stock" min="0" name="stockQuantity" type="number" value="10"/>
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

<!-- JavaScript Controls -->
<script>
  function dismissAlert() {
    const alert = document.getElementById('status-alert');
    if (alert) {
      alert.style.opacity = '0';
      setTimeout(() => alert.remove(), 300);
    }
  }

  // Auto dismiss alert after 5 seconds & clean query URL without page reload
  document.addEventListener('DOMContentLoaded', () => {
    const alert = document.getElementById('status-alert');
    if (alert) {
      setTimeout(() => {
        dismissAlert();
      }, 5000);
    }

    // Clean up status parameter from address bar
    const url = new URL(window.location.href);
    if (url.searchParams.has('status')) {
      url.searchParams.delete('status');
      window.history.replaceState({}, document.title, url.toString());
    }
  });

  function previewImage(input, previewId, placeholderId) {
    const preview = document.getElementById(previewId);
    const placeholder = document.getElementById(placeholderId);

    if (input.files && input.files[0]) {
      const reader = new FileReader();
      reader.onload = function (e) {
        preview.src = e.target.result;
        preview.classList.remove('hidden');
        placeholder.classList.add('hidden');
      };
      reader.readAsDataURL(input.files[0]);
    }
  }

  function toggleCategoryMode() {
    const selectEl = document.getElementById('product-category-select');
    const inputEl = document.getElementById('product-category-input');
    const toggleBtn = document.getElementById('toggle-category-btn');
    const deleteBtn = document.getElementById('delete-category-btn');

    if (selectEl.classList.contains('hidden')) {
      selectEl.classList.remove('hidden');
      inputEl.classList.add('hidden');
      inputEl.value = '';
      toggleBtn.textContent = '+ Create New';
      deleteBtn.classList.remove('hidden');
    } else {
      selectEl.classList.add('hidden');
      inputEl.classList.remove('hidden');
      inputEl.focus();
      toggleBtn.textContent = 'Select Existing';
      deleteBtn.classList.add('hidden');
    }
  }

  async function deleteSelectedCategory() {
    const selectEl = document.getElementById('product-category-select');
    const selectedCategory = selectEl.value;

    if (!selectedCategory) {
      alert('Please select a category to delete.');
      return;
    }

    if (!confirm(`Are you sure you want to delete category "${selectedCategory}"?`)) {
      return;
    }

    try {
      const formData = new FormData();
      formData.append('category_name', selectedCategory);

      const response = await fetch('api/delete_category.php', {
        method: 'POST',
        body: formData
      });

      const result = await response.json();

      if (result.success) {
        const optionToRemove = selectEl.querySelector(`option[value="${selectedCategory}"]`);
        if (optionToRemove) optionToRemove.remove();
        alert('Category deleted successfully!');
      } else {
        alert(result.message || 'Failed to delete category.');
      }
    } catch (err) {
      console.error(err);
      alert('Error connecting to backend API.');
    }
  }

  function calculateOfferPrice() {
    const price = parseFloat(document.getElementById('product-price').value) || 0;
    const discount = parseFloat(document.getElementById('product-deal').value) || 0;
    
    let offerPrice = price - (price * (discount / 100));
    if (offerPrice < 0) offerPrice = 0;
    
    document.getElementById('offer-price').value = Math.round(offerPrice);
  }
</script>