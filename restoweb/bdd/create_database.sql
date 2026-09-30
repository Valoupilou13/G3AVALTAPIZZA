-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le : mer. 30 sep. 2026 à 13:09
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
-- Déclencheurs `ligne_commande`
--
DELIMITER $$
CREATE TRIGGER `after_ligne_update` 
AFTER UPDATE ON `ligne_commande` 
FOR EACH ROW 
BEGIN
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
CREATE TRIGGER `maj_total_commande_after_insert` 
AFTER INSERT ON `ligne_commande` 
FOR EACH ROW 
BEGIN
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

DELIMITER $$
CREATE TRIGGER `calcul_total_ligne_before_insert` 
BEFORE INSERT ON `ligne_commande` 
FOR EACH ROW 
BEGIN
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
--
-- Structure de la table `produit`
--

-- Structure de la table produit
CREATE TABLE IF NOT EXISTS produit (
    id_produit INT AUTO_INCREMENT PRIMARY KEY,
    libelle VARCHAR(100) NOT NULL,
    prix_ht DECIMAL(10,2) NOT NULL,
    image VARCHAR(255) DEFAULT 'default.jpg'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Données de test
INSERT INTO produit (libelle, prix_ht, image) VALUES
('Pizza Margherita', 8.50, 'margherita.jpg'),
('Pizza 4 Fromages', 10.00, '4fromages.jpg'),
('Pizza Reine', 9.50, 'reina.jpg'),
('Pizza Calzone', 9.50, 'calzone.jpg'),
('Pizza Orientale', 10.00, 'orientale.jpg'),
('Soda 33cl', 2.27, 'soda.jpg'),
('Bière 33cl', 3.00, 'biere.jpg'),
('Tiramisu', 3.50, 'tiramisu.jpg'),
('Panna Cotta', 3.50, 'pannacotta.jpg'),
('Menu Solo', 11.50, 'menu_solo.jpg'),
('Menu Duo', 20.00, 'menu_duo.jpg'),
('Menu Maxi', 28.00, 'menu_maxi.jpg');

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
  MODIFY `id_commande` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `ligne_commande`
--
ALTER TABLE `ligne_commande`
  MODIFY `id_ligne_commande` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `produit`
--
ALTER TABLE `produit`
  MODIFY `id_produit` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT;

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
