<?php
require 'db.php';

$email = $_POST['email'];

// Check if email exists
$stmt = $mysqli->prepare("SELECT * FROM staff_users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();

if (!$user) {
    die("Email not found. <a href='forgot_password.html'>Try again</a>");
}

// Generate token and expiry
$token = bin2hex(random_bytes(50));
$expires_at = date('Y-m-d H:i:s', strtotime('+15 minutes'));

// Store in password_resets table
$stmt = $mysqli->prepare("INSERT INTO password_resets (email, token, expires_at) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $email, $token, $expires_at);
$stmt->execute();

// Simulate sending email (in real case use PHPMailer)
$reset_link = "http://localhost/inauguraldates/reset_password.php?token=$token";

echo "A password reset link has been generated:<br><br>";
echo "<a href='$reset_link'>$reset_link</a>";
