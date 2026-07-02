<?php
session_start();
include 'db.php'; // db.php in backend/

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($name) || empty($email) || empty($password)) {
        $error = "Please fill in all fields.";
    } else {
        // check if email exists
        $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $error = "Email is already registered.";
            $stmt->close();
        } else {
            $stmt->close();
            $hash = password_hash($password, PASSWORD_DEFAULT);

            $stmt = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $name, $email, $hash);

            if ($stmt->execute()) {
                $stmt->close();
                $conn->close();
                header("Location: /SeasonalStyleHub/backend/login.php");
                exit();
            } else {
                $error = "Registration failed. Try again later.";
            }
            $stmt->close();
        }
    }
    $conn->close();
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Create Account</title>
  <link rel="stylesheet" href="../season/style.css">
</head>
<body>

  <header>
    <div class="logo">Seasonal Styles</div>
    <nav>
      <ul>
        <li><a href="../season/index.php">Home</a></li>
        <li><a href="../season/shop.html">Shop</a></li>
      </ul>
    </nav>
  </header>

  <div class="form-container">
    <h2>Create Account</h2>
    <?php if (!empty($error)) echo "<p class='error'>$error</p>"; ?>
    <form method="post" action="">
      <label for="name">Full Name</label>
      <input type="text" name="name" id="name" placeholder="Enter your full name" required>

      <label for="email">Email Address</label>
      <input type="email" name="email" id="email" placeholder="Enter your email" required>

      <label for="password">Password</label>
      <input type="password" name="password" id="password" placeholder="Enter a strong password" required>

      <button type="submit" class="btn-primary">Register</button>
    </form>
    <p class="switch-link">Already signed up? <a href="login.php">Login here</a></p>
  </div>

</body>
</html>
