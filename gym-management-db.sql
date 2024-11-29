-- phpMyAdmin SQL Dump
-- version 5.2.2-dev+20240523.ca2d519f07
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Sep 22, 2024 at 01:37 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gym-management-db`
--

-- --------------------------------------------------------

--
-- Table structure for table `display_settings`
--

CREATE TABLE `display_settings` (
  `id` int(11) NOT NULL,
  `column_name` varchar(255) NOT NULL,
  `is_visible` enum('1','0') NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `display_settings`
--

INSERT INTO `display_settings` (`id`, `column_name`, `is_visible`) VALUES
(1, 'firstname', '1'),
(2, 'lastname', '1'),
(3, 'email', '0'),
(4, 'phone', '1'),
(5, 'address', '0'),
(6, 'status', '0'),
(7, 'amount', '1'),
(8, 'remainder', '1'),
(9, 'photo', '1'),
(10, 'payment_date', '1'),
(11, 'creation_date', '1'),
(12, 'inactivated_date', '1');

-- --------------------------------------------------------

--
-- Table structure for table `members`
--

CREATE TABLE `members` (
  `id` int(11) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `status` enum('active','inactive') NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `remainder` decimal(10,2) DEFAULT 0.00,
  `photo` varchar(255) DEFAULT NULL,
  `payment_date` date DEFAULT NULL,
  `creation_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `inactivated_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `members`
--

INSERT INTO `members` (`id`, `firstname`, `lastname`, `email`, `phone`, `address`, `status`, `amount`, `remainder`, `photo`, `payment_date`, `creation_date`, `inactivated_date`) VALUES
(10, 'John', 'Doe', 'john.doe@example.com', '123-456-7890', '123 Elm St', 'active', 100.00, 20.00, '', '2024-10-15', '2024-06-30 23:00:00', NULL),
(11, 'Jane', 'Smith', 'jane.smith@example.com', '987-654-3210', '456 Maple Ave', 'inactive', 80.00, 40.00, '', '2024-07-16', '2024-07-01 23:00:00', NULL),
(12, 'Alice', 'Brown', 'alice.brown@example.com', '555-123-4567', '789 Oak Dr', 'active', 120.00, 0.00, '', '2024-10-17', '2024-07-02 23:00:00', NULL),
(13, 'Bob', 'Johnson', 'bob.johnson@example.com', '444-987-6543', '321 Pine Ln', 'inactive', 110.00, 10.00, '', '2024-07-18', '2024-07-03 23:00:00', NULL),
(14, 'Charlie', 'Davis', 'charlie.davis@example.com', '333-654-3219', '654 Birch St', 'active', 90.00, 30.00, '', '2024-09-19', '2024-07-04 23:00:00', NULL),
(15, 'Diana', 'Clark', 'diana.clark@example.com', '222-765-4321', '987 Cedar Ave', 'inactive', 70.00, 50.00, '', '2024-07-20', '2024-07-05 23:00:00', NULL),
(16, 'Eve', 'Lewis', 'eve.lewis@example.com', '111-876-5432', '123 Walnut St', 'active', 115.00, 5.00, '', '2024-09-21', '2024-07-06 23:00:00', NULL),
(17, 'Frank', 'Hall', 'frank.hall@example.com', '999-345-6789', '456 Willow Rd', 'active', 95.00, 25.00, '', '2024-09-22', '2024-07-07 23:00:00', NULL),
(18, 'Grace', 'Walker', 'grace.walker@example.com', '888-234-5678', '789 Fir Ct', 'active', 85.00, 35.00, '', '2024-09-23', '2024-07-08 23:00:00', NULL),
(19, 'Hank', 'Young', 'hank.young@example.com', '777-123-4567', '321 Spruce Ln', 'active', 75.00, 45.00, '', '2024-09-24', '2024-07-09 23:00:00', NULL),
(20, 'Ivy', 'King', 'ivy.king@example.com', '666-987-6543', '654 Ash Dr', 'active', 65.00, 55.00, '', '2024-09-25', '2024-07-10 23:00:00', NULL),
(21, 'Jack', 'Green', 'jack.green@example.com', '555-876-5432', '987 Poplar St', 'active', 105.00, 15.00, '', '2024-09-26', '2024-07-11 23:00:00', NULL),
(23, 'Leo', 'Morris', 'leo.morris@example.com', '333-654-3219', '456 Beech Ln', 'active', 110.00, 10.00, '', '2024-09-28', '2024-07-13 23:00:00', NULL),
(24, 'Mia', 'Reed', 'mia.reed@example.com', '222-543-2109', '789 Sycamore Ct', 'active', 110.00, 10.00, '', '2024-09-29', '2024-07-14 23:00:00', NULL),
(25, 'Noah', 'Bailey', 'noah.bailey@example.com', '111-432-1098', '321 Pine Dr', 'inactive', 100.00, 20.00, '', '2024-09-30', '2024-07-15 23:00:00', '2024-09-18'),
(26, 'Olivia', 'Perry', 'olivia.perry@example.com', '999-321-0987', '654 Maple Blvd', 'active', 95.00, 25.00, '', '2024-07-31', '2024-07-16 23:00:00', NULL),
(32, 'Uma', 'Gray', 'uma.gray@example.com', '333-765-4321', '654 Pine Ct', 'inactive', 55.00, 65.00, '', '2024-08-06', '2024-07-22 23:00:00', '2024-09-18'),
(33, 'Vince', 'Adams', 'vince.adams@example.com', '222-654-3210', '987 Poplar Blvd', 'active', 100.00, 20.00, '', '2024-11-07', '2024-07-23 23:00:00', NULL),
(54, 'Abdo', 'Bourzikat', 'a.bourzikat@gmail.com', '0627685291', 'Ain cheggag', 'active', 120.00, 20.00, '/uploads/members-photos/IMG-20240921-WA0001.jpg', '2024-10-20', '2024-09-22 11:29:30', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `payments_trace`
--

CREATE TABLE `payments_trace` (
  `id` int(11) NOT NULL,
  `member_id` int(11) NOT NULL,
  `trace_amount` decimal(10,0) NOT NULL,
  `trace_remainder` decimal(10,0) NOT NULL DEFAULT 0,
  `payment_date_trace` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `payments_trace`
--

INSERT INTO `payments_trace` (`id`, `member_id`, `trace_amount`, `trace_remainder`, `payment_date_trace`) VALUES
(2, 10, 80, 40, '2024-07-01 21:52:03'),
(3, 10, 100, 20, '2024-06-01 21:52:03'),
(5, 10, 120, 0, '2024-08-28 22:41:34'),
(7, 24, 105, 15, '2024-08-29 14:52:28'),
(32, 33, 120, 0, '2024-09-18 09:21:22'),
(33, 33, 120, 0, '2024-10-18 09:21:26'),
(34, 10, 100, 20, '2024-09-18 10:40:46'),
(35, 12, 120, 0, '2024-09-18 10:40:49'),
(36, 33, 120, 0, '2024-09-18 13:08:06'),
(37, 33, 100, 20, '2024-09-18 13:08:41'),
(40, 54, 120, 20, '2024-09-22 11:29:30');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(11) NOT NULL,
  `gymname` varchar(100) NOT NULL,
  `logo` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `gymname`, `logo`) VALUES
(1, 'ALPHA-GYM', '/uploads/logo/gym-logo.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `_users_`
--

CREATE TABLE `_users_` (
  `id` int(11) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `prenom` varchar(100) NOT NULL,
  `login` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` int(11) NOT NULL,
  `photo` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `_users_`
--

INSERT INTO `_users_` (`id`, `nom`, `prenom`, `login`, `password`, `role`, `photo`) VALUES
(1, 'Admin', 'Super', 'a.admin@gmail.com', '$2y$10$Bavb6pwHnCoAoB07CC0vWeKWYh..Lsx3zFbQ5cVcZQrub7ARXrZ.O', 1, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `display_settings`
--
ALTER TABLE `display_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `members`
--
ALTER TABLE `members`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payments_trace`
--
ALTER TABLE `payments_trace`
  ADD PRIMARY KEY (`id`),
  ADD KEY `member_id` (`member_id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `_users_`
--
ALTER TABLE `_users_`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `display_settings`
--
ALTER TABLE `display_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `members`
--
ALTER TABLE `members`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT for table `payments_trace`
--
ALTER TABLE `payments_trace`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `_users_`
--
ALTER TABLE `_users_`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `payments_trace`
--
ALTER TABLE `payments_trace`
  ADD CONSTRAINT `member_id` FOREIGN KEY (`member_id`) REFERENCES `members` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
