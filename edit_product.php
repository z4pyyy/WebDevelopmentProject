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

// 🔍 Get existing product
$id = intval($_GET['id'] ?? 0);
$query = mysqli_query($conn, "SELECT * FROM products WHERE id = $id");
$product = mysqli_fetch_assoc($query);

if (!$product) {
    echo "<p>Product not found.</p>";
    exit;
}

// 📋 Fetch all categories for dropdown
$category_options = [];
$cat_result = mysqli_query($conn, "SELECT id, name FROM categories ORDER BY name ASC");
while ($row = mysqli_fetch_assoc($cat_result)) {
    $category_options[] = $row;
}


// 🔁 Handle update
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
  
  include 'navbar.php';
  include 'navbar_admin.php';
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

    <label for="category_id">Category</label>
    <select name="category_id" id="category_id" required>
    <option value="">-- Select Category --</option>
    <?php foreach ($category_options as $cat): ?>
        <option value="<?= $cat['id'] ?>" <?= ($product['category_id'] == $cat['id']) ? 'selected' : '' ?>>
        <?= htmlspecialchars($cat['name']) ?>
        </option>
    <?php endforeach; ?>
    </select>


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
