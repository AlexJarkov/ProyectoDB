// app/controllers/CompaniesController.php
public function dashboard() {
    // Obtener freelancers desde el modelo
    $freelancerModel = new FreelancerModel();
    $freelancers = $freelancerModel->getAllFreelancers();

    // Cargar la vista
    require_once __DIR__ . '/../views/companies/dashboard.php';
}