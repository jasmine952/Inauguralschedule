<?php
require 'db.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $confirm = $_POST['confirm_password'] ?? '';

    if (empty($email) || empty($password) || empty($confirm)) {
        die("All fields are required.");
    }
    if ($password !== $confirm) {
        die("Passwords do not match. <a href='javascript:history.back()'>Go back</a>");
    }
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    // Update the staff user's password
    $update = $mysqli->prepare("UPDATE staff_users SET password = ? WHERE email = ?");
    $update->bind_param("ss", $hashed_password, $email);

    if ($update->execute()) {
        // Delete token after success
        $mysqli->prepare("DELETE FROM password_resets WHERE email = ?")->bind_param("s", $email)->execute();

        echo "Password reset successful! <a href='login.html'>Click here to login</a>";
    } else {
        echo "Failed to reset password. Please try again.";
    }
} else {
    header("Location: password_update_success.php");
    exit();
}
?