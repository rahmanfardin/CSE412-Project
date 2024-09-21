-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 10, 2024 at 02:55 PM
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
-- Database: `ticketing`
--

-- --------------------------------------------------------

--
-- Table structure for table `halltable`
--

CREATE TABLE `halltable` (
  `hallId` int(11) NOT NULL,
  `hallname` varchar(100) NOT NULL,
  `location` varchar(1000) NOT NULL,
  `rating` int(11) NOT NULL,
  `type` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `moviehall`
--

CREATE TABLE `moviehall` (
  `movieid` int(11) NOT NULL,
  `hallid` int(11) NOT NULL,
  `slotid` int(11) NOT NULL,
  `slot` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `movietable`
--

CREATE TABLE `movietable` (
  `movieid` int(11) NOT NULL,
  `moviename` varchar(100) NOT NULL,
  `releasedate` varchar(4) NOT NULL,
  `genre` varchar(100) NOT NULL,
  `rating` int(11) NOT NULL,
  `poster` varchar(2000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ticket`
--

CREATE TABLE `ticket` (
  `ticketid` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `movieid` int(11) NOT NULL,
  `hallid` int(11) NOT NULL,
  `slotid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `usertable`
--

CREATE TABLE `usertable` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(70) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(256) NOT NULL,
  `userType` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `usertable`
--

INSERT INTO `usertable` (`id`, `name`, `email`, `username`, `password`, `userType`) VALUES
(5, 'Fardin Rahman', 'mfardinr@gmail.com', 'neutronslayer', '464f46564cdd937ff3e3e64f605fa70ac3b822e952a55a924adee933271f32d0', 'admin'),
(13, 'admin1', 'admin1@gmail.com', 'admin1', '25f43b1486ad95a1398e3eeb3d83bc4010015fcc9bedb35b432e00298d5021f7', 'admin'),
(18, 'auth1', 'auth1@gmail.com', 'auth1', '31a433abae24092df8636e752d03f0dc1d08b5e292549b68eb5f64755f38903c', 'auth'),
(19, 'user1', 'user1@gmail.com', 'user1', '0a041b9462caa4a31bac3567e0b6e6fd9100787db2ab433d96f6d178cabfce90', 'user'),
(20, 'approver1', 'approver1@gmail.com', 'approver1', 'e973de4808e055b3238a774fbfba4bea8f563b24ff0d60fdb84023588251786f', 'app'),
(21, 'user2', 'user2@gmail.com', 'user2', '6025d18fe48abd45168528f18a82e265dd98d421a7084aa09f61b341703901a3', 'user'),
(22, 'NTN', 'NTN@gmail.com', 'ntn', '86475f5e72acb469f359fa04817d701b5eb7eb380f1ddb635292b7454cb10ce7', 'user'),
(23, 'Redita Sultana', 'redita1409@gmail.com', 'reemu', 'a3ad2fc989d361b3692d13c2e25d2db6aa057fe44cbe100ad3561f8534ed3cbf', 'user'),
(24, 'Fardin Rahman', 'mohammadfardinrahman@gmail.com', 'fardin', '24b625baf04f34f08deafbd3b00f1a4869fe3d314ee766fa1f922bb92b483492', 'user'),
(25, 'Md Asadullah Asad', 'asadulasad728@gmail.com', 'Asad', 'ba83f79d43537a525eb5a38096b56f2fbee05fffdacb6ec9271b0c24b08dce24', 'user'),
(26, 'Md Asadullah Asad', 'asadulasad40@gmail.com', 'Asad1', 'ba83f79d43537a525eb5a38096b56f2fbee05fffdacb6ec9271b0c24b08dce24', 'user'),
(27, 'Umme Habiba Fariha', '2021-2-60-079@std.ewubd.edu', 'Umme Habiba Fariha', '8e5cb0cfa73474d9df2cdd79513fb108969c5efc64530a51d9f4cad6d585db36', 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `halltable`
--
ALTER TABLE `halltable`
  ADD PRIMARY KEY (`hallId`);

--
-- Indexes for table `moviehall`
--
ALTER TABLE `moviehall`
  ADD PRIMARY KEY (`slotid`);

--
-- Indexes for table `movietable`
--
ALTER TABLE `movietable`
  ADD PRIMARY KEY (`movieid`);

--
-- Indexes for table `ticket`
--
ALTER TABLE `ticket`
  ADD PRIMARY KEY (`ticketid`);

--
-- Indexes for table `usertable`
--
ALTER TABLE `usertable`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `halltable`
--
ALTER TABLE `halltable`
  MODIFY `hallId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `moviehall`
--
ALTER TABLE `moviehall`
  MODIFY `slotid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `movietable`
--
ALTER TABLE `movietable`
  MODIFY `movieid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ticket`
--
ALTER TABLE `ticket`
  MODIFY `ticketid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `usertable`
--
ALTER TABLE `usertable`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
