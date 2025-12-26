<?php
// app/Models/ClassModel.php
namespace App\Models;

class ClassModel
{
    private \PDO $db;

    public function __construct()
    {
        $config = require __DIR__ . '/../../config/database.php';
        $this->db = $config['pdo'];
    }

    public function getAllClasses(): array
    {
        $stmt = $this->db->query('SELECT * FROM class ORDER BY id');
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getClassById(int $classId): ?array
    {
        $stmt = $this->db->prepare('SELECT * FROM class WHERE id = ?');
        $stmt->execute([$classId]);
        $class = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $class ?: null;
    }

   
    public function getClassByName(string $name): ?array
    {
        $stmt = $this->db->prepare('SELECT * FROM class WHERE name = ?');
        $stmt->execute([$name]);
        $class = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $class ?: null;
    }

    public function createClass(array $data): int
    {
        $stmt = $this->db->prepare('
            INSERT INTO class (name, description, base_pv, base_mana, strength, initiative, max_items)
            VALUES (:name, :description, :base_pv, :base_mana, :strength, :initiative, :max_items)
        ');
        
        $stmt->execute([
            'name' => $data['name'],
            'description' => $data['description'],
            'base_pv' => $data['base_pv'],
            'base_mana' => $data['base_mana'],
            'strength' => $data['strength'],
            'initiative' => $data['initiative'],
            'max_items' => $data['max_items']
        ]);
        
        return (int)$this->db->lastInsertId();
    }


    public function updateClass(int $classId, array $data): bool
    {
        $stmt = $this->db->prepare('
            UPDATE class 
            SET name = :name, 
                description = :description, 
                base_pv = :base_pv, 
                base_mana = :base_mana, 
                strength = :strength, 
                initiative = :initiative, 
                max_items = :max_items
            WHERE id = :id
        ');
        
        return $stmt->execute([
            'id' => $classId,
            'name' => $data['name'],
            'description' => $data['description'],
            'base_pv' => $data['base_pv'],
            'base_mana' => $data['base_mana'],
            'strength' => $data['strength'],
            'initiative' => $data['initiative'],
            'max_items' => $data['max_items']
        ]);
    }

    public function deleteClass(int $classId): bool
    {
        $stmt = $this->db->prepare('DELETE FROM class WHERE id = ?');
        return $stmt->execute([$classId]);
    }
}