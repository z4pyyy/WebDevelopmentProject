<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Debug: Log session state (remove after testing)
error_log("no_access.php accessed. Session: " . print_r($_SESSION, true));

// If the user is not logged in, redirect to login.php
if (!isset($_SESSION['admin_id']) || !isset($_SESSION['role_id'])) {
    error_log("no_access.php: Session check failed. admin_id: " . ($_SESSION['admin_id'] ?? 'not set') . ", role_id: " . ($_SESSION['role_id'] ?? 'not set'));
    header("Location: login.php");
    exit;
}

// Determine redirect based on role_id
$redirect_url = ($_SESSION['role_id'] == 3) ? 'admin_dashboard.php' : 'index.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="refresh" content="2;url=<?php echo htmlspecialchars($redirect_url); ?>">
    <title>Access Denied</title>
    <link rel="stylesheet" href="styles/style.css">

</head>
<body>
    <div class="error-content">
        <div class="admin-navbar">
            <a href="admin_dashboard.php" class="backto-view">← Back to Dashboard</a>
        </div>
        <div class="access-denied-container">
            <div class="error-icon">🚫</div>
            <h1>Access Denied</h1>
            <p>You do not have permission to view this page.</p>
            <p>You will be redirected to the <a href="<?php echo htmlspecialchars($redirect_url); ?>">
                <?php echo ($_SESSION['role_id'] == 3) ? 'dashboard' : 'homepage'; ?>
            </a> in 3 seconds...</p>
        </div>
    </div>
</body>
</html>