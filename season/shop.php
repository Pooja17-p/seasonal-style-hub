<?php
include '../backend/db.php';
session_start();

if(!isset($_SESSION['user_id'])) {
    die("Please login first.");
}

$user_id = $_SESSION['user_id'];

// Fetch all products
$products = $conn->query("SELECT * FROM products");

echo "<h2>Products</h2>";

while($p = $products->fetch_assoc()) {
    echo "<div style='border:1px solid #ccc; padding:10px; margin:10px;'>";

    // Product title
    echo "<h3>" . $p['title'] . "</h3>";

    // Price
    echo "<p>Price: " . $p['price'] . "</p>";

    // Description
    if(!empty($p['description'])) {
        echo "<p>" . $p['description'] . "</p>";
    }

    // Image (directly in season folder)
    if(!empty($p['image'])) {
        echo "<img src='" . $p['image'] . "' width='100'>";
    }

    // Add-to-Cart form
    echo "<form method='POST' action='../backend/add_to_cart.php'>
            <input type='hidden' name='product_id' value='" . $p['id'] . "'>
            <input type='number' name='quantity' value='1' min='1'>
            <button type='submit'>Add to Cart</button>
          </form>";

    echo "</div>";
}
?>
