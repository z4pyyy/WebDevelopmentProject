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

    <h2 class="prd-drink-name">Artisan Brew</h2>

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
                    <!--butterscotch latte-->
                    <figure class="prd-product-item">
                        <div class="prd-product-image">
                          <img src="images/butterscotch-latte.jpg" alt="Butterscotch Latte"> 
                        </div>
                        <figcaption class="prd-product-info">
                          <h2 class="prd-name">Butterscotch Latte</h2>
                          <p class="prd-description">A delightful blend of espresso and butterscotch syrup.</p>
                          <p class="prd-price">Member: RM11.90</p>
                          <p class="prd-price">Non-Member: RM13.90</p>
                        </figcaption>
                      </figure>
                      
                      <!--butterscotch creme-->
                      <figure class="prd-product-item">
                        <div class="prd-product-image">
                          <img src="images/butterscotch-creme.webp" alt="Butterscotch Creme">
                        </div>
                        <figcaption class="prd-product-info">
                          <h2 class="prd-name">Butterscotch Creme</h2>
                          <p class="prd-description">A creamy blend of butterscotch and espresso.</p>
                          <p class="prd-price">Member: RM14.90</p>
                          <p class="prd-price">Non-Member: RM16.90</p>
                        </figcaption>
                      </figure>
                      
                      <!--mint latte-->
                      <figure class="prd-product-item">
                        <div class="prd-product-image">
                          <img src="images/mint-latte.jpg" alt="Mint Latte">
                        </div>
                        <figcaption class="prd-product-info">
                          <h2 class="prd-name">Mint Latte</h2>
                          <p class="prd-description">A refreshing blend of mint and espresso.</p>
                          <p class="prd-price">Member: RM12.90</p>
                          <p class="prd-price">Non-Member: RM14.90</p>
                        </figcaption>
                      </figure>
                      
                      <!--Vienna Latte-->
                      <figure class="prd-product-item">
                        <div class="prd-product-image">
                          <img src="images/vienna-latte.jpg" alt="Vienna Latte">
                        </div>
                        <figcaption class="prd-product-info">
                          <h2 class="prd-name">Vienna Latte</h2>
                          <p class="prd-description">A rich blend of espresso and whipped cream.</p>
                          <p class="prd-price">Member: RM14.90</p>
                          <p class="prd-price">Non-Member: RM16.90</p>
                        </figcaption>
                      </figure>
                      
                      <!--Pistachio Latte-->
                      <figure class="prd-product-item">
                        <div class="prd-product-image">
                          <img src="images/pistachio-latte.jpg" alt="Pistachio Latte">
                        </div>
                        <figcaption class="prd-product-info">
                          <h2 class="prd-name">Pistachio Latte</h2>
                          <p class="prd-description">A nutty blend of pistachio and espresso.</p>
                          <p class="prd-price">Member: RM15.90</p>
                          <p class="prd-price">Non-Member: RM17.90</p>
                        </figcaption>
                      </figure>
                      
                      <!--strawberry latte-->
                      <figure class="prd-product-item">
                        <div class="prd-product-image">
                          <img src="images/strawberry-latte.jpg" alt="Strawberry Latte">
                        </div>
                        <figcaption class="prd-product-info">
                          <h2 class="prd-name">Strawberry Latte</h2>
                          <p class="prd-description">A fruity blend of strawberry and espresso.</p>
                          <p class="prd-price">Member: RM13.90</p>
                          <p class="prd-price">Non-Member: RM15.90</p>
                        </figcaption>
                      </figure>
                      
                      <!--Mocha-->
                      <figure class="prd-product-item">
                        <div class="prd-product-image">
                          <img src="images/mocha.jpg" alt="Mocha">
                        </div>
                        <figcaption class="prd-product-info">
                          <h2 class="prd-name">Mocha</h2>
                          <p class="prd-description">A rich blend of chocolate and espresso.</p>
                          <p class="prd-price">Member: RM11.90</p>
                          <p class="prd-price">Non-Member: RM13.90</p>
                        </figcaption>
                      </figure>
                      
                      <!--Mint Mocha-->
                      <figure class="prd-product-item">
                        <div class="prd-product-image">
                          <img src="images/mint-mocha.png" alt="Mint Mocha">
                        </div>
                        <figcaption class="prd-product-info">
                          <h2 class="prd-name">Mint Mocha</h2>
                          <p class="prd-description">A refreshing blend of mint, chocolate, and espresso.</p>
                          <p class="prd-price">Member: RM12.90</p>
                          <p class="prd-price">Non-Member: RM14.90</p>
                        </figcaption>
                      </figure>
                      
                      <!--Orange Mocha-->
                      <figure class="prd-product-item">
                        <div class="prd-product-image">
                          <img src="images/orange-mocha.jpg" alt="Orange Mocha">
                        </div>
                        <figcaption class="prd-product-info">
                          <h2 class="prd-name">Orange Mocha</h2>
                          <p class="prd-description">A zesty blend of orange, chocolate, and espresso.</p>
                          <p class="prd-price">Member: RM12.90</p>
                          <p class="prd-price">Non-Member: RM14.90</p>
                        </figcaption>
                      </figure>
                      
                      <!--Yuzu Americano-->
                      <figure class="prd-product-item">
                        <div class="prd-product-image">
                          <img src="images/yuzu-americano.jpeg" alt="Yuzu Americano">
                        </div>
                        <figcaption class="prd-product-info">
                          <h2 class="prd-name">Yuzu Americano</h2>
                          <p class="prd-description">A citrusy blend of yuzu and espresso.</p>
                          <p class="prd-price">Member: RM13.90</p>
                          <p class="prd-price">Non-Member: RM15.90</p>
                        </figcaption>
                      </figure>
                      
                      <!--Cheese Americano-->
                      <figure class="prd-product-item">
                        <div class="prd-product-image">
                          <img src="images/cheese-americano.webp" alt="Cheese Americano">
                        </div>
                        <figcaption class="prd-product-info">
                          <h2 class="prd-name">Cheese Americano</h2>
                          <p class="prd-description">A unique blend of cheese and espresso.</p>
                          <p class="prd-price">Member: RM13.90</p>
                          <p class="prd-price">Non-Member: RM15.90</p>
                        </figcaption>
                      </figure>
                      
                      <!--Orange Americano-->
                      <figure class="prd-product-item">
                        <div class="prd-product-image">
                          <img src="images/orange-americano.jpg" alt="Orange Americano">
                        </div>
                        <figcaption class="prd-product-info">
                          <h2 class="prd-name">Orange Americano</h2>
                          <p class="prd-description">A zesty blend of orange and espresso.</p>
                          <p class="prd-price">Member: RM13.90</p>
                          <p class="prd-price">Non-Member: RM15.90</p>
                        </figcaption>
                      </figure>
                    </div>
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