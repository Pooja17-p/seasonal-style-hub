<?php
// connect.php

$servername = "localhost";
$username   = "root";     // default for XAMPP
$password   = "";         // default is empty
$dbname     = "seasonal_style_hub";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$conn->set_charset("utf8mb4");

// If you want to check manually
// echo "Connected successfully";
?>
