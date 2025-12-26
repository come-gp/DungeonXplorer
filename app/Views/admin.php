
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>

    <title>Dungeon Explorer</title>

    <link rel="stylesheet" href="<?= base_url('/css/navbar.css') ?>">
    <link rel="stylesheet" href="<?= base_url('/css/admin.css') ?>?v=<?= time() ?>">
</head>
<body>
    <header>
        <?php require __DIR__ . '/components/navbar.php'; ?>
    </header>

    <h2 class = "centered">Pannel Administrateur</h2>

    <form method="POST">
        <select name="choix" onchange="this.form.submit()">
            <option value="" disabled selected>Choisir</option>
            <option value="users">Utilisateurs</option>
            <option value="chapters">Chapitres</option>
            <option value="monsters">Monstres</option>
            <option value="items">Objets</option>
            <option value="class">Classes</option>
        </select>
    </form>

    <?php if (!empty($users) && $_POST['choix'] === 'users'){
        echo '<ul class="list-group">';
        foreach ($users as $user) {
            echo '<li class="main-container">
                    <b> Id </b>: '.$user['id'].
                    ' <br> <b> Pseudo </b>: '.$user['pseudo'].
                    '<br>
                    <form method="POST" action="?controller=admin&action=delete">
                        <button name="delete_user" value="'.$user['id'].'" class="btn btn-primary">Supprimer</button>
                    </form>
                </li>';
        }
        echo "</ul>";
    } elseif (!empty($chapters) && $_POST['choix'] === 'chapters'){
        echo '<ul class="list-group">';
        foreach ($chapters as $chapter) {
            echo '<li class="main-container">
            <b> Id </b>: '.$chapter['id'].
            ' <br> <b> Titre </b>: '.$chapter['title'].
            ' <br> <b> Contenu </b>: '.$chapter['content'].
            '<br>
                <form method="POST" action="?controller=admin&action=delete">
                    <button name="delete_chapter" value="'.$chapter['id'].'" class="btn btn-primary">Supprimer</button>
                </form>
            </li>';
        }
        echo '</ul>';
    } elseif (!empty($monsters) && $_POST['choix'] === 'monsters'){
        echo '<ul class="list-group">'; 
        foreach ($monsters as $monster) {
            echo '<li class="main-container">
                    <b> Id </b>: '.$monster['id'].
                    ' <br> <b> Nom </b>: '.$monster['name'].
                    ' <br> <b> PV </b>: '.$monster['pv'].
                    ' <br> <b> Mana </b>: '.$monster['mana'].
                    '<br>
                    <form method="POST" action="">
                        <button name="delete_monster" value="'.$monster['id'].'" class="btn btn-primary">Supprimer</button>
                    </form>
                </li>';
        }
        echo '</ul>';
    } elseif (!empty($items) && $_POST['choix'] === 'items'){
        echo '<ul class="list-group">'; 
        foreach ($items as $item) {
            echo '<li class="main-container">
                    <b> Id </b>: '.$item['id'].
                    ' <br> <b> Nom </b>: '.$item['name'].
                    ' <br> <b> Description </b>: '.$item['description'].
                    ' <br> <b> Type </b>: '.$item['item_type'].
                    '<br>
                    <form method="POST" action="">
                        <button name="delete_item" value="'.$item['id'].'" class="btn btn-primary">Supprimer</button>
                    </form>
                </li>';
        }
        echo '</ul>';
    }
    elseif (!empty($classes) && $_POST['choix'] === 'class'){
        echo '<ul class="list-group">'; 
        foreach ($classes as $class) {
            echo '<li class="main-container">
                    <b> Id </b>: '.$class['id'].
                    ' <br><b> Nom </b>: '.$class['name'].
                    ' <br> <b> Description </b>: '.$class['description'].
                    ' <br> <b> Base de pv </b>: '.$class['base_pv'].
                    '<br>
                    <form method="POST" action="">
                        <button name="delete_class" value="'.$class['id'].'" class="btn btn-primary">Supprimer</button>
                    </form>
                </li>';
        }
        echo '</ul>';
    } ?>
</body>
</html>