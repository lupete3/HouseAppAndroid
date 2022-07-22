-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Client: localhost
-- Généré le: Lun 26 Août 2019 à 09:26
-- Version du serveur: 5.5.24-log
-- Version de PHP: 5.3.13

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données: `house_bk`
--
CREATE DATABASE IF NOT EXISTS house_bk;
USE house_bk;
-- --------------------------------------------------------

--
-- Structure de la table `agents`
--

CREATE TABLE IF NOT EXISTS `agents` (
  `IdAg` int(11) NOT NULL AUTO_INCREMENT,
  `NomAg` varchar(30) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `PrenomAg` varchar(30) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `Sexe` varchar(10) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `Adresse` varchar(30) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `Email` varchar(50) CHARACTER SET utf32 COLLATE utf32_bin NOT NULL,
  `Password` varchar(30) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `Telephone` varchar(15) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `Avatar` varchar(30) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `agentscol` varchar(45) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`IdAg`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Contenu de la table `agents`
--

INSERT INTO `agents` (`IdAg`, `NomAg`, `PrenomAg`, `Sexe`, `Adresse`, `Email`, `Password`, `Telephone`, `Avatar`, `agentscol`) VALUES
(1, 'Lupete Placide', 'ArsÃ¨ne ', 'Masculin', 'Bukavu', 'placide@gmail.com', 'placide', '0989672310', '1.jpg', '');

-- --------------------------------------------------------

--
-- Structure de la table `bailleurs`
--

CREATE TABLE IF NOT EXISTS `bailleurs` (
  `IdBail` int(11) NOT NULL AUTO_INCREMENT,
  `NomBail` varchar(30) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `PrenomBail` varchar(30) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `Sexe` varchar(10) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `DateNaiss` date NOT NULL,
  `EtatCivil` varchar(15) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `Nationalite` varchar(30) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `Residence` varchar(30) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `Email` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `NumPieceIdent` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `Password` varchar(30) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `TelBail` varchar(15) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `Avatar` varchar(30) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`IdBail`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Contenu de la table `bailleurs`
--

INSERT INTO `bailleurs` (`IdBail`, `NomBail`, `PrenomBail`, `Sexe`, `DateNaiss`, `EtatCivil`, `Nationalite`, `Residence`, `Email`, `NumPieceIdent`, `Password`, `TelBail`, `Avatar`) VALUES
(1, 'Mbale', 'Deogratias', 'Masculin', '2019-07-06', 'Célibataire', 'Congolaise', 'Bukavu', 'deo@gmail.com', '123456', 'deo', '0987654322', '1.jpg'),
(2, 'Bahati', 'Serges', 'Masculin', '1996-04-03', 'Célibataire', 'Congolaise', 'Bukavu', 'serges@gmail.com', '124581', 'serges', '0989876742', '2.jpg'),
(3, 'Marie', 'Florentine', 'FÃ©minin', '2019-07-06', 'MariÃ©', 'Congolaise', 'Kamituga', 'marie@gmail.com', '321424', 'marie', '+243978890310', '3.jpg'),
(4, 'Vick', 'Mukamba', 'Masculin', '2004-08-11', 'MariÃ©', 'Congolaise', 'Muhungu', 'vickmm2001@yahoo.fr', '098009', 'vick', '0989876564', '4.jpg');

-- --------------------------------------------------------

--
-- Structure de la table `galeries`
--

CREATE TABLE IF NOT EXISTS `galeries` (
  `IdIm` int(11) NOT NULL AUTO_INCREMENT,
  `LibellePhoto` varchar(30) NOT NULL,
  `DescriptionPhoto` longtext NOT NULL,
  `DateCreation` date NOT NULL,
  `Galerie` varchar(30) NOT NULL,
  `IdMaison` int(11) DEFAULT NULL,
  PRIMARY KEY (`IdIm`),
  KEY `fk_galeries_maisons1_idx` (`IdMaison`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=50 ;

--
-- Contenu de la table `galeries`
--

INSERT INTO `galeries` (`IdIm`, `LibellePhoto`, `DescriptionPhoto`, `DateCreation`, `Galerie`, `IdMaison`) VALUES
(20, 'Chambre', 'Chambre de 5m2', '2019-04-11', 'M3.JPG', 3),
(21, 'Dépôt', 'Dépôt de 4m2 pout stocker vos biens', '2019-04-03', '21.jpg', 1),
(22, 'Salon', 'Salon de 10m2 avec une salle à manger', '2019-04-09', 'M6.JPG', 2),
(23, 'Dépôt', 'Dépôt de 4m2 pout stocker vos biens', '2019-04-03', 'M7.JPG', 4),
(24, 'Salon', 'Salon de 10m2 avec une salle à manger', '2019-04-09', 'M2.JPG', 3),
(25, 'Dépôt', 'Dépôt de 4m2 pout stocker vos biens', '2019-04-03', 'M7.JPG', 4),
(26, 'Salon', 'Salon de 10m2 avec une salle à manger', '2019-04-09', 'M2.JPG', 3),
(27, 'Douche', 'Douche de 5m2 ', '2019-04-03', 'M1.JPG', 4),
(28, 'Salon', 'Salon de 10m2 avec une salle à manger', '2019-04-09', 'M9.JPG', 3),
(29, 'Douche', 'Douche de 5m2 ', '2019-04-03', 'M1.JPG', 4),
(30, 'Salon', 'Salon de 10m2 avec une salle à manger', '2019-04-09', 'M9.JPG', 3),
(31, 'Douche', 'Douche de 5m2 ', '2019-04-03', 'M1.JPG', 4),
(32, 'Salon', 'Salon de 10m2 avec une salle à manger', '2019-04-09', 'M9.JPG', 3),
(33, 'Douche', 'Douche de 5m2 ', '2019-04-03', 'M1.JPG', 4),
(34, 'Salon', 'Salon de 10m2 avec une salle à manger', '2019-04-09', 'M9.JPG', 3),
(35, 'Douche', 'Douche de 5m2 ', '2019-04-03', 'M1.JPG', 4),
(36, 'Salon', 'Salon de 10m2 avec une salle à manger', '2019-04-09', 'M9.JPG', 3),
(37, 'Chambre', 'Chambre de 10m2', '2019-04-15', '37.jpg', 13),
(38, 'Chambre', 'Chambre de 10m2', '2019-04-15', '38.jpg', 13),
(39, 'Chambre', 'Chambre de 10m2', '2019-04-17', '39.jpg', 9),
(40, 'terrasse ', 'terra9', '2019-06-04', '21.png', 8),
(41, 'Terrasse', 'Une terrasse ', '2019-06-10', '22.jpg', 21),
(42, 'Chambre', 'Une chambre de 10m2', '2019-08-21', '23.jpg', 23),
(43, 'Terrasse', 'Une terrasse pour se reoser', '2019-08-21', '24.jpg', 23),
(44, 'Piscine', 'Une piscine pour se baigner', '2019-08-21', '25.jpg', 23),
(45, 'Terrasse', 'une terrasse', '2019-08-21', '26.jpg', 22),
(46, 'Piscine', 'Une piscine pour se baigner', '2019-08-21', '27.jpg', 23),
(47, 'Chambre', 'Une chambre de 15m2', '2019-08-21', '28.jpg', 16),
(48, 'Espace', 'Espace pour se dÃ©tendre', '2019-08-21', '29.jpg', 16),
(49, 'Piscine', 'Une piscine accessible Ã  tout le monde', '2019-08-21', '30.jpg', 16);

-- --------------------------------------------------------

--
-- Structure de la table `locataires`
--

CREATE TABLE IF NOT EXISTS `locataires` (
  `IdLoc` int(11) NOT NULL AUTO_INCREMENT,
  `NomLoc` varchar(30) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `PrenomLoc` varchar(30) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `SexeLoc` varchar(10) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `DateNaissLoc` date NOT NULL,
  `EtatCivilLoc` varchar(15) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `NationaliteLoc` varchar(30) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `EmailLoc` varchar(30) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `ResidenceLoc` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `NumPieceLoc` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `Password` varchar(30) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `TelephoneLoc` varchar(15) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `AvatarLoc` varchar(30) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`IdLoc`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Contenu de la table `locataires`
--

INSERT INTO `locataires` (`IdLoc`, `NomLoc`, `PrenomLoc`, `SexeLoc`, `DateNaissLoc`, `EtatCivilLoc`, `NationaliteLoc`, `EmailLoc`, `ResidenceLoc`, `NumPieceLoc`, `Password`, `TelephoneLoc`, `AvatarLoc`) VALUES
(1, 'Riziki Justin', 'Marceline', 'Feminin', '2019-07-08', 'Célibataire', 'Congolaise', 'riziki@gmail.com', 'Kamituga', '221133', 'riziki', '+243998776543', '1.jpg'),
(2, 'Jule Kolele', 'Serge', 'Feminin', '2003-09-09', 'Marié', 'Rwandaise', 'serge@gmail.com', 'kamembe', '908978', 'serge', '+243998987612', '2.jpg'),
(3, 'David Kola', 'David', 'Feminin', '2019-09-08', 'Marié', 'Congolaise', 'david@gmail.com', 'Pageco', '909787', 'david', '+243975093746', '3.jpg'),
(4, 'Mulamba', 'Luc', 'Masculin', '1993-05-12', 'Célibataire', 'Congolaise', 'luca@gmail.com', 'Pageco', '909787', 'luc', '+243978333654', '4.jpg'),
(5, 'Marcelin Ndume', 'Marcelin', 'Masculin', '1993-05-12', 'Célibataire', 'Congolaise', 'marcelin@gmail.com', 'Pageco', '909787', 'marcelin', '+243978333654', '5.jpg'),
(6, 'Wilo', 'Freddy', 'Masculin', '1988-03-29', 'Célibataire', 'Congolaise', 'wilo@gmail.com', 'Muhungu', '909990', 'wilo', '+243978390875', '6.jpg'),
(7, 'Mali', 'Jeanne', 'Feminin', '1996-06-17', 'Célibataire', 'Congolaise', 'mali@gmail.com', ' Kamituga', '098787', 'mali', '0987876876', '7.jpg'),
(8, 'mukamba', 'mukandama', 'Masculin', '2019-05-06', 'Célibataire', 'Congolaise', 'vickmm2001@yahoo.fr', 'muhungu', '254566699874', '1234', '0989876564', '8.jpg');

-- --------------------------------------------------------

--
-- Structure de la table `maisons`
--

CREATE TABLE IF NOT EXISTS `maisons` (
  `IdM` int(11) NOT NULL AUTO_INCREMENT,
  `Libelle` longtext NOT NULL,
  `Num` varchar(30) NOT NULL,
  `Prix` int(11) NOT NULL,
  `Commune` varchar(30) NOT NULL,
  `Quartier` varchar(30) NOT NULL,
  `Avenue` varchar(30) NOT NULL,
  `NbChambre` int(11) NOT NULL,
  `NbSalon` int(11) NOT NULL,
  `NbDouche` int(11) NOT NULL,
  `Description` longtext NOT NULL,
  `EtatMaison` varchar(20) NOT NULL,
  `StatutMaison` varchar(10) NOT NULL,
  `DateOffre` date NOT NULL,
  `Photo` varchar(30) NOT NULL,
  `IdB` int(11) DEFAULT NULL,
  `IdAdm` int(11) DEFAULT NULL,
  PRIMARY KEY (`IdM`),
  KEY `fk_maisons_bailleurs_idx` (`IdB`),
  KEY `fk_maisons_agents1_idx` (`IdAdm`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=24 ;

--
-- Contenu de la table `maisons`
--

INSERT INTO `maisons` (`IdM`, `Libelle`, `Num`, `Prix`, `Commune`, `Quartier`, `Avenue`, `NbChambre`, `NbSalon`, `NbDouche`, `Description`, `EtatMaison`, `StatutMaison`, `DateOffre`, `Photo`, `IdB`, `IdAdm`) VALUES
(1, 'Appartement recent de 3 chambres à Ibanda', '332B', 200, 'Ibanda', 'Ndendere', 'Poste 1', 4, 1, 1, 'En centre-ville, à proximite des axes passants, 2 villas mitoyennes dans une parcelle close Elle se distribue comme suit  Pour l’une : - salon / séjour lumineux - cuisine - 2 chambres - 1 salle de bains - terrasse - toilettes...', 'Occupee', 'Valide', '2019-04-12', 'M1.JPG', 1, 1),
(2, 'Une maison de 2 Chambre à Kadutu', '8810', 100, 'Kadutu', 'Kasali', 'Coopera', 2, 1, 1, 'Au près de la route, avec une terrasse et un espace aérée, un dépôt pour la nourriture\n', 'Occupee', 'Valide', '2019-04-12', 'M2.JPG', 2, 1),
(3, 'Appartement de 3 chambres ', '441J', 150, 'Kadutu', 'Mosala', 'Limanga', 3, 1, 1, 'A proximité du petit marché limanga, vers la route menant à l''industriel, avec un veranda, avec un dépôt pour vos nourritures \n', 'Innocupee', 'Valide', '2019-04-12', 'M3.JPG', 2, 1),
(4, 'Appartement de 3 chambres dans Kadutu', '8900', 150, 'Kadutu', 'Kasali', 'Coopera', 3, 1, 1, 'En centre-ville, à proximite des axes passants, 2 villas mitoyennes dans une parcelle close Elle se distribue comme suit Pour l''''une : - salon / séjour lumineux - cuisine - 2 chambres - 1 salle de bains - terrasse - toilettes...', 'Innocupee', 'Valide', '2019-04-12', 'M4.JPG', 2, 1),
(5, 'Appartement recent de 3 chambres dans Kadutu', '1109', 150, 'Bagira', 'Lumumba', 'Quartier A', 3, 1, 1, 'En centre-ville, à proximite des axes passants, 2 villas mitoyennes dans une parcelle close Elle se distribue comme suit Pour l''''une : - salon / séjour lumineux - cuisine - 2 chambres - 1 salle de bains - terrasse - toilettes...', 'Innocupee', 'Valide', '2019-04-12', 'M5.JPG', 2, 1),
(6, 'Appartement nouveau de 3chambres dans Ibanda', '3340', 180, 'Ibanda', 'Ndendere', 'Route Ouvira', 3, 1, 1, 'A coté de la route principale menant vers Essence, la charge du courant et au bailleur, avec un parking\n', 'Innocupee', 'Valide', '2019-04-12', 'M6.JPG', 2, 1),
(7, 'Appartement de 3 Chambres dans Ibanda', '321D', 150, 'Ibanda', 'Panzi', 'Mushununu', 3, 1, 1, 'En centre-ville, à proximite des axes passants, 2 villas mitoyennes dans une parcelle close Elle se distribue comme suit Pour l''''une : - salon / séjour lumineux - cuisine - 2 chambres - 1 salle de bains - terrasse - toilettes...', 'Innocupee', 'Valide', '2019-04-12', 'M7.JPG', 2, 1),
(8, 'Appartement de 3 chambre dans Ibanda', '2210', 150, 'Ibanda', 'Ndendere', 'Vamaro', 3, 1, 1, 'Avec une terrasse et un balcon; un dépôt pour la nourriture, un espace aérée, courant et l''eau au compte du Bailleur,... ', 'Innocupee', 'Valide', '2019-04-12', 'M8.JPG', 2, 1),
(9, 'Un Appartement nouveau de 3 chambres dans Kadutu', '1130', 110, 'Ibanda', 'Nyalukemba', 'Hypodrome', 3, 1, 1, 'En centre-ville, à proximite des axes passants, 2 villas mitoyennes dans une parcelle close Elle se distribue comme suit Pour l''''une : - salon / séjour lumineux - cuisine - 2 chambres - 1 salle de bains - terrasse - toilettes...', 'Innocupee', 'Valide', '2019-04-12', 'M9.JPG', 2, 1),
(10, 'Appartement recent de 3 chambres dans Kadutu', '129G', 150, 'Bagira', 'Lumumba', 'Quartier A', 3, 1, 1, 'En centre-ville, à proximite des axes passants, 2 villas mitoyennes dans une parcelle close Elle se distribue comme suit Pour l''''une : - salon / séjour lumineux - cuisine - 2 chambres - 1 salle de bains - terrasse - toilettes...', 'Innocupee', 'Valide', '2019-04-12', 'M10.JPG', 2, 1),
(11, 'Nouveau Appartement dans Ibanda', '510E', 300, 'Ibanda', 'Ndendere', 'Kasai', 5, 1, 1, 'Avec un parking pour vos véhicules, une terrasses pour vos cérémonies, un dépôt pour vos nourriture, l''eau et courant diponible', 'Innocupee', 'Valide', '2019-04-12', 'M11.JPG', 2, 1),
(12, 'Nouveau Appartement recent de 3 chambres dans Ibanda', '652C', 160, 'Ibanda', 'Ndendere', 'Poste', 3, 1, 1, 'A coté de la prison centrale de Bukavu, avec une sécurité, l''eau et courant disponible, la charge du courant et de l''eau revient au locataire', 'Innocupee', 'Valide', '2019-04-12', 'M12.JPG', 2, 1),
(13, 'Appartement recent de 3 chambres dans Kadutu', '901C', 150, 'Bagira', 'Lumumba', 'Quartier A', 3, 1, 1, 'En centre-ville, à proximite des axes passants, 2 villas mitoyennes dans une parcelle close Elle se distribue comme suit Pour l''''une : - salon / séjour lumineux - cuisine - 2 chambres - 1 salle de bains - terrasse - toilettes...', 'Innocupee', 'Valide', '2018-12-10', 'M13.JPG', 2, 1),
(15, 'Appartement recent de 3 chambres dans Kadutu', '109A', 150, 'Bagira', 'Lumumba', 'Quartier A', 3, 1, 1, 'En centre-ville, à proximite des axes passants, 2 villas mitoyennes dans une parcelle close Elle se distribue comme suit Pour l''''une : - salon / séjour lumineux - cuisine - 2 chambres - 1 salle de bains - terrasse - toilettes...', 'Innocupee', 'Invalide', '2019-08-23', 'M15.JPG', 1, NULL),
(16, 'Appartement recent de 5 chambres dans Kadutu', '881C', 150, 'Ibanda', 'Ndendere', 'Kibombo', 4, 1, 1, 'En centre-ville, à proximite des axes passants, 2 villas mitoyennes dans une parcelle close Elle se distribue comme suit Pour l''''une : - salon / séjour lumineux - cuisine - 2 chambres - 1 salle de bains - terrasse - toilettes...', 'Innocupee', 'Valide', '2019-08-11', '16.jpg', 1, 1),
(17, 'Appartement à 4 chambres', '556F', 250, 'Ibanda', 'Ndendere', 'Saio', 4, 2, 1, 'Maison avec une terrasse; au bord du lac; la prise en charge du courant et de l''eau. une maison avec un dépôt pour bien garder la nourriture. une clôture pour une meilleure sécurité', 'Innocupee', 'Invalide', '2019-04-01', 'M3.JPG', 1, NULL),
(18, 'Appartement de 4 de chambres', '541F', 250, 'Ibanda', 'Ndendere', 'Saio', 4, 2, 1, 'Maison se trouvant au bord du lac. La prise en charge du courant et de l''eau. une belle terrasse; un dÃ©pÃ´t pour la conservation des nourritures', 'Occupee', 'Valide', '2019-04-14', '18.jpg', 1, 1),
(19, 'Appartement de 4 de chambres', '00FD', 250, 'Ibanda', 'Ndendere', 'Muhungu', 3, 1, 1, 'Une nouvelle maison', 'Innocupee', 'Valide', '2019-08-11', '18.png', 4, 1),
(20, 'Appartement de 4 de chambres', '00F1', 250, 'Ibanda', 'Ndendere', 'Muhungu', 4, 1, 1, 'une belle maison', 'Occupee', 'Valide', '2019-08-11', '19.png', 4, 1),
(21, 'Appartement de 4 de chambres avec terrasse', '00GS', 250, 'Ibanda', 'Ndendere', 'Fizi', 4, 2, 2, 'Un appartement pas comme les autres', 'Occupee', 'Valide', '2019-08-11', '20.jpg', 4, 1),
(22, 'Nouvelle maison dans Ibanda', '00G0', 200, 'Ibanda', 'Ndendere', 'Muhungu', 3, 1, 1, 'nouvelle maison', 'Occupee', 'Valide', '2019-08-18', '21.jpg', 1, 1),
(23, 'Appartement de 4 de chambres', '00FD', 200, 'Ibanda', 'Ndendere', 'Muhungu', 4, 1, 1, 'Nouvelle maison', 'Innocupee', 'Valide', '2019-08-18', '22.jpg', 1, 1);

-- --------------------------------------------------------

--
-- Structure de la table `reservations`
--

CREATE TABLE IF NOT EXISTS `reservations` (
  `IdRes` int(11) NOT NULL AUTO_INCREMENT,
  `DateRes` date NOT NULL,
  `NbMois` int(11) NOT NULL,
  `DebutContrat` date NOT NULL,
  `StatutRes` varchar(30) NOT NULL,
  `IdLocat` int(11) DEFAULT NULL,
  `IdMaison` int(11) DEFAULT NULL,
  `IdAgent` int(11) DEFAULT NULL,
  `Accord` varchar(10) NOT NULL,
  PRIMARY KEY (`IdRes`),
  KEY `fk_reservations_maisons1_idx` (`IdMaison`),
  KEY `fk_reservations_locataires1_idx` (`IdLocat`),
  KEY `fk_reservations_agents1_idx` (`IdAgent`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=23 ;

--
-- Contenu de la table `reservations`
--

INSERT INTO `reservations` (`IdRes`, `DateRes`, `NbMois`, `DebutContrat`, `StatutRes`, `IdLocat`, `IdMaison`, `IdAgent`, `Accord`) VALUES
(1, '2019-04-11', 1, '2019-05-01', 'Valide', 1, 1, 1, 'Oui'),
(2, '2019-04-11', 6, '2019-08-18', 'Valide', 2, 2, 1, 'Oui'),
(3, '2019-04-11', 7, '0000-00-00', 'Invalide', 2, 12, NULL, 'Non'),
(4, '2019-04-11', 12, '2019-08-10', 'Valide', 2, 11, 1, 'Oui'),
(6, '2019-04-12', 10, '2019-08-25', 'Valide', 1, 7, 1, 'Oui'),
(7, '2019-04-15', 12, '2019-08-25', 'Valide', 1, 9, 1, 'Oui'),
(9, '2019-06-09', 5, '2019-08-11', 'Valide', 1, 13, 1, 'Oui'),
(10, '2019-06-14', 5, '0000-00-00', 'Invalide', 1, 8, NULL, 'Non'),
(11, '2019-08-10', 12, '0000-00-00', 'Invalide', 1, 16, NULL, 'Non'),
(12, '2019-08-11', 5, '2019-08-11', 'Valide', 1, 19, 1, 'Oui'),
(21, '2019-08-18', 24, '2019-08-18', 'Valide', 7, 22, 1, 'Oui'),
(22, '2019-08-23', 48, '2019-08-23', 'Valide', 1, 18, 1, 'Oui');

--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `galeries`
--
ALTER TABLE `galeries`
  ADD CONSTRAINT `fk_galeries_maisons1` FOREIGN KEY (`IdMaison`) REFERENCES `maisons` (`IdM`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Contraintes pour la table `maisons`
--
ALTER TABLE `maisons`
  ADD CONSTRAINT `fk_maisons_agents1` FOREIGN KEY (`IdAdm`) REFERENCES `agents` (`IdAg`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_maisons_bailleurs` FOREIGN KEY (`IdB`) REFERENCES `bailleurs` (`IdBail`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Contraintes pour la table `reservations`
--
ALTER TABLE `reservations`
  ADD CONSTRAINT `fk_reservations_agents1` FOREIGN KEY (`IdAgent`) REFERENCES `agents` (`IdAg`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_reservations_locataires1` FOREIGN KEY (`IdLocat`) REFERENCES `locataires` (`IdLoc`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_reservations_maisons1` FOREIGN KEY (`IdMaison`) REFERENCES `maisons` (`IdM`) ON DELETE SET NULL ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
