
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

<body class="index-page">
  <?php
    session_start();
  ?>
    <div id="top"></div>
    <header>
      <?php include 'navbar.php'; ?>
    </header>
    
    <section class="hero-row">
        <!-- Section 1: BREW -->
        <div class="hero-section section-1">
          <h1 class="hero-header">BREW</h1>
        </div>
      
        <!-- Section 2: & + Button -->
        <div class="hero-section section-2">
          <div class="center-content">
            <br><br>
            <h1 class="hero-header">&</h1>
            <a href="#productsection" class="btn">LEARN MORE</a>
          </div>
        </div>
      
        <!-- Section 3: GO -->
        <div class="hero-section section-3">
            <br>
          <h1 class="hero-header">GO</h1>
        </div>
    </section>    
  
    <div class="index-product" id="productsection">
      <div class="line-title-wrapper">
        <span class="line"></span>
        <h1 class="blend-header"><span class="hover-underline">Let your mood <br> lead the brew</span></h1>
        <span class="line"></span>
      </div>  
  <div class="carousel-container">
    <section class="featured-carousel">
      <div class="carousel-wrapper">
        <div class="scroll">
          <div class="carousel-track">
            <div class="carousel-card">
              <h2>Basic Brew</h2>
              <div class="carousel-img-wrapper">
              <img src="images/OrangeAmericano.jpg" alt="Aerocano">
              </div>                  
              <h3>Orange Americano</h3>
              <br>
              <p>Rich, creamy, and smooth espresso-based latte.</p>
              <br>
            </div>
            <div class="carousel-card">
              <h2>Artisan Brew</h2>
              <div class="carousel-img-wrapper">
                <img src="images/ButterscotchLatte.jpg" alt="Butterscotch Latte">
              </div>     
              <h3>Butterscotch Latte</h3>
              <br>
              <p>A perfect blend of espresso, vanilla, and caramel drizzle.</p>
              <br>
            </div>
            <div class="carousel-card">
              <h2>Artisan Brew</h2>
              <div class="carousel-img-wrapper">
                <img src="images/CheeseAmericano.jpg" alt="Cheese Americano">
              </div>     
              <h3>Cheese Americano</h3>
              <br>
              <p>A bold americano topped with a rich cheese foam.</p>
              <br>
                    </div>
                    <div class="carousel-card">
                        <h2>Non-Coffee</h2>
                        <div class="carousel-img-wrapper">
                          <img src="images/YuriMatchaLatte.jpg" alt="Vienna Latte">
                        </div>     
                        <h3>Yuri Matcha Latte</h3>
                        <br>
                        <p>Aromatic espresso with a frothy milk finish.</p>
                        <br>
                      </div>
                      <div class="carousel-card">
                        <h2>Artisan Brew</h2>
                        <div class="carousel-img-wrapper">
                          <img src="images/IcedMocha.jpg" alt="Iced Mocha">
                        </div>     
                        <h3>Iced Mocha</h3>
                        <br>
                        <p>Chocolate and espresso in perfect harmony.</p>
                        <br>
                    </div>
                    <div class="carousel-card">
                        <h2>Basic Brew</h2>
                        <div class="carousel-img-wrapper">
                          <img src="images/OrangeAmericano.jpg" alt="Aerocano">
                        </div>     
                        <h3>Orange Americano</h3>
                        <br>
                        <p>Rich, creamy, and smooth espresso-based latte.</p>
                        <br>
                      </div>
                      <div class="carousel-card">
                        <h2>Basic Brew</h2>
                        <div class="carousel-img-wrapper">
                          <img src="images/IcedCappucino.jpg" alt="Butterscotch Latte">
                        </div>     
                        <h3>Iced Cappucino</h3>
                        <br>
                        <p>A perfect blend of espresso, vanilla, and caramel drizzle.</p>
                        <br>
                      </div>
                      <div class="carousel-card">
                        <h2>Artisan Brew</h2>
                        <div class="carousel-img-wrapper">
                          <img src="images/OrangeMocha.jpg" alt="Cheese Americano">
                        </div>     
                        <h3>Orange Mocha</h3>
                        <br>
                        <p>A bold americano topped with a rich cheese foam.</p>
                        <br>
                      </div>
                      <div class="carousel-card">
                        <h2>Artisan Brew</h2>
                        <div class="carousel-img-wrapper">
                          <img src="images/StrawberryLatte.jpg" alt="Vienna Latte">
                        </div>     
                        <h3>Strawberry Latte</h3>
                        <br>
                        <p>Aromatic espresso with a frothy milk finish.</p>
                        <br>
                      </div>
                      <div class="carousel-card">
                        <h2>Artisan Brew</h2>
                        <div class="carousel-img-wrapper">
                          <img src="images/PistachioLatte.jpg" alt="Iced Mocha">
                        </div>     
                        <h3>Pistachio Latte</h3>
                        <br>
                        <p>Chocolate and espresso in perfect harmony.</p>
                        <br>
                      </div>
                    </div>
            </div>
          </div>
          <div class="cta-button-wrapper">
            <a href="product1.html" class="cta-button">Mood</a>
          </div>
        </section>   
      </div>
    </div>
  </div>

  <div class="seperater-image">
    <div class="seperater-overlay">
      <div class="seperater-text">
        <h1>Experience Brew & Go</h1>
        <p>Where coffee meets character.</p>
        <a href="blog.html" class="transparent-btn">Explore More</a>
      </div>
    </div>
  </div>
  
      <div class="perks-membership-section">
        <div class="perks-line-title-wrapper">
          <span class="perks-line"></span>
          <h1 class="perks-blend-header"><span class="hover-underline"> Barista in the Blend	<br> Perks Never End </span></h1>
          <span class="perks-line"></span>
        </div>
        <div class="join-section-grid">

          <!-- LEFT: Join as Member -->
          <div class="join-card">
            <div class="card-title-overlay">
              <div class="line-title-wrapper">
                <span class="line"></span>
                <h1 class="blend-header"><span class="hover-underline"> Front of the Queue </span></h1>
                <span class="line"></span>
              </div>
            </div>
            <div class="flip-container">
              <div class="flipper">
                <div class="flip-front">
                  <img src="images/INDEXBNG5.png" alt="Join Our Membership" />
                </div>
                <div class="flip-back">
                  <div class="back-info">
                    <h3>Join Brew & Go Rewards</h3>
                    <h2>Register now and enjoy exclusive member perks, points, and special offers!</h2>
                    
                    <ul class="perk-list">
                      <li>💳 Minimum top-up to join: <strong>RM30</strong></li>
                      <li>💰 Top-up options: <strong>RM50, RM100, RM200</strong></li>
                      <li>🔒 Credit stored is <strong>non-withdrawable</strong></li>
                      <li>🕓 <strong>Lifetime Membership</strong></li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
          
            <div class="button-row">
              <a href="registration.html" class="btn-index-primary">Join Member</a>
              <a href="login.html" class="btn-index-secondary"> Log In</a>
            </div>
          </div>
        
           <!-- RIGHT: Join as Crew -->
          <div class="join-card">
            <div class="card-title-overlay">
              <div class="line-title-wrapper">
                <span class="line"></span>
                <h1 class="blend-header"><span class="hover-underline"> Behind the Brew </span></h1>
                <span class="line"></span>
              </div>
            </div>

            <div class="flip-container">
              <div class="flipper">
                <!-- Front Image -->
                <div class="flip-front">
                  <img src="images/BaristaPIC2.png" alt="Join the Crew" />
                </div>
                <!-- Back Info -->
                <div class="flip-back">
                  <div class="back-info">
                    <h3>We're Hiring!</h3>
                    <p><strong>Positions:</strong> Barista | Cashier</p>
                    <p><strong>Locations:</strong><br>One Jaya Mall<br>Plaza Merdeka Mall</p>
                    <p><strong>Benefits:</strong><br>
                      EPF & SOCSO<br>
                      Meal Allowance Provided<br>
                      Sales Commission<br>
                      Salary Range: RM1,700 – RM3,800
                    </p>
                    <br>
                    <br>
                  </div>
                </div>
              </div>
            </div>

            <div class="button-row">
              <a href="joinus.html" class="btn-index-primary">Join the Crew</a>
              <a href="profile1.html" class="btn-index-secondary">Meet the Team</a>
            </div>
          </div>

        </div>
      </div>

        <div class="membership-section-bng">
          <div class="membership-line-title-wrapper">
            <span class="membership-line"></span>
            <h1 class="membership-blend-header"> <span class="hover-underline"> Membership Perks </span></h1>
            <span class="membership-line"></span>
          </div>      
          <div class="membership-cards-row">
            <div class="membership-card" style="background-image: url('images/INDEXBNG4.png');">
              <div class="membership-overlay">
                <h3>🚀 Member Price</h3>
                <p>Across all BREW & GO locations</p>
              </div>
            </div>
        
            <div class="membership-card" style="background-image: url('images/INDEXBNG10.png');">
              <div class="membership-overlay">
                <h3>🌟 Lucky Draw</h3>
                <p>Win amazing prizes every month!</p>
              </div>
            </div>
        
            <div class="membership-card" style="background-image: url('images/INDEXBNG11REFINED.png');">
              <div class="membership-overlay">
                <h3>☕ Free Drinks</h3>
                <p>Enjoy 5 days of drinks for free!</p>
              </div>
            </div>
        
            <div class="membership-card" style="background-image: url('images/INDEXBNG19.png');">
              <div class="membership-overlay">
                <h3>🤩 Collect Points</h3>
                <p>Redeem exclusive rewards</p>
              </div>
            </div>
        
            <div class="membership-card" style="background-image: url('images/INDEXBNG5.png');">
              <div class="membership-overlay">
                <h3>📱 Grab & GO!</h3>
                <p>Fast online ordering experience</p>
              </div>
            </div>
          </div>
        </div>


        <!-- Latest Promotions & News Section -->
        <section class="promo-news-section">
          <div class="promo-news-title-wrapper">
            <span class="promo-news-line"></span>
            <h1 class="promo-news-header"><span class="hover-underline">What's Brewing?</span></h1>
            <span class="promo-news-line"></span>
          </div>

          <div class="promo-news-grid">
            <!-- Latest News -->
            <div class="promo-card">              
              <a href="past_activity.html#past_activity2">
                <img src="images/DISCOUNTTHURDAY2024.png" alt="Thursday Discount">
              </a>
              <div class="promo-card-content">
                <h2>📣Thursday Discount!</h2>
                <p>Catch us soon at AEON Mall Kuching Central — opening in May!</p>
              </div>
            </div>
            
            <!-- Latest Promotion -->
            <div class="promo-card">
              <a href="current_activity.html">
              <img src="images/Current.jpg" alt="Current Promo">
              <div class="promo-card-content">
              </a>
                  <h2>🔥 March Promo!</h2>
                  <p>Buy 1 Get 1 Free on all Cold Brews every Friday in March!</p>
              </div>
            </div>
          </div>
        </section>


        
        <!-- Store Section -->
      <section class="store-locator">
        <div class="map-line-title-wrapper">
          <span class="map-line"></span>
          <h1 class="map-blend-header"><span class="hover-underline">Find us here - Kuching</span></h1>
          <span class="map-line"></span>
        </div>  
          <div class="store-location">
            <!-- One Jaya Mall -->
            <div class="store-card">
              <!-- LEFT SIDE: Location Info -->
              <div class="store-info">
                <h2 class="store-name">📍&nbsp;<a href="https://www.google.com/maps?ll=1.518072,110.36579&z=16&t=m&hl=en-US&gl=US&mapclient=embed&q=Onejaya+Shopping+Complex+Tabuan+Heights+93350+Kuching+Sarawak">One Jaya Mall</a></h2>
                <h3 class="store-hours">🕙 <strong>Hours:</strong><br> <p>9AM – 6PM Daily</p></h3>
                <h3 class="store-address">🏠 <strong>Address:</strong><br> <p>Ground Floor, G63 Lot One Jaya Shopping Complex,<br>11430 Jalan Song, Tabuan Heights, 93350</p></h3>
                <h3 class="store-contact">📞 <strong>Contact:</strong><br> <p>+6011 1653 1886</p></h3>
              </div>
        
              <!-- RIGHT SIDE: Embedded Map -->
              <div class="map-wrapper">
                <iframe 
                  src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3988.366462936843!2d110.3438275!3d1.5566899999999999!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31fba7f35c6fd89b%3A0x16b49ebadfbb7e87!2sOnejaya%20Shopping%20Complex!5e0!3m2!1sen!2smy!4v1710482345678"
                  class="map"
                  allowfullscreen>
                </iframe>
              </div>
            </div>
            
            <!-- Plaza Merdeka -->
            <div class="store-card">
              <!-- LEFT SIDE: Location Info -->
              <div class="store-info">
                <h2 class="store-name">📍&nbsp;<a href="https://www.google.com/maps?ll=1.558574,110.344017&z=15&t=m&hl=en-US&gl=US&mapclient=embed&cid=1175031353901621320">Plaza Merdeka</a></h2>
                <h3 class="store-hours">🕙 <strong>Hours:</strong><br> <p>10AM – 10PM Daily</p></h3>
                <h3 class="store-address">🏠 <strong>Address:</strong><br> <p>Level 1, Plaza Merdeka, infront of Cotton On,<br>88, Pearl Street, 93000</p></h3>
                <h3 class="store-contact">📞 <strong>Contact:</strong><br> <p>+6011 1653 1886</p></h3>
              </div>
        
              <div class="map-wrapper">
                <iframe 
                  src="https://maps.google.com/maps?q=Plaza+Merdeka,Kuching,Sarawak&t=&z=15&ie=UTF8&iwloc=B&output=embed"
                  class="map"
                  allowfullscreen>
                </iframe>
              </div>
            </div>
          </div>
        </section>

          <section class="barista-section">
            <div class="barista-video-wrapper">
              <video class="barista-video" autoplay muted loop>
                <source src="images/Barista2.mp4" type="video/mp4">
                Your browser does not support the video tag.
              </video>
            </div>
          
            <div class="barista-image">
              <a href="joinus.html" class="btn join-us-btn"> JOIN US? :3</a>
            </div>
          
            <div class="barista-video-wrapper">
              <video class="barista-video" autoplay muted loop>
                <source src="images/Barista1.mp4" type="video/mp4">
                Your browser does not support the video tag.
              </video>
            </div>
          </section>
          
        
        <?php include 'footer.php'; ?>
  
</body>
</html>