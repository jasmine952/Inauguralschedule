<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Forgot Password</title>
  <link rel="stylesheet" href="assets/style.css"> <!-- Optional external CSS -->
  <style>
    body {
      background: #f4f7fa;
      font-family: 'Segoe UI', sans-serif;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
    }

    .form-container {
      background: #ffffff;
      padding: 40px;
      border-radius: 10px;
      box-shadow: 0 0 20px rgba(0, 0, 0, 0.08);
      max-width: 400px;
      width: 100%;
      text-align: center;
    }

    .form-container h2 {
      margin-bottom: 25px;
      color: #333;
    }

    .form-container input[type="email"] {
      width: 100%;
      padding: 12px;
      margin-bottom: 20px;
      border: 1px solid #ccc;
      border-radius: 8px;
      font-size: 15px;
    }

    .form-container button {
      width: 100%;
      padding: 12px;
      background: #0073e6;
      color: white;
      border: none;
      border-radius: 8px;
      font-size: 16px;
      cursor: pointer;
    }

    .form-container button:hover {
      background-color: #005bb5;
    }

    .form-container p {
      margin-top: 15px;
      font-size: 14px;
    }

    .form-container a {
      color: #0073e6;
      text-decoration: none;
    }
     .logo { width: 100px; margin-bottom: 20px; margin: 0 auto 15px auto; display: block;}

  </style>
</head>
<body>

  <div class="form-container">
    <img src="assets/logo.png" alt="University Logo" class="logo" >
    <h2>Forgot Password</h2>
    <form action="send_reset_link.php" method="POST">
      <label for="email">Email Address</label><br>
      <input type="email" name="email" id="email" required>
      <button type="submit">Send Reset Link</button>
    </form>
    <p><a href="login.php">← Back to Login</a></p>
  </div>

</body>
</html>
