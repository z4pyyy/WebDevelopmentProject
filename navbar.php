
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
    <?php if (!empty($_SESSION['cart'])): ?>
      <ul class="cart-list">
        <?php foreach ($_SESSION['cart'] as $item): ?>
          <li class="cart-item">
            <img src="<?= htmlspecialchars($item['image'] ?? 'assets/no-image.png') ?>" alt="<?= htmlspecialchars($item['name']) ?>" class="cart-item-img">
            <div class="cart-item-info">
              <span class="cart-item-name"><?= htmlspecialchars($item['name']) ?></span>
              <!-- Editable quantity form -->
              <form method="post" action="update_cart.php" class="cart-update-form" style="display:inline;">
                <input type="hidden" name="product_id" value="<?= $item['id'] ?>">
                <input type="number" name="quantity" value="<?= $item['quantity'] ?>" min="0" class="cart-qty-input" style="width:44px; text-align:center;">
                <button type="submit" class="cart-update-btn">Update</button>
              </form>
              <span class="cart-item-price">RM<?= number_format($item['price'] * $item['quantity'], 2) ?></span>
            </div>
          </li>
        <?php endforeach; ?>
      </ul>
      <div class="cart-total">
        Total: RM
        <?php
          $total = 0;
          foreach ($_SESSION['cart'] as $item) {
            $total += $item['price'] * $item['quantity'];
          }
          echo number_format($total, 2);
        ?>
      <a href="checkout.php" class="checkout-btn">Checkout</a>
      </div>
    <?php else: ?>
      <p>Your selected items will appear here.</p>
    <?php endif; ?>
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
      <?php
      $role_id = $_SESSION['role_id'] ?? 0;
      $username = $_SESSION['username'] ?? null;
      ?>
        <?php if ($username): ?>
          <?php if ($role_id == 1): ?>
            <!-- Admin: only "View" -->
            <li>
            <span class="hover-underline"><a href="admin_dashboard.php">ADMIN</a></span>
            <?php elseif (in_array($role_id, [2,3])): ?>
              <!-- Operator/Staff: both "View" AND username -->
              <span class="hover-underline"><a href="admin_dashboard.php">View</a></span>
            </li>
            <li>
              <span class="hover-underline"><a href="membership.php"><?= htmlspecialchars($username) ?></a></span>
            </li>
            <?php else: ?>
            <!-- Normal user: only username (membership) -->
            <span class="hover-underline"><a href="membership.php"><?= htmlspecialchars($username) ?></a></span>
          <?php endif; ?>
        <?php else: ?>
          <span class="hover-underline"><a href="registration.php">Membership</a></span>
        <?php endif; ?>
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
          <?php
          $role_id = $_SESSION['role_id'] ?? 0;
          $username = $_SESSION['username'] ?? null;
          ?>
          <li>
            <?php if ($username): ?>
              <?php if ($role_id == 1): ?>
                <!-- Admin: only "View" -->
                <span class="hover-underline"><a href="admin_dashboard.php">View</a></span>
              <?php elseif (in_array($role_id, [2,3])): ?>
                <!-- Operator/Staff: both "View" AND username -->
                <span class="hover-underline"><a href="admin_dashboard.php">View</a></span>
                <span class="hover-underline"><a href="membership.php"><?= htmlspecialchars($username) ?></a></span>
              <?php else: ?>
                <!-- Normal user: only username (membership) -->
                <span class="hover-underline"><a href="membership.php"><?= htmlspecialchars($username) ?></a></span>
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