<?php
// Step out of views/ and admin/ to reach root includes/db_connect.php
require_once __DIR__ . '/../../includes/db_connect.php';

// Pagination setup
$limit = 6;
$page = isset($_GET['p']) ? max(1, (int)$_GET['p']) : 1;
$offset = ($page - 1) *$limit;

try {
    // Total product count for pagination
    $totalStmt =$pdo->query("SELECT COUNT(*) FROM products");
    $totalProducts = (int)$totalStmt->fetchColumn();$totalPages = max(1, ceil($totalProducts / $limit));

    if ($page >$totalPages) {
        $page =$totalPages;
        $offset = ($page - 1) *$limit;
    }

    // Fetch paginated products
    $stmt =$pdo->prepare("SELECT id, product_name, category, product_price, offer_price, image_primary FROM products ORDER BY id DESC LIMIT :limit OFFSET :offset");
    $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);$stmt->execute();
    
    $products =$stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (\PDOException $e) {
    error_log('Error listing products: ' . $e->getMessage());
    $products = [];$totalProducts = 0;
    $totalPages = 1;
}
?>

<!-- SCREEN 2: ALL PRODUCTS (Hidden by default unless toggled) -->
<div id="screen-product-list" class="screen-fade max-w-4xl mt-8 hidden">
  <div class="flex items-center justify-between mb-6">
    <h1 class="text-xl font-bold text-slate-900">All Products</h1>
    <span class="text-xs font-medium text-slate-500 bg-slate-100 px-3 py-1 rounded-full border border-slate-200">
      Total Items: <?= $totalProducts ?>
    </span>
  </div>

  <div class="border border-slate-200 rounded overflow-hidden bg-white shadow-sm">
    <table class="w-full text-left border-collapse text-sm">
      <thead>
        <tr class="bg-slate-50 border-b border-slate-200 text-slate-700">
          <th class="p-3.5 font-medium">Image</th>
          <th class="p-3.5 font-medium">Name</th>
          <th class="p-3.5 font-medium">Category</th>
          <th class="p-3.5 font-medium">Price</th>
          <th class="p-3.5 font-medium text-right">Action</th>
        </tr>
      </thead>
      <tbody class="divide-y divide-slate-100">
        <?php if (empty($products)): ?>
          <tr>
            <td colspan="5" class="p-6 text-center text-slate-500">
              No products found in the catalog.
            </td>
          </tr>
        <?php else: ?>
          <?php foreach ($products as$item): ?>
            <tr id="product-row-<?= $item['id'] ?>" class="hover:bg-slate-50 transition-colors">
              <td class="p-3.5">
                <div class="w-10 h-10 bg-slate-100 border border-slate-200 rounded flex items-center justify-center text-xs text-slate-500 overflow-hidden">
                  <?php if (!empty($item['image_primary'])): ?>
                    <img src="../<?= htmlspecialchars($item['image_primary']) ?>" alt="Thumbnail" class="w-full h-full object-cover">
                  <?php else: ?>
                    Img
                  <?php endif; ?>
                </div>
              </td>
              <td class="p-3.5 font-medium text-slate-900">
                <?= htmlspecialchars($item['product_name']) ?>
              </td>
              <td class="p-3.5 text-slate-600">
                <?= htmlspecialchars($item['category']) ?>
              </td>
              <td class="p-3.5 text-slate-600 font-medium">
                UGX <?= number_format((float)($item['offer_price'] > 0 ? $item['offer_price'] :$item['product_price'])) ?>
              </td>
              <td class="p-3.5 text-right">
                <button onclick="deleteProduct(<?= $item['id'] ?>)" class="text-red-600 hover:text-red-800 text-xs font-medium focus:outline-none transition-colors">
                  Delete
                </button>
              </td>
            </tr>
          <?php endforeach; ?>
        <?php endif; ?>
      </tbody>
    </table>

    <!-- Pagination Footer -->
    <?php if ($totalPages > 1): ?>
      <div class="py-3 px-4 bg-slate-50 border-t border-slate-200 flex items-center justify-between text-xs text-slate-500">
        <span>Showing Page <strong><?= $page ?></strong> of <strong><?= $totalPages ?></strong></span>
        <div class="flex items-center space-x-2">
          <?php if ($page > 1): ?>
            <a href="?view=list_products&p=<?= $page - 1 ?>" class="px-2.5 py-1 rounded border border-slate-300 bg-white text-slate-700 hover:bg-slate-100 transition">Previous</a>
          <?php endif; ?>
          <?php if ($page <$totalPages): ?>
            <a href="?view=list_products&p=<?= $page + 1 ?>" class="px-2.5 py-1 rounded border border-slate-300 bg-white text-slate-700 hover:bg-slate-100 transition">Next</a>
          <?php endif; ?>
        </div>
      </div>
    <?php endif; ?>
  </div>
</div>

<script>
async function deleteProduct(id) {
  if (!confirm(`Are you sure you want to delete product #${id}?`)) {
    return;
  }

  const formData = new FormData();
  formData.append('product_id', id);

  try {
    const response = await fetch('api/delete_product.php', {
      method: 'POST',
      body: formData
    });

    const responseText = await response.text();

    if (!response.ok) {
      console.error('Server returned error:', responseText);
      alert(`Server Error (${response.status}): ${responseText}`);
      return;
    }

    let result;
    try {
      result = JSON.parse(responseText);
    } catch (parseErr) {
      console.error('Non-JSON Server Response:', responseText);
      alert('Server outputted non-JSON content. Press F12 to check console.');
      return;
    }

    if (result.success) {
      const row = document.getElementById(`product-row-${id}`);
      if (row) {
        row.style.transition = 'all 0.3s ease';
        row.style.opacity = '0';
        setTimeout(() => row.remove(), 300);
      }
    } else {
      alert(result.message || 'Failed to delete product.');
    }

  } catch (err) {
    console.error('Network Error:', err);
    alert('Failed to connect to delete endpoint. Check console for details.');
  }
}
</script>