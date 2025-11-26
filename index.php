<?php
session_start();
require 'php/imports.php';

$isLoggedIn = isset($_SESSION['user_id']);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Dungeon Explorer</title>
</head>
<body>
    <header class="d-flex justify-content-end p-3">
    <?php if (!$isLoggedIn) : ?>
        <a class="text-link" href="login/index.php">Se Connecter</a>
        <?php else : ?>
        <a class="text-link" href=" profile/index.php">Mon Profile</a>
        <?php endif; ?>
    </header>
    <div class="main-container">
        <h1 class="mx-auto text-center">Dungeon Explorer</h1>
        <p class="mx-auto text-center">Bienvenue dans Dungeon Explorer, un jeu dont vous êtes
            le heros d'aventure palpitant<br> où vous explorez des donjons mystérieux, combattez des monstres redoutables et
            découvrez des trésors cachés.<br> Préparez-vous à vivre une expérience inoubliable remplie d'action et de stratégie!</p>
        <div class=" d-flex flex-column align-items-center ">
            <?php if ($isLoggedIn) : ?>
            <a href="new-game/index.php"><button class="btn-primary" href>Nouvelle Partie</button></a>
            <button class="btn-primary">Reprendre</button>
            <button class="btn-primary">Charger</button>
            <?php else : ?>
                <a href="register/index.php"><button class="btn-primary">S'inscrire</button></a>
                <a href="login/index.php"><button class="btn-primary">Se Connecter</button></a>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>