<?php
session_start();
require '../db.php'; // Update path if needed

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    $stmt = $mysqli->prepare("SELECT * FROM admin_users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows === 1) {
        $admin = $result->fetch_assoc();

        if (password_verify($password, $admin['password'])) {
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['admin_name'] = $admin['username'];
            header("Location: admin_dashboard.php");
            exit();
        } else {
            $_SESSION['login_error'] = "❌ Incorrect password";
            header("Location: admin_login.php");
            exit();
        }
    } else {
        $_SESSION['login_error'] = "❌ Admin user not found";
        header("Location: admin_login.php");
        exit();
    }
} else {
    header("Location: admin_login.php");
    exit();
}
