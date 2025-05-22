<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

$currentPage = basename($_SERVER['PHP_SELF']);
include 'connection.php';
include 'navbar.php';
include 'navbar_admin.php';

//Get enquiry info
$sql = "SELECT * FROM enquiry ORDER BY submitted_at DESC";
$result = mysqli_query($conn, $sql);

// Handle selected row
$selected_id = $_POST['view_id'] ?? null;
$selected_ticket = null;

if ($selected_id) {
    foreach ($result as $row) {
        if ($row['id'] == $selected_id) {
            $selected_ticket = $row;
            break;
        }
    }
    mysqli_data_seek($result, 0); // reset pointer
}
?>

?>

<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <title>Job Applications Overview</title>
    <link rel="stylesheet" href="styles/style.css">
</head>
<body>

<div class="admin-content">
    <div class="admin-navbar">
        <div><strong>Enquiries</strong></div>
    </div>

<table class="admin-table">
        <thead>
            <tr>
                <th>Full Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Submitted At</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <?php $isSelected = ($selected_id == $row['id']); ?>
            <tr>
                <td><?= htmlspecialchars($row['first_name'] . ' ' . $row['last_name']) ?></td>
                <td><?= htmlspecialchars($row['email']) ?></td>
                <td><?= htmlspecialchars($row['phone']) ?></td>
                <td><?= $row['submitted_at'] ?></td>

                <!-- Action Button -->
                <td>
                    <form method="POST" class="details-form">
                        <input type="hidden" name="view_id" value="<?= $row['id'] ?>">
                        <button type="submit" class="member-details-button">View</button>
                    </form>
                </td>
            </tr>

            <?php if ($isSelected): ?>
            <tr class="member-detail-row">
                <td colspan="5">
                    <div class="member-details-inline">
                        <div class="detail-row"><span class="label">First Name</span>: <?= htmlspecialchars($row['first_name']) ?></div>
                        <div class="detail-row"><span class="label">Last Name</span>: <?= htmlspecialchars($row['last_name']) ?></div>
                        <div class="detail-row"><span class="label">Email</span>: <?= htmlspecialchars($row['email']) ?></div>
                        <div class="detail-row"><span class="label">Phone</span>: <?= htmlspecialchars($row['phone']) ?></div>
                        <div class="detail-row"><span class="label">Address</span>: <?= htmlspecialchars($row['street']) ?></div>
                        <div class="detail-row"><span class="label">Postcode</span>: <?= htmlspecialchars($row['postcode']) ?></div>
                        <div class="detail-row"><span class="label">City</span>: <?= htmlspecialchars($row['city']) ?></div>
                        <div class="detail-row"><span class="label">State</span>: <?= htmlspecialchars($row['state']) ?></div>
                        <div class="detail-row"><span class="label">Enquiry Type</span>: <?= htmlspecialchars($row['enquiry_type']) ?></div>
                        <div class="detail-row"><span class="label">Message</span>: <?= htmlspecialchars($row['message']) ?></div>
                    </td>
                </tr>
                    <?php endif; ?>
                    <?php endwhile; ?>
                </div>
        </tbody>
    </table>
</div>

</body>
</html>


