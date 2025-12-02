<?php
require '../php/imports.php';


if (!isset($_SESSION['user_id'])) {
    
    header('Location: ../login/');
    exit();
}



// recup le hero du joureur

$stmt = $db->prepare('
    SELECT h.*, c.name as class_name, c.base_pv as max_pv, c.base_mana as max_mana
    FROM hero h
    JOIN appartenir a ON h.id = a.id_hero
    JOIN class c ON h.class_id = c.id
    WHERE a.id_user = ?
    ORDER BY a.derniere_utilisation DESC
    LIMIT 1
');
$stmt->execute([$_SESSION['user_id']]);
$hero = $stmt->fetch();

if (!$hero) {
    echo"<script language=\"javascript\">";
    echo"alert('pas de hero , creer une partie redirection');";
    echo"</script>";
    header('Location: ../new-game/index.php');
    exit();
}

// recup progression

$stmt = $db->prepare('
    SELECT chapter_id 
    FROM hero_progress 
    WHERE hero_id = ? 
    ORDER BY completion_date DESC 
    LIMIT 1
');
$stmt->execute([$hero['id']]);
$progress = $stmt->fetch();

// coommencer au chap 1 si ya  r
$currentChapterId = $progress ? $progress['chapter_id'] : 1;


// recup chap actu
$stmt = $db->prepare('SELECT * FROM chapter WHERE id = ?');
$stmt->execute([$currentChapterId]);
$chapter = $stmt->fetch();

// recup combat
$stmt = $db->prepare('
    SELECT *
    FROM encounter e
    JOIN monster m ON e.monster_id = m.id
    WHERE e.chapter_id = ?
');
$stmt->execute([$currentChapterId]);
$encounter = $stmt->fetch();

// recup choix
$stmt = $db->prepare('
    SELECT * FROM links 
    WHERE chapter_id = ?
');
$stmt->execute([$currentChapterId]);
$choices = $stmt->fetchAll();

// foreach($choices as $result) {
//     echo $result['type'], '<br>';
// }
// echo $currentChapterId;

// recup loot
$stmt = $db->prepare('
    SELECT *
    FROM chapter_treasure ct
    JOIN items i ON ct.item_id = i.id
    WHERE ct.chapter_id = ?
');
$stmt->execute([$currentChapterId]);
$treasures = $stmt->fetchAll();

// traitement des action
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['next_chapter'])) {
    $nextChapterId = (int)$_POST['next_chapter'];
    
    // save progression
    $stmt = $db->prepare('
        INSERT INTO hero_progress (hero_id, chapter_id, status, completion_date)
        VALUES (?, ?, "Completed", NOW())
    ');
    $stmt->execute([$hero['id'], $nextChapterId]);
    
    // tresors (marche surement pas)
    if (!empty($treasures)) {
        foreach ($treasures as $treasure) {
            $stmt = $db->prepare('SELECT * FROM inventory WHERE hero_id = ? AND item_id = ?');
            $stmt->execute([$hero['id'], $treasure['item_id']]);
            $existing = $stmt->fetch();
            
            if ($existing) {
                $stmt = $db->prepare('UPDATE inventory SET quantity = quantity + ? WHERE hero_id = ? AND item_id = ?');
                $stmt->execute([$treasure['quantity'], $hero['id'], $treasure['item_id']]);
            } else {
                $stmt = $db->prepare('INSERT INTO inventory (hero_id, item_id, quantity) VALUES (?, ?, ?)');
                $stmt->execute([$hero['id'], $treasure['item_id'], $treasure['quantity']]);
            }
        }
    }
    
    header('Location: index.php');
    exit();
}

// savoir si il y a un combat
$inCombat = $encounter ? true : false;

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DungeonXplorer - Aventure</title>
    <!-- <link rel="stylesheet" href="style.css"> -->
    
</head>
<body>
    <!-- <header>
        <h1>DungeonXplorer</h1>
        <nav>
            <a href="../index.php">Accueil</a>
            <a href="../profil.php">Profil</a>
            <a href="../php/logout.php">Déconnexion</a>
        </nav>
    </header> -->
    
    <main>
        <p>stat hero </p>
        <aside class="hero-stats" id="heroStats">
            <h2 id="heroName"><?= htmlspecialchars($hero['name']) ?></h2>
            <p>Classe: <span id="heroClass"><?= htmlspecialchars($hero['class_name']) ?></span></p>
            <p>Niveau: <span id="heroLevel"><?= $hero['current_level'] ?></span></p>
            <div class="stat-bar">
                <strong>PV:</strong> <span id="heroPV"><?= $hero['pv'] ?></span> / <span id="heroMaxPV"><?= $hero['max_pv'] ?></span>
            </div>
            <div class="stat-bar">
                <strong>Mana:</strong> <span id="heroMana"><?= $hero['mana'] ?></span> / <span id="heroMaxMana"><?= $hero['max_mana'] ?></span>
            </div>
            <div class="stat-bar">
                <strong>XP:</strong> <span id="heroXP"><?= $hero['xp'] ?></span>
            </div>
            <hr>
            <p><strong>Force:</strong> <span id="heroStrength"><?= $hero['strength'] ?></span></p>
            <p><strong>Initiative:</strong> <span id="heroInitiative"><?= $hero['initiative'] ?></span></p>
        </aside>
        
        <section class="game-area">
            
            <?php if ($inCombat): ?>
                <p>==================== combat ====================</p>
                <div class="combat-zone" id="combatZone">
                    <h2>⚔️ Combat contre <span id="monsterName"><?= htmlspecialchars($encounter['name']) ?></span></h2>
                    
                    <div class="monster-info">
                        <h3><?= htmlspecialchars($encounter['name']) ?></h3>
                        <p>PV: <span id="monsterPV"><?= $encounter['pv'] ?></span> / <span id="monsterMaxPV"><?= $encounter['pv'] ?></span></p>
                        <p>Force: <span id="monsterStrength"><?= $encounter['strength'] ?></span></p>
                        <p>Initiative: <span id="monsterInitiative"><?= $encounter['initiative'] ?></span></p>
                    </div>
                    
                    <!-- logs -->
                    <div class="combat-log">
                        <h3>journal de combat</h3>
                        <div class="log-entries" id="combatLog">
                            <p>Le combat commence...</p>
                        </div>
                    </div>
                    
                    <!-- actions combat -->
                    <div class="combat-actions" id="combatActions">
                        <h3>Vos actions</h3>
                        <button onclick="executeTurn('physical_attack')" id="btnPhysical">
                            attaque Physique
                        </button>
                        
                        <?php if ($hero['class_name'] == 'Magicien'): ?>
                            <button onclick="executeTurn('magic_attack')" id="btnMagic">
                                Attaque Magique (Coût: 3 mana)
                            </button>
                        <?php endif; ?>
                        
                        <button onclick="executeTurn('use_potion')" id="btnPotion">
                            Utiliser une Potion
                        </button>
                    </div>
                    
                    <!-- message de fin -->
                    <div id="combatResult" style="display: none;">
                        <h3 id="resultMessage"></h3>
                        <p id="resultDetails"></p>
                        <p>Redirection en cours...</p>
                    </div>
                </div>
                
                <script>
                // variables de combat ( pour le code js)
                let combat = {
                    hero: {
                        id: <?= $hero['id'] ?>,
                        name: "<?= htmlspecialchars($hero['name']) ?>",
                        pv: <?= $hero['pv'] ?>,
                        maxPv: <?= $hero['max_pv'] ?>,
                        mana: <?= $hero['mana'] ?>,
                        maxMana: <?= $hero['max_mana'] ?>,
                        strength: <?= $hero['strength'] ?>,
                        initiative: <?= $hero['initiative'] ?>,
                        class: "<?= htmlspecialchars($hero['class_name']) ?>"
                    },
                    monster: {
                        name: "<?= htmlspecialchars($encounter['name']) ?>",
                        pv: <?= $encounter['pv'] ?>,
                        maxPv: <?= $encounter['pv'] ?>,
                        strength: <?= $encounter['strength'] ?>,
                        initiative: <?= $encounter['initiative'] ?>,
                        xp: <?= $encounter['xp'] ?>,
                        attack: "<?= htmlspecialchars($encounter['attack']) ?>"
                    },
                    log: [],
                    turn: 0,
                    chapterId: <?= $currentChapterId ?>
                };
                </script>
                
                
                
            <?php else: ?>
                <p>==================== mode exploration ====================</p>
                <div class="chapter-zone">
                    <h2>Chapitre <?= $chapter['id'] ?></h2>
                    
                    <?php if ($chapter['image']): ?>
                        <img src="../images/<?= htmlspecialchars($chapter['image']) ?>" style="max-width: 100%; height: auto;">
                    <?php endif; ?>
                    
                    <div class="chapter-content"> bla
                        <?=  nl2br(($chapter['content'])) ?>
                    </div>

                
                    
                    <?php if (!empty($treasures)): ?>
                        <div class="treasures">
                            <h3>Vous avez trouvé des trésors !</h3>
                            <ul>
                                <?php foreach ($treasures as $treasure): ?>
                                    <li>
                                        <?= htmlspecialchars($treasure['item_name']) ?> x<?= $treasure['quantity'] ?>
                                        <small>(<?= htmlspecialchars($treasure['description']) ?>)</small>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>
                    
                    <?php if (!empty($choices)): ?>
                        <div class="choices">
                            <h3>Que faites-vous ?</h3>
                            <?php foreach ($choices as $choice): ?>
                                <form method="POST" style="display: inline-block; margin: 10px;">
                                    <input type="hidden" name="next_chapter" value="<?= $choice['next_chapter_id'] ?>">
                                    <button type="submit">
                                        <?= htmlspecialchars($choice['description']) ?>
                                    </button>
                                </form>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <p><strong>pas de suite pour le moment...</strong></p>
                        <a href="../index.php">Retour à l'accueil</a>
                    <?php endif; ?>
                </div>
                
            <?php endif; ?>
            
        </section>
    </main>
    
    <footer>
        <p>&copy; 2024 DungeonXplorer - Les Aventuriers du Val Perdu</p>
    </footer>

    <!-- <script type="module" src="main.js"></script> -->
     <script src="elemsHtml.js"></script>
    <script src="main.js"></script>

</body>
</html>