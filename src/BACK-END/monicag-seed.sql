-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  lun. 03 sep. 2018 à 23:28
-- Version du serveur :  5.7.21
-- Version de PHP :  7.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `monicag`
--

-- --------------------------------------------------------

--
-- Structure de la table `inventory`
--

DROP TABLE IF EXISTS `inventory`;
CREATE TABLE IF NOT EXISTS `inventory` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `entry_date` date NOT NULL,
  `name` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FOREIGN_INVENTORY_STATUS_ID` (`status_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `referenceStatuses`
--

DROP TABLE IF EXISTS `referenceStatuses`;
CREATE TABLE IF NOT EXISTS `referenceStatuses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `referenceStatuses`
--

INSERT INTO `referenceStatuses` (`id`, `name`) VALUES
(1, 'Au local LCR D4'),
(2, 'Au local F2'),
(3, 'Emprunté'),
(4, 'Perdu'),
(5, 'Inconnu');

-- --------------------------------------------------------

--
-- Structure de la table `registryBorrowings`
--

DROP TABLE IF EXISTS `registryBorrowings`;
CREATE TABLE IF NOT EXISTS `registryBorrowings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `borrowed_inventory_item_id` int(11) NOT NULL,
  `borrower_id` int(11) NOT NULL,
  `lender_id` int(11) NOT NULL,
  `guarantee` int(11) DEFAULT NULL,
  `date_start` date NOT NULL,
  `date_expected_return` date NOT NULL,
  `date_actual_return` date DEFAULT NULL,
  `notes_before` varchar(5000) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `notes_after` varchar(5000) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FOREIGN_REGISTRY_BORROWINGS_LENDER_ID` (`lender_id`),
  KEY `FOREIGN_REGISTRY_BORROWINGS_INVENTORY_ITEM_ID` (`borrowed_inventory_item_id`),
  KEY `FOREIGN_REGISTRY_BORROWINGS_BORROWER_ID` (`borrower_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `hashedPassword` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `firstName` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lastName` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `promotion` int(11) NOT NULL,
  `admin` tinyint(1) NOT NULL,
  `lender` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `inventory`
--
ALTER TABLE `inventory`
  ADD CONSTRAINT `FOREIGN_INVENTORY_STATUS_ID` FOREIGN KEY (`status_id`) REFERENCES `referencestatuses` (`id`);

--
-- Contraintes pour la table `registryBorrowings`
--
ALTER TABLE `registryBorrowings`
  ADD CONSTRAINT `FOREIGN_REGISTRY_BORROWINGS_BORROWER_ID` FOREIGN KEY (`borrower_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `FOREIGN_REGISTRY_BORROWINGS_INVENTORY_ITEM_ID` FOREIGN KEY (`borrowed_inventory_item_id`) REFERENCES `inventory` (`id`),
  ADD CONSTRAINT `FOREIGN_REGISTRY_BORROWINGS_LENDER_ID` FOREIGN KEY (`lender_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
