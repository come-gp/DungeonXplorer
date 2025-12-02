<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Création de personnage - DungeonXplorer</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>DungeonXplorer</h1>
            <p>Bienvenue <?= htmlspecialchars($_SESSION['pseudo']) ?></p>
            <a href="../logout.php">Déconnexion</a>
        </header>
        
        <main>
            <h2>Création de votre héros</h2>
            
            <?php if ($error): ?>
                <div class="error">
                    <?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>
            
            <form method="POST" action="<?= base_url('/new-game') ?>">
                
                <div class="form-group">
                    <label for="hero_name">Nom du héros</label>
                    <input 
                        type="text" 
                        id="hero_name" 
                        name="hero_name" 
                        placeholder="Ex: Thorgar le Brave" 
                        required
                        minlength="3"
                        value="<?= htmlspecialchars($heroName ?? '') ?>"
                    >
                    <small>Minimum 3 caractères</small>
                </div>
                
                <div class="form-group">
                    <label>Choisissez votre classe</label>
                    
                    <?php foreach ($classes as $class): ?>
                        <div class="class-option">
                            <input 
                                type="radio" 
                                id="class_<?= $class['id'] ?>" 
                                name="class_id" 
                                value="<?= $class['id'] ?>"
                                required
                            >
                            <label for="class_<?= $class['id'] ?>">
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
                            </label>
                        </div>
                    <?php endforeach; ?>
                </div>
                
                <div class="form-group">
                    <label for="biography">Biographie (optionnel)</label>
                    <textarea 
                        id="biography" 
                        name="biography" 
                        rows="4" 
                        placeholder="Racontez l'histoire de votre héros..."
                    ><?= htmlspecialchars($biography ?? '') ?></textarea>
                </div>
                
                <div class="form-actions">
                    <button type="submit">Commencer l'aventure</button>
                    <a href="../index.php">Retour</a>
                </div>
                
            </form>
        </main>
        
        <footer>
            <p>&copy; 2024 DungeonXplorer - Team Maxence Langlois</p>
        </footer>
    </div>
</body>
</html>