-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le : mer. 30 sep. 2026 à 16:25
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
-- Base de données : `G3AVALTAPIZZA`
--
CREATE DATABASE IF NOT EXISTS `G3AVALTAPIZZA` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `G3AVALTAPIZZA`;

-- --------------------------------------------------------

--
-- Structure de la table `commande`
--

CREATE TABLE `commande` (
  `id_commande` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `date_commande` datetime NOT NULL,
  `total_commande` decimal(10,2) NOT NULL,
  `type_conso` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `commande`
--

INSERT INTO `commande` (`id_commande`, `id_user`, `date_commande`, `total_commande`, `type_conso`) VALUES
(1, 8, '2026-09-30 11:42:02', 4.99, 1),
(2, 8, '2026-09-30 11:44:52', 0.00, 1),
(3, 8, '2026-09-30 11:49:54', 0.00, 2),
(4, 8, '2026-09-30 11:50:55', 0.00, 2),
(5, 8, '2026-09-30 11:51:12', 0.00, 1),
(6, 8, '2026-09-30 11:56:34', 0.00, 1),
(7, 8, '2026-09-30 11:59:10', 5.45, 1),
(8, 8, '2026-09-30 11:59:54', 5.45, 1),
(9, 8, '2026-09-30 12:00:04', 5.45, 2),
(10, 8, '2026-09-30 12:01:56', 5.45, 1),
(11, 8, '2026-09-30 12:06:24', 5.45, 1),
(12, 8, '2026-09-30 12:06:30', 5.45, 2),
(13, 8, '2026-09-30 12:11:39', 4.79, 2),
(14, 8, '2026-09-30 12:11:47', 4.99, 1),
(15, 8, '2026-09-30 12:32:45', 4.00, 1);

-- --------------------------------------------------------

--
-- Structure de la table `ligne_commande`
--

CREATE TABLE `ligne_commande` (
  `id_ligne_commande` int(11) NOT NULL,
  `id_commande` int(11) NOT NULL,
  `id_produit` int(11) NOT NULL,
  `qte` int(11) NOT NULL,
  `total_ligne_ht` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `ligne_commande`
--

INSERT INTO `ligne_commande` (`id_ligne_commande`, `id_commande`, `id_produit`, `qte`, `total_ligne_ht`) VALUES
(1, 1, 9, 2, 4.54),
(2, 2, 9, 2, 0.00),
(3, 3, 9, 3, 0.00),
(4, 4, 9, 3, 0.00),
(5, 5, 9, 2, 0.00),
(6, 6, 9, 2, 0.00),
(7, 7, 9, 2, 4.54),
(8, 8, 9, 2, 4.54),
(9, 9, 9, 2, 4.54),
(10, 10, 9, 2, 4.54),
(11, 11, 9, 2, 4.54),
(12, 12, 9, 2, 4.54),
(13, 13, 9, 2, 4.54),
(14, 14, 9, 2, 4.54),
(15, 15, 10, 2, 3.64);

--
-- Déclencheurs `ligne_commande`
--
DELIMITER $$
CREATE TRIGGER `after_ligne_update` AFTER UPDATE ON `ligne_commande` FOR EACH ROW BEGIN
    DECLARE mode_conso INT;
    DECLARE mult_tva DECIMAL(4,3);

    SELECT type_conso INTO mode_conso 
    FROM commande 
    WHERE id_commande = NEW.id_commande;

    IF mode_conso = 2 THEN
        SET mult_tva = 1.055;
    ELSE
        SET mult_tva = 1.10;
    END IF;

    UPDATE commande
    SET total_commande = (
        SELECT SUM(total_ligne_ht) * mult_tva
        FROM ligne_commande
        WHERE id_commande = NEW.id_commande
    )
    WHERE id_commande = NEW.id_commande;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `before_ligne_update` BEFORE UPDATE ON `ligne_commande` FOR EACH ROW BEGIN
    /* Recalcul du total HT de la ligne à partir du prix du produit */
    SET NEW.total_ligne_ht = NEW.qte * (
        SELECT prix_ht 
        FROM produit 
        WHERE id_produit = NEW.id_produit
    );
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `calcul_total_ligne_before_insert` BEFORE INSERT ON `ligne_commande` FOR EACH ROW BEGIN
    DECLARE p_prix DECIMAL(10,2);
    
    -- Récupération du prix HT du produit
    SELECT prix_ht INTO p_prix 
    FROM produit 
    WHERE id_produit = NEW.id_produit;
    
    -- Calcul du total HT de la ligne
    SET NEW.total_ligne_ht = NEW.qte * p_prix;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `maj_total_commande_after_insert` AFTER INSERT ON `ligne_commande` FOR EACH ROW BEGIN
    DECLARE mode_conso INT;
    DECLARE mult_tva DECIMAL(4,3);

    -- Récupération du mode de consommation (1 = Sur place, 2 = À emporter)
    SELECT type_conso INTO mode_conso 
    FROM commande 
    WHERE id_commande = NEW.id_commande;

    -- Application du taux correspondant
    IF mode_conso = 2 THEN
        SET mult_tva = 1.055; -- 5,5 % à emporter
    ELSE
        SET mult_tva = 1.10;  -- 10 % sur place
    END IF;

    -- Mise à jour du total TTC de la commande
    UPDATE commande
    SET total_commande = (
        SELECT SUM(total_ligne_ht) * mult_tva
        FROM ligne_commande
        WHERE id_commande = NEW.id_commande
    )
    WHERE id_commande = NEW.id_commande;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Structure de la table `produit`
--

CREATE TABLE `produit` (
  `id_produit` int(11) NOT NULL,
  `libelle` varchar(255) NOT NULL,
  `prix_ht` decimal(10,2) NOT NULL,
  `image` varchar(255) DEFAULT 'default.jpg'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `produit`
--

INSERT INTO `produit` (`id_produit`, `libelle`, `prix_ht`, `image`) VALUES
(1, 'Menu Solo', 12.73, 'menu_solo.jpg'),
(2, 'Menu Duo', 25.00, 'menu_duo.jpg'),
(3, 'Pizza Margherita', 8.64, 'margherita.jpg'),
(4, 'Pizza Reine', 10.45, 'reina.jpg'),
(5, 'Pizza 4 Fromages', 11.36, '4fromages.jpg'),
(6, 'Pizza Orientale', 10.91, 'orientale.jpg'),
(7, 'Tiramisu Maison', 4.09, 'tiramisu.jpg'),
(8, 'Panna Cotta', 3.64, 'pannacotta.jpg'),
(9, 'Soda 33cl', 2.27, 'soda.jpg'),
(10, 'Eau Minérale 50cl', 1.82, 'eau.jpg'),
(11, 'Bière Italienne 33cl', 3.33, 'biere.jpg');

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

CREATE TABLE `utilisateur` (
  `id_user` int(11) NOT NULL,
  `login` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `utilisateur`
--

INSERT INTO `utilisateur` (`id_user`, `login`, `password`, `email`) VALUES
(1, 'val', '$2y$10$zad0QfbOpIS8M/6h5q4BD.iODM4G21KpaOcs4veyPgMaFjaXWaVRO', 'valentin.maurin@limayrac.fr'),
(8, 'valou', '$2y$10$K.l3unCl4RvU1fTxYv0mcu7PPmQv1PERDQfX/ZUeM6D0.NuP1mxSG', 'valou@gmail.com');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `commande`
--
ALTER TABLE `commande`
  ADD PRIMARY KEY (`id_commande`),
  ADD KEY `fk_commande_utilisateur` (`id_user`);

--
-- Index pour la table `ligne_commande`
--
ALTER TABLE `ligne_commande`
  ADD PRIMARY KEY (`id_ligne_commande`),
  ADD KEY `fk_ligne_commande_commande` (`id_commande`),
  ADD KEY `fk_ligne_commande_produit` (`id_produit`);

--
-- Index pour la table `produit`
--
ALTER TABLE `produit`
  ADD PRIMARY KEY (`id_produit`);

--
-- Index pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `login` (`login`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `commande`
--
ALTER TABLE `commande`
  MODIFY `id_commande` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT pour la table `ligne_commande`
--
ALTER TABLE `ligne_commande`
  MODIFY `id_ligne_commande` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT pour la table `produit`
--
ALTER TABLE `produit`
  MODIFY `id_produit` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `commande`
--
ALTER TABLE `commande`
  ADD CONSTRAINT `fk_commande_utilisateur` FOREIGN KEY (`id_user`) REFERENCES `utilisateur` (`id_user`) ON UPDATE CASCADE;

--
-- Contraintes pour la table `ligne_commande`
--
ALTER TABLE `ligne_commande`
  ADD CONSTRAINT `fk_ligne_commande_commande` FOREIGN KEY (`id_commande`) REFERENCES `commande` (`id_commande`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_ligne_commande_produit` FOREIGN KEY (`id_produit`) REFERENCES `produit` (`id_produit`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
