<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

include 'connection.php';

$user_id = $_SESSION['user_id'];

$sql = "SELECT m.profile_picture, m.first_name, m.last_name, m.email, m.phone, m.registered_at,
               m.member_id, m.wallet, m.points, m.sex, m.nationality, m.address,
               IF(m.wallet >= 30, 'Active', 'Expired') AS status
        FROM user u
        JOIN membership m ON u.membership_id = m.id
        WHERE u.id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$member = mysqli_fetch_assoc($result);
$maxPoints = 10000;
$pointsProgress = min(100, ($member['points'] / $maxPoints) * 100);
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
<body class="product-page">
  <div id="top"></div>
  <header>
    <?php include 'navbar.php'; ?>
  </header>

  <section class="member-dashboard">
    <h2>Good day, <span class="member-name"><?= htmlspecialchars($member['first_name']) ?></span>!</h2>

    <div class="member-profile-wrapper" style="text-align: center; margin-bottom: 20px;">
      <form action="update_profile.php" method="POST" enctype="multipart/form-data" style="display:inline-block;">
        <input type="hidden" name="update_type" value="picture">
        <label for="profilePicInput" style="cursor: pointer; display: inline-block;">
          <img 
            src="<?= $member['profile_picture'] ? htmlspecialchars($member['profile_picture']) : 'images/default-profile.png' ?>" alt="Profile Picture" >
          <p>Click to change picture</p>
        </label>
        <input 
          type="file" 
          id="profilePicInput" 
          name="profile_picture" 
          accept="image/*" 
          style="display: none;"
          onchange="this.form.submit();">
      </form>
    </div>

    <div class="rewards-box">
      <div class="star-icon">⭐</div>
      <div class="reward-points">
        <h3><?= number_format($member['points'] ?? 0, 0) ?></h3>
        <p>Total Stars Earned</p>
      </div>
      <div class="progress-bar">
          <span class="star" style="left: 50%">★<br>50k</span>
          <span class="star" style="left: 90%">★<br>100k</span>
          <div class="fill" style="width: <?= $pointsProgress ?>%;"></div>
          <div class="progress-label"><?= number_format($pointsProgress, 1) ?>%</div>
      </div>
    </div>

    <div class="member-info">
      <h3>👤 Account Details</h3>
      <ul>
        <li><strong>Member ID:</strong> <?= $member['member_id'] ?? 'N/A' ?></li>
        <li><strong>Email:</strong> <?= htmlspecialchars($member['email']) ?></li>
        <li><strong>Phone:</strong> <?= htmlspecialchars($member['phone']) ?></li>
        <li><strong>Status:</strong> <?= $member['status'] ?></li>
        <li><strong>Wallet:</strong> RM <?= number_format($member['wallet'] ?? 0, 2) ?></li>
        <li style="margin-top: 10px;">
          <form action="update_profile.php" method="POST" style="display:inline-block;">
            <input type="hidden" name="update_type" value="topup">
            <select name="topup_amount" class="topup-input" required>
              <option value="">Top-Up Amount</option>
              <option value="30">RM30</option>
              <option value="50">RM50</option>
              <option value="100">RM100</option>
              <option value="200">RM200</option>
            </select>
            <button type="submit" class="topup-button">Top Up</button>
          </form>
        </li>
        <li><strong>Nationality:</strong> <?= htmlspecialchars($member['nationality'] ?? '-') ?></li>
        <li><strong>Sex:</strong> <?= htmlspecialchars($member['sex'] ?? '-') ?></li>
        <li><strong>Address:</strong> <?= htmlspecialchars($member['address'] ?? '-') ?></li>
      </ul>
    </div>

    <div class="member-actions">
      <h3>✏️ Update My Info</h3>
      <form action="update_profile.php" method="POST" enctype="multipart/form-data" class="member-update-form">
        <input type="hidden" name="update_type" value="details">
        <input type="text" name="first_name" value="<?= htmlspecialchars($member['first_name']) ?>" placeholder="First Name" required>
        <input type="text" name="last_name" value="<?= htmlspecialchars($member['last_name']) ?>" placeholder="Last Name" required>
        <input type="email" name="email" value="<?= htmlspecialchars($member['email']) ?>" placeholder="Email" required>
        <input type="text" name="phone" value="<?= htmlspecialchars($member['phone']) ?>" placeholder="Phone" required>
        <textarea name="address" placeholder="Address"><?= htmlspecialchars($member['address'] ?? '') ?></textarea>
        <select name="sex">
          <option value="">-- Select Sex --</option>
          <option value="Male" <?= ($member['sex'] ?? '') === 'Male' ? 'selected' : '' ?>>Male</option>
          <option value="Female" <?= ($member['sex'] ?? '') === 'Female' ? 'selected' : '' ?>>Female</option>
        </select>
        <input type="text" name="nationality" value="<?= htmlspecialchars($member['nationality'] ?? '') ?>" placeholder="Nationality">
        <button type="submit">Update Profile</button>
      </form>
    </div>
  </section>

  <?php include 'footer.php'; ?>
</body>
</html>
