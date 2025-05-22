<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include 'connection.php';
include 'navbar.php';

$now = new DateTime();

// Fetch upcoming events
$coming_result = mysqli_query($conn, "SELECT * FROM activities ORDER BY event_date ASC");

$coming_events = [];

while ($row = mysqli_fetch_assoc($coming_result)) {
    $start = new DateTime($row['event_date'] . ' ' . $row['start_time']);
    if ($start > $now) {
        $coming_events[] = $row;
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
    <title>Brew & Go Coffee - Upcoming Events</title>
    <link rel="stylesheet" href="styles/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Outfit' rel='stylesheet'>
</head>

<body class="blog-page">
<div id="top"></div>

<section class="blog-container">
    <div class="blog-title">
        <h1>Upcoming Events</h1>
        <h3>Exciting Events Coming Soon</h3>
    </div>

    <div class="top-row">
        <?php if (!empty($coming_events)): ?>
            <?php foreach ($coming_events as $event): ?>
                <div class="current-wrapper">
                    <div class="current-section">
                        <div class="current-picture">
                            <a href="<?= htmlspecialchars($event['external_link'] ?: '#') ?>" target="_blank">
                                <img src="<?= htmlspecialchars($event['image_path']) ?>" alt="<?= htmlspecialchars($event['title']) ?>">
                            </a>
                        </div>

                        <div class="current-info">
                            <div class="activities-title">
                                <h2><?= htmlspecialchars($event['title']) ?></h2>
                            </div>
                            <div class="current-description">
                                <p><?= nl2br(htmlspecialchars($event['description'])) ?></p>
                                <?php if (!empty($event['external_link'])): ?>
                                    <a href="<?= htmlspecialchars($event['external_link']) ?>" class="web-button" target="_blank">Show in Web</a>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="blog-time-frame">
                            <h2>Date:</h2>
                            <p><?= $event['event_date'] ?></p>
                            <h2>Time:</h2>
                            <p><?= $event['start_time'] ?> – <?= $event['end_time'] ?></p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p style="text-align: center; margin: 40px;">No upcoming events at the moment.</p>
        <?php endif; ?>
    </div>
</section>

<?php include 'footer.php'; ?>
</body>
</html>
