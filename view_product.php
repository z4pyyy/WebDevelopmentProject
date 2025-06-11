<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Debug: Log session variables
error_log("view_product.php accessed. Session: " . print_r($_SESSION, true));

$currentPage = basename($_SERVER['PHP_SELF']);
include 'connection.php';
include 'auth.php';

// 🔒 Secure Access: Check page permissions
if (!isset($_SESSION['admin_id']) || !isset($_SESSION['role_id'])) {
    error_log("view_product.php: Session check failed. admin_id: " . ($_SESSION['admin_id'] ?? 'not set') . ", role_id: " . ($_SESSION['role_id'] ?? 'not set'));
    echo "<meta http-equiv='refresh' content='0;url=login.php'>";
    exit;
}

if (!checkPagePermission($conn, $currentPage, $_SESSION['role_id'])) {
    error_log("view_product.php: Permission denied for role_id: " . $_SESSION['role_id'] . ", page: $currentPage");
    echo "<meta http-equiv='refresh' content='0;url=no_access.php'>";
    exit;
}

include 'navbar.php';
include 'navbar_admin.php';

// 🔍 Handle Search Filters
$filter_by = $_GET['filter_by'] ?? '';
$search_term = trim($_GET['search'] ?? '');
$escaped_search = mysqli_real_escape_string($conn, $search_term);

// 🔄 Toggle Availability (POST, not JS/GET)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['toggle_id'])) {
    $id = intval($_POST['toggle_id']);
    $stmt = mysqli_prepare($conn, "SELECT availability FROM products WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if ($row = mysqli_fetch_assoc($result)) {
        $new_status = ($row['availability'] === 'Available') ? 'Unavailable' : 'Available';
        $update_stmt = mysqli_prepare($conn, "UPDATE products SET availability = ? WHERE id = ?");
        mysqli_stmt_bind_param($update_stmt, "si", $new_status, $id);
        mysqli_stmt_execute($update_stmt);
        mysqli_stmt_close($update_stmt);
    }
    mysqli_stmt_close($stmt);
    // No header(), just reload via standard POST-redirect GET if you want.
    // echo "<meta http-equiv='refresh' content='0;url=view_product.php'>";
    // exit;
}

// 📦 Fetch all products grouped by category
$query = "
    SELECT products.*, categories.name AS category_name
    FROM products
    LEFT JOIN categories ON products.category_id = categories.id
";

$conditions = [];
$params = [];
$types = '';
if (!empty($filter_by) && !empty($search_term)) {
    if ($filter_by === 'name') {
        $conditions[] = "products.name LIKE ?";
        $params[] = "%$search_term%";
        $types .= 's';
    } elseif ($filter_by === 'sku') {
        $conditions[] = "products.sku LIKE ?";
        $params[] = "%$search_term%";
        $types .= 's';
    } elseif ($filter_by === 'availability') {
        $conditions[] = "products.availability = ?";
        $params[] = $search_term;
        $types .= 's';
    }
}

if (!empty($conditions)) {
    $query .= " WHERE " . implode(" AND ", $conditions);
}

$query .= " ORDER BY categories.name ASC, products.name ASC";
$stmt = mysqli_prepare($conn, $query);

if (!empty($params)) {
    mysqli_stmt_bind_param($stmt, $types, ...$params);
}

mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

$products_by_category = [];
while ($row = mysqli_fetch_assoc($result)) {
    $category = $row['category_name'] ?? 'Uncategorized';
    $products_by_category[$category][] = $row;
}
mysqli_stmt_close($stmt);

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
    <!-- No JS: Show full menu always -->
    <div class="admin-prd-menu">
        <ul>
            <?php foreach (array_keys($products_by_category) as $category): ?>
                <?php $category_id = str_replace(' ', '_', $category); ?>
                <li><a href="#<?= htmlspecialchars($category_id) ?>"><?= htmlspecialchars($category) ?></a></li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>
<div class="admin-content">
    <div class="admin-navbar">
        <div><strong>Products</strong></div>
        <a href="add_product.php" class="backto-view">➕ Add New Product</a>
    </div>

    <form method="GET" style="margin: 15px 0;">
        <label for="filter_by"><strong>Search by:</strong></label>
        <select name="filter_by" id="filter_by" class="role-filter" >
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
            <h1 id="<?= htmlspecialchars($category_id) ?>" class="admin-header">
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
                            <form method="POST" style="display:inline;">
                                <input type="hidden" name="toggle_id" value="<?= $product['id'] ?>">
                                <button type="submit" class="status-btn <?= $product['availability'] === 'Available' ? 'available' : 'unavailable' ?>">
                                    <?= $product['availability'] === 'Available' ? '🟢 Available' : '⚪ Unavailable' ?>
                                </button>
                            </form>
                            <a href="edit_product.php?id=<?= $product['id'] ?>" class="edit-btn">✏️ Edit</a>
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
