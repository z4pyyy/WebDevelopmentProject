<?php
session_start();

// Destroy all session data
$_SESSION = [];
session_unset();
session_destroy();

// Remove session cookie if set
if (ini_get("session.use_cookies")) {
    setcookie(session_name(), '', time() - 42000, '/');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="refresh" content="2;url=index.php">
  <title>Logged Out</title>
  <link rel="stylesheet" href="styles/style.css">
</head>
<body class="logout-body">
  <div class="logout-box">
    <h2>👋 You have been logged out.</h2>
    <p>Redirecting to homepage...</p>
  </div>
</body>
</html>
