<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$isLoggedIn = isset($_SESSION['user_id']);
$userId = $_SESSION['user_id'] ?? null;
$userPseudo = $_SESSION['user_pseudo'] ?? null;
$isAdmin = $_SESSION['is_admin'] ?? false;
?>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand fw-bold" href="<?= base_url('/') ?>">
            Dungeon Explorer
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <?php if (!$isLoggedIn): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('/login') ?>">Se Connecter</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('/register') ?>">S'inscrire</a>
                    </li>

                <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('/game') ?>">
                            <i class="fas fa-play-circle"></i> Reprendre la partie
                        </a>
                    </li>

                    <li class="nav-item dropdown">
                        <button class="nav-link dropdown-toggle border-0 bg-transparent" type="button" id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-user-circle"></i> <?= htmlspecialchars($userPseudo ?? 'Compte') ?>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-dark dropdown-menu-end" aria-labelledby="profileDropdown">
                            <li><a class="dropdown-item" href="<?= base_url('/profile') ?>">
                                <i class="fas fa-user"></i> Mon Profil
                            </a></li>
                            
                            <?php if ($isAdmin): ?>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="<?= base_url('/admin/panel') ?>">
                                    <i class="fas fa-tachometer-alt"></i> Panel Admin
                                </a></li>
                                <li><a class="dropdown-item" href="<?= base_url('/admin/users') ?>">
                                    <i class="fas fa-users"></i> Gestion Utilisateurs
                                </a></li>
                                <li><a class="dropdown-item" href="<?= base_url('/admin/chapters') ?>">
                                    <i class="fas fa-book"></i> Gestion Chapitres
                                </a></li>
                            <?php endif; ?>
                            
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="GET" action="<?= base_url('/logout') ?>" class="m-0">
                                    <button type="submit" class="dropdown-item text-danger w-100 text-start">
                                        <i class="fas fa-sign-out-alt"></i> Se déconnecter
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>
