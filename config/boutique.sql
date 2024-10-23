-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : lun. 21 oct. 2024 à 11:56
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
  `status` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `date_commande` timestamp NOT NULL DEFAULT current_timestamp(),
  `id_utilisateur` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `Commande_Produit`
--

CREATE TABLE `Commande_Produit` (
  `id_produit` int(11) NOT NULL,
  `id_commande` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
(1, 'bakugo', 'Peluche de Bakugo de My Hero Academia.', 29.99, 10, 'bakugo.png', '2024-10-21 08:10:02', 9, 2),
(2, 'deku', 'Peluche de Deku de My Hero Academia.', 29.99, 15, 'deku.png', '2024-10-21 08:10:02', 9, 2),
(3, 'shoto', 'Peluche de Shoto de My Hero Academia.', 29.99, 12, 'shoto.png', '2024-10-21 08:10:02', 9, 2),
(4, 'batman', 'Peluche de Batman de DC.', 35.99, 10, 'batman.png', '2024-10-21 08:10:02', 1, 2),
(5, 'catwoman', 'Peluche de Catwoman de DC.', 32.99, 8, 'catwoman.png', '2024-10-21 08:10:02', 1, 2),
(6, 'superman', 'Peluche de Superman de DC.', 33.99, 7, 'superman.png', '2024-10-21 08:10:02', 1, 2),
(7, 'black_widow', 'Peluche de Black Widow de Marvel.', 34.99, 9, 'black_widow.png', '2024-10-21 08:10:02', 3, 2),
(8, 'iron_man', 'Peluche d\'Iron Man de Marvel.', 36.99, 11, 'iron_man.png', '2024-10-21 08:10:02', 3, 2),
(9, 'spider_man', 'Peluche de Spider-Man de Marvel.', 31.99, 14, 'spider_man.png', '2024-10-21 08:10:02', 3, 2),
(10, 'demogorgon', 'Peluche de Demogorgon de Stranger Things.', 28.99, 5, 'demogorgon.png', '2024-10-21 08:10:02', 4, 2),
(11, 'eleven', 'Peluche de Eleven de Stranger Things.', 29.99, 6, 'eleven.png', '2024-10-21 08:10:02', 4, 2),
(12, 'lucas', 'Peluche de Lucas de Stranger Things.', 27.99, 4, 'lucas.png', '2024-10-21 08:10:02', 4, 2),
(13, 'harry_potter', 'Peluche de Harry Potter.', 25.99, 15, 'harry_potter.png', '2024-10-21 08:10:02', 10, 2),
(14, 'hermione_granger', 'Peluche d\'Hermione Granger.', 25.99, 12, 'hermione_granger.png', '2024-10-21 08:10:02', 10, 2),
(15, 'l', 'Peluche de L de Death Note.', 23.99, 10, 'l.png', '2024-10-21 08:10:02', 2, 2),
(16, 'light_yagami', 'Peluche de Light Yagami de Death Note.', 23.99, 11, 'light_yagami.png', '2024-10-21 08:10:02', 2, 2),
(17, 'ryuk', 'Peluche de Ryuk de Death Note.', 24.99, 7, 'ryuk.png', '2024-10-21 08:10:02', 2, 2),
(18, 'muzan_kibutsuji', 'Peluche de Muzan Kibutsuji de Demon Slayer.', 29.99, 10, 'muzan_kibutsuji.png', '2024-10-21 08:10:02', 12, 2),
(19, 'tanjiro_kamado', 'Peluche de Tanjiro Kamado de Demon Slayer.', 29.99, 12, 'tanjiro_kamado.png', '2024-10-21 08:10:02', 12, 2),
(20, 'zenitsu_agatsuma', 'Peluche de Zenitsu Agatsuma de Demon Slayer.', 29.99, 8, 'zenitsu_agatsuma.png', '2024-10-21 08:10:02', 12, 2),
(21, 'gnar', 'Peluche de Gnar de League of Legends.', 26.99, 13, 'gnar.png', '2024-10-21 08:10:02', 11, 2),
(22, 'poro', 'Peluche de Poro de League of Legends.', 21.99, 20, 'poro.png', '2024-10-21 08:10:02', 11, 2),
(23, 'tibbers', 'Peluche de Tibbers de League of Legends.', 34.99, 6, 'tibbers.png', '2024-10-21 08:10:02', 11, 2),
(24, 'carapateur', 'Peluche de Carapateur de League of Legends.', 22.99, 8, 'carapateur.png', '2024-10-21 08:10:02', 11, 2),
(25, 'capumain', 'Peluche de Capumain de Pokémon.', 19.99, 18, 'capumain.png', '2024-10-21 08:10:02', 6, 1),
(26, 'pikachu', 'Peluche de Pikachu de Pokémon.', 22.99, 20, 'pikachu.png', '2024-10-21 08:10:02', 6, 1),
(27, 'salameche', 'Peluche de Salamèche de Pokémon.', 21.99, 14, 'salameche.png', '2024-10-21 08:10:02', 6, 1),
(28, 'boo', 'Peluche de Boo de Mario.', 24.99, 15, 'boo.png', '2024-10-21 08:10:02', 13, 1),
(29, 'bowser', 'Peluche de Bowser de Mario.', 30.99, 5, 'bowser.png', '2024-10-21 08:10:02', 13, 1),
(30, 'luigi', 'Peluche de Luigi de Mario.', 25.99, 10, 'luigi.png', '2024-10-21 08:10:02', 13, 1),
(31, 'mario', 'Peluche de Mario.', 25.99, 12, 'mario.png', '2024-10-21 08:10:02', 13, 1),
(32, 'champignon', 'Peluche du Champignon de Mario.', 19.99, 20, 'champignon.png', '2024-10-21 08:10:02', 13, 1),
(33, 'creeper', 'Peluche de Creeper de Minecraft.', 21.99, 12, 'creeper.png', '2024-10-21 08:10:02', 5, 1),
(34, 'renard', 'Peluche de Renard de Minecraft.', 23.99, 10, 'renard.png', '2024-10-21 08:10:02', 5, 1),
(35, 'ender_dragon', 'Peluche d\'Ender Dragon de Minecraft.', 35.99, 7, 'ender_dragon.png', '2024-10-21 08:10:02', 5, 1),
(36, 'tristesse', 'Peluche de Tristesse de Disney.', 24.99, 10, 'tristesse.png', '2024-10-21 08:10:02', 14, 2),
(37, 'degout', 'Peluche de Dégout de Disney.', 24.99, 8, 'degout.png', '2024-10-21 08:10:02', 14, 2),
(38, 'simba', 'Peluche de Simba de Disney.', 26.99, 9, 'simba.png', '2024-10-21 08:10:02', 14, 2),
(39, 'stitch', 'Peluche de Stitch de Disney.', 27.99, 11, 'stitch.png', '2024-10-21 08:10:02', 14, 2),
(40, 'bourriquet', 'Peluche de Bourriquet de Disney.', 25.99, 12, 'bourriquet.png', '2024-10-21 08:10:02', 14, 2);

-- --------------------------------------------------------

--
-- Structure de la table `Role`
--

CREATE TABLE `Role` (
  `id` int(11) NOT NULL,
  `nom` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `Role`
--

INSERT INTO `Role` (`id`, `nom`) VALUES
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
(14, 'disney', NULL);

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
(1, 'Youssef', 'ghollamallah', 'youssef.gh@live.fr', '$2y$10$4KWzpYl9ZTSRSvoMZAWUEuVKl2kCOPo8O1Zgn1xrC0N/EOdyA1pL.', '2024-10-15 08:54:54', NULL, 2),
(2, 'test', 'test', 'test@test.fr', '$2y$10$jOH3ge3WcV3NJe0m2f2Z2OtXnjYMDblkbVE1LmwUuMkDoTVPpuyYO', '2024-10-16 11:28:24', NULL, 2),
(3, 'lucas', 'irabaren', 'lucas.iribaren@laplateforme.io', '$2y$10$uUsgEssSIZNlKr3QUgniYefxxh43tE0MUdZ33SEg6xZX.HrRfezCW', '2024-10-16 11:30:53', NULL, 1),
(5, 'lucy', 'maced', 'lucy.maced@laplateforme.io', '$2y$10$gsHAvuHj548XgeRrGFlS.eIayMqIBCsvRlfpf1wKFd1P.iuy9BkYC', '2024-10-18 13:46:43', NULL, 1),
(6, 'ryan', 'test', 'ryan.test@laplateforme.io', '$2y$10$kK9RQ8YW/hghc6c7B.dXH.KzbeN5P1CosuPvgdjFA.Noz6jIx9Txe', '2024-10-18 13:58:33', NULL, 2);

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
  ADD KEY `fk_commande_utilisateur` (`id_utilisateur`);

--
-- Index pour la table `Commande_Produit`
--
ALTER TABLE `Commande_Produit`
  ADD PRIMARY KEY (`id_produit`,`id_commande`),
  ADD KEY `fk_commande_produit_commande` (`id_commande`);

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
  ADD PRIMARY KEY (`id`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `Categorie`
--
ALTER TABLE `Categorie`
  MODIFY `id_categorie` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `Commande`
--
ALTER TABLE `Commande`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `Produit`
--
ALTER TABLE `Produit`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT pour la table `Role`
--
ALTER TABLE `Role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `SousCategorie`
--
ALTER TABLE `SousCategorie`
  MODIFY `id_sousCategorie` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT pour la table `Utilisateur`
--
ALTER TABLE `Utilisateur`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

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
  ADD CONSTRAINT `fk_commande_utilisateur` FOREIGN KEY (`id_utilisateur`) REFERENCES `Utilisateur` (`id`);

--
-- Contraintes pour la table `Commande_Produit`
--
ALTER TABLE `Commande_Produit`
  ADD CONSTRAINT `fk_commande_produit_commande` FOREIGN KEY (`id_commande`) REFERENCES `Commande` (`id`),
  ADD CONSTRAINT `fk_commande_produit_produit` FOREIGN KEY (`id_produit`) REFERENCES `Produit` (`id`);

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
  ADD CONSTRAINT `fk_role` FOREIGN KEY (`role_id`) REFERENCES `Role` (`id`),
  ADD CONSTRAINT `fk_utilisateur_adresse` FOREIGN KEY (`id_adresse`) REFERENCES `Adresse` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
