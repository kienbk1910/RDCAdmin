-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Lun 29 Février 2016 à 17:30
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
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(40) NOT NULL,
  `password` varchar(50) NOT NULL,
  `email` text,
  `name` varchar(100) DEFAULT NULL,
  `phone` varchar(40) NOT NULL,
  `note` text,
  `avatar` text,
  `role_id` int(3) NOT NULL,
  `block` int(1) NOT NULL,
  `create_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `name`, `phone`, `note`, `avatar`, `role_id`, `block`, `create_date`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', 'ngocvinh.rdc@gmail.com', 'Phạm Đức Kiện', '23432432423434', '0000-00-00', '001_56a2f46af3523.jpg', 1, 1, '2015-12-16 00:00:00'),
(2, 'user', 'ee11cbb19052e40b07aac0ca060c23ee', NULL, 'Nguyễn Ngọc', '', '0000-00-00', NULL, 4, 1, '0000-00-00 00:00:00'),
(3, 'adminf', '21232f297a57a5a743894a0e4a801fc3', 'dfdffdg0@gmail.com', NULL, '', '0000-00-00', '092659baoxaydung_5_5679698f7baac.jpg', 1, 1, '2015-12-16 00:00:00'),
(4, 'fdsf', '21232f297a57a5a743894a0e4a801fc3', 'dfdffdg0@gmail.com', NULL, '', '0000-00-00', '092659baoxaydung_5_5679698f7baac.jpg', 1, 1, '2015-12-16 00:00:00'),
(5, 'fdsfsdf', '21232f297a57a5a743894a0e4a801fc3', 'dfdffdg0@gmail.com', NULL, '', '0000-00-00', '092659baoxaydung_5_5679698f7baac.jpg', 1, 1, '2015-12-16 00:00:00'),
(6, 'fsfsfsdf', '21232f297a57a5a743894a0e4a801fc3', 'dfdffdg0@gmail.com', NULL, '', '0000-00-00', '092659baoxaydung_5_5679698f7baac.jpg', 1, 1, '2015-12-16 00:00:00'),
(7, 'erer', '21232f297a57a5a743894a0e4a801fc3', 'dfdffdg0@gmail.com', NULL, '', '0000-00-00', '092659baoxaydung_5_5679698f7baac.jpg', 1, 1, '2015-12-16 00:00:00'),
(8, 'rewrffsd', '21232f297a57a5a743894a0e4a801fc3', 'dfdffdg0@gmail.com', NULL, '', '0000-00-00', '092659baoxaydung_5_5679698f7baac.jpg', 1, 1, '2015-12-16 00:00:00'),
(9, 'fsdfsd', '21232f297a57a5a743894a0e4a801fc3', 'dfdffdg0@gmail.com', NULL, '', '0000-00-00', '092659baoxaydung_5_5679698f7baac.jpg', 1, 1, '2015-12-16 00:00:00'),
(10, 'RDC', '21232f297a57a5a743894a0e4a801fc3', 'dfdffdg0@gmail.com', NULL, '', '0000-00-00', '092659baoxaydung_5_5679698f7baac.jpg', 4, 1, '2015-12-16 00:00:00'),
(11, 'Nguyễn Văn A', '21232f297a57a5a743894a0e4a801fc3', 'dfdffdg0@gmail.com', NULL, '', '0000-00-00', '092659baoxaydung_5_5679698f7baac.jpg', 4, 1, '2015-12-16 00:00:00'),
(12, 'Phạm Thi B', '21232f297a57a5a743894a0e4a801fc3', 'dfdffdg0@gmail.com', NULL, '', '0000-00-00', '092659baoxaydung_5_5679698f7baac.jpg', 4, 1, '2015-12-16 00:00:00'),
(13, 'Lã THị C', 'ee11cbb19052e40b07aac0ca060c23ee', NULL, NULL, '', '0000-00-00', NULL, 4, 1, '0000-00-00 00:00:00'),
(14, 'test123', '25d55ad283aa400af464c76d713c07ad', NULL, NULL, '', '0000-00-00', NULL, 1, 0, '2016-01-06 14:03:48'),
(15, 'daily', '21232f297a57a5a743894a0e4a801fc3', NULL, NULL, '', NULL, '238-dich-vu-tu-van-mo-cong-ty-tnhh-nhanh_567805f42b38a_56a2f451e6d31.jpg', 4, 1, '2016-01-19 16:06:34'),
(16, 'nhanvien', '25d55ad283aa400af464c76d713c07ad', NULL, NULL, '', NULL, '092659baoxaydung_5_56c7eaa1899f7.jpg', 3, 1, '2016-02-20 05:22:37'),
(17, 'kienbk1910', 'c27fe7656f40a481d0f55f92b48d8314', NULL, NULL, '', NULL, NULL, 2, 0, '2016-02-28 03:18:58'),
(19, 'kienpd2', '25d55ad283aa400af464c76d713c07ad', NULL, NULL, '', NULL, NULL, 2, 0, '2016-02-28 03:19:57');

--
-- Index pour les tables exportées
--

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
