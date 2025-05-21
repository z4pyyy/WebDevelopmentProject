<?php
session_start();

$currentPage = basename($_SERVER['PHP_SELF']);
include 'connection.php';
include 'navbar.php';
include 'navbar_admin.php';

// 🔒 Secure Access
if (!isset($_SESSION['admin_id']) || !in_array($_SESSION['role_id'] ?? 0, [1, 2, 3])) {
    header("Location: login.php");
    exit;
}

// 🗑 Delete Product
if (isset($_GET['delete_id'])) {
    $id = intval($_GET['delete_id']);
    mysqli_query($conn, "DELETE FROM products WHERE id = $id");
    header("Location: view_product.php");
    exit;
}

// 📦 Fetch all products grouped by category
$query = "
  SELECT products.*, categories.name AS category_name
  FROM products
  LEFT JOIN categories ON products.category_id = categories.id
  ORDER BY categories.name ASC, products.name ASC
";
$result = mysqli_query($conn, $query);

$products_by_category = [];

while ($row = mysqli_fetch_assoc($result)) {
    $category = $row['category_name'] ?? 'Uncategorized';
    $products_by_category[$category][] = $row;
}

// 🔄 Toggle Availability
if (isset($_GET['toggle_id'])) {
    $id = intval($_GET['toggle_id']);
    
    // Get current status
    $result = mysqli_query($conn, "SELECT availability FROM products WHERE id = $id");
    if ($row = mysqli_fetch_assoc($result)) {
        $new_status = ($row['availability'] === 'Available') ? 'Unavailable' : 'Available';
        mysqli_query($conn, "UPDATE products SET availability = '$new_status' WHERE id = $id");
    }
    
    header("Location: view_product.php");
    exit;
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin | Products</title>
  <link rel="stylesheet" href="styles/style.css">
</head>
<body>
  <div class="admin-content">
      <div class="admin-navbar">
        <div><strong>Products</strong></div>
        <a href="add_product.php" class="add-btn">➕ Add New Product</a>
      </div>
      
    <h2 class="admin-activities-title">🛍️ Product Menu</h2>

    <?php if (!empty($products_by_category)): ?>
      <?php foreach ($products_by_category as $category => $products): ?>
        <span class="line"></span>
        <h1 class="admin-header"><span class="hover-underline"><?= htmlspecialchars($category) ?></span></h1>
        <span class="line"></span>

        <?php $i = 1; foreach ($products as $product): ?>
          <div class="admin-activity-card">
            <div class="activity-flex">
              <a href="edit_product.php?id=<?= $product['id'] ?>" class="activity-edit-link">
                <div class="admin-activity-thumbnail">
                  <img src="<?= (!empty($product['image_path']) && file_exists($product['image_path']))
                      ? htmlspecialchars($product['image_path'])
                      : 'assets/no-image.png' ?>"
                       alt="Product Image" class="activity-image">
                </div>
              </a>

              <div class="activity-details">
                <a href="edit_product.php?id=<?= $product['id'] ?>" class="activity-edit-link">
                  <h3><?= $i . '. ' . htmlspecialchars($product['name']) ?></h3>
                </a>

                <div class="admin-activity-meta">
                  💵 Regular: RM <?= number_format($product['price'], 2) ?><br>
                  💵 Large: RM <?= number_format($product['large_price'], 2) ?><br>
                  🏷️ SKU: <?= htmlspecialchars($product['sku']) ?><br>
                  🔄 Availability: <?= htmlspecialchars($product['availability'] ?? 'Available') ?>
                </div>

                <?php if (!empty($product['description'])): ?>
                  <div class="admin-activity-description"><?= nl2br(htmlspecialchars($product['description'])) ?></div>
                <?php endif; ?>

            </div>
            <div class="admin-activity-actions">
              <a href="edit_product.php?id=<?= $product['id'] ?>" class="edit-btn">✏️ Edit</a>
              <a href="?delete_id=<?= $product['id'] ?>" class="delete-btn" onclick="return confirm('Delete this product?')">🗑 Delete</a>
            </div>
            <form method="GET" style="display:inline;">
                <input type="hidden" name="toggle_id" value="<?= $product['id'] ?>">
                <button type="submit"
                        class="status-btn <?= $product['availability'] === 'Available' ? 'available' : 'unavailable' ?>">
                    <?= $product['availability'] === 'Available' ? '🟢 Available' : '⚪ Unavailable' ?>
                </button>
            </form>
            </div>
          </div>
        <?php $i++; endforeach; ?>
      <?php endforeach; ?>
    <?php else: ?>
      <p>No products found.</p>
    <?php endif; ?>
  </div>
</body>
</html>
