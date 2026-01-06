<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Signup Successful</title>
  <link rel="stylesheet" href="assets/style.css">
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

    .success-box {
      background: #ffffff;
      padding: 40px;
      border-radius: 12px;
      box-shadow: 0 0 20px rgba(0, 0, 0, 0.06);
      text-align: center;
      max-width: 400px;
      width: 100%;
    }

    .success-box h2 {
      color: #28a745;
      margin-bottom: 10px;
    }

    .success-box p {
      color: #555;
      margin-bottom: 30px;
      font-size: 16px;
    }

    .success-box a {
      display: inline-block;
      padding: 12px 25px;
      background: #0073e6;
      color: white;
      border-radius: 8px;
      text-decoration: none;
      font-weight: bold;
      transition: background 0.3s ease;
    }

    .success-box a:hover {
      background: #005bb5;
    }
  </style>
</head>
<body>

  <div class="success-box">
    <h2>Successful! </h2>
    <p>Your password has been changed successfully.</p>
    <a href="login.php">Login with your new password</a>
  </div>

</body>
</html>
