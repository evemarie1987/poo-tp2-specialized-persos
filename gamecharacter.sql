-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  ven. 05 jan. 2018 à 18:38
-- Version du serveur :  5.7.19
-- Version de PHP :  7.1.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `openclassrooms`
--

-- --------------------------------------------------------

--
-- Structure de la table `gamecharacter`
--

DROP TABLE IF EXISTS `gamecharacter`;
CREATE TABLE IF NOT EXISTS `gamecharacter` (
  `id` tinyint(2) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  `damaged` tinyint(3) UNSIGNED NOT NULL DEFAULT '0',
  `type` enum('magicien','warrior') NOT NULL,
  `asset` tinyint(3) UNSIGNED NOT NULL DEFAULT '5',
  `timeAsleep` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `level` smallint(4) UNSIGNED NOT NULL DEFAULT '1',
  `experience` tinyint(3) UNSIGNED NOT NULL DEFAULT '0',
  `strength` tinyint(3) UNSIGNED NOT NULL DEFAULT '5',
  `numberOfHits` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `lastHitDate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `lastConnected` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `gamecharacter`
--

INSERT INTO `gamecharacter` (`id`, `name`, `damaged`, `type`, `asset`, `timeAsleep`, `level`, `experience`, `strength`, `numberOfHits`, `lastHitDate`, `lastConnected`) VALUES
(4, 'Monstersqueen', 40, 'warrior', 3, 1515276360, 2, 13, 8, 1, '2018-01-05 00:00:00', '2018-01-05 00:00:00'),
(3, 'Michloune', 0, 'magicien', 4, 1515171188, 1, 45, 5, 3, '2018-01-05 00:00:00', '2018-01-05 00:00:00'),
(5, 'Mich Loinvoyant', 71, 'magicien', 4, 1515171188, 1, 15, 5, 3, '2018-01-05 00:00:00', '2018-01-05 00:00:00');

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
