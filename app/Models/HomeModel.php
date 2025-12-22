<?php
// app/Models/HomeModel.php
namespace App\Models;

class HomeModel
{
    private \PDO $db;

    public function __construct()
    {
        $config = require __DIR__ . '/../../config/database.php';
        $this->db = $config['pdo'];
    }

    public function getLastHeroByUserId(int $userId): ?array
    {
        $stmt = $this->db->prepare('
            SELECT id_hero FROM appartenir 
            WHERE id_user = ? 
            ORDER BY derniere_utilisation DESC 
            LIMIT 1
        ');
        $stmt->execute([$userId]);
        $idHero = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $idHero ?: null;
    }

    public function getHeroById(int $heroId): ?array
    {
        $stmt = $this->db->prepare('
        SELECT * FROM hero WHERE id = ?
        ');
        $stmt->execute([$heroId]);
        $hero = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $hero ?: null;
    }

    public function getChapterIdByHeroId(int $heroId): ?array
    {
        $stmt = $this->db->prepare('
            SELECT chapter_id FROM hero_progress 
            WHERE hero_id = ?
            order by completion_date DESC 
            LIMIT 1
        ');
        $stmt->execute([$heroId]);
        $idChapter = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $idChapter ?: null;
    }

    public function getChapterById(int $chapterId): ?array
    {
        $stmt = $this->db->prepare('
        SELECT * FROM chapter WHERE id = ?
        ');
        $stmt->execute([$chapterId]);
        $chapter = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $chapter ?: null;
    }
}