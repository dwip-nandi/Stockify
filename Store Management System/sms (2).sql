-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Sep 03, 2025 at 09:45 AM
-- Server version: 8.0.36
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sms`
--

-- --------------------------------------------------------

--
-- Table structure for table `catagory_icatagory`
--

CREATE TABLE `catagory_icatagory` (
  `catagory_id` int NOT NULL,
  `catagory_name` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `catagory_entry_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `catagory_icatagory`
--

INSERT INTO `catagory_icatagory` (`catagory_id`, `catagory_name`, `catagory_entry_date`) VALUES
(1, 'catagory1', '2025-09-03'),
(2, 'Catagory5', '2025-09-03'),
(3, 'Category3', '2025-09-03'),
(4, 'Book', '2025-09-03'),
(5, 'Paper', '2025-09-03'),
(6, 'catagory4', '2025-09-03'),
(7, 'category6', '2025-09-03'),
(8, 'catagory2', '2025-09-03'),
(10, 'product1', '2025-02-17'),
(11, 'Samsung Phone', '2025-09-03'),
(15, 'MI Phone', '2025-09-03'),
(21, 'catagory20', '2025-09-02'),
(22, 'Catagory2', '2025-09-04'),
(23, 'catagory1', '2025-09-01'),
(24, 'Mobile Phone', '2025-09-03'),
(25, 'Watch', '2025-07-17'),
(26, 'ca1', '2025-05-21'),
(27, 'pencil', '2025-05-30'),
(28, 'Laptop', '2025-07-05');

-- --------------------------------------------------------

--
-- Table structure for table `feature_products`
--

CREATE TABLE `feature_products` (
  `id` int NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `description` varchar(10000) COLLATE utf8mb4_general_ci NOT NULL,
  `image` varchar(100) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `feature_products`
--

INSERT INTO `feature_products` (`id`, `name`, `description`, `image`) VALUES
(1, 'ABC', 'This product is very reasonable', 'user_vew/imgs/thumb-2.jpg'),
(2, 'NO Image', 'This product is very reasonable price. Bafhkcvh vdnkdn fdvnkd', 'user_vew/imgs/ewwead.jpg'),
(3, 'Product 1', 'This product is very reasonable price. Bafhkcvh vdnkdn fdvnkd. Liked very much.', 'user_vew/imgs/OIP.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `product_id` int NOT NULL,
  `product_name` varchar(30) COLLATE utf8mb4_general_ci NOT NULL,
  `product_catagory` int NOT NULL,
  `product_code` varchar(10) COLLATE utf8mb4_general_ci NOT NULL,
  `product_location` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `quantity` int DEFAULT NULL,
  `purchase_price` varchar(10) COLLATE utf8mb4_general_ci NOT NULL,
  `selling_price` varchar(10) COLLATE utf8mb4_general_ci NOT NULL,
  `product_entry_date` date NOT NULL,
  `product_production_date` date DEFAULT NULL,
  `product_date_over_date` date DEFAULT NULL,
  `product_image` varchar(255) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`product_id`, `product_name`, `product_catagory`, `product_code`, `product_location`, `quantity`, `purchase_price`, `selling_price`, `product_entry_date`, `product_production_date`, `product_date_over_date`, `product_image`) VALUES
(41, 'Product 6', 1, 'Pa101', 'LR1', 18, '705', '710', '2025-05-21', '2024-06-05', '2027-06-13', 'OIG4.jpg'),
(42, 'Product 6', 1, 'Pa102', 'LR1', 50, '705', '710', '2025-05-21', '2024-06-05', '2029-10-13', 'OIP.jpg'),
(44, 'Product 7', 8, 'Pa107', 'LR1', 83, '705', '710', '2025-05-21', '2024-06-05', '2025-05-13', 'default.png'),
(45, 'Product 6', 1, 'Pa101', 'LR1', 92, '705', '710', '2025-05-21', '2024-06-05', '2025-06-07', 'default.png'),
(46, 'Product 8', 7, 'Pa104', 'LR1', 9200, '705', '710', '2025-05-21', '2024-06-05', '2029-11-07', 'default.png'),
(48, 'Product 6', 1, 'Pa101', 'LR1', 983, '705', '710', '2025-05-21', '2024-06-05', '2025-06-07', 'default.png'),
(49, 'Product 9', 6, 'Pa105', 'LW1', 120, '7040', '710', '2025-05-21', '2024-06-05', '2027-11-07', ''),
(50, 'Product 6', 1, 'Pa101', 'LR1', 2, '705', '710', '2025-05-21', '2024-06-05', '2025-06-07', 'default.png'),
(51, 'Product 6', 1, 'Pa101', 'LR1', 77, '705', '710', '2025-05-21', '2024-06-05', '2025-06-07', 'default.png'),
(52, 'LightX', 8, 'Sh101', 'RL4', 100, '705', '750', '2025-09-03', '2024-07-04', '2027-12-07', 'Product+Showcase-1.jpg'),
(53, 'Book1', 4, 'Ba101', 'LE1', 300, '105', '120', '2025-05-21', '2024-06-05', '2038-06-07', 'book1.jpg'),
(54, 'Product 6', 1, 'Pa101', 'LR1', 92, '705', '710', '2025-05-21', '2024-06-05', '2025-06-07', ''),
(55, 'Product 6', 1, 'Pa101', 'LR1', 92, '705', '710', '2025-05-21', '2024-06-05', '2025-06-07', 'default.png'),
(56, 'Product 6', 1, 'Pa101', 'LR1', 406, '705', '710', '2025-05-21', '2024-06-05', '2025-06-07', 'ewwead.jpg'),
(57, 'Product 6', 1, 'Pa101', 'LR1', 107, '705', '710', '2025-05-21', '2024-06-05', '2025-06-07', 'OIP.jpg'),
(58, 'Product 6', 1, 'Pa101', 'LR1', 7, '705', '710', '2025-05-21', '2024-06-05', '2025-06-07', 'default.png'),
(59, 'Product 6', 1, 'Pa101', 'LR1', 16, '705', '710', '2025-05-21', '2024-06-05', '2025-06-07', 'OIG4.jpg'),
(61, 'sarer', 3, 'Pa101', 'LR1', 38, '705', '710', '2025-05-21', '2024-06-05', '2028-02-23', 'logo1.jpg'),
(62, 'Book1', 1, 'Pa101', 'LR1', 143, '705', '710', '2025-05-21', '2024-06-05', '2028-02-23', 'Screenshot 2025-05-13 012605.png'),
(63, 'Pen1', 1, 'Pa101', 'LR1', 17, '705', '710', '2025-05-21', '2024-06-05', '2028-02-23', '2074208244715c6b0ec985336a2b00af.jpg'),
(64, 'Pencil 4B', 27, 'pa 2', '1LR', 10012, '4', '5', '2025-05-30', '2023-07-19', '2027-10-30', 'Copilot_20250530_124506.png'),
(66, 'Pencil 2B', 1, 'pa303', '1LR', 1005, '3', '4', '2025-05-30', '2023-07-19', '2027-10-30', '2074208244715c6b0ec985336a2b00af.jpg'),
(67, 'Apple', 4, 'pa 1', '1LR', 1005, '3', '4', '2025-06-18', '2023-07-19', '2027-10-30', 'Screenshot 2025-05-27 091622.png'),
(68, 'Mango', 10, 'MA 1', '1DR', 1010, '30', '40', '2025-06-18', '2023-07-19', '2027-10-30', 'Screenshot 2025-05-27 090735.png'),
(69, 'Lenovo', 28, 'lenovo123', 'R33', 160, '72000', '78000', '2025-07-04', '2023-06-05', '2027-10-12', 'OIP.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `profit`
--

CREATE TABLE `profit` (
  `id` int NOT NULL,
  `product_id` int NOT NULL,
  `product_code` varchar(250) COLLATE utf8mb4_general_ci NOT NULL,
  `quantity` int NOT NULL,
  `profit_item` int NOT NULL,
  `sell_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `profit`
--

INSERT INTO `profit` (`id`, `product_id`, `product_code`, `quantity`, `profit_item`, `sell_date`) VALUES
(7, 36, '', 5, 25, '2025-05-24'),
(8, 36, '', 3, 15, '2025-05-24'),
(9, 37, '', 3, 15, '2025-05-24'),
(10, 36, '', 2, 10, '2025-05-24'),
(11, 38, '', 100, 500, '2025-05-24'),
(12, 38, '', 20, 100, '2025-05-24'),
(13, 35, '', 20, 100, '2025-05-28'),
(14, 51, '', 6, 30, '2025-05-28'),
(15, 61, '', 45, 225, '2025-05-28'),
(16, 56, '', 45, 225, '2025-05-28'),
(17, 35, '', 20, 100, '2025-05-28'),
(18, 41, '', 5, 25, '2025-05-30'),
(19, 42, '', 5, 25, '2025-05-30'),
(20, 39, '', 50, 250, '2025-05-30'),
(21, 35, '', 20, 100, '2025-06-18'),
(22, 38, '', 20, 100, '2025-06-18'),
(23, 40, '', 10, 50, '2025-06-18'),
(24, 42, '', 10, 50, '2025-06-18'),
(25, 63, '', 100, 500, '2025-06-18'),
(26, 35, '', 10, 50, '2025-06-18'),
(27, 35, '', 11, 55, '2025-06-18'),
(28, 35, 'Pa101', 1, 5, '2025-06-24'),
(29, 35, 'Pa101', 1, 5, '2025-06-24'),
(30, 35, 'Pa101', 12, 60, '2025-06-24'),
(31, 36, 'Pa101', 12, 60, '2025-06-24'),
(32, 37, 'Pa101', 15, 75, '2025-06-24'),
(33, 35, 'Pa101', 1, 5, '2025-06-24'),
(34, 35, 'Pa101', 1, 5, '2025-06-24'),
(35, 35, 'Pa101', 1, 5, '2025-06-24'),
(36, 35, 'Pa101', 1, 5, '2025-06-24'),
(37, 35, 'Pa101', 1, 5, '2025-06-24'),
(38, 37, 'Pa101', 10, 50, '2025-06-24'),
(39, 35, 'Pa101', 1, 5, '2025-06-24'),
(40, 35, 'Pa101', 1, 5, '2025-06-25'),
(41, 35, 'Pa101', 1, 5, '2025-06-25'),
(42, 35, 'Pa101', 1, 5, '2025-06-25'),
(43, 35, 'Pa101', 1, 5, '2025-06-25'),
(44, 35, 'Pa101', 1, 5, '2025-06-25'),
(45, 35, 'Pa101', 1, 5, '2025-06-25'),
(46, 35, 'Pa101', 1, 5, '2025-06-25'),
(47, 35, 'Pa101', 1, 5, '2025-06-25'),
(48, 35, 'Pa101', 1, 5, '2025-06-25'),
(49, 35, 'Pa101', 1, 5, '2025-06-25'),
(50, 35, 'Pa101', 1, 5, '2025-06-25'),
(51, 35, 'Pa101', 1, 5, '2025-06-25'),
(52, 35, 'Pa101', 1, 5, '2025-06-25'),
(53, 35, 'Pa101', 1, 5, '2025-06-25'),
(54, 35, 'Pa101', 1, 5, '2025-06-25'),
(55, 35, 'Pa101', 1, 5, '2025-06-25'),
(56, 35, 'Pa101', 23, 115, '2025-06-25'),
(57, 35, 'Pa101', 12, 60, '2025-06-25'),
(58, 35, 'Pa101', 1, 5, '2025-07-02'),
(59, 38, 'Pa101', 233, 1165, '2025-09-03'),
(60, 42, 'Pa102', 18, 90, '2025-09-03');

-- --------------------------------------------------------

--
-- Table structure for table `report`
--

CREATE TABLE `report` (
  `id` int NOT NULL,
  `product_id` int NOT NULL,
  `adding_product` int NOT NULL,
  `product_type` int NOT NULL,
  `adding_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `report`
--

INSERT INTO `report` (`id`, `product_id`, `adding_product`, `product_type`, `adding_date`) VALUES
(1, 35, 20, 2, '2025-05-30'),
(2, 35, 20, 2, '2025-05-30'),
(3, 39, 10, 2, '2025-06-18'),
(4, 42, 100, 2, '2025-06-18'),
(5, 44, 100, 2, '2025-06-18'),
(6, 62, 10, 2, '2025-06-18'),
(7, 63, 100, 2, '2025-06-18'),
(8, 63, 34, 2, '2025-06-18'),
(9, 64, 12, 2, '2025-06-18'),
(10, 48, 1000, 2, '2025-06-18'),
(11, 51, 100, 2, '2025-06-18'),
(12, 53, 20, 2, '2025-06-18'),
(13, 35, 100, 2, '2025-06-18'),
(14, 37, 100, 2, '2025-06-24'),
(15, 41, 40, 2, '2025-06-25'),
(16, 43, 5, 2, '2025-06-25'),
(17, 43, 5, 2, '2025-06-25'),
(18, 45, 100, 2, '2025-06-27'),
(19, 46, 100, 2, '2025-07-02'),
(20, 47, 100, 2, '2025-07-02'),
(21, 49, 10, 2, '2025-07-02'),
(22, 49, 10, 2, '2025-07-02'),
(23, 50, 10, 2, '2025-07-02'),
(24, 52, 100, 2, '2025-07-02'),
(25, 54, 100, 2, '2025-07-02'),
(26, 55, 100, 2, '2025-07-02'),
(27, 58, 3, 2, '2025-07-02'),
(28, 58, 12, 2, '2025-07-02'),
(29, 59, 12, 2, '2025-07-02'),
(30, 59, 12, 2, '2025-07-02'),
(31, 60, 12, 2, '2025-07-02'),
(32, 60, 12, 2, '2025-07-02'),
(33, 37, 100, 2, '2025-09-03');

-- --------------------------------------------------------

--
-- Table structure for table `sales_events_calander`
--

CREATE TABLE `sales_events_calander` (
  `event_id` int NOT NULL,
  `event_name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `description` text COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sales_events_calander`
--

INSERT INTO `sales_events_calander` (`event_id`, `event_name`, `start_date`, `end_date`, `description`) VALUES
(1, 'Fa', '2025-04-27', '2025-04-28', 'YUtuertuyewrtrt'),
(2, 'Fa', '2025-04-27', '2025-04-28', 'YUtuertuyewrtrt'),
(3, 'Fa', '2025-04-27', '2025-04-30', 'grfjdgfjg'),
(4, 'Fa', '2025-04-25', '2025-04-29', ''),
(5, 'Fa', '2025-04-30', '2025-05-01', ''),
(6, 'Fa', '2025-04-26', '2025-05-01', ''),
(7, 'XYZ', '2025-04-25', '2025-05-09', 'Ttywgeyfgruerg'),
(8, 'Phohela Boishak', '2025-04-21', '2025-05-07', 'You can buy product 50% less, at this time..'),
(9, 'Puja 25', '2025-06-28', '2025-07-09', 'Shirt, Panjabi'),
(10, 'ABC', '2025-07-16', '2025-07-19', 'Shari, Longi, Apax brand Shose'),
(11, 'eid25', '2025-07-15', '2025-07-18', 'lungi25%,underwere25%'),
(12, 'Puja 25', '2025-09-24', '2025-09-30', 'Puja 2025'),
(14, 'abcd', '2025-10-16', '2025-10-23', 'fytrytfryutrytrytugytgytfyvyytfvyfvytfvyff');

-- --------------------------------------------------------

--
-- Table structure for table `spand_product`
--

CREATE TABLE `spand_product` (
  `spand_product_id` int NOT NULL,
  `spand_product_name` varchar(30) COLLATE utf8mb4_general_ci NOT NULL,
  `spand_product_quantity` int NOT NULL,
  `spand_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `spand_product`
--

INSERT INTO `spand_product` (`spand_product_id`, `spand_product_name`, `spand_product_quantity`, `spand_date`) VALUES
(1, '3', 22, '2024-07-09'),
(2, '3', 22, '2024-07-09'),
(3, '7', 20, '2024-07-09'),
(4, '7', 20, '2024-07-09'),
(5, '7', 20, '2024-07-09'),
(6, '7', 20, '2024-07-09'),
(7, '7', 5, '2024-07-10'),
(8, '7', 20, '2024-07-09'),
(9, '7', 20, '2024-07-09'),
(10, '7', 20, '2024-07-09'),
(11, '7', 20, '2024-07-09'),
(12, '5', 23, '2024-07-10');

-- --------------------------------------------------------

--
-- Table structure for table `stor_product`
--

CREATE TABLE `stor_product` (
  `stor_product_id` int NOT NULL,
  `stor_product_name` int NOT NULL,
  `stor_product_quantity` int NOT NULL,
  `stor_product_entry_date` varchar(10) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `stor_product`
--

INSERT INTO `stor_product` (`stor_product_id`, `stor_product_name`, `stor_product_quantity`, `stor_product_entry_date`) VALUES
(1, 2, 1000, '2024-07-08'),
(2, 7, 1005, '2024-07-08'),
(3, 3, 34, '2024-07-08'),
(4, 6, 3457, '2024-07-17'),
(5, 7, 60, '2024-07-08'),
(6, 5, 100, '2024-07-10');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int NOT NULL,
  `user_first_name` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `user_last_name` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `user_email` varchar(30) COLLATE utf8mb4_general_ci NOT NULL,
  `user_password` varchar(20) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `user_first_name`, `user_last_name`, `user_email`, `user_password`) VALUES
(3, 'Nazmul', 'Kumar Sharkar', 'Nazmulkumar@23gmail.com', '1234'),
(5, 'Usuf', 'Rabbi', 'usuf@gmail.com', '1234'),
(6, 'fuad ', 'hasan', 'a@gmail.com', '1111'),
(7, 'Dwip', 'Nandi', 'dwpnandi1234@gmail.com', '12345'),
(8, 'fuad', 'hasan', 'fuad@gmail.com', '1111');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `catagory_icatagory`
--
ALTER TABLE `catagory_icatagory`
  ADD PRIMARY KEY (`catagory_id`);

--
-- Indexes for table `feature_products`
--
ALTER TABLE `feature_products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `profit`
--
ALTER TABLE `profit`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `report`
--
ALTER TABLE `report`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sales_events_calander`
--
ALTER TABLE `sales_events_calander`
  ADD PRIMARY KEY (`event_id`);

--
-- Indexes for table `spand_product`
--
ALTER TABLE `spand_product`
  ADD PRIMARY KEY (`spand_product_id`);

--
-- Indexes for table `stor_product`
--
ALTER TABLE `stor_product`
  ADD PRIMARY KEY (`stor_product_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `catagory_icatagory`
--
ALTER TABLE `catagory_icatagory`
  MODIFY `catagory_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `feature_products`
--
ALTER TABLE `feature_products`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `product_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

--
-- AUTO_INCREMENT for table `profit`
--
ALTER TABLE `profit`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT for table `report`
--
ALTER TABLE `report`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `sales_events_calander`
--
ALTER TABLE `sales_events_calander`
  MODIFY `event_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `spand_product`
--
ALTER TABLE `spand_product`
  MODIFY `spand_product_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `stor_product`
--
ALTER TABLE `stor_product`
  MODIFY `stor_product_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
