
<?php
/***
include 'config/database.php';

// To be implemented With live testing phase

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

    //Hashing password is a secure way of storing password. Most passwords can still be seen using many reverse methods but hashing makes it impossible even for the developer. Don't trust any website that doesn't use this method.
    // Hash password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    

    // Insert user data
    // $stmt = $db->prepare("INSERT INTO users (first_name, last_name, email, password, role) VALUES (?, ?, ?, ?, ?)");
    // $stmt->bind_param("sssss", $first_name, $last_name, $email, $hashed_password, $role);
    //if ($stmt->execute()) 

    // Insert user data into the users table
    $stmt = $db->prepare("INSERT INTO users (first_name, last_name, email, password, role) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $first_name, $last_name, $email, $hashed_password, $role);
    $stmt->execute();
    //if ($stmt->execute()) 

    // Get the ID of the newly inserted user
    $userId = $stmt->insert_id;

    // Insert a new record into user_details, We just need to populate the users_details table with default values
    $stmt = $db->prepare("INSERT INTO user_details (user_id, address, nationality, religion, phone_number, emergency_contact_name, emergency_contact_phone, date_of_birth, gender) VALUES (?, '', '', '', '', '', '', '1970-01-01', 'Other')");
    $stmt->bind_param("i", $userId);
    //$stmt->execute();
    if ($stmt->execute()) 

    {
        // Registration successful
        header('Location: index.php?success=registered');
        exit;
    } 
    else 
    {
        // Registration failed
        header('Location: register.php?error=registration_failed');
        exit;
    }
}