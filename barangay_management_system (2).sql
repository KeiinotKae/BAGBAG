-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3307
-- Generation Time: Jul 21, 2025 at 03:44 PM
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
-- Database: `barangay_management_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `activities`
--

CREATE TABLE `activities` (
  `id` int(11) NOT NULL,
  `title` varchar(100) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `date_held` date DEFAULT NULL,
  `location` varchar(100) DEFAULT NULL,
  `attendees_count` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `position` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `full_name`, `email`, `password`, `position`, `phone`, `created_at`) VALUES
(2, 'Administrator', 'admin@example.com', '$2y$10$Pf9XPIwDEHT65BLkKRAUGeZ/qF/HsL2cTc7KhLYVfofWLmSdD4QGe', 'Administrator', '09978723222', '2025-07-01 07:46:36');

-- --------------------------------------------------------

--
-- Table structure for table `announcements`
--

CREATE TABLE `announcements` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `announcements`
--

INSERT INTO `announcements` (`id`, `title`, `description`, `created_at`) VALUES
(24, 'Announcement', 'Our barangay, Gaid Dimasalang Masbate, is generally peaceful because, aside from our reliable tanods, we homeowners strictly implement measures in each respective street. Extended families are a no-no and transpo is on limited time. Not only is ours peaceful, we also host a lot of schoolchildren from nearby barangays because we have a high school and wide conducive grounds. Our Toda is polite.', '2025-07-01 07:01:21');

-- --------------------------------------------------------

--
-- Table structure for table `announcements2`
--

CREATE TABLE `announcements2` (
  `id` int(11) NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `uploaded_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `announcements2`
--

INSERT INTO `announcements2` (`id`, `image_path`, `uploaded_at`) VALUES
(2, 'announcements2/mission.jpg', '2025-07-19 12:37:44');

-- --------------------------------------------------------

--
-- Table structure for table `blotter_reports`
--

CREATE TABLE `blotter_reports` (
  `id` int(11) NOT NULL,
  `residents_id` int(11) DEFAULT NULL,
  `complainant_name` varchar(255) NOT NULL,
  `incident_details` text NOT NULL,
  `status` varchar(50) DEFAULT 'Pending',
  `date_reported` datetime DEFAULT current_timestamp(),
  `complainant_address` varchar(255) DEFAULT NULL,
  `complainant_contact` varchar(20) DEFAULT NULL,
  `accused_name` varchar(255) DEFAULT NULL,
  `accused_address` varchar(255) DEFAULT NULL,
  `accused_contact` varchar(255) DEFAULT NULL,
  `complaint_type` varchar(100) DEFAULT NULL,
  `incident_date` date DEFAULT NULL,
  `incident_time` time DEFAULT NULL,
  `incident_location` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `blotter_reports`
--

INSERT INTO `blotter_reports` (`id`, `residents_id`, `complainant_name`, `incident_details`, `status`, `date_reported`, `complainant_address`, `complainant_contact`, `accused_name`, `accused_address`, `accused_contact`, `complaint_type`, `incident_date`, `incident_time`, `incident_location`) VALUES
(11, 61, 'Amiel Jake Baril', '\\\"On July 17, 2025, at approximately 2:15 PM, a traffic accident occurred at the intersection of Commonwealth Avenue and Tandang Sora Avenue in Quezon City. The incident involved a collision between a red Toyota Corolla, driven by Juan Dela Cruz (DOB: 01/15/1980), and a black Honda motorcycle, ridden by Maria Santos (DOB: 05/20/1992). Initial reports indicate that the motorcycle, traveling northbound on Commonwealth, ran a red light and collided with the Corolla, which was turning left onto Tandang Sora. Maria Santos sustained minor injuries and was transported to East Avenue Medical Center by responding paramedics. The vehicle sustained damage to the front left fender and headlight. A witness, Pedro Reyes (DOB: 08/10/1975), stated he saw the motorcycle fail to stop for the red light. The incident was referred to the Traffic Management Unit for further investigation. ', 'Pending', '2025-07-17 15:01:49', '', '', 'Jerome Arizobal', 'Gaid', 'Jerome Arizobal', 'Nanapak ng walang dahilan', '2025-07-17', '21:00:00', 'Gaid Plaza'),
(22, 66, 'Mariel Jean Baril', 'Complainant: Jane Smith, 456 Oak Avenue, reported a case of physical assault. The incident occurred at approximately 8:00 PM on July 19, 2025, at the corner of Pine Street and Elm Avenue. Ms. Smith stated that she was walking home when she was approached by an unknown male who pushed her to the ground. The suspect then fled the scene. Ms. Smith sustained minor scratches and bruises. The responding officer, PO1 [Officer\\\'s Name], documented the incident and advised Ms. Smith to seek medical attention if needed. Investigation is ongoing to identify and apprehend the suspect.', 'Pending', '2025-07-19 12:23:31', NULL, NULL, 'Jerome Arizobal', 'Gaid', 'Jerome Arizobal', 'Noise Complaint', '2025-07-19', '18:30:00', 'Gaid Plaza');

-- --------------------------------------------------------

--
-- Table structure for table `bpso`
--

CREATE TABLE `bpso` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `position` varchar(100) DEFAULT NULL,
  `date_started` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bpso`
--

INSERT INTO `bpso` (`id`, `user_id`, `address`, `phone`, `email`, `position`, `date_started`) VALUES
(1, 65, 'QC', '09111111111', 'johnkenneth@gmail.com', 'desk BPSO', '2025-07-17');

-- --------------------------------------------------------

--
-- Table structure for table `budget_allocations`
--

CREATE TABLE `budget_allocations` (
  `id` int(11) NOT NULL,
  `category` varchar(100) DEFAULT NULL,
  `allocated_amount` decimal(10,2) DEFAULT NULL,
  `used_amount` decimal(10,2) DEFAULT NULL,
  `year` int(11) DEFAULT year(curdate())
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `committee_images`
--

CREATE TABLE `committee_images` (
  `id` int(11) NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `uploaded_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `committee_images`
--

INSERT INTO `committee_images` (`id`, `image_path`, `uploaded_at`) VALUES
(1, 'committee_images/committess.png', '2025-07-19 07:54:31'),
(4, 'committee_images/4-bagbag.png', '2025-07-19 08:54:34');

-- --------------------------------------------------------

--
-- Table structure for table `community_reports`
--

CREATE TABLE `community_reports` (
  `report_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `report_type` varchar(255) DEFAULT NULL,
  `category` varchar(255) DEFAULT NULL,
  `priority_level` varchar(50) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `evidence` text DEFAULT NULL,
  `status` varchar(50) DEFAULT 'Pending',
  `action_taken` text DEFAULT NULL,
  `action_date` date DEFAULT NULL,
  `people_involved` text DEFAULT NULL,
  `recommendations` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `submitter_name` varchar(255) DEFAULT NULL,
  `submitter_email` varchar(255) DEFAULT NULL,
  `submitter_contact` varchar(15) DEFAULT NULL,
  `submitter_type` varchar(50) DEFAULT 'Resident'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `community_reports`
--

INSERT INTO `community_reports` (`report_id`, `user_id`, `report_type`, `category`, `priority_level`, `location`, `title`, `description`, `evidence`, `status`, `action_taken`, `action_date`, `people_involved`, `recommendations`, `created_at`, `updated_at`, `submitter_name`, `submitter_email`, `submitter_contact`, `submitter_type`) VALUES
(14, 66, 'Mabahong Aso', 'Health & Sanitation', 'Medium', 'Area 6', 'Mabahong Aso', 'Complainant: Jane Smith, 456 Oak Avenue, reported a case of physical assault. The incident occurred at approximately 8:00 PM on July 19, 2025, at the corner of Pine Street and Elm Avenue. Ms. Smith stated that she was walking home when she was approached by an unknown male who pushed her to the ground. The suspect then fled the scene. Ms. Smith sustained minor scratches and bruises. The responding officer, PO1 [Officer\\\'s Name], documented the incident and advised Ms. Smith to seek medical attention if needed. Investigation is ongoing to identify and apprehend the suspect.', 'uploads/evidence/evidence_687b817390b806.88254572.jpg', 'Pending', NULL, NULL, NULL, NULL, '2025-07-19 11:28:51', '2025-07-19 11:28:51', 'Mariel Jean Baril', 'marieljeanbaril68@gmail.com', '09978723222', 'Resident'),
(16, 61, 'baha', 'Disaster', 'Medium', 'Area 6', 'baha', 'baha', 'uploads/evidence/evidence_687e0ee0177225.00933907.mp4', 'Pending', NULL, NULL, NULL, NULL, '2025-07-21 09:56:48', '2025-07-21 09:56:48', 'Amiel Jake Baril', 'amieljake929@gmail.com', '09978723222', 'Resident');

-- --------------------------------------------------------

--
-- Table structure for table `document_requests`
--

CREATE TABLE `document_requests` (
  `id` int(11) NOT NULL,
  `resident_id` int(11) NOT NULL,
  `resident_name` varchar(255) NOT NULL,
  `document_type` varchar(100) NOT NULL,
  `business_name` varchar(255) DEFAULT NULL,
  `business_address` varchar(255) DEFAULT NULL,
  `tin_number` varchar(100) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `pob` varchar(255) DEFAULT NULL,
  `citizenship` varchar(100) DEFAULT NULL,
  `profile_photo` varchar(255) DEFAULT NULL,
  `educ_attainment` varchar(100) DEFAULT NULL,
  `course_graduated` varchar(100) DEFAULT NULL,
  `profession` varchar(100) DEFAULT NULL,
  `purpose` text NOT NULL,
  `notes` text DEFAULT NULL,
  `request_date` datetime NOT NULL,
  `status` varchar(50) DEFAULT 'Pending',
  `hidden_for_official` tinyint(1) DEFAULT 0,
  `approved_by` int(11) DEFAULT NULL,
  `fee` decimal(10,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `document_requests`
--

INSERT INTO `document_requests` (`id`, `resident_id`, `resident_name`, `document_type`, `business_name`, `business_address`, `tin_number`, `dob`, `pob`, `citizenship`, `profile_photo`, `educ_attainment`, `course_graduated`, `profession`, `purpose`, `notes`, `request_date`, `status`, `hidden_for_official`, `approved_by`, `fee`) VALUES
(46, 35, 'Maricel Baril', 'Clearance', '', '', '', NULL, NULL, NULL, NULL, NULL, NULL, '', 'work purposes', 'work purposes', '2025-07-02 15:27:18', 'Approved', 0, 4, 0.00),
(47, 50, 'Rechel Gentiliso', 'Clearance', '', '', '', NULL, NULL, NULL, NULL, NULL, NULL, '', 'hjh', 'jkjk', '2025-07-03 10:20:14', 'Approved', 0, 4, 0.00),
(48, 32, 'Amiel Jake Baril', 'Barangay ID', '', '', '', '2004-04-09', 'Valenzuela General Hospital', 'Filipino', NULL, '', '', '', 'work purposes', 'work purposes', '2025-07-05 05:41:32', 'Approved', 0, 4, 0.00),
(49, 32, 'Amiel Jake Baril', 'First Time Job Seeker', '', '', '', '0000-00-00', '', '', NULL, '4th year college', 'Information Technology (IT)', '', 'work purposes', 'work purposes', '2025-07-05 05:44:28', 'Approved', 0, 4, 0.00),
(50, 32, 'Amiel Jake Baril', 'Clearance', '', '', '', '0000-00-00', '', '', NULL, '', '', '', 'work purposes', 'work purposes', '2025-07-05 05:46:51', 'Approved', 0, 4, 0.00),
(51, 32, 'Amiel Jake Baril', 'Residency', '', '', '', '0000-00-00', '', '', NULL, '', '', '', 'future purposes', 'future purposes', '2025-07-05 05:47:09', 'Rejected', 0, NULL, 0.00),
(55, 32, 'Amiel Jake Baril', 'Barangay ID', '', '', '', '2004-04-09', 'Valenzuela General Hospital', 'Filipino', NULL, '', '', '', 'work', 'work', '2025-07-05 07:03:57', 'Pending', 0, NULL, 0.00),
(56, 30, 'Jesse Barrera', 'First Time Job Seeker', '', '', '', '0000-00-00', '', '', NULL, 'College Graduated', 'Information Technology (IT)', '', 'work purposes', 'work purposes', '2025-07-05 07:06:16', 'Approved', 0, 4, 0.00),
(57, 30, 'Jesse Barrera', 'Barangay ID', '', '', '', '2000-11-11', 'Valenzuela General Hospital', 'Filipino', NULL, '', '', '', 'work', 'work', '2025-07-05 07:06:53', 'Approved', 0, 33, 0.00),
(58, 30, 'Jesse Barrera', 'Clearance', '', '', '', '0000-00-00', '', '', NULL, '', '', '', 'work ', 'work', '2025-07-05 07:09:31', 'Pending', 0, NULL, 0.00),
(59, 30, 'Jesse Barrera', 'Cedula', '', '', '111-111-111', '0000-00-00', '', '', NULL, '', '', 'Secuirty Guard', 'work', 'work', '2025-07-05 07:10:22', 'Approved', 0, 33, 0.00);

-- --------------------------------------------------------

--
-- Table structure for table `emergency_contacts`
--

CREATE TABLE `emergency_contacts` (
  `id` int(11) NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `uploaded_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `emergency_contacts`
--

INSERT INTO `emergency_contacts` (`id`, `image_path`, `uploaded_at`) VALUES
(1, 'emergency_contacts/BARANGAY-HOTLINE.png', '2025-07-19 09:15:50');

-- --------------------------------------------------------

--
-- Table structure for table `households`
--

CREATE TABLE `households` (
  `id` int(11) NOT NULL,
  `house_number` varchar(50) DEFAULT NULL,
  `head_of_family` varchar(100) DEFAULT NULL,
  `members` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `households`
--

INSERT INTO `households` (`id`, `house_number`, `head_of_family`, `members`, `created_at`) VALUES
(1, '12345', 'Amiel Jake Baril', '[\"Maricel Baril\",\"Ariel Baril\",\"Mariel Jean Baril\"]', '2025-07-02 11:37:45'),
(2, '13456', 'Christine Hieto', '[\"Charlene Hieto\",\"Che hieto\"]', '2025-07-02 11:45:25');

-- --------------------------------------------------------

--
-- Table structure for table `officials`
--

CREATE TABLE `officials` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `dob` date DEFAULT NULL,
  `pob` varchar(255) DEFAULT NULL,
  `age` int(11) DEFAULT NULL,
  `gender` enum('Male','Female') DEFAULT NULL,
  `civil_status` enum('Single','Married','Widow/Widower','Separated') DEFAULT NULL,
  `nationality` varchar(100) DEFAULT NULL,
  `religion` varchar(100) DEFAULT NULL,
  `position` varchar(100) NOT NULL,
  `term_start` date DEFAULT NULL,
  `term_end` date DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `email_off` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `officials`
--

INSERT INTO `officials` (`id`, `user_id`, `dob`, `pob`, `age`, `gender`, `civil_status`, `nationality`, `religion`, `position`, `term_start`, `term_end`, `address`, `phone`, `email_off`) VALUES
(2, 4, '2003-11-09', 'Valenzuela', 22, 'Female', 'Single', 'Philippines', 'INC', 'Secretary', '2024-09-04', '2026-09-04', 'San Pedro 6 Subdi JVC compound Emerald street tandang sora QC', '09858145011', 'chrstn1000011@gmail.com'),
(6, 33, '2004-04-09', 'QC', 21, 'Male', 'Single', 'Filipino', 'catholic', 'Kagawad', '2024-11-11', '2027-11-11', 'QC', '09123238585', 'lukechiang@gmail.com'),
(8, 64, '2001-01-01', 'Masbate', 24, 'Male', 'Single', 'Filipino', 'catholic', 'kagawad', '2025-07-17', '2026-07-17', 'Gaid', '09976723222', 'ricky@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `expires_at` datetime NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_logs`
--

CREATE TABLE `password_reset_logs` (
  `id` int(11) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `action` varchar(50) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `password_reset_logs`
--

INSERT INTO `password_reset_logs` (`id`, `email`, `action`, `created_at`) VALUES
(1, 'amieljake929@gmail.com', 'Password Updated', '2025-07-19 12:17:27'),
(2, 'amieljake929@gmail.com', 'Password Updated', '2025-07-19 12:21:24');

-- --------------------------------------------------------

--
-- Table structure for table `programs`
--

CREATE TABLE `programs` (
  `id` int(11) NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `uploaded_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `programs`
--

INSERT INTO `programs` (`id`, `image_path`, `uploaded_at`) VALUES
(1, 'programs/1.jpg', '2025-07-19 09:45:16'),
(2, 'programs/2.jpg', '2025-07-19 09:45:24'),
(3, 'programs/3.jpg', '2025-07-19 09:45:32'),
(4, 'programs/4.jpg', '2025-07-19 09:45:38');

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE `projects` (
  `id` int(11) NOT NULL,
  `project_name` varchar(100) DEFAULT NULL,
  `total_budget` decimal(10,2) DEFAULT NULL,
  `funds_received` decimal(10,2) DEFAULT NULL,
  `status` enum('Ongoing','Completed','Pending') DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `registered_residents`
--

CREATE TABLE `registered_residents` (
  `id` int(11) NOT NULL,
  `full_name` varchar(255) DEFAULT NULL,
  `nationality` varchar(100) DEFAULT NULL,
  `gender` varchar(10) DEFAULT NULL,
  `pob` varchar(255) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `current_address` text DEFAULT NULL,
  `civil_status` enum('Single','Married','Widowed','Separated','Divorced') DEFAULT NULL,
  `employment_status` varchar(100) DEFAULT NULL,
  `religion` varchar(100) DEFAULT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `family_members` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `valid_id` varchar(255) DEFAULT NULL,
  `face_token` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `registered_residents`
--

INSERT INTO `registered_residents` (`id`, `full_name`, `nationality`, `gender`, `pob`, `dob`, `current_address`, `civil_status`, `employment_status`, `religion`, `phone`, `email`, `family_members`, `created_at`, `valid_id`, `face_token`) VALUES
(3, 'Mariel Jean Baril', 'Filipino', 'Female', 'Valenzuela General Hospital', '2007-09-20', 'San Pedro 6 Tandang Sora QC', 'Single', 'Student', 'catholic', '09123238585', 'marieljeanbaril68@gmail.com', 'Maricel Baril, Ariel Baril, Amiel Jake Baril', '2025-07-16 12:01:39', 'uploads/valid_ids/687794a3e7729_76948092-fd84-4382-9d10-19e2c28de7bf.jfif', NULL),
(8, 'Amiel Jake Baril', 'Filipino', 'Male', 'Valenzuela General Hospital', '2004-04-09', 'Tandang Sora QC', 'Single', 'Student', 'catholic', '09978723222', 'amieljake929@gmail.com', 'Maricel Baril, Ariel Baril, Mariel Jean Baril', '2025-07-17 09:01:20', 'uploads/valid_ids/6878bbe0a71d3_686f5ce9f2279_422382314_289290157493547_4719265083204729881_n.jpg', NULL),
(9, 'Christian Sierra', 'Filipino', 'Male', 'Valenzuela General Hospital', '2002-11-11', 'tsora', 'Single', 'Student', 'catholic', '09978723222', 'sierramark971@gmail.com', 'Amiel', '2025-07-21 10:01:37', 'uploads/valid_ids/687e100165f52_518823347_1251972609754327_6658784571576155397_n.png', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `residents`
--

CREATE TABLE `residents` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `dob` date DEFAULT NULL,
  `pob` varchar(255) DEFAULT NULL,
  `age` int(11) DEFAULT NULL,
  `gender` enum('Male','Female') DEFAULT NULL,
  `civil_status` enum('Single','Married','Widow/Widower','Separated') DEFAULT NULL,
  `nationality` varchar(100) DEFAULT NULL,
  `religion` varchar(100) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `res_email` varchar(255) DEFAULT NULL,
  `resident_type` enum('Permanent','Temporary','Voter','Non-Voter') DEFAULT NULL,
  `stay_length` varchar(50) DEFAULT NULL,
  `proof` varchar(255) DEFAULT NULL,
  `date_registered` datetime DEFAULT current_timestamp(),
  `household_id` int(11) DEFAULT NULL,
  `employment_status` enum('Employed','Unemployed','Self-Employed','Student','Retired','Homemaker','Others') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `residents`
--

INSERT INTO `residents` (`id`, `user_id`, `dob`, `pob`, `age`, `gender`, `civil_status`, `nationality`, `religion`, `address`, `phone`, `res_email`, `resident_type`, `stay_length`, `proof`, `date_registered`, `household_id`, `employment_status`) VALUES
(34, 61, '2004-04-09', 'Valenzuela General Hospital', 21, 'Male', 'Single', 'Filipino', 'catholic', 'San Pedro 6 Subdi JVC compound Emerald street tandang sora QC', '09123238585', 'amieljake929@gmail.com', 'Permanent', '5', '', '2025-07-17 00:00:00', NULL, 'Student'),
(35, 66, '2007-09-20', 'Valenzuela General Hospital', 17, 'Female', 'Single', 'Filipino', 'catholic', 'San Pedro 6 Subdi JVC compound Emerald street tandang sora QC', '09858145011', 'marieljeanbaril68@gmail.com', 'Permanent', '5', '', '2025-07-19 00:00:00', NULL, 'Student'),
(36, 67, '2002-11-11', 'Valenzuela General Hospital', 24, 'Male', 'Single', 'Filipino', 'catholic', 'San Pedro 6 Subdi JVC compound Emerald street tandang sora QC', '09978723222', 'amieljake929@gmail.com', 'Permanent', '2', '', '2025-07-21 00:00:00', NULL, 'Student');

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `position` varchar(100) DEFAULT NULL,
  `date_started` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`id`, `user_id`, `address`, `phone`, `email`, `position`, `date_started`) VALUES
(1, 23, 'San Pedro 6 Subdi JVC compound Emerald street tandang sora QC', '09978723222', 'danielaberba@gmail.com', '', '2025-07-01');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('pending','approved') DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `full_name`, `email`, `password`, `role`, `created_at`, `status`) VALUES
(4, 'Christine Hieto', 'chrstn1000011@gmail.com', '$2y$10$o1c9klg4Fj9wG6memBiWw.lqqu2urxfN88EX.r9X5re7JPJ39TxfC', 'Official', '2025-05-24 03:13:07', 'approved'),
(23, 'Daniela Berba', 'danielaberba@gmail.com', '$2y$10$4U.Kp0DzYa7gQ/Je.z/qpe4uA4JKKvi3.zdOoUTE0FfygHzDsMNvK', 'Staff', '2025-07-01 04:43:59', 'approved'),
(31, 'Administrator', 'admin@example.com', '$2y$10$Pf9XPIwDEHT65BLkKRAUGeZ/qF/HsL2cTc7KhLYVfofWLmSdD4QGe', 'Admin', '2025-07-01 07:46:36', 'approved'),
(33, 'Luke Chiang', 'lukechiang@gmail.com', '$2y$10$EFpw3TB3MInM7HV5EnzAreYGbaz4QVJIYx0iF8G5s3jYw/56xS.ke', 'Official', '2025-07-01 11:40:34', 'approved'),
(61, 'Amiel Jake Baril', 'amieljake929@gmail.com', '$2y$10$W.RgNWlcaigHDY.YGJWeO.wcjJqu7/xDVLv8kkasd24enrv891vDC', 'Resident', '2025-07-17 09:23:08', 'approved'),
(64, 'Ricky Raymundo', 'ricky@gmail.com', '$2y$10$gp.ZLeyOjLcKwgS3P//26.0F.V/XheFzlkouw4qaWOHNx.0Qz4.AW', 'Official', '2025-07-17 05:36:29', 'approved'),
(65, 'John Kenneth Cardinal', 'johnkenneth@gmail.com', '$2y$10$.t1i4RusMSe6ywdQIRY4Ne5GKXxP.mcODeclO7BWiCnPL6zujc6NO', 'BPSO', '2025-07-17 05:39:04', 'approved'),
(66, 'Mariel Jean Baril', 'marieljeanbaril68@gmail.com', '$2y$10$qONAf2zbysIijqWKEgiqjOJ.cYAtKwL8aC.ntBrmj2HL2UrrXhxie', 'Resident', '2025-07-19 10:02:13', 'approved'),
(67, 'Christian Sierra', 'sierramark971@gmail.com', '$2y$10$v/HImHrVybRViFLs1eIt.e/Nxb.7rYD/znGQ1GqyzXHFRmwBCpbvq', 'Resident', '2025-07-21 10:03:14', 'approved');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activities`
--
ALTER TABLE `activities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `announcements`
--
ALTER TABLE `announcements`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `announcements2`
--
ALTER TABLE `announcements2`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `blotter_reports`
--
ALTER TABLE `blotter_reports`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user` (`residents_id`);

--
-- Indexes for table `bpso`
--
ALTER TABLE `bpso`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `budget_allocations`
--
ALTER TABLE `budget_allocations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `committee_images`
--
ALTER TABLE `committee_images`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `community_reports`
--
ALTER TABLE `community_reports`
  ADD PRIMARY KEY (`report_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `document_requests`
--
ALTER TABLE `document_requests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `emergency_contacts`
--
ALTER TABLE `emergency_contacts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `households`
--
ALTER TABLE `households`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `officials`
--
ALTER TABLE `officials`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_logs`
--
ALTER TABLE `password_reset_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `programs`
--
ALTER TABLE `programs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `registered_residents`
--
ALTER TABLE `registered_residents`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `residents`
--
ALTER TABLE `residents`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activities`
--
ALTER TABLE `activities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `announcements`
--
ALTER TABLE `announcements`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `announcements2`
--
ALTER TABLE `announcements2`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `blotter_reports`
--
ALTER TABLE `blotter_reports`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `bpso`
--
ALTER TABLE `bpso`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `budget_allocations`
--
ALTER TABLE `budget_allocations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `committee_images`
--
ALTER TABLE `committee_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `community_reports`
--
ALTER TABLE `community_reports`
  MODIFY `report_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `document_requests`
--
ALTER TABLE `document_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT for table `emergency_contacts`
--
ALTER TABLE `emergency_contacts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `households`
--
ALTER TABLE `households`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `officials`
--
ALTER TABLE `officials`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `password_resets`
--
ALTER TABLE `password_resets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `password_reset_logs`
--
ALTER TABLE `password_reset_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `programs`
--
ALTER TABLE `programs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `registered_residents`
--
ALTER TABLE `registered_residents`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `residents`
--
ALTER TABLE `residents`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `blotter_reports`
--
ALTER TABLE `blotter_reports`
  ADD CONSTRAINT `fk_user` FOREIGN KEY (`residents_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `bpso`
--
ALTER TABLE `bpso`
  ADD CONSTRAINT `bpso_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `community_reports`
--
ALTER TABLE `community_reports`
  ADD CONSTRAINT `community_reports_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `residents` (`user_id`);

--
-- Constraints for table `officials`
--
ALTER TABLE `officials`
  ADD CONSTRAINT `officials_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `residents`
--
ALTER TABLE `residents`
  ADD CONSTRAINT `residents_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `staff`
--
ALTER TABLE `staff`
  ADD CONSTRAINT `staff_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
