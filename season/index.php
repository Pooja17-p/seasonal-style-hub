<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Seasonal Styles Hub</title>
  <link rel="stylesheet" href="style.css">
  <!-- Font Awesome for icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
  <header>
    <div class="logo">Seasonal Styles</div>
    <nav>
      <ul>
        <li><a href="index.php">Home</a></li>
        <li><a href="shop.html">Shop</a></li>
      </ul>
    </nav>

    <!-- Top-right icons -->
    <div class="header-icons">
      <?php if (isset($_SESSION['user_id'])): ?>
        <span class="welcome">👋 Welcome, <?php echo htmlspecialchars($_SESSION['name']); ?></span>
        <a href="backend/profile.php" title="Profile"><i class="fas fa-user"></i></a>
        <a href="backend/logout.php" title="Logout"><i class="fas fa-sign-out-alt"></i></a>
      <?php else: ?>
        <a href="backend/register.php" title="Register"><i class="fas fa-user-plus"></i></a>
        <a href="backend/login.php" title="Login"><i class="fas fa-sign-in-alt"></i></a>
      <?php endif; ?>
      
      <div class="cart-icon">
        <a href="backend/cart.php"><i class="fas fa-shopping-cart"></i></a>
        <span class="cart-count" id="cartCount">0</span>
      </div>
    </div>
  </header>

  <div class="slider">
    <div class="slide active" style="background-image: url('b1.jpg');"></div>
    <div class="slide" style="background-image: url('b2.jpg');"></div>
    <div class="slide" style="background-image: url('b3.jpg');"></div>
    <div class="slide" style="background-image: url('b4.jpg');"></div>
    <div class="overlay">
      <h1>Seasonal Styles</h1>
      <a href="shop.html" class="shop-now">Shop Now</a>
    </div>
  </div>

  <script src="script.js"></script>
</body>
</html>
