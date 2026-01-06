<?php
require 'db.php';

$full_name = $_POST['full_name'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$staff_id = $_POST['staff_id'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);

// Check if staff already exists
$stmt = $mysqli->prepare("SELECT * FROM staff_users WHERE staff_id = ? OR email = ?");
$stmt->bind_param("ss", $staff_id, $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo "Staff ID or email already exists. <a href='signup.html'>Go back</a>";
} else {
    $stmt = $mysqli->prepare("INSERT INTO staff_users (staff_id, full_name, email, phone, password) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $staff_id, $full_name, $email, $phone, $password);

    if ($stmt->execute()) {
        header("Location: success.php");
        exit();
    } else {
        echo "Something went wrong. Please try again.";
    }
}
header("Location: success.php");
?>