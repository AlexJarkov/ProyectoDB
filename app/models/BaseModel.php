<?php
require_once 'BaseModel.php';

class BaseModel {
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getInstance();
    }
    
    public function createUser($email, $password, $role) {
        $sql = "INSERT INTO users (email, password, role) VALUES (?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$email, $password, $role]);
        return $this->db->lastInsertId();
    }

    public function getUserByEmail($email) {
        $sql = "SELECT * FROM users WHERE email = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$email]);
        return $stmt->fetch();
    }
}
?>