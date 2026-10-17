<?php
// trainer-dashboard.php — Trainer Portal with Class Bookings, Attendance, Training Plan Calendar, & Notifications
session_start();

$dbCandidates = [
    __DIR__ . '/includes/db_connect.php',
    __DIR__ . '/../includes/db_connect.php',
    __DIR__ . '/../../includes/db_connect.php',
];
foreach ($dbCandidates as $p) {
    if (file_exists($p)) {
        require_once $p;
        break;
    }
}

// Get logged-in trainer ID
$trainerId = isset($_GET['trainer']) ? (int)$_GET['trainer'] : ($_SESSION['user_id'] ?? 10);

$trainer = ['name' => 'Coach James', 'email' => 'westboyboy373@gmail.com', 'id' => 'TRN-' . sprintf('%03d', $trainerId)];
$members = [];
$classesList = [];
$classBookings = [];
$sentNotifications = [];
$selectedMemberId = isset($_GET['member_id']) ? (int)$_GET['member_id'] : 0;
$activeChatMessages = [];
$successMessage = '';

// Calendar tracking variables
$currentMonth = isset($_GET['month']) ? (int)$_GET['month'] : (int)date('m');
$currentYear = isset($_GET['year']) ? (int)$_GET['year'] : (int)date('Y');
$existingPlanDays = [];

if (isset($pdo)) {
    try {
        $pdo->exec("CREATE TABLE IF NOT EXISTS gym_trainer_assignments (
            assignment_id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
            member_id INT NOT NULL UNIQUE,
            trainer_id INT NOT NULL,
            package_name VARCHAR(120) NULL,
            sessions_per_week INT NULL,
            assigned_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
            assigned_by INT NULL,
            INDEX idx_assignment_trainer (trainer_id),
            INDEX idx_assignment_member (member_id)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");
    } catch (\PDOException $e) { /* table may need manual creation */ }
    try {
        // Fetch Trainer details from gymnuser table
        $stmtUser = $pdo->prepare("SELECT * FROM gymnuser WHERE user_id = ? LIMIT 1");
        $stmtUser->execute([$trainerId]);
        if ($userData = $stmtUser->fetch(PDO::FETCH_ASSOC)) {
            if (!empty($userData['trainer_name'])) {
                $trainer['name'] = ucfirst($userData['trainer_name']);
            }
            $trainer['email'] = $userData['email'] ?? $trainer['email'];
        }

        // Fetch ONLY the members the administrator has assigned to this trainer
        $stmtMembers = $pdo->prepare("SELECT u.* FROM gym_trainer_assignments a
            INNER JOIN gymnuser u ON u.user_id = a.member_id
            WHERE a.trainer_id = ? AND LOWER(COALESCE(u.role, '')) = 'member'
            ORDER BY a.assigned_at DESC");
        $stmtMembers->execute([$trainerId]);
        while ($mRow = $stmtMembers->fetch(PDO::FETCH_ASSOC)) {
            $members[(int)$mRow['user_id']] = [
                'user_id' => (int)$mRow['user_id'],
                'id' => 'APX-' . sprintf('%04d', $mRow['user_id']),
                'name' => $mRow['trainer_name'] ?? ucfirst(explode('@', $mRow['email'])[0]),
                'email' => $mRow['email'],
                'phone' => $mRow['phone'] ?? 'N/A'
            ];
        }

        // A trainer can never open a member who is not assigned to them
        if ($selectedMemberId !== 0 && !isset($members[$selectedMemberId])) {
            $selectedMemberId = 0;
        }

        // Default to first member if none selected
        if ($selectedMemberId === 0 && !empty($members)) {
            $selectedMemberId = array_key_first($members);
        }

        // Handle creating a new class
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['create_class'])) {
            $className = trim($_POST['class_name'] ?? '');
            $classTime = trim($_POST['class_time'] ?? '');
            $capacity = (int)($_POST['capacity'] ?? 15);

            if (!empty($className) && !empty($classTime)) {
                $payload = json_encode([
                    'capacity' => $capacity,
                    'trainer_id' => $trainerId
                ]);

                $insClass = $pdo->prepare("INSERT INTO gym_records (user_id, target_user_id, record_type, title, status, start_time, payload) VALUES (?, ?, 'class', ?, 'scheduled', ?, ?)");
                $insClass->execute([$trainerId, null, $className, $classTime, $payload]);
                $successMessage = "Class '$className' successfully created!";
            }
        }

        // Handle sending notifications to members
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['send_notification'])) {
            $notifTitle = trim($_POST['notif_title'] ?? '');
            $notifBody = trim($_POST['notif_body'] ?? '');
            $targetRecipient = $_POST['target_recipient'] ?? 'all'; // 'all' or specific member ID

            if (!empty($notifTitle) && !empty($notifBody)) {
                $payload = json_encode([
                    'trainer_id' => $trainerId,
                    'title' => $notifTitle,
                    'body' => $notifBody,
                    'recipient' => $targetRecipient
                ]);

                if ($targetRecipient === 'all') {
                    // Send to all members in the database
                    foreach ($members as $mId => $mDetails) {
                        $insNotif = $pdo->prepare("INSERT INTO gym_records (user_id, target_user_id, record_type, title, status, payload) VALUES (?, ?, 'notification', ?, 'active', ?)");
                        $insNotif->execute([$mId, $trainerId, $notifTitle, $payload]);
                    }
                    $successMessage = "Announcement successfully broadcasted to all gym members!";
                } else {
                    // Send to a specific member
                    $mId = (int)$targetRecipient;
                    $insNotif = $pdo->prepare("INSERT INTO gym_records (user_id, target_user_id, record_type, title, status, payload) VALUES (?, ?, 'notification', ?, 'active', ?)");
                    $insNotif->execute([$mId, $trainerId, $notifTitle, $payload]);
                    $successMessage = "Notification successfully sent to member ID #$mId!";
                }
            }
        }

        // Handle saving checked training days calendar plan for a member
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save_training_plan'])) {
            $targetMember = (int)($_POST['plan_member_id'] ?? 0);
            $selectedDays = $_POST['training_days'] ?? [];

            if ($targetMember > 0 && isset($members[$targetMember])) {
                $payload = json_encode([
                    'trainer_id' => $trainerId,
                    'month' => $currentMonth,
                    'year' => $currentYear,
                    'days' => $selectedDays
                ]);

                $checkStmt = $pdo->prepare("SELECT record_id FROM gym_records WHERE user_id = ? AND record_type = 'training_plan' AND title = ? LIMIT 1");
                $planTitle = "Plan-$currentYear-$currentMonth";
                $checkStmt->execute([$targetMember, $planTitle]);
                
                if ($existingPlan = $checkStmt->fetch(PDO::FETCH_ASSOC)) {
                    $upd = $pdo->prepare("UPDATE gym_records SET payload = ?, status = 'active' WHERE record_id = ?");
                    $upd->execute([$payload, $existingPlan['record_id']]);
                } else {
                    $ins = $pdo->prepare("INSERT INTO gym_records (user_id, target_user_id, record_type, title, status, payload) VALUES (?, ?, 'training_plan', ?, 'active', ?)");
                    $ins->execute([$targetMember, $trainerId, $planTitle, $payload]);
                }
                $successMessage = "Training calendar days successfully updated for member #$targetMember!";
            }
        }

        // Handle sending messages between trainer and member
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['send_message'])) {
            $msgBody = trim($_POST['message_body'] ?? '');
            $targetUser = (int)($_POST['target_user_id'] ?? 0);
            
            if (!empty($msgBody) && $targetUser > 0 && isset($members[$targetUser])) {
                $payload = json_encode([
                    'sender' => 'trainer',
                    'trainer_id' => $trainerId,
                    'body' => $msgBody
                ]);
                
                $ins = $pdo->prepare("INSERT INTO gym_records (user_id, record_type, title, status, payload) VALUES (?, 'message', ?, 'active', ?)");
                $ins->execute([$targetUser, $msgBody, $payload]);
                
                header("Location: trainer-dashboard.php?trainer=$trainerId&member_id=$targetUser");
                exit;
            }
        }

        // Fetch existing training plan data for selected member if viewing calendar
        if ($selectedMemberId > 0) {
            $planTitle = "Plan-$currentYear-$currentMonth";
            $planStmt = $pdo->prepare("SELECT payload FROM gym_records WHERE user_id = ? AND record_type = 'training_plan' AND title = ? LIMIT 1");
            $planStmt->execute([$selectedMemberId, $planTitle]);
            if ($pRow = $planStmt->fetch(PDO::FETCH_ASSOC)) {
                $pData = json_decode($pRow['payload'], true) ?? [];
                $existingPlanDays = $pData['days'] ?? [];
            }
        }

        // Fetch all created classes
        $stmtClasses = $pdo->query("SELECT * FROM gym_records WHERE record_type = 'class' ORDER BY created_at DESC");
        while ($cRow = $stmtClasses->fetch(PDO::FETCH_ASSOC)) {
            $payload = json_decode($cRow['payload'], true) ?? [];
            $classesList[] = [
                'record_id' => $cRow['record_id'],
                'title' => $cRow['title'],
                'start_time' => $cRow['start_time'],
                'capacity' => $payload['capacity'] ?? 15,
                'status' => $cRow['status']
            ];
        }

        // Fetch all class bookings made by members
        $stmtBookings = $pdo->query("SELECT * FROM gym_records WHERE record_type = 'class_booking' ORDER BY created_at DESC");
        while ($bRow = $stmtBookings->fetch(PDO::FETCH_ASSOC)) {
            $mId = $bRow['user_id'];
            $memberName = $members[$mId]['name'] ?? 'Member #' . $mId;
            $memberEmail = $members[$mId]['email'] ?? 'N/A';
            $classBookings[] = [
                'booking_id' => $bRow['record_id'],
                'member_name' => $memberName,
                'member_email' => $memberEmail,
                'class_title' => $bRow['title'],
                'booked_time' => !empty($bRow['start_time']) ? date('D d M Y, g:i A', strtotime($bRow['start_time'])) : 'Scheduled',
                'status' => ucfirst($bRow['status'] ?? 'confirmed')
            ];
        }

        // Fetch notifications sent by this trainer
        $stmtNotifs = $pdo->prepare("SELECT * FROM gym_records WHERE record_type = 'notification' AND target_user_id = ? ORDER BY created_at DESC");
        $stmtNotifs->execute([$trainerId]);
        while ($nRow = $stmtNotifs->fetch(PDO::FETCH_ASSOC)) {
            $nPayload = json_decode($nRow['payload'], true) ?? [];
            $sentNotifications[] = [
                'title' => $nRow['title'],
                'body' => $nPayload['body'] ?? '',
                'recipient' => $nPayload['recipient'] === 'all' ? 'All Members' : 'Member #' . $nPayload['recipient'],
                'time' => date('D d M Y, g:i A', strtotime($nRow['created_at']))
            ];
        }

        // Fetch chat messages for selected member
        if ($selectedMemberId > 0) {
            $stmtChat = $pdo->prepare("SELECT * FROM gym_records WHERE user_id = ? AND record_type = 'message' ORDER BY created_at ASC");
            $stmtChat->execute([$selectedMemberId]);
            while ($cRow = $stmtChat->fetch(PDO::FETCH_ASSOC)) {
                $payload = json_decode($cRow['payload'], true) ?? [];
                $sender = $payload['sender'] ?? 'member';
                $activeChatMessages[] = [
                    'sender' => $sender,
                    'body' => $payload['body'] ?? $cRow['title'],
                    'time' => date('H:i', strtotime($cRow['created_at']))
                ];
            }
        }

    } catch (\PDOException $ex) {
        $dbError = $ex->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1"/>
<title>Trainer Portal — <?= htmlspecialchars($trainer['name']) ?></title>
<script src="https://cdn.tailwindcss.com"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet"/>
<style>
  :root { --accent:#0284c7; }
  body { font-family:'Plus Jakarta Sans',sans-serif; -webkit-font-smoothing:antialiased; }
  .nav a { white-space:nowrap; display:flex; align-items:center; gap:12px; padding:14px 18px; font-size:13px; font-weight:700; color:#4b5563; border-bottom:1px solid #e2e2e2; }
  .nav a:hover { background:#e8e8e8; } 
  .nav a.on { background:#fff; color:#111; box-shadow:inset 3px 0 0 var(--accent); }
  .card { background:#fff; border:1px solid #eef0f3; border-radius:20px; padding:20px; }
  .inp { width:100%; background:#f8fafc; border:1px solid #cbd5e1; border-radius:12px; padding:9px 12px; font-size:14px; }
  .inp:focus { outline:2px solid var(--accent); outline-offset:-1px; background:#fff; }
  .chip { font-size:11px; font-weight:700; border-radius:999px; padding:3px 10px; }
  .btn { font-size:13px; font-weight:700; border-radius:12px; padding:9px 14px; transition:background .2s; cursor:pointer; }
  .btn-p { background:var(--accent); color:#fff; } .btn-p:hover { background:#0369a1; }
</style>
</head>
<body class="bg-slate-50 text-slate-800 min-h-screen">

<!-- Header -->
<header class="sticky top-0 z-30 bg-white border-b border-slate-200">
  <div class="max-w-[1200px] mx-auto px-4 h-16 flex items-center justify-between">
    <div class="flex items-center gap-3">
      <span class="w-10 h-10 rounded-full bg-sky-600 text-white font-extrabold flex items-center justify-center">
        <?= strtoupper(substr($trainer['name'], 0, 2)) ?>
      </span>
      <div class="leading-tight">
        <p class="font-bold text-slate-900 text-sm"><?= htmlspecialchars($trainer['name']) ?></p>
        <p class="text-xs text-slate-500">Trainer Portal | Connected to gymnuser</p>
      </div>
    </div>
    <div class="flex items-center gap-4 text-xs">
      <span class="text-slate-500">Switch: <a href="portal.php?user_id=11" class="underline text-sky-600 font-bold ml-1">Member View</a></span>
      <a href="portalogin.php" class="bg-red-50 text-red-600 border border-red-200 px-3 py-1.5 rounded-lg font-bold hover:bg-red-100">Sign Out</a>
    </div>
  </div>
</header>

<div class="max-w-[1200px] mx-auto px-4 py-6 flex flex-col lg:flex-row gap-6">
  <!-- Sidebar Navigation -->
  <aside class="lg:w-60 shrink-0 bg-[#f1f1f1] rounded-2xl overflow-hidden self-start w-full">
    <nav class="nav flex lg:flex-col overflow-x-auto" id="nav">
      <a href="#" data-v="dash" class="on"><i class="fa-solid fa-gauge-high w-5"></i>Dashboard</a>
      <a href="#" data-v="plan-calendar"><i class="fa-solid fa-calendar-check w-5"></i>Training Plan Calendar</a>
      <a href="#" data-v="create-class"><i class="fa-solid fa-calendar-plus w-5"></i>Create Classes</a>
      <a href="#" data-v="bookings"><i class="fa-solid fa-clipboard-list w-5"></i>Booked Classes (<?= count($classBookings) ?>)</a>
      <a href="#" data-v="notifications"><i class="fa-solid fa-bullhorn w-5"></i>Send Notifications</a>
      <a href="#" data-v="messages"><i class="fa-solid fa-comments w-5"></i>Member Messages</a>
      <a href="#" data-v="members"><i class="fa-solid fa-users w-5"></i>Manage Members (<?= count($members) ?>)</a>
    </nav>
  </aside>

  <!-- Main Content -->
  <main class="flex-1 min-w-0 space-y-5">
    
    <?php if (!empty($successMessage)): ?>
      <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 p-4 rounded-xl text-sm font-semibold">
        <?= htmlspecialchars($successMessage) ?>
      </div>
    <?php endif; ?>

    <!-- 1. DASHBOARD -->
    <section data-view="dash" class="view-section space-y-5">
      <h1 class="text-2xl font-extrabold text-sky-700">Coach Dashboard</h1>
      <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div class="card">
          <p class="text-xs font-semibold text-slate-500">Total Members</p>
          <b class="block text-3xl font-extrabold mt-1 text-slate-900"><?= count($members) ?></b>
        </div>
        <div class="card">
          <p class="text-xs font-semibold text-slate-500">Total Bookings Made</p>
          <b class="block text-3xl font-extrabold mt-1 text-sky-600"><?= count($classBookings) ?></b>
        </div>
        <div class="card">
          <p class="text-xs font-semibold text-slate-500">Database Table</p>
          <b class="block text-xl font-extrabold mt-1 text-emerald-600">gymnuser & records</b>
        </div>
      </div>
    </section>

    <!-- 2. TRAINING PLAN CALENDAR -->
    <section data-view="plan-calendar" class="view-section hidden card space-y-5">
      <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
          <h2 class="font-extrabold text-xl text-slate-900">Member Training Plan Calendar</h2>
          <p class="text-sm text-slate-500">Select a member and tick the calendar days they are scheduled to train.</p>
        </div>
        <form method="GET" action="trainer-dashboard.php" class="flex items-center gap-2">
          <input type="hidden" name="trainer" value="<?= $trainerId ?>">
          <input type="hidden" name="month" value="<?= $currentMonth ?>">
          <input type="hidden" name="year" value="<?= $currentYear ?>">
          <select name="member_id" onchange="this.form.submit()" class="inp text-sm font-semibold">
            <?php foreach ($members as $m): ?>
              <option value="<?= $m['user_id'] ?>" <?= $selectedMemberId === $m['user_id'] ? 'selected' : '' ?>>
                <?= htmlspecialchars($m['name']) ?> (<?= $m['id'] ?>)
              </option>
            <?php endforeach; ?>
          </select>
        </form>
      </div>

      <div class="flex items-center justify-between bg-slate-100 p-3 rounded-xl">
        <?php 
          $prevMonth = $currentMonth - 1;
          $prevYear = $currentYear;
          if ($prevMonth < 1) { $prevMonth = 12; $prevYear--; }

          $nextMonth = $currentMonth + 1;
          $nextYear = $currentYear;
          if ($nextMonth > 12) { $nextMonth = 1; $nextYear++; }
        ?>
        <a href="trainer-dashboard.php?trainer=<?= $trainerId ?>&member_id=<?= $selectedMemberId ?>&month=<?= $prevMonth ?>&year=<?= $prevYear ?>" class="btn bg-white border border-slate-200 text-xs font-bold px-3 py-1.5 hover:bg-slate-50">
          <i class="fa-solid fa-chevron-left mr-1"></i> Prev Month
        </a>
        <h3 class="font-extrabold text-base text-slate-800">
          <?= date('F Y', mktime(0, 0, 0, $currentMonth, 1, $currentYear)) ?>
        </h3>
        <a href="trainer-dashboard.php?trainer=<?= $trainerId ?>&member_id=<?= $selectedMemberId ?>&month=<?= $nextMonth ?>&year=<?= $nextYear ?>" class="btn bg-white border border-slate-200 text-xs font-bold px-3 py-1.5 hover:bg-slate-50">
          Next Month <i class="fa-solid fa-chevron-right ml-1"></i>
        </a>
      </div>

      <form method="POST" class="space-y-4">
        <input type="hidden" name="save_training_plan" value="1">
        <input type="hidden" name="plan_member_id" value="<?= $selectedMemberId ?>">
        
        <div class="grid grid-cols-7 gap-2 text-center">
          <div class="text-xs font-extrabold text-slate-400 py-1">Mon</div>
          <div class="text-xs font-extrabold text-slate-400 py-1">Tue</div>
          <div class="text-xs font-extrabold text-slate-400 py-1">Wed</div>
          <div class="text-xs font-extrabold text-slate-400 py-1">Thu</div>
          <div class="text-xs font-extrabold text-slate-400 py-1">Fri</div>
          <div class="text-xs font-extrabold text-slate-400 py-1">Sat</div>
          <div class="text-xs font-extrabold text-slate-400 py-1">Sun</div>

          <?php
            $totalDaysInMonth = cal_days_in_month(CAL_GREGORIAN, $currentMonth, $currentYear);
            $firstDayOfWeek = date('N', strtotime("$currentYear-$currentMonth-01"));
            
            for ($i = 1; $i < $firstDayOfWeek; $i++) {
                echo '<div class="h-20 bg-slate-50/50 rounded-xl border border-transparent"></div>';
            }

            for ($day = 1; $day <= $totalDaysInMonth; $day++) {
                $dateStr = sprintf('%04d-%02d-%02d', $currentYear, $currentMonth, $day);
                $isChecked = in_array($dateStr, $existingPlanDays);
                $isToday = ($dateStr === date('Y-m-d'));
          ?>
            <label class="h-24 p-2 rounded-xl border flex flex-col justify-between cursor-pointer transition-all select-none <?= $isChecked ? 'bg-sky-50 border-sky-400 shadow-sm' : 'bg-white border-slate-200 hover:border-slate-300' ?> <?= $isToday ? 'ring-2 ring-sky-500' : '' ?>">
              <div class="flex justify-between items-center w-full">
                <span class="text-xs font-extrabold <?= $isChecked ? 'text-sky-700' : 'text-slate-700' ?>"><?= $day ?></span>
                <input type="checkbox" name="training_days[]" value="<?= $dateStr ?>" <?= $isChecked ? 'checked' : '' ?> class="rounded text-sky-600 focus:ring-sky-500 w-4 h-4">
              </div>
              <div class="text-[10px] font-bold text-center <?= $isChecked ? 'text-sky-600 bg-sky-100/80 rounded py-0.5' : 'text-slate-400' ?>">
                <?= $isChecked ? 'Training' : 'Rest' ?>
              </div>
            </label>
          <?php } ?>
        </div>

        <div class="pt-3 flex justify-end">
          <button type="submit" class="btn btn-p px-6">Save Training Plan Schedule</button>
        </div>
      </form>
    </section>

    <!-- 3. CREATE CLASSES SECTION -->
    <section data-view="create-class" class="view-section hidden card space-y-5">
      <h2 class="font-extrabold text-xl text-slate-900">Create & Schedule Classes</h2>
      <p class="text-sm text-slate-500">Publish training sessions that members can book directly from their portal.</p>
      
      <form method="POST" class="grid grid-cols-1 sm:grid-cols-3 gap-4 mt-4">
        <input type="hidden" name="create_class" value="1">
        <div>
          <label class="block text-xs font-bold text-slate-700 mb-1">Class Name</label>
          <input type="text" name="class_name" required placeholder="e.g. Advanced Strength Circuit" class="inp">
        </div>
        <div>
          <label class="block text-xs font-bold text-slate-700 mb-1">Schedule Time</label>
          <input type="datetime-local" name="class_time" required class="inp">
        </div>
        <div>
          <label class="block text-xs font-bold text-slate-700 mb-1">Max Capacity</label>
          <input type="number" name="capacity" value="15" min="1" max="50" required class="inp">
        </div>
        <div class="sm:col-span-3">
          <button type="submit" class="btn btn-p px-6">Publish Class Slot</button>
        </div>
      </form>

      <div class="mt-8">
        <h3 class="font-extrabold text-lg text-slate-900 mb-3">Currently Scheduled Classes</h3>
        <div class="overflow-x-auto">
          <table class="w-full text-left text-sm">
            <thead>
              <tr class="border-b border-slate-200 text-slate-400 text-xs uppercase">
                <th class="py-3 px-3">Class Title</th>
                <th class="py-3 px-3">Scheduled Time</th>
                <th class="py-3 px-3">Capacity</th>
                <th class="py-3 px-3">Status</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
              <?php if (empty($classesList)): ?>
                <tr><td colspan="4" class="py-6 text-center text-slate-400">No classes created yet.</td></tr>
              <?php else: ?>
                <?php foreach ($classesList as$cls): ?>
                  <tr>
                    <td class="py-3 px-3 font-bold text-slate-900"><?= htmlspecialchars($cls['title']) ?></td>
                    <td class="py-3 px-3 text-slate-600"><?= htmlspecialchars($cls['start_time']) ?></td>
                    <td class="py-3 px-3 text-slate-500"><?= $cls['capacity'] ?> slots</td>
                    <td class="py-3 px-3"><span class="chip bg-sky-50 text-sky-700"><?= htmlspecialchars($cls['status']) ?></span></td>
                  </tr>
                <?php endforeach; ?>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
      </div>
    </section>

    <!-- 4. BOOKED CLASSES & ATTENDANCE -->
    <section data-view="bookings" class="view-section hidden card space-y-4">
      <div class="flex justify-between items-center">
        <h2 class="font-extrabold text-xl text-slate-900">Member Class Bookings</h2>
        <span class="chip bg-sky-100 text-sky-700"><?= count($classBookings) ?> Total Bookings</span>
      </div>
      <p class="text-sm text-slate-500">See which members have booked your classes in real-time.</p>
      
      <div class="overflow-x-auto mt-3">
        <table class="w-full text-left text-sm">
          <thead>
            <tr class="border-b border-slate-200 text-slate-400 text-xs uppercase">
              <th class="py-3 px-3">Booking ID</th>
              <th class="py-3 px-3">Member Name</th>
              <th class="py-3 px-3">Email</th>
              <th class="py-3 px-3">Booked Class</th>
              <th class="py-3 px-3">Schedule Time</th>
              <th class="py-3 px-3">Status</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-slate-100">
            <?php if (empty($classBookings)): ?>
              <tr><td colspan="6" class="py-6 text-center text-slate-400">No member class bookings found yet.</td></tr>
            <?php else: ?>
              <?php foreach ($classBookings as$b): ?>
                <tr class="hover:bg-slate-50">
                  <td class="py-3 px-3 font-mono text-xs">#<?= $b['booking_id'] ?></td>
                  <td class="py-3 px-3 font-bold text-slate-900"><?= htmlspecialchars($b['member_name']) ?></td>
                  <td class="py-3 px-3 text-slate-600 text-xs"><?= htmlspecialchars($b['member_email']) ?></td>
                  <td class="py-3 px-3 font-semibold text-sky-600"><?= htmlspecialchars($b['class_title']) ?></td>
                  <td class="py-3 px-3 text-slate-500 text-xs"><?= htmlspecialchars($b['booked_time']) ?></td>
                  <td class="py-3 px-3"><span class="chip bg-emerald-100 text-emerald-800"><?= htmlspecialchars($b['status']) ?></span></td>
                </tr>
              <?php endforeach; ?>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </section>

    <!-- 5. SEND NOTIFICATIONS SECTION (NEW) -->
    <section data-view="notifications" class="view-section hidden card space-y-5">
      <h2 class="font-extrabold text-xl text-slate-900">Send Notifications to Members</h2>
      <p class="text-sm text-slate-500">Broadcast important announcements or send targeted alerts directly to member portal feeds.</p>
      
      <form method="POST" class="space-y-4 mt-4">
        <input type="hidden" name="send_notification" value="1">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
          <div>
            <label class="block text-xs font-bold text-slate-700 mb-1">Notification Title</label>
            <input type="text" name="notif_title" required placeholder="e.g. Gym Schedule Update" class="inp">
          </div>
          <div>
            <label class="block text-xs font-bold text-slate-700 mb-1">Target Recipient</label>
            <select name="target_recipient" class="inp font-semibold">
              <option value="all">Broadcast to All Members</option>
              <?php foreach ($members as$m): ?>
                <option value="<?= $m['user_id'] ?>">Specific Member: <?= htmlspecialchars($m['name']) ?> (<?=$m['id'] ?>)</option>
              <?php endforeach; ?>
            </select>
          </div>
        </div>
        <div>
          <label class="block text-xs font-bold text-slate-700 mb-1">Message Body / Content</label>
          <textarea name="notif_body" rows="3" required placeholder="Type the notification details here..." class="inp"></textarea>
        </div>
        <div>
          <button type="submit" class="btn btn-p px-6">Send Notification</button>
        </div>
      </form>

      <div class="mt-8 pt-6 border-t border-slate-200">
        <h3 class="font-extrabold text-lg text-slate-900 mb-3">Notification History</h3>
        <div class="overflow-x-auto">
          <table class="w-full text-left text-sm">
            <thead>
              <tr class="border-b border-slate-200 text-slate-400 text-xs uppercase">
                <th class="py-3 px-3">Title</th>
                <th class="py-3 px-3">Content</th>
                <th class="py-3 px-3">Recipient</th>
                <th class="py-3 px-3">Timestamp</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
              <?php if (empty($sentNotifications)): ?>
                <tr><td colspan="4" class="py-6 text-center text-slate-400">No notifications sent yet.</td></tr>
              <?php else: ?>
                <?php foreach ($sentNotifications as $notif): ?>
                  <tr class="hover:bg-slate-50">
                    <td class="py-3 px-3 font-bold text-slate-900"><?= htmlspecialchars($notif['title']) ?></td>
                    <td class="py-3 px-3 text-slate-600"><?= htmlspecialchars($notif['body']) ?></td>
                    <td class="py-3 px-3"><span class="chip bg-sky-50 text-sky-700"><?= htmlspecialchars($notif['recipient']) ?></span></td>
                    <td class="py-3 px-3 text-slate-400 text-xs"><?= htmlspecialchars($notif['time']) ?></td>
                  </tr>
                <?php endforeach; ?>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
      </div>
    </section>

    <!-- 6. MEMBER MESSAGES (CHAT CENTER) -->
    <section data-view="messages" class="view-section hidden card space-y-4">
      <h2 class="font-extrabold text-xl text-slate-900">Member Messages & Chats</h2>
      <p class="text-sm text-slate-500">Select a member from your table database to chat with them in real-time.</p>
      
      <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mt-4">
        <div class="border-r border-slate-200 pr-3 space-y-2 max-h-[500px] overflow-y-auto">
          <?php if (empty($members)): ?>
            <p class="text-sm text-slate-400">No members have been assigned to you yet.</p>
          <?php else: ?>
            <?php foreach ($members as$m): ?>
              <a href="trainer-dashboard.php?trainer=<?= $trainerId ?>&member_id=<?= $m['user_id'] ?>" 
                 class="block p-3 rounded-xl border transition-all <?= $selectedMemberId ===$m['user_id'] ? 'bg-sky-50 border-sky-300 font-bold' : 'bg-white border-slate-200 hover:bg-slate-50' ?>">
                <p class="text-sm text-slate-900"><?= htmlspecialchars($m['name']) ?></p>
                <p class="text-xs text-slate-400 font-mono"><?= $m['id'] ?> | <?= htmlspecialchars($m['email']) ?></p>
              </a>
            <?php endforeach; ?>
          <?php endif; ?>
        </div>

        <div class="md:col-span-2 flex flex-col h-[500px] bg-slate-50 rounded-2xl border border-slate-200 p-4">
          <div class="border-b border-slate-200 pb-3 mb-3 flex items-center justify-between">
            <h3 class="font-bold text-slate-900">
              Chat Feed with Member ID: #<?= $selectedMemberId ?>
            </h3>
            <span class="chip bg-emerald-100 text-emerald-800">Connected</span>
          </div>

          <div class="flex-1 overflow-y-auto space-y-3 pr-2" id="chat-messages-box">
            <?php if (empty($activeChatMessages)): ?>
              <div class="h-full flex items-center justify-center text-slate-400 text-sm">
                No conversation history yet. Send a message below!
              </div>
            <?php else: ?>
              <?php foreach ($activeChatMessages as$msg): ?>
                <div class="flex <?= $msg['sender'] === 'trainer' ? 'justify-end' : 'justify-start' ?>">
                  <div class="max-w-[75%] rounded-xl px-4 py-2.5 text-sm <?= $msg['sender'] === 'trainer' ? 'bg-sky-600 text-white' : 'bg-white border border-slate-200 text-slate-800' ?>">
                    <p><?= htmlspecialchars($msg['body']) ?></p>
                    <span class="text-[10px] opacity-70 block mt-1 text-right"><?= $msg['time'] ?></span>
                  </div>
                </div>
              <?php endforeach; ?>
            <?php endif; ?>
          </div>

          <form method="POST" class="mt-3 flex gap-2 pt-3 border-t border-slate-200">
            <input type="hidden" name="send_message" value="1">
            <input type="hidden" name="target_user_id" value="<?= $selectedMemberId ?>">
            <input name="message_body" type="text" required placeholder="Type a message to member..." class="inp flex-1"/>
            <button type="submit" class="btn btn-p px-5">Send</button>
          </form>
        </div>
      </div>
    </section>

    <!-- 7. MANAGE MEMBERS -->
    <section data-view="members" class="view-section hidden card space-y-4">
      <h2 class="font-extrabold text-xl text-slate-900">Registered Gym Members (from `gymnuser`)</h2>
      <div class="overflow-x-auto mt-3">
        <table class="w-full text-left text-sm">
          <thead>
            <tr class="border-b border-slate-200 text-slate-400 text-xs uppercase">
              <th class="py-3 px-3">Member ID</th>
              <th class="py-3 px-3">Full Name</th>
              <th class="py-3 px-3">Email Address</th>
              <th class="py-3 px-3">Phone</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-slate-100">
            <?php if (empty($members)): ?>
              <tr><td colspan="4" class="py-6 text-center text-slate-400">No members found in database.</td></tr>
            <?php else: ?>
              <?php foreach ($members as$m): ?>
                <tr class="hover:bg-slate-50">
                  <td class="py-3 px-3 font-mono text-xs font-bold text-sky-600"><?= $m['id'] ?></td>
                  <td class="py-3 px-3 font-bold text-slate-900"><?= htmlspecialchars($m['name']) ?></td>
                  <td class="py-3 px-3 text-slate-600"><?= htmlspecialchars($m['email']) ?></td>
                  <td class="py-3 px-3 text-slate-500"><?= htmlspecialchars($m['phone']) ?></td>
                </tr>
              <?php endforeach; ?>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </section>

  </main>
</div>

<script>
const chatBox = document.getElementById('chat-messages-box');
if (chatBox) chatBox.scrollTop = chatBox.scrollHeight;

function showView(viewName) {
  document.querySelectorAll('.view-section').forEach(sec => sec.classList.add('hidden'));
  const target = document.querySelector('[data-view="' + viewName + '"]');
  if (target) target.classList.remove('hidden');

  document.querySelectorAll('#nav a').forEach(a => a.classList.toggle('on', a.dataset.v === viewName));
}

document.querySelectorAll('#nav a').forEach(a => {
  a.onclick = e => {
    e.preventDefault();
    showView(a.dataset.v);
  };
});
</script>
</body>
</html>