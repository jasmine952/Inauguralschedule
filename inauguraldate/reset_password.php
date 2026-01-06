<?php
require 'db.php';

$token = $_GET['token'] ?? '';

if (empty($token)) {
    die("Invalid or missing token.");
}

// Check if token is valid and not expired
$stmt = $mysqli->prepare("SELECT * FROM password_resets WHERE token = ? AND expires_at > NOW()");
$stmt->bind_param("s", $token);
$stmt->execute();
$data = $stmt->get_result()->fetch_assoc();

if (!$data) {
    die("Token expired or invalid.");
}

$email = $data['email'];
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Reset Password</title>
  <link rel="stylesheet" href="assets/style.css">
</head>
<body>
  <div class="form-container">
    <h2>Reset Your Password</h2>
    <form action="update_password.php" method="POST">
      <input type="hidden" name="email" value="<?= htmlspecialchars($email) ?>">
      <label>New Password</label>
      <input type="password" name="password" required>
      <label>Confirm Password</label>
      <input type="password" name="confirm_password" required>
      <button type="submit">Reset Password</button>
    </form>
  </div>
</body>
</html>
