<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\HeroModel;

class ProfileController
{
    private \PDO $db;
    
    public function __construct()
    {
        $config = require __DIR__ . '/../../config/database.php';
        $this->db = $config['pdo'];
    }
    
    public function show()
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . base_url('/login'));
            exit;
        }
        
        $user_id = $_SESSION['user_id'];
        $success_message = $_SESSION['success_message'] ?? '';
        $error_message = $_SESSION['error_message'] ?? '';
        
        unset($_SESSION['success_message']);
        unset($_SESSION['error_message']);
        
        try {
            $stmt = $this->db->prepare("SELECT id, pseudo FROM user WHERE id = ?");
            $stmt->execute([$user_id]);
            $user = $stmt->fetch(\PDO::FETCH_ASSOC);
            
            if (!$user) {
                session_destroy();
                header('Location: ' . base_url('/login'));
                exit;
            }
            
            $stmt = $this->db->prepare("SELECT COUNT(*) as total FROM appartenir WHERE id_user = ?");
            $stmt->execute([$user_id]);
            $hero_count = $stmt->fetch(\PDO::FETCH_ASSOC)['total'];
            
            $stmt = $this->db->prepare("
                SELECT 
                    h.id,
                    h.name AS hero_name,
                    h.pv,
                    h.mana,
                    h.strength,
                    h.xp,
                    h.current_level,
                    h.image,
                    c.name AS class_name,
                    a.derniere_utilisation,
                    (SELECT COUNT(*) 
                     FROM hero_progress 
                     WHERE hero_id = h.id) AS chapters_completed,
                    (SELECT chapter_id 
                     FROM hero_progress 
                     WHERE hero_id = h.id 
                     ORDER BY completion_date DESC 
                     LIMIT 1) AS last_chapter_id,
                    (SELECT content 
                     FROM chapter 
                     WHERE id = (SELECT chapter_id 
                                FROM hero_progress 
                                WHERE hero_id = h.id 
                                ORDER BY completion_date DESC 
                                LIMIT 1)
                     LIMIT 1) AS last_chapter_content
                FROM hero h
                INNER JOIN appartenir a ON h.id = a.id_hero
                LEFT JOIN class c ON h.class_id = c.id
                WHERE a.id_user = ?
                ORDER BY a.derniere_utilisation DESC
            ");
            $stmt->execute([$user_id]);
            $heroes = $stmt->fetchAll(\PDO::FETCH_ASSOC);
            
        } catch (\PDOException $e) {
            $error_message = "Erreur lors de la récupération des données : " . $e->getMessage();
            $user = ['pseudo' => 'Utilisateur'];
            $hero_count = 0;
            $heroes = [];
        }
        
        require __DIR__ . '/../Views/profile.php';
    }
    
    public function update()
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . base_url('/login'));
            exit;
        }
        
        $user_id = $_SESSION['user_id'];
        $new_pseudo = trim($_POST['pseudo'] ?? '');
        $current_password = $_POST['current_password'] ?? '';
        $new_password = $_POST['new_password'] ?? '';
        $confirm_password = $_POST['confirm_password'] ?? '';
        
        try {
            $stmt = $this->db->prepare("SELECT password FROM user WHERE id = ?");
            $stmt->execute([$user_id]);
            $user_data = $stmt->fetch(\PDO::FETCH_ASSOC);
            
            if (!password_verify($current_password, $user_data['password'])) {
                $_SESSION['error_message'] = "Le mot de passe actuel est incorrect.";
                header('Location: ' . base_url('/profile'));
                exit;
            }
            
            if (empty($new_pseudo) || strlen($new_pseudo) < 3) {
                $_SESSION['error_message'] = "Le pseudo doit contenir au moins 3 caractères.";
                header('Location: ' . base_url('/profile'));
                exit;
            }
            
            if (!empty($new_password)) {
                if (strlen($new_password) < 6) {
                    $_SESSION['error_message'] = "Le nouveau mot de passe doit contenir au moins 6 caractères.";
                    header('Location: ' . base_url('/profile'));
                    exit;
                }
                
                if ($new_password !== $confirm_password) {
                    $_SESSION['error_message'] = "Les mots de passe ne correspondent pas.";
                    header('Location: ' . base_url('/profile'));
                    exit;
                }
                
                $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
                $stmt = $this->db->prepare("UPDATE user SET pseudo = ?, password = ? WHERE id = ?");
                $stmt->execute([$new_pseudo, $hashed_password, $user_id]);
                $_SESSION['success_message'] = "Profil et mot de passe modifiés avec succès !";
            } else {
                $stmt = $this->db->prepare("UPDATE user SET pseudo = ? WHERE id = ?");
                $stmt->execute([$new_pseudo, $user_id]);
                $_SESSION['success_message'] = "Profil modifié avec succès !";
            }
            
        } catch (\PDOException $e) {
            $_SESSION['error_message'] = "Erreur lors de la modification : " . $e->getMessage();
        }
        
        header('Location: ' . base_url('/profile'));
        exit;
    }
}