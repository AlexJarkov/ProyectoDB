<?php
require_once _DIR_ . '/../config/database.php';
// Eliminado: require_once _DIR_ . '/../views/companies/dashboard.php';

class OfferModel extends BaseModel {
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