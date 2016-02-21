-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Dim 21 Février 2016 à 14:29
-- Version du serveur :  10.1.8-MariaDB
-- Version de PHP :  5.5.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `rdc_admin`
--

-- --------------------------------------------------------

--
-- Structure de la table `pay_action`
--

CREATE TABLE `pay_action` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `date_pay` datetime NOT NULL,
  `pay_option` int(11) NOT NULL,
  `create_user` int(11) NOT NULL,
  `create_date` datetime NOT NULL,
  `type` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `pay_action`
--

INSERT INTO `pay_action` (`id`, `user_id`, `date_pay`, `pay_option`, `create_user`, `create_date`, `type`) VALUES
(12, 2, '2016-02-02 00:00:00', 1, 1, '2016-02-21 10:23:39', 1),
(13, 2, '2016-02-17 00:00:00', 2, 1, '2016-02-21 11:47:13', 1),
(14, 2, '2016-02-19 00:00:00', 2, 1, '2016-02-21 12:36:00', 2),
(15, 10, '2016-02-09 00:00:00', 1, 1, '2016-02-21 12:53:47', 1);

--
-- Index pour les tables exportées
--

--
-- Index pour la table `pay_action`
--
ALTER TABLE `pay_action`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `pay_action`
--
ALTER TABLE `pay_action`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
