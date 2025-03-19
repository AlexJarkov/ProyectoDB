// app/controllers/FreelancerController.php
public function getAllFreelancers() {
    $sql = "SELECT f.*, u.email 
            FROM freelancers f
            JOIN users u ON f.user_id = u.id";
    // Ejecutar y retornar resultados
}