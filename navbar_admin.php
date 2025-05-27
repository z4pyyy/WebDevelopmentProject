<?php
function can_view_page($page, $role_id, $conn) {
    $stmt = mysqli_prepare($conn, "SELECT can_view FROM page_permissions WHERE page = ? AND role_id = ?");
    mysqli_stmt_bind_param($stmt, "si", $page, $role_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $can_view);
    $result = mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);
    return $result && $can_view == 1;
}
?>


<?php
$role_id = $_SESSION['role_id'] ?? 0;
?>

<div class="admin-sidebar">
  <div class="admin-brand">
    <a href="admin_dashboard.php" class="admin-brand-link"><h4><span class="icon">👤</span> Admin Panel</h4></a>
  </div>
  
  <?php if (can_view_page('admin_dashboard.php', $role_id, $conn)): ?>
    <a href="admin_dashboard.php" class="<?= $currentPage == 'admin_dashboard.php' ? 'active' : '' ?>">📊 Dashboard</a>
  <?php endif; ?>

  <?php if (can_view_page('view_enquiry.php', $role_id, $conn)): ?>
    <a href="view_enquiry.php" class="<?= $currentPage == 'view_enquiry.php' ? 'active' : '' ?>">📩 View Enquiries</a>
  <?php endif; ?>

  <?php if (can_view_page('view_job.php', $role_id, $conn)): ?>
    <a href="view_job.php" class="<?= $currentPage == 'view_job.php' ? 'active' : '' ?>">💼 Job Applications</a>
  <?php endif; ?>

  <!-- Members Dropdown -->
  <?php if (can_view_page('view_membership.php', $role_id, $conn) || can_view_page('add_role.php', $role_id, $conn) || can_view_page('add_member.php', $role_id, $conn)): ?>
    <div class="sidebar-dropdown <?= $currentPage == 'add_role.php' ? 'open' : '' ?>">
      <?php if (can_view_page('view_membership.php', $role_id, $conn)): ?>
        <a href="view_membership.php" class="<?= $currentPage == 'view_membership.php' ? 'active' : '' ?>">👥 View Members ▸</a>
      <?php endif; ?>
      <div class="dropdown-content">
        <?php if (can_view_page('add_role.php', $role_id, $conn)): ?>
          <a href="add_role.php" class="<?= $currentPage == 'add_role.php' ? 'active' : '' ?>">🪪 Add Role</a>
        <?php endif; ?>
        <?php if (can_view_page('add_member.php', $role_id, $conn)): ?>
          <a href="add_member.php" class="<?= $currentPage == 'add_member.php' ? 'active' : '' ?>">👥 Add New Member</a>
        <?php endif; ?>
      </div>
    </div>
  <?php endif; ?>

  <!-- Activity Dropdown -->
  <?php if (
    can_view_page('view_activity.php', $role_id, $conn) ||
    can_view_page('add_activity.php', $role_id, $conn) ||
    can_view_page('view_newsletter.php', $role_id, $conn)
  ): ?>
    <div class="sidebar-dropdown <?= in_array($currentPage, ['add_activity.php', 'view_newsletter.php', 'admin_newsletter_list.php']) ? 'open' : '' ?>">
      <?php if (can_view_page('view_activity.php', $role_id, $conn)): ?>
        <a href="view_activity.php" class="<?= $currentPage == 'view_activity.php' ? 'active' : '' ?>">📢 Promotions & News ▸</a>
      <?php endif; ?>
      <div class="dropdown-content">
        <?php if (can_view_page('add_activity.php', $role_id, $conn)): ?>
          <a href="add_activity.php" class="<?= $currentPage == 'add_activity.php' ? 'active' : '' ?>">📢 Add Activity</a>
        <?php endif; ?>
        <?php if (can_view_page('view_newsletter.php', $role_id, $conn)): ?>
          <a href="view_newsletter.php" class="<?= $currentPage == 'view_newsletter.php' ? 'active' : '' ?>">📰 Newsletter Panel</a>
        <?php endif; ?>
      </div>
    </div>
  <?php endif; ?>

  <!-- Products Dropdown -->
  <?php if (
    can_view_page('view_product.php', $role_id, $conn) ||
    can_view_page('add_category.php', $role_id, $conn) ||
    can_view_page('add_product.php', $role_id, $conn)
  ): ?>
    <div class="sidebar-dropdown <?= in_array($currentPage, ['view_product.php', 'add_category.php', 'add_product.php']) ? 'open' : '' ?>">
      <?php if (can_view_page('view_product.php', $role_id, $conn)): ?>
        <a href="view_product.php" class="<?= $currentPage == 'view_product.php' ? 'active' : '' ?>">🏷️ Products ▸</a>
      <?php endif; ?>
      <div class="dropdown-content">
        <?php if (can_view_page('add_category.php', $role_id, $conn)): ?>
          <a href="add_category.php" class="<?= $currentPage == 'add_category.php' ? 'active' : '' ?>">🗂️ Add Category</a>
        <?php endif; ?>
        <?php if (can_view_page('add_product.php', $role_id, $conn)): ?>
          <a href="add_product.php" class="<?= $currentPage == 'add_product.php' ? 'active' : '' ?>">🏷️ Add Products</a>
        <?php endif; ?>
      </div>
    </div>
  <?php endif; ?>

  <?php
  // Show "View Permissions" link if role can view, OR if main admin
  if (
    can_view_page('view_permissions.php', $role_id, $conn)
    && isset($_SESSION['admin_id']) && $_SESSION['admin_id'] == 1
  ): ?>
    <a href="view_permissions.php" class="<?= $currentPage == 'view_permissions.php' ? 'active' : '' ?>">🔑 View Permissions</a>
  <?php endif; ?>


  <a href="logout.php" class="logout-btn">🚪 Logout</a>
</div>
