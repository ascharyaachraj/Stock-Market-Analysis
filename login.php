<?php
require_once 'config.php';

$error = '';
$username = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die("Invalid CSRF token");
    }

    $username = trim($_POST['username']);
    $password = $_POST['password'];

    try {
        if (empty($username) || empty($password)) {
            throw new Exception("Please fill in all fields");
        }

        $stmt = $conn->prepare("SELECT id, password FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();
            if (password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                echo json_encode(['success' => true]);
                exit();
            }
        }
        throw new Exception("Invalid username or password");
    } catch (Exception $e) {
        $error = $e->getMessage();
        echo json_encode(['success' => false, 'error' => $error]);
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SmartStock Vision</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
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
            position: relative;
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

        @media (max-width: 480px) {
            .auth-card {
                padding: 25px;
            }
            
            h2 {
                font-size: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <div class="auth-container">
        <div class="auth-card" id="loginCard">
            <h2>🔒 SmartStock Login</h2>
            <div id="errorContainer"></div>
            
            <form id="loginForm" method="POST">
                <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                
                <div class="form-group">
                    <input type="text" id="username" name="username" placeholder="Username" required
                           value="<?= htmlspecialchars($username) ?>">
                </div>

                <div class="form-group">
                    <div class="password-container">
                        <input type="password" id="password" name="password" placeholder="Password" required>
                        <i class="toggle-password fas fa-eye" onclick="togglePassword()"></i>
                    </div>
                </div>

                <button type="submit">
                    <span id="btnText">Sign In</span>
                    <div class="spinner" id="spinner"></div>
                </button>
            </form>

            <div style="margin-top: 20px; text-align: center;">
                <a href="register.php" style="color: var(--primary-color); text-decoration: none;">
                    Create New Account
                </a>
            </div>
        </div>
    </div>

    <script>
        function togglePassword() {
            const password = document.getElementById('password');
            const icon = document.querySelector('.toggle-password');
            password.type = password.type === 'password' ? 'text' : 'password';
            icon.classList.toggle('fa-eye-slash');
        }

        document.getElementById('loginForm').addEventListener('submit', async (e) => {
            e.preventDefault();
            
            const form = e.target;
            const btnText = document.getElementById('btnText');
            const spinner = document.getElementById('spinner');
            const errorContainer = document.getElementById('errorContainer');
            
            btnText.textContent = 'Authenticating...';
            spinner.style.display = 'inline-block';

            try {
                const response = await fetch('login.php', {
                    method: 'POST',
                    body: new FormData(form)
                });
                
                const result = await response.json();
                
                if (result.success) {
                    window.location.href = 'dashboard.php';
                } else {
                    errorContainer.innerHTML = `
                        <div class="alert error">
                            ⚠️ ${result.error}
                        </div>
                    `;
                    loginCard.classList.add('shake');
                    setTimeout(() => loginCard.classList.remove('shake'), 500);
                }
            } catch (error) {
                errorContainer.innerHTML = `
                    <div class="alert error">
                        ⚠️ Network Error - Please try again
                    </div>
                `;
            } finally {
                btnText.textContent = 'Sign In';
                spinner.style.display = 'none';
            }
        });

        // Real-time input validation
        document.getElementById('username').addEventListener('input', function(e) {
            this.value = this.value.replace(/[^a-zA-Z0-9_]/g, '');
        });
    </script>
</body>
</html>