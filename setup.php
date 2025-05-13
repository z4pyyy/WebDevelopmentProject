<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "assignment2";

// Step 1: Connect to MySQL (no DB selected yet)
$conn = mysqli_connect($servername, $username, $password);
if (!$conn) {
    die("❌ Connection failed: " . mysqli_connect_error());
}
echo "✅ Connected to MySQL server.<br>";

// Step 2: Create database if not exists
$sql = "CREATE DATABASE IF NOT EXISTS $dbname";
if (mysqli_query($conn, $sql)) {
    echo "✅ Database '$dbname' is ready.<br>";
} else {
    die("❌ Error creating database: " . mysqli_error($conn));
}

// Step 3: Select the database
mysqli_select_db($conn, $dbname);
echo "✅ Selected database: $dbname<br>";

// USERS TABLE
$sql = "CREATE TABLE IF NOT EXISTS users (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(30) NOT NULL,
    password VARCHAR(30) NOT NULL
)";
echo mysqli_query($conn, $sql) ? "✅ Table 'users' ready.<br>" : "❌ " . mysqli_error($conn);

// Check and insert default admin user
$sql = "SELECT COUNT(*) as count FROM users";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
if ($row['count'] == 0) {
    $sql = "INSERT INTO users (username, password) VALUES ('admin', 'admin')";
    echo mysqli_query($conn, $sql) ? "✅ Default admin inserted.<br>" : "❌ Error inserting admin: " . mysqli_error($conn);
} else {
    echo "ℹ️ Admin already exists or users table is not empty.<br>";
}

// JOB APPLICATION TABLE
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

// ENQUIRY TABLE
$sql = "CREATE TABLE IF NOT EXISTS enquiry (
    id INT AUTO_INCREMENT PRIMARY KEY,
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

// MEMBERSHIP TABLE
$sql = "CREATE TABLE IF NOT EXISTS membership (
    id INT AUTO_INCREMENT PRIMARY KEY,
    login_id VARCHAR(50) NOT NULL,
    id_tag VARCHAR(20) NOT NULL,
    first_name VARCHAR(100) NOT NULL,
    last_name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    phone VARCHAR(20),
    password VARCHAR(255) NOT NULL,
    registered_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";
echo mysqli_query($conn, $sql) ? "✅ Table 'membership' ready.<br>" : "❌ " . mysqli_error($conn);

// Close DB connection
mysqli_close($conn);
echo "✅ MySQL connection closed.<br>";
?>
