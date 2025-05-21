<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include 'connection.php';
$past_activities = mysqli_query($conn, "SELECT * FROM activities WHERE type = 'past' ORDER BY event_date DESC");
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

  <section class="past-activity-blog-container">
    <div class="past-activity-blog-title">
      <h1>Past Events</h1>
      <h3>Memorable Events from the Past</h3>
    </div>

    <div class="top-row">
<?php
$left = true;
while ($row = mysqli_fetch_assoc($past_activities)):
?>
  <div class="<?= $left ? 'left-current-section' : 'right-current-section' ?>">
    <div class="<?= $left ? 'left-current-picture' : 'right-current-picture' ?>">
      <a href="<?= htmlspecialchars($row['external_link'] ?: '#') ?>" target="_blank">
        <img src="<?= htmlspecialchars($row['image_path']) ?>" alt="<?= htmlspecialchars($row['title']) ?>">
      </a>
    </div>

    <div class="<?= $left ? 'left-current-info' : 'right-current-info' ?>">
      <div class="<?= $left ? 'left-activities-title' : 'right-activities-title' ?>">
        <h2><?= date('jS F Y', strtotime($row['event_date'])) ?></h2>
      </div>
      <div class="<?= $left ? 'left-description' : 'right-description' ?>">
        <p><?= nl2br(htmlspecialchars($row['description'])) ?></p>
        <?php if (!empty($row['external_link'])): ?>
          <a href="<?= htmlspecialchars($row['external_link']) ?>" class="past-transparent-btn" target="_blank">Show in Web</a>
        <?php endif; ?>
      </div>
    </div>

    <div class="<?= $left ? 'left-blog-time-frame' : 'right-blog-time-frame' ?>">
      <h2>Date:</h2>
      <p><?= $row['event_date'] ?></p>
      <h2>Time:</h2>
      <p><?= $row['start_time'] ?> – <?= $row['end_time'] ?></p>
    </div>
  </div>

  <div class="line-title-wrapper">
    <span class="end-line"></span>
  </div>
<?php
  $left = !$left; // alternate layout
endwhile;
?>
</div>



  <?php include 'footer.php'; ?>

  
</body>
</html>
``` 