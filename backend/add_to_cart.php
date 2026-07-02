<?php
include 'db.php';
session_start();

if(!isset($_SESSION['user_id'])) {
    die("Please login first.");
}

$user_id = $_SESSION['user_id'];

if(isset($_POST['product_id'])) {
    $product_id = $_POST['product_id'];
    $quantity = $_POST['quantity'] ?? 1;

    // Prepare statement to insert into cart
    $stmt = $conn->prepare("INSERT INTO cart (user_id, product_id, quantity) 
                            VALUES (?, ?, ?)
                            ON DUPLICATE KEY UPDATE quantity = quantity + ?");
    if(!$stmt) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("iiii", $user_id, $product_id, $quantity, $quantity);

    if($stmt->execute()) {
        echo "Added to cart!";
    } else {
        die("Execute failed: " . $stmt->error);
    }
}
?>
