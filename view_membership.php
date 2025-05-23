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

// Capture filters
$filter_by = $_GET['filter_by'] ?? '';
$search_term = trim($_GET['search_term'] ?? '');
$role_filter = $_GET['role'] ?? '';
$sort_by = $_GET['sort_by'] ?? 'registered_at_desc';

// Get role options
$role_options = [];
$role_query = mysqli_query($conn, "SELECT id, name FROM roles");
while ($r = mysqli_fetch_assoc($role_query)) {
    $role_options[] = $r;
}

// Build base SQL
$sql = "SELECT 
            m.id AS membership_id,
            m.first_name, m.last_name, m.email, m.phone, m.registered_at,
            m.wallet,
            u.username,
            u.role_id,
            r.name AS role_name
        FROM membership m
        JOIN user u ON u.membership_id = m.id
        JOIN roles r ON u.role_id = r.id";

// Apply filters
$conditions = [];
if (!empty($role_filter)) {
    $conditions[] = "u.role_id = " . intval($role_filter);
}
if (!empty($filter_by) && !empty($search_term)) {
    $escaped = mysqli_real_escape_string($conn, $search_term);
    if ($filter_by === 'member_id') {
        $id = intval(str_replace('BNG-', '', $escaped));
        $conditions[] = "m.id = $id";
    } elseif ($filter_by === 'username') {
        $conditions[] = "u.username LIKE '%$escaped%'";
    } elseif ($filter_by === 'role') {
        $conditions[] = "r.name = '$escaped'";
    }
}
if ($conditions) {
    $sql .= " WHERE " . implode(" AND ", $conditions);
}
$order_clause = match ($sort_by) {
    'wallet_asc' => 'm.wallet ASC',
    'wallet_desc' => 'm.wallet DESC',
    'member_id_asc' => 'm.id ASC',
    'member_id_desc' => 'm.id DESC',
    'registered_at_asc' => 'm.registered_at ASC',
    default => 'm.registered_at DESC',
};

$sql .= " ORDER BY $order_clause";

$result = mysqli_query($conn, $sql);

// Handle selected row
$selected_id = $_POST['view_id'] ?? null;
$selected_member = null;
if ($selected_id) {
    foreach ($result as $row) {
        if ($row['membership_id'] == $selected_id) {
            $selected_member = $row;
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
    <title>Member Wallet Overview</title>
    <link rel="stylesheet" href="styles/style.css">
</head>
<body>

<div class="admin-content">
    <div class="admin-navbar">
        <div><strong>Registered Member</strong></div>
    </div>

    <form method="GET">
        <label for="filter_by"><strong>Search by:</strong></label>
        <select name="filter_by" id="filter_by" class="role-filter" onchange="this.form.submit()">
            <option value="">-- Select Field --</option>
            <option value="member_id" <?= $filter_by === 'member_id' ? 'selected' : '' ?>>Member ID</option>
            <option value="username" <?= $filter_by === 'username' ? 'selected' : '' ?>>Username</option>
            <option value="role" <?= $filter_by === 'role' ? 'selected' : '' ?>>Role</option>
        </select>
        <label for="sort_by"><strong>Sort by:</strong></label>
        <select name="sort_by" id="sort_by" class="role-filter" onchange="this.form.submit()">
            <option value="registered_at_desc" <?= $sort_by === 'registered_at_desc' ? 'selected' : '' ?>>Newest Registered</option>
            <option value="registered_at_asc" <?= $sort_by === 'registered_at_asc' ? 'selected' : '' ?>>Oldest Registered</option>
            <option value="wallet_desc" <?= $sort_by === 'wallet_desc' ? 'selected' : '' ?>>Wallet High → Low</option>
            <option value="wallet_asc" <?= $sort_by === 'wallet_asc' ? 'selected' : '' ?>>Wallet Low → High</option>
            <option value="member_id_desc" <?= $sort_by === 'member_id_desc' ? 'selected' : '' ?>>Member ID ↓</option>
            <option value="member_id_asc" <?= $sort_by === 'member_id_asc' ? 'selected' : '' ?>>Member ID ↑</option>
        </select>

        <?php if ($filter_by === 'role'): ?>
            <select name="search_term" class="role-filter">
                <option value="">-- Choose Role --</option>
                <?php foreach ($role_options as $role): ?>
                    <option value="<?= htmlspecialchars($role['name']) ?>" <?= $search_term === $role['name'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars(ucfirst($role['name'])) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        <?php elseif ($filter_by): ?>
            <input type="text" name="search_term" class="role-filter"
                value="<?= htmlspecialchars($search_term) ?>"
                placeholder="Enter search..." />
        <?php endif; ?>

        <button type="submit" class="search-button">🔍 Search</button>
    </form>


    <table class="admin-table">
        <thead>
            <tr>
                <th>Username</th>
                <th>Member ID</th>
                <th>Wallet</th>
                <th>Role</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <?php $isSelected = ($selected_id == $row['membership_id']); ?>
            <tr>
                <td><?= htmlspecialchars($row['username']) ?></td>
                <td><?= 'BNG-' . str_pad($row['membership_id'], 5, '0', STR_PAD_LEFT) ?></td>
                <td>RM <?= number_format($row['wallet'], 2) ?></td>

                <td>
                    <form method="POST" action="update_role.php" class="details-form">
                        <input type="hidden" name="user_id" value="<?= $row['membership_id'] ?>">
                        <select name="role_id" class="role-select">
                            <?php foreach ($role_options as $role): ?>
                                <option value="<?= $role['id'] ?>" <?= $role['id'] == $row['role_id'] ? 'selected' : '' ?>>
                                    <?= htmlspecialchars(ucfirst($role['name'])) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <button type="submit" class="update-role-button">Update</button>
                    </form>
                </td>

                <td>
                    <div class="action-buttons-div">
                        <form method="POST" class="details-form">
                            <input type="hidden" name="view_id" value="<?= $row['membership_id'] ?>">
                            <button type="submit" class="member-details-button">View</button>
                        </form>
                        <form method="GET" action="edit_membership.php" class="details-form">
                            <input type="hidden" name="membership_id" value="<?= $row['membership_id'] ?>">
                            <button type="submit" class="member-edit-button">Edit</button>
                        </form>
                    </div>
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
                            <div class="detail-row"><span class="label">Registered At</span>: <?= $row['registered_at'] ?></div>
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
