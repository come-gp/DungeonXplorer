<?php
namespace App\Controllers;

session_start();

use App\Models\UserModel;

class LoginController
{
    private UserModel $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    // affiche la vue
    public function show(): void
    {
        if (isset($_SESSION['user_id'])) {
            header('Location: ' . base_url('/'));
            exit();
        } 

        $error = $_SESSION['error'] ?? '';
        unset($_SESSION['error']);

        // Include la vue (chemin relatif à app/Views)
        require __DIR__ . '/../Views/login.php';
    }

    // traitemenbnt du form
    public function login(): void
    {

        $pseudo = trim($_POST['pseudo'] ?? '');
        $password = $_POST['password'] ?? '';


        try {
            $user = $this->userModel->getUserByPseudo($pseudo);

            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_pseudo'] = $user['pseudo'];
                $_SESSION['is_admin'] = (bool)$user['is_admin'];
                $_SESSION['success'] = 'connecté avec succès.';
                header('Location: ' . base_url('/'));
                exit();
            } else {
                $_SESSION['error'] = 'Identifiants incorrects.';
                header('Location:'  . base_url('/login'));
                exit();
            }
        } catch (\PDOException $e) {
            $_SESSION['error'] = 'Erreur de connexion. Veuillez réessayer.';
            header('Location: ' . base_url('/login'));
            exit();
        }
    }
}
