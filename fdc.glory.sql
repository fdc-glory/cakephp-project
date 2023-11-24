-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Nov 23, 2023 at 06:55 AM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cakephp_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `chats`
--

CREATE TABLE `chats` (
  `chat_id` int(11) NOT NULL,
  `sender_id` int(11) NOT NULL,
  `receive_id` int(11) NOT NULL,
  `last_message_sent` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


-- --------------------------------------------------------

--
-- Table structure for table `chat_history`
--

CREATE TABLE `chat_history` (
  `ch_id` int(11) NOT NULL,
  `chat_id` int(11) NOT NULL,
  `msg_content` varchar(1000) NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `chat_history`
--


-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `user_name` varchar(20) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `date_joined` datetime NOT NULL,
  `last_login_time` datetime NOT NULL,
  `birthdate` date DEFAULT NULL,
  `gender` varchar(20) DEFAULT NULL,
  `profile_img` varchar(255) DEFAULT NULL,
  `hubby` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;



--
-- Indexes for table `chats`
--
ALTER TABLE `chats`
  ADD PRIMARY KEY (`chat_id`);

--
-- Indexes for table `chat_history`
--
ALTER TABLE `chat_history`
  ADD PRIMARY KEY (`ch_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `chats`
--
ALTER TABLE `chats`
  MODIFY `chat_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `chat_history`
--
ALTER TABLE `chat_history`
  MODIFY `ch_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
