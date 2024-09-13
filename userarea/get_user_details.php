<?php
session_start();

require 'database.php';

$user_id = $_SESSION['user_id'];

$stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();

// Fetch additional user details from user_details table
// ...

echo json_encode(['html' => generate_user_profile_html($user)]);

function generate_user_profile_html($user) {
    // Generate HTML for user profile based on user data
    // ...
}