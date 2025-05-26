<div class="admin-sidebar">
  <div class="admin-brand">
    <a href="admin_dashboard.php" class="admin-brand-link"><h4><span class="icon">👤</span> Admin Panel</h4></a>
  </div>
  <a href="admin_dashboard.php" class="<?= $currentPage == 'admin_dashboard.php' ? 'active' : '' ?>">📊 Dashboard</a>
  
  <a href="view_enquiry.php" class="<?= $currentPage == 'view_enquiry.php' ? 'active' : '' ?>">📩 View Enquiries</a>
  <a href="view_job.php" class="<?= $currentPage == 'view_job.php' ? 'active' : '' ?>">💼 Job Applications</a>
  
  <!-- Members Dropdown -->
  <div class="sidebar-dropdown <?= $currentPage == 'add_role.php' ? 'open' : '' ?>">
    <a href="view_membership.php" class="<?= $currentPage == 'view_membership.php' ? 'active' : '' ?>">👥 View Members ▸</a>
    <div class="dropdown-content">
      <a href="add_role.php" class="<?= $currentPage == 'add_role.php' ? 'active' : '' ?>">🪪 Add Role</a>
      <a href="add_member.php" class="<?= $currentPage == 'add_member.php' ? 'active' : '' ?>">👥 Add New Member</a>
    </div>
  </div>

  <!-- Activity Dropdown -->
  <div class="sidebar-dropdown <?= in_array($currentPage, ['add_activity.php', 'admin_newsletter.php', 'admin_newsletter_list.php']) ? 'open' : '' ?>">
    <a href="view_activity.php" class="<?= $currentPage == 'view_activity.php' ? 'active' : '' ?>">📢 Promotions & News ▸</a>  
    <div class="dropdown-content">
        <a href="add_activity.php" class="<?= $currentPage == 'add_activity.php' ? 'active' : '' ?>">📢 Add Activity</a>
        <a href="admin_newsletter.php" class="<?= $currentPage == 'admin_newsletter.php' ? 'active' : '' ?>">📰 Newsletter Panel</a>
    </div>
  </div>

  
  <!-- Products Dropdown -->
  <div class="sidebar-dropdown <?= in_array($currentPage, ['view_product.php', 'add_category.php', 'add_product.php']) ? 'open' : '' ?>">
    <a href="view_product.php" class="<?= $currentPage == 'view_product.php' ? 'active' : '' ?>">🏷️ Products ▸</a>
    <div class="dropdown-content">
      <a href="add_category.php" class="<?= $currentPage == 'add_category.php' ? 'active' : '' ?>">🗂️ Add Category</a>
      <a href="add_product.php" class="<?= $currentPage == 'add_product.php' ? 'active' : '' ?>">🏷️ Add Products</a>
    </div>
  </div>

  
  <a href="logout.php" class="logout-btn">🚪 Logout</a>
</div>
