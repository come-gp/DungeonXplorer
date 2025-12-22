<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link rel="stylesheet" href="/dungeonXplorer/public/css/style.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>

    <title>Dungeon Explorer</title>

    <link rel="stylesheet" href="<?= base_url('/css/navbar.css') ?>">
    <link rel="stylesheet" href="<?= base_url('/css/home.css') ?>?v=<?= time() ?>">
</head>
<body>
    <?php require __DIR__ . '/components/navbar.php'; ?>

    <div class="main-container">
        <h1 class="mx-auto text-center">Dungeon Explorer</h1>

        <p class="mx-auto text-center">
            Bienvenue dans Dungeon Explorer, un jeu dont vous êtes le héro !<br>
            Explorez des donjons mystérieux, combattez des monstres et découvrez des trésors cachés !
        </p>

        <div class="d-flex flex-column align-items-center">

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

        <?php echo 'user_id = . ' . $_SESSION['user_id'] ?>



            <?php if (!$isLoggedIn): ?>
                <a href="<?= base_url('/new-game') ?>"><button class="btn-primary">Nouvelle Partie</button></a>
                <button class="btn-primary">Reprendre</button>
                <button class="btn-primary">Charger</button>

               

            <?php else: ?>
                <a href="<?= base_url('/register') ?>"><button class="btn-primary">S'inscrire</button></a>
                <a href="<?= base_url('/login') ?>"><button class="btn-primary">Se Connecter</button></a>
            <?php endif; ?>


        </div>
    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
