<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include 'connection.php';
include 'navbar.php';

// Fetch all activities
$activities_query = mysqli_query($conn, "SELECT * FROM activities ORDER BY event_date DESC");
$current = null;
$coming = null;
$past = [];

$now = new DateTime();

while ($row = mysqli_fetch_assoc($activities_query)) {
    $start = new DateTime($row['event_date'] . ' ' . $row['start_time']);
    $end = new DateTime($row['event_date'] . ' ' . $row['end_time']);

    if ($start <= $now && $end >= $now && $current === null) {
        $current = $row;
    } elseif ($start > $now && $coming === null) {
        $coming = $row;
    } else {
        $past[] = $row;
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
    <title>Brew & Go Coffee - Home</title>
    <link rel="stylesheet" href="styles/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Outfit' rel='stylesheet'>
</head>

<body class="blog-page">
<div id="top"></div>

<section class="blog-container">
    <div class="blog-title">
        <h1>BLOG</h1>
        <h3>Find out about the future, present, pass of Brew & Go</h3>
        <a href="#current-activities" class="blog-transparent-btn">Explore More</a>
    </div>

    <div class="blog-section-title blog-top-title">
        <h2>Current Activities</h2>
    </div>

    <?php if ($current): ?>
        <div class="current-wrapper">
            <div class="current-section">
                <div class="current-picture">
                    <a href="current_activity.php">
                        <img src="<?= htmlspecialchars($current['image_path']) ?>" alt="Current Activity">
                    </a>
                </div>
                <div class="current-info">
                    <div class="activities-title">
                        <h2><?= htmlspecialchars($current['title']) ?></h2>
                    </div>
                    <div class="description">
                        <p><?= nl2br(htmlspecialchars($current['description'])) ?></p>
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
    <?php else: ?>
        <p style="text-align: center;">No current activity at the moment.</p>
    <?php endif; ?>


    <div class="blog-section-title blog-bottom-title">
        <h2>Coming Soon | Past Activities</h2>
    </div>
    <div class="bottom-row">
        <!-- Coming Soon -->
        <?php if ($coming): ?>
            <div class="coming-soon-box">
                <div class="coming-image">
                    <a href="coming_soon.php">
                        <img src="<?= htmlspecialchars($coming['image_path']) ?>" alt="Coming Soon">
                        <div class="coming-caption">
                            <h3><?= htmlspecialchars($coming['title']) ?></h3>
                            <p><?= htmlspecialchars($coming['description']) ?></p>
                        </div>
                    </a>
                </div>
            </div>
        <?php endif; ?>

        <!-- Past Activities -->
        <div class="past-activities">
            <?php foreach (array_slice($past, 0, 6) as $p): ?>
                <a href="past_activity.php">
                    <div class="past-slide">
                        <img src="<?= htmlspecialchars($p['image_path']) ?>" alt="Past Activity">
                        <div class="slide-caption"><?= $p['event_date'] ?><br><b><?= htmlspecialchars($p['title']) ?></b></div>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<?php include 'footer.php'; ?>
</body>
</html>
