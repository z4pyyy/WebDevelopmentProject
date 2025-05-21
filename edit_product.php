<?php
session_start();
include 'connection.php';
include 'navbar.php';
include 'navbar_admin.php';

if (!isset($_SESSION['admin_id']) || !in_array($_SESSION['role_id'] ?? 0, [1, 2, 3])) {
    header("Location: login.php");
    exit;
}

// 🔍 Get existing product
$id = intval($_GET['id'] ?? 0);
$query = mysqli_query($conn, "SELECT * FROM products WHERE id = $id");
$product = mysqli_fetch_assoc($query);

if (!$product) {
    echo "<p>Product not found.</p>";
    exit;
}

// 🔁 Handle update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name         = trim($_POST['name']);
    $description  = trim($_POST['description']);
    $price        = floatval($_POST['price']);
    $large_price  = floatval($_POST['large_price']);
    $category     = trim($_POST['category']);
    $availability = $_POST['availability'];

    // 📷 Handle image upload
    $image_path = $product['image_path']; // keep existing
    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        $upload_dir = 'images/';
        if (!file_exists($upload_dir)) mkdir($upload_dir, 0777, true);

        $filename    = uniqid('prd_') . '_' . basename($_FILES['image']['name']);
        $target_path = $upload_dir . $filename;

        if (move_uploaded_file($_FILES['image']['tmp_name'], $target_path)) {
            $image_path = $target_path;
        }
    }

    // 💾 Update DB
    $stmt = mysqli_prepare($conn, "UPDATE products SET name=?, description=?, price=?, large_price=?, category=?, availability=?, image_path=? WHERE id=?");
    mysqli_stmt_bind_param($stmt, "ssddsssi", $name, $description, $price, $large_price, $category, $availability, $image_path, $id);
    mysqli_stmt_execute($stmt);

    header("Location: view_product.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Edit Product</title>
  <link rel="stylesheet" href="styles/style.css">
</head>
<body>
<div class="add-activity-container">
  <h2>✏️ Edit Product</h2>

  <?php if (!empty($product['image_path'])): ?>
    <div class="admin-activity-thumbnail" style="text-align:center;margin-bottom:15px;">
      <label for="image" style="cursor:pointer;" title="Click to change image">
        <img src="<?= htmlspecialchars($product['image_path']) ?>" alt="Current Image"
             style="max-width:250px;max-height:200px;border-radius:10px; transition: 0.3s ease;"
             onmouseover="this.style.opacity='0.8'" onmouseout="this.style.opacity='1'">
      </label>
    </div>
  <?php endif; ?>
  <form class="add-activity-form" method="POST" enctype="multipart/form-data">
    <input type="file" name="image" id="image" accept="image/*" style="display:none;">

    <label for="name">Product Name</label>
    <input type="text" name="name" id="name" value="<?= htmlspecialchars($product['name']) ?>" required>

    <label for="description">Description</label>
    <textarea name="description" id="description" rows="5"><?= htmlspecialchars($product['description']) ?></textarea>

    <label for="price">Regular Price</label>
    <input type="number" step="0.01" name="price" id="price" value="<?= $product['price'] ?>" required>

    <label for="large_price">Large Price</label>
    <input type="number" step="0.01" name="large_price" id="large_price" value="<?= $product['large_price'] ?>">

    <label for="category">Category</label>
    <input type="text" name="category" id="category" value="<?= htmlspecialchars($product['category']) ?>" required>

    <label for="availability">Availability</label>
    <select name="availability" id="availability">
      <option value="Available" <?= $product['availability'] === 'Available' ? 'selected' : '' ?>>Available</option>
      <option value="Unavailable" <?= $product['availability'] === 'Unavailable' ? 'selected' : '' ?>>Unavailable</option>
    </select>

    <button type="submit">Update Product</button>
  </form>
</div>
</body>
</html>
