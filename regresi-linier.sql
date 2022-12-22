-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 13, 2022 at 05:22 PM
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
-- Database: `regresi-linier`
--

-- --------------------------------------------------------

--
-- Table structure for table `pmb`
--

CREATE TABLE `pmb` (
  `id` int(11) NOT NULL,
  `tahun_penerimaan` year(4) NOT NULL,
  `jumlah_pendaftar` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pmb`
--

INSERT INTO `pmb` (`id`, `tahun_penerimaan`, `jumlah_pendaftar`, `created_at`) VALUES
(27, 2020, 3921, '2022-12-13 13:59:49'),
(28, 2021, 3712, '2022-12-13 14:15:06'),
(29, 2022, 4487, '2022-12-13 14:17:06');

-- --------------------------------------------------------

--
-- Table structure for table `pmb_fakultas`
--

CREATE TABLE `pmb_fakultas` (
  `id` int(11) NOT NULL,
  `tahun_penerimaan` year(4) NOT NULL,
  `fakultas` varchar(100) NOT NULL,
  `jumlah_pendaftar` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pmb_fakultas`
--

INSERT INTO `pmb_fakultas` (`id`, `tahun_penerimaan`, `fakultas`, `jumlah_pendaftar`) VALUES
(48, 2020, 'Hukum', 320),
(49, 2021, 'Hukum', 320),
(50, 2022, 'Hukum', 373),
(51, 2020, 'Teknik', 736),
(52, 2020, 'Ekonomi dan Bisnis', 684),
(53, 2020, 'Pertanian', 581),
(54, 2020, 'Ilmu Sosial dan Ilmu Budaya', 576),
(55, 2020, 'Keislaman', 320),
(56, 2020, 'Ilmu Pendidikan', 704),
(57, 2021, 'Teknik', 724),
(58, 2021, 'Ekonomi dan Bisnis', 581),
(59, 2021, 'Pertanian', 569),
(60, 2021, 'Ilmu Sosial dan Ilmu Budaya', 576),
(61, 2021, 'Keislaman', 320),
(62, 2021, 'Ilmu Pendidikan', 622),
(63, 2022, 'Teknik', 812),
(64, 2022, 'Ekonomi dan Bisnis', 684),
(65, 2022, 'Pertanian', 740),
(66, 2022, 'Ilmu Sosial dan Ilmu Budaya', 747),
(67, 2022, 'Keislaman', 459),
(68, 2022, 'Ilmu Pendidikan', 672);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `created_at`) VALUES
(1, 'admin', 'd033e22ae348aeb5660fc2140aec35850c4da997', '2019-12-07 03:04:24');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `pmb`
--
ALTER TABLE `pmb`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pmb_fakultas`
--
ALTER TABLE `pmb_fakultas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `pmb`
--
ALTER TABLE `pmb`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `pmb_fakultas`
--
ALTER TABLE `pmb_fakultas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
