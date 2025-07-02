-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 30, 2025 at 12:27 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `police_acrmsdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `his_accounts`
--

CREATE TABLE `his_accounts` (
  `acc_id` int(200) NOT NULL,
  `acc_name` varchar(200) DEFAULT NULL,
  `acc_desc` text DEFAULT NULL,
  `acc_type` varchar(200) DEFAULT NULL,
  `acc_number` varchar(200) DEFAULT NULL,
  `acc_amount` varchar(200) DEFAULT NULL,
  `requestingDate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `his_admin`
--

CREATE TABLE `his_admin` (
  `ad_id` int(20) NOT NULL,
  `ad_fname` varchar(200) DEFAULT NULL,
  `ad_lname` varchar(200) DEFAULT NULL,
  `ad_email` varchar(200) DEFAULT NULL,
  `ad_pwd` varchar(200) DEFAULT NULL,
  `ad_dpic` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `his_admin`
--

INSERT INTO `his_admin` (`ad_id`, `ad_fname`, `ad_lname`, `ad_email`, `ad_pwd`, `ad_dpic`) VALUES
(1, 'System', 'Administrator', 'admin@mail.com', '4c7f5919e957f354d57243d37f223cf31e9e7181', 'staff-icon.png');

-- --------------------------------------------------------

--
-- Table structure for table `his_cases`
--

CREATE TABLE `his_cases` (
  `compt_id` int(20) NOT NULL,
  `compt_fname` varchar(200) DEFAULT NULL,
  `compt_lname` varchar(200) DEFAULT NULL,
  `date_occur` varchar(200) DEFAULT NULL,
  `victim` varchar(200) DEFAULT NULL,
  `sd_ref` varchar(200) DEFAULT NULL,
  `compt_addr` varchar(200) DEFAULT NULL,
  `compt_phone` varchar(200) DEFAULT NULL,
  `compt_type` varchar(200) DEFAULT NULL,
  `compt_date_joined` timestamp(6) NOT NULL DEFAULT current_timestamp(6) ON UPDATE current_timestamp(6),
  `offence_details` varchar(200) DEFAULT NULL,
  `compt_discharge_status` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `his_cases`
--

INSERT INTO `his_cases` (`compt_id`, `compt_fname`, `compt_lname`, `date_occur`, `victim`, `sd_ref`, `compt_addr`, `compt_phone`, `compt_type`, `compt_date_joined`, `offence_details`, `compt_discharge_status`) VALUES
(25, 'TEDDY', 'MARTHA', '2025-06-04', 'OKOTH MARK', '29/17/03/2025', 'ROBBERY', '0785556789', 'Criminal', '2025-06-13 09:00:53.637416', '8 Million robbed', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `his_exhibit`
--

CREATE TABLE `his_exhibit` (
  `xbt_id` int(200) NOT NULL,
  `xbt_compt_name` varchar(200) DEFAULT NULL,
  `xbt_victim` varchar(200) DEFAULT NULL,
  `xbt_sd_ref` varchar(200) DEFAULT NULL,
  `xbt_number` varchar(200) DEFAULT NULL,
  `xbt_compt_addr` varchar(200) DEFAULT NULL,
  `xbt_compt_type` varchar(200) DEFAULT NULL,
  `xbt_date` timestamp(4) NOT NULL DEFAULT current_timestamp(4) ON UPDATE current_timestamp(4),
  `xbt_offence_details` varchar(200) DEFAULT NULL,
  `xbt_desc` longtext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `his_exhibit`
--

INSERT INTO `his_exhibit` (`xbt_id`, `xbt_compt_name`, `xbt_victim`, `xbt_sd_ref`, `xbt_number`, `xbt_compt_addr`, `xbt_compt_type`, `xbt_date`, `xbt_offence_details`, `xbt_desc`) VALUES
(2, 'Tazuba Cyrus', 'kasiba', ' hgsd yhc', 'V8JAM', 'k', 'Civil', '2025-04-19 07:34:13.0000', 'raped', '<p>hhhjj</p>'),
(3, 'Tazuba Cyrus', 'kasiba', ' hgsd yhc', 'VBG4D', 'k', 'Civil', '2025-04-19 08:24:51.0000', 'gfvbws ', '<p>I have add new xbt to test this</p>'),
(4, 'ABAHO NOMAR', 'BONDO TOM', '28/17/03/2025', 'SUCK4', 'Aggravated Robbery', 'Choose', '2025-04-20 06:11:28.0000', '4 identified persons robbed 200,000 UGX from one Bondo Tom', '<ol><li>Bamuriski</li></ol>'),
(5, 'OKUMA RAS', 'BONDO TOM', '27/18/03/2025', '4N3Y6', 'Robbery', 'Choose', '2025-04-20 07:03:48.0000', 'A Motorcycle was stolen', '<p>srdhtfgjk. jhgfdsgn</p>'),
(6, 'ABAHO NOMAR', 'BONDO TOM', '28/17/03/2025', 'BA75S', 'Aggravated Robbery', 'Choose', '2025-04-20 07:13:20.0000', '4 identified persons robbed 200,000 UGX from one Bondo Tom', '<ol><li>Panga</li></ol>'),
(7, 'ASEGE RASMUS', 'BONDO TOM', '22/17/03/2025', 'UWO74', 'Robbery', 'Criminal', '2025-04-20 10:05:33.3643', 'Two identified persons robbed 200,000 UGX from one Bondo Tom', NULL),
(8, 'ASEGE RASMUS', 'BONDO TOM', '22/17/03/2025', 'UWO74', 'Robbery', 'Criminal', '2025-04-20 10:06:28.6650', 'Two identified persons robbed 200,000 UGX from one Bondo Tom', NULL),
(12, 'OKUMA RAS', 'BONDO TOM', '27/18/03/2025', 'JN6BA', 'Robbery', 'Criminal', '2025-04-22 03:47:41.0000', 'A Motorcycle was stolen', '<p>Vehicle</p>'),
(13, 'OKUMATA JAVIS', 'RICHARD WISLEY', '26/17/03/2025', 'JET4B', 'Robbery', 'Civil', '2025-04-22 03:59:12.0000', '4 identified persons robbed 200,000 UGX from one Bondo Tom', '<ol><li>Panga</li><li>National ID</li><li>Motorcycle</li><li>shoes</li></ol>'),
(14, 'ASEGE RAS', 'BON', '21/17/03/2025', 'RJEUX', 'Robbery', 'Disciplinary', '2025-04-22 04:26:11.0000', 'A Motorcycle was stolen', '<ol><li>SCHOOL ID</li><li>TROUSER</li><li>STOLEN ITEMS</li></ol>'),
(15, 'OKUMA RASFORD', 'BONDO TOM', '29/18/03/2025', 'JSQ0P', 'Robbery', 'Criminal', '2025-04-23 15:36:43.0000', 'A Motorcycle was stolen ', '<p>Treasure</p>'),
(16, 'ABAHO RASMUSA', 'ROB WISLEY', '21/17/03/2025', 'D3SW0', 'Aggravated Robbery', 'Criminal', '2025-04-23 15:46:33.0000', 'Robbery of 200,000 UGX', '<p>theeregfh gguhgb h fghg bjghgbhb</p>');

-- --------------------------------------------------------

--
-- Table structure for table `his_pwdresets`
--

CREATE TABLE `his_pwdresets` (
  `id` int(20) NOT NULL,
  `email` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `his_staff`
--

CREATE TABLE `his_staff` (
  `staff_id` int(20) NOT NULL,
  `staff_fname` varchar(200) DEFAULT NULL,
  `staff_lname` varchar(200) DEFAULT NULL,
  `staff_email` varchar(200) DEFAULT NULL,
  `staff_pwd` varchar(200) DEFAULT NULL,
  `staff_dept` varchar(200) DEFAULT NULL,
  `staff_number` varchar(200) DEFAULT NULL,
  `staff_dpic` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `his_staff`
--

INSERT INTO `his_staff` (`staff_id`, `staff_fname`, `staff_lname`, `staff_email`, `staff_pwd`, `staff_dept`, `staff_number`, `staff_dpic`) VALUES
(26, 'MAWA', 'DENIS', 'denis@kaj.pol', 'adcd7048512e64b48da55b027577886ee5a36350', 'ICT', '76333 PPC', 'uploads/1749798923_images.jpeg'),
(27, 'JAMES', 'ATAMA', 'james@kaj.pol', 'adcd7048512e64b48da55b027577886ee5a36350', 'ICT', '42556 CPL', 'uploads/1749800071_download.jpeg');

-- --------------------------------------------------------

--
-- Table structure for table `his_staff_transfer`
--

CREATE TABLE `his_staff_transfer` (
  `t_id` int(20) NOT NULL,
  `t_destination` varchar(200) DEFAULT NULL,
  `t_date` varchar(200) DEFAULT NULL,
  `t_compt_name` varchar(200) DEFAULT NULL,
  `t_sd_ref` varchar(200) DEFAULT NULL,
  `t_status` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `his_suspects`
--

CREATE TABLE `his_suspects` (
  `Cid` int(20) NOT NULL,
  `suspect_number` varchar(200) DEFAULT NULL,
  `suspect_sd_ref` varchar(200) DEFAULT NULL,
  `suspect_name` varchar(200) DEFAULT NULL,
  `suspect_gender` varchar(200) DEFAULT NULL,
  `suspect_arresting_officer` varchar(200) DEFAULT NULL,
  `suspect_arrest_date` datetime(6) DEFAULT NULL,
  `suspect_daterec` timestamp(6) NOT NULL DEFAULT current_timestamp(6) ON UPDATE current_timestamp(6)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `his_suspects`
--

INSERT INTO `his_suspects` (`Cid`, `suspect_number`, `suspect_sd_ref`, `suspect_name`, `suspect_gender`, `suspect_arresting_officer`, `suspect_arrest_date`, `suspect_daterec`) VALUES
(591, 'WAVEU', '29/17/03/2025', 'OUMA JOHN', 'Male', 'CPL NGOMA DAN', '0000-00-00 00:00:00.000000', '2025-06-12 21:00:00.000000');

-- --------------------------------------------------------

--
-- Table structure for table `his_witness`
--

CREATE TABLE `his_witness` (
  `id` int(11) NOT NULL,
  `wit_compt_name` varchar(255) DEFAULT NULL,
  `wit_offence_details` text DEFAULT NULL,
  `wit_sd_ref` varchar(100) DEFAULT NULL,
  `wit_witness_reports` text DEFAULT NULL,
  `wit_witness` varchar(50) DEFAULT NULL,
  `wit_date_rec` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `his_accounts`
--
ALTER TABLE `his_accounts`
  ADD PRIMARY KEY (`acc_id`);

--
-- Indexes for table `his_admin`
--
ALTER TABLE `his_admin`
  ADD PRIMARY KEY (`ad_id`);

--
-- Indexes for table `his_cases`
--
ALTER TABLE `his_cases`
  ADD PRIMARY KEY (`compt_id`);

--
-- Indexes for table `his_exhibit`
--
ALTER TABLE `his_exhibit`
  ADD PRIMARY KEY (`xbt_id`);

--
-- Indexes for table `his_pwdresets`
--
ALTER TABLE `his_pwdresets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `his_staff`
--
ALTER TABLE `his_staff`
  ADD PRIMARY KEY (`staff_id`);

--
-- Indexes for table `his_staff_transfer`
--
ALTER TABLE `his_staff_transfer`
  ADD PRIMARY KEY (`t_id`);

--
-- Indexes for table `his_suspects`
--
ALTER TABLE `his_suspects`
  ADD PRIMARY KEY (`Cid`);

--
-- Indexes for table `his_witness`
--
ALTER TABLE `his_witness`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `his_accounts`
--
ALTER TABLE `his_accounts`
  MODIFY `acc_id` int(200) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `his_cases`
--
ALTER TABLE `his_cases`
  MODIFY `compt_id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `his_exhibit`
--
ALTER TABLE `his_exhibit`
  MODIFY `xbt_id` int(200) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `his_staff`
--
ALTER TABLE `his_staff`
  MODIFY `staff_id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `his_suspects`
--
ALTER TABLE `his_suspects`
  MODIFY `Cid` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=592;

--
-- AUTO_INCREMENT for table `his_witness`
--
ALTER TABLE `his_witness`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
