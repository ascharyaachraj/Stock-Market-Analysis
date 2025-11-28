<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>AI-Driven Purchase Orders</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #f8f9fa;
      margin: 0;
      padding: 0;
    }
    header {
      background: #343a40;
      color: #fff;
      padding: 20px;
      text-align: center;
    }
    section {
      max-width: 900px;
      margin: auto;
      background: #fff;
      padding: 20px;
      margin-top: 20px;
      border-radius: 10px;
      box-shadow: 0 0 10px #ccc;
    }
    h2 {
      color: #343a40;
    }
    .order-box {
      padding: 15px;
      margin: 10px 0;
      background: #e9f5ff;
      border-left: 5px solid #007bff;
    }
    button {
      padding: 10px 20px;
      background: #007bff;
      color: white;
      border: none;
      cursor: pointer;
      margin-top: 10px;
      border-radius: 4px;
    }
    form input, form select {
      padding: 8px;
      margin: 10px 0;
      width: 100%;
      max-width: 400px;
      display: block;
    }
    .confirmation {
      background: #d4edda;
      color: #155724;
      padding: 15px;
      margin-top: 20px;
      border-left: 5px solid #28a745;
      border-radius: 5px;
    }
  </style>
</head>
<body>

<header>
  <h1>AI-Driven Purchase Order System</h1>
</header>

<section>
  <h2>Market Trend Analysis</h2>
  <p>This simulation analyzes current market trends using a mock AI model and suggests optimized purchase orders.</p>
  
  <div id="orders"></div>
  <button onclick="generateOrders()">Generate AI Orders</button>
</section>

<section>
  <h2>Manual Order Override</h2>
  <form method="POST">
    <input type="text" name="product" placeholder="Product Name" required>
    <input type="number" name="quantity" placeholder="Quantity" required min="1">
    <select name="priority" required>
      <option value="">Select Priority</option>
      <option value="High">High</option>
      <option value="Medium">Medium</option>
      <option value="Low">Low</option>
    </select>
    <button type="submit" name="submit_order">Submit Manual Order</button>
  </form>

  <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_order'])) {
      $product = htmlspecialchars($_POST['product']);
      $quantity = (int)$_POST['quantity'];
      $priority = htmlspecialchars($_POST['priority']);

      echo "<div class='confirmation'>
              Manual order submitted: <strong>$product</strong> x <strong>$quantity</strong> (Priority: $priority)
            </div>";
    }
  ?>
</section>

<script>
  const products = ["Semiconductors", "Electric Vehicles", "Solar Panels", "AI Chips", "Cloud Servers"];

  function generateOrders() {
    const container = document.getElementById("orders");
    container.innerHTML = '';
    products.forEach(product => {
      const trend = Math.random();
      let action = "";
      let qty = 0;

      if (trend > 0.7) {
        action = "Strong Buy";
        qty = Math.floor(Math.random() * 100 + 50);
      } else if (trend > 0.4) {
        action = "Moderate Buy";
        qty = Math.floor(Math.random() * 50 + 20);
      } else {
        action = "Hold";
        qty = 0;
      }

      const div = document.createElement("div");
      div.className = "order-box";
      div.innerHTML = `<strong>${product}</strong>: ${action}` + (qty ? ` - Recommended Qty: ${qty}` : '');
      container.appendChild(div);
    });
  }

  // Auto-generate on page load
  window.onload = generateOrders;
</script>

</body>
</html>
