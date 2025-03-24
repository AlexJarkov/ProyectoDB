<?php
class FreelancerController {
    private $freelancerModel;
    private $projectModel;
    private $contractModel;

    public function __construct() {
        $this->FreelancerModel = new FreelancerModel();
        $this->ProjectModel = new ProjectModel();
        $this->ContractModel = new ContractModel();
    }

    public function dashboard() {
        $this->checkFreelancerSession();
        $profile = $this->freelancerModel->getProfile($_SESSION['user']['id']);
        require_once 'views/freelancers/dashboard.php';
    }

    public function viewProfile() {
        $this->checkFreelancerSession();
        $profile = $this->freelancerModel->getProfile($_SESSION['user']['id']);
        require_once 'views/freelancers/profile.php';
    }

    public function editProfile($data) {
        $this->checkFreelancerSession();
        // Lógica de actualización de perfil
    }

    public function searchProjects() {
        $this->checkFreelancerSession();
        $projects = $this->projectModel->getActiveProjects();
        require_once 'views/freelancers/projects.php';
    }

    public function viewContracts() {
        $this->checkFreelancerSession();
        $contracts = $this->contractModel->getContractsByFreelancer($_SESSION['user']['id']);
        require_once 'views/freelancers/contracts.php';
    }

    public function getOffers($freelancerId) {
        $sql = "SELECT * FROM offers WHERE freelancer_id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$freelancerId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function viewOffers() {
        $this->checkFreelancerSession();
        $offers = $this->freelancerModel->getOffers($_SESSION['user']['id']);
        require_once 'views/freelancers/offers.php';
    }

    private function checkFreelancerSession() {
        if (!isset($_SESSION['user'])) {
            header("Location: /login");
            exit();
        }
    }
}
?>