-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 19, 2026 at 07:56 AM
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
  `other_item` text DEFAULT NULL,
  `quantity_to_purchase` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ris_items`
--

INSERT INTO `ris_items` (`id`, `ris_id`, `product_id`, `quantity_requested`, `quantity_issued`, `stock_available`, `remarks`, `other_item`, `quantity_to_purchase`) VALUES
(2, 2, 1, 1, 0, 'NO', NULL, '', 0),
(3, 3, 1, 1, 0, 'NO', NULL, '', 0),
(4, 4, 0, 1, 0, 'NO', NULL, 'Paracetamol', 0),
(5, 5, 0, 1, 0, 'NO', NULL, 'Paracetamol', 0),
(6, 7, 1, 1, 0, 'NO', NULL, '', 0),
(7, 7, 0, 1, 0, 'NO', NULL, 'Paracetamol', 0),
(8, 8, 1, 1, 0, 'NO', NULL, '', 0),
(9, 8, 0, 1, 0, 'NO', NULL, 'Paracetamol', 0),
(10, 12, 0, 2, 0, 'NO', NULL, 'Paracetamol', 0),
(11, 12, 0, 10, 0, 'NO', NULL, 'Diatabs', 0),
(12, 13, 0, 1, 0, 'NO', NULL, 'Stamp Pad (Blue)', 0),
(13, 13, 0, 6, 0, 'NO', NULL, 'Paracetamol', 0),
(14, 14, NULL, 1, 0, 'NO', NULL, 'Colored paper', 0),
(15, 14, NULL, 1, 0, 'NO', NULL, 'Colored pen', 0),
(16, 15, NULL, 20, 0, 'NO', NULL, 'Paracetamol', 0),
(17, 15, NULL, 10, 0, 'NO', NULL, 'Paper Plate', 0),
(18, 16, NULL, 20, 0, 'NO', NULL, 'Paracetamol', 0),
(19, 16, NULL, 10, 0, 'NO', NULL, 'Paper Plate', 0),
(20, 17, NULL, 20, 0, 'NO', NULL, 'Paracetamol', 0),
(21, 17, NULL, 10, 0, 'NO', NULL, 'Paper Plate', 0),
(22, 18, NULL, 20, 0, 'NO', NULL, 'Paracetamol', 0),
(23, 18, NULL, 10, 0, 'NO', NULL, 'Paper Plate', 0),
(24, 19, NULL, 1, 0, 'NO', NULL, 'Cardboard', 0),
(25, 19, NULL, 1, 0, 'NO', NULL, 'Photopaper', 0),
(28, 20, NULL, 2, 0, 'NO', NULL, 'Cardboard', 0),
(29, 20, NULL, 1, 0, 'NO', NULL, 'Photopaper', 0);

-- --------------------------------------------------------

--
-- Table structure for table `ris_requests`
--

CREATE TABLE `ris_requests` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `ris_number` varchar(100) DEFAULT NULL,
  `office` varchar(100) DEFAULT NULL,
  `purpose` text DEFAULT NULL,
  `requested_by` varchar(100) DEFAULT NULL,
  `approved_by` varchar(100) DEFAULT NULL,
  `issued_by` varchar(100) DEFAULT NULL,
  `received_by` varchar(100) DEFAULT NULL,
  `request_date` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` varchar(20) DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ris_requests`
--

INSERT INTO `ris_requests` (`id`, `user_id`, `ris_number`, `office`, `purpose`, `requested_by`, `approved_by`, `issued_by`, `received_by`, `request_date`, `created_at`, `status`) VALUES
(2, NULL, 'RIS-20260513021532', 'FAD', '', NULL, NULL, NULL, NULL, '2026-05-13', '2026-05-13 00:15:32', 'Pending'),
(3, NULL, 'RIS-20260513022044', 'FAD', '', NULL, NULL, NULL, NULL, '2026-05-13', '2026-05-13 00:20:44', 'Pending'),
(4, NULL, 'RIS-20260513022347', 'FAD', '', NULL, NULL, NULL, NULL, '2026-05-13', '2026-05-13 00:23:47', 'Pending'),
(5, NULL, 'RIS-20260513022403', 'FAD', '', NULL, NULL, NULL, NULL, '2026-05-13', '2026-05-13 00:24:03', 'Pending'),
(6, NULL, 'RIS-20260513022935', 'FAD', '', NULL, NULL, NULL, NULL, '2026-05-13', '2026-05-13 00:29:35', 'Pending'),
(7, NULL, 'RIS-20260513023010', 'FAD', '', NULL, NULL, NULL, NULL, '2026-05-13', '2026-05-13 00:30:10', 'Pending'),
(8, NULL, 'RIS-20260513041735', 'FAD', '', NULL, NULL, NULL, NULL, '2026-05-13', '2026-05-13 02:17:35', 'Pending'),
(9, NULL, 'RIS-20260513074324', 'FAD', '', NULL, NULL, NULL, NULL, '2026-05-13', '2026-05-13 05:43:24', 'Pending'),
(10, NULL, 'RIS-20260514010432', 'FAD', '', NULL, NULL, NULL, NULL, '2026-05-14', '2026-05-13 23:04:32', 'Pending'),
(11, NULL, 'RIS-20260514023802', 'FAD', '', NULL, NULL, NULL, NULL, '2026-05-14', '2026-05-14 00:38:02', 'Pending'),
(12, NULL, 'RIS-20260514023957', 'FAD', '', NULL, NULL, NULL, NULL, '2026-05-14', '2026-05-14 00:39:57', 'Pending'),
(13, NULL, 'RIS-20260514025212', 'FAD', '', NULL, NULL, NULL, NULL, '2026-05-14', '2026-05-14 00:52:12', 'Pending'),
(14, NULL, 'RIS-20260514034102', 'FAD', 'Office Supply', NULL, NULL, NULL, NULL, '2026-05-14', '2026-05-14 01:41:02', 'Pending'),
(15, NULL, 'RIS-20260514034133', 'FAD', 'Office use', NULL, NULL, NULL, NULL, '2026-05-14', '2026-05-14 01:41:33', 'Pending'),
(16, NULL, 'RIS-20260514034241', 'FAD', 'Office use', NULL, NULL, NULL, NULL, '2026-05-14', '2026-05-14 01:42:41', 'Pending'),
(17, NULL, 'RIS-20260514034320', 'FAD', 'Office use', NULL, NULL, NULL, NULL, '2026-05-14', '2026-05-14 01:43:20', 'Pending'),
(18, NULL, 'RIS-20260514042846', 'FAD', 'Office use', NULL, NULL, NULL, NULL, '2026-05-14', '2026-05-14 02:28:46', 'Pending'),
(19, NULL, 'RIS-20260514042922', 'FAD', 'Office use', NULL, NULL, NULL, NULL, '2026-05-14', '2026-05-14 02:29:22', 'Pending'),
(20, NULL, 'RIS-20260515033552', 'FAD', 'Office use', NULL, NULL, NULL, NULL, '2026-05-15', '2026-05-15 01:35:52', 'Pending');

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

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` enum('admin','user','supply_officer') DEFAULT 'user',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `position_title` varchar(255) DEFAULT NULL,
  `division` varchar(255) DEFAULT NULL,
  `last_name` varchar(100) DEFAULT NULL,
  `first_name` varchar(100) DEFAULT NULL,
  `middle_initial` varchar(10) DEFAULT NULL,
  `profile_pic` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `role`, `created_at`, `position_title`, `division`, `last_name`, `first_name`, `middle_initial`, `profile_pic`) VALUES
(3, 'mescano@dbm.gov.ph', '$2y$10$9mExyHDebo1POy4WrxfQIegr2DIs4MfXRnOgVylvcz5cJlchKYk1G', 'admin', '2026-05-14 04:27:48', 'ADMINISTRATIVE OFFICER III', 'FINANCE AND ADMINISTRATIVE DIVISION', 'ESCAñO', 'MICHELLE JOY', 'A', NULL),
(4, 'dbm_ro4a@dbm.gov.ph', '$2y$10$1Yp4iTxfb5.eeD3MEMarI.1rHwzdLD4cv2S4B4eLv6ClTJIDB5z9O', 'admin', '2026-05-14 04:41:11', 'ADMINISTRATOR', 'ADMIN DIVISION', 'ADMIN', 'SYSTEM', '', NULL),
(5, 'test@yopmail.com', '$2y$10$fI61yh7UB57LfIv4gaHw4urhssGDmOVI3YEuz7Fe8kRQb0F6D0CFO', 'supply_officer', '2026-05-15 01:40:30', 'ADMINISTRATIVE OFFICER II', 'FIANANCE AND ADMINISTRATIVE DIVISION', 'SAMPLE', 'SAMPLE', '', NULL),
(6, 'user@yopmail.com', '$2y$10$B4LO2oS2ZInqs3wA7xbz.ubfTjX82aATJvxYTAIHoBDmI6Db73k8K', 'user', '2026-05-18 07:58:21', 'SENIOR BUDGET AND MANAGEMENT SPECIALIST', 'TECHNICAL DIVISION A', 'TEST', 'USER', '', NULL);

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
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `ris_requests`
--
ALTER TABLE `ris_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `stock_movements`
--
ALTER TABLE `stock_movements`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
