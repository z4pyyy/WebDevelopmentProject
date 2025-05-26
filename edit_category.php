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
$category = null; // To store the category being edited

// Check if category ID is provided
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: add_category.php");
    exit;
}
$category_id = (int)$_GET['id'];

// Fetch the specific category
$stmt = mysqli_prepare($conn, "SELECT * FROM categories WHERE id = ?");
mysqli_stmt_bind_param($stmt, "i", $category_id);
mysqli_stmt_execute($stmt);
$category_result = mysqli_stmt_get_result($stmt);
$category = mysqli_fetch_assoc($category_result);
mysqli_stmt_close($stmt);

if (!$category) {
    header("Location: add_category.php");
    exit;
}

// Update Category Logic
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $new_category_name = trim($_POST['category_name']);
    if ($new_category_name !== "") {
        // 🛑 Duplicate check (case-insensitive, excluding the current category)
        $stmt = mysqli_prepare($conn, "SELECT COUNT(*) FROM categories WHERE LOWER(name) = LOWER(?) AND id != ?");
        mysqli_stmt_bind_param($stmt, "si", $new_category_name, $category_id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $count);
        mysqli_stmt_fetch($stmt);
        mysqli_stmt_close($stmt);

        if ($count > 0) {
            $error = "Category '$new_category_name' already exists!";
        } else {
            // Safe to update
            $stmt = mysqli_prepare($conn, "UPDATE categories SET name = ? WHERE id = ?");
            mysqli_stmt_bind_param($stmt, "si", $new_category_name, $category_id);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
            header("Location: add_category.php");
            exit;
        }
    } else {
        $error = "Category name cannot be empty!";
    }
}

// Fetch all categories
$categories = mysqli_query($conn, "SELECT * FROM categories ORDER BY id ASC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Category</title>
    <link rel="stylesheet" href="styles/style.css">
</head>
<body>
    <div class="admin-content">
        <div class="admin-navbar">
            <div><strong>✏️ Edit Category</strong></div>
        </div>
    </div>
    <div class="add-item-container">
        <h3>Existing Categories</h3>
        <ul class="add-prd-menu">
            <?php while ($row = mysqli_fetch_assoc($categories)): ?>
                <li><?= htmlspecialchars($row['name']) ?></li>
            <?php endwhile; ?>
        </ul>
        <?php if (!empty($error)): ?>
            <div class="error-msg"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        <form class="add-activity-form" method="POST" autocomplete="off">
            <label for="category_name">Category Name</label>
            <input type="text" name="category_name" id="category_name" value="<?= htmlspecialchars($category['name']) ?>" required>
            <button type="submit">Update Category</button>
        </form>
    </div>
</body>
</html>