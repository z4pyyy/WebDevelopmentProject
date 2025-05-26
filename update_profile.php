<?php
session_start();
include 'connection.php';

$user_id = $_SESSION['user_id'] ?? null;
if (!$user_id) {
    header("Location: login.php");
    exit;
}

// Get membership_id for this user
$query = "SELECT membership_id FROM user WHERE id = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$row = mysqli_fetch_assoc($result);
$membership_id = $row['membership_id'] ?? null;

if (!$membership_id) {
    mysqli_close($conn);
    header("Location: membership.php");
    exit;
}

// Detect type of update
$update_type = $_POST['update_type'] ?? 'full';

if ($update_type === 'picture') {
    // ✅ Picture update
    if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] === 0) {
        $upload_dir = 'uploads/';
        if (!file_exists($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        $filename = basename($_FILES['profile_picture']['name']);
        $target_file = $upload_dir . time() . '_' . $filename;

        if (move_uploaded_file($_FILES['profile_picture']['tmp_name'], $target_file)) {
            $sql = "UPDATE membership SET profile_picture = ? WHERE id = ?";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "si", $target_file, $membership_id);
            mysqli_stmt_execute($stmt);
        }
    }

    mysqli_close($conn);
    header("Location: membership.php");
    exit;
}

if ($update_type === 'topup') {
    // ✅ Top-up update and points increment
    $amount = (int) ($_POST['topup_amount'] ?? 0);
    if (in_array($amount, [30, 50, 100, 200])) {
        // Get current wallet and status
        $query = "SELECT wallet, status FROM membership WHERE id = ?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "i", $membership_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $member = mysqli_fetch_assoc($result);
        $current_wallet = $member['wallet'];
        $current_status = $member['status'];

        $new_wallet = $current_wallet + $amount;
        $new_status = $current_status;

        // If currently Inactive and top-up is >= 30, set status to Active
        if ($current_status === 'Inactive' && $amount >= 30) {
            $new_status = 'Active';
        }

        // Update wallet, points, and possibly status
        $sql = "UPDATE membership SET wallet = ?, points = points + ?, status = ? WHERE id = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "disi", $new_wallet, $amount, $new_status, $membership_id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }

    mysqli_close($conn);
    header("Location: membership.php");
    exit;
}

// ✅ Full form update (only details, status not touched here)
$first_name = trim($_POST['first_name']);
$last_name = trim($_POST['last_name']);
$email = trim($_POST['email']);
$phone = trim($_POST['phone']);
$address = trim($_POST['address']);
$sex = $_POST['sex'];
$nationality = trim($_POST['nationality']);

$sql = "UPDATE membership SET 
        first_name = ?, last_name = ?, email = ?, phone = ?, 
        address = ?, sex = ?, nationality = ? 
        WHERE id = ?";

$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "sssssssi", $first_name, $last_name, $email, $phone, $address, $sex, $nationality, $membership_id);
mysqli_stmt_execute($stmt);

mysqli_close($conn);
header("Location: membership.php");
exit;
?>
