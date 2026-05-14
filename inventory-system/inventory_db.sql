-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 14, 2026 at 03:56 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `inventory_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `item_name` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `unit` varchar(50) DEFAULT NULL,
  `stock_number` varchar(100) DEFAULT NULL,
  `reorder_point` int(11) DEFAULT NULL,
  `current_balance` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `item_name`, `description`, `unit`, `stock_number`, `reorder_point`, `current_balance`, `created_at`) VALUES
(1, 'Carbon Film', 'A4 polyethylene', 'box', '13111201-CF-P01', 1, 0, '2026-05-12 23:34:38');

-- --------------------------------------------------------

--
-- Table structure for table `pr_items`
--

CREATE TABLE `pr_items` (
  `id` int(11) NOT NULL,
  `pr_id` int(11) DEFAULT NULL,
  `item_description` text DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `unit` varchar(50) DEFAULT NULL,
  `estimated_cost` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ris_items`
--

CREATE TABLE `ris_items` (
  `id` int(11) NOT NULL,
  `ris_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity_requested` int(11) DEFAULT NULL,
  `quantity_issued` int(11) DEFAULT NULL,
  `stock_available` varchar(10) DEFAULT NULL,
  `remarks` text DEFAULT NULL,
  `other_item` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ris_items`
--

INSERT INTO `ris_items` (`id`, `ris_id`, `product_id`, `quantity_requested`, `quantity_issued`, `stock_available`, `remarks`, `other_item`) VALUES
(1, 1, 1, 1, 0, 'NO', NULL, NULL),
(2, 2, 1, 1, 0, 'NO', NULL, ''),
(3, 3, 1, 1, 0, 'NO', NULL, ''),
(4, 4, 0, 1, 0, 'NO', NULL, 'Paracetamol'),
(5, 5, 0, 1, 0, 'NO', NULL, 'Paracetamol'),
(6, 7, 1, 1, 0, 'NO', NULL, ''),
(7, 7, 0, 1, 0, 'NO', NULL, 'Paracetamol'),
(8, 8, 1, 1, 0, 'NO', NULL, ''),
(9, 8, 0, 1, 0, 'NO', NULL, 'Paracetamol'),
(10, 12, 0, 2, 0, 'NO', NULL, 'Paracetamol'),
(11, 12, 0, 10, 0, 'NO', NULL, 'Diatabs'),
(12, 13, 0, 1, 0, 'NO', NULL, 'Stamp Pad (Blue)'),
(13, 13, 0, 6, 0, 'NO', NULL, 'Paracetamol'),
(14, 14, NULL, 1, 0, 'NO', NULL, 'Colored paper'),
(15, 14, NULL, 1, 0, 'NO', NULL, 'Colored pen'),
(16, 15, NULL, 20, 0, 'NO', NULL, 'Paracetamol'),
(17, 15, NULL, 10, 0, 'NO', NULL, 'Paper Plate'),
(18, 16, NULL, 20, 0, 'NO', NULL, 'Paracetamol'),
(19, 16, NULL, 10, 0, 'NO', NULL, 'Paper Plate'),
(20, 17, NULL, 20, 0, 'NO', NULL, 'Paracetamol'),
(21, 17, NULL, 10, 0, 'NO', NULL, 'Paper Plate');

-- --------------------------------------------------------

--
-- Table structure for table `ris_requests`
--

CREATE TABLE `ris_requests` (
  `id` int(11) NOT NULL,
  `ris_number` varchar(100) DEFAULT NULL,
  `office` varchar(100) DEFAULT NULL,
  `purpose` text DEFAULT NULL,
  `requested_by` varchar(100) DEFAULT NULL,
  `approved_by` varchar(100) DEFAULT NULL,
  `issued_by` varchar(100) DEFAULT NULL,
  `received_by` varchar(100) DEFAULT NULL,
  `request_date` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ris_requests`
--

INSERT INTO `ris_requests` (`id`, `ris_number`, `office`, `purpose`, `requested_by`, `approved_by`, `issued_by`, `received_by`, `request_date`, `created_at`) VALUES
(1, 'RIS-20260513020132', 'FAD', '', NULL, NULL, NULL, NULL, '2026-05-13', '2026-05-13 00:01:32'),
(2, 'RIS-20260513021532', 'FAD', '', NULL, NULL, NULL, NULL, '2026-05-13', '2026-05-13 00:15:32'),
(3, 'RIS-20260513022044', 'FAD', '', NULL, NULL, NULL, NULL, '2026-05-13', '2026-05-13 00:20:44'),
(4, 'RIS-20260513022347', 'FAD', '', NULL, NULL, NULL, NULL, '2026-05-13', '2026-05-13 00:23:47'),
(5, 'RIS-20260513022403', 'FAD', '', NULL, NULL, NULL, NULL, '2026-05-13', '2026-05-13 00:24:03'),
(6, 'RIS-20260513022935', 'FAD', '', NULL, NULL, NULL, NULL, '2026-05-13', '2026-05-13 00:29:35'),
(7, 'RIS-20260513023010', 'FAD', '', NULL, NULL, NULL, NULL, '2026-05-13', '2026-05-13 00:30:10'),
(8, 'RIS-20260513041735', 'FAD', '', NULL, NULL, NULL, NULL, '2026-05-13', '2026-05-13 02:17:35'),
(9, 'RIS-20260513074324', 'FAD', '', NULL, NULL, NULL, NULL, '2026-05-13', '2026-05-13 05:43:24'),
(10, 'RIS-20260514010432', 'FAD', '', NULL, NULL, NULL, NULL, '2026-05-14', '2026-05-13 23:04:32'),
(11, 'RIS-20260514023802', 'FAD', '', NULL, NULL, NULL, NULL, '2026-05-14', '2026-05-14 00:38:02'),
(12, 'RIS-20260514023957', 'FAD', '', NULL, NULL, NULL, NULL, '2026-05-14', '2026-05-14 00:39:57'),
(13, 'RIS-20260514025212', 'FAD', '', NULL, NULL, NULL, NULL, '2026-05-14', '2026-05-14 00:52:12'),
(14, 'RIS-20260514034102', 'FAD', 'Office Supply', NULL, NULL, NULL, NULL, '2026-05-14', '2026-05-14 01:41:02'),
(15, 'RIS-20260514034133', 'FAD', 'Office use', NULL, NULL, NULL, NULL, '2026-05-14', '2026-05-14 01:41:33'),
(16, 'RIS-20260514034241', 'FAD', 'Office use', NULL, NULL, NULL, NULL, '2026-05-14', '2026-05-14 01:42:41'),
(17, 'RIS-20260514034320', 'FAD', 'Office use', NULL, NULL, NULL, NULL, '2026-05-14', '2026-05-14 01:43:20');

-- --------------------------------------------------------

--
-- Table structure for table `stock_movements`
--

CREATE TABLE `stock_movements` (
  `id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `transaction_date` date DEFAULT NULL,
  `reference_no` varchar(100) DEFAULT NULL,
  `transaction_type` varchar(50) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `office` varchar(100) DEFAULT NULL,
  `balance_after` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pr_items`
--
ALTER TABLE `pr_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ris_items`
--
ALTER TABLE `ris_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ris_requests`
--
ALTER TABLE `ris_requests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stock_movements`
--
ALTER TABLE `stock_movements`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `pr_items`
--
ALTER TABLE `pr_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ris_items`
--
ALTER TABLE `ris_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `ris_requests`
--
ALTER TABLE `ris_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `stock_movements`
--
ALTER TABLE `stock_movements`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
