//USER CLASS
class User {
    private $id;
    private $firstName;
    private $lastName;
    private $email;
    private $password;
    private $db; // Database instance

    public function __construct($db) {
        $this->db = $db;
    }

    // Methods for CRUD operations, getters, setters, and other user-related logic
    // ...

    public function createUser($firstName, $lastName, $email, $password) {
        // Prepare SQL statement
        $sql = "INSERT INTO users (first_name, last_name, email, password) VALUES (?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);

        // Hash the password for security
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Bind parameters
        $stmt->bindParam(1, $firstName);
        $stmt->bindParam(2, $lastName);
        $stmt->bindParam(3, $email);
        $stmt->bindParam(4, $hashedPassword);

        // Execute the statement
        if ($stmt->execute()) {
            return true;
        } else {
            // Handle error
            return false;
        }
    }

    // Other methods like getUserById, updateUser, deleteUser, etc.
}
