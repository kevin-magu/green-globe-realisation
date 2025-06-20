-- phpMyAdmin SQL Dump
-- version 5.1.1deb5ubuntu1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 24, 2023 at 03:59 PM
-- Server version: 8.0.33-0ubuntu0.22.04.2
-- PHP Version: 8.1.2-1ubuntu2.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ggr_test`
--

-- --------------------------------------------------------

--
-- Table structure for table `blogs`CHARSET=utf8
--

CREATE TABLE `blogs` (
  `id` int NOT NULL,
  `blog_title` varchar(300) NOT NULL,
  `paragraph1` varchar(4000) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `paragraph2` varchar(4000) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `paragraph3` varchar(4000) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `photo1` blob,
  `photo2` blob,
  `photo3` blob,
  `author` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `blogs`
--

INSERT INTO `blogs` (`id`, `blog_title`, `paragraph1`, `paragraph2`, `paragraph3`, `photo1`, `photo2`, `photo3`, `author`) VALUES
(3, 'planting trees', 'Engaging in tree planting initiatives is not only beneficial for the environment but also for our communities. Planting trees brings people together, fostering a sense of community and collective responsibility towards the environment.', 'Engaging in tree planting initiatives is not only beneficial for the environment but also for our communities. Planting trees brings people together, fostering a sense of community and collective responsibility towards the environment.', 'Engaging in tree planting initiatives is not only beneficial for the environment but also for our communities. Planting trees brings people together, fostering a sense of community and collective responsibility towards the environment.', 0x4172726179, 0x4172726179, 0x4172726179, 'Farah Ali Farah'),
(5, 'The Importance of Tree Planting', 'Trees are the silent heroes of our planet, playing a crucial role in maintaining ecological balance and combating climate change. Their significance cannot be overstated, as they provide numerous environmental, economic, and social benefits. When we engage in tree planting initiatives, we actively contribute to the restoration and preservation of our natural ecosystems.', 'Trees are the silent heroes of our planet, playing a crucial role in maintaining ecological balance and combating climate change. Their significance cannot be overstated, as they provide numerous environmental, economic, and social benefits. When we engage in tree planting initiatives, we actively contribute to the restoration and preservation of our natural ecosystems.', 'Trees are the silent heroes of our planet, playing a crucial role in maintaining ecological balance and combating climate change. Their significance cannot be overstated, as they provide numerous environmental, economic, and social benefits. When we engage in tree planting initiatives, we actively contribute to the restoration and preservation of our natural ecosystems.', 0x363439343963333938336433352e6a7067, 0x363439343963333938336433382e6a706567, 0x363439343963333938336433392e706e67, 'Kevin Magu');

-- --------------------------------------------------------

--
-- Table structure for table `gallery`
--

CREATE TABLE `gallery` (
  `id` int NOT NULL,
  `image_title` varchar(100) NOT NULL,
  `photo` blob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `gallery`
--

INSERT INTO `gallery` (`id`, `image_title`, `photo`) VALUES
(1, 'planting trees', 0x363439313837316630343630302e6a706567),
(2, 'Plastics', 0x363439313866396238353335302e6a7067),
(3, 'Plastics', 0x363439313866613334373665342e6a7067),
(4, 'Plastics', 0x363439313866616161333065632e6a7067),
(5, 'Plastics', 0x363439313866633739326135622e6a706567),
(6, 'Plastics', 0x363439313930343431353930312e6a706567),
(8, 'Planting trees at huruma', 0x363439356632366661666463312e6a7067);

-- --------------------------------------------------------

--
-- Table structure for table `upcoming_events`
--

CREATE TABLE `upcoming_events` (
  `id` int NOT NULL,
  `event_title` varchar(1000) NOT NULL,
  `place` varchar(1000) NOT NULL,
  `datee` varchar(200) NOT NULL,
  `timee` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `photo` blob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `upcoming_events`
--

INSERT INTO `upcoming_events` (`id`, `event_title`, `place`, `datee`, `timee`, `photo`) VALUES
(9, 'Planting Trees', 'Huruma Estate', '12/05/2023', '12.00pm', 0x363439356631616363333438352e6a706567);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `blogs`
--
ALTER TABLE `blogs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gallery`
--
ALTER TABLE `gallery`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `upcoming_events`
--
ALTER TABLE `upcoming_events`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `blogs`
--
ALTER TABLE `blogs`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `gallery`
--
ALTER TABLE `gallery`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `upcoming_events`
--
ALTER TABLE `upcoming_events`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
