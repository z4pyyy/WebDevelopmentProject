<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['admin_id'])) {
  header("Location: login.php");
  exit;
}

include 'connection.php';
include 'navbar.php';
include 'navbar_admin.php';

$sql = "SELECT 
          m.id AS membership_id,
          m.first_name, m.last_name, m.email, m.phone, m.registered_at,
          u.id AS user_id,
          u.role_id,
          r.name AS role_name
        FROM membership m
        JOIN user u ON u.membership_id = m.id
        JOIN roles r ON u.role_id = r.id
        ORDER BY m.registered_at DESC";$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>View Membership | Admin</title>
  <link rel="stylesheet" href="styles/style.css">
  <style>
    .admin-table {
      width: 95%;
      border-collapse: collapse;
      margin-top: 45px;
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
          <th>Role</th>
        </tr>
      </thead>
      <tbody>
        <?php while($row = mysqli_fetch_assoc($result)): ?>
        <tr>
          <td><?= $row['membership_id'] ?></td>
          <td><?= htmlspecialchars($row['first_name']) ?></td>
          <td><?= htmlspecialchars($row['last_name']) ?></td>
          <td><?= htmlspecialchars($row['email']) ?></td>
          <td><?= htmlspecialchars($row['phone']) ?></td>
          <td><?= $row['registered_at'] ?></td>
          <td>
            <form action="update_role.php" method="POST">
              <input type="hidden" name="user_id" value="<?= $row['user_id'] ?>">
              <select name="role_id" onchange="this.form.submit()">
                <?php
                  $roles = mysqli_query($conn, "SELECT id, name FROM roles");
                  while ($role = mysqli_fetch_assoc($roles)):
                ?>
                  <option value="<?= $role['id'] ?>" <?= $role['id'] == $row['role_id'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars(ucfirst($role['name'])) ?>
                  </option>
                <?php endwhile; ?>
              </select>
            </form>
          </td>
        </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>
</body>
</html>  
