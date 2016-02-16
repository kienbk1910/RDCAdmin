-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Mar 16 Février 2016 à 14:05
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
-- Structure de la table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `notification` text NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `notifications`
--

INSERT INTO `notifications` (`id`, `user_id`, `notification`, `date`) VALUES
(1, 1, 'fsfsdfsdfds', '2016-02-15 16:29:31'),
(2, 1, 'fdsfsdfsdfdsf', '2016-02-15 16:40:35'),
(3, 1, 'rererewr', '2016-02-15 16:41:10'),
(4, 1, 'vcvdfd', '2016-02-15 16:42:17'),
(5, 1, 'fdfdfs', '2016-02-15 16:43:31'),
(6, 1, 'fdfdsfdsf dsf sdfds fdsfdsfdsfdsfdsfsdfgdsgfdgdfsgdfgdfsgdfsgdfsgdfsgdfgdfg fdgdfgdfgdfgdsfgsdgdsg', '2016-02-15 16:54:36'),
(7, 1, 'tets', '2016-02-15 16:59:02'),
(8, 1, 'fsdfsdfsd', '2016-02-15 16:59:06'),
(9, 1, 'fsfsdf', '2016-02-15 16:59:10');

--
-- Index pour les tables exportées
--

--
-- Index pour la table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
