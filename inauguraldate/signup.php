<?php
session_start();
require 'db.php';

// Show all errors (during setup)
ini_set('display_errors', 1);
error_reporting(E_ALL);

$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full_name = trim($_POST['full_name']);
    $email     = trim($_POST['email']);
    $phone     = trim($_POST['phone']);
    $staff_id  = trim($_POST['staff_id']);
    $password  = $_POST['password'];

    // Check if any field is empty
    if (empty($full_name) || empty($email) || empty($phone) || empty($staff_id) || empty($password)) {
        $message = "All fields are required.";
    } else {
        // --- Check if Staff ID already exists ---
        $checkStaff = $mysqli->prepare("SELECT staff_id FROM staff_users WHERE staff_id = ?");
        $checkStaff->bind_param("s", $staff_id);
        $checkStaff->execute();
        $resStaff = $checkStaff->get_result();

        if ($resStaff->num_rows > 0) {
            $message = "Staff ID already registered.";
        } else {
            // --- Check if Email already exists ---
            $checkEmail = $mysqli->prepare("SELECT email FROM staff_users WHERE email = ?");
            $checkEmail->bind_param("s", $email);
            $checkEmail->execute();
            $resEmail = $checkEmail->get_result();

            if ($resEmail->num_rows > 0) {
                $message = "Email already registered.";
            } else {
                // --- Insert New User ---
                $hashed_pass = password_hash($password, PASSWORD_BCRYPT);
                $stmt = $mysqli->prepare("INSERT INTO staff_users (staff_id, full_name, email, phone, password) VALUES (?, ?, ?, ?, ?)");
                $stmt->bind_param("sssss", $staff_id, $full_name, $email, $phone, $hashed_pass);

                if ($stmt->execute()) {
                    $_SESSION['staff_id'] = $staff_id;
                    header("Location: dashboard.php");
                    exit();
                } else {
                    $message = "Registration failed, please try again.";
                }
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Staff Signup</title>
  <link rel="stylesheet" href="assets/style.css">
  <style>
    body {
      background: #f0f4f8;
      font-family: 'Segoe UI';
      display: flex;
      align-items: center;
      justify-content: center;
      height: 100vh;
      margin: 0;
    }
    .form-box {
      background: #fff;
      padding: 50px;
      border-radius: 15px;
      box-shadow: 0 0 20px rgba(0,0,0,0.05);
      width: 100%;
      max-width: 450px;
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
    }
    .form-box button {
      width: 100%;
      padding: 12px;
      background: #0073e6;
      border: none;
      color: #fff;
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
      margin-top: 5px;
    }
    .message {
      color: red;
      text-align: center;
      margin-bottom: 10px;
    }
    .logo {
      width: 100px;
      margin: 0 auto 15px auto;
      display: block;
    }
  </style>
</head>
<body>

<div class="form-box">
    <img src="assets/logo.png" alt="University Logo" class="logo">
    <h2>Create User Account</h2>

    <?php if ($message): ?>
        <div class="message"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>

    <form method="POST">
        <input type="text" name="full_name" placeholder="Full Name" required>
        <input type="email" name="email" placeholder="Email Address" required>
        <input type="text" name="phone" placeholder="Phone Number" required>
        <input type="text" name="staff_id" placeholder="Emp No" required>
        <input type="password" name="password" placeholder="Create Password" required>
        <button type="submit">Sign Up</button>
    </form>
    <a href="login.php">Already have an account? Log in</a>
</div>
</body>
</html>