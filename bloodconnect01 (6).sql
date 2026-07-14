-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 14, 2026 at 05:22 PM
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
-- Database: `bloodconnect01`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity_logs`
--

CREATE TABLE `activity_logs` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `user_name` varchar(255) DEFAULT NULL,
  `action` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `type` varchar(50) DEFAULT 'INFO',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `activity_logs`
--

INSERT INTO `activity_logs` (`id`, `user_id`, `user_name`, `action`, `message`, `type`, `created_at`) VALUES
(1, 58, 'dardarwinnhtet', 'BLOOD_REQUEST_CREATED', 'New blood request REQ20260705234309 was submitted by patient.', 'INFO', '2026-07-05 17:13:09'),
(2, 57, 'Admin', 'USER_LOGIN', 'Admin logged in to system', 'info', '2026-07-05 17:21:24'),
(3, 58, 'dardar', 'USER_LOGIN', 'dardar logged in to system', 'info', '2026-07-05 17:22:28'),
(4, 57, 'Admin', 'USER_LOGIN', 'Admin logged in to system', 'info', '2026-07-05 17:22:42'),
(5, 57, 'Admin', 'USER_LOGIN', 'Admin logged in to system', 'info', '2026-07-05 17:25:44'),
(6, 58, 'dardar', 'USER_LOGIN', 'dardar logged in to system', 'info', '2026-07-05 17:26:28'),
(7, 58, 'dardar', 'BLOOD_REQUEST_CREATED', 'New blood request REQ20260705235644 was submitted by patient.', 'INFO', '2026-07-05 17:26:44'),
(8, 57, 'Admin', 'USER_LOGIN', 'Admin logged in to system', 'info', '2026-07-05 17:27:03'),
(9, 58, 'dardar', 'USER_LOGIN', 'dardar logged in to system', 'info', '2026-07-05 17:27:50'),
(10, 57, 'Admin', 'USER_LOGIN', 'Admin logged in to system', 'info', '2026-07-05 17:28:16'),
(11, 57, 'Admin', 'BLOOD_REQUEST_CREATED', 'New blood request REQ20260705235946 was submitted by patient.', 'INFO', '2026-07-05 17:29:46'),
(12, 57, 'Admin', 'USER_LOGIN', 'Admin logged in to system', 'info', '2026-07-05 18:40:29'),
(13, 59, 'kk', 'USER_LOGIN', 'kk logged in to system', 'info', '2026-07-06 02:56:07'),
(14, 59, 'kk', 'BLOOD_REQUEST_CREATED', 'New blood request REQ20260706092626 was submitted by patient.', 'INFO', '2026-07-06 02:56:26'),
(15, 59, 'kk', 'USER_LOGIN', 'kk logged in to system', 'info', '2026-07-06 02:57:15'),
(16, 59, 'kk', 'USER_LOGIN', 'kk logged in to system', 'info', '2026-07-06 02:58:32'),
(17, 57, 'Admin', 'USER_LOGIN', 'Admin logged in to system', 'info', '2026-07-06 02:59:08'),
(18, 60, 'dd', 'USER_LOGIN', 'dd logged in to system', 'info', '2026-07-06 03:56:26'),
(19, 60, 'dd', 'BLOOD_REQUEST_CREATED', 'New blood request REQ20260706102643 was submitted by patient.', 'INFO', '2026-07-06 03:56:43'),
(20, 57, 'Admin', 'USER_LOGIN', 'Admin logged in to system', 'info', '2026-07-06 03:57:28'),
(21, 57, 'Admin', 'USER_LOGIN', 'Admin logged in to system', 'info', '2026-07-06 04:32:39'),
(22, 60, 'dar dar', 'USER_LOGIN', 'dar dar logged in to system', 'info', '2026-07-06 05:10:56'),
(23, 57, 'Admin', 'USER_LOGIN', 'Admin logged in to system', 'info', '2026-07-06 05:19:37'),
(24, 61, 'kk', 'USER_LOGIN', 'kk logged in to system', 'info', '2026-07-06 05:26:00'),
(25, 61, 'kk', 'BLOOD_REQUEST_CREATED', 'New blood request REQ20260706115614 was submitted by patient.', 'INFO', '2026-07-06 05:26:14'),
(26, 57, 'Admin', 'USER_LOGIN', 'Admin logged in to system', 'info', '2026-07-06 05:27:02'),
(27, 61, 'kk', 'USER_LOGIN', 'kk logged in to system', 'info', '2026-07-06 06:23:54'),
(28, 57, 'Admin', 'USER_LOGIN', 'Admin logged in to system', 'info', '2026-07-06 06:24:16'),
(29, 61, 'kk', 'USER_LOGIN', 'kk logged in to system', 'info', '2026-07-06 06:30:03'),
(30, 57, 'Admin', 'USER_LOGIN', 'Admin logged in to system', 'info', '2026-07-06 06:30:34'),
(31, 60, 'dar dar', 'USER_LOGIN', 'dar dar logged in to system', 'info', '2026-07-06 06:31:11'),
(32, 57, 'Admin', 'USER_LOGIN', 'Admin logged in to system', 'info', '2026-07-06 06:31:27'),
(33, 62, 'bunny', 'USER_LOGIN', 'bunny logged in to system', 'info', '2026-07-06 06:33:16'),
(34, 62, 'bunny', 'BLOOD_REQUEST_CREATED', 'New blood request REQ20260706130338 was submitted by patient.', 'INFO', '2026-07-06 06:33:38'),
(35, 57, 'Admin', 'USER_LOGIN', 'Admin logged in to system', 'info', '2026-07-06 06:34:04'),
(36, 62, 'bunny', 'USER_LOGIN', 'bunny logged in to system', 'info', '2026-07-06 06:39:31'),
(37, 57, 'Admin', 'USER_LOGIN', 'Admin logged in to system', 'info', '2026-07-06 06:40:08'),
(38, 60, 'dar dar', 'USER_LOGIN', 'dar dar logged in to system', 'info', '2026-07-06 06:40:35'),
(39, 57, 'Admin', 'USER_LOGIN', 'Admin logged in to system', 'info', '2026-07-06 06:41:20'),
(40, 61, 'kk', 'USER_LOGIN', 'kk logged in to system', 'info', '2026-07-06 06:43:25'),
(41, 61, 'kk', 'USER_LOGIN', 'kk logged in to system', 'info', '2026-07-06 06:55:11'),
(42, 61, 'kk', 'BLOOD_REQUEST_CREATED', 'New blood request REQ20260706132529 was submitted by patient.', 'INFO', '2026-07-06 06:55:29'),
(43, 61, 'kk', 'BLOOD_REQUEST_CREATED', 'New blood request REQ20260706132912 was submitted by patient.', 'INFO', '2026-07-06 06:59:12'),
(44, 61, 'kk', 'BLOOD_REQUEST_CREATED', 'New blood request REQ20260706162123 was submitted by patient.', 'INFO', '2026-07-06 09:51:23'),
(45, 61, 'kk', 'BLOOD_REQUEST_CREATED', 'New blood request REQ20260706162711 was submitted by patient.', 'INFO', '2026-07-06 09:57:11'),
(46, 57, 'Admin', 'USER_LOGIN', 'Admin logged in to system', 'info', '2026-07-06 10:08:27'),
(47, 61, 'kk', 'BLOOD_REQUEST_CREATED', 'New blood request REQ20260706163934 was submitted by patient.', 'INFO', '2026-07-06 10:09:34'),
(48, 61, 'kk', 'BLOOD_REQUEST_CREATED', 'New blood request REQ20260706164236 was submitted by patient.', 'INFO', '2026-07-06 10:12:36'),
(49, 57, 'Admin', 'USER_LOGIN', 'Admin logged in to system', 'info', '2026-07-06 14:39:00'),
(50, 60, 'dar dar', 'USER_LOGIN', 'dar dar logged in to system', 'info', '2026-07-06 15:20:05'),
(51, 60, 'dar dar', 'BLOOD_REQUEST_CREATED', 'New blood request REQ20260706215112 was submitted by patient.', 'INFO', '2026-07-06 15:21:12'),
(52, 60, 'dar dar', 'BLOOD_REQUEST_CREATED', 'New blood request REQ20260706220348 was submitted by patient.', 'INFO', '2026-07-06 15:33:48'),
(53, 60, 'dar dar', 'BLOOD_REQUEST_CREATED', 'New blood request REQ20260706224057 was submitted by patient.', 'INFO', '2026-07-06 16:10:57'),
(54, 60, 'dar dar', 'BLOOD_REQUEST_CREATED', 'New blood request REQ20260706225205 was submitted by patient.', 'INFO', '2026-07-06 16:22:05'),
(55, 62, 'bunny', 'USER_LOGIN', 'bunny logged in to system', 'info', '2026-07-06 16:51:00'),
(56, 62, 'bb', 'USER_LOGIN', 'bb logged in to system', 'info', '2026-07-06 16:52:00'),
(57, 62, 'bb', 'BLOOD_REQUEST_CREATED', 'New blood request REQ20260706232233 was submitted by patient.', 'INFO', '2026-07-06 16:52:33'),
(58, 62, 'bb', 'BLOOD_REQUEST_CREATED', 'New blood request REQ20260706232256 was submitted by patient.', 'INFO', '2026-07-06 16:52:56'),
(59, 62, 'bb', 'BLOOD_REQUEST_CREATED', 'New blood request REQ20260706232358 was submitted by patient.', 'INFO', '2026-07-06 16:53:58'),
(60, 62, 'bb', 'BLOOD_REQUEST_CREATED', 'New blood request REQ20260706234850 was submitted by patient.', 'INFO', '2026-07-06 17:18:50'),
(61, 63, 'dardarwinnhtet', 'USER_LOGIN', 'dardarwinnhtet logged in to system', 'info', '2026-07-06 17:36:39'),
(62, 63, 'dardarwinnhtet', 'BLOOD_REQUEST_CREATED', 'New blood request REQ20260707000718 was submitted by patient.', 'INFO', '2026-07-06 17:37:18'),
(63, 63, 'dardarwinnhtet', 'USER_LOGIN', 'dardarwinnhtet logged in to system', 'info', '2026-07-06 17:40:33'),
(64, 57, 'Admin', 'USER_LOGIN', 'Admin logged in to system', 'info', '2026-07-06 17:42:04'),
(65, 63, 'dardarwinnhtet', 'BLOOD_REQUEST_CREATED', 'New blood request REQ20260707001339 was submitted by patient.', 'INFO', '2026-07-06 17:43:39'),
(66, 64, 'bunny', 'USER_LOGIN', 'bunny logged in to system', 'info', '2026-07-06 18:26:30'),
(67, 64, 'bunny', 'USER_LOGIN', 'bunny logged in to system', 'info', '2026-07-06 18:31:48'),
(68, 64, 'bunny', 'USER_LOGIN', 'bunny logged in to system', 'info', '2026-07-07 03:03:14'),
(69, 64, 'bunny', 'USER_LOGIN', 'bunny logged in to system', 'info', '2026-07-07 03:54:32'),
(70, 64, 'bunny', 'USER_LOGIN', 'bunny logged in to system', 'info', '2026-07-07 04:23:34'),
(71, 64, 'bunny', 'USER_LOGIN', 'bunny logged in to system', 'info', '2026-07-07 04:26:50'),
(72, 64, 'bunny', 'USER_LOGIN', 'bunny logged in to system', 'info', '2026-07-07 04:58:26'),
(73, 64, 'bunny', 'USER_LOGIN', 'bunny logged in to system', 'info', '2026-07-07 05:05:25'),
(74, 65, 'dardarwinnhtet', 'USER_LOGIN', 'dardarwinnhtet logged in to system', 'info', '2026-07-07 05:13:28'),
(75, 65, 'dardarwinnhtet', 'USER_LOGIN', 'dardarwinnhtet logged in to system', 'info', '2026-07-07 05:16:23'),
(76, 66, 'kk', 'USER_LOGIN', 'kk logged in to system', 'info', '2026-07-07 05:30:24'),
(77, 65, 'dardar', 'USER_LOGIN', 'dardar logged in to system', 'info', '2026-07-07 06:38:41'),
(78, 67, 'dardarwinnhtet', 'USER_LOGIN', 'dardarwinnhtet logged in to system', 'info', '2026-07-07 07:31:05'),
(79, 67, 'dardarwinnhtet', 'BLOOD_REQUEST_CREATED', 'New blood request REQ20260707140124 was submitted by patient.', 'INFO', '2026-07-07 07:31:24'),
(80, 68, 'kk', 'USER_LOGIN', 'kk logged in to system', 'info', '2026-07-07 07:33:34'),
(81, 67, 'dardarwinnhtet', 'BLOOD_REQUEST_CREATED', 'New blood request REQ20260707140407 was submitted by patient.', 'INFO', '2026-07-07 07:34:07'),
(82, 57, 'Admin', 'USER_LOGIN', 'Admin logged in to system', 'info', '2026-07-07 07:35:29'),
(83, 68, 'kk', 'USER_LOGIN', 'kk logged in to system', 'info', '2026-07-07 07:43:38'),
(84, 67, 'dardarwinnhtet', 'BLOOD_REQUEST_CREATED', 'New blood request REQ20260707141745 was submitted by patient.', 'INFO', '2026-07-07 07:47:45'),
(85, 67, 'dardarwinnhtet', 'USER_LOGIN', 'dardarwinnhtet logged in to system', 'info', '2026-07-07 09:20:53'),
(86, 69, 'dardarwinnhtet', 'USER_LOGIN', 'dardarwinnhtet logged in to system', 'info', '2026-07-07 09:29:36'),
(87, 69, 'dardarwinnhtet', 'BLOOD_REQUEST_CREATED', 'Blood request REQ20260707161950 created', 'INFO', '2026-07-07 09:49:50'),
(88, 70, 'kk', 'USER_LOGIN', 'kk logged in to system', 'info', '2026-07-07 09:51:07'),
(89, 57, 'Admin', 'USER_LOGIN', 'Admin logged in to system', 'info', '2026-07-07 10:10:22'),
(90, 70, 'kk', 'USER_LOGIN', 'kk logged in to system', 'info', '2026-07-07 10:14:43'),
(91, 57, 'Admin', 'USER_LOGIN', 'Admin logged in to system', 'info', '2026-07-07 10:28:37'),
(92, 69, 'dardarwinnhtet1', 'USER_LOGIN', 'dardarwinnhtet1 logged in to system', 'info', '2026-07-07 10:32:43'),
(93, 70, 'kkkkkkkkkkkk', 'USER_LOGIN', 'kkkkkkkkkkkk logged in to system', 'info', '2026-07-07 10:33:21'),
(94, 57, 'Admin', 'USER_LOGIN', 'Admin logged in to system', 'info', '2026-07-07 10:36:29'),
(95, 70, 'kkkkkkkkkkkk', 'USER_LOGIN', 'kkkkkkkkkkkk logged in to system', 'info', '2026-07-07 10:40:51'),
(96, 69, 'dardarwinnhtet1', 'USER_LOGIN', 'dardarwinnhtet1 logged in to system', 'info', '2026-07-07 10:42:10'),
(97, 69, 'dardarwinnhtet1', 'BLOOD_REQUEST_CREATED', 'Blood request REQ20260707171227 created', 'INFO', '2026-07-07 10:42:27'),
(98, 69, 'dardarwinnhtet1', 'BLOOD_REQUEST_CREATED', 'Blood request REQ20260707171315 created', 'INFO', '2026-07-07 10:43:15'),
(99, 69, 'dardarwinnhtet1', 'BLOOD_REQUEST_CREATED', 'Blood request REQ20260707171453 created', 'INFO', '2026-07-07 10:44:53'),
(100, 69, 'dardarwinnhtet1', 'BLOOD_REQUEST_CREATED', 'Blood request REQ20260707171517 created', 'INFO', '2026-07-07 10:45:17'),
(101, 70, 'kay', 'USER_LOGIN', 'kay logged in to system', 'info', '2026-07-07 10:59:12'),
(102, 69, 'dardarwinnhtet1', 'USER_LOGIN', 'dardarwinnhtet1 logged in to system', 'info', '2026-07-07 11:00:03'),
(103, 57, 'Admin', 'USER_LOGIN', 'Admin logged in to system', 'info', '2026-07-07 11:06:59'),
(104, 57, 'Admin', 'USER_LOGIN', 'Admin logged in to system', 'info', '2026-07-07 13:55:32'),
(105, 70, 'kay', 'USER_LOGIN', 'kay logged in to system', 'info', '2026-07-07 14:04:06'),
(106, 69, 'dardarwinnhtet1', 'USER_LOGIN', 'dardarwinnhtet1 logged in to system', 'info', '2026-07-07 14:07:35'),
(107, 70, 'kay', 'USER_LOGIN', 'kay logged in to system', 'info', '2026-07-07 14:25:42'),
(108, 57, 'Admin', 'USER_LOGIN', 'Admin logged in to system', 'info', '2026-07-07 15:23:09'),
(109, 57, 'Admin', 'USER_LOGIN', 'Admin logged in to system', 'info', '2026-07-07 17:38:17'),
(110, 57, 'Admin', 'USER_LOGIN', 'Admin logged in to system', 'info', '2026-07-07 18:03:19'),
(111, 69, 'dardarwinnhtet1', 'USER_LOGIN', 'dardarwinnhtet1 logged in to system', 'info', '2026-07-07 18:10:36'),
(112, 69, 'dardarwinnhtet1', 'BLOOD_REQUEST_CREATED', 'Blood request REQ20260708004052 created', 'INFO', '2026-07-07 18:10:52'),
(113, 57, 'Admin', 'USER_LOGIN', 'Admin logged in to system', 'info', '2026-07-07 18:40:54'),
(114, 57, 'Admin', 'USER_LOGIN', 'Admin logged in to system', 'info', '2026-07-08 02:40:28'),
(115, 70, 'kay', 'USER_LOGIN', 'kay logged in to system', 'info', '2026-07-08 02:47:11'),
(116, 70, 'kay', 'USER_LOGIN', 'kay logged in to system', 'info', '2026-07-08 02:47:47'),
(117, 70, 'kay', 'USER_LOGIN', 'kay logged in to system', 'info', '2026-07-08 02:48:32'),
(118, 70, 'kay', 'USER_LOGIN', 'kay logged in to system', 'info', '2026-07-08 02:49:11'),
(119, 70, 'kay', 'USER_LOGIN', 'kay logged in to system', 'info', '2026-07-08 02:58:38'),
(120, 70, 'kay', 'USER_LOGIN', 'kay logged in to system', 'info', '2026-07-08 03:02:10'),
(121, 70, 'kay', 'USER_LOGIN', 'kay logged in to system', 'info', '2026-07-08 03:02:36'),
(122, 70, 'kay', 'USER_LOGIN', 'kay logged in to system', 'info', '2026-07-08 03:03:17'),
(123, 70, 'kay', 'USER_LOGIN', 'kay logged in to system', 'info', '2026-07-08 03:10:42'),
(124, 70, 'kay', 'USER_LOGIN', 'kay logged in to system', 'info', '2026-07-08 03:14:28'),
(125, 70, 'kay', 'USER_LOGIN', 'kay logged in to system', 'info', '2026-07-08 03:20:28'),
(126, 70, 'kay', 'USER_LOGIN', 'kay logged in to system', 'info', '2026-07-08 03:21:22'),
(127, 70, 'kay', 'USER_LOGIN', 'kay logged in to system', 'info', '2026-07-08 03:27:24'),
(128, 72, 'mm', 'USER_LOGIN', 'mm logged in to system', 'info', '2026-07-08 03:40:13'),
(129, 72, 'mm', 'BLOOD_REQUEST_CREATED', 'Blood request REQ20260708101033 created', 'INFO', '2026-07-08 03:40:33'),
(130, 57, 'Admin', 'USER_LOGIN', 'Admin logged in to system', 'info', '2026-07-08 03:40:57'),
(131, 71, 'mm', 'USER_LOGIN', 'mm logged in to system', 'info', '2026-07-08 03:42:19'),
(132, 72, 'mm', 'USER_LOGIN', 'mm logged in to system', 'info', '2026-07-08 03:46:24'),
(133, 71, 'mm', 'USER_LOGIN', 'mm logged in to system', 'info', '2026-07-08 03:53:02'),
(134, 57, 'Admin', 'USER_LOGIN', 'Admin logged in to system', 'info', '2026-07-08 04:01:56'),
(135, 72, 'mm', 'USER_LOGIN', 'mm logged in to system', 'info', '2026-07-08 04:02:26'),
(136, 57, 'Admin', 'USER_LOGIN', 'Admin logged in to system', 'info', '2026-07-08 04:02:51'),
(137, 72, 'mm', 'USER_LOGIN', 'mm logged in to system', 'info', '2026-07-08 04:04:53'),
(138, 72, 'mm', 'USER_LOGIN', 'mm logged in to system', 'info', '2026-07-08 04:05:30'),
(139, 57, 'Admin', 'USER_LOGIN', 'Admin logged in to system', 'info', '2026-07-08 04:06:06'),
(140, 70, 'kay', 'USER_LOGIN', 'kay logged in to system', 'info', '2026-07-08 04:34:31'),
(141, 70, 'kay', 'USER_LOGIN', 'kay logged in to system', 'info', '2026-07-08 04:44:31'),
(142, 70, 'kay', 'USER_LOGIN', 'kay logged in to system', 'info', '2026-07-08 04:45:53'),
(143, 70, 'kay', 'USER_LOGIN', 'kay logged in to system', 'info', '2026-07-08 04:46:47'),
(144, 72, 'mm', 'USER_LOGIN', 'mm logged in to system', 'info', '2026-07-08 04:50:33'),
(145, 72, 'mm', 'USER_LOGIN', 'mm logged in to system', 'info', '2026-07-08 04:52:05'),
(146, 70, 'kay', 'USER_LOGIN', 'kay logged in to system', 'info', '2026-07-08 05:00:22'),
(147, 72, 'mm', 'USER_LOGIN', 'mm logged in to system', 'info', '2026-07-08 05:00:46'),
(148, 72, 'mm', 'USER_LOGIN', 'mm logged in to system', 'info', '2026-07-08 05:34:13'),
(149, 72, 'mm', 'USER_LOGIN', 'mm logged in to system', 'info', '2026-07-08 05:43:17'),
(150, 72, 'may', 'BLOOD_REQUEST_CREATED', 'Blood request REQ20260708132527 created', 'INFO', '2026-07-08 06:55:27'),
(151, 73, 'judy', 'USER_LOGIN', 'judy logged in to system', 'info', '2026-07-08 06:57:07'),
(152, 74, 'akarilay', 'USER_LOGIN', 'akarilay logged in to system', 'info', '2026-07-08 07:11:54'),
(153, 74, 'akarilay', 'BLOOD_REQUEST_CREATED', 'Blood request REQ20260708134218 created', 'INFO', '2026-07-08 07:12:19'),
(154, 75, 'hsumyatakari', 'USER_LOGIN', 'hsumyatakari logged in to system', 'info', '2026-07-08 07:13:45'),
(155, 75, 'hsumyatakari', 'USER_LOGIN', 'hsumyatakari logged in to system', 'info', '2026-07-08 07:17:14'),
(156, 74, 'akarilay', 'BLOOD_REQUEST_CREATED', 'Blood request REQ20260708134812 created', 'INFO', '2026-07-08 07:18:12'),
(157, 74, 'akarilay', 'BLOOD_REQUEST_CREATED', 'Blood request REQ20260708135434 created', 'INFO', '2026-07-08 07:24:34'),
(158, 74, 'akarilay', 'BLOOD_REQUEST_CREATED', 'Blood request REQ20260708140129 created', 'INFO', '2026-07-08 07:31:29'),
(159, 74, 'akarilay', 'BLOOD_REQUEST_CREATED', 'Blood request REQ20260708142435 created', 'INFO', '2026-07-08 07:54:35'),
(160, 74, 'akarilay', 'BLOOD_REQUEST_CREATED', 'Blood request REQ20260708142827 created', 'INFO', '2026-07-08 07:58:27'),
(161, 74, 'akarilay', 'BLOOD_REQUEST_CREATED', 'Blood request REQ20260708152349 created', 'INFO', '2026-07-08 08:53:49'),
(162, 57, 'Admin', 'USER_LOGIN', 'Admin logged in to system', 'info', '2026-07-08 09:25:47'),
(163, 74, 'akarilay', 'BLOOD_REQUEST_CREATED', 'Blood request REQ20260708162617 created', 'INFO', '2026-07-08 09:56:17'),
(164, 74, 'akarilay', 'BLOOD_REQUEST_CREATED', 'Blood request REQ20260708162654 created', 'INFO', '2026-07-08 09:56:54'),
(165, 74, 'akarilay', 'BLOOD_REQUEST_CREATED', 'Blood request REQ20260708163118 created', 'INFO', '2026-07-08 10:01:18'),
(166, 74, 'akarilay', 'BLOOD_REQUEST_CREATED', 'Blood request REQ20260708163841 created', 'INFO', '2026-07-08 10:08:41'),
(167, 57, 'Admin', 'USER_LOGIN', 'Admin logged in to system', 'info', '2026-07-08 10:12:48'),
(168, 57, 'Admin', 'USER_LOGIN', 'Admin logged in to system', 'info', '2026-07-08 10:45:33'),
(169, 57, 'Admin', 'USER_LOGIN', 'Admin logged in to system', 'info', '2026-07-08 15:37:22'),
(170, 74, 'akarilay', 'USER_LOGIN', 'akarilay logged in to system', 'info', '2026-07-08 16:02:53'),
(171, 77, 'kk', 'USER_LOGIN', 'kk logged in to system', 'info', '2026-07-08 16:42:02'),
(172, 77, 'kk', 'BLOOD_REQUEST_CREATED', 'Blood request REQ20260708231304 created', 'INFO', '2026-07-08 16:43:04'),
(173, 78, 'dd', 'USER_LOGIN', 'dd logged in to system', 'info', '2026-07-08 16:45:19'),
(174, 77, 'kk', 'BLOOD_REQUEST_CREATED', 'Blood request REQ20260708232910 created', 'INFO', '2026-07-08 16:59:10'),
(175, 77, 'kay', 'BLOOD_REQUEST_CREATED', 'Blood request REQ20260708234301 created', 'INFO', '2026-07-08 17:13:01'),
(176, 77, 'kayy', 'BLOOD_REQUEST_CREATED', 'Blood request REQ20260709002452 created', 'INFO', '2026-07-08 17:54:52'),
(177, 57, 'Admin', 'USER_LOGIN', 'Admin logged in to system', 'info', '2026-07-09 02:44:01'),
(178, 74, 'akarilay', 'USER_LOGIN', 'akarilay logged in to system', 'info', '2026-07-09 02:45:25'),
(179, 79, 'nick', 'USER_LOGIN', 'nick logged in to system', 'info', '2026-07-09 02:47:52'),
(180, 74, 'akarilay', 'BLOOD_REQUEST_CREATED', 'Blood request REQ20260709091944 created', 'INFO', '2026-07-09 02:49:44'),
(181, 74, 'akarilay', 'BLOOD_REQUEST_CREATED', 'Blood request REQ20260709092426 created', 'INFO', '2026-07-09 02:54:26'),
(182, 74, 'akarilay', 'BLOOD_REQUEST_CREATED', 'Blood request REQ20260709092447 created', 'INFO', '2026-07-09 02:54:47'),
(183, 78, 'darr', 'USER_LOGIN', 'darr logged in to system', 'info', '2026-07-09 02:57:39'),
(184, 74, 'akarilay', 'BLOOD_REQUEST_CREATED', 'Blood request REQ20260709092928 created', 'INFO', '2026-07-09 02:59:28'),
(185, 74, 'akarilay', 'BLOOD_REQUEST_CREATED', 'Blood request REQ20260709093131 created', 'INFO', '2026-07-09 03:01:31'),
(186, 74, 'akarilay', 'BLOOD_REQUEST_CREATED', 'Blood request REQ20260709093611 created', 'INFO', '2026-07-09 03:06:11'),
(187, 74, 'akarilay', 'BLOOD_REQUEST_CREATED', 'Blood request REQ20260709095641 created', 'INFO', '2026-07-09 03:26:41'),
(188, 74, 'akarilay', 'BLOOD_REQUEST_CREATED', 'Blood request REQ20260709095919 created', 'INFO', '2026-07-09 03:29:19'),
(189, 78, 'darr', 'USER_LOGIN', 'darr logged in to system', 'info', '2026-07-09 03:51:19'),
(190, 57, 'Admin', 'USER_LOGIN', 'Admin logged in to system', 'info', '2026-07-09 03:51:49'),
(191, 78, 'darr', 'USER_LOGIN', 'darr logged in to system', 'info', '2026-07-09 03:52:12'),
(192, 57, 'Admin', 'USER_LOGIN', 'Admin logged in to system', 'info', '2026-07-09 03:53:41'),
(193, 78, 'darr', 'USER_LOGIN', 'darr logged in to system', 'info', '2026-07-09 03:54:28'),
(194, 73, 'judy', 'USER_LOGIN', 'judy logged in to system', 'info', '2026-07-09 03:56:27'),
(195, 78, 'darr', 'USER_LOGIN', 'darr logged in to system', 'info', '2026-07-09 03:56:56'),
(196, 73, 'judy', 'USER_LOGIN', 'judy logged in to system', 'info', '2026-07-09 03:57:18'),
(197, 78, 'darr', 'USER_LOGIN', 'darr logged in to system', 'info', '2026-07-09 03:58:15'),
(198, 57, 'Admin', 'USER_LOGIN', 'Admin logged in to system', 'info', '2026-07-09 03:58:47'),
(199, 78, 'darr', 'USER_LOGIN', 'darr logged in to system', 'info', '2026-07-09 03:59:09'),
(200, 57, 'Admin', 'USER_LOGIN', 'Admin logged in to system', 'info', '2026-07-09 04:05:42'),
(201, 74, 'akarilay', 'BLOOD_REQUEST_CREATED', 'Blood request REQ20260709104411 created', 'INFO', '2026-07-09 04:14:11'),
(202, 74, 'akarilay', 'BLOOD_REQUEST_CREATED', 'Blood request REQ20260709104517 created', 'INFO', '2026-07-09 04:15:17'),
(203, 73, 'judy', 'USER_LOGIN', 'judy logged in to system', 'info', '2026-07-09 04:34:55'),
(204, 74, 'akarilay', 'BLOOD_REQUEST_CREATED', 'Blood request REQ20260709110842 created', 'INFO', '2026-07-09 04:38:42'),
(205, 80, 'kay', 'USER_LOGIN', 'kay logged in to system', 'info', '2026-07-09 04:42:10'),
(206, 80, 'kay', 'USER_LOGIN', 'kay logged in to system', 'info', '2026-07-09 04:46:38'),
(207, 81, 'aliceko', 'USER_LOGIN', 'aliceko logged in to system', 'info', '2026-07-09 05:03:09'),
(208, 74, 'akarilay', 'BLOOD_REQUEST_CREATED', 'Blood request REQ20260709113335 created', 'INFO', '2026-07-09 05:03:35'),
(209, 74, 'akarilay', 'BLOOD_REQUEST_CREATED', 'Blood request REQ20260709120531 created', 'INFO', '2026-07-09 05:35:31'),
(210, 57, 'Admin', 'USER_LOGIN', 'Admin logged in to system', 'info', '2026-07-09 06:51:43'),
(211, 79, 'nick', 'USER_LOGIN', 'nick logged in to system', 'info', '2026-07-09 06:52:32'),
(212, 81, 'aliceko', 'USER_LOGIN', 'aliceko logged in to system', 'info', '2026-07-09 07:05:25'),
(213, 82, 'judy', 'USER_LOGIN', 'judy logged in to system', 'info', '2026-07-09 07:07:12'),
(214, 82, 'judy', 'BLOOD_REQUEST_CREATED', 'Blood request REQ20260709133758 created', 'INFO', '2026-07-09 07:07:58'),
(215, 82, 'judy', 'BLOOD_REQUEST_CREATED', 'Blood request REQ20260709133950 created', 'INFO', '2026-07-09 07:09:50'),
(216, 82, 'judy', 'BLOOD_REQUEST_CREATED', 'Blood request REQ20260709134157 created', 'INFO', '2026-07-09 07:11:57'),
(217, 75, 'hsumyatakari', 'USER_LOGIN', 'hsumyatakari logged in to system', 'info', '2026-07-09 07:13:31'),
(218, 79, 'nick', 'USER_LOGIN', 'nick logged in to system', 'info', '2026-07-09 07:22:11'),
(219, 83, 'nicky', 'USER_LOGIN', 'nicky logged in to system', 'info', '2026-07-09 07:24:28'),
(220, 82, 'judyy', 'BLOOD_REQUEST_CREATED', 'Blood request REQ20260709135505 created', 'INFO', '2026-07-09 07:25:05'),
(221, 82, 'judyy', 'BLOOD_REQUEST_CREATED', 'Blood request REQ20260709141748 created', 'INFO', '2026-07-09 07:47:48'),
(222, 86, 'nickyy', 'USER_LOGIN', 'nickyy logged in to system', 'info', '2026-07-09 07:49:44'),
(223, 79, 'nick', 'USER_LOGIN', 'nick logged in to system', 'info', '2026-07-09 07:55:10'),
(224, 86, 'nickyy', 'USER_LOGIN', 'nickyy logged in to system', 'info', '2026-07-09 07:56:07'),
(225, 83, 'nicky', 'USER_LOGIN', 'nicky logged in to system', 'info', '2026-07-09 07:56:44'),
(226, 79, 'nick', 'USER_LOGIN', 'nick logged in to system', 'info', '2026-07-09 07:57:22'),
(227, 79, 'nick', 'USER_LOGIN', 'nick logged in to system', 'info', '2026-07-09 07:59:13'),
(228, 79, 'nick', 'BLOOD_REQUEST_CREATED', 'Blood request REQ20260709143003 created', 'INFO', '2026-07-09 08:00:03'),
(229, 87, 'dar', 'USER_LOGIN', 'dar logged in to system', 'info', '2026-07-09 08:02:06'),
(230, 79, 'nick', 'BLOOD_REQUEST_CREATED', 'Blood request REQ20260709143249 created', 'INFO', '2026-07-09 08:02:49'),
(231, 79, 'nick', 'BLOOD_REQUEST_CREATED', 'Blood request REQ20260709144920 created', 'INFO', '2026-07-09 08:19:20'),
(232, 79, 'nick', 'BLOOD_REQUEST_CREATED', 'Blood request REQ20260709144946 created', 'INFO', '2026-07-09 08:19:46'),
(233, 79, 'nick', 'BLOOD_REQUEST_CREATED', 'Blood request REQ20260709145032 created', 'INFO', '2026-07-09 08:20:32'),
(234, 88, 'dardar', 'USER_LOGIN', 'dardar logged in to system', 'info', '2026-07-09 08:50:34'),
(235, 79, 'nick', 'BLOOD_REQUEST_CREATED', 'Blood request REQ20260709152056 created', 'INFO', '2026-07-09 08:50:56'),
(236, 79, 'nick', 'USER_LOGIN', 'nick logged in to system', 'info', '2026-07-09 09:20:00'),
(237, 83, 'nicky', 'USER_LOGIN', 'nicky logged in to system', 'info', '2026-07-09 09:21:39'),
(238, 89, 'kay', 'USER_LOGIN', 'kay logged in to system', 'info', '2026-07-09 09:22:50'),
(239, 89, 'kay', 'BLOOD_REQUEST_CREATED', 'Blood request REQ20260709155504 created', 'INFO', '2026-07-09 09:25:04'),
(240, 90, 'dardarwinhtet', 'USER_LOGIN', 'dardarwinhtet logged in to system', 'info', '2026-07-09 10:26:01'),
(241, 91, 'bady', 'USER_LOGIN', 'bady logged in to system', 'info', '2026-07-09 11:05:35'),
(242, 89, 'kay kay', 'USER_LOGIN', 'kay kay logged in to system', 'info', '2026-07-09 11:06:20'),
(243, 89, 'kay kay', 'BLOOD_REQUEST_CREATED', 'Blood request REQ20260709173646 created', 'INFO', '2026-07-09 11:06:46'),
(244, 57, 'Admin', 'USER_LOGIN', 'Admin logged in to system', 'info', '2026-07-09 11:17:20'),
(245, 89, 'kay kay', 'USER_LOGIN', 'kay kay logged in to system', 'info', '2026-07-09 11:17:44'),
(246, 57, 'Admin', 'USER_LOGIN', 'Admin logged in to system', 'info', '2026-07-09 11:18:23'),
(247, 57, 'Admin', 'USER_LOGIN', 'Admin logged in to system', 'info', '2026-07-09 14:19:43'),
(248, 57, 'Admin', 'USER_LOGIN', 'Admin logged in to system', 'info', '2026-07-09 15:02:22'),
(249, 57, 'Admin', 'USER_LOGIN', 'Admin logged in to system', 'info', '2026-07-09 15:02:46'),
(250, 57, 'Admin', 'USER_LOGIN', 'Admin logged in to system', 'info', '2026-07-09 15:13:15'),
(251, 91, 'bady', 'USER_LOGIN', 'bady logged in to system', 'info', '2026-07-09 15:30:21'),
(252, 57, 'Admin', 'USER_LOGIN', 'Admin logged in to system', 'info', '2026-07-09 15:55:43'),
(253, 91, 'bady', 'USER_LOGIN', 'bady logged in to system', 'info', '2026-07-09 15:58:39'),
(254, 91, 'bady', 'USER_LOGIN', 'bady logged in to system', 'info', '2026-07-09 15:59:45'),
(255, 91, 'bady', 'USER_LOGIN', 'bady logged in to system', 'info', '2026-07-09 16:00:44'),
(256, 89, 'kay kay', 'USER_LOGIN', 'kay kay logged in to system', 'info', '2026-07-09 16:07:10'),
(257, 57, 'Admin', 'USER_LOGIN', 'Admin logged in to system', 'info', '2026-07-09 16:09:40'),
(258, 89, 'kay kay', 'USER_LOGIN', 'kay kay logged in to system', 'info', '2026-07-09 16:10:19'),
(259, 89, 'kay kay', 'USER_LOGIN', 'kay kay logged in to system', 'info', '2026-07-09 16:13:22'),
(260, 57, 'Admin', 'USER_LOGIN', 'Admin logged in to system', 'info', '2026-07-09 16:14:14'),
(261, 89, 'kay kay', 'USER_LOGIN', 'kay kay logged in to system', 'info', '2026-07-09 16:16:23'),
(262, 91, 'bady', 'USER_LOGIN', 'bady logged in to system', 'info', '2026-07-09 16:24:32'),
(263, 89, 'kay kay', 'USER_LOGIN', 'kay kay logged in to system', 'info', '2026-07-09 16:25:14'),
(264, 57, 'Admin', 'USER_LOGIN', 'Admin logged in to system', 'info', '2026-07-09 16:30:32'),
(265, 91, 'bady', 'USER_LOGIN', 'bady logged in to system', 'info', '2026-07-09 16:31:30'),
(266, 89, 'kay kay', 'USER_LOGIN', 'kay kay logged in to system', 'info', '2026-07-09 16:32:39'),
(267, 91, 'bady', 'USER_LOGIN', 'bady logged in to system', 'info', '2026-07-09 16:50:37'),
(268, 91, 'bady', 'USER_LOGIN', 'bady logged in to system', 'info', '2026-07-09 16:51:12'),
(269, 89, 'kay kay', 'USER_LOGIN', 'kay kay logged in to system', 'info', '2026-07-09 16:52:39'),
(270, 89, 'kay kay', 'USER_LOGIN', 'kay kay logged in to system', 'info', '2026-07-09 16:53:09'),
(271, 89, 'kay kay', 'USER_LOGIN', 'kay kay logged in to system', 'info', '2026-07-09 16:53:53'),
(272, 89, 'kay kay', 'USER_LOGIN', 'kay kay logged in to system', 'info', '2026-07-09 16:59:16'),
(273, 57, 'Admin', 'USER_LOGIN', 'Admin logged in to system', 'info', '2026-07-09 16:59:47'),
(274, 89, 'kay kay', 'USER_LOGIN', 'kay kay logged in to system', 'info', '2026-07-09 17:00:41'),
(275, 89, 'kay', 'BLOOD_REQUEST_CREATED', 'Blood request REQ20260709234822 created', 'INFO', '2026-07-09 17:18:22'),
(276, 92, 'dodo', 'USER_LOGIN', 'dodo logged in to system', 'info', '2026-07-09 17:23:52'),
(277, 89, 'kay', 'BLOOD_REQUEST_CREATED', 'Blood request REQ20260709235422 created', 'INFO', '2026-07-09 17:24:22'),
(278, 57, 'Admin', 'USER_LOGIN', 'Admin logged in to system', 'info', '2026-07-10 02:51:46'),
(279, 89, 'kay kay', 'USER_LOGIN', 'kay kay logged in to system', 'info', '2026-07-10 02:53:28'),
(280, 91, 'bady', 'USER_LOGIN', 'bady logged in to system', 'info', '2026-07-10 02:55:40'),
(281, 92, 'dodo', 'USER_LOGIN', 'dodo logged in to system', 'info', '2026-07-10 02:58:15'),
(282, 91, 'bady', 'USER_LOGIN', 'bady logged in to system', 'info', '2026-07-10 02:58:45'),
(283, 89, 'kay', 'USER_LOGIN', 'kay logged in to system', 'info', '2026-07-10 02:59:28'),
(284, 92, 'dodo', 'USER_LOGIN', 'dodo logged in to system', 'info', '2026-07-10 02:59:49'),
(285, 91, 'bady', 'USER_LOGIN', 'bady logged in to system', 'info', '2026-07-10 03:00:26'),
(286, 92, 'dodo', 'USER_LOGIN', 'dodo logged in to system', 'info', '2026-07-10 03:01:18'),
(287, 82, 'judyy', 'USER_LOGIN', 'judyy logged in to system', 'info', '2026-07-10 03:03:20'),
(288, 89, 'kay', 'USER_LOGIN', 'kay logged in to system', 'info', '2026-07-10 03:04:09'),
(289, 57, 'Admin', 'USER_LOGIN', 'Admin logged in to system', 'info', '2026-07-10 03:10:40'),
(290, 57, 'Admin', 'USER_LOGIN', 'Admin logged in to system', 'info', '2026-07-10 03:29:26'),
(291, 92, 'dodo', 'USER_LOGIN', 'dodo logged in to system', 'info', '2026-07-10 03:30:23'),
(292, 94, 'lina', 'USER_LOGIN', 'lina logged in to system', 'info', '2026-07-10 03:42:44'),
(293, 94, 'linalina', 'BLOOD_REQUEST_CREATED', 'Blood request REQ20260710101340 created', 'INFO', '2026-07-10 03:43:40'),
(294, 95, 'aliceko', 'USER_LOGIN', 'aliceko logged in to system', 'info', '2026-07-10 03:52:42'),
(295, 96, 'kaung', 'USER_LOGIN', 'kaung logged in to system', 'info', '2026-07-10 03:56:57'),
(296, 97, 'kayyyy', 'USER_LOGIN', 'kayyyy logged in to system', 'info', '2026-07-10 03:58:36'),
(297, 97, 'kayyyy', 'BLOOD_REQUEST_CREATED', 'Blood request REQ20260710102903 created', 'INFO', '2026-07-10 03:59:03'),
(298, 97, 'kayyyy', 'BLOOD_REQUEST_CREATED', 'Blood request REQ20260710103243 created', 'INFO', '2026-07-10 04:02:43'),
(299, 97, 'kayyyy', 'BLOOD_REQUEST_CREATED', 'Blood request REQ20260710104234 created', 'INFO', '2026-07-10 04:12:34'),
(300, 97, 'kayyyy', 'BLOOD_REQUEST_CREATED', 'Blood request REQ20260710105301 created', 'INFO', '2026-07-10 04:23:01'),
(301, 98, 'bobo', 'USER_LOGIN', 'bobo logged in to system', 'info', '2026-07-10 04:24:46'),
(302, 97, 'kayyyy', 'BLOOD_REQUEST_CREATED', 'Blood request REQ20260710105641 created', 'INFO', '2026-07-10 04:26:41'),
(303, 99, 'lwinlwin', 'USER_LOGIN', 'lwinlwin logged in to system', 'info', '2026-07-10 04:28:11'),
(304, 100, 'zawzaw', 'USER_LOGIN', 'zawzaw logged in to system', 'info', '2026-07-10 04:37:06'),
(305, 97, 'kayyyy', 'BLOOD_REQUEST_CREATED', 'Blood request REQ20260710110751 created', 'INFO', '2026-07-10 04:37:51'),
(306, 89, 'kay', 'USER_LOGIN', 'kay logged in to system', 'info', '2026-07-10 04:38:20'),
(307, 89, 'kay', 'BLOOD_REQUEST_CREATED', 'Blood request REQ20260710110839 created', 'INFO', '2026-07-10 04:38:39'),
(308, 89, 'kay', 'BLOOD_REQUEST_CREATED', 'Blood request REQ20260710111302 created', 'INFO', '2026-07-10 04:43:02'),
(309, 101, 'myo', 'USER_LOGIN', 'myo logged in to system', 'info', '2026-07-10 04:46:31'),
(310, 89, 'kay', 'BLOOD_REQUEST_CREATED', 'Blood request REQ20260710111824 created', 'INFO', '2026-07-10 04:48:24'),
(311, 89, 'kk', 'BLOOD_REQUEST_CREATED', 'Blood request REQ20260710112354 created', 'INFO', '2026-07-10 04:53:54'),
(312, 89, 'kk', 'BLOOD_REQUEST_CREATED', 'Blood request REQ20260710112507 created', 'INFO', '2026-07-10 04:55:07'),
(313, 102, 'Htet Nandar Winn', 'USER_LOGIN', 'Htet Nandar Winn logged in to system', 'INFO', '2026-07-10 08:09:33'),
(314, 103, 'Htet Htet', 'USER_LOGIN', 'Htet Htet logged in to system', 'INFO', '2026-07-10 08:11:46'),
(315, 103, 'Htet Htet', 'USER_LOGIN', 'Htet Htet logged in to system', 'INFO', '2026-07-10 08:16:23'),
(316, 103, 'Htet Htet', 'USER_LOGIN', 'Htet Htet logged in to system', 'INFO', '2026-07-10 08:16:59'),
(317, 103, 'Htet Htet', 'USER_LOGIN', 'Htet Htet logged in to system', 'INFO', '2026-07-10 08:46:43'),
(318, 104, 'Lina Lina', 'USER_LOGIN', 'Lina Lina logged in to system', 'INFO', '2026-07-10 08:51:45'),
(319, 105, 'Kay Kay', 'USER_LOGIN', 'Kay Kay logged in to system', 'INFO', '2026-07-10 09:02:34'),
(320, 105, 'Kay Kay', 'USER_LOGIN', 'Kay Kay logged in to system', 'INFO', '2026-07-10 09:11:36'),
(321, 106, 'Htet Nandar Winn', 'USER_LOGIN', 'Htet Nandar Winn logged in to system', 'INFO', '2026-07-10 09:12:27'),
(322, 57, 'Admin', 'USER_LOGIN', 'Admin logged in to system', 'info', '2026-07-10 09:13:31'),
(323, 106, 'Htet Nandar Winn', 'USER_LOGIN', 'Htet Nandar Winn logged in to system', 'INFO', '2026-07-10 09:59:06'),
(324, 107, 'Lina Lina', 'USER_LOGIN', 'Lina Lina logged in to system', 'INFO', '2026-07-10 10:09:05'),
(325, 57, 'Admin', 'USER_LOGIN', 'Admin logged in to system', 'info', '2026-07-10 14:26:30'),
(326, 108, 'Htet Nandar Winn', 'USER_LOGIN', 'Htet Nandar Winn logged in to system', 'INFO', '2026-07-10 14:30:17'),
(327, 109, 'Kay Kay', 'USER_LOGIN', 'Kay Kay logged in to system', 'INFO', '2026-07-10 14:31:22'),
(328, 109, 'Kay Kay', 'BLOOD_REQUEST_CREATED', 'Blood request REQ20260710210931 created', 'INFO', '2026-07-10 14:39:31'),
(329, 109, 'Kay Kay', 'BLOOD_REQUEST_CREATED', 'Blood request REQ20260710211236 created', 'INFO', '2026-07-10 14:42:36'),
(330, 110, 'Dar Dar', 'USER_LOGIN', 'Dar Dar logged in to system', 'INFO', '2026-07-10 15:10:54'),
(331, 111, 'Bunny', 'USER_LOGIN', 'Bunny logged in to system', 'INFO', '2026-07-10 15:33:20'),
(332, 109, 'Kay Kay', 'USER_LOGIN', 'Kay Kay logged in to system', 'INFO', '2026-07-10 17:42:14'),
(333, 109, 'Kay Kay', 'BLOOD_REQUEST_CREATED', 'Blood request REQ20260711001235 created', 'INFO', '2026-07-10 17:42:35'),
(334, 109, 'Kay Kay', 'BLOOD_REQUEST_CREATED', 'Blood request REQ20260711001629 created', 'INFO', '2026-07-10 17:46:29'),
(335, 110, 'Dar Dar', 'USER_LOGIN', 'Dar Dar logged in to system', 'INFO', '2026-07-10 18:01:17'),
(336, 112, 'Mayple MP', 'USER_LOGIN', 'Mayple MP logged in to system', 'INFO', '2026-07-10 18:03:31'),
(337, 57, 'Admin', 'USER_LOGIN', 'Admin logged in to system', 'info', '2026-07-11 09:07:30'),
(338, 113, 'Ryou You', 'USER_LOGIN', 'Ryou You logged in to system', 'INFO', '2026-07-11 10:01:25'),
(339, 114, 'Lina Lina', 'USER_LOGIN', 'Lina Lina logged in to system', 'INFO', '2026-07-11 10:02:45'),
(340, 57, 'Admin', 'USER_LOGIN', 'Admin logged in to system', 'info', '2026-07-11 10:03:03'),
(341, 115, 'Lina Lina', 'USER_LOGIN', 'Lina Lina logged in to system', 'info', '2026-07-11 10:21:08'),
(342, 57, 'Admin', 'USER_LOGIN', 'Admin logged in to system', 'info', '2026-07-11 10:22:05'),
(343, 116, 'Mayple MP', 'USER_LOGIN', 'Mayple MP logged in to system', 'INFO', '2026-07-11 10:24:04'),
(344, 116, 'Mayple MP', 'BLOOD_REQUEST_CREATED', 'Blood request REQ20260711165423 created', 'INFO', '2026-07-11 10:24:23'),
(345, 116, 'Mayple MP', 'BLOOD_REQUEST_CREATED', 'Blood request REQ20260711165929 created', 'INFO', '2026-07-11 10:29:29'),
(346, 111, 'Bunny', 'USER_LOGIN', 'Bunny logged in to system', 'INFO', '2026-07-11 11:10:09'),
(347, 117, 'Ryou You', 'USER_LOGIN', 'Ryou You logged in to system', 'INFO', '2026-07-11 11:13:29'),
(348, 119, 'Sakura', 'USER_LOGIN', 'Sakura logged in to system', 'INFO', '2026-07-11 11:22:35'),
(349, 119, 'Sakura', 'BLOOD_REQUEST_CREATED', 'Blood request REQ20260711175535 created', 'INFO', '2026-07-11 11:25:35'),
(350, 119, 'Sakura', 'BLOOD_REQUEST_CREATED', 'Blood request REQ20260711180215 created', 'INFO', '2026-07-11 11:32:15'),
(351, 119, 'Sakura', 'BLOOD_REQUEST_CREATED', 'Blood request REQ20260711180704 created', 'INFO', '2026-07-11 11:37:04'),
(352, 119, 'Sakura', 'BLOOD_REQUEST_CREATED', 'Blood request REQ20260711180812 created', 'INFO', '2026-07-11 11:38:12'),
(353, 119, 'Sakura', 'BLOOD_REQUEST_CREATED', 'Blood request REQ20260711182106 created', 'INFO', '2026-07-11 11:51:06'),
(354, 119, 'Sakura', 'BLOOD_REQUEST_CREATED', 'Blood request REQ20260711182432 created', 'INFO', '2026-07-11 11:54:32'),
(355, 121, 'Ryou You', 'USER_LOGIN', 'Ryou You logged in to system', 'INFO', '2026-07-11 11:59:05'),
(356, 119, 'Sakura', 'BLOOD_REQUEST_CREATED', 'Blood request REQ20260711183013 created', 'INFO', '2026-07-11 12:00:13'),
(357, 122, 'Dar Dar', 'USER_LOGIN', 'Dar Dar logged in to system', 'INFO', '2026-07-11 15:14:08'),
(358, 123, 'Kay Kay', 'USER_LOGIN', 'Kay Kay logged in to system', 'INFO', '2026-07-11 15:14:51'),
(359, 123, 'Kay Kay', 'BLOOD_REQUEST_CREATED', 'Blood request REQ20260711214620 created', 'INFO', '2026-07-11 15:16:20'),
(360, 123, 'Kay Kay', 'BLOOD_REQUEST_CREATED', 'Blood request REQ20260711214829 created', 'INFO', '2026-07-11 15:18:29'),
(361, 126, 'Dar Dar', 'LOGIN', 'User logged in', 'INFO', '2026-07-11 16:39:46'),
(362, 127, 'bunny', 'LOGIN', 'User logged in', 'INFO', '2026-07-11 16:42:22'),
(363, 128, 'Mayple MP', 'LOGIN', 'User logged in', 'INFO', '2026-07-11 16:44:08'),
(364, 128, 'Mayple', 'BLOOD_REQUEST_CREATED', 'Blood request REQ20260711231600 created', 'INFO', '2026-07-11 16:46:00'),
(365, 128, NULL, 'REQUEST_CANCELLED', 'Patient cancelled blood request REQ20260711231600 (ID: 172)', 'INFO', '2026-07-11 16:48:25'),
(366, 128, 'Kay Kay', 'BLOOD_REQUEST_CREATED', 'Blood request REQ20260711231920 created', 'INFO', '2026-07-11 16:49:20'),
(367, 126, 'Dar Dar', 'REQUEST_ACCEPTED', 'Donor accepted blood request REQ20260711231920 (ID: 173)', 'INFO', '2026-07-11 16:50:30'),
(368, 57, 'Admin', 'LOGIN', 'User logged in', 'INFO', '2026-07-12 11:17:14'),
(369, 129, 'Dar Dar', 'USER_LOGIN', 'Dar Dar logged in to system', 'INFO', '2026-07-12 11:19:47'),
(370, 130, 'Kay Kay', 'USER_LOGIN', 'Kay Kay logged in to system', 'INFO', '2026-07-12 11:20:13'),
(371, 129, 'Dar Dar', 'USER_LOGIN', 'Dar Dar logged in to system', 'INFO', '2026-07-12 11:20:55'),
(372, 57, 'Admin', 'LOGIN', 'User logged in', 'INFO', '2026-07-12 14:08:45'),
(373, 131, 'Dar Dar', 'USER_LOGIN', 'Dar Dar logged in to system', 'INFO', '2026-07-12 14:11:48'),
(374, 132, 'Kay Kay', 'USER_LOGIN', 'Kay Kay logged in to system', 'INFO', '2026-07-12 14:12:35'),
(375, 131, 'Dar Dar', 'PROFILE_UPDATED', 'Donor updated their profile', 'INFO', '2026-07-12 14:13:50'),
(376, 132, 'Kay Kay', 'BLOOD_REQUEST_CREATED', 'Blood request REQ20260712205514 created', 'INFO', '2026-07-12 14:25:14'),
(377, 132, NULL, 'REQUEST_CANCELLED', 'Patient cancelled blood request REQ20260712205514 (ID: 174)', 'INFO', '2026-07-12 14:27:44'),
(378, 132, 'Kay Kay', 'BLOOD_REQUEST_CREATED', 'Blood request REQ20260712205852 created', 'INFO', '2026-07-12 14:28:52'),
(379, 131, 'Dar Dar', 'REQUEST_ACCEPTED', 'Donor accepted blood request REQ20260712205852 (ID: 175)', 'INFO', '2026-07-12 14:29:52'),
(380, 133, 'kay', 'LOGIN', 'User logged in', 'INFO', '2026-07-12 16:00:44'),
(381, 134, 'Bunny', 'LOGIN', 'User logged in', 'INFO', '2026-07-12 16:04:40'),
(382, 57, 'Admin', 'LOGIN', 'User logged in', 'INFO', '2026-07-13 02:54:10'),
(383, 135, 'Bunny', 'USER_LOGIN', 'Bunny logged in to system', 'INFO', '2026-07-13 02:55:38'),
(384, 136, 'Kay Kay', 'USER_LOGIN', 'Kay Kay logged in to system', 'INFO', '2026-07-13 02:56:50'),
(385, 136, 'Kay Kay', 'BLOOD_REQUEST_CREATED', 'Blood request REQ20260713092756 created', 'INFO', '2026-07-13 02:57:56'),
(386, 136, NULL, 'REQUEST_CANCELLED', 'Patient cancelled blood request REQ20260713092756 (ID: 176)', 'INFO', '2026-07-13 02:58:27'),
(387, 136, 'Kay Kay', 'BLOOD_REQUEST_CREATED', 'Blood request REQ20260713092913 created', 'INFO', '2026-07-13 02:59:13'),
(388, 135, 'Bunny', 'REQUEST_ACCEPTED', 'Donor accepted blood request REQ20260713092913 (ID: 177)', 'INFO', '2026-07-13 03:01:15'),
(389, 135, 'Bunny', 'PROFILE_UPDATED', 'Donor updated their profile', 'INFO', '2026-07-13 03:02:15'),
(390, 137, 'Lina Lina', 'LOGIN', 'User logged in', 'INFO', '2026-07-13 03:34:33'),
(391, 137, 'Lina Lina', 'USER_LOGIN', 'Lina Lina logged in to system', 'INFO', '2026-07-13 03:45:56'),
(392, 135, 'Bunny', 'USER_LOGIN', 'Bunny logged in to system', 'INFO', '2026-07-13 03:46:36'),
(393, 136, 'Kay Kay', 'BLOOD_REQUEST_CREATED', 'Blood request REQ20260713101713 created', 'INFO', '2026-07-13 03:47:13'),
(394, 136, NULL, 'REQUEST_CANCELLED', 'Patient cancelled blood request REQ20260713101713 (ID: 178)', 'INFO', '2026-07-13 04:17:01'),
(395, 136, 'Kay Kay', 'BLOOD_REQUEST_CREATED', 'Blood request REQ20260713104715 created', 'INFO', '2026-07-13 04:17:15'),
(396, 136, 'Kay Kay', 'USER_LOGIN', 'Kay Kay logged in to system', 'INFO', '2026-07-13 04:23:05'),
(397, 138, 'Bunny', 'USER_LOGIN', 'Bunny logged in to system', 'INFO', '2026-07-13 04:29:50'),
(398, 139, 'Mayple MP', 'USER_LOGIN', 'Mayple MP logged in to system', 'INFO', '2026-07-13 04:35:58'),
(399, 139, 'Mayple', 'BLOOD_REQUEST_CREATED', 'Blood request REQ20260713110657 created', 'INFO', '2026-07-13 04:36:57'),
(400, 57, 'Admin', 'LOGIN', 'User logged in', 'INFO', '2026-07-13 05:04:26'),
(401, 140, 'Ryou You', 'USER_LOGIN', 'Ryou You logged in to system', 'INFO', '2026-07-13 05:05:22'),
(402, 140, 'Ryou You', 'REQUEST_ACCEPTED', 'Donor accepted blood request REQ20260713110657 (ID: 180)', 'INFO', '2026-07-13 05:06:19'),
(403, 138, 'Bunny', 'REQUEST_ACCEPTED', 'Donor accepted blood request REQ20260710112507 (ID: 156)', 'INFO', '2026-07-13 05:21:44'),
(404, 136, 'Kay Kay', 'USER_LOGIN', 'Kay Kay logged in to system', 'INFO', '2026-07-13 05:26:44'),
(405, 136, NULL, 'REQUEST_CANCELLED', 'Patient cancelled blood request REQ20260713104715 (ID: 179)', 'INFO', '2026-07-13 05:26:54'),
(406, 141, 'Htet Nandar Winn', 'USER_LOGIN', 'Htet Nandar Winn logged in to system', 'INFO', '2026-07-13 05:27:32'),
(407, 136, 'Kay Kay', 'BLOOD_REQUEST_CREATED', 'Blood request REQ20260713115754 created', 'INFO', '2026-07-13 05:27:54'),
(408, 136, NULL, 'REQUEST_CANCELLED', 'Patient cancelled blood request REQ20260713115754 (ID: 181)', 'INFO', '2026-07-13 05:28:43'),
(409, 136, 'Kay Kay', 'BLOOD_REQUEST_CREATED', 'Blood request REQ20260713120700 created', 'INFO', '2026-07-13 05:37:00'),
(410, 142, 'Sakura', 'USER_LOGIN', 'Sakura logged in to system', 'INFO', '2026-07-13 05:37:36'),
(411, 136, 'Kay Kay', 'BLOOD_REQUEST_CREATED', 'Blood request REQ20260713121117 created', 'INFO', '2026-07-13 05:41:17'),
(412, 143, 'Lina Lina', 'USER_LOGIN', 'Lina Lina logged in to system', 'INFO', '2026-07-13 05:45:00'),
(413, 136, 'Kay Kay', 'BLOOD_REQUEST_CREATED', 'Blood request REQ20260713121901 created', 'INFO', '2026-07-13 05:49:01'),
(414, 136, 'Kay Kay', 'USER_LOGIN', 'Kay Kay logged in to system', 'INFO', '2026-07-13 06:58:30'),
(415, 57, 'Admin', 'LOGIN', 'User logged in', 'INFO', '2026-07-13 07:12:37'),
(416, 57, 'Admin', 'LOGIN', 'User logged in', 'INFO', '2026-07-13 07:31:13'),
(417, 144, 'Lina Lina', 'USER_LOGIN', 'Lina Lina logged in to system', 'INFO', '2026-07-13 07:31:47'),
(418, 136, 'Kay', 'BLOOD_REQUEST_CREATED', 'Blood request REQ20260713140257 created', 'INFO', '2026-07-13 07:32:57'),
(419, 136, NULL, 'REQUEST_CANCELLED', 'Patient cancelled blood request REQ20260713140257 (ID: 185)', 'INFO', '2026-07-13 07:33:50'),
(420, 136, 'Kay', 'BLOOD_REQUEST_CREATED', 'Blood request REQ20260713140425 created', 'INFO', '2026-07-13 07:34:25'),
(421, 136, 'Kay', 'BLOOD_REQUEST_CREATED', 'Blood request REQ20260713140522 created', 'INFO', '2026-07-13 07:35:22'),
(422, 136, 'Kay', 'BLOOD_REQUEST_CREATED', 'Blood request REQ20260713140643 created', 'INFO', '2026-07-13 07:36:43'),
(423, 144, 'Lina Lina', 'REQUEST_ACCEPTED', 'Donor accepted blood request REQ20260713140643 (ID: 188)', 'INFO', '2026-07-13 07:38:20'),
(424, 145, 'Dar Dar', 'USER_LOGIN', 'Dar Dar logged in to system', 'INFO', '2026-07-13 08:06:36'),
(425, 136, 'Kay', 'BLOOD_REQUEST_CREATED', 'Blood request REQ20260713143744 created', 'INFO', '2026-07-13 08:07:44'),
(426, 145, 'Dar Dar', 'REQUEST_ACCEPTED', 'Donor accepted blood request REQ20260713143744 (ID: 189)', 'INFO', '2026-07-13 08:08:59'),
(427, 145, 'Dar Dar', 'PROFILE_UPDATED', 'Donor updated their profile', 'INFO', '2026-07-13 08:16:27'),
(428, 136, 'Kay Kay', 'USER_LOGIN', 'Kay Kay logged in to system', 'INFO', '2026-07-13 08:29:56'),
(429, 146, 'Htet Htet', 'USER_LOGIN', 'Htet Htet logged in to system', 'INFO', '2026-07-13 08:35:40'),
(430, 146, 'Htet Htet', 'PROFILE_UPDATED', 'Donor updated their profile', 'INFO', '2026-07-13 08:37:52'),
(431, 136, 'Kay Kay', 'USER_LOGIN', 'Kay Kay logged in to system', 'INFO', '2026-07-13 17:30:10'),
(432, 136, 'Kay', 'BLOOD_REQUEST_CREATED', 'Blood request REQ20260714001451 created', 'INFO', '2026-07-13 17:44:51'),
(433, 136, NULL, 'REQUEST_CANCELLED', 'Patient cancelled blood request REQ20260714001451 (ID: 190)', 'INFO', '2026-07-13 17:56:50'),
(434, 136, 'Kay', 'BLOOD_REQUEST_CREATED', 'Blood request REQ20260714002708 created', 'INFO', '2026-07-13 17:57:08'),
(435, 136, NULL, 'REQUEST_CANCELLED', 'Patient cancelled blood request REQ20260714002708 (ID: 191)', 'INFO', '2026-07-13 17:58:51'),
(436, 136, 'Kay', 'BLOOD_REQUEST_CREATED', 'Blood request REQ20260714002907 created', 'INFO', '2026-07-13 17:59:07'),
(437, 144, 'Lina Lina', 'USER_LOGIN', 'Lina Lina logged in to system', 'INFO', '2026-07-13 18:05:08'),
(438, 57, 'Admin', 'LOGIN', 'User logged in', 'INFO', '2026-07-13 18:12:34'),
(439, 57, 'Admin', 'LOGIN', 'User logged in', 'INFO', '2026-07-14 02:58:14'),
(440, 145, 'Dar Dar', 'USER_LOGIN', 'Dar Dar logged in to system', 'INFO', '2026-07-14 02:59:48'),
(441, 136, 'Kay Kay', 'USER_LOGIN', 'Kay Kay logged in to system', 'INFO', '2026-07-14 03:01:21'),
(442, 147, 'Bunny', 'USER_LOGIN', 'Bunny logged in to system', 'INFO', '2026-07-14 03:48:08'),
(443, 136, NULL, 'REQUEST_CANCELLED', 'Patient cancelled blood request REQ20260714002907 (ID: 192)', 'INFO', '2026-07-14 03:48:25'),
(444, 136, 'Kay Kay', 'BLOOD_REQUEST_CREATED', 'Blood request REQ20260714101839 created', 'INFO', '2026-07-14 03:48:39'),
(445, 136, NULL, 'REQUEST_CANCELLED', 'Patient cancelled blood request REQ20260714101839 (ID: 193)', 'INFO', '2026-07-14 03:57:11'),
(446, 136, 'Kay Kay', 'BLOOD_REQUEST_CREATED', 'Blood request REQ20260714102732 created', 'INFO', '2026-07-14 03:57:32'),
(447, 136, NULL, 'REQUEST_CANCELLED', 'Patient cancelled blood request REQ20260714102732 (ID: 194)', 'INFO', '2026-07-14 04:16:19'),
(448, 136, 'Kay Kay', 'BLOOD_REQUEST_CREATED', 'Blood request REQ20260714104912 created', 'INFO', '2026-07-14 04:19:12'),
(449, 147, 'Bunny', 'REQUEST_ACCEPTED', 'Donor accepted blood request REQ20260714104912 (ID: 195)', 'INFO', '2026-07-14 04:38:23'),
(450, 148, 'Dar Dar', 'USER_LOGIN', 'Dar Dar logged in to system', 'INFO', '2026-07-14 04:53:40'),
(451, 136, 'Kay Kay', 'BLOOD_REQUEST_CREATED', 'Blood request REQ20260714112406 created', 'INFO', '2026-07-14 04:54:06'),
(452, 148, 'Dar Dar', 'REQUEST_ACCEPTED', 'Donor accepted blood request REQ20260714112406 (ID: 196)', 'INFO', '2026-07-14 04:54:54'),
(453, 57, 'Admin', 'LOGIN', 'User logged in', 'INFO', '2026-07-14 07:26:59'),
(454, 57, 'Admin', 'LOGIN', 'User logged in', 'INFO', '2026-07-14 09:42:41'),
(455, 57, 'Admin', 'LOGIN', 'User logged in', 'INFO', '2026-07-14 14:11:13'),
(456, 148, 'Dar Dar', 'USER_LOGIN', 'Dar Dar logged in to system', 'INFO', '2026-07-14 14:18:55'),
(457, 149, 'Lina Lina', 'USER_LOGIN', 'Lina Lina logged in to system', 'INFO', '2026-07-14 15:02:36'),
(458, 150, 'Mayple MP', 'USER_LOGIN', 'Mayple MP logged in to system', 'INFO', '2026-07-14 15:06:05'),
(459, 150, 'Mayple', 'BLOOD_REQUEST_CREATED', 'Blood request REQ20260714213736 created', 'INFO', '2026-07-14 15:07:36'),
(460, 150, NULL, 'REQUEST_CANCELLED', 'Patient cancelled blood request REQ20260714213736 (ID: 197)', 'INFO', '2026-07-14 15:10:05'),
(461, 150, 'Mayple', 'BLOOD_REQUEST_CREATED', 'Blood request REQ20260714214118 created', 'INFO', '2026-07-14 15:11:18'),
(462, 149, 'Lina Lina', 'REQUEST_ACCEPTED', 'Donor accepted blood request REQ20260714214118 (ID: 198)', 'INFO', '2026-07-14 15:13:04'),
(463, 148, 'Dar Dar', 'USER_LOGIN', 'Dar Dar logged in to system', 'INFO', '2026-07-14 15:16:12'),
(464, 150, 'Mayple', 'BLOOD_REQUEST_CREATED', 'Blood request REQ20260714214746 created', 'INFO', '2026-07-14 15:17:46'),
(465, 151, 'Bunny', 'USER_LOGIN', 'Bunny logged in to system', 'INFO', '2026-07-14 15:18:55'),
(466, 152, 'Ryou You', 'USER_LOGIN', 'Ryou You logged in to system', 'INFO', '2026-07-14 15:19:23'),
(467, 153, 'Dar Dar', 'USER_LOGIN', 'Dar Dar logged in to system', 'INFO', '2026-07-14 15:20:16');

-- --------------------------------------------------------

--
-- Table structure for table `blood_requests`
--

CREATE TABLE `blood_requests` (
  `request_id` int(11) NOT NULL,
  `request_code` varchar(20) NOT NULL,
  `patient_id` int(11) NOT NULL,
  `patient_name` varchar(100) NOT NULL,
  `blood_group_needed` varchar(10) NOT NULL,
  `hospital_name` varchar(150) NOT NULL,
  `urgency` varchar(50) DEFAULT NULL,
  `contact_phone` varchar(20) DEFAULT NULL,
  `status` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `unit` int(11) NOT NULL DEFAULT 1,
  `donor_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `blood_requests`
--

INSERT INTO `blood_requests` (`request_id`, `request_code`, `patient_id`, `patient_name`, `blood_group_needed`, `hospital_name`, `urgency`, `contact_phone`, `status`, `created_at`, `unit`, `donor_id`) VALUES
(136, 'REQ20260709143249', 79, 'tt', 'A+', 'Grand Hospital , Yangon', 'Critical', '09671739912', 8, '2026-07-09 08:02:49', 3, 101),
(137, 'REQ20260709144920', 79, 'nn', 'B+', 'Grand Hospital , Yangon', 'Standard', '09671739912', 8, '2026-07-09 08:19:20', 10, 99),
(139, 'REQ20260709145032', 79, 'kk', 'AB+', 'Grand Hospital , Yangon', 'Standard', '09752591553', 8, '2026-07-09 08:20:32', 3, 95),
(141, 'REQ20260709155504', 89, 'nn', 'B+', 'Grand Hospital , Yangon', 'Standard', '09671739912', 8, '2026-07-09 09:25:04', 1, 98),
(142, 'REQ20260709173646', 89, 'yy', 'O-', 'Grand Hospital , Yangon', 'Critical', '09671739912', 8, '2026-07-09 11:06:46', 2, 91),
(143, 'REQ20260709234822', 89, 'kk', 'O-', 'Grand Hospital , Yangon', 'Standard', '09671739912', 8, '2026-07-09 17:18:22', 2, 91),
(144, 'REQ20260709235422', 89, 'nn', 'B-', 'Grand Hospital , Yangon', 'Standard', '09671739912', 8, '2026-07-09 17:24:22', 3, 92),
(145, 'REQ20260710101340', 94, 'lina', 'AB+', 'Grand Hospital , Yangon', 'Standard', '09671739912', 8, '2026-07-10 03:43:40', 4, 95),
(146, 'REQ20260710102903', 97, 'kay', 'O+', 'Grand Hospital , Yangon', 'Standard', '09671739912', 8, '2026-07-10 03:59:03', 4, 96),
(147, 'REQ20260710103243', 97, 'kk', 'O+', 'Grand Hospital , Yangon', 'Standard', '09671739912', 10, '2026-07-10 04:02:43', 3, NULL),
(148, 'REQ20260710104234', 97, 'akari', 'O+', 'Grand Hospital , Yangon', 'Critical', '09671739912', 10, '2026-07-10 04:12:34', 3, NULL),
(149, 'REQ20260710105301', 97, 'yy', 'B+', 'Grand Hospital , Yangon', 'Urgent', '09671739912', 8, '2026-07-10 04:23:01', 3, 98),
(151, 'REQ20260710110751', 97, 'kk', 'B+', 'Grand Hospital , Yangon', 'Standard', '09671739912', 8, '2026-07-10 04:37:51', 2, 100),
(197, 'REQ20260714213736', 150, 'Mayple', 'A+', 'Grand Hospital, Yangon', 'Standard', '09671739912', 10, '2026-07-14 15:07:36', 3, NULL),
(198, 'REQ20260714214118', 150, 'Mayple', 'A+', 'Grand Hospital, Yangon', 'Standard', '09671739912', 8, '2026-07-14 15:11:18', 3, 149),
(199, 'REQ20260714214746', 150, 'Mayple', 'B+', 'Grand Hospital, Yangon', 'Standard', '09671739912', 7, '2026-07-14 15:17:46', 2, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `donation_history`
--

CREATE TABLE `donation_history` (
  `donation_id` int(11) NOT NULL,
  `request_id` int(11) NOT NULL,
  `donor_id` int(11) NOT NULL,
  `donation_date` date NOT NULL,
  `status` int(11) NOT NULL,
  `remarks` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `donation_history`
--

INSERT INTO `donation_history` (`donation_id`, `request_id`, `donor_id`, `donation_date`, `status`, `remarks`, `created_at`) VALUES
(5, 143, 91, '2026-07-09', 8, 'Accepted by donor', '2026-07-09 17:21:40'),
(7, 145, 95, '2026-07-10', 8, 'Accepted by donor', '2026-07-10 03:53:39'),
(8, 139, 95, '2026-07-10', 8, 'Accepted by donor', '2026-07-10 03:53:55'),
(9, 146, 96, '2026-07-10', 8, 'Accepted by donor', '2026-07-10 04:01:38'),
(10, 149, 98, '2026-07-10', 8, 'Accepted by donor', '2026-07-10 04:25:19'),
(12, 137, 99, '2026-07-10', 8, 'Accepted by donor', '2026-07-10 04:30:17');

-- --------------------------------------------------------

--
-- Table structure for table `donors`
--

CREATE TABLE `donors` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `weight` varchar(50) DEFAULT NULL,
  `last_donation_date` date DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `profile_photo` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `donors`
--

INSERT INTO `donors` (`id`, `user_id`, `weight`, `last_donation_date`, `created_at`, `profile_photo`) VALUES
(11, 126, NULL, NULL, NULL, NULL),
(12, 127, NULL, NULL, NULL, NULL),
(13, 134, NULL, NULL, NULL, NULL),
(14, 137, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `email_verifications`
--

CREATE TABLE `email_verifications` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `token` char(64) NOT NULL,
  `expires_at` datetime NOT NULL,
  `verified_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `master_data`
--

CREATE TABLE `master_data` (
  `id` int(11) NOT NULL,
  `category` varchar(50) NOT NULL,
  `code` varchar(50) NOT NULL,
  `label` varchar(100) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `master_data`
--

INSERT INTO `master_data` (`id`, `category`, `code`, `label`, `description`, `is_active`, `created_at`) VALUES
(1, 'STATUS', 'ACTIVE', 'Active', 'Active account', 1, '2026-06-26 06:58:02'),
(2, 'STATUS', 'INACTIVE', 'Inactive', 'Inactive account', 1, '2026-06-26 06:58:02'),
(3, 'STATUS', 'PENDING', 'Pending', 'Waiting for approval', 1, '2026-06-26 06:58:02'),
(4, 'STATUS', 'SUSPENDED', 'Suspended', 'Suspended account', 1, '2026-06-26 06:58:02'),
(5, 'AVAILABILITY', 'AVAILABLE', 'Available', 'Ready to donate', 1, '2026-06-26 06:58:02'),
(6, 'AVAILABILITY', 'UNAVAILABLE', 'Unavailable', 'Currently unavailable', 1, '2026-06-26 06:58:02'),
(7, 'REQUEST_STATUS', 'PENDING', 'Pending', 'Waiting for donor', 1, '2026-06-26 06:58:02'),
(8, 'REQUEST_STATUS', 'ACCEPTED', 'Accepted', 'Donor accepted', 1, '2026-06-26 06:58:02'),
(9, 'REQUEST_STATUS', 'COMPLETED', 'Completed', 'Donation completed', 1, '2026-06-26 06:58:02'),
(10, 'REQUEST_STATUS', 'CANCELLED', 'Cancelled', 'Request cancelled', 1, '2026-06-26 06:58:02'),
(11, 'RESPONSE_STATUS', 'PENDING', 'Pending', 'Waiting for donor response', 1, '2026-06-26 06:58:02'),
(12, 'RESPONSE_STATUS', 'ACCEPTED', 'Accepted', 'Donor accepted', 1, '2026-06-26 06:58:02'),
(13, 'RESPONSE_STATUS', 'DECLINED', 'Declined', 'Donor declined', 1, '2026-06-26 06:58:02'),
(14, 'NOTIFICATION_TYPE', 'REQUEST', 'Blood Request', 'New blood request notification', 1, '2026-06-26 06:58:02'),
(15, 'NOTIFICATION_TYPE', 'APPROVAL', 'Approval', 'Approval notification', 1, '2026-06-26 06:58:02'),
(16, 'NOTIFICATION_TYPE', 'REMINDER', 'Reminder', 'Reminder notification', 1, '2026-06-26 06:58:02'),
(17, 'BLOOD_GROUP', 'A_POS', 'A+', 'A Positive', 1, '2026-06-26 06:58:23'),
(18, 'BLOOD_GROUP', 'A_NEG', 'A-', 'A Negative', 1, '2026-06-26 06:58:23'),
(19, 'BLOOD_GROUP', 'B_POS', 'B+', 'B Positive', 1, '2026-06-26 06:58:23'),
(20, 'BLOOD_GROUP', 'B_NEG', 'B-', 'B Negative', 1, '2026-06-26 06:58:23'),
(21, 'BLOOD_GROUP', 'AB_POS', 'AB+', 'AB Positive', 1, '2026-06-26 06:58:23'),
(22, 'BLOOD_GROUP', 'AB_NEG', 'AB-', 'AB Negative', 1, '2026-06-26 06:58:23'),
(23, 'BLOOD_GROUP', 'O_POS', 'O+', 'O Positive', 1, '2026-06-26 06:58:23'),
(24, 'BLOOD_GROUP', 'O_NEG', 'O-', 'O Negative', 1, '2026-06-26 06:58:23'),
(25, 'URGENCY', 'LOW', 'Low', 'Low priority', 1, '2026-06-26 06:58:46'),
(26, 'URGENCY', 'MEDIUM', 'Medium', 'Medium priority', 1, '2026-06-26 06:58:46'),
(27, 'URGENCY', 'HIGH', 'High', 'High priority', 1, '2026-06-26 06:58:46'),
(28, 'URGENCY', 'CRITICAL', 'Critical', 'Immediate blood needed', 1, '2026-06-26 06:58:46'),
(29, 'MESSAGE_TYPE', 'REQUEST', 'Blood Request', 'New blood request message', 1, '2026-06-26 07:02:21'),
(30, 'MESSAGE_TYPE', 'ACCEPTED', 'Request Accepted', 'Donor accepted the blood request', 1, '2026-06-26 07:02:21'),
(31, 'MESSAGE_TYPE', 'DECLINED', 'Request Declined', 'Donor declined the blood request', 1, '2026-06-26 07:02:21'),
(32, 'MESSAGE_TYPE', 'COMPLETED', 'Donation Completed', 'Donation has been completed', 1, '2026-06-26 07:02:21'),
(33, 'MESSAGE_TYPE', 'REMINDER', 'Reminder', 'Reminder notification', 1, '2026-06-26 07:02:21'),
(34, 'MESSAGE_TYPE', 'ANNOUNCEMENT', 'Announcement', 'General system announcement', 1, '2026-06-26 07:02:21'),
(35, 'MESSAGE_TYPE', 'REQUEST', 'Blood Request', 'New blood request message', 1, '2026-06-26 07:04:43'),
(36, 'MESSAGE_TYPE', 'ACCEPTED', 'Request Accepted', 'Donor accepted the blood request', 1, '2026-06-26 07:04:43'),
(37, 'MESSAGE_TYPE', 'DECLINED', 'Request Declined', 'Donor declined the blood request', 1, '2026-06-26 07:04:43'),
(38, 'MESSAGE_TYPE', 'COMPLETED', 'Donation Completed', 'Donation completed successfully', 1, '2026-06-26 07:04:43'),
(39, 'MESSAGE_TYPE', 'REMINDER', 'Reminder', 'Reminder notification', 1, '2026-06-26 07:04:43'),
(40, 'MESSAGE_TYPE', 'ANNOUNCEMENT', 'Announcement', 'General system announcement', 1, '2026-06-26 07:04:43'),
(41, 'NOTIFICATION_TYPE', 'PROFILE_UPDATE', 'Profile Updated', NULL, 1, '2026-07-03 17:58:23');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `notification_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `notification_type_id` int(11) NOT NULL,
  `title` varchar(200) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `is_read` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `type` varchar(50) NOT NULL DEFAULT 'general'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`notification_id`, `user_id`, `notification_type_id`, `title`, `message`, `is_read`, `created_at`, `type`) VALUES
(69, 57, 14, 'New Blood Request', 'New blood request submitted by judy (AB-) and is waiting for matching donors.', 1, '2026-07-06 15:21:12', 'request'),
(71, 57, 14, 'New Blood Request', 'New blood request submitted by nick (B+) and is waiting for matching donors.', 1, '2026-07-06 15:33:48', 'request'),
(73, 57, 14, 'New Blood Request', 'New blood request submitted by dar (O+) and is waiting for matching donors.', 1, '2026-07-06 16:10:57', 'request'),
(75, 57, 14, 'New Blood Request', 'New blood request submitted by ngal (O-) and is waiting for matching donors.', 1, '2026-07-06 16:22:05', 'request'),
(80, 57, 14, 'New Blood Request', 'New blood request submitted by bunny (O+) and is waiting for matching donors.', 1, '2026-07-06 16:52:33', 'request'),
(82, 57, 14, 'New Blood Request', 'New blood request submitted by bb (AB+) and is waiting for matching donors.', 1, '2026-07-06 16:52:56', 'request'),
(84, 57, 14, 'New Blood Request', 'New blood request submitted by bunn (AB-) and is waiting for matching donors.', 1, '2026-07-06 16:53:58', 'request'),
(86, 57, 14, 'New Blood Request', 'New blood request submitted by nommi (O+) and is waiting for matching donors.', 1, '2026-07-06 17:18:50', 'request'),
(88, 57, 14, 'New Blood Request', 'New blood request submitted by dardar (AB+) and is waiting for matching donors.', 1, '2026-07-06 17:37:18', 'request'),
(92, 57, 14, 'New Blood Request', 'New blood request submitted by dar (A+) and is waiting for matching donors.', 1, '2026-07-06 17:43:39', 'request'),
(94, 57, 41, 'Patient Profile Updated', 'dardar updated their profile information.', 1, '2026-07-06 17:57:18', 'profile_update'),
(96, 57, 41, 'Patient Profile Updated', 'bunny updated their profile information.', 1, '2026-07-07 05:11:37', 'profile_update'),
(98, 57, 41, 'Patient Profile Updated', 'dardarwinnhtet updated their profile information.', 1, '2026-07-07 05:13:49', 'profile_update'),
(100, 57, 41, 'Patient Profile Updated', 'kk updated their profile information.', 1, '2026-07-07 05:30:50', 'profile_update'),
(102, 57, 14, 'New Blood Request', 'New blood request submitted by dar (O+) and is waiting for matching donors.', 1, '2026-07-07 07:31:24', 'request'),
(104, 57, 14, 'New Blood Request', 'New blood request submitted by ngal (B+) and is waiting for matching donors.', 1, '2026-07-07 07:34:07', 'request'),
(106, 57, 14, 'New Blood Request', 'New blood request submitted by judy (AB+) and is waiting for matching donors.', 1, '2026-07-07 07:47:45', 'request'),
(108, 57, 14, 'New Blood Request', 'New blood request REQ20260707161950 from kk (AB+)', 1, '2026-07-07 09:49:50', 'request'),
(110, 57, 41, 'Patient Profile Updated', 'dardarwinnhtet1 updated their profile information.', 1, '2026-07-07 10:13:40', 'profile_update'),
(112, 57, 14, 'New Blood Request', 'New blood request REQ20260707171227 from dd (AB+)', 1, '2026-07-07 10:42:27', 'request'),
(114, 57, 14, 'New Blood Request', 'New blood request REQ20260707171315 from judy (O+)', 1, '2026-07-07 10:43:15', 'request'),
(116, 57, 14, 'New Blood Request', 'New blood request REQ20260707171453 from judy (O+)', 1, '2026-07-07 10:44:53', 'request'),
(118, 57, 14, 'New Blood Request', 'New blood request REQ20260707171517 from nick (O+)', 1, '2026-07-07 10:45:17', 'request'),
(120, 57, 14, 'New Blood Request', 'New blood request REQ20260708004052 from kk (AB+)', 1, '2026-07-07 18:10:52', 'request'),
(122, 57, 14, 'New Blood Request', 'New blood request REQ20260708101033 from nick (O-)', 1, '2026-07-08 03:40:33', 'request'),
(126, 57, 41, 'Patient Profile Updated', 'may updated their profile information.', 1, '2026-07-08 06:55:01', 'profile_update'),
(128, 57, 14, 'New Blood Request', 'New blood request REQ20260708132527 from may (AB+)', 1, '2026-07-08 06:55:27', 'request'),
(130, 57, 14, 'New Blood Request', 'New blood request REQ20260708134218 from akari (A+)', 1, '2026-07-08 07:12:19', 'request'),
(132, 57, 14, 'New Blood Request', 'New blood request REQ20260708134812 from akariri (AB+)', 1, '2026-07-08 07:18:12', 'request'),
(134, 57, 14, 'New Blood Request', 'New blood request REQ20260708135434 from kk (AB+)', 1, '2026-07-08 07:24:34', 'request'),
(136, 57, 14, 'New Blood Request', 'New blood request REQ20260708140129 from yy (AB+)', 1, '2026-07-08 07:31:29', 'request'),
(137, 57, 14, 'Blood Request Accepted', 'Blood request REQ20260708140129 has been accepted by donor hsumyatakari.', 1, '2026-07-08 07:31:54', 'request'),
(142, 57, 14, 'New Blood Request', 'New blood request REQ20260708142435 from akari (AB+)', 1, '2026-07-08 07:54:35', 'request'),
(145, 57, 14, 'New Blood Request', 'New blood request REQ20260708142827 from tt (AB+)', 1, '2026-07-08 07:58:27', 'request'),
(146, 57, 14, 'Blood Request Accepted', 'Blood request REQ20260708142827 has been accepted by donor hsumyatakari.', 1, '2026-07-08 07:59:01', 'request'),
(150, 57, 41, 'Donor Profile Updated', 'hsumyatakarilay updated their donor profile information.', 1, '2026-07-08 08:00:10', 'profile_update'),
(151, 57, 14, 'Blood Request Accepted', 'Blood request REQ20260708142435 has been accepted by donor hsumyatakarilay.', 1, '2026-07-08 08:00:39', 'request'),
(155, 57, 41, 'Patient Profile Updated', 'akarilayy updated their profile information.', 1, '2026-07-08 08:05:21', 'profile_update'),
(157, 57, 41, 'Donor Profile Updated', 'hsumyatakar updated their donor profile information.', 1, '2026-07-08 08:05:47', 'profile_update'),
(159, 57, 41, 'Donor Profile Updated', 'hsumyatakary updated their donor profile information.', 1, '2026-07-08 08:06:11', 'profile_update'),
(161, 57, 41, 'Donor Profile Updated', 'hsumyatakari updated their donor profile information.', 1, '2026-07-08 08:06:38', 'profile_update'),
(163, 57, 41, 'Donor Profile Updated', 'hsumyatakarilay updated their donor profile information.', 1, '2026-07-08 08:11:18', 'profile_update'),
(165, 57, 41, 'Donor Profile Updated', 'hsumyatakari updated their donor profile information.', 1, '2026-07-08 08:30:21', 'profile_update'),
(167, 57, 41, 'Patient Profile Updated', 'akarilay updated their profile information.', 1, '2026-07-08 08:33:29', 'profile_update'),
(170, 57, 14, 'New Blood Request', 'New blood request REQ20260708152349 from akari (AB+)', 1, '2026-07-08 08:53:49', 'request'),
(171, 57, 14, 'Blood Request Accepted', 'Blood request REQ20260708152349 has been accepted by donor hsumyatakari.', 1, '2026-07-08 08:54:09', 'request'),
(176, 57, 14, 'New Blood Request', 'New blood request REQ20260708162617 from kaung (AB+)', 1, '2026-07-08 09:56:17', 'request'),
(179, 57, 14, 'New Blood Request', 'New blood request REQ20260708162654 from yy (AB+)', 1, '2026-07-08 09:56:54', 'request'),
(181, 57, 14, 'New Blood Request', 'New blood request REQ20260708163118 from akari (O-)', 1, '2026-07-08 10:01:18', 'request'),
(182, 57, 14, 'Blood Request Accepted', 'Blood request REQ20260708162654 has been accepted by donor hsumyatakari.', 1, '2026-07-08 10:02:09', 'request'),
(185, 57, 14, 'Blood Request Accepted', 'Blood request REQ20260708162617 has been accepted by donor hsumyatakari.', 1, '2026-07-08 10:02:21', 'request'),
(190, 57, 14, 'New Blood Request', 'New blood request REQ20260708163841 from kk (AB+)', 1, '2026-07-08 10:08:41', 'request'),
(191, 57, 14, 'Blood Request Accepted', 'Blood request REQ20260708163841 has been accepted by donor hsumyatakari.', 1, '2026-07-08 10:09:16', 'request'),
(195, 57, 14, 'New Blood Request', 'New blood request REQ20260708231304 from kk (A+)', 1, '2026-07-08 16:43:04', 'request'),
(196, 57, 14, 'Blood Request Accepted', 'Blood request REQ20260708231304 has been accepted by donor dd.', 1, '2026-07-08 16:45:40', 'request'),
(201, 57, 14, 'New Blood Request', 'New blood request REQ20260708232910 from kk (A+)', 1, '2026-07-08 16:59:10', 'request'),
(202, 57, 14, 'Blood Request Accepted', 'Blood request REQ20260708232910 has been accepted by donor dd.', 1, '2026-07-08 17:01:02', 'request'),
(206, 57, 41, 'Patient Profile Updated', 'kay updated their profile information.', 1, '2026-07-08 17:12:21', 'profile_update'),
(209, 57, 14, 'New Blood Request', 'New blood request REQ20260708234301 from nn (A+)', 1, '2026-07-08 17:13:01', 'request'),
(211, 57, 41, 'Donor Profile Updated', 'dar updated their donor profile information.', 1, '2026-07-08 17:13:36', 'profile_update'),
(213, 57, 41, 'Patient Profile Updated', 'kayy updated their profile information.', 1, '2026-07-08 17:16:02', 'profile_update'),
(215, 57, 41, 'Donor Profile Updated', 'darr updated their donor profile information.', 1, '2026-07-08 17:16:43', 'profile_update'),
(216, 57, 14, 'Blood Request Accepted', 'Blood request REQ20260708234301 has been accepted by donor darr.', 1, '2026-07-08 17:16:57', 'request'),
(221, 57, 14, 'New Blood Request', 'New blood request REQ20260709002452 from kaung (A+)', 1, '2026-07-08 17:54:52', 'request'),
(222, 57, 14, 'Blood Request Accepted', 'Blood request REQ20260709002452 has been accepted by donor darr.', 1, '2026-07-08 17:55:55', 'request'),
(226, 79, 14, 'New Blood Request', 'Patient nn has requested B+ blood. Please review the request.', 1, '2026-07-09 02:49:44', 'request'),
(227, 57, 14, 'New Blood Request', 'New blood request REQ20260709091944 from nn (B+)', 1, '2026-07-09 02:49:44', 'request'),
(228, 57, 14, 'Blood Request Accepted', 'Blood request REQ20260709091944 has been accepted and assigned to donor nick.', 1, '2026-07-09 02:52:48', 'request'),
(229, 79, 14, 'Blood Request Assigned', 'You have been selected for blood request REQ20260709091944. Please contact the hospital or patient coordinator.', 1, '2026-07-09 02:52:48', 'request'),
(233, 57, 14, 'New Blood Request', 'New blood request REQ20260709092426 from yy (A+)', 1, '2026-07-09 02:54:26', 'request'),
(235, 57, 14, 'New Blood Request', 'New blood request REQ20260709092447 from tt (A-)', 1, '2026-07-09 02:54:47', 'request'),
(236, 57, 14, 'Blood Request Accepted', 'Blood request REQ20260709092426 has been accepted and assigned to donor darr.', 1, '2026-07-09 02:55:39', 'request'),
(241, 57, 14, 'New Blood Request', 'New blood request REQ20260709092928 from kk (A+)', 1, '2026-07-09 02:59:28', 'request'),
(242, 57, 14, 'Blood Request Accepted', 'Blood request REQ20260709092928 has been accepted and assigned to donor darr.', 1, '2026-07-09 03:00:31', 'request'),
(247, 57, 14, 'New Blood Request', 'New blood request REQ20260709093131 from yy (A+)', 1, '2026-07-09 03:01:31', 'request'),
(248, 57, 14, 'Blood Request Accepted', 'Blood request REQ20260709093131 has been accepted and assigned to donor darr.', 1, '2026-07-09 03:01:58', 'request'),
(253, 57, 14, 'New Blood Request', 'New blood request REQ20260709093611 from akari (A+)', 1, '2026-07-09 03:06:11', 'request'),
(254, 57, 14, 'Blood Request Accepted', 'Blood request REQ20260709093611 has been accepted and assigned to donor darr.', 1, '2026-07-09 03:06:36', 'request'),
(259, 57, 14, 'New Blood Request', 'New blood request REQ20260709095641 from kk (A+)', 1, '2026-07-09 03:26:41', 'request'),
(260, 57, 14, 'Blood Request Assigned', 'Blood request REQ20260709095641 has been assigned to donor darr and is waiting for donor acceptance.', 1, '2026-07-09 03:27:06', 'request'),
(263, 57, 14, 'Blood Request Accepted', 'Blood request REQ20260709095641 has been accepted by donor darr.', 1, '2026-07-09 03:27:31', 'request'),
(268, 57, 14, 'New Blood Request', 'New blood request REQ20260709095919 from kaung (A+)', 1, '2026-07-09 03:29:19', 'request'),
(269, 57, 14, 'Blood Request Assigned', 'Blood request REQ20260709095919 has been assigned to donor darr and is waiting for donor acceptance.', 1, '2026-07-09 03:30:25', 'request'),
(272, 57, 14, 'Blood Request Accepted', 'Blood request REQ20260709095919 has been accepted by donor darr.', 1, '2026-07-09 03:30:53', 'request'),
(275, 57, 14, 'Blood Request Accepted', 'Blood request REQ20260708134218 has been accepted by donor darr.', 1, '2026-07-09 04:04:28', 'request'),
(279, 57, 14, 'New Blood Request', 'New blood request REQ20260709104411 from nn (A+)', 1, '2026-07-09 04:14:11', 'request'),
(282, 57, 14, 'New Blood Request', 'New blood request REQ20260709104517 from yy (O+)', 1, '2026-07-09 04:15:17', 'request'),
(283, 57, 14, 'Blood Request Assigned', 'Blood request REQ20260709104517 has been assigned to donor judy and is waiting for donor acceptance.', 1, '2026-07-09 04:15:39', 'request'),
(286, 57, 14, 'Blood Request Accepted', 'Blood request REQ20260709104517 has been accepted by donor judy.', 1, '2026-07-09 04:35:57', 'request'),
(290, 57, 14, 'New Blood Request', 'New blood request REQ20260709110842 from yy (O-)', 1, '2026-07-09 04:38:42', 'request'),
(291, 57, 14, 'Blood Request Assigned', 'Blood request REQ20260709110842 has been assigned to donor kay and is waiting for donor acceptance.', 1, '2026-07-09 04:43:34', 'request'),
(294, 57, 14, 'Blood Request Accepted', 'Blood request REQ20260709110842 has been accepted by donor kay.', 1, '2026-07-09 04:44:18', 'request'),
(299, 57, 14, 'New Blood Request', 'New blood request REQ20260709113335 from nn (AB+)', 1, '2026-07-09 05:03:35', 'request'),
(300, 57, 14, 'Blood Request Accepted', 'Blood request REQ20260709113335 has been accepted by donor aliceko.', 1, '2026-07-09 05:05:46', 'request'),
(304, 57, 14, 'New Blood Request', 'New blood request REQ20260709120531 from tt (AB+)', 1, '2026-07-09 05:35:31', 'request'),
(305, 57, 14, 'Blood Request Accepted', 'Blood request REQ20260709120531 has been accepted by donor aliceko.', 1, '2026-07-09 05:35:45', 'request'),
(308, 79, 41, 'Profile Updated', 'Your donor profile has been updated successfully.', 1, '2026-07-09 07:04:35', 'profile_update'),
(309, 57, 41, 'Donor Profile Updated', 'nick updated their donor profile information.', 1, '2026-07-09 07:04:35', 'profile_update'),
(310, 82, 14, 'Blood Request Submitted', 'Your blood request is now pending.', 1, '2026-07-09 07:07:58', 'request'),
(311, 57, 14, 'New Blood Request', 'New blood request REQ20260709133758 from juu (AB+)', 1, '2026-07-09 07:07:58', 'request'),
(312, 82, 41, 'Profile Updated', 'Your profile has been updated successfully.', 0, '2026-07-09 07:08:32', 'profile_update'),
(313, 57, 41, 'Patient Profile Updated', 'judy updated their profile information.', 1, '2026-07-09 07:08:32', 'profile_update'),
(314, 82, 14, 'Blood Request Submitted', 'Your blood request is now pending.', 0, '2026-07-09 07:09:50', 'request'),
(315, 57, 14, 'New Blood Request', 'New blood request REQ20260709133950 from juu (B+)', 1, '2026-07-09 07:09:50', 'request'),
(316, 57, 14, 'Blood Request Accepted', 'Blood request REQ20260709133950 has been accepted by donor nick.', 1, '2026-07-09 07:11:00', 'request'),
(317, 79, 14, 'Blood Request Accepted', 'You accepted blood request REQ20260709133950. The patient will be notified shortly.', 1, '2026-07-09 07:11:00', 'request'),
(318, 82, 14, 'Blood Request Accepted', 'Donor nick has accepted your blood request REQ20260709133950.', 0, '2026-07-09 07:11:00', 'request'),
(319, 82, 14, 'Blood Request Submitted', 'Your blood request is now pending.', 1, '2026-07-09 07:11:57', 'request'),
(320, 57, 14, 'New Blood Request', 'New blood request REQ20260709134157 from dd (A-)', 1, '2026-07-09 07:11:57', 'request'),
(321, 57, 14, 'Blood Request Accepted', 'Blood request REQ20260709133758 has been accepted by donor Unknown donor.', 1, '2026-07-09 07:17:23', 'request'),
(322, 82, 14, 'Blood Request Accepted', 'Donor A donor has accepted your blood request REQ20260709133758.', 1, '2026-07-09 07:17:23', 'request'),
(325, 82, 41, 'Profile Updated', 'Your profile has been updated successfully.', 1, '2026-07-09 07:18:43', 'profile_update'),
(326, 57, 41, 'Patient Profile Updated', 'judyy updated their profile information.', 1, '2026-07-09 07:18:43', 'profile_update'),
(327, 57, 41, 'Donor Profile Updated', 'hsumyatakari updated their donor profile information.', 1, '2026-07-09 07:20:01', 'profile_update'),
(328, 57, 41, 'Donor Profile Updated', 'hsumyatakari updated their donor profile information.', 1, '2026-07-09 07:20:07', 'profile_update'),
(329, 82, 14, 'Blood Request Submitted', 'Your blood request is now pending.', 1, '2026-07-09 07:25:05', 'request'),
(331, 57, 14, 'New Blood Request', 'New blood request REQ20260709135505 from juudy (AB-)', 1, '2026-07-09 07:25:05', 'request'),
(332, 57, 14, 'Blood Request Assigned', 'Blood request REQ20260709135505 has been assigned to donor nicky and is waiting for donor acceptance.', 1, '2026-07-09 07:26:04', 'request'),
(334, 82, 14, 'Blood Request Matched', 'A donor has been assigned for your blood request REQ20260709135505 and is pending acceptance.', 0, '2026-07-09 07:26:04', 'request'),
(335, 57, 14, 'Blood Request Accepted', 'Blood request REQ20260709135505 has been accepted by donor nicky.', 1, '2026-07-09 07:26:20', 'request'),
(337, 82, 14, 'Blood Request Accepted', 'Donor nicky has accepted your blood request REQ20260709135505.', 0, '2026-07-09 07:26:20', 'request'),
(338, 82, 14, 'Blood Request Submitted', 'Your blood request is now pending.', 0, '2026-07-09 07:47:48', 'request'),
(339, 57, 14, 'New Blood Request', 'New blood request REQ20260709141748 from jue (A+)', 1, '2026-07-09 07:47:48', 'request'),
(340, 57, 14, 'Blood Request Assigned', 'Blood request REQ20260709141748 has been assigned to donor nickyy and is waiting for donor acceptance.', 1, '2026-07-09 07:50:19', 'request'),
(342, 82, 14, 'Blood Request Matched', 'A donor has been assigned for your blood request REQ20260709141748 and is pending acceptance.', 0, '2026-07-09 07:50:19', 'request'),
(343, 57, 14, 'Blood Request Accepted', 'Blood request REQ20260709141748 has been accepted by donor nickyy.', 1, '2026-07-09 07:50:40', 'request'),
(345, 82, 14, 'Blood Request Accepted', 'Donor nickyy has accepted your blood request REQ20260709141748.', 0, '2026-07-09 07:50:40', 'request'),
(347, 57, 41, 'Donor Profile Updated', 'nickyy updated their donor profile information.', 1, '2026-07-09 07:52:08', 'profile_update'),
(349, 57, 41, 'Donor Profile Updated', 'nicckyy updated their donor profile information.', 1, '2026-07-09 07:52:28', 'profile_update'),
(351, 57, 41, 'Donor Profile Updated', 'nickyy updated their donor profile information.', 1, '2026-07-09 07:52:41', 'profile_update'),
(353, 57, 41, 'Donor Profile Updated', 'nickyy updated their donor profile information.', 1, '2026-07-09 07:52:58', 'profile_update'),
(355, 57, 41, 'Donor Profile Updated', 'nickyy updated their donor profile information.', 1, '2026-07-09 07:53:17', 'profile_update'),
(356, 79, 14, 'Blood Request Submitted', 'Your blood request is now pending.', 1, '2026-07-09 08:00:03', 'request'),
(357, 57, 14, 'New Blood Request', 'New blood request REQ20260709143003 from nn (O+)', 1, '2026-07-09 08:00:03', 'request'),
(358, 79, 14, 'Blood Request Submitted', 'Your blood request is now pending.', 1, '2026-07-09 08:02:49', 'request'),
(359, 57, 14, 'New Blood Request', 'New blood request REQ20260709143249 from tt (A+)', 1, '2026-07-09 08:02:49', 'request'),
(360, 57, 14, 'Blood Request Assigned', 'Blood request REQ20260709143003 has been assigned to donor dar and is waiting for donor acceptance.', 1, '2026-07-09 08:03:42', 'request'),
(362, 79, 14, 'Blood Request Matched', 'A donor has been assigned for your blood request REQ20260709143003 and is pending acceptance.', 1, '2026-07-09 08:03:42', 'request'),
(363, 57, 14, 'Blood Request Accepted', 'Blood request REQ20260709143003 has been accepted by donor dar.', 1, '2026-07-09 08:04:09', 'request'),
(365, 79, 14, 'Blood Request Accepted', 'Donor dar has accepted your blood request REQ20260709143003.', 1, '2026-07-09 08:04:09', 'request'),
(366, 79, 14, 'Blood Request Submitted', 'Your blood request is now pending.', 0, '2026-07-09 08:19:20', 'request'),
(367, 57, 14, 'New Blood Request', 'New blood request REQ20260709144920 from nn (B+)', 1, '2026-07-09 08:19:20', 'request'),
(368, 79, 14, 'Blood Request Submitted', 'Your blood request is now pending.', 0, '2026-07-09 08:19:46', 'request'),
(369, 57, 14, 'New Blood Request', 'New blood request REQ20260709144946 from akari (A-)', 1, '2026-07-09 08:19:46', 'request'),
(370, 79, 14, 'Blood Request Submitted', 'Your blood request is now pending.', 0, '2026-07-09 08:20:32', 'request'),
(371, 57, 14, 'New Blood Request', 'New blood request REQ20260709145032 from kk (AB+)', 1, '2026-07-09 08:20:32', 'request'),
(372, 79, 14, 'Blood Request Submitted', 'Your blood request is now pending.', 0, '2026-07-09 08:50:56', 'request'),
(374, 57, 14, 'New Blood Request', 'New blood request REQ20260709152056 from nn (AB-)', 1, '2026-07-09 08:50:56', 'request'),
(375, 57, 14, 'Blood Request Assigned', 'Blood request REQ20260709152056 has been assigned to donor dardar and is waiting for donor acceptance.', 1, '2026-07-09 08:51:34', 'request'),
(377, 79, 14, 'Blood Request Matched', 'A donor has been assigned for your blood request REQ20260709152056 and is pending acceptance.', 0, '2026-07-09 08:51:34', 'request'),
(378, 89, 14, 'Blood Request Submitted', 'Your blood request is now pending.', 1, '2026-07-09 09:25:04', 'request'),
(379, 57, 14, 'New Blood Request', 'New blood request REQ20260709155504 from nn (B+)', 1, '2026-07-09 09:25:04', 'request'),
(380, 89, 41, 'Profile Updated', 'Your profile has been updated successfully.', 1, '2026-07-09 09:55:00', 'profile_update'),
(381, 57, 41, 'Patient Profile Updated', 'kay kay updated their profile information.', 1, '2026-07-09 09:55:00', 'profile_update'),
(382, 57, 14, 'Blood Request Assigned', 'Blood request REQ20260709155504 has been assigned to donor dardarwinhtet and is waiting for donor acceptance.', 1, '2026-07-09 10:28:26', 'request'),
(384, 89, 14, 'Blood Request Matched', 'A donor has been assigned for your blood request REQ20260709155504 and is pending acceptance.', 1, '2026-07-09 10:28:26', 'request'),
(385, 57, 14, 'Blood Request Accepted', 'Blood request REQ20260709152056 has been accepted by donor dardar.', 1, '2026-07-09 10:28:45', 'request'),
(387, 79, 14, 'Blood Request Accepted', 'Donor dardar has accepted your blood request REQ20260709152056.', 0, '2026-07-09 10:28:45', 'request'),
(388, 89, 14, 'Blood Request Submitted', 'Your blood request is now pending.', 1, '2026-07-09 11:06:46', 'request'),
(389, 91, 14, 'New Blood Request', 'Patient yy has requested O- blood. Please review the request.', 1, '2026-07-09 11:06:46', 'request'),
(390, 57, 14, 'New Blood Request', 'New blood request REQ20260709173646 from yy (O-)', 1, '2026-07-09 11:06:46', 'request'),
(391, 57, 14, 'Blood Request Assigned', 'Blood request REQ20260709173646 has been assigned to donor bady and is waiting for donor acceptance.', 1, '2026-07-09 11:07:27', 'request'),
(392, 91, 14, 'Blood Request Assigned', 'You have been assigned to blood request REQ20260709173646. Please review and accept it when ready.', 1, '2026-07-09 11:07:27', 'request'),
(393, 89, 14, 'Blood Request Matched', 'A donor has been assigned for your blood request REQ20260709173646 and is pending acceptance.', 1, '2026-07-09 11:07:27', 'request'),
(394, 57, 14, 'Blood Request Accepted', 'Blood request REQ20260709173646 has been accepted by donor bady.', 1, '2026-07-09 11:07:50', 'request'),
(395, 91, 14, 'Blood Request Accepted', 'You accepted blood request REQ20260709173646. The patient will be notified shortly.', 1, '2026-07-09 11:07:50', 'request'),
(396, 89, 14, 'Blood Request Accepted', 'Donor bady has accepted your blood request REQ20260709173646.', 1, '2026-07-09 11:07:50', 'request'),
(397, 89, 41, 'Profile Updated', 'Your profile has been updated successfully.', 1, '2026-07-09 17:09:45', 'profile_update'),
(398, 57, 41, 'Patient Profile Updated', 'kay updated their profile information.', 1, '2026-07-09 17:09:45', 'profile_update'),
(399, 89, 14, 'Blood Request Submitted', 'Your blood request is now pending.', 1, '2026-07-09 17:18:22', 'request'),
(400, 57, 14, 'New Blood Request', 'New blood request REQ20260709234822 from kk (O-)', 1, '2026-07-09 17:18:22', 'request'),
(401, 57, 14, 'Blood Request Accepted', 'Blood request REQ20260709234822 has been accepted by donor bady.', 1, '2026-07-09 17:21:40', 'request'),
(402, 91, 14, 'Blood Request Accepted', 'You accepted blood request REQ20260709234822. The patient will be notified shortly.', 1, '2026-07-09 17:21:40', 'request'),
(403, 89, 14, 'Blood Request Accepted', 'Donor bady has accepted your blood request REQ20260709234822.', 1, '2026-07-09 17:21:40', 'request'),
(404, 89, 14, 'Blood Request Submitted', 'Your blood request is now pending.', 1, '2026-07-09 17:24:22', 'request'),
(405, 92, 14, 'New Blood Request', 'Patient nn has requested B- blood. Please review the request.', 1, '2026-07-09 17:24:22', 'request'),
(406, 57, 14, 'New Blood Request', 'New blood request REQ20260709235422 from nn (B-)', 1, '2026-07-09 17:24:22', 'request'),
(407, 57, 14, 'Blood Request Assigned', 'Blood request REQ20260709235422 has been assigned to donor dodo and is waiting for donor acceptance.', 1, '2026-07-09 17:25:19', 'request'),
(408, 92, 14, 'Blood Request Assigned', 'You have been assigned to blood request REQ20260709235422. Please review and accept it when ready.', 1, '2026-07-09 17:25:19', 'request'),
(409, 89, 14, 'Blood Request Matched', 'A donor has been assigned for your blood request REQ20260709235422 and is pending acceptance.', 1, '2026-07-09 17:25:19', 'request'),
(410, 57, 14, 'Blood Request Accepted', 'Blood request REQ20260709235422 has been accepted by donor dodo.', 1, '2026-07-09 17:25:57', 'request'),
(411, 92, 14, 'Blood Request Accepted', 'You accepted blood request REQ20260709235422. The patient will be notified shortly.', 1, '2026-07-09 17:25:57', 'request'),
(412, 89, 14, 'Blood Request Accepted', 'Donor dodo has accepted your blood request REQ20260709235422.', 1, '2026-07-09 17:25:57', 'request'),
(413, 89, 41, 'Profile Updated', 'Your profile has been updated successfully.', 1, '2026-07-09 17:35:19', 'profile_update'),
(414, 57, 41, 'Patient Profile Updated', 'kay kay updated their profile information.', 1, '2026-07-09 17:35:19', 'profile_update'),
(415, 89, 41, 'Profile Updated', 'Your profile has been updated successfully.', 1, '2026-07-10 02:56:45', 'profile_update'),
(416, 57, 41, 'Patient Profile Updated', 'kay updated their profile information.', 1, '2026-07-10 02:56:45', 'profile_update'),
(417, 89, 41, 'Profile Updated', 'Your profile has been updated successfully.', 1, '2026-07-10 03:40:56', 'profile_update'),
(418, 57, 41, 'Patient Profile Updated', 'kay updated their profile information.', 1, '2026-07-10 03:40:56', 'profile_update'),
(419, 94, 41, 'Profile Updated', 'Your profile has been updated successfully.', 1, '2026-07-10 03:43:19', 'profile_update'),
(420, 57, 41, 'Patient Profile Updated', 'linalina updated their profile information.', 1, '2026-07-10 03:43:19', 'profile_update'),
(421, 94, 14, 'Blood Request Submitted', 'Your blood request is now pending.', 1, '2026-07-10 03:43:40', 'request'),
(422, 57, 14, 'New Blood Request', 'New blood request REQ20260710101340 from lina (AB+)', 1, '2026-07-10 03:43:40', 'request'),
(423, 94, 16, 'Duplicate Request Blocked', 'You already have a pending blood request.', 0, '2026-07-10 03:51:16', 'reminder'),
(424, 57, 14, 'Blood Request Assigned', 'Blood request REQ20260710101340 has been assigned to donor aliceko and is waiting for donor acceptance.', 1, '2026-07-10 03:53:09', 'request'),
(425, 95, 14, 'Blood Request Assigned', 'You have been assigned to blood request REQ20260710101340. Please review and accept it when ready.', 0, '2026-07-10 03:53:09', 'request'),
(426, 94, 14, 'Blood Request Matched', 'A donor has been assigned for your blood request REQ20260710101340 and is pending acceptance.', 0, '2026-07-10 03:53:09', 'request'),
(427, 57, 14, 'Blood Request Accepted', 'Blood request REQ20260710101340 has been accepted by donor aliceko.', 1, '2026-07-10 03:53:39', 'request'),
(428, 95, 14, 'Blood Request Accepted', 'You accepted blood request REQ20260710101340. The patient will be notified shortly.', 0, '2026-07-10 03:53:39', 'request'),
(429, 94, 14, 'Blood Request Accepted', 'Donor aliceko has accepted your blood request REQ20260710101340.', 0, '2026-07-10 03:53:39', 'request'),
(430, 57, 14, 'Blood Request Accepted', 'Blood request REQ20260709145032 has been accepted by donor aliceko.', 1, '2026-07-10 03:53:55', 'request'),
(431, 95, 14, 'Blood Request Accepted', 'You accepted blood request REQ20260709145032. The patient will be notified shortly.', 0, '2026-07-10 03:53:55', 'request'),
(432, 79, 14, 'Blood Request Accepted', 'Donor aliceko has accepted your blood request REQ20260709145032.', 0, '2026-07-10 03:53:55', 'request'),
(433, 97, 14, 'Blood Request Submitted', 'Your blood request is now pending.', 1, '2026-07-10 03:59:03', 'request'),
(434, 96, 14, 'New Blood Request', 'Patient kay has requested O+ blood. Please review the request.', 1, '2026-07-10 03:59:03', 'request'),
(435, 57, 14, 'New Blood Request', 'New blood request REQ20260710102903 from kay (O+)', 1, '2026-07-10 03:59:03', 'request'),
(436, 97, 16, 'Duplicate Request Blocked', 'You already have a pending blood request.', 1, '2026-07-10 04:00:09', 'reminder'),
(437, 97, 16, 'Duplicate Request Blocked', 'You already have a pending blood request.', 1, '2026-07-10 04:00:47', 'reminder'),
(438, 57, 14, 'Blood Request Assigned', 'Blood request REQ20260710102903 has been assigned to donor kaung and is waiting for donor acceptance.', 1, '2026-07-10 04:01:09', 'request'),
(439, 96, 14, 'Blood Request Assigned', 'You have been assigned to blood request REQ20260710102903. Please review and accept it when ready.', 1, '2026-07-10 04:01:09', 'request'),
(440, 97, 14, 'Blood Request Matched', 'A donor has been assigned for your blood request REQ20260710102903 and is pending acceptance.', 1, '2026-07-10 04:01:09', 'request'),
(441, 57, 14, 'Blood Request Accepted', 'Blood request REQ20260710102903 has been accepted by donor kaung.', 1, '2026-07-10 04:01:38', 'request'),
(442, 96, 14, 'Blood Request Accepted', 'You accepted blood request REQ20260710102903. The patient will be notified shortly.', 1, '2026-07-10 04:01:38', 'request'),
(443, 97, 14, 'Blood Request Accepted', 'Donor kaung has accepted your blood request REQ20260710102903.', 1, '2026-07-10 04:01:38', 'request'),
(444, 97, 14, 'Blood Request Submitted', 'Your blood request is now pending.', 1, '2026-07-10 04:02:43', 'request'),
(445, 57, 14, 'New Blood Request', 'New blood request REQ20260710103243 from kk (O+)', 1, '2026-07-10 04:02:43', 'request'),
(446, 97, 16, 'Request Cancelled', 'Your blood request has been cancelled.', 1, '2026-07-10 04:11:42', 'reminder'),
(447, 97, 14, 'Blood Request Submitted', 'Your blood request is now pending.', 1, '2026-07-10 04:12:34', 'request'),
(448, 57, 14, 'New Blood Request', 'New blood request REQ20260710104234 from akari (O+)', 1, '2026-07-10 04:12:34', 'request'),
(449, 97, 16, 'Request Cancelled', 'Your blood request has been cancelled.', 1, '2026-07-10 04:19:11', 'reminder'),
(450, 97, 14, 'Blood Request Submitted', 'Your blood request is now pending.', 1, '2026-07-10 04:23:01', 'request'),
(451, 57, 14, 'New Blood Request', 'New blood request REQ20260710105301 from yy (B+)', 1, '2026-07-10 04:23:02', 'request'),
(452, 57, 14, 'Blood Request Accepted', 'Blood request REQ20260710105301 has been accepted by donor bobo.', 1, '2026-07-10 04:25:19', 'request'),
(453, 98, 14, 'Blood Request Accepted', 'You accepted blood request REQ20260710105301. The patient will be notified shortly.', 1, '2026-07-10 04:25:19', 'request'),
(454, 97, 14, 'Blood Request Accepted', 'Donor bobo has accepted your blood request REQ20260710105301.', 1, '2026-07-10 04:25:19', 'request'),
(455, 57, 14, 'Blood Request Accepted', 'Blood request REQ20260709155504 has been accepted by donor bobo.', 1, '2026-07-10 04:25:49', 'request'),
(456, 98, 14, 'Blood Request Accepted', 'You accepted blood request REQ20260709155504. The patient will be notified shortly.', 0, '2026-07-10 04:25:49', 'request'),
(457, 89, 14, 'Blood Request Accepted', 'Donor bobo has accepted your blood request REQ20260709155504.', 0, '2026-07-10 04:25:49', 'request'),
(458, 97, 14, 'Blood Request Submitted', 'Your blood request is now pending.', 0, '2026-07-10 04:26:41', 'request'),
(459, 57, 14, 'New Blood Request', 'New blood request REQ20260710105641 from kk (B+)', 1, '2026-07-10 04:26:41', 'request'),
(460, 97, 16, 'Duplicate Request Blocked', 'You already have a pending blood request.', 0, '2026-07-10 04:29:25', 'reminder'),
(461, 97, 16, 'Request Cancelled', 'Your blood request has been cancelled.', 0, '2026-07-10 04:29:45', 'reminder'),
(462, 57, 16, 'Request Cancelled', 'A blood request has been cancelled by the patient.', 1, '2026-07-10 04:29:45', 'reminder'),
(463, 57, 14, 'Blood Request Accepted', 'Blood request REQ20260709144920 has been accepted by donor lwinlwin.', 1, '2026-07-10 04:30:17', 'request'),
(464, 99, 14, 'Blood Request Accepted', 'You accepted blood request REQ20260709144920. The patient will be notified shortly.', 1, '2026-07-10 04:30:17', 'request'),
(465, 79, 14, 'Blood Request Accepted', 'Donor lwinlwin has accepted your blood request REQ20260709144920.', 0, '2026-07-10 04:30:17', 'request'),
(466, 97, 14, 'Blood Request Submitted', 'Your blood request is now pending.', 0, '2026-07-10 04:37:51', 'request'),
(467, 100, 14, 'New Blood Request', 'Patient kk has requested B+ blood. Please review the request.', 1, '2026-07-10 04:37:51', 'request'),
(468, 57, 14, 'New Blood Request', 'New blood request REQ20260710110751 from kk (B+)', 1, '2026-07-10 04:37:51', 'request'),
(469, 89, 14, 'Blood Request Submitted', 'Your blood request is now pending.', 0, '2026-07-10 04:38:39', 'request'),
(470, 100, 14, 'New Blood Request', 'Patient kk has requested B+ blood. Please review the request.', 1, '2026-07-10 04:38:39', 'request'),
(471, 57, 14, 'New Blood Request', 'New blood request REQ20260710110839 from kk (B+)', 1, '2026-07-10 04:38:39', 'request'),
(472, 89, 16, 'Request Cancelled', 'Your blood request has been cancelled.', 0, '2026-07-10 04:39:44', 'reminder'),
(473, 57, 16, 'Request Cancelled', 'A blood request has been cancelled by the patient.', 1, '2026-07-10 04:39:44', 'reminder'),
(474, 57, 14, 'Blood Request Accepted', 'Blood request REQ20260710110751 has been accepted by donor zawzaw.', 1, '2026-07-10 04:40:31', 'request'),
(475, 100, 14, 'Blood Request Accepted', 'You accepted blood request REQ20260710110751. The patient will be notified shortly.', 0, '2026-07-10 04:40:31', 'request'),
(476, 97, 14, 'Blood Request Accepted', 'Donor zawzaw has accepted your blood request REQ20260710110751.', 0, '2026-07-10 04:40:31', 'request'),
(477, 89, 14, 'Blood Request Submitted', 'Your blood request is now pending.', 1, '2026-07-10 04:43:02', 'request'),
(478, 57, 14, 'New Blood Request', 'New blood request REQ20260710111302 from kay (A+)', 1, '2026-07-10 04:43:02', 'request'),
(479, 89, 16, 'Request Cancelled', 'Your blood request has been cancelled.', 0, '2026-07-10 04:47:23', 'reminder'),
(480, 57, 16, 'Request Cancelled', 'kay has cancelled their blood request.', 1, '2026-07-10 04:47:23', 'reminder'),
(481, 89, 14, 'Blood Request Submitted', 'Your blood request is now pending.', 0, '2026-07-10 04:48:24', 'request'),
(482, 101, 14, 'New Blood Request', 'Patient kk has requested A+ blood. Please review the request.', 1, '2026-07-10 04:48:24', 'request'),
(483, 57, 14, 'New Blood Request', 'New blood request REQ20260710111824 from kk (A+)', 1, '2026-07-10 04:48:24', 'request'),
(484, 89, 41, 'Profile Updated', 'Your profile has been updated successfully.', 0, '2026-07-10 04:50:26', 'profile_update'),
(485, 57, 41, 'Patient Profile Updated', 'kk updated their profile information.', 1, '2026-07-10 04:50:26', 'profile_update'),
(486, 89, 16, 'Request Cancelled', 'Your blood request has been cancelled.', 0, '2026-07-10 04:50:49', 'reminder'),
(487, 57, 16, 'Request Cancelled', 'kk has cancelled their blood request.', 1, '2026-07-10 04:50:49', 'reminder'),
(488, 89, 14, 'Blood Request Submitted', 'Your blood request is now pending.', 0, '2026-07-10 04:53:54', 'request'),
(489, 101, 14, 'New Blood Request', 'Patient kk has requested A+ blood. Please review the request.', 1, '2026-07-10 04:53:54', 'request'),
(490, 57, 14, 'New Blood Request', 'New blood request REQ20260710112354 from kk (A+)', 1, '2026-07-10 04:53:54', 'request'),
(491, 89, 16, 'Request Cancelled', 'Your blood request has been cancelled.', 0, '2026-07-10 04:54:36', 'reminder'),
(492, 101, 16, 'Request Cancelled', 'kk has cancelled their A+ blood request.', 0, '2026-07-10 04:54:36', 'reminder'),
(493, 57, 16, 'Request Cancelled', 'kk has cancelled their A+ blood request.', 1, '2026-07-10 04:54:36', 'reminder'),
(494, 89, 14, 'Blood Request Submitted', 'Your blood request is now pending.', 0, '2026-07-10 04:55:07', 'request'),
(495, 101, 14, 'New Blood Request', 'Patient kk has requested A+ blood. Please review the request.', 0, '2026-07-10 04:55:07', 'request'),
(496, 57, 14, 'New Blood Request', 'New blood request REQ20260710112507 from kk (A+)', 1, '2026-07-10 04:55:07', 'request'),
(497, 89, 16, 'Duplicate Request Blocked', 'You already have a pending blood request.', 1, '2026-07-10 04:55:26', 'reminder'),
(498, 57, 14, 'Blood Request Assigned', 'Blood request REQ20260709143249 has been assigned to donor myo and is waiting for donor acceptance.', 1, '2026-07-10 04:56:02', 'request'),
(499, 101, 14, 'Blood Request Assigned', 'You have been assigned to blood request REQ20260709143249. Please review and accept it when ready.', 1, '2026-07-10 04:56:02', 'request'),
(500, 79, 14, 'Blood Request Matched', 'A donor has been assigned for your blood request REQ20260709143249 and is pending acceptance.', 0, '2026-07-10 04:56:02', 'request'),
(501, 57, 14, 'Blood Request Accepted', 'Blood request REQ20260709143249 has been accepted by donor myo.', 1, '2026-07-10 04:56:46', 'request'),
(502, 101, 14, 'Blood Request Accepted', 'You accepted blood request REQ20260709143249. The patient will be notified shortly.', 1, '2026-07-10 04:56:46', 'request'),
(503, 79, 14, 'Blood Request Accepted', 'Donor myo has accepted your blood request REQ20260709143249.', 0, '2026-07-10 04:56:46', 'request'),
(505, 57, 41, 'Patient Profile Updated', 'Kay Kay updated their profile information.', 1, '2026-07-10 14:32:44', 'profile_update'),
(507, 57, 41, 'Donor Profile Updated', 'Htet Nandar Winn updated their donor profile information.', 1, '2026-07-10 14:36:47', 'profile_update'),
(510, 57, 14, 'New Blood Request', 'New blood request REQ20260710210931 from Kay Kay (A+)', 1, '2026-07-10 14:39:31', 'request'),
(513, 57, 16, 'Request Cancelled', 'Kay Kay has cancelled their A+ blood request.', 1, '2026-07-10 14:40:16', 'reminder'),
(516, 57, 14, 'New Blood Request', 'New blood request REQ20260710211236 from Kay Kay (A+)', 1, '2026-07-10 14:42:36', 'request'),
(518, 57, 14, 'Blood Request Assigned', 'Blood request REQ20260710211236 has been assigned to donor Htet Nandar Winn and is waiting for donor acceptance.', 1, '2026-07-10 14:45:55', 'request'),
(521, 57, 14, 'Blood Request Accepted', 'Blood request REQ20260710211236 has been accepted by donor Htet Nandar Winn.', 1, '2026-07-10 14:46:59', 'request'),
(525, 57, 41, 'Donor Profile Updated', 'Dar Dar updated their donor profile information.', 1, '2026-07-10 15:13:44', 'profile_update'),
(526, 57, 14, 'Blood Request Assigned', 'Blood request REQ20260709144946 has been assigned to donor Dar Dar and is waiting for donor acceptance.', 1, '2026-07-10 15:15:03', 'request'),
(528, 79, 14, 'Blood Request Matched', 'A donor has been assigned for your blood request REQ20260709144946 and is pending acceptance.', 0, '2026-07-10 15:15:03', 'request'),
(529, 57, 14, 'Blood Request Accepted', 'Blood request REQ20260709144946 has been accepted by donor Dar Dar.', 1, '2026-07-10 15:15:47', 'request'),
(531, 79, 14, 'Blood Request Accepted', 'Donor Dar Dar has accepted your blood request REQ20260709144946.', 0, '2026-07-10 15:15:47', 'request'),
(533, 57, 41, 'Donor Profile Updated', 'Bunny updated their donor profile information.', 1, '2026-07-10 15:34:19', 'profile_update'),
(534, 57, 14, 'Blood Request Assigned', 'Blood request REQ20260710112507 has been assigned to donor Bunny and is waiting for donor acceptance.', 1, '2026-07-10 15:34:54', 'request'),
(536, 89, 14, 'Blood Request Matched', 'A donor has been assigned for your blood request REQ20260710112507 and is pending acceptance.', 0, '2026-07-10 15:34:54', 'request'),
(537, 57, 14, 'Blood Request Accepted', 'Blood request REQ20260710112507 has been accepted by donor Bunny.', 1, '2026-07-10 15:35:19', 'request'),
(539, 89, 14, 'Blood Request Accepted', 'Donor Bunny has accepted your blood request REQ20260710112507.', 0, '2026-07-10 15:35:19', 'request'),
(541, 57, 14, 'New Blood Request', 'New blood request REQ20260711001235 from Kay Kay (AB-)', 1, '2026-07-10 17:42:35', 'request'),
(544, 57, 16, 'Request Cancelled', 'Kay Kay has cancelled their AB- blood request.', 1, '2026-07-10 17:45:56', 'reminder'),
(546, 57, 14, 'New Blood Request', 'New blood request REQ20260711001629 from Kay Kay (A+)', 1, '2026-07-10 17:46:29', 'request'),
(548, 57, 16, 'Request Cancelled', 'Kay Kay has cancelled their A+ blood request.', 1, '2026-07-10 17:59:30', 'reminder'),
(550, 57, 41, 'Donor Profile Updated', 'Mayple MP updated their donor profile information.', 1, '2026-07-10 18:03:59', 'profile_update'),
(553, 57, 14, 'New Blood Request', 'New blood request REQ20260711165423 from Mayple (AB-)', 1, '2026-07-11 10:24:23', 'request'),
(557, 57, 16, 'Request Cancelled', 'Mayple has cancelled their AB- blood request.', 1, '2026-07-11 10:28:38', 'reminder'),
(560, 57, 14, 'New Blood Request', 'New blood request REQ20260711165929 from Mayple (AB-)', 1, '2026-07-11 10:29:29', 'request'),
(561, 57, 14, 'Blood Request Assigned', 'Blood request REQ20260711165929 has been assigned to donor Lina Lina and is waiting for donor acceptance.', 1, '2026-07-11 10:30:55', 'request'),
(564, 57, 14, 'Blood Request Accepted', 'Blood request REQ20260711165929 has been accepted by donor Lina Lina.', 1, '2026-07-11 10:31:20', 'request'),
(568, 57, 41, 'Donor Profile Updated', 'Lina Lina updated their donor profile information.', 1, '2026-07-11 10:33:26', 'profile_update'),
(570, 57, 41, 'Patient Profile Updated', 'Mayple MP updated their profile information.', 1, '2026-07-11 10:34:17', 'profile_update'),
(571, 57, 41, 'Donor Profile Updated', 'Htet Nandar Winn updated their donor profile information.', 1, '2026-07-11 11:23:28', 'profile_update'),
(572, 57, 41, 'Donor Profile Updated', 'Htet Nandar updated their donor profile information.', 1, '2026-07-11 11:23:46', 'profile_update'),
(573, 57, 41, 'Donor Profile Updated', 'Htet Nandar Winn updated their donor profile information.', 1, '2026-07-11 11:24:30', 'profile_update'),
(575, 57, 41, 'Patient Profile Updated', 'Sakura updated their profile information.', 1, '2026-07-11 11:24:57', 'profile_update'),
(577, 57, 14, 'New Blood Request', 'New blood request REQ20260711175535 from Sakura (AB+)', 1, '2026-07-11 11:25:35', 'request'),
(579, 57, 41, 'Patient Profile Updated', 'Sakura updated their profile information.', 1, '2026-07-11 11:25:56', 'profile_update'),
(581, 57, 41, 'Donor Profile Updated', 'sam sam updated their donor profile information.', 1, '2026-07-11 11:28:50', 'profile_update'),
(583, 57, 16, 'Request Cancelled', 'Sakura has cancelled their AB+ blood request.', 1, '2026-07-11 11:31:18', 'reminder'),
(587, 57, 14, 'New Blood Request', 'New blood request REQ20260711180215 from Sakura (O-)', 1, '2026-07-11 11:32:15', 'request'),
(588, 57, 14, 'Blood Request Assigned', 'Blood request REQ20260711180215 has been assigned to donor sam sam and is waiting for donor acceptance.', 1, '2026-07-11 11:34:43', 'request'),
(591, 57, 14, 'Blood Request Accepted', 'Blood request REQ20260711180215 has been accepted by donor sam sam.', 1, '2026-07-11 11:35:38', 'request'),
(596, 57, 14, 'New Blood Request', 'New blood request REQ20260711180704 from Sakura (O-)', 1, '2026-07-11 11:37:04', 'request'),
(599, 57, 16, 'Request Cancelled', 'Sakura has cancelled their O- blood request.', 1, '2026-07-11 11:37:24', 'reminder'),
(602, 57, 14, 'New Blood Request', 'New blood request REQ20260711180812 from Sakura (O-)', 1, '2026-07-11 11:38:12', 'request'),
(606, 57, 16, 'Request Cancelled', 'Sakura has cancelled their O- blood request.', 1, '2026-07-11 11:50:32', 'reminder'),
(609, 57, 14, 'New Blood Request', 'New blood request REQ20260711182106 from Sakura (O-)', 1, '2026-07-11 11:51:06', 'request'),
(610, 57, 14, 'Blood Request Assigned', 'Blood request REQ20260711182106 has been assigned to donor Ryou You and is waiting for donor acceptance.', 1, '2026-07-11 11:51:27', 'request'),
(616, 57, 16, 'Request Cancelled', 'Sakura has cancelled their O- blood request.', 1, '2026-07-11 11:53:33', 'reminder'),
(619, 57, 14, 'New Blood Request', 'New blood request REQ20260711182432 from Sakura (O-)', 1, '2026-07-11 11:54:32', 'request'),
(622, 57, 16, 'Request Cancelled', 'Sakura has cancelled their O- blood request.', 1, '2026-07-11 11:59:37', 'reminder'),
(625, 57, 14, 'New Blood Request', 'New blood request REQ20260711183013 from Sakura (O-)', 1, '2026-07-11 12:00:13', 'request'),
(626, 57, 14, 'Blood Request Assigned', 'Blood request REQ20260711183013 has been assigned to donor Ryou You and is waiting for donor acceptance.', 1, '2026-07-11 12:00:47', 'request'),
(629, 57, 14, 'Blood Request Accepted', 'Blood request REQ20260711183013 has been accepted by donor Ryou You.', 1, '2026-07-11 12:01:21', 'request'),
(633, 57, 41, 'Patient Profile Updated', 'Kay Kay updated their profile information.', 1, '2026-07-11 15:15:15', 'profile_update'),
(635, 57, 41, 'Donor Profile Updated', 'Dar Dar updated their donor profile information.', 1, '2026-07-11 15:15:44', 'profile_update'),
(638, 57, 14, 'New Blood Request', 'New blood request REQ20260711214620 from Kay Kay (O+)', 1, '2026-07-11 15:16:20', 'request'),
(642, 57, 16, 'Request Cancelled', 'Kay Kay has cancelled their O+ blood request.', 1, '2026-07-11 15:17:39', 'reminder'),
(645, 57, 14, 'New Blood Request', 'New blood request REQ20260711214829 from Kay Kay (O+)', 1, '2026-07-11 15:18:29', 'request'),
(646, 57, 14, 'Blood Request Assigned', 'Blood request REQ20260711214829 has been assigned to donor Dar Dar and is waiting for donor acceptance.', 1, '2026-07-11 15:19:11', 'request'),
(649, 57, 14, 'Blood Request Accepted', 'Blood request REQ20260711214829 has been accepted by donor Dar Dar.', 1, '2026-07-11 15:19:26', 'request'),
(653, 57, 41, 'Patient Profile Updated', 'Mayple updated their profile information.', 1, '2026-07-11 16:44:24', 'profile_update'),
(656, 57, 14, 'New Blood Request', 'New blood request REQ20260711231600 from Mayple (B-)', 1, '2026-07-11 16:46:00', 'request'),
(660, 57, 16, 'Request Cancelled', 'Mayple has cancelled their B- blood request.', 1, '2026-07-11 16:48:25', 'reminder'),
(663, 57, 14, 'New Blood Request', 'New blood request REQ20260711231920 from Kay Kay (B-)', 1, '2026-07-11 16:49:20', 'request'),
(664, 57, 14, 'Blood Request Assigned', 'Blood request REQ20260711231920 has been assigned to donor Dar Dar and is waiting for donor acceptance.', 1, '2026-07-11 16:49:57', 'request'),
(667, 57, 14, 'Blood Request Accepted', 'Blood request REQ20260711231920 has been accepted by donor Dar Dar.', 1, '2026-07-11 16:50:30', 'request'),
(671, 57, 41, 'Patient Profile Updated', 'Kay Kay updated their profile information.', 1, '2026-07-12 14:13:11', 'profile_update'),
(673, 57, 41, 'Donor Profile Updated', 'Dar Dar updated their donor profile information.', 1, '2026-07-12 14:13:50', 'profile_update'),
(676, 57, 14, 'New Blood Request', 'New blood request REQ20260712205514 from Kay Kay (B+)', 1, '2026-07-12 14:25:14', 'request'),
(681, 57, 16, 'Request Cancelled', 'Kay Kay has cancelled their B+ blood request.', 1, '2026-07-12 14:27:44', 'reminder'),
(684, 57, 14, 'New Blood Request', 'New blood request REQ20260712205852 from Kay Kay (B+)', 1, '2026-07-12 14:28:52', 'request'),
(685, 57, 14, 'Blood Request Assigned', 'Blood request REQ20260712205852 has been assigned to donor Dar Dar and is waiting for donor acceptance.', 1, '2026-07-12 14:29:11', 'request'),
(688, 57, 14, 'Blood Request Accepted', 'Blood request REQ20260712205852 has been accepted by donor Dar Dar.', 1, '2026-07-12 14:29:52', 'request'),
(692, 57, 41, 'Patient Profile Updated', 'Kay Kay updated their profile information.', 1, '2026-07-13 02:57:12', 'profile_update'),
(695, 57, 14, 'New Blood Request', 'New blood request REQ20260713092756 from Kay Kay (AB+)', 1, '2026-07-13 02:57:56', 'request'),
(699, 57, 16, 'Request Cancelled', 'Kay Kay has cancelled their AB+ blood request.', 1, '2026-07-13 02:58:27', 'reminder'),
(702, 57, 14, 'New Blood Request', 'New blood request REQ20260713092913 from Kay Kay (AB+)', 1, '2026-07-13 02:59:14', 'request'),
(703, 57, 14, 'Blood Request Assigned', 'Blood request REQ20260713092913 has been assigned to donor Bunny and is waiting for donor acceptance.', 1, '2026-07-13 03:00:04', 'request'),
(706, 57, 14, 'Blood Request Accepted', 'Blood request REQ20260713092913 has been accepted by donor Bunny.', 1, '2026-07-13 03:01:15', 'request'),
(710, 57, 41, 'Donor Profile Updated', 'Bunny updated their donor profile information.', 1, '2026-07-13 03:02:15', 'profile_update'),
(712, 57, 14, 'New Blood Request', 'New blood request REQ20260713101713 from Kay Kay (AB+)', 1, '2026-07-13 03:47:13', 'request'),
(715, 57, 16, 'Request Cancelled', 'Kay Kay has cancelled their AB+ blood request.', 1, '2026-07-13 04:17:01', 'reminder'),
(717, 57, 14, 'New Blood Request', 'New blood request REQ20260713104715 from Kay Kay (B+)', 1, '2026-07-13 04:17:15', 'request'),
(719, 57, 14, 'New Blood Request', 'New blood request REQ20260713110657 from Mayple (B+)', 1, '2026-07-13 04:36:57', 'request'),
(720, 57, 14, 'Blood Request Assigned', 'Blood request REQ20260713110657 has been assigned to donor Ryou You and is waiting for donor acceptance.', 1, '2026-07-13 05:05:40', 'request'),
(723, 57, 14, 'Blood Request Accepted', 'Blood request REQ20260713110657 has been accepted by donor Ryou You.', 1, '2026-07-13 05:06:19', 'request'),
(726, 57, 14, 'Blood Request Assigned', 'Blood request REQ20260710111824 has been assigned to donor Bunny and is waiting for donor acceptance.', 1, '2026-07-13 05:18:46', 'request');
INSERT INTO `notifications` (`notification_id`, `user_id`, `notification_type_id`, `title`, `message`, `is_read`, `created_at`, `type`) VALUES
(728, 89, 14, 'Blood Request Matched', 'A donor has been assigned for your blood request REQ20260710111824 and is pending acceptance.', 0, '2026-07-13 05:18:46', 'request'),
(729, 57, 14, 'Blood Request Assigned', 'Blood request REQ20260710111302 has been assigned to donor Bunny and is waiting for donor acceptance.', 1, '2026-07-13 05:19:21', 'request'),
(731, 89, 14, 'Blood Request Matched', 'A donor has been assigned for your blood request REQ20260710111302 and is pending acceptance.', 0, '2026-07-13 05:19:21', 'request'),
(732, 57, 14, 'Blood Request Assigned', 'Blood request REQ20260710112354 has been assigned to donor Bunny and is waiting for donor acceptance.', 1, '2026-07-13 05:20:04', 'request'),
(734, 89, 14, 'Blood Request Matched', 'A donor has been assigned for your blood request REQ20260710112354 and is pending acceptance.', 0, '2026-07-13 05:20:04', 'request'),
(735, 57, 14, 'Blood Request Assigned', 'Blood request REQ20260710112507 has been assigned to donor Bunny and is waiting for donor acceptance.', 1, '2026-07-13 05:21:28', 'request'),
(737, 89, 14, 'Blood Request Matched', 'A donor has been assigned for your blood request REQ20260710112507 and is pending acceptance.', 0, '2026-07-13 05:21:28', 'request'),
(738, 57, 14, 'Blood Request Accepted', 'Blood request REQ20260710112507 has been accepted by donor Bunny.', 1, '2026-07-13 05:21:44', 'request'),
(740, 89, 14, 'Blood Request Accepted', 'Donor Bunny has accepted your blood request REQ20260710112507.', 0, '2026-07-13 05:21:44', 'request'),
(742, 57, 16, 'Request Cancelled', 'Kay Kay has cancelled their B+ blood request.', 1, '2026-07-13 05:26:54', 'reminder'),
(745, 57, 14, 'New Blood Request', 'New blood request REQ20260713115754 from Kay Kay (B+)', 1, '2026-07-13 05:27:54', 'request'),
(748, 57, 16, 'Request Cancelled', 'Kay Kay has cancelled their B+ blood request.', 1, '2026-07-13 05:28:43', 'reminder'),
(750, 57, 14, 'New Blood Request', 'New blood request REQ20260713120700 from Kay Kay (A-)', 1, '2026-07-13 05:37:00', 'request'),
(752, 57, 16, 'Request Deleted', 'Pending blood request REQ20260713120700 was deleted by admin.', 1, '2026-07-13 05:38:37', 'reminder'),
(754, 57, 14, 'New Blood Request', 'New blood request REQ20260713121117 from Kay Kay (O-)', 1, '2026-07-13 05:41:17', 'request'),
(756, 57, 16, 'Request Deleted', 'Pending blood request REQ20260713121117 was deleted by admin.', 1, '2026-07-13 05:45:43', 'reminder'),
(759, 57, 14, 'New Blood Request', 'New blood request REQ20260713121901 from Kay Kay (O-)', 1, '2026-07-13 05:49:01', 'request'),
(762, 57, 16, 'Request Deleted', 'Pending blood request REQ20260713121901 was deleted by admin.', 1, '2026-07-13 05:49:39', 'reminder'),
(763, 89, 16, 'Request Deleted', 'Admin deleted your pending blood request REQ20260710112354.', 0, '2026-07-13 05:50:54', 'reminder'),
(764, 57, 16, 'Request Deleted', 'Pending blood request REQ20260710112354 was deleted by admin.', 1, '2026-07-13 05:50:54', 'reminder'),
(765, 89, 16, 'Request Deleted', 'Admin deleted your pending blood request REQ20260710111824.', 0, '2026-07-13 05:51:15', 'reminder'),
(766, 57, 16, 'Request Deleted', 'Pending blood request REQ20260710111824 was deleted by admin.', 1, '2026-07-13 05:51:15', 'reminder'),
(767, 89, 16, 'Request Deleted', 'Admin deleted your pending blood request REQ20260710111302.', 0, '2026-07-13 05:51:24', 'reminder'),
(768, 57, 16, 'Request Deleted', 'Pending blood request REQ20260710111302 was deleted by admin.', 1, '2026-07-13 05:51:24', 'reminder'),
(771, 57, 14, 'New Blood Request', 'New blood request REQ20260713140257 from Kay (A+)', 1, '2026-07-13 07:32:58', 'request'),
(775, 57, 16, 'Request Cancelled', 'Kay has cancelled their A+ blood request.', 1, '2026-07-13 07:33:50', 'reminder'),
(777, 57, 14, 'New Blood Request', 'New blood request REQ20260713140425 from Kay (B+)', 1, '2026-07-13 07:34:25', 'request'),
(779, 57, 16, 'Request Deleted', 'Pending blood request REQ20260713140425 was deleted by admin.', 1, '2026-07-13 07:34:46', 'reminder'),
(782, 57, 14, 'New Blood Request', 'New blood request REQ20260713140522 from Kay (A+)', 1, '2026-07-13 07:35:22', 'request'),
(785, 57, 16, 'Request Deleted', 'Pending blood request REQ20260713140522 was deleted by admin.', 1, '2026-07-13 07:35:55', 'reminder'),
(788, 57, 14, 'New Blood Request', 'New blood request REQ20260713140643 from Kay (A+)', 1, '2026-07-13 07:36:43', 'request'),
(789, 57, 14, 'Blood Request Assigned', 'Blood request REQ20260713140643 has been assigned to donor Lina Lina and is waiting for donor acceptance.', 1, '2026-07-13 07:37:12', 'request'),
(792, 57, 14, 'Blood Request Accepted', 'Blood request REQ20260713140643 has been accepted by donor Lina Lina.', 1, '2026-07-13 07:38:20', 'request'),
(797, 57, 14, 'New Blood Request', 'New blood request REQ20260713143744 from Kay (A+)', 1, '2026-07-13 08:07:44', 'request'),
(798, 57, 14, 'Blood Request Assigned', 'Blood request REQ20260713143744 has been assigned to donor Dar Dar and is waiting for donor acceptance.', 1, '2026-07-13 08:08:38', 'request'),
(801, 57, 14, 'Blood Request Accepted', 'Blood request REQ20260713143744 has been accepted by donor Dar Dar.', 1, '2026-07-13 08:08:59', 'request'),
(805, 57, 41, 'Donor Profile Updated', 'Dar Dar updated their donor profile information.', 1, '2026-07-13 08:16:27', 'profile_update'),
(807, 57, 41, 'Donor Profile Updated', 'Htet Htet updated their donor profile information.', 1, '2026-07-13 08:37:52', 'profile_update'),
(809, 57, 14, 'New Blood Request', 'New blood request REQ20260714001451 from Kay (AB+)', 1, '2026-07-13 17:44:51', 'request'),
(811, 57, 16, 'Request Cancelled', 'Kay has cancelled their AB+ blood request.', 1, '2026-07-13 17:56:50', 'reminder'),
(813, 57, 14, 'New Blood Request', 'New blood request REQ20260714002708 from Kay (A-)', 1, '2026-07-13 17:57:08', 'request'),
(815, 57, 16, 'Request Cancelled', 'Kay has cancelled their A- blood request.', 1, '2026-07-13 17:58:51', 'reminder'),
(817, 57, 14, 'New Blood Request', 'New blood request REQ20260714002907 from Kay (AB-)', 1, '2026-07-13 17:59:07', 'request'),
(819, 57, 16, 'Request Cancelled', 'Kay has cancelled their AB- blood request.', 1, '2026-07-14 03:48:25', 'reminder'),
(822, 57, 14, 'New Blood Request', 'New blood request REQ20260714101839 from Kay Kay (A+)', 1, '2026-07-14 03:48:39', 'request'),
(825, 57, 16, 'Request Cancelled', 'Kay Kay has cancelled their A+ blood request.', 1, '2026-07-14 03:57:11', 'reminder'),
(828, 57, 14, 'New Blood Request', 'New blood request REQ20260714102732 from Kay Kay (A+)', 1, '2026-07-14 03:57:32', 'request'),
(831, 57, 16, 'Request Cancelled', 'Kay Kay has cancelled their A+ blood request.', 1, '2026-07-14 04:16:19', 'reminder'),
(834, 57, 14, 'New Blood Request', 'New blood request REQ20260714104912 from Kay Kay (A+)', 1, '2026-07-14 04:19:12', 'request'),
(835, 57, 14, 'Blood Request Accepted', 'Blood request REQ20260714104912 has been accepted by donor Bunny.', 1, '2026-07-14 04:38:23', 'request'),
(840, 57, 14, 'New Blood Request', 'New blood request REQ20260714112406 from Kay Kay (B+)', 1, '2026-07-14 04:54:06', 'request'),
(841, 57, 14, 'Blood Request Assigned', 'Blood request REQ20260714112406 has been assigned to donor Dar Dar and is waiting for donor acceptance.', 1, '2026-07-14 04:54:38', 'request'),
(844, 57, 14, 'Blood Request Accepted', 'Blood request REQ20260714112406 has been accepted by donor Dar Dar.', 1, '2026-07-14 04:54:54', 'request'),
(847, 150, 14, 'Blood Request Submitted', 'Your blood request is now pending.', 1, '2026-07-14 15:07:36', 'request'),
(849, 57, 14, 'New Blood Request', 'New blood request REQ20260714213736 from Mayple (A+)', 1, '2026-07-14 15:07:36', 'request'),
(850, 150, 16, 'Request Cancelled', 'Your blood request has been cancelled.', 1, '2026-07-14 15:10:05', 'reminder'),
(852, 57, 16, 'Request Cancelled', 'Mayple has cancelled their A+ blood request.', 1, '2026-07-14 15:10:05', 'reminder'),
(853, 150, 14, 'Blood Request Submitted', 'Your blood request is now pending.', 1, '2026-07-14 15:11:18', 'request'),
(855, 57, 14, 'New Blood Request', 'New blood request REQ20260714214118 from Mayple (A+)', 1, '2026-07-14 15:11:18', 'request'),
(856, 150, 14, 'Pending Request Exists', 'You already have a pending blood request. Please wait until it is resolved before creating a new one.', 1, '2026-07-14 15:11:58', 'request'),
(857, 57, 14, 'Blood Request Assigned', 'Blood request REQ20260714214118 has been assigned to donor Lina Lina and is waiting for donor acceptance.', 1, '2026-07-14 15:12:38', 'request'),
(859, 150, 14, 'Blood Request Matched', 'A donor has been assigned for your blood request REQ20260714214118 and is pending acceptance.', 1, '2026-07-14 15:12:38', 'request'),
(860, 57, 14, 'Blood Request Accepted', 'Blood request REQ20260714214118 has been accepted by donor Lina Lina.', 1, '2026-07-14 15:13:04', 'request'),
(862, 150, 14, 'Blood Request Accepted', 'Donor Lina Lina has accepted your blood request REQ20260714214118.', 1, '2026-07-14 15:13:04', 'request'),
(863, 150, 14, 'Blood Request Submitted', 'Your blood request is now pending.', 1, '2026-07-14 15:17:46', 'request'),
(864, 57, 14, 'New Blood Request', 'New blood request REQ20260714214746 from Mayple (B+)', 1, '2026-07-14 15:17:46', 'request');

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `permission_id` int(11) NOT NULL,
  `permission_name` varchar(100) NOT NULL,
  `permission_key` varchar(100) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`permission_id`, `permission_name`, `permission_key`, `description`, `created_at`) VALUES
(13, 'View Dashboard', 'dashboard.view', 'View dashboard', '2026-07-07 15:23:44'),
(14, 'View Profile', 'profile.view', 'View profile', '2026-07-07 15:23:44'),
(15, 'Update Profile', 'profile.update', 'Update profile', '2026-07-07 15:23:44'),
(16, 'Create Blood Request', 'blood_request.create', 'Create blood request', '2026-07-07 15:23:44'),
(17, 'View My Requests', 'blood_request.view_own', 'View own requests', '2026-07-07 15:23:44'),
(18, 'Search Donor', 'donor.search', 'Search donors', '2026-07-07 15:23:44'),
(19, 'View Matching Requests', 'blood_request.view_matching', 'View matching requests', '2026-07-07 15:23:44'),
(20, 'Accept Blood Request', 'blood_request.accept', 'Accept blood request', '2026-07-07 15:23:44'),
(21, 'Decline Blood Request', 'blood_request.decline', 'Decline blood request', '2026-07-07 15:23:44'),
(22, 'View Donation History', 'donation_history.view', 'View donation history', '2026-07-07 15:23:44'),
(23, 'View Notifications', 'notification.view', 'View notifications', '2026-07-07 15:23:44'),
(24, 'View Users', 'user.view', 'View users', '2026-07-07 15:23:44'),
(25, 'Delete Users', 'user.delete', 'Delete users', '2026-07-07 15:23:44'),
(26, 'View Donors', 'donor.view', 'View donors', '2026-07-07 15:23:44'),
(27, 'Delete Donors', 'donor.delete', 'Delete donors', '2026-07-07 15:23:44'),
(28, 'View Statistics', 'statistics.view', 'Dashboard statistics', '2026-07-07 15:23:44'),
(29, 'View Activity Log', 'activity_log.view', 'View system activity', '2026-07-07 15:23:44'),
(30, 'Manage User Types', 'user_type.manage', 'Manage roles', '2026-07-07 15:23:44'),
(31, 'Manage Permissions', 'permission.manage', 'Assign permissions', '2026-07-07 15:23:44');

-- --------------------------------------------------------

--
-- Table structure for table `request_donors`
--

CREATE TABLE `request_donors` (
  `request_donor_id` int(11) NOT NULL,
  `request_id` int(11) NOT NULL,
  `donor_id` int(11) NOT NULL,
  `response_status_id` int(11) NOT NULL,
  `response_date` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `google_id` varchar(255) DEFAULT NULL,
  `avatar` varchar(500) DEFAULT NULL,
  `auth_provider` varchar(50) DEFAULT 'local',
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `blood_group` varchar(10) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `status_id` int(11) NOT NULL,
  `available` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `username` varchar(100) DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL,
  `user_type_id` int(11) NOT NULL,
  `is_verified` tinyint(1) DEFAULT 0,
  `verification_code` varchar(10) DEFAULT NULL,
  `verification_expires_at` datetime DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `is_login` tinyint(1) DEFAULT 0,
  `blood_group_code` varchar(50) DEFAULT NULL,
  `next_available_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `google_id`, `avatar`, `auth_provider`, `email`, `phone`, `password`, `blood_group`, `address`, `status_id`, `available`, `created_at`, `username`, `updated_at`, `deleted_at`, `user_type_id`, `is_verified`, `verification_code`, `verification_expires_at`, `is_active`, `is_login`, `blood_group_code`, `next_available_date`) VALUES
(57, NULL, NULL, 'local', 'adminbloodconnect@gmail.com', NULL, '$2y$10$5efVnZlim6W66nsKyKhcW.nizpGZE1xGhYrmhjJlJJ1VEQQJllK2u', 'A_POS', NULL, 1, 1, '2026-07-05 16:13:33', 'Admin', '2026-07-13 07:31:13', NULL, 1, 1, NULL, NULL, 1, 1, NULL, NULL),
(79, NULL, NULL, 'local', 'nick@gmail.com', '09765732081', '$2y$10$EEZDUMKtoVaQnzmtxXS.5exn8aH9x6DDBuuLOFNdN1E63bHD.j.my', 'B+', 'yangon', 3, 0, '2026-07-09 02:47:01', 'nick', '2026-07-09 07:11:00', NULL, 2, 1, NULL, NULL, 1, 0, NULL, '2026-10-09 13:41:00'),
(82, NULL, NULL, 'local', 'judy123@gmail.com', '09671739912', '$2y$10$aMsu98VrXnUuaLaHz2q8Jurb8jTA01QH5iDeF9.5i0W5pfSUdDOz6', 'B+', 'Yamethin', 3, 1, '2026-07-09 07:06:23', 'judyy', '2026-07-09 07:18:43', NULL, 3, 1, NULL, NULL, 1, 0, NULL, NULL),
(89, NULL, NULL, 'local', 'kay@gmail.com', '09765732081', '$2y$10$sLRKWzHb/jUJVu7ofh3hrOHj/lyL8tDmAcapjha80Gmir78LIrdZe', 'A+', 'yangonn', 3, 1, '2026-07-09 09:22:12', 'kk', '2026-07-10 04:50:26', NULL, 3, 1, NULL, NULL, 1, 0, NULL, NULL),
(91, NULL, NULL, 'local', 'bady@gmail.com', '09671739912', '$2y$10$9aztrqX4w5jDCm840YeAIe8u5pDpXv9VOZrsQXhV2Tf87fcXq6JiW', 'O-', NULL, 3, 0, '2026-07-09 11:05:01', 'bady', '2026-07-09 17:21:40', NULL, 2, 1, NULL, NULL, 1, 0, NULL, '2026-10-09 23:51:40'),
(92, NULL, NULL, 'local', 'dodo@gmail.com', '09671739912', '$2y$10$0.uAI8PttRSeMrHCfOI.w.x24T78QgTuwL9gAr1PvWlP4TDVMfHje', 'B-', NULL, 3, 0, '2026-07-09 17:22:55', 'dodo', '2026-07-09 17:25:57', NULL, 2, 1, NULL, NULL, 1, 0, NULL, '2026-10-09 23:55:57'),
(94, NULL, NULL, 'local', 'lina@gmail.com', '09765732081', '$2y$10$nRyhkEMl2CSa6/IWvHWpd.Cmb9PWAlLnzErD6psfGBf5KED7vEiDK', 'A-', 'yangon', 3, 1, '2026-07-10 03:42:17', 'linalina', '2026-07-10 03:43:19', NULL, 3, 1, NULL, NULL, 1, 0, NULL, NULL),
(95, NULL, NULL, 'local', 'alice@gmail.com', '09671739912', '$2y$10$AcLBgWZm0weu7705hOItj.BzFyWWCMpzOgnfkSAMUr7etb3UKyDYe', 'AB+', NULL, 3, 0, '2026-07-10 03:51:57', 'aliceko', '2026-07-10 03:53:55', NULL, 2, 1, NULL, NULL, 1, 0, NULL, '2026-10-10 10:23:55'),
(96, NULL, NULL, 'local', 'kaungkaung@gmail.com', '09671739912', '$2y$10$VarV/AOIIUO83s1/nmbDoOTarTBzELQzXguvEODtMvYsK4hEYVRrG', 'O+', NULL, 3, 0, '2026-07-10 03:56:14', 'kaung', '2026-07-10 04:01:38', NULL, 2, 1, NULL, NULL, 1, 0, NULL, '2026-10-10 10:31:38'),
(97, NULL, NULL, 'local', 'kayyy@gmail.com', '09765732081', '$2y$10$yJ0Ik/z.7wEv5oWTF1RGvO55SXt27JqRlOWgyL/Xks9RtwZ80b/Ua', 'O+', NULL, 3, 1, '2026-07-10 03:57:58', 'kayyyy', '2026-07-10 03:58:24', NULL, 3, 1, NULL, NULL, 1, 0, NULL, NULL),
(98, NULL, NULL, 'local', 'bobo@gmail.com', '09671739912', '$2y$10$fpC6V4xkPW7X4GLMDZhvdeXtM1A/FgI54gCdQncIJtz9Hr39Ptd4C', 'B+', NULL, 3, 0, '2026-07-10 04:24:02', 'bobo', '2026-07-10 04:25:49', NULL, 2, 1, NULL, NULL, 1, 0, NULL, '2026-10-10 10:55:49'),
(99, NULL, NULL, 'local', 'lwinlwin@gmail.com', '09671739912', '$2y$10$me8j/x2yTgNQC1SstsF93.5zqHLKq0eK4yVH0bROibz8ceSbzEG0m', 'B+', NULL, 3, 0, '2026-07-10 04:27:39', 'lwinlwin', '2026-07-10 04:30:17', NULL, 2, 1, NULL, NULL, 1, 0, NULL, '2026-10-10 11:00:17'),
(100, NULL, NULL, 'local', 'zawzaw@gmail.com', '09671739912', '$2y$10$/IaAFq6gynCShgPWHYDyseIxCoiH0NyfY2cP4F1IAF6USAMoPV5yu', 'B+', NULL, 3, 0, '2026-07-10 04:36:41', 'zawzaw', '2026-07-10 04:40:31', NULL, 2, 1, NULL, NULL, 1, 0, NULL, '2026-10-10 11:10:31'),
(101, NULL, NULL, 'local', 'myo@gmail.com', '09671739912', '$2y$10$9dHrXLOf2SEWoRUCIxuR5.ccYQb32x3aGXzn6QnvQ71p8lycXjba.', 'A+', NULL, 3, 0, '2026-07-10 04:45:45', 'myo', '2026-07-10 04:56:46', NULL, 2, 1, NULL, NULL, 1, 0, NULL, '2026-10-10 11:26:46'),
(150, '116276058991510286256', 'https://lh3.googleusercontent.com/a/ACg8ocJVCHyWnk4ugAkIdOc2jwyP7aIhRm-rnJkrN93LQIZ1RB9IPA=s96-c', 'google', 'mayple86425@gmail.com', NULL, '', 'A+', NULL, 1, 1, '2026-07-14 15:06:05', 'Mayple MP', '2026-07-14 15:06:05', NULL, 3, 1, NULL, NULL, 1, 1, NULL, NULL),
(151, '100637882766589240359', 'https://lh3.googleusercontent.com/a/ACg8ocLq-nYuKtdaILNaxZqpk-CP_oUEzKAog-HQGwocTViGmeppr7o=s96-c', 'google', 'bunny86425@gmail.com', NULL, '', 'A-', NULL, 1, 1, '2026-07-14 15:18:55', 'Bunny', '2026-07-14 15:19:04', NULL, 2, 1, NULL, NULL, 1, 0, NULL, NULL),
(152, '113431109616103400882', 'https://lh3.googleusercontent.com/a/ACg8ocJ6pnC_jMieMhX4vpW7aZWlX0R82GJkQERcftBNDyzqblYf5A=s96-c', 'google', 'ryouyou86425@gmail.com', NULL, '', 'AB-', NULL, 1, 1, '2026-07-14 15:19:23', 'Ryou You', '2026-07-14 15:19:52', NULL, 2, 1, NULL, NULL, 1, 0, NULL, NULL),
(153, '111703472602645590421', 'https://lh3.googleusercontent.com/a/ACg8ocKPkjLhL9EsShy3IvoR-9zxQ__wM_C_twgxHrq54QyVLlXpfw=s96-c', 'google', 'dardar86425@gmail.com', NULL, '', 'O-', NULL, 1, 1, '2026-07-14 15:20:16', 'Dar Dar', '2026-07-14 15:20:16', NULL, 2, 1, NULL, NULL, 1, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_types`
--

CREATE TABLE `user_types` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `permissions` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_types`
--

INSERT INTO `user_types` (`id`, `name`, `permissions`, `created_at`) VALUES
(1, 'admin', '*', '2026-07-07 12:46:52'),
(2, 'donor', 'dashboard,blood_requests,accept_request,profile,notifications,history', '2026-07-07 12:46:52'),
(3, 'patient', 'dashboard,request_blood,search_donor,my_requests,profile,notifications', '2026-07-07 12:46:52');

-- --------------------------------------------------------

--
-- Table structure for table `user_type_permissions`
--

CREATE TABLE `user_type_permissions` (
  `user_type_id` int(11) NOT NULL,
  `permission_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_type_permissions`
--

INSERT INTO `user_type_permissions` (`user_type_id`, `permission_id`) VALUES
(1, 13),
(1, 14),
(1, 15),
(1, 16),
(1, 17),
(1, 18),
(1, 19),
(1, 20),
(1, 21),
(1, 22),
(1, 23),
(1, 24),
(1, 25),
(1, 26),
(1, 27),
(1, 28),
(1, 29),
(1, 30),
(1, 31),
(2, 13),
(2, 14),
(2, 15),
(2, 16),
(2, 17),
(2, 18),
(2, 19),
(2, 20),
(2, 21),
(2, 22),
(2, 23),
(2, 26),
(2, 27),
(2, 28),
(2, 29),
(2, 31),
(3, 13),
(3, 14),
(3, 15),
(3, 16),
(3, 17),
(3, 18),
(3, 19),
(3, 20),
(3, 21),
(3, 22),
(3, 23),
(3, 26),
(3, 27),
(3, 28),
(3, 29),
(3, 31);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `blood_requests`
--
ALTER TABLE `blood_requests`
  ADD PRIMARY KEY (`request_id`),
  ADD UNIQUE KEY `request_code` (`request_code`),
  ADD KEY `status_id` (`status`),
  ADD KEY `blood_requests_ibfk_1` (`patient_id`);

--
-- Indexes for table `donation_history`
--
ALTER TABLE `donation_history`
  ADD PRIMARY KEY (`donation_id`),
  ADD KEY `request_id` (`request_id`),
  ADD KEY `donor_id` (`donor_id`),
  ADD KEY `status_id` (`status`);

--
-- Indexes for table `donors`
--
ALTER TABLE `donors`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `email_verifications`
--
ALTER TABLE `email_verifications`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `token` (`token`),
  ADD KEY `fk_email_verification_user` (`user_id`);

--
-- Indexes for table `master_data`
--
ALTER TABLE `master_data`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`notification_id`),
  ADD KEY `notification_type_id` (`notification_type_id`),
  ADD KEY `notifications_ibfk_1` (`user_id`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`permission_id`),
  ADD UNIQUE KEY `permission_key` (`permission_key`);

--
-- Indexes for table `request_donors`
--
ALTER TABLE `request_donors`
  ADD PRIMARY KEY (`request_donor_id`),
  ADD KEY `request_id` (`request_id`),
  ADD KEY `donor_id` (`donor_id`),
  ADD KEY `response_status_id` (`response_status_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `google_id` (`google_id`),
  ADD KEY `availability_id` (`available`),
  ADD KEY `fk_users_user_types` (`user_type_id`),
  ADD KEY `fk_user_status` (`status_id`);

--
-- Indexes for table `user_types`
--
ALTER TABLE `user_types`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `user_type_permissions`
--
ALTER TABLE `user_type_permissions`
  ADD PRIMARY KEY (`user_type_id`,`permission_id`),
  ADD KEY `permission_id` (`permission_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activity_logs`
--
ALTER TABLE `activity_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=468;

--
-- AUTO_INCREMENT for table `blood_requests`
--
ALTER TABLE `blood_requests`
  MODIFY `request_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=200;

--
-- AUTO_INCREMENT for table `donation_history`
--
ALTER TABLE `donation_history`
  MODIFY `donation_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `donors`
--
ALTER TABLE `donors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `email_verifications`
--
ALTER TABLE `email_verifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `master_data`
--
ALTER TABLE `master_data`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `notification_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=865;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `permission_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `request_donors`
--
ALTER TABLE `request_donors`
  MODIFY `request_donor_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=154;

--
-- AUTO_INCREMENT for table `user_types`
--
ALTER TABLE `user_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `blood_requests`
--
ALTER TABLE `blood_requests`
  ADD CONSTRAINT `blood_requests_ibfk_1` FOREIGN KEY (`patient_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `blood_requests_ibfk_2` FOREIGN KEY (`status`) REFERENCES `master_data` (`id`);

--
-- Constraints for table `donation_history`
--
ALTER TABLE `donation_history`
  ADD CONSTRAINT `donation_history_ibfk_1` FOREIGN KEY (`request_id`) REFERENCES `blood_requests` (`request_id`),
  ADD CONSTRAINT `donation_history_ibfk_2` FOREIGN KEY (`donor_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `donation_history_ibfk_3` FOREIGN KEY (`status`) REFERENCES `master_data` (`id`);

--
-- Constraints for table `email_verifications`
--
ALTER TABLE `email_verifications`
  ADD CONSTRAINT `fk_email_verification_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `notifications_ibfk_2` FOREIGN KEY (`notification_type_id`) REFERENCES `master_data` (`id`);

--
-- Constraints for table `request_donors`
--
ALTER TABLE `request_donors`
  ADD CONSTRAINT `request_donors_ibfk_1` FOREIGN KEY (`request_id`) REFERENCES `blood_requests` (`request_id`),
  ADD CONSTRAINT `request_donors_ibfk_2` FOREIGN KEY (`donor_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `request_donors_ibfk_3` FOREIGN KEY (`response_status_id`) REFERENCES `master_data` (`id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `fk_user_status` FOREIGN KEY (`status_id`) REFERENCES `master_data` (`id`),
  ADD CONSTRAINT `fk_users_user_types` FOREIGN KEY (`user_type_id`) REFERENCES `user_types` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `user_type_permissions`
--
ALTER TABLE `user_type_permissions`
  ADD CONSTRAINT `user_type_permissions_ibfk_1` FOREIGN KEY (`user_type_id`) REFERENCES `user_types` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_type_permissions_ibfk_2` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`permission_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
