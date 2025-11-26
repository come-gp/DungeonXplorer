<?php

namespace App\Controllers;

class HomeController {

    public function index()
    {
        session_start();

        $isLoggedIn = isset($_SESSION['user_id']);

        require __DIR__ . '/../Views/home.php';
    }
}
