<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include 'connection.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

$enquiry_id = intval($_POST['enquiry_id']);
$new_status = $_POST['status'];

$allowed_statuses = ['Pending', 'In Progress', 'Resolved'];
if (!in_array($new_status, $allowed_statuses)) {
    die("❌ Invalid status.");
}

$update_sql = "UPDATE enquiry SET status = ? WHERE id = ?";
$stmt = mysqli_prepare($conn, $update_sql);
mysqli_stmt_bind_param($stmt, "si", $new_status, $enquiry_id);

if (mysqli_stmt_execute($stmt)) {
    header("Location: view_enquiry.php?success=1");
} else {
    die("❌ Failed to update status: " . mysqli_error($conn));
}
?>
