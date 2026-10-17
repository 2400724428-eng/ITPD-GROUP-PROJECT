<?php
// admin/api/approve-subscription.php — API endpoint to approve member gym subscriptions
header('Content-Type: application/json');
ini_set('display_errors', 0);
error_reporting(0);

$dbPath = __DIR__ . '/../../includes/db_connect.php';
if (file_exists($dbPath)) {
    require_once $dbPath;
} else {
    $altPath = __DIR__ . '/../db_connect.php';
    if (file_exists($altPath)) {
        require_once $altPath;
    } else {
        echo json_encode(['success' => false, 'error' => 'Database connection file not found.']);
        exit;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($pdo)) {
    // Capture record ID from any standard request key
    $recordId = (int)($_POST['record_id'] ?? $_POST['approve_subscription_id'] ?? $_POST['id'] ?? 0);

    if ($recordId > 0) {
        try {
            // Strictly target record_id to avoid unknown column errors on 'id'
            $stmt = $pdo->prepare("UPDATE gym_records SET status = 'approved' WHERE record_id = ?");
            $stmt->execute([$recordId]);

            // Check if any row was successfully updated
            if ($stmt->rowCount() > 0) {
                echo json_encode(['success' => true, 'message' => 'Subscription approved successfully. Member portal access unlocked.']);
                exit;
            } else {
                echo json_encode(['success' => false, 'error' => 'Record not found or already approved.']);
                exit;
            }
        } catch (\PDOException $ex) {
            echo json_encode(['success' => false, 'error' => $ex->getMessage()]);
            exit;
        }
    }
}

echo json_encode(['success' => false, 'error' => 'Invalid request method or missing parameters.']);