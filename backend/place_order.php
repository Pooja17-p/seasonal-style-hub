<?php
include 'db.php';
session_start();

if(!isset($_SESSION['user_id'])) {
    die("Please login first.");
}

$user_id = $_SESSION['user_id'];

// Get payment method
if(!isset($_POST['payment_method'])) {
    die("Please select a payment method.");
}
$payment_method = $_POST['payment_method'];

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
$stmt = $conn->prepare("INSERT INTO orders (user_id, total, status, payment_method) VALUES (?, ?, 'pending', ?)");
$stmt->bind_param("ids", $user_id, $total, $payment_method);
$stmt->execute();
$order_id = $stmt->insert_id;

// Insert order items
$cart_items->data_seek(0); // reset pointer
$stmt2 = $conn->prepare("INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");
while($row = $cart_items->fetch_assoc()) {
    $price = getProductPrice($row['product_id'], $conn);
    $stmt2->bind_param("iiid", $order_id, $row['product_id'], $row['quantity'], $price);
    $stmt2->execute();
}

// Clear cart
$conn->query("DELETE FROM cart WHERE user_id = $user_id");

echo "<h2>✅ Order placed successfully!</h2>";
echo "<p>Order ID: $order_id</p>";
echo "<p>Payment Method: $payment_method</p>";
echo "<a href='index.php'>Go back to Home</a>";
?>
