<?php
include 'connection.php';
session_start();

// 1. Fetch & sanitize input
$username   = trim($_POST['username']);
$first_name = trim($_POST['first_name']);
$last_name  = trim($_POST['last_name']);
$email      = trim($_POST['email']);
$phone      = trim($_POST['phone']);
$password   = $_POST['password'];
$confirm_password = $_POST['confirm_password'];
$errors = [];

// 2. Validation (exactly the same as registration)
if ($password !== $confirm_password) {
    $errors[] = "Passwords do not match.";
}
if (!preg_match('/^[A-Za-z]{3,}$/', $username)) {
    $errors[] = "Username must be letters only, minimum 3 characters.";
}
if (!preg_match('/^[A-Za-z]{2,}$/', $first_name)) {
    $errors[] = "First name must be at least 2 letters, letters only.";
}
if (!preg_match('/^[A-Za-z]{2,}$/', $last_name)) {
    $errors[] = "Last name must be at least 2 letters, letters only.";
}
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = "Invalid email format.";
}
if (!preg_match('/^[0-9]{8,15}$/', $phone)) {
    $errors[] = "Phone must be 8-15 digits only.";
}
if (strtolower($username) === 'admin' || strtolower($email) === 'admin' || strtolower($email) === 'admin@yourdomain.com') {
    $errors[] = "❌ Don't try to be an Admin, It won't work.";
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
    $_SESSION['add_member_errors'] = $errors;
    $_SESSION['add_member_input'] = $_POST;
    header("Location: add_member.php");
    exit;
}

// Insert into membership
$insert_membership_sql = "INSERT INTO membership (first_name, last_name, email, phone) VALUES (?, ?, ?, ?)";
$membership_stmt = mysqli_prepare($conn, $insert_membership_sql);
mysqli_stmt_bind_param($membership_stmt, "ssss", $first_name, $last_name, $email, $phone);

if (!mysqli_stmt_execute($membership_stmt)) {
    die("❌ Membership insert failed: " . mysqli_error($conn));
}

// Get inserted membership ID
$membership_id = mysqli_insert_id($conn);
if ($membership_id <= 0) {
    die("❌ Invalid membership ID returned.");
}

// Generate and update member_id (e.g., BNG-00001)
$formatted_id = 'BNG-' . str_pad($membership_id, 5, '0', STR_PAD_LEFT);
$update_id_sql = "UPDATE membership SET member_id = ? WHERE id = ?";
$update_stmt = mysqli_prepare($conn, $update_id_sql);
mysqli_stmt_bind_param($update_stmt, "si", $formatted_id, $membership_id);
mysqli_stmt_execute($update_stmt);

// Insert into user table
$hashed_password = password_hash($password, PASSWORD_DEFAULT);
$insert_user_sql = "INSERT INTO user (username, password, membership_id, role_id) VALUES (?, ?, ?, 4)";
$user_stmt = mysqli_prepare($conn, $insert_user_sql);
mysqli_stmt_bind_param($user_stmt, "ssi", $username, $hashed_password, $membership_id);

if (!mysqli_stmt_execute($user_stmt)) {
    die("❌ User insert failed: " . mysqli_error($conn));
}

// Confirmation page for admin
$_SESSION['added_member_username'] = $username;
header("Refresh: 3; URL=view_membership.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Member Added | Brew & Go Admin</title>
  <link rel="stylesheet" href="styles/style.css">
</head>
<body class="confirmation-page">
  <section class="thankyou-container">
    <div class="thankyou-box">
      <h1>✅ Member Added Successfully!</h1>
      <p>Account <strong><?= htmlspecialchars($username) ?></strong> has been created.</p>
      <p>You’ll be redirected to add another member shortly...</p>
      <div class="redirect-info">If not redirected, <a href="view_membership.php">click here</a>.</div>
    </div>
  </section>
</body>
</html>
<?php exit; ?>
