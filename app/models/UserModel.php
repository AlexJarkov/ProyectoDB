<?php
require_once __DIR__ . '/../views/companies/dashboard.php';

class UserModel extends BaseModel {
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getInstance();
    }

    public function createUser($email, $password, $role) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO users (email, password, role) VALUES (?, ?, ?)";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$email, $hashed_password, $role]);
        return $this->db->lastInsertId();
    }

    public function getUserByEmail($email) {
        $sql = "SELECT * FROM users WHERE email = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    /**
     * Actualiza la fecha y hora del último inicio de sesión del usuario.
     *
     * @param int $userId ID del usuario
     * @return bool Resultado de la actualización
     */
    public function updateLastLogin($userId) {
        $currentDateTime = date('Y-m-d H:i:s');
        $sql = "UPDATE users SET last_login = ? WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$currentDateTime, $userId]);
    }
}
?>