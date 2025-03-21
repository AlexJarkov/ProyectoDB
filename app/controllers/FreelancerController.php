// app/controllers/FreelancerController.php
public function getAllFreelancers() {
    $sql = "SELECT f.*, u.email 
            FROM freelancers f
            JOIN users u ON f.user_id = u.id";
    // Ejecutar y retornar resultados
}

<?php
class FreelancerController {
    private $freelancerModel;
    private $projectModel;
    private $contractModel;

    public function __construct() {
        $this->freelancerModel = new FreelancerModel();
        $this->projectModel = new ProjectModel();
        $this->contractModel = new ContractModel();
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
        $projects = $this->projectModel->getAllActiveProjects();
        require_once 'views/freelancers/projects.php';
    }

    public function viewContracts() {
        $this->checkFreelancerSession();
        $contracts = $this->contractModel->getFreelancerContracts($_SESSION['user']['id']);
        require_once 'views/freelancers/contracts.php';
    }

    private function checkFreelancerSession() {
        if (!isset($_SESSION['user'])) {
            header("Location: /login");
            exit();
        }
    }
}
?>