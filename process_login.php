<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include 'connection.php';
$username = trim($_POST['username']);
$password = $_POST['password'];

// 🔍 Special handling for admin login
if (strtolower($username) === 'admin'){
    $lower_admin = strtolower($username);
    $admin_sql = "SELECT id, password FROM admin WHERE LOWER(username) = ?";
    $admin_stmt = mysqli_prepare($conn, $admin_sql);
    mysqli_stmt_bind_param($admin_stmt, "s", $lower_admin);
    mysqli_stmt_execute($admin_stmt);
    $admin_result = mysqli_stmt_get_result($admin_stmt);

    if ($admin_row = mysqli_fetch_assoc($admin_result)) {
        if (strtolower($password) === strtolower($admin_row['password'])) {
            // ✅ Admin login success
            $_SESSION['admin_id'] = $admin_row['id'];
            $_SESSION['role'] = 'admin';
            $_SESSION['role_id'] = 1;
            $_SESSION['username'] = 'admin';

            echo <<<HTML
              <!DOCTYPE html>
              <html lang="en">
              <head>
                <meta charset="UTF-8">
                <meta http-equiv="refresh" content="2;url=admin_dashboard.php">
                <title>Admin Login</title>
                <link rel="stylesheet" href="styles/style.css">
              </head>
              <body class="login-confirm-body">
                <div class="login-confirm-box">
                  <h2>👑 Welcome, Admin!</h2>
                  <p>You are now logged in as an administrator.</p>
                  <p>Redirecting to dashboard...</p>
                </div>
              </body>
              </html>
              HTML;
            exit;
        }
    }

    // ❌ Admin login failed
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

if ($row = mysqli_fetch_assoc($result)) {
    if (password_verify($password, $row['password'])) {
        // ✅ User login success
        $_SESSION['user_id'] = $row['id'];
        $_SESSION['username'] = $username;
        $_SESSION['role'] = 'user';

        echo <<<HTML
          <!DOCTYPE html>
          <html lang="en">
          <head>
            <meta charset="UTF-8">
            <meta http-equiv="refresh" content="2;url=admin_dashboard.php">
            <title>Admin Login</title>
            <link rel="stylesheet" href="styles/style.css">
          </head>
          <body class="login-confirm-body">
            <div class="login-confirm-box">
            <h2>✅ Welcome, {$username}!</h2>
            <p>You are now logged in.</p>
            <p>Redirecting to homepage...</p>
          </div>
        </body>
        </html>
        HTML;
        exit;
    }
}

// ❌ General login failure
$_SESSION['login_error'] = "Invalid Login ID or Password.";
header("Location: login.php");
exit;
