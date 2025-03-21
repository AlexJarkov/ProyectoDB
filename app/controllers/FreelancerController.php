<?php
session_start();

class FreelancerController {
    public function dashboard() {
        require_once __DIR__ . '/../views/freelancers/dashboard.php';
    }

    public function contracts() {
        require_once __DIR__ . '/../views/freelancers/contracts.php';
    }

    public function offers() {
        require_once __DIR__ . '/../views/freelancers/offers.php';
    }
}
?>
