<?php
session_start();
include 'connection.php';

// Only run process if form submitted (POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // 1. Collect and sanitize form inputs
    $first_name   = trim($_POST['first_name']);
    $last_name    = trim($_POST['last_name']);
    $phone        = trim($_POST['phone']);
    $email        = trim($_POST['email']);
    $street       = trim($_POST['street']);
    $city         = trim($_POST['city']);
    $state        = $_POST['state'];
    $postcode     = trim($_POST['postcode']);
    $enquiry_type = $_POST['enquiry'];
    $message      = trim($_POST['message']);
    $address      = $street; // For column mapping

    // 2. Insert into enquiry table (without ticket_id first)
    $sql = "INSERT INTO enquiry (
        first_name, last_name, email, phone, address, postcode, city, state, enquiry_type, message
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param(
        $stmt,
        "ssssssssss",
        $first_name,
        $last_name,
        $email,
        $phone,
        $address,
        $postcode,
        $city,
        $state,
        $enquiry_type,
        $message
    );

    if (mysqli_stmt_execute($stmt)) {
        $last_id = mysqli_insert_id($conn);
        $ticket_id = "ENQ-" . str_pad($last_id, 4, "0", STR_PAD_LEFT);

        // Update ticket_id in DB
        $update_sql = "UPDATE enquiry SET ticket_id = ? WHERE id = ?";
        $update_stmt = mysqli_prepare($conn, $update_sql);
        mysqli_stmt_bind_param($update_stmt, "si", $ticket_id, $last_id);
        mysqli_stmt_execute($update_stmt);

        // ---------- SHOW THANK YOU PAGE BELOW ----------
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
          <meta charset="UTF-8">
          <title>Thank You | Brew & Go</title>
          <meta name="viewport" content="width=device-width, initial-scale=1.0">
          <meta name="robots" content="noindex, nofollow">
          <link rel="stylesheet" href="styles/style.css">
        </head>
        <body>
          <div class="thankyou-content">
            <div class="thankyou-box">
              <h1>📬 Thank You for Your Enquiry!</h1>
              <div class="ticket-line">Ticket ID: <?= htmlspecialchars($ticket_id) ?></div>

              <h3>We’ve received the following details:</h3>
              <p><strong>Name:</strong> <?= htmlspecialchars($first_name . ' ' . $last_name) ?></p>
              <p><strong>Email:</strong> <?= htmlspecialchars($email) ?></p>
              <p><strong>Phone:</strong> <?= htmlspecialchars($phone) ?></p>
              <p><strong>Message:</strong><br><?= nl2br(htmlspecialchars($message)) ?></p>
              <p>Our team will be in touch with you shortly. This summary is for your reference.</p>
              <a href="index.php" class="back-button">Back to Home</a>
            </div>
          </div>
        </body>
        </html>
        <?php
        exit;
    } else {
        echo "<p style='color:red;'>❌ Submission failed: " . mysqli_error($conn) . "</p>";
    }

} else {
    // If not a POST request, show error or redirect
    header("Location: enquiry.php");
    exit;
}
?>
