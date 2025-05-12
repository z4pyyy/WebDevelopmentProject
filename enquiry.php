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
    <link rel="stylesheet" href="styles/mobile.css?" media="screen and (max-width: 1300px)">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Outfit' rel='stylesheet'>
</head>

<body class="enquiry-page">
    <div id="top"></div>
    <header>
      <?php include 'navbar.php'; ?>
    </header>
    <section class="enquiry-hero">
      <h1>How Can We Help You?</h1>
      <p>We’re here to answer your questions, take suggestions, and assist with anything you need.</p>
    </section>


    <section class="enquiry-header">
      <div class="header-left">
        <img src="images/Logo.png" alt="Brew & Go Logo">
      </div>
      <div class="header-right">
        <strong>BREW & GO COFFEE</strong><br>
        Ground Floor, G63, Lot, Onejaya Shopping Complex,<br>
        11430, Jalan Song, Tabuan Heights,<br>
        93350 Kuching, Sarawak<br>
        www.brewngo.com<br>
        (+60)11-1653 1886
      </div>
    </section>
    
    <section class="enquiry-container">
      <hr>
      <form action="process_enquiry.php" method="POST" class="enquiry-form">
        <div class="form-reset-topright">
          <button type="reset">Reset Form</button>
        </div>
        <h2>Customer Enquiry</h2>
        <!-- Name Row -->
        <div class="input-row">
          <div class="input-col">
            <label><strong>Your Name</strong></label>
            <input type="text" name="first_name" placeholder="First Name" required>
          </div>
          <div class="input-col">
            <label>&nbsp;</label>
            <input type="text" name="last_name" placeholder="Last Name" required>
          </div>
        </div>
    
        <!-- Contact Row -->
        <div class="input-row">
          <div class="input-col">
            <label><strong>Number</strong></label>
            <input type="tel" name="phone" placeholder="(+60) 1234-5678" required>
          </div>
          <div class="input-col">
            <label><strong>Your E-mail Address</strong></label>
            <input type="email" name="email" placeholder="ex: email@example.com" required>
          </div>
        </div>
    
        <!-- Address Section -->
        <fieldset>
          <legend>Address</legend>
          <div class="form-field">
            <label for="street">Street Address</label>
            <input type="text" id="street" name="street" maxlength="40" required>
          </div>
          <div class="form-field">
            <label for="city">City/Town</label>
            <input type="text" id="city" name="city" maxlength="20" required>
          </div>
          <div class="form-field">
            <label for="state">State</label>
            <select id="state" name="state" required>
              <option value="">Select a state</option>
              <option value="Johor">Johor</option>
              <option value="Kedah">Kedah</option>
              <option value="Kelantan">Kelantan</option>
              <option value="Malacca">Malacca</option>
              <option value="Negeri Sembilan">Negeri Sembilan</option>
              <option value="Pahang">Pahang</option>
              <option value="Penang">Penang</option>
              <option value="Perak">Perak</option>
              <option value="Perlis">Perlis</option>
              <option value="Sabah">Sabah</option>
              <option value="Sarawak">Sarawak</option>
              <option value="Selangor">Selangor</option>
              <option value="Terengganu">Terengganu</option>
              <option value="WP Kuala Lumpur">WP Kuala Lumpur</option>
              <option value="WP Labuan">WP Labuan</option>
              <option value="WP Putrajaya">WP Putrajaya</option>
            </select>
          </div>
          <div class="form-field">
            <label for="postcode">Postcode</label>
            <input type="text" id="postcode" name="postcode" pattern="\d{5}" maxlength="5" required>
          </div>
        </fieldset>
    
        <!-- Enquiry -->
        <div class="form-field">
          <label for="enquiry"><strong>Enquiry Type</strong></label>
          <select id="enquiry" name="enquiry" required>
            <option value="">Select an enquiry type</option>
            <option value="Membership">Membership</option>
            <option value="Products">Products</option>
            <option value="Pop-up Market Activities">Pop-up Market Activities</option>
          </select>
        </div>
    
        <!-- Message -->
        <div class="input-full">
          <label><strong>Leave Your Message</strong></label>
          <textarea name="message" rows="5" required></textarea>
        </div>
    
        <button type="submit">Submit</button>
      </form>
    </section>
    

  <?php include 'footer.php'; ?>

</body>
</html>
