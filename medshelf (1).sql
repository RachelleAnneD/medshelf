-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 28, 2024 at 12:33 AM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 7.3.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `medshelf`
--

-- --------------------------------------------------------

--
-- Table structure for table `barangays`
--

CREATE TABLE `barangays` (
  `id` int(11) NOT NULL,
  `barangay_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `barangays`
--

INSERT INTO `barangays` (`id`, `barangay_name`) VALUES
(5, 'Allangigan'),
(6, 'Aludaid'),
(7, 'Bacsayan'),
(8, 'Balballosa'),
(9, 'Bambanay'),
(10, 'Bugbugcao'),
(11, 'Caarusipan'),
(12, 'Cabaroan'),
(13, 'Cabugnayan'),
(14, 'Cacapian'),
(15, 'Caculangan'),
(16, 'Calincamasan'),
(17, 'Casilagan'),
(18, 'Catdongan'),
(19, 'Dangdangla'),
(20, 'Dasay'),
(21, 'Dinanum'),
(22, 'Duplas'),
(23, 'Guinguinabang'),
(24, 'Ili Norte'),
(25, 'Ili Sur'),
(26, 'Legleg'),
(27, 'Lubing'),
(28, 'Nadsaag'),
(29, 'Nagsabaran'),
(30, 'Naguirangan'),
(31, 'Naguituban'),
(32, 'Nagyubuyuban'),
(33, 'Oaquing'),
(34, 'Pacpacac'),
(35, 'Pagdildilan'),
(36, 'Panicsican'),
(37, 'Quidem'),
(38, 'San Felipe'),
(39, 'Santa Rosa'),
(40, 'Santo Rosario'),
(41, 'Saracat'),
(42, 'Sinapangan'),
(43, 'Taboc'),
(44, 'Talogtog'),
(45, 'Urbiztondo');

-- --------------------------------------------------------

--
-- Table structure for table `patients`
--

CREATE TABLE `patients` (
  `patientid` int(11) NOT NULL,
  `fname` varchar(255) NOT NULL,
  `mname` varchar(255) DEFAULT NULL,
  `lname` varchar(255) NOT NULL,
  `nickname` varchar(255) DEFAULT NULL,
  `barangay_id` int(11) DEFAULT NULL,
  `municipality` varchar(20) NOT NULL,
  `province` varchar(20) NOT NULL,
  `date_of_birth` date NOT NULL,
  `age` int(11) NOT NULL,
  `birthplace` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `mobile_number` varchar(15) NOT NULL,
  `sex` enum('Male','Female') NOT NULL,
  `nationality` enum('Filipino','Others') DEFAULT NULL,
  `pwd_senior` enum('PWD','Senior','None') DEFAULT NULL,
  `pwd_sc_no` varchar(50) DEFAULT NULL,
  `member_status` enum('Dependent','Member') DEFAULT NULL,
  `member_pin_no` varchar(50) DEFAULT NULL,
  `dependent_pin_no` varchar(50) DEFAULT NULL,
  `consent` varchar(10) NOT NULL,
  `civil_status` enum('Single','Married','Widowed','Deceased','Separated','Child') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `patients`
--

INSERT INTO `patients` (`patientid`, `fname`, `mname`, `lname`, `nickname`, `barangay_id`, `municipality`, `province`, `date_of_birth`, `age`, `birthplace`, `email`, `mobile_number`, `sex`, `nationality`, `pwd_senior`, `pwd_sc_no`, `member_status`, `member_pin_no`, `dependent_pin_no`, `consent`, `civil_status`) VALUES
(47, 'josh', 'camero', 'miranda', 'joshua', 5, 'san juan ', 'la union', '0000-00-00', 24, 'bacnotan la union', 'joshua_miranda47@yahoo.com', '09123784081', '', NULL, NULL, NULL, NULL, NULL, NULL, '', ''),
(48, 'kc', 'herman', 'bedey', 'kc', 6, 'san juan ', 'la union', '2000-08-19', 24, 'bacnotan la union', '', '09123784084', 'Female', 'Filipino', 'PWD', '123', 'Dependent', 'n/a', '123', 'Yes', 'Single');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_drugs`
--

CREATE TABLE `tbl_drugs` (
  `id` int(11) NOT NULL,
  `Name` varchar(300) NOT NULL,
  `DOE` varchar(300) NOT NULL,
  `Quantity` varchar(300) NOT NULL,
  `Drugsremain` varchar(300) NOT NULL,
  `PurchasedPrice` varchar(300) NOT NULL,
  `RetailPrice` varchar(300) NOT NULL,
  `Strength` varchar(300) NOT NULL,
  `Medstype` varchar(300) NOT NULL,
  `Marker` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_drugs`
--

INSERT INTO `tbl_drugs` (`id`, `Name`, `DOE`, `Quantity`, `Drugsremain`, `PurchasedPrice`, `RetailPrice`, `Strength`, `Medstype`, `Marker`) VALUES
(1, 'Paracetamol', '2019-03-29', '5000', '4484', '1000', '7.5', '500mg', 'Tablet', '1.5'),
(2, 'Magnesium', '2020-03-11', '2000', '1647', '1000', '3', '250mg', 'Tablet', '1.5'),
(3, 'Parapain', '2015-01-07', '3000', '2785', '1000', '4.5', '100mg', 'Capsules', '1.5'),
(4, 'La', '2017-02-01', '10000', '9724', '2000', '7.5', '500mg', 'Tablet', '1.5'),
(5, 'Buffen', '2020-03-19', '6000', '5738', '3000', '3', '250mg', 'Tablet', '1.5'),
(6, 'CIPRO', '2021-01-07', '100', '100', '8100', '129.6', '500mg', 'Tablet', '1.6'),
(7, 'Quenin', '2019-04-04', '5000', '4960', '28800', '8.64', '250mg', 'Tablet', '1.5'),
(8, 'Penecilin', '19/04/18', '400', '400', '7000', '26.25', '200mg', 'Tablet', '1.5'),
(9, 'Bactrim', '19/04/19', '600', '600', '2000', '5', '200mg', 'Capsoles', '1.5');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','user') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`, `created_at`) VALUES
(2, 'user1', '$2y$10$1DGd/lQbWtTgZrzc3.ja8uej6.UHHxhBbwVIOXbfbfkyHl7K1kSeG', '', '2024-11-23 01:59:01'),
(6, 'admin', '$2y$10$tR.45y1lT9A4dZdMFId.SONTGXxC.9JxlykFPZsvWTnWIPinDQfWq', '', '2024-11-23 02:18:36'),
(7, 'user2', '$2y$10$SPSDpEqE/1eo0XUDlB9b4Ou/NUXqm5mFP7p472v1COdsQSJoblUGe', '', '2024-11-23 09:18:04'),
(8, 'Geannele', '$2y$10$pqGWVByDgF2aysPQXSC7LubG6dL/SIa0cTHAJjYFmaAzDkYVprs9a', '', '2024-11-25 10:47:53'),
(9, 'Cjhay', '$2y$10$L.9a6vHmmjkhkEsr/pYV.ON9Biq.izk1xu28fFQ/mJr70pR.Gx1Yi', '', '2024-11-25 13:46:40');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `barangays`
--
ALTER TABLE `barangays`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `patients`
--
ALTER TABLE `patients`
  ADD PRIMARY KEY (`patientid`),
  ADD KEY `idx_fname` (`fname`),
  ADD KEY `idx_lname` (`lname`),
  ADD KEY `fk_barangay` (`barangay_id`);

--
-- Indexes for table `tbl_drugs`
--
ALTER TABLE `tbl_drugs`
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
-- AUTO_INCREMENT for table `barangays`
--
ALTER TABLE `barangays`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `patients`
--
ALTER TABLE `patients`
  MODIFY `patientid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `tbl_drugs`
--
ALTER TABLE `tbl_drugs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `patients`
--
ALTER TABLE `patients`
  ADD CONSTRAINT `fk_barangay` FOREIGN KEY (`barangay_id`) REFERENCES `barangays` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
