<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DungeonXplorer - Aventure</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="<?= base_url('/css/navbar.css') ?>">
    <link rel="stylesheet" href="<?= base_url('/css/style.css') ?>">
    
</head>
<body>
    <?php require __DIR__ . '/components/navbar.php'; ?>
    
    <main>

        <?php if ($error): ?>
            <div class="alert alert-danger" role="alert">
                <i class="fas fa-exclamation-triangle"></i> <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>

        <?php if ($success): ?>
            <div class="alert alert-success" role="alert">
                <i class="fas fa-check-circle"></i> <?= htmlspecialchars($success) ?>
            </div>
        <?php endif; ?>

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
            
            <?php if (!empty($encounter)): ?>
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
                    <h2>Chapitre <?= $chapterContent['id'] ?></h2>
                    
                    <?php if ($chapterContent['image']): ?>
                        <img src="../images/<?= htmlspecialchars($chapterContent['image']) ?>" style="max-width: 100%; height: auto;">
                    <?php endif; ?>
                    
                    <div class="chapter-content"> bla
                        <?=  nl2br(($chapterContent['content'])) ?>
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
    <script src="<?= base_url('/js/elemsHtml.js') ?>"></script>
    <script src="<?= base_url('/js/combat.js') ?>"></script>
    
    <!-- vbootstrap  -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOYfy6S4+gkCQ/lqojAsuBjKSo" crossorigin="anonymous"></script>

</body>
</html>