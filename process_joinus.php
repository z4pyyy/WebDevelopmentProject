<?php
include 'connection.php';
session_start();

// ✅ Preserve form data
$_SESSION['joinus_form'] = $_POST;

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

// ✅ Helper function: display styled error page
function showUploadError($message) {
    echo <<<HTML
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Upload Error</title>
        <link rel="stylesheet" href="styles/style.css">
        
    </head>
    <body class="joinus-error-body">
        <div class="joinus-error-box">
            <h2>❌ Upload Error</h2>
            <p>{$message}</p>
            <a href="joinus.php">← Go Back to Join Us Page</a>
        </div>
    </body>
    </html>
    HTML;
    exit;
}

// ✅ 4. Validate & Move Photo
if ($photo['size'] > 500000) {
    showUploadError("Photo file too large. Must be under 500KB.");
}
if (!move_uploaded_file($photo['tmp_name'], $photo_target)) {
    showUploadError("Failed to upload photo.");
}

// ✅ 5. Validate & Move CV
$allowed_cv_ext = ['pdf', 'doc', 'docx'];
$cv_ext = strtolower(pathinfo($cv['name'], PATHINFO_EXTENSION));

if ($cv['size'] > 200000) {
    showUploadError("CV file too large. Must be under 200KB.");
}
if (!in_array($cv_ext, $allowed_cv_ext)) {
    showUploadError("Invalid CV file type. Only PDF, DOC, or DOCX allowed.");
}
if (!move_uploaded_file($cv['tmp_name'], $cv_target)) {
    showUploadError("Failed to upload CV file.");
}

// ✅ 6. Insert into job_application table
$sql = "INSERT INTO job_application (
    first_name, last_name, email, phone, preferred_shift,
    address, postcode, city, state, photo_path, cv_path
) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "sssssssssss",
    $first_name, $last_name, $email, $phone, $preferred_shift,
    $address, $postcode, $city, $state, $photo_target, $cv_target
);

if (mysqli_stmt_execute($stmt)) {
    unset($_SESSION['joinus_form']);
    echo <<<HTML
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="refresh" content="4;url=index.php">
        <title>Application Submitted</title>
        <link rel="stylesheet" href="styles/style.css">
    </head>
    <body class="joinus-confirm-body">
        <div class="joinus-confirm-box">
            <h2>✅ Application Submitted!</h2>
            <p>Thank you, <strong>{$first_name} {$last_name}</strong>.</p>
            <p>Your job application has been successfully received.</p>
            <p>You’ll be redirected to the homepage shortly.</p>
            <a href="index.php" class="joinus-confirm-link">← Click here if not redirected</a>
        </div>
    </body>
    </html>
    HTML;
    exit;
}

// ✅ Cleanup
mysqli_stmt_close($stmt);
mysqli_close($conn);
