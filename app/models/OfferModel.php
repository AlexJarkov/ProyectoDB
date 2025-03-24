<?php
require_once __DIR__ . '/../config/database.php';

class OfferModel extends BaseModel {
    protected $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function getAvailableOffers() {
        $sql = "SELECT 
                    o.*, 
                    c.company_name,
                    c.location,
                    c.industry
                FROM offers o
                JOIN companies c ON o.company_id = c.user_id
                WHERE o.status = 'active'
                ORDER BY o.created_at DESC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>