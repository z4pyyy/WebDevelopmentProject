<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
  
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Brew & Go Coffee - Premium handcrafted beverages">
    <meta name="keywords" content="Coffee, Brew & Go, Kuching, handcrafted beverages">
    <meta name="author" content="TERENCE WONG, DARREN CHONG, HANS YEE">
    <title>Brew & Go Coffee - Home</title>
    <link rel="stylesheet" href="styles/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Outfit' rel='stylesheet'>
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
          <li><a href="product1.html">Basic Brew</a></li>
          <li><a href="product2.html">Artisan Brew</a></li>
          <li><a href="product3.html">Non-Coffee</a></li>
          <li><a href="product4.html">Hot Beverages</a></li>
        </ul>
      </div>
    </div>
    
    <div class="prd-content-container">
        <div id="basic-brew">
                <div class="prd-product-list">
                  <!--Chocolate-->
                  <figure class="prd-product-item">
                    <div class="prd-product-image">
                      <img src="images/chocolate.jpg" alt="Chocolate">
                    </div>
                    <figcaption class="prd-product-info">
                      <h2 class="prd-name">Chocolate</h2>
                      <p class="prd-description">A rich and creamy chocolate drink.</p>
                      <p class="prd-price">Member: RM13.90</p>
                      <p class="prd-price">Non-Member: RM15.90</p>
                    </figcaption>
                  </figure>

                  <!--Mint Chocolate-->
                  <figure class="prd-product-item">
                    <div class="prd-product-image">
                      <img src="images/mint-chocolate.avif" alt="Mint Chocolate">
                    </div>
                    <figcaption class="prd-product-info">
                      <h2 class="prd-name">Mint Chocolate</h2>
                      <p class="prd-description">A refreshing minty twist on classic chocolate.</p>
                      <p class="prd-price">Member: RM13.90</p>
                      <p class="prd-price">Non-Member: RM15.90</p>
                    </figcaption>
                  </figure>

                  <!--Orange Chocolate-->
                  <figure class="prd-product-item">
                    <div class="prd-product-image">
                      <img src="images/orange-chocolate.jpg" alt="Orange Chocolate">
                    </div>
                    <figcaption class="prd-product-info">
                      <h2 class="prd-name">Orange Chocolate</h2>
                      <p class="prd-description">A zesty orange flavor combined with rich chocolate.</p>
                      <p class="prd-price">Member: RM13.90</p>
                      <p class="prd-price">Non-Member: RM15.90</p>
                    </figcaption>
                  </figure>

                  <!--Yuzu Soda-->
                  <figure class="prd-product-item">
                    <div class="prd-product-image">
                      <img src="images/yuzu-soda.jpeg" alt="Yuzu Soda">
                    </div>
                    <figcaption class="prd-product-info">
                      <h2 class="prd-name">Yuzu Soda</h2>
                      <p class="prd-description">A refreshing soda with a hint of yuzu.</p>
                      <p class="prd-price">Member: RM13.90</p>
                      <p class="prd-price">Non-Member: RM15.90</p>
                    </figcaption>
                  </figure>

                  <!--Strawberry Mocha-->
                  <figure class="prd-product-item">
                    <div class="prd-product-image">
                      <img src="images/strawberry-mocha.jpeg" alt="Strawberry Mocha">
                    </div>
                    <figcaption class="prd-product-info">
                      <h2 class="prd-name">Strawberry Mocha</h2>
                      <p class="prd-description">A delightful blend of strawberry and mocha.</p>
                      <p class="prd-price">Member: RM14.90</p>
                      <p class="prd-price">Non-Member: RM16.90</p>
                    </figcaption>
                  </figure>

                  <!--Yuzu Mocha-->
                  <figure class="prd-product-item">
                    <div class="prd-product-image">
                      <img src="images/yuzu-mocha.jpg" alt="Yuzu Mocha">
                    </div>
                    <figcaption class="prd-product-info">
                      <h2 class="prd-name">Yuzu Mocha</h2>
                      <p class="prd-description">A refreshing blend of yuzu and mocha.</p>
                      <p class="prd-price">Member: RM14.90</p>
                      <p class="prd-price">Non-Member: RM16.90</p>
                    </figcaption>
                  </figure>

                  <!--Houjicha-->
                  <figure class="prd-product-item">
                    <div class="prd-product-image">
                      <img src="images/houjicha.jpg" alt="Houjicha">
                    </div>
                    <figcaption class="prd-product-info">
                      <h2 class="prd-name">Houjicha</h2>
                      <p class="prd-description">A roasted green tea with a unique flavor.</p>
                      <p class="prd-price">Member: RM13.90</p>
                      <p class="prd-price">Non-Member: RM15.90</p>
                    </figcaption>
                  </figure>
                </div>
            </div>
        </div>
    </div>

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