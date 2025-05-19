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

// Get member & user info
$sql = "SELECT 
            m.id AS membership_id,
            m.first_name, m.last_name, m.email, m.phone, m.registered_at,
            m.wallet,
            u.username,
            u.role_id,
            r.name AS role_name
        FROM membership m
        JOIN user u ON u.membership_id = m.id
        JOIN roles r ON u.role_id = r.id
        ORDER BY m.registered_at DESC";
$result = mysqli_query($conn, $sql);

// Get role options
$role_options = [];
$role_query = mysqli_query($conn, "SELECT id, name FROM roles");
while ($r = mysqli_fetch_assoc($role_query)) {
    $role_options[] = $r;
}

// Handle selected row
$selected_id = $_POST['view_id'] ?? null;
$selected_member = null;

if ($selected_id) {
    foreach ($result as $row) {
        if ($row['membership_id'] == $selected_id) {
            $selected_member = $row;
            break;
        }
    }
    mysqli_data_seek($result, 0);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Member Wallet Overview</title>
    <link rel="stylesheet" href="styles/style.css">
</head>
<body>

<div class="admin-content">
    <div class="admin-navbar">
        <div><strong>Member Wallet Overview</strong></div>
        <div><a href="admin_panel.php" class="admin-logout-button">⬅ Back</a></div>
    </div>

    <table class="admin-table">
        <caption>Member Table</caption>
        <thead>
            <tr>
                <th>Username</th>
                <th>Member ID</th>
                <th>Wallet</th>
                <th>Role</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <?php $isSelected = ($selected_id == $row['membership_id']); ?>
            <tr>
                <td><?= htmlspecialchars($row['username']) ?></td>
                <td><?= 'BNG-' . str_pad($row['membership_id'], 5, '0', STR_PAD_LEFT) ?></td>
                <td>RM <?= number_format($row['wallet'], 2) ?></td>

                <!-- Role Dropdown Only -->
                <td>
                  <form method="POST" action="update_role.php" class="details-form">
                      <input type="hidden" name="user_id" value="<?= $row['membership_id'] ?>">
                      <select name="role_id" class="role-select">
                          <?php foreach ($role_options as $role): ?>
                              <option value="<?= $role['id'] ?>" <?= $role['id'] == $row['role_id'] ? 'selected' : '' ?>>
                                  <?= htmlspecialchars(ucfirst($role['name'])) ?>
                              </option>
                          <?php endforeach; ?>
                      </select>
                      <button type="submit" class="member-details-button">Update</button>
                  </form>
                </td>

                <!-- Action Buttons -->
                <td>
                  <div class="action-buttons">
                      <!-- View Details -->
                      <form method="POST" class="details-form">
                          <input type="hidden" name="view_id" value="<?= $row['membership_id'] ?>">
                          <button type="submit" class="member-details-button">View</button>
                      </form>

                      <!-- Edit Member (Link to edit page) -->
                      <form method="GET" action="edit_membership.php" class="details-form">
                          <input type="hidden" name="membership_id" value="<?= $row['membership_id'] ?>">
                          <button type="submit" class="member-details-button">Edit</button>
                      </form>
                  </div>
              </td>
            </tr>

            <?php if ($isSelected): ?>
            <tr class="member-detail-row">
                <td colspan="5">
                    <div class="member-details-inline">
                        <strong>First Name:</strong> <?= htmlspecialchars($row['first_name']) ?><br>
                        <strong>Last Name:</strong> <?= htmlspecialchars($row['last_name']) ?><br>
                        <strong>Email:</strong> <?= htmlspecialchars($row['email']) ?><br>
                        <strong>Phone:</strong> <?= htmlspecialchars($row['phone']) ?><br>
                        <strong>Registered At:</strong> <?= $row['registered_at'] ?><br>
                    </div>
                </td>
            </tr>
            <?php endif; ?>
        <?php endwhile; ?>
        </tbody>
    </table>
</div>

</body>
</html>
