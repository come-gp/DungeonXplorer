<?php
namespace App\Controllers;

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

        $error = $_SESSION['login_error'] ?? '';
        unset($_SESSION['login_error']);

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
                header('Location: ' . base_url('/'));
                exit();
            } else {
                $_SESSION['login_error'] = 'Identifiants incorrects.';
                header('Location:'  . base_url('/login'));
                exit();
            }
        } catch (\PDOException $e) {
            $_SESSION['login_error'] = 'Erreur de connexion. Veuillez réessayer.';
            header('Location: ' . base_url('/login'));
            exit();
        }
    }
}
