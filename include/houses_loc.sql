-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Client: localhost
-- Généré le: Lun 10 Juin 2019 à 13:29
-- Version du serveur: 5.5.24-log
-- Version de PHP: 5.3.13

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données: `houses_loc`
--

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
  `Email` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `Password` varchar(30) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `Telephone` varchar(20) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `Avatar` varchar(30) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`IdAg`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Contenu de la table `agents`
--

INSERT INTO `agents` (`IdAg`, `NomAg`, `PrenomAg`, `Sexe`, `Adresse`, `Email`, `Password`, `Telephone`, `Avatar`) VALUES
(1, 'Lupete Placid', 'ArsÃ¨ne ', 'Masculin', 'Bukavu', 'placide@gmail.com', 'placide', '0989672310', '1.png');

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
  `TelBail` varchar(20) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `Avatar` varchar(30) CHARACTER SET utf8 DEFAULT NULL,
  PRIMARY KEY (`IdBail`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Contenu de la table `bailleurs`
--

INSERT INTO `bailleurs` (`IdBail`, `NomBail`, `PrenomBail`, `Sexe`, `DateNaiss`, `EtatCivil`, `Nationalite`, `Residence`, `Email`, `NumPieceIdent`, `Password`, `TelBail`, `Avatar`) VALUES
(1, 'Mbale', 'Deogratias', 'FÃ©minin', '1998-06-05', 'CÃ©libataire', 'Congolaise', 'Bukavu', 'deo@gmail.com', '123456', 'deo', '0987654322', 'user.jpg'),
(2, 'Ishara', 'Kevin', 'Masculin', '1996-04-03', 'Célibataire', 'Congolaise', 'Bukavu', 'ishara@gmail.com', '124581', 'ishara', '0989876742', 'user.jpg'),
(3, 'Marie', 'Florentine', 'Féminin', '1974-03-09', 'Marié', 'Congolaise', 'Kamituga', 'marie@gmail.com', '321424', 'marie', '+243978890310', 'user.jpg');

-- --------------------------------------------------------

--
-- Structure de la table `galeries`
--

CREATE TABLE IF NOT EXISTS `galeries` (
  `IdIm` int(11) NOT NULL AUTO_INCREMENT,
  `LibellePhoto` varchar(30) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `DescriptionPhoto` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `DateCreation` date NOT NULL,
  `Galerie` varchar(30) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `IdMaison` int(11) NOT NULL,
  PRIMARY KEY (`IdIm`),
  KEY `IdMaison` (`IdMaison`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=41 ;

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
(40, 'terrasse ', 'terra9', '2019-06-04', '21.png', 8);

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
  `ResidenceLoc` varchar(30) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `EmailLoc` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `NumPieceLoc` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `Password` varchar(30) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `TelephoneLoc` varchar(20) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `AvatarLoc` varchar(30) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`IdLoc`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Contenu de la table `locataires`
--

INSERT INTO `locataires` (`IdLoc`, `NomLoc`, `PrenomLoc`, `SexeLoc`, `DateNaissLoc`, `EtatCivilLoc`, `NationaliteLoc`, `ResidenceLoc`, `EmailLoc`, `NumPieceLoc`, `Password`, `TelephoneLoc`, `AvatarLoc`) VALUES
(1, 'Riziki Justine', 'Marceline', 'Féminin', '1994-01-10', 'Célibataire', 'Congolaise', 'Kamituga', 'riziki@gmail.com', '221133', 'riziki', '+243998776543', '1.jpg'),
(2, 'Jule Kolele', 'Serge', 'Féminin', '1998-07-20', 'Marié', 'Rwandaise', 'kamembe', 'serge@gmail.com', '908978', 'serge', '+243998987612', 'user.jpg'),
(3, 'David Kola', 'David', 'FÃ©minin', '0000-00-00', 'MariÃ©', 'Congolaise', 'Pageco', 'david@gmail.com', '909787', 'david', '+243975093746', 'user.jpg'),
(4, 'Mulamba', 'Luc', 'Masculin', '1993-05-12', 'Célibataire', 'Congolaise', 'Pageco', 'luca@gmail.com', '909787', 'luc', '+243978333654', 'user.jpg'),
(5, 'Marcelin Ndume', 'Marcelin', 'Masculin', '1993-05-12', 'Célibataire', 'Congolaise', 'Pageco', 'marcelin@gmail.com', '909787', 'marcelin', '+243978333654', 'user.jpg'),
(6, 'Wilo', 'Freddy', 'Masculin', '1988-03-29', 'Célibataire', 'Congolaise', 'Muhungu', 'wilo@gmail.com', '909990', 'wilo', '+243978390875', 'user.jpg');

-- --------------------------------------------------------

--
-- Structure de la table `maisons`
--

CREATE TABLE IF NOT EXISTS `maisons` (
  `IdM` int(11) NOT NULL AUTO_INCREMENT,
  `Libelle` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `Num` varchar(30) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `Prix` int(7) NOT NULL,
  `Commune` varchar(30) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `Quartier` varchar(30) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `Avenue` varchar(30) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `NbChambre` int(2) NOT NULL,
  `NbSalon` int(2) NOT NULL,
  `NbDouche` int(2) NOT NULL,
  `Description` text CHARACTER SET utf8 COLLATE utf8_bin,
  `EtatMaison` varchar(20) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `StatutMaison` varchar(20) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `DateOffre` date NOT NULL,
  `Photo` varchar(30) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `IdB` int(11) NOT NULL,
  `IdAdm` int(11) DEFAULT NULL,
  PRIMARY KEY (`IdM`),
  KEY `IdB` (`IdB`),
  KEY `IdAdm` (`IdAdm`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=19 ;

--
-- Contenu de la table `maisons`
--

INSERT INTO `maisons` (`IdM`, `Libelle`, `Num`, `Prix`, `Commune`, `Quartier`, `Avenue`, `NbChambre`, `NbSalon`, `NbDouche`, `Description`, `EtatMaison`, `StatutMaison`, `DateOffre`, `Photo`, `IdB`, `IdAdm`) VALUES
(1, 'Appartement recent de 3 chambres à Ibanda', '332B', 200, 'Ibanda', 'Ndendere', 'Poste 1', 4, 1, 1, 'En centre-ville, à proximite des axes passants, 2 villas mitoyennes dans une parcelle close Elle se distribue comme suit  Pour l’une : - salon / séjour lumineux - cuisine - 2 chambres - 1 salle de bains - terrasse - toilettes...', 'Occupee', 'Valide', '2019-04-12', 'M1.JPG', 1, 1),
(2, 'Appartement recent de 3 chambres dans Kadutu', '8810', 150, 'Kadutu', 'Kasali', 'Coopera', 3, 1, 1, 'En centre-ville, à proximite des axes passants, 2 villas mitoyennes dans une parcelle close Elle se distribue comme suit Pour l''''une : - salon / séjour lumineux - cuisine - 2 chambres - 1 salle de bains - terrasse - toilettes...', 'Occupee', 'Valide', '2019-04-12', 'M2.JPG', 2, 1),
(3, 'Appartement recent de 3 chambres dans Kadutu', '2210', 150, 'Kadutu', 'Kasali', 'Coopera', 3, 1, 1, 'En centre-ville, à proximite des axes passants, 2 villas mitoyennes dans une parcelle close Elle se distribue comme suit Pour l''''une : - salon / séjour lumineux - cuisine - 2 chambres - 1 salle de bains - terrasse - toilettes...', 'Innocupee', 'Valide', '2019-04-12', 'M3.JPG', 2, 1),
(4, 'Appartement recent de 3 chambres dans Kadutu', '2210', 150, 'Kadutu', 'Kasali', 'Coopera', 3, 1, 1, 'En centre-ville, à proximite des axes passants, 2 villas mitoyennes dans une parcelle close Elle se distribue comme suit Pour l''''une : - salon / séjour lumineux - cuisine - 2 chambres - 1 salle de bains - terrasse - toilettes...', 'Innocupee', 'Valide', '2019-04-12', 'M4.JPG', 2, 1),
(5, 'Appartement recent de 3 chambres dans Kadutu', '2210', 150, 'Bagira', 'Lumumba', 'Quartier A', 3, 1, 1, 'En centre-ville, à proximite des axes passants, 2 villas mitoyennes dans une parcelle close Elle se distribue comme suit Pour l''''une : - salon / séjour lumineux - cuisine - 2 chambres - 1 salle de bains - terrasse - toilettes...', 'Innocupee', 'Valide', '2019-04-12', 'M5.JPG', 2, 1),
(6, 'Appartement recent de 3 chambres dans Ibanda', '3340', 200, 'Ibanda', 'Ndendere', 'Route Ouvira', 3, 1, 1, 'En centre-ville, à proximite des axes passants, 2 villas mitoyennes dans une parcelle close Elle se distribue comme suit Pour l''''une : - salon / séjour lumineux - cuisine - 2 chambres - 1 salle de bains - terrasse - toilettes...', 'Innocupee', 'Valide', '2019-04-12', 'M6.JPG', 2, 1),
(7, 'Appartement recent de 3 chambres dans Kadutu', '2210', 150, 'Ibanda', 'Panzi', 'Mushununu', 3, 1, 1, 'En centre-ville, à proximite des axes passants, 2 villas mitoyennes dans une parcelle close Elle se distribue comme suit Pour l''''une : - salon / séjour lumineux - cuisine - 2 chambres - 1 salle de bains - terrasse - toilettes...', 'Innocupee', 'Valide', '2019-04-12', 'M7.JPG', 2, 1),
(8, 'Appartement recent de 3 chambres dans Kadutu', '2210', 150, 'Ibanda', 'Ndendere', 'Vamaro', 3, 1, 1, 'En centre-ville, à proximite des axes passants, 2 villas mitoyennes dans une parcelle close Elle se distribue comme suit Pour l''''une : - salon / séjour lumineux - cuisine - 2 chambres - 1 salle de bains - terrasse - toilettes...', 'Innocupee', 'Valide', '2019-04-12', 'M8.JPG', 2, 1),
(9, 'Appartement recent de 3 chambres dans Kadutu', '1130', 150, 'Ibanda', 'Nyalukemba', 'Hypodrome', 3, 1, 1, 'En centre-ville, à proximite des axes passants, 2 villas mitoyennes dans une parcelle close Elle se distribue comme suit Pour l''''une : - salon / séjour lumineux - cuisine - 2 chambres - 1 salle de bains - terrasse - toilettes...', 'Innocupee', 'Valide', '2019-04-12', 'M9.JPG', 2, 1),
(10, 'Appartement recent de 3 chambres dans Kadutu', '2210', 150, 'Bagira', 'Lumumba', 'Quartier A', 3, 1, 1, 'En centre-ville, à proximite des axes passants, 2 villas mitoyennes dans une parcelle close Elle se distribue comme suit Pour l''''une : - salon / séjour lumineux - cuisine - 2 chambres - 1 salle de bains - terrasse - toilettes...', 'Innocupee', 'Valide', '2019-04-12', 'M10.JPG', 2, 1),
(11, 'Appartement recent de 3 chambres dans Kadutu', '2210', 150, 'Bagira', 'Lumumba', 'Quartier A', 3, 1, 1, 'En centre-ville, à proximite des axes passants, 2 villas mitoyennes dans une parcelle close Elle se distribue comme suit Pour l''''une : - salon / séjour lumineux - cuisine - 2 chambres - 1 salle de bains - terrasse - toilettes...', 'Innocupee', 'Valide', '2019-04-12', 'M11.JPG', 2, 1),
(12, 'Appartement recent de 3 chambres dans Kadutu', '2210', 150, 'Bagira', 'Lumumba', 'Quartier A', 3, 1, 1, 'En centre-ville, à proximite des axes passants, 2 villas mitoyennes dans une parcelle close Elle se distribue comme suit Pour l''''une : - salon / séjour lumineux - cuisine - 2 chambres - 1 salle de bains - terrasse - toilettes...', 'Innocupee', 'Valide', '2019-04-12', 'M12.JPG', 2, 1),
(13, 'Appartement recent de 3 chambres dans Kadutu', '2210', 150, 'Bagira', 'Lumumba', 'Quartier A', 3, 1, 1, 'En centre-ville, à proximite des axes passants, 2 villas mitoyennes dans une parcelle close Elle se distribue comme suit Pour l''''une : - salon / séjour lumineux - cuisine - 2 chambres - 1 salle de bains - terrasse - toilettes...', 'Innocupee', 'Valide', '2019-04-12', 'M13.JPG', 2, 1),
(15, 'Appartement recent de 3 chambres dans Kadutu', '2210', 150, 'Bagira', 'Lumumba', 'Quartier A', 3, 1, 1, 'En centre-ville, à proximite des axes passants, 2 villas mitoyennes dans une parcelle close Elle se distribue comme suit Pour l''''une : - salon / séjour lumineux - cuisine - 2 chambres - 1 salle de bains - terrasse - toilettes...', 'Innocupee', 'Invalide', '2019-04-12', 'M15.JPG', 1, NULL),
(16, 'Appartement recent de 5 chambres dans Kadutu', '881C', 150, 'Ibanda', 'Ndendere', 'Kibombo', 4, 1, 1, 'En centre-ville, à proximite des axes passants, 2 villas mitoyennes dans une parcelle close Elle se distribue comme suit Pour l''''une : - salon / séjour lumineux - cuisine - 2 chambres - 1 salle de bains - terrasse - toilettes...', 'Innocupee', 'Invalide', '2019-04-18', '16.jpg', 1, NULL),
(17, 'Appartement à 4 chambres', '556F', 250, 'Ibanda', 'Ndendere', 'Saio', 4, 2, 1, 'Maison avec une terrasse; au bord du lac; la prise en charge du courant et de l''eau. une maison avec un dépôt pour bien garder la nourriture. une clôture pour une meilleure sécurité', 'Innocupee', 'Invalide', '2019-04-14', 'M3.JPG', 1, NULL),
(18, 'Appartement de 4 de chambres', '541F', 250, 'Ibanda', 'Ndendere', 'Saio', 4, 2, 1, 'Maison se trouvant au bord du lac. La prise en charge du courant et de l''eau. une belle terrasse; un dÃ©pÃ´t pour la conservation des nourritures', 'Innocupee', 'Invalide', '2019-04-14', '18.jpg', 1, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `reservations`
--

CREATE TABLE IF NOT EXISTS `reservations` (
  `IdRes` int(11) NOT NULL AUTO_INCREMENT,
  `DateRes` date NOT NULL,
  `NbMois` int(11) NOT NULL,
  `DebutContrat` date NOT NULL,
  `StatutRes` varchar(30) CHARACTER SET utf8 NOT NULL,
  `IdLocat` int(11) NOT NULL,
  `IdMaison` int(11) NOT NULL,
  `IdAgent` int(11) DEFAULT NULL,
  PRIMARY KEY (`IdRes`),
  KEY `IdLocat` (`IdLocat`),
  KEY `IdMaison` (`IdMaison`),
  KEY `IdAgent` (`IdAgent`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Contenu de la table `reservations`
--

INSERT INTO `reservations` (`IdRes`, `DateRes`, `NbMois`, `DebutContrat`, `StatutRes`, `IdLocat`, `IdMaison`, `IdAgent`) VALUES
(1, '2019-04-11', 1, '2019-05-01', 'Valide', 1, 1, 1),
(2, '2019-04-11', 6, '2019-06-09', 'Valide', 2, 2, 1),
(3, '2019-04-11', 0, '0000-00-00', 'Invalide', 2, 12, NULL),
(4, '2019-04-11', 0, '0000-00-00', 'Invalide', 2, 11, NULL),
(6, '2019-04-12', 10, '0000-00-00', 'Valide', 1, 7, 1),
(7, '2019-04-15', 12, '0000-00-00', 'Valide', 1, 9, 1),
(9, '2019-06-09', 5, '2019-06-01', 'Invalide', 1, 13, NULL);

--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `galeries`
--
ALTER TABLE `galeries`
  ADD CONSTRAINT `galeries_ibfk_1` FOREIGN KEY (`IdMaison`) REFERENCES `maisons` (`IdM`);

--
-- Contraintes pour la table `maisons`
--
ALTER TABLE `maisons`
  ADD CONSTRAINT `maisons_ibfk_1` FOREIGN KEY (`IdB`) REFERENCES `bailleurs` (`IdBail`),
  ADD CONSTRAINT `maisons_ibfk_2` FOREIGN KEY (`IdAdm`) REFERENCES `agents` (`IdAg`);

--
-- Contraintes pour la table `reservations`
--
ALTER TABLE `reservations`
  ADD CONSTRAINT `reservations_ibfk_1` FOREIGN KEY (`IdLocat`) REFERENCES `locataires` (`IdLoc`),
  ADD CONSTRAINT `reservations_ibfk_2` FOREIGN KEY (`IdMaison`) REFERENCES `maisons` (`IdM`),
  ADD CONSTRAINT `reservations_ibfk_3` FOREIGN KEY (`IdAgent`) REFERENCES `agents` (`IdAg`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
