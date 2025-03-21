<?php
session_start();

class AuthController {
    private $userModel;
    private $freelancerModel;
    private $companyModel;

    public function __construct() {
        $this->userModel = new UserModel();
        $this->freelancerModel = new FreelancerModel();
        $this->companyModel = new CompanyModel();
    }

    public function showLogin() {
        require_once __DIR__ . '/../views/auth/login.php';
    }

    public function showRegister() {
        require_once __DIR__ . '/../views/auth/register.php';
    }

    public function register($data) {
        $errors = [];
        
        // Validaciones
        if (empty($data['email'])) {
            $errors[] = "Email es requerido";
        } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Formato de email inválido";
        }
        
        if (empty($data['password'])) {
            $errors[] = "Contraseña es requerida";
        } elseif (strlen($data['password']) < 8) {
            $errors[] = "La contraseña debe tener al menos 8 caracteres";
        } elseif (!preg_match('/\d/', $data['password'])) {
            $errors[] = "La contraseña debe contener al menos un número";
        } elseif (!preg_match('/[A-Za-z]/', $data['password'])) {
            $errors[] = "La contraseña debe contener al menos una letra";
        }
        
        if ($data['password'] !== $data['confirm_password']) {
            $errors[] = "Las contraseñas no coinciden";
        }
        
        if (!in_array($data['role'], ['freelancer', 'company'])) {
            $errors[] = "Rol de usuario inválido";
        }

        if (empty($errors)) {
            try {
                $hashedPassword = password_hash($data['password'], PASSWORD_DEFAULT);
                
                $user_id = $this->userModel->createUser(
                    $data['email'],
                    $hashedPassword,
                    $data['role']
                );
                
                // Crear perfil según rol
                if ($data['role'] === 'freelancer') {
                    $this->createFreelancerProfile($user_id, $data);
                } else {
                    $this->createCompanyProfile($user_id, $data);
                }

                $_SESSION['user'] = [
                    'id' => $user_id,
                    'email' => $data['email'],
                    'role' => $data['role']
                ];
                
                header("Location: /{$data['role']}/dashboard");
                exit();
            } catch (PDOException $e) {
                $errors[] = ($e->getCode() == 23000) ? "El email ya está registrado" : "Error en el registro: " . $e->getMessage();
            }
        }
        
        $_SESSION['errors'] = $errors;
        header("Location: /register");
        exit();
    }

    public function login($data) {
        $user = $this->userModel->getUserByEmail($data['email']);
        $errors = [];
        
        if ($user && password_verify($data['password'], $user['password'])) {
            // Eliminada la verificación de email
            session_regenerate_id(true);
            
            $_SESSION['user'] = [
                'id' => $user['id'],
                'email' => $user['email'],
                'role' => $user['role']
            ];
            
            $this->userModel->updateLastLogin($user['id']);
            header("Location: /{$user['role']}/dashboard");
            exit();
        }
        
        $errors[] = "Credenciales incorrectas";
        $_SESSION['errors'] = $errors;
        header("Location: /login");
        exit();
    }

    public function logout() {
        $_SESSION = array();
        
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }
        
        session_destroy();
        header("Location: /login");
        exit();
    }

    private function createFreelancerProfile($user_id, $data) {
        $requiredFields = ['full_name', 'skills', 'expected_payment', 'cv_summary'];
        $errors = [];
        
        // Validar campos requeridos
        foreach ($requiredFields as $field) {
            if (empty($data[$field])) {
                $errors[] = "El campo " . str_replace('_', ' ', $field) . " es requerido";
            }
        }
        
        // Validaciones adicionales
        if (!empty($data['full_name']) && strlen($data['full_name']) > 100) {
            $errors[] = "El nombre completo no puede exceder los 100 caracteres";
        }
        
        if (!empty($data['expected_payment']) && !is_numeric($data['expected_payment'])) {
            $errors[] = "El pago esperado debe ser un valor numérico válido";
        }
        
        if (!empty($errors)) {
            throw new Exception(implode(', ', $errors));
        }
        
        // Preparar datos para inserción
        $profileData = [
            'user_id' => (int)$user_id,  // PRIMARY KEY y FOREIGN KEY
            'full_name' => htmlspecialchars(trim($data['full_name'])), 
            'skills' => htmlspecialchars(trim($data['skills'])),
            'expected_payment' => number_format((float)$data['expected_payment'], 2, '.', ''),
            'cv_summary' => htmlspecialchars(trim($data['cv_summary']))
        ];
        
        $this->freelancerModel->createProfile($profileData);
    }

    private function createCompanyProfile($user_id, $data) {
        $requiredFields = ['company_name', 'industry', 'location'];
        $errors = [];
        
        foreach ($requiredFields as $field) {
            if (empty($data[$field])) {
                $errors[] = "El campo $field es requerido";
            }
        }
        
        if (!empty($errors)) {
            throw new Exception(implode(', ', $errors));
        }
        
        $this->companyModel->createProfile([
            'user_id' => $user_id,
            'company_name' => htmlspecialchars($data['company_name']),
            'industry' => htmlspecialchars($data['industry']),
            'location' => htmlspecialchars($data['location']),
            'website' => !empty($data['website']) ? filter_var($data['website'], FILTER_SANITIZE_URL) : null,
            'description' => !empty($data['description']) ? htmlspecialchars($data['description']) : null
        ]);
    }

    private function sendVerificationEmail($email, $token) {
        // Implementar lógica de envío de email
        $verificationLink = "https://tudominio.com/verify-email?token=$token";
        // Usar PHPMailer o servicio de correo
    }

    // Método para verificación de email
    public function verifyEmail($token) {
        $user = $this->userModel->getUserByVerificationToken($token);
        
        if ($user) {
            $this->userModel->markAsVerified($user['id']);
            $_SESSION['user']['verified'] = true;
            header("Location: /{$user['role']}/dashboard?verified=1");
        } else {
            $_SESSION['errors'] = ['Token de verificación inválido'];
            header("Location: /login");
        }
        exit();
    }
}
?>