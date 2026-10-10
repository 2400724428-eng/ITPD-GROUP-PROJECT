<?php
header('Content-Type: application/json; charset=utf-8');
require_once __DIR__ . '/../../includes/db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $categoryName = trim($_POST['category_name'] ?? '');

    if (empty($categoryName)) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Category name is required.']);
        exit;
    }

    try {
        // Delete category from the categories table
        $stmt = $pdo->prepare("DELETE FROM categories WHERE name = :name");
        $stmt->execute([':name' => $categoryName]);

        if ($stmt->rowCount() > 0) {
            echo json_encode(['success' => true, 'message' => 'Category deleted successfully.']);
        } else {
            http_response_code(444);
            echo json_encode(['success' => false, 'message' => 'Category not found.']);
        }
    } catch (\PDOException $e) {
        error_log('Delete Category Error: ' . $e->getMessage());
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => 'Failed to delete category due to a database error.']);
    }
    exit;
}