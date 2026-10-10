<?php
ini_set('display_errors', 0);
error_reporting(E_ALL);
ob_start();

session_start();
require_once __DIR__ . '/../../includes/db_connect.php';

ob_clean();
header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit;
}

$userId = (int)$_SESSION['user_id'];
$input = json_decode(file_get_contents('php://input'), true);
$productId = isset($input['product_id']) ? (int)$input['product_id'] : 0;
$action = isset($input['action']) ? $input['action'] : 'add'; // 'add', 'decrease', 'remove'
$qtyChange = isset($input['quantity']) ? (int)$input['quantity'] : 1;

if ($productId <= 0) {
    echo json_encode(['success' => false, 'message' => 'Invalid product ID']);
    exit;
}

try {
    if ($action === 'remove') {
        $stmt = $pdo->prepare("DELETE FROM cart WHERE user_id = ? AND product_id = ?");
        $stmt->execute([$userId, $productId]);
        echo json_encode(['success' => true, 'status' => 'removed']);
        exit;
    }

    // Check if item already exists in user's cart
    $stmt = $pdo->prepare("SELECT id, quantity FROM cart WHERE user_id = ? AND product_id = ?");
    $stmt->execute([$userId, $productId]);
    $item = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($item) {
        if ($action === 'decrease') {
            $newQty = $item['quantity'] - $qtyChange;
            if ($newQty > 0) {
                $upd = $pdo->prepare("UPDATE cart SET quantity = ? WHERE user_id = ? AND product_id = ?");
                $upd->execute([$newQty, $userId, $productId]);
                echo json_encode(['success' => true, 'status' => 'decreased', 'quantity' => $newQty]);
            } else {
                $del = $pdo->prepare("DELETE FROM cart WHERE user_id = ? AND product_id = ?");
                $del->execute([$userId, $productId]);
                echo json_encode(['success' => true, 'status' => 'removed', 'quantity' => 0]);
            }
        } else {
            // Default 'add' increments quantity
            $newQty = $item['quantity'] + $qtyChange;
            $upd = $pdo->prepare("UPDATE cart SET quantity = ? WHERE user_id = ? AND product_id = ?");
            $upd->execute([$newQty, $userId, $productId]);
            echo json_encode(['success' => true, 'status' => 'updated', 'quantity' => $newQty]);
        }
    } else {
        if ($action !== 'decrease') {
            $ins = $pdo->prepare("INSERT INTO cart (user_id, product_id, quantity) VALUES (?, ?, ?)");
            $ins->execute([$userId, $productId, max(1, $qtyChange)]);
            echo json_encode(['success' => true, 'status' => 'added', 'quantity' => max(1, $qtyChange)]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Item not in cart']);
        }
    }
} catch (\PDOException $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
exit;