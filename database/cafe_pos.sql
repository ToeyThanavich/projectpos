-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 26, 2026 at 02:41 PM
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
-- Database: `cafe_pos`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(100) NOT NULL,
  `sort_order` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`category_id`, `category_name`, `sort_order`) VALUES
(1, 'อาหาร', 1),
(2, 'เครื่องดื่ม', 2),
(3, 'ของหวาน', 3);

-- --------------------------------------------------------

--
-- Table structure for table `discounts`
--

CREATE TABLE `discounts` (
  `id` int(11) NOT NULL,
  `discount_name` varchar(100) NOT NULL,
  `discount_type` enum('percent','fixed') NOT NULL,
  `discount_value` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `members`
--

CREATE TABLE `members` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `menu_items`
--

CREATE TABLE `menu_items` (
  `item_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `item_name` varchar(150) NOT NULL,
  `size` varchar(50) DEFAULT '',
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `active` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `menu_items`
--

INSERT INTO `menu_items` (`item_id`, `category_id`, `item_name`, `size`, `description`, `price`, `image`, `active`) VALUES
(1, 1, 'ข้าวกะเพราไก่', 'ปกติ', 'กะเพราหอม เผ็ดกลาง', 55.00, NULL, 1),
(2, 1, 'ข้าวผัดกุ้ง', 'จาน', 'หอมกระทะ', 65.00, NULL, 1),
(3, 2, 'อเมริกาโน่เย็น', '16oz', 'ไม่หวาน', 45.00, NULL, 1),
(4, 2, 'ลาเต้ร้อน', '8oz', 'นมเนียน', 55.00, NULL, 1),
(5, 3, 'บราวนี่', 'ชิ้น', 'เข้มข้นช็อกโกแลต', 40.00, NULL, 1),
(6, 3, 'ไอศกรีมวานิลลา', 'สกู๊ป', 'หอมมัน', 35.00, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `order_code` varchar(16) NOT NULL,
  `table_id` int(11) NOT NULL,
  `status` enum('pending','cooking','serving','completed','cancelled') DEFAULT 'pending',
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `order_time` datetime DEFAULT current_timestamp(),
  `user_id` int(11) DEFAULT NULL,
  `member_id` int(11) DEFAULT NULL,
  `payment_method_id` int(11) DEFAULT NULL,
  `discount_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `order_code`, `table_id`, `status`, `created_at`, `updated_at`, `order_time`, `user_id`, `member_id`, `payment_method_id`, `discount_id`) VALUES
(39, 'ORD2025081708322', 1, 'cancelled', '2025-08-17 13:32:22', '2025-08-17 13:47:46', '2025-08-17 13:32:22', NULL, NULL, NULL, NULL),
(40, 'ORD2025081708370', 1, 'cancelled', '2025-08-17 13:37:05', '2025-08-17 13:47:45', '2025-08-17 13:37:05', NULL, NULL, NULL, NULL),
(41, 'ORD2025081708432', 1, 'cancelled', '2025-08-17 13:43:28', '2025-08-17 13:47:44', '2025-08-17 13:43:28', NULL, NULL, NULL, NULL),
(42, 'ORD2025081708475', 1, 'serving', '2025-08-17 13:47:57', '2025-08-17 14:00:52', '2025-08-17 13:47:57', NULL, NULL, NULL, NULL),
(43, 'ORD2025081709023', 2, 'pending', '2025-08-17 14:02:32', '2025-08-17 14:02:32', '2025-08-17 14:02:32', NULL, NULL, NULL, NULL),
(44, 'ORD2025081709040', 1, 'pending', '2025-08-17 14:04:03', '2025-08-17 14:04:03', '2025-08-17 14:04:03', NULL, NULL, NULL, NULL),
(45, 'ORD2025081713384', 1, 'pending', '2025-08-17 18:38:47', '2025-08-17 18:38:47', '2025-08-17 18:38:47', NULL, NULL, NULL, NULL),
(46, 'ORD2025081714131', 1, 'cooking', '2025-08-17 19:13:12', '2025-08-17 19:16:13', '2025-08-17 19:13:12', NULL, NULL, NULL, NULL),
(47, 'ORD2025081714441', 1, 'cooking', '2025-08-17 19:44:16', '2026-01-30 15:59:16', '2025-08-17 19:44:16', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `order_item_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `note` varchar(255) DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`order_item_id`, `order_id`, `item_id`, `quantity`, `price`, `note`) VALUES
(19, 39, 1, 1, 55.00, ''),
(20, 40, 2, 1, 65.00, ''),
(21, 41, 1, 1, 55.00, ''),
(22, 42, 1, 1, 55.00, ''),
(23, 43, 1, 1, 55.00, ''),
(24, 43, 2, 1, 65.00, ''),
(25, 44, 1, 1, 55.00, ''),
(26, 45, 1, 1, 55.00, 'เผ็ด'),
(27, 46, 2, 1, 65.00, 'ไม่ใส่ผัก'),
(28, 46, 3, 1, 45.00, 'ไม่หวาน  น้ำแข็งน้อย'),
(29, 46, 6, 1, 35.00, ''),
(30, 47, 4, 1, 55.00, '');

-- --------------------------------------------------------

--
-- Table structure for table `payment_methods`
--

CREATE TABLE `payment_methods` (
  `id` int(11) NOT NULL,
  `method_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tables`
--

CREATE TABLE `tables` (
  `table_id` int(11) NOT NULL,
  `table_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tables`
--

INSERT INTO `tables` (`table_id`, `table_name`) VALUES
(1, 'โต๊ะ 1'),
(2, 'โต๊ะ 2'),
(3, 'โต๊ะ 3');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','staff') DEFAULT 'staff'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `fullname`, `password`, `role`) VALUES
(1, 'admin', 'thitiwut', '1234', 'admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `discounts`
--
ALTER TABLE `discounts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `members`
--
ALTER TABLE `members`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `menu_items`
--
ALTER TABLE `menu_items`
  ADD PRIMARY KEY (`item_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD UNIQUE KEY `order_code` (`order_code`),
  ADD KEY `table_id` (`table_id`),
  ADD KEY `fk_orders_user` (`user_id`),
  ADD KEY `fk_orders_member` (`member_id`),
  ADD KEY `fk_orders_payment` (`payment_method_id`),
  ADD KEY `fk_orders_discount` (`discount_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`order_item_id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `item_id` (`item_id`);

--
-- Indexes for table `payment_methods`
--
ALTER TABLE `payment_methods`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tables`
--
ALTER TABLE `tables`
  ADD PRIMARY KEY (`table_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `discounts`
--
ALTER TABLE `discounts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `members`
--
ALTER TABLE `members`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `menu_items`
--
ALTER TABLE `menu_items`
  MODIFY `item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `order_item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `payment_methods`
--
ALTER TABLE `payment_methods`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tables`
--
ALTER TABLE `tables`
  MODIFY `table_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `menu_items`
--
ALTER TABLE `menu_items`
  ADD CONSTRAINT `menu_items_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`category_id`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `fk_orders_discount` FOREIGN KEY (`discount_id`) REFERENCES `discounts` (`id`),
  ADD CONSTRAINT `fk_orders_member` FOREIGN KEY (`member_id`) REFERENCES `members` (`id`),
  ADD CONSTRAINT `fk_orders_payment` FOREIGN KEY (`payment_method_id`) REFERENCES `payment_methods` (`id`),
  ADD CONSTRAINT `fk_orders_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`table_id`) REFERENCES `tables` (`table_id`);

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`),
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`item_id`) REFERENCES `menu_items` (`item_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
