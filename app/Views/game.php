<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DungeonXplorer - Aventure</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="<?= base_url('/css/navbar.css') ?>">
    <link rel="stylesheet" href="<?= base_url('/css/home.css') ?>">
</head>
<body style="overflow: hidden; height: 100vh;">
    <?php require __DIR__ . '/components/navbar.php'; ?>
    
    <main style="background-color: #1A1A1A; height: calc(100vh - 60px); overflow: hidden;">
        <div class="container-fluid p-0" style="display: flex; height: 100%;">
            <!--pannel profile joueur -->
            <div style="width: 300px; background-color: #2E2E2E; padding: 1.5rem; border-right: 1px solid #C4975E; overflow-y: auto; height: 100%; box-sizing: border-box;">
                <div class="text-center">
                    <!-- img-->
                    <div class="mb-4">
                        <div style="overflow: hidden; width: 120px; height: 120px; margin: 0 auto 1rem; background: linear-gradient(135deg, #C4975E, #8B6914); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 3rem;">
                            <img class="img-rounded img-fluid" src="<?= base_url('/imgs/illuClasses/' . htmlspecialchars($hero['class_name']) .'.png') ?>" alt="">

                        </div>
                        <h3 style="color: #C4975E; margin-bottom: 0.5rem; font-size: 1.2rem;"><?= htmlspecialchars($hero['name']) ?></h3>
                        <p style="color: #E5E5E5; font-size: 0.9rem; margin: 0;"><strong><?= htmlspecialchars($hero['class_name']) ?></strong></p>
                    </div>

                    <!-- lvl -->
                    <div style="background-color: #1A1A1A; padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem;">
                        <p style="color: #C4975E; margin: 0; font-size: 0.85rem;">NIVEAU</p>
                        <h2 style="color: #E5E5E5; margin: 0.5rem 0; font-size: 2rem;" id="heroLevelBig"><?= $hero['current_level'] ?></h2>
                        
                        <!-- bare de exp -->
                        <div style="margin-top: 0.75rem;">
                            <p style="color: #C4975E; margin: 0 0 0.3rem; font-size: 0.75rem;">EXP</p>
                            <div class="progress" style="height: 8px; background-color: #0A0A0A; border: 1px solid #444;">
                                <?php
                                    $xpInCurrentLevel = getXpInCurrentLevel($hero['xp'], $hero['current_level']);
                                    $xpNeededForNextLevel = getXpNeededForNextLevel($hero['xp'], $hero['current_level']);
                                    $xpPercentage = ($xpInCurrentLevel / $xpNeededForNextLevel) * 100;
                                ?>
                                <div class="progress-bar" id="heroXpBar" style="width: <?= $xpPercentage ?>%; background-color: #C4975E;"></div>
                            </div>
                            <p style="color: #999; margin: 0.3rem 0 0; font-size: 0.7rem;" id="heroXpText"><?= $xpInCurrentLevel ?>/<?= $xpNeededForNextLevel ?></p>
                        </div>
                    </div>

                    <!-- PV -->
                    <div style="margin-bottom: 1.5rem;">
                        <p style="color: #C4975E; margin: 0 0 0.5rem; font-size: 0.85rem;"><i class="fas fa-heart me-1"></i>SANTÉ</p>
                        <div style="background-color: #1A1A1A; padding: 0.5rem; border-radius: 5px;">
                            <p style="color: #E5E5E5; margin: 0 0 0.5rem; font-size: 0.85rem;"><span id="heroPVSidebar"><?= $hero['pv'] ?></span> / <?= $hero['max_pv'] ?></p>
                            <div class="progress" style="height: 12px;">
                                <div class="progress-bar bg-danger" id="heroHpBarSidebar" style="width: 100%"></div>
                            </div>
                        </div>
                    </div>

                    <!-- mana (si magicien) -->
                    <?php if ($hero['class_name'] == 'Magicien'): ?>
                        <div style="margin-bottom: 1.5rem;">
                            <p style="color: #C4975E; margin: 0 0 0.5rem; font-size: 0.85rem;"><i class="fas fa-wand-magic-sparkles me-1"></i>MANA</p>
                            <div style="background-color: #1A1A1A; padding: 0.5rem; border-radius: 5px;">
                                <p style="color: #E5E5E5; margin: 0 0 0.5rem; font-size: 0.85rem;"><span id="heroManaSidebar"><?= $hero['mana'] ?></span> / <?= $hero['max_mana'] ?></p>
                                <div class="progress" style="height: 12px;">
                                    <div class="progress-bar bg-info" id="heroManaBarSidebar" style="width: 100%"></div>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- forece -->
                    <div style="background-color: #1A1A1A; padding: 0.8rem; border-radius: 5px; text-align: left;">
                        <p style="color: #C4975E; margin: 0 0 0.5rem; font-size: 0.85rem;"><i class="fas fa-fist-raised me-1"></i>FORCE</p>
                        <p style="color: #E5E5E5; margin: 0; font-size: 1.2rem; font-weight: bold;" id="heroStrengthSidebar"><?= $hero['strength'] ?></p>
                    </div>

                    <!-- inventaure -->
                    <div style="margin-top: 2rem; padding-top: 1.5rem; border-top: 1px solid #C4975E;">
                        <p style="color: #C4975E; margin: 0 0 1rem; font-size: 0.9rem; font-weight: bold;"><i class="fas fa-backpack me-2"></i>INVENTAIRE</p>
                        
                        <?php 
                        $potionCount = 0;
                        foreach ($inventory as $item): 

                            if (strpos($item['item_type'], 'potion') !== false):
                                $potionCount += $item['quantity'];
                            endif;
                        endforeach;
                        ?>
                        
                        <div style="background-color: #1A1A1A; padding: 0.8rem; border-radius: 5px; text-align: center;">
                            <p style="color: #C4975E; margin: 0 0 0.5rem; font-size: 0.85rem;"><i class="fas fa-flask me-1"></i>POTIONS</p>
                            <p style="color: #E5E5E5; margin: 0; font-size: 1.5rem; font-weight: bold;"><?= $potionCount ?></p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- MAIN -->
            <div style="flex: 1; padding: 1rem; overflow-y: auto; height: 100%; box-sizing: border-box;">
                <!-- si le hero eset mort-->
                <div id="deathAlert" style="display: <?= ($hero['pv'] <= 0) ? 'block' : 'none' ?>; background-color: #8B1E1E; border-left: 4px solid #FF0000; color: #FFFFFF; padding: 1.5rem; border-radius: 5px; margin-bottom: 1.5rem; box-shadow: 0 4px 6px rgba(0,0,0,0.3);">
                    <div style="display: flex; align-items: center; gap: 1rem;">
                        <i class="fas fa-skull" style="font-size: 2.5rem; color: #FF0000;"></i>
                        <div style="flex: 1;">
                            <h4 style="margin: 0 0 0.5rem; color: #FFFFFF; font-weight: bold;">
                                <i class="fas fa-exclamation-triangle me-2"></i>VOTRE HÉROS EST MORT
                            </h4>
                            <p style="margin: 0; font-size: 0.95rem;">
                                Votre héros n'a plus de points de vie. Vous ne pouvez plus continuer l'aventure. 
                                Créez un nouveau héros ou choisissez un autre héros existant pour recommencer.
                            </p>
                        </div>
                    </div>
                    <div style="margin-top: 1rem; display: flex; gap: 0.5rem;">
                        <a href="<?= base_url('/heroes') ?>" class="btn" style="background-color: #C4975E; color: #1A1A1A; font-weight: 600;">
                            <i class="fas fa-users me-2"></i>Mes Héros
                        </a>
                        <a href="<?= base_url('/hero/create') ?>" class="btn btn-outline-light">
                            <i class="fas fa-plus me-2"></i>Créer un Nouveau Héros
                        </a>
                    </div>
                </div>

                <!-- alertes -->
                <?php if ($error): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-triangle me-2"></i> <?= htmlspecialchars($error) ?>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <?php if ($success): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i> <?= htmlspecialchars($success) ?>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <?php if (!empty($encounter)): ?>
                    <!-- mode comabt-->
                    <div class="row">
                        <div class="col-lg-12">
                            <h2 style="color: #C4975E; margin-bottom: 2rem;"><i class="fas fa-dragon me-2"></i><?= htmlspecialchars($encounter['name']) ?></h2>
                            
                            <!-- resultat combat -->
                            <div id="combatResult" style="display: none; background-color: #2E2E2E; border-left: 4px solid #C4975E; color: #E5E5E5; padding: 1rem; border-radius: 5px; margin-bottom: 1.5rem;">
                                <h4 id="resultMessage" style="color: #C4975E; margin-bottom: 0.5rem;"></h4>
                                <p id="resultDetails" style="margin: 0;"></p>
                            </div>
                            
                            <div class="row">
                                <!-- Partie gauche : Stats, Actions et Log -->
                                <div class="col-lg-5 pe-lg-4">
                                    <!-- stats monstre -->
                                    <div class="mb-4">
                                        <div style="background-color: #2E2E2E; padding: 1.5rem; border-radius: 8px; border: 2px solid #8B1E1E;">
                                            <h4 style="color: #FF6B6B; margin-bottom: 1rem;"><i class="fas fa-dragon me-2"></i><?= htmlspecialchars($encounter['name']) ?></h4>
                                            <div class="mb-3">
                                                <p style="color: #C4975E; margin: 0 0 0.5rem; font-size: 0.85rem;">PV</p>
                                                <div style="background-color: #1A1A1A; padding: 0.5rem; border-radius: 5px;">
                                                    <p style="color: #E5E5E5; margin: 0 0 0.5rem;"><span id="monsterPV"><?= $encounter['pv'] ?></span> / <?= $encounter['pv'] ?></p>
                                                    <div class="progress" style="height: 12px;">
                                                        <div class="progress-bar bg-danger" id="monsterHpBar" style="width: 100%"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-6">
                                                    <p style="color: #C4975E; margin: 0; font-size: 0.85rem;">Force</p>
                                                    <p style="color: #E5E5E5; margin: 0; font-size: 1.2rem; font-weight: bold;"><?= $encounter['strength'] ?></p>
                                                </div>
                                                <div class="col-6">
                                                    <p style="color: #C4975E; margin: 0; font-size: 0.85rem;">Initiative</p>
                                                    <p style="color: #E5E5E5; margin: 0; font-size: 1.2rem; font-weight: bold;"><?= $encounter['initiative'] ?></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- actions -->
                                    <div id="combatActions" style="background-color: #2E2E2E; padding: 1.5rem; border-radius: 8px; margin-bottom: 2rem;">
                                        <h4 style="color: #C4975E; margin-bottom: 1rem;"><i class="fas fa-fist-raised me-2"></i>Actions</h4>
                                        <div class="d-grid gap-2">
                                            <button onclick="executeTurn('physical_attack')" class="btn btn-lg" style="background-color: #C4975E; color: #1A1A1A; font-weight: 600;">
                                                <i class="fas fa-sword me-2"></i>Attaque Physique
                                            </button>
                                            
                                            <?php if ($hero['class_name'] == 'Magicien'): ?>
                                                <button onclick="executeTurn('magic_attack')" id="btnMagic" class="btn btn-lg" style="background-color: #6B5B95; color: #E5E5E5; font-weight: 600;">
                                                    <i class="fas fa-wand-magic-sparkles me-2"></i>Attaque Magique (3 Mana)
                                                </button>
                                            <?php endif; ?>
                                            
                                            <button onclick="executeTurn('drink_potion')" id="btnPotion" class="btn btn-lg btn-success" <?= $potionCount <= 0 ? 'disabled' : '' ?>>
                                                <i class="fas fa-flask-potion me-2"></i>Boire une Potion (<span id="potionCountBattle"><?= $potionCount ?></span>)
                                            </button>
                                        </div>
                                    </div>

                                    <!-- logs -->
                                    <div style="background-color: #2E2E2E; padding: 1.5rem; border-radius: 8px; max-height: 250px; overflow-y: auto;" id="combatLog">
                                        <p style="color: #999; font-style: italic;">Le combat va commencer...</p>
                                    </div>
                                </div>

                                <!-- Partie droite : Image du monstre/chapitre -->
                                <div class="col-lg-7 d-flex align-items-center justify-content-center">
                                    <img src="<?= base_url('/imgs/illuChap/chap' . $chapterContent['id'] . '.png') ?>" alt="<?= htmlspecialchars($encounter['name']) ?>" class="img-fluid rounded" style="aspect-ratio: 1; width: 100%; max-width: 500px; object-fit: cover; border: 3px solid #C4975E;">
                                </div>
                            </div>
                    

                <?php else: ?>
                    <!-- exploration -->
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="row">
                                <!-- gauche -->
                                <div class="col-lg-5 pe-lg-4">
                                    <div style="background-color: #2E2E2E; padding: 2rem; border-radius: 8px; border-left: 4px solid #C4975E;">
                                        <h2 style="color: #C4975E; margin-bottom: 1rem;"><?= htmlspecialchars($chapterContent['title'] ?? 'Chapitre') ?></h2>
                                        
                                        <div style="color: #E5E5E5; line-height: 1.8; margin-bottom: 2rem;">
                                            <p><?= nl2br(htmlspecialchars($chapterContent['content'] ?? 'Contenu non disponible.')) ?></p>
                                        </div>

                                        <!-- tresors (que potion pour l'instant) -->
                                        <?php if (!empty($treasures)): ?>
                                            <div class="alert mb-4" style="background-color: #2E2E2E; border-left: 4px solid #C4975E; color: #E5E5E5;">
                                                <strong><i class="fas fa-coins me-2"></i>Trésors trouvés</strong>
                                                <ul class="mb-0 mt-2 small">
                                                    <?php foreach ($treasures as $treasure): ?>
                                                        <!-- <script>
                                                            
                                                        </script> -->
                                                         <?php $potionCount += $treasure['quantity'];
                                                         ?>;

                                                        <li><?= htmlspecialchars($treasure['name'])?> x<?= $treasure['quantity'] ?> - <em><?= htmlspecialchars($treasure['description']) ?></em></li>
                                                    <?php endforeach; ?>
                                                </ul>
                                            </div>
                                        <?php endif; ?>

                                        <!-- choicxes -->
                                        <?php if (!empty($choices)): ?>
                                            <div>
                                                <p style="color: #C4975E; margin-bottom: 1rem;"><strong><i class="fas fa-compass me-2"></i>Que faites-vous ?</strong></p>
                                                <div class="d-grid gap-2">
                                                    <?php foreach ($choices as $choice): ?>
                                                        <form method="POST">
                                                            <input type="hidden" name="next_chapter" value="<?= $choice['next_chapter_id'] ?>">
                                                            <button type="submit" class="btn w-100 choice-button" style="background-color: #C4975E; color: #1A1A1A; font-weight: 600;">
                                                                <i class="fas fa-arrow-right me-2"></i><?= htmlspecialchars($choice['description']) ?>
                                                            </button>
                                                        </form>
                                                    <?php endforeach; ?>
                                                </div>
                                            </div>
                                        <?php else: ?>
                                            <div class="alert mb-0" style="background-color: #8B1E1E; border-color: #8B1E1E; color: #E5E5E5;">
                                                <strong>Aucune suite disponible pour le moment...</strong>
                                                <div class="mt-2">
                                                    <a href="<?= base_url('/') ?>" class="btn btn-sm" style="background-color: #C4975E; color: #1A1A1A; font-weight: 600;">
                                                        <i class="fas fa-home me-2"></i>Retour
                                                    </a>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <!-- img monstre / chapitre -->
                                <div class="col-lg-7 d-flex align-items-center justify-content-center">
                                    <img src="<?= base_url('/imgs/illuChap/chap' . $chapterContent['id'] . '.png') ?>" alt="<?= htmlspecialchars($chapterContent['title'] ?? 'Chapitre') ?>" class="img-fluid rounded" style="aspect-ratio: 1; width: 100%; max-width: 500px; object-fit: cover; border: 3px solid #C4975E;">
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </main>

    <script src="<?= base_url('/js/elemsHtml.js') ?>"></script>
    <script src="<?= base_url('/js/combat.js') ?>"></script>
    <script src="<?= base_url('/js/potion.js') ?>"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // mettre les potions
        potions.count = <?= $potionCount ?? 0 ?>;
        
        // bares mana et pv
        window.addEventListener('load', () => {
            // hero pv
            if (document.getElementById('heroHpBarSidebar')) {
                const maxPV = <?= $hero['max_pv'] ?>;
                const currentPV = <?= $hero['pv'] ?>;
                const percentage = Math.max(0, (currentPV / maxPV) * 100);
                document.getElementById('heroHpBarSidebar').setAttribute('style', 'width: ' + percentage + '% !important');
            }
            
            // mana
            <?php if ($hero['class_name'] == 'Magicien'): ?>
            if (document.getElementById('heroManaBarSidebar')) {
                const maxMana = <?= $hero['max_mana'] ?>;
                const currentMana = <?= $hero['mana'] ?>;
                const percentage = (currentMana / maxMana) * 100;
                document.getElementById('heroManaBarSidebar').setAttribute('style', 'width: ' + percentage + '% !important');
            }
            <?php endif; ?>
            
            // pv monstre
            <?php if (!empty($encounter)): ?>
            if (document.getElementById('monsterHpBar') && combat && combat.monster) {
                const maxMonsterPV = combat.monster.maxPv;
                const currentMonsterPV = combat.monster.pv;
                const percentage = (currentMonsterPV / maxMonsterPV) * 100;
                document.getElementById('monsterHpBar').setAttribute('style', 'width: ' + percentage + '% !important');
            }
            <?php endif; ?>
        });

        // pour transmettre au js
        <?php if (!empty($encounter)): ?>
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
        <?php endif; ?>
        potions.count = <?= $potionCount ?>;
        console.log('combat:', combat);
    </script>
</body>
</html>