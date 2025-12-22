<?php

namespace App\Controllers;
session_start();

use App\Models\UserModel;
use App\Models\HeroModel;
use App\Models\ChapterModel;

class GameController{

    private UserModel $userModel;
    private HeroModel $heroModel;
    private ChapterModel $ChapterModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->heroModel = new HeroModel();
        $this->ChapterModel = new ChapterModel();
    }

    public function show()
    {

        
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['error'] = 'Vous devez être connecté pour accéder au jeu.';
            header('Location: ' . base_url('/'));
            exit();
        }



        $error = $_SESSION['error'] ?? '';
        unset($_SESSION['error']);
        $success = $_SESSION['success'] ?? '';
        unset($_SESSION['success']);




        // recup hero 

        $hero = $this->heroModel->getActiveHeroByUserId($_SESSION['user_id']);

        if (!$hero) {
            echo"<script language=\"javascript\">";
            echo"alert('pas de hero , creer une partie redirection');";
            echo"</script>";
            header('Location: ' . base_url('/new-game'));
            exit();
        }


        // recup progression

        // $stmt = $db->prepare('
        //     SELECT chapter_id 
        //     FROM hero_progress 
        //     WHERE hero_id = ? 
        //     ORDER BY completion_date DESC 
        //     LIMIT 1
        // ');
        // $stmt->execute([$hero['id']]);
        // $progress = $stmt->fetch();

        echo "hero id: " . $hero['id']; // Debug line

        $progress = $this->heroModel->getProgress($hero['id']);



        // coommencer au chap 1 si ya  r
        $currentChapterId = $progress ? $progress['chapter_id'] : 1;


        // recup chap actu
        // $stmt = $db->prepare('SELECT * FROM chapter WHERE id = ?');
        // $stmt->execute([$currentChapterId]);
        // $chapter = $stmt->fetch();
        $chapterContent = $this->ChapterModel->getChapContent($currentChapterId);

        // recup combat
        // $stmt = $db->prepare('
        //     SELECT *
        //     FROM encounter e
        //     JOIN monster m ON e.monster_id = m.id
        //     WHERE e.chapter_id = ?
        // ');
        // $stmt->execute([$currentChapterId]);
        // $encounter = $stmt->fetch();

        $encounter = $this->ChapterModel->getCombatByChapterId($currentChapterId);

        // recup choix
        // $stmt = $db->prepare('
        //     SELECT * FROM links 
        //     WHERE chapter_id = ?
        // ');
        // $stmt->execute([$currentChapterId]);
        // $choices = $stmt->fetchAll();

        $choices = $this->ChapterModel->getChoicesByChapterId($currentChapterId);

        // foreach($choices as $result) {
        //     echo $result['type'], '<br>';
        // }
        // echo $currentChapterId;

        // recup loot
        // $stmt = $db->prepare('
        //     SELECT *
        //     FROM chapter_treasure ct
        //     JOIN items i ON ct.item_id = i.id
        //     WHERE ct.chapter_id = ?
        // ');
        // $stmt->execute([$currentChapterId]);
        // $treasures = $stmt->fetchAll();
        $treasures = $this->ChapterModel->getLootByChapterId($currentChapterId);



        // Charger la vue
        require __DIR__ . '/../Views/game.php';
    }




    public function postGame()
    {
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['error'] = 'Vous devez être connecté pour accéder au jeu.';
            header('Location: ' . base_url('/'));
            exit();
        }

        // require __DIR__ . '/../core/helpers.php';
        //require __DIR__ . '/../../php/Database.php';

        $error = '';
        $success = '';
        $pseudo = '';

        

        // traitement des action
        if ( isset($_POST['next_chapter'])) {
            $nextChapterId = (int)$_POST['next_chapter'];
            
            // save progression
            // $stmt = $db->prepare('
            //     INSERT INTO hero_progress (hero_id, chapter_id, status, completion_date)
            //     VALUES (?, ?, "Completed", NOW())
            // ');
            // $stmt->execute([$hero['id'], $nextChapterId]);
            

            // recup hero 

            $hero = $this->heroModel->getActiveHeroByUserId($_SESSION['user_id']);
            $this->heroModel->saveProgress($hero['id'], $nextChapterId);
            
            // tresors (marche surement pas)
            // if (!empty($treasures)) {
            //     foreach ($treasures as $treasure) {
            //         $stmt = $db->prepare('SELECT * FROM inventory WHERE hero_id = ? AND item_id = ?');
            //         $stmt->execute([$hero['id'], $treasure['item_id']]);
            //         $existing = $stmt->fetch();
                    
            //         if ($existing) {
            //             $stmt = $db->prepare('UPDATE inventory SET quantity = quantity + ? WHERE hero_id = ? AND item_id = ?');
            //             $stmt->execute([$treasure['quantity'], $hero['id'], $treasure['item_id']]);
            //         } else {
            //             $stmt = $db->prepare('INSERT INTO inventory (hero_id, item_id, quantity) VALUES (?, ?, ?)');
            //             $stmt->execute([$hero['id'], $treasure['item_id'], $treasure['quantity']]);
            //         }
            //     }
            // }
            
            header('Location: ' . base_url('/game'));
            exit();
        }

        // savoir si il y a un combat
        $inCombat = $encounter ? true : false;




        

        // Charger la vue
        //require __DIR__ . '/../Views/register.php';
        header('Location: ' . base_url('/game'));
    }
}
