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

// 🔍 Handle Search Filters
$filter_by = $_GET['filter_by'] ?? '';
$search_term = trim($_GET['search'] ?? '');
$escaped_search = mysqli_real_escape_string($conn, $search_term);

// 📦 Fetch all products grouped by category
$query = "
  SELECT products.*, categories.name AS category_name
  FROM products
  LEFT JOIN categories ON products.category_id = categories.id
";

$conditions = [];
if (!empty($filter_by) && !empty($search_term)) {
    if ($filter_by === 'name') {
        $conditions[] = "products.name LIKE '%$escaped_search%'";
    } elseif ($filter_by === 'sku') {
        $conditions[] = "products.sku LIKE '%$escaped_search%'";
    } elseif ($filter_by === 'availability') {
        $conditions[] = "products.availability = '$escaped_search'";
    }
}

if (!empty($conditions)) {
    $query .= " WHERE " . implode(" AND ", $conditions);
}

$query .= " ORDER BY categories.name ASC, products.name ASC";
$result = mysqli_query($conn, $query);

$products_by_category = [];

while ($row = mysqli_fetch_assoc($result)) {
    $category = $row['category_name'] ?? 'Uncategorized';
    $products_by_category[$category][] = $row;
}

// 🔄 Toggle Availability
if (isset($_GET['toggle_id'])) {
    $id = intval($_GET['toggle_id']);
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
  <div class="prd-toggle-wrapper">
    <input type="checkbox" id="prd-menu-toggle" class="prd-menu-toggle">
    <label for="prd-menu-toggle" class="prd-menu-btn">☰ Select Category</label>
    <div class="admin-prd-menu">
      <ul>
        <li><a href="#Artisan_Brew">Artisan Brew</a></li>
        <li><a href="#Basic_Brew">Basic Brew</a></li>
        <li><a href="#Hot_Beverages">Hot Beverages</a></li>
        <li><a href="#Non-Coffee">Non-Coffee</a></li>
      </ul>
    </div>
  </div>
  <div class="admin-content">
    <div class="admin-navbar">
      <div><strong>Products</strong></div>
      <a href="add_product.php" class="add-btn">➕ Add New Product</a>
    </div>

    <form method="GET" style="margin: 15px 0;">
      <label for="filter_by"><strong>Search by:</strong></label>
      <select name="filter_by" id="filter_by" class="role-filter" onchange="this.form.submit()">
        <option value="">-- Select Field --</option>
        <option value="name" <?= $filter_by === 'name' ? 'selected' : '' ?>>Name</option>
        <option value="sku" <?= $filter_by === 'sku' ? 'selected' : '' ?>>SKU</option>
        <option value="availability" <?= $filter_by === 'availability' ? 'selected' : '' ?>>Availability</option>
      </select>

      <?php if ($filter_by === 'availability'): ?>
        <select name="search" class="role-filter">
          <option value="">-- Choose Availability --</option>
          <option value="Available" <?= $search_term === 'Available' ? 'selected' : '' ?>>Available</option>
          <option value="Unavailable" <?= $search_term === 'Unavailable' ? 'selected' : '' ?>>Unavailable</option>
        </select>
      <?php elseif ($filter_by): ?>
        <input type="text" name="search" class="role-filter" placeholder="Enter keyword..." value="<?= htmlspecialchars($search_term) ?>">
      <?php endif; ?>

      <button type="submit" class="search-button">🔍 Search</button>
    </form>

    <?php if (!empty($products_by_category)): ?>
      <?php foreach ($products_by_category as $category => $products): ?>
        <?php $category_id = str_replace(' ', '_', $category); ?>
        <h1 id="<?= $category_id ?>" class="admin-header">
          <span class="hover-underline"><?= htmlspecialchars($category) ?></span>
        </h1>
        <span class="line"></span>

        <?php $i = 1; foreach ($products as $product): ?>
          <div class="admin-activity-card">
            <div class="activity-flex">
              <a href="edit_product.php?id=<?= $product['id'] ?>" class="activity-edit-link">
                <div class="admin-activity-thumbnail">
                  <img src="<?= (!empty($product['image_path']) && file_exists($product['image_path'])) ? htmlspecialchars($product['image_path']) : 'assets/no-image.png' ?>" alt="Product Image" class="activity-image">
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
                <form method="GET" style="display:inline;">
                  <input type="hidden" name="toggle_id" value="<?= $product['id'] ?>">
                  <button type="submit" class="status-btn <?= $product['availability'] === 'Available' ? 'available' : 'unavailable' ?>">
                    <?= $product['availability'] === 'Available' ? '🟢 Available' : '⚪ Unavailable' ?>
                  </button>
                </form>
                <a href="edit_product.php?id=<?= $product['id'] ?>" class="edit-btn">✏️ Edit</a>
                <a href="?delete_id=<?= $product['id'] ?>" class="delete-btn" onclick="return confirm('Delete this product?')">🗑 Delete</a>
              </div>
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
