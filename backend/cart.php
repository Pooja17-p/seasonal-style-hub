<?php
include 'db.php';
session_start();

if(!isset($_SESSION['user_id'])) {
    die("Please login first.");
}

$user_id = $_SESSION['user_id'];
$result = $conn->query("SELECT cart.id, cart.quantity, products.name, products.price 
                        FROM cart 
                        JOIN products ON cart.product_id = products.id 
                        WHERE cart.user_id = $user_id");

$total = 0;

echo "<h2>Your Cart</h2>";
echo "<table border='1'><tr><th>Product</th><th>Price</th><th>Quantity</th><th>Subtotal</th></tr>";

while($row = $result->fetch_assoc()) {
    $subtotal = $row['price'] * $row['quantity'];
    $total += $subtotal;
    echo "<tr>
            <td>{$row['name']}</td>
            <td>{$row['price']}</td>
            <td>{$row['quantity']}</td>
            <td>$subtotal</td>
          </tr>";
}

echo "<tr><td colspan='3'>Total</td><td>$total</td></tr></table>";

echo '<form method="POST" action="checkout.php">
        <button type="submit" name="checkout">Checkout</button>
      </form>';
?>
