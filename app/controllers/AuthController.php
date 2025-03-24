<?php

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

        if (empty($data['email']) || !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Email inválido";
        }

        if (empty($data['password']) || strlen($data['password']) < 6) {
            $errors[] = "Contraseña muy corta";
        }

        if ($data['password'] !== $data['confirm_password']) {
            $errors[] = "Las contraseñas no coinciden";
        }

        if (!in_array($data['role'], ['freelancer', 'company'])) {
            $errors[] = "Rol inválido";
        }

        if (empty($errors)) {
            try {
                $userId = $this->userModel->createUser($data['email'], $data['password'], $data['role']);

                if ($data['role'] === 'freelancer') {
                    $this->freelancerModel->createProfile($userId, [
                        'full_name' => 'Freelancer por defecto',
                        'skills' => 'Habilidades iniciales',
                        'expected_payment' => 1000.00,
                        'cv_summary' => 'Resumen genérico'
                    ]);
                } else {
                    $this->companyModel->createProfile([
                        'user_id' => $userId,
                        'company_name' => 'Empresa por defecto',
                        'industry' => 'General',
                        'location' => 'Ciudad',
                        'website' => null,
                        'description' => 'Descripción básica'
                    ]);
                }

                $_SESSION['user'] = [
                    'id' => $userId,
                    'email' => $data['email'],
                    'role' => $data['role']
                ];

                // Redirigir directamente al archivo físico
                header("Location: /app/views/{$data['role']}s/dashboard.php");
                exit();
            } catch (PDOException $e) {
                $errors[] = "Error: " . $e->getMessage();
            }
        }

        $_SESSION['errors'] = $errors;
        header("Location: /app/views/auth/register.php");
        exit();
    }

    public function login($data) {
        $errors = [];

        $user = $this->userModel->getUserByEmail($data['email']);

        if ($user && password_verify($data['password'], $user['password'])) {
            $_SESSION['user'] = [
                'id' => $user['id'],
                'email' => $user['email'],
                'role' => $user['role']
            ];

            $this->userModel->updateLastLogin($user['id']);

            // Redirigir directamente a la vista del dashboard según el rol
            header("Location: /app/views/{$user['role']}s/dashboard.php");
            exit();
        }

        $errors[] = "Credenciales incorrectas";
        $_SESSION['errors'] = $errors;
        header("Location: /app/views/auth/login.php");
        exit();
    }

    public function logout() {
        session_destroy();
        header("Location: /app/views/auth/login.php");
        exit();
    }
}
