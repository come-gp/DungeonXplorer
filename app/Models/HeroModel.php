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


    public function getProgress(int $heroId): ?array
    {
        $stmt = $this->db->prepare('
            SELECT chapter_id 
            FROM hero_progress 
            WHERE hero_id = ? 
            ORDER BY completion_date DESC 
            LIMIT 1
        ');
        $stmt->execute([$heroId]);
        $progres = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $progres ?: null;
    }

    public function saveProgress(int $heroId, int $chapterId): bool
    {
        $stmt = $this->db->prepare('
            INSERT INTO hero_progress (hero_id, chapter_id, completion_date)
            VALUES (?, ?, NOW())
        ');
        return $stmt->execute([$heroId, $chapterId]);
    }

    public function getInventory(int $heroId): array
    {
        $stmt = $this->db->prepare('
            SELECT i.id, i.name, i.description, i.item_type, inv.quantity
            FROM inventory inv
            JOIN items i ON inv.item_id = i.id
            WHERE inv.hero_id = ? AND inv.quantity > 0
            ORDER BY i.name
        ');
        $stmt->execute([$heroId]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getPotion(int $heroId, int $itemId): ?array
    {
        $stmt = $this->db->prepare('
            SELECT i.id, i.name, i.description, i.item_type, inv.quantity
            FROM inventory inv
            JOIN items i ON inv.item_id = i.id
            WHERE inv.hero_id = ? AND inv.item_id = ? AND inv.quantity > 0
        ');
        $stmt->execute([$heroId, $itemId]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function usePotion(int $heroId, int $itemId): bool
    {
        $stmt = $this->db->prepare('
            UPDATE inventory 
            SET quantity = quantity - 1 
            WHERE hero_id = ? AND item_id = ? AND quantity > 0
        ');
        return $stmt->execute([$heroId, $itemId]);
    }

    public function addToInventory(int $heroId, int $itemId, int $quantity = 1): bool
    {
        // si l'item est deja dans l'inventaure
        $stmt = $this->db->prepare('
            SELECT id FROM inventory 
            WHERE hero_id = ? AND item_id = ?
        ');
        $stmt->execute([$heroId, $itemId]);
        $exists = $stmt->fetch();

        if ($exists) {
            //maj quantity
            $stmt = $this->db->prepare('
                UPDATE inventory 
                SET quantity = quantity + ? 
                WHERE hero_id = ? AND item_id = ?
            ');
            return $stmt->execute([$quantity, $heroId, $itemId]);
        } else {
            // insert
            $stmt = $this->db->prepare('
                INSERT INTO inventory (hero_id, item_id, quantity)
                VALUES (?, ?, ?)
            ');
            return $stmt->execute([$heroId, $itemId, $quantity]);
        }
    }


    public function setItemInventory(int $heroId, int $itemId, int $quantity = 1): bool
    {
        // si l'item est deja dans l'inventaure
        $stmt = $this->db->prepare('
            SELECT id FROM inventory 
            WHERE hero_id = ? AND item_id = ?
        ');
        $stmt->execute([$heroId, $itemId]);
        $exists = $stmt->fetch();

        if ($exists) {
            //maj quantity
            $stmt = $this->db->prepare('
                UPDATE inventory 
                SET quantity =  ? 
                WHERE hero_id = ? AND item_id = ?
            ');
            return $stmt->execute([$quantity, $heroId, $itemId]);
        } else {
            // insert
            $stmt = $this->db->prepare('
                INSERT INTO inventory (hero_id, item_id, quantity)
                VALUES (?, ?, ?)
            ');
            return $stmt->execute([$heroId, $itemId, $quantity]);
        }
    }
}