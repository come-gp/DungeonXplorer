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
(1, "Introduction", "Le ciel est lourd sur le village du Val Perdu. Le bourgmestre vous demande de retrouver sa fille, disparue dans la forêt, où l'on raconte qu'un sorcier vit dans un château en ruines. La quête commence. Le bourgmestre vous confie tout ce qu'il lui reste : 2 potions", NULL),
(2, "L'orée de la forêt", "Vous franchissez la lisière des arbres. Deux chemins s'offrent à vous : l'un sinueux, bordé de vieux arbres noueux ; l'autre droit mais envahi par des ronces épaisses.", NULL),
(3, "L'arbre aux corbeaux", "Votre choix vous mène devant un vieux chêne grouillant de corbeaux. Des traces de pas légers mènent plus loin. Un bruit de pas feutrés se fait entendre.", NULL),
(4, "Le sanglier enragé", "Le calme est brisé par un grognement. Un énorme sanglier enragé surgit et vous charge.", NULL),
(5, "Après le sanglier", "Vous avez vaincu le sanglier. Épuisé, vous trouvez une petite clairière pour reprendre votre souffle. En fouillant les buissons, vous découvrez une potion de soin abandonnée.", NULL),
(6, "Rencontre avec le paysan", "Une voix humaine s'élève. Vous tombez sur un vieux paysan accroupi près de champignons. Il vous avertit que la nuit, des cris terrifiants retentissent.", NULL),
(7, "Le loup noir", "Une silhouette sombre s'élance devant vous : un loup noir aux yeux perçants, prêt à bondir. Le combat est inévitable.", NULL),
(8, "Après le loup", "Le loup gît à vos pieds. Vous continuez prudemment votre chemin à travers les arbres.", NULL),
(9, "La clairière aux pierres anciennes", "Vous atteignez une clairière étrange, entourée de pierres dressées. Une légère brume rampe au sol.", NULL),
(10, "Les murmures du ruisseau", "Vous arrivez près d'un petit ruisseau qui serpente au milieu des arbres. Des murmures étranges semblent émaner de la rive. Vous apercevez des inscriptions anciennes gravées dans une pierre moussue.", NULL),
(11, "La Voix du Ruisseau", "Le contact avec la pierre est froid, les inscriptions s'illuminent. Une voix résonne, douce mais inintelligible.", NULL),
(12, "Le Secret de la Pierre", "Vous déchiffrez le message : 'Ne t'approche pas du Château si tu n'es pas prêt... Il y a un autre chemin, plus sûr, mais oublié... Le chemin sous les Racines Moussues.'", NULL),
(13, "Le Passage Oublié", "Vous trouvez une ouverture étroite sous un vieux saule pleureur, masquée par des racines et de la mousse. L'air froid sent l'ancienneté.", NULL),
(14, "Les Souterrains du Sorcier", "Le passage s'ouvre sur une caverne sous le château. Des traces de pas légers s'enfoncent dans l'obscurité.", NULL),
(15, "L'Embuscade du Gobelin", "Un Gobelin des Profondeurs surgit de l'obscurité et vous attaque avec un cri strident.", NULL),
(16, "Après le Gobelin", "Le gobelin vaincu, vous avancez prudemment dans les souterrains. L'humidité colle à votre peau.", NULL),
(17, "La Réverbération", "Vous allumez une torche qui éclaire la caverne et révèle un piège à fosse que vous contournez. Les traces mènent à un escalier en colimaçon.", NULL),
(18, "La Crypte", "Vous arrivez dans une grande crypte. Au centre se trouve une cage de fer. À l'intérieur, la fille du bourgmestre est vivante mais faible. Le Sorcier est absent.", NULL),
(19, "Le Grimoire Interdit", "En fouillant, vous trouvez le Grimoire du Sorcier. Une note indique : 'Clé de la cage... dans la poche de la robe de mon disciple.'", NULL),
(20, "Le Bruit Attir  e le Maître", "Le bruit du métal résonne dans la crypte. Des pas lourds se font entendre au loin.", NULL),
(21, "Le Pouvoir du Rituel", "Vous trouvez et utilisez l'incantation dans le Grimoire. La serrure s'ouvre dans un clic magique. La fille est libre et vous avertit que le Sorcier est dans la Tour Principale.", NULL),
(22, "Au pied du château", "La forêt se disperse. Devant vous se dresse une colline escarpée, et au sommet, le château en ruines. L'ancienne porte principale est barricadée. Vous repérez deux autres points d'entrée possibles.", NULL),
(23, "La Brèche dans le Mur Ouest", "Vous entrez dans l'aile ouest. L'air sent le vieux parchemin moisi. Le couloir mène à deux portes.", NULL),
(24, "La Porte Dérobée", "Alors que vous êtes concentré sur la serrure de la porte dérobée, une chauve-souris géante, rendue agressive par la magie noire, vous attaque depuis les hauteurs.", NULL),
(25, "Après la chauve-souris", "Vous avez repoussé la créature ailée. La porte dérobée est maintenant accessible.", NULL),
(26, "L'Art du Crochetage", "Vous crochetez la serrure en silence. Vous entrez dans une petite salle d'armes désaffectée. Une vieille potion de soin repose sur une étagère.", NULL),
(27, "La Bibliothèque Interdite", "Vous entrez dans une vaste bibliothèque. Des milliers de livres poussiéreux. Vous trouvez un journal de bord du Sorcier. Soudain, la porte se referme avec fracas et se verrouille !", NULL),
(28, "Les Cachots Rouillés", "Vous descendez dans les cachots humides. Les cellules sont vides et silencieuses.", NULL),
(29, "Le Disciple Déchu", "Un Disciple Déchu du Sorcier, devenu fou, surgit d'une cellule et vous attaque avec rage.", NULL),
(30, "La Récompense du Vainqueur", "Après avoir vaincu le disciple, vous fouillez son corps. Vous trouvez un petit Sceau en Ténèbre-Pierre et une Clé en Fer. Vous pouvez maintenant retourner à la Crypte ou continuer l'exploration.", NULL),
(31, "L'Énigme du Pupitre", "Dans la bibliothèque, vous examinez le journal plus attentivement. Il indique : 'Le mot de passe pour le Sceau est RAVEN, inscrit au dos de la Ténèbre-Pierre.' Mais vous avez perdu du temps. Des bruits de pas se rapprochent.", NULL),
(32, "L'Évasion de la Bibliothèque", "Vous cherchez désespérément un moyen de sortir. Vous trouvez une petite fenêtre cachée derrière une étagère. Elle donne sur une gouttière menant au toit. Un Spectre flotte près de la fenêtre, vous barrant le passage.", NULL),
(33, "Le Toit et la Tempête", "La gouttière vous mène sur le toit battu par les vents. Une porte scellée par un mécanisme magique vous fait face. Vous devez avoir le Sceau de Ténèbre-Pierre pour l'ouvrir.", NULL),
(34, "Le Piège de l'Oubliette", "Vous explorez une salle adjacente. Le sol cède sous vos pieds ! Vous tombez dans une ancienne oubliette. Heureusement, la chute n'était pas trop haute et vous trouvez une échelle rouillée pour remonter, mais vous avez perdu du temps.", NULL),
(35, "Le Couloir de la Tour", "Vous êtes dans un couloir en spirale, menant vers le sommet de la tour. Une Gargouille de pierre postée au-dessus de la porte prend vie. Ses yeux s'allument et elle pousse un rugissement.", NULL),
(36, "Après la Gargouille", "La gargouille s'effondre en morceaux. Vous continuez votre ascension vers le sommet.", NULL),
(37, "Le Chien de Garde Squelette", "Dans un corridor sombre, un grognement se fait entendre. Un Chien de Garde Squelette vous bloque le chemin, ses yeux brillant d'une lueur surnaturelle.", NULL),
(38, "Après le Chien de Garde", "Le squelette s'effondre en un tas d'ossements. Le passage est libre.", NULL),
(39, "Accès au Sommet", "Vous placez le Sceau sur la porte et prononcez le mot de passe 'RAVEN'. La porte s'ouvre dans un grincement. Vous entrez dans les quartiers privés du Sorcier.", NULL),
(40, "L'Antichambre du Sorcier", "Vous progressez dans les appartements du Sorcier. Des symboles magiques ornent les murs. Une dernière porte mène à la salle du rituel. Sur une table, vous trouvez une précieuse potion de soin. Vous la prenez, sentant que vous en aurez bientôt besoin.", NULL),
(41, "Le Dernier Étage", "Vous poussez la lourde porte. Le Sorcier est là, préparant son rituel. Il se retourne, ses yeux brillent d'une lueur maléfique. 'Tu es allé trop loin, intrus !' Le combat final commence.", NULL),
(42, "La Victoire", "Le Sorcier s'effondre, son aura sombre se dissipant dans l'air. Vous avez vaincu le mal. Vous retrouvez la fille du bourgmestre saine et sauve et la ramenez au village. Le bourgmestre est reconnaissant. Vous êtes un héros ! (FIN BONNE)", NULL),
(43, "La lumière au bout du néant", "Le monde se dérobe sous vos pieds, et une obscurité profonde vous enveloppe. Une lueur douce apparaît au loin, et une voix murmure : 'Brave âme, ton chemin n'est pas achevé... À ceux qui échouent, une seconde chance est accordée'. Vous perdez votre équipement et vos armes.", NULL),
(44, "La Fuite Discrète", "Vous décidez de fuir avec la fille du bourgmestre sans affronter le Sorcier. Vous la ramenez au Val Perdu. Le bourgmestre est reconnaissant, mais le Sorcier reste libre. Vous avez sauvé une vie, mais l'ombre plane toujours sur la région. (FIN NEUTRE)", NULL),
(45, "Le Spectre Repoussé", "Vous utilisez un objet sacré trouvé dans les cachots pour repousser le Spectre. Il s'évanouit dans un cri plaintif, vous laissant accéder à la fenêtre.", NULL),
(46, "Le chat", "Miaou miao miamiaaaa, miaou mia mia mia miaaaa", NULL);

-- --------------------------------------------------------
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


INSERT INTO `chapter_treasure` (`id`, `chapter_id`, `item_id`, `quantity`) VALUES
(6, 1, 1, 2),   -- Potion au tout debut
(1, 5, 1, 1),   -- Potion après le sanglier
(2, 26, 1, 1),  -- Potion dans la salle d'armes
(3, 40, 1, 1),  -- Potion avant le combat final
(4, 16, 1, 1),  -- Potion après le gobelin
(5, 36, 1, 1);  -- Potion après la gargouille

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
(2, 'Guerrier', 'Un guerrier brutal et impitoyable doué d une force extraordinaire', 35, 3, 14, 3, 6),
(3, 'Magicien', 'Un utilisateur de magie capable de puissants sorts dévastateurs', 15, 25, 3, 6, 4);

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
(1, 4, 1),   -- Sanglier enragé au chapitre 4
(2, 7, 2),   -- Loup noir au chapitre 7
(3, 15, 3),  -- Gobelin des Profondeurs au chapitre 15
(4, 24, 4),  -- Chauve-souris géante au chapitre 24
(5, 29, 5),  -- Disciple Déchu au chapitre 29
(6, 35, 6),  -- Gargouille au chapitre 35
(7, 37, 7),  -- Chien de Garde Squelette au chapitre 37
(8, 41, 8);

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
(1, 'Potion', 'Restaure 15 points de vie', 'potion_pv'),
(5, 'Potion Mana', 'Restore 10 Mana (Pour le mage)', 'potion_mana');
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
-- Depuis l'introduction
(1, 1, 2, "Commencer l'aventure"),
(2, 2, 3, "Emprunter le chemin sinueux"),
(3, 2, 4, "Emprunter le sentier couvert de ronces"),
(4, 3, 6, "Rester prudent et chercher le paysan"),
(5, 3, 7, "Ignorer les bruits et poursuivre"),
(6, 4, 5, "Victoire contre le sanglier"),
(7, 5, 6, "Continuer votre chemin"),
(8, 6, 9, "Continuer après avoir parlé au paysan"),
(9, 7, 8, "Victoire contre le loup"),

-- Depuis Après le loup
(10, 8, 9, "Avancer vers la clairière"),

-- Depuis la clairière aux pierres anciennes
(11, 9, 10, "Prendre le sentier couvert de mousse vers le ruisseau"),
(12, 9, 22, "Suivre le chemin tortueux vers le château"),

-- Depuis les murmures du ruisseau
(13, 10, 11, "Toucher la pierre gravée"),
(14, 10, 22, "Ignorer et poursuivre vers le château"),

-- Depuis La Voix du Ruisseau
(15, 11, 12, "Essayer de comprendre les murmures"),
(16, 11, 22, "Se retirer, inquiet, et aller au château"),

-- Depuis Le Secret de la Pierre
(17, 12, 13, "Chercher le chemin sous les Racines Moussues"),
(18, 12, 22, "Ignorer l'avertissement et aller au château"),

-- Depuis Le Passage Oublié
(19, 13, 14, "S'engager dans le tunnel"),
(20, 13, 22, "Préférer prendre le risque du château"),
(21, 14, 15, "Suivre les traces dans les ténèbres"),
(22, 14, 17, "Utiliser une torche pour éclairer"),
(23, 15, 16, "Vaincre le Gobelin"),
(24, 16, 17, "Poursuivre prudemment"),
(25, 17, 18, "Poursuivre vers la crypte"),
(26, 18, 19, "Chercher la clé de la cage"),
(27, 18, 20, "Tenter de briser la serrure"),
(28, 19, 21, "Utiliser le Grimoire pour ouvrir la cage"),
(29, 19, 28, "Chercher le disciple dans les cachots"),
(30, 20, 28, "Fuir vers les cachots"),
(31, 21, 40, "Monter vers le sommet pour affronter le Sorcier"),
(32, 21, 44, "S'enfuir discrètement avec la fille"),
(33, 22, 23, "Emprunter la brèche dans le mur ouest"),
(34, 22, 13, "Chercher un passage secret"),
(35, 23, 24, "Approcher la porte dérobée"),
(36, 23, 27, "Emprunter la porte vers la Bibliothèque"),
(37, 23, 28, "Descendre vers les cachots"),
(38, 24, 25, "Vaincre la chauve-souris"),
(39, 25, 26, "Crocheter la porte dérobée"),
(40, 26, 38, "Continuer l'exploration"),
(41, 27, 31, "Examiner le journal plus en détail"),
(42, 27, 32, "Chercher un moyen de sortir"),
(43, 28, 29, "Explorer les cellules"),
(44, 29, 30, "Vaincre le Disciple Déchu"),
(45, 30, 18, "Retourner à la Crypte avec la clé"),
(46, 30, 34, "Continuer à explorer le château"),
(47, 31, 37, "Les gardes arrivent !"),
(48, 32, 45, "Repousser le Spectre"),
(49, 32, 31, "Chercher une autre issue dans la bibliothèque"),
(50, 33, 39, "Utiliser le Sceau et le mot de passe"),
(51, 33, 28, "Faire demi-tour chercher le disciple"),
(52, 34, 28, "Remonter de l'oubliette et retourner aux cachots"),
(53, 35, 36, "Vaincre la Gargouille"),
(54, 36, 38, "Continuer l'ascension"),
(55, 37, 38, "Vaincre le Chien de Garde Squelette"),
(56, 38, 39, "Continuer vers le sommet"),
(57, 39, 40, "Entrer dans les quartiers du Sorcier"),
(58, 40, 41, "Pousser la porte du combat final"),
(59, 41, 42, "Victoire contre le Sorcier"),
(60, 43, 1, "Reprendre l'aventure depuis le début"),
(61, 45, 33, "Accéder au toit via la gouttière");

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
(2, 'Loup noir', 15, 0, 7, 5, 'Morsure', 12),
(3, 'Gobelin des Profondeurs', 18, 5, 6, 5, 'Coup de dague empoisonnée', 18),
(4, 'Chauve-souris géante', 12, 0, 9, 4, 'Attaque en piqué', 10),
(5, 'Disciple Déchu', 25, 15, 5, 7, 'Sort de terreur', 25),
(6, 'Gargouille', 30, 0, 4, 8, 'Griffes de pierre', 30),
(7, 'Chien de Garde Squelette', 22, 0, 6, 6, 'Morsure nécrotique', 20),
(8, 'Le Sorcier', 50, 40, 7, 10, 'Éclair de ténèbres', 100);

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