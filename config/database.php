<?php
class Database {
    private $host = 'localhost';
    private $db_name = 'zenus_bank';
    private $username = 'root';
    private $password = '';
    public $conn;

    public function getConnection() {
        $this->conn = null;
        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->exec("set names utf8");
            // Set error mode to exception for better debugging
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $exception) {
            // Log the error for debugging purposes (check your PHP error logs)
            error_log("Database connection error: " . $exception->getMessage());
            // Return null if connection fails
            return null; 
        }
        return $this->conn;
    }
}

$database = new Database();
return $database->getConnection();
?>
