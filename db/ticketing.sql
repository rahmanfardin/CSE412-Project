-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 29, 2024 at 05:28 PM
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
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(500) NOT NULL,
  `phone` varchar(500) NOT NULL,
  `message` varchar(5000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `halltable`
--

CREATE TABLE `halltable` (
  `hallId` int(11) NOT NULL,
  `hallname` varchar(100) NOT NULL,
  `location` varchar(1000) NOT NULL,
  `rating` int(11) NOT NULL,
  `type` varchar(100) NOT NULL,
  `capacity` int(11) NOT NULL DEFAULT 48
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `halltable`
--

INSERT INTO `halltable` (`hallId`, `hallname`, `location`, `rating`, `type`, `capacity`) VALUES
(30, 'Dhaka', 'Rampura', 4, '3D', 48),
(32, 'Cineplex', 'Rampura', 5, '2D', 48);

-- --------------------------------------------------------

--
-- Table structure for table `movietable`
--

CREATE TABLE `movietable` (
  `movieid` int(11) NOT NULL,
  `moviename` varchar(100) NOT NULL,
  `releasedate` date NOT NULL,
  `genre` varchar(100) NOT NULL,
  `rating` varchar(40) NOT NULL,
  `movierating` int(11) NOT NULL,
  `poster` blob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `movietable`
--

INSERT INTO `movietable` (`movieid`, `moviename`, `releasedate`, `genre`, `rating`, `movierating`, `poster`) VALUES
(24, 'Hob', '2024-09-18', 'action', 'PG-13', 6, 0x486f626273536861775f706f737465722e6a7067),
(26, 'Fast-X', '2024-09-03', 'action', 'PG-13', 5, 0x666173742d782e6a7067),
(27, 'Iratta', '2024-09-09', 'action', 'R', 1, 0x52616e6761737468616c616d2e6a7067);

--
-- Triggers `movietable`
--
DELIMITER $$
CREATE TRIGGER `deleteSlot` AFTER DELETE ON `movietable` FOR EACH ROW BEGIN
    DELETE FROM slottable WHERE movieid = OLD.movieid;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `seattable`
--

CREATE TABLE `seattable` (
  `ticketid` int(11) NOT NULL,
  `seatno` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `seattable`
--

INSERT INTO `seattable` (`ticketid`, `seatno`) VALUES
(1, 9),
(1, 10),
(4, 22),
(5, 30),
(6, 21),
(7, 21),
(7, 29),
(8, 27),
(9, 19),
(10, 20);

-- --------------------------------------------------------

--
-- Table structure for table `slottable`
--

CREATE TABLE `slottable` (
  `movieid` int(11) NOT NULL,
  `hallid` int(11) NOT NULL,
  `slotid` int(11) NOT NULL,
  `date` date NOT NULL,
  `slot` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `slottable`
--

INSERT INTO `slottable` (`movieid`, `hallid`, `slotid`, `date`, `slot`) VALUES
(24, 30, 19, '2024-09-27', 'Morning');

-- --------------------------------------------------------

--
-- Table structure for table `ticket`
--

CREATE TABLE `ticket` (
  `ticketid` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `slotid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ticket`
--

INSERT INTO `ticket` (`ticketid`, `userid`, `slotid`) VALUES
(1, 21, 19),
(4, 21, 19),
(5, 21, 19),
(6, 21, 19),
(7, 21, 19),
(8, 21, 19),
(9, 21, 19),
(10, 21, 19);

--
-- Triggers `ticket`
--
DELIMITER $$
CREATE TRIGGER `deleteSeats` AFTER DELETE ON `ticket` FOR EACH ROW BEGIN
	DELETE FROM seattable WHERE ticketid = OLD.ticketid;
END
$$
DELIMITER ;

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
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `halltable`
--
ALTER TABLE `halltable`
  ADD PRIMARY KEY (`hallId`);

--
-- Indexes for table `movietable`
--
ALTER TABLE `movietable`
  ADD PRIMARY KEY (`movieid`);

--
-- Indexes for table `slottable`
--
ALTER TABLE `slottable`
  ADD PRIMARY KEY (`slotid`),
  ADD UNIQUE KEY `date` (`date`,`slot`,`hallid`) USING BTREE;

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
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `halltable`
--
ALTER TABLE `halltable`
  MODIFY `hallId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `movietable`
--
ALTER TABLE `movietable`
  MODIFY `movieid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `slottable`
--
ALTER TABLE `slottable`
  MODIFY `slotid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `ticket`
--
ALTER TABLE `ticket`
  MODIFY `ticketid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `usertable`
--
ALTER TABLE `usertable`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
