<?php
// Load DB credentials first
$db_user   = getenv('DB_USER') ?: 'root';
$db_pass   = getenv('DB_PASS') ?: '';
$db_name   = getenv('DB_NAME') ?: 'developmentdb';
$db_socket = getenv('DB_SOCKET');

// Check socket
if (!$db_socket || !file_exists($db_socket)) {
    die("❌ Cloud SQL socket not found at: $db_socket");
}

// Connect via socket
$mysqli = new mysqli(null, $db_user, $db_pass, $db_name, null, $db_socket);
if ($mysqli->connect_error) {
    die("❌ Connection failed: " . $mysqli->connect_error);
}
$conn = $mysqli;

echo "✅ Connected to Cloud SQL via socket and using database '$db_name'.<br>";

// Create roles table
$sql = "CREATE TABLE IF NOT EXISTS roles (
  id TINYINT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(50) UNIQUE NOT NULL
)";
mysqli_query($conn, $sql) ? "✅ Table 'roles' ready.<br>" : "❌ " . mysqli_error($conn);

// Insert roles
$roles = [1 => 'admin', 2 => 'operator', 3 => 'staff', 4 => 'user'];
foreach ($roles as $id => $name) {
    $check = mysqli_query($conn, "SELECT id FROM roles WHERE id = $id");
    if (mysqli_num_rows($check) === 0) {
        mysqli_query($conn, "INSERT INTO roles (id, name) VALUES ($id, '$name')");
    }
}

// 1️⃣ MEMBERSHIP TABLE
$sql = "CREATE TABLE IF NOT EXISTS membership (
  id INT AUTO_INCREMENT PRIMARY KEY,
  member_id VARCHAR(10) UNIQUE,
  first_name VARCHAR(100) NOT NULL,
  last_name VARCHAR(100) NOT NULL,
  email VARCHAR(100) UNIQUE NOT NULL,
  phone VARCHAR(20) UNIQUE,
  address TEXT DEFAULT NULL,
  sex VARCHAR(10) DEFAULT NULL,
  nationality VARCHAR(50) DEFAULT NULL,
  wallet DECIMAL(10,2) DEFAULT 0.00,
  points INT DEFAULT 0,
  profile_picture VARCHAR(255) DEFAULT NULL,
  status ENUM('Active', 'Inactive') DEFAULT 'Inactive',
  registered_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";
mysqli_query($conn, $sql) ? "✅ Table 'membership' updated and ready.<br>" : "❌ " . mysqli_error($conn);




// 2️⃣ USER TABLE (Login credentials)
$sql = "CREATE TABLE IF NOT EXISTS user (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(50) UNIQUE NOT NULL,
  password VARCHAR(255) NOT NULL,
  membership_id INT,
  role_id TINYINT DEFAULT 4,
  FOREIGN KEY (membership_id) REFERENCES membership(id) ON DELETE CASCADE,
  FOREIGN KEY (role_id) REFERENCES roles(id)
)";
mysqli_query($conn, $sql) ? "✅ Table 'user' ready.<br>" : "❌ " . mysqli_error($conn);

// 3️⃣ ADMIN TABLE
$sql = "CREATE TABLE IF NOT EXISTS admin (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(50) UNIQUE NOT NULL,
  password VARCHAR(255) NOT NULL
)";
mysqli_query($conn, $sql) ? "✅ Table 'admin' ready.<br>" : "❌ " . mysqli_error($conn);

// Insert default admin (plain text 'admin')
$check_admin_sql = "SELECT id FROM admin WHERE LOWER(username) = 'admin'";
$check_admin_result = mysqli_query($conn, $check_admin_sql);
if (mysqli_num_rows($check_admin_result) === 0) {
    $insert_admin_sql = "INSERT INTO admin (username, password) VALUES ('admin', 'admin')";
    if (mysqli_query($conn, $insert_admin_sql)) {
        // echo "✅ Default admin account created.<br>";
    } else {
        echo "❌ Failed to create default admin: " . mysqli_error($conn) . "<br>";
    }
} else {
    // echo "ℹ️ Default admin already exists.<br>";
}

// 4️⃣ JOB APPLICATION TABLE
$sql = "CREATE TABLE IF NOT EXISTS job_application (
  id INT AUTO_INCREMENT PRIMARY KEY,
  first_name VARCHAR(100) NOT NULL,
  last_name VARCHAR(100) NOT NULL,
  email VARCHAR(100) NOT NULL,
  phone VARCHAR(20),
  preferred_shift VARCHAR(50),
  address TEXT,
  postcode VARCHAR(10),
  city VARCHAR(100),
  state VARCHAR(100),
  photo_path VARCHAR(255),
  cv_path VARCHAR(255),
  status ENUM('Pending', 'Accepted', 'Rejected') NOT NULL DEFAULT 'Pending',
  submitted_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";
mysqli_query($conn, $sql) ? "✅ Table 'job_application' ready.<br>" : "❌ " . mysqli_error($conn);

// 5️⃣ ENQUIRY TABLE
$sql = "CREATE TABLE IF NOT EXISTS enquiry (
  id INT AUTO_INCREMENT PRIMARY KEY,
  ticket_id VARCHAR(20) UNIQUE,
  first_name VARCHAR(100) NOT NULL,
  last_name VARCHAR(100) NOT NULL,
  email VARCHAR(100) NOT NULL,
  phone VARCHAR(20),
  address TEXT,
  postcode VARCHAR(10),
  city VARCHAR(100),
  state VARCHAR(100),
  enquiry_type VARCHAR(100),
  message TEXT,
  status ENUM('Pending', 'In Progress', 'Resolved') DEFAULT 'Pending',
  submitted_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";
mysqli_query($conn, $sql) ? "✅ Table 'enquiry' ready.<br>" : "❌ " . mysqli_error($conn);

// 6️⃣ ACTIVITIES TABLE
$sql = "CREATE TABLE IF NOT EXISTS activities (
  id INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(255) NOT NULL,
  description TEXT,
  image_path VARCHAR(255),
  event_date DATE,
  start_time TIME,
  end_time TIME,
  location VARCHAR(255),
  external_link VARCHAR(255),
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";
mysqli_query($conn, $sql) ? "✅ Table 'activities' ready.<br>" : "❌ " . mysqli_error($conn);

$check = mysqli_query($conn, "SELECT COUNT(*) AS count FROM activities");
$count_row = mysqli_fetch_assoc($check);
if (intval($count_row['count']) === 0) {

    // --- Coming Soon Activities (event_date in 2026) ---
    $coming_soon = [
        [
            'title' => "What's New? (Mini Seni Kita: Open haus)",
            'description' => "Get your fuel satisfied with the perfect brew! ☕️✨ Meet @brewngo.coffee, where quality coffee meets exceptional flavour. Whether you’re on the go or looking to savour every sip, their caffeine creations are here to satisfy your coffee cravings like never before ☕️ #coffeelover #supportlocal #caffeine\n\nMini Seni Kita: Open haus\n📍 HAUS KCH, Yun Phin Building\n📆 29 March 2026\n🕒 3.00pm - 10.00pm\n🔥 All ages welcome – let’s have fun!\n🌟 It’s free entry!\n\nFollow for more updates and releases (*^ω^)! @senikitakch @hauskch",
            'image_path' => "images/ComingSoon1.png",
            'event_date' => "2026-03-29",
            'start_time' => "15:00:00",
            'end_time' => "22:00:00",
            'location' => "HAUS KCH, Yun Phin Building",
            'external_link' => "https://www.instagram.com/p/DHXgoi2vMe_/?img_index=1"
        ],
        [
            'title' => "Current Promo: Free Drink + Voucher",
            'description' => "(Change to today date)🎉 Get 1 free drink and 1 RM10 voucher if you topup with a minimum of RM50! Available only at our Plaza Merdeka outlet. Limited time offer!",
            'image_path' => "images/Current.jpg", 
            'event_date' => "2026-04-10",
            'start_time' => "00:00",
            'end_time' => "23:59",
            'location' => "Plaza Merdeka",
            'external_link' => "https://www.facebook.com/share/p/15QWjDkuAL/"
        ]
    ];

    // --- Past Activities (event_date in 2024) ---
    $past_activities = [
        [
            'title' => "24th January 2024 - FREE ORANGES",
            'description' => "FREE ORANGES!!! 🍊🧧🪭\nRedeem free oranges from us when you purchase 2 drinks & more. Starting from Saturday 25/1 and while stocks last. Come come!!",
            'image_path' => "images/Past1.jpg",
            'event_date' => "2024-01-24",
            'start_time' => "00:00",
            'end_time' => "23:59",
            'location' => "All outlets",
            'external_link' => "https://www.facebook.com/share/p/1AXJ2yhYcx/"
        ],
        [
            'title' => "28th October 2024 - 11% OFF Thursdays",
            'description' => "Enjoy 11% OFF on your total bill, every Thursday! ☕️",
            'image_path' => "images/Past2.jpg",
            'event_date' => "2024-10-28",
            'start_time' => "00:00",
            'end_time' => "23:59",
            'location' => "All outlets",
            'external_link' => "https://www.facebook.com/share/p/15ownGyQ5r/"
        ],
        [
            'title' => "9th September 2024 - Grabfood 50% Off",
            'description' => "Lazy to go out?\nOrder from us on Grabfood and get it delivered right at your door step! ☕️\nGet up to 50% off too!",
            'image_path' => "images/Past3.jpg",
            'event_date' => "2024-09-09",
            'start_time' => "00:00",
            'end_time' => "23:59",
            'location' => "Online / Grabfood",
            'external_link' => "https://www.facebook.com/share/p/1AEvFEc2tA/"
        ],
        [
            'title' => "4th April 2024 - Coffee Cart @ One Jaya",
            'description' => "We’re excited to announce that our cozy little coffee cart is now open for all the coffee drinkers community!\nLocation: Main entrance of One Jaya\nOpening hours: Saturday to Thursday 9am-6pm, close on Friday",
            'image_path' => "images/Past4.jpg",
            'event_date' => "2024-04-04",
            'start_time' => "00:00",
            'end_time' => "23:59",
            'location' => "Main entrance of One Jaya",
            'external_link' => "https://www.facebook.com/share/p/12H4yxZbY8g/"
        ],
        [
            'title' => "28th March 2024 - Grand Opening Coffee Cart",
            'description' => "Finally.. the wait is over!\nJoin us at the Grand Opening of our Coffee Cart this Saturday, 30th March 2024 at 9am onwards!\nStand a chance to get our free goodie bag for the first 50 customers!!",
            'image_path' => "images/Past5.jpg",
            'event_date' => "2024-03-28",
            'start_time' => "00:00",
            'end_time' => "23:59",
            'location' => "Coffee Cart, One Jaya",
            'external_link' => "https://www.facebook.com/share/p/15xobh7QwJ/"
        ],
        [
            'title' => "1st February 2024 - Team is Growing!",
            'description' => "🧧开工大吉🧧 we’re grateful that our team is slowly growing, and we’re determined to serve you at our very best! Come visit us from 9am-6pm daily!",
            'image_path' => "images/CNYOPENING.png",
            'event_date' => "2024-02-01",
            'start_time' => "00:00",
            'end_time' => "23:59",
            'location' => "All outlets",
            'external_link' => "https://www.instagram.com/p/DFg4hlxvOxg/?img_index=1"
        ]
    ];

    // Insert function
    function insert_activity($conn, $data) {
        $sql = "INSERT INTO activities 
            (title, description, image_path, event_date, start_time, end_time, location, external_link)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param(
            $stmt, "ssssssss",
            $data['title'], $data['description'], $data['image_path'], $data['event_date'],
            $data['start_time'], $data['end_time'], $data['location'], $data['external_link']
        );
        $ok = mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        return $ok;
    }

    $inserted = 0;
    foreach ($coming_soon as $a) { $inserted += insert_activity($conn, $a) ? 1 : 0; }
    foreach ($past_activities as $a) { $inserted += insert_activity($conn, $a) ? 1 : 0; }

} else {
    // Table already has data
    // echo "<i>Activities already populated.</i>";
}

// 7️⃣ CATEGORY TABLE
$sql = "CREATE TABLE IF NOT EXISTS categories (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) UNIQUE NOT NULL
)";
mysqli_query($conn, $sql) ? "✅ Table 'categories' ready.<br>" : "❌ " . mysqli_error($conn);

// 8️⃣ PRODUCTS TABLE
$sql = "CREATE TABLE IF NOT EXISTS products (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(255) NOT NULL,
  description TEXT,
  price DECIMAL(10,2) NOT NULL,
  large_price DECIMAL(10,2) DEFAULT NULL,
  sku VARCHAR(100) UNIQUE,
  category_id INT,
  image_path VARCHAR(255),
  availability ENUM('Available', 'Unavailable') DEFAULT 'Available',
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE SET NULL
) ENGINE=InnoDB";
mysqli_query($conn, $sql) ? "✅ Table 'products' (with category_id) ready.<br>" : "❌ " . mysqli_error($conn);

// 9️⃣ Populate categories
$categoryList = ['Basic Brew', 'Artisan Brew', 'Non-Coffee', 'Hot Beverages'];
foreach ($categoryList as $cat) {
    $cat_escaped = mysqli_real_escape_string($conn, $cat);
    $check = mysqli_query($conn, "SELECT id FROM categories WHERE name = '$cat_escaped'");
    if (mysqli_num_rows($check) === 0) {
        mysqli_query($conn, "INSERT INTO categories (name) VALUES ('$cat_escaped')");
    }
}

// 1️⃣0️⃣ NEWSLETTER SUBSCRIBERS TABLE
$sql = "CREATE TABLE IF NOT EXISTS newsletter_subscribers (
  id INT AUTO_INCREMENT PRIMARY KEY,
  email VARCHAR(255) NOT NULL UNIQUE,
  subscribed_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";
mysqli_query($conn, $sql) ? "✅ Table 'newsletter_subscribers' ready.<br>" : "❌ " . mysqli_error($conn);

// 1️⃣1️⃣ NEWSLETTER HISTORY TABLE
$sql = "CREATE TABLE IF NOT EXISTS newsletter_history (
  id INT AUTO_INCREMENT PRIMARY KEY,
  subject VARCHAR(255) NOT NULL,
  body TEXT NOT NULL,
  attachment_path VARCHAR(255) DEFAULT NULL,
  sent_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";
mysqli_query($conn, $sql) ? "✅ Table 'newsletter_history' ready.<br>" : "❌ " . mysqli_error($conn);

// 1️⃣2️⃣ PAGE PERMISSIONS TABLE
$sql = "CREATE TABLE IF NOT EXISTS page_permissions (
  id INT AUTO_INCREMENT PRIMARY KEY,
  page VARCHAR(100) NOT NULL,
  role_id TINYINT NOT NULL,
  can_view TINYINT(1) NOT NULL DEFAULT 1,
  UNIQUE KEY unique_page_role (page, role_id),
  FOREIGN KEY (role_id) REFERENCES roles(id) ON DELETE CASCADE
)";
mysqli_query($conn, $sql) ? "✅ Table 'page_permissions' ready.<br>" : "❌ " . mysqli_error($conn);

// Optionally, insert example permissions (customize as needed)
$page_perms = [
    // page => [list of role ids who CAN view]
    'admin_dashboard.php' => [1, 2, 3],    // admin, operator, staff
    'view_activity.php' => [1, 2, 3],  // admin, operator, staff
    'view_enquiry.php' => [1, 2, 3],   // admin, operator, staff
    'view_job.php'     => [1, 2],      // admin, operator only
    'view_membership.php' => [1, 2],   // admin, operator only
    'view_newsletter.php' => [1, 2],   // admin, operator only
    'view_product.php' => [1, 2, 3],   // admin, operator, staff
    'view_role.php' => [1],         // admin only
    'view_subscriber.php' => [1, 2], // admin, operator only
    'view_permissions.php' => [1, 2], // admin only

    'add_activity.php' => [1, 2], // admin, operator only
    'add_category.php' => [1, 2], // admin, operator only
    'add_member.php' => [1, 2], // admin, operator only
    'add_product.php'  => [1, 2], // admin, operator only
    'add_role.php' => [1], // admin only

    'edit_activity.php' => [1, 2], // admin, operator only
    'edit_category.php' => [1, 2], // admin, operator only
    'edit_member.php' => [1, 2], // admin, operator only
    'edit_product.php'  => [1, 2], // admin, operator only
    'edit_role.php' => [1], // admin only
];
foreach ($page_perms as $page => $roles) {
    $role_ids = [];
      $res = mysqli_query($conn, "SELECT id FROM roles");
      while ($r = mysqli_fetch_assoc($res)) $role_ids[] = $r['id'];
      foreach ($role_ids as $role_id) {
        $can_view = in_array($role_id, $roles) ? 1 : 0;
        $check = mysqli_query($conn, "SELECT id FROM page_permissions WHERE page='$page' AND role_id=$role_id");
        if (mysqli_num_rows($check) === 0) {
            mysqli_query($conn, "INSERT INTO page_permissions (page, role_id, can_view) VALUES ('$page', $role_id, $can_view)");
        }
    }
}
// echo "✅ Page permissions seeded.<br>";

// 🔁 Populate products
$products = [
    // [category name, product name, price, large price, image file]
    ['Basic Brew', 'Americano', 8.90, 10.90, 'ice-americano.jpg'],
    ['Basic Brew', 'Latte', 10.90, 12.90, 'latte.jpg'],
    ['Basic Brew', 'Cappuccino', 11.90, 13.90, 'cappuccino.jpg'],
    ['Basic Brew', 'Aerocano', 10.90, 12.90, 'aerocano.jpg'],
    ['Basic Brew', 'Aero-latte', 12.90, 14.90, 'aero-latte.jpg'],

    ['Artisan Brew', 'Butterscotch Creme', 14.90, 16.90, 'butterscotch-creme.jpg'],
    ['Artisan Brew', 'Butterscotch Latte', 11.90, 13.90, 'butterscotch-latte.jpg'],
    ['Artisan Brew', 'Mint Latte', 12.90, 14.90, 'mint-latte.jpg'],
    ['Artisan Brew', 'Vienna Latte', 14.90, 16.90, 'vienna-latte.jpg'],
    ['Artisan Brew', 'Pistachio Latte', 15.90, 17.90, 'pistachio-latte.jpg'],
    ['Artisan Brew', 'Strawberry Latte', 14.90, 16.90, 'strawberry-latte.jpg'],
    ['Artisan Brew', 'Mocha', 11.90, 13.90, 'mocha.jpg'],
    ['Artisan Brew', 'Mint Mocha', 12.90, 14.90, 'mint-mocha.jpg'],
    ['Artisan Brew', 'Orange Mocha', 12.90, 14.90, 'orange-mocha.jpg'],
    ['Artisan Brew', 'Yuzu Americano', 13.90, 15.90, 'yuzu-americano.jpg'],
    ['Artisan Brew', 'Cheese Americano', 13.90, 15.90, 'cheese-americano.jpg'],
    ['Artisan Brew', 'Orange Americano', 13.90, 15.90, 'orange-americano.jpg'],

    ['Non-Coffee', 'Chocolate', 13.90, 15.90, 'chocolate.jpg'],
    ['Non-Coffee', 'Mint Chocolate', 13.90, 15.90, 'mint-chocolate.jpg'],
    ['Non-Coffee', 'Orange Chocolate', 13.90, 15.90, 'orange-chocolate.jpg'],
    ['Non-Coffee', 'Yuzu Soda', 13.90, 15.90, 'yuzu-soda.jpg'],
    ['Non-Coffee', 'Strawberry Soda', 13.90, 15.90, 'strawberry-mocha.jpg'],
    ['Non-Coffee', 'Yuzu Cheese', 13.90, 15.90, 'yuzu-cheese.jpg'],
    ['Non-Coffee', 'Yuri Matcha', 13.90, 15.90, 'yuri-matcha.jpg'],
    ['Non-Coffee', 'Strawberry Matcha', 14.90, 16.90, 'strawberry-matcha.jpg'],
    ['Non-Coffee', 'Yuzu Matcha', 14.90, 16.90, 'yuzu-matcha.jpg'],
    ['Non-Coffee', 'Houjicha', 13.90, 15.90, 'houjicha.jpg'],

    ['Hot Beverages', 'Americano', 7.90, 9.90, 'hot-americano.jpg'],
    ['Hot Beverages', 'Latte', 9.90, 11.90, 'hot-latte.jpg'],
    ['Hot Beverages', 'Butterscotch Latte', 10.90, 12.90, 'hot-butterscotch-latte.jpg'],
    ['Hot Beverages', 'Cappuccino', 10.90, 12.90, 'cappuccino.jpg'],
    ['Hot Beverages', 'Chocolate', 12.90, 14.90, 'chocolate.jpg'],
    ['Hot Beverages', 'Yuri Matcha', 13.90, 15.90, 'yuri-matcha.jpg'],
    ['Hot Beverages', 'Houjicha', 13.90, 14.90, 'houjicha.jpg'],
];

// ✅ Prepared insert with category_id lookup
foreach ($products as [$category, $name, $price, $large, $filename]) {
    $sku = strtoupper(str_replace(' ', '_', $category . '_' . $name));
    $escaped_name = mysqli_real_escape_string($conn, $name);
    $escaped_category = mysqli_real_escape_string($conn, $category);
    $image_path = mysqli_real_escape_string($conn, "images/" . $filename);

    // Fetch category_id
    $cat_result = mysqli_query($conn, "SELECT id FROM categories WHERE name = '$escaped_category'");
    $cat_row = mysqli_fetch_assoc($cat_result);
    $category_id = $cat_row['id'] ?? 'NULL';

    $check = mysqli_query($conn, "SELECT id FROM products WHERE name = '$escaped_name' AND category_id = $category_id");
    if (mysqli_num_rows($check) === 0) {
        $insert = "
        INSERT INTO products (name, price, large_price, sku, category_id, image_path)
        VALUES ('$escaped_name', $price, $large, '$sku', $category_id, '$image_path')";
        mysqli_query($conn, $insert);
    }
}
// echo "✅ Product migration complete: menu items inserted.<br>";


// Close
mysqli_close($conn);
// echo "✅ MySQL connection closed.<br>";
?>
