<?php
require_once 'config.php';

// Destroy session completely
session_start();
$_SESSION = array();

// Destroy session cookie
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(
        session_name(), 
        '', 
        time() - 42000,
        $params["path"], 
        $params["domain"], 
        $params["secure"], 
        $params["httponly"]
    );
}

session_destroy();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logout - SmartStock Vision</title>
    <style>
        .logout-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            background: var(--bg-dark);
            color: white;
            text-align: center;
            padding: 20px;
        }
        
        .spinner {
            border: 4px solid rgba(255,255,255,0.3);
            border-radius: 50%;
            border-top: 4px solid #4FACFE;
            width: 40px;
            height: 40px;
            animation: spin 1s linear infinite;
            margin-bottom: 20px;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
</head>
<body>
    <div class="logout-container">
        <div class="spinner"></div>
        <h2>Logging you out securely...</h2>
        <p>You will be redirected to the login page shortly.</p>
        <p>If not redirected, <a href="login.php" style="color: #4FACFE;">click here</a>.</p>
    </div>

    <script>
        // Immediate redirect with fallback
        setTimeout(() => {
            window.location.href = 'index.php';
        }, 3000);
    </script>
</body>
</html>