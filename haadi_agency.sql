-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 25, 2025 at 06:27 AM
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
-- Database: `haadi_agency`
--

-- --------------------------------------------------------

--
-- Table structure for table `add_details`
--

CREATE TABLE `add_details` (
  `id` int(100) NOT NULL,
  `add_purchase_id` int(100) NOT NULL,
  `category_id` int(100) NOT NULL,
  `items_id` int(100) NOT NULL,
  `price_id` int(100) NOT NULL,
  `qty` double(10,2) NOT NULL,
  `amount` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `add_details`
--

INSERT INTO `add_details` (`id`, `add_purchase_id`, `category_id`, `items_id`, `price_id`, `qty`, `amount`) VALUES
(217, 137, 8, 27, 99, 40.00, '3960.00'),
(218, 137, 8, 26, 153, 20.00, '3060.00'),
(219, 137, 8, 22, 152, 60.00, '9120.00'),
(220, 137, 8, 19, 73, 80.00, '5840.00'),
(221, 137, 8, 15, 290, 150.00, '43500.00'),
(222, 137, 9, 28, 157, 120.00, '18840.00'),
(223, 137, 9, 29, 157, 75.00, '11775.00'),
(224, 137, 9, 33, 53, 25.00, '1325.00'),
(225, 137, 9, 37, 157, 30.00, '4710.00'),
(226, 137, 9, 35, 35, 15.00, '525.00'),
(227, 137, 10, 38, 125, 10.00, '1250.00'),
(228, 138, 9, 28, 157, 10.00, '1570.00'),
(229, 138, 9, 30, 157, 15.00, '2355.00'),
(230, 138, 9, 37, 157, 10.00, '1570.00'),
(231, 138, 8, 26, 153, 15.00, '2295.00'),
(232, 138, 8, 27, 99, 25.00, '2475.00'),
(233, 138, 8, 23, 152, 13.00, '1976.00'),
(234, 138, 8, 22, 152, 8.00, '1216.00'),
(235, 138, 10, 38, 125, 9.00, '1125.00'),
(236, 138, 10, 39, 310, 17.00, '5270.00'),
(237, 138, 10, 40, 138, 16.00, '2208.00'),
(238, 139, 8, 12, 300, 10.00, '3000.00'),
(239, 139, 8, 13, 304, 20.00, '6080.00'),
(240, 139, 8, 15, 290, 10.00, '2900.00'),
(241, 139, 8, 19, 73, 15.00, '1095.00'),
(242, 139, 8, 25, 145, 14.00, '2030.00'),
(243, 139, 9, 35, 35, 16.00, '560.00'),
(244, 139, 9, 37, 157, 18.00, '2826.00'),
(245, 139, 10, 38, 125, 10.00, '1250.00');

-- --------------------------------------------------------

--
-- Table structure for table `add_purchase`
--

CREATE TABLE `add_purchase` (
  `id` int(100) NOT NULL,
  `bill_no` varchar(150) NOT NULL,
  `user_name` varchar(150) NOT NULL,
  `date` date NOT NULL,
  `req_total` varchar(150) NOT NULL,
  `status` varchar(100) NOT NULL DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `add_purchase`
--

INSERT INTO `add_purchase` (`id`, `bill_no`, `user_name`, `date`, `req_total`, `status`) VALUES
(137, '1', 'varsha', '2025-03-20', '103905.00', 'Pending'),
(138, '2', 'akif', '2025-03-20', '22060.00', 'Pending'),
(139, '3', 'akif', '2025-03-21', '19741.00', 'Pending');

-- --------------------------------------------------------

--
-- Table structure for table `bank_transactions`
--

CREATE TABLE `bank_transactions` (
  `id` int(100) NOT NULL,
  `bill_no` varchar(100) NOT NULL,
  `requested_name` varchar(100) NOT NULL,
  `sales_order_id` int(100) NOT NULL,
  `utr_no` varchar(150) NOT NULL,
  `b_amt` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bank_transactions`
--

INSERT INTO `bank_transactions` (`id`, `bill_no`, `requested_name`, `sales_order_id`, `utr_no`, `b_amt`) VALUES
(101, '2', 'akif', 409, '123', '500'),
(102, '3', 'akif', 419, '111', '500');

-- --------------------------------------------------------

--
-- Table structure for table `cash_denom`
--
-- Error reading structure for table haadi_agency.cash_denom: #1932 - Table &#039;haadi_agency.cash_denom&#039; doesn&#039;t exist in engine
-- Error reading data for table haadi_agency.cash_denom: #1064 - You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near &#039;FROM `haadi_agency`.`cash_denom`&#039; at line 1

-- --------------------------------------------------------

--
-- Table structure for table `cash_denominations`
--

CREATE TABLE `cash_denominations` (
  `id` int(100) NOT NULL,
  `bill_no` varchar(100) NOT NULL,
  `requested_name` varchar(100) NOT NULL,
  `sales_order_id` int(100) NOT NULL,
  `denomination` varchar(150) NOT NULL,
  `count_x` varchar(150) NOT NULL,
  `amount` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cash_denominations`
--

INSERT INTO `cash_denominations` (`id`, `bill_no`, `requested_name`, `sales_order_id`, `denomination`, `count_x`, `amount`) VALUES
(192, '2', 'akif', 409, '500', '10', '5000'),
(193, '2', 'akif', 409, '200', '10', '2000'),
(194, '3', 'akif', 419, '500', '1', '500'),
(195, '3', 'akif', 419, '200', '1', '200'),
(196, '3', 'akif', 419, '100', '1', '100'),
(197, '3', 'akif', 419, '50', '1', '50'),
(198, '3', 'akif', 419, '20', '1', '20'),
(199, '3', 'akif', 419, '10', '1', '10'),
(200, '3', 'akif', 419, '1', '1', '1');

-- --------------------------------------------------------

--
-- Table structure for table `cash_denom_details`
--
-- Error reading structure for table haadi_agency.cash_denom_details: #1932 - Table &#039;haadi_agency.cash_denom_details&#039; doesn&#039;t exist in engine
-- Error reading data for table haadi_agency.cash_denom_details: #1064 - You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near &#039;FROM `haadi_agency`.`cash_denom_details`&#039; at line 1

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE `login` (
  `id` int(100) NOT NULL,
  `name` varchar(150) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`id`, `name`, `email`, `password`) VALUES
(1, 'admin', 'admin@gmail.com', 'admin@12');

-- --------------------------------------------------------

--
-- Table structure for table `master_category`
--

CREATE TABLE `master_category` (
  `id` int(100) NOT NULL,
  `category` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `master_category`
--

INSERT INTO `master_category` (`id`, `category`) VALUES
(8, 'IPM'),
(9, 'GPI'),
(10, 'CANDY');

-- --------------------------------------------------------

--
-- Table structure for table `master_items`
--

CREATE TABLE `master_items` (
  `id` int(100) NOT NULL,
  `items` varchar(150) NOT NULL,
  `category_id` int(100) NOT NULL,
  `price` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `master_items`
--

INSERT INTO `master_items` (`id`, `items`, `category_id`, `price`) VALUES
(12, 'ADVANCE 20s', 8, '300'),
(13, 'LIGHT 20s', 8, '304'),
(14, 'RED 20s', 8, '290'),
(15, 'FUSE BOYEND 20s', 8, '290'),
(16, 'FOREST FUSION 20s', 8, '276'),
(17, 'PARLIMENT SPLASH 10s', 8, '109'),
(18, 'PARLIMENT GOLD 10s', 8, '109'),
(19, 'ADV COMPACT 10s', 8, '73'),
(22, 'ADVANCE 20s', 8, '152'),
(23, 'LIGHT 10s', 8, '152'),
(24, 'RED 10s', 8, '145'),
(25, 'FUSE BOYEND 10s', 8, '145'),
(26, 'CLOVE MIX 10s', 8, '153'),
(27, 'FINE TOUCH 10s', 8, '99'),
(28, 'SHIF ME 97MM', 9, '157'),
(29, 'SHIFT SLIM 100MM', 9, '157'),
(30, 'DEFINE ME 97MM', 9, '157'),
(31, 'DEFINE SLIM 100MM', 9, '157'),
(32, 'STELLAR CB 10s', 9, '49'),
(33, 'STELLAR IB 10s', 9, '53'),
(34, 'STELLAR SHIFT DUO 10s', 9, '187'),
(35, 'ORIGINAL 10s', 9, '35'),
(36, 'F S CRUSH TROPICAL', 9, '72'),
(37, 'DEFINE PAN ', 9, '157'),
(38, 'IMLI SMALL 525GM', 10, '125'),
(39, 'TIC TAK JAR', 10, '310'),
(40, 'TIC TAK HANGER', 10, '138');

-- --------------------------------------------------------

--
-- Table structure for table `order_list`
--

CREATE TABLE `order_list` (
  `id` int(100) NOT NULL,
  `bill_no` varchar(150) NOT NULL,
  `requested_name` varchar(100) NOT NULL,
  `category` varchar(100) NOT NULL,
  `items` varchar(100) NOT NULL,
  `price` varchar(150) NOT NULL,
  `qty` varchar(150) NOT NULL,
  `stc_qty` varchar(150) NOT NULL,
  `amount` varchar(150) NOT NULL,
  `sub_total` varchar(150) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` varchar(150) NOT NULL DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_list`
--

INSERT INTO `order_list` (`id`, `bill_no`, `requested_name`, `category`, `items`, `price`, `qty`, `stc_qty`, `amount`, `sub_total`, `created_at`, `status`) VALUES
(481, '2', 'akif', 'GPI', 'SHIF ME 97MM', '157', '10.00', '10.00', '1570.00', '22060.00', '2025-03-20 01:46:42', 'submitted'),
(482, '2', 'akif', 'GPI', 'DEFINE ME 97MM', '157', '15.00', '15.00', '2355.00', '22060.00', '2025-03-20 01:46:42', 'submitted'),
(483, '2', 'akif', 'GPI', 'DEFINE PAN ', '157', '10.00', '10.00', '1570.00', '22060.00', '2025-03-20 01:46:42', 'submitted'),
(484, '2', 'akif', 'IPM', 'CLOVE MIX 10s', '153', '15.00', '15.00', '2295.00', '22060.00', '2025-03-20 01:46:42', 'submitted'),
(485, '2', 'akif', 'IPM', 'FINE TOUCH 10s', '99', '25.00', '25.00', '2475.00', '22060.00', '2025-03-20 01:46:42', 'submitted'),
(486, '2', 'akif', 'IPM', 'LIGHT 10s', '152', '13.00', '13.00', '1976.00', '22060.00', '2025-03-20 01:46:42', 'submitted'),
(487, '2', 'akif', 'IPM', 'ADVANCE 20s', '152', '8.00', '8.00', '1216.00', '22060.00', '2025-03-20 01:46:42', 'submitted'),
(488, '2', 'akif', 'CANDY', 'IMLI SMALL 525GM', '125', '9.00', '9.00', '1125.00', '22060.00', '2025-03-20 01:46:42', 'submitted'),
(489, '2', 'akif', 'CANDY', 'TIC TAK JAR', '310', '17.00', '17.00', '5270.00', '22060.00', '2025-03-20 01:46:42', 'submitted'),
(490, '2', 'akif', 'CANDY', 'TIC TAK HANGER', '138', '16.00', '16.00', '2208.00', '22060.00', '2025-03-20 01:46:42', 'submitted'),
(491, '3', 'akif', 'IPM', 'ADVANCE 20s', '300', '10.00', '10.00', '3000.00', '19741.00', '2025-03-21 02:09:58', 'submitted'),
(492, '3', 'akif', 'IPM', 'LIGHT 20s', '304', '20.00', '20.00', '6080.00', '19741.00', '2025-03-21 02:09:58', 'submitted'),
(493, '3', 'akif', 'IPM', 'FUSE BOYEND 20s', '290', '10.00', '10.00', '2900.00', '19741.00', '2025-03-21 02:09:58', 'submitted'),
(494, '3', 'akif', 'IPM', 'ADV COMPACT 10s', '73', '15.00', '15.00', '1095.00', '19741.00', '2025-03-21 02:09:58', 'submitted'),
(495, '3', 'akif', 'IPM', 'FUSE BOYEND 10s', '145', '14.00', '14.00', '2030.00', '19741.00', '2025-03-21 02:09:58', 'submitted'),
(496, '3', 'akif', 'GPI', 'ORIGINAL 10s', '35', '16.00', '16.00', '560.00', '19741.00', '2025-03-21 02:09:58', 'submitted'),
(497, '3', 'akif', 'GPI', 'DEFINE PAN ', '157', '18.00', '18.00', '2826.00', '19741.00', '2025-03-21 02:09:58', 'submitted'),
(498, '3', 'akif', 'CANDY', 'IMLI SMALL 525GM', '125', '10.00', '10.00', '1250.00', '19741.00', '2025-03-21 02:09:58', 'submitted');

-- --------------------------------------------------------

--
-- Table structure for table `payment_details`
--

CREATE TABLE `payment_details` (
  `id` int(100) NOT NULL,
  `bill_no` varchar(100) NOT NULL,
  `requested_name` varchar(100) NOT NULL,
  `sales_order_id` int(100) NOT NULL,
  `payable_amount` varchar(150) NOT NULL,
  `paid_amount` varchar(150) NOT NULL,
  `balance_amount` varchar(150) NOT NULL,
  `sales_total` decimal(10,2) NOT NULL,
  `bank_total` decimal(10,2) NOT NULL,
  `voucher_total` decimal(10,2) NOT NULL,
  `total_amount` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payment_details`
--

INSERT INTO `payment_details` (`id`, `bill_no`, `requested_name`, `sales_order_id`, `payable_amount`, `paid_amount`, `balance_amount`, `sales_total`, `bank_total`, `voucher_total`, `total_amount`) VALUES
(106, '2', 'akif', 409, '17181', '8550', '8631', 17181.00, 650.00, 900.00, 7000.00),
(107, '3', 'akif', 419, '14256', '6031', '8225', 14256.00, 650.00, 4500.00, 881.00);

-- --------------------------------------------------------

--
-- Table structure for table `registration`
--

CREATE TABLE `registration` (
  `id` int(100) NOT NULL,
  `name` varchar(150) NOT NULL,
  `account_type` varchar(150) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(150) NOT NULL,
  `mobile_no` varchar(100) NOT NULL,
  `curr_date` date NOT NULL,
  `curr_time` varchar(150) NOT NULL,
  `status` varchar(100) NOT NULL DEFAULT 'confirm'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `registration`
--

INSERT INTO `registration` (`id`, `name`, `account_type`, `email`, `password`, `mobile_no`, `curr_date`, `curr_time`, `status`) VALUES
(13, 'varsha', 'user', 'rathodsushma121@gmail.com', 'varsha@12', '8596532563', '2025-03-13', '06:50:10', 'confirmed'),
(14, 'akif', 'user', 'sushmarathod090@gmail.com', 'sush@12', '9586545698', '2025-03-19', '06:54:54', 'confirmed');

-- --------------------------------------------------------

--
-- Table structure for table `sales_details`
--

CREATE TABLE `sales_details` (
  `id` int(100) NOT NULL,
  `buyer_name` varchar(150) NOT NULL,
  `mobile_no` varchar(150) NOT NULL,
  `email` varchar(150) NOT NULL,
  `address` varchar(150) NOT NULL,
  `sub_total` varchar(100) NOT NULL,
  `status` varchar(100) NOT NULL DEFAULT 'Order',
  `registration_id` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sales_details`
--

INSERT INTO `sales_details` (`id`, `buyer_name`, `mobile_no`, `email`, `address`, `sub_total`, `status`, `registration_id`) VALUES
(10, 'abc', '8545896589', 'abc@gmail.com', 'Bijapure', '6000.00', 'Order', 8),
(11, 'pop', '9586545698', 'rathodsushma121@gmail.com', 'Bijapure', '1450.00', 'orderplaced', 8);

-- --------------------------------------------------------

--
-- Table structure for table `sales_entry`
--

CREATE TABLE `sales_entry` (
  `id` int(100) NOT NULL,
  `sales_id` int(100) NOT NULL,
  `category` varchar(150) NOT NULL,
  `items` varchar(150) NOT NULL,
  `price` varchar(150) NOT NULL,
  `quantity` decimal(10,2) NOT NULL,
  `sales_date` date NOT NULL,
  `sales` varchar(150) NOT NULL,
  `total_amount` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sales_entry`
--

INSERT INTO `sales_entry` (`id`, `sales_id`, `category`, `items`, `price`, `quantity`, `sales_date`, `sales`, `total_amount`) VALUES
(23, 10, 'four square', 'original', '50', 20.00, '2025-02-21', '15', 1000.00),
(24, 10, 'four square', 'define slim', '100', 50.00, '2025-02-21', '45', 5000.00),
(25, 11, '10\'s', 'light', '25', 10.00, '2025-02-21', '10', 250.00),
(26, 11, '20\'s', 'advance', '35', 10.00, '2025-02-21', '10', 350.00),
(27, 11, 'four square', 'original', '50', 10.00, '2025-02-21', '10', 500.00),
(28, 11, '20\'s', 'advance', '35', 10.00, '2025-02-21', '10', 350.00);

-- --------------------------------------------------------

--
-- Table structure for table `sales_orders`
--

CREATE TABLE `sales_orders` (
  `id` int(100) NOT NULL,
  `bill_no` varchar(100) NOT NULL,
  `requested_name` varchar(100) NOT NULL,
  `category` varchar(150) NOT NULL,
  `items` varchar(120) NOT NULL,
  `price` varchar(130) NOT NULL,
  `quantity_stc` varchar(140) NOT NULL,
  `return_qty` varchar(150) NOT NULL,
  `sales` varchar(160) NOT NULL,
  `amount` varchar(120) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sales_orders`
--

INSERT INTO `sales_orders` (`id`, `bill_no`, `requested_name`, `category`, `items`, `price`, `quantity_stc`, `return_qty`, `sales`, `amount`, `created_at`) VALUES
(409, '2', 'akif', 'GPI', 'SHIF ME 97MM', '157', '10.00', '0', '10', '1570.00', '2025-03-20 07:00:39'),
(410, '2', 'akif', 'GPI', 'DEFINE ME 97MM', '157', '15.00', '5', '10', '1570.00', '2025-03-20 07:00:39'),
(411, '2', 'akif', 'GPI', 'DEFINE PAN ', '157', '10.00', '0', '10', '1570.00', '2025-03-20 07:00:39'),
(412, '2', 'akif', 'IPM', 'CLOVE MIX 10s', '153', '15.00', '5', '10', '1530.00', '2025-03-20 07:00:39'),
(413, '2', 'akif', 'IPM', 'FINE TOUCH 10s', '99', '25.00', '5', '20', '1980.00', '2025-03-20 07:00:39'),
(414, '2', 'akif', 'IPM', 'LIGHT 10s', '152', '13.00', '3', '10', '1520.00', '2025-03-20 07:00:39'),
(415, '2', 'akif', 'IPM', 'ADVANCE 20s', '152', '8.00', '0', '8', '1216.00', '2025-03-20 07:00:39'),
(416, '2', 'akif', 'CANDY', 'IMLI SMALL 525GM', '125', '9.00', '0', '9', '1125.00', '2025-03-20 07:00:39'),
(417, '2', 'akif', 'CANDY', 'TIC TAK JAR', '310', '17.00', '5', '12', '3720.00', '2025-03-20 07:00:39'),
(418, '2', 'akif', 'CANDY', 'TIC TAK HANGER', '138', '16.00', '6', '10', '1380.00', '2025-03-20 07:00:39'),
(419, '3', 'akif', 'IPM', 'ADVANCE 20s', '300', '10.00', '0', '10', '3000.00', '2025-03-21 06:42:14'),
(420, '3', 'akif', 'IPM', 'LIGHT 20s', '304', '20.00', '5', '15', '4560.00', '2025-03-21 06:42:14'),
(421, '3', 'akif', 'IPM', 'FUSE BOYEND 20s', '290', '10.00', '5', '5', '1450.00', '2025-03-21 06:42:14'),
(422, '3', 'akif', 'IPM', 'ADV COMPACT 10s', '73', '15.00', '3', '12', '876.00', '2025-03-21 06:42:14'),
(423, '3', 'akif', 'IPM', 'FUSE BOYEND 10s', '145', '14.00', '4', '10', '1450.00', '2025-03-21 06:42:14'),
(424, '3', 'akif', 'GPI', 'ORIGINAL 10s', '35', '16.00', '6', '10', '350.00', '2025-03-21 06:42:14'),
(425, '3', 'akif', 'GPI', 'DEFINE PAN ', '157', '18.00', '8', '10', '1570.00', '2025-03-21 06:42:14'),
(426, '3', 'akif', 'CANDY', 'IMLI SMALL 525GM', '125', '10.00', '2', '8', '1000.00', '2025-03-21 06:42:14');

-- --------------------------------------------------------

--
-- Table structure for table `voucher_details`
--

CREATE TABLE `voucher_details` (
  `id` int(100) NOT NULL,
  `bill_no` varchar(100) NOT NULL,
  `requested_name` varchar(100) NOT NULL,
  `sales_order_id` int(100) NOT NULL,
  `voucher_no` varchar(150) NOT NULL,
  `v_amt` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `voucher_details`
--

INSERT INTO `voucher_details` (`id`, `bill_no`, `requested_name`, `sales_order_id`, `voucher_no`, `v_amt`) VALUES
(99, '2', 'akif', 409, '123', '650'),
(100, '3', 'akif', 419, '111', '250');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `add_details`
--
ALTER TABLE `add_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `add_purchase`
--
ALTER TABLE `add_purchase`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bank_transactions`
--
ALTER TABLE `bank_transactions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cash_denominations`
--
ALTER TABLE `cash_denominations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `master_category`
--
ALTER TABLE `master_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `master_items`
--
ALTER TABLE `master_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_list`
--
ALTER TABLE `order_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payment_details`
--
ALTER TABLE `payment_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `registration`
--
ALTER TABLE `registration`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sales_details`
--
ALTER TABLE `sales_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sales_entry`
--
ALTER TABLE `sales_entry`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sales_orders`
--
ALTER TABLE `sales_orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `voucher_details`
--
ALTER TABLE `voucher_details`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `add_details`
--
ALTER TABLE `add_details`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=246;

--
-- AUTO_INCREMENT for table `add_purchase`
--
ALTER TABLE `add_purchase`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=140;

--
-- AUTO_INCREMENT for table `bank_transactions`
--
ALTER TABLE `bank_transactions`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=103;

--
-- AUTO_INCREMENT for table `cash_denominations`
--
ALTER TABLE `cash_denominations`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=201;

--
-- AUTO_INCREMENT for table `login`
--
ALTER TABLE `login`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `master_category`
--
ALTER TABLE `master_category`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `master_items`
--
ALTER TABLE `master_items`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `order_list`
--
ALTER TABLE `order_list`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=499;

--
-- AUTO_INCREMENT for table `payment_details`
--
ALTER TABLE `payment_details`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=108;

--
-- AUTO_INCREMENT for table `registration`
--
ALTER TABLE `registration`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `sales_details`
--
ALTER TABLE `sales_details`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `sales_entry`
--
ALTER TABLE `sales_entry`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `sales_orders`
--
ALTER TABLE `sales_orders`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=427;

--
-- AUTO_INCREMENT for table `voucher_details`
--
ALTER TABLE `voucher_details`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
