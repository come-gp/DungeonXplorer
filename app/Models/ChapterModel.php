<?php
// app/Models/HeroModel.php
namespace App\Models;

class ChapterModel
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


    public function getChapContent(int $chapterId): ?array
    {
        $stmt = $this->db->prepare('SELECT * FROM chapter WHERE id = ?');

        
        $stmt->execute([$chapterId]);
        $chapter = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $chapter ?: null;
    }

    public function getCombatByChapterId(int $chapterId): ?array
    {
        $stmt = $this->db->prepare('
            SELECT *
            FROM encounter e
            JOIN monster m ON e.monster_id = m.id
            WHERE e.chapter_id = ?
        ');

        $stmt->execute([$chapterId]);
        $encounter = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $encounter ?: null;
    }

    public function getChoicesByChapterId(int $chapterId): array
    {
        $stmt = $this->db->prepare('
            SELECT * FROM links 
            WHERE chapter_id = ?
        ');
        $stmt->execute([$chapterId]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getLootByChapterId(int $chapterId): array
    {
        $stmt = $this->db->prepare('
            SELECT *
            FROM chapter_treasure ct
            JOIN items i ON ct.item_id = i.id
            WHERE ct.chapter_id = ?
        ');
        $stmt->execute([$chapterId]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getAllChapters(): array
    {
        $stmt = $this->db->query(
                'SELECT id, title, content
                 FROM chapter'
            );
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function delete(int $id): void
    {
        $stmt = $this->db->prepare('DELETE FROM chapter WHERE id = :id');
        $stmt->execute(['id' => $id]);
    }
}