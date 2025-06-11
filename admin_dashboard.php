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
                <a href="view_job.php" class="admin-card-link">
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
                <a href="view_product.php" class="admin-card-link">
                  <div class="admin-card">
                  <h5>🏷️ Products</h5>
                  <p>Manage current products and availability.</p>
                  </div>
                </a>
                <a href="view_newsletter.php" class="admin-card-link">
                  <div class="admin-card">
                  <h5>📰 Newsletter</h5>
                  <p>View and manage Newsletter and Subscriber.</p>
                  </div>
                </a>
                <a href="view_permissions.php" class="admin-card-link">
                  <div class="admin-card">
                  <h5>👮 Permissions</h5>
                  <p>View and manage User Permissions.</p>
                  </div>
                </a>
            </div>
        </div>
    </div>
</body>
</html>
