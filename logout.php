<?php
session_start();
session_unset();
session_destroy();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="refresh" content="1;url=index.php">
  <title>Logged Out</title>
  <style>
    body { font-family: Arial, sans-serif; text-align: center; padding-top: 100px; background-color: #f4f4f4; }
    .box { background: white; display: inline-block; padding: 40px; border-radius: 10px; box-shadow: 0 8px 24px rgba(0,0,0,0.15); }
  </style>
</head>
<body>
  <div class="box">
    <h2>👋 You are now logged out.</h2>
    <p>Redirecting to homepage.</p>
  </div>
</body>
</html>
