// app/controllers/ContractController.php
public function createOffer($company_id, $freelancer_id, $data) {
    $sql = "INSERT INTO contracts 
            (company_id, freelancer_id, proposed_payment, details)
            VALUES (?, ?, ?, ?)";
    // Usar prepared statements
}