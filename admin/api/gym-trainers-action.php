<?php
// gym-trainers-action.php — admin endpoint: allocate / remove a trainer for a member (JSON)
header('Content-Type: application/json');
session_start();

foreach ([__DIR__.'/includes/db_connect.php', __DIR__.'/../includes/db_connect.php', __DIR__.'/../../includes/db_connect.php', __DIR__.'/db_connect.php'] as $p) {
    if (file_exists($p)) { require_once $p; break; }
}
if (!isset($pdo)) { echo json_encode(['success' => false, 'error' => 'No database connection']); exit; }

// TODO: restrict to admins using your admin session check, e.g.
// if (($_SESSION['role'] ?? '') !== 'admin') { http_response_code(403); echo json_encode(['success'=>false,'error'=>'Forbidden']); exit; }

$action    = $_POST['action'] ?? '';
$memberId  = (int)($_POST['member_id'] ?? 0);
$adminId   = (int)($_SESSION['user_id'] ?? 0) ?: null;

try {
    if ($action === 'allocate') {
        $trainerId = (int)($_POST['trainer_id'] ?? 0);
        $package   = trim($_POST['package_name'] ?? '');

        $chk = $pdo->prepare("SELECT COUNT(*) FROM gymnuser WHERE user_id = ? AND LOWER(role) = ?");
        $chk->execute([$memberId, 'member']);  $okMember = $chk->fetchColumn() > 0;
        $chk->execute([$trainerId, 'trainer']); $okTrainer = $chk->fetchColumn() > 0;
        if (!$okMember || !$okTrainer) { echo json_encode(['success'=>false,'error'=>'Invalid member or trainer']); exit; }

        // One trainer per member: re-allocating simply moves the member to the new trainer
        $st = $pdo->prepare("INSERT INTO gym_trainer_assignments (member_id, trainer_id, package_name, assigned_by)
                             VALUES (?, ?, ?, ?)
                             ON DUPLICATE KEY UPDATE trainer_id = VALUES(trainer_id), package_name = VALUES(package_name),
                                                     assigned_by = VALUES(assigned_by), assigned_at = CURRENT_TIMESTAMP");
        $st->execute([$memberId, $trainerId, $package, $adminId]);
        echo json_encode(['success' => true]); exit;
    }

    if ($action === 'unassign') {
        $pdo->prepare("DELETE FROM gym_trainer_assignments WHERE member_id = ?")->execute([$memberId]);
        echo json_encode(['success' => true]); exit;
    }

    echo json_encode(['success' => false, 'error' => 'Unknown action']);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}