<?php
include 'db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    echo 0; // not logged in
    exit;
}

$user_id = $_SESSION['user_id'];

$stmt = $conn->prepare("SELECT SUM(quantity) AS count FROM cart WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($count);
$stmt->fetch();

echo $count ?? 0;

$stmt->close();
$conn->close();
?>
