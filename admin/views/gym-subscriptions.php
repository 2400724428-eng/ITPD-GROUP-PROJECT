<?php
// gym-subscriptions.php — Dynamic Gym Subscriptions & Payment Verification Panel
if (isset($_POST['approve_subscription_id']) && isset($pdo)) {
    try {
        $approveId = (int)$_POST['approve_subscription_id'];
        // Safely try updating status using standard column identifiers
        $stmtApprove =$pdo->prepare("UPDATE gym_records SET status = 'approved' WHERE record_id = ? OR id = ?");
        $stmtApprove->execute([$approveId,$approveId]);
    } catch (\Exception $e) {
        // Silent catch to prevent execution halts
    }
}

$subscriptionsList = [];
if (isset($pdo)) {
    try {
        // Safe query matching both subscription types
        $stmtSubs =$pdo->query("SELECT * FROM gym_records WHERE record_type IN ('gymn_suscrption', 'subscription') ORDER BY created_at DESC");
        while ($sRow =$stmtSubs->fetch(PDO::FETCH_ASSOC)) {
            // Safely resolve primary key across different schema versions
            $recordId = $sRow['record_id'] ?? $sRow['id'] ?? 0;
            
            $payload = [];
            if (!empty($sRow['payload'])) {
                $payload = json_decode($sRow['payload'], true) ?? [];
            }

            // Safely resolve member name from JSON payload or user id fallback
            $memberName = $payload['member_name'] ?? $payload['name'] ?? null;
            if (!$memberName && !empty($sRow['title']) && strpos($sRow['title'], 'Gym') === false) {
                $memberName =$sRow['title'];
            }
            if (!$memberName) {
                $memberName = 'Member #' . ($sRow['user_id'] ?? '11');
            }

            $subscriptionsList[] = [
                'record_id' => $recordId,
                'member_name' => $memberName,
                'service' => $sRow['title'] ?? 'Gym Membership',
                'amount' => (int)($sRow['numeric_value'] ?? $payload['amount'] ?? 0), 'status' =>$sRow['status'] ?? 'pending',
                'date' => !empty($sRow['created_at']) ? date('d M Y, g:i A', strtotime($sRow['created_at'])) : 'N/A',
                'channel' => $payload['payment_channel'] ?? 'WhatsApp'
            ];
        }
    } catch (\PDOException $e) {
        $dbError =$e->getMessage();
    }
}
?>
<div id="screen-gym-subscriptions" class="screen-fade max-w-5xl hidden relative">
  
  <!-- Toast Notification Container -->
  <div id="toast-container" class="fixed top-5 right-5 z-50 transform translate-y-[-20px] opacity-0 transition-all duration-300 pointer-events-none">
    <div id="toast-message-box" class="flex items-center gap-3 px-4 py-3 bg-slate-900 text-white rounded-md shadow-lg border border-slate-700 text-sm font-medium">
      <svg class="w-5 h-5 text-emerald-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
      </svg>
      <span id="toast-text">Subscription approved successfully. Member portal access unlocked.</span>
    </div>
  </div>

  <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6 gap-4">
    <div>
      <h1 class="text-xl font-bold text-slate-900">Gym Subscriptions & Payment Approvals</h1>
      <p class="text-sm text-slate-500 mt-0.5">Track monthly/weekly subscription payments and membership renewals.</p>
    </div>
    <span class="px-3 py-1 bg-sky-50 text-sky-700 text-xs font-bold rounded-full border border-sky-200">
      <?= count($subscriptionsList) ?> Subscriptions Logged
    </span>
  </div>

  <div class="bg-white border border-slate-200 rounded-sm shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
      <table class="w-full text-left border-collapse">
        <thead>
          <tr class="bg-slate-50 border-b border-slate-200 text-xs font-semibold text-slate-600 uppercase tracking-wider">
            <th class="py-3.5 px-4">Member Name</th>
            <th class="py-3.5 px-4">Service / Package</th>
            <th class="py-3.5 px-4">Amount Paid</th>
            <th class="py-3.5 px-4">Date Logged</th>
            <th class="py-3.5 px-4">Status</th>
            <th class="py-3.5 px-4 text-right">Action</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-slate-200 text-sm">
          <?php if (empty($subscriptionsList)): ?>
            <tr>
              <td colspan="6" class="py-8 text-center text-slate-400">No subscription payment attempts recorded yet.</td>
            </tr>
          <?php else: ?>
            <?php foreach ($subscriptionsList as$sub): ?>
              <tr class="hover:bg-slate-50" id="sub-row-<?= $sub['record_id'] ?>">
                <td class="py-3.5 px-4 font-bold text-slate-900"><?= htmlspecialchars($sub['member_name']) ?></td>
                <td class="py-3.5 px-4 text-slate-700"><?= htmlspecialchars($sub['service']) ?></td>
                <td class="py-3.5 px-4 text-slate-700 font-medium">UGX <?= number_format($sub['amount']) ?></td>
                <td class="py-3.5 px-4 text-xs text-slate-500"><?= htmlspecialchars($sub['date']) ?></td>
                <td class="py-3.5 px-4 status-cell">
     <?php if (strtolower($sub['status']) === 'approved' || strtolower($sub['status']) === 'active'): ?>
                    <span class="px-2.5 py-1 bg-emerald-100 text-emerald-800 text-xs font-bold rounded-full">Approved</span>
                  <?php else: ?>
                    <span class="px-2.5 py-1 bg-amber-100 text-amber-800 text-xs font-bold rounded-full">Pending</span>
                  <?php endif; ?>
                </td>
                <td class="py-3.5 px-4 text-right action-cell">
                  <?php if (strtolower($sub['status']) !== 'approved' && strtolower($sub['status']) !== 'active'): ?>
                    <button type="button" onclick="approveSubscription(<?= $sub['record_id'] ?>, this)" class="px-3 py-1 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold rounded shadow-sm transition">
                      Approve
                    </button>
                  <?php else: ?>
                    <span class="text-xs font-semibold text-slate-400">Active</span>
                  <?php endif; ?>
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
function showToast(message) {
    const toastContainer = document.getElementById('toast-container');
    const toastText = document.getElementById('toast-text');
    
    toastText.textContent = message;
    toastContainer.classList.remove('translate-y-[-20px]', 'opacity-0', 'pointer-events-none');
    toastContainer.classList.add('translate-y-0', 'opacity-100');

    // Auto hide after 3.5 seconds
    setTimeout(() => {
        toastContainer.classList.remove('translate-y-0', 'opacity-100');
        toastContainer.classList.add('translate-y-[-20px]', 'opacity-0', 'pointer-events-none');
    }, 3500);
}

function approveSubscription(recordId, btnElement) {
    const formData = new URLSearchParams();
    formData.append('approve_subscription_id', recordId);

    // Disable button to prevent double-clicks
    btnElement.disabled = true;
    btnElement.textContent = 'Approving...';

    fetch('api/approve-subscription.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: formData.toString()
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Show toast notification
            showToast(data.message || "Subscription approved successfully. Member portal access unlocked.");

            // Update row UI dynamically without reloading the page
            const row = document.getElementById('sub-row-' + recordId);
            if (row) {
                const statusCell = row.querySelector('.status-cell');
                const actionCell = row.querySelector('.action-cell');

                statusCell.innerHTML = `<span class="px-2.5 py-1 bg-emerald-100 text-emerald-800 text-xs font-bold rounded-full">Approved</span>`;
                actionCell.innerHTML = `<span class="text-xs font-semibold text-slate-400">Active</span>`;
            }
        } else {
            alert('Error: ' + (data.message || 'Could not approve subscription.'));
            btnElement.disabled = false;
            btnElement.textContent = 'Approve';
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An unexpected network error occurred.');
        btnElement.disabled = false;
        btnElement.textContent = 'Approve';
    });
}
</script>