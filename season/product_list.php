<?php
include '../backend/db.php';
session_start();

if(!isset($_SESSION['user_id'])) {
    die("Please login first.");
}

$user_id = $_SESSION['user_id'];

// Season filter from GET parameter
$seasons = ['summer', 'winter', 'spring', 'autumn'];
$selected_season = isset($_GET['season']) && in_array($_GET['season'], $seasons) ? $_GET['season'] : 'summer';

// Fetch products for selected season
$products = $conn->query("SELECT * FROM products WHERE season='$selected_season'");

// Display season buttons
echo '<div style="margin-bottom:20px;">';
foreach($seasons as $season) {
    $style = $season === $selected_season ? 'background-color:#007BFF; color:#fff;' : 'background-color:#f0f0f0;';
    echo "<a href='product_list.php?season=$season' style='margin:5px; padding:10px; text-decoration:none; $style border-radius:5px;'>" . ucfirst($season) . "</a>";
}
echo '</div>';

// Display products in a grid
echo "<div style='display:grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap:20px;'>";

while($p = $products->fetch_assoc()) {
    echo "<div style='border:1px solid #ccc; padding:10px; border-radius:5px; text-align:center;'>";

    // Product title
    echo "<h3>" . htmlspecialchars($p['title']) . "</h3>";

    // Price
    echo "<p>Price: $" . htmlspecialchars($p['price']) . "</p>";

    // Description
    if(!empty($p['description'])) {
        echo "<p>" . htmlspecialchars($p['description']) . "</p>";
    }

    // Image handling
    $image_file = $p['image'];
    if(!empty($image_file) && file_exists($image_file)) {
        echo "<img src='" . htmlspecialchars($image_file) . "' style='max-width:100%; height:auto;'>";
    } else {
        echo "<img src='https://via.placeholder.com/150?text=No+Image' style='max-width:100%; height:auto;'>";
    }

    // Add-to-Cart form
    echo "<form method='POST' action='../backend/add_to_cart.php' style='margin-top:10px;'>
            <input type='hidden' name='product_id' value='" . intval($p['id']) . "'>
            <input type='number' name='quantity' value='1' min='1' style='width:50px;'>
            <button type='submit' style='padding:5px 10px; margin-left:5px;'>Add to Cart</button>
          </form>";

    echo "</div>";
}

echo "</div>";
?>
