-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Feb 21, 2016 at 06:44 PM
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
  `permanent_address` varchar(100) NOT NULL,
  `current_address` varchar(100) NOT NULL,
  `identity_card` int(11) NOT NULL,
  `day_of_birth` datetime NOT NULL,
  `last_user_id` int(11) NOT NULL,
  `last_update` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `manager_certificates`
--

INSERT INTO `manager_certificates` (`id`, `certificate_type`, `certificate_code`, `full_name`, `place_of_birth`, `permanent_address`, `current_address`, `identity_card`, `day_of_birth`, `last_user_id`, `last_update`) VALUES
(1, 1, 1122, 'Tran Viet', 'Quang Nam', 'Hong Lac', 'Thu Duc', 121213, '2016-02-06 00:00:00', 1, '2016-02-24 00:00:00');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
