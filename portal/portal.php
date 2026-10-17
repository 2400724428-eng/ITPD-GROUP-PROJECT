<?php
// portal.php — Member Portal with Database Subscriptions, WhatsApp Payment, & Approval-Based Access Control
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$dbPath = __DIR__ . '/../includes/db_connect.php';
if (file_exists($dbPath)) {
    require_once $dbPath;
} else {
    $altPath = __DIR__ . '/db_connect.php';
    if (file_exists($altPath)) {
        require_once $altPath;
    } else {
        die("<b>Database Error:</b> Could not find <code>db_connect.php</code>.");
    }
}

// Trainer/member assignments are stored in the same database as the existing gym tables.
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
    } catch (PDOException $e) {
        // A database account without CREATE permission should have the table created manually.
    }
}

$selectedUserId = isset($_GET['user_id']) ? (int)$_GET['user_id'] : 11;

// Calendar tracking variables for member plan view
$currentMonth = isset($_GET['month']) ? (int)$_GET['month'] : (int)date('m');
$currentYear = isset($_GET['year']) ? (int)$_GET['year'] : (int)date('Y');
$memberTrainingDays = [];
$memberNotifications = [];

// Handle AJAX / Form request to record payment attempt in gym_records (`gymn_suscrption`)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['log_subscription_attempt'])) {
    header('Content-Type: application/json');
    $planTitle = trim($_POST['plan_title'] ?? '');
    $amount = (int)($_POST['amount'] ?? 0);
    $memberName = trim($_POST['member_name'] ?? 'Member');

    if (!empty($planTitle) && isset($pdo)) {
        try {
            $payload = json_encode([
                'member_name' => $memberName,
                'plan' => $planTitle,
                'amount' => $amount,
                'payment_channel' => 'WhatsApp (0761448094)'
            ]);

            // Recorded into gym_records table with pending status awaiting admin approval
            $ins = $pdo->prepare("INSERT INTO gym_records (user_id, record_type, title, status, numeric_value, payload) VALUES (?, 'gymn_suscrption', ?, 'pending', ?, ?)");
            $ins->execute([$selectedUserId, $planTitle, $amount, $payload]);

            echo json_encode(['success' => true]);
            exit;
        } catch (\PDOException $ex) {
            echo json_encode(['success' => false, 'error' => $ex->getMessage()]);
            exit;
        }
    }
    echo json_encode(['success' => false, 'error' => 'Invalid data']);
    exit;
}

// Handle new message submission from member to trainer
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['send_message'])) {
    $msgBody = trim($_POST['message_body'] ?? '');
    if (!empty($msgBody) && isset($pdo)) {
        try {
            $payload = json_encode([
                'sender' => 'member',
                'body' => $msgBody
            ]);
            $ins = $pdo->prepare("INSERT INTO gym_records (user_id, record_type, title, status, payload) VALUES (?, 'message', ?, 'active', ?)");
            $ins->execute([$selectedUserId, $msgBody, $payload]);
            
            header("Location: portal.php?user_id=" . $selectedUserId);
            exit;
        } catch (\PDOException $ex) {
            $dbError = $ex->getMessage();
        }
    }
}

// Handle class booking / cancellation (Only permitted if subscription is approved)
$isSubscriptionApproved = false;

// Default fallbacks
$me = ['name' => 'Grace Nakato', 'id' => 'APX-0231', 'profile_pic' => ''];
$coach = ['name' => 'Coach James', 'exp' => '5 yrs', 'since' => '16 Oct', 'profile_pic' => ''];
$memList = []; $clsList = [];
$upcomingSessions = [];
$histList = []; $rewardList = [];
$chatList = [];
$workoutPlan = ['title' => 'General Fitness', 'notes' => 'Stay active and hydrated.', 'protein' => 130, 'water' => 2.5];
$pointsBalance = 0;
$debugRecordsFound = 0;
$bookedClassTitles = [];

if (isset($pdo)) {
    try {
        $stmtUser = $pdo->prepare("SELECT * FROM gymnuser WHERE user_id = ? LIMIT 1");
        $stmtUser->execute([$selectedUserId]);
        if ($userData = $stmtUser->fetch(PDO::FETCH_ASSOC)) {
            if (!empty($userData['email'])) {
                $parts = explode('@', $userData['email']);
                $me['name'] = ucfirst($userData['trainer_name'] ?? $userData['name'] ?? $parts[0]);
            }
            $me['id'] = 'APX-' . sprintf('%04d', $userData['user_id']);
            $me['profile_pic'] = $userData['profile_pic'] ?? $userData['avatar'] ?? '';
        }

        // Fetch user records (memberships, subscriptions, messages, bookings, etc.)
        $stmtRecords = $pdo->prepare("SELECT * FROM gym_records WHERE user_id = ? ORDER BY created_at ASC");
        $stmtRecords->execute([$selectedUserId]);
        while ($row = $stmtRecords->fetch(PDO::FETCH_ASSOC)) {
            $debugRecordsFound++;
            $payload = json_decode($row['payload'], true) ?? [];
            
            switch ($row['record_type']) {
                case 'gymn_suscrption':
                case 'subscription':
                case 'membership_plan':
                    if (strtolower($row['status']) === 'approved' || strtolower($row['status']) === 'active') {
                        $isSubscriptionApproved = true;
                    }
                    $memList[] = [
                        'ic' => 'fa-dumbbell', 
                        'c' => 'bg-sky-100 text-sky-600',
                        'n' => $row['title'] ?? 'Gym Membership', 
                        's' => ucfirst($row['status'] ?? 'Pending'), 
                        'a' => (int)($row['numeric_value'] ?? 0), 
                        'd' => date('d M Y', strtotime($row['created_at'])),
                        'l' => 22,
                        't' => 30
                    ];
                    break;

                case 'class_booking':
                    $bookedClassTitles[] = $row['title'];
                    $upcomingSessions[] = [
                        'n' => $row['title'],
                        'w' => !empty($row['start_time']) ? date('D g:i A', strtotime($row['start_time'])) : 'Scheduled'
                    ];
                    break;

                case 'message':
                    $sender = $payload['sender'] ?? 'member';
                    $chatList[] = [
                        'me' => ($sender === 'trainer') ? 0 : 1, 
                        'x' => $payload['body'] ?? $row['title'], 
                        't' => date('H:i', strtotime($row['created_at']))
                    ];
                    break;

                case 'workout_plan':
                    $workoutPlan['title'] = $row['title'] ?? 'Workout Plan';
                    $workoutPlan['protein'] = $payload['protein_g'] ?? 130;
                    $workoutPlan['water'] = $payload['water_litres'] ?? 2.5;
                    $workoutPlan['notes'] = $payload['nutrition_notes'] ?? '';
                    break;

                case 'reward_ledger':
                    $pointsBalance += (int)($row['numeric_value'] ?? 0);
                    break;
            }
        }

        // Fetch only the trainer assigned to this member. Never show an arbitrary trainer.
        $coachNameForBooking = 'Pending Assignment';
        $coach = ['name' => 'Pending Assignment', 'exp' => '', 'since' => '', 'profile_pic' => '', 'assigned' => false, 'trainer_id' => 0];
        $stmtCoach = $pdo->prepare("SELECT u.* FROM gym_trainer_assignments a
            INNER JOIN gymnuser u ON u.user_id = a.trainer_id
            WHERE a.member_id = ? AND LOWER(COALESCE(u.role, '')) = 'trainer' LIMIT 1");
        $stmtCoach->execute([$selectedUserId]);
        if ($t = $stmtCoach->fetch(PDO::FETCH_ASSOC)) {
            $rawName = $t['trainer_name'] ?? $t['name'] ?? '';
            if ($rawName === '' && !empty($t['email'])) $rawName = explode('@', $t['email'])[0];
            $coachNameForBooking = 'Coach ' . ucfirst($rawName ?: 'Trainer');
            $coach = [
                'name' => $coachNameForBooking,
                'exp' => '',
                'since' => '',
                'profile_pic' => $t['profile_pic'] ?? $t['avatar'] ?? '',
                'assigned' => true,
                'trainer_id' => (int)$t['user_id']
            ];
        }

        // Handle class booking / cancellation action only if subscription is approved
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['toggle_booking'])) {
            if ($isSubscriptionApproved) {
                $classTitle = trim($_POST['class_title'] ?? '');
                $classTime = trim($_POST['class_time'] ?? '');
                $trainerName = trim($_POST['trainer_name'] ?? $coachNameForBooking);
                $action = $_POST['action'] ?? 'book';

                if (!empty($classTitle)) {
                    if ($action === 'book') {
                        $bookingPayload = json_encode([
                            'booked_by' => $selectedUserId,
                            'member_name' => $me['name'],
                            'trainer_name' => $trainerName,
                            'class_time' => $classTime
                        ]);
                        $ins = $pdo->prepare("INSERT INTO gym_records (user_id, record_type, title, status, start_time, payload) VALUES (?, 'class_booking', ?, 'confirmed', ?, ?)");
                        $ins->execute([$selectedUserId, $classTitle, $classTime, $bookingPayload]);
                    } else {
                        $del = $pdo->prepare("DELETE FROM gym_records WHERE user_id = ? AND record_type = 'class_booking' AND title = ?");
                        $del->execute([$selectedUserId, $classTitle]);
                    }
                    header("Location: portal.php?user_id=" . $selectedUserId);
                    exit;
                }
            }
        }

        // Fetch Notifications sent to this member or broadcasted to all
        $stmtNotifs = $pdo->prepare("SELECT * FROM gym_records WHERE record_type = 'notification' AND (user_id = ? OR payload LIKE ?) ORDER BY created_at DESC");
        $stmtNotifs->execute([$selectedUserId, '%"recipient":"all"%']);
        while ($nRow = $stmtNotifs->fetch(PDO::FETCH_ASSOC)) {
            $nPayload = json_decode($nRow['payload'], true) ?? [];
            $memberNotifications[] = [
                'title' => $nRow['title'],
                'body' => $nPayload['body'] ?? '',
                'time' => date('D d M Y, g:i A', strtotime($nRow['created_at']))
            ];
        }

        // Fetch Trainer's ticked training plan days for this member for the active month
        $planTitle = "Plan-$currentYear-$currentMonth";
        $planStmt = $pdo->prepare("SELECT payload FROM gym_records WHERE user_id = ? AND record_type = 'training_plan' AND title = ? LIMIT 1");
        $planStmt->execute([$selectedUserId, $planTitle]);
        if ($pRow = $planStmt->fetch(PDO::FETCH_ASSOC)) {
            $pData = json_decode($pRow['payload'], true) ?? [];
            $memberTrainingDays = $pData['days'] ?? [];
        }

        // Fetch all classes created by trainers
        $stmtAllClasses = $pdo->query("SELECT * FROM gym_records WHERE record_type = 'class' ORDER BY created_at DESC");
        while ($cRow = $stmtAllClasses->fetch(PDO::FETCH_ASSOC)) {
            $cPayload = json_decode($cRow['payload'], true) ?? [];
            $isBooked = in_array($cRow['title'], $bookedClassTitles);
            $clsList[] = [
                'n' => $cRow['title'],
                'w' => !empty($cRow['start_time']) ? date('D g:i A', strtotime($cRow['start_time'])) : 'Scheduled',
                'raw_time' => $cRow['start_time'],
                'trainer' => $cPayload['trainer_name'] ?? $coachNameForBooking,
                'cap' => $cPayload['capacity'] ?? 15,
                'me' => $isBooked ? 1 : 0
            ];
        }

    } catch (\PDOException $ex) {
        $dbError = $ex->getMessage();
    }
}

// Fallbacks if empty
if (empty($memList)) {
    $memList = [['ic'=>'fa-dumbbell','c'=>'bg-amber-100 text-amber-700','n'=>'Gym Membership','s'=>'Pending Approval','a'=>150000,'d'=>date('d M Y'),'l'=>22,'t'=>30]];
}
if (empty($clsList)) {
    $clsList = [['n'=>'Strength Circuit','w'=>'Mon 6:00 PM','raw_time'=>'2026-10-19 18:00:00','trainer'=>$coach['name'],'cap'=>12,'me'=>0]];
}
if (empty($chatList)) {
    $chatList = [['me'=>0,'x'=>'Welcome to Pure Gain! Please submit your membership subscription payment to unlock full portal access.','t'=>'09:12']];
}
$histList = [['Today','Checked in at the gym'],['Yesterday','PT session with ' . $coach['name']]];
$rewardList = [['Free protein shake',200],['Gym towel',300],['30 min PT session',800]];
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1"/>
<title>Member Portal — <?= htmlspecialchars($me['name']) ?></title>
<script src="https://cdn.tailwindcss.com"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet"/>
<style>
  :root { --accent:#2563eb; }
  body { font-family:'Plus Jakarta Sans',sans-serif; -webkit-font-smoothing:antialiased; }
  .nav a { white-space:nowrap; display:flex; align-items:center; gap:12px; padding:14px 18px; font-size:13px; font-weight:700; color:#4b5563; border-bottom:1px solid #e2e2e2; }
  .nav a:hover { background:#e8e8e8; } .nav a.on { background:#fff; color:#111; box-shadow:inset 3px 0 0 var(--accent); }
  .card { background:#fff; border:1px solid #eef0f3; border-radius:20px; padding:20px; }
  .inp { width:100%; background:#f8fafc; border:1px solid #cbd5e1; border-radius:12px; padding:9px 12px; font-size:14px; }
  .inp:focus { outline:2px solid var(--accent); outline-offset:-1px; background:#fff; }
  .chip { font-size:11px; font-weight:700; border-radius:999px; padding:3px 10px; }
  .btn { font-size:13px; font-weight:700; border-radius:12px; padding:9px 14px; transition:background .2s; cursor:pointer; }
  .btn-p { background:var(--accent); color:#fff; } .btn-p:hover { background:#1d4ed8; }
  .btn-s { background:#f1f5f9; color:#334155; } .btn-s:hover { background:#e2e8f0; }
  
  /* Loading screen overlay */
  #whatsapp-loader {
    display: none;
    position: fixed;
    inset: 0;
    background: rgba(15, 23, 42, 0.85);
    z-index: 9999;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    color: white;
  }
  .spinner {
    width: 60px;
    height: 60px;
    border: 5px solid rgba(255, 255, 255, 0.2);
    border-top-color: #22c55e;
    border-radius: 50%;
    animation: spin 0.8s linear infinite;
  }
  @keyframes spin {
    to { transform: rotate(360deg); }
  }
</style>
</head>
<body class="bg-slate-50 text-slate-800 min-h-screen">

<!-- Custom Loading Screen Overlay -->
<div id="whatsapp-loader">
  <div class="spinner mb-4"></div>
  <h2 class="text-lg font-bold">Logging Payment & Connecting to WhatsApp...</h2>
  <p class="text-xs text-slate-300 mt-1">Redirecting you securely to admin at 0761448094</p>
</div>

<!-- Debug Banner -->
<div class="bg-slate-900 text-slate-200 text-xs py-1.5 px-4 text-center">
  DB Status: Connected | User ID: <b><?= $selectedUserId ?></b> | Subscription Status: <b><?= $isSubscriptionApproved ? 'Approved' : 'Pending Verification' ?></b>
</div>

<header class="sticky top-0 z-30 bg-white border-b border-slate-200">
  <div class="max-w-[1100px] mx-auto px-4 h-16 flex items-center justify-between">
    <div class="flex items-center gap-3">
      <?php 
        $hasMemberPic = !empty($me['profile_pic']) && file_exists(__DIR__ . '/../' . $me['profile_pic']);
      ?>
      <?php if ($hasMemberPic): ?>
        <img src="../<?= htmlspecialchars($me['profile_pic']) ?>" alt="Profile" class="w-10 h-10 rounded-full object-cover border border-slate-200" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';"/>
        <span class="w-10 h-10 rounded-full bg-blue-600 text-white font-extrabold items-center justify-center" style="display:none;" id="av"></span>
      <?php else: ?>
        <span class="w-10 h-10 rounded-full bg-blue-600 text-white font-extrabold flex items-center justify-center" id="av"></span>
      <?php endif; ?>
      <div class="leading-tight"><p class="font-bold text-slate-900 text-sm" id="hn"></p><p class="text-xs text-slate-500">ID: <?= htmlspecialchars($me['id']) ?></p></div>
    </div>
    <div class="text-xs text-slate-500 flex items-center gap-3">
      <span>Switch User ID: <a href="?user_id=10" class="underline text-blue-600 font-bold ml-1">Trainer (10)</a> | <a href="?user_id=11" class="underline text-blue-600 font-bold ml-1">Member (11)</a></span>
      <a href="trainer-dashboard.php?trainer=10&member_id=<?= $selectedUserId ?>" class="bg-sky-50 text-sky-700 px-3 py-1.5 rounded-lg border border-sky-200 font-bold">Trainer View</a>
    </div>
  </div>
</header>

<div class="max-w-[1100px] mx-auto px-4 py-6 flex flex-col lg:flex-row gap-6">
  <aside class="lg:w-56 shrink-0 bg-[#f1f1f1] rounded-2xl overflow-hidden self-start w-full">
    <nav class="nav flex lg:flex-col overflow-x-auto" id="nav">
      <a href="#" data-v="dash" class="on"><i class="fa-solid fa-gauge-high w-5"></i>Dashboard</a>
      <a href="#" data-v="coach"><i class="fa-solid fa-user-tie w-5"></i>My trainer</a>
      <a href="#" data-v="classes"><i class="fa-regular fa-calendar-check w-5"></i>Book classes</a>
      <a href="#" data-v="plan"><i class="fa-solid fa-dumbbell w-5"></i>My training plan</a>
      <a href="#" data-v="pay-fee"><i class="fa-brands fa-whatsapp w-5 text-emerald-600"></i>Pay Membership</a>
      <a href="#" data-v="hist"><i class="fa-solid fa-clock-rotate-left w-5"></i>History</a>
      <a href="#" data-v="pts"><i class="fa-solid fa-coins w-5"></i>Redeem points</a>
      <a href="#" data-v="note"><i class="fa-solid fa-bullhorn w-5"></i>Notifications (<?= count($memberNotifications) ?>)</a>
      <a href="#" data-v="acct"><i class="fa-regular fa-user w-5"></i>My account</a>
    </nav>
  </aside>

  <main class="flex-1 min-w-0 space-y-5">
    
    <!-- SUBSCRIPTION LOCK BANNER IF NOT APPROVED -->
    <?php if (!$isSubscriptionApproved): ?>
      <div class="bg-amber-50 border border-amber-200 text-amber-900 p-4 rounded-2xl flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3 text-sm">
        <div class="flex items-center gap-3">
          <i class="fa-solid fa-triangle-exclamation text-amber-600 text-xl"></i>
          <div>
            <b class="block font-bold">Subscription Pending Approval</b>
            <p class="text-xs text-amber-700 mt-0.5">Your payment attempt is recorded. Once an admin approves your subscription, full portal access will be granted.</p>
          </div>
        </div>
        <button onclick="show('pay-fee')" class="btn bg-amber-600 text-white hover:bg-amber-700 text-xs shrink-0">Pay / Renew Now</button>
      </div>
    <?php endif; ?>

    <!-- DASHBOARD VIEW -->
    <section data-view="dash" class="view-section space-y-5">
      <h1 class="text-2xl font-extrabold text-[#1e4fa3]" id="greet"></h1>
      <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 mt-4" id="stats"></div>
      <h2 class="font-extrabold text-lg mt-6">Gym Subscriptions & Payment Records</h2>
      <div id="mems" class="space-y-3 mt-3"></div>
      
      <div class="card mt-6">
        <h3 class="font-extrabold text-base mb-3">Your Booked Sessions</h3>
        <div class="divide-y divide-slate-100 text-sm">
          <?php if (empty($upcomingSessions)): ?>
            <p class="text-slate-400 py-2">No classes booked yet. Go to 'Book classes' to reserve a slot!</p>
          <?php else: ?>
            <?php foreach ($upcomingSessions as $us): ?>
              <div class="py-3 flex justify-between items-center">
                <div><b><?= htmlspecialchars($us['n']) ?></b><p class="text-xs text-slate-500"><?= htmlspecialchars($us['w']) ?></p></div>
                <span class="chip bg-emerald-100 text-emerald-800">Confirmed</span>
              </div>
            <?php endforeach; ?>
          <?php endif; ?>
        </div>
      </div>
    </section>

    <!-- MY TRAINER & CHAT VIEW -->
    <section data-view="coach" class="view-section hidden space-y-5">
      <h1 class="text-2xl font-extrabold text-[#1e4fa3]">My trainer</h1>
      <div class="rounded-3xl p-6 text-white bg-gradient-to-br from-blue-700 to-slate-900 flex items-center gap-5 flex-wrap">
        <?php 
          $hasCoachPic = !empty($coach['profile_pic']) && file_exists(__DIR__ . '/../' . $coach['profile_pic']);
        ?>
        <?php if ($hasCoachPic): ?>
          <img src="../<?= htmlspecialchars($coach['profile_pic']) ?>" alt="Coach" class="w-20 h-20 rounded-full object-cover border-2 border-white/30 shadow-md" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';"/>
          <span class="w-20 h-20 rounded-full bg-white/20 text-2xl font-extrabold items-center justify-center border-2 border-white/30" style="display:none;" id="cav"></span>
        <?php else: ?>
          <span class="w-20 h-20 rounded-full bg-white/20 text-2xl font-extrabold flex items-center justify-center" id="cav"></span>
        <?php endif; ?>
        <div class="min-w-0"><span class="chip bg-white/20"><?= !empty($coach['assigned']) ? 'Assigned trainer' : 'Assignment status' ?></span><h2 class="text-2xl font-extrabold mt-1" id="cn"></h2><p class="text-blue-100 text-sm"><?= !empty($coach['assigned']) ? 'Your assigned strength and conditioning coach' : 'Pending Assignment — the gym administrator has not assigned a trainer yet.' ?></p></div>
      </div>
      
      <div class="card">
        <h3 class="font-extrabold">Chat with <span id="cn2"></span></h3>
        <div id="chat" class="bg-slate-50 rounded-xl p-3 mt-3 h-64 overflow-y-auto space-y-3 text-sm">
          <?php if (empty($chatList)): ?>
            <div class="text-center text-slate-400 py-10">No messages yet. Say hello to your trainer!</div>
          <?php else: ?>
            <?php foreach ($chatList as $m): ?>
              <div class="flex <?= $m['me'] ? 'justify-end' : 'justify-start' ?>">
                <div class="max-w-[80%] rounded-xl px-4 py-2.5 <?= $m['me'] ? 'bg-blue-600 text-white' : 'bg-white border border-slate-200 text-slate-800' ?>">
                  <p><?= htmlspecialchars($m['x']) ?></p>
                  <span class="text-[10px] opacity-60 block mt-1 text-right"><?= $m['t'] ?></span>
                </div>
              </div>
            <?php endforeach; ?>
          <?php endif; ?>
        </div>

        <?php if (!empty($coach['assigned'])): ?>
        <form method="POST" class="flex gap-2 mt-3">
          <input type="hidden" name="send_message" value="1">
          <input name="message_body" id="cm" required class="inp flex-1" placeholder="Type a message to your trainer..."/>
          <button type="submit" class="btn btn-p px-5">Send</button>
        </form>
        <?php else: ?>
        <p class="mt-3 rounded-xl bg-amber-50 border border-amber-200 p-3 text-sm text-amber-800">Messaging will become available after the administrator assigns your trainer.</p>
        <?php endif; ?>
      </div>
    </section>

    <!-- BOOK CLASSES VIEW -->
    <section data-view="classes" class="view-section card hidden space-y-4">
      <h2 class="font-extrabold text-lg">Available Classes (Created by Trainers)</h2>
      <?php if (!$isSubscriptionApproved): ?>
        <div class="bg-red-50 border border-red-200 text-red-700 p-3 rounded-xl text-xs font-semibold">
          <i class="fa-solid fa-lock mr-1"></i> Class booking is locked until your subscription payment is approved by administration.
        </div>
      <?php endif; ?>
      <div class="divide-y divide-slate-100 text-sm mt-3">
        <?php if (empty($clsList)): ?>
          <p class="text-slate-400 py-4">No classes available for booking right now.</p>
        <?php else: ?>
          <?php foreach ($clsList as $cls): ?>
            <div class="py-4 flex justify-between items-center flex-wrap gap-3">
              <div>
                <b class="text-base text-slate-900"><?= htmlspecialchars($cls['n']) ?></b>
                <p class="text-xs text-slate-500 mt-0.5"><i class="fa-regular fa-clock mr-1"></i><?= htmlspecialchars($cls['w']) ?> • Trainer: <?= htmlspecialchars($cls['trainer']) ?> • Capacity: <?= $cls['cap'] ?></p>
              </div>
              <div>
                <?php if ($isSubscriptionApproved): ?>
                  <form method="POST">
                    <input type="hidden" name="toggle_booking" value="1">
                    <input type="hidden" name="class_title" value="<?= htmlspecialchars($cls['n']) ?>">
                    <input type="hidden" name="class_time" value="<?= htmlspecialchars($cls['raw_time']) ?>">
                    <input type="hidden" name="trainer_name" value="<?= htmlspecialchars($cls['trainer']) ?>">
                    <input type="hidden" name="action" value="<?= $cls['me'] ? 'cancel' : 'book' ?>">
                    <button type="submit" class="btn <?= $cls['me'] ? 'btn-s text-red-600' : 'btn-p' ?>">
                      <?= $cls['me'] ? 'Cancel Booking' : 'Book Class' ?>
                    </button>
                  </form>
                <?php else: ?>
                  <button disabled class="btn bg-slate-200 text-slate-400 cursor-not-allowed">Locked</button>
                <?php endif; ?>
              </div>
            </div>
          <?php endforeach; ?>
        <?php endif; ?>
      </div>
    </section>

    <!-- MY TRAINING PLAN CALENDAR VIEW -->
    <section data-view="plan" class="view-section card hidden space-y-5">
      <div class="flex justify-between items-center">
        <div>
          <h2 class="font-extrabold text-xl text-slate-900">My Training Schedule</h2>
          <p class="text-sm text-slate-500">View the training days assigned to you by your coach.</p>
        </div>
        <span class="chip bg-blue-100 text-blue-700"><?= count($memberTrainingDays) ?> Training Days Scheduled</span>
      </div>

      <!-- Month Navigation Bar -->
      <div class="flex items-center justify-between bg-slate-100 p-3 rounded-xl mt-3">
        <?php 
          $prevMonth = $currentMonth - 1;
          $prevYear = $currentYear;
          if ($prevMonth < 1) { $prevMonth = 12; $prevYear--; }

          $nextMonth = $currentMonth + 1;
          $nextYear = $currentYear;
          if ($nextMonth > 12) { $nextMonth = 1; $nextYear++; }
        ?>
        <a href="portal.php?user_id=<?= $selectedUserId ?>&month=<?= $prevMonth ?>&year=<?= $prevYear ?>" class="btn bg-white border border-slate-200 text-xs font-bold px-3 py-1.5 hover:bg-slate-50">
          <i class="fa-solid fa-chevron-left mr-1"></i> Prev Month
        </a>
        <h3 class="font-extrabold text-base text-slate-800">
          <?= date('F Y', mktime(0, 0, 0, $currentMonth, 1, $currentYear)) ?>
        </h3>
        <a href="portal.php?user_id=<?= $selectedUserId ?>&month=<?= $nextMonth ?>&year=<?= $nextYear ?>" class="btn bg-white border border-slate-200 text-xs font-bold px-3 py-1.5 hover:bg-slate-50">
          Next Month <i class="fa-solid fa-chevron-right ml-1"></i>
        </a>
      </div>

      <!-- Calendar Grid Displaying Ticked Days -->
      <div class="grid grid-cols-7 gap-2 text-center mt-3">
        <div class="text-xs font-extrabold text-slate-400 py-1">Mon</div>
        <div class="text-xs font-extrabold text-slate-400 py-1">Tue</div>
        <div class="text-xs font-extrabold text-slate-400 py-1">Wed</div>
        <div class="text-xs font-extrabold text-slate-400 py-1">Thu</div>
        <div class="text-xs font-extrabold text-slate-400 py-1">Fri</div>
        <div class="text-xs font-extrabold text-slate-400 py-1">Sat</div>
        <div class="text-xs font-extrabold text-slate-400 py-1">Sun</div>

        <?php
          $totalDaysInMonth = cal_days_in_month(CAL_GREGORIAN, $currentMonth, $currentYear);$firstDayOfWeek = date('N', strtotime("$currentYear-$currentMonth-01"));
          
          for ($i = 1; $i < $firstDayOfWeek; $i++) {
              echo '<div class="h-20 bg-slate-50/50 rounded-xl border border-transparent"></div>';
          }

          for ($day = 1; $day <=$totalDaysInMonth; $day++) {$dateStr = sprintf('%04d-%02d-%02d', $currentYear,$currentMonth, $day);$isTrainingDay = in_array($dateStr,$memberTrainingDays);
              $isToday = ($dateStr === date('Y-m-d'));
        ?>
          <div class="h-24 p-2 rounded-xl border flex flex-col justify-between select-none <?= $isTrainingDay ? 'bg-blue-50 border-blue-400 shadow-sm' : 'bg-white border-slate-200 opacity-70' ?> <?= $isToday ? 'ring-2 ring-blue-500' : '' ?>">
            <div class="flex justify-between items-center w-full">
              <span class="text-xs font-extrabold <?= $isTrainingDay ? 'text-blue-700' : 'text-slate-700' ?>"><?= $day ?></span>
              <?php if ($isTrainingDay): ?>
                <i class="fa-solid fa-circle-check text-blue-600 text-xs"></i>
              <?php endif; ?>
            </div>
            <div class="text-[10px] font-bold text-center <?= $isTrainingDay ? 'text-blue-700 bg-blue-100 rounded py-0.5' : 'text-slate-400' ?>">
              <?= $isTrainingDay ? 'Training Day' : 'Rest' ?>
            </div>
          </div>
        <?php } ?>
      </div>
    </section>

    <!-- PAY MEMBERSHIP FEE VIA WHATSAPP VIEW -->
    <section data-view="pay-fee" class="view-section card hidden space-y-6">
      <div>
        <h2 class="font-extrabold text-xl text-slate-900">Pay Membership Fee via WhatsApp</h2>
        <p class="text-sm text-slate-500 mt-1">Select your subscription plan. This will log your payment attempt in our database as <b>Pending</b> and route you to admin WhatsApp at <b class="text-slate-800">+256 761 448094</b>.</p>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
        <!-- Monthly Plan Card -->
        <div class="border border-slate-200 rounded-2xl p-5 bg-gradient-to-b from-white to-slate-50 flex flex-col justify-between space-y-4">
          <div>
            <span class="chip bg-blue-100 text-blue-700">Monthly Plan</span>
            <h3 class="text-2xl font-extrabold text-slate-900 mt-2">UGX 150,000 <span class="text-xs font-normal text-slate-500">/ month</span></h3>
            <p class="text-sm text-slate-600 mt-2">Full access to gym equipment, locker rooms, and standard group training classes.</p>
          </div>
          <button onclick="payViaWhatsApp('Monthly Gym Membership', 150000)" class="w-full btn bg-emerald-600 text-white hover:bg-emerald-700 flex items-center justify-center gap-2 py-3">
            <i class="fa-brands fa-whatsapp text-lg"></i> Pay Monthly via WhatsApp
          </button>
        </div>

        <!-- Annual Plan Card -->
        <div class="border-2 border-blue-500 rounded-2xl p-5 bg-gradient-to-b from-blue-50/50 to-white flex flex-col justify-between space-y-4 shadow-sm">
          <div>
            <div class="flex justify-between items-center">
              <span class="chip bg-blue-600 text-white">Annual Plan</span>
              <span class="text-[10px] font-extrabold text-emerald-700 bg-emerald-100 px-2 py-0.5 rounded-full">Save 20%</span>
            </div>
            <h3 class="text-2xl font-extrabold text-slate-900 mt-2">UGX 1,440,000 <span class="text-xs font-normal text-slate-500">/ year</span></h3>
            <p class="text-sm text-slate-600 mt-2">Unlimited annual access, free PT assessment, VIP priority booking, and custom nutrition guidance.</p>
          </div>
          <button onclick="payViaWhatsApp('Annual Gym Membership', 1440000)" class="w-full btn bg-emerald-600 text-white hover:bg-emerald-700 flex items-center justify-center gap-2 py-3">
            <i class="fa-brands fa-whatsapp text-lg"></i> Pay Annual via WhatsApp
          </button>
        </div>
      </div>
    </section>

    <!-- NOTIFICATIONS VIEW -->
    <section data-view="note" class="view-section card hidden space-y-4">
      <div class="flex justify-between items-center">
        <h2 class="font-extrabold text-xl text-slate-900">Notifications & Announcements</h2>
        <span class="chip bg-blue-100 text-blue-700"><?= count($memberNotifications) ?> Total</span>
      </div>
      <p class="text-sm text-slate-500">Read announcements and direct alerts sent to you by your trainers.</p>
      
      <div class="divide-y divide-slate-100 mt-2">
        <?php if (empty($memberNotifications)): ?>
          <div class="py-8 text-center text-slate-400 text-sm">
            <i class="fa-regular fa-bell-slash text-2xl mb-2 block"></i>
            No notifications found right now.
          </div>
        <?php else: ?>
          <?php foreach ($memberNotifications as $notif): ?>
            <div class="py-4 space-y-1">
              <div class="flex justify-between items-center">
                <h3 class="font-bold text-slate-900 text-base"><?= htmlspecialchars($notif['title']) ?></h3>
                <span class="text-xs text-slate-400"><?= htmlspecialchars($notif['time']) ?></span>
              </div>
              <p class="text-sm text-slate-600"><?= htmlspecialchars($notif['body']) ?></p>
            </div>
          <?php endforeach; ?>
        <?php endif; ?>
      </div>
    </section>

    <!-- OTHER VIEWS -->
    <section data-view="hist" class="view-section card hidden"><h2 class="font-extrabold text-lg">History</h2><ul id="hist" class="mt-3 divide-y divide-slate-100 text-sm"></ul></section>
    <section data-view="pts" class="view-section card hidden"><div class="flex justify-between items-end"><h2 class="font-extrabold text-lg">Redeem points</h2><p class="text-sm">Balance <b class="text-2xl text-blue-600" id="bal"></b></p></div></section>
    <section data-view="acct" class="view-section card hidden"><h2 class="font-extrabold text-lg">My account</h2><div class="mt-3 space-y-3 max-w-md"><label class="block text-sm font-bold">Full name</label><input id="an" class="inp" value="<?= htmlspecialchars($me['name']) ?>"/></div></section>
  </main>
</div>

<script>
const $ = id => document.getElementById(id);
const ini = n => (n || 'User').split(/\s+/).filter(Boolean).slice(0, 2).map(w => w[0].toUpperCase()).join('');

const C = <?= json_encode($coach, JSON_HEX_TAG | JSON_HEX_AMP) ?>;
const ME = <?= json_encode($me, JSON_HEX_TAG | JSON_HEX_AMP) ?>;
let pts = <?= (int)$pointsBalance ?>, name = ME.name;
const MEM = <?= json_encode($memList, JSON_HEX_TAG | JSON_HEX_AMP) ?>;

if($('av'))$('av').textContent = ini(name);
if($('hn'))$('hn').textContent = name;
if($('cav'))$('cav').textContent = ini(C.name);
if($('cn'))$('cn').textContent = C.name;
if($('cn2'))$('cn2').textContent = C.name;
if($('greet'))$('greet').textContent = 'Welcome back, ' + name.split(' ')[0];

if($('stats')) {$('stats').innerHTML = `<div class="bg-white border border-slate-200 rounded-2xl p-4"><p class="text-xs font-semibold text-slate-500">Visits</p><b class="block text-2xl font-extrabold mt-1">14</b></div>` +
                         `<div class="bg-white border border-slate-200 rounded-2xl p-4"><p class="text-xs font-semibold text-slate-500">PT Sessions</p><b class="block text-2xl font-extrabold mt-1">2</b></div>`;
}

if($('mems')) {$('mems').innerHTML = MEM.map(m => `<div class="card !p-3 flex gap-4 items-center flex-wrap"><span class="w-14 h-14 rounded-xl flex items-center justify-center text-xl ${m.c}"><i class="fa-solid ${m.ic}"></i></span><div class="flex-1"><b>${m.n}</b><p class="text-xs text-slate-500">${m.s} • UGX ${m.a.toLocaleString()}</p></div></div>`).join('');
}

const chatBox = $('chat');
if(chatBox) chatBox.scrollTop = chatBox.scrollHeight;

function show(v) {
  document.querySelectorAll('.view-section').forEach(x => x.classList.add('hidden'));
  const target = document.querySelector('[data-view="' + v + '"]');
  if (target) target.classList.remove('hidden');
  document.querySelectorAll('#nav a').forEach(a => a.classList.toggle('on', a.dataset.v === v));
}

document.querySelectorAll('#nav a').forEach(a => {
  a.onclick = e => { e.preventDefault(); show(a.dataset.v); };
});

// Log payment attempt in database via AJAX, show spinner loader, and redirect to WhatsApp
async function payViaWhatsApp(planTitle, amount) {
  const loader = $('whatsapp-loader');
  if (loader) loader.style.display = 'flex';

  try {
    const formData = new URLSearchParams();
    formData.append('log_subscription_attempt', '1');
    formData.append('plan_title', planTitle);
    formData.append('amount', amount);
    formData.append('member_name', ME.name);

    await fetch('portal.php?user_id=<?= $selectedUserId ?>', {
      method: 'POST',
      headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
      body: formData.toString()
    });
  } catch (err) {
    console.error('Failed to log payment attempt:', err);
  }

  const message = `Hello Admin, I have initiated a payment for my gym membership.\n\n*Plan:* ${planTitle}\n*Amount:* UGX ${amount.toLocaleString()}\n*Member Name:* ${ME.name}\n*Member ID:* ${ME.id}\n\nPlease verify and approve my subscription.`;
  const encodedMessage = encodeURIComponent(message);
  const whatsappUrl = `https://wa.me/256761448094?text=${encodedMessage}`;

  setTimeout(() => {
    window.location.href = whatsappUrl;
    setTimeout(() => {
      if (loader) loader.style.display = 'none';
    }, 2000);
  }, 1200);
}
</script>
</body>
</html>