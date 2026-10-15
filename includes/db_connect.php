<?php
// Auto-detect environment: If running on local development (localhost or 127.0.0.1)
$hostHeader = $_SERVER['HTTP_HOST'] ?? $_SERVER['SERVER_NAME'] ?? '';
$isLocal    = (strpos($hostHeader, 'localhost') !== false || strpos($hostHeader, '127.0.0.1') !== false);

if (!$isLocal) {
    // LIVE ENVIRONMENT (InfinityFree - Filled exactly from your panel)
    $host     = 'sql303.infinityfree.com'; // FIXED: Switched from sql100 to sql303
    $dbName   = 'if0_42288211_jumika';     // FIXED: Target database verified from list
    $username = 'if0_42288211';
    $password = '3mTB6HRSCw7vH38';         // FIXED: Your new live database password
} else {
    // LOCAL ENVIRONMENT
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
        'message' => 'Database connection failed.',
        'debug'   => $e->getMessage()
    ]);
    exit;
}
