<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Création de personnage - DungeonXplorer</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('/css/navbar.css') ?>">
    <link  rel="stylesheet" href="<?= base_url('/css/new-game.css') ?>?v=<?= time() ?>">
    <script defer src="<?= base_url('/js/new-game.js') ?>?v=<?= time() ?>"></script>
    
    
</head>
<body>
    <header>
            <?php require __DIR__ . '/components/navbar.php'; ?>
    </header>
    <div>
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

            <h2 class="mb-3">Création de votre héros : </h2>
            
           
            
            <form method="POST" action="<?= base_url('/new-game') ?>" id="newGameForm">
                <div class = "main-container">
                    <div class="form-group">
                        <h2 class ="mb-4" for="hero_name">Nom du héros : </h2>
                        <input 
                            class="mb-3"
                            type="text" 
                            id="hero_name" 
                            name="hero_name" 
                            placeholder="Ex: Thorgar le Brave" 
                            required
                            minlength="3"
                            value="<?= htmlspecialchars($heroName ?? '') ?>"
                        >
                        <br>
                        <small>(Minimum 3 caractères)</small>
                    </div>
                    
                    <div class="form-group">
                        <h2>Choisissez votre classe</h2>
                        <div class="carrousel">
                            <?php foreach ($classes as $class): ?>
                                <div class="slide">
                                    
                                    <label for="class_<?= $class['id'] ?>">
                                        <div class="container">
                                            <div class="left-arrow">
                                                <button type="button" class ="prev" onClick="nextPrevSlide(-1)"> 
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16">
                                                        <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8"/>
                                                    </svg>
                                                </button>
                                            </div>
                                            <div class="hero ">
                                    
                                                <h3><?= htmlspecialchars($class['name']) ?></h3>
                                                
                                                <div class="class-description">
                                                    <p><?= htmlspecialchars($class['description']) ?></p>
                                                </div>
                                                
                                                <div class="class-stats">
                                                    <h4>Statistiques de base :</h4>
                                                    <ul>
                                                        <li>PV : <?= $class['base_pv'] ?></li>
                                                        <li>Mana : <?= $class['base_mana'] ?></li>
                                                        <li>Force : <?= $class['strength'] ?></li>
                                                        <li>Initiative : <?= $class['initiative'] ?></li>
                                                        <li>Objets max : <?= $class['max_items'] ?></li>
                                                    </ul>
                                                </div>
                                                <div class ="checkbox-container">
                                                    <input 
                                                    type="radio" 
                                                    id="class_<?= $class['id'] ?>" 
                                                    class="class_id" 
                                                    name="class_id"
                                                    value="<?= $class['id'] ?>"
                                                    >
                                                    <label for="class_<?= $class['id'] ?>" class="btn-label">
                                                        <span class="selected">Sélectionné</span>
                                                        <span class="unselected">Choisir</span>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="right-arrow">
                                                <button type="button" class ="next" onClick="nextPrevSlide(1)"> <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16">
                                                        <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8"/>
                                                    </svg></button></button>
                                            </div>
                                            
                                        </div>
                                    </label>
                                    
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <h2 for="biography">Biographie</h2>
                        <textarea 
                            id="biography" 
                            name="biography" 
                            rows="8"
                            placeholder="Racontez l'histoire de votre héros..."
                        ><?= htmlspecialchars($biography ?? '') ?></textarea>
                        <br>
                        <small>(Optionnel)</small>
                    </div>
                    
                    <div class="form-actions">
                        <button type="button" class="btn-primary" id="prevBtn" onclick="nextPrev(-1)">Précédent</button>
                        <button type="button" class="btn-primary" id="nextBtn" onclick="nextPrev(1)">Suivant</button>
                        
                    </div>
                </div>
            </form>
            <div style="text-align:center;margin:25px;">
                <span class="step"></span>
                <span class="step"></span>
                <span class="step"></span>
            </div>
        </main>
        
       
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
</body>
</html>