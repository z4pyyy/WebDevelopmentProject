<?php
session_start();
$currentPage = basename($_SERVER['PHP_SELF']);
require_once 'connection.php';
include 'navbar.php'; 
include 'navbar_admin.php';

// Only allow admin
if (!isset($_SESSION['admin_id']) || ($_SESSION['role_id'] ?? 0) != 1) {
    header("Location: login.php");
    exit;
}

$feedback = '';
if (isset($_SESSION['subscriber_feedback'])) {
    $feedback = $_SESSION['subscriber_feedback'];
    unset($_SESSION['subscriber_feedback']);
}

// Handle deletion
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_subscriber_id'])) {
    $del_id = intval($_POST['delete_subscriber_id']);
    mysqli_query($conn, "DELETE FROM newsletter_subscribers WHERE id = $del_id");
    $_SESSION['subscriber_feedback'] = "<span style='color:#27ae60;'>Subscriber deleted.</span>";
    header("Location: view_subscriber.php");
    exit;
}

// Fetch all subscribers
$subscribers = mysqli_query($conn, "SELECT * FROM newsletter_subscribers ORDER BY subscribed_at DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>All Newsletter Subscribers | Brew & Go Admin</title>
    <link rel="stylesheet" href="styles/style.css">
</head>

<body>
    <div class="center-div">
    <div class="subscriber-list-wrapper">
        <h2>All Newsletter Subscribers (<?= mysqli_num_rows($subscribers) ?>)</h2>
        <?php if (!empty($feedback)): ?>
            <div class="feedback"><?= $feedback ?></div>
        <?php endif; ?>
        <table class="subscriber-list-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Email Address</th>
                    <th>Subscribed At</th>
                    <th>Delete</th>
                </tr>
            </thead>
            <tbody>
                <?php $n = 1; while ($row = mysqli_fetch_assoc($subscribers)): ?>
                    <tr>
                        <td><?= $n++ ?></td>
                        <td><?= htmlspecialchars($row['email']) ?></td>
                        <td><?= htmlspecialchars($row['subscribed_at']) ?></td>
                        <td>
                            <form method="POST" style="display:inline;">
                                <input type="hidden" name="delete_subscriber_id" value="<?= $row['id'] ?>">
                                <button type="submit" class="subscriber-delete-btn" onclick="return confirm('Delete this subscriber?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <a href="admin_newsletter.php" class="back-link-newsletter">← Back to Newsletter Panel</a>
    </div>
    </div>
</body>
</html>

