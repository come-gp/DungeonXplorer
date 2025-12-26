<?php
namespace App\Models;

use PDO;

class ItemModel {
    private PDO $db;
    public function __construct() {
        $config = require __DIR__ . '/../../config/database.php';
        $this->db = $config['pdo'];
    }
    /**
     * Crée un nouvel item
     * Retourne l'id de l'item créé
     */
    public function create(
        string $name,
        string $description,
        string $item_type
    ): int {

        $stmt = $this->db->prepare(
            'INSERT INTO items (name, description, item_type)
             VALUES (:name, :description, :item_type)'
        );

        $stmt->execute([
            'name' => $name,
            'description' => $description,
            'item_type' => $item_type
        ]);

        return (int)$this->db->lastInsertId();
    }

    /**
     * Récupère tous les items (admin panel)
     */
    public function getAll(): array {
        $stmt = $this->db->query(
                'SELECT id, name, description, item_type
                 FROM items'
            );
            
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Récupère un item par son id (modifier)
     */
    public function find(int $id): ?array {
        $stmt = $this->db->prepare(
            'SELECT * FROM items WHERE id = :id'
        );
        $stmt->execute(['id' => $id]);

        $item = $stmt->fetch(PDO::FETCH_ASSOC);
        return $item ?: null;
    }

    /**
     * Met à jour un item
     */
    public function update(
        int $id,
        string $name,
        string $description,
        string $item_type
    ): void {

        $stmt = $this->db->prepare(
            'UPDATE items SET
                name = :name,
                description = :description,
                item_type = :item_type
             WHERE id = :id'
        );

        $stmt->execute([
            'id' => $id,
            'name' => $name,
            'description' => $description,
            'item_type' => $item_type
        ]);
    }
    
    /**
     * Supprime un item
     */
    public function delete($id) {
        //mets à null les références aux items dans la table hero
        $stmt = $this->db->prepare('UPDATE hero SET 
        armor_item_id = CASE WHEN armor_item_id = :id THEN NULL ELSE armor_item_id END,
        primary_weapon_item_id = CASE WHEN primary_weapon_item_id = :id THEN NULL ELSE primary_weapon_item_id END,
        secondary_weapon_item_id = CASE WHEN secondary_weapon_item_id = :id THEN NULL ELSE secondary_weapon_item_id END,
        shield_item_id = CASE WHEN shield_item_id = :id THEN NULL ELSE shield_item_id END');
        $stmt->execute(['id' => $id]);

        // Delete from related tables
        $stmt = $this->db->prepare('DELETE FROM monster_loot WHERE item_id = :id');
        $stmt->execute(['id' => $id]);
        
        $stmt = $this->db->prepare('DELETE FROM chapter_treasure WHERE item_id = :id');
        $stmt->execute(['id' => $id]);
        
        $stmt = $this->db->prepare('DELETE FROM inventory WHERE item_id = :id');
        $stmt->execute(['id' => $id]);
        
        $stmt = $this->db->prepare('DELETE FROM items WHERE id = :id');
        $stmt->execute(['id' => $id]);
    }
    
}
?>

