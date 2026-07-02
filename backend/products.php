<?php
include 'db.php';
session_start();

$sql = "SELECT * FROM products";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<div style='margin:20px; border:1px solid #ccc; padding:10px; width:220px; display:inline-block; text-align:center;'>";
        
        // Image (from season folder)
        if (!empty($row['image'])) {
            echo "<img src='../season/" . $row['image'] . "' alt='" . $row['title'] . "' width='150'><br>";
        } else {
            echo "<img src='../season/placeholder.png' alt='No Image' width='150'><br>";
        }

        // Product title
        echo "<h3>" . htmlspecialchars($row['title']) . "</h3>";

        // Description
        echo "<p>" . htmlspecialchars($row['description']) . "</p>";

        // Price
        echo "<p><strong>₹" . number_format($row['price'], 2) . "</strong></p>";

        // Cart button
        echo "<button>Add to Cart 🛒</button>";

        echo "</div>";
    }
} else {
    echo "No products available.";
}

$conn->close();
?>
