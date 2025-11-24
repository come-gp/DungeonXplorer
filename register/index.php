<?php
session_start();

require '../php/Database.php';

// Si l'utilisateur est déjà connecté, redirection
if (isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit();
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupération et validation des données
    $pseudo = trim($_POST['pseudo'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';
    
    // Validation
    if (empty($pseudo)) {
        $error = 'Le pseudo est requis.';
    } elseif (strlen($pseudo) < 3) {
        $error = 'Le pseudo doit contenir au moins 3 caractères.';
    } elseif (empty($password)) {
        $error = 'Le mot de passe est requis.';
    } elseif (strlen($password) < 6) {
        $error = 'Le mot de passe doit contenir au moins 6 caractères.';
    } elseif ($password !== $confirm_password) {
        $error = 'Les mots de passe ne correspondent pas.';
    } else {
        try {
            // Connexion à la base de données
            // $dsn = 'mysql:host=localhost;dbname=dungeonxplorer;charset=utf8mb4';
            // $username = 'root'; // À adapter selon votre configuration
            // $db_password = ''; // À adapter selon votre configuration
            
            // $db = new db($dsn, $username, $db_password, [
            //     db::ATTR_ERRMODE => db::ERRMODE_EXCEPTION,
            //     db::ATTR_DEFAULT_FETCH_MODE => db::FETCH_ASSOC
            // ]);
            
            // Vérifier si le pseudo existe déjà
            $stmt = $db->prepare('SELECT id FROM user WHERE pseudo = :pseudo');
            $stmt->execute(['pseudo' => $pseudo]);
            
            if ($stmt->fetch()) {
                $error = 'Ce pseudo est déjà utilisé.';
            } else {
                // Hachage du mot de passe
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                
                // Insertion du nouvel utilisateur
                $stmt = $db->prepare('INSERT INTO user (pseudo, password) VALUES (:pseudo, :password)');
                $stmt->execute([
                    'pseudo' => $pseudo,
                    'password' => $hashed_password
                ]);
                
                $success = 'Compte créé avec succès ! Vous pouvez maintenant vous connecter.';
                
                // Optionnel : connexion automatique
                // $_SESSION['user_id'] = $db->lastInsertId();
                // $_SESSION['pseudo'] = $pseudo;
                // header('Location: index.php');
                // exit();
            }
        } catch (dbException $e) {
            $error = 'Erreur lors de la création du compte. Veuillez réessayer.';
            // En développement, pour déboguer : $error = $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Créer un compte - DungeonXplorer</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    
    <link href="https://fonts.googleapis.com/css2?family=Pirata+One&family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="register-container">
        <div class="logo-text">
            <i class="fas fa-dungeon"></i> DungeonXplorer
        </div>
        
        <h2 class="text-center mb-4">Créer un compte</h2>
        
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
        
        <form method="POST" action="">
            <div class="mb-3">
                <label for="pseudo" class="form-label">
                    <i class="fas fa-user"></i> Pseudo
                </label>
                <input 
                    type="text" 
                    class="form-control" 
                    id="pseudo" 
                    name="pseudo" 
                    placeholder="Choisissez votre pseudo" 
                    required
                    minlength="3"
                    value="<?= htmlspecialchars($pseudo ?? '') ?>"
                >
                <div class="form-text text-secondary">Minimum 3 caractères</div>
            </div>
            
            <div class="mb-3">
                <label for="password" class="form-label">
                    <i class="fas fa-lock"></i> Mot de passe
                </label>
                <input 
                    type="password" 
                    class="form-control" 
                    id="password" 
                    name="password" 
                    placeholder="Créez un mot de passe" 
                    required
                    minlength="6"
                >
                <div class="form-text text-secondary">Minimum 6 caractères</div>
            </div>
            
            <div class="mb-4">
                <label for="confirm_password" class="form-label">
                    <i class="fas fa-lock"></i> Confirmer le mot de passe
                </label>
                <input 
                    type="password" 
                    class="form-control" 
                    id="confirm_password" 
                    name="confirm_password" 
                    placeholder="Confirmez votre mot de passe" 
                    required
                    minlength="6"
                >
            </div>
            
            <button type="submit" class="btn btn-primary w-100 mb-3">
                <i class="fas fa-user-plus"></i> Créer mon compte
            </button>
        </form>
        
        <div class="text-center">
            <p class="mb-0" style="color: #BFBFBF;">
                Vous avez déjà un compte ? 
                <a href="../login/" class="text-link">Se connecter</a>
            </p>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>