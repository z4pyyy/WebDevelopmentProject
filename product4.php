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
        <nav class="navbar">
            <input type="checkbox" id="nav-toggle" class="nav-toggle">
            <label for="nav-toggle" class="nav-icon">&#9776;</label>
            
            <a href="index.html" class="logo">
                <img src="images/Logo.png" alt="Brew & Go Logo">
                BREW & GO
            </a>
            
            <!-- Shopping Cart -->
            <input type="checkbox" id="cart-toggle" class="floating-cart-toggle" aria-label="Toggle Cart">
            <label for="cart-toggle" class="floating-cart-icon">🛒</label>
            <div class="cart-sidebar">
                <h2>Shopping Cart</h2>
                <p>Your selected items will appear here.</p>
                <label for="cart-toggle" class="close-cart">✖ Close</label>
            </div>

            <div class="cart-overlay"></div>

            <!-- Full Navbar Menu (Hidden in Portrait) -->
            <ul class="nav-menu">
                <li class="dropdown">
                  <span class="hover-underline"><a href="product1.html">Products ▾</a></span>
                  <ul class="dropdown-content">
                    <li><a href="product1.html">Basic Brew</a></li>
                    <li><a href="product2.html">Artisan Brew</a></li>
                    <li><a href="product3.html">Non-Coffee</a></li>
                    <li><a href="product4.html">Hot Beverage</a></li>
                  </ul>
                <li class="dropdown">
                  <span class="hover-underline"><a href="blog.html">Blog ▾</a></span>
                  <ul class="dropdown-content">
                    <li><a href="coming_soon.html">Coming Soon</a></li>
                    <li><a href="current_activity.html">Current Event</a></li>
                    <li><a href="past_activity.html">Past Events</a></li>
                  </ul>
                </li>
                <li><span class="hover-underline"><a href="joinus.html">Join Us</a></li></span>
                <li><span class="hover-underline"><a href="enquiry.html">Enquiry</a></li></span>
                <li><span class="hover-underline"><a href="registration.html">Membership</a></li></span>
                <!-- <li>
                  <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true): ?>
                    <a href="view.php">View</a>
                  <?php else: ?>
                    <a href="login.php">Login</a>
                  <?php endif; ?>
                </li> -->
              </ul>
    
            <!-- Mobile Dropdown Menu -->
            <div class="nav-dropdown">
                <ul>
                    <li><a href="product1.html">Products</a></li>
                    <li><a href="blog.html">Blog</a></li>
                    <li><a href="joinus.html">Join Us</a></li>
                    <li><a href="enquiry.html">Enquiry</a></li>
                    <li><a href="registration.html">Membership</a></li>
                </ul>
            </div>
        </nav>
    </header>


    <h2 class="prd-drink-name">Hot Beverages</h2>
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
                <!--Hot Americano-->
                  <figure class="prd-product-item">
                    <div class="prd-product-image">
                      <img src="images/hot-americano.jpeg" alt="Americano">
                    </div>
                    <figcaption class="prd-product-info">
                      <h2 class="prd-name">Americano</h2>
                      <p class="prd-description">Rich and creamy, a timeless favorite.</p>
                      <p class="prd-price">Member: RM8.90</p>
                      <p class="prd-price">Non-Member: RM10.90</p>
                    </figcaption>
                  </figure>

                  <!--Hot Latte-->
                  <figure class="prd-product-item">
                    <div class="prd-product-image">
                      <img src="images/hot-latte.jpg" alt="Latte">
                    </div>
                    <figcaption class="prd-product-info">
                      <h2 class="prd-name">Latte</h2>
                      <p class="prd-description">Indulge in the deep flavors of chocolate.</p>
                      <p class="prd-price">Member: RM9.90</p>
                      <p class="prd-price">Non-Member: RM11.90</p>
                    </figcaption>
                  </figure>

                  <!--hot butterscotch latte-->
                  <figure class="prd-product-item">
                    <div class="prd-product-image">
                      <img src="images/hot-butterscotch-latte.webp" alt="Butterscotch Latte"> 
                    </div>
                    <figcaption class="prd-product-info">
                      <h2 class="prd-name">Butterscotch Latte</h2>
                      <p class="prd-description">A delightful blend of espresso and butterscotch syrup.</p>
                      <p class="prd-price">Member: RM10.90</p>
                      <p class="prd-price">Non-Member: RM12.90</p>
                    </figcaption>
                  </figure>

                  <!--Hot Cappuccino-->
                  <figure class="prd-product-item">
                    <div class="prd-product-image">
                      <img src="images/hot-cappuccino.jpg" alt="Cappuccino">
                    </div>
                    <figcaption class="prd-product-info">
                      <h2 class="prd-name">Cappuccino</h2>
                      <p class="prd-description">A classic blend of espresso and steamed milk.</p>
                      <p class="prd-price">Member: RM10.90</p>
                      <p class="prd-price">Non-Member: RM12.90</p>
                    </figcaption>
                  </figure>

                  <!--Hot Chocolate-->
                  <figure class="prd-product-item">
                    <div class="prd-product-image">
                      <img src="images/hot-chocolate.jpg" alt="Chocolate">
                    </div>
                    <figcaption class="prd-product-info">
                      <h2 class="prd-name">Chocolate</h2>
                      <p class="prd-description">A rich and creamy chocolate drink.</p>
                      <p class="prd-price">Member: RM12.90</p>
                      <p class="prd-price">Non-Member: RM14.90</p>
                    </figcaption>
                  </figure>

                  <!--Hot Yuri Mocha-->
                  <figure class="prd-product-item">
                    <div class="prd-product-image">
                      <img src="images/hot-yuri-mocha.webp" alt="Yuri Mocha">
                    </div>
                    <figcaption class="prd-product-info">
                      <h2 class="prd-name">Yuri Mocha</h2>
                      <p class="prd-description">A unique blend of yuzu and mocha flavors.</p>
                      <p class="prd-price">Member: RM12.90</p>
                      <p class="prd-price">Non-Member: RM14.90</p>
                    </figcaption>
                  </figure>

                  <!--Hot Houjicha-->
                  <figure class="prd-product-item">
                    <div class="prd-product-image">
                      <img src="images/hot-houjicha.jpg" alt="Houjicha">
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
<footer class="footer">
  <div class="footer-container">
    
    <!-- Column 1: Developers -->
    <div class="footer-column">
      <p class="footer-header">DEVELOPED BY</p>
      <p><a href="profile1.html">Terence Wong</a></p>
      <p><a href="profile2.html">Darren Chong</a></p>
      <p><a href="profile3.html">Hans Yee</a></p>
      <p><a href="profile4.html">Jared Teh</a></p>
    </div>

    <!-- Column 2: Acknowledgement -->
    <div class="footer-column">
      <p class="footer-header">ACKNOWLEDGEMENT</p>
      <p><a href="acknowledgement.html">Acknowledgement</a></p>
      <p><a href="enhancements.html">Enhancements</a></p>
      <p><a href="https://www.youtube.com/watch?v=Nz_lsiT_kcI">Presentation Video</a></p>
    </div>

    <!-- Column 3: Subscription -->
    <div class="footer-column">
      <p class="footer-header">SUBSCRIBE EMAIL</p>
      <form class="subscribe-form">
        <input type="email" placeholder="Enter your email" required>
        <button type="submit" class="btn-index-subscribe">Subscribe</button>
      </form>
    </div>

    <!-- Column 4: Social Links -->
    <div class="footer-column">
      <p class="footer-header">MORE ABOUT US</p>
      <div class="social-icons">
        <a href="https://www.instagram.com/brewngo.coffee/" target="_blank"><img src="images/Instagram.png" alt="Instagram"></a>
        <a href="https://www.facebook.com/profile.php?id=61554234958482" target="_blank"><img src="images/Meta.png" alt="Facebook"></a>
        <a href="#"><img src="images/Whatsapp.png" alt="Whatsapp"></a>
        <a href="mailto:104404059@students.swinburne.edu.my"><img src="images/Mail.png" alt="Mail"></a>
      </div>
    </div>
  </div>

  <div class="footer-bottom">
    <a href="#top"><p class="footer-brand">BREW & GO</p></a>
    <p>© COPYRIGHT 2025 BREW & GO</p>
  </div>
</footer>  
</body>
</html> 
