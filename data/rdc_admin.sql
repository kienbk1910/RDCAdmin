-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Mer 09 Mars 2016 à 16:18
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
  `certificate_name` varchar(500) NOT NULL,
  `location_option` int(2) NOT NULL DEFAULT '1',
  `certificate_note` text NOT NULL,
  `create_date` datetime NOT NULL,
  `create_user_id` int(11) NOT NULL,
  `last_user_id` int(11) NOT NULL,
  `last_update` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `certificates`
--

INSERT INTO `certificates` (`id`, `certificate_name`, `location_option`, `certificate_note`, `create_date`, `create_user_id`, `last_user_id`, `last_update`) VALUES
(27, 'An Toàn Lao Động', 1, 'fdfd', '2016-03-06 03:59:35', 1, 1, '2016-03-06 03:59:35'),
(29, 'An Toàn Lao Động', 2, 'frtererere', '2016-03-06 04:10:34', 1, 1, '2016-03-06 04:10:34'),
(30, 'Quản Lý Dự Án', 2, '', '2016-03-06 07:58:25', 1, 1, '2016-03-06 07:58:25'),
(31, 'fdsfsdfds', 1, 'fdsfd', '2016-03-06 16:42:31', 1, 1, '2016-03-06 16:42:31');

-- --------------------------------------------------------

--
-- Structure de la table `courses`
--

CREATE TABLE `courses` (
  `id` int(11) NOT NULL,
  `certificate_id` int(11) NOT NULL,
  `month` int(2) NOT NULL,
  `year` int(4) NOT NULL,
  `start` datetime NOT NULL,
  `end` datetime NOT NULL,
  `finish` datetime NOT NULL,
  `create_date` datetime NOT NULL,
  `create_id` int(11) NOT NULL,
  `edit_date` datetime NOT NULL,
  `edit_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `courses`
--

INSERT INTO `courses` (`id`, `certificate_id`, `month`, `year`, `start`, `end`, `finish`, `create_date`, `create_id`, `edit_date`, `edit_id`) VALUES
(7, 30, 1, 2013, '2016-03-01 00:00:00', '2016-03-23 00:00:00', '2016-03-10 00:00:00', '2016-03-06 08:33:37', 1, '2016-03-06 08:33:37', 1),
(8, 27, 1, 2013, '2016-03-02 00:00:00', '2016-03-18 00:00:00', '2016-03-10 00:00:00', '2016-03-06 16:43:25', 1, '2016-03-06 16:43:25', 1);

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
-- Structure de la table `file_attachment`
--

CREATE TABLE `file_attachment` (
  `id` int(11) NOT NULL,
  `task_id` int(11) NOT NULL,
  `file_name` varchar(200) NOT NULL,
  `real_name` varchar(200) NOT NULL,
  `permission_option` int(2) NOT NULL,
  `user_create` int(11) NOT NULL,
  `date_create` datetime NOT NULL,
  `last_user` int(11) NOT NULL,
  `last_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `file_attachment`
--

INSERT INTO `file_attachment` (`id`, `task_id`, `file_name`, `real_name`, `permission_option`, `user_create`, `date_create`, `last_user`, `last_date`) VALUES
(3, 18, 'call-centre-girl2.png', 'call-centre-girl2_56b21a34b0e96.png', 1, 1, '2016-02-03 16:18:12', 1, '2016-02-03 16:18:12'),
(4, 18, 'hoa-da-quy.jpg', 'hoa-da-quy_56b21a43cebec.jpg', 3, 1, '2016-02-03 16:18:27', 1, '2016-02-03 16:18:27'),
(5, 18, '238-dich-vu-tu-van-mo-cong-ty-tnhh-nhanh (1).jpg', '238-dich-vu-tu-van-mo-cong-ty-tnhh-nhanh (1)_56b21a62f233d.jpg', 2, 1, '2016-02-03 16:18:58', 1, '2016-02-03 16:18:58'),
(6, 18, 'pham_duc_kien1.png', 'pham_duc_kien_56b21a87c0f93.png', 4, 1, '2016-02-03 16:19:35', 1, '2016-02-03 16:19:35'),
(10, 18, '346verbs.pdf', '346verbs_56b3624890d4c.pdf', 2, 15, '2016-02-04 15:38:00', 15, '2016-02-04 15:38:00'),
(12, 14, 'HP-SmartStream-Photo-Enhancement-Server-User-Guide.pdf', 'HP-SmartStream-Photo-Enhancement-Server-User-Guide_56b9f98d23e1b.pdf', 1, 1, '2016-02-09 15:37:01', 1, '2016-02-09 15:37:01');

-- --------------------------------------------------------

--
-- Structure de la table `location_option`
--

CREATE TABLE `location_option` (
  `id` int(11) NOT NULL,
  `name` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `location_option`
--

INSERT INTO `location_option` (`id`, `name`) VALUES
(1, 'Quên Quán'),
(2, 'Nơi Sinh'),
(3, 'Hộ Khẩu Thường Chú');

-- --------------------------------------------------------

--
-- Structure de la table `logs`
--

CREATE TABLE `logs` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `action_id` int(11) NOT NULL,
  `value` text NOT NULL,
  `task_id` int(11) NOT NULL,
  `date` datetime NOT NULL,
  `type` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `logs`
--

INSERT INTO `logs` (`id`, `user_id`, `action_id`, `value`, `task_id`, `date`, `type`) VALUES
(57, 1, 3, '{"id":"23","custumer":"Nguyen Van A","certificate":"Test San Pham","agency_id":"2","cost_sell":"100000000","date_open":"2016-02-10","date_end":null,"agency_note":"","provider_id":"2","cost_buy":"","date_open_pr":null,"date_end_pr":null,"provider_note":"","user_id":"1","create_date":"2016-02-20 05:19:21","last_user_id":"1","last_update":"2016-02-20 05:19:21","process_id":1,"reporter_id":"1","assign_id":"1"}', 23, '2016-02-20 05:19:21', 0),
(58, 1, 2, '{"key":"date_end","key_name":"Ng\\u00e0y H\\u1eb9n (B\\u00ean Kh\\u00e1ch H\\u00e0ng)","old_value":null,"old_id":null,"new_value":null,"new_id":"12\\/06\\/2017","custumer":"Nguyen Van A"}', 23, '2016-02-20 05:21:47', 1),
(59, 1, 3, '{"id":"24","custumer":"Nguyen Van A","certificate":"Test fdsfedfere","agency_id":"2","cost_sell":"100000","date_open":"2016-02-02","date_end":null,"agency_note":"","provider_id":"2","cost_buy":"","date_open_pr":null,"date_end_pr":null,"provider_note":"","user_id":"1","create_date":"2016-02-20 08:53:24","last_user_id":"1","last_update":"2016-02-20 08:53:24","process_id":1,"reporter_id":"1","assign_id":"1"}', 24, '2016-02-20 08:53:24', 0),
(60, 1, 3, '{"id":"25","custumer":"Nguy\\u1ec5n V\\u0103n B","certificate":"Anh Sao Xanh ","agency_id":"2","cost_sell":"1000000000","date_open":"2016-02-11","date_end":null,"agency_note":"","provider_id":"2","cost_buy":"","date_open_pr":null,"date_end_pr":null,"provider_note":"","user_id":"1","create_date":"2016-02-20 08:53:57","last_user_id":"1","last_update":"2016-02-20 08:53:57","process_id":1,"reporter_id":"1","assign_id":"1"}', 25, '2016-02-20 08:53:57', 0),
(61, 1, 5, '{"id":null,"task_id":0,"user_id":"1","money":"0","date_pay":"2016-02-03","create_date":"2016-02-21 09:59:55","money_option":"1","last_user_id":"1","last_update":"2016-02-21 09:59:55","note":"","type":"2","username":null,"pay_action_id":"2","custumer":null}', 0, '2016-02-21 09:59:55', 2),
(62, 1, 5, '{"id":null,"task_id":0,"user_id":"1","money":"0","date_pay":"2016-02-03","create_date":"2016-02-21 09:59:55","money_option":"1","last_user_id":"1","last_update":"2016-02-21 09:59:55","note":"","type":"2","username":null,"pay_action_id":"2","custumer":null}', 0, '2016-02-21 09:59:55', 2),
(63, 1, 5, '{"id":null,"task_id":0,"user_id":"1","money":"0","date_pay":"2016-02-03","create_date":"2016-02-21 10:00:55","money_option":"1","last_user_id":"1","last_update":"2016-02-21 10:00:55","note":"","type":"2","username":null,"pay_action_id":"3","custumer":null}', 0, '2016-02-21 10:00:55', 2),
(64, 1, 5, '{"id":null,"task_id":0,"user_id":"1","money":"0","date_pay":"2016-02-03","create_date":"2016-02-21 10:00:55","money_option":"1","last_user_id":"1","last_update":"2016-02-21 10:00:55","note":"","type":"2","username":null,"pay_action_id":"3","custumer":null}', 0, '2016-02-21 10:00:55', 2),
(65, 1, 5, '{"id":null,"task_id":0,"user_id":"1","money":"0","date_pay":"2016-02-03","create_date":"2016-02-21 10:01:40","money_option":"1","last_user_id":"1","last_update":"2016-02-21 10:01:40","note":"","type":"2","username":null,"pay_action_id":"4","custumer":null}', 0, '2016-02-21 10:01:40', 2),
(66, 1, 5, '{"id":null,"task_id":0,"user_id":"1","money":"0","date_pay":"2016-02-03","create_date":"2016-02-21 10:01:40","money_option":"1","last_user_id":"1","last_update":"2016-02-21 10:01:40","note":"","type":"2","username":null,"pay_action_id":"4","custumer":null}', 0, '2016-02-21 10:01:40', 2),
(67, 1, 5, '{"id":null,"task_id":0,"user_id":"1","money":"0","date_pay":"2016-02-16","create_date":"2016-02-21 10:02:02","money_option":"1","last_user_id":"1","last_update":"2016-02-21 10:02:02","note":"","type":"2","username":null,"pay_action_id":"5","custumer":null}', 0, '2016-02-21 10:02:02', 2),
(68, 1, 5, '{"id":null,"task_id":0,"user_id":"1","money":"0","date_pay":"2016-02-16","create_date":"2016-02-21 10:02:02","money_option":"1","last_user_id":"1","last_update":"2016-02-21 10:02:02","note":"","type":"2","username":null,"pay_action_id":"5","custumer":null}', 0, '2016-02-21 10:02:03', 2),
(69, 1, 5, '{"id":null,"task_id":0,"user_id":"1","money":"0","date_pay":"2016-02-16","create_date":"2016-02-21 10:04:54","money_option":"1","last_user_id":"1","last_update":"2016-02-21 10:04:54","note":"","type":"2","username":null,"pay_action_id":"6","custumer":null}', 0, '2016-02-21 10:04:54', 2),
(70, 1, 5, '{"id":null,"task_id":0,"user_id":"1","money":"0","date_pay":"2016-02-16","create_date":"2016-02-21 10:04:54","money_option":"1","last_user_id":"1","last_update":"2016-02-21 10:04:54","note":"","type":"2","username":null,"pay_action_id":"6","custumer":null}', 0, '2016-02-21 10:04:54', 2),
(71, 1, 5, '{"id":null,"task_id":0,"user_id":"1","money":"0","date_pay":"2016-02-11","create_date":"2016-02-21 10:07:00","money_option":"1","last_user_id":"1","last_update":"2016-02-21 10:07:00","note":"","type":"2","username":null,"pay_action_id":"7","custumer":null}', 0, '2016-02-21 10:07:00', 2),
(72, 1, 5, '{"id":null,"task_id":0,"user_id":"1","money":"0","date_pay":"2016-02-11","create_date":"2016-02-21 10:07:00","money_option":"1","last_user_id":"1","last_update":"2016-02-21 10:07:00","note":"","type":"2","username":null,"pay_action_id":"7","custumer":null}', 0, '2016-02-21 10:07:00', 2),
(73, 1, 5, '{"id":null,"task_id":0,"user_id":"1","money":"0","date_pay":"2016-02-17","create_date":"2016-02-21 10:10:52","money_option":"1","last_user_id":"1","last_update":"2016-02-21 10:10:52","note":"","type":"2","username":null,"pay_action_id":"8","custumer":null}', 0, '2016-02-21 10:10:52', 2),
(74, 1, 5, '{"id":null,"task_id":0,"user_id":"1","money":"0","date_pay":"2016-02-17","create_date":"2016-02-21 10:10:52","money_option":"1","last_user_id":"1","last_update":"2016-02-21 10:10:52","note":"","type":"2","username":null,"pay_action_id":"8","custumer":null}', 0, '2016-02-21 10:10:52', 2),
(75, 1, 5, '{"id":null,"task_id":0,"user_id":"1","money":"0","date_pay":"2016-02-11","create_date":"2016-02-21 10:13:55","money_option":"1","last_user_id":"1","last_update":"2016-02-21 10:13:55","note":"","type":"2","username":null,"pay_action_id":"9","custumer":null}', 0, '2016-02-21 10:13:56', 2),
(76, 1, 5, '{"id":null,"task_id":0,"user_id":"1","money":"0","date_pay":"2016-02-11","create_date":"2016-02-21 10:13:55","money_option":"1","last_user_id":"1","last_update":"2016-02-21 10:13:55","note":"","type":"2","username":null,"pay_action_id":"9","custumer":null}', 0, '2016-02-21 10:13:56', 2),
(77, 1, 5, '{"id":null,"task_id":"23","user_id":"1","money":"50000","date_pay":"2016-02-02","create_date":"2016-02-21 10:16:31","money_option":"1","last_user_id":"1","last_update":"2016-02-21 10:16:31","note":"","type":"2","username":null,"pay_action_id":"10","custumer":"Nguyen Van A"}', 23, '2016-02-21 10:16:31', 2),
(78, 1, 5, '{"id":null,"task_id":"24","user_id":"1","money":"50000","date_pay":"2016-02-02","create_date":"2016-02-21 10:16:31","money_option":"1","last_user_id":"1","last_update":"2016-02-21 10:16:31","note":"","type":"2","username":null,"pay_action_id":"10","custumer":"Nguyen Van A"}', 24, '2016-02-21 10:16:32', 2),
(79, 1, 5, '{"id":null,"task_id":"23","user_id":"1","money":"50000","date_pay":"2016-02-11","create_date":"2016-02-21 10:22:04","money_option":"1","last_user_id":"1","last_update":"2016-02-21 10:22:04","note":"","type":"2","username":null,"pay_action_id":"11","custumer":"Nguyen Van A"}', 23, '2016-02-21 10:22:04', 2),
(80, 1, 5, '{"id":null,"task_id":"24","user_id":"1","money":"50000","date_pay":"2016-02-11","create_date":"2016-02-21 10:22:04","money_option":"1","last_user_id":"1","last_update":"2016-02-21 10:22:04","note":"","type":"2","username":null,"pay_action_id":"11","custumer":"Nguyen Van A"}', 24, '2016-02-21 10:22:04', 2),
(81, 1, 5, '{"id":null,"task_id":"23","user_id":"1","money":"100000","date_pay":"2016-02-02","create_date":"2016-02-21 10:23:39","money_option":"1","last_user_id":"1","last_update":"2016-02-21 10:23:39","note":"","type":"2","username":null,"pay_action_id":"12","custumer":"Nguyen Van A"}', 23, '2016-02-21 10:23:39', 2),
(82, 1, 5, '{"id":null,"task_id":"24","user_id":"1","money":"100000","date_pay":"2016-02-02","create_date":"2016-02-21 10:23:39","money_option":"1","last_user_id":"1","last_update":"2016-02-21 10:23:39","note":"","type":"2","username":null,"pay_action_id":"12","custumer":"Nguyen Van A"}', 24, '2016-02-21 10:23:39', 2),
(83, 1, 5, '{"id":null,"task_id":"25","user_id":"1","money":"100000","date_pay":"2016-02-02","create_date":"2016-02-21 10:23:39","money_option":"1","last_user_id":"1","last_update":"2016-02-21 10:23:39","note":"","type":"2","username":null,"pay_action_id":"12","custumer":"Nguy\\u1ec5n V\\u0103n B"}', 25, '2016-02-21 10:23:39', 2),
(84, 1, 6, '{"old_value":{"id":"22","task_id":"24","user_id":null,"money":"100000","date_pay":"2016-02-02 00:00:00","create_date":null,"money_option":"1","last_user_id":null,"last_update":null,"note":"","type":"2","username":null,"pay_action_id":null,"custumer":null},"new_value":{"id":"22","task_id":"24","user_id":"1","money":"20000","date_pay":"2016-02-02","create_date":"2016-02-21 10:26:40","money_option":"1","last_user_id":"1","last_update":"2016-02-21 10:26:40","note":"","type":"2","username":null,"pay_action_id":null,"custumer":"Nguyen Van A"}}', 24, '2016-02-21 10:26:40', 2),
(85, 1, 5, '{"id":null,"task_id":"23","user_id":"1","money":"10000000","date_pay":"2016-02-17","create_date":"2016-02-21 11:47:13","money_option":"2","last_user_id":"1","last_update":"2016-02-21 11:47:13","note":"","type":"1","username":null,"pay_action_id":"13","custumer":"Nguyen Van A"}', 23, '2016-02-21 11:47:13', 1),
(86, 1, 5, '{"id":null,"task_id":"24","user_id":"1","money":"80000","date_pay":"2016-02-17","create_date":"2016-02-21 11:47:13","money_option":"2","last_user_id":"1","last_update":"2016-02-21 11:47:13","note":"","type":"1","username":null,"pay_action_id":"13","custumer":"Nguyen Van A"}', 24, '2016-02-21 11:47:13', 1),
(87, 1, 7, '{"id":"21","task_id":"23","user_id":null,"money":"100000","date_pay":"2016-02-02 00:00:00","create_date":null,"money_option":"1","last_user_id":null,"last_update":null,"note":"","type":"1","username":null,"pay_action_id":null,"custumer":"Nguyen Van A"}', 23, '2016-02-21 12:15:54', 1),
(88, 1, 2, '{"key":"cost_buy","key_name":"Tho\\u1ea3 Thu\\u1eadn (B\\u00ean Nh\\u00e0 Cung C\\u1ea5p)","old_value":null,"old_id":"0","new_value":null,"new_id":"10,000","custumer":"Nguyen Van A"}', 24, '2016-02-21 12:28:01', 2),
(89, 1, 3, '{"id":"26","custumer":"Pham \\u0110\\u1ee9c Ki\\u1ec7n","certificate":"Test Tao h\\u00f3a \\u0111\\u01a1n","agency_id":"10","cost_sell":"10000000","date_open":"2016-02-10","date_end":null,"agency_note":"","provider_id":"2","cost_buy":"2000000","date_open_pr":null,"date_end_pr":null,"provider_note":"","user_id":"1","create_date":"2016-02-21 12:35:06","last_user_id":"1","last_update":"2016-02-21 12:35:06","process_id":1,"reporter_id":"1","assign_id":"1"}', 26, '2016-02-21 12:35:06', 0),
(90, 1, 5, '{"id":null,"task_id":"24","user_id":"1","money":"5000","date_pay":"2016-02-19","create_date":"2016-02-21 12:36:00","money_option":"2","last_user_id":"1","last_update":"2016-02-21 12:36:00","note":"","type":"2","username":null,"pay_action_id":"14","custumer":"Nguyen Van A"}', 24, '2016-02-21 12:36:00', 2),
(91, 1, 5, '{"id":null,"task_id":"26","user_id":"1","money":"10000","date_pay":"2016-02-19","create_date":"2016-02-21 12:36:00","money_option":"2","last_user_id":"1","last_update":"2016-02-21 12:36:00","note":"","type":"2","username":null,"pay_action_id":"14","custumer":"Pham \\u0110\\u1ee9c Ki\\u1ec7n"}', 26, '2016-02-21 12:36:00', 2),
(92, 1, 5, '{"id":null,"task_id":"26","user_id":"1","money":"1000000","date_pay":"2016-02-09","create_date":"2016-02-21 12:53:47","money_option":"1","last_user_id":"1","last_update":"2016-02-21 12:53:47","note":"","type":"1","username":null,"pay_action_id":"15","custumer":"Pham \\u0110\\u1ee9c Ki\\u1ec7n"}', 26, '2016-02-21 12:53:47', 1),
(93, 1, 5, '{"id":null,"task_id":"25","user_id":"1","money":"100000","date_pay":"2016-02-09","create_date":"2016-02-21 16:48:54","money_option":"1","last_user_id":"1","last_update":"2016-02-21 16:48:54","note":"","type":"1","username":null,"pay_action_id":"16","custumer":"Nguy\\u1ec5n V\\u0103n B"}', 25, '2016-02-21 16:48:54', 1),
(94, 1, 6, '{"old_value":{"id":"26","task_id":"24","user_id":null,"money":"5000","date_pay":"2016-02-19 00:00:00","create_date":null,"money_option":"2","last_user_id":null,"last_update":null,"note":"","type":"2","username":null,"pay_action_id":null,"custumer":null},"new_value":{"id":"26","task_id":"24","user_id":"1","money":"100000","date_pay":"2016-02-19","create_date":"2016-02-21 16:50:53","money_option":"2","last_user_id":"1","last_update":"2016-02-21 16:50:53","note":"","type":"2","username":null,"pay_action_id":null,"custumer":"Nguyen Van A"}}', 24, '2016-02-21 16:50:53', 2),
(95, 1, 7, '{"id":"24","task_id":"23","user_id":null,"money":"10000000","date_pay":"2016-02-17 00:00:00","create_date":null,"money_option":"2","last_user_id":null,"last_update":null,"note":"","type":"1","username":null,"pay_action_id":null,"custumer":"Nguyen Van A"}', 23, '2016-02-21 17:50:10', 1),
(96, 1, 7, '{"id":"25","task_id":"24","user_id":null,"money":"80000","date_pay":"2016-02-17 00:00:00","create_date":null,"money_option":"2","last_user_id":null,"last_update":null,"note":"","type":"1","username":null,"pay_action_id":null,"custumer":"Nguyen Van A"}', 24, '2016-02-21 17:50:10', 1),
(97, 1, 7, '{"id":"24","task_id":"23","user_id":null,"money":"10000000","date_pay":"2016-02-17 00:00:00","create_date":null,"money_option":"2","last_user_id":null,"last_update":null,"note":"","type":"1","username":null,"pay_action_id":null,"custumer":"Nguyen Van A"}', 23, '2016-02-21 17:50:19', 1),
(98, 1, 7, '{"id":"25","task_id":"24","user_id":null,"money":"80000","date_pay":"2016-02-17 00:00:00","create_date":null,"money_option":"2","last_user_id":null,"last_update":null,"note":"","type":"1","username":null,"pay_action_id":null,"custumer":"Nguyen Van A"}', 24, '2016-02-21 17:50:19', 1),
(99, 1, 7, '{"id":"24","task_id":"23","user_id":null,"money":"10000000","date_pay":"2016-02-17 00:00:00","create_date":null,"money_option":"2","last_user_id":null,"last_update":null,"note":"","type":"1","username":null,"pay_action_id":null,"custumer":"Nguyen Van A"}', 23, '2016-02-21 17:51:04', 1),
(100, 1, 7, '{"id":"25","task_id":"24","user_id":null,"money":"80000","date_pay":"2016-02-17 00:00:00","create_date":null,"money_option":"2","last_user_id":null,"last_update":null,"note":"","type":"1","username":null,"pay_action_id":null,"custumer":"Nguyen Van A"}', 24, '2016-02-21 17:51:04', 1),
(101, 1, 7, '{"id":"24","task_id":"23","user_id":null,"money":"10000000","date_pay":"2016-02-17 00:00:00","create_date":null,"money_option":"2","last_user_id":null,"last_update":null,"note":"","type":"1","username":null,"pay_action_id":null,"custumer":"Nguyen Van A"}', 23, '2016-02-21 17:52:28', 1),
(102, 1, 7, '{"id":"25","task_id":"24","user_id":null,"money":"80000","date_pay":"2016-02-17 00:00:00","create_date":null,"money_option":"2","last_user_id":null,"last_update":null,"note":"","type":"1","username":null,"pay_action_id":null,"custumer":"Nguyen Van A"}', 24, '2016-02-21 17:52:28', 1),
(103, 1, 7, '{"id":"24","task_id":"23","user_id":null,"money":"10000000","date_pay":"2016-02-17 00:00:00","create_date":null,"money_option":"2","last_user_id":null,"last_update":null,"note":"","type":"1","username":null,"pay_action_id":null,"custumer":"Nguyen Van A"}', 23, '2016-02-21 17:52:42', 1),
(104, 1, 7, '{"id":"25","task_id":"24","user_id":null,"money":"80000","date_pay":"2016-02-17 00:00:00","create_date":null,"money_option":"2","last_user_id":null,"last_update":null,"note":"","type":"1","username":null,"pay_action_id":null,"custumer":"Nguyen Van A"}', 24, '2016-02-21 17:52:42', 1),
(105, 1, 7, '{"id":"24","task_id":"23","user_id":null,"money":"10000000","date_pay":"2016-02-17 00:00:00","create_date":null,"money_option":"2","last_user_id":null,"last_update":null,"note":"","type":"1","username":null,"pay_action_id":null,"custumer":"Nguyen Van A"}', 23, '2016-02-21 17:54:02', 1),
(106, 1, 7, '{"id":"25","task_id":"24","user_id":null,"money":"80000","date_pay":"2016-02-17 00:00:00","create_date":null,"money_option":"2","last_user_id":null,"last_update":null,"note":"","type":"1","username":null,"pay_action_id":null,"custumer":"Nguyen Van A"}', 24, '2016-02-21 17:54:02', 1),
(107, 1, 7, '{"id":"24","task_id":"23","user_id":null,"money":"10000000","date_pay":"2016-02-17 00:00:00","create_date":null,"money_option":"2","last_user_id":null,"last_update":null,"note":"","type":"1","username":null,"pay_action_id":null,"custumer":"Nguyen Van A"}', 23, '2016-02-21 17:54:13', 1),
(108, 1, 7, '{"id":"25","task_id":"24","user_id":null,"money":"80000","date_pay":"2016-02-17 00:00:00","create_date":null,"money_option":"2","last_user_id":null,"last_update":null,"note":"","type":"1","username":null,"pay_action_id":null,"custumer":"Nguyen Van A"}', 24, '2016-02-21 17:54:14', 1),
(109, 1, 7, '{"id":"24","task_id":"23","user_id":null,"money":"10000000","date_pay":"2016-02-17 00:00:00","create_date":null,"money_option":"2","last_user_id":null,"last_update":null,"note":"","type":"1","username":null,"pay_action_id":null,"custumer":"Nguyen Van A"}', 23, '2016-02-21 17:55:11', 1),
(110, 1, 7, '{"id":"25","task_id":"24","user_id":null,"money":"80000","date_pay":"2016-02-17 00:00:00","create_date":null,"money_option":"2","last_user_id":null,"last_update":null,"note":"","type":"1","username":null,"pay_action_id":null,"custumer":"Nguyen Van A"}', 24, '2016-02-21 17:55:11', 1),
(111, 1, 7, '{"id":"26","task_id":"24","user_id":null,"money":"100000","date_pay":"2016-02-19 00:00:00","create_date":null,"money_option":"2","last_user_id":null,"last_update":null,"note":"","type":"2","username":null,"pay_action_id":null,"custumer":"Nguyen Van A"}', 24, '2016-02-21 17:58:55', 2),
(112, 1, 7, '{"id":"27","task_id":"26","user_id":null,"money":"10000","date_pay":"2016-02-19 00:00:00","create_date":null,"money_option":"2","last_user_id":null,"last_update":null,"note":"","type":"2","username":null,"pay_action_id":null,"custumer":"Pham \\u0110\\u1ee9c Ki\\u1ec7n"}', 26, '2016-02-21 17:58:56', 2),
(113, 1, 7, '{"id":"26","task_id":"24","user_id":null,"money":"100000","date_pay":"2016-02-19 00:00:00","create_date":null,"money_option":"2","last_user_id":null,"last_update":null,"note":"","type":"2","username":null,"pay_action_id":null,"custumer":"Nguyen Van A"}', 24, '2016-02-21 17:59:55', 2),
(114, 1, 7, '{"id":"27","task_id":"26","user_id":null,"money":"10000","date_pay":"2016-02-19 00:00:00","create_date":null,"money_option":"2","last_user_id":null,"last_update":null,"note":"","type":"2","username":null,"pay_action_id":null,"custumer":"Pham \\u0110\\u1ee9c Ki\\u1ec7n"}', 26, '2016-02-21 17:59:55', 2),
(115, 1, 7, '{"id":"24","task_id":"23","user_id":null,"money":"10000000","date_pay":"2016-02-17 00:00:00","create_date":null,"money_option":"2","last_user_id":null,"last_update":null,"note":"","type":"1","username":null,"pay_action_id":null,"custumer":"Nguyen Van A"}', 23, '2016-02-21 18:03:37', 1),
(116, 1, 7, '{"id":"25","task_id":"24","user_id":null,"money":"80000","date_pay":"2016-02-17 00:00:00","create_date":null,"money_option":"2","last_user_id":null,"last_update":null,"note":"","type":"1","username":null,"pay_action_id":null,"custumer":"Nguyen Van A"}', 24, '2016-02-21 18:03:37', 1),
(117, 1, 7, '{"id":"24","task_id":"23","user_id":null,"money":"10000000","date_pay":"2016-02-17 00:00:00","create_date":null,"money_option":"2","last_user_id":null,"last_update":null,"note":"","type":"1","username":null,"pay_action_id":null,"custumer":"Nguyen Van A"}', 23, '2016-02-21 18:03:54', 1),
(118, 1, 7, '{"id":"25","task_id":"24","user_id":null,"money":"80000","date_pay":"2016-02-17 00:00:00","create_date":null,"money_option":"2","last_user_id":null,"last_update":null,"note":"","type":"1","username":null,"pay_action_id":null,"custumer":"Nguyen Van A"}', 24, '2016-02-21 18:03:55', 1),
(119, 1, 7, '{"id":"28","task_id":"26","user_id":null,"money":"1000000","date_pay":"2016-02-09 00:00:00","create_date":null,"money_option":"1","last_user_id":null,"last_update":null,"note":"","type":"1","username":null,"pay_action_id":null,"custumer":"Pham \\u0110\\u1ee9c Ki\\u1ec7n"}', 26, '2016-02-21 18:04:35', 1),
(120, 1, 7, '{"id":"26","task_id":"24","user_id":null,"money":"100000","date_pay":"2016-02-19 00:00:00","create_date":null,"money_option":"2","last_user_id":null,"last_update":null,"note":"","type":"2","username":null,"pay_action_id":null,"custumer":"Nguyen Van A"}', 24, '2016-02-21 18:06:26', 2),
(121, 1, 7, '{"id":"27","task_id":"26","user_id":null,"money":"10000","date_pay":"2016-02-19 00:00:00","create_date":null,"money_option":"2","last_user_id":null,"last_update":null,"note":"","type":"2","username":null,"pay_action_id":null,"custumer":"Pham \\u0110\\u1ee9c Ki\\u1ec7n"}', 26, '2016-02-21 18:06:26', 2),
(122, 1, 7, '{"id":"29","task_id":"25","user_id":null,"money":"100000","date_pay":"2016-02-09 00:00:00","create_date":null,"money_option":"1","last_user_id":null,"last_update":null,"note":"","type":"1","username":null,"pay_action_id":null,"custumer":"Nguy\\u1ec5n V\\u0103n B"}', 25, '2016-02-21 18:06:53', 1),
(123, 1, 7, '{"id":"22","task_id":"24","user_id":null,"money":"20000","date_pay":"2016-02-02 00:00:00","create_date":null,"money_option":"1","last_user_id":null,"last_update":null,"note":"","type":"1","username":null,"pay_action_id":null,"custumer":"Nguyen Van A"}', 24, '2016-02-21 18:09:54', 1),
(124, 1, 7, '{"id":"23","task_id":"25","user_id":null,"money":"100000","date_pay":"2016-02-02 00:00:00","create_date":null,"money_option":"1","last_user_id":null,"last_update":null,"note":"","type":"1","username":null,"pay_action_id":null,"custumer":"Nguy\\u1ec5n V\\u0103n B"}', 25, '2016-02-21 18:09:54', 1),
(125, 1, 5, '{"id":null,"task_id":"23","user_id":"1","money":"10000","date_pay":"2016-02-19","create_date":"2016-02-21 18:13:27","money_option":"1","last_user_id":"1","last_update":"2016-02-21 18:13:27","note":"","type":"1","username":null,"pay_action_id":"17","custumer":"Nguyen Van A"}', 23, '2016-02-21 18:13:28', 1),
(126, 1, 5, '{"id":null,"task_id":"24","user_id":"1","money":"20000","date_pay":"2016-02-19","create_date":"2016-02-21 18:13:27","money_option":"1","last_user_id":"1","last_update":"2016-02-21 18:13:27","note":"","type":"1","username":null,"pay_action_id":"17","custumer":"Nguyen Van A"}', 24, '2016-02-21 18:13:28', 1),
(127, 1, 7, '{"id":"30","task_id":"23","user_id":null,"money":"10000","date_pay":"2016-02-19 00:00:00","create_date":null,"money_option":"1","last_user_id":null,"last_update":null,"note":"","type":"1","username":null,"pay_action_id":null,"custumer":"Nguyen Van A"}', 23, '2016-02-21 18:13:34', 1),
(128, 1, 7, '{"id":"31","task_id":"24","user_id":null,"money":"20000","date_pay":"2016-02-19 00:00:00","create_date":null,"money_option":"1","last_user_id":null,"last_update":null,"note":"","type":"1","username":null,"pay_action_id":null,"custumer":"Nguyen Van A"}', 24, '2016-02-21 18:13:34', 1),
(129, 1, 7, '{"id":"25","task_id":"24","user_id":null,"money":"80000","date_pay":"2016-02-17 00:00:00","create_date":null,"money_option":"2","last_user_id":null,"last_update":null,"note":"","type":"1","username":null,"pay_action_id":null,"custumer":"Nguyen Van A"}', 24, '2016-02-22 16:13:06', 1),
(130, 1, 5, '{"id":null,"task_id":"23","user_id":"1","money":"900000","date_pay":"2016-02-27","create_date":"2016-02-27 09:03:26","money_option":"1","last_user_id":"1","last_update":"2016-02-27 09:03:26","note":"","type":"1","username":null,"pay_action_id":"1","custumer":"Nguyen Van A"}', 23, '2016-02-27 09:03:26', 1),
(131, 1, 5, '{"id":null,"task_id":"24","user_id":"1","money":"100000","date_pay":"2016-02-27","create_date":"2016-02-27 09:03:26","money_option":"1","last_user_id":"1","last_update":"2016-02-27 09:03:26","note":"","type":"1","username":null,"pay_action_id":"1","custumer":"Nguyen Van A"}', 24, '2016-02-27 09:03:26', 1),
(132, 1, 5, '{"id":null,"task_id":"26","user_id":"1","money":"1000000","date_pay":"2016-02-27","create_date":"2016-02-27 10:23:42","money_option":"1","last_user_id":"1","last_update":"2016-02-27 10:23:42","note":"","type":"2","username":null,"pay_action_id":"2","custumer":"Pham \\u0110\\u1ee9c Ki\\u1ec7n"}', 26, '2016-02-27 10:23:43', 2),
(133, 1, 5, '{"id":null,"task_id":"26","user_id":"1","money":"800000","date_pay":"2016-02-11","create_date":"2016-02-29 16:19:56","money_option":"2","last_user_id":"1","last_update":"2016-02-29 16:19:56","note":"","type":"1","username":null,"pay_action_id":"9","custumer":"Pham \\u0110\\u1ee9c Ki\\u1ec7n"}', 26, '2016-02-29 16:19:56', 1),
(134, 1, 5, '{"id":null,"task_id":"26","user_id":"1","money":"990000","date_pay":"2016-02-02","create_date":"2016-02-29 16:21:11","money_option":"1","last_user_id":"1","last_update":"2016-02-29 16:21:11","note":"","type":"2","username":null,"pay_action_id":"10","custumer":"Pham \\u0110\\u1ee9c Ki\\u1ec7n"}', 26, '2016-02-29 16:21:11', 2),
(135, 1, 3, '{"id":"27","custumer":"Ph\\u1ea1m \\u0110\\u1ee9c Ki\\u1ec7n","certificate":"Qu\\u1ea3n L\\u00fd D\\u01b0 \\u00c1n","agency_id":"","cost_sell":"2000000","date_open":"2016-03-22","date_end":null,"agency_note":null,"provider_id":"","cost_buy":"1000000","date_open_pr":null,"date_end_pr":null,"provider_note":null,"user_id":"1","create_date":"2016-03-05 08:18:18","last_user_id":"1","last_update":"2016-03-05 08:18:18","process_id":1,"reporter_id":1,"assign_id":1}', 27, '2016-03-05 08:18:18', 0),
(136, 1, 3, '{"id":"28","custumer":"r\\u1ec3","certificate":"rewrwer","agency_id":"undefined","cost_sell":"4343432","date_open":"2016-03-22","date_end":null,"agency_note":null,"provider_id":"undefined","cost_buy":"432432423","date_open_pr":null,"date_end_pr":null,"provider_note":null,"user_id":"1","create_date":"2016-03-05 08:36:33","last_user_id":"1","last_update":"2016-03-05 08:36:33","process_id":1,"reporter_id":1,"assign_id":1}', 28, '2016-03-05 08:36:33', 0),
(137, 1, 3, '{"id":"29","custumer":"r\\u1ec3w","certificate":"rewrewrwe","agency_id":"10","cost_sell":"3434324","date_open":"2016-03-22","date_end":null,"agency_note":null,"provider_id":"11","cost_buy":"4324324","date_open_pr":null,"date_end_pr":null,"provider_note":null,"user_id":"1","create_date":"2016-03-05 08:39:55","last_user_id":"1","last_update":"2016-03-05 08:39:55","process_id":1,"reporter_id":1,"assign_id":1}', 29, '2016-03-05 08:39:55', 0),
(138, 1, 3, '{"id":"30","custumer":"r\\u1ec3w","certificate":"rewrewrwe","agency_id":"10","cost_sell":"3434324","date_open":"2016-03-22","date_end":null,"agency_note":null,"provider_id":"11","cost_buy":"4324324","date_open_pr":null,"date_end_pr":null,"provider_note":null,"user_id":"1","create_date":"2016-03-05 08:41:18","last_user_id":"1","last_update":"2016-03-05 08:41:18","process_id":1,"reporter_id":1,"assign_id":1}', 30, '2016-03-05 08:41:18', 0),
(139, 1, 3, '{"id":"31","custumer":"r\\u1ec3w","certificate":"rewrewrwe","agency_id":"10","cost_sell":"3434324","date_open":"2016-03-22","date_end":null,"agency_note":null,"provider_id":"11","cost_buy":"4324324","date_open_pr":null,"date_end_pr":null,"provider_note":null,"user_id":"1","create_date":"2016-03-05 08:42:45","last_user_id":"1","last_update":"2016-03-05 08:42:45","process_id":1,"reporter_id":1,"assign_id":1}', 31, '2016-03-05 08:42:45', 0),
(140, 1, 3, '{"id":"32","custumer":"Ph\\u1ea1m \\u0110\\u1ee8c Ki\\u1ec7n","certificate":"Ki\\u1ec3m Tra C\\u00f4ng N\\u1ee3","agency_id":"11","cost_sell":"3333333","date_open":"2016-03-05","date_end":null,"agency_note":null,"provider_id":"12","cost_buy":"111111","date_open_pr":null,"date_end_pr":null,"provider_note":null,"user_id":"1","create_date":"2016-03-05 08:44:07","last_user_id":"1","last_update":"2016-03-05 08:44:07","process_id":1,"reporter_id":1,"assign_id":1}', 32, '2016-03-05 08:44:07', 0),
(141, 1, 3, '{"id":"33","custumer":"Mai Ngoc V\\u00ecnh","certificate":"dfdsfrewrewrwete","agency_id":"2","cost_sell":"434343","date_open":"2016-03-02","date_end":null,"agency_note":"","provider_id":"2","cost_buy":"","date_open_pr":null,"date_end_pr":null,"provider_note":"","user_id":"1","create_date":"2016-03-05 08:44:49","last_user_id":"1","last_update":"2016-03-05 08:44:49","process_id":1,"reporter_id":"1","assign_id":"1"}', 33, '2016-03-05 08:44:49', 0),
(142, 1, 3, '{"id":"34","custumer":"r3r43","certificate":"543545435","agency_id":"2","cost_sell":"454354354","date_open":"2016-03-09","date_end":null,"agency_note":null,"provider_id":"2","cost_buy":"5435435","date_open_pr":null,"date_end_pr":null,"provider_note":null,"user_id":"1","create_date":"2016-03-05 08:46:57","last_user_id":"1","last_update":"2016-03-05 08:46:57","process_id":1,"reporter_id":1,"assign_id":1}', 34, '2016-03-05 08:46:57', 0),
(143, 1, 3, '{"id":"35","custumer":"rtrtret","certificate":"rewrew","agency_id":"11","cost_sell":"435435345","date_open":"2016-03-23","date_end":null,"agency_note":null,"provider_id":"10","cost_buy":"5435435","date_open_pr":null,"date_end_pr":null,"provider_note":null,"user_id":"1","create_date":"2016-03-05 08:48:19","last_user_id":"1","last_update":"2016-03-05 08:48:19","process_id":1,"reporter_id":1,"assign_id":1}', 35, '2016-03-05 08:48:19', 0),
(144, 1, 3, '{"id":"36","custumer":"r\\u1ec3wrew","certificate":"rewrewr","agency_id":"11","cost_sell":"343242134","date_open":"2016-03-10","date_end":null,"agency_note":null,"provider_id":"11","cost_buy":"345324524","date_open_pr":null,"date_end_pr":null,"provider_note":null,"user_id":"1","create_date":"2016-03-05 08:49:33","last_user_id":"1","last_update":"2016-03-05 08:49:33","process_id":1,"reporter_id":1,"assign_id":1}', 36, '2016-03-05 08:49:33', 0),
(145, 1, 3, '{"id":"37","custumer":"tretre","certificate":"tretretr","agency_id":"2","cost_sell":"4545435","date_open":"2016-03-22","date_end":null,"agency_note":null,"provider_id":"2","cost_buy":"4354353","date_open_pr":null,"date_end_pr":null,"provider_note":null,"user_id":"1","create_date":"2016-03-05 08:50:28","last_user_id":"1","last_update":"2016-03-05 08:50:28","process_id":1,"reporter_id":1,"assign_id":1}', 37, '2016-03-05 08:50:28', 0),
(146, 1, 3, '{"id":"38","custumer":"4343","certificate":"43434","agency_id":"2","cost_sell":"43434","date_open":"2016-03-22","date_end":null,"agency_note":null,"provider_id":"2","cost_buy":"3434","date_open_pr":null,"date_end_pr":null,"provider_note":null,"user_id":"1","create_date":"2016-03-05 08:54:12","last_user_id":"1","last_update":"2016-03-05 08:54:12","process_id":1,"reporter_id":1,"assign_id":1}', 38, '2016-03-05 08:54:12', 0),
(147, 1, 3, '{"id":"39","custumer":"4343","certificate":"43434","agency_id":"2","cost_sell":"43434","date_open":"2016-03-22","date_end":null,"agency_note":null,"provider_id":"2","cost_buy":"3434","date_open_pr":null,"date_end_pr":null,"provider_note":null,"user_id":"1","create_date":"2016-03-05 08:54:18","last_user_id":"1","last_update":"2016-03-05 08:54:18","process_id":1,"reporter_id":1,"assign_id":1}', 39, '2016-03-05 08:54:19', 0),
(148, 1, 3, '{"id":"40","custumer":"r3434","certificate":"34343","agency_id":"12","cost_sell":"434343","date_open":"2016-03-18","date_end":null,"agency_note":null,"provider_id":"11","cost_buy":"43434","date_open_pr":null,"date_end_pr":null,"provider_note":null,"user_id":"1","create_date":"2016-03-05 09:05:47","last_user_id":"1","last_update":"2016-03-05 09:05:47","process_id":1,"reporter_id":1,"assign_id":1}', 40, '2016-03-05 09:05:47', 0),
(149, 1, 3, '{"id":"41","custumer":"fdfds","certificate":"fdsfdsf","agency_id":"10","cost_sell":"434343","date_open":"2016-03-31","date_end":null,"agency_note":null,"provider_id":"10","cost_buy":"4324324","date_open_pr":null,"date_end_pr":null,"provider_note":null,"user_id":"1","create_date":"2016-03-05 09:06:51","last_user_id":"1","last_update":"2016-03-05 09:06:51","process_id":1,"reporter_id":1,"assign_id":1}', 41, '2016-03-05 09:06:52', 0),
(150, 1, 3, '{"id":"42","custumer":"r\\u1ebberere","certificate":"r\\u00eare","agency_id":"2","cost_sell":"3434324","date_open":"2016-03-08","date_end":null,"agency_note":null,"provider_id":"2","cost_buy":"32432432","date_open_pr":null,"date_end_pr":null,"provider_note":null,"user_id":"1","create_date":"2016-03-05 09:08:26","last_user_id":"1","last_update":"2016-03-05 09:08:26","process_id":1,"reporter_id":1,"assign_id":1}', 42, '2016-03-05 09:08:26', 0),
(151, 1, 3, '{"id":"43","custumer":"fdfds","certificate":"fdsfdsfd","agency_id":"2","cost_sell":"5454353","date_open":"2016-03-02","date_end":null,"agency_note":null,"provider_id":"2","cost_buy":"4543543","date_open_pr":null,"date_end_pr":null,"provider_note":null,"user_id":"1","create_date":"2016-03-05 09:08:46","last_user_id":"1","last_update":"2016-03-05 09:08:46","process_id":1,"reporter_id":1,"assign_id":1}', 43, '2016-03-05 09:08:46', 0),
(152, 1, 3, '{"id":"44","custumer":"fderewr","certificate":"ewrewrewr","agency_id":"2","cost_sell":"55545","date_open":"2016-03-10","date_end":null,"agency_note":null,"provider_id":"2","cost_buy":"6565465","date_open_pr":null,"date_end_pr":null,"provider_note":null,"user_id":"1","create_date":"2016-03-05 09:10:19","last_user_id":"1","last_update":"2016-03-05 09:10:19","process_id":1,"reporter_id":1,"assign_id":1}', 44, '2016-03-05 09:10:19', 0),
(153, 1, 3, '{"id":"45","custumer":"gfdgfd","certificate":"gfgfdgfd","agency_id":"2","cost_sell":"545435","date_open":"2016-03-23","date_end":null,"agency_note":null,"provider_id":"2","cost_buy":"4543543","date_open_pr":null,"date_end_pr":null,"provider_note":null,"user_id":"1","create_date":"2016-03-05 09:10:21","last_user_id":"1","last_update":"2016-03-05 09:10:21","process_id":1,"reporter_id":1,"assign_id":1}', 45, '2016-03-05 09:10:21', 0),
(154, 1, 3, '{"id":"46","custumer":"r\\u00eare","certificate":"r\\u00ear","agency_id":"2","cost_sell":"5443535","date_open":"2016-03-09","date_end":null,"agency_note":null,"provider_id":"2","cost_buy":"5435435","date_open_pr":null,"date_end_pr":null,"provider_note":null,"user_id":"1","create_date":"2016-03-05 09:45:33","last_user_id":"1","last_update":"2016-03-05 09:45:33","process_id":1,"reporter_id":1,"assign_id":1}', 46, '2016-03-05 09:45:33', 0),
(155, 1, 3, '{"id":"47","custumer":"r\\u1ec3wr","certificate":"ewrewrewr","agency_id":"11","cost_sell":"5454354354","date_open":"2016-03-09","date_end":null,"agency_note":null,"provider_id":"2","cost_buy":"4354543543","date_open_pr":null,"date_end_pr":null,"provider_note":null,"user_id":"1","create_date":"2016-03-05 09:46:58","last_user_id":"1","last_update":"2016-03-05 09:46:58","process_id":1,"reporter_id":1,"assign_id":1}', 47, '2016-03-05 09:46:59', 0),
(156, 1, 3, '{"id":"48","custumer":"fdffredf","certificate":"dfdfdf","agency_id":"2","cost_sell":"4343434","date_open":"2016-03-22","date_end":null,"agency_note":null,"provider_id":"2","cost_buy":"343434","date_open_pr":null,"date_end_pr":null,"provider_note":null,"user_id":"1","create_date":"2016-03-05 09:47:12","last_user_id":"1","last_update":"2016-03-05 09:47:12","process_id":1,"reporter_id":1,"assign_id":1}', 48, '2016-03-05 09:47:12', 0),
(157, 1, 3, '{"id":"49","custumer":"rewrew","certificate":"rewrewr","agency_id":"2","cost_sell":"4535324","date_open":"2016-03-16","date_end":null,"agency_note":null,"provider_id":"2","cost_buy":"324324","date_open_pr":null,"date_end_pr":null,"provider_note":null,"user_id":"1","create_date":"2016-03-05 09:49:50","last_user_id":"1","last_update":"2016-03-05 09:49:50","process_id":1,"reporter_id":1,"assign_id":1}', 49, '2016-03-05 09:49:50', 0),
(158, 1, 3, '{"id":"50","custumer":"r\\u1ec3w","certificate":"rewrewrewr","agency_id":"2","cost_sell":"32543432","date_open":"2016-03-23","date_end":null,"agency_note":null,"provider_id":"2","cost_buy":"4324324","date_open_pr":null,"date_end_pr":null,"provider_note":null,"user_id":"1","create_date":"2016-03-05 09:52:00","last_user_id":"1","last_update":"2016-03-05 09:52:00","process_id":1,"reporter_id":1,"assign_id":1}', 50, '2016-03-05 09:52:00', 0),
(159, 1, 2, '{"key":"","key_name":"","old_value":null,"old_id":null,"new_value":null,"new_id":"2","custumer":"Nguyen Van A"}', 24, '2016-03-05 11:31:25', 0),
(160, 1, 2, '{"key":"process_id","key_name":"Tr\\u1ea1ng Th\\u00e1i","old_value":"Nh\\u1eadn H\\u1ed3 S\\u01a1","old_id":"1","new_value":"\\u0110ang x\\u1eed l\\u00fd","new_id":"2","custumer":"Nguyen Van A"}', 24, '2016-03-05 11:37:34', 0),
(161, 1, 2, '{"key":"process_id","key_name":"Tr\\u1ea1ng Th\\u00e1i","old_value":"Nh\\u1eadn H\\u1ed3 S\\u01a1","old_id":"1","new_value":"Thi\\u1ebfu H\\u1ed3 S\\u01a1","new_id":"5","custumer":"Pham \\u0110\\u1ee9c Ki\\u1ec7n"}', 26, '2016-03-05 11:44:05', 0),
(162, 1, 2, '{"key":"process_id","key_name":"Tr\\u1ea1ng Th\\u00e1i","old_value":"\\u0110ang x\\u1eed l\\u00fd","old_id":"2","new_value":"C\\u00f3 Ng\\u00e0y h\\u1eb9n","new_id":"3","custumer":"Nguyen Van A"}', 24, '2016-03-05 11:50:23', 0);

-- --------------------------------------------------------

--
-- Structure de la table `manager_certificates`
--

CREATE TABLE `manager_certificates` (
  `id` int(11) NOT NULL,
  `certificate_type` int(11) NOT NULL,
  `certificate_code` varchar(100) NOT NULL,
  `full_name` varchar(20) NOT NULL,
  `place_of_birth` varchar(100) NOT NULL,
  `identity_card` int(11) NOT NULL,
  `date_of_issue` datetime NOT NULL,
  `start_time` datetime NOT NULL,
  `end_time` datetime NOT NULL,
  `day_of_birth` datetime NOT NULL,
  `note` varchar(500) DEFAULT NULL,
  `create_user_id` datetime NOT NULL,
  `last_user_id` int(11) NOT NULL,
  `last_update` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
(24, 23, 1, 10000000, '2016-02-17 00:00:00', '2016-02-21 11:47:13', 2, 1, '2016-02-21 11:47:13', '', 1, 13),
(26, 24, 1, 100000, '2016-02-19 00:00:00', '2016-02-21 12:36:00', 2, 1, '2016-02-21 16:50:53', '', 2, 14),
(27, 26, 1, 10000, '2016-02-19 00:00:00', '2016-02-21 12:36:00', 2, 1, '2016-02-21 12:36:00', '', 2, 14),
(28, 26, 1, 1000000, '2016-02-09 00:00:00', '2016-02-21 12:53:47', 1, 1, '2016-02-21 12:53:47', '', 1, 15),
(29, 25, 1, 100000, '2016-02-09 00:00:00', '2016-02-21 16:48:54', 1, 1, '2016-02-21 16:48:54', '', 1, 16),
(30, 23, 1, 900000, '2016-02-27 00:00:00', '2016-02-27 09:03:26', 1, 1, '2016-02-27 09:03:26', '', 1, 1),
(31, 24, 1, 100000, '2016-02-27 00:00:00', '2016-02-27 09:03:26', 1, 1, '2016-02-27 09:03:26', '', 1, 1),
(32, 26, 1, 1000000, '2016-02-27 00:00:00', '2016-02-27 10:23:42', 1, 1, '2016-02-27 10:23:42', '', 2, 2),
(33, 26, 1, 800000, '2016-02-11 00:00:00', '2016-02-29 16:19:56', 2, 1, '2016-02-29 16:19:56', '', 1, 9),
(34, 26, 1, 990000, '2016-02-02 00:00:00', '2016-02-29 16:21:11', 1, 1, '2016-02-29 16:21:11', '', 2, 10);

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
(3, 'Có Ngày hẹn'),
(4, 'Ra Chứng Chỉ'),
(5, 'Thiếu Hồ Sơ'),
(6, 'Trả Hồ Sơ'),
(7, 'Đóng');

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
-- Structure de la table `state`
--

CREATE TABLE `state` (
  `id` int(11) NOT NULL,
  `state_id` int(11) NOT NULL,
  `state_string` varchar(20) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `state`
--

INSERT INTO `state` (`id`, `state_id`, `state_string`) VALUES
(4, 1, 'Đang hoạt động'),
(5, 0, 'Block'),
(6, 2, 'Chưa kích hoạt'),
(9, 3, 'Online');

-- --------------------------------------------------------

--
-- Structure de la table `students`
--

CREATE TABLE `students` (
  `id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `name` text NOT NULL,
  `address` text NOT NULL,
  `card_id` varchar(30) DEFAULT NULL,
  `course_name` text NOT NULL,
  `code` varchar(50) NOT NULL,
  `birth_of_date` varchar(50) NOT NULL,
  `create_id` int(11) NOT NULL,
  `create_date` datetime NOT NULL,
  `edit_id` int(11) NOT NULL,
  `edit_date` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
  `date_end` datetime DEFAULT NULL,
  `agency_note` text,
  `provider_id` int(11) NOT NULL,
  `cost_buy` int(30) NOT NULL,
  `date_open_pr` datetime DEFAULT NULL,
  `date_end_pr` datetime DEFAULT NULL,
  `provider_note` text,
  `process_id` int(3) NOT NULL,
  `reporter_id` int(11) NOT NULL,
  `assign_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `create_date` datetime NOT NULL,
  `last_user_id` int(11) NOT NULL,
  `last_update` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `tasks`
--

INSERT INTO `tasks` (`id`, `agency_id`, `custumer`, `certificate`, `cost_sell`, `date_open`, `date_end`, `agency_note`, `provider_id`, `cost_buy`, `date_open_pr`, `date_end_pr`, `provider_note`, `process_id`, `reporter_id`, `assign_id`, `user_id`, `create_date`, `last_user_id`, `last_update`) VALUES
(23, 2, 'Nguyen Van A', 'Test San Pham', 100000000, '2016-02-10 00:00:00', '2017-06-12 00:00:00', '', 2, 0, NULL, NULL, '', 1, 1, 1, 1, '2016-02-20 05:19:21', 1, '2016-02-20 05:21:47'),
(24, 2, 'Nguyen Van A', 'Test fdsfedfere', 100000, '2016-02-02 00:00:00', NULL, '', 2, 10000, NULL, NULL, '', 3, 1, 1, 1, '2016-02-20 08:53:24', 1, '2016-03-05 11:50:23'),
(25, 2, 'Nguyễn Văn B', 'Anh Sao Xanh ', 1000000000, '2016-02-11 00:00:00', NULL, '', 2, 0, NULL, NULL, '', 1, 1, 1, 1, '2016-02-20 08:53:57', 1, '2016-02-20 08:53:57'),
(26, 10, 'Pham Đức Kiện', 'Test Tao hóa đơn', 10000000, '2016-02-10 00:00:00', NULL, '', 2, 2000000, NULL, NULL, '', 5, 1, 1, 1, '2016-02-21 12:35:06', 1, '2016-03-05 11:44:05'),
(27, 0, 'Phạm Đức Kiện', 'Quản Lý Dư Án', 2000000, '2016-03-22 00:00:00', NULL, NULL, 0, 1000000, NULL, NULL, NULL, 1, 1, 1, 1, '2016-03-05 08:18:18', 1, '2016-03-05 08:18:18'),
(28, 0, 'rể', 'rewrwer', 4343432, '2016-03-22 00:00:00', NULL, NULL, 0, 432432423, NULL, NULL, NULL, 1, 1, 1, 1, '2016-03-05 08:36:33', 1, '2016-03-05 08:36:33'),
(29, 10, 'rểw', 'rewrewrwe', 3434324, '2016-03-22 00:00:00', NULL, NULL, 11, 4324324, NULL, NULL, NULL, 1, 1, 1, 1, '2016-03-05 08:39:55', 1, '2016-03-05 08:39:55'),
(30, 10, 'rểw', 'rewrewrwe', 3434324, '2016-03-22 00:00:00', NULL, NULL, 11, 4324324, NULL, NULL, NULL, 1, 1, 1, 1, '2016-03-05 08:41:18', 1, '2016-03-05 08:41:18'),
(31, 10, 'rểw', 'rewrewrwe', 3434324, '2016-03-22 00:00:00', NULL, NULL, 11, 4324324, NULL, NULL, NULL, 1, 1, 1, 1, '2016-03-05 08:42:45', 1, '2016-03-05 08:42:45'),
(32, 11, 'Phạm ĐỨc Kiện', 'Kiểm Tra Công Nợ', 3333333, '2016-03-05 00:00:00', NULL, NULL, 12, 111111, NULL, NULL, NULL, 1, 1, 1, 1, '2016-03-05 08:44:07', 1, '2016-03-05 08:44:07'),
(33, 2, 'Mai Ngoc Vình', 'dfdsfrewrewrwete', 434343, '2016-03-02 00:00:00', NULL, '', 2, 0, NULL, NULL, '', 1, 1, 1, 1, '2016-03-05 08:44:49', 1, '2016-03-05 08:44:49'),
(34, 2, 'r3r43', '543545435', 454354354, '2016-03-09 00:00:00', NULL, NULL, 2, 5435435, NULL, NULL, NULL, 1, 1, 1, 1, '2016-03-05 08:46:57', 1, '2016-03-05 08:46:57'),
(35, 11, 'rtrtret', 'rewrew', 435435345, '2016-03-23 00:00:00', NULL, NULL, 10, 5435435, NULL, NULL, NULL, 1, 1, 1, 1, '2016-03-05 08:48:19', 1, '2016-03-05 08:48:19'),
(36, 11, 'rểwrew', 'rewrewr', 343242134, '2016-03-10 00:00:00', NULL, NULL, 11, 345324524, NULL, NULL, NULL, 1, 1, 1, 1, '2016-03-05 08:49:33', 1, '2016-03-05 08:49:33'),
(37, 2, 'tretre', 'tretretr', 4545435, '2016-03-22 00:00:00', NULL, NULL, 2, 4354353, NULL, NULL, NULL, 1, 1, 1, 1, '2016-03-05 08:50:28', 1, '2016-03-05 08:50:28'),
(38, 2, '4343', '43434', 43434, '2016-03-22 00:00:00', NULL, NULL, 2, 3434, NULL, NULL, NULL, 1, 1, 1, 1, '2016-03-05 08:54:12', 1, '2016-03-05 08:54:12'),
(39, 2, '4343', '43434', 43434, '2016-03-22 00:00:00', NULL, NULL, 2, 3434, NULL, NULL, NULL, 1, 1, 1, 1, '2016-03-05 08:54:18', 1, '2016-03-05 08:54:18'),
(40, 12, 'r3434', '34343', 434343, '2016-03-18 00:00:00', NULL, NULL, 11, 43434, NULL, NULL, NULL, 1, 1, 1, 1, '2016-03-05 09:05:47', 1, '2016-03-05 09:05:47'),
(41, 10, 'fdfds', 'fdsfdsf', 434343, '2016-03-31 00:00:00', NULL, NULL, 10, 4324324, NULL, NULL, NULL, 1, 1, 1, 1, '2016-03-05 09:06:51', 1, '2016-03-05 09:06:51'),
(42, 2, 'rẻerere', 'rêre', 3434324, '2016-03-08 00:00:00', NULL, NULL, 2, 32432432, NULL, NULL, NULL, 1, 1, 1, 1, '2016-03-05 09:08:26', 1, '2016-03-05 09:08:26'),
(43, 2, 'fdfds', 'fdsfdsfd', 5454353, '2016-03-02 00:00:00', NULL, NULL, 2, 4543543, NULL, NULL, NULL, 1, 1, 1, 1, '2016-03-05 09:08:46', 1, '2016-03-05 09:08:46'),
(44, 2, 'fderewr', 'ewrewrewr', 55545, '2016-03-10 00:00:00', NULL, NULL, 2, 6565465, NULL, NULL, NULL, 1, 1, 1, 1, '2016-03-05 09:10:19', 1, '2016-03-05 09:10:19'),
(45, 2, 'gfdgfd', 'gfgfdgfd', 545435, '2016-03-23 00:00:00', NULL, NULL, 2, 4543543, NULL, NULL, NULL, 1, 1, 1, 1, '2016-03-05 09:10:21', 1, '2016-03-05 09:10:21'),
(46, 2, 'rêre', 'rêr', 5443535, '2016-03-09 00:00:00', NULL, NULL, 2, 5435435, NULL, NULL, NULL, 1, 1, 1, 1, '2016-03-05 09:45:33', 1, '2016-03-05 09:45:33'),
(47, 11, 'rểwr', 'ewrewrewr', 2147483647, '2016-03-09 00:00:00', NULL, NULL, 2, 2147483647, NULL, NULL, NULL, 1, 1, 1, 1, '2016-03-05 09:46:58', 1, '2016-03-05 09:46:58'),
(48, 2, 'fdffredf', 'dfdfdf', 4343434, '2016-03-22 00:00:00', NULL, NULL, 2, 343434, NULL, NULL, NULL, 1, 1, 1, 1, '2016-03-05 09:47:12', 1, '2016-03-05 09:47:12'),
(49, 2, 'rewrew', 'rewrewr', 4535324, '2016-03-16 00:00:00', NULL, NULL, 2, 324324, NULL, NULL, NULL, 1, 1, 1, 1, '2016-03-05 09:49:50', 1, '2016-03-05 09:49:50'),
(50, 2, 'rểw', 'rewrewrewr', 32543432, '2016-03-23 00:00:00', NULL, NULL, 2, 4324324, NULL, NULL, NULL, 1, 1, 1, 1, '2016-03-05 09:52:00', 1, '2016-03-05 09:52:00');

-- --------------------------------------------------------

--
-- Structure de la table `task_comments`
--

CREATE TABLE `task_comments` (
  `id` int(11) NOT NULL,
  `comment` varchar(1000) NOT NULL,
  `user_id` int(11) NOT NULL,
  `create_date` datetime NOT NULL,
  `task_id` int(11) NOT NULL,
  `is_read` int(2) NOT NULL,
  `type` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `task_comments`
--

INSERT INTO `task_comments` (`id`, `comment`, `user_id`, `create_date`, `task_id`, `is_read`, `type`) VALUES
(26, 'fdfdfd', 15, '2016-02-03 17:59:42', 21, 0, 2),
(27, 'dsds', 15, '2016-02-04 15:49:33', 21, 0, 2),
(28, 'fdfdf', 15, '2016-02-04 16:00:01', 21, 0, 2),
(29, 'fdfdf', 15, '2016-02-04 16:01:27', 21, 0, 2),
(30, 'fdfdf', 15, '2016-02-04 16:01:30', 21, 0, 2),
(31, 'fdsfsdf', 1, '2016-02-04 16:02:05', 21, 0, 2),
(32, '2222222222222222', 15, '2016-02-04 16:02:19', 21, 0, 2),
(33, 'fdfd', 15, '2016-02-04 16:03:14', 21, 0, 2),
(34, '222222222222222', 15, '2016-02-04 16:03:32', 21, 0, 2),
(35, 'fdsfsdf', 15, '2016-02-04 16:05:09', 21, 0, 2),
(36, 'dsdasedw', 1, '2016-02-04 16:06:59', 21, 0, 2),
(37, 'fdfd', 1, '2016-02-04 16:10:27', 21, 0, 2),
(38, 'fdfdfd', 1, '2016-02-04 16:10:31', 21, 0, 1),
(39, 'fdfd', 1, '2016-02-04 16:10:34', 21, 0, 1),
(40, 'fdfd', 15, '2016-02-04 16:10:44', 21, 0, 2),
(41, 'dfdfdf', 1, '2016-02-09 11:21:50', 14, 0, 1),
(42, 'TRÊTTERT', 1, '2016-02-09 15:41:01', 14, 0, 1),
(43, 'yuyuyufd fds f dsf dsf ds f dsf ds f dsfds f sdf ds f', 1, '2016-02-09 15:45:36', 14, 0, 2),
(44, 'test comment', 1, '2016-02-10 03:25:22', 14, 0, 1),
(45, 'fdfdfdfd', 1, '2016-02-10 03:27:04', 14, 0, 1),
(46, 'dsdsdsd', 1, '2016-02-10 03:29:48', 14, 0, 1),
(47, 'dfdfsdfrsd', 1, '2016-02-10 03:33:08', 14, 0, 1),
(48, 'fdfsfsdf', 1, '2016-02-10 03:35:34', 14, 0, 1),
(49, 'fdfdf', 1, '2016-02-10 03:40:11', 14, 0, 1);

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
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', 'ngocvinh.rdc@gmail.com', 'Kienbk1910', '23432432423434', '0000-00-00', '001_56a2f46af3523.jpg', 1, 1, '2015-12-16 00:00:00'),
(2, 'user', 'ee11cbb19052e40b07aac0ca060c23ee', NULL, 'Nguyễn Ngọc', '', '0000-00-00', NULL, 4, 1, '0000-00-00 00:00:00'),
(3, 'adminf', '21232f297a57a5a743894a0e4a801fc3', 'dfdffdg0@gmail.com', 'kien', '', '0000-00-00', '092659baoxaydung_5_5679698f7baac.jpg', 1, 1, '2015-12-16 00:00:00'),
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
(16, 'nhanvien', '21232f297a57a5a743894a0e4a801fc3', NULL, NULL, '', NULL, '092659baoxaydung_5_56c7eaa1899f7.jpg', 3, 1, '2016-02-20 05:22:37'),
(17, 'kienbk1910', 'c27fe7656f40a481d0f55f92b48d8314', NULL, NULL, '', NULL, NULL, 2, 0, '2016-02-28 03:18:58'),
(19, 'kienpd2', '25d55ad283aa400af464c76d713c07ad', NULL, NULL, '', NULL, NULL, 2, 0, '2016-02-28 03:19:57');

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
-- Index pour la table `courses`
--
ALTER TABLE `courses`
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
-- Index pour la table `file_attachment`
--
ALTER TABLE `file_attachment`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `location_option`
--
ALTER TABLE `location_option`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `manager_certificates`
--
ALTER TABLE `manager_certificates`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `certificate_code` (`certificate_code`);

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
-- Index pour la table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `pay_action`
--
ALTER TABLE `pay_action`
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
-- Index pour la table `state`
--
ALTER TABLE `state`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `state_id` (`state_id`);

--
-- Index pour la table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code` (`code`);

--
-- Index pour la table `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `task_comments`
--
ALTER TABLE `task_comments`
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;
--
-- AUTO_INCREMENT pour la table `courses`
--
ALTER TABLE `courses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
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
-- AUTO_INCREMENT pour la table `file_attachment`
--
ALTER TABLE `file_attachment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT pour la table `location_option`
--
ALTER TABLE `location_option`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT pour la table `logs`
--
ALTER TABLE `logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=163;
--
-- AUTO_INCREMENT pour la table `manager_certificates`
--
ALTER TABLE `manager_certificates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `money_history`
--
ALTER TABLE `money_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;
--
-- AUTO_INCREMENT pour la table `money_option`
--
ALTER TABLE `money_option`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT pour la table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT pour la table `pay_action`
--
ALTER TABLE `pay_action`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT pour la table `process`
--
ALTER TABLE `process`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT pour la table `state`
--
ALTER TABLE `state`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT pour la table `students`
--
ALTER TABLE `students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `tasks`
--
ALTER TABLE `tasks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;
--
-- AUTO_INCREMENT pour la table `task_comments`
--
ALTER TABLE `task_comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;
--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
