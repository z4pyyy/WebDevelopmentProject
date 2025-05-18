<?php
include 'connection.php';
session_start();

// 1. Fetch & sanitize input
$username = trim($_POST['username']);
$first_name = trim($_POST['first_name']);
$last_name = trim($_POST['last_name']);
$email = trim($_POST['email']);
$phone = trim($_POST['phone']);
$password = $_POST['password'];
$confirm_password = $_POST['confirm_password'];

$errors = [];

// 2. Validation
if ($password !== $confirm_password) {
    $errors[] = "Passwords do not match.";
}

if (!preg_match('/^[A-Za-z]{3,}$/', $username)) {
    $errors[] = "Username must be letters only, minimum 3 characters.";
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = "Invalid email format.";
}

// Check if username already exists
$check_user_sql = "SELECT id FROM user WHERE username = ?";
$check_user_stmt = mysqli_prepare($conn, $check_user_sql);
mysqli_stmt_bind_param($check_user_stmt, "s", $username);
mysqli_stmt_execute($check_user_stmt);
$user_result = mysqli_stmt_get_result($check_user_stmt);
if (mysqli_fetch_assoc($user_result)) {
    $errors[] = "Username '$username' is already taken.";
}

// Check if email exists
$check_email_sql = "SELECT id FROM membership WHERE email = ?";
$check_email_stmt = mysqli_prepare($conn, $check_email_sql);
mysqli_stmt_bind_param($check_email_stmt, "s", $email);
mysqli_stmt_execute($check_email_stmt);
$email_result = mysqli_stmt_get_result($check_email_stmt);
if (mysqli_fetch_assoc($email_result)) {
    $errors[] = "Email '$email' is already registered.";
}

// Check if phone exists
$check_phone_sql = "SELECT id FROM membership WHERE phone = ?";
$check_phone_stmt = mysqli_prepare($conn, $check_phone_sql);
mysqli_stmt_bind_param($check_phone_stmt, "s", $phone);
mysqli_stmt_execute($check_phone_stmt);
$phone_result = mysqli_stmt_get_result($check_phone_stmt);
if (mysqli_fetch_assoc($phone_result)) {
    $errors[] = "Phone '$phone' is already registered.";
}

// 3. Handle errors
if (!empty($errors)) {
    $_SESSION['registration_errors'] = $errors;
    $_SESSION['registration_input'] = $_POST;
    header("Location: registration.php");
    exit;
}

// 4. Insert into `membership` table
$insert_membership_sql = "INSERT INTO membership (first_name, last_name, email, phone) VALUES (?, ?, ?, ?)";
$membership_stmt = mysqli_prepare($conn, $insert_membership_sql);
mysqli_stmt_bind_param($membership_stmt, "ssss", $first_name, $last_name, $email, $phone);
mysqli_stmt_execute($membership_stmt);

// Get the inserted membership ID
$membership_id = mysqli_insert_id($conn);

// 5. Insert into `user` table (hashed password)
$hashed_password = password_hash($password, PASSWORD_DEFAULT);
$insert_user_sql = "INSERT INTO user (username, password, membership_id, role) VALUES (?, ?, ?, 4)";
$user_stmt = mysqli_prepare($conn, $insert_user_sql);
mysqli_stmt_bind_param($user_stmt, "ssi", $username, $hashed_password, $membership_id);
mysqli_stmt_execute($user_stmt);

// 6. Redirect
header("Location: thankyou_registration.php");
exit;
?>
