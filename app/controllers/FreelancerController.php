<?php
require_once __DIR__ . '/../views/companies/dashboard.php';
require_once __DIR__ . '/../models/FreelancerModel.php';
require_once __DIR__ . '/../models/ProjectModel.php';
require_once __DIR__ . '/../models/ContractModel.php';
require_once __DIR__ . '/../models/OfferModel.php';
require_once __DIR__ . '/../config/database.php';

class FreelancerController {
    private $freelancerModel;
    private $projectModel;
    private $contractModel;
    private $offerModel;

    public function __construct() {
        $this->freelancerModel = new FreelancerModel();
        $this->projectModel    = new ProjectModel();
        $this->contractModel   = new ContractModel();
        $this->offerModel      = new OfferModel();
    }

    public function dashboard() {
        $this->checkFreelancerSession();
        $profile = $this->freelancerModel->getProfile($_SESSION['user']['id']);
        require_once __DIR__ . '/../views/freelancers/dashboard.php';
    }

    public function showDashboard() {

        // Obtener la lista de freelancers desde el modelo
        $freelancers = $this->freelancerModel->getAllFreelancers();
        $freelancers = $this->freelancerModel->freelancers;
    
        // Verificar si se están obteniendo freelancers
        if ($freelancers === false) {
            echo "Error al obtener freelancers.";
            return;
        }
    
        // Pasar la variable a la vista
        require_once __DIR__ . '/../views/companies/dashboard.php';
    }

    public function viewProfile() {
        $this->checkFreelancerSession();
        $profile = $this->freelancerModel->getProfile($_SESSION['user']['id']);
        require_once __DIR__ . '/../views/freelancers/profile.php';
    }

    public function editProfile($data) {
        $this->checkFreelancerSession();
        // Lógica de actualización de perfil
    }

    public function searchProjects() {
        $this->checkFreelancerSession();
        $projects = $this->projectModel->getActiveProjects();
        require_once __DIR__ . '/../views/freelancers/projects.php';
    }

    public function viewContracts() {
        $this->checkFreelancerSession();
        $contracts = $this->contractModel->getContractsByFreelancer($_SESSION['user']['id']);
        require_once __DIR__ . '/../views/freelancers/contracts.php';
    }

    public function viewOffers() {
        $this->checkFreelancerSession();
        
        try {
            // Obtener ofertas disponibles
            $offers = $this->offerModel->getAvailableOffers();
            
            // Cargar vista con header, contenido y footer
            require_once __DIR__ . '/../views/shared/header.php';
            require_once __DIR__ . '/../views/freelancers/offers.php';
            require_once __DIR__ . '/../views/shared/footer.php';
            
        } catch (Exception $e) {
            $_SESSION['error'] = "Error al cargar las ofertas: " . $e->getMessage();
            header("Location: /freelancer/dashboard");
            exit();
        }
    }

    private function checkFreelancerSession() {
        if (!isset($_SESSION['user'])) {
            header("Location: /login");
            exit();
        }
    }
}
?>