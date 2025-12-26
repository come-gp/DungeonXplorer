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
            SELECT * FROM appartenir 
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

    public function getProgressByHeroId(int $heroId): ?array
    {
        $stmt = $this->db->prepare('
            SELECT * FROM hero_progress 
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

    public function getClassByHeroId(int $heroId): ?array
    {
        $stmt = $this->db->prepare('
        SELECT c.* FROM class c
        JOIN hero h ON h.class_id = c.id
        WHERE h.id = ?
        ');
        $stmt->execute([$heroId]);
        $class = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $class ?: null;
    }
}