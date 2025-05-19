<?php
session_start();
include 'connection.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

$membership_id = $_GET['membership_id'] ?? null;
if (!$membership_id || !is_numeric($membership_id)) {
    die("Invalid membership ID.");
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $first_name = trim($_POST['first_name']);
    $last_name  = trim($_POST['last_name']);
    $email      = trim($_POST['email']);
    $phone      = trim($_POST['phone']);
    $address    = trim($_POST['address']);
    $sex        = $_POST['sex'];
    $nationality = trim($_POST['nationality']);
    $wallet     = floatval($_POST['wallet']);
    $points     = intval($_POST['points']);

    // Status update based on wallet
    $status = ($wallet >= 30) ? 'Active' : 'Expired';

    // Profile picture upload
    $profile_picture = $_POST['existing_picture'];
    if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] === 0) {
        $upload_dir = "uploads/";
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }
        $filename = basename($_FILES['profile_picture']['name']);
        $target_path = $upload_dir . time() . "_" . $filename;
        if (move_uploaded_file($_FILES['profile_picture']['tmp_name'], $target_path)) {
            $profile_picture = $target_path;
        }
    }

    if ($first_name && $last_name && filter_var($email, FILTER_VALIDATE_EMAIL) && $phone !== '') {
        $stmt = mysqli_prepare($conn, "UPDATE membership SET first_name = ?, last_name = ?, email = ?, phone = ?, address = ?, sex = ?, nationality = ?, wallet = ?, points = ?, profile_picture = ?, status = ? WHERE id = ?");
        mysqli_stmt_bind_param($stmt, "sssssssddssi", $first_name, $last_name, $email, $phone, $address, $sex, $nationality, $wallet, $points, $profile_picture, $status, $membership_id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        header("Location: view_membership.php");
        exit;
    } else {
        $error = "Please ensure all fields are valid.";
    }
}

// Fetch member data
$stmt = mysqli_prepare($conn, "SELECT * FROM membership WHERE id = ?");
mysqli_stmt_bind_param($stmt, "i", $membership_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$member = mysqli_fetch_assoc($result);
mysqli_stmt_close($stmt);

if (!$member) {
    die("Member not found.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Member</title>
    <link rel="stylesheet" href="styles/style.css">
    <style>
        .readonly-field {
            background-color: #e9ecef;
            color: #6c757d;
        }
    </style>
</head>
<body>

<?php include 'navbar.php'; ?>
<?php include 'navbar_admin.php'; ?>

<div class="admin-content">
    <?php if (isset($error)): ?>
        <p class="form-error"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <form method="POST" enctype="multipart/form-data" class="edit-form">
        <table class="admin-table">
            <caption>Editing Member Profile</caption>
            <thead>
                <tr><th>Field</th><th>Value</th></tr>
            </thead>
            <tbody>
                <tr>
                    <td>Membership ID</td>
                    <td><input type="text" class="readonly-field" value="<?= 'BNG-' . str_pad($member['id'], 5, '0', STR_PAD_LEFT) ?>" readonly></td>
                </tr>
                <tr>
                    <td>First Name</td>
                    <td><input type="text" name="first_name" value="<?= htmlspecialchars($member['first_name']) ?>" required></td>
                </tr>
                <tr>
                    <td>Last Name</td>
                    <td><input type="text" name="last_name" value="<?= htmlspecialchars($member['last_name']) ?>" required></td>
                </tr>
                <tr>
                    <td>Email</td>
                    <td><input type="email" name="email" value="<?= htmlspecialchars($member['email']) ?>" required></td>
                </tr>
                <tr>
                    <td>Phone</td>
                    <td><input type="text" name="phone" value="<?= htmlspecialchars($member['phone']) ?>" required></td>
                </tr>
                <tr>
                    <td>Address</td>
                    <td><input type="text" name="address" value="<?= htmlspecialchars($member['address']) ?>" ></td>
                </tr>
                <tr>
                    <td>Sex</td>
                    <td>
                        <select name="sex" required>
                            <option value="Male" <?= $member['sex'] === 'Male' ? 'selected' : '' ?>>Male</option>
                            <option value="Female" <?= $member['sex'] === 'Female' ? 'selected' : '' ?>>Female</option>
                            <option value="Other" <?= $member['sex'] === 'Other' ? 'selected' : '' ?>>Other</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Nationality</td>
                    <td><input type="text" name="nationality" value="<?= htmlspecialchars($member['nationality']) ?>" ></td>
                </tr>
                <tr>
                    <td>Wallet (RM)</td>
                    <td><input type="number" name="wallet" step="0.01" value="<?= htmlspecialchars($member['wallet']) ?>" ></td>
                </tr>
                <tr>
                    <td>Points</td>
                    <td><input type="number" name="points" value="<?= htmlspecialchars($member['points']) ?>" ></td>
                </tr>
                <tr>
                    <td>Profile Picture</td>
                    <td>
                        <?php if (!empty($member['profile_picture'])): ?>
                            <img src="<?= $member['profile_picture'] ?>" alt="Profile" width="80"><br>
                        <?php endif; ?>
                        <input type="file" name="profile_picture" accept="image/*">
                        <input type="hidden" name="existing_picture" value="<?= $member['profile_picture'] ?>">
                    </td>
                </tr>
                <tr>
                    <td>Status (Auto)</td>
                    <td><input type="text" class="readonly-field" value="<?= $member['status'] ?>" readonly></td>
                </tr>
                <tr>
                    <td>Registered At</td>
                    <td><input type="text" class="readonly-field" value="<?= $member['registered_at'] ?>" readonly></td>
                </tr>
            </tbody>
        </table>

        <div class="form-actions">
            <button type="submit" class="save-edit-button">Save Changes</button>
            <a href="view_membership.php" class="cancel-edit-button">Cancel</a>
        </div>
    </form>
</div>

</body>
</html>
