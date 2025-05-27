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

$error = ""; // For in-page error message

// Fetch the current number of roles before inserting
$row_count_query = "SELECT COUNT(*) as total FROM roles";
$row_count_result = mysqli_query($conn, $row_count_query);
$row_count = mysqli_fetch_assoc($row_count_result)['total'];
$expected_id = $row_count + 1; // Expected ID for the new role

// Handle Role Deletion
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_role'])) {
    $role_id = intval($_POST['role_id'] ?? 0);

    if ($role_id > 0) {
        // Check if the role is in use by any users
        $stmt = mysqli_prepare($conn, "SELECT COUNT(*) FROM user WHERE role_id = ?");
        mysqli_stmt_bind_param($stmt, "i", $role_id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $user_count);
        mysqli_stmt_fetch($stmt);
        mysqli_stmt_close($stmt);

        if ($user_count > 0) {
            $error = "Cannot delete role ID $role_id: It is currently assigned to $user_count user(s).";
        } else {
            // Check if the role has any page permissions
            $stmt = mysqli_prepare($conn, "SELECT COUNT(*) FROM page_permissions WHERE role_id = ?");
            mysqli_stmt_bind_param($stmt, "i", $role_id);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_bind_result($stmt, $perm_count);
            mysqli_stmt_fetch($stmt);
            mysqli_stmt_close($stmt);

            if ($perm_count > 0) {
                $error = "Cannot delete role ID $role_id: It has $perm_count page permissions associated with it.";
            } else {
                // Safe to delete
                $stmt = mysqli_prepare($conn, "DELETE FROM roles WHERE id = ?");
                mysqli_stmt_bind_param($stmt, "i", $role_id);
                if (mysqli_stmt_execute($stmt)) {
                    header("Location: add_role.php");
                    exit;
                } else {
                    $error = "Failed to delete role: " . mysqli_error($conn);
                }
                mysqli_stmt_close($stmt);
            }
        }
    } else {
        $error = "Invalid role ID for deletion.";
    }
}

// Insert Role Logic
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_role'])) {
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
            if (mysqli_stmt_execute($stmt)) {
                $new_role_id = mysqli_insert_id($conn); // Get the ID of the newly inserted role
                if ($new_role_id == 0) {
                    $error = "Failed to generate a proper ID for the new role. Check the AUTO_INCREMENT setting on the roles table.";
                } elseif ($new_role_id != $expected_id) {
                    $error = "Warning: New role ID ($new_role_id) does not match expected ID ($expected_id). Check the AUTO_INCREMENT setting.";
                } else {
                    exit;
                }
            } else {
                $error = "Failed to insert role: " . mysqli_error($conn);
            }
            mysqli_stmt_close($stmt);
        }
    } else {
        $error = "Role name cannot be empty!";
    }
}

include 'navbar.php';
include 'navbar_admin.php';

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
            <a href="view_membership.php" class="backto-view">← Back to Member List</a>
        </div>
        <div class="add-item-container">
            <h2 class="admin-dashboard">Existing Roles</h2>
            <table class="category-table">
                <thead>
                    <tr>
                        <th>Role ID</th>
                        <th>Role Name</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($roles)): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['id']) ?></td>
                            <td><a href="edit_role.php?id=<?= $row['id'] ?>"><?= htmlspecialchars($row['name']) ?></a></td>
                            <td>
                                <form method="POST" action="">
                                    <input type="hidden" name="role_id" value="<?= htmlspecialchars($row['id']) ?>">
                                    <button type="submit" name="delete_role" class="delete-btn">Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
            <form class="add-category-form" method="POST" action="" autocomplete="off">
                <input type="hidden" name="add_role" value="1">
                <label for="role_name">New Role Name</label>
                <input type="text" name="role_name" id="role_name" required>
                <button type="submit">Add Role</button>
            </form>
        </div>
    </div>
</body>
</html>