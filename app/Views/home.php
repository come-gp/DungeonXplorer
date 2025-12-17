
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link rel="stylesheet" href="/dungeonXplorer/public/css/style.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVJkEZSMUkrQ6usznuy8+u+7NfbbQvB/bigoOkc46FefubnmUZnyjveGQE/7GuirVH40LxUpg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <title>Dungeon Explorer</title>

    <link rel="stylesheet" href="../public/css/home.css">
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOYfy6S4+gkCQ/lqojAsuBjKSo" crossorigin="anonymous"></script>
</body>
</html>
