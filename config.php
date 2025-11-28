<?php
// Database configuration
$host = "localhost";      // Database host
$dbusername = "root";     // Database username
$dbpassword = "";         // Database password
$dbname = "stock_market"; // Database name

// Error reporting (disable in production)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Create database connection
try {
    $conn = new mysqli($host, $dbusername, $dbpassword, $dbname);
    
    // Check connection
    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }
    
    // Set charset to utf8mb4
    $conn->set_charset("utf8mb4");
    
} catch (Exception $e) {
    die("Database connection error: " . $e->getMessage());
}

// Session configuration
session_start([
    'cookie_lifetime' => 86400,          // 1 day
    'cookie_secure'   => false,          // Set to true in production with HTTPS
    'cookie_httponly' => true,
    'use_strict_mode' => true
]);

// Security headers
header("X-Frame-Options: DENY");
header("X-Content-Type-Options: nosniff");
header("X-XSS-Protection: 1; mode=block");
header("Referrer-Policy: strict-origin-when-cross-origin");

// Timezone setting
date_default_timezone_set('UTC');

// Handle session fixation
if (!isset($_SESSION['created'])) {
    $_SESSION['created'] = time();
} elseif (time() - $_SESSION['created'] > 1800) {
    session_regenerate_id(true);
    $_SESSION['created'] = time();
}

// CSRF Token Generation
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
?>