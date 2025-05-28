<?php
// Start session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Define search query
$search_query = isset($_GET['search']) ? trim($_GET['search']) : '';
?>

<nav class="navbar">
  <input type="checkbox" id="nav-toggle" class="nav-toggle">
  <label for="nav-toggle" class="nav-icon">☰</label>
  
  <a href="index.php" class="logo">
    <img src="images/Logo.png" alt="Brew & Go Logo">
    BREW & GO!
  </a>

  <!-- Search Form -->
  <div class="search-container">
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="get" class="search-form">
      <input type="text" name="search" id="search-bar" placeholder="Search..." value="<?php echo htmlspecialchars($search_query); ?>" aria-label="Search">
    </form>
    <?php if (!empty($search_query) && strlen($search_query) >= 2): ?>
      <div class="search-results">
        <?php
        $results = [];

        // Database search
        if (isset($conn) && !$conn->connect_error) {
            // Get all tables
            $tables_result = $conn->query("SHOW TABLES");
            if ($tables_result) {
                $searchable_tables = [
                    'products' => ['category' => 'Products', 'url' => 'product1.php?id=', 'name_col' => 'name', 'desc_col' => 'description'],
                    // Add more table mappings if needed, e.g., 'categories' => [...]
                ];

                while ($row = $tables_result->fetch_array()) {
                    $table_name = $row[0];
                    if (isset($searchable_tables[$table_name])) {
                        $config = $searchable_tables[$table_name];
                        $query = $conn->real_escape_string($search_query);

                        // Get searchable columns
                        $columns_result = $conn->query("SHOW COLUMNS FROM `$table_name` WHERE Type LIKE '%char%' OR Type LIKE '%text%'");
                        $search_columns = [];
                        while ($col = $columns_result->fetch_assoc()) {
                            $search_columns[] = $col['Field'];
                        }

                        if (!empty($search_columns)) {
                            $conditions = [];
                            foreach ($search_columns as $col) {
                                $conditions[] = "`$col` LIKE '%$query%'";
                            }
                            $where_clause = implode(' OR ', $conditions);

                            $sql = "SELECT '{$config['category']}' as category, id, {$config['name_col']} as name, {$config['desc_col']} as description, '{$config['url']}' as url 
                                    FROM `$table_name` 
                                    WHERE $where_clause";
                            $result = $conn->query($sql);
                            if ($result) {
                                while ($row = $result->fetch_assoc()) {
                                    $results[] = [
                                        'category' => $row['category'],
                                        'name' => $row['name'],
                                        'description' => $row['description'] ?: 'No description',
                                        'url' => $row['url'] . $row['id']
                                    ];
                                }
                            }
                        }
                    }
                }
            }
        } else {
            echo '<div class="result-item">Database connection not available: ' . ($conn->connect_error ?? 'No connection object') . '</div>';
        }

        // Static pages (dynamic)
        $static_pages = [];
        $php_files = glob('*.php'); // Scan root directory
        foreach ($php_files as $file) {
            $name = ucwords(str_replace(['-', '_', '.php'], [' ', ' ', ''], $file));
            $description = "Visit our $name page";
            $static_pages[] = [
                'category' => 'Pages',
                'name' => $name,
                'description' => $description,
                'url' => $file
            ];
        }

        // Add promotions and locations from index.php
        $static_pages = array_merge($static_pages, [
            ['category' => 'Promotions', 'name' => 'Thursday Discount', 'description' => 'Discounts every Thursday at AEON Mall Kuching', 'url' => 'past_activity.php#past_activity2'],
            ['category' => 'Promotions', 'name' => 'March Promo', 'description' => 'Buy 1 Get 1 Free on Cold Brews every Friday', 'url' => 'current_activity.php'],
            ['category' => 'Locations', 'name' => 'One Jaya Mall', 'description' => 'Brew & Go at One Jaya Mall, Kuching', 'url' => 'index.php#store-locator'],
            ['category' => 'Locations', 'name' => 'Plaza Merdeka', 'description' => 'Brew & Go at Plaza Merdeka, Kuching', 'url' => 'index.php#store-locator']
        ]);

        foreach ($static_pages as $page) {
            if (stripos($page['name'], $search_query) !== false || stripos($page['description'], $search_query) !== false) {
                $results[] = $page;
            }
        }

        // Group results
        $grouped_results = [];
        foreach ($results as $result) {
            $grouped_results[$result['category']][] = $result;
        }

        // Display results
        if (empty($grouped_results)) {
            echo '<div class="result-item">No results found</div>';
        } else {
            foreach ($grouped_results as $category => $items) {
                echo '<div class="category">' . htmlspecialchars($category) . '</div>';
                foreach ($items as $item) {
                    echo '<div class="result-item">';
                    echo '<a href="' . htmlspecialchars($item['url']) . '">';
                    echo '<strong>' . htmlspecialchars($item['name']) . '</strong><br>';
                    echo '<small>' . htmlspecialchars(substr($item['description'], 0, 50)) . '...</small>';
                    echo '</a>';
                    echo '</div>';
                }
            }
        }
        echo '<div class="result-item"><a href="' . htmlspecialchars($_SERVER['PHP_SELF']) . '">Clear Search</a></div>';
        ?>
      </div>
    <?php elseif (!empty($search_query)): ?>
      <div class="search-results">
        <div class="result-item">Please enter at least 2 characters</div>
      </div>
    <?php endif; ?>
  </div>

  <!-- Shopping Cart -->
  <input type="checkbox" id="cart-toggle" class="floating-cart-toggle" aria-label="Toggle Cart">
  <label for="cart-toggle" class="floating-cart-icon">🛒</label>
  <div class="cart-sidebar">
    <h2>Shopping Cart</h2>
    <?php if (!empty($_SESSION['cart'])): ?>
      <ul class="cart-list">
        <?php foreach ($_SESSION['cart'] as $item): ?>
          <li class="cart-item">
            <img src="<?php echo htmlspecialchars($item['image'] ?? 'assets/no-image.png'); ?>" alt="<?php echo htmlspecialchars($item['name']); ?>" class="cart-item-img">
            <div class="cart-item-info">
              <span class="cart-item-name"><?php echo htmlspecialchars($item['name']); ?></span>
              <form method="post" action="update_cart.php" class="cart-update-form" style="display:inline;">
                <input type="hidden" name="product_id" value="<?php echo $item['id']; ?>">
                <input type="number" name="quantity" value="<?php echo $item['quantity']; ?>" min="0" class="cart-qty-input" style="width:44px; text-align:center;">
                <button type="submit" class="cart-update-btn">Update</button>
              </form>
              <span class="cart-item-price">RM<?php echo number_format($item['price'] * $item['quantity'], 2); ?></span>
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

  <!-- Full Navbar Menu -->
  <ul class="nav-menu">
    <li class="dropdown">
      <span class="hover-underline"><a href="product1.php">Products ▾</a></span>
      <ul class="dropdown-content">
        <li><a href="product1.php">Basic Brew</a></li>
        <li><a href="product2.php">Artisan Brew</a></li>
        <li><a href="product3.php">Non-Coffee</a></li>
        <li><a href="product4.php">Hot Beverage</a></li>
      </ul>
    </li>
    <li class="dropdown">
      <span class="hover-underline"><a href="Blog.php">Blog ▾</a></span>
      <ul class="dropdown-content">
        <li><a href="coming_soon.php">Coming Soon</a></li>
        <li><a href="current_activity.php">Current Event</a></li>
        <li><a href="past_activity.php">Past Events</a></li>
      </ul>
    </li>
    <li><span class="hover-underline"><a href="joinus.php">Join Us</a></span></li>
    <li><span class="hover-underline"><a href="enquiry.php">Enquiry</a></span></li>
    <?php
    $role_id = $_SESSION['role_id'] ?? 0;
    $username = $_SESSION['username'] ?? null;
    ?>
    <?php if ($username): ?>
      <?php if ($role_id == 1): ?>
        <li><span class="hover-underline"><a href="admin_dashboard.php">ADMIN</a></span></li>
      <?php elseif (in_array($role_id, [2,3])): ?>
        <li><span class="hover-underline"><a href="admin_dashboard.php">View</a></span></li>
        <li><span class="hover-underline"><a href="membership.php"><?php echo htmlspecialchars($username); ?></a></span></li>
      <?php else: ?>
        <li><span class="hover-underline"><a href="membership.php"><?php echo htmlspecialchars($username); ?></a></span></li>
      <?php endif; ?>
    <?php else: ?>
      <li><span class="hover-underline"><a href="registration.php">Membership</a></span></li>
    <?php endif; ?>
    <?php if (isset($_SESSION['username'])): ?>
      <li><span class="hover-underline"><a href="logout.php">Logout</a></span></li>
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
        <?php if ($username): ?>
          <?php if ($role_id == 1): ?>
            <span class="hover-underline"><a href="admin_dashboard.php">View</a></span>
          <?php elseif (in_array($role_id, [2,3])): ?>
            <span class="hover-underline"><a href="admin_dashboard.php">View</a></span>
            <span class="hover-underline"><a href="membership.php"><?php echo htmlspecialchars($username); ?></a></span>
          <?php else: ?>
            <span class="hover-underline"><a href="membership.php"><?php echo htmlspecialchars($username); ?></a></span>
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