<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include 'connection.php';
include 'navbar.php';

$current_date = date('Y-m-d');
$current_time = date('H:i:s');

$current_result = mysqli_query($conn, "
    SELECT * FROM activities 
    WHERE 
        event_date = '$current_date' 
        AND start_time <= '$current_time' 
        AND end_time >= '$current_time'
    ORDER BY event_date ASC 
    LIMIT 1
");

$current = mysqli_fetch_assoc($current_result);
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
    <h1>Current Activities</h1>
    <h3>Explore our ongoing promotions and events</h3>
  </div>

  <?php if ($current): ?>
    <div class="top-row">
      <div class="current-wrapper">
        <div class="current-section">
          <div class="current-picture">
            <a href="<?= htmlspecialchars($current['external_link'] ?: '#') ?>" target="_blank">
              <img src="<?= htmlspecialchars($current['image_path']) ?>" alt="<?= htmlspecialchars($current['title']) ?>">
            </a>
          </div>

          <div class="current-info">
            <div class="activities-title">
              <h2><?= htmlspecialchars($current['title']) ?></h2>
            </div>
            <div class="description">
              <p><?= nl2br(htmlspecialchars($current['description'])) ?></p>
              <?php if (!empty($current['external_link'])): ?>
                <a href="<?= htmlspecialchars($current['external_link']) ?>" class="web-button" target="_blank">Show in Web</a>
              <?php endif; ?>
            </div>
          </div>

          <div class="blog-time-frame">
            <h2>Date:</h2>
            <p><?= $current['event_date'] ?></p>
            <h2>Time:</h2>
            <p><?= $current['start_time'] ?> – <?= $current['end_time'] ?></p>
          </div>
        </div>
      </div>
    </div>
  <?php else: ?>
    <p style="text-align: center; margin: 40px;">No current activities at the moment.</p>
  <?php endif; ?>
</section>



  <?php include 'footer.php'; ?>

</body>
</html>
``` 
