<!DOCTYPE html>
<html lang="en">
<head>
  
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Brew & Go Coffee - Premium handcrafted beverages">
    <meta name="keywords" content="Coffee, Brew & Go, Kuching, handcrafted beverages">
    <meta name="author" content="TERENCE WONG, DARREN CHONG, HANS YEE">
    <title>Brew & Go Coffee - Home</title>
    <link rel="stylesheet" href="styles/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Outfit' rel='stylesheet'>
</head>

<body class="login-page">
    <div id="top"></div>
    <header>
      <?php include 'navbar.php'; ?>
    </header>

    <div class="login-wrapper">
        <section class="registration-container">
          <h2>Member Login</h2>
          <form action="process_login.php" method="POST" class="registration-form">
            <div class="form-section">
              <h3>Login Credentials</h3>
              <div class="input-group-row">
                <div class="input-group">
                  <label for="username">Login ID</label>
                  <input type="text" id="username" name="username" maxlength="10" pattern="[A-Za-z]+" placeholder="Enter Login ID" required>
                </div>
                <div class="input-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" maxlength="25" required>
              </div>
            </div>
            <p>Not a member yet?<br><a href="registration.html">Join Now!</a></p>
          </div>
    <button type="submit">Login</button>
        </form>
        </section>
    </div>
  
  <?php include 'footer.php'; ?>
 
</body>

</html>
  