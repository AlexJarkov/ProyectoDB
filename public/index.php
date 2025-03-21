// public/index.php
$router->get('/companies/dashboard', 'CompaniesController@dashboard');

<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
require_once __DIR__ . '/../app/controllers/FreelancerController.php';

$request = $_SERVER['REQUEST_URI'];
$freelancerController = new FreelancerController();

switch ($request) {
    case '/freelancers/dashboard':
        $freelancerController->dashboard();
        break;
    case '/freelancers/contracts':
        $freelancerController->contracts();
        break;
    case '/freelancers/offers':
        $freelancerController->offers();
        break;
    default:
        http_response_code(404);
        echo "404 Not Found";
        break;
}
?>
