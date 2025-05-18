<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['admin_id'])) {
  header("Location: login.php");
  exit;
}

include 'connection.php';
$sql = "SELECT * FROM membership ORDER BY registered_at DESC";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>View Membership | Admin</title>
  <link rel="stylesheet" href="styles/style.css">
  <style>
    .admin-table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
      background: white;
    }
    .admin-table th, .admin-table td {
      border: 1px solid #ccc;
      padding: 10px;
      text-align: left;
    }
    .admin-table th {
      background-color: #343a40;
      color: white;
    }
    .admin-table tbody tr:nth-child(even) {
      background-color: #f2f2f2;
    }
    .admin-table caption {
      font-size: 1.4rem;
      font-weight: bold;
      margin-bottom: 10px;
    }
  </style>
</head>
<body>
    <?php include 'navbar.php'; ?>
    <?php include 'navbar_admin.php'; ?>

  <div class="admin-content">
    <div class="admin-navbar">
      <div><strong>Membership Records</strong></div>
      <div><a href="admin_panel.php" class="admin-logout-button">⬅ Back to Dashboard</a></div>
    </div>

    <table class="admin-table">
      <caption>All Registered Members</caption>
      <thead>
        <tr>
          <th>ID</th>
          <th>First Name</th>
          <th>Last Name</th>
          <th>Email</th>
          <th>Phone</th>
          <th>Registered At</th>
        </tr>
      </thead>
      <tbody>
        <?php while($row = mysqli_fetch_assoc($result)): ?>
        <tr>
          <td><?= $row['id'] ?></td>
          <td><?= htmlspecialchars($row['first_name']) ?></td>
          <td><?= htmlspecialchars($row['last_name']) ?></td>
          <td><?= htmlspecialchars($row['email']) ?></td>
          <td><?= htmlspecialchars($row['phone']) ?></td>
          <td><?= $row['registered_at'] ?></td>
        </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>
</body>
</html>  
