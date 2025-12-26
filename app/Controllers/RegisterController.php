<?php

namespace App\Controllers;

use App\Models\UserModel;

session_start();

class RegisterController{

    private UserModel $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function show()
    {
        // session_start();
        if (isset($_SESSION['user_id'])) {
            header('Location: ' . base_url('/'));
            exit();
        }

        $error = $_SESSION['register_error'] ?? '';
        unset($_SESSION['register_error']);



        // Charger la vue
        require __DIR__ . '/../Views/register.php';
    }




    public function register()
    {
        session_start();
        if (isset($_SESSION['user_id'])) {
            header('Location: ' . base_url('/'));
            exit();
        }

        // require __DIR__ . '/../Core/helpers.php';
        //require __DIR__ . '/../../php/Database.php';

        $error = '';
        $success = '';
        $pseudo = '';

        
        $pseudo = trim($_POST['pseudo'] ?? '');
        $password = $_POST['password'] ?? '';
        $confirm_password = $_POST['confirm_password'] ?? '';

        // Validation
        if (empty($pseudo)) {
            // $error = 'Le pseudo est requis.';
            $_SESSION['register_error'] = 'Le pseudo est requis.';
            header('Location:'  . base_url('/register'));
        } elseif (strlen($pseudo) < 3) {
            //$error = 'Le pseudo doit contenir au moins 3 caractères.';
            $_SESSION['register_error'] = 'Le pseudo doit contenir au moins 3 caractères.';
            header('Location:'  . base_url('/register'));
        } elseif (empty($password)) {
            //$error = 'Le mot de passe est requis.';
            $_SESSION['register_error'] = 'Le mot de passe est requis.';
            header('Location:'  . base_url('/register'));
        } elseif ($password !== $confirm_password) {
            //$error = 'Les mots de passe ne correspondent pas.';
            $_SESSION['register_error'] = 'Les mots de passe ne correspondent pas.';
            header('Location:'  . base_url('/register'));
        } else {
            try {
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                $user = $this->userModel->createUser($pseudo, $hashed_password);


                // $stmt = $db->prepare('SELECT id FROM user WHERE pseudo = :pseudo');
                // $stmt->execute(['pseudo' => $pseudo]);

                // if ($stmt->fetch()) {
                //     $error = 'Ce pseudo est déjà utilisé.';
                // } else {
                //     $hashed_password = password_hash($password, PASSWORD_DEFAULT);

                //     $stmt = $db->prepare('INSERT INTO user (pseudo, password) VALUES (:pseudo, :password)');
                //     $stmt->execute([
                //         'pseudo' => $pseudo,
                //         'password' => $hashed_password
                //     ]);

                //     $success = 'Compte créé avec succès ! Vous pouvez maintenant vous connecter.';
                //     $pseudo = '';
                // }
            } catch (\PDOException $e) {
                $error = 'Erreur lors de la création du compte. Veuillez réessayer.';
            }
        }
        

        // Charger la vue
        //require __DIR__ . '/../Views/register.php';
        header('Location: ' . base_url('/'));
    }
}
