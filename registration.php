<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

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
  <?php
    $errors = $_SESSION['registration_errors'] ?? [];
    $input = $_SESSION['registration_input'] ?? [];
    unset($_SESSION['registration_errors'], $_SESSION['registration_input']);
  ?>

    <div id="top"></div>
    <header>
      <?php include 'navbar.php'; ?>
    </header>

  <!-- Hero Section -->
  <section class="enquiry-hero">
    <h1>Join Brew & Go Rewards</h1>
    <p>Register now and enjoy exclusive member perks, points, and special offers!</p>
    <hr>
    <h3>Terms & Conditions</h3>
    <ul class="tnc-list">
      <li>💳 Minimum top-up to join: RM30</li>
      <li>💰 Top-up options: RM50, RM100, RM200</li>
      <li>🔒 Credit stored is not withdrawable</li>
      <li>🕓 Lifetime Membership</li>
    <li>Already a member?<br><a href="login.php">Login Here!</a></li>
    </ul>
  </section>

  <!-- Header Section -->
  <!-- <section class="enquiry-header">
    <div class="header-left">
      <img src="images/Logo.png" alt="Brew & Go Logo" />
    </div>
    <div class="header-right">
      <strong>BREW & GO COFFEE</strong><br />
      Ground Floor, G63, Lot, Onejaya Shopping Complex,<br />
      11430, Jalan Song, Tabuan Heights,<br />
      93350 Kuching, Sarawak<br />
      www.brewngo.com<br />
      (+60)11-1653 1886
    </div>
  </section> -->

  <!-- Registration Form -->
  <section class="registration-container">
    <h2>Membership Registration</h2>
    <div class="form-reset-topright">
      <button type="reset">Reset Form</button>
    </div>
    <form action="process_registration.php" method="POST" class="registration-form">
      <div class="form-section">
      <?php if (!empty($errors)): ?>
        <div class="form-errors" style="
          background-color: #ffe6e6;
          border: 2px solid #ff4d4d;
          color: #b30000;
          padding: 15px 20px;
          border-radius: 8px;
          margin-bottom: 20px;
          box-shadow: 0 2px 6px rgba(0,0,0,0.1);
        ">
          <h4 style="margin-top: 0;">⚠ Please correct the following:</h4>
          <ul style="padding-left: 20px; margin-top: 10px;">
            <?php foreach ($errors as $error): ?>
              <li>❌ <?= htmlspecialchars($error) ?></li>
            <?php endforeach; ?>
          </ul>
        </div>
      <?php endif; ?>


        <h3>Login Info</h3>
        <div class="input-group-row">
        <div class="input-group">
          <label for="username">Username</label>
          <input type="text" id="username" name="username" class="username-input"
            maxlength="10" pattern="[A-Za-z]+"
            placeholder="Username" required
            value="<?= htmlspecialchars($input['username'] ?? '') ?>">
          <p class="password-hint">⚠ A-Z only, case-sensitive, max 25 characters.</p>
        </div>
      </div>
    </div>

  
      <div class="form-section">
        <h3>Personal Info</h3>
        <div class="input-group-row">
          <div class="input-group">
            <label for="first_name">First Name</label>
            <input type="text" id="first_name" name="first_name"
              maxlength="25" pattern="[A-Za-z]+"
              placeholder="Jackie" required
              value="<?= htmlspecialchars($input['first_name'] ?? '') ?>">
          </div>
          <div class="input-group">
            <label for="last_name">Last Name</label>
            <input type="text" id="last_name" name="last_name"
              maxlength="25" pattern="[A-Za-z]+"
              placeholder="Chan" required
              value="<?= htmlspecialchars($input['last_name'] ?? '') ?>">
          </div>
        </div>
      </div>
  
      <div class="form-section">
        <h3>Contact Info</h3>
        <div class="input-group-row">
          <div class="input-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email"
              placeholder="meow@mail.com" required
              value="<?= htmlspecialchars($input['email'] ?? '') ?>">
          </div>
          <div class="input-group">
            <label for="phone">Phone</label>
            <input type="tel" id="phone" name="phone"
              placeholder="(+60) 1234-5678" required
              value="<?= htmlspecialchars($input['phone'] ?? '') ?>">
          </div>
        </div>
      </div>
  
      <div class="form-section">
        <h3>Set Your Password</h3>
        <div class="input-group-row">
          <div class="input-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" maxlength="25" pattern="[A-Za-z]{1,25}" placeholder="Aa-Zz" required>
            <p class="password-hint">⚠ A-Z only, case-sensitive, max 25 characters.</p>
          </div>
          <div class="input-group">
            <label for="confirm_password">Confirm Password</label>
            <input type="password" id="confirm_password" name="confirm_password" maxlength="25" pattern="[A-Za-z]+" required>
          </div>
        </div>
      </div>
  
      <button type="submit">Register</button>
    </form>
  </section>

  <?php include 'footer.php'; ?>

</body>

</html>
