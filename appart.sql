-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  ven. 20 nov. 2020 à 13:07
-- Version du serveur :  10.4.10-MariaDB
-- Version de PHP :  7.3.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `appart`
--

-- --------------------------------------------------------

--
-- Structure de la table `admin`
--

DROP TABLE IF EXISTS `admin`;
CREATE TABLE IF NOT EXISTS `admin` (
  `id_admin` int(11) NOT NULL AUTO_INCREMENT,
  `pseudo` varchar(20) NOT NULL,
  `mdp` varchar(30) NOT NULL,
  `type` varchar(20) NOT NULL,
  PRIMARY KEY (`id_admin`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `admin`
--

INSERT INTO `admin` (`id_admin`, `pseudo`, `mdp`, `type`) VALUES
(11, 'Danype', 'D@nype123', 'super'),
(12, 'kakashi', 'KAKASHI123', 'standar'),
(13, 'naruto', 'NAURTO123', '');

-- --------------------------------------------------------

--
-- Structure de la table `appartement`
--

DROP TABLE IF EXISTS `appartement`;
CREATE TABLE IF NOT EXISTS `appartement` (
  `id_appart` int(11) NOT NULL AUTO_INCREMENT,
  `lib_appart` varchar(30) NOT NULL,
  `tar_jour` int(11) NOT NULL,
  `tar_mois` int(11) NOT NULL,
  `id_bat` int(3) NOT NULL,
  PRIMARY KEY (`id_appart`),
  KEY `appartement_ibfk_1` (`id_bat`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `appartement`
--

INSERT INTO `appartement` (`id_appart`, `lib_appart`, `tar_jour`, `tar_mois`, `id_bat`) VALUES
(1, 'A1_4PIECES', 150000, 2500000, 1),
(2, 'A2_4PIECES', 150000, 2500000, 1),
(3, 'A3_4PIECES', 150000, 2500000, 1),
(4, 'A4_4PIECES', 150000, 2500000, 1),
(5, 'B1_4PIECES', 200000, 3000000, 2),
(6, 'B2_4PIECES', 200000, 3000000, 2),
(7, 'B3_3PIECES', 150000, 2000000, 2),
(8, 'B0_SUITE', 200000, 2500000, 2),
(9, 'B5_SUITE', 200000, 2500000, 2),
(10, 'B6_SUITE', 150000, 2000000, 2),
(11, 'B7_SUITE', 150000, 2000000, 2);

-- --------------------------------------------------------

--
-- Structure de la table `batiment`
--

DROP TABLE IF EXISTS `batiment`;
CREATE TABLE IF NOT EXISTS `batiment` (
  `id_bat` int(3) NOT NULL AUTO_INCREMENT,
  `lib_bat` varchar(30) NOT NULL,
  PRIMARY KEY (`id_bat`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `batiment`
--

INSERT INTO `batiment` (`id_bat`, `lib_bat`) VALUES
(1, 'BATIMENT A'),
(2, 'BATIMENT B'),
(3, 'BATIMENT C'),
(4, 'BATIMENT D');

-- --------------------------------------------------------

--
-- Structure de la table `client`
--

DROP TABLE IF EXISTS `client`;
CREATE TABLE IF NOT EXISTS `client` (
  `id_clt` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(10) NOT NULL,
  `nom_clt` varchar(60) NOT NULL,
  `pnom_clt` varchar(60) NOT NULL,
  `tel` varchar(60) NOT NULL,
  `mail` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  PRIMARY KEY (`id_clt`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `client`
--

INSERT INTO `client` (`id_clt`, `title`, `nom_clt`, `pnom_clt`, `tel`, `mail`, `address`) VALUES
(8, 'M', 'kacou', 'daniel', '89880477', 'Kadep198@gmail.com', 'BP ABIDJAN 02'),
(12, 'Mme', 'KOKORA', 'BROU PELAGIE', '46471471', 'pelagiekokorabrou@gmail.com', ''),
(13, 'M', 'KADIO', 'JACQUES', '12345678', 'jaq@gmail.com', '');

-- --------------------------------------------------------

--
-- Structure de la table `entretien`
--

DROP TABLE IF EXISTS `entretien`;
CREATE TABLE IF NOT EXISTS `entretien` (
  `id_ent` varchar(11) NOT NULL,
  `lib_ent` varchar(255) NOT NULL,
  `id_appart` int(11) NOT NULL,
  `dat_op` date NOT NULL,
  `mont_entretien` int(11) NOT NULL,
  PRIMARY KEY (`id_ent`),
  KEY `id_appart` (`id_appart`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `entretien`
--

INSERT INTO `entretien` (`id_ent`, `lib_ent`, `id_appart`, `dat_op`, `mont_entretien`) VALUES
('ENT13901', 'lavage', 6, '2020-07-30', 120000),
('ENT24727', 'lavage', 1, '2020-07-30', 100000),
('ENT27637', 'lavage', 5, '2020-07-04', 100000),
('ENT65631', 'lavage', 5, '2020-07-31', 500000),
('ENT665', 'balyage', 1, '2020-07-19', 500000),
('ENT91407', 'lavage', 5, '2020-07-30', 400000);

-- --------------------------------------------------------

--
-- Structure de la table `facture`
--

DROP TABLE IF EXISTS `facture`;
CREATE TABLE IF NOT EXISTS `facture` (
  `id_fact` varchar(40) NOT NULL,
  `mont_pay` int(30) NOT NULL,
  `id_reserv` varchar(30) NOT NULL,
  `dat_emi` date NOT NULL,
  `rest_a_pay` int(30) NOT NULL,
  `hr_emi` time NOT NULL,
  `s` tinyint(1) NOT NULL,
  `id_pay` int(11) NOT NULL,
  PRIMARY KEY (`id_fact`),
  KEY `id_reserv` (`id_reserv`),
  KEY `id_pay` (`id_pay`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `facture`
--

INSERT INTO `facture` (`id_fact`, `mont_pay`, `id_reserv`, `dat_emi`, `rest_a_pay`, `hr_emi`, `s`, `id_pay`) VALUES
('F2156', 1504237, 'RESER6076', '2020-10-20', 1504237, '10:09:13', 0, 4);

-- --------------------------------------------------------

--
-- Structure de la table `lit`
--

DROP TABLE IF EXISTS `lit`;
CREATE TABLE IF NOT EXISTS `lit` (
  `id_lit` int(30) NOT NULL AUTO_INCREMENT,
  `nb_place` int(11) NOT NULL,
  `id_appart` int(11) NOT NULL,
  PRIMARY KEY (`id_lit`),
  KEY `lit_ibfk_1` (`id_appart`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `lit`
--

INSERT INTO `lit` (`id_lit`, `nb_place`, `id_appart`) VALUES
(1, 3, 1),
(2, 3, 2),
(3, 3, 3),
(4, 3, 4),
(5, 3, 5),
(6, 3, 6),
(7, 3, 7),
(8, 3, 7),
(9, 3, 8),
(10, 3, 9),
(11, 3, 10),
(12, 3, 11),
(13, 2, 1),
(14, 2, 2),
(15, 2, 3),
(16, 2, 4),
(17, 2, 5),
(18, 2, 5),
(19, 2, 6),
(20, 2, 6),
(21, 1, 1),
(22, 1, 2),
(23, 1, 3),
(24, 1, 4);

-- --------------------------------------------------------

--
-- Structure de la table `payment`
--

DROP TABLE IF EXISTS `payment`;
CREATE TABLE IF NOT EXISTS `payment` (
  `id_pay` int(11) NOT NULL AUTO_INCREMENT,
  `mod_pay` varchar(45) NOT NULL,
  PRIMARY KEY (`id_pay`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `payment`
--

INSERT INTO `payment` (`id_pay`, `mod_pay`) VALUES
(1, 'par chèque'),
(2, 'En espèce'),
(3, 'par virement'),
(4, 'inconnu');

-- --------------------------------------------------------

--
-- Structure de la table `reservation`
--

DROP TABLE IF EXISTS `reservation`;
CREATE TABLE IF NOT EXISTS `reservation` (
  `id_reserv` varchar(30) NOT NULL,
  `id_appart` int(11) NOT NULL,
  `id_clt` int(11) NOT NULL,
  `dat_reserv` date NOT NULL,
  `nb_adlt` int(11) NOT NULL,
  `nb_enf` int(11) NOT NULL,
  `mont_reserv` int(30) NOT NULL,
  `dat_arriv` date NOT NULL,
  `dat_dep` date NOT NULL,
  `statut` tinyint(1) NOT NULL,
  `nb_jr` int(11) NOT NULL,
  `hr_reserv` time NOT NULL,
  `objet` varchar(255) NOT NULL,
  `rem` int(10) NOT NULL,
  PRIMARY KEY (`id_reserv`),
  KEY `id_appart` (`id_appart`),
  KEY `id_clt` (`id_clt`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `reservation`
--

INSERT INTO `reservation` (`id_reserv`, `id_appart`, `id_clt`, `dat_reserv`, `nb_adlt`, `nb_enf`, `mont_reserv`, `dat_arriv`, `dat_dep`, `statut`, `nb_jr`, `hr_reserv`, `objet`, `rem`) VALUES
('RESER6076', 8, 8, '2020-10-20', 1, 0, 1504237, '2020-10-20', '2020-11-20', 0, 30, '10:09:13', 'Location d\'appartement(s) meublé(s)', 47);

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `appartement`
--
ALTER TABLE `appartement`
  ADD CONSTRAINT `appartement_ibfk_1` FOREIGN KEY (`id_bat`) REFERENCES `batiment` (`id_bat`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `entretien`
--
ALTER TABLE `entretien`
  ADD CONSTRAINT `entretien_ibfk_1` FOREIGN KEY (`id_appart`) REFERENCES `appartement` (`id_appart`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `facture`
--
ALTER TABLE `facture`
  ADD CONSTRAINT `facture_ibfk_1` FOREIGN KEY (`id_reserv`) REFERENCES `reservation` (`id_reserv`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `facture_ibfk_2` FOREIGN KEY (`id_pay`) REFERENCES `payment` (`id_pay`);

--
-- Contraintes pour la table `lit`
--
ALTER TABLE `lit`
  ADD CONSTRAINT `lit_ibfk_1` FOREIGN KEY (`id_appart`) REFERENCES `appartement` (`id_appart`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `reservation`
--
ALTER TABLE `reservation`
  ADD CONSTRAINT `reservation_ibfk_1` FOREIGN KEY (`id_appart`) REFERENCES `appartement` (`id_appart`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `reservation_ibfk_2` FOREIGN KEY (`id_clt`) REFERENCES `client` (`id_clt`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
