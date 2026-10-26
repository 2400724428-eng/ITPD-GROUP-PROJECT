<?php
// overview.php — Dynamic Gym Dashboard Overview Panel
// Metrics: Members | Check-ins | Classes Booked | Money Collected

if (!isset($pdo)) {
    foreach ([
        __DIR__ . '/includes/db_connect.php',
        __DIR__ . '/../includes/db_connect.php',
        __DIR__ . '/../../includes/db_connect.php',
    ] as $__p) {
        if (file_exists($__p)) { require_once $__p; break; }
    }
}

$overviewError = '';

// ================================================================
// 1. MEMBERS  (count from gymnuser)
// ================================================================
$totalMembers     = 0;
$membersLastMonth = 0;
if (isset($pdo)) {
    try {
        $totalMembers = (int)$pdo->query(
            "SELECT COUNT(*) FROM gymnuser WHERE LOWER(role) = 'member'"
        )->fetchColumn();

        $membersLastMonth = (int)$pdo->query(
            "SELECT COUNT(*) FROM gymnuser
             WHERE LOWER(role) = 'member'
               AND created_at < DATE_FORMAT(CURDATE(), '%Y-%m-01')"
        )->fetchColumn();
    } catch (\PDOException $e) {
        $overviewError = $e->getMessage();
    }
}
$newThisMonth    = $totalMembers - $membersLastMonth;
$memberGrowthPct = ($membersLastMonth > 0)
    ? round(($newThisMonth / $membersLastMonth) * 100, 1)
    : 0;

// ================================================================
// 2. CLASSES BOOKED
// ================================================================
$classesBookedTotal  = 0;
$classesBookedToday  = 0;
$classesRunningToday = 0;
if (isset($pdo)) {
    try {
        $classesBookedTotal = (int)$pdo->query(
            "SELECT COUNT(*) FROM gym_records WHERE record_type = 'class_booking'"
        )->fetchColumn();

        $classesBookedToday = (int)$pdo->query(
            "SELECT COUNT(*) FROM gym_records
             WHERE record_type = 'class_booking'
               AND DATE(created_at) = CURDATE()"
        )->fetchColumn();

        $classesRunningToday = (int)$pdo->query(
            "SELECT COUNT(DISTINCT title) FROM gym_records
             WHERE record_type = 'class_booking'
               AND DATE(created_at) = CURDATE()"
        )->fetchColumn();
    } catch (\PDOException $e) {
        $overviewError = $e->getMessage();
    }
}

// ================================================================
// 3. MONEY COLLECTED  (mirrors gym-subscriptions.php)
// ================================================================
$moneyThisMonth = 0;
$moneyAllTime   = 0;
$moneyPending   = 0;
if (isset($pdo)) {
    try {
        $stmtMoney = $pdo->query(
            "SELECT record_type, numeric_value, payload, status, created_at
             FROM gym_records
             WHERE record_type IN ('gymn_suscrption', 'subscription')"
        );

        $currentMonth = date('Y-m');

        while ($m = $stmtMoney->fetch(PDO::FETCH_ASSOC)) {
            $payload = [];
            if (!empty($m['payload'])) {
                $payload = json_decode($m['payload'], true) ?? [];
            }
            $amount = (int)($m['numeric_value'] ?? $payload['amount'] ?? 0);
            $status = strtolower($m['status'] ?? 'pending');

            $isCollected = ($status === 'approved' || $status === 'active');

            if ($isCollected) {
                $moneyAllTime += $amount;
                if (!empty($m['created_at'])) {
                    $ts = strtotime($m['created_at']);
                    if ($ts && date('Y-m', $ts) === $currentMonth) {
                        $moneyThisMonth += $amount;
                    }
                }
            } else {
                $moneyPending += $amount;
            }
        }
    } catch (\PDOException $e) {
        $overviewError = $e->getMessage();
    }
}

// ================================================================
// 4. CHECK-INS  (fixed — now shows real "inside right now" count)
// ================================================================
$gymCapacity        = 50;   // set to real max occupancy
$totalCheckinsToday = 0;    // raw count of check_in rows today
$currentlyInside    = 0;    // check_in today MINUS check_out today
$peakHour           = '—';
$peakCount          = 0;

if (isset($pdo)) {
    try {
        // Total check-in rows today (what the old card was showing)
        $totalCheckinsToday = (int)$pdo->query(
            "SELECT COUNT(*) FROM gym_records
             WHERE record_type = 'check_in'
               AND DATE(created_at) = CURDATE()"
        )->fetchColumn();

        // People actually inside = checked in today AND not checked out yet
        $currentlyInside = (int)$pdo->query(
            "SELECT COUNT(DISTINCT user_id) FROM gym_records
             WHERE record_type = 'check_in'
               AND DATE(created_at) = CURDATE()
               AND user_id NOT IN (
                 SELECT user_id FROM gym_records
                 WHERE record_type = 'check_out'
                   AND DATE(created_at) = CURDATE()
               )"
        )->fetchColumn();

        // Peak hour today (with count)
        $peakRow = $pdo->query(
            "SELECT HOUR(created_at) AS h, COUNT(*) AS c
             FROM gym_records
             WHERE record_type = 'check_in' AND DATE(created_at) = CURDATE()
             GROUP BY HOUR(created_at) ORDER BY c DESC LIMIT 1"
        )->fetch(PDO::FETCH_ASSOC);
        if ($peakRow && isset($peakRow['h'])) {
            $h       = (int)$peakRow['h'];
            $peakCount = (int)$peakRow['c'];
            $suffix  = ($h >= 12) ? 'PM' : 'AM';
            $h12     = $h % 12; if ($h12 === 0) $h12 = 12;
            $peakHour = $h12 . ':00 ' . $suffix;
        }
    } catch (\PDOException $e) {
        $overviewError = $e->getMessage();
    }
}

// Occupancy % of gym capacity (clamped 0–100)
$occupancyPct = $gymCapacity > 0
    ? min(100, (int)round(($currentlyInside / $gymCapacity) * 100))
    : 0;

// ================================================================
// 5. RECENT MEMBER SIGN-UPS
// ================================================================
$recentSignups = [];
if (isset($pdo)) {
    try {
        $stmt = $pdo->query(
            "SELECT * FROM gymnuser
             WHERE LOWER(role) = 'member'
             ORDER BY user_id DESC LIMIT 5"
        );
        while ($u = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $recentSignups[] = [
                'name'  => $u['trainer_name'] ?? 'Unnamed Member',
                'email' => $u['email'] ?? '',
                'date'  => !empty($u['created_at'])
                    ? date('M d, Y', strtotime($u['created_at']))
                    : 'N/A',
            ];
        }
    } catch (\PDOException $e) {
        $overviewError = $e->getMessage();
    }
}

// UGX formatter
$fmtUGX = function (int $n): string {
    if ($n >= 1_000_000) return 'UGX ' . number_format($n / 1_000_000, 1) . 'M';
    if ($n >= 1_000)     return 'UGX ' . number_format($n / 1_000, 0)     . 'K';
    return 'UGX ' . number_format($n);
};
?>

<div id="screen-gym-dashboard" class="screen-fade max-w-5xl hidden">
  <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6 gap-4">
    <div>
      <h1 class="text-xl font-bold text-slate-900">Gym Dashboard Overview</h1>
      <p class="text-sm text-slate-500 mt-0.5">Key performance indicators, daily check-ins, and revenue overview.</p>
    </div>
    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-emerald-50 text-emerald-700 border border-emerald-100">
      System Online &amp; Active
    </span>
  </div>

  <?php if (!empty($overviewError)): ?>
    <div class="mb-4 p-3 rounded-lg bg-rose-50 text-rose-700 text-xs border border-rose-200">
      <?= htmlspecialchars($overviewError) ?>
    </div>
  <?php endif; ?>

  <!-- ===== Metric Summary Cards ===== -->
  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">

    <!-- MEMBERS -->
    <div class="bg-white border border-slate-200 rounded-sm p-5 shadow-sm">
      <div class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Members</div>
      <div class="text-2xl font-bold text-slate-900 mt-2"><?= number_format($totalMembers) ?></div>
      <div class="text-xs <?= $newThisMonth >= 0 ? 'text-emerald-600' : 'text-rose-600' ?> font-medium mt-1">
        <?= $newThisMonth >= 0 ? '+' : '' ?><?= $newThisMonth ?> this month
        (<?= $memberGrowthPct >= 0 ? '+' : '' ?><?= $memberGrowthPct ?>%)
      </div>
    </div>

    <!-- CHECK-INS (UPDATED) -->
    <div class="bg-white border border-slate-200 rounded-sm p-5 shadow-sm">
      <div class="flex items-start justify-between">
        <div class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Check-ins</div>
        <span class="text-[10px] font-bold px-2 py-0.5 rounded-full
                     <?= $occupancyPct >= 90
                          ? 'bg-rose-100 text-rose-700'
                          : ($occupancyPct >= 70
                              ? 'bg-amber-100 text-amber-700'
                              : 'bg-emerald-100 text-emerald-700') ?>">
          <?= $occupancyPct ?>%
        </span>
      </div>
      <div class="text-2xl font-bold text-slate-900 mt-2">
        <?= number_format($currentlyInside) ?>
        <span class="text-sm font-semibold text-slate-400">/ <?= $gymCapacity ?></span>
      </div>
      <div class="text-xs text-slate-500 font-medium mt-1">
        <?= number_format($totalCheckinsToday) ?> check-ins today
        <?php if ($peakHour !== '—'): ?>
          · Peak <?= htmlspecialchars($peakHour) ?> (<?= $peakCount ?>)
        <?php endif; ?>
      </div>
      <!-- Occupancy bar -->
      <div class="mt-2 h-1.5 w-full bg-slate-100 rounded-full overflow-hidden">
        <div class="h-full rounded-full <?= $occupancyPct >= 90 ? 'bg-rose-500' : ($occupancyPct >= 70 ? 'bg-amber-500' : 'bg-emerald-500') ?>"
             style="width: <?= $occupancyPct ?>%"></div>
      </div>
    </div>

    <!-- CLASSES BOOKED -->
    <div class="bg-white border border-slate-200 rounded-sm p-5 shadow-sm">
      <div class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Classes Booked</div>
      <div class="text-2xl font-bold text-slate-900 mt-2"><?= number_format($classesBookedTotal) ?></div>
      <div class="text-xs text-slate-500 font-medium mt-1">
        <?= $classesBookedToday ?> today
        · <?= $classesRunningToday ?> session<?= $classesRunningToday === 1 ? '' : 's' ?> running
      </div>
    </div>

    <!-- MONEY COLLECTED -->
    <div class="bg-white border border-slate-200 rounded-sm p-5 shadow-sm">
      <div class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Money Collected (Month)</div>
      <div class="text-2xl font-bold text-slate-900 mt-2"><?= $fmtUGX($moneyThisMonth) ?></div>
      <div class="text-xs text-slate-500 font-medium mt-1">
        All-time: <?= $fmtUGX($moneyAllTime) ?>
        <?php if ($moneyPending > 0): ?>
          · <span class="text-amber-600">Pending: <?= $fmtUGX($moneyPending) ?></span>
        <?php endif; ?>
      </div>
    </div>
  </div>

  <!-- ===== Recent Member Sign-ups ===== -->
  <div class="bg-white border border-slate-200 rounded-sm shadow-sm overflow-hidden">
    <div class="px-5 py-4 border-b border-slate-200 font-semibold text-sm text-slate-800">Recent Member Sign-ups</div>
    <div class="overflow-x-auto">
      <table class="w-full text-left border-collapse">
        <thead>
          <tr class="bg-slate-50 border-b border-slate-200 text-xs font-semibold text-slate-600 uppercase tracking-wider">
            <th class="py-3 px-4">Member Name</th>
            <th class="py-3 px-4">Email</th>
            <th class="py-3 px-4">Date Joined</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-slate-200 text-sm">
          <?php if (empty($recentSignups)): ?>
            <tr>
              <td colspan="3" class="py-8 text-center text-slate-400 italic text-xs">
                No member sign-ups recorded yet.
              </td>
            </tr>
          <?php else: ?>
            <?php foreach ($recentSignups as $row): ?>
              <tr class="hover:bg-slate-50">
                <td class="py-3 px-4 font-medium text-slate-900"><?= htmlspecialchars($row['name']) ?></td>
                <td class="py-3 px-4 text-xs text-slate-500"><?= htmlspecialchars($row['email']) ?></td>
                <td class="py-3 px-4 text-xs text-slate-500"><?= htmlspecialchars($row['date']) ?></td>
              </tr>
            <?php endforeach; ?>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>