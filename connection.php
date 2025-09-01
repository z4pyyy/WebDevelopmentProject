<?php
$db_user   = getenv('DB_USER') ?: 'root';
$db_pass   = getenv('DB_PASS') ?: '';
$db_name   = getenv('DB_NAME') ?: 'developmentdb';
$db_socket = getenv('DB_SOCKET');

// Safety check
if (!$db_socket || !file_exists($db_socket)) {
    die("❌ Cloud SQL socket not found at: $db_socket");
}

// Connect via Unix socket
$conn = new mysqli(null, $db_user, $db_pass, $db_name, null, $db_socket);

// Error handling
if ($conn->connect_error) {
    die("❌ Connection failed: " . $conn->connect_error);
}
