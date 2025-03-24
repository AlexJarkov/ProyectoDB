<?php
require_once __DIR__ . '/../views/companies/dashboard.php';

class ProjectModel {
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getInstance();
    }

    /**
     * Crea un nuevo proyecto
     */
    public function createProject($companyId, $projectData) {
        $requiredFields = ['title', 'description', 'required_skills', 'budget'];
        $errors = [];

        // Validación de campos
        foreach ($requiredFields as $field) {
            if (empty($projectData[$field])) {
                $errors[] = "El campo " . str_replace('_', ' ', $field) . " es requerido";
            }
        }

        if (!is_numeric($projectData['budget']) || $projectData['budget'] <= 0) {
            $errors[] = "El presupuesto debe ser un valor numérico positivo";
        }

        if (!empty($errors)) {
            throw new Exception(implode(', ', $errors));
        }

        // Sanitización de datos
        $project = [
            'company_id' => (int)$companyId,
            'title' => htmlspecialchars(trim($projectData['title']), ENT_QUOTES, 'UTF-8'),
            'description' => htmlspecialchars(trim($projectData['description']), ENT_QUOTES, 'UTF-8'),
            'required_skills' => htmlspecialchars(trim($projectData['required_skills']), ENT_QUOTES, 'UTF-8'),
            'budget' => number_format((float)$projectData['budget'], 2, '.', ''),
            'status' => 'open',
            'created_at' => date('Y-m-d H:i:s')
        ];

        $sql = "INSERT INTO projects (
            company_id, 
            title, 
            description, 
            required_skills, 
            budget, 
            status, 
            created_at
        ) VALUES (
            :company_id, 
            :title, 
            :description, 
            :required_skills, 
            :budget, 
            :status, 
            :created_at
        )";

        $stmt = $this->db->prepare($sql);
        return $stmt->execute($project);
    }

    /**
     * Obtiene proyectos por ID de empresa
     */
    public function getProjectsByCompany($companyId) {
        $sql = "SELECT * FROM projects WHERE company_id = :company_id ORDER BY created_at DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':company_id' => $companyId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Obtiene proyectos activos (abiertos)
     */
    public function getActiveProjects() {
        $sql = "SELECT 
                p.*, 
                c.company_name 
            FROM projects p
            JOIN companies c ON p.company_id = c.user_id
            WHERE p.status = 'open'
            ORDER BY p.created_at DESC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Actualiza el estado de un proyecto
     */
    public function updateProjectStatus($projectId, $newStatus) {
        $allowedStatuses = ['open', 'in_progress', 'completed'];
        
        if (!in_array($newStatus, $allowedStatuses)) {
            throw new Exception("Estado de proyecto inválido");
        }

        $sql = "UPDATE projects SET status = :status WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':status' => $newStatus,
            ':id' => $projectId
        ]);
    }

    /**
     * Obtiene detalles de un proyecto específico
     */
    public function getProjectDetails($projectId) {
        $sql = "SELECT 
                p.*, 
                c.company_name, 
                c.location 
            FROM projects p
            JOIN companies c ON p.company_id = c.user_id
            WHERE p.id = :id";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $projectId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>