<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Debug: Log session variables
error_log("view_membership.php accessed. Session: " . print_r($_SESSION, true));

$currentPage = basename($_SERVER['PHP_SELF']);
include 'connection.php';
include 'auth.php';

// 🔒 Secure Access: Check page permissions
if (!isset($_SESSION['admin_id']) || !isset($_SESSION['role_id'])) {
    error_log("view_membership.php: Session check failed. admin_id: " . ($_SESSION['admin_id'] ?? 'not set') . ", role_id: " . ($_SESSION['role_id'] ?? 'not set'));
    header("Location: login.php");
    exit;
}

if (!checkPagePermission($conn, $currentPage, $_SESSION['role_id'])) {
    error_log("view_membership.php: Permission denied for role_id: " . $_SESSION['role_id'] . ", page: $currentPage");
    header("Location: no_access.php"); // Redirect to no_access.php
    exit;
}

// 🔍 Fetch existing activity
$id = intval($_GET['id'] ?? 0);
$query = mysqli_query($conn, "SELECT * FROM activities WHERE id = $id");
$activity = mysqli_fetch_assoc($query);

if (!$activity) {
    echo "<p>Activity not found.</p>";
    exit;
}

// 🔁 Handle update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title         = trim($_POST['title']);
    $description   = trim($_POST['description']);
    $event_date    = $_POST['event_date'];
    $start_time    = $_POST['start_time'];
    $end_time      = $_POST['end_time'];
    $location      = trim($_POST['location']);
    $external_link = trim($_POST['external_link']);

    // 📷 Image handling
    $image_path = $activity['image_path']; // default to old image
    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        $upload_dir = 'uploads/events/';
        if (!file_exists($upload_dir)) mkdir($upload_dir, 0777, true);

        $filename    = uniqid('event_') . '_' . basename($_FILES['image']['name']);
        $target_path = $upload_dir . $filename;

        if (move_uploaded_file($_FILES['image']['tmp_name'], $target_path)) {
            $image_path = $target_path;
        }
    }

    // 💾 Update database
    $stmt = mysqli_prepare($conn, "UPDATE activities SET title=?, description=?, image_path=?, event_date=?, start_time=?, end_time=?, location=?, external_link=? WHERE id=?");
    mysqli_stmt_bind_param($stmt, "ssssssssi", $title, $description, $image_path, $event_date, $start_time, $end_time, $location, $external_link, $id);
    mysqli_stmt_execute($stmt);

    header("Location: view_activity.php");
    exit;
}

include 'navbar.php';
include 'navbar_admin.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Activity</title>
    <link rel="stylesheet" href="styles/style.css">
</head>
<body>

<div class="admin-content">
    <div class="admin-navbar">
        <div><strong>✏️ Edit Activity</strong></div>
        <a href="view_activity.php" class="backto-view">← Back to Activity</a>
    </div>
<div class="add-activity-container">
    <div class="center-div">
    <?php if (!empty($activity['image_path'])): ?>
        <div class="admin-activity-thumbnail centered-thumbnail">
            <label for="image" class="clickable-thumbnail" title="Click to change image">
                <img src="<?= htmlspecialchars($activity['image_path']) ?>" alt="Current Image" class="activity-image">
            </label>
        </div>
    <?php endif; ?>
    </div>
    <input type="file" name="image" id="image" accept="image/*" style="display:none;">

    <form class="add-activity-form" method="POST" enctype="multipart/form-data">
        <label for="title">Activity Title</label>
        <input type="text" name="title" id="title" value="<?= htmlspecialchars($activity['title']) ?>" required>

        <label for="description">Description</label>
        <textarea name="description" id="description" rows="5" required><?= htmlspecialchars($activity['description']) ?></textarea>

        <label for="event_date">Date</label>
        <input type="date" name="event_date" id="event_date" value="<?= $activity['event_date'] ?>" required>

        <label for="start_time">Start Time</label>
        <input type="time" name="start_time" id="start_time" value="<?= $activity['start_time'] ?>" required>

        <label for="end_time">End Time</label>
        <input type="time" name="end_time" id="end_time" value="<?= $activity['end_time'] ?>" required>

        <label for="location">Location</label>
        <input type="text" name="location" id="location" value="<?= htmlspecialchars($activity['location']) ?>" required>

        <label for="external_link">External Link (optional)</label>
        <input type="url" name="external_link" id="external_link" value="<?= htmlspecialchars($activity['external_link']) ?>">

        <button type="submit">Update Activity</button>
    </form>
</div>
</div>
</body>
</html>
