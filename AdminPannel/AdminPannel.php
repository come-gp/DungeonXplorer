<?php

session_start();

require '../php/imports.php';
/*
if (!isset($_SESSION['user_id'] && $_SESSION['is_admin'])) {
    header('Location: ../index.php');
    exit();
}
*/
function deleteFromTable($table,$col, $id) {
    global $db;
    $stmt = $db->prepare('DELETE FROM ' . $table . ' WHERE ' . $col . ' = ' . intval($id).';');
    $stmt->execute();
}

//delete, modifier, ajouter des utilisateurs
//delete, modifier, ajouter des chapitres
//delete, modifier, ajouter des monstres
//delete, modifier, ajouter des items
//delete, modifier, ajouter des classes
//delete, modifier, ajouter des niveau (xp) selon classes
?>

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
</head>
<body>
    
    <div class="AdminPannel-container mx-4">
        <div class="logo-text">
            <i class="fas fa-dungeon"></i> DungeonXplorer
        </div>
        
        <h2 class="text-center mb-4">Panneau Administrateur</h2>

        <div class="p-4">
            <h3 class="mb-3">Gestion de la base de données</h3>
            <form method="POST">
                <select class="form-select mb-3"name="choix" onchange="this.form.submit()">
                    <option value="">selectionnez une option</option>
                    <option value="users">Utilisateurs</option>
                    <option value="chapters">Chapitres</option>
                    <option value="monsters">Monstres</option>
                    <option value="items">Objets</option>
                    <option value="class">Classes</option>
                    <option value="level">Niveaux</option>
                </select>
            </form>
            <div class="row mb-3">
                <div class="col"></div>
                <div class="col-6">
                    <?php
                    if (!empty($_POST['choix'])) {
                        if ($_POST['choix'] === 'users') {
                            $stmt = $db->prepare('SELECT id, pseudo FROM user');
                            $stmt->execute();
                            $row = $stmt->fetchall(PDO::FETCH_ASSOC);
                            echo '<ul class="list-group">';
                            foreach ($row as $user) {
                                echo '
                                <li class="list-group-item align-items-center text-center">id: '
                                    .$user['id'].', pseudo: '.$user['pseudo'].'<br>
                                    <form method="POST">
                                        <button type="submit" name="BouttonSupprimerUser" value="'.$user['id'].'" class="btn btn-danger">supprimer</button>
                                        <button type="submit" name="BouttonModifierUser" class="btn btn-success">modifier</button>
                                    </form>
                                </li>';
                            }
                            echo "</ul>";
                        } elseif ($_POST['choix'] === 'chapters') {
                            $stmt = $db->prepare('SELECT id,title,content FROM chapter');
                            $stmt->execute();
                            $row = $stmt->fetchall(PDO::FETCH_ASSOC);
                            echo '<ul class="list-group">';
                            foreach ($row as $chapter) {
                                echo '
                                <li class="list-group-item align-items-center text-center">id: '
                                    .$chapter['id'].', titre: '.$chapter['title'].', contenu: '.$chapter['content'].'<br>
                                    <form method="POST">
                                        <button type="submit" name="BouttonSupprimerChapter" value="'.$chapter['id'].'" class="btn btn-danger">supprimer</button>
                                        <button type="submit" name="BouttonModifierChapter" class="btn btn-success">modifier</button>
                                    </form>
                                </li>';
                            }
                            echo "</ul>";
                        } elseif ($_POST['choix'] === 'monsters') {
                            $stmt = $db->prepare('SELECT id,name,pv,mana,initiative,strength,attack,xp FROM monster');
                            $stmt->execute();
                            $row = $stmt->fetchall(PDO::FETCH_ASSOC);
                            echo '<ul class="list-group">';
                            foreach ($row as $monster) {
                                echo '
                                <li class="list-group-item align-items-center text-center">id: '
                                    .$monster['id'].', nom: '.$monster['name'].', pv: '.$monster['pv'].', mana: '.$monster['mana'].', initiative: '.$monster['initiative'].', strength: '.$monster['strength'].', attack: '.$monster['attack'].', xp: '.$monster['xp'].'<br>
                                    <form method="POST">
                                        <button type="submit" name="BouttonSupprimerMonster" value="'.$monster['id'].'" class="btn btn-danger">supprimer</button>
                                        <button type="submit" name="BouttonModifierMonster" class="btn btn-success">modifier</button>
                                    </form>
                                </li>';
                            }
                            echo "</ul>";
                        } elseif ($_POST['choix'] === 'items') {
                            $stmt = $db->prepare('SELECT id,name,description,item_type FROM items');
                            $stmt->execute();
                            $row = $stmt->fetchall(PDO::FETCH_ASSOC);
                            echo '<ul class="list-group">';
                            foreach ($row as $item) {
                                echo '
                                <li class="list-group-item align-items-center text-center">id: '
                                    .$item['id'].', nom: '.$item['name'].', description: '.$item['description'].', type: '.$item['item_type'].'<br>
                                    <form method="POST">
                                        <button type="submit" name="BouttonSupprimerItem" value="'.$item['id'].'" class="btn btn-danger">supprimer</button>
                                        <button type="submit" name="BouttonModifierItem" class="btn btn-success">modifier</button>
                                    </form>
                                </li>';
                            }
                            echo "</ul>";
                        } elseif ($_POST['choix'] === 'class') {
                            $stmt = $db->prepare('SELECT id, name, description, base_pv, base_mana, strength, initiative, max_items FROM class');
                            $stmt->execute();
                            $row = $stmt->fetchall(PDO::FETCH_ASSOC);
                            echo '<ul class="list-group">';
                            foreach ($row as $class) {
                                echo '
                                <li class="list-group-item align-items-center text-center">id: '
                                    .$class['id'].', nom: '.$class['name'].', description: '.$class['description'].', base_pv: '.$class['base_pv'].', base_mana: '.$class['base_mana'].', strength: '.$class['strength'].', initiative: '.$class['initiative'].', max_items: '.$class['max_items'].'<br>
                                    <form method="POST">
                                        <button type="submit" name="BouttonSupprimerClass" value="'.$class['id'].'" class="btn btn-danger">supprimer</button>
                                        <button type="submit" name="BouttonModifierClass" class="btn btn-success">modifier</button>
                                    </form>
                                </li>';
                            }
                            echo "</ul>";
                        } elseif ($_POST['choix'] === 'level') {
                            $stmt = $db->prepare('SELECT id, class_id, level, required_xp, pv_bonus, mana_bonus, strength_bonus, initiative_bonus FROM level');
                            $stmt->execute();
                            $row = $stmt->fetchall(PDO::FETCH_ASSOC);
                            echo '<ul class="list-group">';
                            foreach ($row as $level) {
                                echo '
                                <li class="list-group-item align-items-center text-center">id: '
                                    .$level['id'].', class_id: '.$level['class_id'].', level: '.$level['level'].', required_xp: '.$level['required_xp'].', pv_bonus: '.$level['pv_bonus'].', mana_bonus: '.$level['mana_bonus'].', strength_bonus: '.$level['strength_bonus'].', initiative_bonus: '.$level['initiative_bonus'].'<br>
                                    <form method="POST">
                                        <button type="submit" name="BouttonSupprimerLevel" value="'.$level['id'].'" class="btn btn-danger">supprimer</button>
                                        <button type="submit" name="BouttonModifierLevel" class="btn btn-success">modifier</button>
                                    </form>
                                </li>';
                            }
                            echo "</ul>";
                        }
                    }
                    if(!empty($_POST['BouttonSupprimerUser'])){
                        deleteFromTable('user', 'id', $_POST['BouttonSupprimerUser']);
                    }
                    if(!empty($_POST['BouttonSupprimerChapter'])){
                        deleteFromTable('chapter_treasure', 'chapter_id', $_POST['BouttonSupprimerChapter']);
                        deleteFromTable('encounter', 'chapter_id', $_POST['BouttonSupprimerChapter']);
                        deleteFromTable('links', 'chapter_id', $_POST['BouttonSupprimerChapter']);
                        deleteFromTable('links', 'next_chapter_id', $_POST['BouttonSupprimerChapter']);
                        deleteFromTable('chapter', 'id', $_POST['BouttonSupprimerChapter']);
                    }
                    if(!empty($_POST['BouttonSupprimerMonster'])){
                        deleteFromTable('monster', 'id', $_POST['BouttonSupprimerMonster']);
                    }
                    if(!empty($_POST['BouttonSupprimerItem '])){
                        deleteFromTable('items', 'id', $_POST['BouttonSupprimerItem']);
                    }
                    if(!empty($_POST['BouttonSupprimerClass'])){
                        deleteFromTable('class', 'id', $_POST['BouttonSupprimerClass']);
                    }
                    if(!empty($_POST['BouttonSupprimerLevel'])){
                        deleteFromTable('level', 'id', $_POST['BouttonSupprimerLevel']);
                    }
                    ?>
                </div>
                <div class="col"></div>
            </div>
            
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>