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
    <title>Add New Member | Brew & Go Admin</title>
    <link rel="stylesheet" href="styles/style.css">
</head>
<body>
<div class="admin-content">
    <div class="admin-navbar">
        <div><strong>➕ Add New Member</strong></div>
        <a href="view_membership.php" class="backto-view">← Back to Member List</a>
    </div>
    <div class="add-item-container">
        <h1>Add New Member</h1>
        <?php if (!empty($errors)): ?>
            <div class="form-errors">
                <h4>⚠ Please correct the following:</h4>
                <ul>
                    <?php foreach ($errors as $error): ?>
                        <li>❌ <?= htmlspecialchars($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>
        <form action="process_add_member.php" method="post" autocomplete="off" class="admin-add-member-form">
            <div class="form-group">
                <label for="username">Username<span style="color:red">*</span></label>
                <input type="text" id="username" name="username" class="add-member-form" required minlength="3" pattern="[A-Za-z]{3,}" value="<?= htmlspecialchars($input['username'] ?? '') ?>">
            </div>
            <div class="form-group">
                <label for="first_name">First Name<span style="color:red">*</span></label>
                <input type="text" id="first_name" name="first_name" class="add-member-form" required minlength="2" pattern="[A-Za-z]+" value="<?= htmlspecialchars($input['first_name'] ?? '') ?>">
            </div>
            <div class="form-group">
                <label for="last_name">Last Name<span style="color:red">*</span></label>
                <input type="text" id="last_name" name="last_name" class="add-member-form" required minlength="2" pattern="[A-Za-z]+" value="<?= htmlspecialchars($input['last_name'] ?? '') ?>">
            </div>
            <div class="form-group">
                <label for="email">Email<span style="color:red">*</span></label>
                <input type="email" id="email" name="email" class="add-member-form" required value="<?= htmlspecialchars($input['email'] ?? '') ?>">
            </div>
            <div class="form-group">
                <label for="phone">Phone<span style="color:red">*</span></label>
                <input type="text" id="phone" name="phone" class="add-member-form" required minlength="8" maxlength="15" pattern="[0-9]+" value="<?= htmlspecialchars($input['phone'] ?? '') ?>">
            </div>
            <div class="form-group">
                <label for="password">Password<span style="color:red">*</span></label>
                <input type="password" id="password" name="password" class="add-member-form" required>
            </div>
            <div class="form-group">
                <label for="confirm_password">Confirm Password<span style="color:red">*</span></label>
                <input type="password" id="confirm_password" name="confirm_password" class="add-member-form" required>
            </div>
            <div class="form-actions">
                <button type="submit" class="save-edit-button">Add Member</button>
                <button type="reset" class="cancel-edit-button">Reset</button>
            </div>
        </form>
    </div>
</div>
</body>
</html>
