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

$error = ""; // For in-page error message

// Insert Role Logic
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $role_name = trim($_POST['role_name']);
    if ($role_name !== "") {
        // 🛑 Duplicate check (case-insensitive)
        $stmt = mysqli_prepare($conn, "SELECT COUNT(*) FROM roles WHERE LOWER(name) = LOWER(?)");
        mysqli_stmt_bind_param($stmt, "s", $role_name);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $count);
        mysqli_stmt_fetch($stmt);
        mysqli_stmt_close($stmt);

        if ($count > 0) {
            $error = "Role '$role_name' already exists!";
        } else {
            // Safe to insert
            $stmt = mysqli_prepare($conn, "INSERT INTO roles (name) VALUES (?)");
            mysqli_stmt_bind_param($stmt, "s", $role_name);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
            header("Location: add_role.php");
            exit;
        }
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
    <div class="add-item-container">
        <h2 class="admin-dashboard">Existing Roles</h2>
        <table class="category-table">
            <thead>
                <tr>
                    <th>Role Name</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($roles)): ?>
                    <tr>
                        <td><a href="edit_role.php?id=<?= $row['id'] ?>"><?= htmlspecialchars($row['name']) ?></a></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <?php if (!empty($error)): ?>
            <div class="error-msg"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        <form class="add-category-form" method="POST" autocomplete="off">
            <label for="role_name">New Role Name</label>
            <input type="text" name="role_name" id="role_name" required>
            <button type="submit">Add Role</button>
        </form>
    </div>
</div>
</body>
</html>