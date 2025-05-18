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

<body class="blog-page">
    <div id="top"></div>
    <header>
      <?php include 'navbar.php'; ?>
    </header>

  <section class="coming-soon-blog-container">
    <div class="coming-soon-blog-title">
      <h1>Upcoming Events</h1>
      <h3>Exciting Events Coming Soon</h3>
    </div>
    


      <div class="top-row">
        <div class="current-wrapper">
          <div class="current-section">
            <div class="current-picture">
              <a href="https://www.instagram.com/p/DHXgoi2vMe_/?img_index=1">
              <img src="images/ComingSoon1.png" alt="Current Promo">
              </a>
            </div>
        
            <div class="current-info">
              <div class="activities-title">
                <h2>What's New?</h2>
              </div>
              <div class="description">
                <p>Get your fuel satisfied with the perfect brew! ☕️✨ Meet @brewngo.coffee, where quality coffee meets exceptional flavour. Whether you’re on the go or looking to savour every sip, their caffeine creations are here to satisfy your coffee cravings like never before ☕️ #coffeelover #supportlocal #caffeine</p>
                  <br>
                  <p>
                    Mini Seni Kita: Open haus
                  </p>
                  <p>
                    📍 HAUS KCH, Yun Phin Building
                  </p>
                  <p>
                    📆 29 March 2025
                  </p>
                  <p>
                    🕒 3.00pm - 10.00pm
                  </p>
                  <p>
                    🔥 All ages welcome – let’s have fun!
                  </p>
                  <p>
                    🌟 It’s free entry!
                  </p>
                  <br>
                  <br>
                  <p>Follow for more updates and releases (*^ω^)!
                  <br>@senikitakch
                  <br>@hauskch</p>
                  <br>
                  
              </div>
            </div>
        
            <!-- Timeframe block -->
            <div class="blog-time-frame">
              <h2>Date:</h2>
              <p>Valid until end of the month at all outlets.</p>
              <h2>Expiry Date:</h2>
              <p>March 31, 2025</p>
            </div>
          </div>
        </div>
        <div class="line-title-wrapper">
          <span class="end-line"></span>
        </div>      
      </div>
      
      <?php include 'footer.php'; ?>

      
    </body>
    </html>