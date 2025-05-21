<?php
session_start();

$currentPage = basename($_SERVER['PHP_SELF']);
include 'connection.php';
include 'navbar.php';
include 'navbar_admin.php';

if (!isset($_SESSION['admin_id']) || !in_array($_SESSION['role_id'] ?? 0, [1, 2, 3])) {
    header("Location: login.php");
    exit;
}

// 📋 Fetch categories for dropdown
$category_options = [];
$cat_result = mysqli_query($conn, "SELECT id, name FROM categories ORDER BY name ASC");
while ($row = mysqli_fetch_assoc($cat_result)) {
    $category_options[] = $row;
}


// 🔁 Handle Insert
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name         = trim($_POST['name']);
    $description  = trim($_POST['description']);
    $price        = floatval($_POST['price']);
    $large_price  = floatval($_POST['large_price']);
    $category_id = intval($_POST['category_id']);

    // Lookup category name for SKU generation
    $cat_lookup = mysqli_query($conn, "SELECT name FROM categories WHERE id = $category_id");
    $cat_row = mysqli_fetch_assoc($cat_lookup);
    $category_name = $cat_row['name'] ?? 'UNKNOWN';

    $sku = strtoupper(str_replace(' ', '_', $category_name . '_' . $name));
    $availability = $_POST['availability'];


    // 📷 Handle image upload
    $image_path = '';
    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        $upload_dir = 'images/';
        if (!file_exists($upload_dir)) mkdir($upload_dir, 0777, true);

        $filename    = uniqid('prd_') . '_' . basename($_FILES['image']['name']);
        $target_path = $upload_dir . $filename;

        if (move_uploaded_file($_FILES['image']['tmp_name'], $target_path)) {
            $image_path = $target_path;
        }
    }

    // 📂 Insert into DB
    $stmt = mysqli_prepare($conn, "INSERT INTO products (name, description, price, large_price, category_id, availability, image_path, sku)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    mysqli_stmt_bind_param($stmt, "ssddisss", $name, $description, $price, $large_price, $category_id, $availability, $image_path, $sku);
    mysqli_stmt_execute($stmt);

    header("Location: view_product.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Add Product</title>
  <link rel="stylesheet" href="styles/style.css">
</head>
<body>
<div class="add-activity-container">
  <h2>➕ Add New Product</h2>

  <form class="add-activity-form" method="POST" enctype="multipart/form-data">
    <label for="image">Product Image</label>
    <input type="file" name="image" id="image" accept="image/*">

    <label for="name">Product Name</label>
    <input type="text" name="name" id="name" required>

    <label for="description">Description</label>
    <textarea name="description" id="description" rows="5"></textarea>

    <label for="price">Regular Price</label>
    <input type="number" step="0.01" name="price" id="price" required>

    <label for="large_price">Large Price</label>
    <input type="number" step="0.01" name="large_price" id="large_price">

    <label for="category_id">Category</label>
    <select name="category_id" id="category_id" required>
    <option value="">-- Select Category --</option>
    <?php foreach ($category_options as $cat): ?>
        <option value="<?= $cat['id'] ?>"><?= htmlspecialchars($cat['name']) ?></option>
    <?php endforeach; ?>
    </select>


    <label for="availability">Availability</label>
    <select name="availability" id="availability">
      <option value="Available">Available</option>
      <option value="Unavailable">Unavailable</option>
    </select>

    <button type="submit">Add Product</button>
  </form>
</div>
</body>
</html>
