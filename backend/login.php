<?php 
session_start();
include 'db.php'; // db.php in backend/

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    $stmt = $conn->prepare("SELECT id, name, email, password FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows === 1) {
        $row = $result->fetch_assoc();

        if (password_verify($password, $row['password'])) {
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['email'] = $row['email'];
            $_SESSION['name'] = $row['name'];

            header("Location: /SeasonalStyleHub/season/index.php");
            exit();
        } else {
            $error = "Incorrect password.";
        }
    } else {
        $error = "No account found with that email.";
    }

    $stmt->close();
    $conn->close();
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Login</title>
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
    <h2>Login</h2>
    <?php if (!empty($error)) echo "<p class='error'>$error</p>"; ?>
    <form method="post" action="">
      <label for="email">Email Address</label>
      <input type="email" name="email" id="email" placeholder="Enter your email" required>

      <label for="password">Password</label>
      <input type="password" name="password" id="password" placeholder="Enter your password" required>

      <button type="submit" class="btn-primary">Login</button>
    </form>
    <p class="switch-link">Don’t have an account? <a href="register.php">Register here</a></p>
  </div>

</body>
</html>
