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

// Close
mysqli_close($conn);
echo "✅ MySQL connection closed.<br>";
?>
