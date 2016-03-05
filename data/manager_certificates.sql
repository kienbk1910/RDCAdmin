-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Mar 04, 2016 at 09:21 PM
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
-- Table structure for table `manager_certificates`
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

--
-- Dumping data for table `manager_certificates`
--

INSERT INTO `manager_certificates` (`id`, `certificate_type`, `certificate_code`, `full_name`, `place_of_birth`, `identity_card`, `date_of_issue`, `start_time`, `end_time`, `day_of_birth`, `note`, `create_user_id`, `last_user_id`, `last_update`) VALUES
(18, 24, '6', 'anh viet', '1', 3, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00', '0000-00-00 00:00:00', 1, '2016-03-04 21:19:52'),
(19, 24, '3', 'anh 2', '4', 545645646, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00', '0000-00-00 00:00:00', 1, '2016-03-04 21:18:24'),
(24, 24, '7', 'a/Tam', '989866', 2147483647, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00', '0000-00-00 00:00:00', 1, '2016-03-04 21:15:47'),
(25, 24, '123123', 'a.Viet', '32131', 123123, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0002-03-04 00:00:00', '0000-00-00', '0000-00-00 00:00:00', 1, '2016-03-04 19:00:45'),
(26, 24, '3123', 'viet', 'tran', 123123123, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00', '0000-00-00 00:00:00', 1, '2016-03-04 19:50:20'),
(27, 24, '0', 'Viet', 'QunA NAm', 123, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00', '0000-00-00 00:00:00', 1, '2016-03-04 20:23:25'),
(29, 24, '1111111', 'Viet 2', 'QN', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00', '0000-00-00 00:00:00', 1, '2016-03-04 20:24:13'),
(31, 24, 'asdasdasdas', 'a', 'asdasdasd', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00', '0000-00-00 00:00:00', 1, '2016-03-04 20:29:07'),
(34, 24, 'asdasdasdasaaaa', 'a', 'asdasdasd', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00', '0000-00-00 00:00:00', 1, '2016-03-04 20:29:53');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `manager_certificates`
--
ALTER TABLE `manager_certificates`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `certificate_code` (`certificate_code`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `manager_certificates`
--
ALTER TABLE `manager_certificates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
