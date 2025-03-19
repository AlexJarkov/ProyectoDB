// app/controllers/AuthController.php
public function registerFreelancer($data) {
    // Validar datos
    // Hash password
    $hashed_password = password_hash($data['password'], PASSWORD_DEFAULT);
    
    // Insertar en users
    $sql = "INSERT INTO users (email, password, role) VALUES (?, ?, 'freelancer')";
    // Ejecutar query
    
    // Obtener ID insertado
    $user_id = $conn->lastInsertId();
    
    // Insertar en freelancers
    $sql = "INSERT INTO freelancers 
            (user_id, full_name, skills, expected_payment, cv_summary)
            VALUES (?, ?, ?, ?, ?)";
    // Ejecutar query
}