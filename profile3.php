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

<body class="product-page">
    <div id="top"></div>
    <header>
      <?php include 'navbar.php'; ?>
    </header>



    <section class="profile-container">
      <div class="profile-card">
        <img src="images/Hans Profile Pic.jpg" alt="Hans Yee Profile Photo" class="profile-photo">
        <div class="profile-info">
          <h1>Hans Yee Jia Syn</h1>
          <p class="student-id">Student ID: 102780414</p>
          <p class="course">Bachelor of Computer Science</p>
          <div class="category-section">
            <details open class="animated-details">
              <summary>About Me</summary>
              <hr>
                <ol class="category-list">            
                <p>Currently studying in Bachelor of Computer Science. <br> </p>
                </ol>
              </details>
            </div>
          </div>
        </div>
      
        <div class="category-section">
          <details>
            <summary>Experience</summary>
            <hr>
            <ol class="category-list">
            </ol>
          </details>
          
          <details>
            <summary>Education</summary>
            <hr>
            <ol class="category-list">
              <li>
                <img src="images/swinburne.png" alt="Swinburne Logo" class="category-icon">
                <p>
                <strong>Swinburne University Technology of sarawak – Bachelor in Computer Science</strong><br>
                <span class="time-frame">PRESENT</span>
                </p>
              </li>
              <li>
                <img src="images/swinburne.png" alt="Swinburne Logo" class="category-icon">
                <p>
                <strong>Swinburne University Technology of Sarawak – Diploma In Business Management</strong><br>
                <span class="time-frame">2022 - 2024</span>
              </p>
              </li>
              <li>
                <img src="images/SMKGREENROAD.jpeg" alt="Swinburne Logo" class="category-icon">
                <p>
                <strong>SMK GREEN ROAD – 5S3</strong><br>
                <span class="time-frame">2017-2022</span>
              </p>
              </li>
            </ol>
          </details>
          
          <details>
            <summary>Skills</summary>
            <hr>
            <ol class="category-list">
              <li>
                <img src="images/HTML.png" alt="HTML Logo" class="category-icon">
                <p><strong>HTML</strong><br></p>
              </li>
              <li>
                <img src="images/CSS.png" alt="CSS Logo" class="category-icon">
                <p><strong>CSS3</strong><br></p>
              </li>
              <li>
                <img src="images/PHP.png" alt="PHP Logo" class="category-icon">
                <p><strong>PHP</strong><br></p>
              </li>
            </ol>
          </details>

          <details>
            <summary>Personal Achievements</summary>
            <hr>
            <ol class="category-list">
            </ol>
          </details>


                    
          
        </div>
      </section>

  <?php include 'footer.php'; ?>

</body>
</html>
