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
$sort_by = $_GET['sort_by'] ?? '';    // captures selected sort
$status_filter = $_GET['status_filter'] ?? '';  // NEW: captures individual status view

// Build base query
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

// NEW: Add status filtering if selected
if (in_array($status_filter, ['Pending', 'In Progress', 'Resolved'])) {
    $conditions[] = "status = '" . mysqli_real_escape_string($conn, $status_filter) . "'";
}

if (!empty($conditions)) {
    $sql .= " WHERE " . implode(" AND ", $conditions);
}

// Sorting
if ($sort_by === 'status_order') {
    $sql .= " ORDER BY FIELD(status, 'Pending', 'In Progress', 'Resolved')";
} else {
    $sql .= " ORDER BY submitted_at DESC";  // default newest first
}

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
        <a href="admin_dashboard.php" class="backto-view">← Back to Dashboard</a>
    </div>

    <div class="admin-flex-container">
    <form method="GET" class="filter-sort">
        <div class="search-enquiry">
        <label for="filter_by"><strong>Search by:</strong></label>
        <select name="filter_by" id="filter_by" class="search-filter" onchange="this.form.submit()">
            <option value="">-- Select Field --</option>
            <option value="ticket_id" <?= $filter_by === 'ticket_id' ? 'selected' : '' ?>>Ticket ID</option>
            <option value="full_name" <?= $filter_by === 'full_name' ? 'selected' : '' ?>>Full Name</option>
            <option value="email" <?= $filter_by === 'email' ? 'selected' : '' ?>>Email</option>
            <option value="phone" <?= $filter_by === 'phone' ? 'selected' : '' ?>>Phone</option>
        </select>
        
        <?php if (!empty($filter_by)): ?>
            <input type="text" name="search" class="search-filter" value="<?= htmlspecialchars($search_term) ?>" placeholder="Enter keyword...">
        <?php endif; ?>
        </div>

        <div class="status-search">
            <div class="sort-enquiry">
                <label for="status_filter" class="sort-label"><strong>View Status:</strong></label>
                <select name="status_filter" id="status_filter" class="enquiry-filter">
                    <option value="">-- All Status --</option>
                    <option value="Pending" <?= $status_filter === 'Pending' ? 'selected' : '' ?>>Only Pending</option>
                    <option value="In Progress" <?= $status_filter === 'In Progress' ? 'selected' : '' ?>>Only In Progress</option>
                    <option value="Resolved" <?= $status_filter === 'Resolved' ? 'selected' : '' ?>>Only Resolved</option>
                </select>
            </div>
            
            <div class="sort-enquiry">
                <label for="sort_by" class="sort-label"><strong>Sort by:</strong></label>
                <select name="sort_by" id="sort_by" class="enquiry-filter">
                    <option value="">Newest First</option>
                    <option value="status_order" <?= $sort_by === 'status_order' ? 'selected' : '' ?>>Pending → Resolved</option>
                </select>
            </div>
        </div>
            <button type="submit" class="search-button">🔍 Apply</button>
    </form>


            <aside class="status-legend-aside">
                <h4>Status Legend</h4>
                <ul>
                    <li><span class="legend-badge status-pending"></span> Pending</li>
                    <li><span class="legend-badge status-inprogress"></span> In Progress</li>
                    <li><span class="legend-badge status-resolved"></span> Resolved</li>
                </ul>
            </aside>
        </div>
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
                    <?php 
                        $isSelected = ($selected_id == $row['id']); 
                        $statusClass = '';
                        if ($row['status'] === 'Pending') {
                            $statusClass = 'status-pending';
                        } elseif ($row['status'] === 'In Progress') {
                            $statusClass = 'status-inprogress';
                        } elseif ($row['status'] === 'Resolved') {
                            $statusClass = 'status-resolved';
                        }
                    ?>
                    <tr class="<?= $statusClass ?>">
                        <td><?= htmlspecialchars($row['ticket_id']) ?></td>
                        <td><?= htmlspecialchars($row['first_name'] . ' ' . $row['last_name']) ?></td>
                        <td><?= htmlspecialchars($row['email']) ?></td>
                        <td><?= htmlspecialchars($row['phone']) ?></td>
                        <td><?= htmlspecialchars($row['submitted_at']) ?> </td>
                        <td>
                            <form method="POST" class="details-form">
                                <input type="hidden" name="view_id" value="<?= $row['id'] ?>">
                                <button type="submit" class="member-details-button-view">View</button>
                            </form>

                            <form method="POST" action="update_enquiry.php" class="status-form" style="margin-top: 5px;">
                                <input type="hidden" name="enquiry_id" value="<?= $row['id'] ?>">
                                <select name="status" required>
                                    <option value="Pending" <?= $row['status'] === 'Pending' ? 'selected' : '' ?>>Pending</option>
                                    <option value="In Progress" <?= $row['status'] === 'In Progress' ? 'selected' : '' ?>>In Progress</option>
                                    <option value="Resolved" <?= $row['status'] === 'Resolved' ? 'selected' : '' ?>>Resolved</option>
                                </select>
                                <button type="submit" class="member-details-button">Update</button>
                            </form>
                        </td>
                    </tr>

                    <?php if ($isSelected): ?>
                    <tr class="member-detail-row">
                        <td colspan="6">
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
