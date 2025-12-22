<?php

namespace App\Controllers;

session_start();

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

        
        
        if ($isLoggedIn) {
            $lastIdHero = $this->homeModel->getLastHeroByUserId($_SESSION['user_id']);
            if ($lastIdHero) {
                $lastHero = $this->homeModel->getHeroById($lastIdHero['id_hero']);
                $idChapter = $this->homeModel->getChapterIdByHeroId($lastIdHero['id_hero']);
                if ($idChapter) {
                    $chapter = $this->homeModel->getChapterById($idChapter['chapter_id']);
                }
            }
        }

        require __DIR__ . '/../Views/home.php';

    }
}
