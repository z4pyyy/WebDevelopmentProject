<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include 'connection.php';
include 'navbar.php';

// 📦 Fetch only Hot Beverages
$query = "
  SELECT products.*
  FROM products
  JOIN categories ON products.category_id = categories.id
  WHERE categories.name = 'Hot Beverages'
  ORDER BY products.name ASC
";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="description" content="Brew & Go Coffee - Hot Beverages">
  <meta name="keywords" content="Hot Coffee, Brew & Go, Tea, Latte, Chocolate, Kuching">
  <meta name="author" content="TERENCE WONG, DARREN CHONG, HANS YEE">
  <title>Brew & Go - Hot Beverages</title>
  <link rel="stylesheet" href="styles/style.css" />
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css?family=Outfit" rel="stylesheet" />
</head>
<body class="product-page">
  <div id="top"></div>
  <header>
    <?php include 'navbar.php'; ?>
  </header>

  <h2 class="prd-drink-name">Hot Beverages</h2>

  <div class="prd-toggle-wrapper">
    <input type="checkbox" id="prd-menu-toggle" class="prd-menu-toggle">
    <label for="prd-menu-toggle" class="prd-menu-btn">☰ Select Category</label>
    <div class="prd-menu">
      <ul>
        <li><a href="product1.php">Basic Brew</a></li>
        <li><a href="product2.php">Artisan Brew</a></li>
        <li><a href="product3.php">Non-Coffee</a></li>
        <li><a href="product4.php">Hot Beverages</a></li>
      </ul>
    </div>
  </div>

  <div class="prd-content-container">
    <div id="hot-beverages">
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
                  <input type="number" name="quantity" min="1" value="1" class="cart-quantity">
                  <input type="hidden" name="image" value="<?= htmlspecialchars($row['image_path']) ?>">
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
    <!-- BASIC BREW -->
    <tr class="prd-menu-category"><td rowspan="6">Basic Brew</td></tr>
    <td>Americano</td><td>8.90</td><td>10.90</td></tr>
    <tr><td>Latte</td><td>10.90</td><td>12.90</td></tr>
    <tr><td>Cappuccino</td><td>11.90</td><td>13.90</td></tr>
    <tr><td>Aerocano</td><td>10.90</td><td>12.90</td></tr>
    <tr><td>Aero-latte</td><td>12.90</td><td>14.90</td></tr>

    <!-- ARTISAN BREW -->
    <tr class="prd-menu-category"><td rowspan="13">Artisan Brew</td></tr>
    <td>Butterscotch Latte</td><td>11.90</td><td>13.90</td></tr>
    <tr><td>Butterscotch Creme</td><td>14.90</td><td>16.90</td></tr>
    <tr><td>Mint Latte</td><td>12.90</td><td>14.90</td></tr>
    <tr><td>Vienna Latte</td><td>14.90</td><td>16.90</td></tr>
    <tr><td>Pistachio Latte</td><td>15.90</td><td>17.90</td></tr>
    <tr><td>Strawberry Latte</td><td>14.90</td><td>16.90</td></tr>
    <tr><td>Mocha</td><td>11.90</td><td>13.90</td></tr>
    <tr><td>Mint Mocha</td><td>12.90</td><td>14.90</td></tr>
    <tr><td>Orange Mocha</td><td>12.90</td><td>14.90</td></tr>
    <tr><td>Yuzu Americano</td><td>13.90</td><td>15.90</td></tr>
    <tr><td>Cheese Americano</td><td>13.90</td><td>15.90</td></tr>
    <tr><td>Orange Americano</td><td>13.90</td><td>15.90</td></tr>

    <!-- NON-COFFEE -->
    <tr class="prd-menu-category"><td rowspan="11">Non-Coffee</td></tr>
    <td>Chocolate</td><td>13.90</td><td>15.90</td></tr>
    <tr><td>Mint Chocolate</td><td>13.90</td><td>15.90</td></tr>
    <tr><td>Orange Chocolate</td><td>13.90</td><td>15.90</td></tr>
    <tr><td>Yuzu Soda</td><td>13.90</td><td>15.90</td></tr>
    <tr><td>Strawberry Soda</td><td>13.90</td><td>15.90</td></tr>
    <tr><td>Yuzu Cheese</td><td>13.90</td><td>15.90</td></tr>
    <tr><td>Yuri Matcha</td><td>13.90</td><td>15.90</td></tr>
    <tr><td>Strawberry Matcha</td><td>14.90</td><td>16.90</td></tr>
    <tr><td>Yuzu Matcha</td><td>14.90</td><td>16.90</td></tr>
    <tr><td>Houjicha</td><td>13.90</td><td>15.90</td></tr>

    <!-- HOT BEVERAGES -->
    <tr class="prd-menu-category"><td rowspan="8">Hot Beverages</td></tr>
      <td>Americano</td><td>7.90</td><td>9.90</td></tr>
    <tr><td>Latte</td><td>9.90</td><td>11.90</td></tr>
    <tr><td>Butterscotch Latte</td><td>10.90</td><td>12.90</td></tr>
    <tr><td>Cappuccino</td><td>10.90</td><td>12.90</td></tr>
    <tr><td>Chocolate</td><td>12.90</td><td>14.90</td></tr>
    <tr><td>Yuri Matcha</td><td>13.90</td><td>15.90</td></tr>
    <tr><td>Houjicha</td><td>13.90</td><td>14.90</td></tr>

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
