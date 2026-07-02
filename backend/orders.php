<?php
include 'db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    die("❌ Please login to view orders.");
}

$user_id = $_SESSION['user_id'];

$sql = "SELECT id, total, created_at FROM orders WHERE user_id = ? ORDER BY created_at DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "📭 No orders found.";
} else {
    while ($order = $result->fetch_assoc()) {
        echo "<h3>🧾 Order #" . $order['id'] . " | ₹" . $order['total'] . " | " . $order['created_at'] . "</h3>";

        // Fetch items for this order
        $items_sql = "SELECT products.name, order_items.quantity, order_items.price 
                      FROM order_items 
                      JOIN products ON order_items.product_id = products.id 
                      WHERE order_items.order_id = ?";
        $items_stmt = $conn->prepare($items_sql);
        $items_stmt->bind_param("i", $order['id']);
        $items_stmt->execute();
        $items_result = $items_stmt->get_result();

        while ($item = $items_result->fetch_assoc()) {
            echo "- " . $item['name'] . " (" . $item['quantity'] . " x ₹" . $item['price'] . ")<br>";
        }
        echo "<hr>";
    }
}
$stmt->close();
$conn->close();
?>
