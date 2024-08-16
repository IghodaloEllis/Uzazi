<?php
class Database {
    private $pdo;

    public function __construct() {
        require_once 'config/database.php';

        try {
            $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME;
            $this->pdo = new PDO($dsn, DB_USER, DB_PASSWORD);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }

    public function query($sql, $params = []) {
        $stmt = $this->pdo->prepare($sql);
        if ($stmt) {
            $stmt->execute($params);
            return $stmt;
        } else {
            throw new Exception("Error preparing statement: " . $this->pdo->errorInfo()[2]);
        }
    }

    public function fetchAll($sql, $params = []) {
        $stmt = $this->query($sql, $params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function fetch($sql, $params = []) {
        $stmt = $this->query($sql, $params);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
