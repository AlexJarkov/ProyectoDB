<?php
require_once __DIR__ . '/../config/database.php';

class OfferModel {
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    public function getOffersForFreelancer($freelancerId) {
        $sql = "SELECT o.*, comp.company_name 
                FROM offers o 
                JOIN companies comp ON o.company_id = comp.user_id
                WHERE o.freelancer_id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$freelancerId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
