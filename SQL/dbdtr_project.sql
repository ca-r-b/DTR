-- phpMyAdmin SQL Dump
-- version 5.3.0-dev+20220602.a8a5655e4e
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 02, 2022 at 03:40 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dbdtr_project`
--

-- --------------------------------------------------------

--
-- Table structure for table `calendar`
--

CREATE TABLE `calendar` (
  `date` date NOT NULL,
  `event` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `calendar`
--

INSERT INTO `calendar` (`date`, `event`) VALUES
('2022-01-01', 'New Year\'s Day'),
('2022-02-01', 'Lunar New Year'),
('2022-04-09', 'Day of Valor'),
('2022-04-14', 'Maundy Thursday'),
('2022-04-15', 'Good Friday'),
('2022-05-01', 'Labour Day'),
('2022-06-13', 'Philippines Independence Day'),
('2022-08-29', 'National Heroes\' Day (in Philippines)'),
('2022-11-30', 'Bonifacio Day'),
('2022-12-08', 'Feast of the Immaculate Conception'),
('2022-12-25', 'Christmas'),
('2022-12-30', 'Rizal Day');

-- --------------------------------------------------------

--
-- Table structure for table `dtr`
--

CREATE TABLE `dtr` (
  `dtr_ID` int(11) NOT NULL,
  `dayAttendance` enum('Present','Absent') NOT NULL,
  `user_ID` int(11) NOT NULL,
  `date` date NOT NULL,
  `timein` time NOT NULL,
  `timeout` time NOT NULL,
  `is_restday` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `position`
--

CREATE TABLE `position` (
  `position_ID` int(11) NOT NULL,
  `position` enum('Manager','Programmer','Encoder','Secretary','Network Admin','No Position') NOT NULL,
  `salary` int(11) NOT NULL,
  `OT` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `position`
--

INSERT INTO `position` (`position_ID`, `position`, `salary`, `OT`) VALUES
(0, 'No Position', 0, 0),
(1, 'Manager', 880, 340),
(2, 'Programmer', 620, 300),
(3, 'Encoder', 410, 280),
(4, 'Secretary', 450, 280),
(5, 'Network Admin', 850, 330);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_ID` int(11) NOT NULL,
  `fName` varchar(25) NOT NULL,
  `lName` varchar(25) NOT NULL,
  `mName` varchar(25) DEFAULT NULL,
  `username` varchar(25) NOT NULL,
  `password` varchar(25) NOT NULL,
  `gender` enum('Male','Female','Others') NOT NULL,
  `status` enum('Regular','Probation') NOT NULL,
  `dateHired` date NOT NULL,
  `position_ID` int(11) DEFAULT NULL,
  `image` varchar(60) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `dtr`
--
ALTER TABLE `dtr`
  ADD PRIMARY KEY (`dtr_ID`),
  ADD KEY `user_id` (`user_ID`);

--
-- Indexes for table `position`
--
ALTER TABLE `position`
  ADD PRIMARY KEY (`position_ID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_ID`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `position` (`position_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `dtr`
--
ALTER TABLE `dtr`
  MODIFY `dtr_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `dtr`
--
ALTER TABLE `dtr`
  ADD CONSTRAINT `user_id` FOREIGN KEY (`user_ID`) REFERENCES `users` (`user_ID`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `position` FOREIGN KEY (`position_ID`) REFERENCES `position` (`position_ID`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;



