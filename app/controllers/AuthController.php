<?php
session_start();

class AuthController {
    private $userModel;

    public function __construct() {
        $this->userModel = new UserModel();
    }

    public function showLogin() {
        require_once __DIR__ . '/../views/auth/login.php';
    }

    public function showRegister() {
        require_once __DIR__ . '/../views/auth/register.php';
    }

    public function register($data) {
        // Validación
        $errors = [];
        if (empty($data['email'])) $errors[] = "Email es requerido";
        if (empty($data['password'])) $errors[] = "Contraseña es requerida";
        if ($data['password'] !== $data['confirm_password']) $errors[] = "Las contraseñas no coinciden";

        if (count($errors) === 0) {
            try {
                $user_id = $this->userModel->createUser(
                    $data['email'],
                    $data['password'],
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
                $errors[] = "El email ya está registrado";
            }
        }
        $_SESSION['errors'] = $errors;
        header("Location: /register");
        exit();
    }

    public function login($data) {
        $user = $this->userModel->getUserByEmail($data['email']);
        
        if ($user && password_verify($data['password'], $user['password'])) {
            $_SESSION['user'] = [
                'id' => $user['id'],
                'email' => $user['email'],
                'role' => $user['role']
            ];
            
            header("Location: /{$user['role']}/dashboard");
            exit();
        }
        
        $_SESSION['errors'] = ["Credenciales incorrectas"];
        header("Location: /login");
        exit();
    }

    public function logout() {
        session_destroy();
        header("Location: /login");
        exit();
    }

    private function createFreelancerProfile($user_id, $data) {
        // Implementar creación de perfil freelancer
    }

    private function createCompanyProfile($user_id, $data) {
        // Implementar creación de perfil empresa
    }
}
?>