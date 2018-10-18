-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Sep 24, 2018 at 01:32 PM
-- Server version: 5.7.23-0ubuntu0.16.04.1
-- PHP Version: 7.0.30-0ubuntu0.16.04.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `zomato`
--

-- --------------------------------------------------------

--
-- Table structure for table `cards`
--

CREATE TABLE `cards` (
  `id` int(11) NOT NULL,
  `card_number` varchar(100) NOT NULL,
  `is_used` int(5) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cards`
--

INSERT INTO `cards` (`id`, `card_number`, `is_used`) VALUES
(1, '1234', 1);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `thumbnail` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `thumbnail`) VALUES
(1, 'Bevarages', '/uploads/categories/u1533922247AadharID.png'),
(3, 'Clothes', '/uploads/categories/u1536400327pasted image 0.png'),
(4, 'Movie', '/uploads/categories/u1536400576trickle.png'),
(5, 'Footwear', '/uploads/categories/u1536400791trickle.png'),
(11, 'Shoes', '/uploads/categories/u1536476542trainers.png'),
(12, 'Food', '/uploads/categories/u1536476572pizza.png'),
(13, 'Clothinas', '/uploads/categories/u1536477389jumper.png');

-- --------------------------------------------------------

--
-- Table structure for table `coupons`
--

CREATE TABLE `coupons` (
  `id` bigint(20) NOT NULL,
  `offer_id` bigint(10) NOT NULL,
  `user_id` bigint(10) NOT NULL,
  `coupon_code` varchar(50) NOT NULL,
  `created_at` datetime NOT NULL,
  `used` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `coupons`
--

INSERT INTO `coupons` (`id`, `offer_id`, `user_id`, `coupon_code`, `created_at`, `used`) VALUES
(1, 1, 1, 'bGe6aS8X', '2018-09-08 22:25:54', 0),
(4, 2, 1, 'wPndQWNG', '2018-09-08 22:27:01', 0);

-- --------------------------------------------------------

--
-- Table structure for table `offers`
--

CREATE TABLE `offers` (
  `id` bigint(20) NOT NULL,
  `description` varchar(2000) NOT NULL,
  `creation_time` datetime NOT NULL,
  `title` varchar(500) NOT NULL,
  `store_id` bigint(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `offers`
--

INSERT INTO `offers` (`id`, `description`, `creation_time`, `title`, `store_id`) VALUES
(1, 'Buy one pizza and get another one for FREE', '2018-09-08 16:31:35', 'Free Pizza', 1),
(2, 'Buy one pizza and get another one for FREE', '2018-09-08 16:32:41', 'Free Pizza', 1);

-- --------------------------------------------------------

--
-- Table structure for table `retailers`
--

CREATE TABLE `retailers` (
  `store_id` bigint(10) NOT NULL,
  `username` varchar(500) NOT NULL,
  `password` varchar(100) NOT NULL,
  `access_token` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `retailers`
--

INSERT INTO `retailers` (`store_id`, `username`, `password`, `access_token`) VALUES
(1, 'dud', '12345678', 'XIMA13DyI0PnVp8sU1I9'),
(3, 'fasfas', 'asfafa', 'UZRIj58XgXVSJSMtUKOw'),
(4, 'hallauser', 'hallpass', 'QmY0Blqqx1GEYBItw8NT'),
(5, 'fsa', 'fsa', 'jI38DCeqMMzH0pPFnGaU');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` bigint(20) NOT NULL,
  `store_id` bigint(10) NOT NULL,
  `user_id` bigint(10) NOT NULL,
  `rating` int(3) NOT NULL,
  `review` varchar(1000) DEFAULT NULL,
  `review_time` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `stores`
--

CREATE TABLE `stores` (
  `id` bigint(20) NOT NULL,
  `name` varchar(200) NOT NULL,
  `photo` varchar(500) NOT NULL,
  `address` varchar(500) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `rating` float NOT NULL DEFAULT '0',
  `total_ratings` bigint(10) NOT NULL DEFAULT '0',
  `category` bigint(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `stores`
--

INSERT INTO `stores` (`id`, `name`, `photo`, `address`, `phone`, `rating`, `total_ratings`, `category`) VALUES
(1, 'Hash guys', '/uploads/stores/u1534424511download.jpg', 'Sector 32, Cahndigarh', '8968894728', 2.33333, 3, 1),
(2, 'Zara', '/uploads/stores/u1536409142Untitled.png', 'Elante, Cahndigarh', '8968894728', 0, 0, 2),
(3, 'fafada', '/uploads/stores/u1536413030trickle.png', 'fafaf', '7894291283', 0, 0, 2),
(4, 'halla', '/uploads/stores/u1536432211pasted image 0 (1).png', 'sector 33, Cahndigarh', '8872039507', 0, 0, 2),
(5, 'fsa', '/uploads/stores/u1536433819trickle.png', 'fsaf', '342', 0, 0, 3);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `phone` varchar(50) NOT NULL,
  `card` varchar(100) NOT NULL,
  `access_token` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `phone`, `card`, `access_token`) VALUES
(1, 'Anup Kumar Panwar', '+918968894728', '1234', 'aHYCGRS6Yrv6rXpRzwmK');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cards`
--
ALTER TABLE `cards`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `coupons`
--
ALTER TABLE `coupons`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `offer_id` (`offer_id`,`user_id`);

--
-- Indexes for table `offers`
--
ALTER TABLE `offers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stores`
--
ALTER TABLE `stores`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `access_token` (`access_token`),
  ADD UNIQUE KEY `phone` (`phone`),
  ADD UNIQUE KEY `card` (`card`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cards`
--
ALTER TABLE `cards`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `coupons`
--
ALTER TABLE `coupons`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `offers`
--
ALTER TABLE `offers`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `stores`
--
ALTER TABLE `stores`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
