<?php
function checkPagePermission($conn, $page, $role_id) {
    $page = mysqli_real_escape_string($conn, $page);
    $role_id = intval($role_id);
    $query = "SELECT can_view FROM page_permissions WHERE page = '$page' AND role_id = $role_id";
    $result = mysqli_query($conn, $query);
    return $result && mysqli_num_rows($result) > 0 && mysqli_fetch_assoc($result)['can_view'] == 1;
}