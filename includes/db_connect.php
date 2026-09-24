<?php
// Choose your active environment: change to 'live' when uploading to InfinityFree
$environment = 'local'; 

if ($environment === 'live') {
    $host = 'sql100.infinityfree.com';
    $db_name = 'if0_42288211_jumika';
    $username = 'if0_42288211';
    $password = 'psI7GvgUoDK7N';
} else {
    $host = 'localhost';
    $db_name = 'gym_supplements_store';
    $username = 'root';
    $password = '';
}

try {
    $conn = new PDO("mysql:host=$host;dbname=$db_name;charset=utf8mb4", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

} catch(PDOException $e) {
    error_log("Database Connection Error: " . $e->getMessage());
    die("Database connection failed. Please try again later.");
}
?>