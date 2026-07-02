<?php
header("Content-Type: application/json");
include "db.php";

$data = json_decode(file_get_contents("php://input"), true);
$action = $data["action"];

if ($action === "register") {
    $name = $data["name"];
    $email = $data["email"];
    $phone = $data["phone"];
    $password = password_hash($data["password"], PASSWORD_BCRYPT);

    $stmt = $conn->prepare("INSERT INTO users (name, email, phone, password) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $name, $email, $phone, $password);

    if ($stmt->execute()) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["error" => "Email already exists"]);
    }
}

if ($action === "login") {
    $email = $data["email"];
    $password = $data["password"];

    $stmt = $conn->prepare("SELECT id, password FROM users WHERE email=?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($id, $hashedPassword);
    $stmt->fetch();

    if ($stmt->num_rows > 0 && password_verify($password, $hashedPassword)) {
        echo json_encode(["success" => true, "user_id" => $id]);
    } else {
        echo json_encode(["error" => "Invalid credentials"]);
    }
}
?>
