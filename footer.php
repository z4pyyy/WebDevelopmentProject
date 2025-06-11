<?php
// Newsletter subscribe logic (put this at the top of your footer.php, before the HTML)
$newsletter_msg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['footer_subscribe'])) {
    require_once 'connection.php';
    $email = trim($_POST['footer_email']);
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $newsletter_msg = '<span style="color:#c0392b;">Please enter a valid email address.</span>';
    } else {
        // Check if already subscribed
        $stmt = mysqli_prepare($conn, "SELECT id FROM newsletter_subscribers WHERE email = ?");
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);
        if (mysqli_stmt_num_rows($stmt) > 0) {
            $newsletter_msg = '<span style="color:#f39c12;">You have already subscribed!</span>';
        } else {
            // Insert new subscriber
            $stmt = mysqli_prepare($conn, "INSERT INTO newsletter_subscribers (email) VALUES (?)");
            mysqli_stmt_bind_param($stmt, "s", $email);
            if (mysqli_stmt_execute($stmt)) {
                $newsletter_msg = '<span style="color:#27ae60;">Thank you for subscribing!</span>';
            } else {
                $newsletter_msg = '<span style="color:#c0392b;">Subscription failed. Please try again.</span>';
            }
        }
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
    }
}
?>

<footer class="footer">
  <div class="footer-container">

    <!-- Column 1: Developers -->
    <div class="footer-column">
      <p class="footer-header">DEVELOPED BY</p>
      <p><a href="profile1.php">Terence Wong</a></p>
      <p><a href="profile2.php">Darren Chong</a></p>
      <p><a href="profile3.php">Hans Yee</a></p>
      <p><a href="profile4.php">Jared Teh</a></p>
    </div>

    <!-- Column 2: Acknowledgement -->
    <div class="footer-column">
      <p class="footer-header">ACKNOWLEDGEMENT</p>
      <p><a href="acknowledgement.php">Acknowledgement</a></p>
      <p><a href="enhancements.php">Enhancements</a></p>
      <p><a href="https://youtu.be/vTK2mGx1TK8">Presentation Video</a></p>
    </div>

    <!-- Column 3: Subscription -->
    <div class="footer-column">
      <p class="footer-header">SUBSCRIBE EMAIL</p>
      <form class="subscribe-form" action="#footer" method="post" autocomplete="off">
        <input type="email" name="footer_email" placeholder="Enter your email" required>
        <button type="submit" class="btn-index-subscribe" name="footer_subscribe">Subscribe</button>
        <?php if (!empty($newsletter_msg)) echo "<div class='newsletter-msg'>{$newsletter_msg}</div>"; ?>
      </form>
    </div>

    <!-- Column 4: Social Links -->
    <div class="footer-column">
      <p class="footer-header">MORE ABOUT US</p>
      <div class="social-icons">
        <a href="https://www.instagram.com/brewngo.coffee/" target="_blank"><img src="images/Instagram.png" alt="Instagram"></a>
        <a href="https://www.facebook.com/profile.php?id=61554234958482" target="_blank"><img src="images/Meta.png" alt="Facebook"></a>
        <a href="#"><img src="images/Whatsapp.png" alt="Whatsapp"></a>
        <a href="mailto:104404059@students.swinburne.edu.my"><img src="images/Mail.png" alt="Mail"></a>
      </div>
    </div>
  </div>

  <div class="footer-bottom">
    <a href="#top"><p class="footer-brand">BREW & GO</p></a>
    <p>© COPYRIGHT 2025 BREW & GO</p>
  </div>
</footer>
