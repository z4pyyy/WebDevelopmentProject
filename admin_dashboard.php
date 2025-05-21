<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
// ✅ SECURITY CHECK: only allow roles 1 (admin), 2 (operator), 3 (staff)
if (!isset($_SESSION['admin_id']) || !isset($_SESSION['role_id']) || !in_array($_SESSION['role_id'], [1, 2, 3])) {
    header("Location: login.php");
    exit;
}

$currentPage = basename($_SERVER['PHP_SELF']);
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
  </div>  
        <div class="admin-dashboard">
            <h2>Dashboard Overview</h2>

            <div class="admin-card-grid">
                  <a href="view_membership.php" class="admin-card-link">
                    <div class="admin-card">
                      <h5>👥 Members</h5>
                      <p>Manage and view all registered members.</p>
                    </div>
                  </a>

                  <a href="view_enquiry.php" class="admin-card-link">
                    <div class="admin-card">
                      <h5>📩 Enquiries</h5>
                      <p>View submitted customer enquiries.</p>
                    </div>
                  </a>
                <a href="view_jon.php" class="admin-card-link">
                  <div class="admin-card">
                    <h5>💼 Job Applications</h5>
                    <p>Check incoming applications for openings.</p>
                  </div>
                </a>
                <a href="view_activity.php" class="admin-card-link">
                  <div class="admin-card">
                    <h5>📅 Activities</h5>
                  <p>Manage and schedule activities & events.</p>
                  </div>
                </a>  
                <a href="view_activity.php" class="admin-card-link">
                  <div class="admin-card">
                  <h5>🏷️ Products</h5>
                  <p>Manage current products and availability.</p>
                  </div>
                </a>
            </div>
        </div>
    </div>
</body>
</html>
