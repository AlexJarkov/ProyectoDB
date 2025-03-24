<?php
// models/FreelancerModel.php

class FreelancerModel {
    private $db;
    private $freelancers;

    // Recibe la conexión a la base de datos por constructor
    public function __construct() {
        $this->db = Database::getInstance();
    }

    // Método para crear un perfil de freelancer
    public function createProfile($profileData) {
        $sql = "INSERT INTO freelancers (
            user_id, 
            full_name, 
            skills, 
            expected_payment, 
            cv_summary
        ) VALUES (
            :user_id, 
            :full_name, 
            :skills, 
            :expected_payment, 
            :cv_summary
        )";

        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':user_id' => $profileData['user_id'],
            ':full_name' => $profileData['full_name'],
            ':skills' => $profileData['skills'],
            ':expected_payment' => $profileData['expected_payment'],
            ':cv_summary' => $profileData['cv_summary']
        ]);
    }

    // Otros métodos útiles (ejemplos)
    public function getProfile($user_id) {
        $sql = "SELECT * FROM freelancers WHERE user_id = :user_id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':user_id' => $user_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getAllFreelancers() {
        $sql = "SELECT * FROM freelancers"; 
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC); // Devuelve los freelancers como un array
    }
}
?>