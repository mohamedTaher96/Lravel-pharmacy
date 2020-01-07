-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 07, 2020 at 05:37 PM
-- Server version: 10.1.35-MariaDB
-- PHP Version: 7.2.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pharmacy`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `email` text NOT NULL,
  `pass` int(11) NOT NULL,
  `name` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `email`, `pass`, `name`) VALUES
(1, 'admin@email.com', 123, 'omar');

-- --------------------------------------------------------

--
-- Table structure for table `bills`
--

CREATE TABLE `bills` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `total` double NOT NULL,
  `branche_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bills`
--

INSERT INTO `bills` (`id`, `created_at`, `updated_at`, `total`, `branche_id`) VALUES
(93, '2019-07-10 03:31:41', '2019-07-10 03:31:41', 30.79166666666667, 1),
(95, '2019-07-18 14:18:27', '2019-07-18 14:18:27', 0, 1),
(97, '2019-07-18 16:14:30', '2019-07-18 16:14:30', 0, 1),
(101, '2019-07-18 16:28:37', '2019-07-18 16:28:37', 0, 1),
(105, '2019-07-18 16:36:44', '2019-07-18 16:36:44', 0, 1),
(120, '2019-07-23 10:40:53', '2019-07-23 10:40:53', 0, 1),
(147, '2019-07-23 15:17:30', '2019-07-23 15:17:30', 23.75, 1),
(148, '2019-07-23 15:18:05', '2019-07-23 15:18:05', 47.5, 1);

-- --------------------------------------------------------

--
-- Table structure for table `branches`
--

CREATE TABLE `branches` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `name` text COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `branches`
--

INSERT INTO `branches` (`id`, `created_at`, `updated_at`, `name`) VALUES
(1, '2019-07-06 02:08:37', '2019-07-06 02:08:37', 'mansoura'),
(2, '2019-07-10 03:36:52', '2019-07-10 03:36:52', 'cairo');

-- --------------------------------------------------------

--
-- Table structure for table `cashier`
--

CREATE TABLE `cashier` (
  `id` int(11) NOT NULL,
  `email` text NOT NULL,
  `pass` int(11) NOT NULL,
  `name` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cashier`
--

INSERT INTO `cashier` (`id`, `email`, `pass`, `name`) VALUES
(1, 'cashier@email.com', 123, 'ali'),
(2, 'admin@email.com', 123, 'omar');

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `precentage` double NOT NULL,
  `expiration` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `medicine_id` bigint(11) NOT NULL,
  `source_id` bigint(11) NOT NULL,
  `stripe` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`id`, `code`, `precentage`, `expiration`, `created_at`, `updated_at`, `medicine_id`, `source_id`, `stripe`) VALUES
(206, 'b3', 92, '1990-09-21', '2019-07-23 15:17:19', '2019-07-23 15:17:19', 28, 10, 4);

-- --------------------------------------------------------

--
-- Table structure for table `makeups`
--

CREATE TABLE `makeups` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `cost` double NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `branche_id` int(11) NOT NULL,
  `photo` text COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `makeups`
--

INSERT INTO `makeups` (`id`, `name`, `cost`, `created_at`, `updated_at`, `branche_id`, `photo`) VALUES
(10, 'haircare', 35, '2019-07-08 08:03:47', '2019-07-08 08:03:47', 1, '1562580226.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `makeup_items`
--

CREATE TABLE `makeup_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `precentage` double NOT NULL,
  `expiration` date NOT NULL,
  `makeup_id` bigint(20) NOT NULL,
  `source_id` bigint(20) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `medicines`
--

CREATE TABLE `medicines` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `cost` double NOT NULL,
  `material` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `stripe` int(11) NOT NULL,
  `branche_id` int(11) NOT NULL,
  `photo` text COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `medicines`
--

INSERT INTO `medicines` (`id`, `name`, `cost`, `material`, `created_at`, `updated_at`, `stripe`, `branche_id`, `photo`) VALUES
(27, 'panadol', 50, 's', '2019-07-08 08:02:29', '2019-07-08 08:02:29', 3, 1, '1562580149.png'),
(28, 'parastamol', 30, 'j', '2019-07-08 08:02:53', '2019-07-08 08:02:53', 4, 1, '1562580173.jpg'),
(29, 'oplex', 25, 'e', '2019-07-08 08:03:17', '2019-07-08 08:03:17', 0, 1, '1562580197.png');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2019_06_21_194913_create_companies_table', 1),
(2, '2019_06_22_152407_create_stores_table', 2),
(3, '2019_06_22_155356_create_medicines_table', 3),
(4, '2019_06_22_182122_create_items_table', 4),
(5, '2019_06_22_183632_create_items_table', 5),
(6, '2019_06_24_193240_create_sources_table', 6),
(7, '2019_06_25_154959_create_makeups_table', 7),
(8, '2019_06_25_155921_create_makeup_items_table', 8),
(9, '2019_06_30_024531_create_sells_table', 9),
(10, '2019_06_30_030725_create_bills_table', 10),
(11, '2019_07_05_072149_create_transactions_table', 11),
(12, '2019_07_06_034136_create_branches_table', 12);

-- --------------------------------------------------------

--
-- Table structure for table `sells`
--

CREATE TABLE `sells` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `code` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `category_id` int(11) NOT NULL,
  `source_id` int(11) NOT NULL,
  `type` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `stripe` int(11) NOT NULL,
  `bill_id` int(11) NOT NULL,
  `expiration` date NOT NULL,
  `precentage` double NOT NULL,
  `branche_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sells`
--

INSERT INTO `sells` (`id`, `created_at`, `updated_at`, `code`, `category_id`, `source_id`, `type`, `stripe`, `bill_id`, `expiration`, `precentage`, `branche_id`) VALUES
(117, '2019-07-10 03:31:41', '2019-07-10 03:31:41', 'b4', 10, 10, 'makeup', 0, 93, '1999-09-09', 85, 1),
(227, '2019-07-23 15:17:30', '2019-07-23 15:17:30', 'b1', 29, 10, 'medicine', 0, 147, '1971-10-15', 44, 1),
(228, '2019-07-23 15:18:05', '2019-07-23 15:18:05', 'b2', 27, 10, 'medicine', 3, 148, '1986-01-27', 25, 1);

-- --------------------------------------------------------

--
-- Table structure for table `sources`
--

CREATE TABLE `sources` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `branche_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sources`
--

INSERT INTO `sources` (`id`, `name`, `type`, `created_at`, `updated_at`, `branche_id`) VALUES
(9, 'pharma', 'company', '2019-07-08 06:52:19', '2019-07-08 06:52:19', 1),
(10, 'niva', 'store', '2019-07-08 06:52:41', '2019-07-08 06:52:41', 1);

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `date` date NOT NULL,
  `total` double NOT NULL,
  `source_id` int(11) NOT NULL,
  `src` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `branche_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`id`, `created_at`, `updated_at`, `date`, `total`, `source_id`, `src`, `branche_id`) VALUES
(9, '2019-07-08 07:41:24', '2019-07-08 07:41:24', '2000-12-14', 76, 9, '1562578883.jpg', 1),
(10, '2019-07-08 07:41:39', '2019-07-08 07:41:39', '1979-03-23', 72, 9, '1562578899.gif', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bills`
--
ALTER TABLE `bills`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `branches`
--
ALTER TABLE `branches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cashier`
--
ALTER TABLE `cashier`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `medicineId` (`medicine_id`);

--
-- Indexes for table `makeups`
--
ALTER TABLE `makeups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `makeup_items`
--
ALTER TABLE `makeup_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `medicines`
--
ALTER TABLE `medicines`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sells`
--
ALTER TABLE `sells`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sources`
--
ALTER TABLE `sources`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `bills`
--
ALTER TABLE `bills`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=149;

--
-- AUTO_INCREMENT for table `branches`
--
ALTER TABLE `branches`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `cashier`
--
ALTER TABLE `cashier`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=207;

--
-- AUTO_INCREMENT for table `makeups`
--
ALTER TABLE `makeups`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `makeup_items`
--
ALTER TABLE `makeup_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `medicines`
--
ALTER TABLE `medicines`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `sells`
--
ALTER TABLE `sells`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=229;

--
-- AUTO_INCREMENT for table `sources`
--
ALTER TABLE `sources`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
