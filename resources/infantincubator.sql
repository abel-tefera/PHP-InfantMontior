-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 01, 2019 at 12:16 PM
-- Server version: 10.1.38-MariaDB
-- PHP Version: 7.3.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `infantincubator`
--

-- --------------------------------------------------------

--
-- Table structure for table `incubators`
--

CREATE TABLE `incubators` (
  `id` int(11) NOT NULL,
  `Number` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `incubators`
--

INSERT INTO `incubators` (`id`, `Number`) VALUES
(1, '24K'),
(3, '26T'),
(4, '24pb'),
(5, 'C-137'),
(6, 'KKK');

-- --------------------------------------------------------

--
-- Table structure for table `infants`
--

CREATE TABLE `infants` (
  `id` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `DateofBirth` date DEFAULT NULL,
  `MotherName` varchar(255) NOT NULL,
  `Sex` varchar(32) NOT NULL,
  `Incubator` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `infants`
--

INSERT INTO `infants` (`id`, `Name`, `DateofBirth`, `MotherName`, `Sex`, `Incubator`) VALUES
(4, 'Infant', '2018-06-05', 'Mum', 'Female', '26T'),
(5, 'Baby', '2019-05-29', 'Mother', 'Male', '24pb'),
(6, 'NewInfant', '2018-09-12', 'Mama', 'Female', '26T'),
(7, 'Rick', '2020-01-01', 'Mazuka', 'Male', 'C-137'),
(8, 'New', '2019-06-11', 'sadasd', 'Female', '24K');

-- --------------------------------------------------------

--
-- Table structure for table `sensors_data`
--

CREATE TABLE `sensors_data` (
  `id` int(128) NOT NULL,
  `infant` int(11) NOT NULL,
  `date_data` date NOT NULL,
  `time_data` time NOT NULL,
  `data_temperature` varchar(32) NOT NULL,
  `data_breathing` varchar(32) NOT NULL,
  `data_humidity` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sensors_data`
--

INSERT INTO `sensors_data` (`id`, `infant`, `date_data`, `time_data`, `data_temperature`, `data_breathing`, `data_humidity`) VALUES
(2098, 4, '2019-07-01', '01:02:14', '0', '27', '67'),
(2099, 4, '2019-07-01', '01:02:15', '67', '80', '13'),
(2100, 4, '2019-07-01', '01:02:21', '86', '16', '96'),
(2101, 4, '2019-07-01', '01:02:27', '74', '42', '0'),
(2102, 4, '2019-07-01', '01:02:34', '9', '38', '35'),
(2103, 4, '2019-07-01', '01:02:40', '44', '34', '69'),
(2104, 4, '2019-07-01', '01:02:46', '16', '0', '22'),
(2105, 4, '2019-07-01', '01:02:52', '51', '96', '56'),
(2106, 4, '2019-06-19', '01:02:59', '39', '22', '60'),
(2107, 4, '2018-01-01', '00:00:00', '40', '50', '60');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `Name` varchar(256) NOT NULL,
  `Username` varchar(256) NOT NULL,
  `password` varchar(256) NOT NULL,
  `Role` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `Name`, `Username`, `password`, `Role`) VALUES
(1, 'Doctor', 'Doctor', '$2y$10$vKLACGZD2.V2a5qC0MCLzekuEUSSjG0ZlB5l/A5EwtGVPo8uNNf/.', 'Doctor'),
(2, 'Nurse', 'Nurse', '$2y$10$K7sZ3ArkCalY7u5kWocrX.sWFvOhffd4XWMlg6KOVTtaTdb7efwwC', 'Nurse'),
(3, 'Admin', 'Admin', '$2y$10$0zUrNRPNgkF7LxHgR89pouEyWe9ZUEE0v4pQq4q9ocoAMtinOap2y', 'Admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `incubators`
--
ALTER TABLE `incubators`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `infants`
--
ALTER TABLE `infants`
  ADD PRIMARY KEY (`id`),
  ADD KEY `inc_id` (`Incubator`);

--
-- Indexes for table `sensors_data`
--
ALTER TABLE `sensors_data`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `incubators`
--
ALTER TABLE `incubators`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `infants`
--
ALTER TABLE `infants`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `sensors_data`
--
ALTER TABLE `sensors_data`
  MODIFY `id` int(128) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2108;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
