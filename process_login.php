<?php
require 'config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Input validation
    if (empty($email)) {
        $response = ['status' => 'error', 'message' => 'Please enter your email address.'];
        echo json_encode($response);
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $response = ['status' => 'error', 'message' => 'Invalid email address.'];
        echo json_encode($response);
        exit;
    }

    if (empty($password)) {
        $response = ['status' => 'error', 'message' => 'Please enter your password.'];
        echo json_encode($response);
        exit;
    }

    // Check if email exists
    $stmt = $db->prepare("SELECT id, password FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if ($row && password_verify($password, $row['password'])) {
        // Successful login
        $response = ['status' => 'success'];
        echo json_encode($response);
    } else {
        // Login failed
        $response = ['status' => 'error', 'message' => 'Invalid email or password.'];
        echo json_encode($response);
    }
}