-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Feb 21, 2016 at 06:42 PM
-- Server version: 10.1.9-MariaDB
-- PHP Version: 5.5.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `rdc_admin`
--

-- --------------------------------------------------------

--
-- Table structure for table `certificates`
--

CREATE TABLE `certificates` (
  `id` int(11) NOT NULL,
  `certificate_name` varchar(500) NOT NULL,
  `certificate_note` text NOT NULL,
  `create_date` datetime NOT NULL,
  `create_user_id` int(11) NOT NULL,
  `last_user_id` int(11) NOT NULL,
  `last_update` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `certificates`
--

INSERT INTO `certificates` (`id`, `certificate_name`, `certificate_note`, `create_date`, `create_user_id`, `last_user_id`, `last_update`) VALUES
(1, 'Chứng Chỉ Hành Nghề', 'Chứng Chỉ Cho Việc Hành Nghề', '2016-02-01 00:00:00', 0, 0, '0000-00-00 00:00:00'),
(2, 'ádasda', 'đâsdasd', '2016-02-21 18:08:46', 1, 1, '2016-02-21 18:08:46'),
(3, 'ádasda', 'đâsdasd', '2016-02-21 18:09:03', 1, 1, '2016-02-21 18:09:03'),
(4, 'dsadasdas', 'đâsdasdasd', '2016-02-21 18:09:52', 1, 1, '2016-02-21 18:09:52'),
(5, '22222', '2222', '2016-02-21 18:10:54', 1, 1, '2016-02-21 18:10:54'),
(6, '333', '3333', '2016-02-21 18:11:41', 1, 1, '2016-02-21 18:11:41'),
(7, '333', '3333', '2016-02-21 18:14:01', 1, 1, '2016-02-21 18:14:01'),
(8, 'sadasd123123', '13', '2016-02-21 18:26:49', 1, 1, '2016-02-21 18:26:49'),
(9, 'aádas', 'đâsdad', '2016-02-21 18:27:27', 1, 1, '2016-02-21 18:27:27'),
(10, '321', '456', '2016-02-21 18:39:34', 1, 1, '2016-02-21 18:39:34');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `certificates`
--
ALTER TABLE `certificates`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `certificates`
--
ALTER TABLE `certificates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
