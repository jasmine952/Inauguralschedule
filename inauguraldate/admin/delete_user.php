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

// Step 1: Delete booking first (child table)
$delete_booking = $mysqli->prepare("DELETE FROM bookings WHERE staff_id = ?");
$delete_booking->bind_param("s", $staff_id);
$delete_booking->execute();

// Step 2: Now delete from staff_users (parent table)
$delete_user = $mysqli->prepare("DELETE FROM staff_users WHERE staff_id = ?");
$delete_user->bind_param("s", $staff_id);
$delete_user->execute();

// Step 3: Redirect
header("Location: admin_dashboard.php");
exit();
?>