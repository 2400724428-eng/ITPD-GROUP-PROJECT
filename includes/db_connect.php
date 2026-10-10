<?php
// Auto-detect environment based on server hostname
$hostHeader = $_SERVER['HTTP_HOST'] ?? $_SERVER['SERVER_NAME'] ?? '';
$isLive     = strpos($hostHeader, 'infinityfree.com') !== false;

if ($isLive) {
    $host     = 'sql100.infinityfree.com';
    $dbName   = 'if0_42288211_jumika';
    $username = 'if0_42288211';
    $password = 'psI7GvgUoDK7N';
} else {
    $host     = 'localhost';
    $dbName   = 'gym_supplements_store';
    $username = 'root';
    $password = '';
}

$charset = 'utf8mb4';
$dsn     = "mysql:host=$host;dbname=$dbName;charset=$charset";

$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $username, $password, $options);
} catch (\PDOException $e) {
    // Log detailed connection error server-side
    error_log('Database Connection Error: ' . $e->getMessage());

    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Database connection failed.'
    ]);
    exit;
}