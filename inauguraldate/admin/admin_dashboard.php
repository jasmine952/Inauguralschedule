<?php
session_start();
$timeout_duration = 300;
require '../db.php';

if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: process_login.php");
    exit();
}

$admin_name = $_SESSION['admin_name'] ?? 'Admin';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard</title>
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background: #f0f4f8;
      margin: 0;
    }
    .header {
      background: #0073e6;
      color: white;
      padding: 20px;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }
    .header h1 {
      margin: 0;
      font-size: 24px;
    }
    .logout {
      background: white;
      color: #0073e6;
      padding: 8px 16px;
      text-decoration: none;
      border-radius: 6px;
      font-weight: bold;
    }
    .content {
      padding: 40px 20px;
    }
    h2 {
      margin-bottom: 20px;
    }

    .export-btn {
      display: inline-block;
      background-color: #28a745;
      color: white;
      padding: 5px 10px;
      border-radius: 6px;
      text-decoration: none;
      font-weight: bold;
      margin-bottom: 20px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      background: white;
      border-radius: 8px;
      overflow: hidden;
      box-shadow: 0 0 8px rgba(0, 0, 0, 0.05);
    }
    th, td {
      padding: 12px 15px;
      border: 1px solid #e0e0e0;
      text-align: left;
    }
    th {
      background: #f1f5f9;
    }
    .btn {
      padding: 6px 12px;
      border-radius: 8px;
      font-size: 15px;
      font-weight: bold;
      text-decoration: none;
      margin-right: 6px;
      display: inline-block;
    }
    .btn-edit {
      background-color: #0073e6;
      color: white;
      padding: 5px;
      width: 25px;
    }
    .btn-delete {
      background-color: #e60000;
      color: white;
      padding: 5px;
      width: 25px;
    }
    .btn-reset {
      background-color: #ff9800;
      color: white;
      padding: 5px;
    }
    .btn:hover, .export-btn:hover {
      opacity: 0.9;
    }

    @media screen and (max-width: 768px) {
      table, thead, tbody, th, td, tr {
        display: block;
      }
      td {
        margin-bottom: 15px;
      }
      td:before {
        content: attr(data-label);
        display: block;
        font-weight: bold;
      }
    }
  </style>
</head>
<body>

<div class="header">
  <h1>Welcome, <?= htmlspecialchars($admin_name) ?></h1>
  <a href="logout.php" class="logout">Logout</a>
</div>

<div class="content">
  <h2>Inuagural Lecture Booking Overview</h2>

  <div style="text-align: right;">
    <a href="add_user_booking.php" class="export-btn" style="background-color:#0073e6; margin-right: 10px;">Add User</a>
    <a href="export_excel.php" class="export-btn">📥 Export</a>
  </div>

  <table>
    <thead>
      <tr>
        <th>S/N</th>
        <th>Full Name</th>
        <th>Email</th>
        <th>Phone</th>
        <th>Emp No</th>
        <th>Lecture Title</th>
        <th>PFQ Date</th>
        <th>Selected Date</th>
        <th>School/Dept</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $query = $mysqli->query("
        SELECT s.full_name, s.email, s.phone, s.staff_id,
               b.lecture_title, b.pfq_date, b.booking_date AS available_date, b.school
        FROM staff_users s
        LEFT JOIN bookings b ON s.staff_id = b.staff_id
        ORDER BY s.staff_id ASC
      ");
      $sn = 1;
      while ($user = $query->fetch_assoc()):
      ?>
        <tr>
          <td><?= $sn++ ?></td>
          <td><?= htmlspecialchars($user['full_name']) ?></td>
          <td><?= htmlspecialchars($user['email']) ?></td>
          <td><?= htmlspecialchars($user['phone']) ?></td>
          <td><?= htmlspecialchars($user['staff_id']) ?></td>
          <td><?= htmlspecialchars($user['lecture_title'] ?? '—') ?></td>
          <td><?= htmlspecialchars($user['pfq_date'] ?? '—') ?></td>
          <td><?= htmlspecialchars($user['available_date'] ?? '—') ?></td>
          <td><?= htmlspecialchars($user['school'] ?? '—') ?></td>
          <td>
            <a href="edit_user.php?staff_id=<?= $user['staff_id'] ?>" class="btn btn-edit">Edit</a>
            <a href="delete_user.php?staff_id=<?= $user['staff_id'] ?>" class="btn btn-delete" onclick="return confirm('Are you sure you want to delete this user?')">Del</a>
            <a href="reset_booking.php?staff_id=<?= $user['staff_id'] ?>" class="btn btn-reset" onclick="return confirm('Allow this user to resubmit the form?')">Reset</a>
          </td>
        </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
</div>

</body>
</html>
