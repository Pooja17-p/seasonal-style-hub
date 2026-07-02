<?php
include 'db.php';
session_start();

if(!isset($_SESSION['user_id'])) {
    die("Please login first.");
}

$user_id = $_SESSION['user_id'];

// Fetch cart items
$cart_items = $conn->query("SELECT * FROM cart WHERE user_id = $user_id");

if($cart_items->num_rows == 0) {
    die("Cart is empty.");
}

// Function to get product price
function getProductPrice($product_id, $conn) {
    $res = $conn->query("SELECT price FROM products WHERE id = $product_id");
    $row = $res->fetch_assoc();
    return $row['price'];
}

// Calculate total
$total = 0;
while($row = $cart_items->fetch_assoc()) {
    $total += $row['quantity'] * getProductPrice($row['product_id'], $conn);
}

// Insert order
$stmt = $conn->prepare("INSERT INTO orders (user_id, total, status) VALUES (?, ?, 'pending')");
$stmt->bind_param("id", $user_id, $total);
$stmt->execute();
$order_id = $stmt->insert_id;

// Insert order items
$cart_items->data_seek(0);
$stmt2 = $conn->prepare("INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");
while($row = $cart_items->fetch_assoc()) {
    $price = getProductPrice($row['product_id'], $conn);
    $stmt2->bind_param("iiid", $order_id, $row['product_id'], $row['quantity'], $price);
    $stmt2->execute();
}

// Clear cart
$conn->query("DELETE FROM cart WHERE user_id = $user_id");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Checkout</title>
  <link rel="stylesheet" href="../season/style.css">
</head>
<body>

  <header>
    <div class="logo">Seasonal Styles</div>
    <nav>
      <ul>
        <li><a href="../season/index.php">Home</a></li>
        <li><a href="../season/shop.html">Shop</a></li>
      </ul>
    </nav>
  </header>

  <div class="form-container">
    <h2>Order Placed Successfully!</h2>
    <p>Your order ID is <strong>#<?php echo $order_id; ?></strong></p>
    <p>Total amount: <stron
