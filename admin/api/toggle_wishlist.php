<?php
// Turn off error output to the browser so notices/warnings don't break JSON
ini_set('display_errors', 0);
error_reporting(E_ALL);

// Start output buffering to catch any stray warnings
ob_start();

session_start();
require_once __DIR__ . '/../../includes/db_connect.php';

// Wipe any stray output or whitespace captured so far
ob_clean();
header('Content-Type: application/json');

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit;
}

$userId = (int)$_SESSION['user_id'];
$input = json_decode(file_get_contents('php://input'), true);
$productId = isset($input['product_id']) ? (int)$input['product_id'] : 0;

if ($productId <= 0) {
    echo json_encode(['success' => false, 'message' => 'Invalid product ID']);
    exit;
}

try {
    // Check if wishlist record already exists
    $stmt = $pdo->prepare("SELECT id FROM wishlist WHERE user_id = ? AND product_id = ?");
    $stmt->execute([$userId, $productId]);
    $exists = $stmt->fetch();

    if ($exists) {
        // Remove item from wishlist
        $del = $pdo->prepare("DELETE FROM wishlist WHERE user_id = ? AND product_id = ?");
        $del->execute([$userId, $productId]);
        echo json_encode(['success' => true, 'status' => 'removed']);
    } else {
        // Add item to wishlist
        $ins = $pdo->prepare("INSERT INTO wishlist (user_id, product_id) VALUES (?, ?)");
        $ins->execute([$userId, $productId]);
        echo json_encode(['success' => true, 'status' => 'added']);
    }
} catch (\PDOException $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
exit;