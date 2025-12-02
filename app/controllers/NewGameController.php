<?php
namespace App\Controllers;

session_start();

use App\Models\HeroModel;
use App\Models\ClassModel;

class NewGameController
{
    private HeroModel $heroModel;
    private ClassModel $classModel;

    public function __construct()
    {
        $this->heroModel = new HeroModel();

        $this->classModel = new ClassModel();

    }

 
    public function show(): void
    {

        if (!isset($_SESSION['user_id'])) {
            $_SESSION['error'] = 'Vous devez être connecté pour créer un héros.';
            header('Location: ' . base_url('/login'));
            exit();
        }

        
        $classes = $this->classModel->getAllClasses();
        

        $error = $_SESSION['newgame_error'] ?? '';
        unset($_SESSION['newgame_error']);

        // variable pour remmettre les choses bien dans les bons endroits si il y a des erreurs
        $heroName = $_SESSION['form_hero_name'] ?? ''; 
        $biography = $_SESSION['form_biography'] ?? '';
        unset($_SESSION['form_hero_name'], $_SESSION['form_biography']);

        require __DIR__ . '/../Views/new-game.php';
    }

    public function create(): void
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . base_url('/login'));
            exit();
        }

       
        $heroName = trim($_POST['hero_name'] ?? '');
        $classId = (int)($_POST['class_id'] ?? 0);
        $biography = trim($_POST['biography'] ?? '');

        
        if (empty($heroName)) {
            $_SESSION['newgame_error'] = 'Le nom du héros est requis.';
            $_SESSION['form_hero_name'] = $heroName;
            $_SESSION['form_biography'] = $biography;
            header('Location: ' . base_url('/new-game'));
            exit();
        }

        if (strlen($heroName) < 3) {
            $_SESSION['newgame_error'] = 'Le nom doit contenir au moins 3 caractères.';
            $_SESSION['form_hero_name'] = $heroName;
            $_SESSION['form_biography'] = $biography;
            header('Location: ' . base_url('/new-game'));
            exit();
        }

        if ($classId <= 0) {
            $_SESSION['newgame_error'] = 'Veuillez sélectionner une classe.';
            $_SESSION['form_hero_name'] = $heroName;
            $_SESSION['form_biography'] = $biography;
            header('Location: ' . base_url('/new-game'));
            exit();
        }

        try {
            // stats class
            $selectedClass = $this->classModel->getClassById($classId);

            if (!$selectedClass) {
                $_SESSION['newgame_error'] = 'Classe invalide.';
                $_SESSION['form_hero_name'] = $heroName;
                $_SESSION['form_biography'] = $biography;
                header('Location: ' . base_url('/new-game'));
                exit();
            }

            // creation hero
            $heroId = $this->heroModel->createHero([
                'name' => $heroName,
                'class_id' => $classId,
                'biography' => $biography,
                'pv' => $selectedClass['base_pv'],
                'mana' => $selectedClass['base_mana'],
                'strength' => $selectedClass['strength'],
                'initiative' => $selectedClass['initiative']
            ]);

            // liasion user hero
            $this->heroModel->linkHeroToUser($_SESSION['user_id'], $heroId);

            //go to le jeu
            $_SESSION['success'] = "Héros {$heroName} créé avec succès !";
            header('Location: ' . base_url('/game'));
            exit();

        } catch (\PDOException $e) {
            $_SESSION['newgame_error'] = 'Erreur lors de la création du héros. Veuillez réessayer.';
            $_SESSION['form_hero_name'] = $heroName;
            $_SESSION['form_biography'] = $biography;
            header('Location: ' . base_url('/new-game'));
            exit();
        }
    }
}