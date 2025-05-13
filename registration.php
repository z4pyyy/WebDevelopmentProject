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
        <h3>Login Info</h3>
        <div class="input-group-row">
        <div class="input-group">
          <label for="username">Login ID</label>
          <input type="text" id="username" name="username" maxlength="10" pattern="[A-Za-z]+" placeholder="Username" required>
          <p class="password-hint">⚠ A-Z only, case-sensitive, max 25 characters.</p>
        </div>
        <div class="input-group">
          <label for="id_tag">ID Tag</label>
          <input 
            type="text" 
            id="id_tag" 
            name="id_tag" 
            maxlength="3" 
            pattern="#\d{2}" 
            placeholder="#78" 
            required
            title="Must start with # followed by exactly 2 digits (e.g., #01)"
          >
          <p class="password-hint">⚠ Must begin with # followed by 2 digits (e.g., #01)</p>
        </div>
      </div>
    </div>

  
      <div class="form-section">
        <h3>Personal Info</h3>
        <div class="input-group-row">
          <div class="input-group">
            <label for="first_name">First Name</label>
            <input type="text" id="first_name" name="first_name" maxlength="25" pattern="[A-Za-z]+" placeholder="Jackie" required>
          </div>
          <div class="input-group">
            <label for="last_name">Last Name</label>
            <input type="text" id="last_name" name="last_name" maxlength="25" pattern="[A-Za-z]+" placeholder="Chan" required>
          </div>
        </div>
      </div>
  
      <div class="form-section">
        <h3>Contact Info</h3>
        <div class="input-group-row">
          <div class="input-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" placeholder="meow@mail.com" required>
          </div>
          <div class="input-group">
            <label for="phone">Phone</label>
            <input type="tel" id="phone" name="phone" placeholder="(+60) 1234-5678" required>
          </div>
        </div>
      </div>
  
      <div class="form-section">
        <h3>Set Your Password</h3>
        <div class="input-group-row">
          <div class="input-group">
            <label for="password">Password</label>
            <input type="text" id="password" name="password" maxlength="25" pattern="[A-Za-z]{1,25}" placeholder="Aa-Zz" required>
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
