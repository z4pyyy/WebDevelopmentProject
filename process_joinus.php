<?php
// ✅ 1. Connect to the database
include 'connection.php';

// ✅ 2. Collect and sanitize form data
$first_name = trim($_POST['first_name']);
$last_name = trim($_POST['last_name']);
$email = trim($_POST['email']);
$phone = trim($_POST['phone']);
$preferred_shift = $_POST['shift'] ?? '';
$address = trim($_POST['street']);
$postcode = trim($_POST['postcode']);
$city = trim($_POST['city']);
$state = $_POST['state'];

// ✅ 3. File Uploads
$photo = $_FILES['photo'];
$cv = $_FILES['cv'];

$upload_dir_photo = 'uploads/photos/';
$upload_dir_cv = 'uploads/cvs/';

$photo_name = uniqid('photo_') . '_' . basename($photo['name']);
$cv_name = uniqid('cv_') . '_' . basename($cv['name']);

$photo_target = $upload_dir_photo . $photo_name;
$cv_target = $upload_dir_cv . $cv_name;

// ✅ 4. Validate & Move Photo (must be under 200KB)
if ($photo['size'] > 200000) {
    die("❌ Photo file too large. Must be under 200KB. <a href='joinus.html'>Go Back</a>");
}
if (!move_uploaded_file($photo['tmp_name'], $photo_target)) {
    die("❌ Failed to upload photo. <a href='joinus.html'>Go Back</a>");
}

// ✅ 5. Validate & Move CV (must be .pdf, .doc, .docx)
$allowed_cv_ext = ['pdf', 'doc', 'docx'];
$cv_ext = strtolower(pathinfo($cv['name'], PATHINFO_EXTENSION));

if (!in_array($cv_ext, $allowed_cv_ext)) {
    die("❌ Invalid CV file type. Only PDF, DOC, DOCX allowed. <a href='joinus.html'>Go Back</a>");
}
if (!move_uploaded_file($cv['tmp_name'], $cv_target)) {
    die("❌ Failed to upload CV. <a href='joinus.html'>Go Back</a>");
}

// ✅ 6. Insert into job_application table
$sql = "INSERT INTO job_application (
    first_name, last_name, email, phone, preferred_shift,
    address, postcode, city, state, photo_path, cv_path
) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param(
    $stmt,
    "sssssssssss",
    $first_name,
    $last_name,
    $email,
    $phone,
    $preferred_shift,
    $address,
    $postcode,
    $city,
    $state,
    $photo_target,
    $cv_target
);

if (mysqli_stmt_execute($stmt)) {
    header("Location: thankyou_joinus.php");
} else {
    echo "<p style='color:red;'>❌ Failed to save application: " . mysqli_error($conn) . "</p>";
}

// ✅ 7. Cleanup
mysqli_stmt_close($stmt);
mysqli_close($conn);
?>
