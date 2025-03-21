// app/controllers/CompaniesController.php
public function dashboard() {
    // Obtener freelancers desde el modelo
    $freelancerModel = new FreelancerModel();
    $freelancers = $freelancerModel->getAllFreelancers();

    // Cargar la vista
    require_once __DIR__ . '/../views/companies/dashboard.php';
}

<?php
session_start();

class CompanyController {
    public function dashboard() {
        require_once __DIR__ . '/../views/companies/dashboard.php';
    }

    public function contracts() {
        require_once __DIR__ . '/../views/companies/contracts.php';
    }

    public function offers() {
        require_once __DIR__ . '/../views/companies/offers.php';
    }
}
?>
