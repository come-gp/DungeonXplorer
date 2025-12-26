
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>

    <title>Dungeon Explorer</title>

    <link rel="stylesheet" href="<?= base_url('/css/navbar.css') ?>">
    <link rel="stylesheet" href="<?= base_url('/css/home.css') ?>?v=<?= time() ?>">
</head>
<body>
    <h2>Pannel Administrateur</h2>

    <form method="POST">
        <select name="choix" onchange="this.form.submit()">
            <option value="">Choisir</option>
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
            echo '<li class="list-group-item align-items-center text-center">
                    id: '.$user['id'].
                    ', pseudo: '.$user['pseudo'].
                    '<br>
                    <form method="POST" action="?controller=admin&action=delete">
                        <button name="delete_user" value="'.$user['id'].'" class="btn btn-danger">Supprimer</button>
                    </form>
                </li>';
        }
        echo "</ul>";
    } elseif (!empty($chapters) && $_POST['choix'] === 'chapters'){
        echo '<ul class="list-group">';
        foreach ($chapters as $chapter) {
            echo '<li class="list-group-item align-items-center text-center">
            id: '.$chapter['id'].
            ', titre: '.$chapter['title'].
            ', contenu: '.$chapter['content'].
            '<br>
                <form method="POST" action="?controller=admin&action=delete">
                    <button name="delete_chapter" value="'.$chapter['id'].'" class="btn btn-danger">Supprimer</button>
                </form>
            </li>';
        }
        echo '</ul>';
    } elseif (!empty($monsters) && $_POST['choix'] === 'monsters'){
        echo '<ul class="list-group">'; 
        foreach ($monsters as $monster) {
            echo '<li class="list-group-item align-items-center text-center">
                    id: '.$monster['id'].
                    ', name: '.$monster['name'].
                    ', pv: '.$monster['pv'].
                    ', mana: '.$monster['mana'].
                    '<br>
                    <form method="POST" action="">
                        <button name="delete_monster" value="'.$monster['id'].'" class="btn btn-danger">Supprimer</button>
                    </form>
                </li>';
        }
        echo '</ul>';
    } elseif (!empty($items) && $_POST['choix'] === 'items'){
        echo '<ul class="list-group">'; 
        foreach ($items as $item) {
            echo '<li class="list-group-item align-items-center text-center">
                    id: '.$item['id'].
                    ', name: '.$item['name'].
                    ', description: '.$item['description'].
                    ', type: '.$item['item_type'].
                    '<br>
                    <form method="POST" action="">
                        <button name="delete_item" value="'.$item['id'].'" class="btn btn-danger">Supprimer</button>
                    </form>
                </li>';
        }
        echo '</ul>';
    }
    elseif (!empty($classes) && $_POST['choix'] === 'class'){
        echo '<ul class="list-group">'; 
        foreach ($classes as $class) {
            echo '<li class="list-group-item align-items-center text-center">
                    id: '.$class['id'].
                    ', name: '.$class['name'].
                    ', description: '.$class['description'].
                    ', base_pv: '.$class['base_pv'].
                    '<br>
                    <form method="POST" action="">
                        <button name="delete_class" value="'.$class['id'].'" class="btn btn-danger">Supprimer</button>
                    </form>
                </li>';
        }
        echo '</ul>';
    } ?>
</body>
</html>