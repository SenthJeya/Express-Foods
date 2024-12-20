-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 19, 2024 at 03:47 PM
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
-- Database: `resturent`
--

-- --------------------------------------------------------

--
-- Table structure for table `food`
--

CREATE TABLE `food` (
  `id` int(100) NOT NULL,
  `name` varchar(250) DEFAULT NULL,
  `price` double(6,2) DEFAULT NULL,
  `path` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `food`
--

INSERT INTO `food` (`id`, `name`, `price`, `path`) VALUES
(1, 'Chicken Burger', 1500.00, 'Chicken Burger.jpeg'),
(2, 'Zing Burger', 1400.00, 'Zing Burger.jpg'),
(7, 'BBQ Chicken Pizza', 2000.00, 'BBQ Chicken Pizza.jpg'),
(8, 'French Fries', 800.00, 'French Fries.jpeg'),
(9, 'Spicy Chicken Submarine', 1800.00, 'Spicy Chicken Submarine.jpeg');

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` int(11) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `mobile_number` varchar(15) NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `payment_reference` varchar(6) NOT NULL,
  `payment_date` date NOT NULL,
  `payment_time` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `user_name`, `user_email`, `mobile_number`, `total_amount`, `payment_reference`, `payment_date`, `payment_time`) VALUES
(1, 'user', 'user@gmail.com', '0766755700', 1400.00, '669101', '2024-09-18', '08:25:16'),
(2, 'user', 'user@gmail.com', '0766755700', 2900.00, '246829', '2024-09-18', '08:50:20'),
(3, 'user1', 'user1@gmail.com', '0777777777', 1400.00, '201559', '2024-09-18', '08:54:04'),
(4, 'user1', 'billadmin@gmail.com', '0777777777', 1500.00, '379357', '2024-09-18', '08:57:59'),
(5, 'user1', 'user@gmail.com', '0777777777', 1400.00, '236589', '2024-09-18', '15:18:31'),
(6, 'user1', 'user@gmail.com', '0777777777', 2800.00, '768413', '2024-09-18', '15:20:30');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `name` varchar(250) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) DEFAULT NULL,
  `mobile` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`name`, `email`, `password`, `mobile`) VALUES
('admin', 'admin@gmail.com', '$2y$10$3oA3X6AQSeU3x.P3g3UqIu5nF0mR1C.eDcJt/TTAVZawVbW./rVNu', 766755700),
('Bill Admin', 'billadmin@gmail.com', '$2y$10$QT5PmJZXBuQYbPtxbcCXh.qEn6qiysJnze.4YfDfOfNcYVAbQKUUG', 766755711),
('User1', 'user1@gmail.com', '$2y$10$5ETcojB/apHYradshrlLDuEHGaY78dTQaC6mMshDtpxlRNo.zgaTy', 777777777),
('user', 'user@gmail.com', '$2y$10$xYA8qdP9Ir/eY7F4iiGrQOTMUTOmP0bDLLI.6z4syvB676YOcE7Py', 774961555);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `food`
--
ALTER TABLE `food`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `food`
--
ALTER TABLE `food`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
