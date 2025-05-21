<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
echo '<pre>';
print_r($_SESSION);
echo '</pre>';

// ✅ SECURITY CHECK: only allow roles 1 (admin), 2 (operator), 3 (staff)
if (!isset($_SESSION['admin_id']) || !isset($_SESSION['role_id']) || !in_array($_SESSION['role_id'], [1, 2, 3])) {
    header("Location: login.php");
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
                <div class="admin-card">
                    <h5>👥 Members</h5>
                    <p>Manage and view all registered members.</p>
                    <a href="view_membership.php" class="admin-btn">View Members</a>
                </div>
                <div class="admin-card">
                    <h5>📩 Enquiries</h5>
                    <p>View submitted customer enquiries.</p>
                    <a href="view_enquiry.php" class="admin-btn">View Enquiries</a>
                </div>
                <div class="admin-card">
                    <h5>💼 Job Applications</h5>
                    <p>Check incoming applications for openings.</p>
                    <a href="view_job.php" class="admin-btn">View Applications</a>
                </div>
                <div class="admin-card">
                  <h5>📅 Activities</h5>
                  <p>Manage and schedule activities & events.</p>
                  <a href="view_activity.php" class="admin-btn">Manage Activities</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
