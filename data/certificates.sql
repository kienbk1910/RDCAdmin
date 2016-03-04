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
(24, 'Chứng Chỉ Lao ĐỘng', 'Hồ sơ gồm có: cmnd, ms thuế, bảo hiểm', '2016-02-29 17:31:44', 1, 1, '2016-03-04 21:20:20'),
(25, 'Chứng Chỉ Hành Nghề', 'Hồ sơ gồm có: cmnd', '2016-02-29 17:31:57', 1, 1, '2016-02-29 17:31:57'),
(26, 'văn bằng 2', 'hồ sơ gồm abc 123 4567', '2016-02-29 18:28:08', 1, 1, '2016-02-29 18:28:24'),
(27, 'chứng chỉ xây dựng', 'không có ghi chú ', '2016-03-02 18:43:32', 1, 1, '2016-03-02 18:43:32');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
