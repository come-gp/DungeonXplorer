<?php

session_start();

if (!isset($_SESSION['user_id'])) {
    $_SESSION['user_id'] = 1;
}

/*
if (!isset($_SESSION['user_id'])) {
    header('Location: ../login/login.php');
    exit;
}
*/

require_once '../php/exemples/Database.php';

$user_id = $_SESSION['user_id'];
$success_message = '';
$error_message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_profile'])) {
    $new_pseudo = trim($_POST['pseudo']);
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    try {
        $stmt = $db->prepare("SELECT password FROM user WHERE id = ?");
        $stmt->execute([$user_id]);
        $user_data = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!password_verify($current_password, $user_data['password'])) {
            $error_message = "Le mot de passe actuel est incorrect.";
        } 

        elseif (empty($new_pseudo) || strlen($new_pseudo) < 3) {
            $error_message = "Le pseudo doit contenir au moins 3 caractères.";
        }

        elseif (!empty($new_password)) {
            if (strlen($new_password) < 6) {
                $error_message = "Le nouveau mot de passe doit contenir au moins 6 caractères.";
            } elseif ($new_password !== $confirm_password) {
                $error_message = "Les mots de passe ne correspondent pas.";
            } else {
                $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
                $stmt = $db->prepare("UPDATE user SET pseudo = ?, password = ? WHERE id = ?");
                $stmt->execute([$new_pseudo, $hashed_password, $user_id]);
                $success_message = "Profil et mot de passe modifiés avec succès !";
            }
        } else {
            $stmt = $db->prepare("UPDATE user SET pseudo = ? WHERE id = ?");
            $stmt->execute([$new_pseudo, $user_id]);
            $success_message = "Profil modifié avec succès !";
        }
    } catch (PDOException $e) {
        $error_message = "Erreur lors de la modification : " . $e->getMessage();
    }
}

try {
    $stmt = $db->prepare("SELECT id, pseudo FROM user WHERE id = ?");
    $stmt->execute([$user_id]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        $stmt = $db->prepare("INSERT INTO user (id, pseudo, password) VALUES (1, 'Utilisateur Test', ?)");
        $stmt->execute([password_hash('test123', PASSWORD_DEFAULT)]);
        
        $stmt = $db->prepare("SELECT id, pseudo FROM user WHERE id = ?");
        $stmt->execute([$user_id]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
    }

    $stmt = $db->prepare("SELECT COUNT(*) as total FROM appartenir WHERE id_user = ?");
    $stmt->execute([$user_id]);
    $hero_count = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

    $stmt = $db->prepare("
        SELECT 
            h.id,
            h.name AS hero_name,
            h.pv,
            h.mana,
            h.strength,
            h.xp,
            h.current_level,
            h.image,
            c.name AS class_name,
            a.derniere_utilisation,
            (SELECT COUNT(*) 
             FROM hero_progress 
             WHERE hero_id = h.id) AS chapters_completed,
            (SELECT chapter_id 
             FROM hero_progress 
             WHERE hero_id = h.id 
             ORDER BY completion_date DESC 
             LIMIT 1) AS last_chapter_id,
            (SELECT content 
             FROM chapter 
             WHERE id = (SELECT chapter_id 
                        FROM hero_progress 
                        WHERE hero_id = h.id 
                        ORDER BY completion_date DESC 
                        LIMIT 1)
             LIMIT 1) AS last_chapter_content
        FROM hero h
        INNER JOIN appartenir a ON h.id = a.id_hero
        LEFT JOIN class c ON h.class_id = c.id
        WHERE a.id_user = ?
        ORDER BY a.derniere_utilisation DESC
    ");
    $stmt->execute([$user_id]);
    $heroes = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    $error_message = "Erreur lors de la récupération des données : " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Profil - DungeonXplorer</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
        }

        .profile-avatar {
            width: 100%;
            aspect-ratio: 1;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 120px;
            color: white;
            border-radius: 12px 12px 0 0;
        }

        .party-card {
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .party-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 16px rgba(0,0,0,0.2);
        }

        .level-badge {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .stat-icon {
            width: 35px;
            height: 35px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
        }

        .sticky-sidebar {
            position: sticky;
            top: 20px;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-dark bg-dark shadow-sm mb-4">
        <div class="container-fluid">
            <span class="navbar-brand mb-0 h1">
                <i class="bi bi-controller"></i> DungeonXplorer
            </span>
            <a href="../index.php" class="btn btn-outline-light btn-sm">
                <i class="bi bi-house-door"></i> Accueil
            </a>
        </div>
    </nav>

    <div class="container py-4">
        <div class="row g-4">
            <div class="col-lg-3">
                <div class="sticky-sidebar">
                    <div class="card shadow">
                        <div class="profile-avatar">
                            <i class="bi bi-person-circle"></i>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title fw-bold mb-1"><?php echo htmlspecialchars($user['pseudo']); ?></h5>
                            <p class="text-muted small mb-3">@<?php echo htmlspecialchars($user['pseudo']); ?></p>
                            
                            <button class="btn btn-primary w-100 mb-2" data-bs-toggle="modal" data-bs-target="#editModal">
                                <i class="bi bi-pencil-square"></i> Modifier le profil
                            </button>
                            <a href="logout.php" class="btn btn-danger w-100">
                                <i class="bi bi-box-arrow-right"></i> Déconnexion
                            </a>
                        </div>
                        <div class="card-footer bg-light">
                            <div class="d-flex justify-content-center align-items-center gap-2">
                                <i class="bi bi-person-badge"></i>
                                <strong><?php echo $hero_count; ?></strong>
                                <span class="text-muted">héros</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-9">
                <?php if ($success_message): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="bi bi-check-circle"></i> <?php echo htmlspecialchars($success_message); ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <?php if ($error_message): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="bi bi-exclamation-triangle"></i> <?php echo htmlspecialchars($error_message); ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h2 class="h4 mb-0 text-white">
                        <i class="bi bi-sword"></i> Mes Parties
                    </h2>
                    <div class="input-group" style="max-width: 300px;">
                        <span class="input-group-text"><i class="bi bi-search"></i></span>
                        <input type="text" class="form-control" id="searchInput" placeholder="Rechercher un héros..." onkeyup="filterHeroes()">
                    </div>
                </div>

                <?php if (empty($heroes)): ?>
                    <div class="card shadow text-center py-5">
                        <div class="card-body">
                            <i class="bi bi-person-plus display-1 text-muted"></i>
                            <h3 class="mt-3">Aucun héros pour le moment</h3>
                            <p class="text-muted mb-4">Créez votre premier héros et commencez votre aventure !</p>
                            <a href="../game/create-hero.php" class="btn btn-primary btn-lg">
                                <i class="bi bi-plus-circle"></i> Créer un héros
                            </a>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="row row-cols-1 g-3">
                        <?php foreach ($heroes as $hero): ?>
                            <div class="col" data-hero-name="<?php echo strtolower(htmlspecialchars($hero['hero_name'])); ?>">
                                <div class="card shadow party-card h-100">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-start mb-3">
                                            <div>
                                                <h5 class="card-title mb-1">
                                                    <i class="bi bi-person-badge-fill text-primary"></i>
                                                    <?php echo htmlspecialchars($hero['hero_name']); ?>
                                                    <span class="badge level-badge text-white ms-2">
                                                        Niv. <?php echo $hero['current_level']; ?>
                                                    </span>
                                                </h5>
                                                <p class="text-muted small mb-0">
                                                    <i class="bi bi-shield-fill"></i>
                                                    <?php echo $hero['class_name'] ? htmlspecialchars($hero['class_name']) : 'Sans classe'; ?>
                                                </p>
                                            </div>
                                        </div>

                                        <div class="row g-2 mb-3">
                                            <div class="col-6 col-md-3">
                                                <div class="d-flex align-items-center gap-2">
                                                    <div class="stat-icon bg-danger bg-opacity-25 text-danger">
                                                        <i class="bi bi-heart-fill"></i>
                                                    </div>
                                                    <div>
                                                        <small class="text-muted d-block">PV</small>
                                                        <strong><?php echo $hero['pv']; ?></strong>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-6 col-md-3">
                                                <div class="d-flex align-items-center gap-2">
                                                    <div class="stat-icon bg-primary bg-opacity-25 text-primary">
                                                        <i class="bi bi-star-fill"></i>
                                                    </div>
                                                    <div>
                                                        <small class="text-muted d-block">Mana</small>
                                                        <strong><?php echo $hero['mana']; ?></strong>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-6 col-md-3">
                                                <div class="d-flex align-items-center gap-2">
                                                    <div class="stat-icon bg-warning bg-opacity-25 text-warning">
                                                        <i class="bi bi-lightning-fill"></i>
                                                    </div>
                                                    <div>
                                                        <small class="text-muted d-block">Force</small>
                                                        <strong><?php echo $hero['strength']; ?></strong>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-6 col-md-3">
                                                <div class="d-flex align-items-center gap-2">
                                                    <div class="stat-icon bg-success bg-opacity-25 text-success">
                                                        <i class="bi bi-trophy-fill"></i>
                                                    </div>
                                                    <div>
                                                        <small class="text-muted d-block">XP</small>
                                                        <strong><?php echo $hero['xp']; ?></strong>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <?php if ($hero['last_chapter_id']): ?>
                                            <div class="alert alert-info mb-3">
                                                <h6 class="alert-heading mb-1">
                                                    <i class="bi bi-book"></i> Chapitre <?php echo $hero['last_chapter_id']; ?>
                                                </h6>
                                                <small class="d-block mb-1">
                                                    <?php echo $hero['chapters_completed']; ?> chapitre(s) complété(s)
                                                </small>
                                                <small class="text-muted">
                                                    <?php echo htmlspecialchars(substr($hero['last_chapter_content'], 0, 80)) . '...'; ?>
                                                </small>
                                            </div>
                                        <?php else: ?>
                                            <div class="alert alert-success mb-3">
                                                <i class="bi bi-stars"></i> <strong>Nouvelle aventure</strong> • Prêt à commencer
                                            </div>
                                        <?php endif; ?>

                                        <div class="d-flex justify-content-between align-items-center pt-3 border-top">
                                            <small class="text-muted">
                                                <i class="bi bi-clock"></i>
                                                <?php echo date('d/m/Y', strtotime($hero['derniere_utilisation'])); ?>
                                            </small>
                                            <div class="btn-group">
                                                <a href="../game/play.php?hero_id=<?php echo $hero['id']; ?>" class="btn btn-primary btn-sm">
                                                    <i class="bi bi-play-fill"></i> 
                                                    <?php echo $hero['last_chapter_id'] ? 'Reprendre' : 'Commencer'; ?>
                                                </a>
                                                <a href="../game/hero-details.php?id=<?php echo $hero['id']; ?>" class="btn btn-outline-secondary btn-sm">
                                                    <i class="bi bi-eye"></i> Détails
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="bi bi-pencil-square"></i> Modifier mon profil
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST" action="">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="pseudo" class="form-label">Pseudo</label>
                            <input 
                                type="text" 
                                class="form-control" 
                                id="pseudo" 
                                name="pseudo" 
                                value="<?php echo htmlspecialchars($user['pseudo']); ?>" 
                                required
                                minlength="3"
                            >
                            <div class="form-text">Minimum 3 caractères</div>
                        </div>

                        <div class="mb-3">
                            <label for="current_password" class="form-label">
                                Mot de passe actuel <span class="text-danger">*</span>
                            </label>
                            <input 
                                type="password" 
                                class="form-control" 
                                id="current_password" 
                                name="current_password" 
                                required
                                placeholder="Requis pour toute modification"
                            >
                            <div class="form-text">Requis pour confirmer votre identité</div>
                        </div>

                        <hr class="my-4">

                        <div class="mb-3">
                            <label for="new_password" class="form-label">Nouveau mot de passe (optionnel)</label>
                            <input 
                                type="password" 
                                class="form-control" 
                                id="new_password" 
                                name="new_password"
                                placeholder="Laisser vide pour ne pas changer"
                                minlength="6"
                            >
                            <div class="form-text">Minimum 6 caractères</div>
                        </div>

                        <div class="mb-3">
                            <label for="confirm_password" class="form-label">Confirmer le nouveau mot de passe</label>
                            <input 
                                type="password" 
                                class="form-control" 
                                id="confirm_password" 
                                name="confirm_password"
                                placeholder="Confirmer le nouveau mot de passe"
                            >
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" name="update_profile" class="btn btn-primary">
                            <i class="bi bi-save"></i> Enregistrer
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        function filterHeroes() {
            const input = document.getElementById('searchInput');
            const filter = input.value.toLowerCase();
            const cards = document.querySelectorAll('[data-hero-name]');

            cards.forEach(card => {
                const heroName = card.getAttribute('data-hero-name');
                if (heroName.includes(filter)) {
                    card.style.display = '';
                } else {
                    card.style.display = 'none';
                }
            });
        }

        <?php if ($error_message): ?>
            const editModal = new bootstrap.Modal(document.getElementById('editModal'));
            editModal.show();
        <?php endif; ?>
    </script>
</body>
</html>