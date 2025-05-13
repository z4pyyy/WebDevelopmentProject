<?php
// Connect to DB
include 'connection.php';

// Fetch and sanitize input
$username = trim($_POST['username']);
$id_tag = trim($_POST['id_tag']);
$first_name = trim($_POST['first_name']);
$last_name = trim($_POST['last_name']);
$email = trim($_POST['email']);
$phone = trim($_POST['phone']);
$password = $_POST['password'];
$confirm_password = $_POST['confirm_password'];

// Basic server-side validation
$errors = [];

if ($password !== $confirm_password) {
    $errors[] = "Passwords do not match.";
}

if (!preg_match('/^#[0-9]{2}$/', $id_tag)) {
    $errors[] = "ID tag must begin with # followed by 2 digits.";
}

if (!empty($errors)) {
    foreach ($errors as $error) {
        echo "<p style='color:red;'>$error</p>";
    }
    echo "<p><a href='registration.php'>Go Back</a></p>";
    exit;
}

// Hash password for security
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Insert into DB
$sql = "INSERT INTO membership (login_id, id_tag, first_name, last_name, email, phone, password)
        VALUES (?, ?, ?, ?, ?, ?, ?)";

$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "sssssss", $username, $id_tag, $first_name, $last_name, $email, $phone, $hashed_password);

if (mysqli_stmt_execute($stmt)) {
    header("Location: thankyou_registration.php");
} else {
    echo "<p style='color:red;'>❌ Registration failed: " . mysqli_error($conn) . "</p>";
}

mysqli_stmt_close($stmt);
mysqli_close($conn);
?>
