<?php
require_once 'config.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die("Invalid CSRF token");
    }

    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    try {
        // Server-side validation
        if (empty($username) || empty($email) || empty($password)) {
            throw new Exception("All fields are required");
        }
        
        if (!preg_match('/^[a-zA-Z0-9_]{3,20}$/', $username)) {
            throw new Exception("Username must be 3-20 characters (letters, numbers, underscores)");
        }
        
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception("Invalid email format");
        }
        
        if (strlen($password) < 8) {
            throw new Exception("Password must be at least 8 characters");
        }
        
        if ($password !== $confirm_password) {
            throw new Exception("Passwords do not match");
        }

        // Check existing users
        $stmt = $conn->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
        $stmt->bind_param("ss", $username, $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            throw new Exception("Username or email already exists");
        }

        // Create account
        $password_hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("INSERT INTO users (username, password, email) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $password_hash, $email);
        
        if ($stmt->execute()) {
            echo json_encode(['success' => true]);
            exit();
        } else {
            throw new Exception("Registration failed: " . $conn->error);
        }
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - SmartStock Vision</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        /* Include all styles from login.php here */
        :root {
            --primary-color: #4FACFE;
            --error-color: #ff4444;
            --bg-dark: #0A0F29;
            --card-bg: #0F1535;
        }

        body {
            margin: 0;
            background: var(--bg-dark);
            color: white;
            font-family: 'Arial', sans-serif;
        }

        .auth-container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }

        .auth-card {
            background: var(--card-bg);
            padding: 40px;
            border-radius: 20px;
            width: 100%;
            max-width: 400px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
            transform: scale(1);
            transition: transform 0.3s ease;
        }

        .auth-card:hover {
            transform: scale(1.02);
        }

        h2 {
            text-align: center;
            margin-bottom: 30px;
            background: linear-gradient(45deg, #4FACFE, #00F2FE);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .form-group {
            margin-bottom: 25px;
        }

        input {
            width: 100%;
            padding: 12px 15px;
            border: none;
            border-radius: 8px;
            background: #1a1f3d;
            color: white;
            transition: all 0.3s ease;
        }

        input:focus {
            outline: none;
            box-shadow: 0 0 0 2px var(--primary-color);
        }

        .password-container {
            position: relative;
        }

        .toggle-password {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #666;
        }

        button {
            width: 100%;
            padding: 12px;
            background: linear-gradient(45deg, #4FACFE, #00F2FE);
            border: none;
            border-radius: 8px;
            color: white;
            cursor: pointer;
            font-weight: bold;
            transition: opacity 0.3s ease;
        }

        button:hover {
            opacity: 0.9;
        }

        .alert {
            padding: 10px;
            border-radius: 8px;
            margin-bottom: 20px;
            text-align: center;
        }

        .error {
            background: #ff444433;
            color: var(--error-color);
        }

        .success {
            background: #00ff0033;
            color: #00ff00;
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-10px); }
            75% { transform: translateX(10px); }
        }

        .shake {
            animation: shake 0.4s ease;
        }

        .spinner {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 3px solid rgba(255,255,255,0.3);
            border-radius: 50%;
            border-top-color: white;
            animation: spin 1s ease-in-out infinite;
            vertical-align: middle;
            margin-left: 10px;
            display: none;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        .password-rules {
            color: #666;
            font-size: 0.9em;
            margin: 10px 0;
        }
    </style>
</head>
<body>
    <div class="auth-container">
        <div class="auth-card" id="registerCard">
            <h2>🚀 Create Account</h2>
            <div id="errorContainer"></div>
            
            <form id="registerForm" method="POST">
                <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                
                <div class="form-group">
                    <input type="text" id="username" name="username" placeholder="Username" required
                           pattern="[a-zA-Z0-9_]{3,20}" title="3-20 characters (letters, numbers, underscores)">
                </div>

                <div class="form-group">
                    <input type="email" id="email" name="email" placeholder="Email" required>
                </div>

                <div class="form-group">
                    <div class="password-container">
                        <input type="password" id="password" name="password" placeholder="Password" required
                               minlength="8">
                        <i class="toggle-password fas fa-eye" onclick="togglePassword('password')"></i>
                    </div>
                </div>

                <div class="form-group">
                    <div class="password-container">
                        <input type="password" id="confirm_password" name="confirm_password" 
                               placeholder="Confirm Password" required>
                        <i class="toggle-password fas fa-eye" onclick="togglePassword('confirm_password')"></i>
                    </div>
                </div>

                <div class="password-rules">
                    ✓ At least 8 characters<br>
                    ✓ Uppercase and lowercase letters<br>
                    ✓ At least one number
                </div>

                <button type="submit">
                    <span id="btnText">Create Account</span>
                    <div class="spinner" id="spinner"></div>
                </button>
            </form>

            <div style="margin-top: 20px; text-align: center;">
                <a href="login.php" style="color: var(--primary-color); text-decoration: none;">
                    Already have an account? Login
                </a>
            </div>
        </div>
    </div>

    <script>
        function togglePassword(fieldId) {
            const field = document.getElementById(fieldId);
            const icon = field.parentNode.querySelector('.toggle-password');
            field.type = field.type === 'password' ? 'text' : 'password';
            icon.classList.toggle('fa-eye-slash');
        }

        document.getElementById('registerForm').addEventListener('submit', async (e) => {
            e.preventDefault();
            
            const form = e.target;
            const btnText = document.getElementById('btnText');
            const spinner = document.getElementById('spinner');
            const errorContainer = document.getElementById('errorContainer');
            
            btnText.textContent = 'Creating Account...';
            spinner.style.display = 'inline-block';

            try {
                const response = await fetch('register.php', {
                    method: 'POST',
                    body: new FormData(form)
                });
                
                const result = await response.json();
                
                if (result.success) {
                    errorContainer.innerHTML = `
                        <div class="alert success">
                            ✅ Registration successful! Redirecting...
                        </div>
                    `;
                    setTimeout(() => window.location.href = 'login.php', 2000);
                } else {
                    errorContainer.innerHTML = `
                        <div class="alert error">
                            ⚠️ ${result.error}
                        </div>
                    `;
                    registerCard.classList.add('shake');
                    setTimeout(() => registerCard.classList.remove('shake'), 500);
                }
            } catch (error) {
                errorContainer.innerHTML = `
                    <div class="alert error">
                        ⚠️ Network Error - Please try again
                    </div>
                `;
            } finally {
                btnText.textContent = 'Create Account';
                spinner.style.display = 'none';
            }
        });

        // Real-time validations
        document.getElementById('username').addEventListener('input', function() {
            this.value = this.value.replace(/[^a-zA-Z0-9_]/g, '');
        });

        document.getElementById('password').addEventListener('input', function() {
            const rules = document.querySelector('.password-rules');
            const hasLength = this.value.length >= 8;
            const hasUpper = /[A-Z]/.test(this.value);
            const hasLower = /[a-z]/.test(this.value);
            const hasNumber = /\d/.test(this.value);

            rules.innerHTML = `
                ${hasLength ? '✓' : '✗'} At least 8 characters<br>
                ${(hasUpper && hasLower) ? '✓' : '✗'} Uppercase and lowercase letters<br>
                ${hasNumber ? '✓' : '✗'} At least one number
            `;
        });
    </script>
</body>
</html>