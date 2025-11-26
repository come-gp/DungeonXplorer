<?php
session_start();
require 'imports.php';

$data = json_decode(file_get_contents('php://input'), true);

try {
    // maj hero
    $stmt = $db->prepare('UPDATE hero SET pv = ?, mana = ?, xp = xp + ? WHERE id = ?');
    $stmt->execute([
        $data['hero_pv'],
        $data['hero_mana'],
        $data['xp_gained'],
        $data['hero_id']
    ]);
    
    // save progression
    if ($data['result'] === 'victory') {
        // prochain chapitre
        $stmt = $db->prepare("SELECT next_chapter_id FROM links WHERE chapter_id = ? AND description LIKE '%Vaincre%' LIMIT 1");
        $stmt->execute([$data['chapter_id']]);
        $next = $stmt->fetch();
        
        if ($next) {
            $stmt = $db->prepare('INSERT INTO hero_progress (hero_id, chapter_id, completion_date) VALUES (?, ?, NOW())');
            $stmt->execute([$data['hero_id'], $next['next_chapter_id']]);
        }
    } else {
        // defaite -> chapitre end
        $stmt = $db->prepare('INSERT INTO hero_progress (hero_id, chapter_id, completion_date) VALUES (?, 10, NOW())');
        $stmt->execute([$data['hero_id']]);
    }
    
    echo json_encode(['success' => true]);
    
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}