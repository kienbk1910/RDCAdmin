-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Lun 11 Janvier 2016 à 18:15
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
-- Structure de la table `actions`
--

CREATE TABLE `actions` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `actions`
--

INSERT INTO `actions` (`id`, `name`) VALUES
(1, 'Đăng Nhập'),
(3, 'Tạo Hồ Sơn'),
(4, 'Xóa Hồ Sơ');

-- --------------------------------------------------------

--
-- Structure de la table `certificates`
--

CREATE TABLE `certificates` (
  `id` int(11) NOT NULL,
  `name` varchar(500) NOT NULL,
  `note` text NOT NULL,
  `create_date` datetime NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `custumers`
--

CREATE TABLE `custumers` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `year_of_birth` int(4) NOT NULL,
  `home_town` text NOT NULL,
  `email` int(11) NOT NULL,
  `phone` int(11) NOT NULL,
  `card_id` varchar(30) NOT NULL,
  `note` text NOT NULL,
  `user_id` int(11) NOT NULL,
  `create_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `files`
--

CREATE TABLE `files` (
  `id` int(11) NOT NULL,
  `certificate_id` int(11) NOT NULL,
  `day` datetime NOT NULL,
  `custumer_id` int(11) NOT NULL,
  `number` varchar(50) NOT NULL,
  `user_id` int(11) NOT NULL,
  `create_date` datetime NOT NULL,
  `task_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `logs`
--

CREATE TABLE `logs` (
  `id` int(11) NOT NULL,
  `action_id` int(11) NOT NULL,
  `old_value` text NOT NULL,
  `new_value` text NOT NULL,
  `create_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
  `type` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `money_history`
--

INSERT INTO `money_history` (`id`, `task_id`, `user_id`, `money`, `date_pay`, `create_date`, `money_option`, `last_user_id`, `last_update`, `note`, `type`) VALUES
(1, 6, 1, 1666, '2016-01-11 00:00:00', '2016-01-11 17:44:07', 1, 1, '2016-01-11 17:44:07', 'rt5454543', 1),
(2, 6, 1, 10000, '2016-01-13 00:00:00', '2016-01-11 18:07:49', 1, 1, '2016-01-11 18:07:49', 'frdere', 1),
(3, 6, 1, 2000, '2016-01-18 00:00:00', '2016-01-11 18:13:21', 1, 1, '2016-01-11 18:13:21', 'retrewtw', 1);

-- --------------------------------------------------------

--
-- Structure de la table `money_option`
--

CREATE TABLE `money_option` (
  `id` int(3) NOT NULL,
  `name` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `money_option`
--

INSERT INTO `money_option` (`id`, `name`) VALUES
(1, 'Tiền mặt'),
(2, 'Chuyển khoản');

-- --------------------------------------------------------

--
-- Structure de la table `process`
--

CREATE TABLE `process` (
  `id` int(11) NOT NULL,
  `name` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `process`
--

INSERT INTO `process` (`id`, `name`) VALUES
(1, 'Nhận Hồ Sơ'),
(2, 'Đang xử lý'),
(3, 'Xử lý xong'),
(4, 'Giao Hồ Sơ'),
(5, 'Đóng');

-- --------------------------------------------------------

--
-- Structure de la table `roles`
--

CREATE TABLE `roles` (
  `id` int(3) NOT NULL,
  `name` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `roles`
--

INSERT INTO `roles` (`id`, `name`) VALUES
(1, 'Super Admin'),
(2, 'Quản Lý'),
(3, 'Nhân Viên'),
(4, 'Đại Lý');

-- --------------------------------------------------------

--
-- Structure de la table `tasks`
--

CREATE TABLE `tasks` (
  `id` int(11) NOT NULL,
  `agency_id` int(11) NOT NULL,
  `custumer` varchar(200) NOT NULL,
  `certificate` varchar(400) NOT NULL,
  `cost_sell` int(11) NOT NULL,
  `date_open` datetime NOT NULL,
  `date_end` datetime NOT NULL,
  `agency_note` text,
  `provider_id` int(11) NOT NULL,
  `cost_buy` int(30) NOT NULL,
  `date_open_pr` datetime NOT NULL,
  `date_end_pr` datetime NOT NULL,
  `provider_note` text,
  `process_id` int(3) NOT NULL,
  `reporter_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `create_date` datetime NOT NULL,
  `last_user_id` int(11) NOT NULL,
  `last_update` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `tasks`
--

INSERT INTO `tasks` (`id`, `agency_id`, `custumer`, `certificate`, `cost_sell`, `date_open`, `date_end`, `agency_note`, `provider_id`, `cost_buy`, `date_open_pr`, `date_end_pr`, `provider_note`, `process_id`, `reporter_id`, `user_id`, `create_date`, `last_user_id`, `last_update`) VALUES
(1, 2, 'phạm đức kiện', '1', 0, '0000-00-00 00:00:00', '2016-01-19 00:00:00', 'fgdfgfdgdf', 2, 1111, '2016-01-05 00:00:00', '2016-01-18 00:00:00', 'gfdgfdg', 1, 2, 1, '2016-01-10 14:52:41', 1, '2016-01-11 15:17:10'),
(2, 2, 'rewrwerewrew', '1', 0, '2016-01-04 00:00:00', '2016-01-14 00:00:00', '', 2, 0, '2016-01-04 00:00:00', '2016-01-14 00:00:00', '', 1, 2, 1, '2016-01-10 14:55:07', 1, '2016-01-10 14:55:07'),
(3, 2, 'rewrwerewrew', 'rewrewrewr', 0, '2016-01-04 00:00:00', '2016-01-14 00:00:00', '', 2, 0, '2016-01-04 00:00:00', '2016-01-14 00:00:00', '', 1, 1, 1, '2016-01-10 14:56:13', 1, '2016-01-10 14:56:13'),
(4, 2, 'rewrwerewrew', 'rewrewrewr', 0, '2016-01-04 00:00:00', '2016-01-14 00:00:00', '', 2, 0, '2016-01-04 00:00:00', '2016-01-14 00:00:00', '', 1, 1, 1, '2016-01-10 14:59:59', 1, '2016-01-10 14:59:59'),
(5, 2, 'rewrwerewrew', 'rewrewrewr', 0, '2016-01-04 00:00:00', '2016-01-14 00:00:00', '', 2, 0, '2016-01-04 00:00:00', '2016-01-14 00:00:00', '', 1, 1, 1, '2016-01-10 15:00:28', 1, '2016-01-10 15:00:28'),
(6, 11, 'fsdfsdf', 'An Toan Lao Độngfdfdsfdsfsdfsd', 10000, '2021-11-30 00:00:00', '2016-03-14 00:00:00', '', 2, 0, '2016-01-04 00:00:00', '2016-01-14 00:00:00', '', 2, 1, 1, '2016-01-10 15:03:25', 1, '2016-01-11 15:50:58');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(50) NOT NULL,
  `email` text,
  `phone` varchar(40) NOT NULL,
  `note` date NOT NULL,
  `avatar` text,
  `role_id` int(3) NOT NULL,
  `block` int(1) NOT NULL,
  `create_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `phone`, `note`, `avatar`, `role_id`, `block`, `create_date`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', 'fdsfsdfsdf@gmail.com', '', '0000-00-00', '092659baoxaydung_5_5679698f7baac.jpg', 1, 1, '2015-12-16 00:00:00'),
(2, 'user', 'ee11cbb19052e40b07aac0ca060c23ee', NULL, '', '0000-00-00', NULL, 4, 1, '0000-00-00 00:00:00'),
(3, 'adminf', '21232f297a57a5a743894a0e4a801fc3', 'dfdffdg0@gmail.com', '', '0000-00-00', '092659baoxaydung_5_5679698f7baac.jpg', 1, 1, '2015-12-16 00:00:00'),
(4, 'fdsf', '21232f297a57a5a743894a0e4a801fc3', 'dfdffdg0@gmail.com', '', '0000-00-00', '092659baoxaydung_5_5679698f7baac.jpg', 1, 1, '2015-12-16 00:00:00'),
(5, 'fdsfsdf', '21232f297a57a5a743894a0e4a801fc3', 'dfdffdg0@gmail.com', '', '0000-00-00', '092659baoxaydung_5_5679698f7baac.jpg', 1, 1, '2015-12-16 00:00:00'),
(6, 'fsfsfsdf', '21232f297a57a5a743894a0e4a801fc3', 'dfdffdg0@gmail.com', '', '0000-00-00', '092659baoxaydung_5_5679698f7baac.jpg', 1, 1, '2015-12-16 00:00:00'),
(7, 'erer', '21232f297a57a5a743894a0e4a801fc3', 'dfdffdg0@gmail.com', '', '0000-00-00', '092659baoxaydung_5_5679698f7baac.jpg', 1, 1, '2015-12-16 00:00:00'),
(8, 'rewrffsd', '21232f297a57a5a743894a0e4a801fc3', 'dfdffdg0@gmail.com', '', '0000-00-00', '092659baoxaydung_5_5679698f7baac.jpg', 1, 1, '2015-12-16 00:00:00'),
(9, 'fsdfsd', '21232f297a57a5a743894a0e4a801fc3', 'dfdffdg0@gmail.com', '', '0000-00-00', '092659baoxaydung_5_5679698f7baac.jpg', 1, 1, '2015-12-16 00:00:00'),
(10, 'RDC', '21232f297a57a5a743894a0e4a801fc3', 'dfdffdg0@gmail.com', '', '0000-00-00', '092659baoxaydung_5_5679698f7baac.jpg', 4, 1, '2015-12-16 00:00:00'),
(11, 'Nguyễn Văn A', '21232f297a57a5a743894a0e4a801fc3', 'dfdffdg0@gmail.com', '', '0000-00-00', '092659baoxaydung_5_5679698f7baac.jpg', 4, 1, '2015-12-16 00:00:00'),
(12, 'Phạm Thi B', '21232f297a57a5a743894a0e4a801fc3', 'dfdffdg0@gmail.com', '', '0000-00-00', '092659baoxaydung_5_5679698f7baac.jpg', 4, 1, '2015-12-16 00:00:00'),
(13, 'Lã THị C', 'ee11cbb19052e40b07aac0ca060c23ee', NULL, '', '0000-00-00', NULL, 4, 1, '0000-00-00 00:00:00'),
(14, 'test123', '25d55ad283aa400af464c76d713c07ad', NULL, '', '0000-00-00', NULL, 1, 0, '2016-01-06 14:03:48');

--
-- Index pour les tables exportées
--

--
-- Index pour la table `actions`
--
ALTER TABLE `actions`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `certificates`
--
ALTER TABLE `certificates`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `custumers`
--
ALTER TABLE `custumers`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `files`
--
ALTER TABLE `files`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `money_history`
--
ALTER TABLE `money_history`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `money_option`
--
ALTER TABLE `money_option`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `process`
--
ALTER TABLE `process`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`id`);

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
-- AUTO_INCREMENT pour la table `actions`
--
ALTER TABLE `actions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT pour la table `certificates`
--
ALTER TABLE `certificates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `custumers`
--
ALTER TABLE `custumers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `files`
--
ALTER TABLE `files`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `logs`
--
ALTER TABLE `logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `money_history`
--
ALTER TABLE `money_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT pour la table `money_option`
--
ALTER TABLE `money_option`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT pour la table `process`
--
ALTER TABLE `process`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT pour la table `tasks`
--
ALTER TABLE `tasks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
