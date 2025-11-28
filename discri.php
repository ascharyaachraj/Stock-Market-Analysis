<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Real-Time Discrepancy Alerts</title>
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      margin: 0;
      padding: 0;
      background: #f0f2f5;
      color: #333;
    }
    header {
      background: #1e1e2f;
      color: white;
      padding: 15px;
      text-align: center;
    }
    main {
      display: flex;
      justify-content: center;
      flex-direction: column;
      align-items: center;
      padding: 20px;
    }
    .video-feed {
      width: 640px;
      height: 360px;
      background: black;
      border-radius: 10px;
      box-shadow: 0 0 20px rgba(0,0,0,0.3);
      position: relative;
      overflow: hidden;
    }
    .alert-box {
      margin-top: 20px;
      padding: 15px;
      background: #fff5f5;
      color: #b00020;
      border: 2px solid #f44336;
      width: 640px;
      border-radius: 10px;
      display: none;
      font-weight: bold;
      animation: blink 1s infinite alternate;
    }
    @keyframes blink {
      from { background-color: #fff5f5; }
      to { background-color: #ffeaea; }
    }
    .controls {
      margin-top: 20px;
    }
    button {
      padding: 10px 20px;
      background: #1976d2;
      border: none;
      color: white;
      font-size: 16px;
      cursor: pointer;
      border-radius: 5px;
    }
    button:hover {
      background: #1565c0;
    }
  </style>
</head>
<body>

<header>
  <h1>Real-Time Discrepancy Alert System</h1>
</header>

<main>
  <div class="video-feed" id="videoFeed">
    <!-- You can use actual video here -->
    <canvas id="canvas" width="640" height="360"></canvas>
  </div>

  <div class="alert-box" id="alertBox">
    🚨 Discrepancy Detected! Please investigate immediately.
  </div>

  <div class="controls">
    <button onclick="toggleMonitoring()">Start Monitoring</button>
  </div>
</main>

<script>
  const canvas = document.getElementById('canvas');
  const ctx = canvas.getContext('2d');
  const alertBox = document.getElementById('alertBox');
  let monitoring = false;
  let interval;

  function drawMockVideo() {
    ctx.fillStyle = '#000';
    ctx.fillRect(0, 0, canvas.width, canvas.height);
    ctx.fillStyle = '#0f0';
    ctx.font = '20px Arial';
    ctx.fillText('Simulated CV Feed...', 20, 50);
    ctx.strokeStyle = '#0f0';
    ctx.strokeRect(150, 100, 200, 150);
    ctx.fillText('Object Detected', 160, 130);
  }

  function toggleMonitoring() {
    monitoring = !monitoring;
    const btn = document.querySelector('button');
    if (monitoring) {
      btn.textContent = 'Stop Monitoring';
      interval = setInterval(simulateDetection, 2000);
    } else {
      btn.textContent = 'Start Monitoring';
      clearInterval(interval);
      alertBox.style.display = 'none';
    }
  }

  function simulateDetection() {
    drawMockVideo();
    const rand = Math.random();
    if (rand > 0.7) {
      alertBox.style.display = 'block';
    } else {
      alertBox.style.display = 'none';
    }
  }

  // Initial render
  drawMockVideo();
</script>

</body>
</html>
