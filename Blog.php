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

<body class="blog-page">
    <div id="top"></div>
    <header>
      <?php include 'navbar.php'; ?>
    </header>

  <section class="blog-container">
    <div class="blog-title">
      <h1>BLOG</h1>
      <h3>Find out about the future, present, pass of Brew & Go</h3>
      <a href="#current-activities" class="blog-transparent-btn">Explore More</a>
    </div>
    <div class="blog-section-title" id="current-activities">
      <h2 >Current Activities</h2>
      </div>
      <div class="line-title-wrapper">
        <span class="line"></span>
      </div>  


      <div class="top-row">
        <div class="current-wrapper">
          <div class="current-section">
            <div class="current-picture">
              <a href="current_activity.html">
              <img src="images/Current.jpg" alt="Current Promo">
              </a>
            </div>
        
            <div class="current-info">
              <div class="activities-title">
                <h2>What's New?</h2>
              </div>
              <div class="description">
                <p>Get 1 free drink with a top-up of RM50!</p>
                <p>Valid until end of the month at all outlets.</p>
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
    






    <div class="blog-section-title blog-bottom-title">
      <h2>Coming Soon | Past Activities</h2>
    </div>
    <div class="bottom-row">
      <!-- Coming Soon -->
      <div class="coming-soon-box">
        <div class="coming-image">
          <a href="coming_soon.html">
            <img src="images/ComingSoon1.png" alt="Coming Soon">
            <div class="coming-caption">
              <h3>COMING SOON</h3>
              <p>Stay tuned for our exciting April deals and new launches!</p>
            </div>
          </a>
        </div>
      </div>
      

      <!-- Past Activities Slideshow -->
      <div class="past-activities">
        <div class="past-slideshow">
          <div class="slides">
            <a href="past_activity.html">
            <div class="past-slide s1 no-animation">
              <img src="images/CHRISTMAS2024.png" alt="Slide 1">
              <div class="slide-caption">25 Jan 2025<br><b>Free Oranges</b> w/ 2 drinks</div>
            </div>
          </a>
          <a href="past_activity.html">  
            <div class="past-slide s2">
              <img src="images/SENIKITAWEEKEND.png" alt="Slide 2">
              <div class="slide-caption">28 Oct 2024<br><b>11% Off</b> Thursdays</div>
            </div>
          </a>
          <a href="past_activity.html">
            <div class="past-slide s3">
              <img src="images/SENIKITA.png" alt="Slide 3">
              <div class="slide-caption">9 Sep 2024<br><b>50% Off</b> Grabfood promo</div>
            </div>
            </a>
            <a href="past_activity.html">
            <div class="past-slide s4">
              <img src="images/RAYA2024.png" alt="Slide 4">
              <div class="slide-caption">Hari Raya Promo</div>
            </div>
            </a>
            <a href="past_activity.html">
            <div class="past-slide s5">
              <img src="images/DISCOUNTTHURDAY2024.png" alt="Slide 5">
              <div class="slide-caption">Discount Thursday</div>
            </div>
          </a>
          <a href="past_activity.html">
            <div class="past-slide s6">
              <img src="images/CNYOPENING.png" alt="Slide 6">
              <div class="slide-caption">Chinese New Year Opening</div>
            </div>
          </a>
          </div>
        </div>
        </div>
    </div>
  </section>

  <?php include 'footer.php'; ?>

</body>
</html>