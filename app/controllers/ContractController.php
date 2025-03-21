// app/controllers/ContractController.php
public function createOffer($company_id, $freelancer_id, $data) {
    $sql = "INSERT INTO contracts 
            (company_id, freelancer_id, proposed_payment, details)
            VALUES (?, ?, ?, ?)";
    // Usar prepared statements
}

<?php
class ContractController {
    private $contractModel;
    private $userModel;

    public function __construct() {
        $this->contractModel = new ContractModel();
        $this->userModel = new UserModel();
    }

    public function createContract($contractData) {
        $this->checkCompanySession();
        // Validar y crear nuevo contrato
    }

    public function acceptContract($contractId) {
        $this->checkFreelancerSession();
        // Lógica de aceptación de contrato
    }

    public function rejectContract($contractId) {
        $this->checkFreelancerSession();
        // Lógica de rechazo de contrato
    }

    public function viewContracts() {
        if ($_SESSION['user']['role'] === 'company') {
            $contracts = $this->contractModel->getCompanyContracts($_SESSION['user']['id']);
        } else {
            $contracts = $this->contractModel->getFreelancerContracts($_SESSION['user']['id']);
        }
        require_once 'views/contracts/list.php';
    }

    private function checkCompanySession() {
        if ($_SESSION['user']['role'] !== 'company') {
            header("Location: /login");
            exit();
        }
    }

    private function checkFreelancerSession() {
        if ($_SESSION['user']['role'] !== 'freelancer') {
            header("Location: /login");
            exit();
        }
    }
}
?>