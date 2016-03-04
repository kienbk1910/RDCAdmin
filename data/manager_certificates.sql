-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Mar 02, 2016 at 07:41 PM
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
  `certificate_code` int(11) NOT NULL,
  `full_name` varchar(20) NOT NULL,
  `place_of_birth` varchar(100) NOT NULL,
  `start_time` datetime NOT NULL,
  `end_time` datetime NOT NULL,
  `identity_card` int(11) NOT NULL,
  `day_of_birth` datetime NOT NULL,
  `note` varchar(500) DEFAULT NULL,
  `create_user_id` datetime NOT NULL,
  `last_user_id` int(11) NOT NULL,
  `last_update` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `manager_certificates`
--

INSERT INTO `manager_certificates` (`id`, `certificate_type`, `certificate_code`, `full_name`, `place_of_birth`, `start_time`, `end_time`, `identity_card`, `day_of_birth`, `note`, `create_user_id`, `last_user_id`, `last_update`) VALUES
(1, 1, 1122, 'Tran Viet', 'Quang Nam', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 121213, '2016-02-06 00:00:00', '', '0000-00-00 00:00:00', 1, '2016-02-24 00:00:00'),
(2, 24, 11, 'ádasdsa', '?âsd', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 2, '0000-00-00 00:00:00', '0000-00-00', '0000-00-00 00:00:00', 1, '2016-03-02 19:33:17'),
(11, 24, 0, 'aViet', 'Trada', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 2147483647, '0000-00-00 00:00:00', '0000-00-00', '0000-00-00 00:00:00', 1, '2016-03-02 19:39:52');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `manager_certificates`
--
ALTER TABLE `manager_certificates`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `certificate_code` (`certificate_code`),
  ADD UNIQUE KEY `identity_card` (`identity_card`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `manager_certificates`
--
ALTER TABLE `manager_certificates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
