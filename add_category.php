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

// Insert Category Logic
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $category_name = trim($_POST['category_name']);
    if ($category_name !== "") {
        // 🛑 Duplicate check (case-insensitive)
        $stmt = mysqli_prepare($conn, "SELECT COUNT(*) FROM categories WHERE LOWER(name) = LOWER(?)");
        mysqli_stmt_bind_param($stmt, "s", $category_name);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $count);
        mysqli_stmt_fetch($stmt);
        mysqli_stmt_close($stmt);

        if ($count > 0) {
            $error = "Category '$category_name' already exists!";
        } else {
            // Safe to insert
            $stmt = mysqli_prepare($conn, "INSERT INTO categories (name) VALUES (?)");
            mysqli_stmt_bind_param($stmt, "s", $category_name);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
            header("Location: add_category.php");
            exit;
        }
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
<div>
    <div class="admin-content">
        <div class="admin-navbar">
            <div><strong>➕ Add New Category</strong></div>
        </div>
    <div class="add-item-container">
        <h2 class="admin-dashboard">Existing Categories</h2>
        <table class="category-table">
            <thead>
                <tr>
                    <th>Category Name</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($categories)): ?>
                    <tr>
                        <td><a href="edit_category.php?id=<?= $row['id'] ?>"><?= htmlspecialchars($row['name']) ?></a></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <?php if (!empty($error)): ?>
            <div class="error-msg"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        <form class="add-category-form" method="POST" autocomplete="off">
            <label for="category_name">New Category Name</label>
            <input type="text" name="category_name" id="category_name" required>
            <button type="submit">Add Category</button>
        </form>
    </div>
</div>
</body>
</html>