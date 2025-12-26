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
        // print_r($treasures[0]['item_id']);
        // foreach ($treasures as $treasure) {
        //     print_r($treasure['item_id']);
        //     print_r($hero['id']);
        //     print_r($treasure['quantity']);
        // }

        foreach ($treasures as $treasure) {
            $this->heroModel->addToInventory($hero['id'], $treasure['item_id'], 1);
        }

        // recup inventaire
        $inventory = $this->heroModel->getInventory($hero['id']);

       


        require __DIR__ . '/../Views/game.php';
    }




    public function postGame()
    {
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['error'] = 'Vous devez être connecté pour accéder au jeu.';
            header('Location: ' . base_url('/'));
            exit();
        }

        $hero = $this->heroModel->getActiveHeroByUserId($_SESSION['user_id']);

        // Traitement des actions de potion en combat
        // if (isset($_POST['drink_potion'])) {
        //     // Récupérer le nombre total de potions
        //     $inventory = $this->heroModel->getInventory($hero['id']);
        //     $potionCount = 0;
        //     $potionItemId = null;
            
        //     foreach ($inventory as $item) {
        //         if (strpos($item['item_type'], 'potion') !== false) {
        //             $potionCount += $item['quantity'];
        //             $potionItemId = $item['id'];
        //         }
        //     }
            
        //     if ($potionCount > 0 && $potionItemId) {
        //         // Restaurer 30 PV
        //         $newPV = min($hero['pv'] + 30, $hero['max_pv']);
        //         $healAmount = $newPV - $hero['pv'];
                
        //         // Utiliser la potion
        //         $this->heroModel->usePotion($hero['id'], $potionItemId);
                
        //         // Mettre à jour les PV du héros
        //         $this->heroModel->updateHeroStats($hero['id'], ['pv' => $newPV]);
                
        //         $_SESSION['success'] = "Potion bue! Restauration de " . $healAmount . " PV.";
        //     } else {
        //         $_SESSION['error'] = "Vous n'avez pas de potion!";
        //     }
            
        //     header('Location: ' . base_url('/game'));
        //     exit();
        // }

        // // Traitement des actions de potion
        // if (isset($_POST['use_potion'])) {
        //     $itemId = (int)$_POST['use_potion'];
            
        //     // Vérifier que la potion existe dans l'inventaire
        //     $potion = $this->heroModel->getPotion($hero['id'], $itemId);
            
        //     if ($potion && $potion['quantity'] > 0) {
        //         // Utiliser la potion
        //         $this->heroModel->usePotion($hero['id'], $itemId);
                
        //         $_SESSION['success'] = 'Potion ' . htmlspecialchars($potion['name']) . ' utilisée!';
        //     } else {
        //         $_SESSION['error'] = 'Vous n\'avez pas cette potion!';
        //     }
            
        //     header('Location: ' . base_url('/game'));
        //     exit();
        // }

        // traitement des action
        if (isset($_POST['next_chapter'])) {
            $nextChapterId = (int)$_POST['next_chapter'];
            
            // save progression
            $this->heroModel->saveProgress($hero['id'], $nextChapterId);
            
            header('Location: ' . base_url('/game'));
            exit();
        }

        // Traitement des actions de combat (à implémenter avec le système de combat)
        if (isset($_POST['combat_action'])) {
            $action = $_POST['combat_action'];
            // À implémenter selon le système de combat
        }

        header('Location: ' . base_url('/game'));
    }

    public function saveCombat()
    {
        header('Content-Type: application/json');

        if (!isset($_SESSION['user_id'])) {
            http_response_code(401);
            echo json_encode(['success' => false, 'error' => 'Non authentifié']);
            exit();
        }

        // Récupérer les données JSON du body
        $inputData = json_decode(file_get_contents('php://input'), true);

        if (!$inputData) {
            http_response_code(400);
            echo json_encode(['success' => false, 'error' => 'Données invalides']);
            exit();
        }

        try {
            $heroId = (int)($inputData['hero_id'] ?? 0);
            $result = $inputData['result'] ?? '';
            $xpGained = (int)($inputData['xp_gained'] ?? 0);
            $heroPv = (int)($inputData['hero_pv'] ?? 0);
            $heroMana = (int)($inputData['hero_mana'] ?? 0);
            $chapterId = (int)($inputData['chapter_id'] ?? 0);
            $nbPotions = (int)($inputData['nbPotions'] ?? 0);

            if (!$heroId || !$result) {
                http_response_code(400);
                echo json_encode(['success' => false, 'error' => 'Données manquantes']);
                exit();
            }

            // maj pv et mana hero
            $this->heroModel->updateHeroPv($heroId, $heroPv);
            $this->heroModel->updateHeroMana($heroId, $heroMana);

            $this->heroModel->setItemInventory($heroId, 1, $nbPotions); // item_id 1 = potion de soin

            // victoire
            if ($result === 'victoire' && $xpGained > 0) {
                $this->heroModel->addXp($heroId, $xpGained);
                
                // si le hero peut changer de niveau
                $hero = $this->heroModel->getHeroById($heroId);
                $currentLevel = getLevelFromXp($hero['xp']);
                
                // level up
                if ($currentLevel > $hero['current_level']) {
                    // maj niveau
                    $this->heroModel->updateHeroStats($heroId, ['current_level' => $currentLevel]);
                }

                //  enregistrer
                $nextChapterId = $chapterId + 1;
                $this->heroModel->saveProgress($heroId, $nextChapterId);
            }

            echo json_encode(['success' => true]);

        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode(['success' => false, 'error' => 'Erreur serveur: ' . $e->getMessage()]);
        }
    }
}
