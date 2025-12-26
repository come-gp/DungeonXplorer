<?php

namespace App\Controllers;

use App\Models\HomeModel;

class HomeController {

    public function index()
    {

        $this->homeModel = new HomeModel();
        $userId = $_SESSION['user_id'] ?? null;
        $error = $_SESSION['error'] ?? '';
        
        unset($_SESSION['error']);

        $success = $_SESSION['success'] ?? '';

        $lastHero = null;
        $chapter = null;
        
        $isLoggedIn = isset($_SESSION['user_id']);
        $isAdmin = $isLoggedIn && $this->homeModel->isAdmin($_SESSION['user_id']);
        $_SESSION['is_admin'] = $isAdmin;
        
        
        if ($isLoggedIn) {
            $lastIdHero = $this->homeModel->getLastHeroByUserId($_SESSION['user_id']);
            if ($lastIdHero) {
                $lastHero = $this->homeModel->getHeroById($lastIdHero['id_hero']);
                $progress = $this->homeModel->getProgressByHeroId($lastIdHero['id_hero']);
                $class = $this->homeModel->getClassByHeroId($lastIdHero['id_hero']);
                if ($progress) {
                    $chapter = $this->homeModel->getChapterById($progress['chapter_id']);
                }
            }
        }

        require __DIR__ . '/../Views/home.php';

    }
}
