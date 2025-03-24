<?php
require_once __DIR__ . '/../config/database.php';

class UserModel {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection(); // ✅ conexión correcta
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
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateLastLogin($userId) {
        $currentDateTime = date('Y-m-d H:i:s');
        $sql = "UPDATE users SET last_login = ? WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$currentDateTime, $userId]);
    }
}
?>
