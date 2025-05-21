<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "assignment2";

// Connect to MySQL
$conn = mysqli_connect($servername, $username, $password);
if (!$conn) {
    die("❌ Connection failed: " . mysqli_connect_error());
}
echo "✅ Connected to MySQL server.<br>";

// Create database
$sql = "CREATE DATABASE IF NOT EXISTS $dbname";
if (mysqli_query($conn, $sql)) {
    echo "✅ Database '$dbname' is ready.<br>";
} else {
    die("❌ Error creating database: " . mysqli_error($conn));
}

mysqli_select_db($conn, $dbname);
echo "✅ Selected database: $dbname<br>";

// Create roles table
$sql = "CREATE TABLE IF NOT EXISTS roles (
  id TINYINT PRIMARY KEY,
  name VARCHAR(50) UNIQUE NOT NULL
)";
echo mysqli_query($conn, $sql) ? "✅ Table 'roles' ready.<br>" : "❌ " . mysqli_error($conn);

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
  status ENUM('Active', 'Expired') DEFAULT 'Expired',
  registered_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";
echo mysqli_query($conn, $sql) ? "✅ Table 'membership' updated and ready.<br>" : "❌ " . mysqli_error($conn);




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
echo mysqli_query($conn, $sql) ? "✅ Table 'user' ready.<br>" : "❌ " . mysqli_error($conn);

// 3️⃣ ADMIN TABLE
$sql = "CREATE TABLE IF NOT EXISTS admin (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(50) UNIQUE NOT NULL,
  password VARCHAR(255) NOT NULL
)";
echo mysqli_query($conn, $sql) ? "✅ Table 'admin' ready.<br>" : "❌ " . mysqli_error($conn);

// Insert default admin (plain text 'admin')
$check_admin_sql = "SELECT id FROM admin WHERE LOWER(username) = 'admin'";
$check_admin_result = mysqli_query($conn, $check_admin_sql);
if (mysqli_num_rows($check_admin_result) === 0) {
    $insert_admin_sql = "INSERT INTO admin (username, password) VALUES ('admin', 'admin')";
    if (mysqli_query($conn, $insert_admin_sql)) {
        echo "✅ Default admin account created.<br>";
    } else {
        echo "❌ Failed to create default admin: " . mysqli_error($conn) . "<br>";
    }
} else {
    echo "ℹ️ Default admin already exists.<br>";
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
  submitted_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";
echo mysqli_query($conn, $sql) ? "✅ Table 'job_application' ready.<br>" : "❌ " . mysqli_error($conn);

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
  submitted_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";
echo mysqli_query($conn, $sql) ? "✅ Table 'enquiry' ready.<br>" : "❌ " . mysqli_error($conn);

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
echo mysqli_query($conn, $sql) ? "✅ Table 'activities' ready.<br>" : "❌ " . mysqli_error($conn);

// 7️⃣ PRODUCTS TABLE
$sql = "CREATE TABLE IF NOT EXISTS products (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(255) NOT NULL,
  description TEXT,
  price DECIMAL(10,2) NOT NULL,
  large_price DECIMAL(10,2) DEFAULT NULL,
  sku VARCHAR(100) UNIQUE,
  category VARCHAR(100),
  image_path VARCHAR(255),
  availability ENUM('Available', 'Unavailable') DEFAULT 'Available',
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;";

if (mysqli_query($conn, $sql)) {
    echo "✅ Table 'products' recreated.<br>";
} else {
    echo "❌ Error: " . mysqli_error($conn) . "<br>";
}

// 🔁 Insert predefined product list
$products = [
    // BASIC BREW
    ['Basic Brew', 'Americano', 8.90, 10.90, 'ice-americano.jpg'],
    ['Basic Brew', 'Latte', 10.90, 12.90, 'latte.jpg'],
    ['Basic Brew', 'Cappuccino', 11.90, 13.90, 'cappuccino.jpg'],
    ['Basic Brew', 'Aerocano', 10.90, 12.90, 'aerocano.jpg'],
    ['Basic Brew', 'Aero-latte', 12.90, 14.90, 'aero-latte.jpg'],

    // ARTISAN BREW
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

    // NON-COFFEE
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

    // HOT BEVERAGES
    ['Hot Beverages', 'Americano', 7.90, 9.90, 'hot-americano.jpg'],
    ['Hot Beverages', 'Latte', 9.90, 11.90, 'hot-latte.jpg'],
    ['Hot Beverages', 'Butterscotch Latte', 10.90, 12.90, 'hot-butterscotch-latte.jpg'],
    ['Hot Beverages', 'Cappuccino', 10.90, 12.90, 'cappuccino.jpg'],
    ['Hot Beverages', 'Chocolate', 12.90, 14.90, 'chocolate.jpg'],
    ['Hot Beverages', 'Yuri Matcha', 13.90, 15.90, 'yuri-matcha.jpg'],
    ['Hot Beverages', 'Houjicha', 13.90, 14.90, 'houjicha.jpg'],
];

// Prepared insert
foreach ($products as [$category, $name, $price, $large, $filename]) {
    $sku = strtoupper(str_replace(' ', '_', $category . '_' . $name));
    $escaped_name = mysqli_real_escape_string($conn, $name);
    $escaped_category = mysqli_real_escape_string($conn, $category);
    $image_path = mysqli_real_escape_string($conn, "images/" . $filename);

    $check = mysqli_query($conn, "SELECT id FROM products WHERE name = '$escaped_name' AND category = '$escaped_category'");
    if (mysqli_num_rows($check) === 0) {
        $insert = "
        INSERT INTO products (name, price, large_price, sku, category, image_path)
        VALUES ('$escaped_name', $price, $large, '$sku', '$escaped_category', '$image_path')";
        mysqli_query($conn, $insert);
    }
}
echo "✅ Product migration complete: menu items inserted.<br>";



// Close
mysqli_close($conn);
echo "✅ MySQL connection closed.<br>";
?>
