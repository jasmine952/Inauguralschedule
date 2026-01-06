<?php
session_start();
require 'db.php';

if (!isset($_SESSION['staff_id'])) {
    header("Location: login.html");
    exit();
}

$staff_id = $_SESSION['staff_id'];
$message = "";

$staff_query = $mysqli->prepare("SELECT full_name FROM staff_users WHERE staff_id = ?");
$staff_query->bind_param("s", $staff_id);
$staff_query->execute();
$staff_result = $staff_query->get_result()->fetch_assoc();
$full_name = $staff_result['full_name'] ?? $staff_id;

// check existing booking
$booking_query = $mysqli->prepare("SELECT * FROM bookings WHERE staff_id = ?");
$booking_query->bind_param("s", $staff_id);
$booking_query->execute();
$booking_result = $booking_query->get_result();
$has_booking = $booking_result->num_rows > 0;
$booking = $booking_result->fetch_assoc();

// Get all booked dates
$booked_query = $mysqli->query("SELECT booking_date FROM bookings");
$booked_dates = [];
while ($row = $booked_query->fetch_assoc()) {
    $booked_dates[] = $row['booking_date'];
}

// Define all possible dates
$all_dates = [
    "2027-01-26",
    "2027-02-23",
    "2027-03-30",
    "2027-04-27",
    "2027-05-25",
    "2027-07-27",
    "2027-08-31",
    "2027-09-28",
    "2027-10-26",
    "2027-11-30",
    "2028-01-25",
    "2028-02-29",
    "2028-03-28",
    "2028-04-25",
    "2028-05-30",
    "2028-06-27",
    "2028-07-25",
    "2028-08-29",
    "2028-09-26",
    "2028-10-31",
    "2028-11-28",
    "2029-01-30",
    "2029-02-27",
    "2029-03-27",
    "2029-04-24",
    "2029-05-29",
    "2029-06-26",
    "2029-07-31",
    "2029-08-28",
    "2029-09-25",
    "2029-10-30",
    "2029-11-27",
    "2030-01-08",
    "2030-01-29",
    "2030-02-12",
    "2030-02-26",
    "2030-03-12",
    "2030-03-26",
    "2030-04-09",
    "2030-04-30",
    "2030-05-14",
    "2030-05-28",
    "2030-06-11",
    "2030-06-25",
    "2030-07-09",
    "2030-07-30",
    "2030-08-13",
    "2030-08-27",
    "2030-09-10",
    "2030-09-24",
    "2030-10-08",
    "2030-10-29",
    "2030-11-12",
    "2030-11-26",
    "2030-12-10"
];

// Remove booked ones
$available_dates = array_diff($all_dates, $booked_dates);

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !$has_booking) {
    $lecture_title = trim($_POST['lecture_title']);
    $pfq_date = $_POST['pfq_date'];
    $school = trim($_POST['school']);
    $booking_date = $_POST['booking_date'];

    // Double check booking date not taken (in case of race condition)
    if (in_array($booking_date, $booked_dates)) {
        $message = "Sorry, that date is already taken. Please choose another.";
    } else {
        $insert = $mysqli->prepare("INSERT INTO bookings (staff_id, lecture_title, pfq_date, school, booking_date, created_at) VALUES (?, ?, ?, ?, ?, NOW())");
        $insert->bind_param("sssss", $staff_id, $lecture_title, $pfq_date, $school, $booking_date);

        if ($insert->execute()) {
            header("Location: dashboard.php");
            exit();
        } else {
            $message = "❌ Failed to save booking. Please try again.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Staff Dashboard</title>
  <link rel="stylesheet" href="assets/style.css">
  <style>
    body {
      margin: 0;
      background: #f4f7fa;
      font-family: 'Segoe UI', sans-serif;
    }

    .header {
      background: #0073e6;
      color: white;
      padding: 20px;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .header h2 {
      margin: 0;
    }

    .btn {
      background: white;
      color: #0073e6;
      padding: 10px 20px;
      border-radius: 6px;
      text-decoration: none;
      font-weight: bold;
    }

    .content {
      padding: 30px;
    }

    .card {
      background: white;
      padding: 30px 20px;
      border-radius: 10px;
      box-shadow: 0 0 15px rgba(0,0,0,0.05);
      max-width: 600px;
      margin: auto;
    }

    .card h3 {
      text-align: center;
      margin-bottom: 15px;
    }

    .message {
      color: red;
      font-weight: bold;
      margin-bottom: 20px;
      text-align: center;
    }

    form {
      max-width: 500px;
      margin: 0 auto;
    }

    label {
      display: block;
      margin-top: 15px;
      font-weight: 500;
    }

    input, select {
      width: 100%;
      padding: 10px;
      margin-top: 5px;
      border-radius: 6px;
      border: 1px solid #ccc;
      box-sizing: border-box;
    }
    .notice {
    text-align: center;
    background: #fff3cd;
    color: #856404;
    padding: 10px;
    border-radius: 6px;
    margin-bottom: 15px;
    font-weight: bold;
    }


    .form-btn {
      background: #0073e6;
      color: white;
      padding: 12px;
      border: none;
      border-radius: 6px;
      cursor: pointer;
      font-weight: bold;
      margin-top: 20px;
      width: 100%;
    }
     .logo { width: 100px; margin-bottom: 20px; margin: 0 auto 15px auto; display: block;}

    .form-btn:hover {
      background: #005bb5;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
    }

    th, td {
      padding: 10px;
      border: 1px solid #eee;
      text-align: left;
    }

    th {
      background-color: #f1f5f9;
    }

    @media (max-width: 768px) {
      .card {
        padding: 20px 10px;
      }

      table, thead, tbody, tr, td, th {
        display: block;
      }

      td:before {
        content: attr(data-label);
        font-weight: bold;
        display: block;
        margin-bottom: 5px;
      }

      td {
        margin-bottom: 100px;
        border: none;
      }
    }
          @media print {
        body * {
          visibility: hidden;
        }
        .card, .card * {
          visibility: visible;
        }
        .card {
          position: absolute;
          left: auto;
          top: auto;
          width: auto;
        }
        .form-btn, .btn, .header {
          display: none !important;
        }
      }

  </style>
</head>
<body>

<div class="header">
  <h2>Welcome, <?= htmlspecialchars($full_name) ?></h2>
  <a href="logout.php" class="btn">Logout</a>
</div>

<div class="content">
  <div class="card">
    <img src="assets/logo.png" alt="University Logo" class="logo" >
    <h3>Your Booking Status</h3>
    <!-- <marquee behavior="alternate" direction="right" text-color="red">Please carefully complete the form</marquee> -->
    <?php if ($has_booking): ?>
      <p style="text-align: center;">✅ You have already submitted your booking.</p>
      <table>
        <tr>
          <th>Lecture Title</th>
          <th>PFQ Date</th>
          <th>School/Dept</th>
          <th>Selected Date</th>
        </tr>
        <tr>
          <td><?= htmlspecialchars($booking['lecture_title']) ?></td>
          <td><?= htmlspecialchars($booking['pfq_date']) ?></td>
          <td><?= htmlspecialchars($booking['school']) ?></td>
          <td><?= htmlspecialchars($booking['booking_date']) ?></td>
        </tr>
      </table>
      <p style="color: gray; text-align: center;">⛔ Contact administrator to modify your booking. 08063712239</p>
      <div style="text-align: center; margin-top: 20px;">
        <button onclick="window.print()" class="form-btn" style="width: auto;">🖨️ Print Booking</button>
      </div>

    <?php else: ?>
    <div class="notice">⚠️ Please carefully complete the form</div>
      <?php if ($message): ?>
        <div class="message"><?= $message ?></div>
      <?php endif; ?>

      <form method="POST">
        <label>Lecture Title:</label>
        <input type="text" name="lecture_title" required>

        <label>Date of PFQ:</label>
        <input type="date" name="pfq_date" required>

        <label>School/Department:</label>
        <input type="text" name="school" required>

        <label>Select Booking Date:</label>
        <select name="booking_date" required>
          <option value="">-- Select a Date --</option>
          <?php foreach ($available_dates as $date): ?>
            <option value="<?= $date ?>"><?= date("l, F j, Y", strtotime($date)) ?></option>
          <?php endforeach; ?>
        </select>

        <button type="submit" class="form-btn">Submit Booking</button>
      </form>
    <?php endif; ?>
  </div>
</div>

</body>
</html>
