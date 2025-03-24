<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

require_once __DIR__ . '/../app/config/database.php';
require_once __DIR__ . '/../app/models/BaseModel.php';
require_once __DIR__ . '/../app/models/UserModel.php';
require_once __DIR__ . '/../app/models/FreelancerModel.php';
require_once __DIR__ . '/../app/models/CompanyModel.php';

require_once __DIR__ . '/../app/controllers/AuthController.php';

$auth = new AuthController();

// Verifica si el formulario envió una acción
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    switch ($action) {
        case 'login':
            $auth->login($_POST);
            break;

        case 'register':
            $auth->register($_POST);
            break;

        default:
            echo "Acción no reconocida.";
    }

} else {
    echo "<h2>Accede desde un formulario</h2>";
}
