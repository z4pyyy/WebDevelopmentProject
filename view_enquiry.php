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

$filter_by = $_GET['filter_by'] ?? '';
$search_term = trim($_GET['search'] ?? '');

// Build query
$sql = "SELECT * FROM enquiry";
$conditions = [];

if (!empty($filter_by) && !empty($search_term)) {
    $escaped_search = mysqli_real_escape_string($conn, $search_term);
    switch ($filter_by) {
        case 'ticket_id':
            $conditions[] = "ticket_id LIKE '%$escaped_search%'";
            break;
        case 'full_name':
            $conditions[] = "CONCAT(first_name, ' ', last_name) LIKE '%$escaped_search%'";
            break;
        case 'email':
            $conditions[] = "email LIKE '%$escaped_search%'";
            break;
        case 'phone':
            $conditions[] = "phone LIKE '%$escaped_search%'";
            break;
    }
}

if (!empty($conditions)) {
    $sql .= " WHERE " . implode(" AND ", $conditions);
}
$sql .= " ORDER BY submitted_at DESC";

$result = mysqli_query($conn, $sql);

// Handle selected row
$selected_id = $_POST['view_id'] ?? null;
$selected_enquiry = null;

if ($selected_id) {
    foreach ($result as $row) {
        if ($row['id'] == $selected_id) {
            $selected_enquiry = $row;
            break;
        }
    }
    mysqli_data_seek($result, 0);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Enquiry Overview</title>
    <link rel="stylesheet" href="styles/style.css">
</head>
<body>

<div class="admin-content">
    <div class="admin-navbar">
        <div><strong>Enquiries</strong></div>
    </div>

    <form method="GET">
        <label for="filter_by"><strong>Search by:</strong></label>
        <select name="filter_by" id="filter_by" class="role-filter" onchange="this.form.submit()">
            <option value="">-- Select Field --</option>
            <option value="ticket_id" <?= $filter_by === 'ticket_id' ? 'selected' : '' ?>>Ticket ID</option>
            <option value="full_name" <?= $filter_by === 'full_name' ? 'selected' : '' ?>>Full Name</option>
            <option value="email" <?= $filter_by === 'email' ? 'selected' : '' ?>>Email</option>
            <option value="phone" <?= $filter_by === 'phone' ? 'selected' : '' ?>>Phone</option>
        </select>

        <?php if (!empty($filter_by)): ?>
            <input type="text" name="search" class="role-filter" value="<?= htmlspecialchars($search_term) ?>" placeholder="Enter keyword...">
        <?php endif; ?>

        <button type="submit" class="search-button">🔍 Search</button>
    </form>

    <table class="admin-table">
        <thead>
            <tr>
                <th>Ticket ID</th>
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
                <td><?= htmlspecialchars($row['ticket_id']) ?></td>
                <td><?= htmlspecialchars($row['first_name'] . ' ' . $row['last_name']) ?></td>
                <td><?= htmlspecialchars($row['email']) ?></td>
                <td><?= htmlspecialchars($row['phone']) ?></td>
                <td><?= htmlspecialchars($row['submitted_at']) ?> </td>
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
                        <div class="detail-row"><span class="label">Address</span>: <?= htmlspecialchars($row['address']) ?></div>
                        <div class="detail-row"><span class="label">Postcode</span>: <?= htmlspecialchars($row['postcode']) ?></div>
                        <div class="detail-row"><span class="label">City</span>: <?= htmlspecialchars($row['city']) ?></div>
                        <div class="detail-row"><span class="label">State</span>: <?= htmlspecialchars($row['state']) ?></div>
                        <div class="detail-row"><span class="label">Enquiry Type</span>: <?= htmlspecialchars($row['enquiry_type']) ?></div>
                        <div class="detail-row"><span class="label">Message</span>: <?= htmlspecialchars($row['message']) ?></div>
                    </div>
                </td>
            </tr>
            <?php endif; ?>
        <?php endwhile; ?>
        </tbody>
    </table>
</div>

</body>
</html>
