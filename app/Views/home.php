<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <title>Dungeon Explorer</title>

    <link rel="stylesheet" href="<?= base_url('/css/navbar.css') ?>">
    <link rel="stylesheet" href="<?= base_url('/css/home.css') ?>?v=<?= time() ?>">
</head>
<body style="background-image: url('<?= base_url('/imgs/foret.jpg') ?>'); background-size: cover; background-repeat: no-repeat; background-attachment: fixed;">
    <?php require __DIR__ . '/components/navbar.php'; ?>

    <div class="container my-5">
        <h1 class="display-1 mx-auto text-center ">Dungeon Explorer</h1>

        <p class="fs-5 mx-auto text-center">
            Bienvenue dans Dungeon Explorer, un jeu dont vous êtes le héro !<br>
            Explorez des donjons mystérieux, combattez des monstres et découvrez des trésors cachés !
        </p>
    </div>

    <div class="container my-5">
        <div class="row">
            <div class="col d-flex flex-column align-items-start justify-content-center pt-4" style="width: 700px; height: 350px;">
                <?php 
                
                if ($error): ?>
                    <div class="alert alert-danger" role="alert">
                        <i class="fas fa-exclamation-triangle"></i> <?= htmlspecialchars($error) ?>
                    </div>
                <?php endif; ?>

                <?php if ($success): ?>
                    <div class="alert alert-success" role="alert">
                        <i class="fas fa-check-circle"></i> <?= htmlspecialchars($success) ?>
                    </div>
                <?php endif; ?>

                <?php if ($isLoggedIn): ?>
                    <a href="<?= base_url('/new-game') ?>" class="btn-primary">Nouvelle Partie</a>
                    <a href="<?= base_url('/game') ?>" class="btn-primary">Reprendre</a>
                    <a href="<?= base_url('/profile') ?>" class="btn-primary">Charger</a>
                <?php else: ?>
                    <a href="<?= base_url('/register') ?>" class="btn-primary">S'inscrire</a>
                    <a href="<?= base_url('/login') ?>" class="btn-primary">Se Connecter</a>
                <?php endif; ?>
            </div>
            <div class="col pt-4">
                <div class=" row main-container" style = "width: 700px; height: 350px;">
                    <div class="col text-center">
                         <?php if ($isLoggedIn): ?>
                            <img src="<?=$lastHero['image']?>" alt="<?=$class['name']?>">
                        <?php else: ?>
                            <img src="../imgs/langlois.jpeg" alt="Héros" width="200" height="250" >
                        <?php endif; ?>
                    </div>
                    <div class="col text-center">
                        <?php if ($isLoggedIn): ?>
                            <h3>Dernière Partie :</h3>
                            <p><?= htmlspecialchars($chapter['title']) ?></p>
                            <p><?= htmlspecialchars($progress['completion_date']) ?></p>
                            <hr>
                            <h3>Héros :</h3>
                            <p>Nom : <?= htmlspecialchars($lastHero['name']) ?></p>
                            <p>Bio : <?= htmlspecialchars($lastHero['biography']) ?></p>
                        <?php else: ?>
                            <h3>Bienvenue Aventurier !</h3>
                            <p>Connectez-vous ou inscrivez-vous pour commencer votre aventure dans Dungeon Explorer !</p>
                            <hr>
                            <h3>Créez votre héros :</h3>
                            <p>Choisissez parmi différentes classes et personnalisez votre héros pour affronter les défis qui vous attendent.</p>   
                            
                        <?php endif; ?>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>