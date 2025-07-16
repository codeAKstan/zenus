<?php
require_once 'database.php';

class SiteSettings {
    private $conn;
    private $table_name = "site_settings";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getSetting($key) {
        $query = "SELECT setting_value FROM " . $this->table_name . " WHERE setting_key = ? LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $key);
        $stmt->execute();
        
        if($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return $row['setting_value'];
        }
        return null;
    }

    public function getAllSettings() {
        $query = "SELECT setting_key, setting_value FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        
        $settings = array();
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $settings[$row['setting_key']] = $row['setting_value'];
        }
        return $settings;
    }

    public function updateSetting($key, $value) {
        $query = "UPDATE " . $this->table_name . " SET setting_value = ? WHERE setting_key = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $value);
        $stmt->bindParam(2, $key);
        
        if($stmt->execute()) {
            return true;
        }
        return false;
    }
}

// Initialize database and settings
$database = new Database();
$db = $database->getConnection();
$siteSettings = new SiteSettings($db);

// Get all settings for global use
$settings = $siteSettings->getAllSettings();
?>
