<?php
session_start();
require '../db.php';

if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: process_login.php");
    exit();
}

if (!isset($_GET['staff_id'])) {
    echo "Staff ID is missing.";
    exit();
}

$staff_id = trim($_GET['staff_id']);

// Delete the user's booking record only
$delete_booking = $mysqli->prepare("DELETE FROM bookings WHERE staff_id = ?");
$delete_booking->bind_param("s", $staff_id);

if ($delete_booking->execute()) {
    header("Location: admin_dashboard.php");
    exit();
} else {
    echo "Error resetting booking.";
}
?>
