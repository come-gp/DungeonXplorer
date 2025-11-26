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
function deleteUser($id) {
    $stmt = $db->prepare('SELECT hero_id FROM links WHERE next_chapter_id='.$id.';');
    $stmt->execute();
    $row = $stmt->fetchall(PDO::FETCH_ASSOC);
    foreach ($row as $hero) {
        deleteHero($hero['hero_id']);
    }
    deleteFromTable('appartenir', 'id_hero', $id);
    deleteFromTable('user', 'id', $id);
}
function deleteChapter($id) {
    global $db;
    try{
        $stmt = $db->prepare(
        'UPDATE hero_progress SET chapter_id=(
        SELECT chapter_id FROM links WHERE next_chapter_id='.$id.'
        )
        WHERE chapter_id='.$id.';');
        $stmt->execute();
    } catch (Exception $e) {
        echo "<script>alert('Le chapitre n'a pas de chapitre précédent ou n'est pas lié correctement.');</script>";
        $stmt = $db->prepare(
        'UPDATE hero_progress SET chapter_id=(
        SELECT chapter_id FROM links WHERE chapter_id not in (SELECT next_chapter_id FROM links) AND chapter_id != '.$id.'
        )
        WHERE chapter_id='.$id.';');
        $stmt->execute();
        //si le chapitre n'a pas de chapitre précédent, on le remplace par un chapitre qui n'est pas lié comme suivant(probablement un debut de jeu) 
        //Probleme si il n'y a aucun chapitre non lié
    }
    deleteFromTable('chapter_treasure', 'chapter_id', $id);
    deleteFromTable('encounter', 'chapter_id', $id);
    deleteFromTable('links', 'chapter_id', $id);
    deleteFromTable('links', 'next_chapter_id', $id);
    deleteFromTable('chapter', 'id', $id);
}
function deleteMonster($id) {
    deleteFromTable('monster_loot', 'monster_id', $id);
    deleteFromTable('encounter', 'monster_id', $id);
    deleteFromTable('monster', 'id', $id);
}
function deleteItem($id) {
    //mets à null les références aux items dans la table hero
    $stmt = $db->prepare('UPDATE hero SET 
    armor_item_id = CASE WHEN armor_item_id = '.$id.' THEN NULL ELSE armor_item_id END,
    primary_weapon_item_id = CASE WHEN primary_weapon_item_id = '.$id.' THEN NULL ELSE primary_weapon_item_id END,
    secondary_weapon_item_id = CASE WHEN secondary_weapon_item_id = '.$id.' THEN NULL ELSE secondary_weapon_item_id END,
    shield_item_id = CASE WHEN shield_item_id = '.$id.' THEN NULL ELSE shield_item_id END;');
    $stmt->execute();
    deleteFromTable('monster_loot', 'item_id', $id);
    deleteFromTable('chapter_treasure', 'item_id', $id);
    deleteFromTable('inventory', 'item_id', $id);
    deleteFromTable('items', 'id', $id);
}
function deleteHero($id) {
    deleteFromTable('inventory', 'hero_id', $id);
    deleteFromTable('hero_progress', 'hero_id', $id);
    deleteFromTable('hero', 'id', $id);
}
function deleteClass($id) {
    deleteFromTable('level', 'class_id', $id);
    global $db;
    $stmt = $db->prepare('SELECT id FROM hero WHERE class_id = ' . intval($id) . ';');
    $stmt->execute();
    $row = $stmt->fetchall(PDO::FETCH_ASSOC);
    foreach ($row as $class) {
        deleteHero($class['id']);
    }
    deleteFromTable('class', 'id', $id);
}
// modifier, ajouter des utilisateurs
// modifier, ajouter des chapitres
// modifier, ajouter des monstres
// modifier, ajouter des items
// modifier, ajouter des classes
// modifier, ajouter des niveau (xp) selon classes
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
                    <option value="users"<?php if (!empty($_POST['choix']) && $_POST['choix'] === 'users') echo ' selected'; ?>>Utilisateurs</option>
                    <option value="chapters"<?php if (!empty($_POST['choix']) && $_POST['choix'] === 'chapters') echo ' selected'; ?>>Chapitres</option>
                    <option value="monsters"<?php if (!empty($_POST['choix']) && $_POST['choix'] === 'monsters') echo ' selected'; ?>>Monstres</option>
                    <option value="items"<?php if (!empty($_POST['choix']) && $_POST['choix'] === 'items') echo ' selected'; ?>>Objets</option>
                    <option value="class"<?php if (!empty($_POST['choix']) && $_POST['choix'] === 'class') echo ' selected'; ?>>Classes</option>
                    <option value="level"<?php if (!empty($_POST['choix']) && $_POST['choix'] === 'level') echo ' selected'; ?>>Niveaux</option>
                </select>
            </form>
            <div class="row mb-3">
                <div class="col"></div>
                <div class="col-6 mb-3">
                    <?php
                    if (!empty($_POST['choix'])){
                        switch($_POST['choix']){
                            case 'users':
                            $stmt = $db->prepare('SELECT id, pseudo FROM user');
                            $stmt->execute();
                            $row = $stmt->fetchall(PDO::FETCH_ASSOC);
                            echo '<a href="CreerUser.php" class="btn btn-primary mb-3">Ajouter un utilisateur</a>
                            <ul class="list-group">';
                            foreach ($row as $user) {
                                echo '
                                <li class="list-group-item align-items-center text-center">
                                    id: '.$user['id'].
                                    ', pseudo: '.$user['pseudo'].
                                    '<br>
                                    <form method="POST">
                                        <button type="submit" name="BouttonSupprimerUser" value="'.$user['id'].'" class="btn btn-danger">supprimer</button>
                                        <button type="submit" name="BouttonModifierUser" class="btn btn-success">modifier</button>
                                    </form>
                                </li>';
                            }
                            echo "</ul>";
                            break;
                        case 'chapters':
                            $stmt = $db->prepare('SELECT id,title,content FROM chapter');
                            $stmt->execute();
                            $row = $stmt->fetchall(PDO::FETCH_ASSOC);
                            echo '<a href="CreerChapter.php" class="btn btn-primary mb-3">Ajouter un chapitre</a>
                            <ul class="list-group">';
                            foreach ($row as $chapter) {
                                echo '
                                <li class="list-group-item align-items-center text-center">
                                id: '.$chapter['id'].
                                ', titre: '.$chapter['title'].
                                ', contenu: '.$chapter['content'].
                                '<br>
                                    <form method="POST">
                                        <button type="submit" name="BouttonSupprimerChapter" value="'.$chapter['id'].'" class="btn btn-danger">supprimer</button>
                                        <button type="submit" name="BouttonModifierChapter" class="btn btn-success">modifier</button>
                                    </form>
                                </li>';
                            }
                            echo "</ul>";
                            break;
                        case 'monsters':
                            $stmt = $db->prepare('SELECT id,name,pv,mana,initiative,strength,attack,xp FROM monster');
                            $stmt->execute();
                            $row = $stmt->fetchall(PDO::FETCH_ASSOC);
                            echo '<a href="CreerMonster.php" class="btn btn-primary mb-3">Ajouter un monstre</a>
                            <ul class="list-group">';
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
                            break;
                        case 'items':
                            $stmt = $db->prepare('SELECT id,name,description,item_type FROM items');
                            $stmt->execute();
                            $row = $stmt->fetchall(PDO::FETCH_ASSOC);
                            echo '<a href="CreerItem.php" class="btn btn-primary mb-3">Ajouter un item</a>
                            <ul class="list-group">';
                            foreach ($row as $item) {
                                echo '
                                <li class="list-group-item align-items-center text-center">
                                id: '.$item['id'].
                                ', nom: '.$item['name'].
                                ', description: '.$item['description'].
                                ', type: '.$item['item_type'].
                                '<br>
                                    <form method="POST">
                                        <button type="submit" name="BouttonSupprimerItem" value="'.$item['id'].'" class="btn btn-danger">supprimer</button>
                                        <button type="submit" name="BouttonModifierItem" class="btn btn-success">modifier</button>
                                    </form>
                                </li>';
                            }
                            echo "</ul>";
                            break;
                        case 'class':
                            $stmt = $db->prepare('SELECT id, name, description, base_pv, base_mana, strength, initiative, max_items FROM class');
                            $stmt->execute();
                            $row = $stmt->fetchall(PDO::FETCH_ASSOC);
                            echo '<a href="CreerClass.php" class="btn btn-primary mb-3">Ajouter une classe</a>
                            <ul class="list-group">';
                            foreach ($row as $class) {
                                echo '
                                <li class="list-group-item align-items-center text-center">
                                id: '.$class['id'].
                                    ', nom: '.$class['name'].
                                    ', description: '.$class['description'].
                                    ', base_pv: '.$class['base_pv'].
                                    ', base_mana: '.$class['base_mana'].
                                    ', strength: '.$class['strength'].
                                    ', initiative: '.$class['initiative'].
                                    ', max_items: '.$class['max_items'].
                                    '<br>
                                    <form method="POST">
                                        <button type="submit" name="BouttonSupprimerClass" value="'.$class['id'].'" class="btn btn-danger">supprimer</button>
                                        <button type="submit" name="BouttonModifierClass" class="btn btn-success">modifier</button>
                                    </form>
                                </li>';
                            }
                            echo "</ul>";
                            break;
                        case 'level':
                            $stmt = $db->prepare('SELECT id, class_id, level, required_xp, pv_bonus, mana_bonus, strength_bonus, initiative_bonus FROM level');
                            $stmt->execute();
                            $row = $stmt->fetchall(PDO::FETCH_ASSOC);
                            echo '<a href="CreerLevel.php" class="btn btn-primary mb-3">Ajouter un niveau</a>
                            <ul class="list-group">';
                            foreach ($row as $level) {
                                echo '
                                <li class="list-group-item align-items-center text-center">
                                    id: '.$level['id'].
                                    ', class_id: '.$level['class_id'].
                                    ', level: '.$level['level'].
                                    ', required_xp: '.$level['required_xp'].
                                    ', pv_bonus: '.$level['pv_bonus'].
                                    ', mana_bonus: '.$level['mana_bonus'].
                                    ', strength_bonus: '.$level['strength_bonus'].
                                    ', initiative_bonus: '.$level['initiative_bonus'].
                                    '<br>
                                    <form method="POST">
                                        <button type="submit" name="BouttonSupprimerLevel" value="'.$level['id'].'" class="btn btn-danger">supprimer</button>
                                        <button type="submit" name="BouttonModifierLevel" class="btn btn-success">modifier</button>
                                    </form>
                                </li>';
                            }
                            echo "</ul>";
                            break;
                        }
                    }
                     else if(!empty($_POST['BouttonSupprimerUser'])){
                        deleteUser($_POST['BouttonSupprimerUser']);
                    }
                    else if(!empty($_POST['BouttonSupprimerChapter'])){
                        deleteChapter($_POST['BouttonSupprimerChapter']);
                    }
                    else if(!empty($_POST['BouttonSupprimerMonster'])){
                        deleteMonster($_POST['BouttonSupprimerMonster']);
                    }
                    else if(!empty($_POST['BouttonSupprimerItem '])){
                        deleteItem($_POST['BouttonSupprimerItem']);
                    }
                    else if(!empty($_POST['BouttonSupprimerClass'])){
                        deleteClass($_POST['BouttonSupprimerClass']);
                    }
                    else if(!empty($_POST['BouttonSupprimerLevel'])){
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