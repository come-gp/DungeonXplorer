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
        $stmt = $this->db->prepare('SELECT id, pseudo, password FROM user WHERE pseudo = :pseudo');
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
}
