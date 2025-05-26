<?php
session_start();
$currentPage = basename($_SERVER['PHP_SELF']);
require_once 'connection.php';
include 'navbar.php';
include 'navbar_admin.php';

// Only allow admin (role_id 1)
if (!isset($_SESSION['admin_id']) || ($_SESSION['role_id'] ?? 0) != 1) {
    header("Location: login.php");
    exit;
}

$feedback = '';
if (isset($_SESSION['newsletter_feedback'])) {
    $feedback = $_SESSION['newsletter_feedback'];
    unset($_SESSION['newsletter_feedback']);
}


// === PHPMailer include & settings ===
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
use PHPMailer\PHPMailer\PHPMailer;

// SMTP Settings (edit these for your sender!)
$mail_host = 'smtp.gmail.com';             // e.g. smtp.gmail.com
$mail_username = 'zapydevtest@gmail.com';  // your sending address
$mail_password = 'zebw zcxr vesx fvsc';      // app password or SMTP password
$mail_from = 'zapydevtest@gmail.com';   // sender shown to recipients
$mail_from_name = 'Brew & Go Newsletter';  // display name

// Handle newsletter sending
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['newsletter_send'])) {
    $subject = trim($_POST['subject'] ?? '');
    $body = trim($_POST['body'] ?? '');
    $attachment_path = '';

    // Handle file upload (if any)
    if (!empty($_FILES['attachment']['name']) && $_FILES['attachment']['error'] === UPLOAD_ERR_OK) {
        $allowed_ext = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'pdf'];
        $ext = strtolower(pathinfo($_FILES['attachment']['name'], PATHINFO_EXTENSION));
        if (in_array($ext, $allowed_ext)) {
            $target_dir = 'uploads/newsletter/';
            if (!is_dir($target_dir)) mkdir($target_dir, 0777, true);
            $basename = uniqid('newsletter_', true) . '.' . $ext;
            $attachment_path = $target_dir . $basename;
            move_uploaded_file($_FILES['attachment']['tmp_name'], $attachment_path);
        } else {
            $feedback = "<span style='color:#c0392b;'>Attachment type not allowed. Only image/PDF accepted.</span>";
        }
    }

    if ($subject && $body && !$feedback) {
        // Get all subscriber emails
        $emails = [];
        $res = mysqli_query($conn, "SELECT email FROM newsletter_subscribers");
        while ($row = mysqli_fetch_assoc($res)) {
            $emails[] = $row['email'];
        }

        $email_count = 0;
        $send_errors = [];
        foreach ($emails as $to) {
            $mail = new PHPMailer(true);
            try {
                $mail->isSMTP();
                $mail->Host = $mail_host;
                $mail->SMTPAuth = true;
                $mail->Username = $mail_username;
                $mail->Password = $mail_password;
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;

                $mail->setFrom($mail_from, $mail_from_name);
                $mail->addAddress($to);

                $mail->isHTML(true);
                $mail->Subject = $subject;
                $mail->Body = $body;

                // Add attachment if any
                if ($attachment_path && file_exists($attachment_path)) {
                    $mail->addAttachment($attachment_path);
                }

                $mail->send();
                $email_count++;
            } catch (Exception $e) {
                $send_errors[] = "Email to $to failed: " . $mail->ErrorInfo;
            }
        }

        if ($email_count > 0) {
            // Save history (only saves path if there was an attachment)
            $bodyForDb = mysqli_real_escape_string($conn, $body);
            $subjectForDb = mysqli_real_escape_string($conn, $subject);
            $attachmentDb = $attachment_path ? mysqli_real_escape_string($conn, $attachment_path) : null;
            $sql = "INSERT INTO newsletter_history (subject, body, attachment_path) VALUES ('$subjectForDb', '$bodyForDb', " . ($attachmentDb ? "'$attachmentDb'" : "NULL") . ")";
            mysqli_query($conn, $sql);
        }


        if (empty($send_errors)) {
            $_SESSION['newsletter_feedback'] = "<span style='color:#27ae60;'>Newsletter sent to $email_count subscribers.</span>";
        } else {
            $_SESSION['newsletter_feedback'] = "<span style='color:#c0392b;'>Some emails failed:<br>" . implode('<br>', $send_errors) . "</span>";
        }
        header("Location: admin_newsletter.php");
        exit;
    } else if (!$subject || !$body) {
        $feedback = "<span style='color:#c0392b;'>Please enter subject and message.</span>";
    }
}

// Fetch all subscribers for display
$subscribers = mysqli_query($conn, "SELECT * FROM newsletter_subscribers ORDER BY subscribed_at DESC");
// Fetch all newsletter history for display
$history = mysqli_query($conn, "SELECT * FROM newsletter_history ORDER BY sent_at DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Newsletter Panel | Brew & Go Admin</title>
    <link rel="stylesheet" href="styles/style.css">
</head>
<body>
    <div class="admin-navbar">
        <div><strong>📰 Newsletter Panel</strong></div>
    </div>
<div class="admin-newsletter-wrapper">
<div class="admin-newsletter-panel">
    <h3>Send Newsletter</h3>
    <?php if (!empty($feedback)): ?>
        <div class="feedback"><?= $feedback ?></div>
    <?php endif; ?>
    <form method="POST" enctype="multipart/form-data">
        <label for="subject" class="newsletter-input">Subject*</label>
        <input type="text" name="subject" id="subject" required>

        <label for="body" class="newsletter-input">Message</label>
        <textarea name="body" id="body" rows="8" required placeholder="Write your newsletter here. HTML allowed for formatting, links, etc."></textarea>

        <label for="attachment" class="newsletter-input">Attachment (image or PDF, optional)</label>
        <input type="file" name="attachment" id="attachment" accept="image/*,.pdf">

        <button type="submit" name="newsletter_send">Send Newsletter</button>
    </form>
</div>
<div class="admin-subscriber-list">
    <div class="view-subscriber-btn">
    <h3>Newsletter Subscribers (<?= mysqli_num_rows($subscribers) ?>)</h3>
        <a href="view_subscriber.php" class="member-subscriber-button">View</a>
    </div>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Email Address</th>
                <th>Subscribed At</th>
            </tr>
        </thead>
        <tbody>
            <?php $n=1; while ($row = mysqli_fetch_assoc($subscribers)): ?>
                <tr>
                    <td><?= $n++ ?></td>
                    <td><?= htmlspecialchars($row['email']) ?></td>
                    <td><?= htmlspecialchars($row['subscribed_at']) ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>
</div>
<div class="admin-newsletter-history-wrapper">
<div class="admin-newsletter-history">
    <h3>Sent Newsletter History (<?= mysqli_num_rows($history) ?>)</h3>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Subject</th>
                <th>Sent At</th>
                <th>Preview</th>
                <th>Attachment</th>
            </tr>
        </thead>
        <tbody>
            <?php $i=1; while ($row = mysqli_fetch_assoc($history)): ?>
                <tr>
                    <td><?= $i++ ?></td>
                    <td><?= htmlspecialchars($row['subject']) ?></td>
                    <td><?= htmlspecialchars($row['sent_at']) ?></td>
                    <td style="max-width:280px;overflow-wrap:anywhere"><?= htmlspecialchars(mb_strimwidth(strip_tags($row['body']), 0, 80, '...')) ?></td>
                    <td>
                        <?php if ($row['attachment_path']): ?>
                            <a href="<?= htmlspecialchars($row['attachment_path']) ?>" target="_blank" class="member-details-button-view">View</a>
                        <?php else: ?>
                            <span>-</span>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>
</div>

</body>
</html>
