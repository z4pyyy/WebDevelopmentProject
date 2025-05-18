<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
  header("Location: login.php");
  exit;
}
include 'connection.php';

$user_id = $_POST['user_id'] ?? null;
$role_id = $_POST['role_id'] ?? null;

if ($user_id && $role_id) {
  $sql = "UPDATE user SET role_id = ? WHERE id = ?";
  $stmt = mysqli_prepare($conn, $sql);
  mysqli_stmt_bind_param($stmt, "ii", $role_id, $user_id);
  mysqli_stmt_execute($stmt);
}

header("Location: view_membership.php");
exit;
