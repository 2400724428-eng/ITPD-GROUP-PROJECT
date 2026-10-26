<?php
// trainer-dashboard.php — Trainer Portal with Class Bookings, Attendance, Training Plan Calendar, & Notifications
ob_start();
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

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

// ---- Resolve a DB avatar path into a working browser URL ----
function trainer_avatar_url(string $pic): string {
    if ($pic === '') return '';
    if (preg_match('#^https?://#i', $pic)) return $pic;

    $pic = ltrim($pic, '/');

    // Where this script lives on the web
    $script    = str_replace('\\', '/', $_SERVER['SCRIPT_NAME'] ?? '/trainer-dashboard.php');
    $scriptDir = rtrim(dirname($script), '/'); // e.g. /ITPD-GROUP-PROJECT-main  (or '' at root)

    // Find the actual project root on disk by walking up until we see an uploads/ folder
    $fsDir  = str_replace('\\', '/', __DIR__);
    $rootFs = $fsDir;
    for ($i = 0; $i < 4; $i++) {
        if (is_dir($rootFs . '/uploads')) break;
        $rootFs = dirname($rootFs);
    }

    // How many folders deep is this script from the project root?
    $depth = 0;
    $probe = $fsDir;
    while ($probe !== $rootFs && strlen($probe) > strlen($rootFs) && strpos($probe, $rootFs) === 0) {
        $depth++;
        $probe = dirname($probe);
    }

    // Trim that many segments off the script's web dir to get the project's web dir
    $segments = array_values(array_filter(explode('/', $scriptDir), 'strlen'));
    if ($depth > 0) {
        $segments = array_slice($segments, 0, max(0, count($segments) - $depth));
    }
    $base = '/' . implode('/', $segments);
    if ($base === '/') $base = '';

    return $base . '/' . $pic;
}

$trainer = [
    'name'  => 'Coach James',
    'email' => 'westboyboy373@gmail.com',
    'id'    => 'TRN-' . sprintf('%03d', $trainerId),
    'avatar'=> ''
];

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

            // Resolve the uploaded profile picture path via helper
            if (!empty($userData['profile_pic'])) {
                $trainer['avatar'] = trainer_avatar_url($userData['profile_pic']);
            }
        }

        // Handle trainer profile picture upload
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_trainer_photo'])) {
            if (!empty($_FILES['trainer_pic']['tmp_name'])
                && $_FILES['trainer_pic']['error'] === UPLOAD_ERR_OK
                && $_FILES['trainer_pic']['size'] <= 2 * 1024 * 1024) {

                // Find the actual uploads dir by walking up like the avatar helper does
                $fsDir  = str_replace('\\', '/', __DIR__);
                $rootFs = $fsDir;
                for ($i = 0; $i < 4; $i++) {
                    if (is_dir($rootFs . '/uploads')) break;
                    $rootFs = dirname($rootFs);
                }
                $uploadDir = rtrim($rootFs, '/') . '/uploads/avatars/';
                if (!is_dir($uploadDir)) @mkdir($uploadDir, 0755, true);

                $ext = strtolower(pathinfo($_FILES['trainer_pic']['name'], PATHINFO_EXTENSION));
                if (in_array($ext, ['jpg','jpeg','png','webp','gif'], true)
                    && @getimagesize($_FILES['trainer_pic']['tmp_name']) !== false) {

                    $fname = 'trainer_' . $trainerId . '_' . time() . '.' . $ext;
                    if (move_uploaded_file($_FILES['trainer_pic']['tmp_name'], $uploadDir . $fname)) {
                        $dbPath = 'uploads/avatars/' . $fname;
                        $upd = $pdo->prepare("UPDATE gymnuser SET profile_pic = ? WHERE user_id = ?");
                        $upd->execute([$dbPath, $trainerId]);
                        header("Location: trainer-dashboard.php?trainer=$trainerId");
                        exit;
                    }
                }
                $successMessage = "Upload failed: invalid image or too large (max 2 MB).";
            }
        }

        // Fetch ONLY the members assigned to this trainer — include avatar
        $stmtMembers = $pdo->prepare("SELECT u.* FROM gym_trainer_assignments a
            INNER JOIN gymnuser u ON u.user_id = a.member_id
            WHERE a.trainer_id = ? AND LOWER(COALESCE(u.role, '')) = 'member'
            ORDER BY a.assigned_at DESC");
        $stmtMembers->execute([$trainerId]);
        while ($mRow = $stmtMembers->fetch(PDO::FETCH_ASSOC)) {
            $mPic    = $mRow['profile_pic'] ?? '';
            $mAvatar = $mPic !== '' ? trainer_avatar_url($mPic) : '';

            $members[(int)$mRow['user_id']] = [
                'user_id' => (int)$mRow['user_id'],
                'id'      => 'APX-' . sprintf('%04d', $mRow['user_id']),
                'name'    => $mRow['trainer_name'] ?? ucfirst(explode('@', $mRow['email'])[0]),
                'email'   => $mRow['email'],
                'phone'   => $mRow['phone'] ?? 'N/A',
                'avatar'  => $mAvatar
            ];
        }

        // A trainer can never open a member who is not assigned to them
        if ($selectedMemberId !== 0 && !isset($members[$selectedMemberId])) {
            $selectedMemberId = 0;
        }
        if ($selectedMemberId === 0 && !empty($members)) {
            $selectedMemberId = array_key_first($members);
        }

        // ==================== DELETE HANDLERS ====================

        // Delete a single chat message
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_message_id'])) {
            $msgId = (int)$_POST['delete_message_id'];
            $mId   = (int)($_POST['msg_member_id'] ?? 0);
            if ($msgId > 0) {
                $delMsg = $pdo->prepare("DELETE FROM gym_records WHERE record_id = ? AND record_type = 'message' AND user_id = ?");
                $delMsg->execute([$msgId, $mId]);
                header("Location: trainer-dashboard.php?trainer=$trainerId&member_id=$mId&msg_deleted=1");
                exit;
            }
        }

        // Clear ALL chat messages with a specific member
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['clear_chat_member_id'])) {
            $mId = (int)$_POST['clear_chat_member_id'];
            if ($mId > 0 && isset($members[$mId])) {
                $clearChat = $pdo->prepare("DELETE FROM gym_records WHERE user_id = ? AND record_type = 'message'");
                $clearChat->execute([$mId]);
                header("Location: trainer-dashboard.php?trainer=$trainerId&member_id=$mId&chat_cleared=1");
                exit;
            }
        }

        // Delete a specific class booking
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_booking_id'])) {
            $bookingIdToDelete = (int)$_POST['delete_booking_id'];
            if ($bookingIdToDelete > 0) {
                $delStmt = $pdo->prepare("DELETE FROM gym_records WHERE record_id = ? AND record_type = 'class_booking'");
                $delStmt->execute([$bookingIdToDelete]);
                header("Location: trainer-dashboard.php?trainer=$trainerId&booking_deleted=1");
                exit;
            }
        }

        // Delete a class slot (the class itself, not a booking)
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_class_id'])) {
            $classIdToDelete = (int)$_POST['delete_class_id'];
            if ($classIdToDelete > 0) {
                $pdo->prepare("DELETE FROM gym_records WHERE record_type = 'class_booking' AND title = (SELECT title FROM gym_records WHERE record_id = ? AND record_type = 'class' LIMIT 1)")
                    ->execute([$classIdToDelete]);
                $delCls = $pdo->prepare("DELETE FROM gym_records WHERE record_id = ? AND record_type = 'class'");
                $delCls->execute([$classIdToDelete]);
                header("Location: trainer-dashboard.php?trainer=$trainerId&class_deleted=1");
                exit;
            }
        }

        // Clear all notifications sent by this trainer
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['clear_all_notifications'])) {
            $clearStmt = $pdo->prepare("DELETE FROM gym_records WHERE record_type = 'notification' AND target_user_id = ?");
            $clearStmt->execute([$trainerId]);
            header("Location: trainer-dashboard.php?trainer=$trainerId&notifs_cleared=1");
            exit;
        }

        // Delete a single notification
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_notification_id'])) {
            $notifRecordId = (int)$_POST['delete_notification_id'];
            if ($notifRecordId > 0) {
                $delNotif = $pdo->prepare("DELETE FROM gym_records WHERE record_id = ? AND record_type = 'notification' AND target_user_id = ?");
                $delNotif->execute([$notifRecordId, $trainerId]);
                header("Location: trainer-dashboard.php?trainer=$trainerId&notif_deleted=1");
                exit;
            }
        }

        // Handle flash messages
        if (isset($_GET['booking_deleted']))   $successMessage = "Class booking deleted successfully.";
        if (isset($_GET['class_deleted']))     $successMessage = "Class slot and its bookings removed.";
        if (isset($_GET['notif_deleted']))     $successMessage = "Notification deleted.";
        if (isset($_GET['notifs_cleared']))    $successMessage = "All sent notifications cleared.";
        if (isset($_GET['msg_deleted']))       $successMessage = "Message deleted.";
        if (isset($_GET['chat_cleared']))      $successMessage = "Chat history cleared with this member.";

        // ==================== END DELETE HANDLERS ====================

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
            $targetRecipient = $_POST['target_recipient'] ?? 'all';

            if (!empty($notifTitle) && !empty($notifBody)) {
                $payload = json_encode([
                    'trainer_id' => $trainerId,
                    'title' => $notifTitle,
                    'body' => $notifBody,
                    'recipient' => $targetRecipient
                ]);

                if ($targetRecipient === 'all') {
                    foreach ($members as $mId => $mDetails) {
                        $insNotif = $pdo->prepare("INSERT INTO gym_records (user_id, target_user_id, record_type, title, status, payload) VALUES (?, ?, 'notification', ?, 'active', ?)");
                        $insNotif->execute([$mId, $trainerId, $notifTitle, $payload]);
                    }
                    $successMessage = "Announcement broadcasted to all members!";
                } else {
                    $mId = (int)$targetRecipient;
                    $insNotif = $pdo->prepare("INSERT INTO gym_records (user_id, target_user_id, record_type, title, status, payload) VALUES (?, ?, 'notification', ?, 'active', ?)");
                    $insNotif->execute([$mId, $trainerId, $notifTitle, $payload]);
                    $successMessage = "Notification sent to member #$mId!";
                }
            }
        }

        // Handle saving training plan
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
                $successMessage = "Training calendar updated for member #$targetMember!";
            }
        }

        // Handle sending messages
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

        // Fetch existing training plan
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

        // Fetch all class bookings
        $stmtBookings = $pdo->query("SELECT * FROM gym_records WHERE record_type = 'class_booking' ORDER BY created_at DESC");
        while ($bRow = $stmtBookings->fetch(PDO::FETCH_ASSOC)) {
            $mId = (int)$bRow['user_id'];
            $memberName  = $members[$mId]['name']   ?? 'Member #' . $mId;
            $memberEmail = $members[$mId]['email']  ?? 'N/A';
            $memberAvatar= $members[$mId]['avatar'] ?? '';
            $classBookings[] = [
                'booking_id' => $bRow['record_id'],
                'member_id' => $mId,
                'member_name' => $memberName,
                'member_email' => $memberEmail,
                'member_avatar' => $memberAvatar,
                'class_title' => $bRow['title'],
                'booked_time' => !empty($bRow['start_time']) ? date('D d M Y, g:i A', strtotime($bRow['start_time'])) : 'Scheduled',
                'status' => ucfirst($bRow['status'] ?? 'confirmed')
            ];
        }

        // Fetch notifications
        $stmtNotifs = $pdo->prepare("SELECT * FROM gym_records WHERE record_type = 'notification' AND target_user_id = ? ORDER BY created_at DESC");
        $stmtNotifs->execute([$trainerId]);
        while ($nRow = $stmtNotifs->fetch(PDO::FETCH_ASSOC)) {
            $nPayload = json_decode($nRow['payload'], true) ?? [];
            $sentNotifications[] = [
                'record_id' => $nRow['record_id'],
                'title' => $nRow['title'],
                'body' => $nPayload['body'] ?? '',
                'recipient' => $nPayload['recipient'] === 'all' ? 'All Members' : 'Member #' . $nPayload['recipient'],
                'time' => date('D d M Y, g:i A', strtotime($nRow['created_at']))
            ];
        }

        // Fetch chat messages for selected member — include record_id for delete
        if ($selectedMemberId > 0) {
            $stmtChat = $pdo->prepare("SELECT * FROM gym_records WHERE user_id = ? AND record_type = 'message' ORDER BY created_at ASC");
            $stmtChat->execute([$selectedMemberId]);
            while ($cRow = $stmtChat->fetch(PDO::FETCH_ASSOC)) {
                $payload = json_decode($cRow['payload'], true) ?? [];
                $sender = $payload['sender'] ?? 'member';
                $activeChatMessages[] = [
                    'record_id' => $cRow['record_id'],
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
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>Trainer Portal — <?= htmlspecialchars($trainer['name']) ?></title>
<script src="https://cdn.tailwindcss.com"></script>
<link href="https://fonts.googleapis.com" rel="preconnect"/>
<link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect"/>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@500;600;700;800&family=Inter:wght@400;500;600&display=swap" rel="stylesheet"/>
<script>
    tailwind.config = {
      theme: { extend: { fontFamily: { sans: ['Plus Jakarta Sans', 'Inter', 'sans-serif'] } } }
    }
</script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet"/>
<style>
    body { font-family: 'Plus Jakarta Sans', sans-serif; -webkit-font-smoothing: antialiased; background:#fff; color:#334155; }
    input::placeholder, textarea::placeholder { color:#94a3b8; }
    .screen-fade { animation: fadeIn .3s ease-in-out forwards; }
    @keyframes fadeIn { from { opacity:0; transform:translateY(6px);} to { opacity:1; transform:none;} }
    @media (max-width:767px) {
      .mobile-drawer { position:fixed!important; top:0; bottom:0; left:0; z-index:50; transform:translateX(-100%); transition:transform .3s; box-shadow:0 20px 25px -5px rgba(0,0,0,.1); }
      .mobile-drawer.drawer-open { transform:translateX(0)!important; }
    }
    .card { background:#fff; border:1px solid #e2e8f0; border-radius:12px; padding:20px; }
    .inp { width:100%; background:#f8fafc; border:1px solid #cbd5e1; border-radius:8px; padding:9px 12px; font-size:14px; }
    .inp:focus { outline:2px solid #2563eb; outline-offset:-1px; background:#fff; }
    .chip { font-size:11px; font-weight:700; border-radius:999px; padding:3px 10px; }
    .btn { font-size:13px; font-weight:700; border-radius:8px; padding:9px 14px; transition:background .2s; cursor:pointer; }
    .btn-p { background:#2563eb; color:#fff; } .btn-p:hover { background:#1d4ed8; }
    .msg-bubble { position:relative; }
    .msg-delete-btn { opacity:0; transition:opacity .15s; }
    .msg-bubble:hover .msg-delete-btn { opacity:1; }
</style>
</head>
<body class="min-h-screen flex flex-col antialiased text-slate-800 pb-16 md:pb-0">

<div id="toast-container" class="fixed bottom-5 right-5 z-50 flex flex-col gap-3 pointer-events-none"></div>
<div id="sidebar-backdrop" onclick="toggleMobileSidebar()" class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-40 hidden md:hidden"></div>

<div class="flex-1 flex overflow-hidden relative">

  <!-- Sidebar -->
  <aside id="app-sidebar" class="mobile-drawer w-64 border-r border-gray-200 bg-white flex flex-col shrink-0 select-none md:static md:translate-x-0 hidden md:flex">
    <div class="p-4 sm:p-6 border-b border-gray-100 flex items-center justify-between gap-2">
      <div class="flex items-center gap-3">
        <?php if (!empty($trainer['avatar'])): ?>
          <img src="<?= htmlspecialchars($trainer['avatar']) ?>" alt="Profile" class="w-9 h-9 rounded-xl object-cover border border-slate-200"/>
        <?php else: ?>
          <span class="w-9 h-9 rounded-xl bg-blue-600 text-white font-extrabold flex items-center justify-center">
            <?= strtoupper(substr($trainer['name'], 0, 2)) ?>
          </span>
        <?php endif; ?>
        <div class="leading-tight">
          <span class="font-bold text-sm text-slate-900 tracking-tight"><?= htmlspecialchars($trainer['name']) ?></span>
          <p class="text-[10px] text-slate-500">Trainer Portal</p>
        </div>
      </div>
    </div>

    <nav class="flex-1 pt-3 space-y-1 overflow-y-auto" id="nav">
      <button onclick="switchScreen('dash', this)" class="nav-item w-full relative flex items-center gap-3.5 px-6 py-3.5 text-sm font-medium bg-blue-50 text-blue-900 border-r-4 border-blue-600 transition-colors text-left">
        <i class="fa-solid fa-gauge-high w-5 text-blue-600 text-base"></i><span>Dashboard</span>
      </button>
      <button onclick="switchScreen('plan-calendar', this)" class="nav-item w-full flex items-center gap-3.5 px-6 py-3.5 text-sm font-medium text-slate-600 hover:text-slate-900 hover:bg-slate-50 transition-colors text-left">
        <i class="fa-solid fa-calendar-check w-5 text-slate-500 text-base"></i><span>Training Plan Calendar</span>
      </button>
      <button onclick="switchScreen('create-class', this)" class="nav-item w-full flex items-center gap-3.5 px-6 py-3.5 text-sm font-medium text-slate-600 hover:text-slate-900 hover:bg-slate-50 transition-colors text-left">
        <i class="fa-solid fa-calendar-plus w-5 text-slate-500 text-base"></i><span>Create Classes</span>
      </button>
      <button onclick="switchScreen('bookings', this)" class="nav-item w-full flex items-center justify-between px-6 py-3.5 text-sm font-medium text-slate-600 hover:text-slate-900 hover:bg-slate-50 transition-colors text-left">
        <div class="flex items-center gap-3.5">
          <i class="fa-solid fa-clipboard-list w-5 text-slate-500 text-base"></i><span>Booked Classes</span>
        </div>
        <span class="px-2 py-0.5 text-xs font-semibold rounded-full bg-slate-100 text-slate-600"><?= count($classBookings) ?></span>
      </button>
      <button onclick="switchScreen('notifications', this)" class="nav-item w-full flex items-center gap-3.5 px-6 py-3.5 text-sm font-medium text-slate-600 hover:text-slate-900 hover:bg-slate-50 transition-colors text-left">
        <i class="fa-solid fa-bullhorn w-5 text-slate-500 text-base"></i><span>Send Notifications</span>
      </button>
      <button onclick="switchScreen('messages', this)" class="nav-item w-full flex items-center gap-3.5 px-6 py-3.5 text-sm font-medium text-slate-600 hover:text-slate-900 hover:bg-slate-50 transition-colors text-left">
        <i class="fa-solid fa-comments w-5 text-slate-500 text-base"></i><span>Member Messages</span>
      </button>
      <button onclick="switchScreen('members', this)" class="nav-item w-full flex items-center justify-between px-6 py-3.5 text-sm font-medium text-slate-600 hover:text-slate-900 hover:bg-slate-50 transition-colors text-left">
        <div class="flex items-center gap-3.5">
          <i class="fa-solid fa-users w-5 text-slate-500 text-base"></i><span>Manage Members</span>
        </div>
        <span class="px-2 py-0.5 text-xs font-semibold rounded-full bg-blue-100 text-blue-700"><?= count($members) ?></span>
      </button>
    </nav>
  </aside>

  <div class="flex-1 flex flex-col min-w-0 overflow-hidden">
    <header class="h-16 border-b border-gray-200 bg-white px-3 sm:px-8 flex items-center justify-between shrink-0 gap-2">
      <div class="flex items-center gap-2 sm:gap-3 flex-1 min-w-0">
        <?php if (!empty($trainer['avatar'])): ?>
          <img src="<?= htmlspecialchars($trainer['avatar']) ?>" alt="Profile" class="w-8 h-8 rounded-full object-cover border border-slate-200"/>
        <?php endif; ?>
        <div class="text-xs text-slate-500 font-medium truncate"><?= htmlspecialchars($trainer['name']) ?></div>
      </div>
      <div class="flex items-center gap-3 shrink-0">
        <a href="portalogin.php" class="bg-red-50 text-red-600 border border-red-200 px-3 py-1.5 rounded-lg text-xs font-bold hover:bg-red-100 transition">Sign Out</a>
      </div>
    </header>

    <main class="flex-1 overflow-y-auto px-3 sm:px-10 py-5 sm:py-8 bg-slate-50 relative">
      <div id="screen-loading" class="absolute inset-0 bg-white/80 backdrop-blur-[2px] z-30 flex flex-col items-center justify-center transition-opacity duration-200 hidden">
        <div class="w-10 h-10 border-4 border-blue-600 border-t-transparent rounded-full animate-spin"></div>
        <p class="text-xs font-semibold text-slate-600 mt-3">Loading...</p>
      </div>

      <?php if (!empty($successMessage)): ?>
        <div class="mb-5 bg-emerald-50 border border-emerald-200 text-emerald-800 p-4 rounded-xl text-sm font-semibold shadow-sm">
          <?= htmlspecialchars($successMessage) ?>
        </div>
      <?php endif; ?>

      <!-- SCREEN 1: DASHBOARD -->
      <section id="screen-dash" class="space-y-5 screen-fade">
        <div class="card flex flex-col sm:flex-row items-center gap-5">
          <div class="shrink-0">
            <?php if (!empty($trainer['avatar'])): ?>
              <img src="<?= htmlspecialchars($trainer['avatar']) ?>" alt="Profile" class="w-20 h-20 rounded-2xl object-cover border-2 border-blue-100 shadow"/>
            <?php else: ?>
              <span class="w-20 h-20 rounded-2xl bg-blue-600 text-white font-extrabold flex items-center justify-center text-2xl">
                <?= strtoupper(substr($trainer['name'], 0, 2)) ?>
              </span>
            <?php endif; ?>
          </div>
          <div class="flex-1 text-center sm:text-left">
            <h1 class="text-xl font-extrabold text-slate-900"><?= htmlspecialchars($trainer['name']) ?></h1>
            <p class="text-xs text-slate-500"><?= htmlspecialchars($trainer['email']) ?> · <?= htmlspecialchars($trainer['id']) ?></p>
            <form method="POST" enctype="multipart/form-data" class="mt-3 flex flex-wrap items-center gap-2 justify-center sm:justify-start">
              <input type="hidden" name="update_trainer_photo" value="1">
              <input type="file" name="trainer_pic" accept="image/*" required
                     class="text-xs text-slate-500 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 cursor-pointer"/>
              <button type="submit" class="btn btn-p text-xs">Upload Photo</button>
            </form>
          </div>
        </div>

        <h2 class="text-2xl font-extrabold text-blue-700">Coach Dashboard</h2>
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
          <div class="card"><p class="text-xs font-semibold text-slate-500">Total Members</p><b class="block text-3xl font-extrabold mt-1 text-slate-900"><?= count($members) ?></b></div>
          <div class="card"><p class="text-xs font-semibold text-slate-500">Total Bookings Made</p><b class="block text-3xl font-extrabold mt-1 text-blue-600"><?= count($classBookings) ?></b></div>
        </div>
      </section>

      <!-- SCREEN 2: TRAINING PLAN CALENDAR -->
      <section id="screen-plan-calendar" class="space-y-5 screen-fade hidden card">
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
            $prevMonth = $currentMonth - 1; $prevYear = $currentYear;
            if ($prevMonth < 1) { $prevMonth = 12; $prevYear--; }
            $nextMonth = $currentMonth + 1; $nextYear = $currentYear;
            if ($nextMonth > 12) { $nextMonth = 1; $nextYear++; }
          ?>
          <a href="trainer-dashboard.php?trainer=<?= $trainerId ?>&member_id=<?= $selectedMemberId ?>&month=<?= $prevMonth ?>&year=<?= $prevYear ?>" class="btn bg-white border border-slate-200 text-xs font-bold px-3 py-1.5 hover:bg-slate-50"><i class="fa-solid fa-chevron-left mr-1"></i> Prev</a>
          <h3 class="font-extrabold text-base text-slate-800"><?= date('F Y', mktime(0,0,0,$currentMonth,1,$currentYear)) ?></h3>
          <a href="trainer-dashboard.php?trainer=<?= $trainerId ?>&member_id=<?= $selectedMemberId ?>&month=<?= $nextMonth ?>&year=<?= $nextYear ?>" class="btn bg-white border border-slate-200 text-xs font-bold px-3 py-1.5 hover:bg-slate-50">Next <i class="fa-solid fa-chevron-right ml-1"></i></a>
        </div>
        <form method="POST" class="space-y-4">
          <input type="hidden" name="save_training_plan" value="1">
          <input type="hidden" name="plan_member_id" value="<?= $selectedMemberId ?>">
          <div class="grid grid-cols-7 gap-2 text-center">
            <?php foreach (['Mon','Tue','Wed','Thu','Fri','Sat','Sun'] as $d): ?>
              <div class="text-xs font-extrabold text-slate-400 py-1"><?= $d ?></div>
            <?php endforeach; ?>
            <?php
              $totalDaysInMonth = cal_days_in_month(CAL_GREGORIAN, $currentMonth, $currentYear);
              $firstDayOfWeek = date('N', strtotime("$currentYear-$currentMonth-01"));
              for ($i = 1; $i < $firstDayOfWeek; $i++) echo '<div class="h-20 bg-slate-50/50 rounded-xl border border-transparent"></div>';
              for ($day = 1; $day <= $totalDaysInMonth; $day++) {
                  $dateStr = sprintf('%04d-%02d-%02d', $currentYear, $currentMonth, $day);
                  $isChecked = in_array($dateStr, $existingPlanDays);
                  $isToday = ($dateStr === date('Y-m-d'));
            ?>
              <label class="h-24 p-2 rounded-xl border flex flex-col justify-between cursor-pointer transition-all select-none <?= $isChecked ? 'bg-blue-50 border-blue-400 shadow-sm' : 'bg-white border-slate-200 hover:border-slate-300' ?> <?= $isToday ? 'ring-2 ring-blue-500' : '' ?>">
                <div class="flex justify-between items-center w-full">
                  <span class="text-xs font-extrabold <?= $isChecked ? 'text-blue-700' : 'text-slate-700' ?>"><?= $day ?></span>
                  <input type="checkbox" name="training_days[]" value="<?= $dateStr ?>" <?= $isChecked ? 'checked' : '' ?> class="rounded text-blue-600 focus:ring-blue-500 w-4 h-4">
                </div>
                <div class="text-[10px] font-bold text-center <?= $isChecked ? 'text-blue-600 bg-blue-100/80 rounded py-0.5' : 'text-slate-400' ?>">
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

      <!-- SCREEN 3: CREATE CLASSES -->
      <section id="screen-create-class" class="space-y-5 screen-fade hidden card">
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
                  <th class="py-3 px-3 text-right">Action</th>
                </tr>
              </thead>
              <tbody class="divide-y divide-slate-100">
                <?php if (empty($classesList)): ?>
                  <tr><td colspan="5" class="py-6 text-center text-slate-400">No classes created yet.</td></tr>
                <?php else: ?>
                  <?php foreach ($classesList as $cls): ?>
                    <tr>
                      <td class="py-3 px-3 font-bold text-slate-900"><?= htmlspecialchars($cls['title']) ?></td>
                      <td class="py-3 px-3 text-slate-600"><?= htmlspecialchars($cls['start_time']) ?></td>
                      <td class="py-3 px-3 text-slate-500"><?= $cls['capacity'] ?> slots</td>
                      <td class="py-3 px-3"><span class="chip bg-blue-50 text-blue-700"><?= htmlspecialchars($cls['status']) ?></span></td>
                      <td class="py-3 px-3 text-right">
                        <form method="POST" onsubmit="return confirm('Delete this class and all its bookings?');">
                          <input type="hidden" name="delete_class_id" value="<?= $cls['record_id'] ?>">
                          <button type="submit" class="text-xs bg-red-50 text-red-600 border border-red-200 font-bold px-3 py-1.5 rounded-lg hover:bg-red-100">Delete</button>
                        </form>
                      </td>
                    </tr>
                  <?php endforeach; ?>
                <?php endif; ?>
              </tbody>
            </table>
          </div>
        </div>
      </section>

      <!-- SCREEN 4: BOOKED CLASSES -->
      <section id="screen-bookings" class="space-y-4 screen-fade hidden card">
        <div class="flex justify-between items-center">
          <h2 class="font-extrabold text-xl text-slate-900">Member Class Bookings</h2>
          <span class="chip bg-blue-100 text-blue-700"><?= count($classBookings) ?> Total Bookings</span>
        </div>
        <p class="text-sm text-slate-500">See which members have booked your classes in real-time. You can delete individual bookings below.</p>
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
                <th class="py-3 px-3 text-right">Actions</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
              <?php if (empty($classBookings)): ?>
                <tr><td colspan="7" class="py-6 text-center text-slate-400">No member class bookings found yet.</td></tr>
              <?php else: ?>
                <?php foreach ($classBookings as $b): ?>
                  <tr class="hover:bg-slate-50">
                    <td class="py-3 px-3 font-mono text-xs">#<?= $b['booking_id'] ?></td>
                    <td class="py-3 px-3 font-bold text-slate-900">
                      <div class="flex items-center gap-2">
                        <?php if (!empty($b['member_avatar'])): ?>
                          <img src="<?= htmlspecialchars($b['member_avatar']) ?>" alt="" class="w-8 h-8 rounded-full object-cover border border-slate-200 shrink-0"/>
                        <?php else: ?>
                          <span class="w-8 h-8 rounded-full bg-blue-100 text-blue-700 font-bold flex items-center justify-center text-xs border border-blue-200 shrink-0">
                            <?= strtoupper(substr($b['member_name'], 0, 2)) ?>
                          </span>
                        <?php endif; ?>
                        <span><?= htmlspecialchars($b['member_name']) ?></span>
                      </div>
                    </td>
                    <td class="py-3 px-3 text-slate-600 text-xs"><?= htmlspecialchars($b['member_email']) ?></td>
                    <td class="py-3 px-3 font-semibold text-blue-600"><?= htmlspecialchars($b['class_title']) ?></td>
                    <td class="py-3 px-3 text-slate-500 text-xs"><?= htmlspecialchars($b['booked_time']) ?></td>
                    <td class="py-3 px-3"><span class="chip bg-emerald-100 text-emerald-800"><?= htmlspecialchars($b['status']) ?></span></td>
                    <td class="py-3 px-3 text-right">
                      <form method="POST" onsubmit="return confirm('Delete this booking permanently from the database?');">
                        <input type="hidden" name="delete_booking_id" value="<?= $b['booking_id'] ?>">
                        <button type="submit" class="text-xs bg-red-50 text-red-600 border border-red-200 font-bold px-3 py-1.5 rounded-lg hover:bg-red-100 transition">Delete</button>
                      </form>
                    </td>
                  </tr>
                <?php endforeach; ?>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
      </section>

      <!-- SCREEN 5: SEND NOTIFICATIONS -->
      <section id="screen-notifications" class="space-y-5 screen-fade hidden card">
        <div class="flex justify-between items-center flex-wrap gap-3">
          <div>
            <h2 class="font-extrabold text-xl text-slate-900">Send Notifications to Members</h2>
            <p class="text-sm text-slate-500">Broadcast important announcements or send targeted alerts.</p>
          </div>
          <?php if (!empty($sentNotifications)): ?>
            <form method="POST" onsubmit="return confirm('Permanently delete ALL notifications from the database?');">
              <input type="hidden" name="clear_all_notifications" value="1">
              <button type="submit" class="btn bg-red-50 text-red-600 border border-red-200 text-xs font-bold hover:bg-red-100">
                <i class="fa-solid fa-trash mr-1"></i> Clear All Notifications
              </button>
            </form>
          <?php endif; ?>
        </div>

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
                <?php foreach ($members as $m): ?>
                  <option value="<?= $m['user_id'] ?>">Specific Member: <?= htmlspecialchars($m['name']) ?> (<?= $m['id'] ?>)</option>
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
                  <th class="py-3 px-3 text-right">Action</th>
                </tr>
              </thead>
              <tbody class="divide-y divide-slate-100">
                <?php if (empty($sentNotifications)): ?>
                  <tr><td colspan="5" class="py-6 text-center text-slate-400">No notifications sent yet.</td></tr>
                <?php else: ?>
                  <?php foreach ($sentNotifications as $notif): ?>
                    <tr class="hover:bg-slate-50">
                      <td class="py-3 px-3 font-bold text-slate-900"><?= htmlspecialchars($notif['title']) ?></td>
                      <td class="py-3 px-3 text-slate-600"><?= htmlspecialchars($notif['body']) ?></td>
                      <td class="py-3 px-3"><span class="chip bg-blue-50 text-blue-700"><?= htmlspecialchars($notif['recipient']) ?></span></td>
                      <td class="py-3 px-3 text-slate-400 text-xs"><?= htmlspecialchars($notif['time']) ?></td>
                      <td class="py-3 px-3 text-right">
                        <form method="POST" onsubmit="return confirm('Delete this notification from the database?');">
                          <input type="hidden" name="delete_notification_id" value="<?= $notif['record_id'] ?>">
                          <button type="submit" class="text-xs bg-red-50 text-red-600 border border-red-200 font-bold px-2.5 py-1 rounded-lg hover:bg-red-100">Delete</button>
                        </form>
                      </td>
                    </tr>
                  <?php endforeach; ?>
                <?php endif; ?>
              </tbody>
            </table>
          </div>
        </div>
      </section>

      <!-- SCREEN 6: MEMBER MESSAGES -->
      <section id="screen-messages" class="space-y-4 screen-fade hidden card">
        <h2 class="font-extrabold text-xl text-slate-900">Member Messages & Chats</h2>
        <p class="text-sm text-slate-500">Select a member to chat. Hover a message to delete it individually, or clear the whole conversation.</p>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mt-4">
          <div class="border-r border-slate-200 pr-3 space-y-2 max-h-[500px] overflow-y-auto">
            <?php if (empty($members)): ?>
              <p class="text-sm text-slate-400">No members assigned to you yet.</p>
            <?php else: ?>
              <?php foreach ($members as $m): ?>
                <a href="trainer-dashboard.php?trainer=<?= $trainerId ?>&member_id=<?= $m['user_id'] ?>"
                   class="flex items-center gap-3 p-3 rounded-xl border transition-all <?= $selectedMemberId === $m['user_id'] ? 'bg-blue-50 border-blue-300 font-bold' : 'bg-white border-slate-200 hover:bg-slate-50' ?>">
                  <?php if (!empty($m['avatar'])): ?>
                    <img src="<?= htmlspecialchars($m['avatar']) ?>" alt="" class="w-10 h-10 rounded-full object-cover border border-slate-200 shrink-0"/>
                  <?php else: ?>
                    <span class="w-10 h-10 rounded-full bg-blue-100 text-blue-700 font-bold flex items-center justify-center text-sm border border-blue-200 shrink-0">
                      <?= strtoupper(substr($m['name'], 0, 2)) ?>
                    </span>
                  <?php endif; ?>
                  <div class="min-w-0">
                    <p class="text-sm text-slate-900 truncate"><?= htmlspecialchars($m['name']) ?></p>
                    <p class="text-xs text-slate-400 font-mono truncate"><?= $m['id'] ?> | <?= htmlspecialchars($m['email']) ?></p>
                  </div>
                </a>
              <?php endforeach; ?>
            <?php endif; ?>
          </div>

          <div class="md:col-span-2 flex flex-col h-[500px] bg-slate-50 rounded-2xl border border-slate-200 p-4">
            <div class="border-b border-slate-200 pb-3 mb-3 flex items-center justify-between">
              <div class="flex items-center gap-2">
                <?php if (!empty($members[$selectedMemberId]['avatar'])): ?>
                  <img src="<?= htmlspecialchars($members[$selectedMemberId]['avatar']) ?>" alt="" class="w-8 h-8 rounded-full object-cover border border-slate-200"/>
                <?php else: ?>
                  <span class="w-8 h-8 rounded-full bg-blue-100 text-blue-700 font-bold flex items-center justify-center text-xs border border-blue-200">
                    <?= strtoupper(substr($members[$selectedMemberId]['name'] ?? '?', 0, 2)) ?>
                  </span>
                <?php endif; ?>
                <h3 class="font-bold text-slate-900">Chat with <?= htmlspecialchars($members[$selectedMemberId]['name'] ?? 'Member #' . $selectedMemberId) ?></h3>
              </div>
              <div class="flex items-center gap-2">
                <?php if (!empty($activeChatMessages)): ?>
                  <form method="POST" onsubmit="return confirm('Permanently clear ALL messages with this member?');">
                    <input type="hidden" name="clear_chat_member_id" value="<?= $selectedMemberId ?>">
                    <button type="submit" class="text-xs bg-red-50 text-red-600 border border-red-200 font-bold px-2.5 py-1 rounded-lg hover:bg-red-100">
                      <i class="fa-solid fa-broom mr-1"></i> Clear Chat
                    </button>
                  </form>
                <?php endif; ?>
                <span class="chip bg-emerald-100 text-emerald-800">Connected</span>
              </div>
            </div>

            <div class="flex-1 overflow-y-auto space-y-3 pr-2" id="chat-messages-box">
              <?php if (empty($activeChatMessages)): ?>
                <div class="h-full flex items-center justify-center text-slate-400 text-sm">
                  No conversation history yet. Send a message below!
                </div>
              <?php else: ?>
                <?php foreach ($activeChatMessages as $msg): ?>
                  <div class="flex <?= $msg['sender'] === 'trainer' ? 'justify-end' : 'justify-start' ?>">
                    <div class="msg-bubble max-w-[75%] rounded-xl px-4 py-2.5 text-sm <?= $msg['sender'] === 'trainer' ? 'bg-blue-600 text-white' : 'bg-white border border-slate-200 text-slate-800' ?>">
                      <p><?= htmlspecialchars($msg['body']) ?></p>
                      <span class="text-[10px] opacity-70 block mt-1 text-right"><?= $msg['time'] ?></span>
                      <form method="POST" onsubmit="return confirm('Delete this message from the database?');" class="absolute -top-2 <?= $msg['sender'] === 'trainer' ? '-left-2' : '-right-2' ?> msg-delete-btn">
                        <input type="hidden" name="delete_message_id" value="<?= $msg['record_id'] ?>">
                        <input type="hidden" name="msg_member_id" value="<?= $selectedMemberId ?>">
                        <button type="submit" class="w-6 h-6 rounded-full bg-red-500 text-white text-[10px] font-bold shadow hover:bg-red-600" title="Delete message">&times;</button>
                      </form>
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

      <!-- SCREEN 7: MANAGE MEMBERS -->
      <section id="screen-members" class="space-y-4 screen-fade hidden card">
        <h2 class="font-extrabold text-xl text-slate-900">Registered Gym Members</h2>
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
                <tr><td colspan="4" class="py-6 text-center text-slate-400">No members found.</td></tr>
              <?php else: ?>
                <?php foreach ($members as $m): ?>
                  <tr class="hover:bg-slate-50">
                    <td class="py-3 px-3 font-mono text-xs font-bold text-blue-600"><?= $m['id'] ?></td>
                    <td class="py-3 px-3 font-bold text-slate-900">
                      <div class="flex items-center gap-2">
                        <?php if (!empty($m['avatar'])): ?>
                          <img src="<?= htmlspecialchars($m['avatar']) ?>" alt="" class="w-9 h-9 rounded-full object-cover border border-slate-200 shrink-0"/>
                        <?php else: ?>
                          <span class="w-9 h-9 rounded-full bg-blue-100 text-blue-700 font-bold flex items-center justify-center text-xs border border-blue-200 shrink-0">
                            <?= strtoupper(substr($m['name'], 0, 2)) ?>
                          </span>
                        <?php endif; ?>
                        <span><?= htmlspecialchars($m['name']) ?></span>
                      </div>
                    </td>
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
</div>

<!-- Mobile Bottom Navigation -->
<nav aria-label="Mobile Bottom Navigation" class="fixed bottom-0 left-0 right-0 z-50 bg-white border-t border-slate-200/90 py-2 px-2 flex justify-around items-center md:hidden shadow-lg">
  <button onclick="switchScreen('dash', this)" data-mob-v="dash" class="mob-nav-item flex flex-col items-center justify-center text-blue-600 flex-1 py-1 focus:outline-none"><i class="fa-solid fa-gauge-high text-base mb-1"></i><span class="text-[10px] font-semibold">Home</span></button>
  <button onclick="switchScreen('plan-calendar', this)" data-mob-v="plan-calendar" class="mob-nav-item flex flex-col items-center justify-center text-slate-500 flex-1 py-1"><i class="fa-solid fa-calendar-check text-base mb-1"></i><span class="text-[10px] font-medium">Calendar</span></button>
  <button onclick="switchScreen('create-class', this)" data-mob-v="create-class" class="mob-nav-item flex flex-col items-center justify-center text-slate-500 flex-1 py-1"><i class="fa-solid fa-calendar-plus text-base mb-1"></i><span class="text-[10px] font-medium">Classes</span></button>
  <button onclick="switchScreen('notifications', this)" data-mob-v="notifications" class="mob-nav-item flex flex-col items-center justify-center text-slate-500 flex-1 py-1"><i class="fa-solid fa-bullhorn text-base mb-1"></i><span class="text-[10px] font-medium">Alerts</span></button>
  <button onclick="switchScreen('messages', this)" data-mob-v="messages" class="mob-nav-item flex flex-col items-center justify-center text-slate-500 flex-1 py-1"><i class="fa-solid fa-comments text-base mb-1"></i><span class="text-[10px] font-medium">Chats</span></button>
  <button onclick="switchScreen('members', this)" data-mob-v="members" class="mob-nav-item flex flex-col items-center justify-center text-slate-500 flex-1 py-1"><i class="fa-solid fa-users text-base mb-1"></i><span class="text-[10px] font-medium">Members</span></button>
</nav>

<script>
  function switchScreen(screenId, element) {
    const loader = document.getElementById('screen-loading');
    if (loader) loader.classList.remove('hidden');
    setTimeout(() => {
      document.querySelectorAll('main > section').forEach(s => s.classList.add('hidden'));
      const target = document.getElementById('screen-' + screenId);
      if (target) target.classList.remove('hidden');

      document.querySelectorAll('.nav-item').forEach(item => {
        item.classList.remove('bg-blue-50', 'text-blue-900', 'border-r-4', 'border-blue-600');
        item.classList.add('text-slate-600');
        const icon = item.querySelector('i');
        if (icon) icon.classList.replace('text-blue-600', 'text-slate-500');
      });
      document.querySelectorAll('.mob-nav-item').forEach(item => {
        item.classList.remove('text-blue-600'); item.classList.add('text-slate-500');
        const span = item.querySelector('span:last-child');
        if (span) span.className = "text-[10px] font-medium";
      });
      document.querySelectorAll('.nav-item').forEach(item => {
        if (item.getAttribute('onclick')?.includes("'" + screenId + "'")) {
          item.classList.remove('text-slate-600');
          item.classList.add('bg-blue-50', 'text-blue-900', 'border-r-4', 'border-blue-600');
          const ai = item.querySelector('i'); if (ai) ai.classList.replace('text-slate-500', 'text-blue-600');
        }
      });
      if (element && element.classList.contains('mob-nav-item')) {
        element.classList.remove('text-slate-500'); element.classList.add('text-blue-600');
        const span = element.querySelector('span:last-child');
        if (span) span.className = "text-[10px] font-semibold";
      }
      if (loader) loader.classList.add('hidden');
    }, 200);
    if (screenId === 'messages') {
      const chatBox = document.getElementById('chat-messages-box');
      if (chatBox) chatBox.scrollTop = chatBox.scrollHeight;
    }
  }
  document.addEventListener('DOMContentLoaded', () => {
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.has('member_id') && urlParams.get('member_id') > 0) {
      const msgBtn = document.querySelector('[onclick*="messages"]');
      const mobMsgBtn = document.querySelector('[data-mob-v="messages"]');
      if (msgBtn) switchScreen('messages', mobMsgBtn || msgBtn);
    }
  });
</script>

</body>
</html>
<?php
ob_end_flush();
?>