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
<?php
include 'connection.php';
$coming_soon = mysqli_query($conn, "SELECT * FROM activities WHERE type = 'coming' ORDER BY event_date ASC");

while ($row = mysqli_fetch_assoc($coming_soon)): ?>
  <div class="current-wrapper">
    <div class="current-section">
      <div class="current-picture">
        <a href="<?= htmlspecialchars($row['external_link'] ?: '#') ?>">
          <img src="<?= htmlspecialchars($row['image_path']) ?>" alt="<?= htmlspecialchars($row['title']) ?>">
        </a>
      </div>

      <div class="current-info">
        <div class="activities-title">
          <h2><?= htmlspecialchars($row['title']) ?></h2>
        </div>
        <div class="description">
          <p><?= nl2br(htmlspecialchars($row['description'])) ?></p>
        </div>
      </div>

      <div class="blog-time-frame">
        <h2>Date:</h2>
        <p><?= $row['event_date'] ?></p>
        <h2>Time:</h2>
        <p><?= $row['start_time'] ?> – <?= $row['end_time'] ?></p>
      </div>
    </div>
  </div>
<?php endwhile; ?>
</div>

      
      <?php include 'footer.php'; ?>

      
    </body>
    </html>