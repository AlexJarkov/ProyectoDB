<?php
require_once __DIR__ . '/../config/database.php';

class CompanyModel {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function getProfile($userId) {
        $sql = "SELECT * FROM companies WHERE user_id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$userId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function createProfile($data) {
        $sql = "INSERT INTO companies (user_id, company_name, industry, location, website, description) 
                VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            $data['user_id'],
            $data['company_name'],
            $data['industry'],
            $data['location'],
            !empty($data['website']) ? $data['website'] : null,
            !empty($data['description']) ? $data['description'] : null,
        ]);
        return $this->db->lastInsertId();
    }

    public function updateProfile($userId, $data) {
        $sql = "UPDATE companies 
                SET company_name = ?, industry = ?, location = ?, website = ?, description = ? 
                WHERE user_id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            $data['company_name'],
            $data['industry'],
            $data['location'],
            !empty($data['website']) ? $data['website'] : null,
            !empty($data['description']) ? $data['description'] : null,
            $userId
        ]);
    }
}
