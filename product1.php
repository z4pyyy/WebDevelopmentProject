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
    <link rel="stylesheet" href="styles/mobile.css?" media="screen and (max-width: 1300px)">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Outfit' rel='stylesheet'>
</head>

<body class="product-page">
    <div id="top"></div>
    <header>
      <?php include 'navbar.php'; ?>
    </header>
<h2 class="prd-drink-name">Basic Brew</h2>
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
      <!--Iced Americano-->
      <figure class="prd-product-item">
        <div class="prd-product-image">
          <img alt="Americano" src="images/iceamericano.jpg"/>
        </div>
        <figcaption class="prd-product-info">
          <h2 class="prd-name">Americano</h2>
          <p class="prd-description">Rich and creamy, a timeless favorite.</p>
          <p class="prd-price">Member: RM8.90</p>
          <p class="prd-price">Non-Member: RM10.90</p>
        </figcaption>
      </figure>
      
      <!-- Latte -->
      <figure class="prd-product-item">
        <div class="prd-product-image">
          <img alt="Latte" src="images/Latte.png"/>
        </div>
        <figcaption class="prd-product-info">
          <h2 class="prd-name">Latte</h2>
          <p class="prd-description">Indulge in the deep flavors of chocolate.</p>
          <p class="prd-price">Member: RM10.90</p>
          <p class="prd-price">Non-Member: RM12.90</p>
        </figcaption>
      </figure>
      
      <!-- Cappuccino -->
      <figure class="prd-product-item">
        <div class="prd-product-image">
          <img alt="Cappuccino" src="images/Cappuccino.jpg"/>
        </div>
        <figcaption class="prd-product-info">
          <h2 class="prd-name">Cappuccino</h2>
          <p class="prd-description">A classic blend of espresso and steamed milk.</p>
          <p class="prd-price">Member: RM11.90</p>
          <p class="prd-price">Non-Member: RM13.90</p>
        </figcaption>
      </figure>
      
      <!-- Aerocano -->
      <figure class="prd-product-item">
        <div class="prd-product-image">
          <img alt="Aerocano" src="images/Aerocano.jpg"/>
        </div>
        <figcaption class="prd-product-info">
          <h2 class="prd-name">Aerocano</h2>
          <p class="prd-description">Aeropress and Americano combined.</p>
          <p class="prd-price">Member: RM10.90</p>
          <p class="prd-price">Non-Member: RM12.90</p>
        </figcaption>
      </figure>
      
      <!-- Aero-Latte -->
      <figure class="prd-product-item">
        <div class="prd-product-image">
          <img alt="Aero-Latte" src="images/aero-latte.jpg"/>
        </div>
        <figcaption class="prd-product-info">
          <h2 class="prd-name">Aero-Latte</h2>
          <p class="prd-description">Aeropress and Latte combined.</p>
          <p class="prd-price">Member: RM12.90</p>
          <p class="prd-price">Non-Member: RM14.90</p>
        </figcaption>
      </figure>      
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
        <td>Americano</td><td>8.90</td><td>10.90</td>
        <tr><td>Latte</td><td>10.90</td><td>12.90</td></tr>
        <tr><td>Cappuccino</td><td>11.90</td><td>13.90</td></tr>
        <tr><td>Aerocano</td><td>10.90</td><td>12.90</td></tr>
        <tr><td>Aero-latte</td><td>12.90</td><td>14.90</td></tr>
        <!-- ARTISAN BREW -->
        <tr class="prd-menu-category"><td rowspan="13">Artisan Brew</td></tr>
        <td>Butterscotch Latte</td><td>11.90</td><td>13.90</td>
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
        <td>Chocolate</td><td>13.90</td><td>15.90</td>
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
        <td>Americano</td><td>7.90</td><td>9.90</td>
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