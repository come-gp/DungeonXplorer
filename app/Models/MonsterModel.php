<?php

namespace App\Models;

class MonsterModel {
    
    private \PDO $db;
    
    public function __construct()
    {
        $config = require __DIR__ . '/../../config/database.php';
        $this->db = $config['pdo'];
    }
    
    /**
     * Crée un monstre
     * Retourne l'id du monstre créé
     */
    public function create(
        string $name,
        int $pv,
        int $mana,
        int $initiative,
        int $strength,
        string $attack,
        int $xp
    ): int {

        $stmt = $this->db->prepare(
            'INSERT INTO monster 
            (name, pv, mana, initiative, strength, attack, xp)
            VALUES 
            (:name, :pv, :mana, :initiative, :strength, :attack, :xp)'
        );

        $stmt->execute([
            'name' => $name,
            'pv' => $pv,
            'mana' => $mana,
            'initiative' => $initiative,
            'strength' => $strength,
            'attack' => $attack,
            'xp' => $xp
        ]);

        return (int)$this->db->lastInsertId();
    }

    /**
     * Récupère tous les monstres (admin panel)
     */
    public function getAllMonsters(): array {
         $stmt = $this->db->query(
                'SELECT id, name, pv, mana, initiative, strength, attack, xp
                 FROM monster'
            );
        $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        return is_array($result) ? $result : [];
    }

    /**
     * Récupère un monstre par son id
     */
    public function find(int $id): ?array {
        $stmt = $this->db->prepare(
            'SELECT * FROM monster WHERE id = :id'
        );
        $stmt->execute(['id' => $id]);

        $monster = $stmt->fetch(PDO::FETCH_ASSOC);
        return $monster ?: null;
    }

    /**
     * Met à jour un monstre
     */
    public function update(
        int $id,
        string $name,
        int $pv,
        int $mana,
        int $initiative,
        int $strength,
        string $attack,
        int $xp
    ): void {
        $stmt = $this->db->prepare(
            'UPDATE monster SET
                name = :name,
                pv = :pv,
                mana = :mana,
                initiative = :initiative,
                strength = :strength,
                attack = :attack,
                xp = :xp
             WHERE id = :id'
        );
        $stmt->execute([
            'id' => $id,
            'name' => $name,
            'pv' => $pv,
            'mana' => $mana,
            'initiative' => $initiative,
            'strength' => $strength,
            'attack' => $attack,
            'xp' => $xp
        ]);
    }

    /**
     * Supprime un monstre
     */
    public function delete($id) {
        // Supprimer les loots associés
        $stmt = $this->db->prepare("DELETE FROM monster_loot WHERE monster_id = :id");
        $stmt->execute(['id' => $id]);
        
        // Supprimer les encounters associées
        $stmt = $this->db->prepare("DELETE FROM encounter WHERE monster_id = :id");
        $stmt->execute(['id' => $id]);
        
        // Supprimer le monstre
        $stmt = $this->db->prepare("DELETE FROM monster WHERE id = :id");
        $stmt->execute(['id' => $id]);
    }
}
?>