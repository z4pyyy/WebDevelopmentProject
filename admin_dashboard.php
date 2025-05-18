<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}
include 'navbar.php';
include 'navbar_admin.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Dashboard | Brew & Go</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="styles/style.css">
</head>

<body>
  <div class="admin-content">
    <div class="admin-navbar">
      <div><strong>Welcome, Admin</strong></div>
      <div><a href="logout.php" class="admin-logout-button">Logout</a></div>
    </div>

    <div class="admin-dashboard">
      <h2>Dashboard Overview</h2>
      <p>This is your Brew & Go admin panel. Use the sidebar to manage users, enquiries, jobs and more.</p>

      <div class="admin-card-grid">
        <div class="admin-card">
          <h5>👥 Members</h5>
          <p>Manage and view all registered members.</p>
          <a href="view_membership.php" class="admin-btn">View Members</a>
        </div>
        <div class="admin-card">
          <h5>📩 Enquiries</h5>
          <p>View submitted customer enquiries.</p>
          <a href="#" class="admin-btn">View Enquiries</a>
        </div>
        <div class="admin-card">
          <h5>💼 Job Applications</h5>
          <p>Check incoming applications for openings.</p>
          <a href="#" class="admin-btn">View Applications</a>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
