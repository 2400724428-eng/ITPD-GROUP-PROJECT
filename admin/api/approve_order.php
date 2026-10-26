<?php
// admin/api/approve_order.php
// Handles order approve / delete actions from the admin Orders screen.
// Called via fetch() from views/orders.php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

header('Content-Type: application/json');

require_once __DIR__ . '/../../includes/db_connect.php';

// Optional auth guard — uncomment if you want admin-only access
// if (empty($_SESSION['user_id'])) {
//     echo json_encode(['success' => false, 'error' => 'Not authenticated']);
//     exit;
// }

if (!isset($pdo)) {
    echo json_encode(['success' => false, 'error' => 'Database connection failed']);
    exit;
}

$raw  = file_get_contents('php://input');
$data = json_decode($raw, true);

if (!$data) {
    echo json_encode(['success' => false, 'error' => 'Invalid request body']);
    exit;
}

$action = $data['action'] ?? '';
$orderNumber = ltrim((string)($data['order_number'] ?? ''), '#');

if ($orderNumber === '') {
    echo json_encode(['success' => false, 'error' => 'Missing order number']);
    exit;
}

try {
    if ($action === 'approve') {
        $stmt = $pdo->prepare(
            "UPDATE `orders`
             SET `payment_status` = 'Completed', `updated_at` = NOW()
             WHERE `order_number` = ?"
        );
        $stmt->execute([$orderNumber]);

        // Log to gym_records if it exists — gives the user a notification record
        try {
            $stmtOrder = $pdo->prepare(
                "SELECT id, user_id, total_amount FROM `orders` WHERE `order_number` = ? LIMIT 1"
            );
            $stmtOrder->execute([$orderNumber]);
            $ord = $stmtOrder->fetch(PDO::FETCH_ASSOC);

            if ($ord && !empty($ord['user_id'])) {
                $payload = json_encode([
                    'order_number' => $orderNumber,
                    'amount'       => (float)$ord['total_amount'],
                    'approved_by'  => $_SESSION['user_id'] ?? null,
                ]);
                $notif = $pdo->prepare(
                    "INSERT INTO gym_records (user_id, record_type, title, status, numeric_value, payload)
                     VALUES (?, 'order_approved', ?, 'approved', ?, ?)"
                );
                $notif->execute([
                    (int)$ord['user_id'],
                    'Order #' . $orderNumber . ' approved',
                    (float)$ord['total_amount'],
                    $payload
                ]);
            }
        } catch (\PDOException $inner) {
            // gym_records may not exist or payload may not accept this shape — ignore
        }

        echo json_encode(['success' => true, 'order_number' => $orderNumber, 'new_status' => 'Completed']);
        exit;
    }

    if ($action === 'delete') {
        $stmt = $pdo->prepare("DELETE FROM `orders` WHERE `order_number` = ?");
        $stmt->execute([$orderNumber]);
        echo json_encode(['success' => true, 'order_number' => $orderNumber]);
        exit;
    }

    echo json_encode(['success' => false, 'error' => 'Unknown action']);
} catch (\PDOException $e) {
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}