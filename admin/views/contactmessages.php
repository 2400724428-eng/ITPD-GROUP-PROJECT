<?php
// Step out of views/ and admin/ to reach root includes/db_connect.php
require_once __DIR__ . '/../../includes/db_connect.php';

// Pagination Setup
$limit = 6; // Maximum messages per page
$page = isset($_GET['p']) ? max(1, (int)$_GET['p']) : 1;
$offset = ($page - 1) * $limit;

try {
    // Get total message count for pagination math
    $totalStmt = $pdo->query("SELECT COUNT(*) FROM contact_submissions");
    $totalMessages = (int)$totalStmt->fetchColumn();
    $totalPages = max(1, ceil($totalMessages / $limit));

    // Ensure current page does not exceed maximum pages
    if ($page > $totalPages) {
        $page = $totalPages;
        $offset = ($page - 1) * $limit;
    }

    // Fetch limited messages for current page
    $stmt = $pdo->prepare("SELECT id, first_name, last_name, email, phone, team, message, created_at FROM contact_submissions ORDER BY id DESC LIMIT :limit OFFSET :offset");
    $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
    
    $messages = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $currentCount = count($messages);
} catch (\PDOException $e) {
    error_log('Error fetching messages: ' . $e->getMessage());
    $messages = [];
    $totalMessages = 0;
    $totalPages = 1;
    $currentCount = 0;
}
?>

<!-- SCREEN: CONTACT MESSAGES (Hidden by default unless active) -->
<div id="screen-contact-messages" class="screen-fade max-w-5xl mt-10 hidden">
  <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6 gap-4">
    <div>
      <h1 class="text-xl font-bold text-slate-900">Customer Messages</h1>
      <p class="text-sm text-slate-500 mt-0.5">Manage and respond to inquiries submitted via the Contact Us page.</p>
    </div>
    <div class="flex items-center gap-2">
      <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-blue-50 text-blue-700 border border-blue-100">
        <?= $totalMessages ?> Total Messages
      </span>
    </div>
  </div>

  <!-- Messages Table Card -->
  <div class="bg-white border border-slate-200 rounded-sm shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
      <table class="w-full text-left border-collapse">
        <thead>
          <tr class="bg-slate-50 border-b border-slate-200 text-xs font-semibold text-slate-600 uppercase tracking-wider">
            <th class="py-3.5 px-4">Sender</th>
            <th class="py-3.5 px-4">Team</th>
            <th class="py-3.5 px-4">Message Preview</th>
            <th class="py-3.5 px-4">Date</th>
            <th class="py-3.5 px-4 text-right">Action</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-slate-200 text-sm">
          <?php if (empty($messages)): ?>
            <tr>
              <td colspan="5" class="py-6 px-4 text-center text-slate-500">
                No customer messages found.
              </td>
            </tr>
          <?php else: ?>
            <?php foreach ($messages as $msg): ?>
              <tr class="hover:bg-slate-50/80 transition-colors">
                <td class="py-3.5 px-4">
                  <div class="font-medium text-slate-900">
                    <?= htmlspecialchars(($msg['first_name'] ?? '') . ' ' . ($msg['last_name'] ?? '')) ?>
                  </div>
                  <div class="text-xs text-slate-500">
                    <?= htmlspecialchars($msg['email'] ?? '') ?>
                  </div>
                  <?php if (!empty($msg['phone'])): ?>
                    <div class="text-xs text-slate-400">
                      <?= htmlspecialchars($msg['phone']) ?>
                    </div>
                  <?php endif; ?>
                </td>

                <td class="py-3.5 px-4 font-medium text-slate-800">
                  <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-slate-100 text-slate-700">
                    <?= htmlspecialchars($msg['team'] ?? 'General') ?>
                  </span>
                </td>

                <td class="py-3.5 px-4 text-slate-600 truncate max-w-xs" title="<?= htmlspecialchars($msg['message'] ?? '') ?>">
                  <?= htmlspecialchars($msg['message'] ?? '') ?>
                </td>

                <td class="py-3.5 px-4 text-xs text-slate-500 whitespace-nowrap">
                  <?= !empty($msg['created_at']) ? date('M j, Y', strtotime($msg['created_at'])) : 'N/A' ?>
                </td>

                <td class="py-3.5 px-4 text-right space-x-3 whitespace-nowrap">
                  <button onclick="alert('Viewing message #<?= $msg['id'] ?>')" class="text-xs font-medium text-blue-600 hover:text-blue-800 transition">
                    View
                  </button>
                  <button onclick="alert('Deleting message #<?= $msg['id'] ?>')" class="text-xs font-medium text-rose-600 hover:text-rose-800 transition">
                    Delete
                  </button>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php endif; ?>
        </tbody>
      </table>
    </div>

    <!-- Pagination Footer -->
    <div class="py-3 px-4 bg-slate-50 border-t border-slate-200 flex items-center justify-between text-xs text-slate-500">
      <span>
        Showing <strong><?= $totalMessages > 0 ? $offset + 1 : 0 ?></strong> to <strong><?= min($offset + $limit, $totalMessages) ?></strong> of <strong><?= $totalMessages ?></strong> messages
      </span>
      <div class="flex items-center space-x-1">
        <?php if ($page > 1): ?>
          <a href="?view=messages&p=<?= $page - 1 ?>" class="px-3 py-1 rounded border border-slate-300 bg-white text-slate-700 hover:bg-slate-100 transition">
            Previous
          </a>
        <?php else: ?>
          <button disabled class="px-3 py-1 rounded border border-slate-200 bg-white text-slate-400 cursor-not-allowed">
            Previous
          </button>
        <?php endif; ?>

        <span class="px-2 font-medium text-slate-600">
          Page <?= $page ?> of <?= $totalPages ?>
        </span>

        <?php if ($page < $totalPages): ?>
          <a href="?view=messages&p=<?= $page + 1 ?>" class="px-3 py-1 rounded border border-slate-300 bg-white text-slate-700 hover:bg-slate-100 transition">
            Next
          </a>
        <?php else: ?>
          <button disabled class="px-3 py-1 rounded border border-slate-200 bg-white text-slate-400 cursor-not-allowed">
            Next
          </button>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>