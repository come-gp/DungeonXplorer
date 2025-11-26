<?php
session_start();

include '../php/imports.php';

if (!isset($_SESSION['user_id'])) {
    echo"<script language=\"javascript\">";
    echo"alert('non connecté, redirection vers login');";
    echo"</script>";
    header('Location: ../login/');
    exit();
}


try {
    $stmt = $db->query('SELECT * FROM class');
    $classes = $stmt->fetchAll();
    
} catch (dbException $e) {
    die('Erreur de connexion : ' . $e->getMessage());
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $heroName = trim($_POST['hero_name'] ?? '');
    $classId = (int)($_POST['class_id'] ?? 0);
    $biography = trim($_POST['biography'] ?? '');
    
    if (empty($heroName)) {
        $error = 'Le nom du héros est requis.';
    } elseif (strlen($heroName) < 3) {
        $error = 'Le nom doit contenir au moins 3 caractères.';
    } elseif ($classId <= 0) {
        $error = 'Veuillez sélectionner une classe.';
    } else {
        try {
            $stmt = $db->prepare('SELECT * FROM class WHERE id = ?');
            $stmt->execute([$classId]);
            $selectedClass = $stmt->fetch();
            
            if (!$selectedClass) {
                $error = 'Classe invalide.';
            } else {
                $stmt = $db->prepare('
                    INSERT INTO hero (name, class_id, biography, pv, mana, strength, initiative, xp, current_level)
                    VALUES (?, ?, ?, ?, ?, ?, ?, 0, 1)
                ');
                
                $stmt->execute([
                    $heroName,
                    $classId,
                    $biography,
                    $selectedClass['base_pv'],
                    $selectedClass['base_mana'],
                    $selectedClass['strength'],
                    $selectedClass['initiative']
                ]);
                
                $heroId = $db->lastInsertId();
                
                $stmt = $db->prepare('
                    INSERT INTO appartenir (id_user, id_hero, derniere_utilisation)
                    VALUES (?, ?, NOW())
                ');
                $stmt->execute([$_SESSION['user_id'], $heroId]);
                
                header('Location: ../game/');
                exit();
            }
        } catch (dbException $e) {
            $error = 'Erreur lors de la création du héros.';
        }
    }
}
?>
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
            
            <form method="POST" action="">
                
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