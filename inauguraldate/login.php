<?php
session_start();
require 'db.php';

$message = "";

// login submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $identifier = trim($_POST['identifier']);
    $password   = $_POST['password'];

    $stmt = $mysqli->prepare("SELECT staff_id, password FROM staff_users WHERE email = ? OR staff_id = ?");
    $stmt->bind_param("ss", $identifier, $identifier);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows === 1) {
        $user = $result->fetch_assoc();

        if (password_verify($password, $user['password'])) {
            $_SESSION['staff_id'] = $user['staff_id'];
            header("Location: dashboard.php");
            exit();
        } else {
            $message = " Incorrect password.";
        }
    } else {
        $message = " No account found with that email or staff ID.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Staff Login</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
  <style>
    body {
      background: #f0f4f8;
      font-family: 'Poppins', sans-serif;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }
    .form-box {
      background: #ffffff;
      padding: 40px;
      border-radius: 10px;
      box-shadow: 0 0 20px rgba(0,0,0,0.05);
      width: 100%;
      max-width: 400px;
    }
    .form-box h2 {
      margin-bottom: 20px;
      color: #333;
      text-align: center;
    }
    .form-box input {
      width: 100%;
      padding: 12px;
      margin: 10px 0;
      border: 1px solid #ddd;
      border-radius: 8px;
      font-size: 15px;
    }
    .form-box button {
      width: 105%;
      padding: 12px;
      background: #0073e6;
      border: none;
      color: white;
      border-radius: 8px;
      font-size: 16px;
      cursor: pointer;
      margin-top: 10px;
    }
    .form-box button:hover {
      background: #005bb5;
    }
    .form-box a {
      display: block;
      text-align: center;
      font-size: 13px;
      color: #0073e6;
      margin-top: 10px;
    }
    .message {
      color: red;
      font-size: 14px;
      text-align: center;
      margin-bottom: 10px;
    }
     .logo { width: 100px; margin-bottom: 20px; margin: 0 auto 15px auto; display: block;}

  </style>
</head>
<body>

  <div class="form-box">
    <img src="assets/logo.png" alt="University Logo" class="logo" >
    <h2>Staff Login</h2>
    <?php if (!empty($message)): ?>
      <div class="message"><?= $message ?></div>
    <?php endif; ?>
    <form method="POST">
      <input type="text" name="identifier" placeholder="Email or Staff ID" required>
      <input type="password" name="password" placeholder="Password" required>
      <button type="submit">Login</button>
    </form>
    <a href="forgot_password.php">Forgot Password?</a>
    <a href="signup.php">Don’t have an account? Sign up</a>
  </div>
</body>
</html>