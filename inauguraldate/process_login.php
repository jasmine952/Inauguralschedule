<?php
session_start();
require 'db.php';

$identifier = $_POST['identifier']; // email or staff_id
$password = $_POST['password'];

$stmt = $mysqli->prepare("SELECT * FROM staff_users WHERE staff_id = ? OR email = ?");
$stmt->bind_param("ss", $identifier, $identifier);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();

    if (password_verify($password, $user['password'])) {
        // Store user in session
        $_SESSION['staff_id'] = $user['staff_id'];
        $_SESSION['full_name'] = $user['full_name'];
        header("Location: dashboard.php");
        exit();
    } else {
        echo "Incorrect password. <a href='login.html'>Try again</a>";
    }
} else {
    echo "User not found. <a href='login.html'>Try again</a>";
}
?>
