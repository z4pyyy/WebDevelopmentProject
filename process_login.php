<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include 'connection.php';

$username = trim($_POST['username'] ?? '');
$password = $_POST['password'] ?? '';

// 🛡 Validate input
if (empty($username) || empty($password)) {
    $_SESSION['login_error'] = "Please enter both username and password.";
    header("Location: login.php");
    exit;
}

// 🔐 Check for admin login
if (strtolower($username) === 'admin') {
    $admin_sql = "SELECT id, password FROM admin WHERE LOWER(username) = ?";
    $admin_stmt = mysqli_prepare($conn, $admin_sql);
    mysqli_stmt_bind_param($admin_stmt, "s", $username);
    mysqli_stmt_execute($admin_stmt);
    $admin_result = mysqli_stmt_get_result($admin_stmt);

    if ($admin = mysqli_fetch_assoc($admin_result)) {
        if (strtolower($password) === strtolower($admin['password'])) {
            // ✅ Admin login success
            $_SESSION['admin_id'] = $admin['id'];
            $_SESSION['role'] = 'admin';
            $_SESSION['role_id'] = 1;
            $_SESSION['username'] = 'admin';

            display_login_success("👑 Welcome, Admin!", "You are now logged in as administrator.", "admin_dashboard.php");
        }
    }

    // ❌ Admin login fail
    $_SESSION['login_error'] = "Invalid admin credentials.";
    header("Location: login.php");
    exit;
}

// 🔍 Normal user login
$sql = "SELECT id, password, role_id FROM user WHERE username = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "s", $username);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if ($user = mysqli_fetch_assoc($result)) {
    if (password_verify($password, $user['password'])) {
        // ✅ User login success
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $username;
        $_SESSION['role_id'] = $user['role_id'];
        $_SESSION['role'] = 'user';

        display_login_success("✅ Welcome, $username!", "You are now logged in.", "membership.php");
    }
}

// ❌ General login fail
$_SESSION['login_error'] = "Invalid Login ID or Password.";
header("Location: login.php");
exit;


// 🔄 Login Success Display Function
function display_login_success($title, $message, $redirect_url) {
    echo <<<HTML
    <!DOCTYPE html>
    <html lang="en">
    <head>
      <meta charset="UTF-8">
      <meta http-equiv="refresh" content="2;url={$redirect_url}">
      <link rel="stylesheet" href="styles/style.css">
      <title>Login Success</title>
    </head>
    <body class="login-confirm-body">
      <div class="login-confirm-box">
        <h2>{$title}</h2>
        <p>{$message}</p>
        <p>Redirecting...</p>
      </div>
    </body>
    </html>
    HTML;
    exit;
}
?>
