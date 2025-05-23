<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
    $form_data = $_SESSION['joinus_form'] ?? [];
    unset($_SESSION['joinus_form']);
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

<body class="joinus-page">
    <div id="top"></div>
    <header>
      <?php include 'navbar.php'; ?>
    </header>

    <section class="joinus-hero">
        <div class="joinus-text">
            <h1>About Us</h1>
            <p>Brew & Go Coffee is a proudly homegrown brand originating from Kuching, Sarawak. Founded in 2023 with a passion for handcrafted beverages, we began our journey as a humble home-based business, brewing artisanal coffee for a growing community of loyal customers. Our commitment to quality, creativity, and consistency quickly earned us a name in the local scene.</p>
            <p>In 2024, we launched our first physical coffee kiosk at One Jaya Mall, bringing our signature blends to a wider audience. Fueled by strong support and positive reception, we expanded shortly after with a second kiosk at Plaza Merdeka Shopping Centre. Our menu features not only expertly brewed coffee but also a curated selection of non-coffee beverages such as premium matcha, rich chocolate drinks, and seasonal specialties.</p>
            <p>As Brew & Go continues to grow, we are actively seeking passionate, motivated individuals to join our team. Whether you're an experienced barista, a customer service enthusiast, or someone eager to learn and grow in the food and beverage industry — we’d love to hear from you. Join us in shaping the future of local coffee culture, one cup at a time.</p>
        </div>
        <form class="joinus-form" action="process_joinus.php" method="POST" enctype="multipart/form-data">
          <div class="form-reset-topright">
            <button type="reset">Reset Form</button>
          </div>
          <fieldset>
            <legend>Applicant Information</legend>
      
            <!-- First and Last Name -->
            <div class="input-group-row">
              <div class="input-group">
                <label for="first_name">First Name</label>
                <input type="text" id="first_name" name="first_name" maxlength="25" pattern="[A-Za-z]+" placeholder="John" required
                      value="<?= htmlspecialchars($form_data['first_name'] ?? '') ?>">              
                </div>
              <div class="input-group">
                <label for="last_name">Last Name</label>
                <input type="text" id="last_name" name="last_name" maxlength="25" pattern="[A-Za-z]+" placeholder="Doe" required
                      value="<?= htmlspecialchars($form_data['last_name'] ?? '') ?>">              
              </div>
            </div>
      
            <!-- Email -->
            <div class="input-group-row">

            <div class="input-group">
              <label for="email">Email Address</label>
              <input type="email" id="email" name="email" placeholder="example@email.com" required
              value="<?= htmlspecialchars($form_data['email'] ?? '') ?>">              

            </div>
            <!-- Phone -->
            <div class="input-group">
              <label for="phone">Phone Number</label>
              <input type="tel" id="phone" name="phone" pattern="\d{10}" maxlength="10" required
              value="<?= htmlspecialchars($form_data['phone'] ?? '') ?>">
            </div>
            </div>
            <div class="input-group">
              <fieldset class="shift-group">
                <legend>Preferred Shift</legend>
                <label for="morning">Morning</label>
                <input type="radio" name="shift" id="morning" value="morning" required
                      <?= ($form_data['shift'] ?? '') === 'morning' ? 'checked' : '' ?>>
                <label for="night">Night</label>
                <input type="radio" name="shift" id="night" value="night" required
                      <?= ($form_data['shift'] ?? '') === 'night' ? 'checked' : '' ?>>
              </fieldset>
            </div>            
            <!-- Address -->
            <fieldset>
              <legend>Address</legend>
                <label for="street">Street Address</label>
                <input type="text" id="street" name="street" maxlength="40" required
                value="<?= htmlspecialchars($form_data['street'] ?? '') ?>">
                <div class="input-group-row">
                    <div class="input-group">
                        <label for="postcode">Postcode</label>
                        <input type="text" id="postcode" name="postcode" pattern="\d{5}" maxlength="5" required
                          value="<?= htmlspecialchars($form_data['postcode'] ?? '') ?>">
                      </div>
                    <div class="input-group">
                      <label for="city">City / Town</label>
                      <input type="text" id="city" name="city" maxlength="20" required
                          value="<?= htmlspecialchars($form_data['city'] ?? '') ?>">
                    </div>  
                <div class="input-group">
                  <label for="state">State</label>
                  <select id="state" name="state" required>
                    <option value="" disabled selected>Select a state</option>
                    <option value="Johor" <?= isset($form_data['state']) && $form_data['state'] === 'Johor' ? 'selected' : '' ?>>Johor</option>
                    <option value="Kedah" <?= isset($form_data['state']) && $form_data['state'] === 'Kedah' ? 'selected' : '' ?>>Kedah</option>
                    <option value="Kelantan" <?= isset($form_data['state']) && $form_data['state'] === 'Kelantan' ? 'selected' : '' ?>>Kelantan</option>
                    <option value="Melaka" <?= isset($form_data['state']) && $form_data['state'] === 'Melaka' ? 'selected' : '' ?>>Melaka</option>
                    <option value="Negeri Sembilan" <?= isset($form_data['state']) && $form_data['state'] === 'Negeri Sembilan' ? 'selected' : '' ?>>Negeri Sembilan</option>
                    <option value="Pahang" <?= isset($form_data['state']) && $form_data['state'] === 'Pahang' ? 'selected' : '' ?>>Pahang</option>
                    <option value="Penang" <?= isset($form_data['state']) && $form_data['state'] === 'Penang' ? 'selected' : '' ?>>Penang</option>
                    <option value="Perlis" <?= isset($form_data['state']) && $form_data['state'] === 'Perlis' ? 'selected' : '' ?>>Perlis</option>
                    <option value="Sabah" <?= isset($form_data['state']) && $form_data['state'] === 'Sabah' ? 'selected' : '' ?>>Sabah</option>
                    <option value="Sarawak" <?= isset($form_data['state']) && $form_data['state'] === 'Sarawak' ? 'selected' : '' ?>>Sarawak</option>
                    <option value="Selangor" <?= isset($form_data['state']) && $form_data['state'] === 'Selangor' ? 'selected' : '' ?>>Selangor</option>
                    <option value="Terengganu" <?= isset($form_data['state']) && $form_data['state'] === 'Terengganu' ? 'selected' : '' ?>>Terengganu</option>
                    <option value="Kuala Lumpur" <?= isset($form_data['state']) && $form_data['state'] === 'Kuala Lumpur' ? 'selected' : '' ?>>Kuala Lumpur</option>
                    <option value="Labuan" <?= isset($form_data['state']) && $form_data['state'] === 'Labuan' ? 'selected' : '' ?>>Labuan</option>
                    <option value="Putrajaya" <?= isset($form_data['state']) && $form_data['state'] === 'Putrajaya' ? 'selected' : '' ?>>Putra Jaya</option>

                    <option value="Terengganu">Terengganu</option>
                    <option value="Kuala Lumpur">Kuala Lumpur</option>
                    <option value="Labuan">Labuan</option>
                    <option value="Putrajaya">Putrajaya</option>
                  </select>
                </div>
              </div>
            </fieldset>
            <!-- CV + Photo -->
            <div class="input-group-row">
            <div class="input-group">
                <label for="photo">Upload Photo (under 200KB)</label>
                <input type="file" id="photo" name="photo" accept="image/*" required>
                <small>Please upload a photo file under 200KB.</small>
            </div>
            <div class="input-group">
                <label for="cv">Upload CV (PDF or Word)</label>
                <input type="file" id="cv" name="cv" accept=".pdf,.doc,.docx" required>
            </div>
                <div class="form-submit-row">
                <button type="submit">Submit Application</button>
            </div>
            </div>
          </fieldset>
        </form>
      </section>


  <?php if (isset($keep_form_data)) unset($_SESSION['joinus_form']); ?>
  <?php include 'footer.php'; ?>

</body>
</html>