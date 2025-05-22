<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "assignment2";

// Connect to MySQL
$conn = mysqli_connect($servername, $username, $password);
if (!$conn) die("Connection failed: " . mysqli_connect_error());

// Check if database exists
$db_check = mysqli_query($conn, "SHOW DATABASES LIKE '$dbname'");
if (mysqli_num_rows($db_check) === 0) {
    include 'setup.php';
} else {
    mysqli_select_db($conn, $dbname);

    $requiredTables = ['roles', 'membership', 'user', 'admin', 'job_application', 'enquiry', 'activities', 'categories', 'products'];
    $missing = [];

    foreach ($requiredTables as $table) {
        $check = mysqli_query($conn, "SHOW TABLES LIKE '$table'");
        if (mysqli_num_rows($check) === 0) {
            $missing[] = $table;
        }
    }

    if (!empty($missing)) {
        include 'setup.php'; // Re-run setup if any table is missing
    }
}

?>
