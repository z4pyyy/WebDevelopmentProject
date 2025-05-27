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

$message = ""; // For in-page feedback message

// Define all admin pages from navbar_admin.php
$all_pages = [
    'admin_dashboard.php',
    'view_enquiry.php',
    'view_job.php',
    'view_membership.php',
    'add_role.php',
    'edit_role.php',
    'add_member.php',
    'edit_member.php',
    'view_activity.php',
    'add_activity.php',
    'edit_activity.php',
    'view_newsletter.php',
    'view_subscriber.php',
    'view_product.php',
    'add_product.php',
    'edit_product.php',
    'add_category.php',
    'edit_category.php',
    'view_permissions.php'
];


// Fetch all roles
$roles = [];
$role_result = mysqli_query($conn, "SELECT id, name FROM roles ORDER BY id ASC");
if (!$role_result) {
    die("Error fetching roles: " . mysqli_error($conn));
}
while ($row = mysqli_fetch_assoc($role_result)) {
    $roles[$row['id']] = $row['name'];
}

// 1️⃣2️⃣ PAGE PERMISSIONS TABLE
$sql = "CREATE TABLE IF NOT EXISTS page_permissions (
  id INT AUTO_INCREMENT PRIMARY KEY,
  page VARCHAR(100) NOT NULL,
  role_id TINYINT NOT NULL,
  can_view TINYINT(1) NOT NULL DEFAULT 1,
  UNIQUE KEY unique_page_role (page, role_id),
  FOREIGN KEY (role_id) REFERENCES roles(id) ON DELETE CASCADE
)";
echo mysqli_query($conn, $sql) ? "✅ Table 'page_permissions' ready.<br>" : "❌ " . mysqli_error($conn);

// Seed page permissions to ensure all pages and roles are represented
foreach ($all_pages as $page) {
    foreach ($roles as $role_id => $name) {
        $check = mysqli_query($conn, "SELECT id FROM page_permissions WHERE page='$page' AND role_id=$role_id");
        if (!$check) {
            die("Error checking permission: " . mysqli_error($conn));
        }
        if (mysqli_num_rows($check) === 0) {
            $can_view = 0; // Default to deny unless explicitly allowed
            $insert = mysqli_query($conn, "INSERT INTO page_permissions (page, role_id, can_view) VALUES ('$page', $role_id, $can_view)");
            if (!$insert) {
                die("Error inserting permission: " . mysqli_error($conn));
            }
        }
    }
}
echo "✅ Page permissions seeded for all pages and roles.<br>";

// Handle permission update (add or remove)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['toggle_permission'])) {
    $page = trim($_POST['page'] ?? '');
    $role_id = intval($_POST['role_id'] ?? 0);
    $can_view = intval($_POST['can_view'] ?? 0);

    if ($page && $role_id > 0) {
        $check = mysqli_query($conn, "SELECT id, can_view FROM page_permissions WHERE page='$page' AND role_id=$role_id");
        if (!$check) {
            $message = "❌ Error checking permission: " . mysqli_error($conn);
        } elseif (mysqli_num_rows($check) > 0) {
            $existing = mysqli_fetch_assoc($check);
            if ($existing['can_view'] != $can_view) {
                $update = mysqli_query($conn, "UPDATE page_permissions SET can_view = $can_view WHERE page='$page' AND role_id=$role_id");
                if ($update) {
                    $message = "✅ Permission updated successfully!";
                } else {
                    $message = "❌ Error updating permission: " . mysqli_error($conn);
                }
            } else {
                $message = "❌ No change needed: Permission state is already set.";
            }
        } else {
            $insert = mysqli_query($conn, "INSERT INTO page_permissions (page, role_id, can_view) VALUES ('$page', $role_id, $can_view)");
            if ($insert) {
                $message = "✅ Permission added successfully!";
            } else {
                $message = "❌ Error adding permission: " . mysqli_error($conn);
            }
        }
    } else {
        $message = "❌ Invalid page or role selected.";
    }
}

// Fetch all page permissions (matrix)
$page_perms = [];
$result = mysqli_query($conn, "SELECT page, role_id, can_view FROM page_permissions ORDER BY page ASC, role_id ASC");
if (!$result) {
    die("Error fetching permissions: " . mysqli_error($conn));
}
while ($row = mysqli_fetch_assoc($result)) {
    $page = $row['page'];
    $role_id = $row['role_id'];
    $can_view = $row['can_view'];
    $page_perms[$page][$role_id] = $can_view;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Page Permissions | Brew & Go Admin</title>
    <link rel="stylesheet" href="styles/style.css">
</head>
<div class="admin-content">
    <div class="admin-navbar">
        <div><strong>Page Permissions Overview</strong></div>
        <a href="view_newsletter.php" class="backto-view">← Back to Newsletter Panel</a>
    </div>
    
    <div class="permission-wrapper">
    <?php if ($message): ?>
        <div class="message <?= strpos($message, '✅') === 0 ? 'success' : 'error' ?>">
            <?= htmlspecialchars($message) ?>
        </div>
    <?php endif; ?>

    <table class="perm-table">
        <thead>
            <tr>
                <th>Page</th>
                <?php foreach ($roles as $id => $name): ?>
                    <th><?= htmlspecialchars(ucfirst($name)) ?></th>
                <?php endforeach; ?>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($all_pages as $page): ?>
                <tr>
                    <td class="page-name"><?= htmlspecialchars($page) ?></td>
                    <?php foreach ($roles as $role_id => $name): ?>
                        <td>
                            <form method="post" action="">
                                <input type="hidden" name="page" value="<?= htmlspecialchars($page) ?>">
                                <input type="hidden" name="role_id" value="<?= $role_id ?>">
                                <?php $current_state = isset($page_perms[$page][$role_id]) && $page_perms[$page][$role_id] ? 1 : 0; ?>
                                <input type="hidden" name="can_view" value="<?= $current_state ? 0 : 1 ?>">
                                <button type="submit" name="toggle_permission" class="<?= $current_state ? 'allow' : 'deny' ?>">
                                    <?= $current_state ? '✔ Allow' : '✖ Deny' ?>
                                </button>
                            </form>
                        </td>
                    <?php endforeach; ?>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
</div>
</body>
</html>