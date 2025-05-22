<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include 'connection.php';

$now = new DateTime();
$past_result = mysqli_query($conn, "SELECT * FROM activities ORDER BY event_date DESC");

$past_activities = [];
while ($row = mysqli_fetch_assoc($past_result)) {
    $end = new DateTime($row['event_date'] . ' ' . $row['end_time']);
    if ($end < $now) {
        $past_activities[] = $row;
    }
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
    <title>Brew & Go Coffee - Past Events</title>
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
        if (empty($past_activities)): ?>
            <p style="text-align:center; margin: 40px;">No past events available.</p>
        <?php else:
            foreach ($past_activities as $row): ?>
                <div class="<?= $left ? 'left-current-section' : 'right-current-section' ?>">
                    <div class="<?= $left ? 'left-current-picture' : 'right-current-picture' ?>">
                        <a href="<?= htmlspecialchars($row['external_link'] ?: '#') ?>" target="_blank">
                            <img src="<?= htmlspecialchars($row['image_path']) ?>" alt="<?= htmlspecialchars($row['title']) ?>">
                        </a>
                    </div>

                    <div class="<?= $left ? 'left-current-info' : 'right-current-info' ?>">
                      <div class="<?= $left ? 'left-activities-title' : 'left-activities-title' ?>">
                            <h2><?= date('jS F Y', strtotime($row['event_date'])) ?></h2>
                        </div>
                        <div class="<?= $left ? 'right-current-description' : 'right-current-description' ?>">
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

                    <span class="end-line"></span>
                </div>
                <?php $left = !$left;
            endforeach;
        endif;
        ?>
    </div>
</section>

<?php include 'footer.php'; ?>
</body>
</html>
