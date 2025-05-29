<?php
// This expects $pending, $in_progress, $resolved, $selected_id to be in scope
$status_section = '';
if (isset($pending) && is_array($pending)) { $status_section = 'pending'; $enquiries = $pending; }
if (isset($in_progress) && is_array($in_progress)) { $status_section = 'in_progress'; $enquiries = $in_progress; }
if (isset($resolved) && is_array($resolved)) { $status_section = 'resolved'; $enquiries = $resolved; }

if (!empty($enquiries)): ?>
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
        <?php foreach ($enquiries as $row): 
            $isSelected = ($selected_id == $row['id']); 
            $statusClass = '';
            if ($row['status'] === 'Pending') $statusClass = 'status-pending';
            elseif ($row['status'] === 'In Progress') $statusClass = 'status-inprogress';
            elseif ($row['status'] === 'Resolved') $statusClass = 'status-resolved';
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
        <?php endforeach; ?>
    </tbody>
</table>
<?php else: ?>
    <p>No enquiries in this section.</p>
<?php endif; ?>
