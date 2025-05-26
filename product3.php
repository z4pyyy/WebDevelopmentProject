<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include 'connection.php';
include 'navbar.php';

// 📦 Fetch only Non-Coffee products
$query = "
  SELECT products.*
  FROM products
  JOIN categories ON products.category_id = categories.id
  WHERE categories.name = 'Non-Coffee'
  ORDER BY products.name ASC
";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="description" content="Brew & Go Coffee - Non-Coffee Beverages">
  <meta name="keywords" content="Brew & Go, Non-Coffee, tea, soda, chocolate, Kuching">
  <meta name="author" content="TERENCE WONG, DARREN CHONG, HANS YEE">
  <title>Brew & Go - Non-Coffee</title>
  <link rel="stylesheet" href="styles/style.css" />
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css?family=Outfit" rel="stylesheet" />
</head>
<body class="product-page">
  <div id="top"></div>
  <header>
    <?php include 'navbar.php'; ?>
  </header>

  <h2 class="prd-drink-name">Non-Coffee</h2>

<div class="prd-toggle-wrapper">
  <input type="checkbox" id="prd-menu-toggle" class="prd-menu-toggle">
  <label for="prd-menu-toggle" class="prd-menu-btn">☰ Select Category</label>
  <div class="prd-menu">
    <ul>
      <li><a href="product1.php">Basic Brew</a></li>
      <li><a href="product2.php">Artisan Brew</a></li>
      <li><a href="product3.php">Non-Coffee</a></li>
      <li><a href="product4.php">Hot Beverages</a></li>
      <?php
      $predefined_categories = ['Basic Brew', 'Artisan Brew', 'Non-Coffee', 'Hot Beverages'];
      $placeholders = implode(',', array_fill(0, count($predefined_categories), '?'));
      $category_query = "
        SELECT COUNT(*) AS count
        FROM categories
        WHERE name NOT IN ($placeholders)
      ";
      $category_stmt = mysqli_prepare($conn, $category_query);
      mysqli_stmt_bind_param($category_stmt, str_repeat('s', count($predefined_categories)), ...$predefined_categories);
      mysqli_stmt_execute($category_stmt);
      $category_result = mysqli_stmt_get_result($category_stmt);
      $new_category_count = mysqli_fetch_assoc($category_result)['count'];
      mysqli_stmt_close($category_stmt);

      if ($new_category_count > 0) {
        echo '<li><a href="other_products.php">Others</a></li>';
      }
      ?>
    </ul>
  </div>
</div>


  <div class="prd-content-container">
    <div id="non-coffee">
                  <div class="prd-product-list">
        <?php if (mysqli_num_rows($result) > 0): ?>
          <?php while ($row = mysqli_fetch_assoc($result)): ?>
          <?php $isUnavailable = ($row['availability'] === 'Unavailable'); ?>
          <figure class="prd-product-item<?= $isUnavailable ? ' prd-unavailable' : '' ?>">
              <div class="prd-product-image">
                <img alt="<?= htmlspecialchars($row['name']) ?>"
                     src="<?= !empty($row['image_path']) && file_exists($row['image_path']) ? htmlspecialchars($row['image_path']) : 'assets/no-image.png' ?>" />
                     <?php if ($isUnavailable): ?>
                  <div class="prd-stock-label">OUT OF STOCK</div>
                <?php endif; ?>
              </div>
              <figcaption class="prd-product-info">
                <h2 class="prd-name"><?= htmlspecialchars($row['name']) ?></h2>
                <p class="prd-description"><?= !empty($row['description']) ? nl2br(htmlspecialchars($row['description'])) : 'No description available.' ?></p>
                <p class="prd-price">Member: RM<?= number_format($row['price'], 2) ?></p>
                <p class="prd-price">Non-Member: RM<?= number_format($row['large_price'], 2) ?></p>
              </figcaption>
              <?php if (!$isUnavailable): ?>
                <form method="post" action="add_to_cart.php" class="cart-add-form">
                  <input type="hidden" name="product_id" value="<?= $row['id'] ?>">
                  <input type="hidden" name="name" value="<?= htmlspecialchars($row['name']) ?>">
                  <input type="hidden" name="price" value="<?= $row['price'] ?>">
                  <input type="hidden" name="large_price" value="<?= $row['large_price'] ?>">
                  <input type="hidden" name="image" value="<?= htmlspecialchars($row['image_path']) ?>">
                  <input type="number" name="quantity" min="1" value="1" class="cart-quantity">
                  <button type="submit" class="add-to-cart-btn">Add to Cart</button>
                </form>
                <?php endif; ?>
              </figure>
          <?php endwhile; ?>
        <?php else: ?>
          <p>No products available in Basic Brew.</p>
        <?php endif; ?>
      </div>
    </div>
  </div>
</body>
</html>



<aside class="full-menu">
  <h2 class="full-menu-title">Full Menu</h2>
  <div class="menu-table-wrapper">
    <table class="menu-table">
      <thead>
        <tr>
          <th>Category</th>
          <th>Beverage</th>
          <th>MP</th>
          <th>NP</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $category_query = "SELECT id, name FROM categories ORDER BY name ASC";
        $category_result = mysqli_query($conn, $category_query);
        if (!$category_result) {
          echo "<tr><td colspan='4'>Error loading categories: " . htmlspecialchars(mysqli_error($conn)) . "</td></tr>";
        } else {
          $has_categories = false;
          while ($category = mysqli_fetch_assoc($category_result)) {
            $has_categories = true;
            $category_name = $category['name'];
            $category_id = $category['id'];

            $count_query = "SELECT COUNT(*) AS count FROM products WHERE category_id = ?";
            $count_stmt = mysqli_prepare($conn, $count_query);
            mysqli_stmt_bind_param($count_stmt, 'i', $category_id);
            mysqli_stmt_execute($count_stmt);
            $count_result = mysqli_stmt_get_result($count_stmt);
            $count = mysqli_fetch_assoc($count_result)['count'];
            mysqli_stmt_close($count_stmt);

            $product_query = "
              SELECT name, price, large_price
              FROM products
              WHERE category_id = ?
              ORDER BY name ASC
            ";
            $product_stmt = mysqli_prepare($conn, $product_query);
            mysqli_stmt_bind_param($product_stmt, 'i', $category_id);
            mysqli_stmt_execute($product_stmt);
            $product_result = mysqli_stmt_get_result($product_stmt);

            // Always display the category, even if it has no products
            echo "<tr class='prd-menu-category'><td rowspan='" . ($count > 0 ? $count + 1 : 2) . "'>" . htmlspecialchars($category_name) . "</td></tr>";
            if ($count > 0) {
              while ($row = mysqli_fetch_assoc($product_result)) {
                $large_price = $row['large_price'] !== null ? number_format($row['large_price'], 2) : 'N/A';
                echo "<tr><td>" . htmlspecialchars($row['name']) . "</td><td>" . number_format($row['price'], 2) . "</td><td>" . $large_price . "</td></tr>";
              }
            } else {
              echo "<tr><td colspan='3'>No products in this category.</td></tr>";
            }
            mysqli_stmt_close($product_stmt);
          }
          if (!$has_categories) {
            echo "<tr><td colspan='4'>No categories available.</td></tr>";
          }
        }
        ?>
        <tr class="full-row"><td colspan="4">MORE COMING SOON</td></tr>
      </tbody>
    </table>
  </div>
</aside>

    <section class="product-explainer">
      <h2>About Our Artisan Drinks</h2>
      <dl>
        <dt>Butterscotch Latte</dt>
        <dd>A rich caramel twist blended into our signature latte.</dd>
        <dt>Mint Mocha</dt>
        <dd>Refreshing mint infused into chocolate espresso base.</dd>
      </dl>
    
      <h3>Top 3 Artisan Picks</h3>
      <ol>
        <li>Butterscotch Creme</li>
        <li>Mint Mocha</li>
        <li>Vienna Latte</li>
      </ol>
    </section>
    
  <?php include 'footer.php'; ?>

    
</body>
</html>            