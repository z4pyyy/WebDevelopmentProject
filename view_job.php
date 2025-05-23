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
$sql = "SELECT * FROM job_application";
$conditions = [];
$sort_by = $_GET['sort_by'] ?? 'submitted_at';

switch ($sort_by) {
    case 'id_asc':
        $sql .= " ORDER BY id ASC";
        break;
    case 'id_desc':
        $sql .= " ORDER BY id DESC";
        break;
    default:
        $sql .= " ORDER BY submitted_at DESC";
        break;
}

if (!empty($filter_by) && !empty($search_term)) {
    $escaped_search = mysqli_real_escape_string($conn, $search_term);
    switch ($filter_by) {
        case 'full_name':
            $conditions[] = "CONCAT(first_name, ' ', last_name) LIKE '%$escaped_search%'";
            break;
        case 'email':
            $conditions[] = "email LIKE '%$escaped_search%'";
            break;
        case 'phone':
            $conditions[] = "phone LIKE '%$escaped_search%'";
            break;
        case 'submitted_at':
            $conditions[] = "DATE(submitted_at) = '$escaped_search'";
            break;
    }
}

if (!empty($conditions)) {
    $sql .= " WHERE " . implode(" AND ", $conditions);
}

$result = mysqli_query($conn, $sql);

// Handle selected row
$selected_id = $_POST['view_id'] ?? null;
$selected_applicant = null;

if ($selected_id) {
    foreach ($result as $row) {
        if ($row['id'] == $selected_id) {
            $selected_applicant = $row;
            break;
        }
    }
    mysqli_data_seek($result, 0); // reset pointer
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Job Applications Overview</title>
    <link rel="stylesheet" href="styles/style.css">
</head>
<body>

<div class="admin-content">
    <div class="admin-navbar">
        <div><strong>Job Applications</strong></div>
    </div>

    <form method="GET">
        <label for="filter_by"><strong>Search by:</strong></label>
        <select name="filter_by" id="filter_by" class="role-filter" onchange="this.form.submit()">
            <option value="">-- Select Field --</option>
            <option value="full_name" <?= $filter_by === 'full_name' ? 'selected' : '' ?>>Full Name</option>
            <option value="email" <?= $filter_by === 'email' ? 'selected' : '' ?>>Email</option>
            <option value="phone" <?= $filter_by === 'phone' ? 'selected' : '' ?>>Phone</option>
            <option value="submitted_at" <?= $filter_by === 'submitted_at' ? 'selected' : '' ?>>Submitted At</option>
        </select>
        <label for="sort_by"><strong>Sort by:</strong></label>
        <select name="sort_by" id="sort_by" class="role-filter" onchange="this.form.submit()">
            <option value="submitted_at" <?= ($_GET['sort_by'] ?? '') === 'submitted_at' ? 'selected' : '' ?>>Submitted At</option>
            <option value="id_asc" <?= ($_GET['sort_by'] ?? '') === 'id_asc' ? 'selected' : '' ?>>ID Ascending</option>
            <option value="id_desc" <?= ($_GET['sort_by'] ?? '') === 'id_desc' ? 'selected' : '' ?>>ID Descending</option>
        </select>

        <?php if (!empty($filter_by)): ?>
            <?php if ($filter_by === 'submitted_at'): ?>
                <input type="date" name="search" class="role-filter" value="<?= htmlspecialchars($search_term) ?>">
            <?php else: ?>
                <input type="text" name="search" class="role-filter" value="<?= htmlspecialchars($search_term) ?>" placeholder="Enter keyword...">
            <?php endif; ?>
        <?php endif; ?>

        <button type="submit" class="search-button">🔍 Search</button>
    </form>

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
                        <div class="detail-row"><span class="label">Shift</span>: <?= htmlspecialchars($row['preferred_shift']) ?></div>
                        <div class="detail-row"><span class="label">Address</span>: <?= htmlspecialchars($row['address']) ?></div>
                        <div class="detail-row"><span class="label">Postcode</span>: <?= htmlspecialchars($row['postcode']) ?></div>
                        <div class="detail-row"><span class="label">City</span>: <?= htmlspecialchars($row['city']) ?></div>
                        <div class="detail-row"><span class="label">State</span>: <?= htmlspecialchars($row['state']) ?></div>
                        <div class="action-buttons">
                        <details class="job-view-photo">
                            <summary class="viewjob-button">📷 View Photo</summary>
                            <img src="<?= htmlspecialchars($row['photo_path']) ?>" alt="Applicant Photo" class="viewjob-photo">
                        </details>
                        <details class="job-view-cv">
                            <summary class="viewjob-button">📄 View CV</summary>
                            <?php
                                $cv_filename = basename($row['cv_path']);
                                $cv_ext = strtolower(pathinfo($cv_filename, PATHINFO_EXTENSION));
                                $cv_path = $row['cv_path'];
                                $cv_path_encoded = 'uploads/cvs/' . rawurlencode($cv_filename);
                            ?>
                            <?php if ($cv_ext === 'pdf'): ?>
                                <embed src="<?= $cv_path_encoded ?>" type="application/pdf" width="100%" height="500px" />
                                <p style="margin-top: 10px;">
                                <a href="<?= htmlspecialchars($cv_path) ?>" target="_blank" class="viewjob-cv-link">🔗 Open PDF in New Tab</a>
                                </p>
                            <?php else: ?>
                                <a href="<?= htmlspecialchars($cv_path) ?>" target="_blank" class="viewjob-cv-link">⬇ Download CV (WORD)</a>
                            <?php endif; ?>
                        </details>
                        </div>
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
