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

if (strtolower($username) === 'admin' || strtolower($email) === 'admin' || strtolower($email) === 'admin@yourdomain.com') {
    echo "❌ Dont try to be an Admin, It wont work";
    exit;
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

// 1. Insert into membership
$insert_membership_sql = "INSERT INTO membership (first_name, last_name, email, phone) VALUES (?, ?, ?, ?)";
$membership_stmt = mysqli_prepare($conn, $insert_membership_sql);
mysqli_stmt_bind_param($membership_stmt, "ssss", $first_name, $last_name, $email, $phone);

if (!mysqli_stmt_execute($membership_stmt)) {
    die("❌ Membership insert failed: " . mysqli_error($conn));
}

// 2. Get inserted membership ID once
$membership_id = mysqli_insert_id($conn);
if ($membership_id <= 0) {
    die("❌ Invalid membership ID returned.");
}

// 3. Generate and update member_id (e.g., BNG-00001)
$formatted_id = 'BNG-' . str_pad($membership_id, 5, '0', STR_PAD_LEFT);
$update_id_sql = "UPDATE membership SET member_id = ? WHERE id = ?";
$update_stmt = mysqli_prepare($conn, $update_id_sql);
mysqli_stmt_bind_param($update_stmt, "si", $formatted_id, $membership_id);
mysqli_stmt_execute($update_stmt); // This is fine AFTER insert_id()

// 4. Insert into user table
$hashed_password = password_hash($password, PASSWORD_DEFAULT);
$insert_user_sql = "INSERT INTO user (username, password, membership_id, role_id) VALUES (?, ?, ?, 4)";
$user_stmt = mysqli_prepare($conn, $insert_user_sql);
mysqli_stmt_bind_param($user_stmt, "ssi", $username, $hashed_password, $membership_id);

if (!mysqli_stmt_execute($user_stmt)) {
    die("❌ User insert failed: " . mysqli_error($conn));
}


// 6. Inline confirmation screen
$_SESSION['registered_user'] = $username;
header("Refresh: 3; URL=login.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Registration Success | Brew & Go</title>
  <link rel="stylesheet" href="styles/style.css">
</head>
<body class="confirmation-page">
  <section class="thankyou-container">
    <div class="thankyou-box">
      <h1>🎉 Registration Successful!</h1>
      <p>Welcome, <strong><?= htmlspecialchars($username) ?></strong>!</p>
      <p>You’ll be redirected to the login page shortly...</p>
      <div class="redirect-info">If not redirected, <a href="login.php">click here</a>.</div>
    </div>
  </section>
</body>
</html>
<?php exit; ?>
