-- phpMyAdmin SQL Dump
-- version 3.3.7deb7
-- http://www.phpmyadmin.net
--
-- Serveur: localhost
-- Généré le : Ven 12 Février 2016 à 12:50
-- Version du serveur: 5.1.73
-- Version de PHP: 5.3.3-7+squeeze19

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données: `sylvain`
--

-- --------------------------------------------------------

--
-- Structure de la table `forum_connexion`
--

CREATE TABLE IF NOT EXISTS `forum_connexion` (
  `ip` varchar(40) NOT NULL,
  `tsActif` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `numUtil` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`ip`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `forum_connexion`
--


-- --------------------------------------------------------

--
-- Structure de la table `forum_etatPost`
--

CREATE TABLE IF NOT EXISTS `forum_etatPost` (
  `code` smallint(2) unsigned NOT NULL AUTO_INCREMENT,
  `lib` varchar(20) NOT NULL,
  PRIMARY KEY (`code`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Contenu de la table `forum_etatPost`
--

INSERT INTO `forum_etatPost` (`code`, `lib`) VALUES
(0, 'supprimé'),
(1, 'créé'),
(2, 'publié'),
(3, 'modifié'),
(4, 'modéré');

-- --------------------------------------------------------

--
-- Structure de la table `forum_langue`
--

CREATE TABLE IF NOT EXISTS `forum_langue` (
  `code` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `lib` varchar(20) NOT NULL,
  PRIMARY KEY (`code`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Contenu de la table `forum_langue`
--

INSERT INTO `forum_langue` (`code`, `lib`) VALUES
(1, 'français');

-- --------------------------------------------------------

--
-- Structure de la table `forum_pays`
--

CREATE TABLE IF NOT EXISTS `forum_pays` (
  `code` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `lib` varchar(20) NOT NULL,
  PRIMARY KEY (`code`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Contenu de la table `forum_pays`
--

INSERT INTO `forum_pays` (`code`, `lib`) VALUES
(1, 'France');

-- --------------------------------------------------------

--
-- Structure de la table `forum_post`
--

CREATE TABLE IF NOT EXISTS `forum_post` (
  `num` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `titre` varchar(50) NOT NULL,
  `corps` text NOT NULL,
  `tsCreation` timestamp NULL DEFAULT NULL,
  `tsDerniereModif` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `estRubrique` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '0 : false ;  other : true',
  `codeEtat` smallint(2) unsigned NOT NULL DEFAULT '1',
  `numAuteur` bigint(20) unsigned NOT NULL,
  `numModif` bigint(20) unsigned DEFAULT NULL,
  `numPostParent` bigint(20) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`num`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Contenu de la table `forum_post`
--

INSERT INTO `forum_post` (`num`, `titre`, `corps`, `tsCreation`, `tsDerniereModif`, `estRubrique`, `codeEtat`, `numAuteur`, `numModif`, `numPostParent`) VALUES
(1, 'Forum', 'rubrique principale, jamais affichée', '2016-02-04 16:39:13', '2016-02-04 16:39:13', 255, 1, 1, NULL, 1),
(2, 'Premier article', 'Bienvenue dans ce mini forum\r\nJ''espère qu''il vous plaira', '2016-02-04 16:40:50', '2016-02-04 16:40:50', 0, 2, 1, NULL, 4),
(3, 'Encore un mini forum', 'C''est encore un mini forum que les étudiants du BTS SIO de Périgueux essaie de mettre au point...', '2016-02-02 14:32:35', '2016-02-02 15:30:56', 0, 3, 2, NULL, 4),
(4, 'Présentation', 'C''est ici qu''on se présente parce qu''on est poli.', '2016-02-04 16:44:11', '2016-02-04 16:44:11', 254, 2, 1, NULL, 1),
(5, 'Potin et autres blablas', '', '2016-02-04 16:44:11', '2016-02-04 16:44:11', 254, 2, 1, NULL, 1);

-- --------------------------------------------------------

--
-- Structure de la table `forum_util`
--

CREATE TABLE IF NOT EXISTS `forum_util` (
  `num` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `pseudo` varchar(50) NOT NULL,
  `mdp` varchar(64) NOT NULL,
  `nom` varchar(50) NOT NULL,
  `prenom` varchar(50) NOT NULL,
  `adlig2` varchar(40) NOT NULL,
  `adlig3` varchar(40) NOT NULL,
  `adlig4` varchar(40) DEFAULT NULL,
  `cp` varchar(8) NOT NULL,
  `ville` varchar(40) NOT NULL,
  `codePays` int(11) unsigned NOT NULL DEFAULT '1',
  `codeLangue` int(11) unsigned NOT NULL DEFAULT '1',
  `tsInscription` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `tsDerniereCx` timestamp NULL DEFAULT NULL,
  `tel` varchar(13) DEFAULT 'sans',
  `mel` varchar(100) DEFAULT 'sans',
  `web` varchar(100) DEFAULT 'sans',
  PRIMARY KEY (`num`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Contenu de la table `forum_util`
--

INSERT INTO `forum_util` (`num`, `pseudo`, `mdp`, `nom`, `prenom`, `adlig2`, `adlig3`, `adlig4`, `cp`, `ville`, `codePays`, `codeLangue`, `tsInscription`, `tsDerniereCx`, `tel`, `mel`, `web`) VALUES
(1, 'webmestre', 'toto', 'Dutoux', 'Patrice', 'résidence Le Quadrille', 'rue de la Blague', NULL, '71 050', 'Thas-Bas', 1, 1, '2016-02-01 15:18:56', '2016-02-09 15:11:22', 'sans', 'sans', 'sans'),
(2, 'albert', 'titi', '', '', '', '', NULL, '', '', 1, 1, '2016-02-02 11:08:37', '2016-02-02 13:20:24', 'sans', 'sans', 'sans');
