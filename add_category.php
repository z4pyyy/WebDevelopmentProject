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

// Insert Category Logic
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $category_name = trim($_POST['category_name']);
    if ($category_name !== "") {
        $stmt = mysqli_prepare($conn, "INSERT INTO categories (name) VALUES (?)");
        mysqli_stmt_bind_param($stmt, "s", $category_name);
        mysqli_stmt_execute($stmt);
        header("Location: add_category.php");
        exit;
    }
}

// Fetch all categories
$categories = mysqli_query($conn, "SELECT * FROM categories ORDER BY id ASC");
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
        </div>
    </div>
<div class="add-item-container">
    <h3>Existing Categories</h3>
    <ul class="add-prd-menu">
        <?php while ($row = mysqli_fetch_assoc($categories)): ?>
            <li><?= htmlspecialchars($row['name']) ?></li>
        <?php endwhile; ?>
    </ul>
    <form class="add-activity-form" method="POST">
        <label for="category_name">Category Name</label>
        <input type="text" name="category_name" id="category_name" required>
        <button type="submit">Add Category</button>
    </form>
</div>
</body>
</html>
