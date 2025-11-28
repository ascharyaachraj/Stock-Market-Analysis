<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?= $_SESSION['csrf_token'] ?>">
    <title>SmartStock Vision - AI Inventory Management</title>
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        :root {
            --primary-gradient: linear-gradient(45deg,#4FACFE,#00F2FE);
            --bg-dark: #0A0F29;
            --text-light: #a0a0a0;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-20px); }
        }

        .float-animation { animation: float 6s ease-in-out infinite; }

        /* Responsive Design */
        @media (max-width: 768px) {
            nav { padding: 20px; flex-direction: column; gap: 15px; }
            .hero-content { flex-direction: column; text-align: center; }
            .feature-card { width: 100%; }
            .demo-section { flex-direction: column; }
            h1 { font-size: 36px; }
            h2 { font-size: 28px; }
        }

        .auth-container {
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
    background: var(--bg-dark);
}

.auth-card {
    background: #0F1535;
    padding: 40px;
    border-radius: 20px;
    width: 100%;
    max-width: 400px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.3);
}

.auth-card input {
    width: 100%;
    padding: 12px;
    margin: 10px 0;
    background: #1a1f3d;
    border: none;
    border-radius: 8px;
    color: white;
}

.auth-card button {
    width: 100%;
    padding: 12px;
    margin-top: 20px;
    background: var(--primary-gradient);
    border: none;
    border-radius: 8px;
    color: white;
    cursor: pointer;
}

.error {
    color: #ff4d4d;
    margin: 10px 0;
}
    </style>
</head>
<body style="margin:0;background:var(--bg-dark);color:white;font-family:Arial,sans-serif;overflow-x:hidden;">

<!-- Navigation -->
<div style="display:flex;gap:30px;align-items:center;">
    <a href="#features" style="color:#fff;text-decoration:none;transition:0.3s;">Features</a>
    <a href="#demo" style="color:#fff;text-decoration:none;transition:0.3s;">Demo</a>
    <a href="contact.php" style="color:#fff;text-decoration:none;transition:0.3s;">Contact</a>
    <div id="authLinks">
        <a href="login.php" class="nav-login" style="color:#fff;text-decoration:none;padding:8px 20px;border-radius:20px;background:var(--primary-gradient);">Login</a>
        <a href="register.php" class="nav-register" style="color:#fff;text-decoration:none;">Register</a>
    </div>
</div>
<!-- Hero Section -->
<section style="min-height:100vh;display:flex;align-items:center;padding:150px 5% 100px;">
    <div style="max-width:1200px;margin:0 auto;display:flex;align-items:center;gap:50px;flex-wrap:wrap;">
        <div style="flex:1;min-width:300px;">
            <h1 style="font-size:48px;margin:0 0 30px;line-height:1.2;background:var(--primary-gradient);-webkit-background-clip:text;-webkit-text-fill-color:transparent;">
                AI-Powered Inventory Optimization
            </h1>
            <p style="font-size:20px;color:var(--text-light);margin-bottom:40px;">
                Real-time stock predictions and automated replenishment using machine learning
            </p>
            <button onclick="window.location.href = 'stockmar.php';" style="padding:15px 40px;font-size:18px;background:var(--primary-gradient);border:none;border-radius:30px;color:white;cursor:pointer;">
                Start Market Analysis
            </button>
        </div>
        <div style="flex:1;position:relative;min-width:300px;">
            <div class="float-animation" style="background:linear-gradient(45deg,#4facfe33,#00f2fe33);border-radius:20px;padding:20px;backdrop-filter:blur(10px);">
                <img src="dashimg.jfif" alt="AI Dashboard" style="width:100%;border-radius:15px;">
            </div>
        </div>
    </div>
    
</section>

<!-- AI Features Section -->
<section id="features" style="padding:100px 5%;background:#070A1C;">
    <h2 style="text-align:center;font-size:36px;margin-bottom:60px;">AI-Powered Features</h2>
    <div style="display:grid;grid-template-columns:repeat(auto-fit, minmax(300px, 1fr));gap:30px;">
        <div data-aos="fade-up" style="background:#0F1535;padding:30px;border-radius:15px;">
            <div style="width:60px;height:60px;background:#4facfe33;border-radius:12px;display:grid;place-items:center;">
                <svg style="width:30px;height:30px;color:#4FACFE;" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9h14M5 15h14m0-6a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2h14z"/>
                </svg>
            </div>
            <h3 style="font-size:24px;margin:20px 0 10px;"><a href="features.php">Predictive Analysis</a></h3>
            <p style="color:var(--text-light);">Machine learning forecasts demand and optimizes stock levels</p>
        </div>

        <div data-aos="fade-up" style="background:#0F1535;padding:30px;border-radius:15px;">
            <div style="width:60px;height:60px;background:#4facfe33;border-radius:12px;display:grid;place-items:center;">
                <svg style="width:30px;height:30px;color:#4FACFE;" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                </svg>
            </div>
            <h3 style="font-size:24px;margin:20px 0 10px;"><a href="ai_purchase_orders.php">Auto-Replenishment</a></h3>
            <p style="color:var(--text-light);">AI-driven purchase orders based on market trends</p>
        </div>

        <div data-aos="fade-up" style="background:#0F1535;padding:30px;border-radius:15px;">
            <div style="width:60px;height:60px;background:#4facfe33;border-radius:12px;display:grid;place-items:center;">
                <svg style="width:30px;height:30px;color:#4FACFE;" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                </svg>
            </div>
            <h3 style="font-size:24px;margin:20px 0 10px;"><a href="discri.php">Anomaly Detection</a></h3>
            <p style="color:var(--text-light);">Real-time discrepancy alerts using computer vision</p>
        </div>
    </div>
</section>

<!-- AI Demo Section -->
<section id="demo" style="padding:100px 5%;">
    <div style="max-width:1200px;margin:0 auto;display:flex;gap:50px;flex-wrap:wrap;align-items:center;">
        <div style="flex:1;min-width:300px;">
            <h2 style="font-size:36px;margin-bottom:30px;"><a href="dashboard.php">Live AI Predictions</a></h2>
            <p style="color:var(--text-light);margin-bottom:40px;">
                See real-time inventory optimization powered by our neural networks
            </p>
            <div id="aiStats" style="display:grid;gap:20px;margin-bottom:40px;">
                <div style="background:#0F1535;padding:20px;border-radius:15px;">
                    <div style="display:flex;justify-content:space-between;">
                        <span>Stock Accuracy</span>
                        <span id="accuracy">95%</span>
                    </div>
                    <div style="height:4px;background:#1a1f3d;margin-top:10px;">
                        <div id="accuracyBar" style="width:95%;height:100%;background:var(--primary-gradient);transition:0.3s;"></div>
                    </div>
                </div>
            </div>
        </div>
        <div style="flex:1;min-width:300px;position:relative;">
            <canvas id="aiChart" style="background:#0F1535;border-radius:15px;padding:20px;"></canvas>
        </div>
    </div>
</section>

<script>
    // Initialize AOS
    AOS.init({ duration: 1000, once: true });

    // Real-time Chart Implementation
    const ctx = document.getElementById('aiChart').getContext('2d');
    const chart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
            datasets: [{
                label: 'AI Predicted Stock',
                data: [65, 59, 80, 81, 56, 55],
                borderColor: '#4FACFE',
                tension: 0.4,
                fill: false
            }, {
                label: 'Actual Stock',
                data: [28, 48, 40, 19, 86, 27],
                borderColor: '#00F2FE',
                tension: 0.4,
                fill: false
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { position: 'top' }
            },
            scales: {
                y: { beginAtZero: true, grid: { color: '#1a1f3d' } },
                x: { grid: { color: '#1a1f3d' } }
            }
        }
    });

    // Simulate real-time updates
    setInterval(() => {
        // Update chart data
        chart.data.datasets.forEach(dataset => {
            dataset.data = dataset.data.map(() => Math.random() * 100);
        });
        chart.update();

        // Update accuracy percentage
        const newAccuracy = Math.floor(Math.random() * 3 + 95);
        document.getElementById('accuracy').textContent = `${newAccuracy}%`;
        document.getElementById('accuracyBar').style.width = `${newAccuracy}%`;
    }, 3000);
</script>

</body>
</html>