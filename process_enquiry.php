<?php
// ✅ 1. Connect to the database
include 'connection.php';

// ✅ 2. Collect and sanitize form inputs
$first_name = trim($_POST['first_name']);
$last_name = trim($_POST['last_name']);
$phone = trim($_POST['phone']);
$email = trim($_POST['email']);
$street = trim($_POST['street']);
$city = trim($_POST['city']);
$state = $_POST['state'];
$postcode = trim($_POST['postcode']);
$enquiry_type = $_POST['enquiry'];
$message = trim($_POST['message']);
$address = $street; // For column mapping

// ✅ 3. Insert into enquiry table (corrected query)
// ✅ 1. Insert without ticket_id
$sql = "INSERT INTO enquiry (
    first_name, last_name, email, phone, address, postcode, city, state, enquiry_type, message
) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"; 

$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param(
    $stmt,
    "ssssssssss",
    $first_name,
    $last_name,
    $email,
    $phone,
    $address,
    $postcode,
    $city,
    $state,
    $enquiry_type,
    $message
);

if (mysqli_stmt_execute($stmt)) {
    $last_id = mysqli_insert_id($conn);
    $ticket_id = "ENQ-" . str_pad($last_id, 4, "0", STR_PAD_LEFT);

    // ✅ 2. Update ticket_id
    $update_sql = "UPDATE enquiry SET ticket_id = ? WHERE id = ?";
    $update_stmt = mysqli_prepare($conn, $update_sql);
    mysqli_stmt_bind_param($update_stmt, "si", $ticket_id, $last_id);
    mysqli_stmt_execute($update_stmt);

    // ✅ 3. Optional: store it in session for thank you page
    session_start();
    $_SESSION['enquiry_data'] = $_POST;
    $_SESSION['enquiry_data']['ticket_id'] = $ticket_id;

    header("Location: thankyou_enquiry.php");
    exit;
} else {
    echo "<p style='color:red;'>❌ Submission failed: " . mysqli_error($conn) . "</p>";
}
