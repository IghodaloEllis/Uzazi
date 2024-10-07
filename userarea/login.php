<?php
require 'config/database.php';

// Create an instance of the Database class
$db = new Database();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $db->escape($_POST['email']);
    $password = $db->escape($_POST['password']);

    // Validate input
    if (empty($email) || empty($password)) {
        // Handle empty input
        header('Location: login.php?error=empty');
        exit;
    }

    // Check if email exists
    $stmt = $db->prepare("SELECT id, password FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if ($row && password_verify($password, $row['password'])) {
        
        // Successful login, start a session

        session_start(); // session start should be added to every page that needs user to be signed on.

        $_SESSION['user_id'] = $row['id'];
        header('Location: dashboard.php');
        exit;
    } else {
        // Login failed
        header('Location: login.php?error=invalid');
        exit;
    }
}





/**


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Validate input
    if (empty($email) || empty($password)) {
        // Handle empty input
        header('Location: login.php?error=empty');
        exit;
    }

    // Sanitize input using the database connection
    $email = mysqli_real_escape_string($db->conn, $email);
    $password = mysqli_real_escape_string($db->conn, $password);

    // Check if email exists
    $stmt = $db->prepare("SELECT id, password FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if ($row && password_verify($password, $row['password'])) {
        // Successful login, start a session
        session_start();
        $_SESSION['user_id'] = $row['id'];
        header('Location: dashboard.php');
        exit;
    } else {
        // Login failed
        header('Location: login.php?error=invalid');
        exit;
    }
}

**/