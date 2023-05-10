-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 12, 2022 at 09:59 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `wordpressage`
--

-- --------------------------------------------------------

--
-- Table structure for table `wp_ensage`
--

CREATE TABLE `wp_ensage` (
  `e_id` int(11) NOT NULL,
  `age` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `diagtext` text NOT NULL,
  `confirm` varchar(255) NOT NULL,
  `Decline` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `wp_ensage`
--

INSERT INTO `wp_ensage` (`e_id`, `age`, `title`, `diagtext`, `confirm`, `Decline`) VALUES
(1, 21, 'Are you 21 or older ?', 'This website requires you to be 21 years of age or older. Please verify your age to view the content, or click', 'I am over 21', 'Exit');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `wp_ensage`
--
ALTER TABLE `wp_ensage`
  ADD PRIMARY KEY (`e_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `wp_ensage`
--
ALTER TABLE `wp_ensage`
  MODIFY `e_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
