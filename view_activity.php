<?php
session_start();
$currentPage = basename($_SERVER['PHP_SELF']);
include 'connection.php';
include 'navbar.php';
include 'navbar_admin.php';
date_default_timezone_set('Asia/Kuching'); 



// 🔒 Secure Access
if (!isset($_SESSION['admin_id']) || !in_array($_SESSION['role_id'] ?? 0, [1, 2, 3])) {
    header("Location: login.php");
    exit;
}

// 🗑 Delete
if (isset($_GET['delete_id'])) {
    $id = intval($_GET['delete_id']);
    mysqli_query($conn, "DELETE FROM activities WHERE id = $id");
    header("Location: admin_activities.php");
    exit;
}

// ⏱ Get current datetime
$now = date('Y-m-d H:i:s');
$today = date('Y-m-d');

// 🔎 Fetch all activities
$all = mysqli_query($conn, "SELECT * FROM activities ORDER BY event_date ASC");

// 🗃️ Categorize
$current = $coming = $past = [];

// Force consistent timezone
date_default_timezone_set('Asia/Kuching');
$now_dt = new DateTime();

while ($row = mysqli_fetch_assoc($all)) {
    $start_dt = DateTime::createFromFormat('Y-m-d H:i:s', $row['event_date'] . ' ' . $row['start_time']);
    $end_dt   = DateTime::createFromFormat('Y-m-d H:i:s', $row['event_date'] . ' ' . $row['end_time']);

    if (!$start_dt || !$end_dt) continue; // skip invalid rows

    if ($start_dt > $now_dt) {
        $coming[] = $row;
    } elseif ($start_dt <= $now_dt && $end_dt >= $now_dt) {
        $current[] = $row;
    } else {
        $past[] = $row;
    }
}


// 📊 Stats
$total_current = count($current);
$today_count = 0;
foreach ($current as $row) {
    if ($row['event_date'] === $today) $today_count++;
}
$today_titles = [];
foreach ($current as $row) {
    if ($row['event_date'] === $today) {
        $today_titles[] = $row['title'];
    }
}

$total_upcoming = count($coming);

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin | Activities</title>
  <link rel="stylesheet" href="styles/style.css">
</head>
<body>
    <div class="prd-toggle-wrapper">
    <input type="checkbox" id="prd-menu-toggle" class="prd-menu-toggle">
    <label for="prd-menu-toggle" class="prd-menu-btn">☰ Select Category</label>
    <div class="admin-prd-menu">
      <ul>
        <li><a href="#section-ongoing">✅ Ongoing</a></li>
        <li><a href="#section-upcoming">📌 Upcoming</a></li>
        <li><a href="#section-past">⏳ Past</a></li>
      </ul>
    </div>
  </div>
    <div class="admin-content">
    <div class="admin-navbar">
      <div><strong>Activities</strong></div>
      <a href="add_activity.php" class="backto-view">➕ Add New Activity</a>
    </div>
    <div class="admin-activities-overview">
      <ul>
        <li>Total Ongoing Events: <strong><?= $total_current ?></strong></li>
        <li>Happening Today (<?= $today_count ?>): 
          <strong>
            <?= $today_count > 0 ? implode(', ', array_map('htmlspecialchars', $today_titles)) : 'None' ?>
          </strong>
        </li>
        <li>Total Upcoming Events: <strong><?= $total_upcoming ?></strong></li>
      </ul>
    </div>
    <span class="line"></span>
      
      
      <!-- ✅ Ongoing -->
    <h1 id="section-ongoing" class="admin-header"><span class="hover-underline">✅ Ongoing</span></h1>
    <span class="line"></span>    
    <?php if ($total_current > 0): ?>
    <?php $i = 1; foreach ($current as $row): ?>
      <div class="admin-activity-card">
        <div class="activity-flex">
          <a href="edit_activity.php?id=<?= $row['id'] ?>" class="activity-edit-link">
            <?php if (!empty($row['image_path'])): ?>
              <div class="admin-activity-thumbnail">
                <img src="<?= htmlspecialchars($row['image_path']) ?>" alt="Activity Thumbnail" class="activity-image">
              </div>
          <?php else: ?><p>No Image activities.</p><?php endif; ?>
          </a>
          <div class="admin-activity-stats">
            <a href="edit_activity.php?id=<?= $row['id'] ?>" class="activity-edit-link">
              <h3><?= $i . '. ' . htmlspecialchars($row['title']) ?></h3>
            </a>
            <div class="admin-activity-meta">
              📅 <?= $row['event_date'] ?><br>
              🕒 <?= $row['start_time'] ?> – <?= $row['end_time'] ?><br>
              📍 <?= htmlspecialchars($row['location']) ?>
            </div>
            <div class="admin-activity-description"><?= nl2br(htmlspecialchars($row['description'])) ?></div>
            <?php if (!empty($row['external_link'])): ?>
              <div class="admin-activity-link">🔗 <a href="<?= htmlspecialchars($row['external_link']) ?>" target="_blank">External Link</a></div>
              <?php endif; ?>
            </div>
            <div class="admin-activity-actions">
              <a href="edit_activity.php?id=<?= $row['id'] ?>" class="edit-btn">✏️ Edit</a>
              <a href="?delete_id=<?= $row['id'] ?>" class="delete-btn" onclick="return confirm('Delete this activity?')">🗑 Delete</a>
            </div>
          </div>
        </div>
    <?php $i++; endforeach; ?>
    <?php else: ?><p>No ongoing activities.</p><?php endif; ?>
    
    <!-- 📌 Upcoming -->
    <span class="line"></span>
    <h1 id="section-upcoming" class="admin-header"><span class="hover-underline">📌 Upcoming</span></h1>
    <span class="line"></span>  
    <?php if (!empty($coming)): ?>
    <?php $i = 1; foreach ($coming as $row): ?>
        <div class="admin-activity-card">
          <div class="activity-flex">
            <a href="edit_activity.php?id=<?= $row['id'] ?>" class="activity-edit-link">
              <?php if (!empty($row['image_path'])): ?>
                <div class="admin-activity-thumbnail">
                  <img src="<?= htmlspecialchars($row['image_path']) ?>" alt="Activity Thumbnail" class="activity-image">
                </div>
        <?php else: ?><p>No Image activities.</p><?php endif; ?>
      </a>
      <div class="admin-activity-stats">
        <a href="edit_activity.php?id=<?= $row['id'] ?>" class="activity-edit-link">
          <h3><?= $i . '. ' . htmlspecialchars($row['title']) ?></h3>
        </a>
        <div class="admin-activity-meta">
          📅 <?= $row['event_date'] ?><br>
          🕒 <?= $row['start_time'] ?> – <?= $row['end_time'] ?><br>
          📍 <?= htmlspecialchars($row['location']) ?>
        </div>
        <div class="admin-activity-description"><?= nl2br(htmlspecialchars($row['description'])) ?></div>
        <?php if (!empty($row['external_link'])): ?>
          <div class="admin-activity-link">🔗 <a href="<?= htmlspecialchars($row['external_link']) ?>" target="_blank">External Link</a></div>
          <?php endif; ?>
        </div>
        <div class="admin-activity-actions">
          <a href="edit_activity.php?id=<?= $row['id'] ?>" class="edit-btn">✏️ Edit</a>
          <a href="?delete_id=<?= $row['id'] ?>" class="delete-btn" onclick="return confirm('Delete this activity?')">🗑 Delete</a>
        </div>
      </div>
    </div>
    <?php $i++; endforeach; ?>
    <?php else: ?><p>No upcoming activities.</p><?php endif; ?>
      
      
      <!-- ⏳ Past -->
      <span class="line"></span>
      <h1 id="section-past" class="admin-header"><span class="hover-underline">⏳ Past Activities</span></h1>
      <span class="line"></span>
      <?php if (!empty($past)): ?>
      <?php $i = 1; foreach ($past as $row): ?>
          <div class="admin-activity-card">
    <div class="activity-flex">
      <a href="edit_activity.php?id=<?= $row['id'] ?>" class="activity-edit-link">
        <?php if (!empty($row['image_path'])): ?>
          <div class="admin-activity-thumbnail">
            <img src="<?= htmlspecialchars($row['image_path']) ?>" alt="Activity Thumbnail" class="activity-image">
          </div>
        <?php else: ?><p>No Image activities.</p><?php endif; ?>

        </a>
        <div class="activity-activities-stats">
          <a href="edit_activity.php?id=<?= $row['id'] ?>" class="activity-edit-link">
            <h3><?= $i . '. ' . htmlspecialchars($row['title']) ?></h3>
          </a>
          <div class="admin-activity-meta">
            📅 <?= $row['event_date'] ?><br>
            🕒 <?= $row['start_time'] ?> – <?= $row['end_time'] ?><br>
            📍 <?= htmlspecialchars($row['location']) ?>
          </div>
          <div class="admin-activity-description"><?= nl2br(htmlspecialchars($row['description'])) ?></div>
        <?php if (!empty($row['external_link'])): ?>
        <div class="admin-activity-link">🔗 <a href="<?= htmlspecialchars($row['external_link']) ?>" target="_blank">External Link</a></div>
        <?php endif; ?>
      </div>
      <div class="admin-activity-actions">
        <a href="edit_activity.php?id=<?= $row['id'] ?>" class="edit-btn">✏️ Edit</a>
        <a href="?delete_id=<?= $row['id'] ?>" class="delete-btn" onclick="return confirm('Delete this activity?')">🗑 Delete</a>
      </div>
    </div>
  </div>
<?php $i++; endforeach; ?>
<?php else: ?><p>No past activities.</p><?php endif; ?>

</div>  
</div>
</body>
</html>
