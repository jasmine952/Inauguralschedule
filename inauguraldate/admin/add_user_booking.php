<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Add User Modal</title>
  <style>
    body {
      font-family: Arial, sans-serif;
    }

    /* The modal */
    .modal {
      display: none;
      position: fixed;
      z-index: 1000;
      left: 0;
      top: 0;
      width: 100%;
      height: 100%;
      background: rgba(0,0,0,0.5);
    }
    /* Modal content box */
    .modal-content {
      background: #fff;
      margin: 8% auto;
      padding: 20px;
      border-radius: 10px;
      width: 400px;
      box-shadow: 0 4px 8px rgba(0,0,0,0.3);
      position: relative;
      animation: fadeIn 0.3s ease-in-out;
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: scale(0.9); }
      to { opacity: 1; transform: scale(1); }
    }

    /* Close button */
    .close {
      position: absolute;
      right: 15px;
      top: 10px;
      font-size: 24px;
      cursor: pointer;
      color: #888;
    }
    .close:hover {
      color: red;
    }

    /* Buttons */
    .btn {
      padding: 10px 20px;
      background: #0073e6;
      color: #fff;
      border: none;
      border-radius: 5px;
      cursor: pointer;
    }
    .btn:hover {
      background: #005bb5;
    }

    /* Form styles */
    form input {
      width: 100%;
      padding: 10px;
      margin: 8px 0;
      border: 1px solid #ccc;
      border-radius: 5px;
    }
  </style>
</head>
<body>

  <!-- Buttons -->
  <div style="text-align:right;">
    <button id="openModal" class="btn" style="background-color:#0073e6; margin-right:10px;">Add User</button>
    <a href="export_excel.php" class="btn">📥 Export</a>
  </div>

  <!-- Modal -->
  <div id="userModal" class="modal">
    <div class="modal-content">
      <span class="close">&times;</span>
      <h2>Add User</h2>
      <form action="add_user_booking.php" method="POST">
        <input type="text" name="full_name" placeholder="Full Name" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="text" name="staff_id" placeholder="Staff ID" required>
        <button type="submit" class="btn">Save User</button>
      </form>
    </div>
  </div>
  <script>
    var modal = document.getElementById("userModal");
    var openBtn = document.getElementById("openModal");
    var closeBtn = document.querySelector(".close");

    openBtn.onclick = function() {
      modal.style.display = "block";
    }
    closeBtn.onclick = function() {
      modal.style.display = "none";
    }
    window.onclick = function(event) {
      if (event.target == modal) {
        modal.style.display = "none";
      }
    }
  </script>
</body>
</html>
