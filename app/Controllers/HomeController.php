<?php

namespace App\Controllers;

session_start();

class HomeController {

    public function index()
    {
        

        $error = $_SESSION['error'] ?? '';
        unset($_SESSION['error']);

        $success = $_SESSION['success'] ?? '';
        unset($_SESSION['success']);

        $isLoggedIn = isset($_SESSION['user_id']);

        require __DIR__ . '/../Views/home.php';
    }
}
