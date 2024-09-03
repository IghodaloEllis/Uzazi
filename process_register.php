
<?php
/***
include 'config/database.php';


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get user input
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    // Prepare SQL statement
    $stmt = $conn->prepare("INSERT INTO users (first_name, last_name, email, password, role) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssss", $first_name, $last_name, $email, $password, $role);

    // Execute statement
    if ($stmt->execute()) {
        // Registration successful, redirect to verify email page
        header("Location: verify_email.php");
        exit();
    } else {
        // Registration failed, display error message
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}
?>
**/

require 'config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    // Validate input
    if (empty($first_name) || empty($last_name) || empty($email) || empty($password) || empty($role)) {
        // Handle empty input
        header('Location: register.php?error=empty');
        exit;
    }

    // Create an instance of the Database class
	$db = new Database();

    // Check if email already exists
    $stmt = $db->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        header('Location: register.php?error=email_exists');
        exit;
    }

    // Hash password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insert user data
    $stmt = $db->prepare("INSERT INTO users (first_name, last_name, email, password, role) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $first_name, $last_name, $email, $hashed_password, $role);

    if ($stmt->execute()) {
        // Registration successful
        header('Location: login.php?success=registered');
        exit;
    } else {
        // Registration failed
        header('Location: register.php?error=registration_failed');
        exit;
    }
}