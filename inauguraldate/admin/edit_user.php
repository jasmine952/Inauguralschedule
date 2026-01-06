<?php
session_start();
require '../db.php';

if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: process_login.php");
    exit();
}

// Get user ID from URL
if (!isset($_GET['id'])) {
    echo "User ID not specified.";
    exit();
}

$user_id = intval($_GET['id']);
$error = "";
$success = "";

// Fetch user details
$stmt = $mysqli->prepare("SELECT * FROM staff_users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if (!$user) {
    echo "User not found.";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full_name = trim($_POST['full_name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $staff_id = trim($_POST['staff_id']);

    if (empty($full_name) || empty($email) || empty($phone) || empty($staff_id)) {
        $error = "All fields are required.";
    } else {
  
        $update = $mysqli->prepare("UPDATE staff_users SET full_name = ?, email = ?, phone = ?, staff_id = ? WHERE id = ?");
        $update->bind_param("ssssi", $full_name, $email, $phone, $staff_id, $user_id);
        if ($update->execute()) {
            $success = "User updated successfully.";
   
            $user['full_name'] = $full_name;
            $user['email'] = $email;
            $user['phone'] = $phone;
            $user['staff_id'] = $staff_id;
        } else {
            $error = "Failed to update user.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit User</title>
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background: #f7f9fb;
      padding: 40px;
    }
    .container {
      max-width: 500px;
      margin: auto;
      background: white;
      padding: 30px;
      border-radius: 8px;
      box-shadow: 0 0 10px rgba(0,0,0,0.05);
    }
    h2 {
      text-align: center;
    }
    label {
      display: block;
      margin-top: 15px;
    }
    input {
      width: 100%;
      padding: 10px;
      margin-top: 5px;
      border-radius: 6px;
      border: 1px solid #ccc;
    }
    .btn {
      margin-top: 20px;
      width: 100%;
      background: #0073e6;
      color: white;
      border: none;
      padding: 12px;
      border-radius: 6px;
      cursor: pointer;
      font-weight: bold;
    }
    .msg {
      text-align: center;
      margin-top: 15px;
    }
    .msg.success {
      color: green;
    }
    .msg.error {
      color: red;
    }
  </style>
</head>
<body>
  <div class="container">
    <h2>Edit Staff User</h2>
    <?php if ($error): ?><div class="msg error"><?= $error ?></div><?php endif; ?>
    <?php if ($success): ?><div class="msg success"><?= $success ?></div><?php endif; ?>
    
    <form method="POST">
      <label>Full Name:</label>
      <input type="text" name="full_name" value="<?= htmlspecialchars($user['full_name']) ?>" required>

      <label>Email:</label>
      <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>

      <label>Phone:</label>
      <input type="text" name="phone" value="<?= htmlspecialchars($user['phone']) ?>" required>

      <label>Staff ID:</label>
      <input type="text" name="staff_id" value="<?= htmlspecialchars($user['staff_id']) ?>" required>

      <button type="submit" class="btn">Update User</button>
    </form>
  </div>
</body>
</html>
