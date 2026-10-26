<?php
// portal.php — Member Portal with Database Subscriptions, WhatsApp Payment, & Approval-Based Access Control
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

ob_start();
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

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

// Trainer/member assignments table check
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
        // Table may already exist or need manual creation
    }
}

$selectedUserId = isset($_GET['user_id']) ? (int)$_GET['user_id'] : 11;

// Calendar tracking variables for member plan view
$currentMonth = isset($_GET['month']) ? (int)$_GET['month'] : (int)date('m');
$currentYear = isset($_GET['year']) ? (int)$_GET['year'] : (int)date('Y');
$memberTrainingDays = [];
$memberNotifications = [];

// ================================================================
// Handle AJAX / Form request to record payment attempt (gymn_suscrption)
// ================================================================
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

// ================================================================
// Handle member check-in / check-out (from dashboard card)
// ================================================================
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['toggle_checkin'])) {
    if (isset($pdo)) {
        try {
            $action = $_POST['checkin_action'] ?? 'in';

            if ($action === 'in') {
                $payload = json_encode([
                    'member_name' => $me['name'] ?? 'Member',
                    'source'      => 'portal',
                ]);
                $ins = $pdo->prepare(
                    "INSERT INTO gym_records (user_id, record_type, title, status, payload)
                     VALUES (?, 'check_in', 'Gym Check-in', 'active', ?)"
                );
                $ins->execute([$selectedUserId, $payload]);
            } else {
                $ins = $pdo->prepare(
                    "INSERT INTO gym_records (user_id, record_type, title, status, payload)
                     VALUES (?, 'check_out', 'Gym Check-out', 'active', ?)"
                );
                $ins->execute([$selectedUserId, json_encode(['member_name' => $me['name'] ?? 'Member'])]);
            }

            header("Location: portal.php?user_id=" . $selectedUserId);
            exit;
        } catch (\PDOException $ex) {
            $dbError = $ex->getMessage();
        }
    }
}

$isSubscriptionApproved = false;

$me = [
    'name' => 'Macarthyjunior',
    'id' => 'APX-0011',
    'profile_pic' => '../uploads/avatars/user_1792216008_7121.jpg'
];

$coach = ['name' => 'Coach Arnold S.', 'exp' => '5 yrs', 'since' => '16 Oct', 'profile_pic' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuBF9x9QZJ9ypx5PJH1tByBvRr23sqBXPV1kqnk6tYNUPjMsqcmOjT7o5cWB4p73heSoFaNblDyvAPvAxkfEOj72FiYvX6g1yU_ZIMjyu1xdnXHEj7EUzXeV6W-wMzscaxRte12UBWHFzY22Cw9EqgLKc0cUG2kTndrprxuqNytc0efn-Ai8IHQDuuCPC2DdLA2Yca8kmPnO36mAk8_0MVJUKxmxp8ixc_JC_x7sjTwSDc6b-mPY2X4BTA'];
$memList = []; $clsList = [];
$upcomingSessions = [];
$chatList = [];
$workoutPlan = ['title' => 'General Fitness', 'notes' => 'Stay active and hydrated.', 'protein' => 130, 'water' => 2.5];
$bookedClassTitles = [];

// ================================================================
// CHECK-IN STATS (from gym_records) — computed before any rendering
// ================================================================
$todayCheckins    = 0;
$currentOccupancy = 0;
$peakHour         = '—';
$isCheckedInToday = false;
$gymCapacity      = 50; // adjust to your real max occupancy

if (isset($pdo)) {
    try {
        // How many check-ins today (all members)
        $todayCheckins = (int)$pdo->query(
            "SELECT COUNT(*) FROM gym_records
             WHERE record_type = 'check_in'
               AND DATE(created_at) = CURDATE()"
        )->fetchColumn();

        // Currently inside = checked in today but not yet checked out
        $currentOccupancy = (int)$pdo->query(
            "SELECT COUNT(DISTINCT user_id) FROM gym_records
             WHERE record_type = 'check_in'
               AND DATE(created_at) = CURDATE()
               AND user_id NOT IN (
                 SELECT user_id FROM gym_records
                 WHERE record_type = 'check_out'
                   AND DATE(created_at) = CURDATE()
               )"
        )->fetchColumn();

        // Did THIS member check in today already?
        $stmtMe = $pdo->prepare(
            "SELECT COUNT(*) FROM gym_records
             WHERE record_type = 'check_in'
               AND user_id = ?
               AND DATE(created_at) = CURDATE()"
        );
        $stmtMe->execute([$selectedUserId]);
        $isCheckedInToday = ((int)$stmtMe->fetchColumn()) > 0;

        // Peak hour today
        $peakRow = $pdo->query(
            "SELECT HOUR(created_at) AS h, COUNT(*) AS c
             FROM gym_records
             WHERE record_type = 'check_in' AND DATE(created_at) = CURDATE()
             GROUP BY HOUR(created_at) ORDER BY c DESC LIMIT 1"
        )->fetch(PDO::FETCH_ASSOC);
        if ($peakRow && isset($peakRow['h'])) {
            $h = (int)$peakRow['h'];
            $suffix = ($h >= 12) ? 'PM' : 'AM';
            $h12 = $h % 12; if ($h12 === 0) $h12 = 12;
            $peakHour = $h12 . ':00 ' . $suffix;
        }
    } catch (\PDOException $e) {
        $dbError = $e->getMessage();
    }
}

// Occupancy % of gym capacity (clamped to 100)
$occupancyPct = $gymCapacity > 0
    ? min(100, (int)round(($currentOccupancy / $gymCapacity) * 100))
    : 0;

// Traffic label
if ($occupancyPct < 30)      { $trafficLabel = 'Quiet';    $trafficColor = 'text-emerald-700 bg-emerald-100'; }
elseif ($occupancyPct < 70)  { $trafficLabel = 'Optimal';  $trafficColor = 'text-emerald-700 bg-emerald-100'; }
elseif ($occupancyPct < 90)  { $trafficLabel = 'Busy';     $trafficColor = 'text-amber-700 bg-amber-100'; }
else                         { $trafficLabel = 'Packed';   $trafficColor = 'text-rose-700 bg-rose-100'; }

// ================================================================
// Load member data, records, coach, classes, notifications
// ================================================================
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

            if (!empty($userData['profile_pic'])) {
                if (strpos($userData['profile_pic'], 'http') === 0) {
                    $me['profile_pic'] = $userData['profile_pic'];
                } else {
                    $me['profile_pic'] = '../' . ltrim($userData['profile_pic'], '/');
                }
            }
        }

        $stmtRecords = $pdo->prepare("SELECT * FROM gym_records WHERE user_id = ? ORDER BY created_at ASC");
        $stmtRecords->execute([$selectedUserId]);
        while ($row = $stmtRecords->fetch(PDO::FETCH_ASSOC)) {
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
                        'c' => 'bg-indigo-50 text-indigo-600',
                        'n' => $row['title'] ?? 'Gym Membership',
                        's' => ucfirst($row['status'] ?? 'Pending'),
                        'a' => (int)($row['numeric_value'] ?? 0),
                        'd' => date('d M Y', strtotime($row['created_at']))
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
            }
        }

        $coachNameForBooking = $coach['name'];
        $stmtCoach = $pdo->prepare("SELECT u.* FROM gym_trainer_assignments a
            INNER JOIN gymnuser u ON u.user_id = a.trainer_id
            WHERE a.member_id = ? AND LOWER(COALESCE(u.role, '')) = 'trainer' LIMIT 1");
        $stmtCoach->execute([$selectedUserId]);
        if ($t = $stmtCoach->fetch(PDO::FETCH_ASSOC)) {
            $rawName = $t['trainer_name'] ?? $t['name'] ?? '';
            if ($rawName === '' && !empty($t['email'])) $rawName = explode('@', $t['email'])[0];
            $coachNameForBooking = 'Coach ' . ucfirst($rawName ?: 'Trainer');

            $coachPic = $t['profile_pic'] ?? $t['avatar'] ?? '';
            if (!empty($coachPic)) {
                if (strpos($coachPic, 'http') === 0) {
                    $coachPic = $coachPic;
                } else {
                    $coachPic = '../' . ltrim($coachPic, '/');
                }
            } else {
                $coachPic = $coach['profile_pic'];
            }

            $coach = [
                'name' => $coachNameForBooking,
                'exp' => '',
                'since' => '',
                'profile_pic' => $coachPic,
                'assigned' => true,
                'trainer_id' => (int)$t['user_id']
            ];
        }

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

        $planTitle = "Plan-$currentYear-$currentMonth";
        $planStmt = $pdo->prepare("SELECT payload FROM gym_records WHERE user_id = ? AND record_type = 'training_plan' AND title = ? LIMIT 1");
        $planStmt->execute([$selectedUserId, $planTitle]);
        if ($pRow = $planStmt->fetch(PDO::FETCH_ASSOC)) {
            $pData = json_decode($pRow['payload'], true) ?? [];
            $memberTrainingDays = $pData['days'] ?? [];
        }

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

if (empty($memList)) {
    $memList = [
        ['ic'=>'fa-dumbbell','c'=>'bg-indigo-50 text-indigo-650','n'=>'Monthly Gym Membership','s'=>'Approved','a'=>150000,'d'=>'May 1, 2024'],
    ];
}
if (empty($clsList)) {
    $clsList = [
        ['n'=>'HIIT Bootcamp','w'=>'Today 6:00 PM','raw_time'=>'2026-10-18 18:00:00','trainer'=>$coach['name'],'cap'=>15,'me'=>1],
    ];
}
if (empty($chatList)) {
    $chatList = [['me'=>0,'x'=>'Welcome to pure Gain! Check your schedule and chat with your trainer here.','t'=>'09:12']];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>ApexFit - Member Dashboard</title>
<script src="https://cdn.tailwindcss.com"></script>
<link href="https://fonts.googleapis.com" rel="preconnect"/>
<link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect"/>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@500;600;700;800&family=Inter:wght@400;500;600&display=swap" rel="stylesheet"/>
<script>
    tailwind.config = {
      theme: {
        extend: {
          fontFamily: { sans: ['Plus Jakarta Sans', 'Inter', 'sans-serif'] },
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
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet"/>
<style>
    body {
      font-family: 'Plus Jakarta Sans', sans-serif;
      -webkit-font-smoothing: antialiased;
      background-color: #ffffff;
      color: #334155;
    }
    input::placeholder, textarea::placeholder {
      color: #94a3b8;
    }
    .screen-fade {
      animation: fadeIn 0.3s ease-in-out forwards;
    }
    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(6px); }
      to { opacity: 1; transform: translateY(0); }
    }
    .card { background:#fff; border:1px solid #e2e8f0; border-radius:12px; padding:20px; }
    .inp { width:100%; background:#f8fafc; border:1px solid #cbd5e1; border-radius:8px; padding:9px 12px; font-size:14px; }
    .inp:focus { outline:2px solid #2563eb; outline-offset:-1px; background:#fff; }
    .chip { font-size:11px; font-weight:700; border-radius:999px; padding:3px 10px; }
    .btn { font-size:13px; font-weight:700; border-radius:8px; padding:9px 14px; transition:background .2s; cursor:pointer; }
    .btn-p { background:#2563eb; color:#fff; } .btn-p:hover { background:#1d4ed8; }
    .btn-s { background:#f1f5f9; color:#334155; } .btn-s:hover { background:#e2e8f0; }
</style>
</head>
<body class="min-h-screen flex flex-col antialiased text-slate-800 pb-16 md:pb-0">

<div id="sidebar-backdrop" onclick="toggleMobileSidebar()" class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-40 hidden md:hidden"></div>

<div class="flex-1 flex overflow-hidden relative">

  <!-- Sidebar -->
  <aside id="app-sidebar" class="mobile-drawer w-64 border-r border-gray-200 bg-white flex flex-col shrink-0 select-none md:static md:translate-x-0 hidden md:flex" data-purpose="sidebar-navigation">
    <div class="p-4 sm:p-6 border-b border-gray-100 flex items-center justify-between gap-2">
      <div class="flex items-center gap-3">
        <img src="<?= htmlspecialchars($me['profile_pic']) ?>" alt="Profile" class="w-9 h-9 rounded-xl object-cover border border-slate-200 shadow-sm">
        <div class="leading-tight">
          <span class="font-bold text-sm text-slate-900 tracking-tight"><?= htmlspecialchars($me['name']) ?></span>
          <p class="text-[10px] text-slate-500">Member Portal</p>
        </div>
      </div>
    </div>

    <nav class="flex-1 pt-3 space-y-1 overflow-y-auto" id="nav">
      <button onclick="switchScreen('dash', this)" class="nav-item w-full relative flex items-center gap-3.5 px-6 py-3.5 text-sm font-medium bg-blue-50 text-blue-900 border-r-4 border-blue-600 transition-colors text-left">
        <i class="fa-solid fa-gauge-high w-5 text-blue-600 text-base"></i>
        <span>Dashboard</span>
      </button>

      <button onclick="switchScreen('coach', this)" class="nav-item w-full flex items-center gap-3.5 px-6 py-3.5 text-sm font-medium text-slate-600 hover:text-slate-900 hover:bg-slate-50 transition-colors text-left">
        <i class="fa-solid fa-user-tie w-5 text-slate-500 text-base"></i>
        <span>My Trainer</span>
      </button>

      <button onclick="switchScreen('classes', this)" class="nav-item w-full flex items-center justify-between px-6 py-3.5 text-sm font-medium text-slate-600 hover:text-slate-900 hover:bg-slate-50 transition-colors text-left">
        <div class="flex items-center gap-3.5">
          <i class="fa-regular fa-calendar-check w-5 text-slate-500 text-base"></i>
          <span>Book Classes</span>
        </div>
        <span class="px-2 py-0.5 text-xs font-semibold rounded-full bg-slate-100 text-slate-600"><?= count($clsList) ?></span>
      </button>

      <button onclick="switchScreen('plan', this)" class="nav-item w-full flex items-center gap-3.5 px-6 py-3.5 text-sm font-medium text-slate-600 hover:text-slate-900 hover:bg-slate-50 transition-colors text-left">
        <i class="fa-solid fa-dumbbell w-5 text-slate-500 text-base"></i>
        <span>Training Plan</span>
      </button>

      <button onclick="switchScreen('pay-fee', this)" class="nav-item w-full flex items-center gap-3.5 px-6 py-3.5 text-sm font-medium text-slate-600 hover:text-slate-900 hover:bg-slate-50 transition-colors text-left">
        <i class="fa-brands fa-whatsapp w-5 text-emerald-600 text-base"></i>
        <span>Pay Membership</span>
      </button>

      <button onclick="switchScreen('note', this)" class="nav-item w-full flex items-center justify-between px-6 py-3.5 text-sm font-medium text-slate-600 hover:text-slate-900 hover:bg-slate-50 transition-colors text-left">
        <div class="flex items-center gap-3.5">
          <i class="fa-solid fa-bullhorn w-5 text-slate-500 text-base"></i>
          <span>Notifications</span>
        </div>
        <span class="px-2 py-0.5 text-xs font-semibold rounded-full bg-rose-500 text-white"><?= count($memberNotifications) ?></span>
      </button>

      <button onclick="switchScreen('acct', this)" class="nav-item w-full flex items-center gap-3.5 px-6 py-3.5 text-sm font-medium text-slate-600 hover:text-slate-900 hover:bg-slate-50 transition-colors text-left">
        <i class="fa-regular fa-user w-5 text-slate-500 text-base"></i>
        <span>My Account</span>
      </button>
    </nav>
  </aside>

  <div class="flex-1 flex flex-col min-w-0 overflow-hidden">
    <header class="h-16 border-b border-gray-200 bg-white px-3 sm:px-8 flex items-center justify-between shrink-0 gap-2">
      <div class="flex items-center gap-2 sm:gap-3 flex-1 min-w-0">
        <div class="text-xs text-slate-500 font-medium flex items-center gap-2">
          <span>Subscription: <b class="<?= $isSubscriptionApproved ? 'text-emerald-600' : 'text-amber-600' ?>"><?= $isSubscriptionApproved ? 'Approved' : 'Pending Verification' ?></b></span>
          <span class="hidden sm:inline">•</span>
        </div>
      </div>

      <div class="flex items-center gap-3 shrink-0">
        <a href="trainer-dashboard.php?trainer=10&member_id=<?= $selectedUserId ?>" class="bg-blue-50 text-blue-700 border border-blue-200 px-3 py-1.5 rounded-lg text-xs font-bold hover:bg-blue-100 transition">Trainer View</a>
      </div>
    </header>

    <main class="flex-1 overflow-y-auto px-3 sm:px-10 py-5 sm:py-8 bg-slate-50 relative" data-purpose="main-content-area">

      <div id="screen-loading" class="absolute inset-0 bg-white/80 backdrop-blur-[2px] z-30 flex flex-col items-center justify-center transition-opacity duration-200 hidden">
        <div class="w-10 h-10 border-4 border-blue-600 border-t-transparent rounded-full animate-spin"></div>
        <p class="text-xs font-semibold text-slate-600 mt-3 tracking-wide">Loading...</p>
      </div>

      <?php if (!$isSubscriptionApproved): ?>
        <div class="mb-5 bg-amber-50 border border-amber-200 text-amber-900 p-4 rounded-xl flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3 text-sm shadow-sm">
          <div class="flex items-center gap-3">
            <i class="fa-solid fa-triangle-exclamation text-amber-600 text-2xl shrink-0"></i>
            <div>
              <b class="block font-bold">Subscription Pending Approval</b>
              <p class="text-xs text-amber-700 mt-0.5">Your payment is logged. Once an admin verifies and approves your subscription, class bookings & messaging will unlock.</p>
            </div>
          </div>
          <button onclick="switchScreen('pay-fee', document.querySelector('[data-mob-v=\'pay-fee\']'))" class="btn bg-amber-600 text-white hover:bg-amber-700 text-xs shrink-0 font-bold px-4 py-2">Pay / Renew Now</button>
        </div>
      <?php endif; ?>

      <!-- SCREEN 1: DASHBOARD -->
      <section id="screen-dash" class="space-y-6 screen-fade">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-1">
          <div>
            <div class="flex items-center space-x-2 text-xs font-semibold text-blue-700 uppercase tracking-wider mb-1">
              <span>Member Portal</span><span>•</span><span class="text-slate-500 font-medium">Dashboard</span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">Welcome back, <?= htmlspecialchars(explode(' ', $me['name'])[0]) ?>! 👋</h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-0.5">Here is your active membership status, booking overview, and trainer connection.</p>
          </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-4 sm:gap-5">
          <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-card">
            <div class="flex items-start justify-between">
              <span class="text-sm font-semibold text-slate-500">Pass Status</span>
              <span class="chip bg-emerald-50 text-emerald-700">Active</span>
            </div>
            <div class="mt-3">
              <span class="text-2xl font-extrabold text-slate-900 tracking-tight">Annual Pass</span>
              <p class="text-xs text-slate-500 mt-1">ID: <?= htmlspecialchars($me['id']) ?></p>
            </div>
          </div>
          <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-card">
            <div class="flex items-start justify-between">
              <span class="text-sm font-semibold text-slate-500">Assigned Trainer</span>
              <span class="chip bg-blue-50 text-blue-600">Connected</span>
            </div>
            <div class="mt-3 flex items-center gap-3">
              <?php if (!empty($coach['profile_pic'])): ?>
                <img src="<?= htmlspecialchars($coach['profile_pic']) ?>" alt="<?= htmlspecialchars($coach['name']) ?>"
                     class="w-10 h-10 rounded-full object-cover border border-slate-200 shrink-0"/>
              <?php else: ?>
                <span class="w-10 h-10 rounded-full bg-blue-600 text-white font-extrabold flex items-center justify-center text-sm shrink-0">
                  <?= strtoupper(substr($coach['name'], 0, 2)) ?>
                </span>
              <?php endif; ?>
              <div>
                <span class="text-lg font-bold text-slate-900 tracking-tight"><?= htmlspecialchars($coach['name']) ?></span>
                <p class="text-xs text-slate-500 mt-0.5">Ready for chat & plans</p>
              </div>
            </div>
          </div>

          <!-- ============================================================ -->
          <!-- NEW: LIVE GYM CHECK-IN CARD (replaces "Gym Occupancy")       -->
          <!-- ============================================================ -->
          <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-card">
            <div class="flex items-start justify-between">
              <span class="text-sm font-semibold text-slate-500">Gym Check-In</span>
              <span class="chip <?= $trafficColor ?>"><?= htmlspecialchars($trafficLabel) ?></span>
            </div>

            <div class="mt-3">
              <div class="flex items-baseline gap-2">
                <span class="text-2xl font-extrabold text-slate-900 tracking-tight">
                  <?= $currentOccupancy ?>
                </span>
                <span class="text-xs font-semibold text-slate-500">/ <?= $gymCapacity ?> inside</span>
              </div>
              <p class="text-xs text-slate-500 mt-1">
                <?= $todayCheckins ?> total check-ins today
                <?php if ($peakHour !== '—'): ?>
                  · Peak: <?= htmlspecialchars($peakHour) ?>
                <?php endif; ?>
              </p>
            </div>

            <!-- Occupancy bar -->
            <div class="mt-3 h-1.5 w-full bg-slate-100 rounded-full overflow-hidden">
              <div class="h-full rounded-full <?= $occupancyPct >= 90 ? 'bg-rose-500' : ($occupancyPct >= 70 ? 'bg-amber-500' : 'bg-emerald-500') ?>"
                   style="width: <?= $occupancyPct ?>%"></div>
            </div>

            <!-- Check-in / out button -->
            <form method="POST" class="mt-3">
              <input type="hidden" name="toggle_checkin" value="1">
              <input type="hidden" name="checkin_action" value="<?= $isCheckedInToday ? 'out' : 'in' ?>">
              <button type="submit"
                class="w-full text-xs font-bold px-4 py-2 rounded-lg transition
                       <?= $isCheckedInToday
                            ? 'bg-slate-100 text-slate-700 hover:bg-slate-200'
                            : 'bg-emerald-600 text-white hover:bg-emerald-700' ?>">
                <?= $isCheckedInToday
                      ? '<i class="fa-solid fa-right-from-bracket mr-1"></i> Check Out'
                      : '<i class="fa-solid fa-right-to-bracket mr-1"></i> Check In Now' ?>
              </button>
            </form>
          </div>
        </div>

        <div class="card space-y-4">
          <h2 class="font-extrabold text-xl text-slate-900">Gym Subscriptions & Payment Records</h2>
          <div class="space-y-3">
            <?php foreach ($memList as $m): ?>
              <div class="flex flex-col md:flex-row md:items-center justify-between rounded-xl border border-slate-200 p-4 gap-4 bg-slate-50/50">
                <div class="flex items-center gap-3">
                  <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center font-bold">
                    <i class="fa-solid <?= $m['ic'] ?? 'fa-dumbbell' ?>"></i>
                  </div>
                  <div>
                    <div class="flex items-center gap-2">
                      <h4 class="font-bold text-sm text-slate-900"><?= htmlspecialchars($m['n']) ?></h4>
                      <span class="chip <?= strtolower($m['s'])==='approved' ? 'bg-emerald-100 text-emerald-800' : 'bg-amber-100 text-amber-800' ?>"><?= htmlspecialchars($m['s']) ?></span>
                    </div>
                    <p class="text-xs text-slate-500 mt-0.5">UGX <?= number_format($m['a'] ?? 150000) ?> • <?= htmlspecialchars($m['d']) ?></p>
                  </div>
                </div>
                <button onclick="switchScreen('pay-fee', document.querySelector('[data-mob-v=\'pay-fee\']'))" class="btn btn-s text-xs font-bold px-4 py-2">Renew / Pay</button>
              </div>
            <?php endforeach; ?>
          </div>
        </div>
      </section>

      <!-- SCREEN 2: MY TRAINER (CHAT) -->
      <section id="screen-coach" class="space-y-4 screen-fade hidden card">
        <div class="flex items-center justify-between pb-3 border-b border-slate-100">
          <div class="flex items-center gap-3">
            <?php if (!empty($coach['profile_pic'])): ?>
              <img src="<?= htmlspecialchars($coach['profile_pic']) ?>" alt="<?= htmlspecialchars($coach['name']) ?>"
                   class="w-12 h-12 rounded-full object-cover border border-slate-200 shadow-sm shrink-0"/>
            <?php else: ?>
              <span class="w-12 h-12 rounded-full bg-blue-600 text-white font-extrabold flex items-center justify-center text-base shrink-0">
                <?= strtoupper(substr($coach['name'], 0, 2)) ?>
              </span>
            <?php endif; ?>
            <div>
              <h2 class="font-extrabold text-xl text-slate-900">My Trainer & Messages</h2>
              <p class="text-sm text-slate-500">Chat live with <?= htmlspecialchars($coach['name']) ?></p>
            </div>
          </div>
          <span class="chip bg-emerald-100 text-emerald-800">Assigned</span>
        </div>

        <div class="flex flex-col h-[450px] bg-slate-50 rounded-xl border border-slate-200 p-4 mt-3">
          <div class="flex-1 overflow-y-auto space-y-3 pr-2" id="chat-messages-box">
            <?php if (empty($chatList)): ?>
              <div class="h-full flex items-center justify-center text-slate-400 text-sm">No messages yet. Say hello to your coach!</div>
            <?php else: ?>
              <?php foreach ($chatList as $m): ?>
                <div class="flex items-end gap-2 <?= $m['me'] ? 'justify-end' : 'justify-start' ?>">
                  <?php if (!$m['me']): ?>
                    <?php if (!empty($coach['profile_pic'])): ?>
                      <img src="<?= htmlspecialchars($coach['profile_pic']) ?>" alt="<?= htmlspecialchars($coach['name']) ?>"
                           class="w-8 h-8 rounded-full object-cover border border-slate-200 shrink-0 mb-1"/>
                    <?php else: ?>
                      <span class="w-8 h-8 rounded-full bg-blue-600 text-white font-extrabold flex items-center justify-center text-xs shrink-0 mb-1">
                        <?= strtoupper(substr($coach['name'], 0, 2)) ?>
                      </span>
                    <?php endif; ?>
                  <?php endif; ?>

                  <div class="max-w-[75%] rounded-xl px-4 py-2.5 text-sm <?= $m['me'] ? 'bg-blue-600 text-white' : 'bg-white border border-slate-200 text-slate-800' ?>">
                    <p><?= htmlspecialchars($m['x']) ?></p>
                    <span class="text-[10px] opacity-70 block mt-1 text-right"><?= $m['t'] ?></span>
                  </div>

                  <?php if ($m['me'] && !empty($me['profile_pic'])): ?>
                    <img src="<?= htmlspecialchars($me['profile_pic']) ?>" alt="<?= htmlspecialchars($me['name']) ?>"
                         class="w-8 h-8 rounded-full object-cover border border-slate-200 shrink-0 mb-1"/>
                  <?php endif; ?>
                </div>
              <?php endforeach; ?>
            <?php endif; ?>
          </div>

          <form method="POST" class="mt-3 flex gap-2 pt-3 border-t border-slate-200">
            <input type="hidden" name="send_message" value="1">
            <input name="message_body" type="text" required placeholder="Type a message to your trainer..." class="inp flex-1"/>
            <button type="submit" class="btn btn-p px-5">Send</button>
          </form>
        </div>
      </section>

      <!-- SCREEN 3: BOOK CLASSES -->
      <section id="screen-classes" class="space-y-4 screen-fade hidden card">
        <div class="flex justify-between items-center">
          <h2 class="font-extrabold text-xl text-slate-900">Available Classes</h2>
          <span class="chip bg-blue-100 text-blue-700"><?= count($clsList) ?> Live Slots</span>
        </div>
        <?php if (!$isSubscriptionApproved): ?>
          <div class="bg-red-50 border border-red-200 text-red-700 p-3 rounded-xl text-xs font-semibold">
            <i class="fa-solid fa-lock mr-1"></i> Class booking is locked until your subscription payment is approved.
          </div>
        <?php endif; ?>

        <div class="divide-y divide-slate-100 text-sm mt-3">
          <?php foreach ($clsList as $cls): ?>
            <div class="py-4 flex justify-between items-center flex-wrap gap-3">
              <div>
                <b class="text-base text-slate-900"><?= htmlspecialchars($cls['n']) ?></b>
                <p class="text-xs text-slate-500 mt-0.5"><i class="fa-regular fa-clock mr-1"></i><?= htmlspecialchars($cls['w']) ?> • Trainer: <?= htmlspecialchars($cls['trainer']) ?></p>
              </div>
              <div>
                <?php if ($isSubscriptionApproved): ?>
                  <form method="POST">
                    <input type="hidden" name="toggle_booking" value="1">
                    <input type="hidden" name="class_title" value="<?= htmlspecialchars($cls['n']) ?>">
                    <input type="hidden" name="class_time" value="<?= htmlspecialchars($cls['raw_time']) ?>">
                    <input type="hidden" name="trainer_name" value="<?= htmlspecialchars($cls['trainer']) ?>">
                    <input type="hidden" name="action" value="<?= $cls['me'] ? 'cancel' : 'book' ?>">
                    <button type="submit" class="btn <?= $cls['me'] ? 'btn-s text-red-600 hover:bg-red-50' : 'btn-p' ?>">
                      <?= $cls['me'] ? 'Cancel Booking' : 'Book Class' ?>
                    </button>
                  </form>
                <?php else: ?>
                  <button disabled class="btn bg-slate-100 text-slate-400 cursor-not-allowed">Locked</button>
                <?php endif; ?>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      </section>

      <!-- SCREEN 4: TRAINING PLAN CALENDAR -->
      <section id="screen-plan" class="space-y-5 screen-fade hidden card">
        <div class="flex justify-between items-center">
          <div>
            <h2 class="font-extrabold text-xl text-slate-900">My Training Schedule</h2>
            <p class="text-sm text-slate-500">View training days scheduled by your coach.</p>
          </div>
          <span class="chip bg-blue-50 text-blue-700"><?= count($memberTrainingDays) ?> Days Scheduled</span>
        </div>

        <div class="flex items-center justify-between bg-slate-100 p-3 rounded-xl mt-3">
          <?php
            $prevMonth = $currentMonth - 1; $prevYear = $currentYear;
            if ($prevMonth < 1) { $prevMonth = 12; $prevYear--; }
            $nextMonth = $currentMonth + 1; $nextYear = $currentYear;
            if ($nextMonth > 12) { $nextMonth = 1; $nextYear++; }
          ?>
          <a href="?user_id=<?= $selectedUserId ?>&month=<?= $prevMonth ?>&year=<?= $prevYear ?>" class="btn bg-white border text-xs px-3 py-1.5"><i class="fa-solid fa-chevron-left mr-1"></i> Prev</a>
          <h3 class="font-extrabold text-sm text-slate-800"><?= date('F Y', mktime(0, 0, 0, $currentMonth, 1, $currentYear)) ?></h3>
          <a href="?user_id=<?= $selectedUserId ?>&month=<?= $nextMonth ?>&year=<?= $nextYear ?>" class="btn bg-white border text-xs px-3 py-1.5">Next <i class="fa-solid fa-chevron-right ml-1"></i></a>
        </div>

        <div class="grid grid-cols-7 gap-2 text-center mt-3">
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
            for ($i = 1; $i < $firstDayOfWeek; $i++) echo '<div class="h-20 bg-slate-50/50 rounded-xl"></div>';
            for ($day = 1; $day <= $totalDaysInMonth; $day++) {
                $dateStr = sprintf('%04d-%02d-%02d', $currentYear, $currentMonth, $day);
                $isTrainingDay = in_array($dateStr, $memberTrainingDays);
          ?>
            <div class="h-20 p-2 rounded-xl border flex flex-col justify-between <?= $isTrainingDay ? 'bg-blue-50 border-blue-400' : 'bg-white border-slate-200' ?>">
              <span class="text-xs font-bold <?= $isTrainingDay ? 'text-blue-700' : 'text-slate-700' ?>"><?= $day ?></span>
              <span class="text-[9px] font-bold <?= $isTrainingDay ? 'text-blue-700 bg-blue-100 rounded py-0.5' : 'text-slate-400' ?>"><?= $isTrainingDay ? 'Training' : 'Rest' ?></span>
            </div>
          <?php } ?>
        </div>
      </section>

      <!-- SCREEN 5: PAY MEMBERSHIP VIA WHATSAPP -->
      <section id="screen-pay-fee" class="space-y-6 screen-fade hidden card">
        <div>
          <h2 class="font-extrabold text-xl text-slate-900">Pay Membership Fee via WhatsApp</h2>
          <p class="text-sm text-slate-500 mt-1">Select your subscription plan. This will log your payment attempt in our database as <b>Pending</b> and route you securely to admin WhatsApp at <b class="text-slate-800">+256 761 448094</b>.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
          <div class="border border-slate-200 rounded-2xl p-5 bg-gradient-to-b from-white to-slate-50 flex flex-col justify-between space-y-4">
            <div>
              <span class="chip bg-blue-50 text-blue-700">Monthly Plan</span>
              <h3 class="text-2xl font-extrabold text-slate-900 mt-2">UGX 150,000 <span class="text-xs font-normal text-slate-500">/ mo</span></h3>
              <p class="text-sm text-slate-600 mt-2">Full access to gym equipment, locker rooms, and group training classes.</p>
            </div>
            <button onclick="payViaWhatsApp('Monthly Gym Membership', 150000)" class="w-full btn bg-emerald-600 text-white hover:bg-emerald-700 py-3">
              <i class="fa-brands fa-whatsapp text-lg"></i> Pay Monthly via WhatsApp
            </button>
          </div>

          <div class="border-2 border-blue-500 rounded-2xl p-5 bg-gradient-to-b from-blue-50/50 to-white flex flex-col justify-between space-y-4 shadow-sm">
            <div>
              <div class="flex justify-between items-center">
                <span class="chip bg-blue-600 text-white">Annual Plan</span>
                <span class="text-[10px] font-extrabold text-emerald-700 bg-emerald-100 px-2 py-0.5 rounded-full">Save 20%</span>
              </div>
              <h3 class="text-2xl font-extrabold text-slate-900 mt-2">UGX 1,440,000 <span class="text-xs font-normal text-slate-500">/ yr</span></h3>
              <p class="text-sm text-slate-600 mt-2">Unlimited annual access, free PT assessment, VIP priority booking, and custom nutrition guidance.</p>
            </div>
            <button onclick="payViaWhatsApp('Annual Gym Membership', 1440000)" class="w-full btn bg-emerald-600 text-white hover:bg-emerald-700 py-3">
              <i class="fa-brands fa-whatsapp text-lg"></i> Pay Annual via WhatsApp
            </button>
          </div>
        </div>
      </section>

      <!-- SCREEN 6: NOTIFICATIONS -->
      <section id="screen-note" class="space-y-4 screen-fade hidden card">
        <h2 class="font-extrabold text-xl text-slate-900">Notifications</h2>
        <div class="divide-y divide-slate-100">
          <?php if (empty($memberNotifications)): ?>
            <p class="text-slate-400 py-6 text-sm text-center">No notifications found right now.</p>
          <?php else: ?>
            <?php foreach ($memberNotifications as $notif): ?>
              <div class="py-4 space-y-1">
                <div class="flex justify-between items-center"><h3 class="font-bold text-slate-900"><?= htmlspecialchars($notif['title']) ?></h3><span class="text-xs text-slate-400"><?= htmlspecialchars($notif['time']) ?></span></div>
                <p class="text-sm text-slate-600"><?= htmlspecialchars($notif['body']) ?></p>
              </div>
            <?php endforeach; ?>
          <?php endif; ?>
        </div>
      </section>

      <!-- SCREEN 7: MY ACCOUNT -->
      <section id="screen-acct" class="space-y-4 screen-fade hidden card">
        <h2 class="font-extrabold text-xl text-slate-900">My Account Settings</h2>
        <div class="space-y-3 max-w-md">
          <label class="block text-xs font-bold text-slate-700">Full Name</label>
          <input class="inp" value="<?= htmlspecialchars($me['name']) ?>"/>
        </div>
      </section>

    </main>
  </div>
</div>

<!-- Mobile Bottom Navigation Bar -->
<nav aria-label="Mobile Bottom Navigation" class="fixed bottom-0 left-0 right-0 z-50 bg-white border-t border-slate-200/90 py-2 px-2 flex justify-around items-center md:hidden shadow-lg">
  <button onclick="switchScreen('dash', this)" data-mob-v="dash" class="mob-nav-item flex flex-col items-center justify-center text-blue-600 flex-1 py-1 focus:outline-none">
    <i class="fa-solid fa-gauge-high text-base mb-1"></i><span class="text-[10px] font-semibold">Home</span>
  </button>
  <button onclick="switchScreen('coach', this)" data-mob-v="coach" class="mob-nav-item flex flex-col items-center justify-center text-slate-500 hover:text-slate-800 flex-1 py-1 transition-colors focus:outline-none">
    <i class="fa-solid fa-user-tie text-base mb-1"></i><span class="text-[10px] font-medium">Trainer</span>
  </button>
  <button onclick="switchScreen('classes', this)" data-mob-v="classes" class="mob-nav-item flex flex-col items-center justify-center text-slate-500 hover:text-slate-800 flex-1 py-1 transition-colors focus:outline-none">
    <i class="fa-regular fa-calendar-check text-base mb-1"></i><span class="text-[10px] font-medium">Classes</span>
  </button>
  <button onclick="switchScreen('plan', this)" data-mob-v="plan" class="mob-nav-item flex flex-col items-center justify-center text-slate-500 hover:text-slate-800 flex-1 py-1 transition-colors focus:outline-none">
    <i class="fa-solid fa-dumbbell text-base mb-1"></i><span class="text-[10px] font-medium">Plan</span>
  </button>
  <button onclick="switchScreen('pay-fee', this)" data-mob-v="pay-fee" class="mob-nav-item flex flex-col items-center justify-center text-slate-500 hover:text-slate-800 flex-1 py-1 transition-colors focus:outline-none">
    <i class="fa-brands fa-whatsapp text-emerald-600 text-base mb-1"></i><span class="text-[10px] font-medium">Pay</span>
  </button>
  <button onclick="switchScreen('note', this)" data-mob-v="note" class="mob-nav-item flex flex-col items-center justify-center text-slate-500 hover:text-slate-800 flex-1 py-1 transition-colors relative focus:outline-none">
    <div class="relative">
      <i class="fa-solid fa-bullhorn text-base mb-1"></i>
      <span class="absolute -top-1 -right-2 w-1.5 h-1.5 bg-rose-500 rounded-full"></span>
    </div>
    <span class="text-[10px] font-medium">Alerts</span>
  </button>
</nav>

<script>
  const ME = <?= json_encode($me, JSON_HEX_TAG | JSON_HEX_AMP) ?>;

  function switchScreen(screenId, element) {
    const loader = document.getElementById('screen-loading');
    if (loader) loader.classList.remove('hidden');

    setTimeout(() => {
      document.querySelectorAll('main > section').forEach(screen => {
        screen.classList.add('hidden');
      });

      const target = document.getElementById('screen-' + screenId);
      if (target) {
        target.classList.remove('hidden');
      }

      document.querySelectorAll('.nav-item').forEach(item => {
        item.classList.remove('bg-blue-50', 'text-blue-900', 'border-r-4', 'border-blue-600', 'font-semibold');
        item.classList.add('text-slate-600');
        const icon = item.querySelector('i');
        if (icon) icon.classList.replace('text-blue-600', 'text-slate-500');
      });

      document.querySelectorAll('.mob-nav-item').forEach(item => {
        item.classList.remove('text-blue-600');
        item.classList.add('text-slate-500');
        const span = item.querySelector('span:last-child');
        if (span) span.className = "text-[10px] font-medium";
      });

      document.querySelectorAll('.nav-item').forEach(item => {
        if (item.getAttribute('onclick')?.includes("'" + screenId + "'")) {
          item.classList.remove('text-slate-600', 'hover:text-slate-900', 'hover:bg-slate-50');
          item.classList.add('bg-blue-50', 'text-blue-900', 'border-r-4', 'border-blue-600');
          const activeIcon = item.querySelector('i');
          if (activeIcon) activeIcon.classList.replace('text-slate-500', 'text-blue-600');
        }
      });

      if (element && element.classList.contains('mob-nav-item')) {
        element.classList.remove('text-slate-500');
        element.classList.add('text-blue-600');
        const span = element.querySelector('span:last-child');
        if (span) span.className = "text-[10px] font-semibold";
      }

      if (loader) loader.classList.add('hidden');
    }, 200);

    if (screenId === 'coach') {
      const chatBox = document.getElementById('chat-messages-box');
      if (chatBox) chatBox.scrollTop = chatBox.scrollHeight;
    }
  }

  async function payViaWhatsApp(planTitle, amount) {
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
    const whatsappUrl = `https://wa.me/256761448094?text=${encodeURIComponent(message)}`;
    window.location.href = whatsappUrl;
  }
</script>

</body>
</html>
<?php
ob_end_flush();
?>