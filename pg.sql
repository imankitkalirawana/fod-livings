-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 16, 2023 at 12:49 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pg`
--

-- --------------------------------------------------------

--
-- Table structure for table `images`
--

CREATE TABLE `images` (
  `image_id` int(11) NOT NULL,
  `image_name` varchar(255) DEFAULT NULL,
  `image_p_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `images`
--

INSERT INTO `images` (`image_id`, `image_name`, `image_p_id`) VALUES
(1, 'img1.jpg', 1),
(2, 'img2.jpg', 1),
(3, 'img3.jpg', 1),
(4, 'img1.jpg', 2),
(5, 'img2.jpg', 2),
(6, 'img3.jpg', 2);

-- --------------------------------------------------------

--
-- Table structure for table `pg_category`
--

CREATE TABLE `pg_category` (
  `cat_id` int(11) NOT NULL,
  `cat_name` varchar(255) DEFAULT NULL,
  `cat_image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pg_category`
--

INSERT INTO `pg_category` (`cat_id`, `cat_name`, `cat_image`) VALUES
(1, 'Luxury', 'img1.jpg'),
(2, 'Budget', 'img2.jpg'),
(3, 'Apartments', 'img3.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `p_id` int(11) NOT NULL,
  `p_name` varchar(255) NOT NULL,
  `original_price` int(11) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `description` text NOT NULL,
  `status` int(11) DEFAULT NULL,
  `ac` int(11) DEFAULT NULL,
  `size` varchar(255) DEFAULT NULL,
  `time` date DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `cat_id` int(11) DEFAULT NULL,
  `featured` int(11) DEFAULT NULL,
  `discount_price` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`p_id`, `p_name`, `original_price`, `location`, `description`, `status`, `ac`, `size`, `time`, `image`, `cat_id`, `featured`, `discount_price`) VALUES
(1, 'Red Apple Tower', 13000, 'Law Gate', '<h1>Fully Furnished</h1>', 1, 1, '1BHK', '2023-05-10', 'img1.jpg', 2, 1, 11000),
(2, 'Shree Krishna', 11000, 'Law Gate', 'Fully Furnished', 1, 0, '2 BHK', '2023-05-12', 'img1.jpg', 2, 0, 9000),
(3, 'Red Apple Tower', 14000, 'Law Gate', '<i>Fully Furnished</i>', 1, 1, '1bhk', '2023-06-11', 'img1.jpg', 1, 1, 11000);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `first_name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `usertype` varchar(11) DEFAULT 'user',
  `last_name` varchar(255) DEFAULT NULL,
  `mobile_number` varchar(21) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `created_at`, `first_name`, `email`, `image`, `usertype`, `last_name`, `mobile_number`, `address`) VALUES
(9, 'imankitkalirawana', '$2y$10$z4FutSqACLUbZCUL3ek4BODzoW0sPGeqsztB21jc0bFnHHPotFo6O', '2023-05-13 16:10:13', 'Ankit', 'imankitkalirawana@gmail.com', '/img/users/PhotoStudio_1666928048069.jpeg', 'admin', 'Kalirawana', '9992682837', 'Jhajjar, Haryana');

-- --------------------------------------------------------

--
-- Table structure for table `website`
--

CREATE TABLE `website` (
  `id` int(11) NOT NULL,
  `w_name` varchar(255) DEFAULT NULL,
  `short_description` text DEFAULT NULL,
  `detailed_description` text DEFAULT NULL,
  `w_phone` varchar(255) DEFAULT NULL,
  `w_mail` varchar(255) DEFAULT NULL,
  `w_tagline` varchar(255) DEFAULT NULL,
  `w_address` varchar(255) DEFAULT NULL,
  `w_location` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `website`
--

INSERT INTO `website` (`id`, `w_name`, `short_description`, `detailed_description`, `w_phone`, `w_mail`, `w_tagline`, `w_address`, `w_location`) VALUES
(1, 'FOD Livings', 'Affordable rooms', 'Affordable rooms at low price', '987654321', 'fodlivings@gmail.com', 'Flats on Demand', 'Phagwara', 'Law Gate');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`image_id`),
  ADD KEY `image_p_id` (`image_p_id`);

--
-- Indexes for table `pg_category`
--
ALTER TABLE `pg_category`
  ADD PRIMARY KEY (`cat_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`p_id`),
  ADD KEY `cat_id` (`cat_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `website`
--
ALTER TABLE `website`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `images`
--
ALTER TABLE `images`
  MODIFY `image_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `pg_category`
--
ALTER TABLE `pg_category`
  MODIFY `cat_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `p_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `website`
--
ALTER TABLE `website`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `images`
--
ALTER TABLE `images`
  ADD CONSTRAINT `images_ibfk_1` FOREIGN KEY (`image_p_id`) REFERENCES `products` (`p_id`);

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`cat_id`) REFERENCES `pg_category` (`cat_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
