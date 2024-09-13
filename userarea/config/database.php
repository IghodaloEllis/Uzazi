<?php

class Database
{
    private $host = 'localhost';
    private $username = 'root';
    private $password = 'Champion2429@@';
    private $database = 'uzazi';
    private $conn;

    public function __construct()
    {
        try {
            $this->conn = new mysqli($this->host, $this->username, $this->password, $this->database);
            if ($this->conn->connect_error) {
                throw new Exception("Connection failed: " . $this->conn->connect_error);
            }
        } catch (Exception $e) {
            die("Database connection error: " . $e->getMessage());
        }
    }
    public function escape($value) 
    {
        return mysqli_real_escape_string($this->conn, $value);
    }

    public function prepare($sql)
    {
        return $this->conn->prepare($sql);
    }

    public function close()
    {
        $this->conn->close();
    }
}
// Database configuration


/** Application configuration
define('SITE_URL', 'http://yourwebsite.com');
define('SITE_NAME', 'UZAZI');
define('EMAIL_FROM', 'noreply@yourwebsite.com');

// Additional configuration options
define('DEBUG_MODE', true); // Set to false for production
define('DEFAULT_LOCALE', 'en_US');
define('TIMEZONE', 'Africa/Lagos');


  class Database {
    private $host = 'localhost';
    private $username = 'root';
    private $password = 'Champion2429@@';
    private $database = 'uzazi';

    public function connect() {
        $this->conn = new mysqli($this->host, $this->username, $this->password, $this->database);

        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }

        return $this->conn;
    }
}

**/

/**

class Database {
    private $host = 'localhost';
    private $username = 'root';
    private $password = 'Champion2429@@';
    private $database = 'uzazi';

    private $conn;

    public function __construct() {
        $this->conn = new mysqli($this->host, $this->username, $password, $database);

        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    public function prepare($sql) {
        return $this->conn->prepare($sql);
    }
}
**/

/**
$servername = "localhost";
$username = "root";
$password = "Champion2429@@";
$dbname = "uzazi";
**/
//include 'config/db.php';

// Create connection
//$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
//if ($conn->connect_error) {
//    die("Connection failed: " . $conn->connect_error);
//}


/** Error reporting
if (DEBUG_MODE) {
    ini_set('display_errors', 1);
    error_reporting(E_ALL);
} else {
    ini_set('display_errors', 0);
    error_reporting(0);
} **/
?>