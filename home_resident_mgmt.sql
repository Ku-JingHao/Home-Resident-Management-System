-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 05, 2024 at 03:12 PM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 8.0.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `home_resident_mgmt`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `admin_id` int(100) NOT NULL,
  `admin_name` varchar(50) NOT NULL,
  `admin_email` varchar(50) NOT NULL,
  `admin_number` varchar(12) NOT NULL,
  `admin_password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_id`, `admin_name`, `admin_email`, `admin_number`, `admin_password`) VALUES
(9, 'Abu', 'abu123@gmail.com', '012-3456789', '0b57bbbe6bc57309ce0e273753b947d60ad46b5b');

-- --------------------------------------------------------

--
-- Table structure for table `event`
--

CREATE TABLE `event` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `start` datetime NOT NULL,
  `end` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `event`
--

INSERT INTO `event` (`id`, `title`, `start`, `end`) VALUES
(6, 'Meeting', '2024-02-15 00:00:00', '2024-02-16 00:00:00'),
(7, 'Concert', '2024-02-09 00:00:00', '2024-02-10 00:00:00'),
(8, 'Tournament', '2024-02-08 00:00:00', '2024-02-09 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `feedback_id` int(20) NOT NULL,
  `feedback_name` varchar(100) NOT NULL,
  `feedback_email` varchar(100) NOT NULL,
  `feedback_type` varchar(50) NOT NULL,
  `feedback_details` text NOT NULL,
  `photo_upload` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`feedback_id`, `feedback_name`, `feedback_email`, `feedback_type`, `feedback_details`, `photo_upload`) VALUES
(2, 'cai', 'cai123@gmail.com', 'complaint', 'asas', 'cross.png');

-- --------------------------------------------------------

--
-- Table structure for table `key`
--

CREATE TABLE `key` (
  `key_id` int(100) NOT NULL,
  `user_id` int(100) NOT NULL,
  `key_requestedName` varchar(100) NOT NULL,
  `key_requestedEmail` varchar(50) NOT NULL,
  `key_requestedNumber` varchar(12) NOT NULL,
  `key_unitNumber` varchar(10) NOT NULL,
  `key_DateRegistered` date NOT NULL DEFAULT current_timestamp(),
  `key_Status` varchar(20) DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `key`
--

INSERT INTO `key` (`key_id`, `user_id`, `key_requestedName`, `key_requestedEmail`, `key_requestedNumber`, `key_unitNumber`, `key_DateRegistered`, `key_Status`) VALUES
(20, 18, 'Ben', 'ben666@gmail.com', '017-5556666', 'A-1', '2024-02-04', 'Successfully');

-- --------------------------------------------------------

--
-- Table structure for table `keyregistration`
--

CREATE TABLE `keyregistration` (
  `keyRegistration_id` int(100) NOT NULL,
  `unit_number` varchar(10) NOT NULL,
  `key_type` varchar(255) NOT NULL,
  `keyRegistration_status` varchar(20) NOT NULL DEFAULT 'Deactivate',
  `keyRegistration_name` varchar(100) NOT NULL DEFAULT 'None',
  `keyRegistration_email` varchar(50) NOT NULL DEFAULT 'None',
  `keyRegistration_number` varchar(12) NOT NULL DEFAULT 'None',
  `keyRegistration_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `keyregistration`
--

INSERT INTO `keyregistration` (`keyRegistration_id`, `unit_number`, `key_type`, `keyRegistration_status`, `keyRegistration_name`, `keyRegistration_email`, `keyRegistration_number`, `keyRegistration_date`) VALUES
(1, 'A-1', 'Masterbedroom Key(1), Bedroom2(2)', 'Deactivate', 'None', 'None', 'None', '0000-00-00'),
(2, 'A-2', 'Masterbedroom Key(1), Bedroom2(1)', 'Deactivate', 'None', 'None', 'None', '0000-00-00'),
(3, 'A-3', 'Masterbedroom Key(1), Bedroom2(1)', 'Deactivate', 'None', 'None', 'None', '0000-00-00'),
(4, 'A-4', 'Masterbedroom Key(1), Bedroom2(1), Bedroom3(1)', 'Deactivate', 'None', 'None', 'None', '0000-00-00'),
(5, 'A-5', 'Masterbedroom Key(1), Bedroom2(2), Bedroom3(1)', 'Deactivate', 'None', 'None', 'None', '0000-00-00'),
(6, 'A-6', 'Masterbedroom Key(1), Bedroom2(2), Bedroom3(1), Bedroom4(1)', 'Deactivate', 'None', 'None', 'None', '0000-00-00');

-- --------------------------------------------------------

--
-- Table structure for table `resident`
--

CREATE TABLE `resident` (
  `resident_id` int(100) NOT NULL,
  `resident_name` varchar(50) NOT NULL,
  `resident_email` varchar(50) NOT NULL,
  `resident_number` varchar(12) NOT NULL,
  `resident_unit` varchar(255) NOT NULL,
  `resident_gender` varchar(255) NOT NULL,
  `resident_password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `resident`
--

INSERT INTO `resident` (`resident_id`, `resident_name`, `resident_email`, `resident_number`, `resident_unit`, `resident_gender`, `resident_password`) VALUES
(18, 'Ben66', 'ben666@gmail.com', '017-5556666', 'A-1', 'Male', '6216f8a75fd5bb3d5f22b6f9958cdede3fc086c2');

-- --------------------------------------------------------

--
-- Table structure for table `visitor`
--

CREATE TABLE `visitor` (
  `visitor_id` int(100) NOT NULL,
  `visitor_type` varchar(255) NOT NULL,
  `visitor_name` varchar(100) NOT NULL,
  `visitor_email` varchar(50) NOT NULL,
  `visitor_number` varchar(12) NOT NULL,
  `visit_date` date NOT NULL,
  `visit_purpose` varchar(255) NOT NULL,
  `resident_name` varchar(100) NOT NULL,
  `resident_unit` varchar(255) NOT NULL,
  `approval_status` enum('Pending','Approved','Declined','') DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `visitor`
--

INSERT INTO `visitor` (`visitor_id`, `visitor_type`, `visitor_name`, `visitor_email`, `visitor_number`, `visit_date`, `visit_purpose`, `resident_name`, `resident_unit`, `approval_status`) VALUES
(2, 'Registered', 'ouyangnananana', 'ouyangnana666@gmail.com', '012-3333333', '2024-01-25', 'sHIT', 'nb ce lian', 'A-1', 'Approved');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `event`
--
ALTER TABLE `event`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`feedback_id`);

--
-- Indexes for table `key`
--
ALTER TABLE `key`
  ADD PRIMARY KEY (`key_id`);

--
-- Indexes for table `keyregistration`
--
ALTER TABLE `keyregistration`
  ADD PRIMARY KEY (`keyRegistration_id`);

--
-- Indexes for table `resident`
--
ALTER TABLE `resident`
  ADD PRIMARY KEY (`resident_id`);

--
-- Indexes for table `visitor`
--
ALTER TABLE `visitor`
  ADD PRIMARY KEY (`visitor_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `admin_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `event`
--
ALTER TABLE `event`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `feedback_id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `key`
--
ALTER TABLE `key`
  MODIFY `key_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `keyregistration`
--
ALTER TABLE `keyregistration`
  MODIFY `keyRegistration_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `resident`
--
ALTER TABLE `resident`
  MODIFY `resident_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `visitor`
--
ALTER TABLE `visitor`
  MODIFY `visitor_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
