<?php
session_start();
$currentPage = basename($_SERVER['PHP_SELF']);
include 'connection.php';
include 'navbar.php';
include 'navbar_admin.php';

// Security: Only allow admin (role_id 1)
if (!isset($_SESSION['admin_id']) || ($_SESSION['role_id'] ?? 0) != 1) {
    header("Location: login.php");
    exit;
}

// Insert Role Logic
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $role_name = trim($_POST['role_name']);
    if ($role_name !== "") {
        $stmt = mysqli_prepare($conn, "INSERT INTO roles (name) VALUES (?)");
        mysqli_stmt_bind_param($stmt, "s", $role_name);
        mysqli_stmt_execute($stmt);
        header("Location: add_role.php");
        exit;
    }
}

// Fetch all roles
$roles = mysqli_query($conn, "SELECT * FROM roles ORDER BY id ASC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Role</title>
    <link rel="stylesheet" href="styles/style.css">
</head>
<body>
    <div class="admin-content">
        <div class="admin-navbar">
            <div><strong>➕ Add New Role</strong></div>
        </div>
    </div>
<div class="add-item-container">
    <h3>Existing Roles</h3>
    <ul class="add-prd-menu">
        <?php while ($row = mysqli_fetch_assoc($roles)): ?>
            <li><?= htmlspecialchars($row['name']) ?></li>
        <?php endwhile; ?>
    </ul>
    <form class="add-activity-form" method="POST">
        <label for="role_name">Role Name</label>
        <input type="text" name="role_name" id="role_name" required>
        <button type="submit">Add Role</button>
    </form>
</div>
</body>
</html>
