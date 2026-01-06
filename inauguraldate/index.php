<?php
session_start();

if (isset($_SESSION['staff_id'])) {
    header("Location: dashboard.php");
    exit();
}

if (isset($_SESSION['admin_logged_in'])) {
    header("Location: admin/dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Welcome - Inaugural Booking</title>
  <link rel="stylesheet" href="assets/style.css">
  <style>
    body {
      background-color: #f8fafc;
      margin: 0;
      padding: 0;
      font-family: "Segoe UI", sans-serif;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }

    .welcome-box {
      text-align: center;
      background: #ffffff;
      padding: 40px;
      border-radius: 12px;
      box-shadow: 0 0 15px rgba(0,0,0,0.1);
    }

    .logo {
      width: 150px;
      margin-bottom: 20px;
    }

    h1 {
      font-size: 24px;
      color: #333;
      margin-bottom: 10px;
    }

    p {
      font-size: 16px;
      color: #555;
      margin-bottom: 30px;
    }

    .get-started-btn {
      display: inline-block;
      background-color: #0073e6;
      color: white;
      text-decoration: none;
      padding: 12px 24px;
      font-size: 16px;
      border-radius: 8px;
      transition: background-color 0.3s ease;
    }

    .get-started-btn:hover {
      background-color: #005bb5;
    }
  </style>
</head>
<body>

  <div class="welcome-box">
    <img src="assets/logo.png" alt="University Logo" class="logo">

    <h1>Welcome to Futa Inaugural Lecture Booking Portal</h1>
    <p>This platform allows staff to register and book their date of inuagural lectures.</p>

    <a href="signup.php" class="get-started-btn">Get Started</a>
  </div>

</body>
</html>
