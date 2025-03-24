<?php

require_once __DIR__ . '/../config/Database.php';

require_once __DIR__ . '/../views/companies/dashboard.php';



class ContractModel {

    private $db;



    public function __construct() {

        // Cambiado para usar el método estático getInstance()

        $this->db = Database::getInstance();

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

    

    /**

     * Obtiene los contratos asociados a una empresa.

     *

     * @param int $companyId ID de la empresa.

     * @return array Lista de contratos.

     */

    public function getCompanyContracts($companyId) {

        $sql = "SELECT c.*, f.full_name AS freelancer_name 

                FROM contracts c 

                JOIN freelancers f ON c.freelancer_id = f.user_id

                WHERE c.company_id = ?

                ORDER BY c.created_at DESC";

        $stmt = $this->db->prepare($sql);

        $stmt->execute([$companyId]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    }

}

?>