<?php
require_once __DIR__ . '/../config/database.php';

class CompanyModel extends BaseModel {
    protected $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    /**
     * Obtiene el perfil de la empresa basado en el ID del usuario.
     *
     * @param int $userId
     * @return array|false
     */
    public function getProfile($userId) {
        $sql = "SELECT * FROM companies WHERE user_id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$userId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Crea el perfil de la empresa.
     *
     * @param array $data Datos del perfil que deben incluir:
     *                    - user_id
     *                    - company_name
     *                    - industry
     *                    - location
     *                    - website (opcional)
     *                    - description (opcional)
     * @return string Último ID insertado en la tabla companies.
     */
    public function createProfile($data) {
        $sql = "INSERT INTO companies (user_id, company_name, industry, location, website, description) 
                VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            $data['user_id'],
            $data['company_name'],
            $data['industry'],
            $data['location'],
            !empty($data['website']) ? $data['website'] : null,
            !empty($data['description']) ? $data['description'] : null,
        ]);
        return $this->db->lastInsertId();
    }

    /**
     * Actualiza el perfil de la empresa.
     *
     * @param int   $userId ID del usuario/empresa.
     * @param array $data   Datos actualizados del perfil que deben incluir:
     *                      - company_name
     *                      - industry
     *                      - location
     *                      - website (opcional)
     *                      - description (opcional)
     * @return bool Resultado de la actualización.
     */
    public function updateProfile($userId, $data) {
        $sql = "UPDATE companies 
                SET company_name = ?, industry = ?, location = ?, website = ?, description = ? 
                WHERE user_id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            $data['company_name'],
            $data['industry'],
            $data['location'],
            !empty($data['website']) ? $data['website'] : null,
            !empty($data['description']) ? $data['description'] : null,
            $userId
        ]);
    }
}
?>