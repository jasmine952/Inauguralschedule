<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Login</title>
  <style>
    body {
      background: #f4f7fa;
      font-family: 'Segoe UI', sans-serif;
    }
    .container {
      max-width: 400px;
      margin: 100px auto;
      background: white;
      padding: 45px;
      border-radius: 20px;
      box-shadow: 0 0 12px rgba(0,0,0,0.1);
    }
    h2 {
      text-align: center;
    }
    label {
      margin-top: 15px;
      display: block;
    }
    input {
      width: 100%;
      padding: 10px;
      margin-top: 5px;
      border-radius: 6px;
      border: 1px solid #ccc;
    }
    .btn {
      background: #0073e6;
      color: white;
      width: 420px;
      padding: 10px;
      margin-top: 20px;
      border: none;
      border-radius: 6px;
      font-weight: bold;
      cursor: pointer;
    }
    .error {
      color: red;
      text-align: center;
      margin-top: 15px;
    }
     .logo { 
      width: 120px; 
      margin-bottom: 20px; 
      margin: 0 auto 15px auto; 
      display: block;
    }
  </style>
</head>
<body>
<div class="container">
    <img src="logo.png" alt="University Logo" class="logo" >
  <h2>Admin Login</h2>
  <form method="POST" action="process_login.php">
    <label>Username:</label>
    <input type="text" name="username" required>

    <label>Password:</label>
    <input type="password" name="password" required>

    <button type="submit" class="btn">Login</button>

    <?php if (!empty($_SESSION['login_error'])): ?>
      <div class="error"><?= $_SESSION['login_error'] ?></div>
      <?php unset($_SESSION['login_error']); ?>
    <?php endif; ?>
  </form>
</div>
</body>
</html>