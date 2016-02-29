-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Lun 29 Février 2016 à 17:31
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
  `title` varchar(200) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `date_pay` datetime NOT NULL,
  `pay_option` int(11) NOT NULL,
  `create_user` int(11) NOT NULL,
  `create_date` datetime NOT NULL,
  `type` int(2) NOT NULL,
  `data` text,
  `cost` int(11) NOT NULL,
  `is_task` int(2) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `pay_action`
--

INSERT INTO `pay_action` (`id`, `title`, `user_id`, `date_pay`, `pay_option`, `create_user`, `create_date`, `type`, `data`, `cost`, `is_task`) VALUES
(1, NULL, 2, '2016-02-27 00:00:00', 1, 1, '2016-02-27 09:03:26', 1, NULL, 0, 1),
(2, NULL, 2, '2016-02-27 00:00:00', 1, 1, '2016-02-27 10:23:42', 2, NULL, 0, 1),
(3, 'Điện Thoại', 0, '2016-02-18 00:00:00', 2, 1, '2016-02-29 14:58:39', 2, '[]', 0, 2),
(4, 'test', 0, '2016-02-11 00:00:00', 1, 1, '2016-02-29 15:02:55', 2, '[]', 0, 2),
(5, 'test 1', 0, '2016-02-10 00:00:00', 1, 1, '2016-02-29 15:04:09', 2, '[]', 0, 2),
(6, 'test 1', 0, '2016-10-02 00:00:00', 1, 1, '2016-02-29 15:04:38', 2, '[]', 0, 2),
(7, 'test 1', 0, '2016-10-02 00:00:00', 1, 1, '2016-02-29 15:06:22', 2, '[{"code_product":"fds","name_product":"","name_task":"","cost_1":"1000000","cost_2":"200000","cost_3":"800000","cost_4":"200000"}]', 200000, 2),
(8, 'Tư Vân giam san', 0, '2016-02-09 00:00:00', 1, 1, '2016-02-29 15:59:58', 1, '[{"code_product":"1","name_product":"goi th\\u1ea7u a","name_task":"","cost_1":"40000000","cost_2":"4000000","cost_3":"36000000","cost_4":"4000000"},{"code_product":"sp2","name_product":"goi thau b","name_task":"","cost_1":"3000000","cost_2":"3000000","cost_3":"0","cost_4":"3000000"}]', 7000000, 2),
(9, 'Thanh Toán Nợ', 10, '2016-02-11 00:00:00', 2, 1, '2016-02-29 16:19:56', 1, '', 0, 1),
(10, 'Thanh Toán Cho nhà Cung cấp', 2, '2016-02-02 00:00:00', 1, 1, '2016-02-29 16:21:11', 2, '', 0, 1);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
