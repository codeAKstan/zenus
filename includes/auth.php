<?php
session_start();
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/email_service.php';

class Auth {
    private $db;
    private $emailService;
    
    public function __construct($database) {
        if (!($database instanceof PDO)) {
            throw new Exception("Invalid database connection passed to Auth class.");
        }
        $this->db = $database;
        $this->emailService = new EmailService($database);
    }

    public function register($userData) {
        try {
            $checkQuery = "SELECT id FROM users WHERE email = ?";
            $checkStmt = $this->db->prepare($checkQuery);
            $checkStmt->bindParam(1, $userData['email']);
            $checkStmt->execute();
            
            if ($checkStmt->rowCount() > 0) {
                return ['success' => false, 'message' => 'Email already exists'];
            }
            
            $password = $userData['password'];
            
            $query = "INSERT INTO users (first_name, last_name, email, password_hash, phone_number, country, account_type, occupation, home_address, state, gender, date_of_birth, account_currency, profile_picture) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(1, $userData['first_name']);
            $stmt->bindParam(2, $userData['last_name']);
            $stmt->bindParam(3, $userData['email']);
            $stmt->bindParam(4, $password);
            $stmt->bindParam(5, $userData['phone_number']);
            $stmt->bindParam(6, $userData['country']);
            $stmt->bindParam(7, $userData['account_type']);
            $stmt->bindParam(8, $userData['occupation']);
            $stmt->bindParam(9, $userData['home_address']);
            $stmt->bindParam(10, $userData['state']);
            $stmt->bindParam(11, $userData['gender']);
            $stmt->bindParam(12, $userData['date_of_birth']);
            $stmt->bindParam(13, $userData['account_currency']);
            $stmt->bindParam(14, $userData['profile_picture']);
            
            if ($stmt->execute()) {
                $userId = $this->db->lastInsertId();
                
                $userData['user_id'] = $userId;
                $emailResult = $this->emailService->sendWelcomeEmail($userData);
                
                if (!$emailResult['success']) {
                    error_log("Welcome email failed for user ID $userId: " . $emailResult['message']);
                }
                
                return ['success' => true, 'message' => 'Account created successfully! Welcome email sent.'];
            } else {
                return ['success' => false, 'message' => 'Registration failed'];
            }
            
        } catch (Exception $e) {
            return ['success' => false, 'message' => 'Registration error: ' . $e->getMessage()];
        }
    }

    public function login($email, $password) {
        try {
            $query = "SELECT id, first_name, last_name, email, password_hash, is_active FROM users WHERE email = ?";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(1, $email);
            $stmt->execute();
            
            if ($stmt->rowCount() === 1) {
                $user = $stmt->fetch(PDO::FETCH_ASSOC);
                
                if (!$user['is_active']) {
                    return ['success' => false, 'message' => 'Account is deactivated'];
                }
                
                if ($password === $user['password_hash']) {
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['user_email'] = $user['email'];
                    $_SESSION['user_name'] = $user['first_name'] . ' ' . $user['last_name'];
                    
                    return ['success' => true, 'message' => 'Login successful'];
                } else {
                    return ['success' => false, 'message' => 'Invalid password'];
                }
            } else {
                return ['success' => false, 'message' => 'Email not found'];
            }
            
        } catch (Exception $e) {
            return ['success' => false, 'message' => 'Login error: ' . $e->getMessage()];
        }
    }
    
    public function logout() {
        session_destroy();
        return ['success' => true, 'message' => 'Logged out successfully'];
    }
    
    public function isLoggedIn() {
        return isset($_SESSION['user_id']);
    }
    
    public function getCurrentUser() {
        if ($this->isLoggedIn()) {
            return [
                'id' => $_SESSION['user_id'],
                'email' => $_SESSION['user_email'],
                'name' => $_SESSION['user_name']
            ];
        }
        return null;
    }
}
?>
