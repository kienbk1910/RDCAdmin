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
-- Structure de la table `money_history`
--

CREATE TABLE `money_history` (
  `id` int(11) NOT NULL,
  `task_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `money` int(20) NOT NULL,
  `date_pay` datetime NOT NULL,
  `create_date` datetime NOT NULL,
  `money_option` int(3) NOT NULL,
  `last_user_id` int(11) NOT NULL,
  `last_update` datetime NOT NULL,
  `note` text,
  `type` int(2) NOT NULL,
  `pay_action_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `money_history`
--

INSERT INTO `money_history` (`id`, `task_id`, `user_id`, `money`, `date_pay`, `create_date`, `money_option`, `last_user_id`, `last_update`, `note`, `type`, `pay_action_id`) VALUES
(22, 24, 1, 20000, '2016-02-02 00:00:00', '2016-02-21 10:23:39', 1, 1, '2016-02-21 10:26:40', '', 1, 12),
(23, 25, 1, 100000, '2016-02-02 00:00:00', '2016-02-21 10:23:39', 1, 1, '2016-02-21 10:23:39', '', 1, 12),
(24, 23, 1, 10000000, '2016-02-17 00:00:00', '2016-02-21 11:47:13', 2, 1, '2016-02-21 11:47:13', '', 1, 13),
(25, 24, 1, 80000, '2016-02-17 00:00:00', '2016-02-21 11:47:13', 2, 1, '2016-02-21 11:47:13', '', 1, 13),
(26, 24, 1, 5000, '2016-02-19 00:00:00', '2016-02-21 12:36:00', 2, 1, '2016-02-21 12:36:00', '', 2, 14),
(27, 26, 1, 10000, '2016-02-19 00:00:00', '2016-02-21 12:36:00', 2, 1, '2016-02-21 12:36:00', '', 2, 14),
(28, 26, 1, 1000000, '2016-02-09 00:00:00', '2016-02-21 12:53:47', 1, 1, '2016-02-21 12:53:47', '', 1, 15);

--
-- Index pour les tables exportées
--

--
-- Index pour la table `money_history`
--
ALTER TABLE `money_history`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `money_history`
--
ALTER TABLE `money_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
