-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jan 25, 2016 at 06:17 PM
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
-- Table structure for table `logs`
--

CREATE TABLE `logs` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `action_id` int(11) NOT NULL,
  `value` text NOT NULL,
  `task_id` int(11) NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `logs`
--

INSERT INTO `logs` (`id`, `user_id`, `action_id`, `value`, `task_id`, `date`) VALUES
(1, 1, 3, '{"custumer":"3","certificate":"3","agency_id":"2","date_open":"2016-01-21","date_end":"2016-01-20","cost_sell":"3","agency_note":"555","provider_id":"2","cost_buy":"3","date_open_pr":"2016-01-21","date_end_pr":"2016-01-20","provider_note":"5555","user_id":"1","create_date":"2016-01-25 16:30:05","last_update":"2016-01-25 16:30:05","last_user_id":"1","process_id":1,"reporter_id":"1","assign_id":"1"}', 25, '2016-01-25 16:30:05'),
(2, 1, 3, '{"id":"26","custumer":"ccc","certificate":"ccc","agency_id":"2","cost_sell":"1","date_open":"2016-01-25","date_end":"2016-01-28","agency_note":"ccc","provider_id":"2","cost_buy":"1","date_open_pr":"2016-01-25","date_end_pr":"2016-01-26","provider_note":"cccc","user_id":"1","create_date":"2016-01-25 17:35:19","last_user_id":"1","last_update":"2016-01-25 17:35:19","process_id":1,"reporter_id":"1","assign_id":"1"}', 26, '2016-01-25 17:35:20'),
(3, 1, 3, '{"id":"27","custumer":"111","certificate":"111","agency_id":"2","cost_sell":"1","date_open":"2016-01-22","date_end":"2016-01-30","agency_note":"1111","provider_id":"2","cost_buy":"1","date_open_pr":"2016-01-22","date_end_pr":"2016-01-25","provider_note":"1111","user_id":"1","create_date":"2016-01-25 18:12:10","last_user_id":"1","last_update":"2016-01-25 18:12:10","process_id":1,"reporter_id":"1","assign_id":"1"}', 27, '2016-01-25 18:12:11');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `logs`
--
ALTER TABLE `logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
