-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 15, 2024 at 01:25 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `urban-outfitters`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `admin_id` int(5) NOT NULL,
  `admin_name` varchar(10) NOT NULL,
  `password` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_id`, `admin_name`, `password`) VALUES
(1, 'jay', 'jay@123');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int(4) NOT NULL,
  `sub_category_id` int(5) NOT NULL,
  `product_name` varchar(30) NOT NULL,
  `product_price` int(6) NOT NULL,
  `product_quantity` int(3) NOT NULL,
  `product_description` varchar(255) NOT NULL,
  `product_image` varchar(255) NOT NULL,
  `added_date` date NOT NULL,
  `product_sizes` text DEFAULT NULL,
  `is_deleted` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `sub_category_id`, `product_name`, `product_price`, `product_quantity`, `product_description`, `product_image`, `added_date`, `product_sizes`, `is_deleted`) VALUES
(1, 3, 'funki jeans', 900, 5, 'this is test 1', '1726377124-jeans-category.jpg', '2024-09-15', '[\"S\",\"L\"]', 1),
(2, 3, 'funki jeans', 500, 5, 'this is test 2', '1726377604-jeans-category.jpg', '2024-09-15', '[\"S\",\"L\"]', 1),
(3, 3, 'jeans', 600, 5, 'this is new test', '1726378152-jeans-category.jpg', '2024-09-15', '[\"S\",\"L\"]', 1),
(4, 3, 'jeans', 500, 5, 'this is test', '1726378428-jeans-category.jpg', '2024-09-15', 'S', 0),
(5, 4, 'shirt', 900, 5, 'this is shirt', '1726396777-shirts-category.jpg', '2024-09-15', '[\"S\",\"M\",\"L\"]', 0),
(6, 6, 'T-Shit', 600, 5, 'this is called t-shirt', '1726396974-tshirts-category.jpg', '2024-09-15', '[\"M\",\"L\"]', 0),
(7, 4, 'Chinese Collar Shirt', 1299, 5, 'this is Chinese Collar', '1726398464-n1.jpg', '2024-09-15', '[\"M\",\"L\"]', 0),
(8, 6, 'black t shirt', 500, 1, 'this is black color t shirt', '1726399321-n8.jpg', '2024-09-15', '[\"S\"]', 0),
(9, 6, 'Hawaiian t shirt', 899, 5, 'this is hawaiian t shirt', '1726399376-f1.jpg', '2024-09-15', '[\"S\",\"M\"]', 0),
(10, 3, 'cotton short', 700, 5, 'this is cotton short', '1726399456-n7.jpg', '2024-09-15', '[\"S\",\"M\"]', 0);

-- --------------------------------------------------------

--
-- Table structure for table `product_category`
--

CREATE TABLE `product_category` (
  `category_id` int(5) NOT NULL,
  `category` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_category`
--

INSERT INTO `product_category` (`category_id`, `category`) VALUES
(1, 'upperware'),
(2, 'bottomware');

-- --------------------------------------------------------

--
-- Table structure for table `product_sub_category`
--

CREATE TABLE `product_sub_category` (
  `sub_category_id` int(5) NOT NULL,
  `category_id` int(5) NOT NULL,
  `sub_category_name` varchar(50) NOT NULL,
  `sub_category_image` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `is_deleted` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_sub_category`
--

INSERT INTO `product_sub_category` (`sub_category_id`, `category_id`, `sub_category_name`, `sub_category_image`, `date`, `is_deleted`) VALUES
(3, 2, 'jeans', '1726376373-jeans-category.jpg', '2024-09-15', 0),
(4, 1, 'shirts', '1726376385-shirts-category.jpg', '2024-09-15', 0),
(5, 1, 'tshirts', '1726376398-tshirts-category.jpg', '2024-09-15', 1),
(6, 1, 'T-Shirt', '1726396942-tshirts-category.jpg', '2024-09-15', 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `uid` int(5) NOT NULL,
  `user_first_name` varchar(20) NOT NULL,
  `user_last_name` varchar(20) NOT NULL,
  `email` varchar(30) NOT NULL,
  `contact_number` int(10) NOT NULL,
  `password` varchar(70) NOT NULL,
  `token` varchar(255) NOT NULL,
  `token_expire` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`uid`, `user_first_name`, `user_last_name`, `email`, `contact_number`, `password`, `token`, `token_expire`) VALUES
(1, 'jay', 'bhardiya', 'jaypatel161200@gmail.com', 1234567890, '$2y$10$l2I6Fjq8t9nFd7fjyjbp3ev739ln9sdt62xDothI3R2JZWZRU78X.', '', '0000-00-00'),
(2, 'sahil', 'hadiya', 'sahilahir2406@gmail.com', 1234567890, '$2y$10$a7HFE3KueDiIlDECy8xmKeqofy9/KRBrR.cmPKrNBkrUou3TkYkg6', '', '0000-00-00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `sub_category_id_fk` (`sub_category_id`);

--
-- Indexes for table `product_category`
--
ALTER TABLE `product_category`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `product_sub_category`
--
ALTER TABLE `product_sub_category`
  ADD PRIMARY KEY (`sub_category_id`),
  ADD KEY `category_fk` (`category_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`uid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `admin_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `product_category`
--
ALTER TABLE `product_category`
  MODIFY `category_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `product_sub_category`
--
ALTER TABLE `product_sub_category`
  MODIFY `sub_category_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `uid` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `sub_category_id_fk` FOREIGN KEY (`sub_category_id`) REFERENCES `product_sub_category` (`sub_category_id`);

--
-- Constraints for table `product_sub_category`
--
ALTER TABLE `product_sub_category`
  ADD CONSTRAINT `category_fk` FOREIGN KEY (`category_id`) REFERENCES `product_category` (`category_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
