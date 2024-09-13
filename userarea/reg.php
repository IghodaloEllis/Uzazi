<?php
require 'config/database.php';

class Registration {
    private $db;

    public function __construct(Database $db) {
        $this->db = $db;
    }

    public function register($first_name, $last_name, $email, $password, $role) {
        // Validate input
        if (empty($first_name) || empty($last_name) || empty($email) || empty($password) || empty($role)) {
            return false;
        }

        // Check if email already exists
        $stmt = $this->db->prepare("SELECT id FROM users WHERE email = ?");
        if (!$stmt) {
            die("Error preparing statement: " . $this->db->error);
        }

        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            return false;
        }

        // Hash password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Insert user data
        $stmt = $this->db->prepare("INSERT INTO users (first_name, last_name, email, password, role) VALUES (?, ?, ?, ?, ?)");
        if (!$stmt) {
            die("Error preparing statement: " . $this->db->error);
        }

        $stmt->bind_param("sssss", $first_name, $last_name, $email, $hashed_password, $role);

        if ($stmt->execute()) {
            $user_id = $this->db->insert_id;
            return $user_id;
        } else {
            die("Error executing statement: " . $this->db->error);
        }
    }
}

// ... (rest of your code)
// Create an instance of the Database class
$db = new Database();

// Create an instance of the Registration class
$registration = new Registration($db);

// Process registration form
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    $user_id = $registration->register($first_name, $last_name, $email, $password, $role);

    if ($user_id) {
        // Registration successful, redirect to dashboard
        header('Location: dashboard.php');
        exit;
    } else {
        // Registration failed, redirect to failed_login.php
        header('Location: failed_login.php');
        exit;
    }
}

?>