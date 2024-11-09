-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 09, 2024 at 06:22 AM
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
-- Database: `portfolio`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `name`, `email`, `password`, `created_at`) VALUES
(1, 'Roby Jay Pastores', 'robipastores@gmail.com', '$2y$10$pP229pQcIn0dUbmrmnuBSezwmVlQ9jRTR20h8b2yd1UHq9ckmOOL2', '2024-10-21 06:36:22');

-- --------------------------------------------------------

--
-- Table structure for table `contacts`
--

CREATE TABLE `contacts` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contacts`
--

INSERT INTO `contacts` (`id`, `name`, `email`, `message`, `created_at`) VALUES
(1, 'Roby Jay Pastores', 'robipastores@gmail.com', 'test4', '2024-10-21 12:38:22'),
(2, 'Roby Jay Pastores', 'supremorobi20@gmail.com', 'robi20', '2024-10-21 12:41:16'),
(3, 'Jonathan Marte', 'nthnmrt@gmail.com', 'kalbo', '2024-10-21 12:42:06'),
(4, 'Roby Jay Pastores', 'supremorobi20@gmail.com', 'trs', '2024-10-21 12:51:11'),
(5, 'Jennilyn Pastores', 'jennilynpastores@gmail.com', 'Hi Robi', '2024-10-21 14:00:52'),
(6, 'Roby Jay Pastores', 'supremorobi20@gmail.com', 'hey', '2024-10-27 08:12:22');

-- --------------------------------------------------------

--
-- Table structure for table `contact_messages`
--

CREATE TABLE `contact_messages` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE `projects` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `image` varchar(255) NOT NULL,
  `programming_language` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`id`, `title`, `description`, `image`, `programming_language`, `created_at`) VALUES
(1, 'Employee Attendance with Payroll System', 'Employee Attendance with Payroll System', 'uploads/NP dashboard.JPG', 'PHP, Mysql, Javascript, Tailwind Css', '2024-10-21 07:36:12'),
(2, 'Grocery Point of Sales with Inventory System', 'Grocery Point of Sales with Inventory System', 'uploads/POS.JPG', 'PHP, Mysql, Javascript, Tailwind Css', '2024-10-21 07:59:46'),
(3, 'Web App Hotel Booking Management System', 'Online Web App Hotel Booking Management System', 'uploads/Hotel.JPG', 'PHP, Mysql, Javascript, React JS, Tailwind Css', '2024-10-21 08:12:57'),
(4, 'Help Desk ticketing System', 'Help Desk ticketing System', 'uploads/ticketsystem.JPG', 'PHP, Mysql, Javascript, React JS, Tailwind Css', '2024-10-21 08:14:14'),
(5, 'Complete Coffee Shop POS with Inventory and Live Notifications System', 'Coffee Shop POS', 'uploads/Admin Dashboard.JPG', 'PHP, Mysql, Javascript, React JS, Tailwind Css', '2024-10-27 09:16:25'),
(8, 'Motorcycle E-commerce Shop with POS and Email Verifications', 'Motorcycle E-commerce Shop with POS and Email Verifications', 'uploads/Landing page.JPG', 'PHP, Mysql, Javascript, React JS, Tailwind Css', '2024-11-09 05:17:27'),
(9, 'School Learning Management with AI Integrated and Email Notifcations System', 'School Learning Management with AI Integrated and Email Notifcations System', 'uploads/index page.JPG', 'PHP, Mysql, Javascript, React JS, Tailwind Css', '2024-11-09 05:19:09');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contact_messages`
--
ALTER TABLE `contact_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `contact_messages`
--
ALTER TABLE `contact_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
