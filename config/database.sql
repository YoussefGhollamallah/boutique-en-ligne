-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : ven. 01 nov. 2024 à 15:25
-- Version du serveur : 10.11.9-MariaDB
-- Version de PHP : 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `u126908064_pixel_plush`
--

-- --------------------------------------------------------

--
-- Structure de la table `Adresse`
--

CREATE TABLE `Adresse` (
  `id` int(11) NOT NULL,
  `adresse` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `adresse_complement` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `code_postal` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `ville` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `pays` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `id_utilisateur` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `Adresse`
--

INSERT INTO `Adresse` (`id`, `adresse`, `adresse_complement`, `code_postal`, `ville`, `pays`, `id_utilisateur`) VALUES
(1, '1 rue albert heinstein', 'les mimosas', 'Marseille', '13013', 'France', 1),
(7, '270 boulevard Baille', 'Bat 4 Résidence Baille', 'Marseille', '13005', 'France', 3),
(8, 'KameHouse', 'A', 'Marseille', '13014', 'Namek', 29);

-- --------------------------------------------------------

--
-- Structure de la table `Categorie`
--

CREATE TABLE `Categorie` (
  `id_categorie` int(11) NOT NULL,
  `nom_p` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `description_c` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `Categorie`
--

INSERT INTO `Categorie` (`id_categorie`, `nom_p`, `description_c`) VALUES
(1, 'Jeux', NULL),
(2, 'Films et Séries', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `Categorie_SousCategorie`
--

CREATE TABLE `Categorie_SousCategorie` (
  `id_categorie` int(11) NOT NULL,
  `id_sousCategorie` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `Categorie_SousCategorie`
--

INSERT INTO `Categorie_SousCategorie` (`id_categorie`, `id_sousCategorie`) VALUES
(1, 5),
(1, 6),
(1, 13),
(2, 1),
(2, 2),
(2, 3),
(2, 4),
(2, 9),
(2, 10),
(2, 11),
(2, 12),
(2, 14);

-- --------------------------------------------------------

--
-- Structure de la table `Commande`
--

CREATE TABLE `Commande` (
  `id` int(11) NOT NULL,
  `status` varchar(50) NOT NULL,
  `date_commande` timestamp NULL DEFAULT current_timestamp(),
  `id_utilisateur` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `Commande`
--

INSERT INTO `Commande` (`id`, `status`, `date_commande`, `id_utilisateur`) VALUES
(1, 'en attente', '2024-10-31 14:29:55', 29),
(2, 'en attente', '2024-10-31 15:29:41', 29);

-- --------------------------------------------------------

--
-- Structure de la table `Commande_Produit`
--

CREATE TABLE `Commande_Produit` (
  `commande_id` int(11) NOT NULL,
  `produit_id` int(11) NOT NULL,
  `quantite` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `Commande_Produit`
--

INSERT INTO `Commande_Produit` (`commande_id`, `produit_id`, `quantite`) VALUES
(1, 4, 1),
(2, 1, 1),
(2, 5, 1),
(2, 6, 1),
(2, 8, 1),
(2, 9, 2);

-- --------------------------------------------------------

--
-- Structure de la table `Panier`
--

CREATE TABLE `Panier` (
  `user_id` int(11) NOT NULL,
  `produit_id` int(11) NOT NULL,
  `quantite` int(11) DEFAULT NULL,
  `checked` tinyint(1) DEFAULT NULL,
  `date_ajout` timestamp NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `Panier`
--

INSERT INTO `Panier` (`user_id`, `produit_id`, `quantite`, `checked`, `date_ajout`) VALUES
(3, 1, 1, 1, '2024-10-31 15:19:40'),
(3, 7, 1, 1, '2024-10-31 15:19:42'),
(3, 14, 1, 1, '2024-10-31 15:19:43'),
(3, 20, 6, 1, '2024-10-31 15:19:44'),
(30, 29, 6, 0, '2024-10-31 14:42:33');

-- --------------------------------------------------------

--
-- Structure de la table `Produit`
--

CREATE TABLE `Produit` (
  `id` int(11) NOT NULL,
  `nom` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `prix` decimal(10,2) NOT NULL,
  `quantite` int(11) NOT NULL,
  `image` varchar(255) NOT NULL,
  `date_ajout` timestamp NOT NULL DEFAULT current_timestamp(),
  `id_sousCategorie` int(11) NOT NULL,
  `id_categorie` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `Produit`
--

INSERT INTO `Produit` (`id`, `nom`, `description`, `prix`, `quantite`, `image`, `date_ajout`, `id_sousCategorie`, `id_categorie`) VALUES
(1, 'katsuki_bakugo', 'Peluche de Bakugo, le héros explosif de My Hero Academia, représentant son caractère fougueux et sa détermination.', 25.00, 10, 'bakugo.png', '2024-10-21 08:10:02', 9, 2),
(2, 'izuku_midoriya', 'Peluche de Izuku, le jeune héros en devenir de My Hero Academia, célèbre pour son courage et son esprit indomptable.', 29.99, 15, 'deku.png', '2024-10-21 08:10:02', 9, 2),
(3, 'shoto_todoroki', 'Peluche de Shoto, le héros aux pouvoirs de glace et de feu, symbole de complexité et de force dans My Hero Academia.', 29.99, 12, 'shoto.png', '2024-10-21 08:10:02', 9, 2),
(4, 'batman', 'Peluche de Batman, le chevalier noir de Gotham, emblématique pour sa bravoure et sa lutte contre le crime.', 35.99, 10, 'batman.png', '2024-10-21 08:10:02', 1, 2),
(5, 'catwoman', 'Peluche de Catwoman, la féline énigmatique de DC, mélange parfait de charme et de mystère.', 32.99, 8, 'catwoman.png', '2024-10-21 08:10:02', 1, 2),
(6, 'superman', 'Peluche de Superman, le super-héros légendaire, incarnation de la justice et de la bonté.', 33.99, 7, 'superman.png', '2024-10-21 08:10:02', 1, 2),
(7, 'black_widow', 'Peluche de Black Widow, l\'agent secret redoutable de Marvel, reconnue pour ses compétences de combat inégalées.', 34.99, 9, 'black_widow.png', '2024-10-21 08:10:02', 3, 2),
(8, 'iron_man', 'Peluche d\'Iron Man, le génie milliardaire derrière l\'armure, symbole de technologie avancée et de bravoure.', 36.99, 11, 'iron_man.png', '2024-10-21 08:10:02', 3, 2),
(9, 'spider-man', 'Peluche de Spider-Man, le héros qui jongle entre vie normale et responsabilités héroïques, toujours prêt à aider.', 31.99, 14, 'spider_man.png', '2024-10-21 08:10:02', 3, 2),
(10, 'demogorgon', 'Peluche de Demogorgon, la créature terrifiante de Stranger Things, incarnant la peur et l\'inconnu.', 28.99, 5, 'demogorgon.png', '2024-10-21 08:10:02', 4, 2),
(11, 'eleven', 'Peluche de Eleven, l\'enfant aux pouvoirs psychiques de Stranger Things, symbolisant l\'amitié et le courage.', 29.99, 6, 'eleven.png', '2024-10-21 08:10:02', 4, 2),
(12, 'lucas', 'Peluche de Lucas, un ami loyal de Stranger Things, prêt à affronter n\'importe quel danger avec bravoure.', 27.99, 4, 'lucas.png', '2024-10-21 08:10:02', 4, 2),
(13, 'harry_potter', 'Peluche de Harry Potter, le célèbre sorcier, représentant la magie et l\'aventure dans un monde fantastique.', 25.99, 15, 'harry_potter.png', '2024-10-21 08:10:02', 10, 2),
(14, 'hermione_granger', 'Peluche d\'Hermione Granger, l\'intellectuelle et la sorcière talentueuse de Harry Potter, symbole de sagesse.', 25.99, 12, 'hermione_granger.png', '2024-10-21 08:10:02', 10, 2),
(15, 'l', 'Peluche de L, le détective génial de Death Note, reconnu pour son intellect aiguisé et son allure mystérieuse.', 23.99, 10, 'l.png', '2024-10-21 08:10:02', 2, 2),
(16, 'light_yagami', 'Peluche de Light Yagami, le jeune homme aux ambitions obscures de Death Note, représentant le dilemme moral.', 23.99, 11, 'light_yagami.png', '2024-10-21 08:10:02', 2, 2),
(17, 'ryuk', 'Peluche de Ryuk, le shinigami espiègle de Death Note, qui observe le monde des humains avec un intérêt amusé.', 24.99, 7, 'ryuk.png', '2024-10-21 08:10:02', 2, 2),
(18, 'muzan_kibutsuji', 'Peluche de Muzan Kibutsuji, l\'antagoniste charismatique de Demon Slayer, représentant le pouvoir et la terreur.', 29.99, 10, 'muzan_kibutsuji.png', '2024-10-21 08:10:02', 12, 2),
(19, 'tanjiro_kamado', 'Peluche de Tanjiro Kamado, le chasseur de démons au cœur pur de Demon Slayer, symbole de compassion et de force.', 29.99, 12, 'tanjiro_kamado.png', '2024-10-21 08:10:02', 12, 2),
(20, 'zenitsu_agatsuma', 'Peluche de Zenitsu Agatsuma, le jeune chasseur de démons timide mais déterminé de Demon Slayer.', 29.99, 8, 'zenitsu_agatsuma.png', '2024-10-21 08:10:02', 12, 2),
(21, 'gnar', 'Peluche de Gnar, le yordle sauvage de League of Legends, connu pour sa personnalité joyeuse et ses pouvoirs impressionnants.', 26.99, 13, 'gnar.png', '2024-10-21 08:10:02', 11, 1),
(22, 'poro', 'Peluche de Poro, la petite créature adorée de League of Legends, célèbre pour sa gentillesse et sa fourrure douce.', 21.99, 20, 'poro.png', '2024-10-21 08:10:02', 11, 1),
(23, 'tibbers', 'Peluche de Tibbers, l\'ami en peluche enflammé d\'Annie de League of Legends, symbole d\'amitié et de magie.', 34.99, 6, 'tibbers.png', '2024-10-21 08:10:02', 11, 1),
(24, 'carapateur', 'Peluche de Carapateur, le célèbre compagnon de League of Legends, connu pour son côté espiègle.', 22.99, 8, 'carapateur.png', '2024-10-21 08:10:02', 11, 1),
(25, 'capumain', 'Peluche de Capumain, le compagnon espiègle de Pokémon, qui apporte joie et aventure à chaque moment.', 15.00, 15, 'capumain.png', '2024-10-21 08:10:02', 6, 1),
(26, 'pikachu', 'Peluche de Pikachu, la mascotte emblématique de Pokémon, célèbre pour sa puissance électrique et sa personnalité joyeuse.', 23.00, 20, 'pikachu.png', '2024-10-21 08:10:02', 6, 1),
(27, 'salameche', 'Peluche de Salamèche, le Pokémon feu adoré, connu pour son courage et son évolution impressionnante.', 45.00, 14, 'salameche.png', '2024-10-21 08:10:02', 6, 1),
(28, 'boo', 'Peluche de Boo, le fantôme espiègle de Mario, connu pour ses manières timides et sa nature amusante.', 24.99, 15, 'boo.png', '2024-10-21 08:10:02', 13, 1),
(29, 'bowser', 'Peluche de Bowser, le roi des Koopas, célèbre pour ses plans machiavéliques et sa puissance redoutable.', 30.99, 5, 'bowser.png', '2024-10-21 08:10:02', 13, 1),
(30, 'luigi', 'Peluche de Luigi, le frère de Mario, connu pour sa bravoure et son esprit d\'aventure.', 25.99, 10, 'luigi.png', '2024-10-21 08:10:02', 13, 1),
(31, 'mario', 'Peluche de Mario, le héros emblématique des jeux vidéo, célèbre pour ses aventures palpitantes et son caractère joyeux.', 45.00, 12, 'mario.png', '2024-10-21 08:10:02', 13, 1),
(32, 'champignon', 'Peluche du Champignon, un élément essentiel du monde de Mario, symbole d\'aventure et de magie.', 19.99, 20, 'champignon.png', '2024-10-21 08:10:02', 13, 1),
(33, 'creeper', 'Peluche de Creeper, la créature emblématique de Minecraft, connue pour sa capacité à surprendre.', 21.99, 12, 'creeper.png', '2024-10-21 08:10:02', 5, 1),
(34, 'renard', 'Peluche de Renard, un compagnon astucieux de Minecraft, symbole de l\'exploration et de l\'amusement.', 23.99, 10, 'renard.png', '2024-10-21 08:10:02', 5, 1),
(35, 'ender_dragon', 'Peluche d\'Ender Dragon, le dragon légendaire de Minecraft, représentant le défi ultime pour les aventuriers.', 35.99, 7, 'ender_dragon.png', '2024-10-21 08:10:02', 5, 1),
(36, 'tristesse', 'Peluche de Tristesse, le personnage émouvant de Disney, qui évoque des émotions profondes et des leçons de vie.', 24.99, 10, 'tristesse.png', '2024-10-21 08:10:02', 14, 2),
(37, 'dégout', 'Peluche de Dégout, une représentation colorée de Disney, qui nous rappelle l\'importance des émotions.', 24.99, 8, 'degout.png', '2024-10-21 08:10:02', 14, 2),
(38, 'simba', 'Peluche de Simba, le lion courageux de Disney, symbole de responsabilité et de royauté.', 26.99, 9, 'simba.png', '2024-10-21 08:10:02', 14, 2),
(39, 'stitch', 'Peluche de Stitch, l\'extraterrestre espiègle de Disney, connu pour son amour inconditionnel et son caractère unique.', 27.99, 11, 'stitch.png', '2024-10-21 08:10:02', 14, 2),
(40, 'bourriquet', 'Peluche de Bourriquet, le personnage mélancolique de Disney, qui nous rappelle l\'importance de l\'amitié.', 25.99, 12, 'bourriquet.png', '2024-10-21 08:10:02', 14, 2),
(41, 'dracaufeu', 'Peluche de Dracaufeu, le dragon emblématique de Pokémon, connu pour sa puissance de feu et son caractère fort.', 20.00, 7, 'dracaufeu.png', '2024-10-22 12:32:40', 6, 1);

-- --------------------------------------------------------

--
-- Structure de la table `Role`
--

CREATE TABLE `Role` (
  `id_role` int(11) NOT NULL,
  `nom_role` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `Role`
--

INSERT INTO `Role` (`id_role`, `nom_role`) VALUES
(1, 'Admin'),
(2, 'Client');

-- --------------------------------------------------------

--
-- Structure de la table `SousCategorie`
--

CREATE TABLE `SousCategorie` (
  `id_sousCategorie` int(11) NOT NULL,
  `nom_sc` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `description_sc` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `SousCategorie`
--

INSERT INTO `SousCategorie` (`id_sousCategorie`, `nom_sc`, `description_sc`) VALUES
(1, 'DC', NULL),
(2, 'death note', NULL),
(3, 'Marvel', NULL),
(4, 'Stranger Things', NULL),
(5, 'Minecraft', NULL),
(6, 'Pokémon', NULL),
(7, 'Figurine', 'Marvel'),
(8, 'Voiture', 'Pièces Automobiles'),
(9, 'My Hero Academia', NULL),
(10, 'harry potter', NULL),
(11, 'league of legend', NULL),
(12, 'demon slayer', NULL),
(13, 'mario', NULL),
(14, 'disney', NULL),
(15, 'Mattel', 'Hotwheels'),
(19, 'Monopoly', 'Jeu de société'),
(20, 'Hasbro', 'My Little pony'),
(21, 'Anime', 'Figurine'),
(22, 'Nounours', 'Bisounours'),
(24, 'Peluche', 'Forraine'),
(25, 'Jouet enfants', 'Hasbro'),
(27, 'martin martin', 'martin'),
(30, 'Naruto', 'Shinobi'),
(38, 'Mickey', 'Peluche, Disney');

-- --------------------------------------------------------

--
-- Structure de la table `Utilisateur`
--

CREATE TABLE `Utilisateur` (
  `id` int(11) NOT NULL,
  `prenom` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `nom` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `mot_de_passe` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `date_inscription` timestamp NOT NULL DEFAULT current_timestamp(),
  `id_adresse` int(11) DEFAULT NULL,
  `role_id` int(11) NOT NULL DEFAULT 2
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `Utilisateur`
--

INSERT INTO `Utilisateur` (`id`, `prenom`, `nom`, `email`, `mot_de_passe`, `date_inscription`, `id_adresse`, `role_id`) VALUES
(1, 'youssef', 'ghollamallah', 'youssef.gh@live.fr', '$2y$10$/XVkJ/NJeINZfuIecoiem.CORHYD64sEhuQiANXPPf3gi39sj6NtK', '2024-10-15 08:54:54', NULL, 2),
(3, 'lucas', 'iribaren', 'lucas.iribaren@laplateforme.io', '$2y$10$uUsgEssSIZNlKr3QUgniYefxxh43tE0MUdZ33SEg6xZX.HrRfezCW', '2024-10-16 11:30:53', NULL, 1),
(5, 'lucy', 'madec', 'lucy.maced@laplateforme.io', '$2y$10$gsHAvuHj548XgeRrGFlS.eIayMqIBCsvRlfpf1wKFd1P.iuy9BkYC', '2024-10-18 13:46:43', NULL, 1),
(14, 'lucy', 'madec', 'lucy.madec@laplateforme.io', '$2y$10$C.kVYrTGyTO/tx4ioGmLQ.6RFLIQHdz6AQrsJj0jFEQ5JdQMNXswq', '2024-10-23 07:29:56', NULL, 2),
(15, 'youssef', 'ghollamallah', 'youssef.ghollamallah@laplateforme.io', '$2y$10$Fx/MuG3ur6nFsaqCjwpKU.rk82HIp34ZQeKqbdmLnDI3ej5h7y2MO', '2024-10-23 07:33:28', NULL, 1),
(29, 'ryan', 'ladmia', 'ryan.ladmia@laplateforme.io', '$2y$10$FMhrXfkfpSujw6Xq1NQSMehj4F4Nb5C9LnR9bGRGthoxTFveDyLvC', '2024-10-30 13:30:29', NULL, 1),
(30, 'antony', 'lucide', 'antony.lucide@laplateforme.io', '$2y$10$U0TTOpHkxS4GGe7uuVtttetLGYJodlSsYpApIehHWTkWHcwo3csIK', '2024-10-31 13:45:34', NULL, 1);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `Adresse`
--
ALTER TABLE `Adresse`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_adresse_utilisateur` (`id_utilisateur`);

--
-- Index pour la table `Categorie`
--
ALTER TABLE `Categorie`
  ADD PRIMARY KEY (`id_categorie`);

--
-- Index pour la table `Categorie_SousCategorie`
--
ALTER TABLE `Categorie_SousCategorie`
  ADD PRIMARY KEY (`id_categorie`,`id_sousCategorie`),
  ADD KEY `fk_categorie_sousCategorie_sousCategorie` (`id_sousCategorie`);

--
-- Index pour la table `Commande`
--
ALTER TABLE `Commande`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_utilisateur` (`id_utilisateur`);

--
-- Index pour la table `Commande_Produit`
--
ALTER TABLE `Commande_Produit`
  ADD PRIMARY KEY (`commande_id`,`produit_id`),
  ADD KEY `produit_id` (`produit_id`);

--
-- Index pour la table `Panier`
--
ALTER TABLE `Panier`
  ADD PRIMARY KEY (`user_id`,`produit_id`);

--
-- Index pour la table `Produit`
--
ALTER TABLE `Produit`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_produit_sousCategorie` (`id_sousCategorie`),
  ADD KEY `fk_produit_categorie` (`id_categorie`);

--
-- Index pour la table `Role`
--
ALTER TABLE `Role`
  ADD PRIMARY KEY (`id_role`);

--
-- Index pour la table `SousCategorie`
--
ALTER TABLE `SousCategorie`
  ADD PRIMARY KEY (`id_sousCategorie`);

--
-- Index pour la table `Utilisateur`
--
ALTER TABLE `Utilisateur`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `fk_utilisateur_adresse` (`id_adresse`),
  ADD KEY `fk_role` (`role_id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `Adresse`
--
ALTER TABLE `Adresse`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT pour la table `Categorie`
--
ALTER TABLE `Categorie`
  MODIFY `id_categorie` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `Commande`
--
ALTER TABLE `Commande`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `Produit`
--
ALTER TABLE `Produit`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT pour la table `Role`
--
ALTER TABLE `Role`
  MODIFY `id_role` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `SousCategorie`
--
ALTER TABLE `SousCategorie`
  MODIFY `id_sousCategorie` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT pour la table `Utilisateur`
--
ALTER TABLE `Utilisateur`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `Adresse`
--
ALTER TABLE `Adresse`
  ADD CONSTRAINT `fk_adresse_utilisateur` FOREIGN KEY (`id_utilisateur`) REFERENCES `Utilisateur` (`id`);

--
-- Contraintes pour la table `Categorie_SousCategorie`
--
ALTER TABLE `Categorie_SousCategorie`
  ADD CONSTRAINT `fk_categorie_sousCategorie_categorie` FOREIGN KEY (`id_categorie`) REFERENCES `Categorie` (`id_categorie`),
  ADD CONSTRAINT `fk_categorie_sousCategorie_sousCategorie` FOREIGN KEY (`id_sousCategorie`) REFERENCES `SousCategorie` (`id_sousCategorie`);

--
-- Contraintes pour la table `Commande`
--
ALTER TABLE `Commande`
  ADD CONSTRAINT `Commande_ibfk_1` FOREIGN KEY (`id_utilisateur`) REFERENCES `Utilisateur` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `Commande_Produit`
--
ALTER TABLE `Commande_Produit`
  ADD CONSTRAINT `Commande_Produit_ibfk_1` FOREIGN KEY (`commande_id`) REFERENCES `Commande` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `Commande_Produit_ibfk_2` FOREIGN KEY (`produit_id`) REFERENCES `Produit` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `Produit`
--
ALTER TABLE `Produit`
  ADD CONSTRAINT `fk_produit_categorie` FOREIGN KEY (`id_categorie`) REFERENCES `Categorie` (`id_categorie`),
  ADD CONSTRAINT `fk_produit_sousCategorie` FOREIGN KEY (`id_sousCategorie`) REFERENCES `SousCategorie` (`id_sousCategorie`);

--
-- Contraintes pour la table `Utilisateur`
--
ALTER TABLE `Utilisateur`
  ADD CONSTRAINT `fk_role` FOREIGN KEY (`role_id`) REFERENCES `Role` (`id_role`),
  ADD CONSTRAINT `fk_utilisateur_adresse` FOREIGN KEY (`id_adresse`) REFERENCES `Adresse` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
