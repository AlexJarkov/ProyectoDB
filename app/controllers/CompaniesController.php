// app/controllers/CompaniesController.php
public function dashboard() {
    // Obtener freelancers desde el modelo
    $freelancerModel = new FreelancerModel();
    $freelancers = $freelancerModel->getAllFreelancers();

    // Cargar la vista
    require_once __DIR__ . '/../views/companies/dashboard.php';
}
<?php
class CompaniesController {
    private $companyModel;
    private $projectModel;
    private $contractModel;

    public function __construct() {
        $this->companyModel = new CompanyModel();
        $this->projectModel = new ProjectModel();
        $this->contractModel = new ContractModel();
    }

    public function dashboard() {
        $this->checkCompanySession();
        $companyData = $this->companyModel->getProfile($_SESSION['user']['id']);
        require_once 'views/companies/dashboard.php';
    }

    public function viewProfile() {
        $this->checkCompanySession();
        $profile = $this->companyModel->getProfile($_SESSION['user']['id']);
        require_once 'views/companies/profile.php';
    }

    public function editProfile($data) {
        $this->checkCompanySession();
        // Lógica de actualización de perfil
    }

    public function postProject($projectData) {
        $this->checkCompanySession();
        // Validar y crear nuevo proyecto
    }

    public function viewPostedProjects() {
        $this->checkCompanySession();
        $projects = $this->projectModel->getProjectsByCompany($_SESSION['user']['id']);
        require_once 'views/companies/projects.php';
    }

    public function searchFreelancers() {
        $this->checkCompanySession();
        // Lógica de búsqueda de freelancers
    }

    private function checkCompanySession() {
        if (!isset($_SESSION['user'])) {
            header("Location: /login");
            exit();
        }
    }
}
?>