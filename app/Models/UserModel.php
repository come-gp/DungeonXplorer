<?php
// app/Models/UserModel.php
namespace App\Models;

class UserModel
{
    private \PDO $db;

    public function __construct()
    {
        $config = require __DIR__ . '/../../config/database.php';
        $this->db = $config['pdo']; 
    }

    public function getUserByPseudo(string $pseudo): ?array
    {
        $stmt = $this->db->prepare('SELECT id, pseudo, password, is_admin FROM user WHERE pseudo = :pseudo');
        $stmt->execute(['pseudo' => $pseudo]);
        $user = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $user ?: null;
    }

    public function createUser(string $pseudo, string $hashedPassword): int
    {
        $stmt = $this->db->prepare('INSERT INTO user (pseudo, password) VALUES (:pseudo, :password)');
        $stmt->execute([
            'pseudo' => $pseudo,
            'password' => $hashedPassword
        ]);
        return (int)$this->db->lastInsertId();
    }

    // public function getHero(string $user_id): ?array
    // {

    //     $stmt = $this->$db->prepare('
    //         SELECT h.*, c.name as class_name, c.base_pv as max_pv, c.base_mana as max_mana
    //         FROM hero h
    //         JOIN appartenir a ON h.id = a.id_hero
    //         JOIN class c ON h.class_id = c.id
    //         WHERE a.id_user = ?
    //         ORDER BY a.derniere_utilisation DESC
    //         LIMIT 1
    //     ');
    //     $stmt->execute($user_id);
    //     $hero = $stmt->fetch();
    //     return $hero ?: null;
    // }

    public function getAllUsers(): array
    {
        $stmt = $this->db->query('SELECT id, pseudo, is_admin FROM user');
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function delete(int $id): void
    {
        $stmt = $this->db->prepare('DELETE FROM user WHERE id = :id');
        $stmt->execute(['id' => $id]);
    }
}
