-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : ven. 21 nov. 2025 à 14:26
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `dungeonxplorer`
--

-- --------------------------------------------------------

--
-- Structure de la table `appartenir`
--

CREATE TABLE `appartenir` (
  `id_user` int(11) NOT NULL,
  `id_hero` int(11) NOT NULL,
  `derniere_utilisation` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `chapter`
--

CREATE TABLE `chapter` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `chapter`
--

INSERT INTO `chapter` (`id`, `title`, `content`, `image`) VALUES
(1, "Introduction", "Le ciel est lourd sur le village du Val Perdu. Le bourgmestre vous demande de retrouver sa fille, disparue dans la forêt, où l'on raconte qu'un sorcier vit dans un château en ruines. La quête commence.", NULL),
(2, "L'orée de la forêt", "Vous franchissez la lisière des arbres. Deux chemins s'offrent à vous : l'un sinueux, bordé de vieux arbres noueux ; l'autre droit mais envahi par des ronces épaisses.", NULL),
(3, "L'arbre aux corbeaux", "Votre choix vous mène devant un vieux chêne grouillant de corbeaux. Des traces de pas légers mènent plus loin. Un bruit de pas feutrés se fait entendre.", NULL),
(4, "Le sanglier enragé", "Le calme est brisé par un grognement. Un énorme sanglier enragé surgit et vous charge.", NULL),
(5, "Rencontre avec le paysan", "Une voix humaine s'élève. Vous tombez sur un vieux paysan accroupi près de champignons. Il vous avertit que la nuit, des cris terrifiants retentissent.", NULL),
(6, "Le loup noir", "Une silhouette sombre s'élance devant vous : un loup noir aux yeux perçants, prêt à bondir. Le combat est inévitable.", NULL),
(7, "La clairière aux pierres anciennes", "Vous atteignez une clairière étrange, entourée de pierres dressées. Une légère brume rampe au sol.", NULL),
(8, "Les murmures du ruisseau", "Vous arrivez près d'un petit ruisseau qui serpente au milieu des arbres. Des murmures étranges semblent émaner de la rive. Vous apercevez des inscriptions anciennes gravées dans une pierre moussue.", NULL),
(9, "Au pied du château", "La forêt se disperse. Devant vous se dresse une colline escarpée, et au sommet, le château en ruines. L'ancienne porte principale est barricadée. Vous repérez deux autres points d'entrée possibles.", NULL),
(10, "La lumière au bout du néant", "Le monde se dérobe sous vos pieds, et une obscurité profonde vous enveloppe. Une lueur douce apparaît au loin, et une voix murmure : 'Brave âme, ton chemin n'est pas achevé... À ceux qui échouent, une seconde chance est accordée'. Vous perdez votre équipement et vos armes.", NULL),
(11, "La curiosité tua le chat", "Qu'avez-vous fait, Malheureux !", NULL),
(12, "La Voix du Ruisseau", "Le contact avec la pierre est froid, les inscriptions s'illuminent. Une voix résonne, douce mais inintelligible.", NULL),
(13, "Le Secret de la Pierre", "Vous déchiffrez le message : Ne t'approche pas du Château si tu n'es pas prêt... Il y a un autre chemin, plus sûr, mais oublié... Le chemin sous les Racines Moussues.", NULL),
(14, "Le Passage Oublié", "Vous trouvez une ouverture étroite sous un vieux saule pleureur, masquée par des racines et de la mousse. L'air froid sent l'ancienneté.", NULL),
(15, "Les Souterrains du Sorcier", "Le passage s'ouvre sur une caverne sous le château. Des traces de pas légers s'enfoncent dans l'obscurité.", NULL),
(16, "L'Embuscade", "Vous êtes attaqué par un Gobelin des Profondeurs qui surgit de l'obscurité.", NULL),
(17, "La Réverbération", "La torche éclaire la caverne et vous permet de voir un piège à fosse que vous contournez. Les traces mènent à un escalier en colimaçon.", NULL),
(18, "La Crypte", "Vous arrivez dans une grande crypte. Au centre se trouve une cage de fer. À l'intérieur, la fille du bourgmestre est vivante mais faible. Le Sorcier est absent.", NULL),
(19, "Le Grimoire Interdit", "En fouillant, vous trouvez le Grimoire du Sorcier. Une note indique : Clé de la cage... dans la poche de la robe de mon disciple.", NULL),
(20, "Le Bruit Attire le Maître", "Le bruit du métal attire le Sorcier !", NULL),
(22, "Le Pouvoir du Rituel", "Vous trouvez et utilisez l'incantation dans le Grimoire. La serrure s'ouvre. La fille est libre et vous avertit que le Sorcier est dans la Tour Principale.", NULL),
(23, "Le Sorcier Arrive !", "Le Sorcier apparaît, furieux d'être interrompu. Il vous attaque immédiatement avec un puissant sort de sommeil.", NULL),
(24, "Le Dernier Étage", "Vous montez vers la Tour Principale. Le Sorcier est là, préparant son rituel. Il se retourne, vous maudit, et le combat commence.", NULL),
(25, "La Fuite Discrète", "Vous fuyez avec la fille. Vous la ramenez au Val Perdu. Le bourgmestre est reconnaissant, mais le Sorcier reste libre. Vous avez sauvé une vie, mais l'ombre plane toujours. (Fin Neutre)", NULL),
(26, "L'Épreuve de Force", "Vous attaquez directement, mais l'aura d'énergie noire du Sorcier vous brûle. Il vous projette contre le mur.", NULL),
(27, "L'Analyse", "Vous ignorez le Sorcier et repérez un cristal noir sur un piédestal : il canalise l'énergie du Sorcier.", NULL),
(28, "Le Coup Final", "Vous détruisez le cristal OU vous réussissez votre attaque finale. Le Sorcier s'écroule, son aura disparaît. Il est vaincu.", NULL),
(29, "La Chute", "Le Sorcier vous terrasse et vous laisse pour mort. Vous vous réveillez plus tard, faible. Le Sorcier s'est échappé, la fille est peut-être perdue. (Fin Mauvaise)", NULL),
(30, "Le Retour au Val Perdu (Victoire)", "Le Sorcier est vaincu. Vous retrouvez la fille et la ramenez au village. Le bourgmestre est reconnaissant. L'ombre est levée. (Fin Bonne)", NULL),
(31, "La Brèche dans le Mur Ouest", "Vous entrez dans l'aile ouest. L'air sent le vieux parchemin moisi. Le couloir mène à deux portes.", NULL),
(32, "La Porte Dérobée", "Alors que vous êtes concentré sur la serrure de la porte dérobée, une chauve-souris anormale, de la taille d'un petit chien et rendue agressive par la magie noire, vous attaque depuis les hauteurs du château. C'est une menace rapide qui force le joueur à agir immédiatement.", NULL),
(33, "La Bibliothèque Interdite", "Vous entrez. Des milliers de livres. Vous trouvez un journal de bord du Sorcier : La clé pour entrer dans la Tour est le sceau en Ténèbre-Pierre que seul mon disciple connaît. La porte se referme et est verrouillée !", NULL),
(34, "Les Cachots Rouillés", "Vous descendez dans les cachots. Les cellules sont vides. Un Disciple Déchu du Sorcier, devenu fou, vous attaque !", NULL),
(35, "Le Bruit de la Rupture", "Vous forcez la serrure. Elle cède dans un claquement sonore qui alerte les gardiens. Un grognement se fait entendre.", NULL),
(36, "L'Art du Crochetage", "Vous crochetez la serrure en silence. Vous entrez dans une petite salle d'armes désaffectée dans la Tour Principale.", NULL),
(37, "L'Évasion de la Bibliothèque", "Vous trouvez une petite fenêtre cachée derrière une étagère. Elle donne sur une gouttière menant au toit de la Tour Ouest. Le Spectre flotte entre vous et la fenêtre. Il ne vous attaque pas, mais son contact glace le sang, vous empêchant d'avancer.", NULL),
(38, "L'Énigme du Pupitre", "Le livre est un journal. Il indique : Le mot de passe pour le Sceau est \"RAVEN\", inscrit au dos de la Ténèbre-Pierre.", NULL),
(39, "La Récompense du Vainqueur", "Après avoir vaincu le disciple, vous fouillez son corps. Vous trouvez un petit Sceau en Ténèbre-Pierre et une Clé en Fer (la clé de la cage, mentionnée au Chapitre 19).", NULL),
(40, "Le Chien de Garde Squelette", "Le grognement venait d'un Chien de Garde Squelette qui vous bloque le chemin dans le couloir de la Tour. Le combat est immédiat.", NULL),
(41, "Le Couloir de la Tour", "Vous êtes dans un couloir en spirale, menant vers le haut. Il n'y a qu'une seule voie possible : l'escalier vers le sommet. Une Gargouille de pierre postée au-dessus de la porte prend vie. Ses yeux s'allument. Elle lâche un rugissement qui ébranle la tour.", NULL),
(42, "Le Toit et la Tempête", "La gouttière vous mène sur le toit. Le vent est violent. Une porte mène à l'intérieur, mais elle est scellée par le Sceau de Ténèbre-Pierre (mentionné au Chapitre 33).", NULL),
(43, "L'Avertissement Final", "Vous avez le mot de passe. Le journal vous a fait perdre trop de temps. Des gardes vous ont repéré !", NULL),
(44, "Le Piège", "Vous continuez l'exploration. Vous tombez dans une oubliette piégée. Impossible de remonter seul.", NULL),
(45, "Accès au Sommet", "Vous placez le Sceau sur la porte, dites le mot de passe \"RAVEN\", et la porte s'ouvre. Vous êtes dans les quartiers privés du Sorcier.", NULL);

-- --------------------------------------------------------

--
-- Structure de la table `chapter_treasure`
--

CREATE TABLE `chapter_treasure` (
  `id` int(11) NOT NULL,
  `chapter_id` int(11) DEFAULT NULL,
  `item_id` int(11) DEFAULT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `class`
--

CREATE TABLE `class` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `description` text DEFAULT NULL,
  `base_pv` int(11) NOT NULL,
  `base_mana` int(11) NOT NULL,
  `strength` int(11) NOT NULL,
  `initiative` int(11) NOT NULL,
  `max_items` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `class`
--

INSERT INTO `class` (`id`, `name`, `description`, `base_pv`, `base_mana`, `strength`, `initiative`, `max_items`) VALUES
(1, 'Voleur', 'Un assassin agile qui frappe vite et disparaît dans les ombres', 18, 8, 6, 10, 4),
(2, 'Bourin', 'Un guerrier brutal et impitoyable doué d une force extraordinaire', 35, 3, 14, 3, 6),
(3, 'Mage', 'Un utilisateur de magie capable de puissants sorts dévastateurs', 15, 25, 3, 6, 4);

-- --------------------------------------------------------

--
-- Structure de la table `encounter`
--

CREATE TABLE `encounter` (
  `id` int(11) NOT NULL,
  `chapter_id` int(11) DEFAULT NULL,
  `monster_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `encounter`
--

INSERT INTO `encounter` (`id`, `chapter_id`, `monster_id`) VALUES
(1, 4, 1),
(2, 6, 2);

-- --------------------------------------------------------

--
-- Structure de la table `hero`
--

CREATE TABLE `hero` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `class_id` int(11) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `biography` text DEFAULT NULL,
  `pv` int(11) NOT NULL,
  `mana` int(11) NOT NULL,
  `strength` int(11) NOT NULL,
  `initiative` int(11) NOT NULL,
  `armor_item_id` int(11) DEFAULT NULL,
  `primary_weapon_item_id` int(11) DEFAULT NULL,
  `secondary_weapon_item_id` int(11) DEFAULT NULL,
  `shield_item_id` int(11) DEFAULT NULL,
  `spell_list` text DEFAULT NULL,
  `xp` int(11) NOT NULL,
  `current_level` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `hero_progress`
--

CREATE TABLE `hero_progress` (
  `id` int(11) NOT NULL,
  `hero_id` int(11) DEFAULT NULL,
  `chapter_id` int(11) DEFAULT NULL,
  `status` varchar(20) DEFAULT 'Completed',
  `completion_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `inventory`
--

CREATE TABLE `inventory` (
  `id` int(11) NOT NULL,
  `hero_id` int(11) DEFAULT NULL,
  `item_id` int(11) DEFAULT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `items`
--

CREATE TABLE `items` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `description` text DEFAULT NULL,
  `item_type` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


-- Ajouter les potions de base
INSERT INTO `items` (`id`, `name`, `description`, `item_type`) VALUES
(1, 'Potion', 'Restaure 15 points de vie', 'potion_pv');
-- --------------------------------------------------------

--
-- Structure de la table `level`
--

CREATE TABLE `level` (
  `id` int(11) NOT NULL,
  `class_id` int(11) DEFAULT NULL,
  `level` int(11) NOT NULL,
  `required_xp` int(11) NOT NULL,
  `pv_bonus` int(11) NOT NULL,
  `mana_bonus` int(11) NOT NULL,
  `strength_bonus` int(11) NOT NULL,
  `initiative_bonus` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `links`
--

CREATE TABLE `links` (
  `id` int(11) NOT NULL,
  `chapter_id` int(11) DEFAULT NULL,
  `next_chapter_id` int(11) DEFAULT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `links`
--

INSERT INTO `links` (`id`, `chapter_id`, `next_chapter_id`, `description`) VALUES
(1, 1, 2, "Commencer l'aventure"),
(2, 2, 3, "Emprunter le chemin sinueux"),
(3, 2, 4, "Emprunter le sentier couvert de ronces"),
(4, 3, 5, "Rester prudent"),
(5, 3, 6, "Ignorer les bruits et poursuivre"),
(6, 4, 8, "Victoire contre le sanglier"),
(7, 4, 10, "Défaite"),
(8, 5, 7, "Continuer après avoir parlé au paysan"),
(9, 6, 7, "Victoire contre le loup"),
(10, 6, 10, "Défaite"),
(11, 7, 8, "Prendre le sentier couvert de mousse"),
(12, 7, 9, "Suivre le chemin tortueux à travers les racines"),
(13, 8, 12, "Toucher la pierre gravée"),
(14, 8, 9, "Ignorer et poursuivre"),
(15, 9, 31, "Emprunter la brèche dans le mur ouest"),
(16, 9, 32, "Emprunter l'escalier vers la Tour principale"),
(17, 10, 1, "Reprendre l'aventure depuis le début"),
(18, 11, 10, "Se rendre au chapitre 10"),
(19, 12, 13, "Essayer de comprendre les murmures"),
(20, 12, 9, "Se retirer, inquiet"),
(21, 13, 14, "Chercher le chemin sous les Racines Moussues"),
(22, 13, 9, "Ignorer l'avertissement et aller au château"),
(23, 14, 15, "S'engager dans le tunnel"),
(24, 14, 9, "Préférer le château"),
(25, 15, 16, "Suivre les traces dans les ténèbres"),
(26, 15, 17, "Utiliser une torche"),
(27, 16, 18, "Vaincre le Gobelin"),
(28, 16, 10, "Ne pas survivre"),
(29, 17, 18, "Poursuivre vers la crypte"),
(30, 18, 19, "Chercher la clé de la cage"),
(31, 18, 20, "Tenter de briser la serrure"),
(32, 19, 22, "Utiliser le Grimoire"),
(33, 19, 34, "Chercher le disciple"),
(34, 20, 23, "Le Sorcier arrive"),
(35, 22, 24, "Affronter le Sorcier"),
(36, 22, 25, "S'enfuir avec la fille"),
(37, 23, 26, "Résister au sort"),
(38, 23, 29, "Perdre connaissance"),
(39, 24, 26, "Attaquer le Sorcier directement"),
(40, 24, 27, "Chercher un point faible"),
(41, 26, 28, "Se relever"),
(42, 26, 29, "Perdre connaissance"),
(43, 27, 28, "Poursuivre le plan d'attaque"),
(44, 28, 30, "Retour victorieux"),
(45, 29, 10, "Retour au néant"),
(46, 31, 33, "Emprunter la porte de la Bibliothèque"),
(47, 31, 34, "Emprunter la grille vers les Cachots"),
(48, 32, 35, "Forcer la serrure"),
(49, 32, 36, "Crocheter la serrure en silence"),
(50, 32, 10, "Vaincu par la Chauve-souris"),
(51, 33, 37, "Chercher un moyen de sortir"),
(52, 33, 38, "Examiner le livre plus en détail"),
(53, 34, 39, "Vaincre le Disciple Déchu"),
(54, 34, 10, "Combat fatal"),
(55, 35, 40, "Le bruit attire le gardien"),
(56, 36, 41, "Accès à la Tour"),
(57, 37, 42, "Repousser le Spectre"),
(58, 37, 38, "Chercher une autre sortie"),
(59, 38, 40, "Les gardes arrivent"),
(60, 39, 18, "Retourner à la Crypte"),
(61, 39, 44, "Continuer à explorer"),
(62, 40, 41, "Vaincre le Chien de Garde"),
(63, 40, 10, "Vaincu par le Chien"),
(64, 41, 24, "Vaincre la Gargouille"),
(65, 41, 10, "Vaincu par la Gargouille"),
(66, 42, 45, "Utiliser le Sceau et le mot de passe"),
(67, 42, 34, "Faire demi-tour chercher le disciple"),
(68, 43, 40, "Confrontation avec les gardes"),
(69, 44, 10, "Tomber dans l'oubliette"),
(70, 45, 24, "Confrontation finale");

-- --------------------------------------------------------

--
-- Structure de la table `monster`
--

CREATE TABLE `monster` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `pv` int(11) NOT NULL,
  `mana` int(11) DEFAULT NULL,
  `initiative` int(11) NOT NULL,
  `strength` int(11) NOT NULL,
  `attack` text DEFAULT NULL,
  `xp` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `monster`
--

INSERT INTO `monster` (`id`, `name`, `pv`, `mana`, `initiative`, `strength`, `attack`, `xp`) VALUES
(1, 'Sanglier enragé', 20, 0, 5, 6, 'Charge furieuse', 15),
(2, 'Loup noir', 15, 0, 7, 5, 'Morsure', 12);

-- --------------------------------------------------------

--
-- Structure de la table `monster_loot`
--

CREATE TABLE `monster_loot` (
  `id` int(11) NOT NULL,
  `monster_id` int(11) DEFAULT NULL,
  `item_id` int(11) DEFAULT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `drop_rate` decimal(5,2) DEFAULT 1.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `pseudo` text NOT NULL,
  `password` text NOT NULL,
  `is_admin` boolean NOT NULL DEFAULT false
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `chapter`
--
ALTER TABLE `chapter`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `chapter_treasure`
--
ALTER TABLE `chapter_treasure`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `chapter_id` (`chapter_id`,`item_id`),
  ADD KEY `item_id` (`item_id`);

--
-- Index pour la table `class`
--
ALTER TABLE `class`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `encounter`
--
ALTER TABLE `encounter`
  ADD PRIMARY KEY (`id`),
  ADD KEY `chapter_id` (`chapter_id`),
  ADD KEY `monster_id` (`monster_id`);

--
-- Index pour la table `hero`
--
ALTER TABLE `hero`
  ADD PRIMARY KEY (`id`),
  ADD KEY `class_id` (`class_id`),
  ADD KEY `armor_item_id` (`armor_item_id`),
  ADD KEY `primary_weapon_item_id` (`primary_weapon_item_id`),
  ADD KEY `secondary_weapon_item_id` (`secondary_weapon_item_id`),
  ADD KEY `shield_item_id` (`shield_item_id`);

--
-- Index pour la table `hero_progress`
--
ALTER TABLE `hero_progress`
  ADD PRIMARY KEY (`id`),
  ADD KEY `hero_id` (`hero_id`),
  ADD KEY `chapter_id` (`chapter_id`);

--
-- Index pour la table `inventory`
--
ALTER TABLE `inventory`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `hero_id` (`hero_id`,`item_id`),
  ADD KEY `item_id` (`item_id`);

--
-- Index pour la table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `level`
--
ALTER TABLE `level`
  ADD PRIMARY KEY (`id`),
  ADD KEY `class_id` (`class_id`);

--
-- Index pour la table `links`
--
ALTER TABLE `links`
  ADD PRIMARY KEY (`id`),
  ADD KEY `chapter_id` (`chapter_id`),
  ADD KEY `next_chapter_id` (`next_chapter_id`);

--
-- Index pour la table `monster`
--
ALTER TABLE `monster`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `monster_loot`
--
ALTER TABLE `monster_loot`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `monster_id` (`monster_id`,`item_id`),
  ADD KEY `item_id` (`item_id`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `chapter`
--
ALTER TABLE `chapter`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT pour la table `chapter_treasure`
--
ALTER TABLE `chapter_treasure`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `class`
--
ALTER TABLE `class`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `encounter`
--
ALTER TABLE `encounter`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `hero`
--
ALTER TABLE `hero`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `hero_progress`
--
ALTER TABLE `hero_progress`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `inventory`
--
ALTER TABLE `inventory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `items`
--
ALTER TABLE `items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `level`
--
ALTER TABLE `level`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `links`
--
ALTER TABLE `links`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT pour la table `monster`
--
ALTER TABLE `monster`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `monster_loot`
--
ALTER TABLE `monster_loot`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `chapter_treasure`
--
ALTER TABLE `chapter_treasure`
  ADD CONSTRAINT `chapter_treasure_ibfk_1` FOREIGN KEY (`chapter_id`) REFERENCES `chapter` (`id`),
  ADD CONSTRAINT `chapter_treasure_ibfk_2` FOREIGN KEY (`item_id`) REFERENCES `items` (`id`);

--
-- Contraintes pour la table `encounter`
--
ALTER TABLE `encounter`
  ADD CONSTRAINT `encounter_ibfk_1` FOREIGN KEY (`chapter_id`) REFERENCES `chapter` (`id`),
  ADD CONSTRAINT `encounter_ibfk_2` FOREIGN KEY (`monster_id`) REFERENCES `monster` (`id`);

--
-- Contraintes pour la table `hero`
--
ALTER TABLE `hero`
  ADD CONSTRAINT `hero_ibfk_1` FOREIGN KEY (`class_id`) REFERENCES `class` (`id`),
  ADD CONSTRAINT `hero_ibfk_2` FOREIGN KEY (`armor_item_id`) REFERENCES `items` (`id`),
  ADD CONSTRAINT `hero_ibfk_3` FOREIGN KEY (`primary_weapon_item_id`) REFERENCES `items` (`id`),
  ADD CONSTRAINT `hero_ibfk_4` FOREIGN KEY (`secondary_weapon_item_id`) REFERENCES `items` (`id`),
  ADD CONSTRAINT `hero_ibfk_5` FOREIGN KEY (`shield_item_id`) REFERENCES `items` (`id`);

--
-- Contraintes pour la table `hero_progress`
--
ALTER TABLE `hero_progress`
  ADD CONSTRAINT `hero_progress_ibfk_1` FOREIGN KEY (`hero_id`) REFERENCES `hero` (`id`),
  ADD CONSTRAINT `hero_progress_ibfk_2` FOREIGN KEY (`chapter_id`) REFERENCES `chapter` (`id`);

--
-- Contraintes pour la table `inventory`
--
ALTER TABLE `inventory`
  ADD CONSTRAINT `inventory_ibfk_1` FOREIGN KEY (`hero_id`) REFERENCES `hero` (`id`),
  ADD CONSTRAINT `inventory_ibfk_2` FOREIGN KEY (`item_id`) REFERENCES `items` (`id`);

--
-- Contraintes pour la table `level`
--
ALTER TABLE `level`
  ADD CONSTRAINT `level_ibfk_1` FOREIGN KEY (`class_id`) REFERENCES `class` (`id`);

--
-- Contraintes pour la table `links`
--
ALTER TABLE `links`
  ADD CONSTRAINT `links_ibfk_1` FOREIGN KEY (`chapter_id`) REFERENCES `chapter` (`id`),
  ADD CONSTRAINT `links_ibfk_2` FOREIGN KEY (`next_chapter_id`) REFERENCES `chapter` (`id`);

--
-- Contraintes pour la table `monster_loot`
--
ALTER TABLE `monster_loot`
  ADD CONSTRAINT `monster_loot_ibfk_1` FOREIGN KEY (`monster_id`) REFERENCES `monster` (`id`),
  ADD CONSTRAINT `monster_loot_ibfk_2` FOREIGN KEY (`item_id`) REFERENCES `items` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;