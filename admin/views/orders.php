<?php
// ==================== BACKEND PHP HANDLER ====================
require_once __DIR__ . '/../../includes/db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Content-Type: application/json');
    $input = json_decode(file_get_contents('php://input'), true);
    $action =$input['action'] ?? '';

    if (!$pdo) {
        echo json_encode(['success' => false, 'error' => 'Database connection failed']);
        exit;
    }

    if ($action === 'approve') {
        $orderNumber = ltrim($input['order_number'] ?? '', '#');
        $stmt =$pdo->prepare("UPDATE `orders` SET `payment_status` = 'Completed', `updated_at` = NOW() WHERE `order_number` = ?");
        $stmt->execute([$orderNumber]);
        echo json_encode(['success' => true]);
        exit;
    }

    if ($action === 'delete') {
        $orderNumber = ltrim($input['order_number'] ?? '', '#');
        $stmt =$pdo->prepare("DELETE FROM `orders` WHERE `order_number` = ?");
        $stmt->execute([$orderNumber]);
        echo json_encode(['success' => true]);
        exit;
    }
    exit;
}

// Fetch orders from the database
$orders = [];
if ($pdo) {
    try {
        $stmt =$pdo->query("SELECT * FROM `orders` ORDER BY `id` DESC");
        $orders =$stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $e) {$orders = [];
    }
}
?>
<!-- SCREEN: ORDERS -->
<div id="screen-orders" class="screen-fade hidden max-w-5xl">
  <h1 class="text-xl font-bold text-slate-900 mb-6">Customer Orders</h1>

  <!-- Orders Table Card -->
  <div class="bg-white border border-slate-200 rounded-sm shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
      <table class="w-full text-left border-collapse">
        <thead>
          <tr class="bg-slate-50 border-b border-slate-200 text-xs font-semibold text-slate-600 uppercase tracking-wider">
            <th class="py-3.5 px-4">Order ID</th>
            <th class="py-3.5 px-4">Customer & Items</th>
            <th class="py-3.5 px-4">Payment</th>
            <th class="py-3.5 px-4">Status</th>
            <th class="py-3.5 px-4 text-right">Action</th>
          </tr>
        </thead>
        <tbody id="orders-table-body" class="divide-y divide-slate-200 text-sm">
          <?php if (empty($orders)): ?>
            <tr>
              <td colspan="5" class="py-6 text-center text-slate-400 text-sm">No customer orders found in the database.</td>
            </tr>
          <?php else: ?>
            <?php foreach ($orders as$order): ?>
              <?php $orderNum = htmlspecialchars($order['order_number']); ?>
              <tr id="order-<?php echo $orderNum; ?>" class="hover:bg-slate-50/80 transition-colors">
                <td class="py-3.5 px-4 font-medium text-slate-900">#<?php echo $orderNum; ?></td>
                <td class="py-3.5 px-4">
                  <div class="font-medium text-slate-900"><?php echo htmlspecialchars($order['shipping_address']); ?></div>
                  <div class="text-xs text-slate-500">Total: UGX <?php echo number_format($order['total_amount'], 2); ?></div>
                </td>
                <td class="py-3.5 px-4 text-slate-600 text-xs"><?php echo htmlspecialchars($order['payment_method']); ?></td>
                <td id="status-<?php echo $orderNum; ?>" class="py-3.5 px-4 text-xs font-medium <?php echo ($order['payment_status'] === 'Completed') ? 'text-emerald-600' : 'text-amber-600'; ?>">
                  <?php echo htmlspecialchars($order['payment_status']); ?>
                </td>
                <td class="py-3.5 px-4 text-right space-x-2">
                  <button onclick="approveOrder('<?php echo $orderNum; ?>')" class="text-xs font-medium text-blue-600 hover:text-blue-800 transition">
                    Approve
                  </button>
                  <button onclick="deleteOrder('<?php echo $orderNum; ?>')" class="text-xs font-medium text-red-600 hover:text-red-800 transition">
                    Delete
                  </button>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<script>
  const ORDER_API = 'api/approve_order.php';

  async function approveOrder(orderId) {
    if (!confirm('Approve order #' + orderId + '? This marks payment as Completed.')) return;

    try {
      const response = await fetch(ORDER_API, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ action: 'approve', order_number: orderId })
      });

      const text = await response.text();
      let result;
      try { result = JSON.parse(text); }
      catch (e) { alert('Server returned non-JSON:\n' + text.slice(0, 300)); return; }

      if (result.success) {
        // Update UI in place
        const statusCell = document.getElementById('status-' + orderId);
        if (statusCell) {
          statusCell.className = 'py-3.5 px-4 text-xs font-medium text-emerald-600';
          statusCell.textContent = 'Completed';
        }
        const row = document.getElementById('order-' + orderId);
        const approveBtn = row ? row.querySelector('button') : null;
        if (approveBtn) {
          approveBtn.disabled = true;
          approveBtn.classList.add('opacity-40', 'cursor-not-allowed');
        }
        showToast('Order #' + orderId + ' approved ✓', 'success');
      } else {
        alert('Failed to approve: ' + (result.error || 'Unknown error'));
      }
    } catch (err) {
      console.error(err);
      alert('Network error while approving order.');
    }
  }

  async function deleteOrder(orderId) {
    if (!confirm('Delete order #' + orderId + '? This cannot be undone.')) return;

    try {
      const response = await fetch(ORDER_API, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ action: 'delete', order_number: orderId })
      });

      const text = await response.text();
      let result;
      try { result = JSON.parse(text); }
      catch (e) { alert('Server returned non-JSON:\n' + text.slice(0, 300)); return; }

      if (result.success) {
        const row = document.getElementById('order-' + orderId);
        if (row) {
          row.style.transition = 'opacity 0.3s';
          row.style.opacity = '0';
          setTimeout(() => row.remove(), 300);
        }
        showToast('Order #' + orderId + ' deleted', 'error');
      } else {
        alert('Failed to delete: ' + (result.error || 'Unknown error'));
      }
    } catch (err) {
      console.error(err);
      alert('Network error while deleting order.');
    }
  }

  function showToast(msg, kind) {
    const bg = kind === 'success' ? 'bg-emerald-600' : 'bg-rose-600';
    const t = document.createElement('div');
    t.className = `fixed bottom-6 right-6 z-[100] ${bg} text-white text-xs font-bold px-4 py-2.5 rounded-lg shadow-lg`;
    t.textContent = msg;
    document.body.appendChild(t);
    setTimeout(() => t.remove(), 3000);
  }
</script>