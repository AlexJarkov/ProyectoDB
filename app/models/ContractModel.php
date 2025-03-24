<?php
require_once __DIR__ . '/../config/database.php';

class ContractModel {
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getInstance();
    }

    public function getContractsByFreelancer($freelancerId) {
        $sql = "SELECT c.*, comp.company_name 
                FROM contracts c 
                JOIN companies comp ON c.company_id = comp.user_id
                WHERE c.freelancer_id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$freelancerId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
