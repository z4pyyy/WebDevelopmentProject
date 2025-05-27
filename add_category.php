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

include 'connection.php';

// Initialize error message
$error = "";

// Handle Category Deletion
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_category'])) {
    $category_id = intval($_POST['category_id'] ?? 0);

    if ($category_id > 0) {
        // Check if the category is in use by any products
        $stmt = mysqli_prepare($conn, "SELECT COUNT(*) FROM products WHERE category_id = ?");
        mysqli_stmt_bind_param($stmt, "i", $category_id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $product_count);
        mysqli_stmt_fetch($stmt);
        mysqli_stmt_close($stmt);

        if ($product_count > 0) {
            $error = "Cannot delete category ID $category_id: It is currently assigned to $product_count product(s).";
        } else {
            // Delete the category
            $stmt = mysqli_prepare($conn, "DELETE FROM categories WHERE id = ?");
            mysqli_stmt_bind_param($stmt, "i", $category_id);
            if (mysqli_stmt_execute($stmt)) {
                // Optionally reset AUTO_INCREMENT to the next expected ID
                $row_count_query = "SELECT COUNT(*) as total FROM categories";
                $row_count_result = mysqli_query($conn, $row_count_query);
                $row_count = mysqli_fetch_assoc($row_count_result)['total'];
                $new_auto_increment = $row_count + 1;

                // Reset AUTO_INCREMENT (uncomment if you want to enforce consecutive IDs)
                /*
                $reset_query = "ALTER TABLE categories AUTO_INCREMENT = $new_auto_increment";
                if (!mysqli_query($conn, $reset_query)) {
                    $error = "Failed to reset AUTO_INCREMENT: " . mysqli_error($conn);
                }
                */

                header("Location: add_category.php");
                exit;
            } else {
                $error = "Failed to delete category: " . mysqli_error($conn);
            }
            mysqli_stmt_close($stmt);
        }
    } else {
        $error = "Invalid category ID for deletion.";
    }
}

// Insert Category Logic
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_category'])) {
    $category_name = trim($_POST['category_name']);
    if ($category_name !== "") {
        // Duplicate check (case-insensitive)
        $stmt = mysqli_prepare($conn, "SELECT COUNT(*) FROM categories WHERE LOWER(name) = LOWER(?)");
        mysqli_stmt_bind_param($stmt, "s", $category_name);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $count);
        mysqli_stmt_fetch($stmt);
        mysqli_stmt_close($stmt);

        if ($count > 0) {
            $error = "Category '$category_name' already exists!";
        } else {
            // Insert the new category
            $stmt = mysqli_prepare($conn, "INSERT INTO categories (name) VALUES (?)");
            mysqli_stmt_bind_param($stmt, "s", $category_name);
            if (mysqli_stmt_execute($stmt)) {
                $new_category_id = mysqli_insert_id($conn);
                if ($new_category_id == 0) {
                    $error = "Failed to generate a proper ID for the new category. Check the AUTO_INCREMENT setting.";
                } else {
                    header("Location: add_category.php");
                    exit;
                }
            } else {
                $error = "Failed to insert category: " . mysqli_error($conn);
            }
            mysqli_stmt_close($stmt);
        }
    } else {
        $error = "Category name cannot be empty!";
    }
}

// Fetch all categories
$categories = mysqli_query($conn, "SELECT * FROM categories ORDER BY id ASC");

// Fetch the current AUTO_INCREMENT value for display (optional)
$auto_increment_query = "SELECT AUTO_INCREMENT FROM information_schema.TABLES WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'categories'";
$auto_increment_result = mysqli_query($conn, $auto_increment_query);
$current_auto_increment = mysqli_fetch_assoc($auto_increment_result)['AUTO_INCREMENT'] ?? 1;

// Include navigation after all header logic
$currentPage = basename($_SERVER['PHP_SELF']);
include 'navbar.php';
include 'navbar_admin.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Category</title>
    <link rel="stylesheet" href="styles/style.css">
</head>
<body>
    <div class="admin-content">
        <div class="admin-navbar">
            <div><strong>➕ Add New Category</strong></div>
            <a href="view_product.php" class="backto-view">← Back to Products</a>
        </div>
        <div class="add-item-container">
            <h2 class="admin-dashboard">Existing Categories (Next ID: <?= $current_auto_increment ?>)</h2>
            <table class="category-table">
                <thead>
                    <tr>
                        <th>Category ID</th>
                        <th>Category Name</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($categories)): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['id']) ?></td>
                            <td><a href="edit_category.php?id=<?= $row['id'] ?>"><?= htmlspecialchars($row['name']) ?></a></td>
                            <td>
                                <form method="POST" action="">
                                    <input type="hidden" name="category_id" value="<?= htmlspecialchars($row['id']) ?>">
                                    <button type="submit" name="delete_category" class="delete-btn">Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
            <?php if (!empty($error)): ?>
                <div class="error-msg"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>
            <form class="add-category-form" method="POST" action="" autocomplete="off">
                <input type="hidden" name="add_category" value="1">
                <label for="category_name">New Category Name</label>
                <input type="text" name="category_name" id="category_name" required>
                <button type="submit">Add Category</button>
            </form>
        </div>
    </div>
</body>
</html>