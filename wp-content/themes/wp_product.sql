-- phpMyAdmin SQL Dump
-- version 5.0.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 22, 2020 at 05:30 PM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.3.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `fbag`
--

-- --------------------------------------------------------

--
-- Table structure for table `wp_product`
--

CREATE TABLE `wp_product` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `barcode` varchar(255) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `product_description` longtext NOT NULL,
  `recipe` varchar(255) NOT NULL,
  `nutrition` varchar(255) NOT NULL,
  `ingredients` varchar(255) NOT NULL,
  `barimage` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `wp_product`
--

INSERT INTO `wp_product` (`id`, `user_id`, `barcode`, `product_name`, `product_description`, `recipe`, `nutrition`, `ingredients`, `barimage`, `created_at`) VALUES
(2, 1, '1256', 'onian', 'onian', 'onian', '', 'onian', '', '2020-12-22 10:06:41'),
(3, 1, '35624', 'Paneer', 'Paneer', 'Paneer', '', 'Paneer', '', '2020-12-22 10:40:59'),
(22, 0, '56486', 'test12', 'It is test product1.', 'test23', 'test3', 'test3', '', '2020-12-21 15:14:44'),
(23, 0, '32423', 'asdsa', '', '', '', '', '', '2020-12-22 10:22:45'),
(28, 1, '1256sd', 'sdg', '', '', '', '', '1608632154download.png', '2020-12-22 10:15:54');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `wp_product`
--
ALTER TABLE `wp_product`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `wp_product`
--
ALTER TABLE `wp_product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
