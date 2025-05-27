<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Debug: Log session variables
error_log("view_membership.php accessed. Session: " . print_r($_SESSION, true));

$currentPage = basename($_SERVER['PHP_SELF']);
include 'connection.php';
include 'auth.php';

// 🔒 Secure Access: Check page permissions
if (!isset($_SESSION['admin_id']) || !isset($_SESSION['role_id'])) {
    error_log("view_membership.php: Session check failed. admin_id: " . ($_SESSION['admin_id'] ?? 'not set') . ", role_id: " . ($_SESSION['role_id'] ?? 'not set'));
    header("Location: login.php");
    exit;
}

if (!checkPagePermission($conn, $currentPage, $_SESSION['role_id'])) {
    error_log("view_membership.php: Permission denied for role_id: " . $_SESSION['role_id'] . ", page: $currentPage");
    header("Location: no_access.php"); // Redirect to no_access.php
    exit;
}

include 'navbar.php';
include 'navbar_admin.php';

$error = ""; // For in-page error message
$role = null; // To store the role being edited

// Check if role ID is provided
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: add_role.php");
    exit;
}
$role_id = (int)$_GET['id'];

// Fetch the specific role
$stmt = mysqli_prepare($conn, "SELECT * FROM roles WHERE id = ?");
mysqli_stmt_bind_param($stmt, "i", $role_id);
mysqli_stmt_execute($stmt);
$role_result = mysqli_stmt_get_result($stmt);
$role = mysqli_fetch_assoc($role_result);
mysqli_stmt_close($stmt);

if (!$role) {
    header("Location: add_role.php");
    exit;
}

// Update Role Logic
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $new_role_name = trim($_POST['role_name']);
    if ($new_role_name !== "") {
        // 🛑 Duplicate check (case-insensitive, excluding the current role)
        $stmt = mysqli_prepare($conn, "SELECT COUNT(*) FROM roles WHERE LOWER(name) = LOWER(?) AND id != ?");
        mysqli_stmt_bind_param($stmt, "si", $new_role_name, $role_id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $count);
        mysqli_stmt_fetch($stmt);
        mysqli_stmt_close($stmt);

        if ($count > 0) {
            $error = "Role '$new_role_name' already exists!";
        } else {
            // Safe to update
            $stmt = mysqli_prepare($conn, "UPDATE roles SET name = ? WHERE id = ?");
            mysqli_stmt_bind_param($stmt, "si", $new_role_name, $role_id);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
            header("Location: add_role.php");
            exit;
        }
    } else {
        $error = "Role name cannot be empty!";
    }
}

// Fetch all roles
$roles = mysqli_query($conn, "SELECT * FROM roles ORDER BY id ASC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Role</title>
    <link rel="stylesheet" href="styles/style.css">
</head>
<body>
    <div class="admin-content">
        <div class="admin-navbar">
            <div><strong>✏️ Edit Role</strong></div>
        </div>
    </div>
    <div class="add-item-container">
        <h3>Existing Roles</h3>
        <ul class="add-prd-menu">
            <?php while ($row = mysqli_fetch_assoc($roles)): ?>
                <li><?= htmlspecialchars($row['name']) ?></li>
            <?php endwhile; ?>
        </ul>
        <?php if (!empty($error)): ?>
            <div class="error-msg"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        <form class="add-activity-form" method="POST" autocomplete="off">
            <label for="role_name">Role Name</label>
            <input type="text" name="role_name" id="role_name" value="<?= htmlspecialchars($role['name']) ?>" required>
            <button type="submit">Update Role</button>
        </form>
    </div>
</body>
</html>