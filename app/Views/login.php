<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - DungeonXplorer</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Pirata+One&family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('/css/login.css') ?>">
    <link rel="stylesheet" href="<?= base_url('/css/navbar.css') ?>">
</head>
<body>
    <?php require __DIR__ . '/components/navbar.php'; ?>
    <div class="content-wrapper">
        <div class="login-container">
            <div class="logo-text">
                <i class="fas fa-dungeon"></i> DungeonXplorer
            </div>
            
            <h2 class="text-center mb-4">Connexion</h2>
            
            <?php if ($error): ?>
                <div class="alert alert-danger" role="alert">
                    <i class="fas fa-exclamation-triangle"></i> <?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>
            
            <form method="POST">
                <div class="mb-3">
                    <label for="pseudo" class="form-label">
                        <i class="fas fa-user"></i> Pseudo
                    </label>
                    <input 
                        type="text" 
                        class="form-control" 
                        id="pseudo" 
                        name="pseudo" 
                        placeholder="Votre pseudo" 
                        required
                        value="<?= htmlspecialchars($pseudo ?? '') ?>"
                    >
                </div>
                
                <div class="mb-4">
                    <label for="password" class="form-label">
                        <i class="fas fa-lock"></i> Mot de passe
                    </label>
                    <input 
                        type="password" 
                        class="form-control" 
                        id="password" 
                        name="password" 
                        placeholder="Votre mot de passe" 
                        required
                    >
                </div>
                
                <button type="submit" class="btn btn-primary w-100 mb-3">
                    <i class="fas fa-sign-in-alt"></i> Se connecter
                </button>
            </form>
            
            <div class="divider">OU</div>
            
            <div class="text-center">
                <p class="mb-0" style="color: #BFBFBF;">
                    Vous n'avez pas encore de compte ?
                </p>
                <a href="<?= base_url('/register') ?>" class="text-link">
                    <i class="fas fa-user-plus"></i> Créer un compte
                </a>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>