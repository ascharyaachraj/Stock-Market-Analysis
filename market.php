<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Stock Market Basics</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0; padding: 0;
      background: #f4f4f4;
    }
    header {
      background: #333;
      color: white;
      padding: 1em;
      text-align: center;
    }
    section {
      padding: 20px;
      max-width: 900px;
      margin: auto;
      background: white;
      margin-top: 20px;
      border-radius: 10px;
      box-shadow: 0 0 10px #ccc;
    }
    .stock-simulator {
      margin-top: 20px;
    }
    .stock-box {
      padding: 10px;
      margin: 10px 0;
      background: #e3f2fd;
      border-left: 5px solid #1976d2;
    }
    button {
      padding: 10px 20px;
      background: #1976d2;
      color: white;
      border: none;
      cursor: pointer;
      margin-top: 10px;
    }
    .faq-item {
      margin: 10px 0;
      border-bottom: 1px solid #ddd;
    }
    .faq-question {
      cursor: pointer;
      font-weight: bold;
      color: #1976d2;
    }
    .faq-answer {
      display: none;
      margin-top: 5px;
    }
    footer {
      margin: 30px auto;
      text-align: center;
      font-size: 0.9em;
      color: #666;
    }
    form input {
      padding: 8px;
      margin: 5px 0;
      width: 100%;
      max-width: 400px;
      display: block;
    }
  </style>
</head>
<body>

<header>
  <h1>Understanding the Stock Market</h1>
</header>

<section>
  <h2>What is the Stock Market?</h2>
  <p>
    The stock market is a marketplace where shares of publicly held companies are bought and sold. It plays a crucial role in the economic development of a country by facilitating capital formation and liquidity.
  </p>

  <div class="stock-simulator">
    <h3>Live Stock Simulator</h3>
    <div id="stockData">
      <!-- JS will inject simulated stocks here -->
    </div>
    <button onclick="generateStocks()">Refresh Prices</button>
  </div>

  <div class="faq">
    <h3>FAQs</h3>
    <div class="faq-item">
      <div class="faq-question">What is a stock?</div>
      <div class="faq-answer">A stock represents ownership in a company and a claim on a part of its profits.</div>
    </div>
    <div class="faq-item">
      <div class="faq-question">How do I start investing?</div>
      <div class="faq-answer">You can start by opening a brokerage account and researching companies before buying their stock.</div>
    </div>
    <div class="faq-item">
      <div class="faq-question">What are dividends?</div>
      <div class="faq-answer">Dividends are payments made by a corporation to its shareholders, usually as a distribution of profits.</div>
    </div>
  </div>

  <div class="newsletter">
    <h3>Subscribe to our Newsletter</h3>
    <form method="POST">
      <input type="text" name="name" placeholder="Your name" required>
      <input type="email" name="email" placeholder="Your email" required>
      <button type="submit" name="subscribe">Subscribe</button>
    </form>
    <?php
      if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['subscribe'])) {
          $name = htmlspecialchars($_POST['name']);
          $email = htmlspecialchars($_POST['email']);
          echo "<p style='color:green;'>Thank you, $name! You've subscribed with $email.</p>";
      }
    ?>
  </div>
</section>

<footer>
  &copy; 2025 Stock Insights. All rights reserved.
</footer>

<script>
  const stockNames = ["AAPL", "GOOG", "AMZN", "TSLA", "MSFT", "META"];

  function generateStocks() {
    const container = document.getElementById("stockData");
    container.innerHTML = '';
    stockNames.forEach(stock => {
      const price = (Math.random() * 1000 + 100).toFixed(2);
      const div = document.createElement("div");
      div.className = "stock-box";
      div.textContent = `${stock}: $${price}`;
      container.appendChild(div);
    });
  }

  // Initial load
  generateStocks();

  // FAQ toggle
  document.querySelectorAll(".faq-question").forEach(item => {
    item.addEventListener("click", () => {
      const answer = item.nextElementSibling;
      answer.style.display = answer.style.display === "block" ? "none" : "block";
    });
  });
</script>

</body>
</html>
