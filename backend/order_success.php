<?php
$fullname = $_GET['fullname'] ?? "Guest";
$payment = $_GET['payment'] ?? "Unknown";
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Order Success</title>
  <style>
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background: #ffe6f0; /* soft pink */
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
      margin: 0;
    }

    .success-container {
      background: #fff;
      padding: 40px 50px;
      border-radius: 12px;
      box-shadow: 0 6px 20px rgba(0,0,0,0.15);
      text-align: center;
      max-width: 500px;
    }

    h1 {
      color: #28a745; /* green success */
      margin-bottom: 20px;
      font-size: 2rem;
    }

    p {
      color: #444;
      font-size: 1.1rem;
      margin: 10px 0;
    }

    strong {
      color: #ff6b81; /* site accent */
    }

    a {
      display: inline-block;
      margin-top: 25px;
      padding: 12px 25px;
      background: #ff6b81;
      color: #fff;
      text-decoration: none;
      border-radius: 8px;
      font-weight: bold;
      transition: all 0.3s ease;
    }

    a:hover {
      background: #ff4757;
      transform: translateY(-2px);
    }
  </style>
</head>
<body>
  <div class="success-container">
    <h1>🎉 Order Placed Successfully!</h1>
    <p>Thank you, <strong><?php echo htmlspecialchars($fullname); ?></strong>.</p>
    <p>Your payment method: <strong><?php echo htmlspecialchars($payment); ?></strong></p>
    <p>We’ll get your order delivered soon.</p>
    <a href="../season/index.php">Go Back to Home</a>
  </div>
</body>
</html>
