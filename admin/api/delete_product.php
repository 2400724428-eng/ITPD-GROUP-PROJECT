<?php
// Start output buffering to capture any accidental warnings or whitespace
ob_start();

// Force JSON response header
header('Content-Type: application/json; charset=utf-8');

// Step out of admin/api/ to reach includes/db_connect.php
$dbPath = __DIR__ . '/../../includes/db_connect.php';

if (!file_exists($dbPath)) {
    ob_clean();
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Database connection file not found at: ' . $dbPath
    ]);
    exit;
}

require_once $dbPath;

// Clear buffer so only clean JSON is returned
ob_clean();

// Allow only POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed. Use POST.']);
    exit;
}

// Retrieve product ID from $_POST or raw JSON input
$productId = isset($_POST['product_id']) ? (int)$_POST['product_id'] : 0;

if ($productId <= 0) {
    $rawInput = json_decode(file_get_contents('php://input'), true);
    if (isset($rawInput['product_id'])) {
        $productId = (int)$rawInput['product_id'];
    }
}

if ($productId <= 0) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Invalid or missing product ID.']);
    exit;
}

try {
    // 1. Fetch primary/secondary image paths before removing DB record
    $imgStmt = $pdo->prepare("SELECT image_primary, image_secondary FROM products WHERE id = :id");
    $imgStmt->execute([':id' => $productId]);
    $product = $imgStmt->fetch(PDO::FETCH_ASSOC);

    // 2. Delete the product record from the MySQL database
    $deleteStmt = $pdo->prepare("DELETE FROM products WHERE id = :id");
    $deleteStmt->execute([':id' => $productId]);

    if ($deleteStmt->rowCount() > 0) {
        // 3. Remove image files from uploads folder if they exist
        if ($product) {
            foreach (['image_primary', 'image_secondary'] as $imgKey) {
                if (!empty($product[$imgKey])) {
                    $filePath = __DIR__ . '/../../' . ltrim($product[$imgKey], '/');
                    if (file_exists($filePath) && is_file($filePath)) {
                        @unlink($filePath);
                    }
                }
            }
        }

        echo json_encode([
            'success' => true,
            'message' => 'Product deleted successfully.',
            'deleted_id' => $productId
        ]);
    } else {
        http_response_code(404);
        echo json_encode(['success' => false, 'message' => 'Product not found or already deleted.']);
    }

} catch (\PDOException $e) {
    error_log('Delete Product API Error: ' . $e->getMessage());
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Database error: ' . $e->getMessage()
    ]);
}
exit;