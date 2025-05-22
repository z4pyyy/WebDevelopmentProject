<?php
session_start();
// In a future version, this data would be passed or queried
$ticket_id = "ENQ-" . str_pad(rand(1, 9999), 4, "0", STR_PAD_LEFT);
$first_name = $_SESSION['enquiry_data']['first_name'] ?? 'John';
$last_name = $_SESSION['enquiry_data']['last_name'] ?? 'Doe';
$email = $_SESSION['enquiry_data']['email'] ?? 'customer@example.com';
$phone = $_SESSION['enquiry_data']['phone'] ?? '+60123456789';
$message = $_SESSION['enquiry_data']['message'] ?? 'Thank you for reaching out!';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Thank You | Brew & Go</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="robots" content="noindex, nofollow">
  <link rel="stylesheet" href="styles/style.css">
  <style>
    body, html {
      margin: 0;
      padding: 0;
      height: 100%;
      font-family: 'Outfit', sans-serif;
    }

    .thankyou-content {
      background-image: url('images/thankyou2.png');
      background-size: cover;
      background-position: center 30%;
      background-repeat: no-repeat;
      background-blend-mode: overlay;
      background-color: rgba(0, 0, 0, 0.5);
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100%;
    }

    .thankyou-box {
      background-color: rgba(255, 255, 255, 0.95);
      color: #222;
      padding: 40px 30px;
      border-radius: 12px;
      max-width: 550px;
      width: 90%;
      box-shadow: 0 15px 35px rgba(0, 0, 0, 0.3);
      text-align: left;
    }

    .thankyou-box h1 {
      font-size: 2rem;
      margin-bottom: 10px;
      color: #4CAF50;
    }

    .thankyou-box h3 {
      margin-top: 20px;
      font-size: 1.2rem;
      font-weight: 600;
      color: #333;
    }

    .thankyou-box p {
      font-size: 1rem;
      line-height: 1.6;
      margin-bottom: 15px;
    }

    .ticket-line {
      background-color: #eee;
      padding: 10px 15px;
      font-weight: bold;
      font-family: monospace;
      border-left: 4px solid #4CAF50;
      margin: 20px 0;
    }

    .back-button {
      display: inline-block;
      padding: 10px 20px;
      background-color: #4CAF50;
      color: white;
      text-decoration: none;
      border-radius: 6px;
      margin-top: 15px;
    }

    .back-button:hover {
      background-color: #43a047;
    }
  </style>
</head>
<body>
  <div class="thankyou-content">
    <div class="thankyou-box">
      <h1>📬 Thank You for Your Enquiry!</h1>
      <div class="ticket-line">Ticket ID: <?= $ticket_id ?></div>

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
