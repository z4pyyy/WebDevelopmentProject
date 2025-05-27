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



// 🔁 Insert logic
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title         = trim($_POST['title']);
    $description   = trim($_POST['description']);
    $event_date    = $_POST['event_date'];
    $start_time    = $_POST['start_time'];
    $end_time      = $_POST['end_time'];
    $location      = trim($_POST['location']);
    $external_link = trim($_POST['external_link']);

    // 📷 Handle image upload
    $image_path = '';
    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        $upload_dir = 'uploads/events/';
        if (!file_exists($upload_dir)) mkdir($upload_dir, 0777, true);

        $filename     = uniqid('event_') . '_' . basename($_FILES['image']['name']);
        $target_path  = $upload_dir . $filename;

        move_uploaded_file($_FILES['image']['tmp_name'], $target_path);
        $image_path = $target_path;
    }

    // 💾 Insert into DB (NO `type`)
    $stmt = mysqli_prepare($conn, "INSERT INTO activities (title, description, image_path, event_date, start_time, end_time, location, external_link)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    mysqli_stmt_bind_param($stmt, "ssssssss", $title, $description, $image_path, $event_date, $start_time, $end_time, $location, $external_link);
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
    <title>Add Activity</title>
    <link rel="stylesheet" href="styles/style.css">
</head>
<body>
    <div class="admin-content">
        <div class="admin-navbar">
            <div><strong>➕ Add New Activity</strong></div>
            <a href="view_activity.php" class="backto-view">← Back to Activity</a>
        </div>
<div class="add-activity-container">

    <form class="add-activity-form" method="POST" enctype="multipart/form-data">
        <label for="title">Activity Title</label>
        <input type="text" name="title" id="title" required>

        <label for="description">Description</label>
        <textarea name="description" id="description" rows="5" required></textarea>

        <label for="event_date">Date</label>
        <input type="date" name="event_date" id="event_date" required>

        <label for="start_time">Start Time</label>
        <input type="time" name="start_time" id="start_time" required>

        <label for="end_time">End Time</label>
        <input type="time" name="end_time" id="end_time" required>

        <label for="location">Location</label>
        <input type="text" name="location" id="location" required>

        <label for="external_link">External Link (optional)</label>
        <input type="url" name="external_link" id="external_link">

        <label for="image">Image Upload</label>
        <input type="file" name="image" id="image" accept="image/*">

        <button type="submit">Add Activity</button>
    </form>
</div>
</div>
</body>
</html>
