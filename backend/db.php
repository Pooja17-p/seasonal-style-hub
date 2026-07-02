<?php
$host = "localhost";   // XAMPP default
$user = "root";        // default username
$pass = "";            // default password is empty
$dbname = "seasonal_style"; // your database name

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
