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
    header("Location: thankyou_enquiry.php");
    exit;
} else {
    echo "<p style='color:red;'>❌ Submission failed: " . mysqli_error($conn) . "</p>";
}

// ✅ 4. Cleanup
mysqli_stmt_close($stmt);
mysqli_close($conn);
?>
