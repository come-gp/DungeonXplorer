<?php
/** @var bool $isLoggedIn */
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link rel="stylesheet" href="/dungeonXplorer/public/css/style.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <title>Dungeon Explorer</title>

    <link rel="stylesheet" href="../public/css/home.css">
</head>
<body>
    <header class="d-flex justify-content-end p-3">
        <a class="text-link" href="/login">Se Connecter</a>
    </header>

    <div class="main-container">
        <h1 class="mx-auto text-center">Dungeon Explorer</h1>

        <p class="mx-auto text-center">
            Bienvenue dans Dungeon Explorer, un jeu dont vous êtes le héro !<br>
            Explorez des donjons mystérieux, combattez des monstres et découvrez des trésors cachés !
        </p>

        <div class="d-flex flex-column align-items-center">

            <?php if (!$isLoggedIn): ?>
                <a href="/new-game"><button class="btn-primary">Nouvelle Partie</button></a>
                <button class="btn-primary">Reprendre</button>
                <button class="btn-primary">Charger</button>

               

            <?php else: ?>
                <a href="<?= base_url('/register') ?>"><button class="btn-primary">S'inscrire</button></a>
                <a href="<?= base_url('/login') ?>"><button class="btn-primary">Se Connecter</button></a>
            <?php endif; ?>


        </div>
    </div>
</body>
</html>
