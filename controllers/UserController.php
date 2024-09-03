<?php
session_start();
require_once 'classes/User.php';
require_once 'classes/Database.php';

class UserController {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }
    public function index() {
        if (isAdmin()) {
            // Fetch all users for admin
            $users = $this->getAllUsers();
        } else {
            // Fetch only the logged-in user's data
            $userId = $_SESSION['user_id'];
            $user = $this->getUserById($userId);
            $users = [$user]; // Convert to array for consistent handling
        }

        // Render the view with the appropriate user data
    }
    
function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

function isAdmin() {
    return isset($_SESSION['user_id']) && $_SESSION['user_role'] === 'admin';
}

    public function register($firstName, $lastName, $email, $password) {
        $user = new User($this->db);
        $result = $user->createUser($firstName, $lastName, $email, $password);

        if ($result) {
            // Handle successful registration
            return true;
        } else {
            // Handle registration error
            return false;
        }
    }

    public function login($email, $password) {
        // Logic for user login, including password verification
    }

    public function getUserById($userId) {
        // Logic to retrieve user by ID
    }

    public function updateUser($userId, $data) {
        // Logic to update user information
    }

    public function deleteUser($userId) {
        // Logic to delete a user
    }
}
