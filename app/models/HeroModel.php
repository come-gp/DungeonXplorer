<?php
// app/Models/HeroModel.php
namespace App\Models;

class HeroModel
{
    private \PDO $db;

    public function __construct()
    {
        $config = require __DIR__ . '/../../config/database.php';
        $this->db = $config['pdo'];
    }


    public function getHeroById(int $heroId): ?array
    {
        $stmt = $this->db->prepare('
            SELECT h.*, c.name as class_name, c.base_pv as max_pv, c.base_mana as max_mana
            FROM hero h
            JOIN class c ON h.class_id = c.id
            WHERE h.id = ?
        ');
        $stmt->execute([$heroId]);
        $hero = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $hero ?: null;
    }


    public function getActiveHeroByUserId(int $userId): ?array
    {
        $stmt = $this->db->prepare('
            SELECT h.*, c.name as class_name, c.base_pv as max_pv, c.base_mana as max_mana
            FROM hero h
            JOIN appartenir a ON h.id = a.id_hero
            JOIN class c ON h.class_id = c.id
            WHERE a.id_user = ?
            ORDER BY a.derniere_utilisation DESC
            LIMIT 1
        ');
        $stmt->execute([$userId]);
        $hero = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $hero ?: null;
    }


    public function getAllHeroesByUserId(int $userId): array
    {
        $stmt = $this->db->prepare('
            SELECT h.*, c.name as class_name, a.derniere_utilisation
            FROM hero h
            JOIN appartenir a ON h.id = a.id_hero
            JOIN class c ON h.class_id = c.id
            WHERE a.id_user = ?
            ORDER BY a.derniere_utilisation DESC
        ');
        $stmt->execute([$userId]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }


    public function createHero(array $data): int
    {
        $stmt = $this->db->prepare('
            INSERT INTO hero (name, class_id, biography, pv, mana, strength, initiative, xp, current_level)
            VALUES (:name, :class_id, :biography, :pv, :mana, :strength, :initiative, 0, 1)
        ');
        
        $stmt->execute([
            'name' => $data['name'],
            'class_id' => $data['class_id'],
            'biography' => $data['biography'] ?? '',
            'pv' => $data['pv'],
            'mana' => $data['mana'],
            'strength' => $data['strength'],
            'initiative' => $data['initiative']
        ]);
        
        return (int)$this->db->lastInsertId();
    }

    public function linkHeroToUser(int $userId, int $heroId): void
    {
        $stmt = $this->db->prepare('
            INSERT INTO appartenir (id_user, id_hero, derniere_utilisation)
            VALUES (?, ?, NOW())
        ');
        $stmt->execute([$userId, $heroId]);
    }


    public function updateHeroStats(int $heroId, array $stats): bool
    {
        $fields = [];
        $values = [];
        
        foreach ($stats as $field => $value) {
            $fields[] = "$field = ?";
            $values[] = $value;
        }
        
        $values[] = $heroId;
        
        $sql = 'UPDATE hero SET ' . implode(', ', $fields) . ' WHERE id = ?';
        $stmt = $this->db->prepare($sql);
        
        return $stmt->execute($values);
    }


    public function updateHeroPv(int $heroId, int $pv): bool
    {
        $stmt = $this->db->prepare('UPDATE hero SET pv = ? WHERE id = ?');
        return $stmt->execute([$pv, $heroId]);
    }

    public function updateHeroMana(int $heroId, int $mana): bool
    {
        $stmt = $this->db->prepare('UPDATE hero SET mana = ? WHERE id = ?');
        return $stmt->execute([$mana, $heroId]);
    }

    public function addXp(int $heroId, int $xp): bool
    {
        $stmt = $this->db->prepare('UPDATE hero SET xp = xp + ? WHERE id = ?');
        return $stmt->execute([$xp, $heroId]);
    }

    public function levelUp(int $heroId): bool
    {
        $stmt = $this->db->prepare('UPDATE hero SET current_level = current_level + 1 WHERE id = ?');
        return $stmt->execute([$heroId]);
    }

    public function deleteHero(int $heroId): bool
    {
        $stmt = $this->db->prepare('DELETE FROM appartenir WHERE id_hero = ?');
        $stmt->execute([$heroId]);
        
        $stmt = $this->db->prepare('DELETE FROM inventory WHERE hero_id = ?');
        $stmt->execute([$heroId]);
        
        $stmt = $this->db->prepare('DELETE FROM hero_progress WHERE hero_id = ?');
        $stmt->execute([$heroId]);
        
        $stmt = $this->db->prepare('DELETE FROM hero WHERE id = ?');
        return $stmt->execute([$heroId]);
    }

    public function updateLastUsed(int $userId, int $heroId): bool
    {
        $stmt = $this->db->prepare('
            UPDATE appartenir 
            SET derniere_utilisation = NOW() 
            WHERE id_user = ? AND id_hero = ?
        ');
        return $stmt->execute([$userId, $heroId]);
    }
}