<?php
session_start();
require 'db.php';

if (!isset($_SESSION['staff_id'])) {
    header("Location: login.html");
    exit();
}

$staff_id = $_SESSION['staff_id'];
$lecture_title = $_POST['lecture_title'];
$pfq_date = $_POST['pfq_date'];
$school = $_POST['school'];
$booking_date = $_POST['booking_date'];

// Prevent duplicate bookings
$stmt = $mysqli->prepare("SELECT * FROM bookings WHERE staff_id = ?");
$stmt->bind_param("s", $staff_id);
$stmt->execute();
if ($stmt->get_result()->num_rows > 0) {
    echo "You have already booked. <a href='dashboard.php'>Go back</a>";
    exit();
}

// Check if date is already booked
$stmt = $mysqli->prepare("SELECT * FROM bookings WHERE booking_date = ?");
$stmt->bind_param("s", $booking_date);
$stmt->execute();
if ($stmt->get_result()->num_rows > 0) {
    echo "This date is already taken. <a href='dashboard.php'>Go back</a>";
    exit();
}

$stmt = $mysqli->prepare("INSERT INTO bookings (staff_id, lecture_title, pfq_date, school, booking_date) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("sssss", $staff_id, $lecture_title, $pfq_date, $school, $booking_date);

if ($stmt->execute()) {
    header("Location: dashboard.php");
    exit();
} else {
    echo "Error submitting booking. <a href='dashboard.php'>Go back</a>";
}
?>
