<?php
session_start();
include 'connection.php';

$username = trim($_POST['username']);
$password = $_POST['password'];

$sql = "SELECT id, password FROM user WHERE username = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "s", $username);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if ($row = mysqli_fetch_assoc($result)) {
    $hashed_password = $row['password'];

    if (password_verify($password, $hashed_password)) {
        // ✅ Login success — set session
        $_SESSION['user_id'] = $row['id'];
        $_SESSION['username'] = $username;

        // ✅ Show success and redirect to index.php
        echo <<<HTML
        <!DOCTYPE html>
        <html lang="en">
        <head>
          <meta charset="UTF-8">
          <meta http-equiv="refresh" content="2;url=index.php">
          <title>Login Successful</title>
          <style>
            body {
              font-family: 'Outfit', sans-serif;
              text-align: center;
              padding-top: 100px;
              background-color: #f8f8f8;
            }
            .box {
              background: white;
              display: inline-block;
              padding: 40px;
              border-radius: 10px;
              box-shadow: 0 8px 24px rgba(0,0,0,0.15);
            }
          </style>
        </head>
        <body>
          <div class="box">
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

// ❌ Login failed — redirect back to login with a message
$_SESSION['login_error'] = "Invalid Login ID or Password.";
header("Location: login.php");
exit;
