<?php
session_start();

// Assume user was just registered and logged in here
// If needed, set session variables during registration:
// $_SESSION['user_id'] = $new_user_id;
// $_SESSION['username'] = $merged_username;

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="refresh" content="3;url=index.php">
  <title>Welcome to Brew & Go!</title>
  <style>
    body {
      font-family: 'Outfit', sans-serif;
      background-color: #f8f8f8;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
    }

    .thankyou-box {
      background-color: white;
      border-radius: 12px;
      padding: 40px 30px;
      box-shadow: 0 8px 20px rgba(0,0,0,0.15);
      text-align: center;
      max-width: 450px;
      width: 90%;
    }

    .thankyou-box h1 {
      color: #4CAF50;
      font-size: 2rem;
      margin-bottom: 15px;
    }

    .thankyou-box p {
      font-size: 1.1rem;
      color: #444;
    }
  </style>
</head>
<body>
  <div class="thankyou-box">
    <h1>🎉 Registration Complete!</h1>
    <p>Welcome, <strong><?= htmlspecialchars($_SESSION['username']) ?></strong>!</p>
    <p>You’ll be redirected to the homepage in a moment...</p>
  </div>
</body>
</html>
