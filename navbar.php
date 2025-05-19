
<nav class="navbar">
  <input type="checkbox" id="nav-toggle" class="nav-toggle">
  <label for="nav-toggle" class="nav-icon">&#9776;</label>
  
  <a href="index.php" class="logo">
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
        <span class="hover-underline"><a href="product1.php">Products ▾</a></span>
        <ul class="dropdown-content">
          <li><a href="product1.php">Basic Brew</a></li>
          <li><a href="product2.php">Artisan Brew</a></li>
          <li><a href="product3.php">Non-Coffee</a></li>
          <li><a href="product4.php">Hot Beverage</a></li>
        </ul>
      <li class="dropdown">
        <span class="hover-underline"><a href="Blog.php">Blog ▾</a></span>
        <ul class="dropdown-content">
          <li><a href="coming_soon.php">Coming Soon</a></li>
          <li><a href="current_activity.php">Current Event</a></li>
          <li><a href="past_activity.php">Past Events</a></li>
        </ul>
      </li>
      <li><span class="hover-underline"><a href="joinus.php">Join Us</a></li></span>
      <li><span class="hover-underline"><a href="enquiry.php">Enquiry</a></li></span>
      <li>
        <?php if (isset($_SESSION['username'])): ?>
          <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
            <span class="hover-underline"><a href="admin_dashboard.php">View</a></span>
          <?php else: ?>
            <span class="hover-underline"><a href="membership.php"><?= htmlspecialchars($_SESSION['username']) ?></a></span>
          <?php endif; ?>
        <?php else: ?>
          <span class="hover-underline"><a href="registration.php">Membership</a></span>
        <?php endif; ?>
      </li>
      <?php if (isset($_SESSION['username'])): ?>
        <li><span class="hover-underline"><a href="logout.php">Logout</a></li></span>
      <?php endif; ?>
    </ul>
  <!-- Mobile Dropdown Menu -->
  <div class="nav-dropdown">
      <ul>
          <li><a href="product1.php">Products</a></li>
          <li><a href="Blog.php">Blog</a></li>
          <li><a href="joinus.php">Join Us</a></li>
          <li><a href="enquiry.php">Enquiry</a></li>
          <li>
            <?php if (isset($_SESSION['username'])): ?>
              <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                <span class="hover-underline"><a href="admin_dashboard.php">View</a></span>
              <?php else: ?>
                <span class="hover-underline"><a href="membership.php"><?= htmlspecialchars($_SESSION['username']) ?></a></span>
              <?php endif; ?>
            <?php else: ?>
              <span class="hover-underline"><a href="registration.php">Membership</a></span>
            <?php endif; ?>
          </li>
          <?php if (isset($_SESSION['username'])): ?>
            <li><a href="logout.php">Logout</a></li>
          <?php endif; ?>      
        </ul>
  </div>
</nav>