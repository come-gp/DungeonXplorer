<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Créer un compte - DungeonXplorer</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="<?= base_url('/css/navbar.css') ?>">
    <link rel="stylesheet" href="../public/css/register.css">
</head>
<body>
<div class="register-container">
    <div class="logo-text">
        <i class="fas fa-dungeon"></i> DungeonXplorer
    </div>

    <h2 class="text-center mb-4">Créer un compte</h2>

    <?php if ($error): ?>
        <div class="alert alert-danger" role="alert">
            <i class="fas fa-exclamation-triangle"></i> <?= e($error) ?>
        </div>
    <?php endif; ?>


    <form method="POST" action="<?= base_url('/register') ?>">
        <div class="mb-3">
            <label for="pseudo" class="form-label"><i class="fas fa-user"></i> Pseudo</label>
            <input type="text" class="form-control" id="pseudo" name="pseudo"
                   placeholder="Choisissez votre pseudo" required minlength="3">
            <div class="form-text text-secondary">Minimum 3 caractères</div>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label"><i class="fas fa-lock"></i> Mot de passe</label>
            <input type="password" class="form-control" id="password" name="password"
                   placeholder="Créez un mot de passe" required minlength="6">
            <div class="form-text text-secondary">Minimum 6 caractères</div>
        </div>

        <div class="mb-4">
            <label for="confirm_password" class="form-label"><i class="fas fa-lock"></i> Confirmer le mot de passe</label>
            <input type="password" class="form-control" id="confirm_password" name="confirm_password"
                   placeholder="Confirmez votre mot de passe" required minlength="6">
        </div>

        <button type="submit" class="btn btn-primary w-100 mb-3">
            <i class="fas fa-user-plus"></i> Créer mon compte
        </button>
    </form>

    <div class="text-center">
        <p class="mb-0" style="color: #BFBFBF;">
            Vous avez déjà un compte ?
            <a href="<?= base_url('/login') ?>" class="text-link">Se connecter</a>
        </p>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
